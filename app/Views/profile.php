
<?= $this->extend("layouts/base_view") ?>

<?= $this->section("content") ?>
<div class="container-fluid px-4">
    <ul>
<?php

print_r($_SESSION);
// print_r($users);
?>
</ul>
</div>


<?= $this->endSection("content") ?>

