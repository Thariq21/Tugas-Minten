<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Portal Berita - Beranda</title>
    
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
        .article-card {
            transition: transform 0.3s ease, box-shadow 0.3s ease;
            border: none;
            border-radius: 15px;
            overflow: hidden;
            margin-bottom: 30px;
        }
        .article-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 10px 30px rgba(0,0,0,0.15);
        }
        .article-image {
            width: 100%;
            height: 250px;
            object-fit: cover;
        }
        .category-badge {
            position: absolute;
            top: 15px;
            right: 15px;
            z-index: 10;
        }
        .article-title {
            font-size: 1.3rem;
            font-weight: bold;
            color: #333;
            margin-bottom: 10px;
        }
        .article-excerpt {
            color: #666;
            font-size: 0.95rem;
            line-height: 1.6;
        }
        .hero-section {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: white;
            padding: 60px 0;
            margin-bottom: 40px;
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
                        <a class="nav-link active" href="{{ route('home') }}">Beranda</a>
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
                        <li class="nav-item">
                            <a class="nav-link" href="{{ route('register') }}">Register</a>
                        </li>
                    @endauth
                </ul>
            </div>
        </div>
    </nav>

    <!-- Hero Section -->
    <div class="hero-section text-center">
        <div class="container">
            <h1 class="display-4 fw-bold mb-3">Selamat Datang di Portal Berita</h1>
            <p class="lead">Berita terkini dan terpercaya untuk Anda</p>
        </div>
    </div>

    <!-- Content -->
    <div class="container">
        <div class="row">
            @forelse($posts as $post)
                <div class="col-md-4">
                    <div class="card article-card shadow-sm">
                        <!-- Category Badge -->
                        <div class="category-badge">
                            @switch($post->kategori)
                                @case(1)
                                    <span class="badge bg-info">Berita</span>
                                    @break
                                @case(2)
                                    <span class="badge bg-warning text-dark">Politik</span>
                                    @break
                                @case(3)
                                    <span class="badge bg-success">Olahraga</span>
                                    @break
                                @case(4)
                                    <span class="badge bg-primary">Teknologi</span>
                                    @break
                                @case(5)
                                    <span class="badge bg-danger">Hiburan</span>
                                    @break
                                @default
                                    <span class="badge bg-secondary">Lainnya</span>
                            @endswitch
                        </div>

                        <!-- Image -->
                        @if($post->thumbimage)
                            <img src="{{ asset('storage/images/' . $post->thumbimage) }}" 
                                 class="article-image" 
                                 alt="{{ $post->judul }}"
                                 onerror="this.src='https://via.placeholder.com/400x250?text=No+Image'">
                        @else
                            <img src="https://via.placeholder.com/400x250?text=No+Image" 
                                 class="article-image" 
                                 alt="No Image">
                        @endif

                        <div class="card-body">
                            <!-- Title -->
                            <h5 class="article-title">
                                <a href="{{ route('artikel.detail', $post->slug) }}" 
                                   class="text-decoration-none text-dark">
                                    {{ $post->judul }}
                                </a>
                            </h5>

                            <!-- Excerpt -->
                            <p class="article-excerpt">
                                {{ Str::limit($post->excerpt ?? strip_tags($post->body), 120) }}
                            </p>

                            <!-- Meta Info -->
                            <div class="d-flex justify-content-between align-items-center mt-3">
                                <small class="text-muted">
                                    <i class="bi bi-person"></i> {{ $post->user->name }}
                                </small>
                                <small class="text-muted">
                                    {{ $post->created_at->diffForHumans() }}
                                </small>
                            </div>

                            <!-- Read More Button -->
                            <a href="{{ route('artikel.detail', $post->slug) }}" 
                               class="btn btn-outline-primary btn-sm mt-3 w-100">
                                Baca Selengkapnya →
                            </a>
                        </div>
                    </div>
                </div>
            @empty
                <div class="col-12">
                    <div class="alert alert-info text-center" role="alert">
                        <h4>Belum Ada Artikel</h4>
                        <p>Saat ini belum ada artikel yang dipublikasikan.</p>
                        @auth
                            <a href="{{ route('admin.posts.create') }}" class="btn btn-primary">
                                Tambah Artikel Pertama
                            </a>
                        @endauth
                    </div>
                </div>
            @endforelse
        </div>

        <!-- Pagination -->
        <div class="d-flex justify-content-center mt-4">
            {{ $posts->links() }}
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