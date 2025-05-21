<nav class="navbar navbar-expand-lg bg-body-tertiary shadow-sm px-3">
  <div class="container-fluid">
      <!-- Sidebar toggle (mobile) -->
      <button class="btn btn-outline-secondary me-2 d-lg-none" type="button" data-bs-toggle="offcanvas" data-bs-target="#sidebar" aria-controls="sidebar">
          ☰
      </button>

      <!-- Brand -->
      <a class="navbar-brand" href="#">PostinganKu</a>

      <!-- Right navbar -->
      <div class="ms-auto d-flex align-items-center gap-3">
          <!-- Notifikasi Icon -->
          @livewire('notifications-dropdown')

          <!-- Dark mode toggle -->
          <button class="btn btn-sm btn-outline-primary" id="toggleTheme">🌓</button>

          <!-- User dropdown -->
          <div class="dropdown">
              <a href="#" class="d-flex align-items-center text-decoration-none dropdown-toggle" data-bs-toggle="dropdown" aria-expanded="false">
                  <img src="{{ Auth::user()->foto ? asset('storage/' . Auth::user()->foto) : (Auth::user()->gender == 'Pria' ? 'https://st3.depositphotos.com/15648834/17930/v/600/depositphotos_179308454-stock-illustration-unknown-person-silhouette-glasses-profile.jpg' : 'https://st2.depositphotos.com/2703645/5669/v/450/depositphotos_56695433-stock-illustration-female-avatar.jpg') }}" alt="Profile" class="rounded-circle me-2 border border-2 bg-light" width="32" height="32">
                  <span class="d-none d-md-inline">{{ Auth::user()->name }}</span>
              </a>
              <ul class="dropdown-menu dropdown-menu-end">
                  <li><a class="dropdown-item" href="{{ route('actionLogout') }}">Logout</a></li>
              </ul>
          </div>
      </div>
  </div>
</nav>

<script>
  document.getElementById('toggleTheme').addEventListener('click', function () {
      const currentTheme = document.documentElement.getAttribute('data-bs-theme');
      const newTheme = currentTheme === 'dark' ? 'light' : 'dark';

      document.documentElement.setAttribute('data-bs-theme', newTheme);
      localStorage.setItem('theme', newTheme); // Simpan pilihan ke localStorage
  });
</script>
