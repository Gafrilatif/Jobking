<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="icon" type="image/png" href="<?= base_url('assets/img/crown_logo.png') ?>">
    <title><?= $title ?></title>
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@400;600&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/cropperjs/1.6.1/cropper.min.css" />
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/css/bootstrap.min.css" integrity="sha384-xOolHFLEh07PJGoPkLv1IbcEPTNtaed2xpHsD9ESMhqIYd0nLMwNLD69Npy4HI+N" crossorigin="anonymous">
    <link rel="stylesheet" href="<?= base_url('assets/css/style.css') ?>">
    <link rel="stylesheet" href="<?= base_url('assets/css/register.css') ?>">
</head>
<body>
    <div class="container-fluid h-100">
        <div class="row h-100">
            <div class="col-12 col-md-4 d-flex flex-column align-items-start justify-content-left" style="background-color: #000; color: #fff; padding-top: 150px;">
                <img src="<?= base_url('assets/img/jobking_logo.png') ?>" alt="Jobking Logo" style="position: absolute; top: 20px; left: 20px; width: 100px;">
                <h1 class="text-left mb-4" style="font-size: 25px; font-weight: 550;">HERE'S YOUR CROWN, KING!</h1>
                <h1 class="text-left ml-5" style="font-size: 25px; font-weight: 550; margin-top: 40px; margin-right: 10px;">DO COMMISSIONS, MAKE MONEY, YOUR JOURNEY STARTS HERE!</h1>
            </div>
            <div class="col-12 col-md-8 d-flex align-items-center justify-content-center" style="background-color: #fff; border-top-left-radius: 60px; border-bottom-left-radius: 60px;">
                <div class="form-wrapper">
                    <h1 style="font-weight: 600;">REGISTER</h1>
                    <form action="<?= base_url('/register') ?>" method="post" enctype="multipart/form-data">
                        <div class="form-group">
                            <label for="username">Username</label>
                            <input type="text" name="username" id="username" class="form-control" value="<?= isset($old_input['username']) ? esc($old_input['username']) : '' ?>">
                        </div>

                        <div class="form-group">
                            <label for="email">Email</label>
                            <input type="email" name="email" id="email" class="form-control" value="<?= isset($old_input['email']) ? esc($old_input['email']) : '' ?>">
                        </div>

                        <div class="form-group">
                            <label for="profile_picture">Profile Picture (Optional)</label>
                            
                            <div class="custom-file-container">
                                <input type="file" name="profile_picture" id="profile_picture_input" class="inputfile" accept="image/*">
                                <label for="profile_picture_input" class="custom-file-upload">Choose file</label>
                                <span class="file-name">No file chosen</span>
                            </div>

                            <div class="avatar-preview-container text-center mt-3">
                                <img id="avatar-preview" src="" alt="Avatar Preview" class="rounded-circle" style="display: none; width: 150px; height: 150px; object-fit: cover; border: 2px solid #eee;">
                            </div>
                        </div>

                        <div class="form-group">
                            <label for="password">Password</label>
                            <div class="password-wrapper">
                                <input type="password" name="password" id="password" class="form-control">
                                <i class="bi bi-eye-slash toggle-password"></i>
                            </div>
                        </div>

                        <div class="form-group">
                            <label for="password_confirm">Confirm Password</label>
                            <div class="password-wrapper">
                                <input type="password" name="password_confirm" id="password_confirm" class="form-control">
                                <i class="bi bi-eye-slash toggle-password"></i>
                            </div>
                        </div>

                        <div class="alert alert-danger errors" role="alert" style="display: none;">
                        </div>

                        <div class="d-flex justify-content-start align-items-center">
                                <button type="submit" class="btn btn-md btn-yellow">Register</button>
                                <span class="ml-3">Do you have an account or not? </span>
                                <a class="ml-2" href="<?= base_url('/login') ?>">Login</a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <div style="position: absolute; bottom: 0px; left: 200px;">
        <img src="<?= base_url('assets/img/crown_logo.png') ?>" alt="Crown Logo" style="width: 550px;"> </div>
    

    <?php include APPPATH . 'views/includes/modal_crop.php'; ?>
    <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/cropperjs/1.6.1/cropper.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        var baseUrl = "<?= base_url('/') ?>";
        var csrfName = "<?= csrf_token() ?>"; // CSRF Token Name
        var csrfHash = "<?= csrf_hash() ?>"; // CSRF Hash
    </script>
    <script src="<?php echo base_url('assets/js/register.js'); ?>"></script>
</body>
</html>
