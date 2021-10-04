<?php
defined('BASEPATH') or exit('No direct script access allowed');

class set_views
{

	public function admin_dashboard()
	{
		return 'body/Dashboard';
	}

	/*Admission */
	/*Parent Portal */
	public function parentfeedback()
	{
		return 'body/ParentPortal/Parent_Feedback';
	}
	public function parentmonitoring()
	{
		return 'body/ParentPortal/Parent_Monitoring';
	}
	public function parent_announcements()
	{
		return 'body/ParentPortal/Announcement';
	}

	public function parent_announcements_create()
	{
		return 'body/ParentPortal/Announcement_creat';
	}

	public function student_search()
	{
		return 'body/ParentPortal/Search_Student';
	}

	public function parentinfo()
	{
		return 'bbody/ParentPortal/Parent_info';
	}

	public function resetpassword()
	{
		return 'body/ParentPortal/Parent_resetpassword';
	}

	public function assign_student()
	{
		return 'body/ParentPortal/Parent_Assign_student';
	}

	public function assign_studentUnssign()
	{
		return 'body/ParentPortal/Parent_Assign_studentUnassign';
	}

	public function assign_studentAssign()
	{
		return 'body/ParentPortal/Parent_Assign_studentAssign';
	}
	/*Admission */



	/*Registrar */

	public function enrolled_student()
	{
		return 'body/registrar/Enrolled_students';
	}

	public function enrolled_student_foreign()
	{
		return 'body/registrar/Enrolled_students_Foreign';
	}


	public function enrolled_studentShs()
	{
		return 'body/registrar/Enrolled_studentsShs';
	}

	public function enrolled_studentBed()
	{
		return 'body/registrar/Enrolled_studentsBed';
	}

	/*Advising */

	public function  advising()
	{
		return 'body/Advising/Advising';
	}

	/*Advising */


	/*Room Viewing*/

	public function  room_view()
	{
		return 'body/registrar/Room';
	}

	/*Room Viewing*/


	/*Create Sched*/

	public function  create_sched()
	{
		return 'body/registrar/Create_Sched';
	}
	public function  edit_sched()
	{
		return 'body/registrar/Edit_Sched';
	}
	/*Create Sched*/

	/*Reg Form*/
	public function Form()
	{
		return 'body/registrar/Regform';
	}

	public function Print_Form()
	{
		return 'body/registrar/PrintRegForm';
	}
	/*Reg Form*/

	/*Curriculum List*/
	public function CurriculumList()
	{
		return 'body/registrar/Curriculum_List';
	}
	public function Curriculum_course_list()
	{
		return 'body/registrar/Curriculum_course_list';
	}
	/*Curriculum List*/

	/*Sched Report*/
	public function SchedReport()
	{
		return 'body/registrar/Sched_Report';
	}
	/*Sched Report*/

	/*Registrar Action Logs*/

	public function  action_logs()
	{
		return 'body/registrar/Activity_logs';
	}

	/*Registrar Action Logs*/

	//Temporary Registration form view
	public function temporary_reg_form()
	{
		return 'body/registrar/TemporaryRegForm';
	}


	/*Registrar Action Logs*/
	public function  Enroll_Summary()
	{
		return 'body/registrar/EnrollSummary';
	}

	/*Registrar Action Logs*/

	//Adding and Dropping
	public function shifting()
	{
		return 'body/registrar/Shifting';
	}

	public function adding()
	{
		return 'body/registrar/AddingForm';
	}

	public function dropping()
	{
		return 'body/registrar/DroppingForm';
	}
	public function classlistingReport()
	{
		return 'body/registrar/ClassListingReport';
	}

	//Error monitor
	public function unitcount()
	{
		return 'body/Advising/Unitcounter';
	}



	/*Registrar */

	/*Registrar CHED REPORT*/

	public function  ched_report()
	{
		return 'body/registrar/Ched_Report';
	}

	/*Registrar CHED REPORT*/


	/*Registrar CHANGE SECTION */

	public function  Change_Section()
	{
		return 'body/registrar/ChangeSection';
	}

	/*Registrar CHANGE SECTION */

	/*Registrar CHANGE SECTION */

	public function  Change_Subject()
	{
		return 'body/registrar/ChangeSubject';
	}

	/*Registrar CHANGE SECTION */


	/*Registrar CHED REPORT*/

	public function  set_major()
	{
		return 'body/registrar/Set_Major';
	}

	/*Registrar CHED REPORT*/


	/*Registrar Students Record */

	public function  Bed_Student_Records()
	{
		return 'body/registrar/Student_Records/BED';
	}


	/*Registrar Students Record */


	////////////////////////////CCAO TAB ////////////////////////

	/*CCAO ENCODING MODULE */

	public function  ccao_encoding()
	{
		return 'body/Ccao/Encoding';
	}

	public function  ccao_reports()
	{
		return 'body/Ccao/Reports';
	}

	public function  import_reports()
	{
		return 'body/Ccao/Import_Reports';
	}
	/*CCAO ENCODING MODULE */

	////////////////////////////CCAO TAB ////////////////////////



	////////////////////////////ADMIISION TAB ////////////////////////

	/*ADMISSION BASIC ED MODULE */

	public function  ad_basiced()
	{
		return 'body/Admission/BasicEd_Inquiry';
	}

