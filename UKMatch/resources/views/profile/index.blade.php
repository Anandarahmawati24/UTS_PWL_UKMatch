@extends('layouts.template')
@section('title', 'Profil Pengguna')
@section('content')
<div class="container-fluid">
    <div class="card shadow-sm">
        <div class="card-header bg-primary text-white">
            <h5 class="mb-0">Profil Saya</h5>
        </div>
        <div class="card-body">
            <p><strong>Nama:</strong> {{ $user->nama }}</p>
            <p><strong>Username:</strong> {{ $user->username }}</p>
            <p><strong>Role:</strong>
                @if ($user->level)
                    {{ $user->level->level_nama }}
                @else
                    Tidak ada level
                @endif
            </p>
        </div>
        <div class="card-footer d-flex justify-content-start">
            <a href="{{ url('/welcome') }}" class="btn btn-secondary me-3"><i class="fas fa-arrow-left"></i> Kembali</a>
            <a href="{{ url('/logout') }}" class="btn btn-danger"><i class="fas fa-sign-out-alt"></i> Logout</a>
        </div>
    </div>
</div>
@endsection