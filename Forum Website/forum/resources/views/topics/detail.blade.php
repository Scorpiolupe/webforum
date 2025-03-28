@extends('layout')

@section('title', $topic->title)

@section('content')
<div class="row">
    <div class="col-md-12">
        <div class="card bg-dark">
            <div class="card-header">
                <h2 class="text-light mb-0">{{ $topic->title }}</h2>
                <br>
                <small class="text-muted text-light">
                    <i class="fas fa-user"></i><a class="text-light" style="text-decoration: none;" href="/profile/{{ $topic->user->id }}"> {{ $topic->user->username }}</a> |
                    <i class="fas fa-folder"></i> {{ $topic->category->name }} |
                    <i class="fas fa-clock"></i> {{ $topic->created_at->diffForHumans() }} |
                    <i class="fas fa-eye"></i> {{ $topic->view_count }} görüntülenme
                </small>
                @if($topic->is_locked)
                    <span class="badge bg-danger">Kilitli</span>
                @else
                    <span class="badge bg-success">Açık</span>
                @endif
            </div>
            <div class="card-body">
                <div class="topic-content text-light mb-3">
                    {{ $topic->content }}
                </div>
            </div>
            <div class="card-footer d-flex justify-content-between">
                @if (Auth::user()->is_admin)
                    <form action="{{ route('topics.lock', $topic->id) }}" method="POST">
                        @csrf
                        <button type="submit" class="btn btn-danger btn-sm">
                            @if($topic->is_locked)
                                <i class="fas fa-unlock"></i> Kilidi Aç
                            @elseif(!$topic->is_locked)
                                <i class="fas fa-lock"></i> Kilitle
                            @endif
                        </button>
                    </form>
                @endif
                @if (Auth::id()==$topic->user_id || Auth::user()->is_admin)
                    <a href="{{ route('topics.edit', $topic->id) }}" class="btn btn-warning btn-sm">
                        <i class="fas fa-edit"></i> Düzenle
                    </a>
                @endif
            </div>
            
        </div>

        @if($topic->replies->count() > 0)
            <div class="card bg-dark mt-4">
                <div class="card-header">
                    <h4 class="text-light mb-0">Yanıtlar</h4>
                </div>
                <div class="card-body">
                    @foreach($topic->replies as $reply)
                        <div class="reply border-bottom border-secondary pb-3 mb-3">
                            <div class="d-flex justify-content-between">
                                <div>
                                    <strong class="text-light">{{ $reply->user->username }}</strong>
                                    <small class="text-muted">{{ $reply->created_at->diffForHumans() }}</small>
                                </div>
                            </div>
                            <div class="reply-content text-light mt-2">
                                {{ $reply->content }}
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        @endif

        @auth
            @if($topic->is_locked)
                <div class="alert alert-danger mt-4">
                    Bu konu kilitli olduğu için yanıt veremezsiniz.
                </div>
            @else
                <div class="card bg-dark mt-4">
                    <div class="card-header">
                        <h4 class="text-light mb-0">Yanıt Yaz</h4>
                    </div>
                    <div class="card-body">
                        <form action="{{ route('topics.reply', $topic->id) }}" method="POST">
                            @csrf
                            <div class="mb-3">
                                <textarea class="form-control bg-dark text-light" name="content" rows="3" required></textarea>
                            </div>
                            <button type="submit" class="btn btn-primary">Yanıtla</button>
                        </form>
                    </div>
                </div>
            @endif
        @endauth
    </div>
</div>
@endsection
