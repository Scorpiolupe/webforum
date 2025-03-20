@extends('layout')

@section('content')
<div class="container-fluid">
    <div class="row">
        <!-- Kenar Çubuğu -->
        <div class="col-md-3 col-lg-2 d-md-block bg-dark sidebar py-3">
            <div class="position-sticky">
                <ul class="nav flex-column">
                    <li class="nav-item">
                        <a class="nav-link active" href="#dashboard">
                            <i class="fas fa-tachometer-alt me-2"></i>Kontrol Paneli
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#pending-questions">
                            <i class="fas fa-question-circle me-2"></i>Bekleyen Sorular
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#users">
                            <i class="fas fa-users me-2"></i>Kullanıcılar
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#reports">
                            <i class="fas fa-flag me-2"></i>Raporlar
                        </a>
                    </li>
                </ul>
            </div>
        </div>

        <!-- Ana İçerik -->
        <div class="col-md-9 col-lg-10 ms-sm-auto px-4 py-3">
            <!-- İstatistik Kartları -->
            <div class="row g-3 mb-4">
                <div class="col-md-3">
                    <div class="card text-white bg-primary">
                        <div class="card-body">
                            <h5 class="card-title">Aktif Kullanıcılar</h5>
                            <h2 class="card-text">{{ $activeUsers ?? 0 }}</h2>
                        </div>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="card text-white bg-success">
                        <div class="card-body">
                            <h5 class="card-title">Toplam Soru</h5>
                            <h2 class="card-text">{{ $totalQuestions ?? 0 }}</h2>
                        </div>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="card text-white bg-warning">
                        <div class="card-body">
                            <h5 class="card-title">Bekleyen Sorular</h5>
                            <h2 class="card-text">{{ $pendingQuestions ?? 0 }}</h2>
                        </div>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="card text-white bg-info">
                        <div class="card-body">
                            <h5 class="card-title">Toplam Cevap</h5>
                            <h2 class="card-text">{{ $totalAnswers ?? 0 }}</h5>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Bekleyen Sorular Tablosu -->
            <div class="card mb-4 text-light">
                <div class="card-header">
                    <h5 class="mb-0">Bekleyen Sorular</h5>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-hover">
                            <thead>
                                <tr>
                                    <th>Başlık</th>
                                    <th>Yazar</th>
                                    <th>Tarih</th>
                                    <th>İşlemler</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse ($pendingQuestionsList ?? [] as $question)
                                <tr>
                                    <td>{{ $question->title ?? '' }}</td>
                                    <td>{{ $question->user->username ?? '' }}</td>
                                    <td>{{ $question->created_at ?? '' }}</td>
                                    <td>
                                        <button class="btn btn-sm btn-success approve-btn" data-id="{{ $question->id }}">
                                            <i class="fas fa-check"></i> Onayla
                                        </button>
                                        <button class="btn btn-sm btn-danger reject-btn" data-id="{{ $question->id }}">
                                            <i class="fas fa-times"></i> Reddet
                                        </button>
                                        <button class="btn btn-sm btn-info detail-btn" data-id="{{ $question->id }}">
                                            <i class="fas fa-info-circle"></i> Detay
                                        </button>
                                    </td>
                                </tr>
                                @empty
                                <tr>
                                    <td colspan="4" class="text-center">Bekleyen soru yok</td>
                                </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>

            <!-- Bekleyen Soru Detay Kartı -->
            <div class="card mb-4 position-fixed top-50 start-50 translate-middle" id="question-detail-card" style="display: none; background-color: #343a40; color: white;">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h5 class="mb-0">Soru Detayları</h5>
                    <button type="button" class="btn-close btn-close-white" aria-label="Close" onclick="$('#question-detail-card').hide();"></button>
                </div>
                <div class="card-body">
                    <h5 id="question-title"></h5>
                    <p id="question-content"></p>
                    <p><strong>Yazar:</strong> <span id="question-author"></span></p>
                    <p><strong>Tarih:</strong> <span id="question-date"></span></p>
                </div>
            </div>

            <!-- Son Aktiviteler -->
            <div class="card text-light">
                <div class="card-header">
                    <h5 class="mb-0">Son Aktiviteler</h5>
                </div>
                <div class="card-body">
                    <ul class="list-group list-group-flush">
                        @forelse ($recentActivities ?? [] as $activity)
                        <li class="list-group-item">
                            <i class="fas fa-clock me-2"></i>
                            {{ $activity->description ?? '' }}
                            <small class="text-muted float-end">{{ $activity->created_at ?? '' }}</small>
                        </li>
                        @empty
                        <li class="list-group-item text-center">Aktivite bulunmamaktadır</li>
                        @endforelse
                    </ul>
                </div>
            </div>
        </div>
    </div>
</div>

@push('scripts')
<script>
    // Soruyu onayla
    $('.approve-btn').click(function() {
        const questionId = $(this).data('id');
        const row = $(this).closest('tr');
        
        $.ajax({
            url: '{{ route("panel.approve") }}',
            type: 'POST',
            data: {
                id: questionId,
                _token: '{{ csrf_token() }}'
            },
            success: function(response) {
                if (response.success) {
                    row.fadeOut();
                }
            }
        });
    });

    // Soruyu reddet
    $('.reject-btn').click(function() {
        const questionId = $(this).data('id');
        const row = $(this).closest('tr');

        if (confirm('Bu soruyu silmek istediğinizden emin misiniz?')) {
            $.ajax({
                url: '{{ route("panel.reject") }}',
                type: 'POST',
                data: {
                    id: questionId,
                    _token: '{{ csrf_token() }}'
                },
                success: function(response) {
                    if (response.success) {
                        row.fadeOut();
                    }
                }
            });
        }
    });

    // Soru detaylarını göster
    $('.detail-btn').click(function() {
        const questionId = $(this).data('id');

        $.ajax({
            url: '{{ route("panel.questionDetail") }}',
            type: 'GET',
            data: { id: questionId },
            success: function(response) {
                if (response.success) {
                    $('#question-title').text(response.data.title);
                    $('#question-content').text(response.data.content);
                    $('#question-author').text(response.data.author);
                    $('#question-date').text(response.data.date);
                    $('#question-detail-card').show();
                }
            }
        });
    });
</script>
@endpush
@endsection