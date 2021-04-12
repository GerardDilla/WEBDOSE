 <section class="content">
        <div class="container-fluid">
            <div class="block-header">
                <h2 style="font-weight: 900;">DASHBOARD</h2>
                <br>
                
            </div>
        <input type="hidden" id="base_url" value="<?php echo base_url(); ?>">
            <!-- Widgets -->
            <h5>Higher Education</h5>

            <div class="row clearfix">
                <div class="col-md-6">
                    <h5>School Year: <?php echo $this->data['get_legends'][0]['School_Year']; ?> </h5>
                 </div>
                 <div class="col-md-6">
                    <h5>Semester:  <?php echo $this->data['get_legends'][0]['Semester']; ?></h5>
                  </div>
             </div>


            <div class="row clearfix">
                <div class="col-lg-4 col-md-3 col-sm-6 col-xs-12">
                    <div class="info-box bg-green hover-expand-effect">
                        <div class="icon">
                            <i class="material-icons">accessibility</i>
                        </div>
                        <div class="content">
                            <div class="text-center">Total of New Students</div>
                            <div class="text-center NewStudents"></div>
                        </div>
                    </div>
                </div>
                <div class="col-lg-4 col-md-3 col-sm-6 col-xs-12">
                    <div class="info-box bg-cyan hover-expand-effect">
                        <div class="icon">
                            <i class="material-icons">accessible</i>
                        </div>
                        <div class="content">
                            <div class="text-center">Total of Old Students</div>
                            <div class="text-center OldStudents"></div>
                        </div>
                    </div>
                </div>
                
                <div class="col-lg-4 col-md-3 col-sm-6 col-xs-12">
                    <div class="info-box bg-red hover-expand-effect">
                        <div class="icon">
                            <i class="material-icons">people</i>
                        </div>
                        <div class="content">
                            <div class="text-center">Total of Enrolled Students</div>
                            <div class="text-center TotalEnrolledStudents"></div>
                        </div>
                    </div>
                </div>
            </div>
            <!-- #END# Widgets -->
              <!-- Widgets -->
  
            <div class="row clearfix">
                <div class="col-lg-4 col-md-3 col-sm-6 col-xs-12">
                    <div class="info-box bg-pink hover-expand-effect">
                        <div class="icon">
                            <i class="material-icons">autorenew</i>
                        </div>
                        <div class="content">
                            <div class="text-center">Total of Students Who Widraw</div>
                            <div class="text-center StudentWithdraw"></div>
                        </div>
                    </div>
                </div>
                <div class="col-lg- col-md-4 col-sm-6 col-xs-12">
                    <div class="info-box bg-deep-purple hover-expand-effect">
                        <div class="icon">
                            <i class="material-icons">nature_people</i>
                        </div>
                        <div class="content">
                            <div class="text-center">Total of Reserved Students</div>
                            <div class="text-center StudentReserved"></div>
                        </div>
                    </div>
                </div>

                <div class="col-lg- col-md-4 col-sm-6 col-xs-12">
                    <div class="info-box bg-orange hover-expand-effect">
                        <div class="icon">
                            <i class="material-icons">help</i>
                        </div>
                        <div class="content">
                            <div class="text-center">Total of Advised Students</div>
                            <div class="text-center TotalAdvisedStudents"></div>
                        </div>
                    </div>
                </div>       
            </div>
            <!-- #END# Widgets -->

            <div class="row clearfix">
                <div class="col-md-6">
                    <h5>School Year: <?php echo $this->data['get_legends'][0]['Grading_School_Year']; ?>  </h5>
                 </div>
                 <div class="col-md-6">
                      <h5>Semester: SUMMER </h5>
                  </div>
             </div>


              <div class="row clearfix">    
                <div class="col-lg-4 col-md-3 col-sm-6 col-xs-12">
                    <div class="info-box bg-green  hover-expand-effect">
                        <div class="icon">
                            <i class="material-icons">accessibility</i>
                        </div>
                        <div class="content">
                            <div class="text-center">Total of New Students</div>
                            <div class="text-center SummerNewStudents"></div>
                        </div>
                    </div>
                </div>
                <div class="col-lg-4 col-md-3 col-sm-6 col-xs-12">
                    <div class="info-box bg-cyan hover-expand-effect">
                        <div class="icon">
                            <i class="material-icons">accessible</i>
                        </div>
                        <div class="content">
                            <div class="text-center">Total of Old Students</div>
                            <div class="text-center TotalSummerOldtudents"></div>
                        </div>
                    </div>
                </div>
                
                <div class="col-lg-4 col-md-3 col-sm-6 col-xs-12">
                    <div class="info-box bg-red hover-expand-effect">
                        <div class="icon">
                            <i class="material-icons">people</i>
                        </div>
                        <div class="content">
                            <div class="text-center">Total of Enrolled Students</div>
                            <div class="text-center SummerOldStudents"></div>
                        </div>
                    </div>
                </div>
            </div>
            <!-- #END# Widgets -->
              <!-- Widgets -->
  
            <div class="row clearfix">
 
                <div class="col-lg-4 col-md-3 col-sm-6 col-xs-12">
                    <div class="info-box bg-pink hover-expand-effect">
                        <div class="icon">
                            <i class="material-icons">autorenew</i>
                        </div>
                        <div class="content">
                            <div class="text-center">Total of Students Who Widraw</div>
                            <div class="text-center TotalSummerWithdraw"></div>
                        </div>
                    </div>
                </div>
                <div class="col-lg- col-md-4 col-sm-6 col-xs-12">
                    <div class="info-box bg-deep-purple  hover-expand-effect">
                        <div class="icon">
                            <i class="material-icons">nature_people</i>
                        </div>
                        <div class="content">
                            <div class="text-center">Total of Reserved Students</div>
                            <div class="text-center TotalSummerReserved"></div>
                        </div>
                    </div>
                </div>

                <div class="col-lg- col-md-4 col-sm-6 col-xs-12">
                    <div class="info-box bg-orange hover-expand-effect">
                        <div class="icon">
                            <i class="material-icons">help</i>
                        </div>
                        <div class="content">
                            <div class="text-center">Total of Advised Students</div>
                            <div class="text-center TotalSummerAdvised"></div>
                        </div>
                    </div>
                </div>
               
                
            </div>
            <!-- #END# Widgets -->


          <!-- Widgets -->
          <h5>Senior High School</h5>
            <div class="row clearfix">
 
                <div class="col-lg-3 col-md-3 col-sm-6 col-xs-12">
                    <div class="info-box bg-green hover-expand-effect">
                        <div class="icon">
                            <i class="material-icons">accessibility</i>
                        </div>
                        <div class="content">
                            <div class="text-center">Total of New Students</div>
                            <div class="text-center TotalNewSHSStudents"></div>
                        </div>
                    </div>
                </div>
                <div class="col-lg-3 col-md-3 col-sm-6 col-xs-12">
                    <div class="info-box bg-cyan hover-expand-effect">
                        <div class="icon">
                            <i class="material-icons">accessible</i>
                        </div>
                        <div class="content">
                            <div class="text-center">Total of Old Students</div>
                            <div class="text-center TotalOLDSHSStudents">(400)</div>
                        </div>
                    </div>
                </div>
                <div class="col-lg-3 col-md-3 col-sm-6 col-xs-12">
                    <div class="info-box bg-deep-purple hover-expand-effect">
                        <div class="icon">
                            <i class="material-icons">nature_people</i>
                        </div>
                        <div class="content">
                            <div class="text-center">Total of Reserved Students</div>
                            <div class="text-center"></div>
                        </div>
                    </div>
                </div>
                <div class="col-lg-3 col-md-3 col-sm-6 col-xs-12">
                    <div class="info-box bg-red hover-expand-effect">
                        <div class="icon">
                            <i class="material-icons">people</i>
                        </div>
                        <div class="content">
                            <div class="text-center">Total of Enrolled Students</div>
                            <div class="text-center TotalSHSStudents"> </div>
                        </div>
                    </div>
                </div>
            </div>
            <!-- #END# Widgets -->
              

     <!-- Widgets -->
     <h5>Basic Education</h5>      
         <div class="row clearfix">
                
                <div class="col-lg-3 col-md-3 col-sm-6 col-xs-12">
                    <div class="info-box bg-green hover-expand-effect">
                        <div class="icon">
                            <i class="material-icons">accessibility</i>
                        </div>
                        <div class="content">
                            <div class="text-center">Total of New Students</div>
                            <div class="text-center TotalNewBedStudents"></div>
                        </div>
                    </div>
                </div>
                <div class="col-lg-3 col-md-3 col-sm-6 col-xs-12">
                    <div class="info-box bg-cyan hover-expand-effect">
                        <div class="icon">
                            <i class="material-icons">accessible</i>
                        </div>
                        <div class="content">
                            <div class="text-center">Total of Old Students</div>
                            <div class="text-center TotalOLDBedStudents"></div>
                        </div>
                    </div>
                </div>
                <div class="col-lg-3 col-md-3 col-sm-6 col-xs-12">
                    <div class="info-box bg-deep-purple hover-expand-effect">
                        <div class="icon">
                            <i class="material-icons">nature_people</i>
                        </div>
                        <div class="content">
                            <div class="text-center">Total of Reserved Students</div>
                            <div class="text-center"></div>
                        </div>
                    </div>
                </div>
                <div class="col-lg-3 col-md-3 col-sm-6 col-xs-12">
                    <div class="info-box bg-red hover-expand-effect">
                        <div class="icon">
                            <i class="material-icons">people</i>
                        </div>
                        <div class="content">
                            <div class="text-center">Total of Enrolled Students</div>
                            <div class="text-center TotalBEDStudents"></div>
                        </div>
                    </div>
                </div>
                </div>
                <!-- #END# Widgets -->
          

            </div>

   
            </div>
        </div>
    </section>


     <script src="<?php echo base_url(); ?>js/dashboard.js"></script>
