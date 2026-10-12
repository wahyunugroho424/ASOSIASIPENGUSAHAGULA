@extends('admin.layouts.app')

@section('title', 'Tambah Anggota')
@section('page-title', 'Tambah Anggota APGI')

@push('styles')
<style>
    .logo-preview-box {
        width: 160px;
        height: 120px;
        border: 2px dashed #dee2e6;
        border-radius: 10px;
        display: flex;
        align-items: center;
        justify-content: center;
        background: #f8f9fa;
        overflow: hidden;
        transition: border-color 0.2s;
    }
    .logo-preview-box img {
        max-width: 100%;
        max-height: 100%;
        object-fit: contain;
    }
    .logo-preview-box.has-image {
        border-style: solid;
        border-color: #198754;
    }
    .style-option {
        cursor: pointer;
        border: 2px solid #dee2e6;
        border-radius: 8px;
        padding: 10px;
        transition: all 0.2s;
    }
    .style-option:hover,
    .style-option.selected {
        border-color: #198754;
        background: #e9f7ef;
    }
    .style-option input[type="radio"] { display: none; }
</style>
@endpush

@section('content')

<div class="d-flex align-items-center gap-2 mb-4">
    <a href="{{ route('admin.member.index') }}" class="btn btn-outline-secondary btn-sm">
        <i class="bi bi-arrow-left"></i>
    </a>
    <span class="text-muted">Kembali ke daftar anggota</span>
</div>

<div class="row">
    <div class="col-lg-8">
        <form action="{{ route('admin.member.store') }}" method="POST" enctype="multipart/form-data">
            @csrf

            <div class="card mb-4">
                <div class="card-header">
                    <h6 class="mb-0"><i class="bi bi-info-circle me-2"></i>Informasi Anggota</h6>
                </div>
                <div class="card-body">

                    {{-- Nama --}}
                    <div class="mb-4">
                        <label class="form-label fw-semibold">Nama Perusahaan <span class="text-danger">*</span></label>
                        <input type="text" name="name" class="form-control @error('name') is-invalid @enderror"
                               value="{{ old('name') }}" placeholder="Contoh: PT Fajar Mulia Transindo" required>
                        @error('name')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    {{-- Logo --}}
                    <div class="mb-4">
                        <label class="form-label fw-semibold">Logo Perusahaan</label>
                        <div class="d-flex align-items-start gap-3">
                            <div class="logo-preview-box" id="preview-box">
                                <span class="text-muted small text-center px-2" id="preview-placeholder">
                                    <i class="bi bi-image d-block fs-3 mb-1"></i>
                                    Preview logo
                                </span>
                                <img id="logo-preview" src="" alt="" style="display:none">
                            </div>
                            <div class="flex-grow-1">
                                <input type="file" name="logo" id="logo-input"
                                       class="form-control @error('logo') is-invalid @enderror"
                                       accept="image/png,image/jpg,image/jpeg,image/svg+xml,image/webp"
                                       onchange="previewLogo(this)">
                                <div class="form-text">PNG, JPG, SVG, atau WEBP. Maks 2MB.</div>
                                @error('logo')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                    </div>

                    {{-- Urutan --}}
                    <div class="mb-4">
                        <label class="form-label fw-semibold">Urutan Tampil</label>
                        <input type="number" name="sort_order" class="form-control" 
                               value="{{ old('sort_order', 0) }}" min="0" style="max-width:120px">
                        <div class="form-text">Semakin kecil angka, semakin awal tampil. Bisa diubah dengan drag-drop di halaman daftar.</div>
                    </div>

                    {{-- Status --}}
                    <div class="mb-3">
                        <label class="form-label fw-semibold">Status</label>
                        <div class="form-check form-switch">
                            <input class="form-check-input" type="checkbox" role="switch" 
                                   name="is_active" id="is_active" value="1"
                                   {{ old('is_active', true) ? 'checked' : '' }}>
                            <label class="form-check-label" for="is_active">
                                Aktif (tampil di website)
                            </label>
                        </div>
                    </div>

                </div>
            </div>

            {{-- Style Card --}}
            <div class="card mb-4">
                <div class="card-header">
                    <h6 class="mb-0"><i class="bi bi-palette me-2"></i>Tampilan Kartu</h6>
                </div>
                <div class="card-body">

                    {{-- Logo Size --}}
                    <div>
                        <label class="form-label fw-semibold">Ukuran Logo</label>
                        <div class="row g-2">
                            @foreach($logoSizes as $value => $label)
                            <div class="col-md-6">
                                <label class="style-option w-100 text-center {{ old('logo_size', 'member-large-logo') === $value ? 'selected' : '' }}">
                                    <input type="radio" name="logo_size" value="{{ $value }}"
                                           {{ old('logo_size', 'member-large-logo') === $value ? 'checked' : '' }}
                                           onchange="selectStyle(this)">
                                    <i class="bi bi-image{{ $value === 'member-large-logo' ? '' : '-fill' }} d-block fs-4 mb-1 text-secondary"></i>
                                    <div class="small">{{ $label }}</div>
                                </label>
                            </div>
                            @endforeach
                        </div>
                        @error('logo_size')
                            <div class="text-danger small mt-1">{{ $message }}</div>
                        @enderror
                    </div>

                </div>
            </div>

            <div class="d-flex gap-2">
                <button type="submit" class="btn btn-primary px-4">
                    <i class="bi bi-check-lg me-1"></i> Simpan Anggota
                </button>
                <a href="{{ route('admin.member.index') }}" class="btn btn-outline-secondary">
                    Batal
                </a>
            </div>

        </form>
    </div>

    {{-- Tips Sidebar --}}
    <div class="col-lg-4">
        <div class="card border-0 bg-light">
            <div class="card-body">
                <h6 class="fw-bold mb-3"><i class="bi bi-lightbulb text-warning me-2"></i>Tips</h6>
                <ul class="small text-muted mb-0 ps-3">
                    <li class="mb-2">Gunakan logo dengan latar belakang transparan (PNG) untuk tampilan terbaik.</li>
                    <li class="mb-2">Anggota dengan status <strong>Nonaktif</strong> tidak akan tampil di halaman utama website.</li>
                    <li class="mb-2">Urutan tampil dapat diubah dengan drag-drop di halaman daftar anggota.</li>
                    <li>Maksimal 3 anggota per baris di tampilan website.</li>
                </ul>
            </div>
        </div>
    </div>
</div>

@endsection

@push('scripts')
<script>
    function previewLogo(input) {
        const preview = document.getElementById('logo-preview');
        const placeholder = document.getElementById('preview-placeholder');
        const box = document.getElementById('preview-box');

        if (input.files && input.files[0]) {
            const reader = new FileReader();
            reader.onload = e => {
                preview.src = e.target.result;
                preview.style.display = 'block';
                placeholder.style.display = 'none';
                box.classList.add('has-image');
            };
            reader.readAsDataURL(input.files[0]);
        }
    }

    function selectStyle(radio) {
        // Hilangkan 'selected' dari semua option dalam grup yang sama
        radio.closest('.row').querySelectorAll('.style-option').forEach(el => {
            el.classList.remove('selected');
        });
        radio.closest('.style-option').classList.add('selected');
    }
</script>
@endpush