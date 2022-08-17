<?= $this->extend("layouts/base_view") ?>

<?= $this->section("content") ?>
<div class="container-fluid px-4">
    <link rel="stylesheet" type="text/css" href="<?= base_url() ?>/public/assets/css/dataTables.bootstrap5.min.css"/>
 
    <!-- Attendance Table -->
    <div class="row my-4">
        <div class="col-12">
            <!-- <div class="d-flex justify-content-center mb-2"> -->
            <div class="d-flex align-items-center">
                <h3>Attendance</h3>
                <button type="button" class="btn btn-outline-primary ms-auto" data-bs-toggle="modal" data-bs-target="#uploadFileModal">Upload Attendance</button>
            </div>
        </div>
    </div>

    <!-- Upload File Modal -->
    <div class="modal fade" id="uploadFileModal" tabindex="-1" aria-labelledby="uploadFileModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="uploadFileModalLabel">Upload Attendance file (.xls/.xlsx)</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form action="./attendance/import_attendance" method="post" enctype="multipart/form-data">
                    <div class="modal-body">
                        <div class="mb-3">
                            <!-- <label for="formFile" class="col-form-label"></label> -->
                            <input class="form-control" type="file" name="atnd_file" id="formFile">
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                        <input type="submit" class="btn btn-primary" value="Upload" id="submit-btn">
                    </div>
                </form>
            </div>
        </div>
    </div>


    <script type="text/javascript" src="<?= base_url() ?>/public/assets/js/dataTables.bootstrap5.min.js"></script>

</div>


<?= $this->endSection("content") ?>