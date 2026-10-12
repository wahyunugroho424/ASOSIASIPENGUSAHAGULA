<?php $__env->startSection('title', 'Detail Galeri'); ?>
<?php $__env->startSection('page-title', 'Detail Galeri'); ?>

<?php $__env->startSection('content'); ?>
<div class="d-flex justify-content-between align-items-center mb-4">
    <h4 class="text-primary">
        <i class="bi bi-image me-2"></i>
        Detail Galeri
    </h4>
    <div>
        <a href="<?php echo e(route('admin.galleries.edit', $gallery)); ?>" class="btn btn-warning">
            <i class="bi bi-pencil me-2"></i>
            Edit
        </a>
        <a href="<?php echo e(route('admin.galleries.index')); ?>" class="btn btn-secondary">
            <i class="bi bi-arrow-left me-2"></i>
            Kembali
        </a>
    </div>
</div>

<div class="row">
    <div class="col-md-8">
        <div class="card">
            <div class="card-header">
                <h6 class="m-0">Informasi Galeri</h6>
            </div>
            <div class="card-body">
                <h3 class="mb-3"><?php echo e($gallery->title); ?></h3>
                
                <?php if($gallery->description): ?>
                <div class="row mb-3">
                    <div class="col-sm-3"><strong>Deskripsi:</strong></div>
                    <div class="col-sm-9"><?php echo e($gallery->description); ?></div>
                </div>
                <?php endif; ?>
                
                <?php if($gallery->alt_text): ?>
                <div class="row mb-3">
                    <div class="col-sm-3"><strong>Alt Text:</strong></div>
                    <div class="col-sm-9"><?php echo e($gallery->alt_text); ?></div>
                </div>
                <?php endif; ?>
                
                <div class="row mb-3">
                    <div class="col-sm-3"><strong>Urutan:</strong></div>
                    <div class="col-sm-9"><?php echo e($gallery->sort_order); ?></div>
                </div>
                
                <div class="row mb-3">
                    <div class="col-sm-3"><strong>Status:</strong></div>
                    <div class="col-sm-9">
                        <?php if($gallery->is_active): ?>
                            <span class="badge bg-success">Aktif</span>
                        <?php else: ?>
                            <span class="badge bg-secondary">Nonaktif</span>
                        <?php endif; ?>
                    </div>
                </div>
                
                <div class="row mb-3">
                    <div class="col-sm-3"><strong>Dibuat:</strong></div>
                    <div class="col-sm-9"><?php echo e($gallery->created_at->format('d M Y H:i')); ?></div>
                </div>
                
                <div class="row mb-3">
                    <div class="col-sm-3"><strong>Diupdate:</strong></div>
                    <div class="col-sm-9"><?php echo e($gallery->updated_at->format('d M Y H:i')); ?></div>
                </div>
            </div>
        </div>
    </div>
    
    <div class="col-md-4">
        <div class="card">
            <div class="card-header">
                <h6 class="m-0">Gambar</h6>
            </div>
            <div class="card-body text-center">
                <img src="<?php echo e($gallery->image_url); ?>" 
                     alt="<?php echo e($gallery->alt_text ?: $gallery->title); ?>" 
                     class="img-fluid rounded"
                     style="max-height: 400px;">
            </div>
        </div>
        
        <div class="card mt-3">
            <div class="card-header">
                <h6 class="m-0">Aksi</h6>
            </div>
            <div class="card-body">
                <div class="d-grid gap-2">
                    <a href="<?php echo e(route('admin.galleries.edit', $gallery)); ?>" class="btn btn-warning">
                        <i class="bi bi-pencil me-2"></i>
                        Edit Galeri
                    </a>
                    
                    <form action="<?php echo e(route('admin.galleries.destroy', $gallery)); ?>" 
                          method="POST" 
                          onsubmit="return confirm('Apakah Anda yakin ingin menghapus gambar ini?')">
                        <?php echo csrf_field(); ?>
                        <?php echo method_field('DELETE'); ?>
                        <button type="submit" class="btn btn-danger w-100">
                            <i class="bi bi-trash me-2"></i>
                            Hapus Galeri
                        </button>
                    </form>
                </div>
            </div>
        </div>
        
        <div class="card mt-3">
            <div class="card-header">
                <h6 class="m-0">Info Teknis</h6>
            </div>
            <div class="card-body">
                <small class="text-muted">
                    <strong>Path:</strong> <?php echo e($gallery->image_path); ?><br>
                    <strong>URL:</strong> <a href="<?php echo e($gallery->image_url); ?>" target="_blank">Lihat gambar</a>
                </small>
            </div>
        </div>
    </div>
</div>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('admin.layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\laragon\www\u360220114\domains\pengusahagulaindonesia.com\public_html\resources\views/admin/galleries/show.blade.php ENDPATH**/ ?>