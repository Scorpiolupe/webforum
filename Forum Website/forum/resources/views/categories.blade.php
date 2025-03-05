@extends('layout')

@section('title', 'Kategoriler')

@section('content')
<div class="row">
    <div class="col-md-12">
        <div class="card">
            <div class="card-header">
                <h2 class="mb-0"><i class="fas fa-folder-open"></i> Kategoriler</h2>
            </div>
            <div class="card-body">
                @if(count($categories) > 0)
                    <div class="row">
                        @foreach($categories as $category)
                            <div class="col-md-4 mb-4">
                                <div class="card h-100">
                                    <div class="card-body">
                                        <h5 class="card-title">
                                            <i class="fas fa-folder"></i> 
                                            {{ $category->name }}
                                        </h5>
                                        <p class="card-text text-muted">
                                            <small>
                                                <i class="fas fa-comments"></i> 
                                                {{ $category->topics_count ?? 0 }} Konu
                                            </small>
                                        </p>
                                        <a href="/categories/{{ $category->id }}" class="btn btn-primary">
                                            <i class="fas fa-arrow-right"></i> Görüntüle
                                        </a>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                @else
                    <div class="alert alert-info">
                        <i class="fas fa-info-circle"></i> Henüz kategori bulunmamaktadır.
                    </div>
                @endif
            </div>
        </div>
    </div>
</div>
@endsection