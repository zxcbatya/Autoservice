<?php

declare(strict_types=1);

namespace App\Models\Sto;

use Illuminate\Database\Eloquent\Model;

class StoExpense extends Model
{
    protected $table = 'sto_expenses';

    protected $fillable = [
        'description',
        'amount',
        'category',
        'expense_date',
    ];

    protected $casts = [
        'amount' => 'decimal:2',
        'expense_date' => 'date',
    ];

    public const CATEGORIES = [
        'rent' => 'Аренда',
        'utilities' => 'Коммунальные',
        'taxes' => 'Налоги',
        'advertising' => 'Реклама',
        'tools' => 'Инструмент',
        'other' => 'Прочее',
    ];
}
