<?= $this->extend("layouts/base_view") ?>

<?= $this->section("content") ?>
<div class="container-fluid px-4">
    <form action="./attendance/import_attendance" method="post" enctype="multipart/form-data">
        <div class="my-3">
            <label for="formFile" class="form-label">Upload Attendance file (.xls/.xlsx)</label>
            <input class="form-control" type="file" name="atnd_file" id="formFile">
        </div>
        <button type="submit" class="btn btn-primary">Upload</button>
    </form>
</div>


<?= $this->endSection("content") ?>