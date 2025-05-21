@extends('layouts.app')

@section('title', 'Dashboard')

@section('content')
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
        <a href="{{ route('bloggers.show', ['blogger' => $dashboardBlog->id]) }}" id="{{ $dashboardBlog->id }}" class="card-body text-primary text-decoration-none">
          <h5 class="card-title">{{ $dashboardBlog->judul }}</h5>
          <p class="card-text">{{ Str::limit($dashboardBlog->isi_konten, 150) }}</p>
        </a>
        <div class="card-footer bg-transparent border-success">{{ $dashboardBlog->updated_at }}</div>
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