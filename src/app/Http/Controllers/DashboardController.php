<?php

namespace App\Http\Controllers;

use Illuminate\Support\Arr;
use App\Models\Entry;
use Inertia\Inertia;
use App\Models\EntryCategory;
use App\Traits\HasStats;
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

        foreach ($allowedOrderByValues as &$value) {
            if (Str::endsWith($value, '_id')) $value = substr($value, 0, -3);
        }

        if (!in_array(request('order_by'), $allowedOrderByValues)) {
            $orderBy = 'transaction_date';
        }

        $order = request('order') === 'asc' ? 'asc' : 'desc';

        $queryBuilder = Entry::query()
            ->select('entries.*')
            ->join('entry_categories', 'entry_categories.id', '=', 'entries.category_id');
        

        // filtering
        $queryBuilder->filter(Request::only('category', 'subcategory', 'income'));

        // ordering
        if ($orderBy === 'category') {
            $queryBuilder->orderBy('entry_categories.name', $order);
        } else {
            $queryBuilder->orderBy($orderBy, $order);
        }

        // pagination
        $data = $queryBuilder->paginate($pageSize)->withQueryString();

        // stats
        $thisMonthsData = Entry::query()->whereMonth('transaction_date', date('m'))->get();
        $stats = Entry::sortedStats($thisMonthsData);


        return Inertia::render('Budgeting/Dashboard', [
            'data' => $data,
            'categories' => EntryCategory::with('subcategories')->get()->keyBy('id'),
            'stats' => $stats,
            'filters' => Request::all('order', 'order_by', 'group_by', 'income', 'category', 'subcategory', 'page'),
        ]);
    }

    
}
