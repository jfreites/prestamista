<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Client extends Model
{
    public function getTotalLoansAmountAttribute(): float
    {
        return $this->loans->sum('amount');
    }

    public function getTotalLoansAttribute(): float
    {
        return $this->loans->count();
    }

    public function addresses(): HasMany
    {
        return $this->hasMany(Address::class);
    }

    public function loans(): HasMany
    {
        return $this->hasMany(Loan::class);
    }
}
