<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ProfileController extends Controller
{
    public function index()
    {
        $user = Auth::user();
        $namaLevel = $user->level ? $user->level->level_nama : 'Tidak ada level'; // Pastikan ada pengecekan jika level null
        return view('profile.index', [
            'user' => $user,
            'activeMenu' => 'profile',
            'breadcrumb' => (object)[
                'title' => 'Profil Saya',
                'menu' => 'Profile',
                'submenu' => 'Profil Saya',
                'list' => ['Profile', 'Profil Saya'] // tambahkan ini
            ]
        ]);
    }
}