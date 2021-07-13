<html>
    <head>
        <style type="text/css">
            body{
                font-family:Arial, Helvetica, sans-serif;
                position:relative;
                /* border:1px solid black; */
                /* page-break-inside:auto; */
            }
            .header-1{
                font-weight:bold;
                font-size:17px;
                text-align:center;
                margin:30px 0px 33px 0px;
            }
            .header-1-sub-1{
                font-size:15px;
                margin-top:8px;
            }
            .table-label{
                font-size:10px;
                padding:2px 0px 0px 7px;
                /* position:relative; */
            }
            td,th{
                border:1px solid black;
            }
            .table-header{
                font-weight:bold;
                background:black;
                color:white;
                font-size:14px;
                font-style: italic;
                padding:1px 0px 1px 7px;
            }
            .table-label-2{
                text-align:center;
                font-size:12px;
                padding:2px 0px 2px 0px;
            }
            .table-label-3{
                padding:2px 0px 2px 7px;
                font-size:13px;
            }
            .table-label-4{
                font-size:14px;
                text-align:center;
            }
            .table-label-5{
                font-size:14px;
                padding:2px 0px 2px 7px;
            }
            .image-header{
                height:auto;
                width:600px;
            }
            .photo-div{
                position:absolute;
                display:flex;
                justify-content: center;
                align-items: center;
                text-align: center;
                border:1px solid black;
                height:170px;
                width:160px;
                top:45px;
                right:15px;
            }
            .border-transparent{
                border:1px solid transparent;
            }
            tr td.border-transparent:first-child{
                border-left:1px solid black;
            }
            tr td.border-transparent:last-child{
                border-right:1px solid black;
            }
            /* tr td.border-transparent{
                border-bottom:1px solid black;
            } */
            table{
                font-size:75%;
            }
            .p-1{
                text-align:center;
                font-size:12px;
            }
            .p-2{
                font-size:13.5px;
                margin:10px 10px 10px 10px;
            }
            .sig-1{
                font-size:13.5px;
                text-align:center;
            }
            .float-right{
                float:right;
                width:50%;
            }
            .float-left{
                float:left;
                width:50%;
            }
            /* .page-1 {page-break-after: always;}
            .page-2 {page-break-after: always;} */
            .page-2{page-break-before: always;}
            .page-1{
                margin:1px 15px 10px 15px ;
            }
            .page-2{
                margin:10px 15px 10px 15px ;
            }
            @page {
                size: 8.5in 13in   portrait;
                margin:0;
            }
            * {
                -webkit-print-color-adjust: exact !important;   /* Chrome, Safari */
                color-adjust: exact !important;                 /*Firefox*/
            }
            .height-1{
                max-height:35px;
                height:35px;
            }
            .label-float-top{
                /* position:absolute;
                top:0;
                left:0; */
            }
            .application-text-1{
                font-size:70%;
                font-weight:bold;
            }
            .application-text-2{
                font-size:80%;
                font-weight:bold;
            }
            .application-text-3{
                font-size:90%;
                font-weight:bold;
            }
            .application-text-4{
                font-size:100%;
                font-weight:bold;
            }
        </style>
    </head>
