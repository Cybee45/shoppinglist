<?php

namespace App\Http\Controllers;

use App\Models\ShoppingList;
use Illuminate\Http\Request;
use App\Models\ShoppingItem;
use Illuminate\Support\Facades\Auth;

class ShoppingListController extends Controller
{
    public function show($id)
    {
        $list = ShoppingList::with('items')->findOrFail($id);

        // Hitung total harga semua item dalam list
        $totalHarga = $list->items->sum(function ($item) {
            return $item->harga * $item->jumlah;
        });

        return view('lists.show', compact('list', 'totalHarga'));
    }

   public function edit($id)
    {
        $item = ShoppingItem::findOrFail($id);
        return view('items.edit', compact('item'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'name' => 'required|string|max:255',
        ]);

        $list = ShoppingList::findOrFail($id);
        $list->update(['name' => $request->name]);

        return redirect()->route('items.edit', $id)->with('success', 'Judul list berhasil diupdate!');
    }

    public function destroy($id)
    {
        $list = ShoppingList::findOrFail($id);

        if ($list->user_id !== auth()->id()) {
            abort(403);
        }

        // Hapus semua item terkait
        $list->items()->delete();
        $list->delete();

        return redirect()->route('items.index')
                         ->with('success', 'Daftar belanja dan semua item di dalamnya berhasil dihapus!');
    }
        public function complete($id)
    {
        $list = ShoppingList::findOrFail($id);

        // Tandai semua item di list ini sebagai selesai
        foreach ($list->items as $item) {
            $item->status = 'selesai';
            $item->save();
        }

        // Tandai list sebagai selesai (optional)
        $list->status_selesai = true;
        $list->save();

        return redirect()->route('items.index')->with('success', 'List berhasil dipindahkan ke riwayat!');
    }

    public function restore($id)
    {
        $list = ShoppingList::findOrFail($id);

        // Ubah status list jadi aktif
        $list->status_selesai = false;
        $list->save();

        // Ubah status semua item jadi aktif
        foreach ($list->items as $item) {
            $item->status = 'aktif';
            $item->save();
        }

        return redirect()->route('items.index')->with('success', 'List berhasil dikembalikan ke daftar aktif!');
    }

}
