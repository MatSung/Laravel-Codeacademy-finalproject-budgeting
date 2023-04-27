<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreEntryRequest;
use App\Http\Requests\UpdateEntryRequest;
use App\Models\Entry;
use App\Models\EntryCategory;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Request as FacadeRequest;
use Inertia\Inertia;
use Inertia\Response;

class EntryController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request): Response
    {
        // add some variables to filter by date, amount, category and so on
        // sorting
        // pages
        // by category?
        
        $sort = request('sort') === 'asc' ? 'asc' : 'desc';
        
        $queryBuilder = Entry::query();

        if ($sort === 'desc'){
            $queryBuilder->latest('transaction_date');
        } else {
            $queryBuilder->oldest('transaction_date');
        }

        $entries = $queryBuilder->get()->toArray();


        $categories = EntryCategory::with('subcategories')->get()->keyBy('id');

        return Inertia::render('Budgeting/Entries',[
            'entries' => $entries,
            'categories' => $categories,
            'filters' => FacadeRequest::all('order', 'order_by', 'group_by', 'income', 'category', 'subcategory')
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreEntryRequest $request): RedirectResponse
    {
        $validated = $request->validated();

        $validated['transaction_date'] = $validated['transaction_date'] ?? now()->toDateTimeString();
        $validated['transaction_date'] = date("Y-m-d H:i:s", strtotime($validated['transaction_date']));

        Entry::create($validated);
        return back(303);
    }

    /**
     * Display the specified resource.
     */
    public function show(Entry $entry)
    {
        // return response()->json($entry);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Entry $entry)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateEntryRequest $request, Entry $entry): RedirectResponse
    {
        $validated = $request->validated();

        $validated['transaction_date'] = $validated['transaction_date'] ?? now()->toDateTimeString();
        $validated['transaction_date'] = date("Y-m-d H:i:s", strtotime($validated['transaction_date']));
        
        $validated['subcategory_id'] = $validated['subcategory_id'] ?? null;
        $entry->update($validated);
        return back(303);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Entry $entry): RedirectResponse
    {
        $entry->delete();
        return back(303);
    }
}
