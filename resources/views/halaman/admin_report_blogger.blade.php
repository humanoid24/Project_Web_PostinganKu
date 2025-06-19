@extends('layouts.app')

@section('title', 'Admin Report Blogger')

@section('content')
<div class="container py-4">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h3>Daftar Laporan Daftar Laporan Blogger</h3>
        <a class="btn btn-danger" href="{{ route('admin.report') }}">
        Laporan Komentar
        </a>
    </div>

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

    <div class="table-responsive">
        <table class="table table-bordered table-striped align-middle">
            <thead class="table-dark">
                <tr>
                    <th>No</th>
                    <th>Nama Pelapor</th>
                    <th>Alasan</th>
                    <th>Status</th>
                    <th>Dilaporkan Pada</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
                {{-- Contoh data statis, ganti dengan perulangan nanti --}}
                @foreach ($reportsblogger as $reports)
                <tr>
                    <td>{{ $loop->iteration }}</td>
                    <td>{{ $reports->user->name }}</td>
                    <td>{{ $reports->alasan }}</td>
                    <td>
                        <span class="badge 
                            {{ $reports->status == 'pending' ? 'bg-warning text-dark' : '' }}
                            {{ $reports->status == 'diterima' ? 'bg-success' : '' }}
                            {{ $reports->status == 'ditolak' ? 'bg-danger' : '' }}">
                            {{ ucfirst($reports->status) }}
                        </span>
                    </td>
                    <td>{{ $reports->updated_at->format('d M Y H:i') }}</td>
                    <td>
                        @if ($reports->status === 'pending')
                            <button class="btn btn-sm btn-danger" title="Detail Report" data-bs-toggle="modal" data-bs-target="#modalReport{{ $reports->id }}">
                                <i class="bi bi-exclamation-lg"></i>
                            </button>
                        @elseif ($reports->status === 'diterima')
                            <span class="text-success" title="Laporan diterima"><i class="bi bi-check-circle-fill"></i></span>
                        @elseif ($reports->status === 'ditolak')
                            <span class="text-danger" title="Laporan ditolak"><i class="bi bi-x-circle-fill"></i></span>
                        @endif
                    </td>
                </tr>
                <div class="modal fade" id="modalReport{{ $reports->id }}" tabindex="-1" aria-labelledby="modalLabel" aria-hidden="true">
                    <div class="modal-dialog">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h1 class="modal-title fs-5" id="modalLabel{{ $reports->id }}">Detail Laporan Komentar</h1>
                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                            </div>
                            <div class="modal-body">
                                @if ($reports->blogger && $reports->blogger->user)
                                    <p><strong>Nama Yang Dilaporkan:</strong></p>
                                    <p>{{ $reports->blogger->user->name ?? '-' }}</p>
                            
                                    <hr>
                        
                                    <p><strong>Isi Postingan:</strong></p>
                                    <p>{{ Str::limit($reports->blogger->isi_konten, 150) }}
                                        <a href="{{ route('bloggers.show', $reports->blogger->id) }}" id="{{ $reports->blogger->id }}">Lihat selengkapnya</a>
                                    </p>
                                @else
                                    <p><em>Postingan telah dihapus.</em></p>
                                @endif

                            </div>
                            <div class="modal-footer">
                                {{-- Form Diterima --}}
                                <form action="{{ route('laporan.updateStatus.blogger', $reports->id) }}" method="POST" class="d-inline">
                                    @csrf
                                    <input type="hidden" name="status" value="diterima">
                                    <button type="submit" class="btn btn-success" >
                                        Diterima
                                    </button>
                                </form>

                                {{-- Form Ditolak --}}
                                <form action="{{ route('laporan.updateStatus.blogger', $reports->id) }}" method="POST" class="d-inline">
                                    @csrf
                                    <input type="hidden" name="status" value="ditolak">
                                    <button type="submit" class="btn btn-danger">Ditolak</button>
                                </form>
                                
                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Tutup</button>
                            </div>
                        </div>
                    </div>
                </div>
                    
                @endforeach
                {{-- Akhiri dengan kondisi @forelse nanti jika sudah dinamis --}}
            </tbody>
        </table>
    </div>
</div>
@endsection
