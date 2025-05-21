@extends('layout')

@section('content')
<!-- Panel Header -->
<div class="bg-dark text-white py-3 px-4 mb-4">
    <div class="container-fluid">
        <div class="d-flex justify-content-between align-items-center">
            <h4 class="mb-0">Admin Paneli</h4>
            
        </div>
    </div>
</div>

<div class="container-fluid px-4">
    <!-- İstatistik Kartları -->
    <div class="row g-4 mb-4">
        <div class="col-md-3">
            <div class="card border-0 bg-dark text-white h-100">
                <div class="card-body">
                    <div class="d-flex align-items-center">
                        <div class="rounded-circle p-3" style="background: rgba(52, 152, 219, 0.2)">
                            <i class="fas fa-users fa-2x text-info"></i>
                        </div>
                        <div class="ms-3">
                            <h6 class="card-title mb-1 text-secondary">Aktif Kullanıcılar</h6>
                            <h3 class="mb-0">{{ $activeUsers ?? 0 }}</h3>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card border-0 bg-dark text-white h-100">
                <div class="card-body">
                    <div class="d-flex align-items-center">
                        <div class="rounded-circle p-3" style="background: rgba(46, 204, 113, 0.2)">
                            <i class="fas fa-question-circle fa-2x text-success"></i>
                        </div>
                        <div class="ms-3">
                            <h6 class="card-title mb-1 text-secondary">Toplam Soru</h6>
                            <h3 class="mb-0">{{ $totalQuestions ?? 0 }}</h3>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card border-0 bg-dark text-white h-100">
                <div class="card-body">
                    <div class="d-flex align-items-center">
                        <div class="rounded-circle p-3" style="background: rgba(241, 196, 15, 0.2)">
                            <i class="fas fa-clock fa-2x text-warning"></i>
                        </div>
                        <div class="ms-3">
                            <h6 class="card-title mb-1 text-secondary">Bekleyen</h6>
                            <h3 class="mb-0">{{ $pendingQuestions ?? 0 }}</h3>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card border-0 bg-dark text-white h-100">
                <div class="card-body">
                    <div class="d-flex align-items-center">
                        <div class="rounded-circle p-3" style="background: rgba(155, 89, 182, 0.2)">
                            <i class="fas fa-comments fa-2x text-purple"></i>
                        </div>
                        <div class="ms-3">
                            <h6 class="card-title mb-1 text-secondary">Toplam Cevap</h6>
                            <h3 class="mb-0">{{ $totalAnswers ?? 0 }}</h3>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Ana İçerik -->
    <div class="row">
        <div class="col-12">
            <!-- Bekleyen Konular Tablosu -->
            <div class="card bg-dark text-white border-0 shadow-sm mb-4">
                <div class="card-header border-0 py-3">
                    <h5 class="mb-0"><i class="fas fa-question-circle me-2 text-info"></i>Bekleyen Konular</h5>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-dark table-hover align-middle" id="pendingQuestions">
                            <thead>
                                <tr class="text-secondary">
                                    <th>Başlık</th>
                                    <th>Yazar</th>
                                    <th>Tarih</th>
                                    <th>İşlemler</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse ($pendingQuestionsList ?? [] as $question)
                                <tr>
                                    <td class="text-white">{{ $question->title ?? '' }}</td>
                                    <td>
                                        <div class="d-flex align-items-center">
                                            <div class="rounded-circle bg-secondary bg-opacity-25 p-2 me-2">
                                                <i class="fas fa-user text-info"></i>
                                            </div>
                                            <span class="text-white">{{ $question->user->username ?? '' }}</span>
                                        </div>
                                    </td>
                                    <td class="text-secondary">{{ $question->created_at ?? '' }}</td>
                                    <td>
                                        <div class="btn-group">
                                            <button class="btn btn-sm btn-outline-success approve-btn" data-id="{{ $question->id }}">
                                                <i class="fas fa-check"></i>
                                            </button>
                                            <button class="btn btn-sm btn-outline-danger reject-btn" data-id="{{ $question->id }}">
                                                <i class="fas fa-times"></i>
                                            </button>
                                            <button class="btn btn-sm btn-outline-info detail-btn" data-id="{{ $question->id }}">
                                                <i class="fas fa-info-circle"></i>
                                            </button>
                                        </div>
                                    </td>
                                </tr>
                                @empty
                                <tr>
                                    <td colspan="4" class="text-center py-4 text-secondary">
                                        <i class="fas fa-inbox fa-2x mb-3"></i>
                                        <p class="mb-0">Bekleyen soru bulunmamaktadır</p>
                                    </td>
                                </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>

            <!-- Onaylanmış Konular Tablosu -->
            <div class="card bg-dark text-white border-0 shadow-sm mb-4">
                <div class="card-header border-0 py-3">
                    <h5 class="mb-0"><i class="fas fa-question-circle me-2 text-info"></i>Onaylanmış Konular</h5>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-dark table-hover align-middle">
                            <thead>
                                <tr class="text-secondary">
                                    <th>Başlık</th>
                                    <th>Yazar</th>
                                    <th>Tarih</th>
                                    <th>İşlemler</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse ($questionsList ?? [] as $question)
                                <tr>
                                    <td class="text-white">{{ $question->title ?? '' }}</td>
                                    <td>
                                        <div class="d-flex align-items-center">
                                            <div class="rounded-circle bg-secondary bg-opacity-25 p-2 me-2">
                                                <i class="fas fa-user text-info"></i>
                                            </div>
                                            <span class="text-white">{{ $question->user->username ?? '' }}</span>
                                        </div>
                                    </td>
                                    <td class="text-secondary">{{ $question->created_at ?? '' }}</td>
                                    <td>
                                        <div class="btn-group">
                                            <button class="btn btn-sm btn-outline-success edit-btn" data-id="{{ $question->id }}">
                                                <i class="fas fa-edit"></i>
                                            </button>
                                            @if (!$question->is_locked)
                                                <button class="btn btn-sm btn-outline-warning lock-btn" data-id="{{ $question->id }}">
                                                    <i class="fas fa-lock-open"></i>
                                                </button>
                                            @elseif($question->is_locked)
                                                <button class="btn btn-sm btn-outline-warning unlock-btn" data-id="{{ $question->id }}">
                                                    <i class="fas fa-lock"></i>
                                                </button>
                                            @endif
                                            <button class="btn btn-sm btn-outline-danger delete-btn" data-id="{{ $question->id }}">
                                                <i class="fas fa-trash"></i>
                                            </button>
                                            <button class="btn btn-sm btn-outline-info detail-btn" data-id="{{ $question->id }}">
                                                <i class="fas fa-info-circle"></i>
                                            </button>
                                        </div>
                                    </td>
                                </tr>
                                @empty
                                <tr>
                                    <td colspan="4" class="text-center py-4 text-secondary">
                                        <i class="fas fa-inbox fa-2x mb-3"></i>
                                        <p class="mb-0">Soru bulunmamaktadır</p>
                                    </td>
                                </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>

            <!-- Kullanıcılar Tablosu -->
            <div class="card bg-dark text-white border-0 shadow-sm mb-4">
                <div class="card-header border-0 py-3">
                    <h5 class="mb-0"><i class="fas fa-users me-2 text-info"></i>Kullanıcılar</h5>
                </div>
                <div class="card-body">
                    <ul class="nav nav-tabs mb-3 border-0">
                        <li class="nav-item">
                            <a class="nav-link active bg-transparent text-white border-info" data-bs-toggle="tab" href="#users-tab">Üyeler</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link bg-transparent text-secondary" data-bs-toggle="tab" href="#admins-tab">Adminler</a>
                        </li>
                    </ul>

                    <div class="tab-content">
                        <div class="tab-pane fade show active" id="users-tab">
                            <div class="table-responsive">
                                <table class="table table-dark table-hover align-middle">
                                    <thead>
                                        <tr class="text-secondary">
                                            <th>ID</th>
                                            <th>Kullanıcı Adı</th>
                                            <th>Email</th>
                                            <th>İşlemler</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @forelse ($users ?? [] as $user)
                                        <tr>
                                            <td class="text-white">{{ $user->id }}</td>
                                            <td>
                                                <div class="d-flex align-items-center">
                                                    <div class="rounded-circle bg-secondary bg-opacity-25 p-2 me-2">
                                                        <i class="fas fa-user text-info"></i>
                                                    </div>
                                                    <span class="text-white">{{ $user->username }}</span>
                                                </div>
                                            </td>
                                            <td class="text-secondary">{{ $user->email }}</td>
                                            <td>
                                                <div class="btn-group">
                                                    @if ($user->is_banned)
                                                        <button class="btn btn-sm btn-outline-success unban-btn" data-id="{{ $user->id }}">
                                                            <i class="fas fa-lock-open"></i>
                                                        </button>
                                                    @else
                                                        <button class="btn btn-sm btn-outline-warning ban-btn" data-id="{{ $user->id }}">
                                                            <i class="fas fa-ban"></i>
                                                        </button>
                                                    @endif
                                                    <button class="btn btn-sm btn-outline-danger" data-id="{{ $user->id }}">
                                                        <i class="fas fa-trash"></i>
                                                    </button>
                                                    <button class="btn btn-sm btn-outline-primary make-admin-btn" data-id="{{ $user->id }}">
                                                        <i class="fas fa-crown"></i>
                                                    </button>
                                                    <button class="btn btn-sm btn-outline-info user-detail-btn" data-id="{{ $user->id }}">
                                                        <i class="fas fa-info-circle"></i>
                                                    </button>
                                                </div>
                                            </td>
                                        </tr>
                                        @empty
                                        <tr>
                                            <td colspan="4" class="text-center py-4 text-secondary">
                                                <i class="fas fa-users fa-2x mb-3"></i>
                                                <p class="mb-0">Kullanıcı bulunmamaktadır</p>
                                            </td>
                                        </tr>
                                        @endforelse
                                    </tbody>
                                </table>
                            </div>
                        </div>

                        <div class="tab-pane fade" id="admins-tab">
                            <div class="table-responsive">
                                <table class="table table-dark table-hover align-middle">
                                    <thead>
                                        <tr class="text-secondary">
                                            <th>ID</th>
                                            <th>Kullanıcı Adı</th>
                                            <th>Email</th>
                                            <th>İşlemler</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @forelse ($admins ?? [] as $admin)
                                        <tr>
                                            <td class="text-white">{{ $admin->id }}</td>
                                            <td>
                                                <div class="d-flex align-items-center">
                                                    <div class="rounded-circle bg-warning bg-opacity-10 p-2 me-2">
                                                        <i class="fas fa-crown text-warning"></i>
                                                    </div>
                                                    <span class="text-white">{{ $admin->username }}</span>
                                                </div>
                                            </td>
                                            <td class="text-secondary">{{ $admin->email }}</td>
                                            <td>
                                                <div class="btn-group">
                                                    <button class="btn btn-sm btn-outline-warning remove-admin-btn" data-id="{{ $admin->id }}">
                                                        <i class="fas fa-user-minus"></i>
                                                    </button>
                                                    <button class="btn btn-sm btn-outline-info user-detail-btn" data-id="{{ $admin->id }}">
                                                        <i class="fas fa-info-circle"></i>
                                                    </button>
                                                </div>
                                            </td>
                                        </tr>
                                        @empty
                                        <tr>
                                            <td colspan="4" class="text-center py-4 text-secondary">
                                                <i class="fas fa-user-shield fa-2x mb-3"></i>
                                                <p class="mb-0">Admin bulunmamaktadır</p>
                                            </td>
                                        </tr>
                                        @endforelse
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Mesajlar -->
            <div class="card bg-dark text-white border-0 shadow-sm mb-4">
                <div class="card-header border-0 py-3">
                    <h5 class="mb-0"><i class="fas fa-envelope me-2 text-info"></i>Mesajlar</h5>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-dark table-hover align-middle">
                            <thead>
                                <tr class="text-secondary">
                                    <th>Mesaj</th>
                                    <th>Tarih</th>
                                    <th>İşlemler</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse ($contacts ?? [] as $contact)
                                <tr>
                                    <td class="text-white">{{ Str::limit($contact->message ?? '', 50) }}</td>
                                    <td class="text-secondary">{{ $contact->created_at ?? 'Belirsiz' }}</td>
                                    <td>
                                        <div class="btn-group">
                                            <button class="btn btn-sm btn-outline-info contact-detail-btn" data-id="{{ $contact->id }}">
                                                <i class="fas fa-eye"></i>
                                            </button>
                                            <button class="btn btn-sm btn-outline-danger contact-delete-btn" data-id="{{ $contact->id }}">
                                                <i class="fas fa-trash"></i>
                                            </button>
                                        </div>
                                    </td>
                                </tr>
                                @empty
                                <tr>
                                    <td colspan="3" class="text-center py-4 text-secondary">
                                        <i class="fas fa-inbox fa-2x mb-3"></i>
                                        <p class="mb-0">Mesaj bulunmamaktadır</p>
                                    </td>
                                </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>

            <!-- Yanıtlar Tablosu -->
            <div class="card bg-dark text-white border-0 shadow-sm mb-4">
                <div class="card-header border-0 py-3">
                    <h5 class="mb-0"><i class="fas fa-comments me-2 text-info"></i>Yanıtlar</h5>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-dark table-hover align-middle">
                            <thead>
                                <tr class="text-secondary">
                                    <th>Yanıt</th>
                                    <th>Konu</th>
                                    <th>Yazan</th>
                                    <th>Tarih</th>
                                    <th>İşlemler</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse ($replies ?? [] as $reply)
                                <tr>
                                    <td class="text-light">{{ Str::limit($reply->content, 50) }}</td>
                                    <td>
                                        <a href="{{ route('topics.show', $reply->topic_id) }}" class="text-light text-decoration-none">
                                            {{ Str::limit($reply->topic->title, 30) }}
                                        </a>
                                    </td>
                                    <td class="text-light">{{ $reply->user->username ?? 'Silinmiş' }}</td>
                                    <td class="text-secondary">{{ $reply->created_at->diffForHumans() }}</td>
                                    <td>
                                        <div class="btn-group">
                                            <button class="btn btn-sm btn-outline-danger delete-reply-btn" 
                                                    data-id="{{ $reply->id }}"
                                                    data-topic-id="{{ $reply->topic_id }}">
                                                <i class="fas fa-trash"></i>
                                            </button>
                                        </div>
                                    </td>
                                </tr>
                                @empty
                                <tr>
                                    <td colspan="5" class="text-center py-4 text-secondary">
                                        <i class="fas fa-comments fa-2x mb-3"></i>
                                        <p class="mb-0">Henüz yanıt bulunmamaktadır</p>
                                    </td>
                                </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>

            <!-- Son Aktiviteler -->
            <div class="card bg-dark text-white border-0 shadow-sm mb-4">
                <div class="card-header border-0 py-3">
                    <h5 class="mb-0"><i class="fas fa-history me-2 text-info"></i>Son Aktiviteler</h5>
                </div>
                <div class="card-body p-0">
                    <div class="list-group list-group-flush">
                        @forelse ($recentActivities ?? [] as $activity)
                        <div class="list-group-item bg-dark border-secondary d-flex align-items-center py-3">
                            <div class="rounded-circle p-2 me-3 
                                @if($activity->type === 'moderation') bg-warning bg-opacity-25
                                @elseif($activity->type === 'user') bg-info bg-opacity-25
                                @else bg-secondary bg-opacity-25
                                @endif">
                                @if($activity->type === 'moderation')
                                    <i class="fas fa-shield-alt text-warning"></i>
                                @elseif($activity->type === 'user')
                                    <i class="fas fa-user text-info"></i>
                                @else
                                    <i class="fas fa-cog text-secondary"></i>
                                @endif
                            </div>
                            <div class="flex-grow-1">
                                <div class="d-flex justify-content-between align-items-center">
                                    <span class="text-white">{{ $activity->description }}</span>
                                    <small class="text-secondary ms-2">{{ $activity->created_at->diffForHumans() }}</small>
                                </div>
                                @if($activity->details)
                                    <small class="text-secondary d-block mt-1">{{ $activity->details }}</small>
                                @endif
                            </div>
                        </div>
                        @empty
                        <div class="text-center py-4 text-secondary">
                            <i class="fas fa-stream fa-2x mb-3"></i>
                            <p class="mb-0">Aktivite bulunmamaktadır</p>
                        </div>
                        @endforelse
                    </div>
                </div>
            </div>

