@extends('layout')

@section('title', 'En Çok Konuşulan Konular')

@section('content')
<div class="row">
    <div class="col-md-12">
        <!-- Arama ve Filtreleme Bölümü -->
        <div class="card mb-4">
            <div class="card-body">
                <div class="row g-3">
                    <div class="col-md-6">
                        <div class="input-group">
                            <span class="input-group-text bg-dark border-primary">
                                <i class="fas fa-search text-light"></i>
                            </span>
                            <input type="text" id="searchInput" class="form-control" 
                                   placeholder="Konu başlığı ara...">
                        </div>
                    </div>
                    <div class="col-md-4">
                        <select id="categoryFilter" class="form-select">
                            <option value="">Tüm Kategoriler</option>
                            @foreach($categories ?? [] as $category)
                                <option value="{{ $category->id }}">{{ $category->name }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col-md-2">
                        <button id="resetFilters" class="btn btn-secondary w-100">
                            <i class="fas fa-undo"></i> Sıfırla
                        </button>
                    </div>
                </div>
            </div>
        </div>

        @auth
            <div class="card mb-4 text-light collapse" id="newTopicCard">
                <div class="card-header bg-primary text-white d-flex justify-content-between align-items-center">
                    <h5 class="mb-0"><i class="fas fa-plus"></i> Yeni Konu Oluştur</h5>
                    <button type="button" class="btn-close btn-close-white" data-bs-toggle="collapse" data-bs-target="#newTopicCard"></button>
                </div>
                <div class="card-body">
                    <form action="{{ route('topics.store') }}" method="POST">
                        @csrf
                        <div class="mb-3">
                            <label for="title" class="form-label">Konu Başlığı</label>
                            <input type="text" class="form-control @error('title') is-invalid @enderror" 
                                   id="title" name="title" required minlength="5" maxlength="255">
                            @error('title')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label for="category_id" class="form-label">Kategori</label>
                            <select class="form-select @error('category_id') is-invalid @enderror" 
                                    id="category_id" name="category_id" required>
                                <option value="">Kategori Seçin</option>
                                @foreach($categories ?? [] as $category)
                                    <option value="{{ $category->id }}">{{ $category->name }}</option>
                                @endforeach
                            </select>
                            @error('category_id')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label for="content" class="form-label">İçerik</label>
                            <textarea class="form-control @error('content') is-invalid @enderror" 
                                      id="content" name="content" rows="5" required minlength="20"></textarea>
                            @error('content')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <button type="submit" class="btn btn-primary">
                            <i class="fas fa-paper-plane"></i> Gönder
                        </button>
                    </form>
                </div>
            </div>
        @endauth

        <div class="card">
            <div class="card-header bg-primary text-white d-flex justify-content-between align-items-center">
                <h4 class="mb-0"><i class="fas fa-newspaper"></i> Konular</h4>
                @auth
                    <button class="btn btn-light btn-sm" data-bs-toggle="collapse" data-bs-target="#newTopicCard">
                        <i class="fas fa-plus"></i> Yeni Konu
                    </button>
                @endauth
            </div>
            <div class="card-body">
                @if(isset($topics) && count($topics) > 0)
                    @foreach($topics as $topic)
                        <div class="card mb-3 topic-card" data-category-id="{{ $topic->category_id ?? '' }}">
                            <div class="card-body">
                                <div class="d-flex justify-content-between align-items-center">
                                    <div>
                                        <h5 class="card-title">
                                            <a href="/topics/{{ $topic->id }}" class="text-decoration-none text-light">
                                                {{ $topic->title }}
                                            </a>
                                        </h5>
                                        <p class="card-text text-light text-muted">
                                            <small>
                                                <i class="fas fa-user"></i> {{ $topic->user->username ?? 'Anonim' }} |
                                                <i class="fas fa-folder"></i> {{ $topic->category->name ?? 'Kategorisiz' }} |
                                                <i class="fas fa-clock"></i> {{ $topic->created_at->diffForHumans() }} |
                                                <i class="fas fa-comments"></i> {{ count($topic->replies) ?? 0 }} Yanıt
                                            </small>
                                        </p>
                                    </div>
                                    <div class="d-flex align-items-center">
                                        <span class="badge bg-primary me-2">{{ $topic->view_count ?? 0 }} Görüntülenme</span></span>
                                        <button class="btn btn-outline-success btn-sm me-1 upvote-btn" data-id="{{ $topic->id }}">
                                            <i class="fas fa-arrow-up"></i> {{ $topic->upvotes()->count() }}
                                        </button>
                                        <button class="btn btn-outline-danger btn-sm downvote-btn" data-id="{{ $topic->id }}">
                                            <i class="fas fa-arrow-down"></i> {{ $topic->downvotes()->count() }}
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endforeach
                    
                    <div class="d-flex justify-content-center mt-4">
                        {{ $topics->links() }}
                    </div>
                @else
                    <div class="text-center">
                        <p>Henüz konu bulunmamaktadır.</p>
                    </div>
                @endif
            </div>
        </div>
    </div>
</div>

<style>
.collapse {
    transition: all 0.3s ease;
}
.card {
    margin-bottom: 1rem;
}
.form-control, .form-select {
    background-color: var(--secondary-bg);
    border-color: var(--primary-color);
    color: var(--text-color);
}
.form-control:focus, .form-select:focus {
    background-color: var(--secondary-bg);
    border-color: var(--primary-color);
    color: var(--text-color);
    box-shadow: 0 0 0 0.25rem rgba(107, 70, 193, 0.25);
}
.btn-close {
    filter: invert(1) grayscale(100%) brightness(200%);
}

#searchInput::placeholder {
    color: var(--text-color);
    opacity: 0.7;
}

