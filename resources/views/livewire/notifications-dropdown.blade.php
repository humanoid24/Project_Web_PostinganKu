<div>
    <div class="dropdown">
        <a href="#" class="text-decoration-none position-relative" id="notificationsDropdown" data-bs-toggle="dropdown" aria-expanded="false">
            <i class="bi bi-bell fs-5 text-primary"></i>

            @if($unreadCount > 0)
                <span class="position-absolute top-0 start-100 translate-middle badge rounded-pill bg-danger">
                    {{ $unreadCount }}
                    <span class="visually-hidden">unread messages</span>
                </span>
            @endif
        </a>

        <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="notificationsDropdown" style="max-height: 250px; overflow-y: auto;">
            @forelse($notifications as $notif)
                <li>
                    <a href="#" wire:click.prevent="markAsRead({{ $notif->id }}, '{{ $notif instanceof App\Models\LaporanKomentar ? 'komentar' : 'blogger' }}')" class="dropdown-item {{ $notif->is_read ? '' : 'fw-bold' }}">
                        <strong>Admin</strong> menghapus 
                        {{ $notif instanceof App\Models\LaporanKomentar ? 'komentar Anda' : 'blog Anda' }} karena: 
                        <em>{{ $notif->alasan }}</em>
                        <small class="text-muted d-block">{{ $notif->updated_at->diffForHumans() }}</small>
                    </a>
                </li>
            @empty
                <li><span class="dropdown-item text-muted">Tidak ada notifikasi baru</span></li>
            @endforelse
        </ul>
    </div>

    <!-- Modal -->
    <!-- Modal -->
<div class="modal fade @if($showModal) show d-block @endif" tabindex="-1" style="@if($showModal) display: block; @else display: none; @endif" role="dialog" aria-modal="true">
    <div class="modal-dialog">
        <div class="modal-content">
            @if($selectedNotif)
                <div class="modal-header">
                    <h5 class="modal-title">Alasan Direport</h5>
                    <button type="button" class="btn-close" wire:click="closeModal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <p><strong>Alasan:</strong> {{ $selectedNotif->alasan }}</p>
                </div>
                <div class="modal-footer">
                    <button class="btn btn-danger" wire:click="removeNotification({{ $selectedNotif->id }})">Hapus</button>
                    <button class="btn btn-secondary" wire:click="closeModal">Tutup</button>
                </div>
            @endif
        </div>
    </div>
</div>
@if($showModal)
    <div class="modal-backdrop fade show"></div>
@endif

</div>
