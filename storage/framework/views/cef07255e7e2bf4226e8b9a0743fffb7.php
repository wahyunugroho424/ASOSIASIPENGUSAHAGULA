<?php $__env->startSection('title', 'Event'); ?>
<?php $__env->startSection('page-title', 'Manajemen Event'); ?>

<?php $__env->startSection('content'); ?>
<div class="d-flex justify-content-between align-items-center mb-4">
    <h4 class="text-primary">
        <i class="bi bi-calendar-event me-2"></i>
        Event
    </h4>
    <a href="<?php echo e(route('admin.events.create')); ?>" class="btn btn-primary">
        <i class="bi bi-plus-circle me-2"></i>
        Tambah Event
    </a>
</div>

<div class="card">
    <div class="card-header">
        <h6 class="m-0">Daftar Event</h6>
    </div>
    <div class="card-body">
        <?php if($events->count() > 0): ?>
            <div class="table-responsive">
                <table class="table table-hover">
                    <thead>
                        <tr>
                            <th>Gambar</th>
                            <th>Judul</th>
                            <th>Tanggal</th>
                            <th>Lokasi</th>
                            <th>Status</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php $__currentLoopData = $events; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $event): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <tr>
                                <td>
                                    <?php if($event->image_path): ?>
                                        <img src="<?php echo e($event->image_url); ?>" 
                                             alt="<?php echo e($event->title); ?>" 
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
                                    <h6 class="mb-1"><?php echo e($event->title); ?></h6>
                                    <small class="text-muted"><?php echo e(Str::limit($event->description, 50)); ?></small>
                                </td>
                                <td>
                                    <div class="text-sm">
                                        <i class="bi bi-calendar me-1"></i>
                                        <?php echo e($event->formatted_date); ?>

                                    </div>
                                    <?php if($event->event_time): ?>
                                        <div class="text-sm text-muted">
                                            <i class="bi bi-clock me-1"></i>
                                            <?php echo e($event->formatted_time); ?>

                                        </div>
                                    <?php endif; ?>
                                </td>
                                <td>
                                    <?php if($event->location): ?>
                                        <small class="text-muted">
                                            <i class="bi bi-geo-alt me-1"></i>
                                            <?php echo e($event->location); ?>

                                        </small>
                                    <?php else: ?>
                                        <span class="text-muted">-</span>
                                    <?php endif; ?>
                                </td>
                                <td>
                                    <?php if($event->is_active): ?>
                                        <span class="badge bg-success">Aktif</span>
                                    <?php else: ?>
                                        <span class="badge bg-secondary">Nonaktif</span>
                                    <?php endif; ?>
                                    
                                    <?php if($event->is_featured): ?>
                                        <span class="badge bg-warning">Unggulan</span>
                                    <?php endif; ?>
                                </td>
                                <td>
                                    <div class="btn-group" role="group">
                                        <a href="<?php echo e(route('admin.events.show', $event)); ?>" 
                                           class="btn btn-outline-info btn-sm">
                                            <i class="bi bi-eye"></i>
                                        </a>
                                        <a href="<?php echo e(route('admin.events.edit', $event)); ?>" 
                                           class="btn btn-outline-warning btn-sm">
                                            <i class="bi bi-pencil"></i>
                                        </a>
                                        <form action="<?php echo e(route('admin.events.destroy', $event)); ?>" 
                                              method="POST" 
                                              class="d-inline"
                                              onsubmit="return confirm('Apakah Anda yakin ingin menghapus event ini?')">
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
                <?php echo e($events->links()); ?>

            </div>
        <?php else: ?>
            <div class="text-center py-5">
                <i class="bi bi-calendar-event text-muted" style="font-size: 4rem;"></i>
                <h5 class="text-muted mt-3">Belum ada event</h5>
                <p class="text-muted">Mulai dengan menambahkan event pertama Anda.</p>
                <a href="<?php echo e(route('admin.events.create')); ?>" class="btn btn-primary">
                    <i class="bi bi-plus-circle me-2"></i>
                    Tambah Event
                </a>
            </div>
        <?php endif; ?>
    </div>
</div>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('admin.layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\laragon\www\u360220114\domains\pengusahagulaindonesia.com\public_html\resources\views/admin/events/index.blade.php ENDPATH**/ ?>