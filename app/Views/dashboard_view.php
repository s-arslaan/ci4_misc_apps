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
                    <!-- <div class="small text-white"><i class="fas fa-angle-right"></i></div> -->
                    <img src="data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAABgAAAAYCAYAAADgdz34AAAABmJLR0QA/wD/AP+gvaeTAAAAW0lEQVRIie2VMQ6AIBAECS21RF9qyxul4DljIZ3Q3RoTbh8ws9vchbBEgKSEF6ABhwKegMqTCmSFZAOuLpEtcYlL5pJo6bQjvdvvDnf4FP7JuT7Nmw8kupf5+9z81yZot2e+VwAAAABJRU5ErkJggg==">
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
                    <!-- <div class="small text-white"><i class="fas fa-angle-right"></i></div> -->
                    <img src="data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAABgAAAAYCAYAAADgdz34AAAABmJLR0QA/wD/AP+gvaeTAAAAW0lEQVRIie2VMQ6AIBAECS21RF9qyxul4DljIZ3Q3RoTbh8ws9vchbBEgKSEF6ABhwKegMqTCmSFZAOuLpEtcYlL5pJo6bQjvdvvDnf4FP7JuT7Nmw8kupf5+9z81yZot2e+VwAAAABJRU5ErkJggg==">
                </div>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-xl-6">
            <div class="card mb-4">
                <div class="card-header">
                    <!-- <i class="fas fa-chart-area me-1"></i> -->
                    <img src="data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAABgAAAAYCAYAAADgdz34AAAABmJLR0QA/wD/AP+gvaeTAAAAyElEQVRIie2UMQrCMBiFP11108FB5x7FwUk8glcQC97IUnB28DKKTlZoR4fUIX8RQ2xjG4dCH7wlj34v/GkCndqiGRADmfgABD7hCZAbfkjWWLEFXjjyUZCVFKRVH/cbluc+Ck4l2dF9L98VoA/UHM8dmPooAP23ROiZp8DeJ/yvGgJrYGTJxpIN6sJXwA0979CS7yS7Astf4VtA8T7Qp6xNxKGsFbkCNq7wuQF3tQIWLgWXGvDCZxPWsxRU3s4KfTCbPhWdWqAXqAxUU0+GUDEAAAAASUVORK5CYII=">
                    Current Attendance Names
                </div>
                <div class="card-body">
                    <?php foreach ($names as $name) : ?>
                        <span class="badge text-bg-light border border-secondary fs-6"><?= ucwords($name['emp_name']) ?></span>
                    <?php endforeach ?>
                </div>
            </div>
        </div>
        <div class="col-xl-6">
            <div class="card mb-4">
                <div class="card-header">
                    <!-- <i class="fas fa-chart-area me-1"></i> -->
                    <img src="data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAABgAAAAYCAYAAADgdz34AAAABmJLR0QA/wD/AP+gvaeTAAAAf0lEQVRIie2VQQ7AIAgE16aP8/9P0IfgpSTVFAiV9sQkHtYQNoBBIHFSAXQA9PK0K4dI20h+NxHhoCiNQ3OLoCyaHqM28n5egWRQMFfn1aZBGDkDSZsGYZzC/ToLj+6aYcQempadVAH3kwxt8vsr4v5pW1LtsUWF/ieYH0riZgC9bFQot9fLAwAAAABJRU5ErkJggg==">
                    Current Attendance Months
                </div>
                <div class="card-body">
                    <?php foreach ($months as $month) : ?>
                        <span class="badge text-bg-light border border-secondary fs-6"><?= ucwords($month['month']) ?></span>
                    <?php endforeach ?>
                </div>
            </div>
        </div>
    </div>

</div>

<?= $this->endSection("content") ?>