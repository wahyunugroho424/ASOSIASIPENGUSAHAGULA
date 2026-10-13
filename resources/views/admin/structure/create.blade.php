@extends('admin.layouts.app')
@section('title', 'Tambah Struktur Organisasi')

@push('styles')
<style>
    .page-wrapper { padding: 1.5rem; }

    .breadcrumb-custom {
        display: flex; align-items: center; gap: 6px;
        font-size: 13px; color: #6c757d;
        margin-bottom: 1.25rem; list-style: none; padding: 0;
    }
    .breadcrumb-custom .sep { color: #adb5bd; }
    .breadcrumb-custom .current { color: #212529; font-weight: 500; }

    .page-header { display: flex; align-items: center; gap: 14px; margin-bottom: 1.75rem; }
    .page-icon {
        width: 44px; height: 44px; border-radius: 10px;
        background: #E1F5EE; display: flex; align-items: center;
        justify-content: center; color: #0F6E56; font-size: 20px; flex-shrink: 0;
    }
    .page-title { font-size: 20px; font-weight: 600; color: #212529; margin: 0; }
    .page-subtitle { font-size: 13px; color: #6c757d; margin: 2px 0 0; }

    .form-layout { display: grid; grid-template-columns: 1fr 340px; gap: 1.5rem; align-items: start; }

    .card-custom {
        background: #fff; border-radius: 14px; border: 1px solid #e9ecef;
        overflow: hidden; margin-bottom: 1rem;
    }
    .card-custom:last-child { margin-bottom: 0; }
    .card-section { padding: 1.25rem 1.5rem; border-bottom: 1px solid #f1f3f5; }
    .card-section:last-child { border-bottom: none; }

    .section-label {
        display: flex; align-items: center; gap: 7px;
        font-size: 11px; font-weight: 600; text-transform: uppercase;
        letter-spacing: 0.07em; color: #adb5bd; margin-bottom: 1.1rem;
    }
    .field-label { display: block; font-size: 13px; font-weight: 500; color: #495057; margin-bottom: 6px; }
    .field-label .req { color: #D85A30; margin-left: 2px; }

    .form-control-custom {
        width: 100%; height: 40px; border: 1px solid #dee2e6; border-radius: 8px;
        background: #fff; padding: 0 12px; font-size: 14px; color: #212529;
        transition: border-color .15s, box-shadow .15s; appearance: none;
    }
    .form-control-custom:focus { outline: none; border-color: #1D9E75; box-shadow: 0 0 0 3px rgba(29,158,117,.12); }
    .form-control-custom.is-invalid { border-color: #dc3545; }

    .select-wrapper { position: relative; }
    .select-wrapper::after {
        content: ''; pointer-events: none; position: absolute;
        right: 12px; top: 50%; transform: translateY(-50%);
        border: 5px solid transparent; border-top-color: #868e96; margin-top: 2px;
    }
    .select-wrapper select { padding-right: 32px; cursor: pointer; }

    .hint-text { margin-top: 5px; font-size: 12px; color: #adb5bd; display: flex; align-items: center; gap: 4px; }
    .hint-text a { color: #1D9E75; text-decoration: none; }
    .hint-text a:hover { text-decoration: underline; }

    .icon-chips { display: flex; flex-wrap: wrap; gap: 6px; margin-top: 10px; }
    .icon-chip {
        display: inline-flex; align-items: center; gap: 5px; padding: 5px 11px;
        background: #f8f9fa; border-radius: 20px; font-size: 12px; color: #495057;
        cursor: pointer; border: 1px solid #e9ecef; transition: all .15s; user-select: none;
    }
    .icon-chip:hover { border-color: #1D9E75; color: #1D9E75; background: #E1F5EE; }
    .icon-chip.active { background: #E1F5EE; border-color: #1D9E75; color: #0F6E56; font-weight: 500; }

    /* ===== Photo Upload ===== */
    .photo-upload-area {
        border: 2px dashed #dee2e6; border-radius: 12px; padding: 1.5rem;
        text-align: center; cursor: pointer; transition: all .2s; position: relative;
    }
    .photo-upload-area:hover { border-color: #1D9E75; background: #f8fffe; }
    .photo-upload-area.dragover { border-color: #1D9E75; background: #E1F5EE; }
    .photo-upload-area input[type="file"] {
        position: absolute; inset: 0; opacity: 0; cursor: pointer; width: 100%; height: 100%;
    }
    .photo-preview-wrap { position: relative; display: inline-block; }
    .photo-preview {
        width: 100px; height: 100px; border-radius: 50%; object-fit: cover;
        border: 3px solid #1D9E75; box-shadow: 0 4px 12px rgba(29,158,117,.2);
        display: block; margin: 0 auto 10px;
    }
    .photo-remove-btn {
        position: absolute; top: -4px; right: -4px;
        width: 24px; height: 24px; border-radius: 50%;
        background: #ef4444; color: #fff; border: none;
        cursor: pointer; font-size: 12px; display: flex;
        align-items: center; justify-content: center;
        box-shadow: 0 2px 6px rgba(239,68,68,.4);
    }
    .photo-upload-icon { font-size: 32px; color: #adb5bd; margin-bottom: 8px; }
    .photo-upload-text { font-size: 13px; color: #6c757d; margin-bottom: 4px; }
    .photo-upload-hint { font-size: 11px; color: #adb5bd; }

    .toggle-row {
        display: flex; align-items: center; justify-content: space-between;
        padding: 12px 0; border-bottom: 1px solid #f1f3f5;
    }
    .toggle-row:last-child { border-bottom: none; padding-bottom: 0; }
    .toggle-title { font-size: 14px; font-weight: 500; color: #212529; }
    .toggle-desc { font-size: 12px; color: #6c757d; margin-top: 2px; }

    .form-switch-custom { position: relative; width: 42px; height: 24px; flex-shrink: 0; }
    .form-switch-custom input { opacity: 0; width: 0; height: 0; position: absolute; }
    .switch-slider {
        position: absolute; inset: 0; background: #dee2e6; border-radius: 12px;
        cursor: pointer; transition: background .2s;
    }
    .switch-slider::before {
        content: ''; position: absolute;
        width: 18px; height: 18px; left: 3px; top: 3px;
        background: white; border-radius: 50%; transition: transform .2s;
        box-shadow: 0 1px 3px rgba(0,0,0,.15);
    }
    .form-switch-custom input:checked + .switch-slider { background: #1D9E75; }
    .form-switch-custom input:checked + .switch-slider::before { transform: translateX(18px); }

    .order-control { display: flex; border: 1px solid #dee2e6; border-radius: 8px; overflow: hidden; width: 120px; }
    .order-btn {
        width: 36px; height: 36px; background: #f8f9fa; border: none; cursor: pointer;
        display: flex; align-items: center; justify-content: center;
        color: #6c757d; font-size: 16px; transition: all .15s; flex-shrink: 0; font-weight: 600;
    }
    .order-btn:hover { background: #e9ecef; color: #1D9E75; }
    .order-input-num {
        flex: 1; border: none; border-left: 1px solid #dee2e6; border-right: 1px solid #dee2e6;
        text-align: center; font-size: 14px; font-weight: 600; color: #212529; background: #fff; min-width: 0;
    }
    .order-input-num:focus { outline: none; }

    /* Preview */
    .preview-card-wrap {
        background: #fff; border-radius: 14px; border: 1px solid #e9ecef;
        overflow: hidden; position: sticky; top: 1.5rem;
    }
    .preview-head {
        padding: 1rem 1.25rem; border-bottom: 1px solid #f1f3f5;
        display: flex; align-items: center; justify-content: space-between;
    }
    .preview-head-label { font-size: 11px; font-weight: 600; text-transform: uppercase; letter-spacing: .07em; color: #adb5bd; }
    .status-badge { font-size: 11px; padding: 3px 10px; border-radius: 20px; font-weight: 600; transition: all .2s; }
    .status-badge.active { background: #E1F5EE; color: #0F6E56; }
    .status-badge.inactive { background: #f8f9fa; color: #6c757d; }
    .preview-body { padding: 1.25rem; }
    .preview-member-card { background: #f8f9fa; border-radius: 10px; padding: 1.25rem; text-align: center; }
    .preview-avatar {
        width: 72px; height: 72px; border-radius: 50%;
        background: #E1F5EE; display: flex; align-items: center; justify-content: center;
        margin: 0 auto 12px; font-size: 26px; color: #0F6E56;
        overflow: hidden; border: 2px solid #1D9E75;
    }
    .preview-avatar img { width: 100%; height: 100%; object-fit: cover; border-radius: 50%; }
    .preview-member-name { font-size: 15px; font-weight: 600; color: #212529; }
    .preview-member-title { font-size: 13px; color: #6c757d; margin-top: 3px; }
    .preview-section-badge {
        display: inline-block; margin-top: 8px; font-size: 11px; padding: 3px 10px;
        background: #E1F5EE; color: #0F6E56; border-radius: 20px; font-weight: 500;
    }
    .preview-divider { height: 1px; background: #f1f3f5; margin: 1rem 0; }
    .meta-list { display: grid; gap: 8px; }
    .meta-row { display: flex; align-items: center; gap: 8px; font-size: 13px; color: #6c757d; }
    .meta-row i { font-size: 15px; color: #adb5bd; }
    .meta-val { color: #212529; font-weight: 500; margin-left: auto; }
    .status-dot { width: 7px; height: 7px; border-radius: 50%; background: #1D9E75; display: inline-block; transition: background .2s; }

    .action-bar { padding: 1rem 1.25rem; border-top: 1px solid #f1f3f5; display: flex; gap: 8px; }
    .btn-save {
        flex: 1; height: 40px; background: #1D9E75; color: #fff; border: none;
        border-radius: 8px; font-size: 14px; font-weight: 600; cursor: pointer;
        display: flex; align-items: center; justify-content: center; gap: 7px; transition: background .15s;
    }
    .btn-save:hover { background: #0F6E56; }
    .btn-cancel {
        height: 40px; padding: 0 18px; background: transparent; color: #6c757d;
        border: 1px solid #dee2e6; border-radius: 8px; font-size: 14px; font-weight: 500;
        cursor: pointer; transition: all .15s; text-decoration: none;
        display: flex; align-items: center;
    }
    .btn-cancel:hover { background: #f8f9fa; color: #212529; }

    @media (max-width: 900px) {
        .form-layout { grid-template-columns: 1fr; }
        .preview-card-wrap { position: static; }
    }
</style>
@endpush

@section('content')
<div class="page-wrapper">

    <ol class="breadcrumb-custom">
        <li><i class="fas fa-home" style="font-size:13px"></i></li>
        <li><span class="sep">›</span> Dashboard</li>
        <li><span class="sep">›</span> <a href="{{ route('admin.structure.index') }}" style="color:#6c757d;text-decoration:none;">Struktur Organisasi</a></li>
        <li><span class="sep">›</span> <span class="current">Tambah Data</span></li>
    </ol>

    <div class="page-header">
        <div class="page-icon"><i class="fas fa-sitemap"></i></div>
        <div>
            <h1 class="page-title">Tambah Struktur Organisasi</h1>
            <p class="page-subtitle">Isi data anggota baru untuk ditampilkan di halaman organisasi</p>
        </div>
    </div>

    <form action="{{ route('admin.structure.store') }}" method="POST" enctype="multipart/form-data" id="structureForm">
        @csrf

        <input type="hidden" name="sort_order" id="hidden-order" value="{{ old('sort_order', 0) }}">
        <input type="hidden" name="is_active"  id="hidden-active" value="{{ old('is_active', 1) ? '1' : '0' }}">
        <input type="hidden" name="icon"        id="hidden-icon"   value="{{ old('icon', 'fas fa-user') }}">

        <div class="form-layout">
            <div>

                {{-- Informasi Utama --}}
                <div class="card-custom">
                    <div class="card-section">
                        <div class="section-label"><i class="fas fa-id-card"></i> Informasi Utama</div>

                        <div class="mb-3">
                            <label class="field-label">Seksi / Posisi <span class="req">*</span></label>
                            <div class="select-wrapper">
                                <select name="section" id="inp-section"
                                    class="form-control-custom @error('section') is-invalid @enderror"
                                    required onchange="updatePreview()">
                                    <option value="">-- Pilih Seksi --</option>
                                    @foreach($sections as $key => $label)
                                        <option value="{{ $key }}" {{ old('section') == $key ? 'selected' : '' }}>
                                            {{ $label }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                            @error('section') <div class="invalid-feedback d-block">{{ $message }}</div> @enderror
                        </div>

                        <div class="mb-3">
                            <label class="field-label">Jabatan <span class="req">*</span></label>
                            <input type="text" name="title" id="inp-title"
                                class="form-control-custom @error('title') is-invalid @enderror"
                                value="{{ old('title') }}" placeholder="Contoh: Ketua Umum"
                                required oninput="updatePreview()">
                            @error('title') <div class="invalid-feedback d-block">{{ $message }}</div> @enderror
                        </div>

                        <div class="mb-0">
                            <label class="field-label">Nama Lengkap <span class="req">*</span></label>
                            <input type="text" name="name" id="inp-name"
                                class="form-control-custom @error('name') is-invalid @enderror"
                                value="{{ old('name') }}" placeholder="Nama lengkap anggota"
                                required oninput="updatePreview()">
                            @error('name') <div class="invalid-feedback d-block">{{ $message }}</div> @enderror
                        </div>
                    </div>

                    {{-- Photo Upload --}}
                    <div class="card-section">
                        <div class="section-label"><i class="fas fa-camera"></i> Foto Profil</div>
                        <div class="photo-upload-area" id="photoDropArea"
                             ondragover="handleDragOver(event)" ondragleave="handleDragLeave(event)"
                             ondrop="handleDrop(event)" onclick="document.getElementById('inp-photo').click()">
                            <input type="file" name="photo" id="inp-photo"
                                   accept="image/jpeg,image/jpg,image/png,image/webp"
                                   onchange="handlePhotoChange(event)" style="display:none;">

                            <div id="photoPlaceholder">
                                <div class="photo-upload-icon"><i class="fas fa-cloud-upload-alt"></i></div>
                                <div class="photo-upload-text">Klik atau drag foto ke sini</div>
                                <div class="photo-upload-hint">JPG, PNG, WEBP · Maks 3MB · Direkomendasikan 300×300px</div>
                            </div>

                            <div id="photoPreviewWrap" class="photo-preview-wrap" style="display:none;">
                                <img src="" alt="Preview" class="photo-preview" id="photoPreviewImg">
                                <button type="button" class="photo-remove-btn" onclick="removePhoto(event)" title="Hapus foto">
                                    <i class="fas fa-times"></i>
                                </button>
                            </div>
                        </div>
                        @error('photo') <div class="text-danger" style="font-size:12px;margin-top:6px;">{{ $message }}</div> @enderror
                    </div>

                    {{-- Icon --}}
                    <div class="card-section">
                        <div class="section-label"><i class="fas fa-icons"></i> Pilih Icon (opsional)</div>
                        <label class="field-label">Icon Font Awesome (tampil jika belum ada foto)</label>
                        <input type="text" id="inp-icon-display"
                            class="form-control-custom"
                            value="{{ old('icon', 'fas fa-user') }}"
                            placeholder="Contoh: fas fa-crown"
                            oninput="onIconTyped(this.value)">
                        <div class="hint-text">
                            <i class="fas fa-info-circle" style="font-size:12px"></i>
                            Lihat icon di <a href="https://fontawesome.com/icons" target="_blank">fontawesome.com</a>
                        </div>
                        <div class="icon-chips" id="icon-chips">
                            @php
                                $chips = [
                                    'fas fa-user'=>'User','fas fa-crown'=>'Crown','fas fa-briefcase'=>'Briefcase',
                                    'fas fa-star'=>'Star','fas fa-users'=>'Group','fas fa-award'=>'Award',
                                    'fas fa-cog'=>'Setting','fas fa-handshake'=>'Handshake',
                                    'fas fa-file-alt'=>'Dokumen','fas fa-shield-alt'=>'Shield',
                                ];
                            @endphp
                            @foreach($chips as $cls => $lbl)
                                <div class="icon-chip {{ old('icon','fas fa-user') == $cls ? 'active' : '' }}"
                                     onclick="selectIcon('{{ $cls }}', this)">
                                    <i class="{{ $cls }}"></i> {{ $lbl }}
                                </div>
                            @endforeach
                        </div>
                    </div>
                </div>

                {{-- Pengaturan --}}
                <div class="card-custom">
                    <div class="card-section">
                        <div class="section-label"><i class="fas fa-sliders-h"></i> Pengaturan</div>

                        <div class="toggle-row">
                            <div>
                                <div class="toggle-title">Urutan Tampil</div>
                                <div class="toggle-desc">Angka lebih kecil tampil lebih dahulu</div>
                            </div>
                            <div class="order-control">
                                <button type="button" class="order-btn" onclick="changeOrder(-1)">−</button>
                                <input type="number" class="order-input-num" id="inp-order"
                                    value="{{ old('sort_order', 0) }}" min="0" oninput="syncOrder(this.value)">
                                <button type="button" class="order-btn" onclick="changeOrder(1)">+</button>
                            </div>
                        </div>

                        <div class="toggle-row">
                            <div>
                                <div class="toggle-title">Status Aktif</div>
                                <div class="toggle-desc">Tampilkan di halaman publik</div>
                            </div>
                            <label class="form-switch-custom">
                                <input type="checkbox" id="tog-active"
                                    {{ old('is_active', true) ? 'checked' : '' }}
                                    onchange="syncActive(this.checked)">
                                <span class="switch-slider"></span>
                            </label>
                        </div>
                    </div>
                </div>

            </div>

            {{-- RIGHT: Preview --}}
            <div>
                <div class="preview-card-wrap">
                    <div class="preview-head">
                        <span class="preview-head-label">Pratinjau</span>
                        <span class="status-badge active" id="prev-status-badge">Aktif</span>
                    </div>
                    <div class="preview-body">
                        <div class="preview-member-card">
                            <div class="preview-avatar" id="prev-avatar">
                                <i class="{{ old('icon', 'fas fa-user') }}" id="prev-icon"></i>
                            </div>
                            <div class="preview-member-name" id="prev-name">–</div>
                            <div class="preview-member-title" id="prev-title">–</div>
                            <div><span class="preview-section-badge" id="prev-section">–</span></div>
                        </div>

                        <div class="preview-divider"></div>

                        <div class="meta-list">
                            <div class="meta-row">
                                <i class="fas fa-sort-numeric-down"></i>
                                Urutan tampil
                                <span class="meta-val" id="prev-order">{{ old('sort_order', 0) }}</span>
                            </div>
                            <div class="meta-row">
                                <i class="fas fa-camera"></i>
                                Foto
                                <span class="meta-val" id="prev-photo-status" style="color:#adb5bd;font-weight:400">Belum dipilih</span>
                            </div>
                            <div class="meta-row">
                                <span class="status-dot" id="prev-dot"></span>
                                Status
                                <span class="meta-val" id="prev-statusval" style="color:#1D9E75">Aktif</span>
                            </div>
                        </div>
                    </div>
                    <div class="action-bar">
                        <button type="submit" class="btn-save">
                            <i class="fas fa-save"></i> Simpan Data
                        </button>
                        <a href="{{ route('admin.structure.index') }}" class="btn-cancel">Batal</a>
                    </div>
                </div>
            </div>
        </div>
    </form>
</div>
@include('admin.structure._cropper')
@endsection

@push('scripts')
<script>
const sectionMap = {
    @foreach($sections as $key => $label)
        '{{ $key }}': '{{ $label }}',
    @endforeach
};

function updatePreview() {
    document.getElementById('prev-name').textContent    = document.getElementById('inp-name')?.value  || '–';
    document.getElementById('prev-title').textContent   = document.getElementById('inp-title')?.value || '–';
    const section = document.getElementById('inp-section')?.value || '';
    document.getElementById('prev-section').textContent = sectionMap[section] || '–';
}

function setIconEverywhere(iconClass) {
    document.getElementById('prev-icon').className       = iconClass;
    document.getElementById('hidden-icon').value         = iconClass;
}

function selectIcon(iconClass, el) {
    document.querySelectorAll('.icon-chip').forEach(c => c.classList.remove('active'));
    el.classList.add('active');
    document.getElementById('inp-icon-display').value = iconClass;
    setIconEverywhere(iconClass);
}

function onIconTyped(val) {
    document.querySelectorAll('.icon-chip').forEach(c => c.classList.remove('active'));
    setIconEverywhere(val);
    document.getElementById('hidden-icon').value = val;
}

function changeOrder(delta) {
    const inp = document.getElementById('inp-order');
    const val = Math.max(0, (parseInt(inp.value) || 0) + delta);
    inp.value = val; syncOrder(val);
}

function syncOrder(val) {
    document.getElementById('hidden-order').value      = val;
    document.getElementById('prev-order').textContent  = val;
}

function syncActive(checked) {
    document.getElementById('hidden-active').value = checked ? '1' : '0';
    const badge = document.getElementById('prev-status-badge');
    const dot   = document.getElementById('prev-dot');
    const sv    = document.getElementById('prev-statusval');
    if (checked) {
        badge.textContent = 'Aktif';   badge.className = 'status-badge active';
        dot.style.background = '#1D9E75'; sv.textContent = 'Aktif'; sv.style.color = '#1D9E75';
    } else {
        badge.textContent = 'Nonaktif'; badge.className = 'status-badge inactive';
        dot.style.background = '#adb5bd'; sv.textContent = 'Nonaktif'; sv.style.color = '#6c757d';
    }
}

/* ===== Photo Upload ===== */
    function handlePhotoChange(event) {
        const file = event.target.files[0];
        if (file) openCropper(file);
    }

function handleDragOver(e) {
    e.preventDefault(); e.stopPropagation();
    document.getElementById('photoDropArea').classList.add('dragover');
}
function handleDragLeave(e) {
    e.preventDefault(); e.stopPropagation();
    document.getElementById('photoDropArea').classList.remove('dragover');
}
function handleDrop(e) {
    e.preventDefault(); e.stopPropagation();
    document.getElementById('photoDropArea').classList.remove('dragover');
    const file = e.dataTransfer.files[0];
    if (file && file.type.startsWith('image/')) {
        const dt = new DataTransfer();
        dt.items.add(file);
        document.getElementById('inp-photo').files = dt.files;
        openCropper(file);
    }
}

function showPhotoPreview(file) {
    const reader = new FileReader();
    reader.onload = function(e) {
        const src = e.target.result;
        document.getElementById('photoPreviewImg').src = src;
        document.getElementById('photoPlaceholder').style.display  = 'none';
        document.getElementById('photoPreviewWrap').style.display  = 'inline-block';
        // Update preview avatar
        const avatar = document.getElementById('prev-avatar');
        avatar.innerHTML = `<img src="${src}" alt="preview">`;
        document.getElementById('prev-photo-status').textContent = file.name;
        document.getElementById('prev-photo-status').style.color = '#1D9E75';
    };
    reader.readAsDataURL(file);
}

function removePhoto(e) {
    e.stopPropagation();
    document.getElementById('inp-photo').value = '';
    document.getElementById('photoPlaceholder').style.display  = 'block';
    document.getElementById('photoPreviewWrap').style.display  = 'none';
    const icon = document.getElementById('hidden-icon').value || 'fas fa-user';
    document.getElementById('prev-avatar').innerHTML = `<i class="${icon}" id="prev-icon"></i>`;
    document.getElementById('prev-photo-status').textContent = 'Belum dipilih';
    document.getElementById('prev-photo-status').style.color = '#adb5bd';
}

document.addEventListener('DOMContentLoaded', function() {
    updatePreview();
    syncActive(document.getElementById('tog-active').checked);
});
</script>
@endpush