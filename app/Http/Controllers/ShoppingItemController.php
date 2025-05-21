<?php

namespace App\Http\Controllers;

use App\Models\ShoppingItem;
use App\Models\ShoppingList;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;

class ShoppingItemController extends Controller
{
        public function index()
    {
        $lists = ShoppingList::withCount('items')
                    ->where('user_id', auth()->id())
                    ->where('status_selesai', false)
                    ->get();

        $listsSelesai = ShoppingList::with(['items' => function($q) {
                        $q->where('status', 'selesai');
                    }])
                    ->where('user_id', auth()->id())
                    ->where('status_selesai', true)
                    ->get();

        return view('items.index', compact('lists', 'listsSelesai'));
    }

    public function edit($id)
    {
        $item = ShoppingItem::findOrFail($id);
        return view('items.edit', compact('item'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'nama_barang' => 'required|string|max:255',
            'jumlah' => 'required|integer|min:1',
            'harga' => 'required|numeric|min:0',
            'kategori' => 'required|string|max:255',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',  // Validasi gambar
        ]);

        $item = ShoppingItem::findOrFail($id);

        // Jika ada gambar baru yang di-upload, hapus gambar lama dan simpan gambar baru
        if ($request->hasFile('image')) {
            // Hapus gambar lama jika ada
            if ($item->image) {
                unlink(storage_path('app/public/' . $item->image));
            }

            // Simpan gambar baru
            $imagePath = $request->file('image')->store('images', 'public');
            $item->image = $imagePath;  // Update gambar di item
        }

        // Update informasi item
        $item->update($request->only('nama_barang', 'jumlah', 'harga', 'kategori'));

        return redirect()->route('lists.show', $item->shopping_list_id)->with('success', 'Item berhasil diperbarui.');
    }


    public function destroy($id)
    {
        $item = ShoppingItem::findOrFail($id);
        $item->delete();
        return back()->with('success', 'Item berhasil dihapus.');
    }

    public function toggleStatus($id)
    {
        $item = ShoppingItem::findOrFail($id);
        $item->status = $item->status === 'aktif' ? 'selesai' : 'aktif';
        $item->save();

        return back();
    }

    public function deleteAllHistory()
    {
        ShoppingItem::where('status', 'selesai')->delete();
        return back()->with('success', 'Semua item selesai berhasil dihapus.');
    }

    public function create()
    {
        return view('items.create'); // Pastikan file blade ada di resources/views/items/create.blade.php
    }                                                                                                                                                                                                                                         

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'items' => 'required|array|min:1',
            'items.*.nama_barang' => 'required|string|max:255',
            'items.*.jumlah' => 'required|integer|min:1',
            'items.*.harga' => 'required|numeric|min:0',
            'items.*.kategori' => 'required|string|max:255',
            'items.*.image' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',  // Validasi gambar
        ]);

        // Buat daftar belanja baru
        $list = ShoppingList::create([
            'user_id' => auth()->id(),
            'name' => $request->name,
            'status_selesai' => false,
        ]);

        // Simpan semua item ke list yang baru dibuat
        foreach ($request->items as $itemData) {
            // Cek apakah ada gambar untuk setiap item
            if ($request->hasFile('items.*.image')) {
                $imagePath = $itemData['image']->store('images', 'public');  // Menyimpan gambar per item
            }

            ShoppingItem::create([
                'user_id' => auth()->id(),
                'shopping_list_id' => $list->id,
                'nama_barang' => $itemData['nama_barang'],
                'jumlah' => $itemData['jumlah'],
                'harga' => $itemData['harga'],
                'kategori' => $itemData['kategori'],
                'image' => $imagePath ?? null,  // Simpan path gambar atau null
                'waktu_belanja' => now(),
                'status' => 'aktif',
            ]);
        }
        return redirect()->route('items.index')->with('success', 'List dan semua barang berhasil ditambahkan!');
    }

    public function storeTambahItem(Request $request)
    {
        $validated = $request->validate([
            'list_id' => 'required|exists:shopping_lists,id',
            'nama_barang' => 'required|string|max:255',
            'jumlah' => 'required|integer|min:1',
            'harga' => 'required|numeric|min:0',
            'kategori' => 'required|string|max:255',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
        ]);

        if ($request->hasFile('image')) {
            $validated['image'] = $request->file('image')->store('images', 'public');
        }

        ShoppingItem::create([
            'user_id' => auth()->id(),
            'shopping_list_id' => $validated['list_id'],
            'nama_barang' => $validated['nama_barang'],
            'jumlah' => $validated['jumlah'],
            'harga' => $validated['harga'],
            'kategori' => $validated['kategori'],
            'image' => $validated['image'] ?? null,
            'waktu_belanja' => now(),
            'status' => 'aktif',
        ]);

        return redirect()->route('lists.show', $validated['list_id'])->with('success', 'Item berhasil ditambahkan ke list!');
    }


    public function createTambah(Request $request)
    {
        $list_id = $request->query('list_id');

        if (!$list_id) {
            abort(404, "List ID tidak ditemukan.");
        }

        $list = ShoppingList::findOrFail($list_id);

        return view('items.createTambah', compact('list'));
    }
}
    
// Catatan perbaikan:
// - Gunakan view 'lists.index' bukan 'items.index' jika kontennya daftar list
// - Semua manajemen item dipindahkan ke controller ini, bukan ShoppingListController
// - Gunakan relasi seperti $list->items atau $list->items()->count() di view
