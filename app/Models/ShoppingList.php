<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class ShoppingList extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'name',
        'status_selesai',
    ];

    public function items()
    {
        return $this->hasMany(ShoppingItem::class, 'shopping_list_id');
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /**  Total nilai uang dari semua item (harga satuan × jumlah). */
    public function getTotalHargaAttribute()
    {
        return $this->items->reduce(function ($sum, $item) {
            return $sum + ($item->harga * $item->jumlah);
        }, 0);
        // Jika 'harga' di DB sudah harga total per-item, cukup:
        // return $this->items->sum('harga');
    }
}
