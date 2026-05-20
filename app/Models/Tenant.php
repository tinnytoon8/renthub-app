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
    
    protected static function booted()
    {
        // mengubah status kontrakan bergantung dari data penyewa yang dihapus dari tabel
        static::deleting(function ($tenant) {
            $activeLeases = $tenant->leases()->where('status', 'active')->get();

            foreach ($activeLeases as $lease) {
                if ($lease->room) {
                    $lease->room->update(['status' => 'available']);
                }

                $lease->delete();
            }
        });

        static::deleted(function ($tenant) {
            if ($tenant->photo_identity) {
                \Illuminate\Support\Facades\Storage::disk('local')->delete($tenant->photo_identity);
            }
        });
    }
}
