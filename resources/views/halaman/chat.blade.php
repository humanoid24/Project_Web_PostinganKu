@section('title', 'Chat')
    
@extends('layouts.app')

@section('content')
<div class="row justify-content-center">
    <div class="col-12">
      <div class="row" style="height: 90vh;">
        
        <!-- Sidebar (Contacts) -->
        <div class="col-md-4 col-12 mb-3 mb-md-0">
          @livewire('contact-list')
        </div>
        
        <!-- Chat Area -->
        <div class="col-md-8 col-12">
          <div class="card">
            @livewire('chat-form') <!-- Component to handle chat -->
          </div>
        </div>

      </div> <!-- End Inner Row -->
    </div>
</div>
@endsection