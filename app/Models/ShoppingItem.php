<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ShoppingItem extends Model
{
    use HasFactory;

    public $timestamps = true;

        protected $fillable = [
        'user_id',
        'shopping_list_id',
        'nama_barang',
        'jumlah',
        'harga',
        'kategori',
        'image',
        'waktu_belanja',
        'status',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function shoppingList()
    {
        return $this->belongsTo(ShoppingList::class);
    }

}
