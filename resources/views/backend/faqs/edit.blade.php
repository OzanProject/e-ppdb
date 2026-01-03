@extends('backend.layouts.app')

@section('content')
<div class="container-fluid pt-4 px-4">
    <div class="row g-4">
        <div class="col-12">
            <div class="bg-secondary rounded h-100 p-4">
                <h6 class="mb-4">Edit FAQ</h6>
                
                <form action="{{ route('admin.faqs.update', $faq) }}" method="POST">
                    @csrf
                    @method('PUT')
                    
                    <div class="mb-3">
                        <label class="form-label">Pertanyaan</label>
                        <input type="text" class="form-control" name="question" value="{{ old('question', $faq->question) }}" required>
                        @error('question') <div class="text-danger small">{{ $message }}</div> @enderror
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Jawaban</label>
                        <textarea class="form-control" name="answer" rows="5" required>{{ old('answer', $faq->answer) }}</textarea>
                        @error('answer') <div class="text-danger small">{{ $message }}</div> @enderror
                    </div>

                    <div class="row mb-3">
                        <div class="col-md-6">
                            <label class="form-label">Urutan Tampil (Angka)</label>
                            <input type="number" class="form-control bg-dark" name="order_index" value="{{ old('order_index', $faq->order_index) }}">
                        </div>
                    </div>

                    <div class="form-check form-switch mb-3">
                        <input class="form-check-input" type="checkbox" id="is_active" name="is_active" value="1" {{ old('is_active', $faq->is_active) ? 'checked' : '' }}>
                        <label class="form-check-label" for="is_active">Status Aktif</label>
                    </div>

                    <button type="submit" class="btn btn-primary"><i class="fa fa-save me-2"></i>Update FAQ</button>
                    <a href="{{ route('admin.faqs.index') }}" class="btn btn-light ms-2">Batal</a>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection
