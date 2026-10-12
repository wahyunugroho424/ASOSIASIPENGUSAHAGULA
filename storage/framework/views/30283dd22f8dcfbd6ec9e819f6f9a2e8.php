<?php $__env->startSection('title', 'Konten Sosial'); ?>
<?php $__env->startSection('page-title', 'Manajemen Konten Sosial'); ?>

<?php $__env->startSection('content'); ?>
<div class="d-flex justify-content-between align-items-center mb-4">
    <h4 class="text-primary">
        <i class="bi bi-newspaper me-2"></i>
        Konten Sosial
    </h4>
    <a href="<?php echo e(route('admin.social-contents.create')); ?>" class="btn btn-primary">
        <i class="bi bi-plus-circle me-2"></i>
        Tambah Konten
    </a>
</div>

<div class="card">
    <div class="card-header">
        <h6 class="m-0">Daftar Konten Sosial</h6>
    </div>
    <div class="card-body">
        <?php if($contents->count() > 0): ?>
            <div class="table-responsive">
                <table class="table table-hover">
                    <thead>
                        <tr>
                            <th>Gambar</th>
                            <th>Judul</th>
                            <th>Tipe</th>
                            <th>Tanggal Publish</th>
                            <th>Status</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php $__currentLoopData = $contents; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $content): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <tr>
                                <td>
                                    <?php if($content->image_path): ?>
                                        <img src="<?php echo e($content->image_url); ?>" 
                                             alt="<?php echo e($content->title); ?>" 
                                             class="img-thumbnail" 
                                             style="width: 60px; height: 60px; object-fit: cover;">
                                    <?php else: ?>
                                        <div class="bg-light d-flex align-items-center justify-content-center" 
                                             style="width: 60px; height: 60px;">
                                            <i class="bi bi-image text-muted"></i>
                                        </div>
                                    <?php endif; ?>
                                </td>
                                <td>
                                    <h6 class="mb-1"><?php echo e($content->title); ?></h6>
                                    <small class="text-muted"><?php echo e(Str::limit($content->description, 60)); ?></small>
                                </td>
                                <td>
                                    <?php switch($content->type):
                                        case ('news'): ?>
                                            <span class="badge bg-primary">Berita</span>
                                            <?php break; ?>
                                        <?php case ('announcement'): ?> 
                                            <span class="badge bg-warning">Pengumuman</span>
                                            <?php break; ?>
                                        <?php case ('activity'): ?>
                                            <span class="badge bg-info">Kegiatan</span>
                                            <?php break; ?>
                                        <?php default: ?>
                                            <span class="badge bg-secondary"><?php echo e(ucfirst($content->type)); ?></span>
                                    <?php endswitch; ?>
                                </td>
                                <td>
                                    <?php if($content->published_at): ?>
                                        <div class="text-sm">
                                            <i class="bi bi-calendar me-1"></i>
                                            <?php echo e($content->formatted_published_date); ?>

                                        </div>
                                    <?php else: ?>
                                        <span class="text-muted">Belum dipublish</span>
                                    <?php endif; ?>
                                </td>
                                <td>
                                    <?php if($content->is_active): ?>
                                        <span class="badge bg-success">Aktif</span>
                                    <?php else: ?>
                                        <span class="badge bg-secondary">Nonaktif</span>
                                    <?php endif; ?>
                                    
                                    <?php if($content->is_featured): ?>
                                        <span class="badge bg-warning">Unggulan</span>
                                    <?php endif; ?>
                                </td>
                                <td>
                                    <div class="btn-group" role="group">
                                        <a href="<?php echo e(route('admin.social-contents.show', $content)); ?>" 
                                           class="btn btn-outline-info btn-sm">
                                            <i class="bi bi-eye"></i>
                                        </a>
                                        <a href="<?php echo e(route('admin.social-contents.edit', $content)); ?>" 
                                           class="btn btn-outline-warning btn-sm">
                                            <i class="bi bi-pencil"></i>
                                        </a>
                                        <form action="<?php echo e(route('admin.social-contents.destroy', $content)); ?>" 
                                              method="POST" 
                                              class="d-inline"
                                              onsubmit="return confirm('Apakah Anda yakin ingin menghapus konten ini?')">
                                            <?php echo csrf_field(); ?>
                                            <?php echo method_field('DELETE'); ?>
                                            <button type="submit" class="btn btn-outline-danger btn-sm">
                                                <i class="bi bi-trash"></i>
                                            </button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    </tbody>
                </table>
            </div>

            <!-- Pagination -->
            <div class="d-flex justify-content-center">
                <?php echo e($contents->links()); ?>

            </div>
        <?php else: ?>
            <div class="text-center py-5">
                <i class="bi bi-newspaper text-muted" style="font-size: 4rem;"></i>
                <h5 class="text-muted mt-3">Belum ada konten sosial</h5>
                <p class="text-muted">Mulai dengan menambahkan konten pertama Anda.</p>
                <a href="<?php echo e(route('admin.social-contents.create')); ?>" class="btn btn-primary">
                    <i class="bi bi-plus-circle me-2"></i>
                    Tambah Konten
                </a>
            </div>
        <?php endif; ?>
    </div>
</div>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('admin.layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\laragon\www\u360220114\domains\pengusahagulaindonesia.com\public_html\resources\views/admin/social-contents/index.blade.php ENDPATH**/ ?>