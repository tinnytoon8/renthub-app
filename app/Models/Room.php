<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Override;

class Room extends Model
{
    // field yang diizinkan untuk diisi ke form/request
    protected $fillable = ['room_number', 'type', 'address', 'photo', 'price', 'status'];

    public function leases()
    {
        // Satu kamar bisa punya banyak kontrak sewa
        return $this->hasMany(Lease::class);
    }

    protected static function booted()
    {
        static::deleted(function ($room) {
            if ($room->photo) {
                \Illuminate\Support\Facades\Storage::disk('local')->delete($room->photo);
            }
        });
    }
}
