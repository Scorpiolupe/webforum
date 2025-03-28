@extends('layout')

@section('title', 'Ana Sayfa - Forum')

@section('content')
<div class="row">
    <div class="col-md-8">
        <!-- Son Konular -->
        <div class="card bg-dark mb-4">
            <div class="card-header d-flex justify-content-between align-items-center">
                <h5 class="mb-0 text-light"><i class="fas fa-comments"></i> Son Konular</h5>
                <a href="/topics/create" class="btn btn-primary btn-sm">
                    <i class="fas fa-plus"></i> Yeni Konu
                </a>
            </div>
            <div class="card-body">
                @if(isset($topics) && count($topics) > 0)
                    @foreach($topics as $topic)
                        <div class="card bg-dark mb-3 border-secondary">
                            <div class="card-body">
                                <div class="d-flex justify-content-between align-items-center">
                                    <div>
                                        <h6 class="mb-0">
                                            <a href="/topics/{{ $topic->id }}" class="text-light text-decoration-none">
                                                {{ $topic->title }}
                                            </a>
                                        </h6>
                                        <small class="text-light">
                                            <i class="fas fa-user"></i> {{ $topic->user->username ?? 'Anonim' }} |
                                            <i class="fas fa-folder"></i> {{ $topic->category->name ?? 'Kategorisiz' }} |
                                            <i class="fas fa-clock"></i> {{ $topic->created_at->diffForHumans() }}
                                        </small>
                                    </div>
                                    <div>
                                        @if($topic->is_locked)
                                            <span class="badge bg-danger me-2">Kilitli</span>
                                        @else
                                            <span class="badge bg-success m-2">Açık</span>
                                        @endif
                                        <span class="badge bg-primary">{{ $topic->view_count ?? 0 }} <i class="fas fa-eye"></i></span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endforeach
                @else
                    <p class="text-center text-light mb-0">Henüz konu bulunmamaktadır.</p>
                @endif
            </div>
        </div>
    </div>

    <div class="col-md-4">
        <!-- Kategoriler -->
        <div class="card bg-dark mb-4">
            <div class="card-header">
                <h5 class="mb-0 text-light"><i class="fas fa-list"></i> Kategoriler</h5>
            </div>
            <div class="card-body">
                @if(isset($categories) && count($categories) > 0)
                    @foreach($categories as $category)
                        <div class="mb-2">
                            <a href="/categories/{{ $category->id }}" class="text-decoration-none text-light">
                                <i class="fas fa-folder"></i> {{ $category->name }}
                            </a>
                            <span class="badge bg-primary float-end">{{ count($category->questions) ?? 0 }}</span>
                        </div>
                    @endforeach
                @else
                    <p class="text-center text-light mb-0">Henüz kategori bulunmamaktadır.</p>
                @endif
            </div>
        </div>

        <!-- İstatistikler -->
        <div class="card bg-dark">
            <div class="card-header">
                <h5 class="mb-0 text-light"><i class="fas fa-chart-bar"></i> İstatistikler</h5>
            </div>
            <div class="card-body">
                <div class="d-flex justify-content-between mb-2">
                    <span class="text-light">Toplam Konu:</span>
                    <span class="badge bg-primary">{{ $totalTopics ?? 0 }}</span>
                </div>
                <div class="d-flex justify-content-between mb-2">
                    <span class="text-light">Toplam Üye:</span>
                    <span class="badge bg-primary">{{ $totalUsers ?? 0 }}</span>
                </div>
                <div class="d-flex justify-content-between">
                    <span class="text-light">Toplam Mesaj:</span>
                    <span class="badge bg-primary">{{ $totalPosts ?? 0 }}</span>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection