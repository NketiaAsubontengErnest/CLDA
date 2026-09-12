<?php require_once '../app/views/layout/header.php'; ?>
<link href="<?php echo ROOT; ?>/css/summernote.css" rel="stylesheet">
<script src="<?php echo ROOT; ?>/js/jquery.js"></script>
<script src="<?php echo ROOT; ?>/js/summernote.js"></script>
<script>
    $(document).ready(function() {
        $('.rich-text').summernote({
            placeholder: 'Enter event description',
            tabsize: 2,
            height: 150,
            toolbar: [
                ['font', ['bold', 'underline', 'clear']],
                ['para', ['ul', 'ol', 'paragraph']],
                ['insert', ['link', 'picture']],
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
                <li class="breadcrumb-item active" aria-current="page">Manage Events</li>
            </ol>
        </nav>

        <div class="d-flex justify-content-between align-items-center mb-4">
            <h2 class="fw-bold">Manage Events</h2>
            <div class="d-flex gap-2">
                <a href="<?php echo ROOT; ?>/admin" class="btn btn-outline-secondary rounded-pill fw-bold">
                    <i class="fas fa-arrow-left me-2"></i> Dashboard
                </a>
                <button class="btn btn-danger rounded-pill fw-bold" data-bs-toggle="modal" data-bs-target="#uploadModal">
                    <i class="fas fa-plus me-2"></i> Add Event
                </button>
            </div>
        </div>

        <?php if (isset($_GET['success'])): ?>
            <div class="alert alert-success alert-dismissible fade show border-0 shadow-sm rounded-3 mb-4" role="alert">
                <i class="fas fa-check-circle me-2"></i> Event scheduled successfully!
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        <?php endif; ?>

        <?php if (isset($_GET['updated'])): ?>
            <div class="alert alert-success alert-dismissible fade show border-0 shadow-sm rounded-3 mb-4" role="alert">
                <i class="fas fa-edit me-2"></i> Event updated successfully!
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        <?php endif; ?>

        <?php if (isset($_GET['deleted'])): ?>
            <div class="alert alert-danger alert-dismissible fade show border-0 shadow-sm rounded-3 mb-4" role="alert">
                <i class="fas fa-trash me-2"></i> Event deleted successfully!
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        <?php endif; ?>

        <div class="card border-0 shadow-sm rounded-4">
            <div class="card-body p-0">
                <div class="table-responsive">
                    <table class="table table-hover align-middle mb-0">
                        <thead class="bg-light">
                            <tr>
                                <th class="ps-4">Event Title</th>
                                <th>Date</th>
                                <th>Location</th>
                                <th class="text-end pe-4">Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php if (empty($items)): ?>
                                <tr>
                                    <td colspan="4" class="text-center py-5 text-muted">No events scheduled.</td>
                                </tr>
                            <?php else: ?>
                                <?php foreach ($items as $item): ?>
                                    <tr>
                                        <td class="ps-4 fw-bold"><?php echo htmlspecialchars($item['title']); ?></td>
                                        <td class="small"><?php echo date('M d, Y', strtotime($item['event_date'])); ?></td>
                                        <td class="small text-muted"><?php echo htmlspecialchars($item['location']); ?></td>
                                        <td class="text-end pe-4">
                                            <button class="btn btn-sm btn-light border-0 me-1" onclick="editEvent(<?php echo htmlspecialchars(json_encode($item), ENT_QUOTES, 'UTF-8'); ?>)"><i class="fas fa-edit"></i></button>
                                            <a href="<?php echo ROOT; ?>/admin/events_delete/<?php echo $item['id']; ?>" class="btn btn-sm btn-outline-danger border-0" onclick="return confirm('Delete this?')"><i class="fas fa-trash"></i></a>
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
                <h5 class="modal-title fw-bold" id="modalTitle">Add Upcoming Event</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form action="<?php echo ROOT; ?>/admin/events" method="POST" id="eventForm">
                <input type="hidden" name="id" id="eventId">
                <div class="modal-body p-4">
                    <div class="mb-3">
                        <label class="form-label small fw-bold">Event Title</label>
                        <input type="text" name="title" id="eventTitle" class="form-control rounded-3" placeholder="Enter event name" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label small fw-bold">Date</label>
                        <input type="date" name="event_date" id="eventDate" class="form-control rounded-3" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label small fw-bold">Location</label>
                        <input type="text" name="location" id="eventLocation" class="form-control rounded-3" placeholder="Enter event location">
                    </div>
                    <div class="mb-0">
                        <label class="form-label small fw-bold">Description</label>
                        <textarea name="description" id="eventDescription" class="form-control rounded-3 rich-text" rows="3" placeholder="Enter event details"></textarea>
                    </div>
                </div>
                <div class="modal-footer border-0 pt-0 pb-4 pe-4">
                    <button type="button" class="btn btn-light rounded-pill px-4" data-bs-dismiss="modal">Cancel</button>
                    <button type="submit" name="upload_event" id="submitBtn" class="btn btn-danger rounded-pill px-5 fw-bold">Schedule Event</button>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
    function editEvent(item) {
        document.getElementById('modalTitle').innerText = 'Edit Event';
        document.getElementById('eventId').value = item.id;
        document.getElementById('eventTitle').value = item.title;
        document.getElementById('eventDate').value = item.event_date;
        document.getElementById('eventLocation').value = item.location;
        document.getElementById('submitBtn').name = 'edit_event';
        document.getElementById('submitBtn').innerText = 'Update Event';
        
        $('.rich-text').summernote('code', item.description);
        
        var modal = new bootstrap.Modal(document.getElementById('uploadModal'));
        modal.show();
    }
    
    document.getElementById('uploadModal').addEventListener('hidden.bs.modal', function () {
        document.getElementById('modalTitle').innerText = 'Add Upcoming Event';
        document.getElementById('eventId').value = '';
        document.getElementById('eventForm').reset();
        $('.rich-text').summernote('code', '');
        document.getElementById('submitBtn').name = 'upload_event';
        document.getElementById('submitBtn').innerText = 'Schedule Event';
    });
</script>

<?php require_once '../app/views/layout/footer.php'; ?>
