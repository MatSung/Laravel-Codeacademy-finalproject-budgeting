<?php

namespace App\Http\Controllers;

use App\Models\Entry;
use Illuminate\Http\Request;
use Inertia\Inertia;
use Inertia\Response;

class StatisticsController extends Controller
{
    public function __invoke(): Response
    {

        $queryBuilder = Entry::query()
            ->select('entries.*')
            ->join('entry_categories', 'entry_categories.id', '=', 'entries.category_id');
        
        $entriesCol = $queryBuilder->get();

        return Inertia::render('Budgeting/Statistics', [
            'stats' => Entry::sortedStats($entriesCol)
        ]);
    }
}
