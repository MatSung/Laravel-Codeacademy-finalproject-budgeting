<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Inertia\Inertia;
use Inertia\Response;
use App\Models\Entry;
use Illuminate\Support\Facades\Storage;

class SettingsController extends Controller
{
    public function __invoke(): Response
    {
        return Inertia::render('Budgeting/Settings');
    }

    public function import()
    {
        // upload file, use it, delete it
    }

    public function export()
    {
        $myData = Entry::formatForExport();

        $fileName = time() . '_export.json';
        $fileStorePath = '/public/export/'.$fileName;

        Storage::put($fileStorePath,$myData);

        return Storage::download($fileStorePath, 'export.json');
    }
}
