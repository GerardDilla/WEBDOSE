<script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.8.0/Chart.bundle.js"></script>

<style>
    .modal-dialog,
    .modal-content {
        width: 98%;
    }
</style>


<section class="content">
    <div class="container-fluid">
        <div class="block-header">
            <div class="card">
                <div class="body">
                    <h2 style="font-weight: 900;">DASHBOARD</h2>
                </div>
            </div>
        </div>
        <input type="hidden" id="base_url" value="<?php echo base_url(); ?>">
        <!-- Widgets -->

        <div class="row">
            <div class="col-md-8">
                <div class="card">
                    <div class="header">
                        <h2>
                            Enrollment Summary Report
                        </h2>
                        <ul class="header-dropdown m-r--5">
                            <li class="dropdown">
                                <a href="javascript:void(0);" class="dropdown-toggle" style="cursor:pointer;" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">
                                    <i class="material-icons" onclick="print_chart()">print</i>
                                </a>
                            </li>
                        </ul>
                    </div>
                    <div class="body">
                        <div class="chart-wrapper" id='printMe'>
                            <canvas id="myChart" width="1000px;" height="500px;"></canvas>

                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-4">
                <div class="row clearfix">
                    <div class="col-md-6">
                        <h5>School Year: <?php echo $this->data['get_legends'][0]['School_Year']; ?> </h5>
                    </div>
                    <div class="col-md-6">
                        <h5>Semester: <?php echo $this->data['get_legends'][0]['Semester']; ?></h5>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-6">
                        <div class="card">
                            <div class="body  bg-green" style="height: 200px;">
                                <h1 class="TotalBEDStudents" Style="text-align: center;"></h1>
                                <p Style="text-align: center;">Total Enrolled Students for BasicEd</p>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="card">
                            <div class="body  bg-pink" style="height: 200px;">
                                <h1 class="TotalSHSStudents" Style="text-align: center;"> </h1>
                                <p Style="text-align: center;">Total Enrolled Students for Shs</p>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="card">
                            <div class="body  bg-blue" style="height: 200px;">
                                <h1 class="TotalEnrolledStudents" Style="text-align: center;"></h1>
                                <p Style="text-align: center;">Total Enrolled Students for Higher Education</p>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="card">
                            <div class="body  bg-orange" style="height: 200px;">
                                <h1 class="TotalAllStudents" Style="text-align: center;"></h1>
                                <p Style="text-align: center;">Total Enrolled Students</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-md-4">
                <div class="card">
                    <div class="header">
                        <h2>
                            Inquiry Summary
                        </h2>
                        <ul class="header-dropdown m-r--5">
                            <li class="dropdown">
                                <a href="javascript:void(0);" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">
                                    <i class="material-icons" onclick="print_chart1()">print</i>
                                </a>
                            </li>
                        </ul>
                    </div>
                    <div class="body">
                        <div class="chart-wrapper" id='printMe1'>
                            <canvas id="myCharts2" width="1000" height="800"></canvas>
                            <span style="font-weight: 900;">Total:</span>
                            <div class="TotalAllInquiryStudents"> </div>
                        </div>
                    </div>
                </div>

                <div class="card">
                    <div class="header">
                        <h2>
                            Reservation Summary
                        </h2>
                        <ul class="header-dropdown m-r--5">
                            <li class="dropdown">
                                <a href="javascript:void(0);" class="dropdown-toggle" style="cursor:pointer;" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">
                                    <i class="material-icons" onclick="print_chart2()">print</i>
                                </a>
                            </li>
                        </ul>
                    </div>
                    <div class="body">
                        <div class="chart-wrapper" id='printMe2'>
                            <canvas id="myCharts3" width="1000" height="800"></canvas>
                            <span style="font-weight: 900;">Total:</span>
                            <div class="TotalAllReserveStudents"> </div>
                        </div>
                    </div>
                </div>

                <div class="card">
                    <div class="header">
                        <h2>
                            Enrollment Summary Other Programs
                        </h2>
                        <ul class="header-dropdown m-r--5">
                            <li class="dropdown">
                                <a href="javascript:void(0);" style="cursor:pointer;" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">
                                    <i class="material-icons" onclick="print_chart3()">print</i>
                                </a>
                            </li>
                        </ul>
                    </div>
                    <div class="body">
                        <div class="chart-wrapper" id='printMe3'>
                            <canvas id="myCharts4" width="1000" height="800"></canvas>
                            <span style="font-weight: 900;">Total:</span> 240
                        </div>
                    </div>
                </div>

                <div class="card">
                    <div class="header">
                        <h2>
                            Enrollment Summary (New Students)
                        </h2>
                        <ul class="header-dropdown m-r--5">
                            <li class="dropdown">
                                <a href="javascript:void(0);" style="cursor:pointer;" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">
                                    <i class="material-icons" onclick="print_chart4()">print</i>
                                </a>
                            </li>
                        </ul>
                    </div>
                    <div class="body">
                        <div class="chart-wrapper" id='printMe4'>
                            <canvas id="myCharts5" width="1000" height="800"></canvas>
                            <span style="font-weight: 900;">Total:</span>
                            <div class="TotalNEWStudents"> 240 </div>
                        </div>
                    </div>
                </div>

                <div class="card">
                    <div class="header">
                        <h2>
                            Enrollment Tracker Summary (Higher Education)
                        </h2>
                        <ul class="header-dropdown m-r--5">
                            <li class="dropdown">
                                <a href="javascript:void(0);" style="cursor:pointer;" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">
                                    <i class="material-icons" onclick="print_chart_tracker()">print</i>
                                </a>
                            </li>
                        </ul>
                    </div>
                    <div class="body">
                        <div class="chart-wrapper" id='printMe_tracker'>
                            <canvas id="myCharts_tracker" width="1000" height="800"></canvas>
                            <span style="font-weight: 900;">Total:</span>
                            <div class="EnrollmentTrackerSummary"> 0 </div>
                        </div>
                    </div>
                </div>

            </div>
            <div class="col-md-8">
                <div class="card">
                    <div class="header">
                        <h2 class="text-center">
                            <span style="font-weight: 900; color: #800000; font-family: Arial;"> BASIC EDUCATION </span>
                        </h2>
                    </div>
                    <div class="body">
                        <div class="row">
                            <div class="col-md-6">
                                <div class="card">
                                    <div class="body bg-pink" data-toggle="modal" style="cursor:pointer;" data-target="#largeModal" style="height: 150px;">
                                        <h1 class="TotalInquiryBED" Style="text-align: center;"></h1>
                                        <p Style="text-align: center;">Inquiry</p>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="card">
                                    <div class="body  bg-blue" data-toggle="modal" style="cursor:pointer;" data-target="#largeModal" style="height: 150px;">
                                        <h1 class="TotalReservedBED" Style="text-align: center;"> </h1>
                                        <p Style="text-align: center;">Reserved</p>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="card">
                                    <div class="body  bg-green" data-toggle="modal" style="cursor:pointer;" data-target="#largeModal" style="height: 150px;">
                                        <h1 class="TotalNewBedStudents" Style="text-align: center;"></h1>
                                        <p Style="text-align: center;">New Students</p>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="card">
                                    <div class="body  bg-orange" style="cursor:pointer;" data-toggle="modal" data-target="#largeModal" style="height: 150px;">
                                        <h1 class="TotalBEDStudents" Style="text-align: center;"></h1>
                                        <p Style="text-align: center;">Enrolled</p>
                                    </div>
                                </div>
                            </div>
                        </div>



                    </div>
                </div>

                <div class="card">
                    <div class="header">
                        <h2 class="text-center">
                            <span style="font-weight: 900; color: #800000; font-family: Arial;"> SENIOR HIGH SCHOOL </span>
                        </h2>
                    </div>
                    <div class="body">

                        <div class="row">
                            <div class="col-md-6">
                                <div class="card">
                                    <div class="body bg-pink" style="cursor:pointer;" data-toggle="modal" data-target="#largeModal1" style="height: 150px;">
                                        <h1 class="TotalInquirySHS" Style="text-align: center;"></h1>
                                        <p Style="text-align: center;">Inquiry</p>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="card">
                                    <div class="body  bg-blue" style="cursor:pointer;" data-toggle="modal" data-target="#largeModal1" style="height: 150px;">
                                        <h1 class="TotalReservedSHS" Style="text-align: center;"> </h1>
                                        <p Style="text-align: center;">Reserved</p>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="card">
                                    <div class="body  bg-green" style="cursor:pointer;" data-toggle="modal" data-target="#largeModal1" style="height: 150px;">
                                        <h1 class="TotalNewSHSStudents" Style="text-align: center;"></h1>
                                        <p Style="text-align: center;">New Students</p>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="card">
                                    <div class="body  bg-orange" style="cursor:pointer;" data-toggle="modal" data-target="#largeModal1" style="height: 150px;">
                                        <h1 class="TotalSHSStudents" Style="text-align: center;"></h1>
                                        <p Style="text-align: center;">Enrolled</p>
                                    </div>
                                </div>
                            </div>

                        </div>
                    </div>
                </div>

                <div class="card">
                    <div class="header">
                        <h2 class="text-center">
                            <span style="font-weight: 900; color: #800000; font-family: Arial;"> HIGHER EDUCATION </span>
                        </h2>
                    </div>
                    <div class="body">
                        <div class="row">
                            <div class="col-md-6">
                                <div class="card">
                                    <div class="body bg-pink" style="cursor:pointer;" data-toggle="modal" data-target="#largeModal2" style="height: 150px;">
                                        <h1 class="TotalInquiryHIGHERED" Style="text-align: center;"></h1>
                                        <p Style="text-align: center;">Inquiry</p>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="card">
                                    <div class="body  bg-blue" style="cursor:pointer;" data-toggle="modal" data-target="#largeModal2" style="height: 150px;">
                                        <h1 class="StudentReserved" Style="text-align: center;"> </h1>
                                        <p Style="text-align: center;">Reserved</p>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="card">
                                    <div class="body  bg-green" style="cursor:pointer;" data-toggle="modal" data-target="#largeModal2" style="height: 150px;">
                                        <h1 class="NewStudents" Style="text-align: center;"></h1>
                                        <p Style="text-align: center;">New Students</p>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="card">
                                    <div class="body  bg-orange" style="cursor:pointer;" data-toggle="modal" data-target="#largeModal2" style="height: 150px;">
                                        <h1 class="TotalEnrolledStudents" Style="text-align: center;"></h1>
                                        <p Style="text-align: center;">Enrolled</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>


                <!-- <div class="card">
                    <div class="header">
                        <h2 class="text-center">
                            <span style="font-weight: 900; color: #800000; font-family: Arial;"> ENROLLMENT TRACKER SUMMARY (HIGHER EDUCATION) </span>
                        </h2>
                    </div>
                    <div class="body">
                        <div class="row">
                            <div class="col-md-6">
                                <div class="card">
                                    <div class="body bg-pink" style="cursor:pointer;" data-toggle="modal" data-target="#largeModal2" style="height: 150px;">
                                        <h1 class="TotalInquiryHIGHERED" Style="text-align: center;"></h1>
                                        <p Style="text-align: center;">Inquiry</p>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="card">
                                    <div class="body  bg-blue" style="cursor:pointer;" data-toggle="modal" data-target="#largeModal2" style="height: 150px;">
                                        <h1 class="StudentReserved" Style="text-align: center;"> </h1>
                                        <p Style="text-align: center;">Reserved</p>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="card">
                                    <div class="body  bg-green" style="cursor:pointer;" data-toggle="modal" data-target="#largeModal2" style="height: 150px;">
                                        <h1 class="NewStudents" Style="text-align: center;"></h1>
                                        <p Style="text-align: center;">New Students</p>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="card">
                                    <div class="body  bg-orange" style="cursor:pointer;" data-toggle="modal" data-target="#largeModal2" style="height: 150px;">
                                        <h1 class="TotalEnrolledStudents" Style="text-align: center;"></h1>
                                        <p Style="text-align: center;">Enrolled</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div> -->


            </div>





        </div>
    </div>
