<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class EntrySubcategory extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'parent_id'
    ];

    protected $hidden = [
        'created_at',
        'updated_at',
        'parent_id'
    ];

    public function entries()
    {
        return $this->hasMany(EntryCategory::class, 'category_id', 'id');
    }

    public function category()
    {
        return $this->belongsTo(EntryCategory::class, 'parent_id', 'id');
    }
}
