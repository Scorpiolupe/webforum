@extends('layout')

@section('title', $topic->title)

@section('content')
<div class="row">
    <div class="col-md-12">
        <div class="card bg-dark">
            <div class="card-header">
                <h2 class="text-light mb-0">{{ $topic->title }}</h2>
                <small class="text-muted">
                    <i class="fas fa-user"></i> {{ $topic->user->name }} |
                    <i class="fas fa-folder"></i> {{ $topic->category->name }} |
                    <i class="fas fa-clock"></i> {{ $topic->created_at->diffForHumans() }} |
                    <i class="fas fa-eye"></i> {{ $topic->view_count }} görüntülenme
                </small>
            </div>
            <div class="card-body">
                <div class="topic-content text-light">
                    {{ $topic->content }}
                </div>
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
                                    <strong class="text-light">{{ $reply->user->name }}</strong>
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
        @endauth
    </div>
</div>
@endsection
