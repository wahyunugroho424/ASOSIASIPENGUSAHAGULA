
<?php $__env->startSection('title', 'Struktur Organisasi'); ?>

<?php $__env->startSection('content'); ?>

<style>
    .section-badge {
        font-size: 0.7rem;
        padding: 4px 10px;
        border-radius: 20px;
        font-weight: 600;
        letter-spacing: 0.5px;
    }
    .org-section-card {
        border: none;
        border-radius: 14px;
        box-shadow: 0 2px 12px rgba(0,0,0,0.07);
        overflow: hidden;
        margin-bottom: 1.5rem;
        transition: box-shadow 0.2s;
    }
    .org-section-card:hover {
        box-shadow: 0 4px 20px rgba(0,0,0,0.12);
    }
    .org-section-header {
        padding: 14px 20px;
        display: flex;
        align-items: center;
        justify-content: space-between;
        border-bottom: 1px solid rgba(0,0,0,0.06);
    }
    .section-icon-wrap {
        width: 32px;
        height: 32px;
        border-radius: 8px;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 14px;
        margin-right: 10px;
        flex-shrink: 0;
    }
    .org-item-row {
        display: flex;
        align-items: center;
        padding: 12px 20px;
        border-bottom: 1px solid #f5f5f5;
        transition: background 0.15s;
        gap: 14px;
    }
    .org-item-row:last-child {
        border-bottom: none;
    }
    .org-item-row:hover {
        background: #f9fafb;
    }
    .drag-handle {
        color: #ccc;
        cursor: grab;
        font-size: 16px;
        flex-shrink: 0;
        transition: color 0.2s;
    }
    .drag-handle:hover {
        color: #28a745;
    }
    .org-avatar {
        width: 42px;
        height: 42px;
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 15px;
        color: white;
        flex-shrink: 0;
        background: linear-gradient(135deg, #28a745, #20c997);
    }
    .org-info {
        flex: 1;
        min-width: 0;
    }
    .org-name {
        font-weight: 600;
        font-size: 0.92rem;
        color: #1a1a2e;
        white-space: nowrap;
        overflow: hidden;
        text-overflow: ellipsis;
    }
    .org-title-label {
        font-size: 0.78rem;
        color: #888;
        margin-top: 1px;
    }
    .org-actions {
        display: flex;
        align-items: center;
        gap: 6px;
        flex-shrink: 0;
    }
    .btn-action {
        width: 32px;
        height: 32px;
        border-radius: 8px;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 13px;
        border: none;
        transition: all 0.2s;
        text-decoration: none;
    }
    .btn-edit {
        background: #e8f5e9;
        color: #28a745;
    }
    .btn-edit:hover {
        background: #28a745;
        color: white;
    }
    .btn-del {
        background: #fdecea;
        color: #e53935;
    }
    .btn-del:hover {
        background: #e53935;
        color: white;
    }
    .status-dot {
        width: 8px;
        height: 8px;
        border-radius: 50%;
        flex-shrink: 0;
    }
    .status-dot.active { background: #28a745; }
    .status-dot.inactive { background: #bbb; }
    .empty-section {
        padding: 24px;
        text-align: center;
        color: #bbb;
        font-size: 0.85rem;
    }
    .empty-section i { font-size: 1.5rem; display: block; margin-bottom: 6px; }
    .page-header {
        background: white;
        border-radius: 14px;
        padding: 20px 24px;
        margin-bottom: 24px;
        box-shadow: 0 2px 12px rgba(0,0,0,0.06);
        display: flex;
        align-items: center;
        justify-content: space-between;
    }
    .page-header-left h4 {
        margin: 0;
        font-weight: 700;
        font-size: 1.2rem;
        color: #1a1a2e;
    }
    .page-header-left p {
        margin: 4px 0 0;
        font-size: 0.82rem;
        color: #999;
    }
    .btn-add {
        background: linear-gradient(135deg, #28a745, #20c997);
        color: white;
        border: none;
        border-radius: 10px;
        padding: 9px 18px;
        font-size: 0.88rem;
        font-weight: 600;
        display: flex;
        align-items: center;
        gap: 7px;
        text-decoration: none;
        transition: all 0.2s;
        box-shadow: 0 3px 10px rgba(40,167,69,0.3);
    }
    .btn-add:hover {
        color: white;
        transform: translateY(-1px);
        box-shadow: 0 5px 15px rgba(40,167,69,0.4);
    }
    .stats-row {
        display: flex;
        gap: 12px;
        margin-bottom: 20px;
        flex-wrap: wrap;
    }
    .stat-chip {
        background: white;
        border-radius: 10px;
        padding: 10px 16px;
        font-size: 0.82rem;
        box-shadow: 0 1px 6px rgba(0,0,0,0.07);
        display: flex;
        align-items: center;
        gap: 8px;
        color: #555;
        font-weight: 500;
    }
    .stat-chip i { color: #28a745; }
    .stat-chip span { font-weight: 700; color: #1a1a2e; }

    /* Section color themes */
    .theme-gold    .section-icon-wrap { background: #fff8e1; color: #f59e0b; }
    .theme-gold    .org-section-header { background: linear-gradient(135deg, #fffde7, #fff8e1); }
    .theme-green   .section-icon-wrap { background: #e8f5e9; color: #28a745; }
    .theme-green   .org-section-header { background: linear-gradient(135deg, #f1f8e9, #e8f5e9); }
    .theme-blue    .section-icon-wrap { background: #e3f2fd; color: #1976d2; }
    .theme-blue    .org-section-header { background: linear-gradient(135deg, #e8f4fd, #e3f2fd); }
    .theme-cyan    .section-icon-wrap { background: #e0f7fa; color: #00acc1; }
    .theme-cyan    .org-section-header { background: linear-gradient(135deg, #e0f7fa, #b2ebf2); }
    .theme-purple  .section-icon-wrap { background: #f3e5f5; color: #7b1fa2; }
    .theme-purple  .org-section-header { background: linear-gradient(135deg, #fce4ec, #f3e5f5); }

    .theme-gold   .org-avatar { background: linear-gradient(135deg, #f59e0b, #fbbf24); }
    .theme-green  .org-avatar { background: linear-gradient(135deg, #28a745, #20c997); }
    .theme-blue   .org-avatar { background: linear-gradient(135deg, #1976d2, #42a5f5); }
    .theme-cyan   .org-avatar { background: linear-gradient(135deg, #00acc1, #26c6da); }
    .theme-purple .org-avatar { background: linear-gradient(135deg, #7b1fa2, #ab47bc); }

    .section-title-text { font-weight: 700; font-size: 0.95rem; color: #1a1a2e; }

    .sortable-ghost { opacity: 0.4; background: #e8f5e9 !important; }
    .sortable-chosen { box-shadow: 0 4px 16px rgba(40,167,69,0.2); }

    .drag-hint {
        font-size: 0.72rem;
        color: #bbb;
        margin-left: 4px;
    }
</style>

<?php
$sectionThemes = [
    'leader'          => ['theme' => 'theme-gold',   'icon' => 'bi bi-star-fill'],
    'vice'            => ['theme' => 'theme-green',  'icon' => 'bi bi-person-badge-fill'],
    'staff'           => ['theme' => 'theme-blue',   'icon' => 'bi bi-people-fill'],
    'department'      => ['theme' => 'theme-green',  'icon' => 'bi bi-briefcase-fill'],
    'humas'           => ['theme' => 'theme-cyan',   'icon' => 'bi bi-megaphone-fill'],
    'board_pembina'   => ['theme' => 'theme-purple', 'icon' => 'bi bi-shield-fill'],
    'board_penasihat' => ['theme' => 'theme-purple', 'icon' => 'bi bi-award-fill'],
];

$totalData = 0;
foreach($structures as $group) {
    $totalData += $group->count();
}
?>


<div class="page-header">
    <div class="page-header-left">
        <h4><i class="bi bi-diagram-3 me-2 text-success"></i>Struktur Organisasi</h4>
        <p>Kelola dan atur urutan struktur kepengurusan APGI</p>
    </div>
    <a href="<?php echo e(route('admin.structure.create')); ?>" class="btn-add">
        <i class="bi bi-plus-lg"></i> Tambah Data
    </a>
</div>


<div class="stats-row">
    <div class="stat-chip">
        <i class="bi bi-people-fill"></i>
        Total Pengurus: <span><?php echo e($totalData); ?></span>
    </div>
    <div class="stat-chip">
        <i class="bi bi-grid-fill"></i>
        Seksi: <span><?php echo e(count($sections)); ?></span>
    </div>
    <div class="stat-chip">
        <i class="bi bi-arrows-move"></i>
        <span class="drag-hint">Drag & drop untuk atur urutan</span>
    </div>
</div>


<?php if(session('success')): ?>
    <div class="alert alert-success alert-dismissible fade show rounded-3 border-0 shadow-sm mb-4" role="alert">
        <i class="bi bi-check-circle-fill me-2"></i><?php echo e(session('success')); ?>

        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
    </div>
<?php endif; ?>


<?php $__currentLoopData = $sections; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $sectionKey => $sectionLabel): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
<?php
    $theme = $sectionThemes[$sectionKey] ?? ['theme' => 'theme-green', 'icon' => 'bi bi-person'];
    $items = $structures[$sectionKey] ?? collect();
?>
<div class="org-section-card <?php echo e($theme['theme']); ?>">
    <div class="org-section-header">
        <div class="d-flex align-items-center">
            <div class="section-icon-wrap">
                <i class="<?php echo e($theme['icon']); ?>"></i>
            </div>
            <div>
                <div class="section-title-text"><?php echo e($sectionLabel); ?></div>
            </div>
        </div>
        <span class="section-badge bg-light text-secondary border">
            <?php echo e($items->count()); ?> orang
        </span>
    </div>

    <div class="card-body p-0">
        <?php if($items->count() > 0): ?>
            <ul class="list-unstyled mb-0 sortable-list" data-section="<?php echo e($sectionKey); ?>">
                <?php $__currentLoopData = $items; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                <li class="org-item-row" data-id="<?php echo e($item->id); ?>">
                    
                    <i class="bi bi-grip-vertical drag-handle"></i>

                    
                    <div class="org-avatar">
                        <i class="<?php echo e($item->icon ?? 'bi bi-person'); ?>"></i>
                    </div>

                    
                    <div class="org-info">
                        <div class="org-name"><?php echo e($item->name); ?></div>
                        <div class="org-title-label">
                            <i class="bi bi-briefcase me-1" style="font-size:0.7rem;"></i>
                            <?php echo e($item->title); ?>

                        </div>
                    </div>

                    
                    <div class="d-flex align-items-center gap-1 me-2">
                        <span class="status-dot <?php echo e($item->is_active ? 'active' : 'inactive'); ?>"></span>
                        <span style="font-size:0.75rem; color: <?php echo e($item->is_active ? '#28a745' : '#bbb'); ?>; font-weight:500;">
                            <?php echo e($item->is_active ? 'Aktif' : 'Nonaktif'); ?>

                        </span>
                    </div>

                    
                    <div class="org-actions">
                        <a href="<?php echo e(route('admin.structure.edit', $item)); ?>" class="btn-action btn-edit" title="Edit">
                            <i class="bi bi-pencil-fill"></i>
                        </a>
                        <form action="<?php echo e(route('admin.structure.destroy', $item)); ?>"
                              method="POST"
                              onsubmit="return confirm('Hapus <?php echo e(addslashes($item->name)); ?>?')"
                              style="margin:0;">
                            <?php echo csrf_field(); ?> <?php echo method_field('DELETE'); ?>
                            <button type="submit" class="btn-action btn-del" title="Hapus">
                                <i class="bi bi-trash-fill"></i>
                            </button>
                        </form>
                    </div>
                </li>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            </ul>
        <?php else: ?>
            <div class="empty-section">
                <i class="bi bi-inbox"></i>
                Belum ada data untuk seksi ini
            </div>
        <?php endif; ?>
    </div>
</div>
<?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>

<?php $__env->startPush('scripts'); ?>
<script src="https://cdn.jsdelivr.net/npm/sortablejs@1.15.0/Sortable.min.js"></script>
<script>
document.querySelectorAll('.sortable-list').forEach(function(el) {
    Sortable.create(el, {
        handle: '.drag-handle',
        animation: 200,
        ghostClass: 'sortable-ghost',
        chosenClass: 'sortable-chosen',
        onEnd: function() {
            const ids = [...el.querySelectorAll('li[data-id]')].map(li => li.dataset.id);
            fetch('<?php echo e(route('admin.structure.update-order')); ?>', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': '<?php echo e(csrf_token()); ?>'
                },
                body: JSON.stringify({ order: ids })
            }).then(res => res.json()).then(data => {
                if (data.success) {
                    // Flash subtle success
                    el.style.transition = 'background 0.3s';
                    el.style.background = '#f0fff4';
                    setTimeout(() => el.style.background = '', 600);
                }
            });
        }
    });
});
</script>
<?php $__env->stopPush(); ?>

<?php $__env->stopSection(); ?>
<?php echo $__env->make('admin.layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\laragon\www\u360220114\domains\pengusahagulaindonesia.com\public_html\resources\views/admin/structure/index.blade.php ENDPATH**/ ?>