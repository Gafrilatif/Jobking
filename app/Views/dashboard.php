<section id="hero" >
    <div class="container container-top">
      <div class="row align-items-center top-banner">
        <div class="col-md-6 pe-5 mt-5 mt-md-0">
          <p class="fs-4 my-4 pb-2" style="font-weight: 500;">SEARCH FOR COMMISSIONS HERE, KING!</p>
          <div>
            <form id="form" class="d-flex align-items-center position-relative ">
              <input type="text" name="email" placeholder="what are you looking for, King?"
                class="form-control bg-white border-0 rounded-4 shadow-none px-4 py-3 w-100">
              <button class="btn btn-primary rounded-4 px-3 py-2 position-absolute align-items-center m-1 end-0">
                <svg
                  xmlns="http://www.w3.org/2000/svg" width="22px" height="22px">
                  <use href="#search" />
                </svg>
              </button>
            </form>

          </div>
        </div>
        <div class="col-md-6 mt-5">
          <img src="<?= base_url('assets/img/lion.png') ?>" alt="img" class="img-fluid">
        </div>
      </div>
    </div>
  </section>

  <section id="features">
    <div class="feature-box container container-feature">
      <ul class="nav nav-tabs justify-content-center mb-4" role="tablist">
        <li class="nav-item">
          <button class="nav-link" id="profile-tab" data-bs-toggle="tab" data-bs-target="#profile" type="button" role="tab" aria-controls="profile" aria-selected="false">Profile</button>
        </li>
        <li class="nav-item">
          <button class="nav-link active" id="commissions-tab" data-bs-toggle="tab" data-bs-target="#commissions" type="button" role="tab" aria-controls="commissions" aria-selected="true">Commissions</button>
        </li>
        <li class="nav-item">
          <button class="nav-link" id="chat-tab" data-bs-toggle="tab" data-bs-target="#chat" type="button" role="tab" aria-controls="chat" aria-selected="false">Chat</button>
        </li>
      </ul>
  
      <div class="tab-content">
        <div class="tab-pane fade" id="profile" role="tabpanel" aria-labelledby="profile-tab">
          <div class="d-flex flex-column align-items-center py-5">
            <img src="<?= base_url('assets/uploads/avatars/' . esc($user['profile_picture'])) ?>" alt="Profile Picture" class="rounded-circle mb-3" width="150" height="150">
            <h3 class="text-light"><?= esc($user['username']) ?></h3>

            <form action="<?= base_url('/dashboard') ?>" method="POST" class="mt-3" style="width: 100%; max-width: 500px;">
                    <?= csrf_field() ?>
                    <div class="form-group">
                        <label for="username" class="text-light">Username</label>
                        <input type="text" name="username" id="username" value="<?= set_value('username', $user['username']) ?>" class="form-control">
                    </div>

                    <div class="form-group mt-3">
                        <label for="password" class="text-light">New Password</label>
                        <input type="password" name="password" id="password" class="form-control">
                    </div>

                    <div class="form-group mt-3">
                        <label for="password_confirm" class="text-light">Confirm Password</label>
                        <input type="password" name="password_confirm" id="password_confirm" class="form-control">
                    </div>

                    <button type="submit" class="btn btn-secondary mt-4">Update Profile</button>
              </form>
        
            <div class="d-flex justify-content-center mt-5">
              <button class="btn btn-secondary px-4 py-2 me-3" id="openModalButton">Post Commission</button>
            </div>
        
            <div class="mt-4 p-3 border rounded text-light" style="width: 100%; max-width: 500px; background-color: #000;">
              <h5 class="text-center mb-3 text-white">Accepted Commissions</h5>
              <ul class="list-group" id="acceptedtask">
                
              </ul>
            </div>

            <div class="d-flex justify-content-center mt-5">
                <button 
                    class="btn btn-secondary px-4 py-2 me-3" 
                    onclick="window.location.href='<?= base_url('/logout') ?>'">
                    LOGOUT
                </button>
            </div>
            
          </div>
        </div>
        
        <div class="tab-pane fade show active" id="commissions" role="tabpanel" aria-labelledby="commissions-tab">

        </div>

        <div class="tab-pane fade" id="chat" role="tabpanel" aria-labelledby="chat-tab">
            <div id="chat-list-container">
                <div class="search-bar-container p-3">
                    <input type="text" id="search-chat-input" class="form-control" placeholder="Search Chat">
                </div>
                <div id="chat-list">
                    </div>
            </div>

            <div id="chat-window-container" style="display: none;">
                <div class="d-flex align-items-center p-3 border-bottom">
                    <button id="back-to-chat-list-btn" class="btn btn-dark me-3">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 16 16">
                            <path fill-rule="evenodd" d="M12 8a.5.5 0 0 1-.5.5H5.707l2.147 2.146a.5.5 0 0 1-.708.708l-3-3a.5.5 0 0 1 0-.708l3-3a.5.5 0 1 1 .708.708L5.707 7.5H11.5a.5.5 0 0 1 .5.5z"/>
                        </svg>
                    </button>
                    <h5 id="chat-window-header" class="mb-0">Chat</h5>
                </div>
                
                <div id="messages" style="height: 400px; overflow-y: scroll; padding: 10px;">
                    </div>
                
                <div class="p-3 d-flex">
                    <input type="text" id="messageBox" class="form-control" placeholder="Type a message...">
                    <button id="sendBtn" class="btn btn-primary ms-2">Send</button>
                </div>
            </div>
        </div>

      </div>
    </div>
  </section>

  <?php include APPPATH . 'views/includes/modal_post.php'; ?>
  <?php include APPPATH . 'views/includes/modal_detail.php'; ?>
  <?php include APPPATH . 'views/includes/modal_accepted_task.php'; ?>
  <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
  <script src="<?php echo base_url('assets/js/dashboard.js'); ?>"></script>
