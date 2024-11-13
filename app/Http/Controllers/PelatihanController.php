<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\PelatihanModel;
use App\Models\LevelPelatihanModel;
use App\Models\BidangModel;
use App\Models\VendorModel;
use Yajra\DataTables\DataTables;

class PelatihanController extends Controller
{
    public function index()
    {
        $breadcrumb = (object) [
            'title' => 'Daftar Pelatihan',
            'list' => ['Home', 'Pelatihan']
        ];
        $page = (object) [
            'title' => 'Daftar pelatihan yang terdaftar dalam sistem',
        ];
        $activeMenu = 'pelatihan'; // set menu yang sedang aktif
        $pelatihan = PelatihanModel::all(); // ambil data pelatihan untuk filter pelatihan
        return view('data_pelatihan.pelatihan.index', ['breadcrumb' => $breadcrumb, 'page' => $page, 'pelatihan' => $pelatihan, 'activeMenu' => $activeMenu]);
    }

    // Ambil data user dalam bentuk json untuk datatables 
    public function list(Request $request) 
    { 
        $users = PelatihanModel::select('pelatihan_id', 'nama_pelatihan', 'deskripsi','tanggal', 'bidang_id', 'level_pelatihan_id', 'vendor_id') 
                    ->with('level'); 
    
        return DataTables::of($users) 
            // menambahkan kolom index / no urut (default nama kolom: DT_RowIndex) 
            ->addIndexColumn()  
            ->addColumn('aksi', function ($user) {  // menambahkan kolom aksi 
                $btn  = '<a href="'.url('/pelatihan/' . $user->user_id).'" class="btn btn-info btn-sm">Detail</a> '; 
                $btn .= '<a href="'.url('/pelatihan/' . $user->user_id . '/edit').'" class="btn btn-warning btn-sm">Edit</a> '; 
                $btn .= '<form class="d-inline-block" method="POST" action="'. url('/pelatihan/'.$user->user_id).'">' 
                        . csrf_field() . method_field('DELETE') .  
                        '<button type="submit" class="btn btn-danger btn-sm" onclick="return confirm(\'Apakah Anda yakit menghapus data ini?\');">Hapus</button></form>';      
                return $btn; 
            }) 
            ->rawColumns(['aksi']) // memberitahu bahwa kolom aksi adalah html 
            ->make(true); 
    } 

    public function create()
    {
        $breadcrumb = (object) [
            'title' => 'Tambah Pelatihan',
            'list' => ['Home', 'Platihan', 'Tambah']
        ];
        $page = (object) [
            'title' => 'Form Tambah Pelatihan',
        ];
        $pelatihan = PelatihanModel::all(); // Ambil data pelatihan untuk ditampilkan di form
        $activeMenu = 'pelatihan'; // Set menu yang sedang aktif
        return view('data_pelatihan.pelatihan.create', ['breadcrumb' => $breadcrumb, 'page' => $page, 'pelatihan' => $pelatihan, 'activeMenu' => $activeMenu]);
    }

    public function store(Request $request)
    {
        $request->validate([
            'nama_sertifikasi' => 'required|string|max:255',
            'tanggal' => 'required|date',
            'bidang_id' => 'required|integer',
            'jenis_id' => 'required|integer',
            'tanggal_berlaku' => 'required|date'

        ]);
        PelatihanModel::create($request->all());
        return redirect('/pelatihan')->with('success', 'Data user berhasil dsimpan');
    }

    // Menampilkan halaman detail user
    public function show(string $id)
    {
        $pelatihan = PelatihanModel::with('pelatihan')->find($id);
        $breadcrumb = (object) [
            'title' => 'Detail Pelatihan',
            'list' => ['Home', 'Pelatihan', 'Detail']
        ];
        $page = (object)[
            'title' => 'Detail Pelatihan'
        ];
        $activeMenu = 'pelatihan';
        return view('data_pelatihan.pelatihan.show', ['breadcrumb' => $breadcrumb, 'page' => $page, 'pelatihan' => $pelatihan, 'activeMenu' => $activeMenu]);
    }

    // Menampilkan halaman form edit user
    public function edit(string $id)
    {
        $pelatihan = PelatihanModel::findOrFail($id); // Mengambil data pelatihan berdasarkan ID
        $bidang = BidangModel::all(); // Mengambil data bidang untuk pilihan dropdown
        $level = LevelPelatihanModel::all(); // Mengambil data level pelatihan
        $vendor = VendorModel::all(); // Mengambil data vendor

        $breadcrumb = (object) [
            'title' => 'Edit Pelatihan',
            'list' => ['Home', 'Pelatihan', 'Edit']
        ];
        
        $page = (object) [
            'title' => 'Edit Data Pelatihan'
        ];
        
        $activeMenu = 'pelatihan'; // Set menu yang sedang aktif

        return view('data_pelatihan.pelatihan.edit', [
            'breadcrumb' => $breadcrumb,
            'page' => $page,
            'pelatihan' => $pelatihan,
            'bidang' => $bidang,
            'level' => $level,
            'vendor' => $vendor,
            'activeMenu' => $activeMenu
        ]);
    }

    public function update(Request $request, string $id)
    {
        $request->validate([
            'nama_pelatihan' => 'required|string|max:255',
            'deskripsi' => 'nullable|string',
            'tanggal' => 'required|date',
            'bidang_id' => 'required|integer',
            'level_pelatihan_id' => 'required|integer',
            'vendor_id' => 'required|integer'
        ]);

        $pelatihan = PelatihanModel::findOrFail($id);
        $pelatihan->update($request->all());
        return redirect('/pelatihan')->with('success', 'Data pelatihan berhasil diupdate');
    }

    public function destroy(string $id)
    {
        // Cek apakah data user dengan ID yang dimaksud ada atau tidak
        $check = PelatihanModel::find($id);
        if (!$check) {
            return redirect('/pelatihan')->with('error', 'Data pelatihan tidak ditemukan');
        }
        try {
            // Hapus data pelatihan
            PelatihanModel::destroy($id);
            return redirect('/pelatihan')->with('success', 'Data pelatihan berhasil dihapus');
        } catch (\Illuminate\Database\QueryException $e) {
            // Jika terjadi error ketika menghapus data, redirect kembali ke halaman dengan membawa pesan error
            return redirect('/pelatihan')->with('error', 'Data pelatihan gagal dihapus karena masih terdapat tabel lain yang terkait dengan data ini');
        }
    }
}