	public function  ad_shs()
	{
		return 'body/Admission/Shs_Inquiry';
	}

	public function  ad_inquiry_shs()
	{
		return 'body/Admission/Shs_Encoding_inquiry';
	}

	public function  ad_inquiry_bed()
	{
		return 'body/Admission/Bed_Encoding_inquiry';
	}

	public function  ad_inquiry_hed()
	{
		return 'body/Admission/Hed_Encoding_inquiry';
	}

	public function  ad_inquiry_reports_hed()
	{
		return 'body/Admission/Hed_Inquiry_Reports';
	}

	public function  ad_inquiry_reports_bed()
	{
		return 'body/Admission/Bed_Inquiry_Reports';
	}

	public function  ad_inquiry_reports_shs()
	{
		return 'body/Admission/Shs_Inquiry_Reports';
	}
	public function  ad_edit_info()
	{
		return 'body/Admission/Admission_HED_Edit_Info';
	}
	public function  ad_edit_bed_info()
	{
		return 'body/Admission/Admission_BED_Edit_Info';
	}

	public function  ad_edit_shs_info()
	{
		return 'body/Admission/Admission_SHS_Edit_Info';
	}
	public function  search_new_student_info()
	{
		return 'body/Admission/New_Students_Report';
	}
	public function Enrollment_Tracker_Report()
	{
		return 'body/Admission/Enrollment_Tracker_Report';
	}
	public function Enrollment_Tally_Report()
	{
		return 'body/Admission/Enrollment_Tally_Report';
	}

	/*ADMISSION BASIC ED MODULE */


	public function  Design()
	{
		return 'body/Admission/Design';
	}


	////////////////////////////ADMIISION TAB ////////////////////////



	////////////////////////////GUIDANCE TAB ////////////////////////


	/*GUIDANCE   MODULE */
	public function  guidance_enrolled_student()
	{
		return 'body/Guidance/Enrolled_students';
	}

	/*GUIDANCE  MODULE */

	////////////////////////////GUIDANCE TAB ////////////////////////




	////////////////////////////ADMIN TAB ////////////////////////

	public function  admind_create_Account()
	{
		return 'body/Admin/Create_Account';
	}

	////////////////////////////ADMIN TAB ////////////////////////




	////////////////////////////EXECUTIVE TAB ////////////////////////

	public function  executive_report()
	{
		return 'body/Executive/Dashboard';
	}

	////////////////////////////EXECUTIVE  TAB ////////////////////////

	////////////////////////////Student Records  TAB ////////////////////////
	public function basiced_form137()
	{
		return 'body/StudentRecords/Basiced_Form137';
	}

	public function shs_form137()
	{
		return 'body/StudentRecords/SHS_Form137';
	}

	//////////////////////////// Cashier  TAB ////////////////////////
	public function enrollment_payment()
	{
		return 'body/Cashier/Enrollment_Payment';
	}

	public function bed_enrollment_payment()
	{
		return 'body/Cashier/BED_Enrollment_Payment';
	}

	public function shs_enrollment_payment()
	{
		return 'body/Cashier/SHS_Enrollment_Payment';
	}
	public function helpdesk_report()
	{

		return 'body/Helpdesk/HelpdeskReport';
	}

	public function proof_of_payment()
	{
		return 'body/Treasury/ProofOfPayment';
	}

	//////////////////////////// User Accessibility  TAB ////////////////////////
	public function user_accessibility()
	{

		return 'body/Admin/User_Accessibility';
	}

	//////////////////////////// Program Chair  TAB ////////////////////////

	public function view_student_sched()
	{
		return 'body/ProgramChair/View_Student_Sched';
	}

	public function preview_student_schedule()
	{
		return 'body/ProgramChair/Preview_Student_Sched';
	}

	public function belltest()
	{

		return 'body/Belltest';
	}
	//////////////////////////// Accounting  TAB ////////////////////////


	public function send_soa()
	{
		return 'body/Accounting/Soa_Send';
	}

	public function student_soa()
	{
		return 'body/Accounting/Student_Soa';
	}

	//////////////////////////// Student Inquiry TAB ////////////////////////
	public function college_inquiry()
	{
		return 'body/StudentInquiry/CollegeInquiry';
	}
	//////////////////////////// Des Module TAB ////////////////////////
	public function digital_citizenship()
	{
		return 'body/Des/DigitalCitizenship';
	}
	public function id_application()
	{
		return 'body/Des/IDApplication';
	}
	//////////////////////////// DOSE Admin Module TAB ////////////////////////
	public function admin_dose_body()
	{
		return 'body/DoseAdmin/Adminpage_Body';
	}
	public function admin_dose_js_ajax()
	{
		return 'body/DoseAdmin/Js_Ajax';
	}
	public function admin_dose_regbody()
	{
		return 'body/DoseAdmin/Adminpage_Regbody';
	}
	public function basiced_regprint()
	{
		return 'body/DoseAdmin/Basiced_Regprint';
	}
	public function adminpage_resprint()
	{
		return 'body/DoseAdmin/Adminpage_Resprint';
	}
	public function bypass_manager()
	{
		return 'body/registrar/BypassManager';
	}
	public function UpdateSATEForm(){
		return 'body/EvaluationForm/UpdateSATEForm';
	}
	
}