<body>
    <div class="page-1">
        <div class="photo-div">
            Photo
        </div>
        <image src="<?= base_url('img/SdcaHeader.jpg');?>" class="image-header">
        <br>
        <!-- <br><span class="application-text"></span> -->
        <div class="header-1">
                APPLICATION FOR ADMISSION<br>
                <div class="header-1-sub-1">BASIC EDUCATION DEPARTMENT</div>
                <div class="header-1-sub-1">AY __________</div>
        </div>
        
        <table width="100%" border="0" cellspacing="0" cellpading="0">
            <tr>
                <td class="table-label height-1" valign="top">Level Applied For<br><span class="application-text-4"><?= $application_form['Gradelevel'];?></span></td>
                <td class="table-label height-1" valign="top">Date of Application<br><span class="application-text-1"><?= $application_form['date_applied'];?></span></td>
                <td class="table-label height-1" valign="top">Learner Reference Number (LRN#)<br><span class="application-text-1"><?= $application_form['LRN'];?></span></td>
                <td class="table-label height-1" valign="top">Reference Number<br><span class="application-text-1"><?= $application_form['Reference_Number'];?></span></td>
            </tr>
            <tr>
                <td class="table-header" colspan="4">PERSONAL INFORMATION OF THE STUDENT</td>
            </tr>
            <tr>
                <td class="table-label height-1">Last Name<br><span class="application-text-1"></span></td>
                <td class="table-label height-1">First Name<br><span class="application-text-1"></span></td>
                <td class="table-label height-1">Middle Name<br><span class="application-text-1"></span></td>
                <td class="table-label height-1">Nickname<br><span class="application-text-1"></span></td>
            </tr>
            <tr>
                <td class="table-label" colspan="4">Home Address (House No./ Street / Subdivision or Village / Town / City / Province / Zip Code )<br><br><br></td>
            </tr>
            <tr>
                <td class="table-label height-1">Gender<br><span class="application-text-1"></span></td>
                <td class="table-label height-1">Age<br><span class="application-text-1"></span></td>
                <td class="table-label height-1">Date of Birth<br><span class="application-text-1"></span></td>
                <td class="table-label height-1">Place of Birth<br><span class="application-text-1"></span></td>
            </tr>
            <tr>
                <td class="table-label height-1">Contact Details<br><span class="application-text-1"></span></td>
                <td class="table-label height-1">Email Address<br><span class="application-text-1"></span></td>
                <td class="table-label height-1">Religion<br><span class="application-text-1"></span></td>
                <td class="table-label">Nationality<br><span class="application-text-1"></span></td>
            </tr>
            <tr>
                <td class="table-header" colspan="4">ACADEMIC BACKGROUND</td>
            </tr>
            <tr>
                <th class="table-label-2">Level</th>
                <th class="table-label-2">School</th>
                <th class="table-label-2">Years Attended</th>
                <th class="table-label-2">Awards / Recognition</th>
            </tr>
            <tr>
                <td class="table-label-2">Preschool</td>
                <td class="table-label-2"></td>
                <td class="table-label-2"></td>
                <td class="table-label-2"></td>
            </tr>
            <tr>
                <td class="table-label-2">Elementary</td>
                <td class="table-label-2"></td>
                <td class="table-label-2"></td>
                <td class="table-label-2"></td>
            </tr>
            <tr>
                <td class="table-label-2">Highschool</td>
                <td class="table-label-2"></td>
                <td class="table-label-2"></td>
                <td class="table-label-2"></td>
            </tr>
            <tr>
                <td class="table-label-3" colspan="4">For Grade 8 - 10 ESC Grantees, indicate your ESC Student ID Number:____________ School ID Number ____________</td>
            </tr>
            <tr>
                <td class="table-label-4">Organization /<br> Club in school</td>
                <td class="table-label-2" align="center">Name of Organization/Club<br><br><br></td>
                <td class="table-label-2" align="center">Position<br><br><br></td>
                <td class="table-label-2" align="center">Year<br><br><br></td>
            </tr>
            <tr>
                <td class="table-label-4">Organization /<br> Club in the community</td>
                <td class="table-label-2" align="center">Name of Organization/Club<br><br><br></td>
                <td class="table-label-2" align="center">Position<br><br><br></td>
                <td class="table-label-2" align="center">Year<br><br><br></td>
            </tr>
            <tr>
                <td class="table-header" colspan="4">FAMILY BACKGROUND</td>
            </tr>
        </table>
        <table width="100%" border="0" cellspacing="0" cellpading="0">
            <tr>
                <td class="table-label-5" width="33%"></td>
                <th class="table-label-5">FATHER</th>
                <th class="table-label-5" width="33%">MOTHER <sub>( Maiden Name )</sub></th>
            </tr>
            <tr>
                <td class="table-label-5">Full Name</td>
                <td class="table-label-5"></td>
                <td class="table-label-5"></td>
            </tr>
            <tr>
                <td class="table-label-5">Age</td>
                <td class="table-label-5"></td>
                <td class="table-label-5"></td>
            </tr>
            <tr>
                <td class="table-label-5">Birthday</td>
                <td class="table-label-5"></td>
                <td class="table-label-5"></td>
            </tr>
            <tr>
                <td class="table-label-5">Address</td>
                <td class="table-label-5"></td>
                <td class="table-label-5"></td>
            </tr>
            <tr>
                <td class="table-label-5">Contact Details</td>
                <td class="table-label-5"></td>
                <td class="table-label-5"></td>
            </tr>
            <tr>
                <td class="table-label-5">Educational Attainment</td>
                <td class="table-label-5"></td>
                <td class="table-label-5"></td>
            </tr>
            <tr>
                <td class="table-label-5">Name of Company</td>
                <td class="table-label-5"></td>
                <td class="table-label-5"></td>
            </tr>
            <tr>
                <td class="table-label-5">Occupation/Position</td>
                <td class="table-label-5"></td>
                <td class="table-label-5"></td>
            </tr>
            <tr>
                <td class="table-label-5">Average Monthly Income</td>
                <td class="table-label-5"></td>
                <td class="table-label-5"></td>
            </tr>
            <tr>
                <td class="table-label-5">Parent's Marital Status</td>
                <td class="table-label-5" colspan="2">
                    __Married &nbsp;&nbsp; __Living together  &nbsp;&nbsp;__Seperated  &nbsp;&nbsp;&nbsp;__Not Married &nbsp;&nbsp;__Widowed<br><br>
                    If separated , since when ? ______________________________________<br>
                    With whom is the child staying ? __________________________________<br>
                    From whom do you receive financial support? ( father, mother, aunt, uncle etc. )<br>
                    ____________________________________________________________<br><br>

                </td>
            </tr>
        </table>
        <table width="100%" border="0" cellspacing="0" cellpading="0">
            <tr>
                <td class="table-header" colspan="5">SIBLINGS</td>
            </tr>
            <tr>
                <td class="table-label-5" align="center">Full Name</td>
                <td class="table-label-5" align="center">Age</td>
                <td class="table-label-5" align="center">Birth Order</td>
                <td class="table-label-5" align="center">Grade/Level</td>
                <td class="table-label-5" align="center">School/Company</td>
            </tr>
            <tr>
                <td class="table-label-5" align="center"><br></td>
                <td class="table-label-5" align="center"><br></td>
                <td class="table-label-5" align="center"><br></td>
                <td class="table-label-5" align="center"><br></td>
                <td class="table-label-5" align="center"><br></td>
            </tr>
            <tr>
                <td class="table-label-5" align="center"><br></td>
                <td class="table-label-5" align="center"><br></td>
                <td class="table-label-5" align="center"><br></td>
                <td class="table-label-5" align="center"><br></td>
                <td class="table-label-5" align="center"><br></td>
            </tr>
            <tr>
                <td class="table-label-5" align="center"><br></td>
                <td class="table-label-5" align="center"><br></td>
                <td class="table-label-5" align="center"><br></td>
                <td class="table-label-5" align="center"><br></td>
                <td class="table-label-5" align="center"><br></td>
            </tr>
            <!-- <tr>
                <td class="table-label-2"><br><br><br></td>
                <td class="table-label-2"><br><br><br></td>
                <td class="table-label-2"><br><br><br></td>
            </tr>
            <tr>
                <th class="table-label"><br><br><br></th>
                <th class="table-label"><br><br><br></th>
                <th class="table-label"><br><br><br></th>
            </tr> -->
        </table>
        <table width="100%" border="0" cellspacing="0" cellpading="0">
            <tr>
                <td class="table-header" colspan="4">Legal Guardian</td>
            </tr>
            <tr>
                <td colspan="2" class="table-label-2">
                    Name
                </td>
                <td colspan="2" class="table-label-2">
                    Relationship to the applicant
                </td>
            </tr>
            <tr>
                <td colspan="4" class="table-label">Home Address (House No./ Street / Subdivision or Village / Town / City / Province / Zip Code )<br><br><br></td>
            </tr>
            <tr>
                <td class="table-label">Contact Details<br><br><br></td>
                <td class="table-label">Name of Company<br><br><br></td>
                <td class="table-label">Occupation/Position<br><br><br></td>
                <td class="table-label">Average Monthly income<br><br><br></td>
            </tr>
        </table>
    </div>
    <div class="page-2">
        <table width="100%" border="0" cellspacing="0" cellpading="0">
            <tr>
                <td class="table-header" colspan="2">MEDICAL BACKGROUND</td>
            </tr>
            <tr>
                <td width="25%" class="table-label-5">Allergy / Surgery</td>
                <td width="75%" class="table-label-5">_________________________________________________________________________</td>
            </tr>
            <tr>
                <td width="25%" class="table-label-5">Visual Acuity</td>
                <td width="75%" class="table-label-5">&nbsp; ___normal vision &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;___wears eyeglass&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;___others(specify)______________________</td>
            </tr>
            <tr>
                <td width="25%" class="table-label-5">Auditory Perception</td>
                <td width="75%" class="table-label-5">&nbsp; ___normal vision &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;___wears hearing aid&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;___others(specify)____________________</td>
            </tr>
            <tr>
                <td width="25%" class="table-label-5">Physical Condition</td>
                <td width="75%" class="table-label-5">&nbsp; ___normal condition &nbsp;___with physical disability(specify)___________________________</td>
            </tr>
            <tr>
                <td width="25%" class="table-label-5">Psychologycal Condition</td>
                <td width="75%" class="table-label-5">&nbsp; ___normal condition &nbsp;___with psychologycal concern(specify)_______________________</td>
            </tr>
        </table>
        <table width="100%" border="0" cellspacing="0" cellpading="0">
            <tr>
                <td colspan="3" class="table-header">How did you learn about SDCA?</td>
            </tr>
            <tr>
                <td width="33%" class="table-label-5 border-transparent">[ ] Family members / relatives</td>
                <td class="table-label-5 border-transparent">[ ] Friends / Neighbors</td>
                <td width="33%" class="table-label-5 border-transparent">[ ] Streamer / Billboard / Flyers</td>
            </tr>
            <tr>
                <td width="33%" class="table-label-5 border-transparent">[ ] Official Website / Social Media</td>
                <td class="table-label-5 border-transparent">[ ] Referred by _______________</td>
                <td width="33%" class="table-label-5 border-transparent">Contact Number_______________</td>
            </tr>
            <tr>
                <td colspan="3" class="table-header" style="font-size:18px;text-align:center;">CONFORME</td>
            </tr>
            <tr>
                <td colspan="3">
                    <p class="p-1">
                        This is under DATA PRIVACY ACT of 2012 or RA 10173
                    </p>
                    <p class="p-2">
                        I hereby acknowledge that all information written in the Admission Application Form is true and correct. I am allowing St. 
                        Dominic College Basic Education to use this information for the Academic Affairs and Student Affairs services,
                         PEAC/FAPE and Scholarship Grants. Guidance and Admissions Office upholds all the submitted documents with utmost confidentiality.
                    </p><br><br>
                    <div class="float-right sig-1">Mother's Name and Signature</div>
                    <div class="float-left sig-1">Father's Name and Signature</div>
                    <br><br><br>
                    <div class="float-right sig-1">Guardian's Name and Signature</div>
                    <div class="float-left sig-1">Admission's OFficer and Signature</div>
                </td>
            </tr>
        </table><br>
        <table width="100%" border="0" cellspacing="0" cellpading="0">
            <tr>
                <td colspan="3" class="table-header" style="text-align:center;">FOR SDCA USE ONLY</td>
            </tr>
            <tr>
                <td colspan="3" class="table-header">ADMISSION DETAILS</td>
            </tr>
            <tr>
                <td colspan="2" class="table-label">Test Date<br><br><br></td>
                <td></td>
            </tr>
            <tr>
                <td width="25%" class="table-label">Test/s Given<br><br><br></td>
                <td width="25%" class="table-label">Test Score<br><br><br></td>
                <td width="50%" class="table-label">Interpretation/Verbal Description<br><br><br></td>
            </tr>
            <tr>
                <td colspan="2" class="table-label">Result<br><br><br></td>
                <td class="table-label">Examiner's Name and Signature<br><br><br></td>
            </tr>
            <tr>
                <td colspan="3" class="table-label">Remarks<br><br></td>
            </tr>
            <tr>
                <td colspan="3" class="table-label">Interview  Date<br><br><br></td>
            </tr>
            <tr>
                <td colspan="2" class="table-label">Name of Interviewer<br><br><br></td>
                <td class="table-label">Signature of Interviewer<br><br><br></td>
            </tr>
            <tr>
                <td colspan="3" class="table-label">Remarks<br><br><br><br><br></td>
            </tr>
            <tr>
                <td colspan="3" class="table-label">Recommendation<br><br><br></td>
            </tr>
            <tr>
                <td colspan="3" class="table-header">ENROLLMENT DETAILS</td>
            </tr>
            <tr>
                <td class="table-label" colspan="3">Reservation/Enrollment Official Receipt Number<br><br><br></td>
            </tr>
            <tr>
                <td colspan="3" class="table-label-5">
                    For Scholarship <br>
                    <div style="margin-left:30px;margin-top:10px;">[ ] &nbsp;&nbsp;Siblings Discount &nbsp;&nbsp;_____________________</div>
                    <div style="margin-left:30px;">[ ] &nbsp;&nbsp;PEAC/FAPE &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;        _____________________</div>
                    <div style="margin-left:30px;margin-bottom:10px;">[ ] &nbsp;&nbsp;Others, specify   &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;_____________________</div>
                </td>
            </tr>
            <tr>
                <td colspan="3" class="table-label-5">
                    Received the folowing requirements:<br>
                    <div style="margin-left:30px;margin-top:10px;">[ ] &nbsp;&nbsp;NSO/PSA Birth Certificate (2 pieces photocopy)</div>
                    <div style="margin-left:30px;">[ ] &nbsp;&nbsp;Passport Sized Picture (3 pieces)</div>
                    <div style="margin-left:30px;">[ ] &nbsp;&nbsp;Report Card or SF9 (original and 2 pieces photocopy)</div>
                    <div style="margin-left:30px;">[ ] &nbsp;&nbsp;Form 137-A or SF10 (for Registrar's File)</div>
                    <div style="margin-left:30px;">[ ] &nbsp;&nbsp;Certificate of Good mral Character</div>
                    <div style="margin-left:30px;">[ ] &nbsp;&nbsp;Photocopy of Kindergarten Certificate of Completion/Photocopy of Elementary Diploma</div>
                    <div style="margin-left:30px;">[ ] &nbsp;&nbsp;Photocopy of NCAE Result (if applicable)</div>
                    <div style="margin-left:30px;">[ ] &nbsp;&nbsp;ESC Certification (Grade 8-10) if applicable</div>
                    <div style="margin-left:30px;margin-bottom:10px;">[ ] &nbsp;&nbsp;Long Brown Envelope</div>
                    <b>Received by:</b><br><br>
                    <div style="padding-top:10px;padding-bottom:20px;">
                        <div class="float-left">Admission's Officer and Signature</div>
                        <div class="float-right">Date:</div>
                    </div>
                    <div style="padding-top:10px;padding-bottom:20px;">
                        <div class="float-left"><b>Endorsed to the Registrar's Office:</b></div>
                        <div class="float-right"></div>
                    </div>
                    <div style="padding-top:10px;padding-bottom:25px;">
                        <div class="float-left">Registrar's Name and Signature</div>
                        <div class="float-right">Date:</div>
                    </div>
                </td>
            </tr>
            <!-- <tr>
                <td colspan="3" class="table-label-5" style="border-top:1px solid transparent;">
                    <b>Received by:</b><br>
                    <div style="padding-top:10px;padding-bottom:20px;">
                        <div class="float-left">Admission's Officer and Signature</div>
                        <div class="float-right">Date:</div>
                    </div>
                    <div style="padding-top:10px;padding-bottom:20px;">
                        <div class="float-left"><b>Endorsed to the Registrar's Office:</b></div>
                        <div class="float-right"></div>
                    </div>
                    <div style="padding-top:10px;padding-bottom:20px;">
                        <div class="float-left">Registrar's Name and Signature</div>
                        <div class="float-right">Date:</div>
                    </div>
                </td>
            </tr> -->
        </table>
    </div>
</body>
<script>
// $(document).ready(function(){
   
// })
window.print();
</script>
</html>