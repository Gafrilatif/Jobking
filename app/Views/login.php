<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <title><?= $title ?></title>
        <meta name="description" content="">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <link rel="icon" type="image/png" href="<?= base_url('assets/img/crown_logo.png') ?>">
        <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/css/bootstrap.min.css" integrity="sha384-xOolHFLEh07PJGoPkLv1IbcEPTNtaed2xpHsD9ESMhqIYd0nLMwNLD69Npy4HI+N" crossorigin="anonymous">
        <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@400;600&display=swap" rel="stylesheet">
        <link rel="stylesheet" href="<?= base_url('assets/css/style.css') ?>">
        <link rel="stylesheet" href="<?= base_url('assets/css/login.css') ?>">
    </head>
    <body>
        <div class="container-fluid h-100">
            <div class="row h-100">
                <div class="col-12 col-md-4 d-flex flex-column align-items-start justify-content-left" style="background-color: #000; color: #fff; padding-top: 140px;">
                    <img src="<?= base_url('assets/img/jobking_logo.png') ?>" alt="Jobking Logo" style="position: absolute; top: 20px; left: 20px; width: 100px;">
                    <h1 class="text-left mb-4" style="font-size: 25px; font-weight: 550;">DON'T FORGET YOUR CROWN, KING!</h1>
                    <h1 class="text-left ml-5" style="font-size: 25px; font-weight: 550; margin-top: 30px; margin-right: 10px;">WELCOME BACK, READY TO DO SOME COMMISSIONS?</h1>
                </div>
                <div class="col-12 col-md-8 d-flex align-items-center justify-content-center" style="background-color: #fff; border-top-left-radius: 60px; border-bottom-left-radius: 60px;">
                    <div class="form-wrapper">
                        <h1 style="font-weight: 600;">LOGIN</h1>
                        <?php if (session()->get('success')) : ?>
                            <div class="alert alert-success" role="alert">
                                <?= session()->get('success') ?>
                            </div>
                        <?php endif; ?>
                        <form action="<?= base_url('/login') ?>" method="post">
                            <div class="form-group">
                                <label for="email">Email</label>
                                <input type="email" name="email" id="email" class="form-control" value="<?= isset($old_input['email']) ? $old_input['email'] : '' ?>">
                            </div>
                            <div class="form-group">
                                <label for="password">Password</label>
                                <input type="password" name="password" id="password" class="form-control">
                            </div>
                            <?php if (isset($validation)) : ?>
                                <div class="alert alert-danger errors" role="alert">
                                    <?= $validation->listErrors() ?>
                                </div>
                            <?php endif; ?>
                            <div class="d-flex justify-content-start align-items-center">
                                <button type="submit" class="btn btn-md btn-yellow">Login</button>
                                <span class="ml-3">Do you have an account or not? </span>
                                <a class="ml-2" href="<?= base_url('/register') ?>">Register</a>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>

        <div style="position: absolute; bottom: 0px; left: 200px;">
            <img src="<?= base_url('assets/img/crown_logo.png') ?>" alt="Crown Logo" style="width: 550px;"> <!-- Adjust width as needed -->
        </div>
        
        <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/js/bootstrap.bundle.min.js"></script>
    </body>
</html>



