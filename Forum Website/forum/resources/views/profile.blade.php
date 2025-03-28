@extends('layout')

@section('title', 'Profil')

@section('content')
<div class="row">
    <div class="col-md-4">
        <div class="card bg-dark mb-4">
            <div class="card-header">
                <h4 class="text-light mb-0"><i class="fas fa-user"></i> Profil Bilgileri</h4>
            </div>
            <div class="card-body">
                <div class="text-center mb-4">
                    <i class="fas fa-user-circle fa-5x text-primary"></i>
                </div>
                <div class="mb-3">
                    <label class="form-label text-light">Kullanıcı Adı</label>
                    <p class="form-control bg-secondary text-light">{{ $user->username }}</p>
                </div>
                <div class="mb-3">
                    <label class="form-label text-light">E-posta</label>
                    <p class="form-control bg-secondary text-light">{{ $user->email }}</p>
                </div>
                <div class="mb-3">
                    <label class="form-label text-light">Kayıt Tarihi</label>
                    <p class="form-control bg-secondary text-light">{{ $user->created_at->format('d.m.Y') }}</p>
                </div>
            </div>
        </div>
    </div>

    <div class="col-md-8">
        <!-- Konularım -->
        <div class="card bg-dark mb-4">
            <div class="card-header">
                <h4 class="text-light mb-0"><i class="fas fa-newspaper"></i> Konularım</h4>
            </div>
            <div class="card-body">
                @if(count($topics ?? []) > 0)
                    @foreach($topics as $topic)
                        <div class="card bg-secondary mb-3">
                            <div class="card-body">
                                <div class="d-flex justify-content-between align-items-center">
                                    <div>
                                        <h5 class="mb-1">
                                            <a href="/topics/{{ $topic->id }}" class="text-light text-decoration-none">
                                                {{ $topic->title }}
                                            </a>
                                        </h5>
                                        <small class="text-light">
                                            <i class="fas fa-folder"></i> {{ $topic->category->name }} |
                                            <i class="fas fa-clock"></i> {{ $topic->created_at->diffForHumans() }} |
                                            <i class="fas fa-comments"></i> {{ $topic->replies->count() }} Yanıt |
                                            <i class="fas fa-eye"></i> {{ $topic->view_count }} Görüntülenme
                                        </small>
                                    </div>
                                    @if(!$topic->is_approved)
                                        <span class="badge bg-warning">Onay Bekliyor</span>
                                    @endif
                                </div>
                            </div>
                        </div>
                    @endforeach
                @else
                    <p class="text-light text-center">Henüz konu açmamışsınız.</p>
                @endif
            </div>
        </div>

        <!-- Yanıtlarım -->
        <div class="card bg-dark">
            <div class="card-header">
                <h4 class="text-light mb-0"><i class="fas fa-comments"></i> Yanıtlarım</h4>
            </div>
            <div class="card-body">
                @if(count($replies ?? []) > 0)
                    @foreach($replies as $reply)
                        <div class="card bg-secondary mb-3">
                            <div class="card-body">
                                <div class="d-flex justify-content-between align-items-center">
                                    <div>
                                        <h6 class="mb-1">
                                            <a href="/topics/{{ $reply->topic->id }}" class="text-light text-decoration-none">
                                                {{ $reply->topic->title }}
                                            </a>
                                        </h6>
                                        <div class="d-flex align-items-start mb-2">
                                            <i class="fas fa-comment-dots text-white me-2 mt-1"></i>
                                            <div>
                                                <p class="mb-0 text-light fst-italic">
                                                    "{{ Str::limit($reply->content, 150) }}"
                                                </p>
                                            </div>
                                        </div>
                                        <small class="text-light">
                                            <i class="fas fa-clock"></i> {{ $reply->created_at->diffForHumans() }}
                                        </small>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endforeach
                @else
                    <p class="text-light text-center">Henüz yanıt yazmamışsınız.</p>
                @endif
            </div>
        </div>
    </div>
</div>
@endsection