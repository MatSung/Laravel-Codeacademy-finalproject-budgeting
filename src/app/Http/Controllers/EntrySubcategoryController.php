<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreEntrySubcategoryRequest;
use App\Http\Requests\UpdateEntrySubcategoryRequest;
use App\Models\EntrySubcategory;
use Illuminate\Http\RedirectResponse;
use Illuminate\Validation\ValidationException;
use Inertia\Inertia;
use Inertia\Response;

class EntrySubcategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
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
        EntrySubcategory::create($validated);
        return back(303);
    }

    /**
     * Display the specified resource.
     */
    public function show(EntrySubcategory $entrySubcategory)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(EntrySubcategory $entrySubcategory)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateEntrySubcategoryRequest $request, EntrySubcategory $subcategory)
    {
        
        $validated = $request->validated();
        $subcategory->update($validated);
        return back(303);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(EntrySubcategory $subcategory)
    {
        $subcategory->delete();
        return back(303);
    }
}
