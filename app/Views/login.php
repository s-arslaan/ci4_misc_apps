<?php $page_session = \Config\Services::session(); ?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
    <meta name="description" content="" />
    <meta name="author" content="" />
    <!-- <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous"> -->
    <title><?= $title; ?></title>
    <link href="<?= base_url() ?>/assets/css/styles.css" rel="stylesheet" />
    <link href="<?= base_url() ?>/assets/css/toastr.min.css" rel="stylesheet" />
    <!-- fa -->
    <script src="<?= base_url() ?>/assets/js/all.min.js"></script>
</head>

<body class="bg-info">
    <div id="layoutAuthentication">
        <div id="layoutAuthentication_content">
            <main>
                <div class="container">
                    <div class="row justify-content-center">
                        <div class="col-lg-5">
                            <div class="card shadow-lg border-0 rounded-lg mt-5">
                                <div class="card-header">
                                    <h3 class="text-center font-weight-light my-4"><?= APP_NAME ?> Login</h3>
                                </div>
                                <div class="card-body">
                                    <form method="POST">
                                        <div class="form-floating mb-3">
                                            <input class="form-control" id="inputEmail" name="email" type="email" placeholder="name@example.com" required />
                                            <label for="inputEmail">Email address*</label>
                                        </div>
                                        <div class="form-floating mb-3">
                                            <input class="form-control" id="inputPassword" name="password" type="password" placeholder="Password" required />
                                            <label for="inputPassword">Password*</label>
                                        </div>
                                        <!-- <div class="form-check mb-3">
                                                <input class="form-check-input" id="inputRememberPassword" type="checkbox" value="" />
                                                <label class="form-check-label" for="inputRememberPassword">Remember Password</label>
                                            </div> -->
                                        <div class="d-flex align-items-center justify-content-between mt-4 mb-0">
                                            <!-- <a class="small" href="<?= base_url() ?>/auth/forgotPassword">Forgot Password?</a> -->
                                            <button type="submit" class="btn btn-primary">Login</button>
                                        </div>
                                    </form>
                                </div>
                                <div class="card-footer text-center py-3">
                                    <!-- <div class="small"><a href="<?= base_url() ?>/auth/register">Need an account? Sign up!</a></div> -->
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

<?= $this->include("layouts/footer"); ?>