@extends('layouts.app')

@section('title', 'Admin Report Komentar')

@section('content')
<div class="container py-4">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h3>Daftar Laporan Komentar</h3>
        <a class="btn btn-danger" href="{{ route('admin.report.blogger') }}">
        Laporan Blogger
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
                @forelse ($AdminReport as $index => $report)
                <tr>
                    <td>{{ $loop->iteration }}</td>
                    <td>{{ $report->user->name ?? 'Unknown' }}</td>
                    <td>{{ $report->alasan }}</td>
                    <td>
                        <span class="badge 
                            {{ $report->status == 'pending' ? 'bg-warning text-dark' : '' }}
                            {{ $report->status == 'diterima' ? 'bg-success' : '' }}
                            {{ $report->status == 'ditolak' ? 'bg-danger' : '' }}
                        ">
                            {{ ucfirst($report->status) }}
                        </span>
                    </td>
                    <td>{{ $report->created_at->format('d M Y H:i') }}</td>
                    <td>
                        @if ($report->status === 'pending')
                            <button class="btn btn-sm btn-danger" title="Detail Report" data-bs-toggle="modal" data-bs-target="#modalReport{{ $report->id }}">
                                <i class="bi bi-exclamation-lg"></i>
                            </button>
                        @elseif ($report->status === 'diterima')
                            <span class="text-success" title="Laporan diterima"><i class="bi bi-check-circle-fill"></i></span>
                        @elseif ($report->status === 'ditolak')
                            <span class="text-danger" title="Laporan ditolak"><i class="bi bi-x-circle-fill"></i></span>
                        @endif
                    </td>
                </tr>

                {{-- Modal untuk tiap report --}}
                <div class="modal fade" id="modalReport{{ $report->id }}" tabindex="-1" aria-labelledby="modalLabel{{ $report->id }}" aria-hidden="true">
                    <div class="modal-dialog">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h1 class="modal-title fs-5" id="modalLabel{{ $report->id }}">Detail Laporan Komentar</h1>
                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                            </div>
                            <div class="modal-body">
                                <p><strong>Nama Yang Dilaporkan:</strong></p>
                                <p>{{ $report->comment->user->name ?? '-' }}</p>

                                <hr>

                                <p><strong>Isi Komentar:</strong></p>
                                <p>{{ $report->comment->isi ?? '-'}}</p>
                            </div>
                            <div class="modal-footer">
                                {{-- Form Diterima --}}
                                <form action="{{ route('laporan.updateStatus', $report->id) }}" method="POST" class="d-inline">
                                    @csrf
                                    <input type="hidden" name="status" value="diterima">
                                    <button type="submit" class="btn btn-success" >
                                        Diterima
                                    </button>
                                </form>

                                {{-- Form Ditolak --}}
                                <form action="{{ route('laporan.updateStatus', $report->id) }}" method="POST" class="d-inline">
                                    @csrf
                                    <input type="hidden" name="status" value="ditolak">
                                    <button type="submit" class="btn btn-danger">Ditolak</button>
                                </form>
                                
                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Tutup</button>
                            </div>
                        </div>
                    </div>
                </div>
                @empty
                <tr>
                    <td colspan="6" class="text-center">Tidak ada laporan.</td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    {{-- Pagination --}}
    <div class="d-flex justify-content-center mt-4">
        {{ $AdminReport->links() }}
    </div>
</div>
@endsection
