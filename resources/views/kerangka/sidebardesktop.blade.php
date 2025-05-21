<!-- Sidebar (Desktop) -->
      <div class="col-lg-2 d-none d-lg-block border-end">
        <div class="list-group list-group-flush">
          <a href="{{ route('bloggers.index') }}" class="list-group-item list-group-item-action">🏠 Home</a>
          <a href="{{ route('user.posts', auth()->user()->id) }}" class="list-group-item list-group-item-action">📝 Post saya</a>
          <a href="{{ route('chatting'), auth()->user()->id }}" class="list-group-item list-group-item-action">💬 Chat</a>
          <a href="{{ route('saved.show') }}" class="list-group-item list-group-item-action"><i class="ms-1 me-2 fa fa-bookmark"></i>Postingan di simpan</a>
          <a href="{{ route('editprofile') }}" class="list-group-item list-group-item-action">⚙️ Settings</a>
          @if (Auth::user()->role === 'admin')
            <a href="{{ route('admin.report') }}" class="list-group-item list-group-item-action"><i class="ms-1 me-2 bi bi-exclamation-square-fill"></i>Laporan</a>
          @endif
        </div>
      </div>