<?= $this->extend("layouts/base_view") ?>

<?= $this->section("content") ?>
<div class="container-fluid px-4">
    <?php if(session()->get('logged_user_isAdmin')) { ?>
    <div class="row my-4">
        <div class="col-12 mb-2">
            <div class="d-flex align-items-center">
                <h2>Users</h2>
                <!-- <button type="button" class="btn btn-primary ms-auto" data-bs-toggle="modal" data-bs-target="#addUserModal">Add User</button> -->
            </div>
        </div>
        <div class="col-12">
            <div class="card mb-4">
                <div class="card-header">
                    <!-- <i class="fas fa-chart-area me-1"></i> -->
                    <img src="data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAABgAAAAYCAYAAADgdz34AAAABmJLR0QA/wD/AP+gvaeTAAAAyElEQVRIie2UMQrCMBiFP11108FB5x7FwUk8glcQC97IUnB28DKKTlZoR4fUIX8RQ2xjG4dCH7wlj34v/GkCndqiGRADmfgABD7hCZAbfkjWWLEFXjjyUZCVFKRVH/cbluc+Ck4l2dF9L98VoA/UHM8dmPooAP23ROiZp8DeJ/yvGgJrYGTJxpIN6sJXwA0979CS7yS7Astf4VtA8T7Qp6xNxKGsFbkCNq7wuQF3tQIWLgWXGvDCZxPWsxRU3s4KfTCbPhWdWqAXqAxUU0+GUDEAAAAASUVORK5CYII=">
                    Users List
                </div>
                <div class="card-body">
                    <table class="table table-striped">
                        <thead>
                            <tr>
                                <th scope="col">#</th>
                                <th scope="col">Name</th>
                                <th scope="col">Email</th>
                                <th scope="col">Date Added</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($users as $i => $user) : ?>
                                <tr>
                                    <td><?= $i+1 ?></td>
                                    <td><?= $user['name'] ?></td>
                                    <td><?= $user['email'] ?></td>
                                    <td><?= date('d-M, Y H:i:s', strtotime($user['date_added'])) ?></td>
                                </tr>
                            <?php endforeach ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
    <?php } else { ?>
        <h2 class="text-danger my-3">You don't have access to this page, contact Admin.</h2>
    <?php } ?>

</div>

<!-- Modal -->
<div class="modal fade" id="addUserModal" tabindex="-1" aria-labelledby="addUserModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h1 class="modal-title fs-5" id="addUserModalLabel">New User Details</h1>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form method="POST" action="./auth/register">
                    <div class="form-floating mb-3 ">
                        <input class="form-control" id="inputName" name="name" type="text" placeholder="Enter your name" required />
                        <label for="inputFirstName">Name*</label>
                    </div>
                    <div class="form-floating mb-3">
                        <input class="form-control" id="inputEmail" name="email" type="email" placeholder="name@example.com" required />
                        <label for="inputEmail">Email address*</label>
                    </div>
                    <div class="row mb-3">
                        <div class="col-md-6">
                            <div class="form-floating mb-3 mb-md-0">
                                <input class="form-control" id="inputPassword" name="password" type="password" placeholder="Create a password" />
                                <label for="inputPassword">Password*</label>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-floating mb-3 mb-md-0">
                                <input class="form-control" id="inputPasswordConfirm" name="confirm_password" type="password" placeholder="Confirm password" />
                                <label for="inputPasswordConfirm">Confirm Password*</label>
                            </div>
                        </div>
                    </div>
                    <div class="form-floating mb-3">
                        <input class="form-control" id="inputMobile" name="mobile" type="number" placeholder="9876543210" required />
                        <label for="inputMobile">Mobile*</label>
                    </div>
                    <div class="mt-4 mb-0">
                        <div class=""><button class="btn btn-primary btn-block" type="submit">Create Account</button></div>
                    </div>
                </form>
            </div>
            <!-- <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
        <button type="button" class="btn btn-primary">Add New User</button>
      </div> -->
        </div>
    </div>
</div>

<?= $this->endSection("content") ?>