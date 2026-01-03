@extends('backend.layouts.app')

@section('content')
<div class="container-fluid pt-4 px-4">
    <div class="row g-4">
        <div class="col-12">
            <div class="bg-secondary rounded h-100 p-4">
                <h6 class="mb-4">Edit Berita</h6>
                
                <form action="{{ route('admin.posts.update', $post) }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    @method('PUT')
                    
                    <div class="mb-3">
                        <label class="form-label">Judul Berita</label>
                        <input type="text" class="form-control" name="title" value="{{ old('title', $post->title) }}" required>
                        @error('title') <div class="text-danger small">{{ $message }}</div> @enderror
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Gambar Utama</label>
                        @if($post->image && Storage::disk('public')->exists($post->image))
                            <div class="mb-2">
                                <img src="{{ asset('storage/' . $post->image) }}" alt="Current Image" class="rounded" style="max-height: 150px;">
                            </div>
                        @endif
                        <input type="file" class="form-control bg-dark" name="image" accept="image/*">
                        <div class="form-text text-muted">Biarkan kosong jika tidak ingin mengubah gambar.</div>
                        @error('image') <div class="text-danger small">{{ $message }}</div> @enderror
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Isi Berita</label>
                        <textarea class="form-control" name="content" rows="10" required>{{ old('content', $post->content) }}</textarea>
                        @error('content') <div class="text-danger small">{{ $message }}</div> @enderror
                    </div>

                    <div class="form-check form-switch mb-3">
                        <input class="form-check-input" type="checkbox" id="is_published" name="is_published" value="1" {{ old('is_published', $post->is_published) ? 'checked' : '' }}>
                        <label class="form-check-label" for="is_published">Publikasikan</label>
                    </div>

                    <button type="submit" class="btn btn-primary"><i class="fa fa-save me-2"></i>Update Berita</button>
                    <a href="{{ route('admin.posts.index') }}" class="btn btn-light ms-2">Batal</a>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection
