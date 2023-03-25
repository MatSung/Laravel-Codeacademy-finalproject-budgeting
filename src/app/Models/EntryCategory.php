<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class EntryCategory extends Model
{
    use HasFactory;

    protected $table = 'entry_categories';

    protected $fillable = [
        'name'
    ];

    protected $hidden = [
        'created_at',
        'updated_at'
    ];

    public function entries()
    {
        return $this->hasMany(Entry::class);
    }

    public function subcategories()
    {
        return $this->hasMany(EntrySubcategory::class, 'parent_id', 'id');
    }
}
