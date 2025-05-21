@extends('layouts.app')

@section('title', 'Postingan Saya')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-3">
    <h5>Postingan Saya</h5>
    <a class="btn btn-primary" href="{{ route('bloggers.create') }}">
    Buat Postingan
    </a>
</div>

  <!-- Daftar Postingan -->
<div class="row row-cols-1 row-cols-md-4 g-4">
    @forelse ($posts as $post)
      <div class="col">
        <div class="card h-100 text-bg-transparent">
          <div class="card-header bg-transparent">
            <a href="{{ route('bloggers.edit', $post->id) }}" class="btn btn-primary me-2">Edit Postingan</a>  
            <button type="button" class="btn btn-danger" data-bs-toggle="modal" data-bs-target="#modalHapus{{ $post->id }}">
              Hapus
            </button>
          </div>
          <a href="{{ route('bloggers.show', $post->id) }}" class="card-body text-primary text-decoration-none">
            <h5 class="card-title">{{ $post->judul }}</h5>
            <p class="card-text">{{ Str::limit($post->isi_konten, 150) }}</p>
          </a>
          <div class="card-footer bg-transparent">{{ $post->updated_at }}</div>
        </div>
      </div>

      <!-- Modal Hapus Postingan -->
      <div class="modal fade" id="modalHapus{{ $post->id }}" tabindex="-1" aria-labelledby="modalHapusLabel{{ $post->id }}" aria-hidden="true">
        <div class="modal-dialog">
          <div class="modal-content">
            <div class="modal-header">
              <h1 class="modal-title fs-5" id="modalHapusLabel{{ $post->id }}">Hapus Postingan</h1>
              <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
              Yakin ingin menghapus postingan <strong>{{ $post->judul }}</strong>?
            </div>
            <div class="modal-footer">
              <form action="{{ route('bloggers.destroy', $post->id) }}" method="POST">
                @csrf
                @method('DELETE')
                <button type="submit" class="btn btn-danger">Hapus</button>
              </form>
              <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
            </div>
          </div>
        </div>
      </div>
    @empty
      <div class="d-flex justify-content-center align-items-center" style="min-height: 300px; width: 100%;">
        <div class="text-center text-muted fs-5">
          Kamu tidak memiliki postingan.
        </div>
      </div>
    @endforelse
</div>
@endsection