<!-- Soru Detay Kartı -->
<div id="question-detail-card" class="card bg-dark text-white border-0 shadow-sm mb-4" style="display: none;">
    <div class="card-header border-0 py-3 d-flex justify-content-between align-items-center">
        <h5 class="mb-0"><i class="fas fa-question-circle me-2 text-info"></i>Soru Detayı</h5>
        <button type="button" class="btn-close btn-close-white" onclick="$('#question-detail-card').hide()"></button>
    </div>
    <div class="card-body">
        <div class="mb-3">
            <label class="text-secondary">Başlık</label>
            <p id="question-title" class="mb-0"></p>
        </div>
        <div class="mb-3">
            <label class="text-secondary">İçerik</label>
            <p id="question-content" class="mb-0"></p>
        </div>
        <div class="row">
            <div class="col-md-4">
                <label class="text-secondary">Yazar ID</label>
                <p id="question-author-id" class="mb-0"></p>
            </div>
            <div class="col-md-4">
                <label class="text-secondary">Yazar</label>
                <p id="question-author" class="mb-0"></p>
            </div>
            <div class="col-md-4">
                <label class="text-secondary">Tarih</label>
                <p id="question-date" class="mb-0"></p>
            </div>
        </div>
    </div>
</div>

<!-- Kullanıcı Detay Kartı -->
<div id="user-detail-card" class="card bg-dark text-white border-0 shadow-sm mb-4" style="display: none;">
    <div class="card-header border-0 py-3 d-flex justify-content-between align-items-center">
        <h5 class="mb-0"><i class="fas fa-user me-2 text-info"></i>Kullanıcı Detayı</h5>
        <button type="button" class="btn-close btn-close-white" onclick="$('#user-detail-card').hide()"></button>
    </div>
    <div class="card-body">
        <div class="row">
            <div class="col-md-3">
                <label class="text-secondary">ID</label>
                <p id="id" class="mb-0"></p>
            </div>
            <div class="col-md-3">
                <label class="text-secondary">Kullanıcı Adı</label>
                <p id="username" class="mb-0"></p>
            </div>
            <div class="col-md-3">
                <label class="text-secondary">Email</label>
                <p id="email" class="mb-0"></p>
            </div>
            <div class="col-md-3">
                <label class="text-secondary">Kayıt Tarihi</label>
                <p id="created_at" class="mb-0"></p>
            </div>
        </div>
    </div>
