@extends('layout')

@section('title', 'Giriş & Kayıt')

@section('content')
<div class="row justify-content-center">
    <div class="col-md-6">
        <div class="card login-card mb-4">
            <div class="card-body p-4 bg-dark text-light">
                <ul class="nav nav-tabs mb-4" id="authTab" role="tablist">
                    <li class="nav-item" role="presentation">
                        <button class="nav-link active" id="login-tab" data-bs-toggle="tab" data-bs-target="#login" type="button" role="tab">
                            <i class="fas fa-sign-in-alt"></i> Giriş Yap
                        </button>
                    </li>
                    <li class="nav-item" role="presentation">
                        <button class="nav-link" id="register-tab" data-bs-toggle="tab" data-bs-target="#register" type="button" role="tab">
                            <i class="fas fa-user-plus"></i> Kayıt Ol
                        </button>
                    </li>
                </ul>

                <div class="tab-content text-light" id="authTabContent">
                    <!-- Login Form -->
                    <div class="tab-pane fade show active" id="login" role="tabpanel">
                        <form action="{{ route('login') }}" method="POST" class="needs-validation" novalidate>
                            @csrf
                            <div class="mb-3">
                                <label for="loginEmail" class="form-label">Email Adresi</label>
                                <div class="input-group">
                                    <span class="input-group-text"><i class="fas fa-envelope"></i></span>
                                    <input type="email" class="form-control @error('email') is-invalid @enderror" 
                                           id="loginEmail" name="email" required>
                                    @error('email')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>

                            <div class="mb-3">
                                <label for="loginPassword" class="form-label">Şifre</label>
                                <div class="input-group">
                                    <span class="input-group-text"><i class="fas fa-lock"></i></span>
                                    <input type="password" class="form-control @error('password') is-invalid @enderror" 
                                           id="loginPassword" name="password" required>
                                    <button class="btn btn-outline-secondary" type="button" onclick="togglePassword('loginPassword')">
                                        <i class="fas fa-eye"></i>
                                    </button>
                                    @error('password')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>

                            <div class="mb-3 form-check">
                                <input type="checkbox" class="form-check-input" id="remember" name="remember">
                                <label class="form-check-label" for="remember">Beni Hatırla</label>
                            </div>

                            <button type="submit" class="btn btn-primary w-100">
                                <i class="fas fa-sign-in-alt"></i> Giriş Yap
                            </button>
                        </form>
                    </div>

                    <!-- Register Form -->
                    <div class="tab-pane fade text-light" id="register" role="tabpanel">
                        <form action="{{ route('register') }}" method="POST" class="needs-validation" novalidate>
                            @csrf
                            <div class="mb-3">
                                <label for="username" class="form-label">Kullanıcı Adı</label>
                                <div class="input-group">
                                    <span class="input-group-text"><i class="fas fa-user"></i></span>
                                    <input type="text" class="form-control @error('username') is-invalid @enderror" 
                                           id="username" name="username" required>
                                    @error('username')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>

                            <div class="mb-3">
                                <label for="registerEmail" class="form-label">Email Adresi</label>
                                <div class="input-group">
                                    <span class="input-group-text"><i class="fas fa-envelope"></i></span>
                                    <input type="email" class="form-control @error('email') is-invalid @enderror" 
                                           id="registerEmail" name="email" required>
                                    @error('email')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>

                            <div class="mb-3">
                                <label for="registerPassword" class="form-label">Şifre</label>
                                <div class="input-group">
                                    <span class="input-group-text"><i class="fas fa-lock"></i></span>
                                    <input type="password" class="form-control @error('password') is-invalid @enderror" 
                                           id="registerPassword" name="password" required>
                                    <button class="btn btn-outline-secondary" type="button" onclick="togglePassword('registerPassword')">
                                        <i class="fas fa-eye"></i>
                                    </button>
                                    @error('password')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>

                            <div class="mb-3">
                                <label for="password_confirmation" class="form-label">Şifre Tekrarı</label>
                                <div class="input-group">
                                    <span class="input-group-text"><i class="fas fa-lock"></i></span>
                                    <input type="password" class="form-control" id="password_confirmation" 
                                           name="password_confirmation" required>
                                    <button class="btn btn-outline-secondary" type="button" onclick="togglePassword('password_confirmation')">
                                        <i class="fas fa-eye"></i>
                                    </button>
                                </div>
                            </div>

                            <button type="submit" class="btn btn-primary w-100">
                                <i class="fas fa-user-plus"></i> Kayıt Ol
                            </button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
function togglePassword(inputId) {
    const input = document.getElementById(inputId);
    if (input.type === "password") {
        input.type = "text";
    } else {
        input.type = "password";
    }
}

// Form validation
(function () {
    'use strict'
    var forms = document.querySelectorAll('.needs-validation')
    Array.prototype.slice.call(forms).forEach(function (form) {
        form.addEventListener('submit', function (event) {
            if (!form.checkValidity()) {
                event.preventDefault()
                event.stopPropagation()
            }
            form.classList.add('was-validated')
        }, false)
    })
})()
</script>

<style>
.nav-tabs {
    border-bottom: 1px solid var(--primary-color);
}

.nav-tabs .nav-link {
    color: var(--text-color);
    border: 1px solid transparent;
    padding: 10px 18px;
    font-size: 15px;
    font-weight: 500;
    border-radius: 6px;
    transition: background-color 0.2s ease, border-color 0.2s ease;
}

.nav-tabs .nav-link.active {
    background-color: var(--primary-color);
    color: white;
    border-color: var(--primary-color);
}

.nav-tabs .nav-link:hover {
    background-color: rgba(255, 255, 255, 0.1);
    border-color: var(--primary-color);
}



.input-group-text {
    background-color: var(--secondary-bg);
    border-color: var(--primary-color);
    color: var(--text-color);
}

.form-control {
    background-color: var(--secondary-bg);
    border-color: var(--primary-color);
    color: var(--text-color);
}

.form-control:focus {
    background-color: var(--secondary-bg);
    border-color: var(--primary-color);
    color: var(--text-color);
    box-shadow: 0 0 0 0.25rem rgba(107, 70, 193, 0.25);
}

.btn-outline-secondary {
    color: var(--text-color);
    border-color: var(--primary-color);
}

.btn-outline-secondary:hover {
    background-color: var(--primary-color);
    border-color: var(--primary-color);
}
</style>
@endsection