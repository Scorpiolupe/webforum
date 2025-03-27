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
            <div class="card mb-4 position-fixed top-50 start-50 translate-middle" id="question-detail-card" style="display: none; background-color: #343a40; color: white; z-index: 1050;">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h5 class="mb-0">Soru Detayları</h5>
                    <button type="button" class="btn-close btn-close-white" aria-label="Close" onclick="$('#question-detail-card').hide();"></button>
                </div>
                <div class="card-body">
                    <h5 id="question-title"></h5>
                    <p id="question-content"></p>
                    <p><strong>Yazar ID:</strong> <span id="question-author-id"></span></p>
                    <p><strong>Yazar:</strong> <span id="question-author"></span></p>
                    <p><strong>Tarih:</strong> <span id="question-date"></span></p>
                </div>
            </div>

            <!-- Kullanıcılar Tablosu -->

            <div class="card text-light">
                <div class="card-header">
                    <h5 class="mb-0">Kullanıcılar</h5>
                </div>
                <div class="card-body">
                    <h6 class="mb-2">Üyeler</h6>
                    <div class="table-responsive">
                        <table class="table table-hover">
                            <thead>
                                <tr>
                                    <th>ID</th>
                                    <th>Kullanıcı Adı</th>
                                    <th>Email</th>
                                    <th>İşlemler</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse ($users ?? [] as $user)
                                <tr>
                                    <td>{{ $user->id }}</td>
                                    <td><i class="fas fa-user me-2"></i>{{ $user->username }}</td>
                                    <td>{{ $user->email }}</td>
                                    <td>
                                        @if ($user->is_banned)
                                            <button class="btn btn-sm btn-success unban-btn" data-id="{{ $user->id }}">
                                                <i class="fas fa-lock-open"></i> Banı Kaldır
                                            </button>
                                        @else
                                            <button class="btn btn-sm btn-warning ban-btn" data-id="{{ $user->id }}">
                                                <i class="fas fa-ban"></i> Ban
                                            </button>
                                        @endif
                                        <button class="btn btn-sm btn-danger ban-btn" data-id="{{ $user->id }}">
                                                <i class="fas fa-times"></i> Sil
                                            </button>
                                        <button class="btn btn-sm btn-primary make-admin-btn" data-id="{{ $user->id }}">
                                            <i class="fas fa-crown"></i> Yetki Ver
                                        </button>
                                        <button class="btn btn-sm btn-secondary others-btn" data-id="{{ $user->id }}">
                                            <i class="fas fa-caret-down"></i> Diğer İşlemler
                                        </button>
                                        <button class="btn btn-sm btn-info user-detail-btn" data-id="{{ $user->id }}">
                                            <i class="fas fa-info-circle"></i> Bilgiler
                                        </button>
                                    </td>
                                </tr>
                                @empty
                                <tr>
                                    <td colspan="4" class="text-center">Kullanıcı bulunmamaktadır</td>
                                </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>

                    <h6 class="mb-2 mt-4">Adminler</h6>
                    <div class="table-responsive">
                        <table class="table table-hover">
                            <thead>
                                <tr>
                                    <th>ID</th>
                                    <th>Kullanıcı Adı</th>
                                    <th>Email</th>
                                    <th>İşlemler</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse ($admins ?? [] as $admin)
                                <tr>
                                    <td>{{ $admin->id }}</td>
                                    <td><i class="fas fa-crown me-2"></i>{{ $admin->username }}</td>
                                    <td>{{ $admin->email }}</td>
                                    <td>
                                        <button class="btn btn-sm btn-warning remove-admin-btn" data-id="{{ $admin->id }}">
                                            <i class="fas fa-times"></i> Yetkiyi Kaldır
                                        </button>
                                        <button class="btn btn-sm btn-secondary others-btn" data-id="{{ $admin->id }}">
                                            <i class="fas fa-caret-down"></i> Diğer İşlemler
                                        </button>
                                        <button class="btn btn-sm btn-info user-detail-btn" data-id="{{ $admin->id }}">
                                            <i class="fas fa-info-circle"></i> Bilgiler
                                        </button>
                                    </td>
                                </tr>
                                @empty
                                <tr>
                                    <td colspan="4" class="text-center">Admin bulunmamaktadır</td>
                                </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>

            <!-- Mesajlar -->
            <div class="card mb-4 mt-4 text-light">
                <div class="card-header">
                    <h5 class="mb-0">Mesajlar</h5>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-hover">
                            <thead>
                                <tr>
                                    <th>Mesaj</th>
                                    <th>Tarih</th>
                                    <th>İşlemler</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse ($contacts ?? [] as $contact)
                                <tr>
                                    <td>{{ Str::limit($contact->message ?? '', 50) }}</td>
                                    <td>{{ $contact->created_at ?? 'Belirsiz' }}</td>
                                    <td>
                                        <button class="btn btn-sm btn-info contact-detail-btn" data-id="{{ $contact->id }}">
                                            <i class="fas fa-info-circle"></i> Detay
                                        </button>
                                        <button class="btn btn-sm btn-danger contact-delete-btn" data-id="{{ $contact->id }}">
                                            <i class="fas fa-times"></i> Sil
                                        </button>
                                    </td>
                                </tr>
                                @empty
                                <tr>
                                    <td colspan="3" class="text-center">Mesaj bulunmamaktadır.</td>
                                </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>

            <!-- Son Aktiviteler -->
            <div class="card mb-4 mt-4 text-light">
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

            

            
            <div class="card mb-4 position-fixed top-50 start-50 translate-middle" id="user-detail-card" style="display: none; background-color: #343a40; color: white; z-index: 1050;">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h5 class="mb-0">Kullanıcı Detayları</h5>
                    <button type="button" class="btn-close btn-close-white" aria-label="Close" onclick="$('#user-detail-card').hide();"></button>
                </div>
                <div class="card-body">
                    <h5 id="question-title"></h5>
                    <p id="question-content"></p>
                    <p><strong>ID:</strong> <span id="id"></span></p>
                    <p><strong>Kullanıcı Adı:</strong> <span id="username"></span></p>
                    <p><strong>Email:</strong> <span id="email"></span></p>
                    <p><strong>Kayıt Tarihi:</strong> <span id="created_at"></span></p>
                </div>
            </div>

            <!-- İletişim Detay Kartı -->
            <div class="card mb-4 position-fixed top-50 start-50 translate-middle" id="contact-detail-card" style="display: none; background-color: #343a40; color: white; z-index: 1050;">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h5 class="mb-0">İletişim Mesajı Detayları</h5>
                    <button type="button" class="btn-close btn-close-white" aria-label="Close" onclick="$('#contact-detail-card').hide();"></button>
                </div>
                <div class="card-body">
                    <p><strong>Gönderen:</strong> <span id="contact-name"></span></p>
                    <p><strong>Email:</strong> <span id="contact-email"></span></p>
                    <p><strong>Tarih:</strong> <span id="contact-date"></span></p>
                    <div class="mt-3">
                        <strong>Mesaj:</strong>
                        <p id="contact-message" class="mt-2 p-3 bg-secondary rounded"></p>
                    </div>
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

    // Kullanıcı detaylarını göster
    $('.user-detail-btn').click(function() {
        const userId = $(this).data('id');
        $.ajax({
            url: '{{ route("panel.userDetail") }}',
            type: 'GET',
            data: { id: userId },
            success: function(response) {
                if (response.success) {
                    $('#user-detail-card #id').text(response.data.id);
                    $('#user-detail-card #username').text(response.data.username);
                    $('#user-detail-card #email').text(response.data.email);
                    $('#user-detail-card #created_at').text(response.data.created_at);
                    $('#user-detail-card').show();
                }
            }
        });
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
                    $('#question-title').text(response.data.title);
                    $('#question-content').text(response.data.content);
                    $('#question-author-id').text(response.data.author_id);
                    $('#question-author').text(response.data.author);
                    $('#question-date').text(response.data.date);
                    $('#question-detail-card').show();
                }
            }
        });
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
                    $('#contact-name').text(response.data.name);
                    $('#contact-message').text(response.data.message);
                    $('#contact-email').text(response.data.email);
                    $('#contact-date').text(response.data.date);
                    $('#contact-detail-card').show();
                }
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
</script>
@endpush
@endsection