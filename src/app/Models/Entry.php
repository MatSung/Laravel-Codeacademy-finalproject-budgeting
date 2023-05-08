<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\ValidationException;

class Entry extends Model
{
    use HasFactory;

    protected $table = 'entries';

    protected $fillable = [
        'transaction_date',
        'category_id',
        'subcategory_id',
        'amount',
        'note'
    ];

    protected $hidden = [
        'created_at',
        'updated_at',
        'category_id',
        'subcategory_id'
    ];

    protected $with = [
        'category',
        'subcategory'
    ];

    // https://laravel.com/docs/10.x/eloquent#default-attribute-values
    // protected $attributes = [];


    public function category()
    {
        return $this->belongsTo(EntryCategory::class, 'category_id', 'id');
    }

    public function subcategory()
    {
        return $this->belongsTo(EntrySubcategory::class, 'subcategory_id', 'id');
    }

    public static function getColumns(): array
    {
        return Schema::getColumnListing((new Entry)->getTable());
    }


    //https://laravel.com/docs/10.x/eloquent#query-scopes
    public function scopeIncomes(Builder $query): void
    {
        $query->where('amount', '>', 0);
    }

    public function scopeExpenses(Builder $query): void
    {
        $query->where('amount', '<', 0);
    }

    public function getTableColumns()
    {
        return $this->getConnection()->getSchemaBuilder()->getColumnListing($this->getTable());
    }

    public function scopeFilter(Builder $query, array $filters): void
    {
        $query->when($filters['category'] ?? null, function ($query, $filter) {
            $query->where('category_id', '=', $filter);
        })
            ->when($filters['subcategory'] ?? null, function ($query, $filter) {
                $query->where('subcategory_id', '=', $filter);
            })->when($filters['income'] ?? null, function ($query, $filter) {
                if ($filter === 'income') {
                    $query->where('amount', '>', 0);
                } else if ($filter === 'expense') {
                    $query->where('amount', '<=', 0);
                }
            });
    }

    public static function importFromArray(array $arr): bool
    {
        $categoryIds = [];
        if (isset($arr['categories'])) {
            foreach ($arr['categories'] as $key => $category) {
                $categoryName = $category['name'];
                $existingCategory = EntryCategory::where('name', '=', $categoryName)->first();

                if (!$existingCategory) {
                    $existingCategory = EntryCategory::create([
                        'name' => $categoryName
                    ]);
                }
                $categoryIds[$categoryName] = ['id' => $existingCategory->id];

                foreach ($category['subcategories'] as $key => $subcategory) {
                    $existingSubcategory = EntrySubcategory::where('name', '=', $subcategory)
                        ->where('parent_id', '=', $categoryIds[$categoryName]['id'])->first();
                    if (!$existingSubcategory) {
                        $existingSubcategory = EntrySubcategory::create([
                            'name' => $subcategory,
                            'parent_id' => $categoryIds[$categoryName]['id']
                        ]);
                    }
                    $categoryIds[$categoryName]['subcategories'][$subcategory] = $existingSubcategory->id;
                }
            }
        } else {
            throw ValidationException::withMessages([
                'fileInput' => 'The format of the import file is either corrupt or invalid'
            ]);
        }

        if (isset($arr['entries'])) {
            foreach ($arr['entries'] as $key => $value) {
                if ($value['subcategory']) $value['subcategory_id'] = $categoryIds[$value['category']]['subcategories'][$value['subcategory']];
                $value['category_id'] = $categoryIds[$value['category']]['id'];
                unset($value['category']);
                unset($value['subcategory']);
                Entry::create($value);
            }
        }
        return true;
    }

    /**
     * Formats entire database to a json string for export.
     *
     * @return string
     */
    public static function formatForExport(): string
    {
        // format should be categories then entries
        // [
        //   ['categoryName'] => [subcategory, subcategory, ...]],
        //   ...
        // ]
        //

        $result = [
            'categories' => [],
            'entries' => []
        ];

        $categories = EntryCategory::with('subcategories')->get();
        $categories->each(function ($item, $key) use (&$result) {
            array_push($result['categories'], [
                'name' => $item->name,
                'subcategories' => $item->subcategories->pluck('name')->toArray()
            ]);
        });
        $entries = self::all();
        $entries->each(function ($item, $key) use (&$result) {
            array_push($result['entries'], [
                'transaction_date' => $item->transaction_date,
                'amount' => $item->amount,
                'note' => $item->note,
                'category' => $item->category->name,
                'subcategory' => isset($item->subcategory) ? $item->subcategory->name : null,
            ]);
        });
        return json_encode($result, JSON_PRETTY_PRINT);
    }

    /**
     * Get an array of objects of sums of incomes and expenses from each category.
     *
     * @param  Collection $entryCollection
     * @return array
     */
    public static function stats(Collection $entryCollection): array
    {
        $groupedEntries = $entryCollection->groupBy('category.name');

        $stats = [
            'income' => [],
            'expense' => [],
        ];

        $groupedEntries->each(function (Collection $item, string $categoryName) use (&$stats) {

            $sortedArr = $item->groupBy(function ($item, int $key) {
                return $item->amount >= 0 ? 'income' : 'expense';
            });

            array_push($stats['income'], self::collateStats($sortedArr, $categoryName, 'income'));

            array_push($stats['expense'], self::collateStats($sortedArr, $categoryName, 'expense'));
        });

        return $stats;
    }

    private static function collateStats($sortedArr, $categoryName, $type = 'income'): array
    {
        $arrToPush = [
            'name' => $categoryName,
            'amount' => isset($sortedArr[$type]) ?
                round($sortedArr[$type]->sum('amount'), 2) :
                0,
            'subcategories' => []
        ];

        if (isset($sortedArr[$type])) {
            $sortedArr[$type]->groupBy(function ($item) {
                return isset($item->subcategory) ? $item->subcategory->name : 'none';
            })->each(function ($item, $subcategoryName) use (&$arrToPush) {
                $arrToPush['subcategories'][] = [
                    'name' => $subcategoryName,
                    'amount' => round($item->sum('amount'), 2)
                ];
            });
        }
        if(count($arrToPush['subcategories']) <= 1){
            $arrToPush['subcategories'] = [];
        }

        return $arrToPush;
    }

    /**
     * Get a sorted array of objects of sums of incomes and expenses from each category.
     *  
     * @param Collection $entryCollection
     * @return array
     */
    public static function sortedStats(Collection $entryCollection): array
    {
        $unsortedStats = self::stats($entryCollection);

        $stats = [
            'income' => [],
            'expense' => [],
        ];

        $stats['income'] = collect($unsortedStats['income'])->sortByDesc('amount')->values()->all();
        $stats['expense'] = collect($unsortedStats['expense'])->sortByDesc('amount')->values()->all();

        return $stats;
    }

    public static function getUsedYearsMonths(): array
    {
        $yearMonths = DB::table('entries')
                    ->select(DB::raw('YEAR(transaction_date) as year'), DB::raw('MONTH(transaction_date) as month'))
                    ->distinct()
                    ->orderBy('year', 'desc')
                    ->orderBy('month', 'desc')
                    ->get();

        $availableDates = [];

        foreach ($yearMonths as $yearMonth) {
            $year = $yearMonth->year;
            $month = str_pad($yearMonth->month, 2, '0', STR_PAD_LEFT); // add leading zero if necessary
            if (!array_key_exists($year, $availableDates)) {
                $availableDates[$year] = [];
            }
            $availableDates[$year][] = $month;
        }

        return $availableDates;
    }


}
