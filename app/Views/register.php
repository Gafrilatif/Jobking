<!-- <div class="container">
    <div class="row">
        <div class="col-12 col-sm-8 offset-sm-2 col-md-6 offset-md-3 mt-5 pt-3 pb-3 bg-white form-wrapper">
            <h1>Register</h1>
            <form action="<?= base_url('/register') ?>" method="post">
                <div class="form-group">
                    <label for="username">username</label>
                    <input type="text" name="username" id="username" class="form-control" value="<?= isset($old_input['username']) ? $old_input['username'] : '' ?>">
                </div>
                <div class="form-group">
                    <label for="email">Email</label>
                    <input type="email" name="email" id="email" class="form-control" value="<?= isset($old_input['email']) ? $old_input['email'] : '' ?>">
                </div>
                <div class="row">
                    <div class="col-12 col-sm-6">
                        <div class="form-group">
                            <label for="password">Password</label>
                            <input type="password" name="password" id="password" class="form-control">
                        </div>
                    </div>
                    <div class="col-12 col-sm-6">
                        <div class="form-group">
                            <label for="password_confirm">Confirm Password</label>
                            <input type="password" name="password_confirm" id="password_confirm" class="form-control">
                        </div>
                    </div>
                    <?php if (isset($validation)) : ?>
                        <div class="col-12">
                            <div class="alert alert-danger errors" role="alert">
                                <?= $validation->listErrors() ?>
                            </div>
                        </div>
                    <?php endif; ?>
                </div>

                <div class="row">
                    <div class="col-12 col-sm-4">
                        <button type="submit" class="btn btn-primary">Register</button>
                    </div>
                    <div class="col-12 col-sm-8 text-right">
                        <a href="<?= base_url('/login') ?>">Already have an account?</a>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div> -->

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="icon" type="image/png" href="<?= base_url('assets/img/crown_logo.png') ?>">
    <title><?= $title ?></title>
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@400;600&display=swap" rel="stylesheet">
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
                    <form action="<?= base_url('/register') ?>" method="post">
                        <div class="form-group">
                            <label for="username">Username</label>
                            <input type="text" name="username" id="username" class="form-control" value="<?= isset($old_input['username']) ? $old_input['username'] : '' ?>">
                        </div>

                        <div class="form-group">
                            <label for="email">Email</label>
                            <input type="email" name="email" id="email" class="form-control" value="<?= isset($old_input['email']) ? $old_input['email'] : '' ?>">
                        </div>

                        <div class="form-group">
                            <label for="password">Password</label>
                            <input type="password" name="password" id="password" class="form-control">
                        </div>

                        <div class="form-group">
                            <label for="password_confirm">Confirm Password</label>
                            <input type="password" name="password_confirm" id="password_confirm" class="form-control">
                        </div>

                        <?php if (isset($validation)) : ?>
                            <div class="alert alert-danger errors" role="alert">
                                <?= $validation->listErrors() ?>
                            </div>
                        <?php endif; ?>

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
        <img src="<?= base_url('assets/img/crown_logo.png') ?>" alt="Crown Logo" style="width: 550px;"> <!-- Adjust width as needed -->
    </div>
    

    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>



