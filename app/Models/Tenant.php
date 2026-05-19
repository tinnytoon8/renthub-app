<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Tenant extends Model
{
    // field yang diizinkan untuk diisi ke form/request
    protected $fillable = ['tenant_number', 'name', 'no_identity', 'phone', 'emergency_phone', 'photo_identity'];

    public function leases()
    {
        // satu penyewa bisa punya banyak kontrak
        return $this->hasMany(Lease::class);
    }
}
