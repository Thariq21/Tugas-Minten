<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $post->judul }} - Portal Berita</title>
    
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    
    <style>
        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background-color: #f8f9fa;
        }
        .navbar {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            box-shadow: 0 2px 10px rgba(0,0,0,0.1);
        }
        .article-header {
            background: white;
            padding: 40px 0;
            border-radius: 15px;
            margin-bottom: 30px;
        }
        .article-title {
            font-size: 2.5rem;
            font-weight: bold;
            color: #333;
            margin-bottom: 20px;
        }
        .article-meta {
            color: #666;
            font-size: 0.95rem;
        }
        .article-image {
            width: 100%;
            max-height: 500px;
            object-fit: cover;
            border-radius: 15px;
            margin-bottom: 20px;
        }
        .article-content {
            background: white;
            padding: 40px;
            border-radius: 15px;
            line-height: 1.8;
            font-size: 1.1rem;
        }
        .article-content img {
            max-width: 100%;
            height: auto;
            border-radius: 10px;
            margin: 20px 0;
        }
        .related-articles {
            background: white;
            padding: 30px;
            border-radius: 15px;
            margin-top: 40px;
        }
        .related-card {
            border: 1px solid #e0e0e0;
            border-radius: 10px;
            overflow: hidden;
            transition: transform 0.3s ease;
        }
        .related-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 5px 20px rgba(0,0,0,0.1);
        }
        .related-image {
            width: 100%;
            height: 150px;
            object-fit: cover;
        }
        .footer {
            background-color: #2c3e50;
            color: white;
            padding: 30px 0;
            margin-top: 60px;
        }
    </style>
</head>
<body>

    <!-- Navbar -->
    <nav class="navbar navbar-expand-lg navbar-dark">
        <div class="container">
            <a class="navbar-brand fw-bold fs-4" href="{{ route('home') }}">
                📰 Portal Berita
            </a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav ms-auto">
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('home') }}">Beranda</a>
                    </li>
                    @auth
                        <li class="nav-item">
                            <a class="nav-link" href="{{ route('admin.dashboard') }}">Dashboard Admin</a>
                        </li>
                        <li class="nav-item">
                            <form method="POST" action="{{ route('logout') }}" class="d-inline">
                                @csrf
                                <button type="submit" class="btn btn-link nav-link">Logout</button>
                            </form>
                        </li>
                    @else
                        <li class="nav-item">
                            <a class="nav-link" href="{{ route('login') }}">Login</a>
                        </li>
                    @endauth
                </ul>
            </div>
        </div>
    </nav>

    <!-- Content -->
    <div class="container mt-5">
        <div class="row">
            <div class="col-lg-8 mx-auto">
                <!-- Article Header -->
                <div class="article-header">
                    <div class="px-4">
                        <!-- Category Badge -->
                        @switch($post->kategori)
                            @case(1)
                                <span class="badge bg-info mb-3">Berita</span>
                                @break
                            @case(2)
                                <span class="badge bg-warning text-dark mb-3">Politik</span>
                                @break
                            @case(3)
                                <span class="badge bg-success mb-3">Olahraga</span>
                                @break
                            @case(4)
                                <span class="badge bg-primary mb-3">Teknologi</span>
                                @break
                            @case(5)
                                <span class="badge bg-danger mb-3">Hiburan</span>
                                @break
                        @endswitch

                        <!-- Title -->
                        <h1 class="article-title">{{ $post->judul }}</h1>

                        <!-- Meta Info -->
                        <div class="article-meta d-flex gap-3 mb-3">
                            <span>
                                <i class="bi bi-person-fill"></i> 
                                <strong>{{ $post->user->name }}</strong>
                            </span>
                            <span>
                                <i class="bi bi-calendar-fill"></i> 
                                {{ $post->created_at->format('d F Y') }}
                            </span>
                            <span>
                                <i class="bi bi-clock-fill"></i> 
                                {{ $post->created_at->format('H:i') }} WIB
                            </span>
                        </div>

                        <!-- Excerpt -->
                        @if($post->excerpt)
                            <p class="lead text-muted">{{ $post->excerpt }}</p>
                        @endif
                    </div>
                </div>

                <!-- Featured Image -->
                @if($post->bigimage)
                    <figure class="mb-4">
                        <img src="{{ asset('storage/images/' . $post->bigimage) }}" 
                             class="article-image shadow-sm" 
                             alt="{{ $post->judul }}"
                             onerror="this.src='https://via.placeholder.com/800x500?text=No+Image'">
                        @if($post->figcaption)
                            <figcaption class="text-center text-muted mt-2">
                                <small>{{ $post->figcaption }}</small>
                            </figcaption>
                        @endif
                    </figure>
                @endif

                <!-- Article Content -->
                <div class="article-content shadow-sm">
                    {!! $post->body !!}
                </div>

                <!-- Share Buttons -->
                <div class="text-center mt-4">
                    <a href="{{ route('home') }}" class="btn btn-outline-primary">
                        ← Kembali ke Beranda
                    </a>
                </div>

                <!-- Related Articles -->
                @if($relatedPosts->count() > 0)
                    <div class="related-articles shadow-sm">
                        <h3 class="mb-4">Artikel Terkait</h3>
                        <div class="row">
                            @foreach($relatedPosts as $related)
                                <div class="col-md-4 mb-3">
                                    <div class="related-card">
                                        @if($related->thumbimage)
                                            <img src="{{ asset('storage/images/' . $related->thumbimage) }}" 
                                                 class="related-image" 
                                                 alt="{{ $related->judul }}"
                                                 onerror="this.src='https://via.placeholder.com/300x150?text=No+Image'">
                                        @else
                                            <img src="https://via.placeholder.com/300x150?text=No+Image" 
                                                 class="related-image" 
                                                 alt="No Image">
                                        @endif
                                        <div class="p-3">
                                            <h6>
                                                <a href="{{ route('artikel.detail', $related->slug) }}" 
                                                   class="text-decoration-none text-dark">
                                                    {{ Str::limit($related->judul, 50) }}
                                                </a>
                                            </h6>
                                            <small class="text-muted">
                                                {{ $related->created_at->diffForHumans() }}
                                            </small>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </div>
                @endif
            </div>
        </div>
    </div>

    <!-- Footer -->
    <footer class="footer text-center">
        <div class="container">
            <p class="mb-0">&copy; {{ date('Y') }} Portal Berita. All Rights Reserved.</p>
            <p class="mb-0 mt-2">
                <small>Dibuat dengan ❤️ menggunakan Laravel 10</small>
            </p>
        </div>
    </footer>

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>