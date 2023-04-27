<?php

namespace App\Http\Controllers;

use Illuminate\Support\Arr;
use App\Models\Entry;
use Inertia\Inertia;
use App\Models\EntryCategory;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Support\Facades\Request;
use Illuminate\Support\Facades\Schema;
use Inertia\Response;
use Illuminate\Support\Str;
use PhpParser\Node\Expr\Cast\Array_;

class DashboardController extends Controller
{
    public function __invoke(): Response
    {
        $orderBy = request('order_by');
        $pageSize = 10;

        $allowedOrderByValues = Entry::getColumns();

        foreach ($allowedOrderByValues as &$value){
            if(Str::endsWith($value,'_id')) $value = substr($value, 0, -3);
        }

        if (!in_array(request('order_by'), $allowedOrderByValues)) {
            $orderBy = 'transaction_date';
        }

        $order = request('order') === 'asc' ? 'asc' : 'desc';

        $queryBuilder = Entry::query()
            ->select('entries.*')
            ->join('entry_categories', 'entry_categories.id', '=', 'entries.category_id');

        // ordering
        if($orderBy === 'category'){
            $queryBuilder->orderBy('entry_categories.name', $order);
        } else {
            $queryBuilder->orderBy($orderBy, $order);
        }

        // filtering

        // collection before pagination
        $entriesCol = $queryBuilder->get();

        // pagination
        $data = $queryBuilder->paginate($pageSize)->withQueryString();
        

        // entries
        // $entries = $queryBuilder->get()->toArray();

        // dd($data);

        // categories
        $categories = EntryCategory::with('subcategories')->get()->keyBy('id');


        // stats
        $stats = $this->stats($entriesCol);

        return Inertia::render('Budgeting/Dashboard', [
            'data' => $data,
            'categories' => $categories,
            'stats' => $stats,
            'filters' => Request::all('order', 'order_by', 'group_by', 'income', 'category', 'subcategory'),
            // 'entries' => $data->items()
        ]);
    }

    private function stats(Collection $entryCollection): Array
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

            if (isset($sortedArr['income'])) {
                $stats['income'][$categoryName] = $sortedArr['income']->sum('amount');
            } else {
                $stats['income'][$categoryName] = 0;
            }

            if (isset($sortedArr['expense'])) {
                $stats['expense'][$categoryName] = $sortedArr['expense']->sum('amount');
            } else {
                $stats['expense'][$categoryName] = 0;
            }
        });

        return $stats;
    }
}
