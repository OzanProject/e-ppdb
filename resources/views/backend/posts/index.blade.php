@extends('backend.layouts.app')

@section('content')
<div class="container-fluid pt-4 px-4">
    <div class="row g-4">
        <div class="col-12">
            <div class="bg-secondary rounded h-100 p-4">
                <div class="d-flex justify-content-between align-items-center mb-4">
                    <h6 class="mb-0">Manajemen Berita / Artikel</h6>
                    <a href="{{ route('admin.posts.create') }}" class="btn btn-primary btn-sm"><i class="fa fa-plus me-2"></i>Tambah Berita</a>
                </div>

                @if(session('success'))
                    <div class="alert alert-success alert-dismissible fade show" role="alert">
                        {{ session('success') }}
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>
                @endif

                <div class="table-responsive">
                    <table class="table table-hover">
                        <thead>
                            <tr>
                                <th scope="col">#</th>
                                <th scope="col">Gambar</th>
                                <th scope="col">Judul</th>
                                <th scope="col">Penulis</th>
                                <th scope="col">Status</th>
                                <th scope="col">Tanggal</th>
                                <th scope="col">Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($posts as $post)
                            <tr>
                                <th scope="row">{{ $loop->iteration }}</th>
                                <td>
                                    @if($post->image && Storage::disk('public')->exists($post->image))
                                        <img src="{{ asset('storage/' . $post->image) }}" alt="Thumbnail" style="width: 50px; height: 50px; object-fit: cover;" class="rounded">
                                    @else
                                        <span class="text-muted">No IMG</span>
                                    @endif
                                </td>
                                <td>
                                    <div class="fw-bold">{{ Str::limit($post->title, 40) }}</div>
                                    <small class="text-muted">/{{ $post->slug }}</small>
                                </td>
                                <td>{{ $post->author->name ?? 'Unknown' }}</td>
                                <td>
                                    @if($post->is_published)
                                        <span class="badge bg-success">Published</span>
                                    @else
                                        <span class="badge bg-warning">Draft</span>
                                    @endif
                                </td>
                                <td>{{ $post->created_at->format('d M Y') }}</td>
                                <td>
                                    <a href="{{ route('admin.posts.edit', $post) }}" class="btn btn-sm btn-info me-1"><i class="fa fa-edit"></i></a>
                                    <form action="{{ route('admin.posts.destroy', $post) }}" method="POST" class="d-inline" onsubmit="return confirm('Yakin ingin menghapus berita ini?');">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-sm btn-danger"><i class="fa fa-trash"></i></button>
                                    </form>
                                </td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="7" class="text-center py-4">Belum ada berita.</td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
                
                <div class="mt-3">
                    {{ $posts->links() }}
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
