<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Eloquent\Collection;
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
                        ->where('parent_id', '=', $categoryIds[$categoryName]['id']);
                    if (!$existingSubcategory) {
                        $existingSubcategory = EntrySubcategory::create([
                            'name' => $subcategory,
                            'parent_id' => $categoryIds[$categoryName]
                        ]);
                    }
                    $categoryIds[$categoryName]['subcategories'] = [$subcategory => $existingSubcategory->id];
                }
            }
        } else {
            throw ValidationException::withMessages([
                'fileInput' => 'The format of the import file is either corrupt or invalid'
            ]);
        }
        
        if (isset($arr['entries'])) {
            foreach ($arr['entries'] as $key => $value) {
                if($value['subcategory']) $value['subcategory_id'] = $categoryIds[$value['category']][$value['subcategory']];
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

        $groupedEntries->each(function ($item, $categoryName) use (&$stats) {

            $sortedArr = $item->groupBy(function ($item, int $key) {
                return $item->amount >= 0 ? 'income' : 'expense';
            });

            array_push($stats['income'], [
                'name' => $categoryName,
                'amount' => isset($sortedArr['income']) ?
                    round($sortedArr['income']->sum('amount'), 2) :
                    0
            ]);

            array_push($stats['expense'], [
                'name' => $categoryName,
                'amount' => isset($sortedArr['expense']) ?
                    round($sortedArr['expense']->sum('amount'), 2) :
                    0
            ]);
        });

        return $stats;
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
}
