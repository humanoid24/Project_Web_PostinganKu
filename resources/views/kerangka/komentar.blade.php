<div class="collapse mt-4 p-4 bg-secondary bg-opacity-10 rounded-4" id="komentar{{ $blogger->id }}">
    <h5 class="mb-3">Komentar</h5>
    <div class="overflow-y-auto mb-2" style="max-height: 300px;">
    @forelse ($blogger->komentar as $komentar)
        <div class="d-flex mb-3 position-relative border p-3 rounded">
            <img src="{{ $komentar->user->foto ? asset('storage/' . $komentar->user->foto) : ($komentar->user->gender == 'Pria' ? 'https://st3.depositphotos.com/15648834/17930/v/600/depositphotos_179308454-stock-illustration-unknown-person-silhouette-glasses-profile.jpg' : 'https://st2.depositphotos.com/2703645/5669/v/450/depositphotos_56695433-stock-illustration-female-avatar.jpg') }}" class="rounded-circle me-3" width="40" height="40" alt="User">
            <div>
                <h5 class="mb-1 text-warning">{{ $komentar->user->name ?? 'Anonim' }}</h5>
                <p class="mb-1">{{ $komentar->updated_at->format('d M Y H:i') }}</p>
                <p class="mb-1">{{ $komentar->isi }}</p>
            </div>

            {{-- button modal komentar --}}
            <div class="position-absolute top-0 end-0 me-2 mt-2">
                {{-- Tombol Edit: hanya untuk pemilik komentar --}}
                @if (Auth::id() === $komentar->user_id)
                    <button class="btn btn-sm btn-light" data-bs-toggle="modal" title="Edit Comment" data-bs-target="#editKomentarModal-{{ $komentar->id }}">
                        <i class="bi bi-pencil"></i>
                    </button>

                    <!-- Modal Edit -->
                    <div class="modal fade" id="editKomentarModal-{{ $komentar->id }}" tabindex="-1" aria-labelledby="editKomentarLabel" aria-hidden="true">
                        <div class="modal-dialog">
                            <form action="{{ route('komentars.update', $komentar->id) }}" method="POST">
                            @csrf
                            @method('PUT')
                            <input type="hidden" name="blogger_id" value="{{ $blogger->id }}">
                            <div class="modal-content">
                                <div class="modal-header">
                                <h5 class="modal-title">Edit Komentar</h5>
                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Tutup"></button>
                                </div>
                                <div class="modal-body">
                                <textarea name="isi" class="form-control" rows="3">{{ $komentar->isi }}</textarea>
                                </div>
                                <div class="modal-footer">
                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                                <button type="submit" class="btn btn-primary">Simpan Perubahan</button>
                                </div>
                            </div>
                            </form>
                        </div>
                    </div>
                @endif
            
                {{-- Tombol Delete: untuk admin atau pemilik komentar --}}
                @if (Auth::user()->role === 'admin' || Auth::id() === $komentar->user_id)
                    <button type="button" class="btn btn-sm btn-light" data-bs-toggle="modal" title="Delete Comment" data-bs-target="#deleteKomentarModal-{{ $komentar->id }}">
                        <i class="bi bi-trash"></i>
                    </button>

                    <!-- Modal Delete -->
                    <div class="modal fade" id="deleteKomentarModal-{{ $komentar->id }}" tabindex="-1" aria-labelledby="deleteKomentarModalLabel-{{ $komentar->id }}" aria-hidden="true">
                        <div class="modal-dialog">
                            <form action="{{ route('komentars.destroy', $komentar->id) }}" method="POST">
                            @csrf
                            @method('DELETE')
                            <div class="modal-content">
                                <div class="modal-header">
                                <h5 class="modal-title">Hapus Komentar</h5>
                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Tutup"></button>
                                </div>
                                <div class="modal-body">
                                    Apakah kamu yakin ingin menghapus komentar ini?
                                    <blockquote class="blockquote mt-2 mb-0 text-muted">
                                        <small>"{{ $komentar->isi }}"</small>
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
                @endif

                @if (Auth::id() !== $komentar->user_id && Auth::user()->role !== 'admin')
                    <button class="btn btn-sm btn-light" data-bs-toggle="modal" data-bs-target="#reportKomentarModal-{{ $komentar->id }}" title="Laporkan Komentar">
                        <i class="bi bi-exclamation-lg"></i>
                    </button>
            
                    <!-- Modal Report -->
                    <div class="modal fade" id="reportKomentarModal-{{ $komentar->id }}" tabindex="-1" aria-labelledby="reportKomentarModalLabel-{{ $komentar->id }}" aria-hidden="true">
                        <div class="modal-dialog">
                            <form action="{{ route('komentars.report', $komentar->id) }}" method="POST">
                                @csrf
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h5 class="modal-title" id="reportKomentarModalLabel-{{ $komentar->id }}">Laporkan Komentar</h5>
                                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Tutup"></button>
                                    </div>
                                    <div class="modal-body">
                                        <p>Alasan laporan:</p>
                                        <select name="alasan" id="alasan" class="form-control" required>
                                            <option value="">-- Pilih Alasan --</option>
                                            <option value="spam" {{ old('alasan') == 'spam' ? 'selected' : '' }}>Spam</option>
                                            <option value="pelecehan" {{ old('alasan') == 'pelecehan' ? 'selected' : '' }}>Pelecehan</option>
                                            <option value="komentar tidak pantas" {{ old('alasan') == 'komentar tidak pantas' ? 'selected' : '' }}>Komentar Tidak Pantas</option>
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
                @endif
            </div>        
        </div>     
    @empty
        <p>Belum ada komentar.</p>
    @endforelse
    </div>

    <form class="mb-4" method="POST" action="{{ route('komentars.store') }}">
    @csrf
    <input type="hidden" name="blogger_id" value="{{ $blogger->id }}">
    <div class="d-flex align-items-start mb-3">
        <img src="{{ Auth::user()->foto ? asset('storage/' . Auth::user()->foto) : (Auth::user()->gender == 'Pria' ? 'https://st3.depositphotos.com/15648834/17930/v/600/depositphotos_179308454-stock-illustration-unknown-person-silhouette-glasses-profile.jpg' : 'https://st2.depositphotos.com/2703645/5669/v/450/depositphotos_56695433-stock-illustration-female-avatar.jpg') }}" class="rounded-circle me-3" width="40" height="40" alt="User">
        <textarea class="form-control" name="isi" rows="3" placeholder="Tulis komentar di sini..."></textarea>
    </div>
    <button type="submit" class="btn btn-primary">Post Komentar</button>
    </form>
</div>

<script>
    document.addEventListener("DOMContentLoaded", function () {
        const tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'))
        tooltipTriggerList.map(function (tooltipTriggerEl) {
            return new bootstrap.Tooltip(tooltipTriggerEl)
        })
    });
</script>
