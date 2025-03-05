@extends('layout')

@section('title', 'Ana Sayfa - Forum')

@section('content')
<div class="row">
    <div class="col-md-8">
        <!-- Son Konular -->
        <div class="card mb-4">
            <div class="card-header d-flex justify-content-between align-items-center">
                <h5 class="mb-0"><i class="fas fa-comments"></i> Son Konular</h5>
                <a href="/topics/create" class="btn btn-primary btn-sm">
                    <i class="fas fa-plus"></i> Yeni Konu
                </a>
            </div>
            <div class="card-body">
                @if(isset($topics) && count($topics) > 0)
                    @foreach($topics as $topic)
                        <div class="d-flex align-items-center mb-3">
                            <div class="flex-shrink-0">
                                <img src="{{ $topic->user->avatar ?? 'https://via.placeholder.com/50' }}" class="rounded-circle" width="50" height="50" alt="User avatar">
                            </div>
                            <div class="ms-3">
                                <h6 class="mb-0">
                                    <a href="/topics/{{ $topic->id }}" class="text-decoration-none text-light">
                                        {{ $topic->title }}
                                    </a>
                                </h6>
                                <small class="text-muted">
                                    {{ $topic->user->name ?? 'Anonim' }} tarafından 
                                    {{ $topic->created_at->diffForHumans() }}
                                </small>
                            </div>
                        </div>
                    @endforeach
                @else
                    <p class="text-center mb-0">Henüz konu bulunmamaktadır.</p>
                @endif
            </div>
        </div>
    </div>

    <div class="col-md-4">
        <!-- Kategoriler -->
        <div class="card mb-4">
            <div class="card-header">
                <h5 class="mb-0"><i class="fas fa-list"></i> Kategoriler</h5>
            </div>
            <div class="card-body">
                @if(isset($categories) && count($categories) > 0)
                    @foreach($categories as $category)
                        <div class="mb-2">
                            <a href="/categories/{{ $category->id }}" class="text-decoration-none text-light">
                                <i class="fas fa-folder"></i> {{ $category->name }}
                            </a>
                            <span class="badge bg-primary float-end">{{ $category->topics_count ?? 0 }}</span>
                        </div>
                    @endforeach
                @else
                    <p class="text-center mb-0">Henüz kategori bulunmamaktadır.</p>
                @endif
            </div>
        </div>

        <!-- İstatistikler -->
        <div class="card">
            <div class="card-header">
                <h5 class="mb-0"><i class="fas fa-chart-bar"></i> İstatistikler</h5>
            </div>
            <div class="card-body">
                <div class="d-flex justify-content-between mb-2">
                    <span>Toplam Konu:</span>
                    <span class="badge bg-primary">{{ $totalTopics ?? 0 }}</span>
                </div>
                <div class="d-flex justify-content-between mb-2">
                    <span>Toplam Üye:</span>
                    <span class="badge bg-primary">{{ $totalUsers ?? 0 }}</span>
                </div>
                <div class="d-flex justify-content-between">
                    <span>Toplam Mesaj:</span>
                    <span class="badge bg-primary">{{ $totalPosts ?? 0 }}</span>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection