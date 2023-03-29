<?php

namespace App\Http\Controllers\Api;

use App\Http\Requests\StoreEntryRequest;
use App\Http\Requests\UpdateEntryRequest;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use App\Models\Entry;
use DateTime;
use Illuminate\Http\JsonResponse;

class EntryController extends ApiController
{
    /**
     * Display a listing of the resource.
     */
    public function index(): JsonResponse
    {
        // add some variables to filter by date, amount, category and so on
        // sorting
        // pages
        // by category?
        $sort = request('sort') ?? false;

        $queryBuilder = Entry::query();

        if ($sort){
            $queryBuilder->latest('transaction_date');
        }
        $entries = $queryBuilder->get()->toArray();
        return response()->json($entries);
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
    public function store(StoreEntryRequest $request): JsonResponse
    {
        $validated = $request->validated();
        $validated['transaction_date'] = $validated['transaction_date'] ?? now()->toDateTimeString();
        return response()->json(Entry::create($validated), 201);
    }

    /**
     * Display the specified resource.
     */
    public function show(Entry $entry): JsonResponse
    {
        return response()->json($entry);
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
    public function update(UpdateEntryRequest $request, Entry $entry): JsonResponse
    {
        $validated = $request->validated();
        $validated['transaction_date'] = $validated['transaction_date'] ?? now()->toDateTimeString();
        $validated['subcategory_id'] = $validated['subcategory_id'] ?? null;
        return response()->json($entry->update($validated), 200);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Entry $entry): Response
    {
        // if exists, delete
        $entry->delete();
        return response();
    }
}
