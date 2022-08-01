
<?= $this->extend("layouts/base_view") ?>

<?= $this->section("content") ?>
<div class="container-fluid px-4">
    <ul>
<?php

print_r($_SESSION);
print_r($user);
?>
</ul>
</div>


<?= $this->endSection("content") ?>

