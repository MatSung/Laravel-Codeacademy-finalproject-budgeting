<?php

namespace App\Http\Controllers;

use App\Models\Entry;
use Illuminate\Http\Request;
use Inertia\Inertia;
use Inertia\Response;
use Illuminate\Support\Facades\DB;

class StatisticsController extends Controller
{
    public function __invoke(Request $request): Response
    {
        $year = request('year');
        $month = request('month');
        if (!(is_numeric($year) && intval($year) >= 2000 && intval($year) <= 2100)) $year = '';
        if (!(is_numeric($month) && intval($month) >= 1 && intval($month) <= 12)) $month = '';

        $queryBuilder = Entry::query();

        if ($year) {
            $queryBuilder->whereYear('transaction_date', $year);
        }
        if ($month) {
            $queryBuilder->whereMonth('transaction_date', $month);
        }

        $entriesCol = $queryBuilder->get();

        $availableDates = Entry::getUsedYearsMonths();


        return Inertia::render('Budgeting/Statistics', [
            'stats' => Entry::sortedStats($entriesCol),
            'availableDates' => $availableDates,
            'filters' => ['year' => $year, 'month' => $month]
        ]);
    }
}
