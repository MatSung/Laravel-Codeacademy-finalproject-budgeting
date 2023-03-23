<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreEntryRequest;
use App\Http\Requests\UpdateEntryRequest;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use App\Models\Entry;
use DateTime;
use Illuminate\Http\JsonResponse;

class EntryController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(): JsonResponse
    {
        $dbEntries = Entry::all()->toArray();
        return response()->json($dbEntries);
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
        return response()->json(Entry::create($validated));
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

        return response()->json($entry->update($validated));
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
