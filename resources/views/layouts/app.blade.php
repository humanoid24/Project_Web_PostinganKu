<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
  <meta http-equiv="X-UA-Compatible" content="ie=edge" />
  <title>@yield('title')</title>

  <!-- Bootstrap CSS -->
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" />
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css" />
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">

  <!-- Auto Set Theme (Light/Dark) -->
  <script>
    const savedTheme = localStorage.getItem('theme'); // Ambil dari localStorage
    const prefersDark = window.matchMedia("(prefers-color-scheme: dark)").matches;

    const currentTheme = savedTheme ? savedTheme : (prefersDark ? 'dark' : 'light');
    document.documentElement.setAttribute('data-bs-theme', currentTheme);
</script>

    @stack('style')
  @livewireStyles
</head>
<body>
    <!-- Navbar -->
  @include('kerangka.navbar')

  <!-- Main Layout -->
  <div class="container-fluid">
    <div class="row">
      @include('kerangka.sidebardesktop')
      <!-- Content Area -->
      <div class="col-lg-10 p-4">
        @yield('content')
      </div>
    </div>
  </div>

  <!-- Modal Buat Thread -->
  <!-- Bootstrap Bundle JS -->
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>

  @livewireScripts
  @stack('scripts')

</body>
</html>
