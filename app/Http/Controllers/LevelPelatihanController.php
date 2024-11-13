<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;
use App\Models\LevelPelatihanModel;

class LevelPelatihanController extends Controller
{
    public function index()
    {
        $breadcrumb = (object) [
            'title' => 'Daftar Level Pelatihan',
            'list' => ['Home', 'Level Pelatihan']
        ];
        $page = (object) [
            'title' => 'Daftar level pelatihan yang terdaftar dalam sistem',
        ];
        $activeMenu = 'level_pelatihan';

        return view('data_pelatihan.level.index', [
            'breadcrumb' => $breadcrumb,
            'page' => $page,
            'activeMenu' => $activeMenu
        ]);
    }

    // Ambil data level pelatihan dalam bentuk JSON untuk DataTables
    public function list(Request $request) 
    { 
        $levelPelatihan = LevelPelatihanModel::select('level_pelatihan_id', 'level_pelatihan_kode', 'level_pelatihan_nama');
    
        return DataTables::of($levelPelatihan)
            ->addIndexColumn()
            ->addColumn('aksi', function ($level) {  
                $btn  = '<a href="'.url('/level_pelatihan/' . $level->level_pelatihan_id).'" class="btn btn-info btn-sm">Detail</a> '; 
                $btn .= '<a href="'.url('/level_pelatihan/' . $level->level_pelatihan_id . '/edit').'" class="btn btn-warning btn-sm">Edit</a> '; 
                $btn .= '<form class="d-inline-block" method="POST" action="'. url('/level_pelatihan/'.$level->level_pelatihan_id).'">' 
                        . csrf_field() . method_field('DELETE') .  
                        '<button type="submit" class="btn btn-danger btn-sm" onclick="return confirm(\'Apakah Anda yakin menghapus data ini?\');">Hapus</button></form>';      
                return $btn; 
            })
            ->rawColumns(['aksi'])
            ->make(true);
    } 

    public function create()
    {
        $breadcrumb = (object) [
            'title' => 'Tambah Level Pelatihan',
            'list' => ['Home', 'Level Pelatihan', 'Tambah']
        ];
        $page = (object) [
            'title' => 'Form Tambah Level Pelatihan',
        ];
        $activeMenu = 'level_pelatihan';

        return view('data_pelatihan.level.create', [
            'breadcrumb' => $breadcrumb,
            'page' => $page,
            'activeMenu' => $activeMenu
        ]);
    }

    public function store(Request $request)
    {
        $request->validate([
            'level_pelatihan_kode' => 'required|string|max:255',
            'level_pelatihan_nama' => 'required|string|max:255',
        ]);

        LevelPelatihanModel::create($request->all());
        return redirect('/level_pelatihan')->with('success', 'Data level pelatihan berhasil disimpan');
    }

    public function show($id)
    {
        $levelPelatihan = LevelPelatihanModel::findOrFail($id);
        $breadcrumb = (object) [
            'title' => 'Detail Level Pelatihan',
            'list' => ['Home', 'Level Pelatihan', 'Detail']
        ];
        $page = (object) [
            'title' => 'Detail Level Pelatihan'
        ];
        $activeMenu = 'level_pelatihan';

        return view('data_pelatihan.level.show', [
            'breadcrumb' => $breadcrumb,
            'page' => $page,
            'levelPelatihan' => $levelPelatihan,
            'activeMenu' => $activeMenu
        ]);
    }

    public function edit($id)
    {
        $levelPelatihan = LevelPelatihanModel::findOrFail($id);

        $breadcrumb = (object) [
            'title' => 'Edit Level Pelatihan',
            'list' => ['Home', 'Level Pelatihan', 'Edit']
        ];
        $page = (object) [
            'title' => 'Edit Data Level Pelatihan'
        ];
        $activeMenu = 'level_pelatihan';

        return view('data_pelatihan.level.edit', [
            'breadcrumb' => $breadcrumb,
            'page' => $page,
            'levelPelatihan' => $levelPelatihan,
            'activeMenu' => $activeMenu
        ]);
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'level_pelatihan_kode' => 'required|string|max:255',
            'level_pelatihan_nama' => 'required|string|max:255',
        ]);

        $levelPelatihan = LevelPelatihanModel::findOrFail($id);
        $levelPelatihan->update($request->all());
        return redirect('/level_pelatihan')->with('success', 'Data level pelatihan berhasil diupdate');
    }

    public function destroy($id)
    {
        $levelPelatihan = LevelPelatihanModel::findOrFail($id);
        
        try {
            $levelPelatihan->delete();
            return redirect('/level_pelatihan')->with('success', 'Data level pelatihan berhasil dihapus');
        } catch (\Illuminate\Database\QueryException $e) {
            return redirect('/level_pelatihan')->with('error', 'Data level pelatihan gagal dihapus karena masih terdapat keterkaitan dengan data lain');
        }
    }
}


