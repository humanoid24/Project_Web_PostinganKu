<div>
    <div class="card h-100">
        <div class="card-header bg-primary text-white">
            Kontak
        </div>
        <div class="list-group list-group-flush overflow-auto" style="height: 100%;">
            @forelse ($users as $user)
                <button 
                    wire:click="selectContact('{{ $user->id }}')"
                    class="list-group-item list-group-item-action d-flex align-items-center">
                    <img style="width: 40px; height: 40px; object-fit: cover;" src="{{ $user->foto ? asset('storage/' . $user->foto) : ($user->gender == 'Pria' ? 'https://st3.depositphotos.com/15648834/17930/v/600/depositphotos_179308454-stock-illustration-unknown-person-silhouette-glasses-profile.jpg' : 'https://st2.depositphotos.com/2703645/5669/v/450/depositphotos_56695433-stock-illustration-female-avatar.jpg') }}" class="rounded-circle me-3" alt="Avatar">
                    <div>
                        <div class="fw-bold">{{ $user->name }}</div>
                        <small class="text-muted">Klik untuk lihat chat</small>
                    </div>
                    
                    @if(isset($unreadMessagesCount[$user->id]) && $unreadMessagesCount[$user->id] > 0)
                        <span class="badge bg-danger rounded-pill ms-auto">{{ $unreadMessagesCount[$user->id] }}</span>
                    @endif
                </button>      
            @empty
                <div class="list-group-item text-muted">Belum ada kontak lain</div>
            @endforelse
            @if ($users->total() > 10)
                <div class="mt-2 px-3" style="font-size: 0.8rem;">
                    {{ $users->links('pagination::bootstrap-5') }}
                </div>
             @endif
                  
        </div>
    </div>
</div>
