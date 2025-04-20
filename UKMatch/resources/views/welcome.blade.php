@extends('layouts.template')
@section('title', 'Dashboard')
@section('content')
<div class="container-fluid">
     <!-- Header Selamat Datang -->
    <div class="row mb-4">
        <div class="col-12">
            <div class="p-4 rounded shadow-sm" style="background: linear-gradient(135deg, #03459d, #ffd704); color: white;">
                <h2 class="mb-0">Selamat Datang di <strong>UKMatch</strong></h2>
                <p class="mb-0">Sistem Informasi Manajemen Unit Kegiatan Mahasiswa</p>
            </div>
        </div>
    </div>

    <!-- Fitur Aplikasi -->
    <div class="row">
        <div class="col-md-4 mb-3">
            <div class="card shadow border-0 bg-primary text-white h-100">
                <div class="card-body">
                    <h5 class="card-title"><i class="fas fa-users"></i> Manajemen UKM</h5>
                    <p class="card-text">Kelola data UKM mulai dari nama, deskripsi, email, hingga status dan tanggal berdirinya UKM.</p>
                </div>
            </div>
        </div>

        <div class="col-md-4 mb-3">
            <div class="card shadow border-0 bg-warning text-white h-100">
                <div class="card-body">
                    <h5 class="card-title"><i class="fas fa-tags"></i> Kategori UKM</h5>
                    <p class="card-text">Mengelompokkan UKM berdasarkan kategori seperti Olahraga, Seni, Teknologi, dan lainnya.</p>
                </div>
            </div>
        </div>

        <div class="col-md-4 mb-3">
            <div class="card shadow border-0 bg-info text-white h-100">
                <div class="card-body">
                    <h5 class="card-title"><i class="fas fa-user-cog"></i> Manajemen User</h5>
                    <p class="card-text">Admin mengelola user dengan role dan hak akses berbeda sesuai peran di sistem.</p>
                </div>
            </div>
        </div>

        <div class="col-md-4 mb-3">
            <div class="card shadow border-0 bg-secondary text-white h-100">
                <div class="card-body">
                    <h5 class="card-title"><i class="fas fa-layer-group"></i> Level Pengguna</h5>
                    <p class="card-text">Pengaturan level pengguna untuk Admin dan Mahasiswa</p>
                </div>
            </div>
        </div>

        <div class="col-md-4 mb-3">
            <div class="card shadow border-0 bg-danger text-white h-100">
                <div class="card-body">
                    <h5 class="card-title"><i class="fas fa-info-circle"></i> Tentang Aplikasi</h5>
                    <p class="card-text">UKMatch dikembangkan untuk mendukung kegiatan organisasi mahasiswa berbasis digital.</p>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection