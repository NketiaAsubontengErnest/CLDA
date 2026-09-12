<?php require_once '../app/views/layout/header.php'; ?>
<link href="<?php echo ROOT; ?>/css/summernote.css" rel="stylesheet">
<script src="<?php echo ROOT; ?>/js/jquery.js"></script>
<script src="<?php echo ROOT; ?>/js/summernote.js"></script>
<script>
    $(document).ready(function() {
        $('.rich-text').summernote({
            placeholder: 'Write your content here...',
            tabsize: 2,
            height: 200,
            toolbar: [
                ['style', ['style']],
                ['font', ['bold', 'underline', 'clear']],
                ['color', ['color']],
                ['para', ['ul', 'ol', 'paragraph']],
                ['table', ['table']],
                ['insert', ['link', 'picture', 'video']],
                ['view', ['fullscreen', 'codeview', 'help']]
            ]
        });
    });
</script>
<style>
    .ck-editor__editable {
        min-height: 250px;
    }
</style>

<main class="py-5 bg-light" style="min-height: 80vh;">
    <div class="container">
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="<?php echo ROOT; ?>/admin" class="text-decoration-none">Dashboard</a></li>
                <li class="breadcrumb-item active" aria-current="page">Manage News</li>
            </ol>
        </nav>

        <div class="d-flex justify-content-between align-items-center mb-4">
            <h2 class="fw-bold">Manage News</h2>
            <div class="d-flex gap-2">
                <a href="<?php echo ROOT; ?>/admin" class="btn btn-outline-secondary rounded-pill fw-bold">
                    <i class="fas fa-arrow-left me-2"></i> Dashboard
                </a>
                <button class="btn btn-primary rounded-pill fw-bold" data-bs-toggle="modal" data-bs-target="#uploadModal">
                    <i class="fas fa-plus me-2"></i> Upload News
                </button>
            </div>
        </div>

        <?php if (isset($_GET['success'])): ?>
            <div class="alert alert-success alert-dismissible fade show border-0 shadow-sm rounded-3 mb-4" role="alert">
                <i class="fas fa-check-circle me-2"></i> News uploaded successfully!
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        <?php endif; ?>

        <?php if (isset($_GET['updated'])): ?>
            <div class="alert alert-success alert-dismissible fade show border-0 shadow-sm rounded-3 mb-4" role="alert">
                <i class="fas fa-edit me-2"></i> News updated successfully!
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        <?php endif; ?>

        <?php if (isset($_GET['deleted'])): ?>
            <div class="alert alert-danger alert-dismissible fade show border-0 shadow-sm rounded-3 mb-4" role="alert">
                <i class="fas fa-trash me-2"></i> News deleted successfully!
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        <?php endif; ?>

        <div class="card border-0 shadow-sm rounded-4">
            <div class="card-body p-0">
                <div class="table-responsive">
                    <table class="table table-hover align-middle mb-0">
                        <thead class="bg-light">
                            <tr>
                                <th class="ps-4">Image</th>
                                <th>Title</th>
                                <th>Date</th>
                                <th class="text-end pe-4">Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php if (empty($news)): ?>
                                <tr>
                                    <td colspan="4" class="text-center py-5 text-muted">No news articles found.</td>
                                </tr>
                            <?php else: ?>
                                <?php foreach ($news as $item): ?>
                                    <tr>
                                        <td class="ps-4">
                                            <?php if ($item['image_path']): ?>
                                                <img src="<?php echo ROOT . '/' . $item['image_path']; ?>" alt="" class="rounded-3" style="width: 60px; height: 40px; object-fit: cover;">
                                            <?php else: ?>
                                                <div class="bg-light rounded-3 d-flex align-items-center justify-content-center" style="width: 60px; height: 40px;">
                                                    <i class="fas fa-image text-muted"></i>
                                                </div>
                                            <?php endif; ?>
                                        </td>
                                        <td class="fw-bold"><?php echo htmlspecialchars($item['title']); ?></td>
                                        <td class="text-muted small"><?php echo date('M d, Y', strtotime($item['created_at'])); ?></td>
                                        <td class="text-end pe-4">
                                            <button class="btn btn-sm btn-light rounded-3 me-2" onclick="editNews(<?php echo htmlspecialchars(json_encode($item), ENT_QUOTES, 'UTF-8'); ?>)"><i class="fas fa-edit"></i></button>
                                            <a href="<?php echo ROOT; ?>/admin/news_delete/<?php echo $item['id']; ?>" class="btn btn-sm btn-outline-danger rounded-3" onclick="return confirm('Delete this?')"><i class="fas fa-trash"></i></a>
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
    <div class="modal-dialog modal-lg modal-dialog-centered">
        <div class="modal-content border-0 shadow-lg rounded-4">
            <div class="modal-header border-0 pb-0">
                <h5 class="modal-title fw-bold" id="modalTitle">Upload News Article</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form action="<?php echo ROOT; ?>/admin/news" method="POST" enctype="multipart/form-data" id="newsForm">
                <input type="hidden" name="id" id="newsId">
                <input type="hidden" name="current_image" id="currentImage">
                <div class="modal-body p-4">
                    <div class="mb-3">
                        <label class="form-label small fw-bold">Title</label>
                        <input type="text" name="title" id="newsTitle" class="form-control rounded-3" placeholder="Enter news title" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label small fw-bold">Content</label>
                        <textarea name="content" id="newsContent" class="form-control rounded-3 rich-text" rows="6" placeholder="Write your news article here..."></textarea>
                    </div>
                    <div class="mb-4">
                        <label class="form-label small fw-bold">Featured Image</label>
                        <div class="upload-area">
                            <i class="fas fa-cloud-upload-alt"></i>
                            <p class="upload-text">Drag & drop featured image or click to browse</p>
                            <p class="upload-hint">Supported formats: JPG, PNG, WEBP (Max 5MB)</p>
                            <input type="file" name="image" accept="image/*">
                        </div>
                        <div class="file-preview" id="imagePreview"></div>
                    </div>
                </div>
                <div class="modal-footer border-0 pt-0 pb-4 pe-4">
                    <button type="button" class="btn btn-light rounded-pill px-4" data-bs-dismiss="modal">Cancel</button>
                    <button type="submit" name="upload_news" id="submitBtn" class="btn btn-primary rounded-pill px-5 fw-bold">Upload Article</button>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
    function editNews(item) {
        document.getElementById('modalTitle').innerText = 'Edit News Article';
        document.getElementById('newsId').value = item.id;
        document.getElementById('newsTitle').value = item.title;
        document.getElementById('currentImage').value = item.image_path;
        document.getElementById('submitBtn').name = 'edit_news';
        document.getElementById('submitBtn').innerText = 'Update Article';
        
        // Populate Sumernote
        $('.rich-text').summernote('code', item.content);
        
        if (item.image_path) {
            document.getElementById('imagePreview').style.display = 'block';
            document.getElementById('imagePreview').innerHTML = `<img src="<?php echo ROOT; ?>/${item.image_path}" class="img-thumbnail mt-2" style="max-height: 100px;">`;
        } else {
            document.getElementById('imagePreview').style.display = 'none';
        }
        
        var modal = new bootstrap.Modal(document.getElementById('uploadModal'));
        modal.show();
    }
    
    // Reset modal when hidden
    document.getElementById('uploadModal').addEventListener('hidden.bs.modal', function () {
        document.getElementById('modalTitle').innerText = 'Upload News Article';
        document.getElementById('newsId').value = '';
        document.getElementById('newsForm').reset();
        $('.rich-text').summernote('code', '');
        document.getElementById('submitBtn').name = 'upload_news';
        document.getElementById('submitBtn').innerText = 'Upload Article';
        document.getElementById('imagePreview').style.display = 'none';
    });
</script>

<?php require_once '../app/views/layout/footer.php'; ?>
