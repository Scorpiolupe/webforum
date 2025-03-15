@extends('layout')

@section('title', 'Admin Panel')

@section('content')
<div class="container">
    @if(auth()->check() && auth()->user()->is_admin)
        <div class="row">
            <div class="col-md-3">
                <div class="card mb-4">
                    <div class="card-header bg-primary text-white">
                        <h5 class="mb-0"><i class="fas fa-cogs"></i> Admin Menü</h5>
                    </div>
                    <div class="list-group list-group-flush">
                        <a href="#users" class="list-group-item list-group-item-action active" data-bs-toggle="list">
                            <i class="fas fa-users"></i> Kullanıcı Yönetimi
                        </a>
                        <a href="#categories" class="list-group-item list-group-item-action" data-bs-toggle="list">
                            <i class="fas fa-folder"></i> Kategori Yönetimi
                        </a>
                        <a href="#topics" class="list-group-item list-group-item-action" data-bs-toggle="list">
                            <i class="fas fa-comments"></i> Konu Yönetimi
                        </a>
                        <a href="#reports" class="list-group-item list-group-item-action" data-bs-toggle="list">
                            <i class="fas fa-flag"></i> Raporlar
                        </a>
                    </div>
                </div>
            </div>

            <div class="col-md-9">
                <div class="tab-content">
                    <!-- Kullanıcı Yönetimi -->
                    <div class="tab-pane fade show active" id="users">
                        <div class="card">
                            <div class="card-header d-flex justify-content-between align-items-center">
                                <h5 class="mb-0"><i class="fas fa-users"></i> Kullanıcı Yönetimi</h5>
                                <button class="btn btn-primary btn-sm" data-bs-toggle="modal" data-bs-target="#addUserModal">
                                    <i class="fas fa-plus"></i> Yeni Kullanıcı
                                </button>
                            </div>
                            <div class="card-body">
                                <div class="table-responsive">
                                    <table class="table table-hover">
                                        <thead>
                                            <tr>
                                                <th>ID</th>
                                                <th>Kullanıcı Adı</th>
                                                <th>E-posta</th>
                                                <th>Katılım Tarihi</th>
                                                <th>Durum</th>
                                                <th>İşlemler</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach($users ?? [] as $user)
                                            <tr>
                                                <td>{{ $user->id }}</td>
                                                <td>{{ $user->username }}</td>
                                                <td>{{ $user->email }}</td>
                                                <td>{{ $user->created_at->format('d.m.Y') }}</td>
                                                <td>
                                                    <span class="badge bg-{{ $user->is_active ? 'success' : 'danger' }}">
                                                        {{ $user->is_active ? 'Aktif' : 'Pasif' }}
                                                    </span>
                                                </td>
                                                <td>
                                                    <button class="btn btn-sm btn-warning" title="Düzenle">
                                                        <i class="fas fa-edit"></i>
                                                    </button>
                                                    <button class="btn btn-sm btn-danger" title="Sil">
                                                        <i class="fas fa-trash"></i>
                                                    </button>
                                                </td>
                                            </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Kategori Yönetimi -->
                    <div class="tab-pane fade" id="categories">
                        <div class="card">
                            <div class="card-header d-flex justify-content-between align-items-center">
                                <h5 class="mb-0"><i class="fas fa-folder"></i> Kategori Yönetimi</h5>
                                <button class="btn btn-primary btn-sm" data-bs-toggle="modal" data-bs-target="#addCategoryModal">
                                    <i class="fas fa-plus"></i> Yeni Kategori
                                </button>
                            </div>
                            <div class="card-body">
                                <div class="table-responsive">
                                    <table class="table table-hover">
                                        <thead>
                                            <tr>
                                                <th>ID</th>
                                                <th>Kategori Adı</th>
                                                <th>Konu Sayısı</th>
                                                <th>Oluşturma Tarihi</th>
                                                <th>İşlemler</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach($categories ?? [] as $category)
                                            <tr>
                                                <td>{{ $category->id }}</td>
                                                <td>{{ $category->name }}</td>
                                                <td>{{ $category->topics_count ?? 0 }}</td>
                                                <td>{{ $category->created_at->format('d.m.Y') }}</td>
                                                <td>
                                                    <button class="btn btn-sm btn-warning" title="Düzenle">
                                                        <i class="fas fa-edit"></i>
                                                    </button>
                                                    <button class="btn btn-sm btn-danger" title="Sil">
                                                        <i class="fas fa-trash"></i>
                                                    </button>
                                                </td>
                                            </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Konu Yönetimi -->
                    <div class="tab-pane fade" id="topics">
                        <div class="card">
                            <div class="card-header">
                                <h5 class="mb-0"><i class="fas fa-comments"></i> Konu Yönetimi</h5>
                            </div>
                            <div class="card-body">
                                <div class="table-responsive">
                                    <table class="table table-hover">
                                        <thead>
                                            <tr>
                                                <th>ID</th>
                                                <th>Başlık</th>
                                                <th>Yazar</th>
                                                <th>Kategori</th>
                                                <th>Yanıtlar</th>
                                                <th>Durum</th>
                                                <th>İşlemler</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach($topics ?? [] as $topic)
                                            <tr>
                                                <td>{{ $topic->id }}</td>
                                                <td>{{ $topic->title }}</td>
                                                <td>{{ $topic->user->username ?? 'Anonim' }}</td>
                                                <td>{{ $topic->category->name ?? 'Kategorisiz' }}</td>
                                                <td>{{ $topic->replies_count ?? 0 }}</td>
                                                <td>
                                                    <span class="badge bg-{{ $topic->is_active ? 'success' : 'danger' }}">
                                                        {{ $topic->is_active ? 'Aktif' : 'Pasif' }}
                                                    </span>
                                                </td>
                                                <td>
                                                    <button class="btn btn-sm btn-warning" title="Düzenle">
                                                        <i class="fas fa-edit"></i>
                                                    </button>
                                                    <button class="btn btn-sm btn-danger" title="Sil">
                                                        <i class="fas fa-trash"></i>
                                                    </button>
                                                </td>
                                            </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Raporlar -->
                    <div class="tab-pane fade" id="reports">
                        <div class="card">
                            <div class="card-header">
                                <h5 class="mb-0"><i class="fas fa-flag"></i> Raporlar</h5>
                            </div>
                            <div class="card-body">
                                <div class="row">
                                    <div class="col-md-6 col-lg-3 mb-4">
                                        <div class="card bg-primary text-white">
                                            <div class="card-body">
                                                <h6 class="card-title">Toplam Kullanıcı</h6>
                                                <h2 class="mb-0">{{ $totalUsers ?? 0 }}</h2>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-6 col-lg-3 mb-4">
                                        <div class="card bg-success text-white">
                                            <div class="card-body">
                                                <h6 class="card-title">Toplam Kategori</h6>
                                                <h2 class="mb-0">{{ $totalCategories ?? 0 }}</h2>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-6 col-lg-3 mb-4">
                                        <div class="card bg-info text-white">
                                            <div class="card-body">
                                                <h6 class="card-title">Toplam Konu</h6>
                                                <h2 class="mb-0">{{ $totalTopics ?? 0 }}</h2>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-6 col-lg-3 mb-4">
                                        <div class="card bg-warning text-white">
                                            <div class="card-body">
                                                <h6 class="card-title">Toplam Yanıt</h6>
                                                <h2 class="mb-0">{{ $totalReplies ?? 0 }}</h2>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    @else
        <div class="alert alert-danger">
            <i class="fas fa-exclamation-triangle"></i> Bu sayfaya erişim yetkiniz bulunmamaktadır.
        </div>
    @endif
</div>

<style>
.list-group-item {
    background-color: var(--secondary-bg);
    border-color: var(--primary-color);
    color: var(--text-color);
}

.list-group-item:hover {
    background-color: var(--primary-color);
    color: white;
}

.list-group-item.active {
    background-color: var(--primary-color);
    border-color: var(--primary-color);
}

.table {
    color: var(--text-color);
}

.table > :not(caption) > * > * {
    background-color: var(--secondary-bg);
    border-bottom-color: var(--primary-color);
}