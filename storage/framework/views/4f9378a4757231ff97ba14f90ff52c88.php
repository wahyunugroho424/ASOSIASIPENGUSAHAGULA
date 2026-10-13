
<?php $__env->startSection('title', 'Edit Struktur Organisasi'); ?>

<?php $__env->startPush('styles'); ?>
<style>
    .page-wrapper { padding: 1.5rem; }

    .breadcrumb-custom {
        display: flex; align-items: center; gap: 6px; font-size: 13px; color: #6c757d;
        margin-bottom: 1.25rem; list-style: none; padding: 0;
    }
    .breadcrumb-custom .sep { color: #adb5bd; }
    .breadcrumb-custom .current { color: #212529; font-weight: 500; }

    .page-header { display: flex; align-items: center; gap: 14px; margin-bottom: 1.75rem; }
    .page-icon {
        width: 44px; height: 44px; border-radius: 10px; background: #fff3e0;
        display: flex; align-items: center; justify-content: center;
        color: #e65100; font-size: 20px; flex-shrink: 0;
    }
    .page-title { font-size: 20px; font-weight: 600; color: #212529; margin: 0; }
    .page-subtitle { font-size: 13px; color: #6c757d; margin: 2px 0 0; }
    .edit-badge {
        display: inline-flex; align-items: center; gap: 5px; padding: 4px 12px;
        background: #fff3e0; color: #e65100; border-radius: 20px;
        font-size: 11px; font-weight: 600; border: 1px solid #ffe0b2;
    }

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
        letter-spacing: .07em; color: #adb5bd; margin-bottom: 1.1rem;
    }
    .field-label { display: block; font-size: 13px; font-weight: 500; color: #495057; margin-bottom: 6px; }
    .field-label .req { color: #D85A30; margin-left: 2px; }

    .form-control-custom {
        width: 100%; height: 40px; border: 1px solid #dee2e6; border-radius: 8px;
        background: #fff; padding: 0 12px; font-size: 14px; color: #212529;
        transition: border-color .15s, box-shadow .15s; appearance: none;
    }
    .form-control-custom:focus { outline: none; border-color: #e65100; box-shadow: 0 0 0 3px rgba(230,81,0,.10); }
    .form-control-custom.is-invalid { border-color: #dc3545; }

    .select-wrapper { position: relative; }
    .select-wrapper::after {
        content: ''; pointer-events: none; position: absolute;
        right: 12px; top: 50%; transform: translateY(-50%);
        border: 5px solid transparent; border-top-color: #868e96; margin-top: 2px;
    }
    .select-wrapper select { padding-right: 32px; cursor: pointer; }

    .hint-text { margin-top: 5px; font-size: 12px; color: #adb5bd; display: flex; align-items: center; gap: 4px; }
    .hint-text a { color: #e65100; text-decoration: none; }
    .hint-text a:hover { text-decoration: underline; }

    .icon-chips { display: flex; flex-wrap: wrap; gap: 6px; margin-top: 10px; }
    .icon-chip {
        display: inline-flex; align-items: center; gap: 5px; padding: 5px 11px;
        background: #f8f9fa; border-radius: 20px; font-size: 12px; color: #495057;
        cursor: pointer; border: 1px solid #e9ecef; transition: all .15s; user-select: none;
    }
    .icon-chip:hover { border-color: #e65100; color: #e65100; background: #fff3e0; }
    .icon-chip.active { background: #fff3e0; border-color: #e65100; color: #e65100; font-weight: 500; }

    /* ===== Photo Upload ===== */
    .photo-upload-area {
        border: 2px dashed #dee2e6; border-radius: 12px; padding: 1.5rem;
        text-align: center; cursor: pointer; transition: all .2s; position: relative;
    }
    .photo-upload-area:hover { border-color: #e65100; background: #fffaf8; }
    .photo-upload-area.dragover { border-color: #e65100; background: #fff3e0; }
    .photo-upload-area input[type="file"] {
        position: absolute; inset: 0; opacity: 0; cursor: pointer; width: 100%; height: 100%;
    }
    .photo-preview-wrap { position: relative; display: inline-block; }
    .photo-preview {
        width: 100px; height: 100px; border-radius: 50%; object-fit: cover;
        border: 3px solid #e65100; box-shadow: 0 4px 12px rgba(230,81,0,.2);
        display: block; margin: 0 auto 10px;
    }
    .photo-remove-btn {
        position: absolute; top: -4px; right: -4px;
        width: 24px; height: 24px; border-radius: 50%;
        background: #ef4444; color: #fff; border: none;
        cursor: pointer; font-size: 12px; display: flex; align-items: center; justify-content: center;
        box-shadow: 0 2px 6px rgba(239,68,68,.4);
    }
    .photo-upload-icon { font-size: 32px; color: #adb5bd; margin-bottom: 8px; }
    .photo-upload-text { font-size: 13px; color: #6c757d; margin-bottom: 4px; }
    .photo-upload-hint { font-size: 11px; color: #adb5bd; }

    .current-photo-badge {
        display: inline-flex; align-items: center; gap: 6px;
        padding: 5px 12px; background: #e8f5e9; color: #2e7d32;
        border-radius: 20px; font-size: 12px; font-weight: 500;
        border: 1px solid #c8e6c9; margin-bottom: 10px;
    }

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
        content: ''; position: absolute; width: 18px; height: 18px;
        left: 3px; top: 3px; background: white; border-radius: 50%;
        transition: transform .2s; box-shadow: 0 1px 3px rgba(0,0,0,.15);
    }
    .form-switch-custom input:checked + .switch-slider { background: #1D9E75; }
    .form-switch-custom input:checked + .switch-slider::before { transform: translateX(18px); }

    .order-control { display: flex; border: 1px solid #dee2e6; border-radius: 8px; overflow: hidden; width: 120px; }
    .order-btn {
        width: 36px; height: 36px; background: #f8f9fa; border: none; cursor: pointer;
        display: flex; align-items: center; justify-content: center;
        color: #6c757d; font-size: 18px; font-weight: 600; transition: all .15s; flex-shrink: 0;
    }
    .order-btn:hover { background: #fff3e0; color: #e65100; }
    .order-input-num {
        flex: 1; border: none; border-left: 1px solid #dee2e6; border-right: 1px solid #dee2e6;
        text-align: center; font-size: 14px; font-weight: 600; color: #212529;
        background: #fff; min-width: 0;
    }
    .order-input-num:focus { outline: none; }

    .changed-dot {
        display: inline-block; width: 6px; height: 6px;
        background: #e65100; border-radius: 50%; margin-left: 6px;
        opacity: 0; transition: opacity .2s; vertical-align: middle;
    }
    .changed-dot.show { opacity: 1; }
    .original-val { font-size: 11px; color: #adb5bd; margin-top: 4px; display: flex; align-items: center; gap: 4px; }
    .original-val i { font-size: 11px; }

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
        background: linear-gradient(135deg, #f59e0b, #e65100);
        display: flex; align-items: center; justify-content: center;
        margin: 0 auto 12px; font-size: 24px; color: #fff;
        overflow: hidden; border: 2px solid #e65100;
    }
    .preview-avatar img { width: 100%; height: 100%; object-fit: cover; border-radius: 50%; }
    .preview-member-name { font-size: 15px; font-weight: 600; color: #212529; }
    .preview-member-title { font-size: 13px; color: #6c757d; margin-top: 3px; }
    .preview-section-badge {
        display: inline-block; margin-top: 8px; font-size: 11px; padding: 3px 10px;
        background: #fff3e0; color: #e65100; border-radius: 20px; font-weight: 500;
    }
    .preview-divider { height: 1px; background: #f1f3f5; margin: 1rem 0; }
    .meta-list { display: grid; gap: 8px; }
    .meta-row { display: flex; align-items: center; gap: 8px; font-size: 13px; color: #6c757d; }
    .meta-row i { font-size: 15px; color: #adb5bd; }
    .meta-val { color: #212529; font-weight: 500; margin-left: auto; }
    .status-dot { width: 7px; height: 7px; border-radius: 50%; background: #1D9E75; display: inline-block; transition: background .2s; }

    .action-bar { padding: 1rem 1.25rem; border-top: 1px solid #f1f3f5; display: flex; gap: 8px; }
    .btn-update {
        flex: 1; height: 40px; background: #e65100; color: #fff; border: none;
        border-radius: 8px; font-size: 14px; font-weight: 600; cursor: pointer;
        display: flex; align-items: center; justify-content: center; gap: 7px; transition: background .15s;
    }
    .btn-update:hover { background: #bf360c; }
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
<?php $__env->stopPush(); ?>

<?php $__env->startSection('content'); ?>
<div class="page-wrapper">

    <ol class="breadcrumb-custom">
        <li><i class="bi bi-house-fill" style="font-size:13px"></i></li>
        <li><span class="sep">›</span> Dashboard</li>
        <li><span class="sep">›</span> <a href="<?php echo e(route('admin.structure.index')); ?>" style="color:#6c757d;text-decoration:none;">Struktur Organisasi</a></li>
        <li><span class="sep">›</span> <span class="current">Edit Data</span></li>
    </ol>

    <div class="page-header">
        <div class="page-icon"><i class="bi bi-pencil-square"></i></div>
        <div style="flex:1">
            <div style="display:flex;align-items:center;gap:10px">
                <h1 class="page-title">Edit Struktur Organisasi</h1>
                <span class="edit-badge"><i class="bi bi-pencil-fill"></i> Mode Edit</span>
            </div>
            <p class="page-subtitle">Perbarui data <strong><?php echo e($structure->name); ?></strong></p>
        </div>
    </div>

    <form action="<?php echo e(route('admin.structure.update', $structure)); ?>" method="POST"
          enctype="multipart/form-data" id="editForm">
        <?php echo csrf_field(); ?> <?php echo method_field('PUT'); ?>

        <input type="hidden" name="sort_order"   id="hidden-order"  value="<?php echo e(old('sort_order', $structure->sort_order)); ?>">
        <input type="hidden" name="is_active"    id="hidden-active" value="<?php echo e(old('is_active', $structure->is_active) ? '1' : '0'); ?>">
        <input type="hidden" name="icon"         id="hidden-icon"   value="<?php echo e(old('icon', $structure->icon)); ?>">
        <input type="hidden" name="remove_photo" id="hidden-remove" value="0">

        <div class="form-layout">
            <div>

                <div class="card-custom">
                    <div class="card-section">
                        <div class="section-label"><i class="bi bi-id-card"></i> Informasi Utama</div>

                        <div class="mb-3">
                            <label class="field-label">
                                Seksi / Posisi <span class="req">*</span>
                                <span class="changed-dot" id="dot-section"></span>
                            </label>
                            <div class="select-wrapper">
                                <select name="section" id="inp-section"
                                    class="form-control-custom <?php $__errorArgs = ['section'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>"
                                    required onchange="markChanged('section'); updatePreview()">
                                    <?php $__currentLoopData = $sections; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key => $label): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                        <option value="<?php echo e($key); ?>"
                                            <?php echo e(old('section', $structure->section) == $key ? 'selected' : ''); ?>>
                                            <?php echo e($label); ?>

                                        </option>
                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                </select>
                            </div>
                            <div class="original-val"><i class="bi bi-clock-history"></i> Sebelumnya: <strong><?php echo e($sections[$structure->section] ?? $structure->section); ?></strong></div>
                            <?php $__errorArgs = ['section'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> <div class="invalid-feedback d-block"><?php echo e($message); ?></div> <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                        </div>

                        <div class="mb-3">
                            <label class="field-label">
                                Jabatan <span class="req">*</span>
                                <span class="changed-dot" id="dot-title"></span>
                            </label>
                            <input type="text" name="title" id="inp-title"
                                class="form-control-custom <?php $__errorArgs = ['title'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>"
                                value="<?php echo e(old('title', $structure->title)); ?>"
                                required oninput="markChanged('title'); updatePreview()">
                            <div class="original-val"><i class="bi bi-clock-history"></i> Sebelumnya: <strong><?php echo e($structure->title); ?></strong></div>
                            <?php $__errorArgs = ['title'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> <div class="invalid-feedback d-block"><?php echo e($message); ?></div> <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                        </div>

                        <div class="mb-0">
                            <label class="field-label">
                                Nama Lengkap <span class="req">*</span>
                                <span class="changed-dot" id="dot-name"></span>
                            </label>
                            <input type="text" name="name" id="inp-name"
                                class="form-control-custom <?php $__errorArgs = ['name'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>"
                                value="<?php echo e(old('name', $structure->name)); ?>"
                                required oninput="markChanged('name'); updatePreview()">
                            <div class="original-val"><i class="bi bi-clock-history"></i> Sebelumnya: <strong><?php echo e($structure->name); ?></strong></div>
                            <?php $__errorArgs = ['name'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> <div class="invalid-feedback d-block"><?php echo e($message); ?></div> <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                        </div>
                    </div>

                    
                    <div class="card-section">
                        <div class="section-label">
                            <i class="bi bi-camera"></i> Foto Profil
                            <span class="changed-dot" id="dot-photo"></span>
                        </div>

                        <?php if($structure->photo && Storage::disk('public')->exists($structure->photo)): ?>
                            <div id="currentPhotoBadge" class="current-photo-badge">
                                <i class="bi bi-check-circle-fill"></i>
                                Foto saat ini tersedia
                            </div>
                        <?php endif; ?>

                        <div class="photo-upload-area" id="photoDropArea"
                             ondragover="handleDragOver(event)" ondragleave="handleDragLeave(event)"
                             ondrop="handleDrop(event)" onclick="document.getElementById('inp-photo').click()">
                            <input type="file" name="photo" id="inp-photo"
                                   accept="image/jpeg,image/jpg,image/png,image/webp"
                                   onchange="handlePhotoChange(event)" style="display:none;">

                            <div id="photoPlaceholder"
                                 <?php if($structure->photo && Storage::disk('public')->exists($structure->photo)): ?> style="display:none;" <?php endif; ?>>
                                <div class="photo-upload-icon"><i class="bi bi-cloud-upload"></i></div>
                                <div class="photo-upload-text">Klik atau drag foto baru ke sini</div>
                                <div class="photo-upload-hint">JPG, PNG, WEBP · Maks 3MB · 300×300px</div>
                            </div>

                            <div id="photoPreviewWrap" class="photo-preview-wrap"
                                 <?php if(!($structure->photo && Storage::disk('public')->exists($structure->photo))): ?> style="display:none;" <?php endif; ?>>
                                <img src="<?php echo e($structure->photo_url); ?>"
                                     alt="<?php echo e($structure->name); ?>"
                                     class="photo-preview" id="photoPreviewImg">
                                <button type="button" class="photo-remove-btn"
                                        onclick="removePhoto(event)" title="Hapus foto">
                                    <i class="bi bi-x-lg"></i>
                                </button>
                            </div>
                        </div>
                        <div class="hint-text mt-2">
                            <?php if($structure->photo && Storage::disk('public')->exists($structure->photo)): ?>
                                <button type="button" class="btn btn-sm btn-outline-secondary mt-2"
                                        onclick="openCropperFromUrl('<?php echo e($structure->photo_url); ?>', 'foto-<?php echo e($structure->id); ?>')">
                                    <i class="bi bi-crop me-1"></i> Atur ulang crop foto saat ini
                                </button>
                            <?php endif; ?>
                            <i class="bi bi-info-circle" style="font-size:12px"></i>
                            Upload foto baru untuk mengganti yang lama. Klik × untuk menghapus foto.
                        </div>
                        <?php $__errorArgs = ['photo'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> <div class="text-danger" style="font-size:12px;margin-top:6px;"><?php echo e($message); ?></div> <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                    </div>

                    
                    <div class="card-section">
                        <div class="section-label">
                            <i class="bi bi-emoji-smile"></i> Pilih Icon
                            <span class="changed-dot" id="dot-icon"></span>
                        </div>
                        <label class="field-label">Icon Font Awesome (tampil jika belum ada foto)</label>
                        <input type="text" id="inp-icon-display"
                            class="form-control-custom"
                            value="<?php echo e(old('icon', $structure->icon)); ?>"
                            placeholder="Contoh: fas fa-crown"
                            oninput="onIconTyped(this.value)">
                        <div class="hint-text">
                            <i class="bi bi-info-circle" style="font-size:12px"></i>
                            Lihat icon di <a href="https://fontawesome.com/icons" target="_blank">fontawesome.com</a>
                            &nbsp;·&nbsp; Sebelumnya: <strong><?php echo e($structure->icon); ?></strong>
                        </div>
                        <div class="icon-chips" id="icon-chips">
                            <?php
                                $currentIcon = old('icon', $structure->icon);
                                $presetIcons = [
                                    'fas fa-user'=>'User','fas fa-crown'=>'Crown','fas fa-briefcase'=>'Briefcase',
                                    'fas fa-star'=>'Star','fas fa-users'=>'Group','fas fa-award'=>'Award',
                                    'fas fa-cog'=>'Setting','fas fa-handshake'=>'Handshake',
                                    'fas fa-file-alt'=>'Dokumen','fas fa-shield-alt'=>'Shield',
                                ];
                            ?>
                            <?php $__currentLoopData = $presetIcons; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $iconClass => $iconLabel): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <div class="icon-chip <?php echo e($currentIcon == $iconClass ? 'active' : ''); ?>"
                                     onclick="selectIcon('<?php echo e($iconClass); ?>', this)">
                                    <i class="<?php echo e($iconClass); ?>"></i> <?php echo e($iconLabel); ?>

                                </div>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        </div>
                    </div>
                </div>

                
                <div class="card-custom">
                    <div class="card-section">
                        <div class="section-label"><i class="bi bi-sliders"></i> Pengaturan</div>

                        <div class="toggle-row">
                            <div>
                                <div class="toggle-title">Urutan Tampil <span class="changed-dot" id="dot-order"></span></div>
                                <div class="toggle-desc">Angka lebih kecil tampil lebih dahulu · Sebelumnya: <strong><?php echo e($structure->sort_order); ?></strong></div>
                            </div>
                            <div class="order-control">
                                <button type="button" class="order-btn" onclick="changeOrder(-1)">−</button>
                                <input type="number" class="order-input-num" id="inp-order"
                                    value="<?php echo e(old('sort_order', $structure->sort_order)); ?>" min="0"
                                    oninput="syncOrder(this.value); markChanged('order')">
                                <button type="button" class="order-btn" onclick="changeOrder(1)">+</button>
                            </div>
                        </div>

                        <div class="toggle-row">
                            <div>
                                <div class="toggle-title">Status Aktif <span class="changed-dot" id="dot-active"></span></div>
                                <div class="toggle-desc">Tampilkan di halaman publik · Sebelumnya: <strong><?php echo e($structure->is_active ? 'Aktif' : 'Nonaktif'); ?></strong></div>
                            </div>
                            <label class="form-switch-custom">
                                <input type="checkbox" id="tog-active"
                                    <?php echo e(old('is_active', $structure->is_active) ? 'checked' : ''); ?>

                                    onchange="syncActive(this.checked); markChanged('active')">
                                <span class="switch-slider"></span>
                            </label>
                        </div>
                    </div>
                </div>

            </div>

            
            <div>
                <div class="preview-card-wrap">
                    <div class="preview-head">
                        <span class="preview-head-label">Pratinjau</span>
                        <span class="status-badge <?php echo e($structure->is_active ? 'active' : 'inactive'); ?>" id="prev-status-badge">
                            <?php echo e($structure->is_active ? 'Aktif' : 'Nonaktif'); ?>

                        </span>
                    </div>
                    <div class="preview-body">
                        <div class="preview-member-card">
                            <div class="preview-avatar" id="prev-avatar">
                                <?php if($structure->photo && Storage::disk('public')->exists($structure->photo)): ?>
                                    <img src="<?php echo e($structure->photo_url); ?>" alt="<?php echo e($structure->name); ?>">
                                <?php else: ?>
                                    <i class="<?php echo e(old('icon', $structure->icon)); ?>" id="prev-icon"></i>
                                <?php endif; ?>
                            </div>
                            <div class="preview-member-name" id="prev-name"><?php echo e(old('name', $structure->name)); ?></div>
                            <div class="preview-member-title" id="prev-title"><?php echo e(old('title', $structure->title)); ?></div>
                            <div><span class="preview-section-badge" id="prev-section">
                                <?php echo e($sections[old('section', $structure->section)] ?? $structure->section); ?>

                            </span></div>
                        </div>

                        <div class="preview-divider"></div>

                        <div class="meta-list">
                            <div class="meta-row">
                                <i class="bi bi-sort-numeric-down"></i>
                                Urutan tampil
                                <span class="meta-val" id="prev-order"><?php echo e(old('sort_order', $structure->sort_order)); ?></span>
                            </div>
                            <div class="meta-row">
                                <i class="bi bi-camera"></i>
                                Foto
                                <span class="meta-val" id="prev-photo-status"
                                    style="color: <?php echo e(($structure->photo && Storage::disk('public')->exists($structure->photo)) ? '#1D9E75' : '#adb5bd'); ?>; font-weight:400">
                                    <?php echo e(($structure->photo && Storage::disk('public')->exists($structure->photo)) ? 'Tersedia' : 'Belum ada'); ?>

                                </span>
                            </div>
                            <div class="meta-row">
                                <span class="status-dot" id="prev-dot"
                                      style="background: <?php echo e($structure->is_active ? '#1D9E75' : '#adb5bd'); ?>"></span>
                                Status
                                <span class="meta-val" id="prev-statusval"
                                    style="color: <?php echo e($structure->is_active ? '#1D9E75' : '#6c757d'); ?>">
                                    <?php echo e($structure->is_active ? 'Aktif' : 'Nonaktif'); ?>

                                </span>
                            </div>
                        </div>
                    </div>

                    <div class="action-bar">
                        <button type="submit" class="btn-update">
                            <i class="bi bi-check-lg"></i> Simpan Perubahan
                        </button>
                        <a href="<?php echo e(route('admin.structure.index')); ?>" class="btn-cancel">Batal</a>
                    </div>
                </div>
            </div>
        </div>
    </form>
</div>
<?php echo $__env->make('admin.structure._cropper', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>
<?php $__env->stopSection(); ?>

<?php $__env->startPush('scripts'); ?>
<script>
const sectionMap = {
    <?php $__currentLoopData = $sections; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key => $label): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
        '<?php echo e($key); ?>': '<?php echo e($label); ?>',
    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
};
const originals = {
    section : '<?php echo e($structure->section); ?>',
    title   : <?php echo json_encode($structure->title, 15, 512) ?>,
    name    : <?php echo json_encode($structure->name, 15, 512) ?>,
    icon    : <?php echo json_encode($structure->icon, 15, 512) ?>,
    order   : '<?php echo e($structure->sort_order); ?>',
    active  : '<?php echo e($structure->is_active ? "1" : "0"); ?>',
    photo   : '<?php echo e($structure->photo ? "has" : "none"); ?>',
};

function markChanged(field) {
    const dot = document.getElementById('dot-' + field);
    if (!dot) return;
    let current;
    if (field === 'section') current = document.getElementById('inp-section').value;
    else if (field === 'title')  current = document.getElementById('inp-title').value;
    else if (field === 'name')   current = document.getElementById('inp-name').value;
    else if (field === 'icon')   current = document.getElementById('hidden-icon').value;
    else if (field === 'order')  current = document.getElementById('inp-order').value;
    else if (field === 'active') current = document.getElementById('tog-active').checked ? '1' : '0';
    else if (field === 'photo')  { dot.classList.add('show'); return; }
    if (dot) dot.classList.toggle('show', current !== originals[field]);
}

function updatePreview() {
    document.getElementById('prev-name').textContent    = document.getElementById('inp-name').value || '–';
    document.getElementById('prev-title').textContent   = document.getElementById('inp-title').value || '–';
    const section = document.getElementById('inp-section').value;
    document.getElementById('prev-section').textContent = sectionMap[section] || '–';
}

function setIconEverywhere(iconClass) {
    const pi = document.getElementById('prev-icon');
    if (pi) pi.className = iconClass;
    document.getElementById('hidden-icon').value = iconClass;
}

function selectIcon(iconClass, el) {
    document.querySelectorAll('.icon-chip').forEach(c => c.classList.remove('active'));
    el.classList.add('active');
    document.getElementById('inp-icon-display').value = iconClass;
    setIconEverywhere(iconClass);
    markChanged('icon');
}

function onIconTyped(val) {
    document.getElementById('hidden-icon').value = val;
    document.querySelectorAll('.icon-chip').forEach(c => c.classList.remove('active'));
    setIconEverywhere(val);
    markChanged('icon');
}

function changeOrder(delta) {
    const inp = document.getElementById('inp-order');
    const val = Math.max(0, (parseInt(inp.value) || 0) + delta);
    inp.value = val; syncOrder(val); markChanged('order');
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
        badge.textContent = 'Aktif';    badge.className = 'status-badge active';
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
        document.getElementById('photoPreviewImg').src  = src;
        document.getElementById('photoPlaceholder').style.display   = 'none';
        document.getElementById('photoPreviewWrap').style.display   = 'inline-block';
        const badge = document.getElementById('currentPhotoBadge');
        if (badge) badge.style.display = 'none';
        // Update preview avatar
        document.getElementById('prev-avatar').innerHTML = `<img src="${src}" alt="preview">`;
        document.getElementById('prev-photo-status').textContent = file.name;
        document.getElementById('prev-photo-status').style.color = '#e65100';
        // Reset remove flag since we're uploading a new one
        document.getElementById('hidden-remove').value = '0';
        markChanged('photo');
    };
    reader.readAsDataURL(file);
}

function removePhoto(e) {
    e.stopPropagation();
    document.getElementById('inp-photo').value = '';
    document.getElementById('hidden-remove').value = '1';
    document.getElementById('photoPreviewImg').src = '';
    document.getElementById('photoPlaceholder').style.display  = 'block';
    document.getElementById('photoPreviewWrap').style.display  = 'none';
    const badge = document.getElementById('currentPhotoBadge');
    if (badge) badge.style.display = 'none';
    // Restore icon in preview
    const icon = document.getElementById('hidden-icon').value || 'fas fa-user';
    document.getElementById('prev-avatar').innerHTML = `<i class="${icon}" id="prev-icon"></i>`;
    document.getElementById('prev-photo-status').textContent = 'Akan dihapus';
    document.getElementById('prev-photo-status').style.color = '#ef4444';
    markChanged('photo');
}

document.addEventListener('DOMContentLoaded', function () {
    syncActive(document.getElementById('tog-active').checked);
});
</script>
<?php $__env->stopPush(); ?>
<?php echo $__env->make('admin.layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\laragon\www\u360220114\domains\pengusahagulaindonesia.com\public_html\resources\views/admin/structure/edit.blade.php ENDPATH**/ ?>