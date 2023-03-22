<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class EntryCategory extends Model
{
    use HasFactory;

    protected $fillable = [
        'name'
    ];

    public function entry()
    {
        return $this->belongsTo(Entry::class);
    }
}
