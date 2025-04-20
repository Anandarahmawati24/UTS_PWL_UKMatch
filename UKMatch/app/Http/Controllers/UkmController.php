<?php
namespace App\Http\Controllers;

use App\Models\UkmModel;
use App\Models\KategoriUkmModel;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Auth;

class UkmController extends Controller
{
    public function index()
{
    $breadcrumb = (object)[
        'title' => 'Daftar UKM',
        'list' => ['Home', 'UKM']
    ];

    $page = (object)[
        'title' => 'Daftar UKM dalam sistem'
    ];

    $activeMenu = 'ukm';
    
    // Tambahkan ini untuk mengambil data kategori UKM
    $kategori_ukm = KategoriUkmModel::all();
    
    return view('ukm.index', compact('breadcrumb', 'page', 'activeMenu', 'kategori_ukm'));
}

    public function list(Request $request)
    {
        $ukm = UkmModel::with('kategori')->select('id_ukm', 'nama_ukm', 'id_kategori', 'email', 'alamat', 'tanggal_berdiri', 'status');

        if ($request->id_kategori) {
            $ukm->where('id_kategori', $request->id_kategori);
        }
        return DataTables::of($ukm)
        ->addIndexColumn()
        ->addColumn('nama_kategori', function ($ukm) {
            return $ukm->kategori->nama_kategori ?? '-';
        })
        ->addColumn('aksi', function ($ukm) {
            $btn = '<button onclick="modalAction(\''.url('/ukm/' . $ukm->id_ukm . '/show_ajax').'\')" class="btn btn-info btn-sm">Detail</button> ';
            $btn .= '<button onclick="modalAction(\''.url('/ukm/' . $ukm->id_ukm . '/edit_ajax').'\')" class="btn btn-warning btn-sm">Edit</button> ';
            $btn .= '<button onclick="modalAction(\''.url('/ukm/' . $ukm->id_ukm . '/delete_ajax').'\')" class="btn btn-danger btn-sm">Hapus</button>';
            return $btn;
        })
        ->rawColumns(['aksi'])
        ->make(true);    
    }

    public function create()
    {
        $breadcrumb = (object)[
            'title' => 'Tambah UKM',
            'list' => ['Home', 'UKM', 'Tambah']
        ];

        $page = (object)[
            'title' => 'Form Tambah UKM'
        ];

        $activeMenu = 'ukm';
        $kategoriList = KategoriUkmModel::all();

        return view('ukm.create', compact('breadcrumb', 'page', 'activeMenu', 'kategoriList'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'nama_ukm' => 'required|string|max:255',
            'id_kategori' => 'required|exists:kategori_ukm,id_kategori',
            'email' => 'required|email',
            'alamat' => 'required|string',
            'deskripsi' => 'required|string',
            'tanggal_berdiri' => 'required|date',
            'status' => 'required|in:aktif,nonaktif'
        ]);

        UkmModel::create($request->all());

        return redirect('/ukm')->with('success', 'Data UKM berhasil disimpan');
    }

    public function show(string $id)
    {
        $ukm = UkmModel::with('kategori')->findOrFail($id);

        $breadcrumb = (object)[
            'title' => 'Detail UKM',
            'list' => ['Home', 'UKM', 'Detail']
        ];

        $page = (object)[
            'title' => 'Detail UKM'
        ];

        $activeMenu = 'ukm';

        return view('ukm.show', compact('breadcrumb', 'page', 'activeMenu', 'ukm'));
    }

    public function edit(string $id)
    {
        $ukm = UkmModel::findOrFail($id);

        $breadcrumb = (object)[
            'title' => 'Edit UKM',
            'list' => ['Home', 'UKM', 'Edit']
        ];

        $page = (object)[
            'title' => 'Edit UKM'
        ];

        $activeMenu = 'ukm';
        $kategoriList = KategoriUkmModel::all();

        return view('ukm.edit', compact('breadcrumb', 'page', 'activeMenu', 'ukm', 'kategoriList'));
    }

    public function update(Request $request, string $id)
    {
        $request->validate([
            'nama_ukm' => 'required|string|max:255',
            'id_kategori' => 'required|exists:kategori_ukm,id_kategori',
            'email' => 'required|email',
            'alamat' => 'required|string',
            'deskripsi' => 'required|string',
            'tanggal_berdiri' => 'required|date',
            'status' => 'required|in:aktif,nonaktif'
        ]);

        $ukm = UkmModel::findOrFail($id);
        $ukm->update($request->all());

        return redirect('/ukm')->with('success', 'Data UKM berhasil diperbarui');
    }

    public function destroy(string $id)
    {
        try {
            UkmModel::destroy($id);
            return redirect('/ukm')->with('success', 'Data UKM berhasil dihapus');
        } catch (\Illuminate\Database\QueryException $e) {
            return redirect('/ukm')->with('error', 'Gagal menghapus UKM. Data masih terkait dengan tabel lain.');
        }
    }

