@extends('layouts.app')

@section('title', 'Show Postingan')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <h5>Postingan {{ $blogger->user->name }}</h5>
</div>
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

  <div class="container my-4">
    <div class="p-4 bg-secondary bg-opacity-10 rounded-4">

      {{-- Postingan Blog --}}
      @include('kerangka.postinganBlog')

      {{-- Like --}}
      @include('kerangka.like')

    </div>
  </div>
  
  {{-- Komentar --}}
  @include('kerangka.komentar')
@endsection

