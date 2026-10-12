

<?php $__env->startSection('title', 'Edit Anggota'); ?>
<?php $__env->startSection('page-title', 'Edit Anggota: ' . $member->name); ?>

<?php $__env->startPush('styles'); ?>
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
        <form action="<?php echo e(route('admin.member.update', $encryptedId)); ?>" method="POST" enctype="multipart/form-data">
            <?php echo csrf_field(); ?>
            <?php echo method_field('PUT'); ?>

            <input type="hidden" name="remove_logo" id="remove_logo" value="0">

            
            <div class="card mb-4">
                <div class="card-header">
                    <h6 class="mb-0"><i class="bi bi-info-circle me-2"></i>Informasi Anggota</h6>
                </div>
                <div class="card-body">

                    
                    <div class="mb-4">
                        <label class="form-label fw-semibold">
                            Nama Perusahaan <span class="text-danger">*</span>
                        </label>
                        <input type="text" name="name"
                               class="form-control <?php $__errorArgs = ['name'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>"
                               value="<?php echo e(old('name', $member->name)); ?>" required>
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

                            <!-- Preview -->
                            <div class="logo-preview-box position-relative">

                                <img id="logo-preview"
                                    src="<?php echo e($member->logo_url); ?>"
                                    alt="<?php echo e($member->name); ?>">

                                <?php if($member->logo): ?>
                                <button type="button"
                                        onclick="removeLogo()"
                                        class="remove-logo-btn">
                                    ×
                                </button>
                                <?php endif; ?>

                            </div>

                            <!-- Input -->
                            <div class="flex-grow-1">

                                <input type="file"
                                    id="logo-input"
                                    name="logo"
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

                                <div class="form-text">
                                    Kosongkan jika tidak ingin mengganti logo.<br>

                                    <?php if($member->logo): ?>
                                        Logo saat ini:
                                        <code><?php echo e($member->logo); ?></code>
                                    <?php else: ?>
                                        Saat ini menggunakan <em>placeholder</em>.
                                    <?php endif; ?>
                                </div>

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
                               value="<?php echo e(old('sort_order', $member->sort_order)); ?>"
                               min="0" style="max-width:120px">
                    </div>

                    
                    <div class="mb-0">
                        <label class="form-label fw-semibold">Status</label>
                        <div class="form-check form-switch">
                            <input class="form-check-input" type="checkbox" role="switch"
                                   name="is_active" id="is_active" value="1"
                                   <?php echo e(old('is_active', $member->is_active) ? 'checked' : ''); ?>>
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
                                <label class="style-option w-100 text-center
                                    <?php echo e(old('logo_size', $member->logo_size) === $value ? 'selected' : ''); ?>">
                                    <input type="radio" name="logo_size" value="<?php echo e($value); ?>"
                                           <?php echo e(old('logo_size', $member->logo_size) === $value ? 'checked' : ''); ?>

                                           onchange="selectStyle(this)">
                                    <i class="bi bi-image<?php echo e($value === 'member-large-logo' ? '' : '-fill'); ?> d-block fs-4 mb-1 text-secondary"></i>
                                    <div class="small"><?php echo e($label); ?></div>
                                </label>
                            </div>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        </div>
                    </div>

                </div>
            </div>

            <div class="d-flex gap-2">
                <button type="submit" class="btn btn-primary px-4">
                    <i class="bi bi-check-lg me-1"></i> Simpan Perubahan
                </button>
                <a href="<?php echo e(route('admin.member.index')); ?>" class="btn btn-outline-secondary">
                    Batal
                </a>
                <button type="button" class="btn btn-outline-danger ms-auto"
                        onclick="confirmDelete('<?php echo e(addslashes($member->name)); ?>')">
                    <i class="bi bi-trash me-1"></i> Hapus
                </button>

            </div>

        </form>
    </div>

    
    <div class="col-lg-4">
        <div class="card mb-3">
            <div class="card-body">
                <h6 class="fw-bold mb-3">Info Anggota</h6>
                <dl class="row small mb-0">
                    <dt class="col-5 text-muted">Dibuat</dt>
                    <dd class="col-7"><?php echo e($member->created_at ? $member->created_at->format('d M Y') : '-'); ?></dd>
                    <dt class="col-5 text-muted">Diperbarui</dt>
                    <dd class="col-7"><?php echo e($member->updated_at ? $member->updated_at->format('d M Y') : '-'); ?></dd>
                    <dt class="col-5 text-muted">Status</dt>
                    <dd class="col-7">
                        <?php if($member->is_active): ?>
                            <span class="badge bg-success">Aktif</span>
                        <?php else: ?>
                            <span class="badge bg-secondary">Nonaktif</span>
                        <?php endif; ?>
                    </dd>
                </dl>
            </div>
        </div>

        
        <div class="card border-0 bg-light">
            <div class="card-body">
                <h6 class="fw-bold mb-3">
                    <i class="bi bi-eye text-primary me-2"></i>Preview Kartu
                </h6>
                <div class="bg-white rounded-3 shadow p-3 text-center">
                    <img src="<?php echo e($member->logo_url); ?>" alt="<?php echo e($member->name); ?>"
                         class="img-fluid mb-2" style="max-height:60px;object-fit:contain">
                    <h6 class="small mb-0 fw-semibold"><?php echo e($member->name); ?></h6>
                    <p class="text-muted mb-0" style="font-size:11px">Anggota APGI</p>
                </div>
            </div>
        </div>
    </div>
</div>


<form id="delete-form" method="POST"
      action="<?php echo e(route('admin.member.destroy', $encryptedId)); ?>">
    <?php echo csrf_field(); ?> <?php echo method_field('DELETE'); ?>
</form>

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

<?php $__env->stopSection(); ?>

<?php $__env->startPush('scripts'); ?>
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
            "<?php echo e(asset('images/members/placeholder.png')); ?>";

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
<?php $__env->stopPush(); ?>

<?php echo $__env->make('admin.layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\laragon\www\u360220114\domains\pengusahagulaindonesia.com\public_html\resources\views/admin/member/edit.blade.php ENDPATH**/ ?>