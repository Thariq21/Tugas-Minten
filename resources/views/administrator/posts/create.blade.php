@extends('layouts.administrator')

@section('title', 'Tambah Artikel Baru')

@section('page-title', 'Tambah Artikel')

@section('breadcrumb')
    <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Home</a></li>
    <li class="breadcrumb-item"><a href="{{ route('admin.posts.index') }}">Artikel</a></li>
    <li class="breadcrumb-item active">Tambah Baru</li>
@endsection

@section('content')
<div class="row">
    <div class="col-md-12">
        <div class="card card-primary">
            <div class="card-header">
                <h3 class="card-title">Form Artikel Baru</h3>
            </div>
            
            <form action="{{ route('admin.posts.store') }}" method="POST" enctype="multipart/form-data">
                @csrf
                
                <div class="card-body">
                    <!-- Judul -->
                    <div class="form-group">
                        <label for="judul">Judul Artikel <span class="text-danger">*</span></label>
                        <input type="text" 
                               class="form-control @error('judul') is-invalid @enderror" 
                               id="judul" 
                               name="judul" 
                               value="{{ old('judul') }}"
                               placeholder="Masukkan judul artikel" 
                               required>
                        @error('judul')
                            <span class="invalid-feedback">{{ $message }}</span>
                        @enderror
                    </div>

                    <!-- Kategori -->
                    <div class="form-group">
                        <label for="kategori">Kategori</label>
                        <select class="form-control @error('kategori') is-invalid @enderror" 
                                id="kategori" 
                                name="kategori">
                            <option value="">-- Pilih Kategori --</option>
                            <option value="1" {{ old('kategori') == '1' ? 'selected' : '' }}>Berita</option>
                            <option value="2" {{ old('kategori') == '2' ? 'selected' : '' }}>Politik</option>
                            <option value="3" {{ old('kategori') == '3' ? 'selected' : '' }}>Olahraga</option>
                            <option value="4" {{ old('kategori') == '4' ? 'selected' : '' }}>Teknologi</option>
                            <option value="5" {{ old('kategori') == '5' ? 'selected' : '' }}>Hiburan</option>
                        </select>
                        @error('kategori')
                            <span class="invalid-feedback">{{ $message }}</span>
                        @enderror
                    </div>

                    <!-- Excerpt -->
                    <div class="form-group">
                        <label for="excerpt">Ringkasan (Excerpt)</label>
                        <textarea class="form-control @error('excerpt') is-invalid @enderror" 
                                  id="excerpt" 
                                  name="excerpt" 
                                  rows="3"
                                  placeholder="Masukkan ringkasan singkat artikel (opsional)">{{ old('excerpt') }}</textarea>
                        @error('excerpt')
                            <span class="invalid-feedback">{{ $message }}</span>
                        @enderror
                        <small class="form-text text-muted">Ringkasan akan ditampilkan di halaman daftar artikel</small>
                    </div>

                    <!-- Body (Summernote) -->
                    <div class="form-group">
                        <label for="summernote">Isi Artikel <span class="text-danger">*</span></label>
                        <textarea id="summernote" 
                                  name="body" 
                                  class="form-control @error('body') is-invalid @enderror"
                                  required>{{ old('body') }}</textarea>
                        @error('body')
                            <span class="invalid-feedback d-block">{{ $message }}</span>
                        @enderror
                    </div>

                    <!-- Upload Gambar -->
                    <div class="form-group">
                        <label for="bigimage">Gambar Artikel <span class="text-danger">*</span></label>
                        <div class="input-group">
                            <div class="custom-file">
                                <input type="file" 
                                       class="custom-file-input @error('bigimage') is-invalid @enderror" 
                                       id="bigimage" 
                                       name="bigimage"
                                       accept="image/*"
                                       onchange="previewImage(event)"
                                       required>
                                <label class="custom-file-label" for="bigimage">Pilih gambar</label>
                            </div>
                        </div>
                        @error('bigimage')
                            <span class="invalid-feedback d-block">{{ $message }}</span>
                        @enderror
                        <small class="form-text text-muted">Format: JPG, PNG, GIF (Max: 2MB)</small>
                        
                        <!-- Preview Gambar -->
                        <div class="mt-3" id="imagePreview" style="display: none;">
                            <img src="" alt="Preview" class="img-thumbnail" style="max-width: 300px;">
                        </div>
                    </div>

                    <!-- Figure Caption -->
                    <div class="form-group">
                        <label for="figcaption">Keterangan Gambar <span class="text-danger">*</span></label>
                        <input type="text" 
                               class="form-control @error('figcaption') is-invalid @enderror" 
                               id="figcaption" 
                               name="figcaption" 
                               value="{{ old('figcaption') }}"
                               placeholder="Contoh: Foto oleh John Doe"
                               required>
                        @error('figcaption')
                            <span class="invalid-feedback">{{ $message }}</span>
                        @enderror
                    </div>
                </div>

                <div class="card-footer">
                    <button type="submit" class="btn btn-primary">
                        <i class="fas fa-save"></i> Simpan Artikel
                    </button>
                    <a href="{{ route('admin.posts.index') }}" class="btn btn-secondary">
                        <i class="fas fa-times"></i> Batal
                    </a>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
    // Preview gambar sebelum upload
    function previewImage(event) {
        const reader = new FileReader();
        reader.onload = function(){
            const preview = document.getElementById('imagePreview');
            const img = preview.querySelector('img');
            img.src = reader.result;
            preview.style.display = 'block';
        };
        reader.readAsDataURL(event.target.files[0]);
        
        // Update label dengan nama file
        const fileName = event.target.files[0].name;
        const label = event.target.nextElementSibling;
        label.textContent = fileName;
    }
</script>
@endpush