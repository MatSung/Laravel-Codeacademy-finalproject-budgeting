<?php

namespace App\Http\Controllers;

use App\Models\Entry;
use Inertia\Inertia;
use App\Models\EntryCategory;
use Inertia\Response;

class DashboardController extends Controller
{
    public function __invoke(): Response
    {
        $sort = request('sort') ?? true;

        $queryBuilder = Entry::query();

        if ($sort){
            $queryBuilder->latest('transaction_date');
        }

        $entries = $queryBuilder->get()->toArray();


        $categories = EntryCategory::with('subcategories')->get()->keyBy('id');

        return Inertia::render('Budgeting/Dashboard',[
            'entries' => $entries,
            'categories' => $categories
        ]);
    }
}
