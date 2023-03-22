<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreEntryRequest;
use App\Http\Requests\UpdateEntryRequest;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use App\Models\Entry;

class EntryController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request, Response $response)
    {
        $entries = [];
        $dbEntries = Entry::with(['entryCategory','entrySubcategory'])
            ->get();
        foreach ( $dbEntries as $key => $value) {
            array_push(
                $entries,
                [
                    'id' => $value->id,
                    'amount' =>$value->amount,
                    'category_id' =>$value->category_id,
                    'subcategory_id' =>$value->subcategory_id,
                    'category' =>$value->entryCategory->name,
                    'subcategory' =>$value->entrySubcategory !== null ? $value->entrySubcategory->name : null,
                    'note' =>$value->note,
                ]
            );
        }
        return response()->json($entries);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(Request $request, Response $response)
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreEntryRequest $request)
    {
        $validated = $request->validate();
        dd($validated);
        // $request('transaction_date')
    }

    /**
     * Display the specified resource.
     */
    public function show(Entry $entry)
    {
        //
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
    public function update(UpdateEntryRequest $request, Entry $entry)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Entry $entry)
    {
        //
    }
}
