<?php require_once '../app/views/layout/header.php'; ?>
<link href="<?php echo ROOT; ?>/css/summernote.css" rel="stylesheet">
<script src="<?php echo ROOT; ?>/js/jquery.js"></script>
<script src="<?php echo ROOT; ?>/js/summernote.js"></script>
<script>
    $(document).ready(function() {
        $('.rich-text').summernote({
            placeholder: 'Enter short description',
            tabsize: 2,
            height: 150,
            toolbar: [
                ['font', ['bold', 'underline', 'clear']],
                ['para', ['ul', 'ol', 'paragraph']],
                ['insert', ['link']],
                ['view', ['codeview']]
            ]
        });
    });
</script>
<style>
    .ck-editor__editable {
        min-height: 150px;
    }
</style>

<main class="py-5 bg-light" style="min-height: 80vh;">
    <div class="container">
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="<?php echo ROOT; ?>/admin" class="text-decoration-none">Dashboard</a></li>
                <li class="breadcrumb-item active" aria-current="page">Manage Downloads</li>
            </ol>
        </nav>

        <div class="d-flex justify-content-between align-items-center mb-4">
            <h2 class="fw-bold">Manage Downloads</h2>
            <div class="d-flex gap-2">
                <a href="<?php echo ROOT; ?>/admin" class="btn btn-outline-secondary rounded-pill fw-bold">
                    <i class="fas fa-arrow-left me-2"></i> Dashboard
                </a>
                <button class="btn btn-warning rounded-pill fw-bold text-white" data-bs-toggle="modal" data-bs-target="#uploadModal">
                    <i class="fas fa-plus me-2"></i> Add Download
                </button>
            </div>
        </div>

        <?php if (isset($_GET['success'])): ?>
            <div class="alert alert-success alert-dismissible fade show border-0 shadow-sm rounded-3 mb-4" role="alert">
                <i class="fas fa-check-circle me-2"></i> Download resource added successfully!
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        <?php endif; ?>

        <?php if (isset($_GET['updated'])): ?>
            <div class="alert alert-success alert-dismissible fade show border-0 shadow-sm rounded-3 mb-4" role="alert">
                <i class="fas fa-edit me-2"></i> Download updated successfully!
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        <?php endif; ?>

        <?php if (isset($_GET['deleted'])): ?>
            <div class="alert alert-danger alert-dismissible fade show border-0 shadow-sm rounded-3 mb-4" role="alert">
                <i class="fas fa-trash me-2"></i> Download deleted successfully!
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        <?php endif; ?>

        <div class="card border-0 shadow-sm rounded-4">
            <div class="card-body p-0">
                <div class="table-responsive">
                    <table class="table table-hover align-middle mb-0">
                        <thead class="bg-light">
                            <tr>
                                <th class="ps-4">Resource Title</th>
                                <th>Description</th>
                                <th>File Path</th>
                                <th class="text-end pe-4">Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php if (empty($items)): ?>
                                <tr>
                                    <td colspan="4" class="text-center py-5 text-muted">No download resources found.</td>
                                </tr>
                            <?php else: ?>
                                <?php foreach ($items as $item): ?>
                                    <tr>
                                        <td class="ps-4 fw-bold"><?php echo htmlspecialchars($item['title']); ?></td>
                                        <td class="small text-muted ellipsis" style="max-width: 200px;"><?php echo strip_tags($item['description']); ?></td>
                                        <td class="small text-muted">
                                            <?php if ($item['file_path']): ?>
                                                <button onclick="previewFile('<?php echo ROOT . '/' . $item['file_path']; ?>', '<?php echo htmlspecialchars($item['title']); ?>')" class="btn btn-sm btn-link text-decoration-none p-0">
                                                    <i class="fas fa-eye me-1"></i> Preview
                                                </button>
                                            <?php else: ?>
                                                No file
                                            <?php endif; ?>
                                        </td>
                                        <td class="text-end pe-4">
                                            <button class="btn btn-sm btn-light border-0 me-1" onclick="editDownload(<?php echo htmlspecialchars(json_encode($item), ENT_QUOTES, 'UTF-8'); ?>)"><i class="fas fa-edit"></i></button>
                                            <a href="<?php echo ROOT; ?>/admin/downloads_delete/<?php echo $item['id']; ?>" class="btn btn-sm btn-outline-danger border-0" onclick="return confirm('Delete this?')"><i class="fas fa-trash"></i></a>
                                        </td>
                                    </tr>
                                <?php endforeach; ?>
                            <?php endif; ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</main>

