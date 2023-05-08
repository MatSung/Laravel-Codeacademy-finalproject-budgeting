<?php

namespace App\Http\Controllers;

use App\Services\ExchangerateService;
use Illuminate\Http\Request;
use Inertia\Inertia;

class ExchangeController extends Controller
{
    

    public function __invoke(ExchangerateService $exchange)
    {
        return Inertia::render('Budgeting/Exchange',[
            'exchange' => $exchange->getSymbols()
    ]);
    }
}
