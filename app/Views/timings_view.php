<?= $this->extend("layouts/base_view") ?>

<?= $this->section("content") ?>
<div class="container-fluid px-4">
    <link rel="stylesheet" type="text/css" href="<?= base_url() ?>/assets/css/dataTables.bootstrap5.min.css"/>
    <link rel="stylesheet" type="text/css" href="<?= base_url() ?>/assets/css/responsive.bootstrap5.min.css"/>
    <link rel="stylesheet" type="text/css" href="<?= base_url() ?>/assets/css/scroller.bootstrap5.min.css"/>
 
    <!-- Timings Table -->
    <div class="row my-4">
        <div class="col-12">
            <div class="d-flex align-items-center">
                <h2>Timings</h2>
                <ul class="nav nav-pills ms-auto" id="pills-tab" role="tablist">
                    <li class="nav-item" role="presentation">
                        <button class="nav-link active" id="pill-in-tab" data-bs-toggle="pill" data-bs-target="#pill-in" type="button" role="tab" aria-controls="pill-in" aria-selected="true" onclick="showTable();">IN Timings</button>
                    </li>
                    <li class="nav-item" role="presentation">
                        <button class="nav-link" id="pill-out-tab" data-bs-toggle="pill" data-bs-target="#pill-out" type="button" role="tab" aria-controls="pill-out" aria-selected="false" onclick="showTable();">OUT Timings</button>
                    </li>
                </ul>
            </div>
        </div>

        <div class="col-12 mt-3">
            <div class="tab-content" id="pills-tabContent">
                <div class="tab-pane fade show active" id="pill-in" role="tabpanel" aria-labelledby="pill-in-tab" tabindex="0">
                    <table id="in_table" class="table table-striped-columns table-hover dt-responsive nowrap">
                        <thead>
                            <tr>
                                <th>#</th><th>Code</th><th>Name</th><th>month</th><th>1</th><th>2</th><th>3</th><th>4</th><th>5</th><th>6</th><th>7</th><th>8</th><th>9</th><th>10</th><th>11</th><th>12</th><th>13</th><th>14</th><th>15</th><th>16</th><th>17</th><th>18</th><th>19</th><th>20</th><th>21</th><th>22</th><th>23</th><th>24</th><th>25</th><th>26</th><th>27</th><th>28</th><th>29</th><th>30</th><th>31</th><th>present_days</th><th>absent_days</th>
                            </tr>
                        </thead>
                    </table>
                </div>
                <div class="tab-pane fade" id="pill-out" role="tabpanel" aria-labelledby="pill-out-tab" tabindex="0">
                    <table id="out_table" class="table table-striped-columns table-hover dt-responsive nowrap">
                        <thead>
                            <tr>
                                <th>#</th><th>Code</th><th>Name</th><th>month</th><th>1</th><th>2</th><th>3</th><th>4</th><th>5</th><th>6</th><th>7</th><th>8</th><th>9</th><th>10</th><th>11</th><th>12</th><th>13</th><th>14</th><th>15</th><th>16</th><th>17</th><th>18</th><th>19</th><th>20</th><th>21</th><th>22</th><th>23</th><th>24</th><th>25</th><th>26</th><th>27</th><th>28</th><th>29</th><th>30</th><th>31</th><th>present_days</th><th>absent_days</th>
                            </tr>
                        </thead>
                    </table>
                </div>
            </div>
        </div>


    </div>

    <script type="text/javascript" src="<?= base_url() ?>/assets/js/jquery.dataTables.min.js"></script>
    <script type="text/javascript" src="<?= base_url() ?>/assets/js/dataTables.bootstrap5.min.js"></script>
    <script type="text/javascript" src="<?= base_url() ?>/assets/js/dataTables.responsive.min.js"></script>
    <script type="text/javascript" src="<?= base_url() ?>/assets/js/responsive.bootstrap5.min.js"></script>
    <script type="text/javascript" src="<?= base_url() ?>/assets/js/scroller.bootstrap5.min.js"></script>
    <script>
        const showTable = () => {
            let sh = $('#pills-tab > .nav-item > .active').attr('id');
            let table = '';
            let url = '';
            
            if(sh === 'pill-in-tab'){
                table = '#in_table';
                url = './getAttendance/0';
            }
            else if (sh === 'pill-out-tab'){
                table = '#out_table'
                url = './getAttendance/1';
            }
            // console.log(table+' '+url+' '+sh);

            $(table).DataTable({
                retrieve: true,
                ajax: {
                    url: url,
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
        }
        showTable();
    </script>
</div>



<?= $this->endSection("content") ?>