.topic-card {
    display: block;
}

.topic-card.hidden {
    display: none;
}
</style>

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    axios.defaults.headers.common['X-CSRF-TOKEN'] = document.querySelector('meta[name="csrf-token"]').getAttribute('content');
    const searchInput = document.getElementById('searchInput');
    const categoryFilter = document.getElementById('categoryFilter');
    const resetButton = document.getElementById('resetFilters');
    const topicCards = document.querySelectorAll('.card.mb-3');

    function filterTopics() {
        const searchTerm = searchInput.value.toLowerCase();
        const selectedCategory = categoryFilter.value;

        topicCards.forEach(card => {
            const title = card.querySelector('.card-title a').textContent.toLowerCase();
            const category = card.querySelector('.fa-folder').parentElement.textContent;
            const categoryId = card.getAttribute('data-category-id');

            const matchesSearch = title.includes(searchTerm);
            const matchesCategory = !selectedCategory || categoryId === selectedCategory;

            if (matchesSearch && matchesCategory) {
                card.classList.remove('hidden');
            } else {
                card.classList.add('hidden');
            }
        });
    }

    // Event listeners
    searchInput.addEventListener('input', filterTopics);
    categoryFilter.addEventListener('change', filterTopics);
    
    resetButton.addEventListener('click', () => {
        searchInput.value = '';
        categoryFilter.value = '';
        topicCards.forEach(card => card.classList.remove('hidden'));
    });

    // Form validation (existing code)
    const form = document.querySelector('form');
    if (form) {
        form.addEventListener('submit', function(event) {
            if (!form.checkValidity()) {
                event.preventDefault();
                event.stopPropagation();
            }
            form.classList.add('was-validated');
        });
    }

    // Upvote and Downvote functionality
    document.querySelectorAll('.upvote-btn').forEach(button => {
        button.addEventListener('click', function() {
            const questionId = this.getAttribute('data-id');
            axios.post('/questions/' + questionId + '/upvote')
                .then(response => {
                    if (response.data.success) {
                        this.querySelector('i').nextSibling.textContent = ' ' + response.data.upvotes;
                        this.nextElementSibling.querySelector('i').nextSibling.textContent = ' ' + response.data.downvotes;
                    }
                })
                .catch(error => {
                    console.error('Error:', error);
                });
        });
    });

    document.querySelectorAll('.downvote-btn').forEach(button => {
        button.addEventListener('click', function() {
            const questionId = this.getAttribute('data-id');
            axios.post('/questions/' + questionId + '/downvote')
                .then(response => {
                    if (response.data.success) {
                        this.querySelector('i').nextSibling.textContent = ' ' + response.data.downvotes;
                        this.previousElementSibling.querySelector('i').nextSibling.textContent = ' ' + response.data.upvotes;
                    }
                })
                .catch(error => {
                    console.error('Error:', error);
                });
        });
    });
});
</script>
@endpush
@endsection