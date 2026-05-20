<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Lease extends Model
{
    use HasFactory;
    // field yang diizinkan untuk diisi ke form/request
    protected $fillable = ['room_id', 'tenant_id', 'start_date', 'end_date', 'deposit_amount', 'status'];

    public function room()
    {
        // kontrak sewa ini milik satu room (kontrakan)
        return $this->belongsTo(Room::class);
    }

    public function tenant()
    {
        // kontrak sewa ini milik satu penyewa
        return $this->belongsTo(Tenant::class);
    }

    protected static function booted()
    {
        // ubah status room saat sudah di check-in oleh penyewa
        static::created(function ($lease) {
            $lease->room->update(['status' => 'occupied']);
        });

        // mengubab status kontrakan bergantung dari aktif atau tidak penyewa
        static::updated(function ($lease) {
            if($lease->status === 'closed') {
                $lease->room->update(['status' => 'available']);
            } else if ($lease->status === 'active') {
                $lease->room->update(['status' => 'occupied']);
            }
        });

        // mengubah status kontrakan bergantung dari penyewa pindah kontrakan
        static::updating(function ($lease) {
            if ($lease->isDirty('room_id')) {
                $oldRoomId = $lease->getOriginal('room_id');
                $newRoomId = $lease->room_id;

                \App\Models\Room::find($oldRoomId)->update(['status' => 'available']);
                \App\Models\Room::find($newRoomId)->update(['status' => 'available']);
            }

            if($lease->isDirty('status') && $lease->status === 'closed') {
                $lease->room->update(['status' => 'available']);
            }
        });

        // mengubah status kontrakan bergantung dari data penyewa yang dihapus dari tabel
        static::deleting(function ($lease) {
            if ($lease->room_id) {
                \App\Models\Room::where('id', $lease->room_id)
                    ->update(['status' => 'available']);
            }
        });
    }

    public function payments()
    {
        // satu kontrakan bisa punya banyak pembayaran
        return $this->hasMany(Payment::class);
    }
}
