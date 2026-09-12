<?php require_once '../app/views/layout/header.php'; ?>

<main class="py-5 bg-light" style="min-height: 80vh;">
    <div class="container">
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="<?php echo ROOT; ?>/admin" class="text-decoration-none">Dashboard</a></li>
                <li class="breadcrumb-item active" aria-current="page">Manage Media</li>
            </ol>
        </nav>

        <div class="d-flex justify-content-between align-items-center mb-4">
            <h2 class="fw-bold">Manage Media</h2>
            <div class="d-flex gap-2">
                <a href="<?php echo ROOT; ?>/admin" class="btn btn-outline-secondary rounded-pill fw-bold">
                    <i class="fas fa-arrow-left me-2"></i> Dashboard
                </a>
                <button class="btn btn-info rounded-pill fw-bold text-white" data-bs-toggle="modal" data-bs-target="#uploadModal">
                    <i class="fas fa-plus me-2"></i> Upload Media
                </button>
            </div>
        </div>

        <?php if (isset($_GET['success'])): ?>
            <div class="alert alert-success alert-dismissible fade show border-0 shadow-sm rounded-3 mb-4" role="alert">
                <i class="fas fa-check-circle me-2"></i> Media uploaded successfully!
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        <?php endif; ?>

        <?php if (isset($_GET['updated'])): ?>
            <div class="alert alert-success alert-dismissible fade show border-0 shadow-sm rounded-3 mb-4" role="alert">
                <i class="fas fa-edit me-2"></i> Media updated successfully!
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        <?php endif; ?>

        <?php if (isset($_GET['deleted'])): ?>
            <div class="alert alert-danger alert-dismissible fade show border-0 shadow-sm rounded-3 mb-4" role="alert">
                <i class="fas fa-trash me-2"></i> Media deleted successfully!
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        <?php endif; ?>

        <div class="row g-4">
            <?php if (empty($items)): ?>
                <div class="col-12 text-center py-5 text-muted">No media items found.</div>
            <?php else: ?>
                <?php foreach ($items as $item): ?>
                    <div class="col-md-3">
                        <div class="card border-0 shadow-sm rounded-4 overflow-hidden h-100">
                            <?php if ($item['type'] == 'image'): ?>
                                <img src="<?php echo ROOT . '/' . $item['file_path']; ?>" class="card-img-top" style="height: 180px; object-fit: cover; cursor: pointer;" 
                                     onclick="previewFile('<?php echo ROOT . '/' . $item['file_path']; ?>', '<?php echo htmlspecialchars($item['title']); ?>')">
                            <?php else: ?>
                                <div class="bg-dark d-flex align-items-center justify-content-center" style="height: 180px; cursor: pointer;"
                                     onclick="previewFile('<?php echo ROOT . '/' . $item['file_path']; ?>', '<?php echo htmlspecialchars($item['title']); ?>')">
                                    <i class="fas fa-play fa-3x text-white"></i>
                                </div>
                            <?php endif; ?>
                            <div class="card-body p-3">
                                <h6 class="fw-bold mb-1"><?php echo htmlspecialchars($item['title']); ?></h6>
                                <div class="d-flex justify-content-between align-items-center">
                                    <span class="badge bg-light text-dark small fw-normal"><?php echo ucfirst($item['type']); ?></span>
                                    <div>
                                        <button class="btn btn-sm btn-light border-0 me-1" onclick="editMedia(<?php echo htmlspecialchars(json_encode($item), ENT_QUOTES, 'UTF-8'); ?>)"><i class="fas fa-edit"></i></button>
                                        <a href="<?php echo ROOT; ?>/admin/media_delete/<?php echo $item['id']; ?>" class="btn btn-sm btn-outline-danger border-0" onclick="return confirm('Delete this?')"><i class="fas fa-trash"></i></a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                <?php endforeach; ?>
            <?php endif; ?>
        </div>
    </div>
</main>

<!-- Upload/Edit Modal -->
<div class="modal fade" id="uploadModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content border-0 shadow-lg rounded-4">
            <div class="modal-header border-0 pb-0">
                <h5 class="modal-title fw-bold" id="modalTitle">Upload Media File</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form action="<?php echo ROOT; ?>/admin/media" method="POST" enctype="multipart/form-data" id="mediaForm">
                <input type="hidden" name="id" id="mediaId">
                <input type="hidden" name="current_file" id="currentFile">
                <div class="modal-body p-4">
                    <div class="mb-3">
                        <label class="form-label small fw-bold">Title</label>
                        <input type="text" name="title" id="mediaTitle" class="form-control rounded-3" placeholder="Enter media title" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label small fw-bold">Type</label>
                        <select name="type" id="mediaType" class="form-select rounded-3">
                            <option value="image">Image</option>
                            <option value="video">Video</option>
                        </select>
                    </div>
                    <div class="mb-4">
                        <label class="form-label small fw-bold">Select File</label>
                        <div class="upload-area">
                            <i class="fas fa-photo-video text-info"></i>
                            <p class="upload-text">Drag & drop media file or click to browse</p>
                            <p class="upload-hint">Supported formats: Images & Videos</p>
                            <input type="file" name="file">
                        </div>
                        <div class="file-preview" id="filePreviewDisplay"></div>
                    </div>
                </div>
                <div class="modal-footer border-0 pt-0 pb-4 pe-4">
                    <button type="button" class="btn btn-light rounded-pill px-4" data-bs-dismiss="modal">Cancel</button>
                    <button type="submit" name="upload_media" id="submitBtn" class="btn btn-info rounded-pill px-5 fw-bold text-white">Upload Media</button>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
    function editMedia(item) {
        document.getElementById('modalTitle').innerText = 'Edit Media File';
        document.getElementById('mediaId').value = item.id;
        document.getElementById('mediaTitle').value = item.title;
        document.getElementById('mediaType').value = item.type;
        document.getElementById('currentFile').value = item.file_path;
        document.getElementById('submitBtn').name = 'edit_media';
        document.getElementById('submitBtn').innerText = 'Update Media';
        
        if (item.file_path) {
            document.getElementById('filePreviewDisplay').style.display = 'block';
            document.getElementById('filePreviewDisplay').innerHTML = `<i class="fas fa-paperclip me-2"></i> Current: <strong>${item.file_path.split('/').pop()}</strong>`;
        }
        
        var modal = new bootstrap.Modal(document.getElementById('uploadModal'));
        modal.show();
    }
    
    document.getElementById('uploadModal').addEventListener('hidden.bs.modal', function () {
        document.getElementById('modalTitle').innerText = 'Upload Media File';
        document.getElementById('mediaId').value = '';
        document.getElementById('mediaForm').reset();
        document.getElementById('submitBtn').name = 'upload_media';
        document.getElementById('submitBtn').innerText = 'Upload Media';
        document.getElementById('filePreviewDisplay').style.display = 'none';
    });
</script>

<?php require_once '../app/views/layout/footer.php'; ?>
