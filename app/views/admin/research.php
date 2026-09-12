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
        min-height: 200px;
    }
</style>

<main class="py-5 bg-light" style="min-height: 80vh;">
    <div class="container">
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="<?php echo ROOT; ?>/admin" class="text-decoration-none">Dashboard</a></li>
                <li class="breadcrumb-item active" aria-current="page">Manage Research</li>
            </ol>
        </nav>

        <div class="d-flex justify-content-between align-items-center mb-4">
            <h2 class="fw-bold">Manage Research</h2>
             <div class="d-flex gap-2">
                <a href="<?php echo ROOT; ?>/admin" class="btn btn-outline-secondary rounded-pill fw-bold">
                    <i class="fas fa-arrow-left me-2"></i> Dashboard
                </a>
                <button class="btn btn-success rounded-pill fw-bold text-white" data-bs-toggle="modal" data-bs-target="#uploadModal">
                    <i class="fas fa-plus me-2"></i> Upload Research
                </button>
            </div>
        </div>

        <?php if (isset($_GET['success'])): ?>
            <div class="alert alert-success alert-dismissible fade show border-0 shadow-sm rounded-3 mb-4" role="alert">
                <i class="fas fa-check-circle me-2"></i> Research uploaded successfully!
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        <?php endif; ?>

        <?php if (isset($_GET['updated'])): ?>
            <div class="alert alert-success alert-dismissible fade show border-0 shadow-sm rounded-3 mb-4" role="alert">
                <i class="fas fa-edit me-2"></i> Research updated successfully!
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        <?php endif; ?>

        <?php if (isset($_GET['deleted'])): ?>
            <div class="alert alert-danger alert-dismissible fade show border-0 shadow-sm rounded-3 mb-4" role="alert">
                <i class="fas fa-trash me-2"></i> Research deleted successfully!
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        <?php endif; ?>

        <div class="card border-0 shadow-sm rounded-4">
            <div class="card-body p-0">
                <div class="table-responsive">
                    <table class="table table-hover align-middle mb-0">
                        <thead class="bg-light">
                            <tr>
                                <th class="ps-4">Title</th>
                                <th>Description</th>
                                <th>File</th>
                                <th>Date</th>
                                <th class="text-end pe-4">Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php if (empty($items)): ?>
                                <tr>
                                    <td colspan="5" class="text-center py-5 text-muted">No research items found.</td>
                                </tr>
                            <?php else: ?>
                                <?php foreach ($items as $item): ?>
                                    <tr>
                                        <td class="ps-4 fw-bold"><?php echo htmlspecialchars($item['title']); ?></td>
                                        <td class="small text-muted ellipsis" style="max-width: 200px;"><?php echo strip_tags($item['description']); ?></td>
                                        <td>
                                            <?php if ($item['file_path']): ?>
                                                <button onclick="previewFile('<?php echo ROOT . '/' . $item['file_path']; ?>', '<?php echo htmlspecialchars($item['title']); ?>')" class="btn btn-sm btn-light rounded-pill"><i class="fas fa-eye text-success me-1"></i> Preview</button>
                                            <?php else: ?>
                                                <span class="text-muted small">No file</span>
                                            <?php endif; ?>
                                        </td>
                                        <td class="text-muted small"><?php echo date('M d, Y', strtotime($item['created_at'])); ?></td>
                                        <td class="text-end pe-4">
                                            <button class="btn btn-sm btn-light rounded-3 me-2" onclick="editResearch(<?php echo htmlspecialchars(json_encode($item), ENT_QUOTES, 'UTF-8'); ?>)"><i class="fas fa-edit"></i></button>
                                            <a href="<?php echo ROOT; ?>/admin/research_delete/<?php echo $item['id']; ?>" class="btn btn-sm btn-outline-danger rounded-3" onclick="return confirm('Delete this?')"><i class="fas fa-trash"></i></a>
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

<!-- Upload Modal -->
<div class="modal fade" id="uploadModal" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-centered">
        <div class="modal-content border-0 shadow-lg rounded-4">
            <div class="modal-header border-0 pb-0">
                <h5 class="modal-title fw-bold" id="modalTitle">Upload Research Paper</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form action="<?php echo ROOT; ?>/admin/research" method="POST" enctype="multipart/form-data" id="researchForm">
                <input type="hidden" name="id" id="researchId">
                <input type="hidden" name="current_file" id="currentFile">
                <div class="modal-body p-4">
                    <div class="mb-3">
                        <label class="form-label small fw-bold">Title</label>
                        <input type="text" name="title" id="researchTitle" class="form-control rounded-3" placeholder="Enter research title" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label small fw-bold">Description</label>
                        <textarea name="description" id="researchDescription" class="form-control rounded-3 rich-text" rows="4" placeholder="Enter short description"></textarea>
                    </div>
                    <div class="mb-4">
                        <label class="form-label small fw-bold">Resource File (PDF/Doc)</label>
                        <div class="upload-area">
                            <i class="fas fa-file-pdf text-danger"></i>
                            <p class="upload-text">Drag & drop research file or click to browse</p>
                            <p class="upload-hint">Supported formats: PDF, DOC, DOCX</p>
                            <input type="file" name="file">
                        </div>
                        <div class="file-preview" id="filePreviewDisplay"></div>
                    </div>
                </div>
                <div class="modal-footer border-0 pt-0 pb-4 pe-4">
                    <button type="button" class="btn btn-light rounded-pill px-4" data-bs-dismiss="modal">Cancel</button>
                    <button type="submit" name="upload_research" id="submitBtn" class="btn btn-success rounded-pill px-5 fw-bold text-white">Upload Research</button>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
    function editResearch(item) {
        document.getElementById('modalTitle').innerText = 'Edit Research Paper';
        document.getElementById('researchId').value = item.id;
        document.getElementById('researchTitle').value = item.title;
        document.getElementById('currentFile').value = item.file_path;
        document.getElementById('submitBtn').name = 'edit_research';
        document.getElementById('submitBtn').innerText = 'Update Research';
        
        $('.rich-text').summernote('code', item.description);
        
        if (item.file_path) {
            document.getElementById('filePreviewDisplay').style.display = 'block';
            document.getElementById('filePreviewDisplay').innerHTML = `<i class="fas fa-file-alt me-2"></i> Current: <strong>${item.file_path.split('/').pop()}</strong>`;
        }
        
        var modal = new bootstrap.Modal(document.getElementById('uploadModal'));
        modal.show();
    }
    
    document.getElementById('uploadModal').addEventListener('hidden.bs.modal', function () {
        document.getElementById('modalTitle').innerText = 'Upload Research Paper';
        document.getElementById('researchId').value = '';
        document.getElementById('researchForm').reset();
        $('.rich-text').summernote('code', '');
        document.getElementById('submitBtn').name = 'upload_research';
        document.getElementById('submitBtn').innerText = 'Upload Research';
        document.getElementById('filePreviewDisplay').style.display = 'none';
    });
</script>

<?php require_once '../app/views/layout/footer.php'; ?>
