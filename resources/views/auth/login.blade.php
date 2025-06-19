<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta http-equiv="X-UA-Compatible" content="ie=edge">
  <title>Login Page</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css" rel="stylesheet">
</head>
<body class="bg-light">

<section class="vh-100 d-flex align-items-center justify-content-center" style="background: blue">
  <div class="container">
    <div class="row justify-content-center">
      <div class="col-md-8 col-lg-5">
        <div class="card shadow-lg border-0 rounded-4">
          <div class="card-body p-5 text-center">

            <div class="mb-4">
              <i class="bi bi-person-circle" style="font-size: 3rem; color: #2575fc;"></i>
              <h2 class="fw-bold mt-2 text-dark">Login</h2>
              <p class="text-muted">Masukkan username dan password kamu</p>
            </div>

            @if(session('message'))
              <div class="alert alert-success">{{ session('message') }}</div>
            @endif
            @if(session('error'))
              <div class="alert alert-danger"><b>Oops!</b> {{ session('error') }}</div>
            @endif

            <form action="{{ route('actionLogin') }}" method="post">
              @csrf
              <div class="form-floating mb-3 text-start">
                <input type="text" name="name" id="typeEmailX" class="form-control" placeholder="Username">
                <label for="typeEmailX">Username</label>
              </div>

              <div class="form-floating mb-4 text-start">
                <input type="password" name="password" id="typePasswordX" class="form-control" placeholder="Password">
                <label for="typePasswordX">Password</label>
              </div>

              <button class="btn btn-primary w-100 btn-lg mb-3" type="submit">
                <i class="bi bi-box-arrow-in-right me-1"></i> Login
              </button>
            </form>

            <p class="mb-0">Belum punya akun? 
              <a href="{{ route('register') }}" class="fw-semibold text-decoration-none">Daftar</a>
            </p>

          </div>
        </div>
      </div>
    </div>
  </div>
</section>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>

</body>
</html>