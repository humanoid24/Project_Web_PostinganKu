<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
  <meta http-equiv="X-UA-Compatible" content="ie=edge" />
  <title>Edit Postingan</title>

  <!-- Bootstrap CSS -->
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" />

  <!-- Auto Set Theme (Light/Dark) -->
  <script>
    const savedTheme = localStorage.getItem('theme'); // Ambil dari localStorage
    const prefersDark = window.matchMedia("(prefers-color-scheme: dark)").matches;

    const currentTheme = savedTheme ? savedTheme : (prefersDark ? 'dark' : 'light');
    document.documentElement.setAttribute('data-bs-theme', currentTheme);
</script>
</head>
<body>

  <!-- Navbar -->
  @include('kerangka.navbar')

  <!-- Main Layout -->
  <div class="container-fluid">
    <div class="row">
      
      <!-- Sidebar -->
      @include('kerangka.sidebardesktop')

      <!-- Content Area -->
      <form action="{{ route('bloggers.update', $blogger) }}" class="col-lg-10 p-4" enctype="multipart/form-data" method="POST">
        @csrf
        @method('PUT')
        
        <!-- Title Section -->
        <div class="d-flex justify-content-between align-items-center mb-4">
          <h5>Buat Postingan</h5>
        </div>

        <!-- Blog Content Form -->
        <div class="container my-4">
          <div class="p-4 bg-secondary bg-opacity-10 rounded-4">

            <!-- Author Info -->
            <div class="d-flex align-items-center gap-3 mb-4">
              <img src="{{ Auth::user()->foto ? asset('storage/' . Auth::user()->foto) : 'https://st3.depositphotos.com/15648834/17930/v/600/depositphotos_179308454-stock-illustration-unknown-person-silhouette-glasses-profile.jpg' }}" alt="author" class="rounded-circle" width="40" height="40">
              <div>
                <div class="fw-semibold">{{ Auth::user()->name }}</div>
                <small class="text-muted"></small>
              </div>
            </div>
                
            <!-- Title and Date -->
            <div class="d-flex justify-content-between align-items-center mb-3">
              <h2 class="mb-0">
                <input type="text" name="judul" class="form-control" value="{{ old('judul', $blogger->judul) }}" placeholder="Judul Diskusi" />
              </h2>
            </div>

            <!-- Blog Header Image -->
            <div id="mediaPreviewContainer" class="w-100 mb-4 d-flex justify-content-start">
              @if ($blogger->media)
                  @php
                      $ext = pathinfo($blogger->media, PATHINFO_EXTENSION);
                  @endphp

                  @if (in_array($ext, ['jpg', 'jpeg', 'png']))
                    <img src="{{ asset('storage/' . $blogger->media) }}" 
                    id="selectedImage"
                    class="img-fluid" 
                    style="max-height: 350px; object-fit: contain;" 
                    alt="UX Header" />
                  @elseif (in_array($ext, ['mp4', 'mov', 'avi', 'wmv']))
                  <video width="100%" height="auto" controls preload="auto" controlsList="nodownload">
                      <source src="{{ asset('storage/' . $blogger->media) }}" type="video/{{ $ext }}">
                      Your browser does not support the video tag.
                  </video>
                  @else
                  <img src="https://mdbootstrap.com/img/Photos/Others/placeholder.jpg" 
                    id="selectedImage"
                    class="img-fluid" 
                    style="max-height: 350px; object-fit: contain;" 
                    alt="UX Header" />
                      
                  @endif
              @endif
            </div>
            <div class="d-flex justify-content-start mt-4">
              <div class="btn btn-primary btn-rounded">
                <label class="form-label text-white m-1" for="customFile1">Choose file</label>
                <input type="file" name="media"
                  accept=".jpg,.jpeg,.png,.mp4,.webm"
                  class="form-control d-none" id="customFile1"
                  onchange="displaySelectedMedia(event, 'mediaPreviewContainer')" />
              </div>
              <!-- Cancel Button -->
              <button type="button"
                  id="resetButton"
                  class="btn btn-sm btn-danger ms-2 btn-rounded"
                  style="display: none;"
                  onclick="resetMedia('customFile1', 'mediaPreviewContainer')">
                  Cancel
              </button>
            </div>

            <!-- Discussion Content -->
            <div class="mb-4 mt-4">
              <textarea class="form-control" name="isi" rows="10">{{ old('isi', $blogger->isi_konten) }}</textarea>
            </div>

            <!-- Action Buttons -->
            <div class="d-flex mt-2 justify-content-end gap-2">
              <a href="{{ route('bloggers.show', $blogger) }}" class="btn btn-secondary">Cancel</a>
              <button class="btn btn-success">Simpan Perubahan</button>
            </div>

          </div>
        </div>
        
      </form>
    </div>
  </div>

  <!-- Bootstrap Bundle JS -->
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>

<script>
  function displaySelectedMedia(event, containerId) {
    const file = event.target.files[0];
    const previewContainer = document.getElementById(containerId);
    const resetButton = document.getElementById("resetButton");

    // Hapus isi lama
    previewContainer.innerHTML = "";

    if (file) {
      const url = URL.createObjectURL(file);
      const ext = file.name.split('.').pop().toLowerCase();

      if (['jpg', 'jpeg', 'png'].includes(ext)) {
        const img = document.createElement("img");
        img.src = url;
        img.className = "img-fluid";
        img.style.maxHeight = "350px";
        img.style.objectFit = "contain";
        previewContainer.appendChild(img);
      } else if (['mp4', 'webm'].includes(ext)) {
        const video = document.createElement("video");
        video.src = url;
        video.controls = true;
        video.style.maxHeight = "350px";
        previewContainer.appendChild(video);
      }

      resetButton.style.display = "inline-block";
    }
  }

  function resetMedia(fileInputId, containerId) {
  const previewContainer = document.getElementById(containerId);
  const fileInput = document.getElementById(fileInputId);
  const resetButton = document.getElementById("resetButton");

  previewContainer.innerHTML = '';

  // Tambahkan kembali placeholder gambar
  const placeholder = document.createElement("img");
  placeholder.src = "https://mdbootstrap.com/img/Photos/Others/placeholder.jpg";
  placeholder.className = "img-fluid";
  placeholder.style.maxHeight = "350px";
  placeholder.style.objectFit = "contain";
  previewContainer.appendChild(placeholder);

  fileInput.value = "";
  resetButton.style.display = "none";
}

  </script>

</body>
</html>
