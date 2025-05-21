@extends('layouts.app')

@section('title', 'Postingan Tersimpan')

@section('content')
<div class="d-flex justify-content-between align-items-center">
  <h5>Postingan Tersimpan</h5>
  <a class="btn btn-primary" href="{{ route('bloggers.create') }}">
  Buat Postingan
  </a>
</div>
<!-- Contoh Card -->
<div class="row row-cols-1 row-cols-md-4 g-4">
    @forelse ($savedPosts as $saved)
    <div class="col">
      <div class="card h-100 text-bg-transparent">
        <a href="{{ route('bloggers.show', $saved->blogger->id) }}" id="{{ $saved->id }}" class="card-body text-primary text-decoration-none">
          <h5 class="card-title">{{ $saved->blogger->judul }}</h5>
          <p class="card-text">{{ Str::limit($saved->blogger->isi_konten, 150) }}</p>
        </a>
        <div class="card-footer bg-transparent border-success">{{ $saved->blogger->updated_at->format('d M Y') }}</div>
      </div>
    </div>
    @empty
        <div class="d-flex justify-content-center align-items-center" style="min-height: 300px; width: 100%;">
          <div class="text-center text-muted fs-5">
            Tidak ada postingan yang disimpan.
          </div>
        </div>
    @endforelse

</div>
@endsection