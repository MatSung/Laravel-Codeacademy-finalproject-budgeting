<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreEntryCategoryRequest;
use App\Http\Requests\UpdateEntryCategoryRequest;
use App\Models\EntryCategory;
use Illuminate\Http\RedirectResponse;
use Illuminate\Validation\ValidationException;
use Inertia\Inertia;
use Inertia\Response;

class EntryCategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $queryBuilder = EntryCategory::query();
        $queryBuilder->withCount('entries');
        $queryBuilder->with('subcategories');
        $categories = $queryBuilder->get()->toArray();
        // dd($categories);
        return Inertia::render('Budgeting/Categories',[
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
    public function store(StoreEntryCategoryRequest $request)
    {
        $validated = $request->validated();
        EntryCategory::create($validated);
        return back(303);
    }

    /**
     * Display the specified resource.
     */
    public function show(EntryCategory $entryCategory)
    {
        //
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
        $category->update($validated);
        return back(303);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(EntryCategory $category): RedirectResponse
    {
        throw_if(EntryCategory::count() === 1, ValidationException::withMessages((
            ['category' => ['You cannot delete the final category']]
        )));
        throw_if($category->loadCount('entries')->entries_count > 0, ValidationException::withMessages(
            ['category' => ['Category still has entries']]
        ));
        $category->delete();
        return back(303);
    }
}
