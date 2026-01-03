@extends('backend.layouts.app')

@section('content')
<div class="container-fluid pt-4 px-4">
    <div class="bg-secondary rounded p-4">
        <div class="d-flex align-items-center justify-content-between mb-4">
            <h6 class="mb-0">Edit Sekolah</h6>
            <a href="{{ route('admin.schools.index') }}" class="btn btn-sm btn-primary">Kembali</a>
        </div>
        <form action="{{ route('admin.schools.update', $school->id) }}" method="POST" enctype="multipart/form-data">
            @csrf
            @method('PUT')
            
            <div class="row">
                <div class="col-md-6 mb-3">
                    <label for="name" class="form-label">Nama Sekolah</label>
                    <input type="text" class="form-control" id="name" name="name" value="{{ $school->name }}" required>
                </div>

                <div class="col-12 mb-3">
                    <label for="description" class="form-label">Deskripsi Singkat (Footer)</label>
                    <textarea class="form-control" id="description" name="description" rows="2">{{ $school->description }}</textarea>
                    <small class="text-muted">Ditampilkan di footer halaman depan.</small>
                </div>

                <div class="col-md-6 mb-3">
                    <label for="jenjang" class="form-label">Jenjang</label>
                    <select class="form-select" id="jenjang" name="jenjang" required>
                        <option value="sd" {{ $school->jenjang == 'sd' ? 'selected' : '' }}>SD</option>
                        <option value="smp" {{ $school->jenjang == 'smp' ? 'selected' : '' }}>SMP</option>
                        <option value="sma" {{ $school->jenjang == 'sma' ? 'selected' : '' }}>SMA</option>
                        <option value="smk" {{ $school->jenjang == 'smk' ? 'selected' : '' }}>SMK</option>
                    </select>
                </div>

                <div class="col-md-6 mb-3">
                    <label for="accreditation" class="form-label">Akreditasi</label>
                    <select class="form-select" id="accreditation" name="accreditation">
                        <option value="" {{ $school->accreditation == '' ? 'selected' : '' }}>- Belum Ada -</option>
                        <option value="A" {{ $school->accreditation == 'A' ? 'selected' : '' }}>A (Unggul)</option>
                        <option value="B" {{ $school->accreditation == 'B' ? 'selected' : '' }}>B (Baik)</option>
                        <option value="C" {{ $school->accreditation == 'C' ? 'selected' : '' }}>C (Cukup)</option>
                        <option value="TT" {{ $school->accreditation == 'TT' ? 'selected' : '' }}>Belum Terakreditasi</option>
                    </select>
                </div>

                <div class="col-md-6 mb-3">
                    <label for="tahun_ajaran" class="form-label">Tahun Ajaran</label>
                    <input type="text" class="form-control" id="tahun_ajaran" name="tahun_ajaran" value="{{ $school->tahun_ajaran }}" required>
                </div>

                <div class="mb-4">
                    <label for="logo" class="form-label">Logo Sekolah</label>
                    <input type="file" class="form-control" id="logo" name="logo" accept="image/*">
                    @if($school->logo)
                        <div class="mt-2">
                            <img src="{{ asset('storage/' . $school->logo) }}" alt="Logo" class="img-thumbnail" width="100">
                        </div>
                    @endif
                </div>

                <div class="mb-4">
                    <label for="hero_image" class="form-label">Gambar Hero (Halaman Depan)</label>
                    <input type="file" class="form-control" id="hero_image" name="hero_image" accept="image/*">
                    <small class="text-muted">Rekomendasi ukuran: 1920x1080px atau Landscape.</small>
                    @if($school->hero_image)
                        <div class="mt-2">
                            <img src="{{ asset('storage/' . $school->hero_image) }}" alt="Hero Image" class="img-thumbnail" width="200">
                        </div>
                    @endif
                </div>

                <div class="col-12 mb-3">
                    <label for="alamat" class="form-label">Alamat Lengkap</label>
                    <textarea class="form-control" id="alamat" name="alamat" rows="3" required>{{ $school->alamat }}</textarea>
                </div>

                <div class="col-md-6 mb-3">
                    <label for="phone" class="form-label">Nomor Telepon</label>
                    <input type="text" class="form-control" id="phone" name="phone" value="{{ $school->phone }}">
                </div>

                <div class="col-md-6 mb-3">
                    <label for="email" class="form-label">Email Sekolah</label>
                    <input type="email" class="form-control" id="email" name="email" value="{{ $school->email }}">
                </div>

                <div class="col-md-6 mb-3">
                    <label for="website" class="form-label">Website</label>
                    <input type="url" class="form-control" id="website" name="website" value="{{ $school->website }}">
                </div>

                <div class="col-md-6 mb-3">
                    <!-- Spacer or other field -->
                </div>

                <div class="col-md-6 mb-3">
                    <label for="district" class="form-label">Kota / Kabupaten (Untuk Surat)</label>
                    <input type="text" class="form-control" id="district" name="district" value="{{ $school->district }}" placeholder="Contoh: Jakarta Selatan">
                </div>

                <div class="col-md-6 mb-3">
                    <!-- Spacer -->
                </div>

                <div class="col-12"><hr></div>
                <h6 class="mb-3">Media Sosial Custom</h6>
                <p class="text-sm text-gray-500 mb-3">Tambahkan akun media sosial sekolah (Facebook, Instagram, TikTok, dll).</p>

                <div id="social-media-container">
                    @php
                        $socials = old('social_media', $school->social_media ?? []);
                        // Ensure it is array
                        if(!is_array($socials)) $socials = [];
                    @endphp
                    
                    @foreach($socials as $index => $social)
                    <div class="row mb-2 social-item">
                        <div class="col-md-4">
                            <select name="social_media[{{ $index }}][platform]" class="form-select" required>
                                <option value="facebook" {{ isset($social['platform']) && $social['platform'] == 'facebook' ? 'selected' : '' }}>Facebook</option>
                                <option value="instagram" {{ isset($social['platform']) && $social['platform'] == 'instagram' ? 'selected' : '' }}>Instagram</option>
                                <option value="youtube" {{ isset($social['platform']) && $social['platform'] == 'youtube' ? 'selected' : '' }}>YouTube</option>
                                <option value="tiktok" {{ isset($social['platform']) && $social['platform'] == 'tiktok' ? 'selected' : '' }}>TikTok</option>
                                <option value="twitter" {{ isset($social['platform']) && $social['platform'] == 'twitter' ? 'selected' : '' }}>Twitter / X</option>
                                <option value="linkedin" {{ isset($social['platform']) && $social['platform'] == 'linkedin' ? 'selected' : '' }}>LinkedIn</option>
                            </select>
                        </div>
                        <div class="col-md-6">
                            <input type="url" name="social_media[{{ $index }}][url]" class="form-control" value="{{ $social['url'] ?? '' }}" placeholder="https://..." required>
                        </div>
                        <div class="col-md-2">
                            <button type="button" class="btn btn-danger btn-sm w-100 remove-social"><i class="fa fa-trash"></i></button>
                        </div>
                    </div>
                    @endforeach
                </div>

                <div class="col-12 mb-4">
                    <button type="button" id="add-social" class="btn btn-success btn-sm"><i class="fa fa-plus me-1"></i> Tambah Sosmed</button>
                    <!-- Hidden input to detect next index for JS -->
                    <input type="hidden" id="social-count" value="{{ count($socials) }}">
                </div>

                <script>
                    document.getElementById('add-social').addEventListener('click', function() {
                        const container = document.getElementById('social-media-container');
                        let index = parseInt(document.getElementById('social-count').value) || 0;
                        // Increment internal counter but relying on random or unique IDs is safer for array handling if removing items, 
                        // but since we rely on array_values in backend, sequential index is fine for submission as long as they are distinct.
                        // Actually, using Date.now() for index ensures no collision if we delete items.
                        index = Date.now(); 
                        
                        const template = `
                            <div class="row mb-2 social-item">
                                <div class="col-md-4">
                                    <select name="social_media[${index}][platform]" class="form-select" required>
                                        <option value="facebook">Facebook</option>
                                        <option value="instagram">Instagram</option>
                                        <option value="youtube">YouTube</option>
                                        <option value="tiktok">TikTok</option>
                                        <option value="twitter">Twitter / X</option>
                                        <option value="linkedin">LinkedIn</option>
                                    </select>
                                </div>
                                <div class="col-md-6">
                                    <input type="url" name="social_media[${index}][url]" class="form-control" placeholder="https://..." required>
                                </div>
                                <div class="col-md-2">
                                    <button type="button" class="btn btn-danger btn-sm w-100 remove-social"><i class="fa fa-trash"></i></button>
                                </div>
                            </div>
                        `;
                        container.insertAdjacentHTML('beforeend', template);
                    });

                    document.addEventListener('click', function(e) {
                        if (e.target && e.target.closest('.remove-social')) {
                            e.target.closest('.social-item').remove();
                        }
                    });
                </script>

                <div class="col-12"><hr></div>
                <h6 class="mb-3">Data Kepala Sekolah (Untuk Tanda Tangan Laporan)</h6>

                <div class="col-md-6 mb-3">
                    <label for="headmaster_name" class="form-label">Nama Kepala Sekolah</label>
                    <input type="text" class="form-control" id="headmaster_name" name="headmaster_name" value="{{ $school->headmaster_name }}">
                </div>

                <div class="col-md-6 mb-3">
                     <label for="headmaster_nip" class="form-label">NIP Kepala Sekolah</label>
                    <input type="text" class="form-control" id="headmaster_nip" name="headmaster_nip" value="{{ $school->headmaster_nip }}">
                </div>

                <div class="col-12 mb-3">
                    <div class="form-check">
                        <input class="form-check-input" type="checkbox" value="1" id="is_active" name="is_active" {{ $school->is_active ? 'checked' : '' }}>
                        <label class="form-check-label" for="is_active">
                            Status Aktif (Buka Pendaftaran)
                        </label>
                    </div>
                </div>
            </div>

            <button type="submit" class="btn btn-primary">Update</button>
        </form>
    </div>
</div>
@endsection
