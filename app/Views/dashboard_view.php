<?= $this->extend("layouts/base_view") ?>

<?= $this->section("content") ?>
<div class="container-fluid px-4">

    <h1 class="my-3">Dashboard</h1>
    <div class="row">
        <div class="col-md-6">
            <div class="card bg-primary text-white mb-4">
                <div class="d-flex card-body display-5">
                    Successful Rescues
                    <span class="badge bg-secondary ms-auto">24</span>
                </div>
                <!-- <div class="card-footer d-flex align-items-center justify-content-between"> -->
                <!-- <a class="small text-white stretched-link" href="=/attendance">View Details</a> -->
                <!-- <div class="small text-white"><i class="fas fa-angle-right"></i></div> -->
                <!-- <img src="data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAABgAAAAYCAYAAADgdz34AAAABmJLR0QA/wD/AP+gvaeTAAAAW0lEQVRIie2VMQ6AIBAECS21RF9qyxul4DljIZ3Q3RoTbh8ws9vchbBEgKSEF6ABhwKegMqTCmSFZAOuLpEtcYlL5pJo6bQjvdvvDnf4FP7JuT7Nmw8kupf5+9z81yZot2e+VwAAAABJRU5ErkJggg=="> -->
                <!-- </div> -->
            </div>
        </div>
        <div class="col-md-6">
            <div class="card bg-danger text-white mb-4">
                <div class="d-flex card-body display-5">
                    Today's Alerts
                    <span class="badge bg-secondary ms-auto">3</span>
                </div>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-12">
            <div class="card mb-4">
                <div class="card-header">
                    <!-- <i class="fas fa-chart-area me-1"></i> -->
                    <img src="data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAABgAAAAYCAYAAADgdz34AAAABmJLR0QA/wD/AP+gvaeTAAAAyElEQVRIie2UMQrCMBiFP11108FB5x7FwUk8glcQC97IUnB28DKKTlZoR4fUIX8RQ2xjG4dCH7wlj34v/GkCndqiGRADmfgABD7hCZAbfkjWWLEFXjjyUZCVFKRVH/cbluc+Ck4l2dF9L98VoA/UHM8dmPooAP23ROiZp8DeJ/yvGgJrYGTJxpIN6sJXwA0979CS7yS7Astf4VtA8T7Qp6xNxKGsFbkCNq7wuQF3tQIWLgWXGvDCZxPWsxRU3s4KfTCbPhWdWqAXqAxUU0+GUDEAAAAASUVORK5CYII=">
                    Alerts
                </div>
                <div class="card-body">
                    <table class="table table-striped table-responsive">
                        <thead>
                            <tr>
                                <th scope="col">#</th>
                                <th scope="col">Name</th>
                                <th scope="col">Timestamp</th>
                                <th scope="col">City</th>
                                <th scope="col">Address</th>
                                <th scope="col">Latitude</th>
                                <th scope="col">Longitude</th>
                                <th scope="col">Rescue Status</th>
                                <th scope="col">Remarks</th>
                                <th scope="col">Email</th>
                                <th scope="col">Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($alerts as $i => $alert) : ?>
                                <tr>
                                    <th scope="col"><?= $i+1 ?></th>
                                    <td><?= $alert['name'] ?></td>
                                    <td><?= date('d-M, Y H:i:s', strtotime($alert['timestamp'])) ?></td>
                                    <td><?= $alert['city_name'] ?></td>
                                    <td><?= $alert['address'] ?></td>
                                    <td><?= $alert['latitude'] ?></td>
                                    <td><?= $alert['longitude'] ?></td>
                                    <td><?= $alert['isRescued'] == 0 ? 'Not Rescued':'Rescued' ?></td>
                                    <td><?= $alert['remarks'] ?? '' ?></td>
                                    <td><?= $alert['email'] ?? '' ?></td>
                                    <td><button class="btn btn-warning btn-sm">Details</button></td>
                                </tr>
                            <?php endforeach ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

</div>

<?= $this->endSection("content") ?>