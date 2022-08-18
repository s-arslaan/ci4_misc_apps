<?= $this->extend("layouts/base_view") ?>

<?= $this->section("content") ?>
<div class="container-fluid px-4">
    <link rel="stylesheet" type="text/css" href="<?= base_url() ?>/public/assets/css/dataTables.bootstrap5.min.css"/>
    <link rel="stylesheet" type="text/css" href="<?= base_url() ?>/public/assets/css/responsive.bootstrap5.min.css"/>
    <link rel="stylesheet" type="text/css" href="<?= base_url() ?>/public/assets/css/scroller.bootstrap5.min.css"/>
 
    <!-- Attendance Table -->
    <div class="row my-4">
        <div class="col-12">
            <!-- <div class="d-flex justify-content-center mb-2"> -->
            <div class="d-flex align-items-center">
                <h3>Attendance</h3>
                <button type="button" class="btn btn-outline-primary ms-auto" data-bs-toggle="modal" data-bs-target="#uploadFileModal">Upload Attendance</button>
            </div>
        </div>
        <div class="col-12 mt-3">
            <table id="attendance_table" class="table table-striped dt-responsive nowrap">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Code</th>
                        <th>Name</th>
                        <th>month</th>
                        <th>1</th>
                        <th>2</th>
                        <th>3</th>
                        <th>4</th>
                        <th>5</th>
                        <th>6</th>
                        <th>7</th>
                        <th>8</th>
                        <th>9</th>
                        <th>10</th>
                        <th>11</th>
                        <th>12</th>
                        <th>13</th>
                        <th>14</th>
                        <th>15</th>
                        <th>16</th>
                        <th>17</th>
                        <th>18</th>
                        <th>19</th>
                        <th>20</th>
                        <th>21</th>
                        <th>22</th>
                        <th>23</th>
                        <th>24</th>
                        <th>25</th>
                        <th>26</th>
                        <th>27</th>
                        <th>28</th>
                        <th>29</th>
                        <th>30</th>
                        <th>31</th>
                        <th>present_days</th>
                        <th>absent_days</th>
                    </tr>
                </thead>
            </table>
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

    <script type="text/javascript" src="<?= base_url() ?>/public/assets/js/jquery.dataTables.min.js"></script>
    <script type="text/javascript" src="<?= base_url() ?>/public/assets/js/dataTables.bootstrap5.min.js"></script>
    <script type="text/javascript" src="<?= base_url() ?>/public/assets/js/dataTables.responsive.min.js"></script>
    <script type="text/javascript" src="<?= base_url() ?>/public/assets/js/responsive.bootstrap5.min.js"></script>
    <script type="text/javascript" src="<?= base_url() ?>/public/assets/js/scroller.bootstrap5.min.js"></script>
    <script>
        $(document).ready(function () {
            $('#attendance_table').DataTable({
                ajax: {
                    url: './attendance/getAttendance/2',
                    dataSrc: ''
                },
                columns: [
                    {responsivePriority: 1, data:"attendance_id"},
                    {responsivePriority: 1, data:"emp_code"},
                    {responsivePriority: 1, data:"emp_name"},
                    {responsivePriority: 1, data:"month"},
                    {data:"date_1"},
                    {data:"date_2"},
                    {data:"date_3"},
                    {data:"date_4"},
                    {data:"date_5"},
                    {data:"date_6"},
                    {data:"date_7"},
                    {data:"date_8"},
                    {data:"date_9"},
                    {data:"date_10"},
                    {data:"date_11"},
                    {data:"date_12"},
                    {data:"date_13"},
                    {data:"date_14"},
                    {data:"date_15"},
                    {data:"date_16"},
                    {data:"date_17"},
                    {data:"date_18"},
                    {data:"date_19"},
                    {data:"date_20"},
                    {data:"date_21"},
                    {data:"date_22"},
                    {data:"date_23"},
                    {data:"date_24"},
                    {data:"date_25"},
                    {data:"date_26"},
                    {data:"date_27"},
                    {data:"date_28"},
                    {data:"date_29"},
                    {data:"date_30"},
                    {data:"date_31"},
                    {responsivePriority: 1, data:"present_days"},
                    {responsivePriority: 1, data:"absent_days"},
                ]
            });
        });
    </script>
</div>



<?= $this->endSection("content") ?>