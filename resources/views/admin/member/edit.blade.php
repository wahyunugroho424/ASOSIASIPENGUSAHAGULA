@extends('admin.layouts.app')

@section('title', 'Edit Anggota')
@section('page-title', 'Edit Anggota: ' . $member->name)

@push('styles')
<style>
    .logo-preview-box {
        width: 160px;
        height: 120px;
        border: 2px solid #198754;
        border-radius: 10px;
        display: flex;
        align-items: center;
        justify-content: center;
        background: #f8f9fa;
        overflow: hidden;
    }
    .logo-preview-box img {
        max-width: 100%;
        max-height: 100%;
        object-fit: contain;
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
    .remove-logo-btn{
        position:absolute;
        top:-10px;
        right:-10px;
        width:32px;
        height:32px;
        border:none;
        border-radius:50%;
        background:#dc3545;
        color:#fff;
        font-size:22px;
        font-weight:bold;
        line-height:1;
        cursor:pointer;
        box-shadow:0 4px 10px rgba(0,0,0,.18);
        display:flex;
        align-items:center;
        justify-content:center;
        transition:.2s;
    }

.remove-logo-btn:hover{
    transform:scale(1.1);
    background:#bb2d3b;
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
        <form action="{{ route('admin.member.update', $encryptedId) }}" method="POST" enctype="multipart/form-data">
            @csrf
            @method('PUT')

            <input type="hidden" name="remove_logo" id="remove_logo" value="0">

            {{-- Informasi Anggota --}}
            <div class="card mb-4">
                <div class="card-header">
                    <h6 class="mb-0"><i class="bi bi-info-circle me-2"></i>Informasi Anggota</h6>
                </div>
                <div class="card-body">

                    {{-- Nama --}}
                    <div class="mb-4">
                        <label class="form-label fw-semibold">
                            Nama Perusahaan <span class="text-danger">*</span>
                        </label>
                        <input type="text" name="name"
                               class="form-control @error('name') is-invalid @enderror"
                               value="{{ old('name', $member->name) }}" required>
                        @error('name')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    {{-- Logo --}}
                    <div class="mb-4">
                        <label class="form-label fw-semibold">Logo Perusahaan</label>

                        <div class="d-flex align-items-start gap-3">

                            <!-- Preview -->
                            <div class="logo-preview-box position-relative">

                                <img id="logo-preview"
                                    src="{{ $member->logo_url }}"
                                    alt="{{ $member->name }}">

                                @if($member->logo)
                                <button type="button"
                                        onclick="removeLogo()"
                                        class="remove-logo-btn">
                                    ×
                                </button>
                                @endif

                            </div>

                            <!-- Input -->
                            <div class="flex-grow-1">

                                <input type="file"
                                    id="logo-input"
                                    name="logo"
                                    class="form-control @error('logo') is-invalid @enderror"
                                    accept="image/png,image/jpg,image/jpeg,image/svg+xml,image/webp"
                                    onchange="previewLogo(this)">

                                <div class="form-text">
                                    Kosongkan jika tidak ingin mengganti logo.<br>

                                    @if($member->logo)
                                        Logo saat ini:
                                        <code>{{ $member->logo }}</code>
                                    @else
                                        Saat ini menggunakan <em>placeholder</em>.
                                    @endif
                                </div>

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
                               value="{{ old('sort_order', $member->sort_order) }}"
                               min="0" style="max-width:120px">
                    </div>

                    {{-- Status --}}
                    <div class="mb-0">
                        <label class="form-label fw-semibold">Status</label>
                        <div class="form-check form-switch">
                            <input class="form-check-input" type="checkbox" role="switch"
                                   name="is_active" id="is_active" value="1"
                                   {{ old('is_active', $member->is_active) ? 'checked' : '' }}>
                            <label class="form-check-label" for="is_active">
                                Aktif (tampil di website)
                            </label>
                        </div>
                    </div>

                </div>
            </div>

            {{-- Tampilan Kartu --}}
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
                                <label class="style-option w-100 text-center
                                    {{ old('logo_size', $member->logo_size) === $value ? 'selected' : '' }}">
                                    <input type="radio" name="logo_size" value="{{ $value }}"
                                           {{ old('logo_size', $member->logo_size) === $value ? 'checked' : '' }}
                                           onchange="selectStyle(this)">
                                    <i class="bi bi-image{{ $value === 'member-large-logo' ? '' : '-fill' }} d-block fs-4 mb-1 text-secondary"></i>
                                    <div class="small">{{ $label }}</div>
                                </label>
                            </div>
                            @endforeach
                        </div>
                    </div>

                </div>
            </div>

            <div class="d-flex gap-2">
                <button type="submit" class="btn btn-primary px-4">
                    <i class="bi bi-check-lg me-1"></i> Simpan Perubahan
                </button>
                <a href="{{ route('admin.member.index') }}" class="btn btn-outline-secondary">
                    Batal
                </a>
                <button type="button" class="btn btn-outline-danger ms-auto"
                        onclick="confirmDelete('{{ addslashes($member->name) }}')">
                    <i class="bi bi-trash me-1"></i> Hapus
                </button>

            </div>

        </form>
    </div>

    {{-- Info Sidebar --}}
    <div class="col-lg-4">
        <div class="card mb-3">
            <div class="card-body">
                <h6 class="fw-bold mb-3">Info Anggota</h6>
                <dl class="row small mb-0">
                    <dt class="col-5 text-muted">Dibuat</dt>
                    <dd class="col-7">{{ $member->created_at ? $member->created_at->format('d M Y') : '-' }}</dd>
                    <dt class="col-5 text-muted">Diperbarui</dt>
                    <dd class="col-7">{{ $member->updated_at ? $member->updated_at->format('d M Y') : '-' }}</dd>
                    <dt class="col-5 text-muted">Status</dt>
                    <dd class="col-7">
                        @if($member->is_active)
                            <span class="badge bg-success">Aktif</span>
                        @else
                            <span class="badge bg-secondary">Nonaktif</span>
                        @endif
                    </dd>
                </dl>
            </div>
        </div>

        {{-- Preview Kartu --}}
        <div class="card border-0 bg-light">
            <div class="card-body">
                <h6 class="fw-bold mb-3">
                    <i class="bi bi-eye text-primary me-2"></i>Preview Kartu
                </h6>
                <div class="bg-white rounded-3 shadow p-3 text-center">
                    <img src="{{ $member->logo_url }}" alt="{{ $member->name }}"
                         class="img-fluid mb-2" style="max-height:60px;object-fit:contain">
                    <h6 class="small mb-0 fw-semibold">{{ $member->name }}</h6>
                    <p class="text-muted mb-0" style="font-size:11px">Anggota APGI</p>
                </div>
            </div>
        </div>
    </div>
</div>

{{-- Form Hapus --}}
<form id="delete-form" method="POST"
      action="{{ route('admin.member.destroy', $encryptedId) }}">
    @csrf @method('DELETE')
</form>
{{-- Modal Konfirmasi Hapus --}}
<div class="modal fade" id="deleteModal" tabindex="-1">
    <div class="modal-dialog modal-sm">
        <div class="modal-content">
            <div class="modal-header bg-danger text-white">
                <h6 class="modal-title">
                    <i class="bi bi-exclamation-triangle me-2"></i>Hapus Anggota
                </h6>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body text-center">
                <p>Hapus <strong id="delete-name"></strong>?<br>
                <small class="text-muted">Cek kembali sebelum menghapus.</</small></p>
            </div>
            <div class="modal-footer">
                <button class="btn btn-secondary btn-sm" data-bs-dismiss="modal">Batal</button>
                <button class="btn btn-danger btn-sm"
                        onclick="document.getElementById('delete-form').submit()">Hapus</button>
            </div>
        </div>
    </div>
</div>

@endsection

@push('scripts')
<script>
    function previewLogo(input) {
        if (input.files && input.files[0]) {
            const reader = new FileReader();
            reader.onload = e => {
                document.getElementById('logo-preview').src = e.target.result;
            };
            reader.readAsDataURL(input.files[0]);
        }
    }

    function removeLogo()
    {
        // preview jadi placeholder
        document.getElementById('logo-preview').src =
            "{{ asset('images/members/placeholder.png') }}";

        // kosongkan input file
        document.getElementById('logo-input').value = '';

        // tandai hapus
        document.getElementById('remove_logo').value = '1';
    }

    function selectStyle(radio) {
        radio.closest('.row').querySelectorAll('.style-option').forEach(el => {
            el.classList.remove('selected');
        });
        radio.closest('.style-option').classList.add('selected');
    }

    function confirmDelete(name) {
        document.getElementById('delete-name').textContent = name;
        new bootstrap.Modal(document.getElementById('deleteModal')).show();
    }
</script>
@endpush
