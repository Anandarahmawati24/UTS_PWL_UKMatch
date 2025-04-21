<?php

namespace App\Http\Controllers;

use App\Models\KategoriUkmModel;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;
use Illuminate\Support\Facades\Validator;

class KategoriUkmController extends Controller
{
    //controller halaman index
    public function index()
    {
        $breadcrumb = (object)[ //menampilkan title dan list untuk breadcrumb (jika ada)
            'title' => 'Daftar Kategori UKM',
            'list' => ['Beranda', 'Kategori UKM']
        ];

        $page = (object)[
            'title' => 'Daftar Kategori UKM dalam sistem'
        ];

        $activeMenu = 'kategori_ukm';
        // Ambil data kategori untuk dropdown filter
        $kategori_ukm = KategoriUkmModel::select('id_kategori', 'nama_kategori')->get();

        return view('kategori_ukm.index', compact('breadcrumb', 'page', 'activeMenu', 'kategori_ukm'));
    }

    //menampilkan data tabel
    public function list(Request $request)
    {
        $kategori = KategoriUkmModel::select('id_kategori', 'nama_kategori', 'created_at', 'updated_at');
        // Filter berdasarkan kategori jika ada
        if ($request->kategori_filter) {  // Gunakan kategori_filter, sesuai yang dikirim dari frontend
            $kategori->where('id_kategori', $request->kategori_filter);  // Filter berdasarkan id_kategori
        }
        return DataTables::of($kategori)
            ->addIndexColumn()
            ->addColumn('aksi', function ($item) {
                $btn = '<button onclick="modalAction(\'' . url('/kategori_ukm/' . $item->id_kategori . '/show_ajax') . '\')" class="btn btn-info btn-sm">Detail</button> ';
                $btn .= '<button onclick="modalAction(\'' . url('/kategori_ukm/' . $item->id_kategori . '/edit_ajax') . '\')" class="btn btn-warning btn-sm">Edit</button> ';
                $btn .= '<button onclick="modalAction(\'' . url('/kategori_ukm/' . $item->id_kategori . '/delete_ajax') . '\')" class="btn btn-danger btn-sm">Hapus</button> ';
                return $btn;
            })
            ->rawColumns(['aksi'])
            ->make(true);
    }

    public function create() //menampilkan halaman tambah data ver belum ajax
    {
        $breadcrumb = (object)[
            'title' => 'Tambah Kategori UKM',
            'list' => ['Beranda', 'Kategori UKM', 'Tambah']
        ];

        $page = (object)[
            'title' => 'Form Tambah Kategori UKM'
        ];

        $activeMenu = 'kategori_ukm';

        return view('kategori_ukm.create', compact('breadcrumb', 'page', 'activeMenu'));
    }

    public function store(Request $request) // menyimpan data tapi belum ajax
    {
        $request->validate([
            'nama_kategori' => 'required|string|max:255|unique:kategori_ukm,nama_kategori',
        ]);

        KategoriUkmModel::create($request->all());

        return redirect('/kategori_ukm')->with('success', 'Data Kategori UKM berhasil disimpan');
    }

    public function show(string $id)
    {
        $kategori = KategoriUkmModel::findOrFail($id);

        $breadcrumb = (object)[
            'title' => 'Detail Kategori UKM',
            'list' => ['Beranda', 'Kategori UKM', 'Detail']
        ];

        $page = (object)[
            'title' => 'Detail Kategori UKM'
        ];

        $activeMenu = 'kategori_ukm';

        return view('kategori_ukm.show', compact('breadcrumb', 'page', 'activeMenu', 'kategori'));
    }

    public function edit(string $id)
    {
        $kategori = KategoriUkmModel::findOrFail($id);

        $breadcrumb = (object)[
            'title' => 'Edit Kategori UKM',
            'list' => ['Beranda', 'Kategori UKM', 'Edit']
        ];

        $page = (object)[
            'title' => 'Edit Kategori UKM'
        ];

        $activeMenu = 'kategori_ukm';

        return view('kategori_ukm.edit', compact('breadcrumb', 'page', 'activeMenu', 'kategori'));
    }

    public function update(Request $request, string $id)
    {
        $request->validate([
            'nama_kategori' => 'required|string|max:255|unique:kategori_ukm,nama_kategori,' . $id . ',id_kategori',
        ]);

        $kategori = KategoriUkmModel::findOrFail($id);
        $kategori->update($request->all());

        return redirect('/kategori_ukm')->with('success', 'Data Kategori UKM berhasil diperbarui');
    }

