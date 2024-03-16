<?php 
$page_id = null;
$comp_model = new SharedController;
$current_page = $this->set_current_page_link();
?>
<div>
    <div  class="bg-light p-3 mb-3">
        <div class="container">
            <div class="row ">
                <div class="col-md-12 comp-grid">
                    <h4 >The Dashboard</h4>
                </div>
            </div>
        </div>
    </div>
    <div  class="mb-3">
        <div class="container">
            <div class="row ">
                <div class="col-sm-4 comp-grid">
                    <?php $rec_count = $comp_model->getcount_totalsiswa();  ?>
                    <a class="animated zoomIn record-count card bg-light text-dark"  href="<?php print_link("siswa/") ?>">
                        <div class="row">
                            <div class="col-2">
                                <i class="fa fa-users "></i>
                            </div>
                            <div class="col-10">
                                <div class="flex-column justify-content align-center">
                                    <div class="title">Total Siswa</div>
                                    <small class=""></small>
                                </div>
                            </div>
                            <h4 class="value"><strong><?php echo $rec_count; ?></strong></h4>
                        </div>
                    </a>
                </div>
                <div class="col-md-4 comp-grid">
                    <?php $rec_count = $comp_model->getcount_lakilaki();  ?>
                    <a class="animated zoomIn record-count card bg-secondary text-white"  href="<?php print_link("siswa/") ?>">
                        <div class="row">
                            <div class="col-2">
                                <i class="fa fa-mars "></i>
                            </div>
                            <div class="col-10">
                                <div class="flex-column justify-content align-center">
                                    <div class="title">Laki - Laki</div>
                                    <small class=""></small>
                                </div>
                            </div>
                            <h4 class="value"><strong><?php echo $rec_count; ?></strong></h4>
                        </div>
                    </a>
                </div>
                <div class="col-md-4 comp-grid">
                    <?php $rec_count = $comp_model->getcount_perempuan();  ?>
                    <a class="animated zoomIn record-count card bg-light text-dark"  href="<?php print_link("siswa/") ?>">
                        <div class="row">
                            <div class="col-2">
                                <i class="fa fa-mercury "></i>
                            </div>
                            <div class="col-10">
                                <div class="flex-column justify-content align-center">
                                    <div class="title">Perempuan</div>
                                    <small class=""></small>
                                </div>
                            </div>
                            <h4 class="value"><strong><?php echo $rec_count; ?></strong></h4>
                        </div>
                    </a>
                </div>
            </div>
        </div>
    </div>
    <div  class="mb-3">
        <div class="container">
            <div class="row ">
                <div class="col-sm-6 comp-grid">
                    <div class="card card-body">
                        <?php 
                        $chartdata = $comp_model->doughnutchart_jeniskelamin();
                        ?>
                        <div>
                            <h4>Jenis Kelamin</h4>
                            <small class="text-muted"></small>
                        </div>
                        <hr />
                        <canvas id="doughnutchart_jeniskelamin"></canvas>
                        <script>
                            $(function (){
                            var chartData = {
                            labels : <?php echo json_encode($chartdata['labels']); ?>,
                            datasets : [
                            {
                            label: 'Jenis Kelamin',
                            backgroundColor:'rgba(0 , 128 , 192, 0.5)',
                            borderWidth:3,
                            data : <?php echo json_encode($chartdata['datasets'][0]); ?>,
                            }
                            ]
                            }
                            var ctx = document.getElementById('doughnutchart_jeniskelamin');
                            var chart = new Chart(ctx, {
                            type:'doughnut',
                            data: chartData,
                            options: {
                            responsive: true,
                            scales: {
                            yAxes: [{
                            ticks:{display: false},
                            gridLines:{display: false},
                            scaleLabel: {
                            display: true,
                            labelString: ""
                            }
                            }],
                            xAxes: [{
                            ticks:{display: false},
                            gridLines:{display: false},
                            scaleLabel: {
                            display: true,
                            labelString: ""
                            }
                            }],
                            },
                            }
                            ,
                            })});
                        </script>
                    </div>
                </div>
                <div class="col-sm-6 comp-grid">
                    <div class="card card-body">
                        <?php 
                        $chartdata = $comp_model->piechart_kotaasal();
                        ?>
                        <div>
                            <h4>Kota Asal</h4>
                            <small class="text-muted"></small>
                        </div>
                        <hr />
                        <canvas id="piechart_kotaasal"></canvas>
                        <script>
                            $(function (){
                            var chartData = {
                            labels : <?php echo json_encode($chartdata['labels']); ?>,
                            datasets : [
                            {
                            label: 'Kota Asal',
                            backgroundColor:'rgba(128 , 128 , 255, 0.5)',
                            borderWidth:3,
                            data : <?php echo json_encode($chartdata['datasets'][0]); ?>,
                            }
                            ]
                            }
                            var ctx = document.getElementById('piechart_kotaasal');
                            var chart = new Chart(ctx, {
                            type:'pie',
                            data: chartData,
                            options: {
                            responsive: true,
                            scales: {
                            yAxes: [{
                            ticks:{display: false},
                            gridLines:{display: false},
                            scaleLabel: {
                            display: true,
                            labelString: ""
                            }
                            }],
                            xAxes: [{
                            ticks:{display: false},
                            gridLines:{display: false},
                            scaleLabel: {
                            display: true,
                            labelString: ""
                            }
                            }],
                            },
                            }
                            ,
                            })});
                        </script>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div  class="">
        <div class="container">
            <div class="row ">
                <div class="col-md-12 comp-grid">
                    <div class="card card-body">
                        <?php 
                        $chartdata = $comp_model->barchart_tahunlahir();
                        ?>
                        <div>
                            <h4>Tahun Lahir</h4>
                            <small class="text-muted"></small>
                        </div>
                        <hr />
                        <canvas id="barchart_tahunlahir"></canvas>
                        <script>
                            $(function (){
                            var chartData = {
                            labels : <?php echo json_encode($chartdata['labels']); ?>,
                            datasets : [
                            {
                            label: 'Total Siswa',
                            backgroundColor:'rgba(0 , 128 , 128, 0.5)',
                            type:'bar',
                            borderWidth:3,
                            data : <?php echo json_encode($chartdata['datasets'][0]); ?>,
                            }
                            ]
                            }
                            var ctx = document.getElementById('barchart_tahunlahir');
                            var chart = new Chart(ctx, {
                            type:'bar',
                            data: chartData,
                            options: {
                            scaleStartValue: 0,
                            responsive: true,
                            scales: {
                            xAxes: [{
                            ticks:{display: true},
                            gridLines:{display: true},
                            categoryPercentage: 1.0,
                            barPercentage: 0.8,
                            scaleLabel: {
                            display: true,
                            labelString: ""
                            },
                            }],
                            yAxes: [{
                            ticks: {
                            beginAtZero: true,
                            display: true
                            },
                            scaleLabel: {
                            display: true,
                            labelString: ""
                            }
                            }]
                            },
                            }
                            ,
                            })});
                        </script>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
