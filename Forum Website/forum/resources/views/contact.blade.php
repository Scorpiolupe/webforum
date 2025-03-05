@extends('layout')

@section('title', 'İletişim')

@section('content')
<div class="row justify-content-center">
    <div class="col-md-8">
        <div class="card">
            <div class="card-header">
                <h3 class="mb-0"><i class="fas fa-envelope"></i> Bizimle İletişime Geçin</h3>
            </div>
            <div class="card-body">
                @if(session('success'))
                    <div class="alert alert-success">
                        {{ session('success') }}
                    </div>
                @endif

                <form action="{{ route('contact.send') }}" method="POST">
                    @csrf
                    <div class="mb-3">
                        <label for="name" class="form-label">Ad Soyad</label>
                        <input type="text" class="form-control bg-dark text-light" id="name" name="name" required>
                    </div>

                    <div class="mb-3">
                        <label for="email" class="form-label">E-posta Adresi</label>
                        <input type="email" class="form-control bg-dark text-light" id="email" name="email" required>
                    </div>

                    <div class="mb-3">
                        <label for="subject" class="form-label">Konu</label>
                        <input type="text" class="form-control bg-dark text-light" id="subject" name="subject" required>
                    </div>

                    <div class="mb-3">
                        <label for="message" class="form-label">Mesajınız</label>
                        <textarea class="form-control bg-dark text-light" id="message" name="message" rows="5" required></textarea>
                    </div>

                    <button type="submit" class="btn btn-primary">
                        <i class="fas fa-paper-plane"></i> Mesaj Gönder
                    </button>
                </form>
            </div>
        </div>

        <div class="card mt-4">
            <div class="card-body">
                <h4><i class="fas fa-map-marker-alt"></i> Adres</h4>
                <p>İstanbul, Türkiye</p>

                <h4><i class="fas fa-phone"></i> Telefon</h4>
                <p>+90 (212) XXX XX XX</p>

                <h4><i class="fas fa-envelope"></i> E-posta</h4>
                <p>info@forum.com</p>
            </div>
        </div>
    </div>
</div>
@endsection