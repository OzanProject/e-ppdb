@extends('backend.layouts.app')

@section('content')
<div class="container-fluid pt-4 px-4">
    <div class="row g-4">
        <div class="col-12">
            <div class="bg-secondary rounded h-100 p-4">
                <div class="d-flex justify-content-between align-items-center mb-4">
                    <h6 class="mb-0">Manajemen FAQ (Tanya Jawab)</h6>
                    <a href="{{ route('admin.faqs.create') }}" class="btn btn-primary btn-sm"><i class="fa fa-plus me-2"></i>Tambah FAQ</a>
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
                                <th scope="col">Urutan</th>
                                <th scope="col">Pertanyaan</th>
                                <th scope="col">Status</th>
                                <th scope="col">Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($faqs as $faq)
                            <tr>
                                <td>{{ $faq->order_index }}</td>
                                <td>
                                    <div class="fw-bold">{{ Str::limit($faq->question, 60) }}</div>
                                    <small class="text-muted">{{ Str::limit($faq->answer, 60) }}</small>
                                </td>
                                <td>
                                    @if($faq->is_active)
                                        <span class="badge bg-success">Aktif</span>
                                    @else
                                        <span class="badge bg-danger">Non-Aktif</span>
                                    @endif
                                </td>
                                <td>
                                    <a href="{{ route('admin.faqs.edit', $faq) }}" class="btn btn-sm btn-info me-1"><i class="fa fa-edit"></i></a>
                                    <form action="{{ route('admin.faqs.destroy', $faq) }}" method="POST" class="d-inline" onsubmit="return confirm('Yakin ingin menghapus FAQ ini?');">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-sm btn-danger"><i class="fa fa-trash"></i></button>
                                    </form>
                                </td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="4" class="text-center py-4">Belum ada data FAQ.</td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
