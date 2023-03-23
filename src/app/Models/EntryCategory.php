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

    protected $hidden = [
        'created_at',
        'updated_at'
    ];

    public function entry()
    {
        return $this->hasMany(Entry::class);
    }

    public function subcategories()
    {
        return $this->hasMany(EntrySubcategory::class, 'parent_id', 'id');
    }
}
