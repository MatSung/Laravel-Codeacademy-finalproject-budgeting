<?php

namespace App\Http\Controllers\Api;

use App\Http\Requests\StoreEntryCategoryRequest;
use App\Http\Requests\UpdateEntryCategoryRequest;
use App\Models\EntryCategory;
use Illuminate\Http\Client\RequestException;
use Illuminate\Validation\ValidationException;
use Illuminate\Validation\Validator;

class ApiEntryCategoryController extends ApiController
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
    public function show(EntryCategory $category)
    {
        $listSubcategories = request('subcategories') ?? false;

        if ($listSubcategories) {
            $category->load('subcategories');;
        }

        return response()->json($category);
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
    public function update(UpdateEntryCategoryRequest $request, EntryCategory $category)
    {
        $validated = $request->validated();
        return response()->json($category->update($validated), 200);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(EntryCategory $category)
    {
        throw_if($category->loadCount('entries')->entries_count > 0, ValidationException::withMessages(
            ['category' => ['Category still has entries']]
        ));
        $category->delete();
        return response('',200);
    }
}
