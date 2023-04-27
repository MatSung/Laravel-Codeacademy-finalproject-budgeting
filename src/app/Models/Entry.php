<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Schema;

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

    protected $hidden = [
        'created_at',
        'updated_at',
        'category_id',
        'subcategory_id'
    ];

    protected $with = [
        'category',
        'subcategory'
    ];

    // https://laravel.com/docs/10.x/eloquent#default-attribute-values
    // protected $attributes = [];


    public function category()
    {
        return $this->belongsTo(EntryCategory::class, 'category_id', 'id');
    }

    public function subcategory()
    {
        return $this->belongsTo(EntrySubcategory::class, 'subcategory_id', 'id');
    }

    public static function getColumns(): array
    {
        return Schema::getColumnListing((new Entry)->getTable());
    }


    //https://laravel.com/docs/10.x/eloquent#query-scopes
    public function scopeIncomes(Builder $query): void
    {
        $query->where('amount', '>', 0);
    }

    public function scopeExpenses(Builder $query): void
    {
        $query->where('amount', '<', 0);
    }

    public function getTableColumns() {
        return $this->getConnection()->getSchemaBuilder()->getColumnListing($this->getTable());
    }
}