</section>


<div class="modal" id="largeModal" tabindex="-1" role="dialog">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title" id="largeModalLabel">Basic Education Bar Chart</h4>

                <button class="btn btn-lg btn-success" onclick="print_chart5()">PRINT</button>
                <button class="btn btn-lg btn-danger" data-dismiss="modal">CLOSE</button>

            </div>
            <div class="modal-body">

                <div class="chart-wrapper" id='printMe5'>
                    <canvas id="myCharts6" class="chart-height"></canvas>
                </div>

            </div>
            <div class="modal-footer">

            </div>
        </div>
    </div>
</div>


<div class="modal" id="largeModal1" tabindex="-1" role="dialog">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title" id="largeModalLabel">Senior HighSchool Bar Chart</h4>

                <button class="btn btn-lg btn-success" onclick="print_chart6()">PRINT</button>
                <button class="btn btn-lg btn-danger" data-dismiss="modal">CLOSE</button>

            </div>
            <div class="modal-body">
                <div class="chart-wrapper" id='printMe6'>
                    <canvas id="myCharts7" class="chart-height"></canvas>
                </div>
            </div>
            <div class="modal-footer">

            </div>
        </div>
    </div>
</div>


<div class="modal" id="largeModal2" tabindex="-1" role="dialog" style="width:100%; height:100%;">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title" id="largeModalLabel">Higher Education Bar Chart</h4>

                <button class="btn btn-lg btn-success" onclick="print_chart7()">PRINT</button>
                <button class="btn btn-lg btn-danger" data-dismiss="modal">CLOSE</button>

            </div>
            <div class="modal-body">
                <div class="chart-wrapper" id='printMe7'>
                    <canvas id="myCharts8" class="chart-height"></canvas>
                </div>
            </div>
            <div class="modal-footer">

            </div>
        </div>
    </div>
</div>




<script src="<?php echo base_url(); ?>js/dashboard.js"></script>
<script type="text/javascript" src="<?php echo base_url(); ?>js/html2canvas.js"></script>
<script src="<?php echo base_url(); ?>js/printChart.js"></script>





<!-- Custom Js -->