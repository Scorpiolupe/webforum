@extends('layout')

@section('title', 'Yanıt Düzenle')

@section('content')
<div class="row">
    <div class="col-md-12">
        <div class="card bg-dark">
            <div class="card-header">
                <h4 class="text-light mb-0">Yanıt Düzenle</h4>
            </div>
            <div class="card-body">
                <form action="{{ route('topics.updateReply', ['question' => $question->id, 'reply' => $reply->id]) }}" method="POST">
                    @csrf
                    @method('PUT')
                    <div class="mb-3">
                        <label class="form-label text-light">Yanıt İçeriği</label>
                        <textarea class="form-control bg-dark text-light" name="content" rows="5" required>{{ $reply->content }}</textarea>
                    </div>
                    <button type="submit" class="btn btn-primary">Güncelle</button>
                    <a href="{{ route('topics.show', $question->id) }}" class="btn btn-secondary">İptal</a>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection
