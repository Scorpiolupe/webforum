@extends('layout')

@section('title', 'En Çok Konuşulan Konular')

@section('content')
<div class="row">
    <div class="col-md-12">
        <div class="card">
            <div class="card-header bg-primary text-white">
                <h4 class="mb-0"><i class="fas fa-newspaper"></i> Konular</h4>
            </div>
            <div class="card-body">
                @if(isset($topics) && count($topics) > 0)
                    @foreach($topics as $topic)
                        <div class="card mb-3">
                            <div class="card-body">
                                <div class="d-flex justify-content-between align-items-center">
                                    <div>
                                        <h5 class="card-title">
                                            <a href="/topics/{{ $topic->id }}" class="text-decoration-none text-light">
                                                {{ $topic->title }}
                                            </a>
                                        </h5>
                                        <p class="card-text text-muted">
                                            <small>
                                                <i class="fas fa-user"></i> {{ $topic->user->name ?? 'Anonim' }} |
                                                <i class="fas fa-folder"></i> {{ $topic->category->name ?? 'Kategorisiz' }} |
                                                <i class="fas fa-clock"></i> {{ $topic->created_at->diffForHumans() }} |
                                                <i class="fas fa-comments"></i> {{ $topic->replies_count ?? 0 }} Yanıt
                                            </small>
                                        </p>
                                    </div>
                                    <div>
                                        <span class="badge bg-primary">{{ $topic->views ?? 0 }} Görüntülenme</span>
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
                        @auth
                            <a href="/topics/create" class="btn btn-primary">
                                <i class="fas fa-plus"></i> Yeni Konu Oluştur
                            </a>
                        @endauth
                    </div>
                @endif
            </div>
        </div>
    </div>
</div>

@if(auth()->check())
    <div class="position-fixed bottom-0 end-0 m-4">
        <a href="/topics/create" class="btn btn-primary btn-lg rounded-circle">
            <i class="fas fa-plus"></i>
        </a>
    </div>
@endif
@endsection