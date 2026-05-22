<?php

namespace App\Models;

use App\Models\Lease;
use Illuminate\Database\Eloquent\Model;
use Spatie\Activitylog\Models\Concerns\LogsActivity;
use Spatie\Activitylog\Support\LogOptions;

class Room extends Model
{
    use LogsActivity;
    // field yang diizinkan untuk diisi ke form/request
    protected $fillable = ['room_number', 'type', 'address', 'photo', 'price', 'status'];

    public function leases()
    {
        // Satu kamar bisa punya banyak kontrak sewa
        return $this->hasMany(Lease::class);
    }

    protected static function booted()
    {
        // menghapus foto secara otomatis di storage jika data kontrakan dihapus
        static::deleted(function ($room) {
            if ($room->photo) {
                \Illuminate\Support\Facades\Storage::disk('local')->delete($room->photo);
            }
        });
    }

    public function getActivityLogOptions(): LogOptions
    {
        return LogOptions::defaults()
            ->logOnly(['room_number', 'price', 'status'])
            ->logOnlyDirty();
    }
}
