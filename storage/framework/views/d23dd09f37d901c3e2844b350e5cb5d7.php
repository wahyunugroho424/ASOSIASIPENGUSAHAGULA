<?php $__env->startPush('styles'); ?>
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/cropperjs/1.6.2/cropper.min.css">
<style>
    .crop-stage { background:#212529; border-radius:10px; overflow:hidden; max-height:60vh; }
    .crop-stage img { display:block; max-width:100%; }
    .crop-toolbar { display:flex; flex-wrap:wrap; gap:6px; margin-top:12px; }
    .crop-toolbar .btn { font-size:13px; }
    .crop-toolbar .btn.active { background:#198754; border-color:#198754; color:#fff; }
    .crop-sep { width:1px; background:#dee2e6; margin:0 4px; }
</style>
<?php $__env->stopPush(); ?>

<div class="modal fade" id="cropModal" tabindex="-1" aria-hidden="true" data-bs-backdrop="static">
    <div class="modal-dialog modal-lg modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h6 class="modal-title mb-0">Atur Posisi Foto</h6>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Tutup"></button>
            </div>
            <div class="modal-body">
                <div class="crop-stage"><img id="cropImage" alt="Foto yang akan di-crop"></div>

                <div class="crop-toolbar">
                    <button type="button" class="btn btn-outline-secondary btn-sm" onclick="cropMove(0,-30)">▲ Geser ke atas</button>
                    <button type="button" class="btn btn-outline-secondary btn-sm" onclick="cropMove(0,30)">▼ Geser ke bawah</button>
                    <span class="crop-sep"></span>
                    <button type="button" class="btn btn-outline-secondary btn-sm" onclick="cropZoom(0.1)">＋ Zoom</button>
                    <button type="button" class="btn btn-outline-secondary btn-sm" onclick="cropZoom(-0.1)">－ Zoom</button>
                    <button type="button" class="btn btn-outline-secondary btn-sm" onclick="cropRotate(-90)">⟲</button>
                    <button type="button" class="btn btn-outline-secondary btn-sm" onclick="cropRotate(90)">⟳</button>
                    <button type="button" class="btn btn-outline-secondary btn-sm" onclick="cropReset()">Reset</button>
                </div>

                <div class="crop-toolbar">
                    <span class="small text-muted align-self-center me-1">Rasio:</span>
                    <button type="button" class="btn btn-outline-success btn-sm active" data-aspect onclick="setCropAspect(3/4, this)">3:4 (potret)</button>
                    <button type="button" class="btn btn-outline-success btn-sm" data-aspect onclick="setCropAspect(1, this)">1:1</button>
                    <button type="button" class="btn btn-outline-success btn-sm" data-aspect onclick="setCropAspect(NaN, this)">Bebas</button>
                </div>

                <div class="small text-muted mt-2">
                    Geser foto di dalam bingkai untuk memilih bagian atas atau bawahnya. Tarik sudut bingkai untuk mengubah ukuran.
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary btn-sm" data-bs-dismiss="modal">Batal</button>
                <button type="button" class="btn btn-success btn-sm" onclick="applyCrop()">Gunakan Foto Ini</button>
            </div>
        </div>
    </div>
</div>

<?php $__env->startPush('scripts'); ?>
<script src="https://cdnjs.cloudflare.com/ajax/libs/cropperjs/1.6.2/cropper.min.js"></script>
<script>
let cropper = null, cropObjectUrl = null, cropModalInstance = null;
let cropFileName = 'foto', cropApplied = false, cropIsNew = false, lastCroppedFile = null;

function getCropModal() {
    if (!cropModalInstance) {
        cropModalInstance = new bootstrap.Modal(document.getElementById('cropModal'));
    }
    return cropModalInstance;
}

function startCropper(src, name, isNew) {
    cropFileName = (name || 'foto').replace(/\.[^.]+$/, '').replace(/[^\w-]+/g, '-') || 'foto';
    cropApplied = false;
    cropIsNew = isNew;
    document.getElementById('cropImage').src = src;
    getCropModal().show();
}

// Dari file yang baru dipilih atau di-drag
function openCropper(file) {
    if (!file || !file.type.startsWith('image/')) return;
    if (cropObjectUrl) URL.revokeObjectURL(cropObjectUrl);
    cropObjectUrl = URL.createObjectURL(file);
    startCropper(cropObjectUrl, file.name, true);
}

// Dari foto yang sudah tersimpan di server (halaman edit)
function openCropperFromUrl(url, name) {
    startCropper(url + (url.includes('?') ? '&' : '?') + 't=' + Date.now(), name, false);
}

document.addEventListener('DOMContentLoaded', function () {
    const modalEl = document.getElementById('cropModal');
    const img = document.getElementById('cropImage');

    modalEl.addEventListener('shown.bs.modal', function () {
        if (cropper) cropper.destroy();
        cropper = new Cropper(img, {
            aspectRatio: 3 / 4,
            viewMode: 1,
            dragMode: 'move',
            autoCropArea: 1,
            background: false,
            responsive: true,
            cropBoxMovable: true,
            cropBoxResizable: true,
            toggleDragModeOnDblclick: false,
        });
        document.querySelectorAll('[data-aspect]').forEach((b, i) => b.classList.toggle('active', i === 0));
    });

    modalEl.addEventListener('hidden.bs.modal', function () {
        if (cropper) { cropper.destroy(); cropper = null; }
        img.removeAttribute('src');

        // Dibatalkan: kembalikan input file ke kondisi sebelumnya
        if (cropIsNew && !cropApplied) {
            const input = document.getElementById('inp-photo');
            const wrap  = document.getElementById('photoPreviewWrap');
            const previewVisible = wrap && wrap.style.display !== 'none';
            if (lastCroppedFile && previewVisible) {
                const dt = new DataTransfer();
                dt.items.add(lastCroppedFile);
                input.files = dt.files;
            } else {
                input.value = '';
            }
        }
    });
});

function cropMove(dx, dy)  { if (cropper) cropper.move(dx, dy); }
function cropZoom(r)       { if (cropper) cropper.zoom(r); }
function cropRotate(deg)   { if (cropper) cropper.rotate(deg); }
function cropReset()       { if (cropper) cropper.reset(); }

function setCropAspect(ratio, btn) {
    if (!cropper) return;
    cropper.setAspectRatio(ratio);
    document.querySelectorAll('[data-aspect]').forEach(b => b.classList.remove('active'));
    btn.classList.add('active');
}

function applyCrop() {
    if (!cropper) return;
    let canvas = null;
    try {
        canvas = cropper.getCroppedCanvas({
            maxWidth: 900,
            maxHeight: 1200,
            fillColor: '#ffffff',
            imageSmoothingQuality: 'high',
        });
    } catch (e) { canvas = null; }

    if (!canvas) {
        alert('Foto tidak dapat diproses di browser. Unggah ulang file aslinya dari komputer.');
        return;
    }

    try {
        canvas.toBlob(function (blob) {
            if (!blob) {
                alert('Gagal membuat hasil crop. Coba lagi.');
                return;
            }
            const file = new File([blob], cropFileName + '-crop.jpg', {
                type: 'image/jpeg',
                lastModified: Date.now(),
            });
            const dt = new DataTransfer();
            dt.items.add(file);
            document.getElementById('inp-photo').files = dt.files;

            lastCroppedFile = file;
            cropApplied = true;
            showPhotoPreview(file);   // fungsi bawaan di halaman create/edit
            getCropModal().hide();
        }, 'image/jpeg', 0.9);
    } catch (e) {
        alert('Foto ini berasal dari alamat lain, sehingga tidak bisa di-crop dari browser. Unggah ulang file aslinya dari komputer.');
    }
}
</script>
<?php $__env->stopPush(); ?><?php /**PATH C:\laragon\www\u360220114\domains\pengusahagulaindonesia.com\public_html\resources\views/admin/structure/_cropper.blade.php ENDPATH**/ ?>