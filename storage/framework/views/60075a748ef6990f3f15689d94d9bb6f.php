

<?php $__env->startSection('title', 'Manajemen Anggota'); ?>
<?php $__env->startSection('page-title', 'Manajemen Anggota APGI'); ?>

<?php use Illuminate\Support\Facades\Crypt; ?>

<?php $__env->startPush('styles'); ?>
<style>
    .member-logo-preview {
        width: 80px;
        height: 60px;
        object-fit: contain;
        background: #f8f9fa;
        border-radius: 6px;
        padding: 4px;
        border: 1px solid #dee2e6;
    }
    .badge-active   { background-color: #198754; }
    .badge-inactive { background-color: #6c757d; }
    .drag-handle {
        cursor: grab;
        color: #adb5bd;
        font-size: 18px;
    }
    .drag-handle:active { cursor: grabbing; }
    tr.sortable-ghost { opacity: 0.4; background: #e9f7ef; }
    .stat-mini-card {
        border-left: 4px solid;
        border-radius: 8px;
    }
    .stat-mini-card.green { border-color: #198754; }
    .stat-mini-card.gray  { border-color: #6c757d; }
    .stat-mini-card.blue  { border-color: #0d6efd; }
</style>
<?php $__env->stopPush(); ?>

<?php $__env->startSection('content'); ?>


<div class="row g-3 mb-4">
    <div class="col-md-4">
        <div class="card stat-mini-card blue p-3">
            <div class="d-flex justify-content-between align-items-center">
                <div>
                    <div class="text-muted small">Total Anggota</div>
                    <div class="fs-3 fw-bold"><?php echo e($totalMembers); ?></div>
                </div>
                <i class="bi bi-people-fill text-primary fs-2 opacity-50"></i>
            </div>
        </div>
    </div>
    <div class="col-md-4">
        <div class="card stat-mini-card green p-3">
            <div class="d-flex justify-content-between align-items-center">
                <div>
                    <div class="text-muted small">Anggota Aktif</div>
                    <div class="fs-3 fw-bold text-success"><?php echo e($activeMembers); ?></div>
                </div>
                <i class="bi bi-check-circle-fill text-success fs-2 opacity-50"></i>
            </div>
        </div>
    </div>
    <div class="col-md-4">
        <div class="card stat-mini-card gray p-3">
            <div class="d-flex justify-content-between align-items-center">
                <div>
                    <div class="text-muted small">Anggota Nonaktif</div>
                    <div class="fs-3 fw-bold text-secondary"><?php echo e($inactiveMembers); ?></div>
                </div>
                <i class="bi bi-x-circle-fill text-secondary fs-2 opacity-50"></i>
            </div>
        </div>
    </div>
</div>


<div class="card mb-4">
    <div class="card-body">
        <div class="row g-2 align-items-end">
            <div class="col-md-7">
                <form method="GET" action="<?php echo e(route('admin.member.index')); ?>" class="d-flex gap-2">
                    <input type="text" name="search" class="form-control"
                           placeholder="Cari nama anggota..."
                           value="<?php echo e(request('search')); ?>">
                    <select name="status" class="form-select" style="width:160px;flex-shrink:0">
                        <option value="">Semua Status</option>
                        <option value="active"   <?php echo e(request('status') === 'active'   ? 'selected' : ''); ?>>Aktif</option>
                        <option value="inactive" <?php echo e(request('status') === 'inactive' ? 'selected' : ''); ?>>Nonaktif</option>
                    </select>
                    <button type="submit" class="btn btn-primary">
                        <i class="bi bi-search"></i>
                    </button>
                    <?php if(request('search') || request('status')): ?>
                        <a href="<?php echo e(route('admin.member.index')); ?>" class="btn btn-outline-secondary">
                            <i class="bi bi-x-lg"></i>
                        </a>
                    <?php endif; ?>
                </form>
            </div>
            <div class="col-md-5 text-md-end">
                <a href="<?php echo e(route('admin.member.create')); ?>" class="btn btn-primary">
                    <i class="bi bi-plus-lg me-1"></i> Tambah Anggota
                </a>
            </div>
        </div>
    </div>
</div>


<div class="card">
    <div class="card-header d-flex justify-content-between align-items-center">
        <h6 class="mb-0"><i class="bi bi-list-ul me-2"></i>Daftar Anggota</h6>
        <small class="text-muted">
            Drag <i class="bi bi-grip-vertical"></i> untuk mengubah urutan tampil
        </small>
    </div>
    <div class="card-body p-0">
        <?php if($members->isEmpty()): ?>
            <div class="text-center py-5 text-muted">
                <i class="bi bi-people fs-1 d-block mb-2"></i>
                Belum ada anggota.
                <a href="<?php echo e(route('admin.member.create')); ?>">Tambah sekarang</a>
            </div>
        <?php else: ?>
            <div class="table-responsive">
                <table class="table table-hover align-middle mb-0">
                    <thead class="table-light">
                        <tr>
                            <th style="width:40px"></th>
                            <th style="width:50px">#</th>
                            <th style="width:90px">Logo</th>
                            <th>Nama Perusahaan</th>
                            <th style="width:80px">Urutan</th>
                            <th style="width:100px">Status</th>
                            <th style="width:150px">Aksi</th>
                        </tr>
                    </thead>
                    <tbody id="sortable-body">
                        <?php $__currentLoopData = $members; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $i => $member): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <?php $encId = Crypt::encryptString($member->id); ?>
                        <tr data-id="<?php echo e($member->id); ?>">
                            <td class="text-center">
                                <span class="drag-handle"><i class="bi bi-grip-vertical"></i></span>
                            </td>
                            <td class="text-muted small"><?php echo e($members->firstItem() + $i); ?></td>
                            <td>
                                <img src="<?php echo e($member->logo_url); ?>"
                                     alt="<?php echo e($member->name); ?>"
                                     class="member-logo-preview">
                            </td>
                            <td>
                                <div class="fw-semibold"><?php echo e($member->name); ?></div>
                                <small class="text-muted"><?php echo e($member->logo ?? 'placeholder.png'); ?></small>
                            </td>
                            <td class="text-center"><?php echo e($member->sort_order); ?></td>
                            <td>
                                <?php if($member->is_active): ?>
                                    <span class="badge badge-active">Aktif</span>
                                <?php else: ?>
                                    <span class="badge badge-inactive">Nonaktif</span>
                                <?php endif; ?>
                            </td>
                            <td>
                                <div class="d-flex gap-1">
                                    
                                    <form action="<?php echo e(route('admin.member.toggle-status', $encId)); ?>" method="POST">
                                        <?php echo csrf_field(); ?> <?php echo method_field('PATCH'); ?>
                                        <button type="submit"
                                                class="btn btn-sm <?php echo e($member->is_active ? 'btn-outline-warning' : 'btn-outline-success'); ?>"
                                                title="<?php echo e($member->is_active ? 'Nonaktifkan' : 'Aktifkan'); ?>">
                                            <i class="bi <?php echo e($member->is_active ? 'bi-toggle-on' : 'bi-toggle-off'); ?>"></i>
                                        </button>
                                    </form>

                                    
                                    <a href="<?php echo e(route('admin.member.edit', $encId)); ?>"
                                       class="btn btn-sm btn-outline-primary" title="Edit">
                                        <i class="bi bi-pencil"></i>
                                    </a>

                                    
                                    <button type="button" class="btn btn-sm btn-outline-danger"
                                            title="Hapus"
                                            onclick="confirmDelete('<?php echo e($encId); ?>', '<?php echo e(addslashes($member->name)); ?>')">
                                        <i class="bi bi-trash"></i>
                                    </button>
                                </div>
                            </td>
                        </tr>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    </tbody>
                </table>
            </div>

            <?php if($members->hasPages()): ?>
            <div class="card-footer">
                <?php echo e($members->links()); ?>

            </div>
            <?php endif; ?>
        <?php endif; ?>
    </div>
</div>


<form id="delete-form" method="POST" action="">
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
                <p class="mb-0">Hapus anggota<br><strong id="delete-member-name"></strong>?</p>
                <small class="text-muted">Cek kembali sebelum menghapus.</small>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary btn-sm" data-bs-dismiss="modal">Batal</button>
                <button type="button" class="btn btn-danger btn-sm"
                        onclick="document.getElementById('delete-form').submit()">
                    Ya, Hapus
                </button>
            </div>
        </div>
    </div>
</div>

<?php $__env->stopSection(); ?>

<?php $__env->startPush('scripts'); ?>
<script src="https://cdn.jsdelivr.net/npm/sortablejs@1.15.0/Sortable.min.js"></script>
<script>
    // Pakai encrypted ID di action form hapus
    function confirmDelete(encryptedId, name) {
        document.getElementById('delete-form').action =
            '<?php echo e(url('admin/member')); ?>/' + encryptedId;
        document.getElementById('delete-member-name').textContent = name;
        new bootstrap.Modal(document.getElementById('deleteModal')).show();
    }

    const sortableBody = document.getElementById('sortable-body');
    if (sortableBody) {
        Sortable.create(sortableBody, {
            handle: '.drag-handle',
            animation: 150,
            ghostClass: 'sortable-ghost',
            onEnd: function () {
                // update-order tetap pakai ID asli (integer) — aman karena lewat POST body, bukan URL
                const order = [...sortableBody.querySelectorAll('tr[data-id]')]
                    .map(tr => tr.dataset.id);

                fetch('<?php echo e(route('admin.member.update-order')); ?>', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
                    },
                    body: JSON.stringify({ order }),
                })
                .then(r => r.json())
                .then(d => {
                    if (d.success) {
                        const toast = document.createElement('div');
                        toast.className = 'position-fixed bottom-0 end-0 m-3 alert alert-success py-2 px-3 shadow';
                        toast.innerHTML = '<i class="bi bi-check2 me-1"></i> Urutan disimpan';
                        document.body.appendChild(toast);
                        setTimeout(() => toast.remove(), 2000);
                    }
                });
            }
        });
    }
</script>
<?php $__env->stopPush(); ?>
<?php echo $__env->make('admin.layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\laragon\www\u360220114\domains\pengusahagulaindonesia.com\public_html\resources\views/admin/member/index.blade.php ENDPATH**/ ?>