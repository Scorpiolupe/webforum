@extends('layout')

@section('title', 'En Çok Konuşulan Konular')

@section('content')
<div class="row">
    <div class="col-md-12">
        <!-- Arama ve Filtreleme Bölümü -->
        <div class="card mb-4 bg-dark text-light">
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
                        <select id="categoryFilter" class="form-select bg-dark text-light border-primary">
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
                    <div class="card bg-dark text-light">
            <div class="card-header bg-dark text-white d-flex justify-content-between align-items-center">
                <h4 class="mb-0"><i class="fas fa-newspaper"></i> Konular</h4>
                <div class="d-flex align-items-center gap-2">
                    <select id="sortFilter" class="form-select form-select-sm bg-dark text-light border-primary" style="width: auto;">
                        <option value="latest">En Son </option>
                        
                        <option value="most_upvoted">En Çok Oylanan </option>
                        <option value="most_viewed">En Çok Görüntülenen</option>
                    </select>
                    @auth
                        <button class="btn btn-light btn-sm" data-bs-toggle="collapse" data-bs-target="#newTopicCard">
                            <i class="fas fa-plus"></i> Yeni Konu
                        </button>
                    @endauth
                </div>
            </div>
                </div>
            </div>
        </div>

        <div class="card-body">
            @if(isset($topics) && count($topics) > 0)
                @foreach($topics as $topic)
                    <div class="card mb-3 topic-card" 
                        data-category-id="{{ $topic->category_id ?? '' }}"
                        data-created-at="{{ $topic->created_at }}"
                        data-upvotes="{{ $topic->upvotes()->count() }}"
                        data-views="{{ $topic->view_count ?? 0 }}">
                        <div class="card-body bg-dark text-light">
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
                                            <i class="fas fa-clock"></i> {{ $topic->created_at->diffForHumans() }}
                                            @if($topic->updated_at != $topic->created_at)
                                                | <i class="fas fa-edit"></i> {{ $topic->updated_at->diffForHumans() }} düzenlendi
                                            @endif |
                                            <i class="fas fa-comments"></i> {{ is_countable($topic->replies) ? count($topic->replies) : 0 }} Yanıt
                                        </small>
                                    </p>
                                </div>
                                <div class="d-flex align-items-center">
                                    @if($topic->is_locked)
                                        <span class="badge bg-danger me-2">Kilitli</span>
                                    @else
                                        <span class="badge bg-success m-2">Açık</span>
                                    @endif
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
                <div class="text-center text-light">
                    <p>Henüz konu bulunmamaktadır.</p>
                </div>
            @endif
        </div>
    </div>
</div>

@auth
    <div class="card text-light collapse new-topic-modal" id="newTopicCard">
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
                        <option value="" class="bg-dark text-light">Kategori Seçin</option>
                        @foreach($categories ?? [] as $category)
                            <option value="{{ $category->id }}" class="bg-dark text-light">{{ $category->name }}</option>
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

.new-topic-modal {
    position: fixed;
    top: 50%;
    left: 50%;
    transform: translate(-50%, -50%);
    z-index: 1060; /* z-index değerini arttırdık */
    width: 90%;
    max-width: 600px;
    pointer-events: none; /* Başlangıçta tıklamayı devre dışı bırak */
}

.new-topic-modal.show {
    display: block;
    pointer-events: auto; /* Modal gösterildiğinde tıklamayı etkinleştir */
}

.new-topic-modal .card-body {
    background-color: var(--secondary-bg);
}

.modal-backdrop {
    position: fixed;
    top: 0;
    left: 0;
    width: 100%;
    height: 100%;
    background-color: rgba(0, 0, 0, 0.5);
    z-index: 1055; /* Modal'dan düşük, diğer elementlerden yüksek */
    display: none;
    pointer-events: auto;
}

.modal-backdrop.show {
    display: block;
}

