<?php

declare(strict_types=1);

namespace App\Models\Sto;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class StoClient extends Model
{
    protected $table = 'sto_clients';

    protected $fillable = [
        'name',
        'phone',
        'email',
    ];

    public function orders(): HasMany
    {
        return $this->hasMany(StoOrder::class, 'client_id');
    }
}
