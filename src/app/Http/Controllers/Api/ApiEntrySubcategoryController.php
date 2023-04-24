<?php

namespace App\Http\Controllers\Api;

use App\Http\Requests\StoreEntrySubcategoryRequest;
use App\Http\Requests\UpdateEntrySubcategoryRequest;
use App\Models\EntrySubcategory;
use Illuminate\Support\Facades;

class ApiEntrySubcategoryController extends ApiController
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $showParent = request('showParent') ?? false;

        $queryBuilder = EntrySubcategory::query();

        if ($showParent) {
            $queryBuilder->with('category');
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
    public function store(StoreEntrySubcategoryRequest $request)
    {
        $validated = $request->validated();
        return response()->json(EntrySubcategory::create($validated), 201);
    }

    /**
     * Display the specified resource.
     */
    public function show(EntrySubcategory $subcategory)
    {
        $showParent = request('showParent') ?? false;

        if ($showParent) {
            $subcategory->load('category');
        }

        return response()->json($subcategory);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(EntrySubcategory $subcategory)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateEntrySubcategoryRequest $request, EntrySubcategory $subcategory)
    {
        $validated = $request->validated();
        return response()->json($subcategory->update($validated), 200);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(EntrySubcategory $subcategory)
    {
        $subcategory->delete();
        return response();
    }
}
