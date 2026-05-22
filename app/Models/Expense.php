<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Spatie\Activitylog\Models\Concerns\LogsActivity;
use Spatie\Activitylog\Support\LogOptions;

class Expense extends Model
{
    use LogsActivity;

    protected $fillable = ['title', 'amount', 'expense_date', 'proof_of_expense', 'notes'];

    public function getActivityLogOptions(): LogOptions
    {
        return LogOptions::defaults()
            ->logOnly(['title', 'amount', 'expense_date'])
            ->logOnlyDirty();
    }
}