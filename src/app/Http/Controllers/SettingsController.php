<?php

namespace App\Http\Controllers;

use App\Http\Requests\ImportRequest;
use Illuminate\Http\Request;
use Inertia\Inertia;
use Inertia\Response;
use App\Models\Entry;
use App\Models\EntryCategory;
use App\Models\EntrySubcategory;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\Storage;
use Symfony\Component\HttpFoundation\StreamedResponse;

class SettingsController extends Controller
{
    public function __invoke(): Response
    {
        return Inertia::render('Budgeting/Settings');
    }

    public function import(ImportRequest $request)
    {
        $path = $request->file('importFile')->store('imports');
        $contents = json_decode(Storage::get($path), true);
        Storage::delete($path);
        Entry::importFromArray($contents);
        return back(303)->with('notification','Success');
    }
    
    /**
     * Export database contents
     *
     * @return StreamedResponse
     */
    public function export(): StreamedResponse
    {
        $myData = Entry::formatForExport();

        $fileName = time() . '_export.json';
        $fileStorePath = '/public/export/'.$fileName;

        Storage::put($fileStorePath,$myData);

        return Storage::download($fileStorePath, 'export.json');
    }
    
    /**
     * Delete all user database data
     *
     * @return void
     */
    public function purge()
    {
        Entry::truncate();
        Schema::disableForeignKeyConstraints();
        EntrySubcategory::truncate();
        EntryCategory::truncate();
        Schema::enableForeignKeyConstraints();
        EntryCategory::create(['name' => 'Category']);
        return back(303)->with('notification', 'Data purged. (Yes really)');
    }
}
