<?= $this->extend("layouts/base_view") ?>

<?= $this->section("content") ?>
<div class="container-fluid px-4">
    <link rel="stylesheet" type="text/css" href="<?= base_url() ?>/public/assets/css/dataTables.bootstrap5.min.css"/>
    <link rel="stylesheet" type="text/css" href="<?= base_url() ?>/public/assets/css/responsive.bootstrap5.min.css"/>
    <link rel="stylesheet" type="text/css" href="<?= base_url() ?>/public/assets/css/scroller.bootstrap5.min.css"/>
 
    <!-- Timings Table -->
    <div class="row my-4">
        <div class="col-12">
            <h3>Timings</h3>
        </div>
        <div class="col-12 mt-3">
            <table id="attendance_table" class="table table-striped dt-responsive nowrap">
                <thead>
                    <tr>
                        <th>#</th>
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

    <script type="text/javascript" src="<?= base_url() ?>/public/assets/js/jquery.dataTables.min.js"></script>
    <script type="text/javascript" src="<?= base_url() ?>/public/assets/js/dataTables.bootstrap5.min.js"></script>
    <script type="text/javascript" src="<?= base_url() ?>/public/assets/js/dataTables.responsive.min.js"></script>
    <script type="text/javascript" src="<?= base_url() ?>/public/assets/js/responsive.bootstrap5.min.js"></script>
    <script type="text/javascript" src="<?= base_url() ?>/public/assets/js/scroller.bootstrap5.min.js"></script>
    <script>
        $(document).ready(function () {
            $('#attendance_table').DataTable({
                ajax: {
                    url: './getAttendance/0',
                    dataSrc: ''
                },
                columns: [
                    {responsivePriority: 1, data:"id"},
                    {responsivePriority: 1, data:"emp_code"},
                    {responsivePriority: 1, data:"emp_name"},
                    {responsivePriority: 1, data:"month"},
                    {responsivePriority: 2, data:"date_1"},
                    {responsivePriority: 2, data:"date_2"},
                    {responsivePriority: 2, data:"date_3"},
                    {responsivePriority: 2, data:"date_4"},
                    {responsivePriority: 2, data:"date_5"},
                    {responsivePriority: 2, data:"date_6"},
                    {responsivePriority: 2, data:"date_7"},
                    {responsivePriority: 2, data:"date_8"},
                    {responsivePriority: 2, data:"date_9"},
                    {responsivePriority: 2, data:"date_10"},
                    {responsivePriority: 2, data:"date_11"},
                    {responsivePriority: 2, data:"date_12"},
                    {responsivePriority: 2, data:"date_13"},
                    {responsivePriority: 2, data:"date_14"},
                    {responsivePriority: 2, data:"date_15"},
                    {responsivePriority: 2, data:"date_16"},
                    {responsivePriority: 2, data:"date_17"},
                    {responsivePriority: 2, data:"date_18"},
                    {responsivePriority: 2, data:"date_19"},
                    {responsivePriority: 2, data:"date_20"},
                    {responsivePriority: 2, data:"date_21"},
                    {responsivePriority: 2, data:"date_22"},
                    {responsivePriority: 2, data:"date_23"},
                    {responsivePriority: 2, data:"date_24"},
                    {responsivePriority: 2, data:"date_25"},
                    {responsivePriority: 2, data:"date_26"},
                    {responsivePriority: 2, data:"date_27"},
                    {responsivePriority: 2, data:"date_28"},
                    {responsivePriority: 2, data:"date_29"},
                    {responsivePriority: 2, data:"date_30"},
                    {responsivePriority: 2, data:"date_31"},
                    {responsivePriority: 1, data:"present_days"},
                    {responsivePriority: 1, data:"absent_days"},
                ]
            });
        });
    </script>
</div>



<?= $this->endSection("content") ?>