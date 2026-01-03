@extends('backend.layouts.app')

@section('content')
<div class="container-fluid pt-4 px-4">
    <div class="row g-4">
        <div class="col-12">
            <div class="bg-secondary rounded h-100 p-4">
                <h6 class="mb-4">Tambah FAQ Baru</h6>
                
                <form action="{{ route('admin.faqs.store') }}" method="POST">
                    @csrf
                    
                    <div class="mb-3">
                        <label class="form-label">Pertanyaan</label>
                        <input type="text" class="form-control" name="question" value="{{ old('question') }}" required>
                        @error('question') <div class="text-danger small">{{ $message }}</div> @enderror
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Jawaban</label>
                        <textarea class="form-control" name="answer" rows="5" required>{{ old('answer') }}</textarea>
                        @error('answer') <div class="text-danger small">{{ $message }}</div> @enderror
                    </div>

                    <div class="row mb-3">
                        <div class="col-md-6">
                            <label class="form-label">Urutan Tampil (Angka)</label>
                            <input type="number" class="form-control bg-dark" name="order_index" value="{{ old('order_index', 0) }}">
                        </div>
                    </div>

                    <div class="form-check form-switch mb-3">
                        <input class="form-check-input" type="checkbox" id="is_active" name="is_active" value="1" {{ old('is_active', true) ? 'checked' : '' }}>
                        <label class="form-check-label" for="is_active">Status Aktif</label>
                    </div>

                    <button type="submit" class="btn btn-primary"><i class="fa fa-save me-2"></i>Simpan FAQ</button>
                    <a href="{{ route('admin.faqs.index') }}" class="btn btn-light ms-2">Batal</a>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection
