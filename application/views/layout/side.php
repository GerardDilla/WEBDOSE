<section>
    <!-- Left Sidebar -->
    <aside id="leftsidebar" class="sidebar">
        <!-- User Info -->
        <div class="user-info" style="background:#811e1e">
            <div class="image" style="background:white;border-radius:10px;">
                <img src="<?php echo base_url(); ?>img/DOSE_LOGO.PNG" width="120" height="auto" alt="User" />
            </div>
            <div class="info-container" style="color:black;">
                <div class="name" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">Jhon Norman Fabregas<?php echo $this->session->userdata("fullname")['fullname']; ?></div>
                <div class="email"><?php echo $this->session->userdata("position")['fullname']; ?>Web Developer</div>
            </div>
        </div>
        <!-- #User Info -->

        <!-- Menu -->
        <div class="menu">
            <ul class="list">
                <li class="header"></li>
                <!-- Accounting Module -->
                <?php if (in_array($this->data['module_list']['accounting'], $this->data['user_module_access'])) : ?>
                    <li>
                        <a href="javascript:void(0);" class="menu-toggle">
                            <i class="material-icons">receipt</i>
                            <span>Accounting</span>
                        </a>
                        <ul class="ml-menu">
                            <li>
                                <a href="<?php echo base_url(); ?>index.php/StatementOfAccount" class="">
                                    <span>Statement Of Account</span>
                                </a>
                            </li>
                        </ul>
                    </li>

                <?php endif ?>
                <!-- Admin Module -->
                <?php if (in_array($this->data['module_list']['admin'], $this->data['user_module_access'])) : ?>
                    <li>
                        <a href="javascript:void(0);" class="menu-toggle">
                            <i class="material-icons">account_box</i>
                            <span>Admin</span>
                        </a>
                        <ul class="ml-menu">
                            <li>
                                <a href="<?php echo base_url(); ?>index.php/UserAccessibility" class="">
                                    <span>-User Roles </span>
                                </a>
                            </li>



                        </ul>
                    </li>
                <?php endif ?>
                <!-- Admission Module -->
                <?php if (in_array($this->data['module_list']['admission'], $this->data['user_module_access'])) : ?>
                    <li>
                        <a href="javascript:void(0);" class="menu-toggle">
                            <i class="material-icons">visibility</i>
                            <span>Admission</span>
                        </a>
                        <ul class="ml-menu">

                            <li>
                                <a href="<?php echo base_url(); ?>index.php/Admission/New_Students">
                                    <span>- Enrolled New Students</span>
                                </a>
                            </li>
                            <li>
                                <a href="javascript:void(0);" class="menu-toggle">
                                    <span>- Enrollment Tracker Reports</span>
                                </a>
                                <ul class="ml-menu">
                                    <li>
                                        <a href="<?php echo base_url(); ?>index.php/Admission/Enrollment_Tracker_Report">
                                            <span>- Enrollment Tracker Reports</span>
                                        </a>
                                    </li>
                                    <li>
                                        <a href="<?php echo base_url(); ?>index.php/Admission/Enrollment_Tally_Report">
                                            <span>- Enrollment Tally Reports</span>
                                        </a>
                                    </li>
                                </ul>
                                <!-- <a href="<?php echo base_url(); ?>index.php/Admission/Enrollment_Tracker_Report">
                             <span>- Enrollment Tracker Reports</span>
                         </a> -->
                            </li>
                            <li>
                                <a href="javascript:void(0);" class="menu-toggle">
                                    <span>- Inquiry Form Reports</span>
                                </a>
                                <ul class="ml-menu">
                                    <li>
                                        <a href="<?php echo base_url(); ?>index.php/Admission/HED_Inquiry_Reports">
                                            <span>- Higher Education</span>
                                        </a>
                                    </li>
                                    <li>
                                        <a href="<?php echo base_url(); ?>index.php/Admission/SHS_Inquiry_Reports">
                                            <span>- Senior High School</span>
                                        </a>
                                    </li>
                                    <li>
                                        <a href="<?php echo base_url(); ?>index.php/Admission/BED_Inquiry_Reports">
                                            <span>- Basic Education</span>
                                        </a>
                                    </li>
                                </ul>

                                <a href="javascript:void(0);" class="menu-toggle">
                                    <span>- Student Edit Info </span>
                                </a>
                                <ul class="ml-menu">
                                    <li>
                                        <a href="<?php echo base_url(); ?>index.php/Admission/HED_Edit_Info">
                                            <span>- Higher Education</span>
                                        </a>
                                    </li>
                                    <li>
                                        <a href="<?php echo base_url(); ?>index.php/Admission/SHS_Edit_Info">
                                            <span>- Senior High School</span>
                                        </a>
                                    </li>
                                    <li>
                                        <a href="<?php echo base_url(); ?>index.php/Admission/BED_Edit_Info">
                                            <span>- Basic Education</span>
                                        </a>
                                    </li>
                                </ul>
                            </li>

                        </ul>
                    </li>
                <?php endif ?>
                <!-- Advising Module -->
                <?php if (in_array($this->data['module_list']['advising'], $this->data['user_module_access'])) : ?>
                    <li>
                        <a href="<?php echo base_url(); ?>index.php/Advising">
                            <i class="material-icons">dashboard</i>
                            <span>Advising</span>
                        </a>
                    </li>
                <?php endif ?>
                <!-- Cashier Module -->
                <?php if (in_array($this->data['module_list']['cashier'], $this->data['user_module_access'])) : ?>
                    <li>
                        <a href="javascript:void(0);" class="menu-toggle">
                            <i class="material-icons">account_box</i>
                            <span>Cashier</span>
                        </a>
                        <ul class="ml-menu">
                            <li>
                                <a href="<?php echo base_url(); ?>index.php/Cashier" class="">
                                    <span>-HED Enrollment Payment</span>
                                </a>
                            </li>
                            <li>
                                <a href="<?php echo base_url(); ?>index.php/Cashier/basiced_home" class="">
                                    <span>-BED and SHS Enrollment Payment</span>
                                </a>
                            </li>
                            <!-- <li>
                                <a href="<?php echo base_url(); ?>index.php/Cashier/proof_of_payment" class="">
                                    <span>- Proof of Payemts </span>
                                </a>
                            </li> -->

                        </ul>
                    </li>
                <?php endif ?>
                <!-- CCAO Module -->
                <?php if (in_array($this->data['module_list']['admission'], $this->data['user_module_access'])) : ?>
                    <li>
                        <a href="javascript:void(0);" class="menu-toggle">
                            <i class="material-icons">accessibility</i>
                            <span>CCAO</span>
                        </a>
                        <ul class="ml-menu">
                            <li>
                                <a href="<?php echo base_url(); ?>index.php/ccao/Encoding" class="">
                                    <span>Career Talk Encoding</span>
                                </a>
                            </li>
                            <li>
                                <a href="<?php echo base_url(); ?>index.php/ccao/Reports" class="">
                                    <span>Career Talk Reports</span>
                                </a>
                            </li>
                        </ul>
                    </li>
                <?php endif ?>
                <!-- Class List Module -->
                <?php if (in_array($this->data['module_list']['advising'], $this->data['user_module_access'])) : ?>
                    <li>
                        <a href="<?php echo base_url(); ?>index.php/Advising/Class_Listing">
                            <i class="material-icons">subject</i>
                            <span>Class List</span>
                        </a>
                    </li>
                <?php endif ?>
                <!-- Curriculum Module -->
                <?php if (in_array($this->data['module_list']['advising'], $this->data['user_module_access'])) : ?>
                    <li>
                        <a href="<?php echo base_url(); ?>index.php/Advising/Curriculum">
                            <i class="material-icons">list</i>
                            <span>Curriculum</span>
                        </a>
                    </li>
                <?php endif ?>
                <!-- Executive Module -->
                <?php if (in_array($this->data['module_list']['executive'], $this->data['user_module_access'])) : ?>
                    <li>
                        <a href="javascript:void(0);" class="menu-toggle">
                            <i class="material-icons">pie_chart</i>
                            <span>Executive</span>
                        </a>
                        <ul class="ml-menu">
                            <li>
                                <a href="<?php echo base_url(); ?>index.php/Executive/enrollment_report" class="">
                                    <span>- Enrollment Report</span>
                                </a>
                            </li>
                            <li>
                                <a href="<?php echo base_url(); ?>index.php/Executive/HelpdeskReport">
                                    <span>- Helpdesk Inquiries</span>
                                </a>
                            </li>

                        </ul>
                    </li>
                <?php endif ?>
                <!-- Guidance Module -->
                <?php if (in_array($this->data['module_list']['admission'], $this->data['user_module_access'])) : ?>
                    <li>
                        <a href="javascript:void(0);" class="menu-toggle">
                            <i class="material-icons">account_box</i>
                            <span>Guidance</span>
                        </a>
                        <ul class="ml-menu">
                            <li>
                                <a href="<?php echo base_url(); ?>index.php/Guidance/reportenrollstudents" class="">
                                    <span>- Enrolled Student</span>
                                </a>
                            </li>

                        </ul>
                    </li>
                <?php endif ?>

                <!-- Program Chair Module -->
                <?php if (in_array($this->data['module_list']['program_chair'], $this->data['user_module_access'])) : ?>
                    <li>
                        <a href="javascript:void(0);" class="menu-toggle">
                            <i class="material-icons">accessibility</i>
                            <span>Program Chair</span>
                        </a>

                        <ul class="ml-menu">
                            <li>
                                <a href="<?php echo base_url(); ?>index.php/ProgramChair/view_student_sched" class="">
                                    <span>View Student Schedule</span>
                                </a>
                            </li>

                        </ul>
                    </li>
                <?php endif ?>
                <!-- Registrar Module -->
                <?php if (in_array($this->data['module_list']['registrar'], $this->data['user_module_access'])) : ?>
                    <li>
                        <a href="javascript:void(0);" class="menu-toggle">
                            <i class="material-icons">person</i>
                            <span>Registrar</span>
                        </a>
                        <ul class="ml-menu">
                            <li>
                                <a href="javascript:void(0);" class="menu-toggle">
                                    <span>Reports</span>
                                </a>
                                <ul class="ml-menu">
                                    <li>
                                        <a href="<?php echo base_url(); ?>index.php/Registrar/SchedReport">
                                            <span>- Schedule Report</span>
                                        </a>
                                    </li>
                                    <li>
                                        <a href="<?php echo base_url(); ?>index.php/Registrar/Activity_Logs">
                                            <span>- Activity Logs</span>
                                        </a>
                                    </li>
                                    <li>
                                        <a href="javascript:void(0);" class="menu-toggle">
                                            <span>-Enrollment Summary</span>
                                        </a>
                                        <ul class="ml-menu">
                                            <li>
                                                <a href="<?php echo base_url(); ?>index.php/Registrar/Enroll_Summary">
                                                    <span>- Higher Education</span>
                                                </a>
                                            </li>
                                            <li>
                                                <a href="<?php echo base_url(); ?>index.php/Admission/BasicEd">
                                                    <span>- Basic Education</span>
                                                </a>
                                            </li>
                                            <li>
                                                <a href="<?php echo base_url(); ?>index.php/Admission/Shs">
                                                    <span>- Senior High School</span>
                                                </a>
                                            </li>
                                        </ul>
                                    <li>
                                        <a href="<?php echo base_url(); ?>index.php/Registrar/EnrolledStudentForeign">
                                            <span>Enrolled Foreign Students</span>
                                        </a>
                                    </li>

                                    <li>
                                        <a href="javascript:void(0);" class="menu-toggle">
                                            <span>- Enrolled Students</span>
                                        </a>
                                        <ul class="ml-menu">
                                            <li>
                                                <a href="<?php echo base_url(); ?>index.php/Registrar/EnrolledStudent">
                                                    <span>- Higher Education</span>
                                                </a>
                                            </li>
                                            <li>
                                                <a href="<?php echo base_url(); ?>index.php/Registrar/EnrolledStudentsShs">
                                                    <span>- Senior Highschool</span>
                                                </a>
                                            </li>
                                            <li>
                                                <a href="<?php echo base_url(); ?>index.php/Registrar/EnrolledStudentsBED">
                                                    <span>- Basic Education</span>
                                                </a>
                                            </li>
                                        </ul>
                                    </li>
                                    <li>
                                        <a href="<?php echo base_url(); ?>index.php/Registrar/Class_Listing">
                                            <span>- Class List Report </span>
                                        </a>
                                    </li>
                                    <li>
                                        <a href="<?php echo base_url(); ?>index.php/Registrar/Ched_Report">
                                            <span>- Ched Report </span>
                                        </a>
                                    </li>
                            </li>
                        </ul>

                    </li>

                    <li>
                        <a href="javascript:void(0);" class="menu-toggle">
                            <span>Subject Modification</span>
                        </a>
                        <ul class="ml-menu">
                            <li>
                                <a href="<?php echo base_url(); ?>index.php/Registrar/Adding">
                                    <span>- Add Subjects</span>
                                </a>
                            </li>
                            <li>
                                <a href="<?php echo base_url(); ?>index.php/Registrar/dropping">
                                    <span>- Drop Subjects</span>
                                </a>
                            </li>
                            <li>
                                <a href="<?php echo base_url(); ?>index.php/Registrar/Shifting">
                                    <span>- Shifting</span>
                                </a>
                            </li>
                        </ul>
                    </li>

                    <li>
                        <a href="javascript:void(0);" class="menu-toggle">
                            <span>Student Records</span>
                        </a>
                        <ul class="ml-menu">
                            <li>
                                <a href="javascript:void(0);" class="menu-toggle">
                                    <span>Form 137</span>
                                </a>
                                <ul class="ml-menu">
                                    <!--
                                            <li>
                                                <a href="">
                                                    <span>- Higher Education</span>
                                                </a>
                                            </li>
                                            <li>
                                                <a href="">
                                                    <span>- Senior Highschool</span>
                                                </a>
                                            </li>
                                            -->
                                    <li>
                                        <a href="<?php echo base_url(); ?>index.php/StudentRecords">
                                            <span>- Basic Education</span>
                                        </a>
                                    </li>
                                    <li>
                                        <a href="<?php echo base_url(); ?>index.php/StudentRecords/shs_student_form">
                                            <span>- Senior High School</span>
                                        </a>
                                    </li>
                                </ul>
                            </li>

                        </ul>
                    </li>

                    <li>
                        <a href="<?php echo base_url(); ?>index.php/Registrar/ChangeSection">
                            <span>Change Section</span>
                        </a>
                    </li>

                    <li>
                        <a href="<?php echo base_url(); ?>index.php/Registrar/Change_Subject">
                            <span>Change Subject</span>
                        </a>
                    </li>

                    <li>
                        <a target="_blank" href="<?php echo base_url(); ?>index.php/Registrar/Curriculum">
                            <span>Curriculum List</span>
                        </a>
                    </li>

                    <li>
                        <a href="<?php echo base_url(); ?>index.php/Registrar/Create_Sched">
                            <span>Scheduling</span>
                        </a>
                    </li>

                    <li>
                        <a href="<?php echo base_url(); ?>index.php/Registrar/SetMajor">
                            <span>Set Major</span>
                        </a>
                    </li>

                    <li>
                        <a href="<?php echo base_url(); ?>index.php/Registrar/Forms">
                            <span>Manage RegForm</span>
                        </a>
                    </li>

            </ul>
            </li>
        <?php endif ?>
        <!-- Schedule Report Module -->
        <?php if (in_array($this->data['module_list']['advising'], $this->data['user_module_access'])) : ?>

            <li>
                <a href="<?php echo base_url(); ?>index.php/Advising/SchedReport">
                    <i class="material-icons">note</i>
                    <span>Schedule Report</span>
                </a>
            </li>
        <?php endif ?>
        <!-- Student Inquiry Module -->
        <?php 
        // if (in_array($this->data['module_list']['admission'], $this->data['user_module_access'])) : 
        ?>
            <li>
                <a href="javascript:void(0);" class="menu-toggle">
                    <i class="material-icons">chat</i>
                    <span>Student Inquiry</span>
                </a>
                <ul class="ml-menu">
                    <li>
                        <a href="<?php echo base_url(); ?>index.php/StudentInquiry" class="">
                            <span>- College Student</span>
                        </a>
                    </li>
                    <!-- <li>
                        <a href="<?php echo base_url(); ?>index.php/ccao/Reports" class="">
                            <span>Career Talk Reports</span>
                        </a>
                    </li> -->
                </ul>
            </li>
        <?php 
        // endif
            ?>


        <li class="header"></li>
        <li>
            <a href="javascript:void(0);">
                <i class="material-icons col-red">donut_large</i>
                <span></span>
            </a>
        </li>
        <li>
            <a href="javascript:void(0);">
                <i class="material-icons col-amber">donut_large</i>
                <span></span>
            </a>
        </li>
        <li>
            <a href="javascript:void(0);">
                <i class="material-icons col-light-blue">donut_large</i>
                <span></span>
            </a>
        </li>
        </ul>
        </div>
        <!-- #Menu -->






































































        <!-- Footer -->
        <div class="legal">
            <div class="copyright">
                <a href="javascript:void(0);">St. Dominic College Of Asia</a> |
                <a href="javascript:void(0);" onclick="view_privacy_policy()">Privacy Policy</a>
            </div>
        </div>
        <!-- #Footer -->
    </aside>