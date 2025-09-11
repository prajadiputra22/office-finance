<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Transaction extends Model
{
    use HasFactory;

    protected $table = 'transactions';

    protected $fillable = [
        'type',
        'category_id',
        'amount',
        'date',
        'description',
        'date_factur',
        'no_factur',
        'attachment'
    ];

    protected $casts = [
        'date' => 'date',
        'date_factur' => 'date',
        'amount' => 'decimal:2'
    ];

    public function category()
    {
        return $this->belongsTo(Category::class, 'category_id');
    }
}
