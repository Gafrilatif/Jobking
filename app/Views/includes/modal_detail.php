<style>
  .modal-content {
      background-color: #000; 
      color: #fff; 
      border: 2px solid #fff; 
  }

  .btn-close {
      filter: invert(100%); /
  }

  .modal-title {
      font-weight: bold;
      color: #fff;
  }

  .modal-body h6, .modal-body p {
      margin-bottom: 5px;
      margin-top: 10px;
      color: #fff;
  }

  #modalTaskTags {
      margin-bottom: 20px; 
  }
</style>




<div class="modal fade" id="commissionModal" tabindex="-1" aria-labelledby="commissionModalLabel" aria-hidden="true" data-task-id="">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="commissionModalLabel">Task Details</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <h6>Username:</h6>
                <p id="modalUsername"></p>
                <h6>Task Title:</h6>
                <p id="modalTaskTitle"></p>
                <h6>Task Tags:</h6>
                <div id="modalTaskTags"></div>
                <h6>Task Description:</h6>
                <p id="modalTaskDesc"></p>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" id="accept_btn">Accept</button>
            </div>
        </div>
    </div>
</div>
