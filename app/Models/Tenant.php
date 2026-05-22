<?php

namespace App\Models;

use App\Models\Lease;
use Illuminate\Database\Eloquent\Model;
use Spatie\Activitylog\Models\Concerns\LogsActivity;
use Spatie\Activitylog\Support\LogOptions;

class Tenant extends Model
{
    use LogsActivity;
    
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

        // menghapus foto identitas secara otomatis di storage jika data penyewa dihapus
        static::deleted(function ($tenant) {
            if ($tenant->photo_identity) {
                \Illuminate\Support\Facades\Storage::disk('local')->delete($tenant->photo_identity);
            }
        });
    }

    public function getActivityLogOptions(): LogOptions
    {
        return LogOptions::defaults()
            ->logOnly(['name', 'phone'])
            ->logOnlyDirty();
    }
}
