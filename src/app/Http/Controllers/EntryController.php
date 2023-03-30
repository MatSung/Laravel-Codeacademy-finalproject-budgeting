<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreEntryRequest;
use App\Http\Requests\UpdateEntryRequest;
use App\Models\Entry;
use App\Models\EntryCategory;
use DateTime;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Redirect;
use Inertia\Inertia;
use Inertia\Response;

class EntryController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(): Response
    {
        // add some variables to filter by date, amount, category and so on
        // sorting
        // pages
        // by category?
        $sort = request('sort') ?? true;

        $queryBuilder = Entry::query();

        if ($sort){
            $queryBuilder->latest('transaction_date');
        }

        $entries = $queryBuilder->get()->toArray();


        $categories = EntryCategory::with('subcategories')->get()->keyBy('id');

        // dd($categories);

        return Inertia::render('Budgeting/Dashboard',[
            'entries' => $entries,
            'categories' => $categories
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
        Entry::create($validated);
        return redirect(route('entries.index'));
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
        $validated['subcategory_id'] = $validated['subcategory_id'] ?? null;
        $entry->update($validated);
        return redirect(route('entries.index'));
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Entry $entry): RedirectResponse
    {
        // if exists, delete
        $entry->delete();
        return redirect(route('entries.index'));
    }
}
