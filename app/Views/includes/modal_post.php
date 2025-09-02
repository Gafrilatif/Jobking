<div class="modal fade" id="modalPost" tabindex="-1" aria-labelledby="modalPostLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="modalPostLabel">Post a Commission</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        <!-- Step 1 -->
        <div id="modalStep1">
          <div class="mb-3">
            <label for="taskTitle" class="form-label">Task Title</label>
            <input type="text" class="form-control" id="taskTitle" placeholder="Enter task title">
          </div>
          <div class="mb-3">
            <label for="briefDescription" class="form-label">Brief Description</label>
            <textarea class="form-control" id="briefDescription" rows="3" placeholder="Enter brief description"></textarea>
          </div>
          <div class="mb-3">
            <label for="testTags" class="form-label">Test Tags</label>
            <input type="text" class="form-control" id="testTags" placeholder="Enter tags separated by commas">
          </div>

          <div class="d-flex justify-content-end">
            <button type="button" class="btn btn-secondary" id="nextStep">Next</button>
          </div>
        </div>
        <!-- Step 2 -->
        <div id="modalStep2" class="d-none">
          <div class="mb-3">
            <label for="detailedDescription" class="form-label">Detailed Description</label>
            <textarea class="form-control" id="detailedDescription" rows="5" placeholder="Enter detailed description"></textarea>
          </div>
          <div class="d-flex justify-content-between">
            <button type="button" class="btn btn-secondary" id="backStep">Back</button>
            <button type="button" class="btn btn-primary" id="postTask">Post</button>
          </div>
        </div>
        <?php if (isset($validation)): ?>
            <div class="alert alert-danger">
                <?= $validation->listErrors() ?>
            </div>
        <?php endif; ?>
      </div>
    </div>
  </div>
</div>