    public function destroy(string $id)
    {
        try {
            $kategori = KategoriUkmModel::findOrFail($id);

            // Cek apakah kategori ini digunakan oleh UKM
            if ($kategori->ukm()->exists()) {
                return redirect('/kategori_ukm')->with('error', 'Gagal menghapus kategori. Data masih digunakan oleh UKM.');
            }

            $kategori->delete();
            return redirect('/kategori_ukm')->with('success', 'Data Kategori UKM berhasil dihapus');
        } catch (\Illuminate\Database\QueryException $e) {
            return redirect('/kategori_ukm')->with('error', 'Gagal menghapus kategori. Data masih terkait dengan tabel lain.');
        }
    }

    public function create_ajax() // menampilkan halaman tambah data ajax
    {
        $kategori_ukm = KategoriUkmModel::select('id_kategori', 'nama_kategori')->get();
        return view('kategori_ukm.create_ajax')->with('kategori_ukm', $kategori_ukm);
    }

    // Menyimpan data kategori UKM baru
    public function store_ajax(Request $request)
    {
        if ($request->ajax() || $request->wantsJson()) {
            $rules = [
                'nama_kategori' => 'required|string|min:3|max:100|unique:kategori_ukm,nama_kategori',
            ];

            $validator = Validator::make($request->all(), $rules);

            if ($validator->fails()) {
                return response()->json([
                    'status'  => false,
                    'message' => 'Validasi Gagal',
                    'msgField' => $validator->errors(),
                ]);
            }

            KategoriUkmModel::create($request->all());
            return response()->json([
                'status'  => true,
                'message' => 'Kategori UKM berhasil ditambahkan'
            ]);
        }

        return redirect('/kategori_ukm');
    }

    // Menampilkan form edit kategori UKM
    public function edit_ajax(string $id)
    {
        $kategori_ukm = KategoriUkmModel::find($id);
        return view('kategori_ukm.edit_ajax', ['kategori_ukm' => $kategori_ukm]);
    }

    // Proses update kategori UKM via AJAX
    public function update_ajax(Request $request, string $id)
    {
        if ($request->ajax() || $request->wantsJson()) {
            $rules = [
                'nama_kategori' => 'required|string|min:3|max:100|unique:kategori_ukm,nama_kategori,' . $id . ',id_kategori'
            ];

            $validator = Validator::make($request->all(), $rules);

            if ($validator->fails()) {
                return response()->json([
                    'status' => false,
                    'message' => 'Validasi gagal.',
                    'msgField' => $validator->errors()
                ]);
            }

            $kategori = KategoriUkmModel::find($id);
            if ($kategori) {
                $kategori->update($request->all());

                return response()->json([
                    'status' => true,
                    'message' => 'Data kategori UKM berhasil diperbarui'
                ]);
            } else {
                return response()->json([
                    'status' => false,
                    'message' => 'Data tidak ditemukan'
                ]);
            }
        }

        return redirect('/');
    }

    // Menampilkan konfirmasi hapus
    public function confirm_ajax(string $id)
    {
        $kategori_ukm = KategoriUkmModel::find($id);
        return view('kategori_ukm.confirm_ajax', ['kategori_ukm' => $kategori_ukm]);
    }
// Hapus data kategori UKM via AJAX
public function delete_ajax(Request $request, string $id)
{
    if ($request->ajax() || $request->wantsJson()) {
        $kategori = KategoriUkmModel::find($id);

        if ($kategori) {
            // Cek apakah kategori ini digunakan oleh UKM
            if ($kategori->ukm()->exists()) {
                return response()->json([
                    'status'  => false,
                    'message' => 'Gagal menghapus kategori. Data masih digunakan oleh UKM.'
                ]);
            }

            $kategori->delete();
            return response()->json([
                'status'  => true,
                'message' => 'Data kategori UKM berhasil dihapus'
            ]);
        } else {
            return response()->json([
                'status'  => false,
                'message' => 'Data tidak ditemukan'
            ]);
        }
    }

    return redirect('/');
}


    // Menampilkan detail kategori UKM
    public function show_ajax($id_kategori)
    {
        $kategori = KategoriUkmModel::find($id_kategori);

        if (!$kategori) {
            return response()->json(['success' => false, 'message' => 'Kategori UKM tidak ditemukan'], 404);
        }

        return view('kategori_ukm.show_ajax', compact('kategori'));
    }
}