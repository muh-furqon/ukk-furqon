<?php

namespace App\Http\Controllers\Member;

use App\Http\Controllers\Controller;
use App\Models\Barang;
use App\Models\Kategori;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    public function index(Request $request)
    {
        // Get search and category filter input
        $search = $request->input('search');
        $categoryId = $request->input('category');

        // Fetch products with filtering
        $query = Barang::query();

        if ($search) {
            $query->where('nama_barang', 'like', '%' . $search . '%');
        }

        if ($categoryId) {
            $query->where('kategori_id', $categoryId);
        }

        $products = $query->with('kategori')->get();
        $categories = Kategori::all();

        return view('member.index', compact('products', 'categories'));
    }
}
