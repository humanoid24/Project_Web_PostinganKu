<div class="d-flex align-items-center gap-3 mb-4">
    <img src="{{ $blogger->user->foto ? asset('storage/' . $blogger->user->foto) : ($blogger->user->gender == 'Pria' ? 'https://st3.depositphotos.com/15648834/17930/v/600/depositphotos_179308454-stock-illustration-unknown-person-silhouette-glasses-profile.jpg' : 'https://st2.depositphotos.com/2703645/5669/v/450/depositphotos_56695433-stock-illustration-female-avatar.jpg') }}" alt="author" class="rounded-circle" width="40" height="40">

    <div>
        <div class="fw-semibold">{{ $blogger->user->name }}</div>
        <small class="text-muted">{{ $blogger->updated_at }}</small>
    </div>

    @if (Auth::user()->role !== 'admin' && Auth::id() !== $blogger->user_id)
        <div class="ms-auto">
            <button class="btn btn-sm btn-danger" title="Detail Report" data-bs-toggle="modal" data-bs-target="#reportBloggerModal-{{ $blogger->id }}">
                <i class="bi bi-exclamation-lg"></i>
            </button>

            <div class="modal fade" id="reportBloggerModal-{{ $blogger->id }}" tabindex="-1" aria-labelledby="reportBloggerModalLabel-{{ $blogger->id }}" aria-hidden="true">
                <div class="modal-dialog">
                    <form action="{{ route('bloggers.report', $blogger->id) }}" method="POST">
                        @csrf
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title" id="reportBloggerModalLabel-{{ $blogger->id }}">Laporkan Komentar</h5>
                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Tutup"></button>
                            </div>
                            <div class="modal-body">
                                <p>Alasan laporan:</p>
                                <select name="alasan" id="alasan" class="form-control" required>
                                    <option value="">-- Pilih Alasan --</option>
                                    <option value="spam" {{ old('alasan') == 'spam' ? 'selected' : '' }}>Spam</option>
                                    <option value="pelecehan" {{ old('alasan') == 'pelecehan' ? 'selected' : '' }}>Pelecehan</option>
                                    <option value="Postingan tidak pantas" {{ old('alasan') == 'Postingan tidak pantas' ? 'selected' : '' }}>Postingan Tidak Pantas</option>
                                    <option value="lainnya" {{ old('alasan') == 'lainnya' ? 'selected' : '' }}>Lainnya</option>
                                </select>
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                                <button type="submit" class="btn btn-danger">Laporkan</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>   
        </div>
    @elseif (Auth::user()->role === 'admin')
        <div class="ms-auto">
            <button class="btn btn-sm btn-light" title="Hapus Postingan" data-bs-toggle="modal" data-bs-target="#deleteBloggerModal-{{ $blogger->id }}">
                <i class="bi bi-trash"></i>
            </button>
        
            <div class="modal fade" id="deleteBloggerModal-{{ $blogger->id }}" tabindex="-1" aria-labelledby="deleteBloggerModalLabel-{{ $blogger->id }}" aria-hidden="true">
                <div class="modal-dialog">
                    <form action="{{ route('bloggers.destroy', $blogger->id) }}" method="POST">
                        @csrf
                        @method('DELETE')
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title" id="deleteBloggerModalLabel-{{ $blogger->id }}">Hapus Komentar</h5>
                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Tutup"></button>
                            </div>
                            <div class="modal-body">
                                Apakah kamu yakin ingin menghapus blogger ini?
                                <blockquote class="blockquote mt-2 mb-0 text-muted">
                                    <small>{{ Str::limit($blogger->isi_konten, 150) }}</small>
                                </blockquote>
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                                <button type="submit" class="btn btn-danger">Hapus</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    @endif

    
</div>

<div class="d-flex justify-content-between align-items-center mb-3">
    <h2 class="mb-0">{{ $blogger->judul }}</h2>
</div>

@if ($blogger->media)
    @php
        $ext = pathinfo($blogger->media, PATHINFO_EXTENSION);
    @endphp
    @if (in_array($ext, ['jpg', 'jpeg', 'png']))
        <div class="w-100 mb-4 d-flex justify-content-center mt-4">
            <img src="{{ asset('storage/' . $blogger->media) }}" id="selectedImage" class="img-fluid" style="max-height: 350px; object-fit: contain;" alt="UX Header" />
        </div>
    @elseif (in_array($ext, ['mp4', 'mov', 'avi', 'wmv']))
        <div class="w-100 mb-4 d-flex justify-content-center mt-4">
            <video width="100%" height="auto" controls preload="auto" controlsList="nodownload">
                <source src="{{ asset('storage/' . $blogger->media) }}" type="video/{{ $ext }}">
                Your browser does not support the video tag.
            </video>
        </div>
    @endif
@endif

<div class="mb-4 mt-4">
    <p>{!! nl2br(e($blogger->isi_konten)) !!}</p>
</div>
