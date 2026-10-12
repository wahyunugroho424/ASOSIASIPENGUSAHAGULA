<?php $__env->startSection('title', 'Galeri'); ?>
<?php $__env->startSection('page-title', 'Manajemen Galeri'); ?>

<?php $__env->startSection('content'); ?>
<div class="d-flex justify-content-between align-items-center mb-4">
    <h4 class="text-primary">
        <i class="bi bi-images me-2"></i>
        Galeri
    </h4>
    <a href="<?php echo e(route('admin.galleries.create')); ?>" class="btn btn-primary">
        <i class="bi bi-plus-circle me-2"></i>
        Tambah Galeri
    </a>
</div>

<div class="card">
    <div class="card-header">
        <h6 class="m-0">Daftar Galeri</h6>
    </div>
    <div class="card-body">
        <?php if($galleries->count() > 0): ?>
            <div class="row">
                <?php $__currentLoopData = $galleries; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $gallery): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <div class="col-lg-3 col-md-4 col-sm-6 mb-4">
                        <div class="card h-100">
                            <div class="position-relative">
                                <img src="<?php echo e($gallery->image_url); ?>" 
                                     class="card-img-top" 
                                     alt="<?php echo e($gallery->alt_text); ?>"
                                     style="height: 200px; object-fit: cover;">
                                
                                <!-- Status Badge -->
                                <div class="position-absolute top-0 end-0 m-2">
                                    <?php if($gallery->is_active): ?>
                                        <span class="badge bg-success">Aktif</span>
                                    <?php else: ?>
                                        <span class="badge bg-secondary">Nonaktif</span>
                                    <?php endif; ?>
                                </div>
                                
                                <!-- Category Badge -->
                                <div class="position-absolute top-0 start-0 m-2">
                                    <span class="badge bg-primary"><?php echo e($gallery->category_label); ?></span>
                                </div>
                            </div>
                            
                            <div class="card-body d-flex flex-column">
                                <h6 class="card-title"><?php echo e($gallery->title); ?></h6>
                                <?php if($gallery->description): ?>
                                    <p class="card-text text-muted small flex-grow-1">
                                        <?php echo e(Str::limit($gallery->description, 80)); ?>

                                    </p>
                                <?php endif; ?>
                                
                                <div class="text-muted small mb-2">
                                    <i class="bi bi-sort-numeric-down me-1"></i>
                                    Urutan: <?php echo e($gallery->sort_order); ?>

                                </div>
                                
                                <div class="mt-auto">
                                    <div class="btn-group w-100" role="group">
                                        <a href="<?php echo e(route('admin.galleries.show', $gallery)); ?>" 
                                           class="btn btn-outline-info btn-sm">
                                            <i class="bi bi-eye"></i>
                                        </a>
                                        <a href="<?php echo e(route('admin.galleries.edit', $gallery)); ?>" 
                                           class="btn btn-outline-warning btn-sm">
                                            <i class="bi bi-pencil"></i>
                                        </a>
                                        <form action="<?php echo e(route('admin.galleries.destroy', $gallery)); ?>" 
                                              method="POST" 
                                              class="d-inline"
                                              onsubmit="return confirm('Apakah Anda yakin ingin menghapus galeri ini?')">
                                            <?php echo csrf_field(); ?>
                                            <?php echo method_field('DELETE'); ?>
                                            <button type="submit" class="btn btn-outline-danger btn-sm">
                                                <i class="bi bi-trash"></i>
                                            </button>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            </div>

            <!-- Pagination -->
            <div class="d-flex justify-content-center">
                <?php echo e($galleries->links()); ?>

            </div>
        <?php else: ?>
            <div class="text-center py-5">
                <i class="bi bi-images text-muted" style="font-size: 4rem;"></i>
                <h5 class="text-muted mt-3">Belum ada galeri</h5>
                <p class="text-muted">Mulai dengan menambahkan galeri pertama Anda.</p>
                <a href="<?php echo e(route('admin.galleries.create')); ?>" class="btn btn-primary">
                    <i class="bi bi-plus-circle me-2"></i>
                    Tambah Galeri
                </a>
            </div>
        <?php endif; ?>
    </div>
</div>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('admin.layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\laragon\www\u360220114\domains\pengusahagulaindonesia.com\public_html\resources\views/admin/galleries/index.blade.php ENDPATH**/ ?>