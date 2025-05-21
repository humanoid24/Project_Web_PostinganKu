<div class="d-flex align-items-center gap-2 mb-3">
    <div class="d-flex align-items-center justify-content-center mb-3">
        <div class="d-flex flex-column align-items-center">
            <button class="btn p-0 border-0 bg-transparent heart-button" data-blogger-id="{{ $blogger->id }}" style="font-size: 1.5rem;">
                <span class="heart-icon {{ $blogger->likes->where('user_id', auth()->id())->count() ? 'liked' : '' }}">
                    {{ $blogger->likes->where('user_id', auth()->id())->count() ? '❤️' : '🤍' }}
                </span>
            </button>
            <span class="like-count text-muted mt-1" style="font-size: 0.9rem;">
                {{ $blogger->likes->count() }}
            </span>
        </div>

        <div class="d-flex flex-column align-items-center mx-3 mt-1">
            <button class="btn p-0 border-0 bg-transparent" 
                data-bs-toggle="collapse" 
                data-bs-target="#komentar{{ $blogger->id }}" 
                aria-expanded="false" 
                aria-controls="komentar{{ $blogger->id }}">
                <i class="fa fa-comment-o" style="font-size: 1.5rem;"></i>
            </button>
            <span class="text-muted mt-2" style="font-size: 0.9rem;">{{ $blogger->komentar->count() }}</span>
        </div>

        <div class="d-flex flex-column align-items-center align-self-center mx-1 mt-1">
            <button class="btn p-0 border-0 bg-transparent save-button" data-blogger-id="{{ $blogger->id }}" style="font-size: 1.5rem;">
                <span class="save-icon {{ $blogger->savedPost->where('user_id', auth()->id())->count() ? 'saved' : '' }}">
                    <i class="fa {{ $blogger->savedPost->where('user_id', auth()->id())->count() ? 'fa-bookmark' : 'fa-bookmark-o' }}"></i>
                </span>
            </button>
            <span class="text-muted mt-2" style="font-size: 0.9rem;">&nbsp;</span>
        </div>
    </div>
</div>


@push('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function () {
      const heartButtons = document.querySelectorAll('.heart-button');

      heartButtons.forEach(button => {
        button.addEventListener('click', function (e) {
          e.preventDefault();

          const bloggerId = this.dataset.bloggerId;
          const icon = this.querySelector('.heart-icon');
          const count = this.nextElementSibling;

          fetch("{{ route('like.store') }}", {
            method: 'POST',
            headers: {
              'Content-Type': 'application/json',
              'X-CSRF-TOKEN': '{{ csrf_token() }}',
            },
            body: JSON.stringify({ blogger_id: bloggerId })
          })
          .then(response => response.json())
          .then(data => {
            icon.textContent = data.status === 'liked' ? '❤️' : '🤍';
            icon.classList.toggle('liked', data.status === 'liked');
            count.textContent = data.count;

            icon.classList.add('animate');
            setTimeout(() => icon.classList.remove('animate'), 200);
          })
          .catch(error => console.error('Like error:', error));
        });
      });
    });
</script>


<script>
  document.addEventListener('DOMContentLoaded', function () {
    const saveButtons = document.querySelectorAll('.save-button');

    saveButtons.forEach(button => {
        button.addEventListener('click', function (e) {
            e.preventDefault();

            const bloggerId = this.dataset.bloggerId;
            const icon = this.querySelector('.save-icon i');
            const status = icon.classList.contains('fa-bookmark') ? 'unsave' : 'save';

            fetch("{{ route('saved.store') }}", {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': '{{ csrf_token() }}',
                },
                body: JSON.stringify({ blogger_id: bloggerId, status: status })
            })
            .then(response => response.json())
            .then(data => {
                // Toggle ikon bookmark
                icon.classList.toggle('fa-bookmark', status === 'save');
                icon.classList.toggle('fa-bookmark-o', status === 'unsave');
            })
            .catch(error => console.error('Save error:', error));
        });
    });
});
</script>
@endpush

@push('style')
<style>
    .heart-icon {
      transition: transform 0.2s ease;
      display: inline-block;
    }

    .heart-icon.animate {
      transform: scale(1.3);
    }

    .heart-icon.liked {
      color: red;
    }

    /* Saved icon */
      .save-icon.saved {
        color: #f39c12; /* Ganti dengan warna yang kamu inginkan */
        transition: color 0.3s ease;
      }

      .save-icon i {
          font-size: 1.5rem;
          cursor: pointer;
      }

  </style>
@endpush
