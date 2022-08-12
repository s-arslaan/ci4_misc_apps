<?= $this->extend("layouts/base_view") ?>

<?= $this->section("content") ?>
<div class="container-fluid px-4">
    <form action="./attendance/import_attendance" method="post" enctype="multipart/form-data">
        <div class="mb-3">
            <label for="formFile" class="form-label">File Input</label>
            <input class="form-control" type="file" name="atnd_file" id="formFile">
        </div>
        <div class="d-flex align-items-center justify-content-between mt-4 mb-0">
            <button type="submit" class="btn btn-primary">Upload</button>
        </div>
    </form>
</div>


<?= $this->endSection("content") ?>