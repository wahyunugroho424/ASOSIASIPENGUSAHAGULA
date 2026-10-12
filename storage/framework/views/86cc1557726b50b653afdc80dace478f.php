

<?php $__env->startSection('title', 'Tambah Anggota'); ?>
<?php $__env->startSection('page-title', 'Tambah Anggota APGI'); ?>

<?php $__env->startPush('styles'); ?>
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
<?php $__env->stopPush(); ?>

<?php $__env->startSection('content'); ?>

<div class="d-flex align-items-center gap-2 mb-4">
    <a href="<?php echo e(route('admin.member.index')); ?>" class="btn btn-outline-secondary btn-sm">
        <i class="bi bi-arrow-left"></i>
    </a>
    <span class="text-muted">Kembali ke daftar anggota</span>
</div>

<div class="row">
    <div class="col-lg-8">
        <form action="<?php echo e(route('admin.member.store')); ?>" method="POST" enctype="multipart/form-data">
            <?php echo csrf_field(); ?>

            <div class="card mb-4">
                <div class="card-header">
                    <h6 class="mb-0"><i class="bi bi-info-circle me-2"></i>Informasi Anggota</h6>
                </div>
                <div class="card-body">

                    
                    <div class="mb-4">
                        <label class="form-label fw-semibold">Nama Perusahaan <span class="text-danger">*</span></label>
                        <input type="text" name="name" class="form-control <?php $__errorArgs = ['name'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>"
                               value="<?php echo e(old('name')); ?>" placeholder="Contoh: PT Fajar Mulia Transindo" required>
                        <?php $__errorArgs = ['name'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                            <div class="invalid-feedback"><?php echo e($message); ?></div>
                        <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                    </div>

                    
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
                                       class="form-control <?php $__errorArgs = ['logo'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>"
                                       accept="image/png,image/jpg,image/jpeg,image/svg+xml,image/webp"
                                       onchange="previewLogo(this)">
                                <div class="form-text">PNG, JPG, SVG, atau WEBP. Maks 2MB.</div>
                                <?php $__errorArgs = ['logo'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                                    <div class="invalid-feedback"><?php echo e($message); ?></div>
                                <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                            </div>
                        </div>
                    </div>

                    
                    <div class="mb-4">
                        <label class="form-label fw-semibold">Urutan Tampil</label>
                        <input type="number" name="sort_order" class="form-control" 
                               value="<?php echo e(old('sort_order', 0)); ?>" min="0" style="max-width:120px">
                        <div class="form-text">Semakin kecil angka, semakin awal tampil. Bisa diubah dengan drag-drop di halaman daftar.</div>
                    </div>

                    
                    <div class="mb-3">
                        <label class="form-label fw-semibold">Status</label>
                        <div class="form-check form-switch">
                            <input class="form-check-input" type="checkbox" role="switch" 
                                   name="is_active" id="is_active" value="1"
                                   <?php echo e(old('is_active', true) ? 'checked' : ''); ?>>
                            <label class="form-check-label" for="is_active">
                                Aktif (tampil di website)
                            </label>
                        </div>
                    </div>

                </div>
            </div>

            
            <div class="card mb-4">
                <div class="card-header">
                    <h6 class="mb-0"><i class="bi bi-palette me-2"></i>Tampilan Kartu</h6>
                </div>
                <div class="card-body">

                    
                    <div>
                        <label class="form-label fw-semibold">Ukuran Logo</label>
                        <div class="row g-2">
                            <?php $__currentLoopData = $logoSizes; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $value => $label): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <div class="col-md-6">
                                <label class="style-option w-100 text-center <?php echo e(old('logo_size', 'member-large-logo') === $value ? 'selected' : ''); ?>">
                                    <input type="radio" name="logo_size" value="<?php echo e($value); ?>"
                                           <?php echo e(old('logo_size', 'member-large-logo') === $value ? 'checked' : ''); ?>

                                           onchange="selectStyle(this)">
                                    <i class="bi bi-image<?php echo e($value === 'member-large-logo' ? '' : '-fill'); ?> d-block fs-4 mb-1 text-secondary"></i>
                                    <div class="small"><?php echo e($label); ?></div>
                                </label>
                            </div>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        </div>
                        <?php $__errorArgs = ['logo_size'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                            <div class="text-danger small mt-1"><?php echo e($message); ?></div>
                        <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                    </div>

                </div>
            </div>

            <div class="d-flex gap-2">
                <button type="submit" class="btn btn-primary px-4">
                    <i class="bi bi-check-lg me-1"></i> Simpan Anggota
                </button>
                <a href="<?php echo e(route('admin.member.index')); ?>" class="btn btn-outline-secondary">
                    Batal
                </a>
            </div>

        </form>
    </div>

    
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

<?php $__env->stopSection(); ?>

<?php $__env->startPush('scripts'); ?>
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
<?php $__env->stopPush(); ?>
<?php echo $__env->make('admin.layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\laragon\www\u360220114\domains\pengusahagulaindonesia.com\public_html\resources\views/admin/member/create.blade.php ENDPATH**/ ?>