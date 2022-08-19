<?= $this->extend("layouts/base_view") ?>

<?= $this->section("content") ?>
<div class="container-fluid px-4">
    <!--
        people emp_code
        months 
    -->
    <h1 class="my-3">Dashboard</h1>
    <div class="row">
        <div class="col-md-6">
            <div class="card bg-primary text-white mb-4">
                <div class="d-flex card-body display-5">
                    Total People
                    <span class="badge bg-secondary ms-auto"><?= $count_names ?></span>
                </div>
                <div class="card-footer d-flex align-items-center justify-content-between">
                    <a class="small text-white stretched-link" href="<?= base_url() ?>./attendance">View Details</a>
                    <div class="small text-white"><i class="fas fa-angle-right"></i></div>
                </div>
            </div>
        </div>
        <div class="col-md-6">
            <div class="card bg-warning text-white mb-4">
                <div class="d-flex card-body display-5">
                    Total Months
                    <span class="badge bg-secondary ms-auto"><?= $count_months ?></span>
                </div>
                <div class="card-footer d-flex align-items-center justify-content-between">
                    <a class="small text-white stretched-link" href="<?= base_url() ?>./attendance">View Details</a>
                    <div class="small text-white"><i class="fas fa-angle-right"></i></div>
                </div>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-xl-6">
            <div class="card mb-4">
                <div class="card-header">
                    <i class="fas fa-chart-area me-1"></i>
                    Current Attendance Names
                </div>
                <div class="card-body">
                    <?php foreach ($names as $name) : ?>
                        <span class="badge text-bg-light border border-secondary fs-6"><?= $name['emp_name'] ?></span>
                    <?php endforeach ?>
                </div>
            </div>
        </div>
        <div class="col-xl-6">
            <div class="card mb-4">
                <div class="card-header">
                    <i class="fas fa-chart-area me-1"></i>
                    Current Attendance Months
                </div>
                <div class="card-body">
                    <?php foreach ($months as $month) : ?>
                        <span class="badge text-bg-light border border-secondary fs-6"><?= $month['month'] ?></span>
                    <?php endforeach ?>
                </div>
            </div>
        </div>
    </div>

</div>

<?= $this->endSection("content") ?>