<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Barang;
use App\Models\Supplier;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index()
    {
        $totalVariety = Barang::count(); // Total jenis barang (variety)
        $totalStock = Barang::sum('stok'); // Total jumlah barang dari semua variety
        $totalSuppliers = Supplier::count(); // Total supplier yang bekerja sama

        return view('admin.index', compact('totalVariety', 'totalStock', 'totalSuppliers'));
    }
}