    // Menampilkan form tambah UKM
    public function create_ajax() {
        // Mengambil data UKM (misalnya, jika Anda membutuhkan informasi UKM untuk ditampilkan)
        $ukm = UkmModel::select('id_ukm', 'nama_ukm', 'id_kategori', 'email', 'alamat', 'tanggal_berdiri', 'status')->get();
    
        // Mengambil data kategori untuk dropdown
        $kategori_ukm = KategoriUkmModel::all(); // Pastikan nama model ini sesuai dengan model kategori Anda
    
        // Mengirimkan data UKM dan kategori ke view
        return view('ukm.create_ajax', compact('ukm', 'kategori_ukm'));
    }    
// Menyimpan data UKM baru via AJAX
public function store_ajax(Request $request) {
    if ($request->ajax() || $request->wantsJson()) {
        // Validasi data
        $rules = [
            'nama_ukm' => 'required|string|max:255',
            'id_kategori' => 'required|exists:kategori_ukm,id_kategori',
            'email' => 'required|email',
            'alamat' => 'required|string',
            'deskripsi' => 'required|string',
            'tanggal_berdiri' => 'required|date',
            'status' => 'required|in:aktif,nonaktif',
        ];

        $validator = Validator::make($request->all(), $rules);

        if ($validator->fails()) {
            return response()->json([
                'status' => false,
                'message' => 'Validasi Gagal',
                'msgField' => $validator->errors(),
            ]);
        }

        // Menyimpan data UKM baru
        UkmModel::create($request->all());

        return response()->json([
            'status' => true,
            'message' => 'Data UKM berhasil disimpan',
        ]);
    }

    return redirect('/');
}

// Menampilkan form edit UKM dengan data kategori
public function edit_ajax(string $id_ukm)
{
    // Ambil data UKM berdasarkan ID
    $ukm = UkmModel::find($id_ukm);

    // Cek jika data UKM tidak ditemukan
    if (!$ukm) {
        return response()->json([
            'status' => false,
            'message' => 'UKM tidak ditemukan',
        ]);
    }

    // Ambil semua data kategori UKM
    $kategori_ukm = KategoriUkmModel::all();

    // Kirim data UKM dan kategori UKM ke view
    return view('ukm.edit_ajax', [
        'ukm' => $ukm,
        'kategori_ukm' => $kategori_ukm
    ]);
}


// Proses update UKM via AJAX
public function update_ajax(Request $request, string $id) {
    if ($request->ajax() || $request->wantsJson()) {
        // Validasi data
        $rules = [
            'nama_ukm' => 'required|string|max:255',
            'id_kategori' => 'required|exists:kategori_ukm,id_kategori',
            'email' => 'required|email',
            'alamat' => 'required|string',
            'deskripsi' => 'required|string',
            'tanggal_berdiri' => 'required|date',
            'status' => 'required|in:aktif,nonaktif',
        ];

        $validator = Validator::make($request->all(), $rules);

        if ($validator->fails()) {
            return response()->json([
                'status' => false,
                'message' => 'Validasi gagal.',
                'msgField' => $validator->errors()
            ]);
        }

        // Cari UKM berdasarkan ID
        $ukm = UkmModel::find($id);
        if ($ukm) {
            // Update data UKM
            $ukm->update($request->all());

            return response()->json([
                'status' => true,
                'message' => 'Data UKM berhasil diperbarui'
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
public function confirm_ajax(string $id) {
    $ukm = UkmModel::find($id);

    return view('ukm.confirm_ajax', ['ukm' => $ukm]);
}

// Hapus data UKM via AJAX
public function delete_ajax(Request $request, string $id) {
    if ($request->ajax() || $request->wantsJson()) {
        $ukm = UkmModel::find($id);
        if ($ukm) {
            $ukm->delete();
            return response()->json([
                'status' => true,
                'message' => 'Data UKM berhasil dihapus'
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

// Menampilkan detail UKM via AJAX
public function show_ajax($id) {
    $ukm = UkmModel::find($id);

    // Pastikan data ditemukan
    if (!$ukm) {
        return response()->json(['success' => false, 'message' => 'UKM tidak ditemukan'], 404);
    }
    // Kembalikan data UKM dalam bentuk view HTML
    return view('ukm.show_ajax', compact('ukm'));
}

public function indexMahasiswa()
{
    $breadcrumb = (object)[
        'title' => 'Daftar UKM',
        'list' => ['Home', 'UKM']
    ];

    $page = (object)[
        'title' => 'Daftar UKM untuk Mahasiswa'
    ];

    $activeMenu = 'ukm-mahasiswa'; // Menandai menu aktif untuk mahasiswa
    
    // Ambil data kategori UKM
    $kategori_ukm = KategoriUkmModel::all();

    // Ambil data UKM yang akan ditampilkan untuk mahasiswa
    $ukm = UkmModel::all();

    return view('ukm.indexMahasiswa', compact('breadcrumb', 'page', 'activeMenu', 'kategori_ukm', 'ukm'));
}

public function listUkmMahasiswa(Request $request)
{
    $ukm = UkmModel::with('kategori')->select('id_ukm', 'nama_ukm', 'id_kategori', 'email', 'alamat', 'tanggal_berdiri', 'status');

        if ($request->id_kategori) {
            $ukm->where('id_kategori', $request->id_kategori);
        }
        return DataTables::of($ukm)
        ->addIndexColumn()
        ->addColumn('nama_kategori', function ($ukm) {
            return $ukm->kategori->nama_kategori ?? '-';
        })
        ->addColumn('aksi', function ($ukm) {
            $btn = '<button onclick="modalAction(\''.url('/ukm/' . $ukm->id_ukm . '/show_ajax').'\')" class="btn btn-info btn-sm">Detail</button> ';
            return $btn;
        })
        ->rawColumns(['aksi'])
        ->make(true);
}

}