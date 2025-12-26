@extends('layouts.administrator')

@section('title', 'Dashboard')

@section('page-title', 'Dashboard')

@section('breadcrumb')
    <li class="breadcrumb-item active">Dashboard</li>
@endsection

@section('content')
<div class="row">
    <!-- Total Artikel -->
    <div class="col-lg-3 col-6">
        <div class="small-box bg-info">
            <div class="inner">
                <h3>{{ \App\Models\Post::count() }}</h3>
                <p>Total Artikel</p>
            </div>
            <div class="icon">
                <i class="fas fa-newspaper"></i>
            </div>
            <a href="{{ route('admin.posts.index') }}" class="small-box-footer">
                Lihat Detail <i class="fas fa-arrow-circle-right"></i>
            </a>
        </div>
    </div>

    <!-- Artikel Bulan Ini -->
    <div class="col-lg-3 col-6">
        <div class="small-box bg-success">
            <div class="inner">
                <h3>{{ \App\Models\Post::whereMonth('created_at', date('m'))->count() }}</h3>
                <p>Artikel Bulan Ini</p>
            </div>
            <div class="icon">
                <i class="fas fa-calendar-check"></i>
            </div>
            <a href="{{ route('admin.posts.index') }}" class="small-box-footer">
                Lihat Detail <i class="fas fa-arrow-circle-right"></i>
            </a>
        </div>
    </div>

    <!-- Total User -->
    <div class="col-lg-3 col-6">
        <div class="small-box bg-warning">
            <div class="inner">
                <h3>{{ \App\Models\User::count() }}</h3>
                <p>Total User</p>
            </div>
            <div class="icon">
                <i class="fas fa-users"></i>
            </div>
            <a href="#" class="small-box-footer">
                Info <i class="fas fa-arrow-circle-right"></i>
            </a>
        </div>
    </div>

    <!-- Artikel Hari Ini -->
    <div class="col-lg-3 col-6">
        <div class="small-box bg-danger">
            <div class="inner">
                <h3>{{ \App\Models\Post::whereDate('created_at', today())->count() }}</h3>
                <p>Artikel Hari Ini</p>
            </div>
            <div class="icon">
                <i class="fas fa-chart-line"></i>
            </div>
            <a href="{{ route('admin.posts.index') }}" class="small-box-footer">
                Lihat Detail <i class="fas fa-arrow-circle-right"></i>
            </a>
        </div>
    </div>
</div>

<!-- Artikel Terbaru -->
<div class="row">
    <div class="col-md-12">
        <div class="card">
            <div class="card-header">
                <h3 class="card-title">Artikel Terbaru</h3>
            </div>
            <div class="card-body">
                <table class="table table-striped">
                    <thead>
                        <tr>
                            <th>Judul</th>
                            <th>Kategori</th>
                            <th>Penulis</th>
                            <th>Tanggal</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach(\App\Models\Post::with('user')->latest()->take(5)->get() as $post)
                        <tr>
                            <td>{{ $post->judul }}</td>
                            <td>
                                @switch($post->kategori)
                                    @case(1) <span class="badge badge-info">Berita</span> @break
                                    @case(2) <span class="badge badge-warning">Politik</span> @break
                                    @case(3) <span class="badge badge-success">Olahraga</span> @break
                                    @case(4) <span class="badge badge-primary">Teknologi</span> @break
                                    @case(5) <span class="badge badge-danger">Hiburan</span> @break
                                    @default <span class="badge badge-secondary">-</span>
                                @endswitch
                            </td>
                            <td>{{ $post->user->name }}</td>
                            <td>{{ $post->created_at->format('d/m/Y H:i') }}</td>
                            <td>
                                <a href="{{ route('admin.posts.edit', $post->id) }}" class="btn btn-sm btn-warning">
                                    <i class="fas fa-edit"></i>
                                </a>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
@endsection