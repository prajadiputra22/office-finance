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
        'attachment',
        'date_entry',
    ];

    protected $casts = [
        'date' => 'date',
        'date_factur' => 'date',
        'date_entry' => 'datetime',
        'amount' => 'decimal:2',
    ];

    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    public function scopeIncome($query)
    {
        return $query->where('type', 'income');
    }

    public function scopeExpenditure($query)
    {
        return $query->where('type', 'expenditure');
    }

    public function scopeByDateRange($query, $startDate, $endDate)
    {
        return $query->whereBetween('date', [$startDate, $endDate]);
    }
}
