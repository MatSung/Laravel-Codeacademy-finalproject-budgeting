<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreEntryCategoryRequest;
use App\Http\Requests\UpdateEntryCategoryRequest;
use App\Models\Entry;
use App\Models\EntryCategory;
use Illuminate\Http\Request;

class EntryCategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $listSubcategories = request('subcategories') ?? false;

        $queryBuilder = EntryCategory::query();

        if ($listSubcategories) {
            $queryBuilder->with('subcategories');;
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
    public function store(StoreEntryCategoryRequest $request)
    {
        $validated = $request->validated();
        return response()->json(EntryCategory::create($validated), 201);
    }

    /**
     * Display the specified resource.
     */
    public function show(EntryCategory $entryCategory)
    {
        $listSubcategories = request('subcategories') ?? false;

        if ($listSubcategories) {
            $entryCategory->load('subcategories');;
        }

        return response()->json($entryCategory);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(EntryCategory $entryCategory)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateEntryCategoryRequest $request, EntryCategory $entryCategory)
    {
        $validated = $request->validated();
        return response()->json($entryCategory->update($validated), 200);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(EntryCategory $entryCategory)
    {
        $entryCategory->delete();
        return response();
    }
}
