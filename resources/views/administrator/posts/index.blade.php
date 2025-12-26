@extends('layouts.administrator')

@section('title', 'Kelola Artikel')

@section('page-title', 'Kelola Artikel')

@section('breadcrumb')
    <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Home</a></li>
    <li class="breadcrumb-item active">Artikel</li>
@endsection

@section('content')
<div class="row">
    <div class="col-md-12">
        <div class="card">
            <div class="card-header">
                <h3 class="card-title">Daftar Artikel</h3>
                <div class="card-tools">
                    <a href="{{ route('admin.posts.create') }}" class="btn btn-primary btn-sm">
                        <i class="fas fa-plus"></i> Tambah Artikel
                    </a>
                </div>
            </div>
            
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-bordered table-striped">
                        <thead>
                            <tr>
                                <th width="5%">No</th>
                                <th width="15%">Gambar</th>
                                <th width="25%">Judul</th>
                                <th width="15%">Kategori</th>
                                <th width="15%">Penulis</th>
                                <th width="10%">Tanggal</th>
                                <th width="15%">Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($posts as $index => $post)
                                <tr>
                                    <td>{{ $posts->firstItem() + $index }}</td>
                                    <td>
                                        @if($post->thumbimage)
                                            <img src="{{ asset('storage/images/' . $post->thumbimage) }}" 
                                                 alt="{{ $post->judul }}" 
                                                 class="img-thumbnail"
                                                 style="max-width: 100px;"
                                                 onerror="this.src='{{ asset('adminlte/dist/img/default-150x150.png') }}'">
                                        @else
                                            <img src="{{ asset('adminlte/dist/img/default-150x150.png') }}" 
                                                 alt="No Image" 
                                                 class="img-thumbnail"
                                                 style="max-width: 100px;">
                                        @endif
                                    </td>
                                    <td>
                                        <strong>{{ $post->judul }}</strong>
                                        <br>
                                        <small class="text-muted">{{ Str::limit($post->excerpt, 50) }}</small>
                                    </td>
                                    <td>
                                        @switch($post->kategori)
                                            @case(1)
                                                <span class="badge badge-info">Berita</span>
                                                @break
                                            @case(2)
                                                <span class="badge badge-warning">Politik</span>
                                                @break
                                            @case(3)
                                                <span class="badge badge-success">Olahraga</span>
                                                @break
                                            @case(4)
                                                <span class="badge badge-primary">Teknologi</span>
                                                @break
                                            @case(5)
                                                <span class="badge badge-danger">Hiburan</span>
                                                @break
                                            @default
                                                <span class="badge badge-secondary">Uncategorized</span>
                                        @endswitch
                                    </td>
                                    <td>{{ $post->user->name }}</td>
                                    <td>{{ $post->created_at->format('d/m/Y') }}</td>
                                    <td>
                                        <div class="btn-group" role="group">
                                            <a href="{{ route('admin.posts.edit', $post->id) }}" 
                                               class="btn btn-warning btn-sm" 
                                               title="Edit">
                                                <i class="fas fa-edit"></i>
                                            </a>
                                            <form action="{{ route('admin.posts.destroy', $post->id) }}" 
                                                  method="POST" 
                                                  class="d-inline"
                                                  onsubmit="return confirm('Yakin ingin menghapus artikel ini?')">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" 
                                                        class="btn btn-danger btn-sm" 
                                                        title="Hapus">
                                                    <i class="fas fa-trash"></i>
                                                </button>
                                            </form>
                                        </div>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="7" class="text-center">
                                        <p class="text-muted my-3">Belum ada artikel</p>
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
            
            <div class="card-footer">
                {{ $posts->links() }}
            </div>
        </div>
    </div>
</div>
@endsection