<!-- Upload/Edit Modal -->
<div class="modal fade" id="uploadModal" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content border-0 shadow-lg rounded-4">
            <div class="modal-header border-0 pb-0">
                <h5 class="modal-title fw-bold" id="modalTitle">Add Download Resource</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form action="<?php echo ROOT; ?>/admin/downloads" method="POST" enctype="multipart/form-data" id="downloadForm">
                <input type="hidden" name="id" id="downloadId">
                <input type="hidden" name="current_file" id="currentFile">
                <div class="modal-body p-4">
                    <div class="mb-3">
                        <label class="form-label small fw-bold">Resource Title</label>
                        <input type="text" name="title" id="downloadTitle" class="form-control rounded-3" placeholder="Enter resource name" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label small fw-bold">Description</label>
                        <textarea name="description" id="downloadDescription" class="form-control rounded-3 rich-text" rows="3" placeholder="Enter short description"></textarea>
                    </div>
                    <div class="mb-4">
                        <label class="form-label small fw-bold">Select Resource File</label>
                        <div class="upload-area">
                            <i class="fas fa-file-archive text-warning"></i>
                            <p class="upload-text">Drag & drop resource file or click to browse</p>
                            <p class="upload-hint">Supported formats: PDF, ZIP, DOC, DOCX</p>
                            <input type="file" name="file">
                        </div>
                        <div class="file-preview" id="filePreviewDisplay"></div>
                    </div>
                </div>
                <div class="modal-footer border-0 pt-0 pb-4 pe-4">
                    <button type="button" class="btn btn-light rounded-pill px-4" data-bs-dismiss="modal">Cancel</button>
                    <button type="submit" name="upload_download" id="submitBtn" class="btn btn-warning rounded-pill px-5 fw-bold text-white">Add Download</button>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
    function editDownload(item) {
        document.getElementById('modalTitle').innerText = 'Edit Download Resource';
        document.getElementById('downloadId').value = item.id;
        document.getElementById('downloadTitle').value = item.title;
        document.getElementById('currentFile').value = item.file_path;
        document.getElementById('submitBtn').name = 'edit_download';
        document.getElementById('submitBtn').innerText = 'Update Download';
        
        $('.rich-text').summernote('code', item.description);
        
        if (item.file_path) {
            document.getElementById('filePreviewDisplay').style.display = 'block';
            document.getElementById('filePreviewDisplay').innerHTML = `<i class="fas fa-paperclip me-2"></i> Current: <strong>${item.file_path.split('/').pop()}</strong>`;
        }
        
        var modal = new bootstrap.Modal(document.getElementById('uploadModal'));
        modal.show();
    }
    
    document.getElementById('uploadModal').addEventListener('hidden.bs.modal', function () {
        document.getElementById('modalTitle').innerText = 'Add Download Resource';
        document.getElementById('downloadId').value = '';
        document.getElementById('downloadForm').reset();
        $('.rich-text').summernote('code', '');
        document.getElementById('submitBtn').name = 'upload_download';
        document.getElementById('submitBtn').innerText = 'Add Download';
        document.getElementById('filePreviewDisplay').style.display = 'none';
    });
</script>

<?php require_once '../app/views/layout/footer.php'; ?>
