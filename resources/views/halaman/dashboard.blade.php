@extends('layouts.app')

@section('title', 'Dashboard')

@section('content')
@if (session('message'))
  <div id="flash-message" class="alert alert-success" role="alert">
    {{ session('message') }}
  </div>
@endif
@if (session('error'))
  <div id="flash-message" class="alert alert-danger" role="alert">
    {{ session('error') }}
  </div>
@endif
@include('kerangka.tombolbuatpostingan')
<!-- Contoh Card -->
<div class="row row-cols-1 row-cols-md-4 g-4">
    @forelse ($dashboard as $dashboardBlog)
    <div class="col">
      <div class="card h-100 text-bg-transparent">
        @if (Auth::user()->role === 'admin')
          <div class="card-header bg-transparent d-flex justify-content-center">
            <button type="button" class="btn btn-danger" data-bs-toggle="modal" data-bs-target="#modalHapus{{ $dashboardBlog->id }}">
              Hapus
            </button>
          </div>

          <div class="modal fade" id="modalHapus{{ $dashboardBlog->id }}" tabindex="-1" aria-labelledby="modalHapusLabel{{ $dashboardBlog->id }}" aria-hidden="true">
            <div class="modal-dialog">
              <div class="modal-content">
                <div class="modal-header">
                  <h1 class="modal-title fs-5" id="modalHapusLabel{{ $dashboardBlog->id }}">Hapus Postingan</h1>
                  <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                  Yakin ingin menghapus postingan <strong>{{ $dashboardBlog->judul }}</strong>?
                </div>
                <div class="modal-footer">
                  <form action="{{ route('bloggers.destroy', $dashboardBlog->id) }}" method="POST">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="btn btn-danger">Hapus</button>
                  </form>
                  <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                </div>
              </div>
            </div>
          </div>
        @endif
        <a href="{{ route('bloggers.show', ['blogger' => $dashboardBlog->id]) }}" id="{{ $dashboardBlog->id }}" class="card-body theme-aware text-decoration-none" style="text-decoration: none;">
          <div class="card-header bg-transparent">
             <img src="{{ $dashboardBlog->user->foto ? asset('storage/' . $dashboardBlog->user->foto) : ($dashboardBlog->user->gender == 'Pria' ? 'https://st3.depositphotos.com/15648834/17930/v/600/depositphotos_179308454-stock-illustration-unknown-person-silhouette-glasses-profile.jpg' : 'https://st2.depositphotos.com/2703645/5669/v/450/depositphotos_56695433-stock-illustration-female-avatar.jpg') }}" alt="author" class="rounded-circle" width="40" height="40">
              <span class="d-none d-md-inline">{{ $dashboardBlog->user->name}}</span>
          </div>
          <h5 class="card-title mt-3">{{ $dashboardBlog->judul }}</h5>
          <p class="card-text">{{ Str::limit($dashboardBlog->isi_konten, 150) }}</p>
          <div class="card-footer bg-transparent ">{{ $dashboardBlog->updated_at }}</div>
        </a>
       
      </div>
    </div>
    @empty
        <div class="d-flex justify-content-center align-items-center" style="min-height: 300px; width: 100%;">
          <div class="text-center text-muted fs-5">
            Tidak ada postingan.
          </div>
        </div>
    @endforelse

</div>
@endsection

@push('style')
<style>
  [data-bs-theme="light"] .card-body.theme-aware {
    background-color: #e5ddd5; /* warna terang */
    color: #212529; /* teks gelap */
}

[data-bs-theme="dark"] .card-body.theme-aware {
    background-color: #2b2b2b; /* warna gelap */
    color: #f8f9fa; /* teks terang */
}

</style>
@endpush