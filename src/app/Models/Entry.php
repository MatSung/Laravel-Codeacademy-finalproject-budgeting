<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Entry extends Model
{
    use HasFactory;

    protected $table = 'entries';

    protected $fillable = [
        'transaction_date',
        'category_id',
        'subcategory_id',
        'amount',
        'note'
    ];

    // protected $attributes = [];


    public function entryCategory()
    {
        return $this->hasOne(EntryCategory::class, 'id', 'category_id');
    }

    public function entrySubcategory()
    {
        return $this->hasOne(EntrySubcategory::class, 'id', 'subcategory_id');
    }
}