/* Form elemanlarına hover durumunda stabilite sağlamak için */
.new-topic-modal input:hover,
.new-topic-modal select:hover,
.new-topic-modal textarea:hover {
    z-index: 1061;
    position: relative;
}
</style>

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    axios.defaults.headers.common['X-CSRF-TOKEN'] = document.querySelector('meta[name="csrf-token"]').getAttribute('content');
    const searchInput = document.getElementById('searchInput');
    const categoryFilter = document.getElementById('categoryFilter');
    const sortFilter = document.getElementById('sortFilter');
    const resetButton = document.getElementById('resetFilters');
    const topicsContainer = document.querySelector('.card.bg-dark.text-light .card-body');

    function filterAndSortTopics() {
        const searchTerm = searchInput.value.toLowerCase();
        const selectedCategory = categoryFilter.value;
        const sortBy = sortFilter.value;
        
        let topicArray = Array.from(document.querySelectorAll('.topic-card'));

        // Filtreleme
        topicArray = topicArray.filter(card => {
            const title = card.querySelector('.card-title a').textContent.toLowerCase();
            const categoryId = card.getAttribute('data-category-id');
            const matchesSearch = title.includes(searchTerm);
            const matchesCategory = !selectedCategory || categoryId === selectedCategory;
            return matchesSearch && matchesCategory;
        });

        // Sıralama
        topicArray.sort((a, b) => {
            switch(sortBy) {
                case 'latest':
                    return new Date(b.getAttribute('data-created-at')) - new Date(a.getAttribute('data-created-at'));
                case 'oldest':
                    return new Date(a.getAttribute('data-created-at')) - new Date(b.getAttribute('data-created-at'));
                case 'most_upvoted':
                    return parseInt(b.getAttribute('data-upvotes')) - parseInt(a.getAttribute('data-upvotes'));
                case 'most_viewed':
                    return parseInt(b.getAttribute('data-views')) - parseInt(a.getAttribute('data-views'));
                default:
                    return 0;
            }
        });

        // Sonuçları gösterme
        const topicsList = document.querySelector('.card-body');
        const existingCards = topicsList.querySelectorAll('.topic-card');
        existingCards.forEach(card => card.style.display = 'none');

        if (topicArray.length > 0) {
            topicArray.forEach(card => {
                card.style.display = 'block';
                topicsList.appendChild(card);
            });
        } else {
            const noResults = document.createElement('div');
            noResults.className = 'text-center text-light';
            noResults.innerHTML = '<p>Konular bulunamadı.</p>';
            topicsList.appendChild(noResults);
        }
    }

    // Event listenerleri
    searchInput.addEventListener('input', filterAndSortTopics);
    categoryFilter.addEventListener('change', filterAndSortTopics);
    sortFilter.addEventListener('change', filterAndSortTopics);
    
    resetButton.addEventListener('click', () => {
        searchInput.value = '';
        categoryFilter.value = '';
        sortFilter.value = 'latest';
        document.querySelectorAll('.topic-card').forEach(card => card.style.display = 'block');
        filterAndSortTopics();
    });

    filterAndSortTopics();

    // Form Validationu
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

    // Upvote and Downvote Fonksiyonluğu
    document.querySelectorAll('.upvote-btn').forEach(button => {
        button.addEventListener('click', function() {
            const questionId = this.getAttribute('data-id');
            axios.post('/topics/' + questionId + '/upvote')
                .then(response => {
                    if (response.data.success) {
                        this.querySelector('i').nextSibling.textContent = ' ' + response.data.upvotes;
                        this.nextElementSibling.querySelector('i').nextSibling.textContent = ' ' + response.data.downvotes;
                        // Upvote sonrası sayfayı güncelle
                        filterAndSortTopics();
                        // İlgili kartın data attribute'unu güncelle
                        const card = this.closest('.topic-card');
                        card.setAttribute('data-upvotes', response.data.upvotes);
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
            axios.post('/topics/' + questionId + '/downvote')
                .then(response => {
                    if (response.data.success) {
                        this.querySelector('i').nextSibling.textContent = ' ' + response.data.downvotes;
                        this.previousElementSibling.querySelector('i').nextSibling.textContent = ' ' + response.data.upvotes;
                        // Downvote sonrası sayfayı güncelle
                        filterAndSortTopics();
                        // İlgili kartın data attribute'unu güncelle
                        const card = this.closest('.topic-card');
                        card.setAttribute('data-upvotes', response.data.upvotes);
                    }
                })
                .catch(error => {
                    console.error('Error:', error);
                });
        });
    });

    // Modal işlemleri için yeni kod
    const modalTrigger = document.querySelector('[data-bs-target="#newTopicCard"]');
    const modal = document.getElementById('newTopicCard');
    const closeButton = modal.querySelector('.btn-close');
    
    if (modalTrigger) {
        modalTrigger.addEventListener('click', function(e) {
            e.preventDefault();
            modal.classList.add('show');
            const backdrop = document.createElement('div');
            backdrop.className = 'modal-backdrop';
            document.body.appendChild(backdrop);
            setTimeout(() => backdrop.classList.add('show'), 10);
        });
    }
    
    if (closeButton) {
        closeButton.addEventListener('click', function() {
            modal.classList.remove('show');
            const backdrop = document.querySelector('.modal-backdrop');
            if (backdrop) {
                backdrop.classList.remove('show');
                setTimeout(() => backdrop.remove(), 200);
            }
        });
    }

    // Backdrop'a tıklandığında modalı kapat
    document.addEventListener('click', function(e) {
        if (e.target.classList.contains('modal-backdrop')) {
            modal.classList.remove('show');
            e.target.classList.remove('show');
            setTimeout(() => e.target.remove(), 200);
        }
    });
});
</script>
@endpush
@endsection