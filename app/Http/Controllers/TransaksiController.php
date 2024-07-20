<?php
namespace App\Http\Controllers;

use App\Models\TransaksiHead;
use App\Models\TransaksiDetail;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class TransaksiController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $title = "Halaman Transaksi";
        $subtitle = "Menu Transaksi";
    
        // Mengambil semua transaksi head dengan detailnya
        $transaksiHeads = TransaksiHead::with('details.produk', 'user')->orderBy('id', 'desc')->get();
    
        // Mengambil semua detail transaksi
        $transaksiDetails = TransaksiDetail::with('produk', 'transaksiHead.user')->get();
    
        return view('back.transaksi.index', compact('transaksiHeads', 'transaksiDetails', 'title', 'subtitle'));
    }
    

    public function deleteAll()
    {
        try {
            // Use DB facade to perform a raw SQL delete query
            DB::statement('DELETE FROM transaksi_head');
            DB::statement('DELETE FROM transaksi_detail');
            
            // Redirect back with a success message
            return redirect()->route('transaksi.index')->with('success', 'All data deleted successfully.');
        } catch (\Exception $e) {
            // Redirect back with an error message if something goes wrong
            return redirect()->route('transaksi.index')->with('error', 'Failed to delete data. Please try again.');
        }
    }

    // Other methods remain unchanged

    public function show($id)
{
    $transaksiHead = TransaksiHead::with('details.produk', 'user')->findOrFail($id);
    return view('back.transaksi.detail', compact('transaksiHead'));
}

}
