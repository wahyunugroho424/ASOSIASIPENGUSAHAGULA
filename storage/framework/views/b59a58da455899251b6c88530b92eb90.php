<?php $__env->startSection('title', 'Kelola News'); ?>

<?php $__env->startSection('content'); ?>
<div class="d-flex justify-content-between align-items-center mb-4">
    <h2>Kelola News</h2>
    <a href="<?php echo e(route('admin.news.create')); ?>" class="btn btn-primary">
        <i class="fas fa-plus"></i> Tambah News
    </a>
</div>

<?php if(session('success')): ?>
    <div class="alert alert-success alert-dismissible fade show" role="alert">
        <?php echo e(session('success')); ?>

        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
    </div>
<?php endif; ?>

<div class="card">
    <div class="card-body">
        <?php if($news->count() > 0): ?>
            <div class="table-responsive">
                <table class="table table-striped">
                    <thead>
                        <tr>
                            <th style="width: 80px;">Gambar</th>
                            <th style="width: 35%;">Judul</th>
                            <th style="width: 12%;">Author</th>
                            <th style="width: 12%;">Publish</th>
                            <th style="width: 10%;">Link</th>
                            <th style="width: 10%;">Status</th>
                            <th style="width: 150px;">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php $__currentLoopData = $news; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $article): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <tr>
                            <td>
                                <?php if($article->image_path): ?>
                                    <img src="<?php echo e($article->image_url); ?>" 
                                         alt="<?php echo e($article->title); ?>" 
                                         class="img-thumbnail" 
                                         style="width: 60px; height: 60px; object-fit: cover;">
                                <?php else: ?>
                                    <div class="bg-light d-flex align-items-center justify-content-center" 
                                         style="width: 60px; height: 60px;">
                                        <i class="fas fa-newspaper text-muted"></i>
                                    </div>
                                <?php endif; ?>
                            </td>
                            <td>
                                <strong><?php echo e(Str::limit($article->title, 60)); ?></strong>
                                <br>
                                <small class="text-muted"><?php echo e(Str::limit($article->excerpt, 80)); ?></small>
                            </td>
                            <td><?php echo e($article->author ?? '-'); ?></td>
                            <td>
                                <?php if($article->published_at): ?>
                                    <small><?php echo e($article->formatted_published_date); ?></small>
                                    <br><small class="text-muted"><?php echo e($article->published_at->format('H:i')); ?></small>
                                <?php else: ?>
                                    <span class="text-muted">Draft</span>
                                <?php endif; ?>
                            </td>
                            <td>
                                <?php if($article->link): ?>
                                    <a href="<?php echo e($article->link); ?>" 
                                       target="_blank" 
                                       class="btn btn-sm btn-outline-primary"
                                       title="<?php echo e($article->link); ?>">
                                        <i class="fas fa-external-link-alt"></i>
                                    </a>
                                <?php else: ?>
                                    <span class="text-muted">-</span>
                                <?php endif; ?>
                            </td>
                            <td>
                                <?php if($article->is_active): ?>
                                    <span class="badge bg-success mb-1">Aktif</span>
                                <?php else: ?>
                                    <span class="badge bg-secondary mb-1">Nonaktif</span>
                                <?php endif; ?>
                                
                                <?php if($article->is_featured): ?>
                                    <br><span class="badge bg-warning">Featured</span>
                                <?php endif; ?>
                            </td>
                            <td>
                                <div class="d-flex flex-column gap-1">
                                    <a href="<?php echo e(route('admin.news.show', $article)); ?>" 
                                       class="btn btn-sm btn-outline-info"
                                       title="Lihat">
                                        <i class="fas fa-eye"></i> Lihat
                                    </a>
                                    <a href="<?php echo e(route('admin.news.edit', $article)); ?>" 
                                       class="btn btn-sm btn-outline-warning"
                                       title="Edit">
                                        <i class="fas fa-edit"></i> Edit
                                    </a>
                                    <form action="<?php echo e(route('admin.news.destroy', $article)); ?>" 
                                          method="POST" 
                                          onsubmit="return confirm('Yakin ingin menghapus berita ini?')">
                                        <?php echo csrf_field(); ?>
                                        <?php echo method_field('DELETE'); ?>
                                        <button type="submit" 
                                                class="btn btn-sm btn-outline-danger"
                                                title="Hapus">
                                            <i class="fas fa-trash"></i> Hapus
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    </tbody>
                </table>
            </div>
            
            <?php echo e($news->links()); ?>

        <?php else: ?>
            <div class="text-center py-5">
                <i class="fas fa-newspaper fa-3x text-muted mb-3"></i>
                <h5 class="text-muted">Belum ada berita</h5>
                <p class="text-muted">Klik tombol "Tambah News" untuk menambah berita pertama</p>
            </div>
        <?php endif; ?>
    </div>
</div>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('admin.layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\laragon\www\u360220114\domains\pengusahagulaindonesia.com\public_html\resources\views/admin/news/index.blade.php ENDPATH**/ ?>