</div>

<!-- Mesaj Detay Kartı -->
<div id="contact-detail-card" class="card bg-dark text-white border-0 shadow-sm mb-4" style="display: none;">
    <div class="card-header border-0 py-3 d-flex justify-content-between align-items-center">
        <h5 class="mb-0"><i class="fas fa-envelope me-2 text-info"></i>Mesaj Detayı</h5>
        <button type="button" class="btn-close btn-close-white" onclick="$('#contact-detail-card').hide()"></button>
    </div>
    <div class="card-body">
        <div class="mb-3">
            <label class="text-secondary">Gönderen</label>
            <p id="contact-name" class="mb-0"></p>
        </div>
        <div class="mb-3">
            <label class="text-secondary">Email</label>
            <p id="contact-email" class="mb-0"></p>
        </div>
        <div class="mb-3">
            <label class="text-secondary">Mesaj</label>
            <p id="contact-message" class="mb-0"></p>
        </div>
        <div class="mb-3">
            <label class="text-secondary">Tarih</label>
            <p id="contact-date" class="mb-0"></p>
        </div>
    </div>
</div>

<style>
.bg-dark {
    background-color: #1a1d21 !important;
}
.card {
    background-color: #1a1d21;
}
.table-dark {
    background-color: #1a1d21;
    color: #fff;
}
.table-dark td, .table-dark th {
    border-color: #2d3238;
}
.nav-tabs .nav-link {
    color: #fff;
}
.nav-tabs .nav-link:hover {
    border-color: #3498db;
}
.nav-tabs .nav-link.active {
    background-color: transparent;
    border-color: #3498db;
    border-bottom-color: transparent;
}
.btn-outline-light:hover {
    background-color: #2d3238;
}
.modal-custom {
    background: #1a1d21;
    color: #fff;
}
.text-purple {
    color: #9b59b6;
}
.btn-group .btn {
    margin: 0 2px;
}
#question-detail-card, #user-detail-card, #contact-detail-card {
    position: fixed;
    top: 50%;
    left: 50%;
    transform: translate(-50%, -50%);
    z-index: 1000;
    max-width: 800px;
    width: 90%;
}
</style>

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
                    row.fadeOut(400, function() {
                        row.remove();
                        if($('#pendingQuestions tr').length === 0) {
                            $('#pendingQuestions').append('<tr><td colspan="4" class="text-center">Bekleyen soru bulunmamaktadır.</td></tr>');
                        }
                    });
                }
            },
            error: function(xhr) {
                alert('Bir hata oluştu: ' + xhr.responseJSON.message);
            }
        });
    });

    // Soruyu reddet
    $('.reject-btn').click(function() {
        const questionId = $(this).data('id');
        const row = $(this).closest('tr');

        if (confirm('Bu soruyu reddetmek istediğinizden emin misiniz?')) {
            $.ajax({
                url: '{{ route("panel.reject") }}',
                type: 'POST',
                data: {
                    id: questionId,
                    _token: '{{ csrf_token() }}'
                },
                success: function(response) {
                    if (response.success) {
                        row.fadeOut(400, function() {
                            row.remove();
                            if($('#pendingQuestions tr').length === 0) {
                                $('#pendingQuestions').append('<tr><td colspan="4" class="text-center">Bekleyen soru bulunmamaktadır.</td></tr>');
                            }
                        });
                    }
                },
                error: function(xhr) {
                    alert('Bir hata oluştu: ' + xhr.responseJSON.message);
                }
            });
        }
    });

    // Kullanıcıyı banla
    $('.ban-btn').click(function() {
        const userId = $(this).data('id');
        if (confirm('Bu kullanıcıyı banlamak istediğinizden emin misiniz?')) {
            $.ajax({
                url: '{{ route("panel.banUser") }}',
                type: 'POST',
                data: {
                    id: userId,
                    _token: '{{ csrf_token() }}'
                },
                success: function(response) {
                    if (response.success) {
                        location.reload();
                    }
                }
            });
        }
    });

    // Banı kaldır
    $('.unban-btn').click(function() {
        const userId = $(this).data('id');
        if (confirm('Bu kullanıcının banını kaldırmak istediğinizden emin misiniz?')) {
            $.ajax({
                url: '{{ route("panel.unbanUser") }}',
                type: 'POST',
                data: {
                    id: userId,
                    _token: '{{ csrf_token() }}'
                },
                success: function(response) {
                    if (response.success) {
                        location.reload();
                    }
                }
            });
        }
    });

    // Kullanıcıya yetki ver
    $('.make-admin-btn').click(function() {
        const userId = $(this).data('id');
        if (confirm('Bu kullanıcıya admin yetkisi vermek istediğinizden emin misiniz?')) {
            $.ajax({
                url: '{{ route("panel.makeAdmin") }}',
                type: 'POST',
                data: {
                    id: userId,
                    _token: '{{ csrf_token() }}'
                },
                success: function(response) {
                    if (response.success) {
                        location.reload();
                    }
                }
            });
        }
    });

    // Admin yetkisini kaldır 
    $('.remove-admin-btn').click(function() {
        const userId = $(this).data('id');
        if (confirm('Bu kullanıcının admin yetkisini kaldırmak istediğinizden emin misiniz?')) {
            $.ajax({
                url: '{{ route("panel.removeAdmin") }}',
                type: 'POST',
                data: {
                    id: userId,
                    _token: '{{ csrf_token() }}'
                },
                success: function(response) {
                    if (response.success) {
                        location.reload();
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
            data: {
                id: questionId
            },
            success: function(response) {
                if (response.success) {
                    // Verileri doldur
                    $('#question-title').text(response.data.title);
                    $('#question-content').text(response.data.content);
                    $('#question-author-id').text(response.data.author_id); 
                    $('#question-author').text(response.data.author);
                    $('#question-date').text(response.data.date);

                    // Kartı göster
                    $('#question-detail-card').fadeIn(300);
                }
            },
            error: function() {
                alert('Soru detayları yüklenirken bir hata oluştu');
            }
        });
    });

    // Kullanıcı detaylarını göster  
    $('.user-detail-btn').click(function() {
        const userId = $(this).data('id');

        $.ajax({
            url: '{{ route("panel.userDetail") }}',
            type: 'GET',
            data: { id: userId },
            success: function(response) {
                if (response.success) {
                    // Verileri doldur
                    $('#user-detail-card #id').text(response.data.id);
                    $('#user-detail-card #username').text(response.data.username);
                    $('#user-detail-card #email').text(response.data.email);
                    $('#user-detail-card #created_at').text(response.data.created_at);

                    // Kartı göster
                    $('#user-detail-card').fadeIn(300);
                }
            },
            error: function() {
                alert('Kullanıcı detayları yüklenirken bir hata oluştu');
            }
        });
    });

    // Kartları kapatma
    $('.btn-close').click(function() {
        $(this).closest('.card').fadeOut(300);
    });

    // Mesaj detaylarını göster
    $('.contact-detail-btn').click(function() {
        const contactId = $(this).data('id');

        $.ajax({
            url: '{{ route("panel.contactDetail") }}',
            type: 'GET',
            data: {
                id: contactId
            },
            success: function(response) {
                if (response.success) {
                    // Verileri doldur
                    $('#contact-name').text(response.data.name);
                    $('#contact-message').text(response.data.message);
                    $('#contact-email').text(response.data.email);
                    $('#contact-date').text(response.data.created_at);

                    // Kartı göster
                    $('#contact-detail-card').fadeIn(300);
                }
            },
            error: function() {
                alert('Mesaj detayları yüklenirken bir hata oluştu');
            }
        });
    });

    // Mesajı sil
    $('.contact-delete-btn').click(function() {
        const contactId = $(this).data('id');
        const row = $(this).closest('tr');

        if (confirm('Bu mesajı silmek istediğinizden emin misiniz?')) {
            $.ajax({
                url: '{{ route("panel.contactDelete") }}',
                type: 'POST',
                data: {
                    id: contactId,
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

    //Soru kilitle
    $('.lock-btn').click(function() {
        const questionId = $(this).data('id');
        if (confirm('Bu soruyu kilitlemek istediğinizden emin misiniz?')) {
            $.ajax({
                url: '{{ route("panel.lockQuestion") }}',
                type: 'POST',
                data: {
                    id: questionId,
                    _token: '{{ csrf_token() }}'
                },
                success: function(response) {
                    if (response.success) {
                        location.reload();
                    }
                }
            });
        }
    });

    //Soru kilidini aç
    $('.unlock-btn').click(function() {
        const questionId = $(this).data('id');
        if (confirm('Bu sorunun kilidini açmak istediğinizden emin misiniz?')) {
            $.ajax({
                url: '{{ route("panel.unlockQuestion") }}',
                type: 'POST',
                data: {
                    id: questionId,
                    _token: '{{ csrf_token() }}'
                },
                success: function(response) {
                    if (response.success) {
                        location.reload();
                    }
                }
            });
        }
    });

    //Soru Sil
    $('.delete-btn').click(function() {
        const questionId = $(this).data('id');
        const row = $(this).closest('tr');

        if (confirm('Bu soruyu silmek istediğinizden emin misiniz?')) {
            $.ajax({
                url: '{{ route("panel.deleteQuestion") }}',
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

    // Soru editle
    $('.edit-btn').click(function() {
        const questionId = $(this).data('id');
        window.location.href = '{{ route("topics") }}' + '/' + questionId + '/edit';
    });

    // Yanıt silme işlemi için
    $(document).on('click', '.delete-reply-btn', function() {
        if(confirm('Bu yanıtı silmek istediğinize emin misiniz?')) {
            const replyId = $(this).data('id');
            const topicId = $(this).data('topic-id');
            const row = $(this).closest('tr');
            
            $.ajax({
                url: '/panel/reply-delete',
                type: 'POST',
                data: {
                    reply_id: replyId,
                    topic_id: topicId,
                    _token: '{{ csrf_token() }}'
                },
                success: function(response) {
                    if(response.success) {
                        row.fadeOut();
                    }
                },
                error: function(xhr) {
                    alert('Bir hata oluştu: ' + xhr.responseJSON.message);
                }
            });
        }
    });

</script>
@endpush
@endsection