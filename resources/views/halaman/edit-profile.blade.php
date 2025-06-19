@extends('layouts.app')

@section('title', 'Edit Profile')

@section('content')
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
<div class="container rounded mt-5 mb-5">
    {{-- <div class="row"> --}}
    <form class="row" action="{{ route('profile.update', Auth::user()) }}" method="POST" enctype="multipart/form-data">
        @csrf
        @method('PUT')
        <div class="col-md-3 border-right">
            <div class="d-flex flex-column align-items-center text-center p-3 py-5">
                <!-- Foto Profil -->
                <img id="selectedAvatar" class="rounded-circle mt-5" style="width: 200px; height: 200px; object-fit: cover;" 
                     src="{{ Auth::user()->foto ? asset('storage/' . Auth::user()->foto) : (Auth::user()->gender == 'Pria' ? 'https://st3.depositphotos.com/15648834/17930/v/600/depositphotos_179308454-stock-illustration-unknown-person-silhouette-glasses-profile.jpg' : 'https://st2.depositphotos.com/2703645/5669/v/450/depositphotos_56695433-stock-illustration-female-avatar.jpg') }}">

                <span class="font-weight-bold">
                    <label for="fotoprofil" class="btn btn-primary mt-3">Pilih Foto Profil</label>
                    <input type="file" name="foto" accept=".jpg,.jpeg,.png,.mp4,.webm" class="form-control d-none" id="fotoprofil" onchange="displaySelectedImage(event, 'selectedAvatar')">
                </span>
            </div>
        </div>

        <div class="col-md-5 border-right">
                <div class="p-3 py-5">
                    <div class="d-flex justify-content-between align-items-center mb-3">
                        <h4 class="text-right">Profile Settings</h4>
                    </div>
                    <div class="row mt-3">
                        <div class="col-md-12">
                            <label class="labels">Name</label>
                            <input type="text" name="name" class="form-control" placeholder="Name" value="{{ Auth::user()->name }}">
                        </div>
                        <div class="col-md-12">
                            <label class="labels">Email ID</label>
                            <input type="email" name="email" class="form-control" placeholder="Email" value="{{ Auth::user()->email }}">
                        </div>
                        <div class="col-md-12">
                            <label class="labels">Password</label>
                            <input type="password" name="password" class="form-control" placeholder="password">
                        </div>
                        <div class="col-md-12">
                            <label class="labels">Confirm Password</label>
                            <input type="password" name="password_confirmation" class="form-control" placeholder="Confirm Password">
                        </div>
                    </div>
                    <div class="mt-5 text-center">
                        <button class="btn btn-primary profile-button p-3" type="submit">Save Profile</button>
                        <a href="{{ route('bloggers.index') }}"> 
                            <button class="btn btn-danger profile-button p-3" type="button">Cancel</button>
                        </a>                 
                    </div> 
                </div>
            </div>
        </div>
    </form>
</div>
@endsection

@push('scripts')
<script>
    function displaySelectedImage(event, elementId) {
      const selectedImage = document.getElementById(elementId);
      const fileInput = event.target;
  
      if (fileInput.files && fileInput.files[0]) {
          const reader = new FileReader();
  
          reader.onload = function(e) {
              selectedImage.src = e.target.result;
          };
  
          reader.readAsDataURL(fileInput.files[0]);
      }
  }
  </script>
@endpush