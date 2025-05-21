<div>
    <div class="h-100 d-flex flex-column">
        @if($user)
            <div class="card-header bg-success text-white d-flex align-items-center">
                <img style="width: 40px; height: 40px; object-fit: cover;" src="{{ $user->foto ? asset('storage/' . $user->foto) : ($user->gender == 'Pria' ? 'https://st3.depositphotos.com/15648834/17930/v/600/depositphotos_179308454-stock-illustration-unknown-person-silhouette-glasses-profile.jpg' : 'https://st2.depositphotos.com/2703645/5669/v/450/depositphotos_56695433-stock-illustration-female-avatar.jpg') }}" class="rounded-circle me-2 border bg-light" alt="Avatar">
                <div>
                    <div class="fw-bold">{{ $user->name }}</div>
                    <small></small>
                </div>
            </div>

            <div id="chat-body" class="card-body overflow-auto" style="background-color: #e5ddd5; height: 70vh;">
                @foreach($messages as $msg)
                    @if($msg['from_user_id'] == auth()->id())
                        <div class="d-flex justify-content-end mb-3">
                            <div class="text-end">
                                <div class="bg-success text-dark p-2 rounded mb-1">{{ $msg['message'] }}</div>
                                <small class="text-dark">{{ \Carbon\Carbon::parse($msg['created_at'])->setTimezone('Asia/Jakarta')->format('H:i') }}</small>
                            </div>
                        </div>
                    @else
                        <div class="d-flex mb-3">
                            <div>
                                <div class="bg-white p-2 rounded mb-1 text-dark">{{ $msg['message'] }}</div>
                                <small class="text-dark">{{ \Carbon\Carbon::parse($msg['created_at'])->setTimezone('Asia/Jakarta')->format('H:i') }}</small>
                            </div>
                        </div>
                    @endif
                @endforeach
            </div>

            <div class="card-footer bg-light">
                <form wire:submit.prevent="sendMessage">
                    <div class="input-group">
                        <input type="text" wire:model.defer="message" class="form-control" placeholder="Ketik pesan...">
                        <button class="btn btn-success" type="submit">Kirim</button>
                    </div>
                </form>
            </div>
        @else
            <div class="card-body d-flex justify-content-center align-items-center text-muted" style="height: 100%;">
                Pilih kontak untuk mulai chat
            </div>
        @endif
    </div>
</div>