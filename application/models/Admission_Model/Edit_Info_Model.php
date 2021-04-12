<?php


class Edit_Info_Model extends CI_Model
{

  // HED     STUDENT INFO                          
  public function Select_Studeninfo($sturef)
  {

    $this->db->select('*');
    $this->db->from('Student_Info');
    $this->db->where('Student_Number', $sturef);
    $this->db->or_where('Reference_Number', $sturef);
    $query = $this->db->get();

    return $query->result_array();
  }


  //CHECK REFERENCE/ STUDENT NUMBER OF HED
  public function Get_Info($refstu)
  {

    $this->db->select('*');
    $this->db->from('Student_Info as S');
    $this->db->join('4ps_inquiry_infoid as 4ps', 'S.Reference_Number = 4ps.Reference_Number', 'LEFT');
    $this->db->where('S.Student_Number', $refstu);
    $this->db->or_where('S.Reference_Number', $refstu);

    $query = $this->db->get();
    return $query;
  }


  // HED  UPDATE STUDENT INFO
  public function Update_Info($array)
  {

    $this->db->set('First_Name', $array['f_name']);
    $this->db->set('Middle_Name', $array['m_name']);
    $this->db->set('Last_Name', $array['l_name']);
    $this->db->set('Address_No', $array['address_no']);
    $this->db->set('Address_Street', $array['address_st']);
    $this->db->set('Address_Subdivision', $array['subdivision']);
    $this->db->set('Address_Barangay', $array['barangay']);
    $this->db->set('Address_Province', $array['province']);
    $this->db->set('Address_City', $array['city']);
    $this->db->set('Birth_Date', $array['b-date']);
    $this->db->set('Tel_No', $array['phone_num']);
    $this->db->set('Nationality', $array['nationality']);
    $this->db->set('CP_No', $array['mobile_num']);
    $this->db->set('Age', $array['Age']);
    $this->db->set('Birth_Place', $array['b_place']);
    $this->db->set('Address_Zip', $array['zip_code']);
    $this->db->set('Parents_Status', $array['parent_Status']);
    $this->db->set('Gender', $array['gender']);
    $this->db->set('Email', $array['email_add']);
    $this->db->set('Father_Name', $array['father_name']);
    $this->db->set('Father_Occupation', $array['father_occupation']);
    $this->db->set('Father_Contact', $array['father_contact']);
    $this->db->set('Father_Address', $array['father_add']);
    $this->db->set('Father_Email', $array['father_email']);
    $this->db->set('Father_Income', $array['father_inc']);
    $this->db->set('Father_Education', $array['father_ed']);
    $this->db->set('Mother_Name', $array['mother_name']);
    $this->db->set('Mother_Address', $array['mother_address']);
    $this->db->set('Mother_Contact', $array['mother_contact']);
    $this->db->set('Mother_Occupation', $array['mother_occupation']);
    $this->db->set('Mother_Email', $array['mother_email']);
    $this->db->set('Mother_Income', $array['mother_inc']);
    $this->db->set('Mother_Education', $array['mother_ed']);
    $this->db->set('Course_1st', $array['first_choice']);
    $this->db->set('Course_2nd', $array['second_choice']);
    $this->db->set('Course_3rd', $array['third_choice']);
    $this->db->set('Others_Know_SDCA', $array['OTKSDCA']);
    $this->db->set('Others_Relative_Stats', $array['Relative']);
    $this->db->set('Others_Relative_Name', $array['Relative_name']);
    $this->db->set('Others_Relative_Department', $array['relative_department']);
    $this->db->set('Others_Relative_Relationship', $array['relative_relationship']);
    $this->db->set('Others_Relative_Contact', $array['relative_contact']);
    $this->db->set('Secondary_School_Name', $array['secondary_school']);
    $this->db->set('Grade_School_Name', $array['elementary_school']);
    $this->db->set('Secondary_School_Address', $array['secondary_address']);
    $this->db->set('Grade_School_Address', $array['gradeschool_address']);
    $this->db->set('Secondary_School_Grad', $array['secondary_grad']);
    $this->db->set('Grade_School_Grad', $array['elem_grad']);
    $this->db->set('Transferee_Name', $array['transfere_nameschool']);
    $this->db->set('Transferee_Attend', $array['transfere_lastattend']);
    $this->db->set('Transferee_Address', $array['transfere_schooladdress']);
    $this->db->set('Transferee_Course', $array['transfere_course']);
    $this->db->set('Guardian_Name', $array['guardian_name']);
    $this->db->set('Guardian_Contact', $array['guardian_contact']);
    $this->db->set('Guardian_Address', $array['guardian_address']);
    $this->db->set('Guardian_Relationship', $array['guardian_relationship']);
    $this->db->set('SHS_School_Name', $array['shs_name']);
    $this->db->set('SHS_School_Grad', $array['shs_grad']);
    $this->db->set('SHS_School_Address', $array['shs_address']);
    $this->db->where('Reference_Number', $array['ref_num']);
    $this->db->update('Student_Info');

    $query_log = $this->db->last_query();
    return $query_log;
  }



  //CHECK REFERENCE/ STUDENT NUMBER OF HED
  public function Get_Info_BED($refstu)
  {
    $this->db->select('*');
    $this->db->from('Basiced_Studentinfo');
    $this->db->where('Student_Number', $refstu);
    $this->db->or_where('Reference_Number', $refstu);
    $query = $this->db->get();
    return $query;
  }


  //BED STUDENT INFO 
  // BED   STUDENT INFO                          
  public function Select_StudeninfoBED($sturef)
  {

    $this->db->select('*');
    $this->db->from('Basiced_Studentinfo');
    $this->db->where('Student_Number', $sturef);
    $this->db->or_where('Reference_Number', $sturef);
    $query = $this->db->get();

    return $query->result_array();
  }

  public function Update_Info_BED($array)
  {
    $this->db->set('LRN', $array['lrn']);
    $this->db->set('First_Name', $array['f_name']);
    $this->db->set('Middle_Name', $array['m_name']);
    $this->db->set('Last_Name', $array['l_name']);
    $this->db->set('Nick_Name', $array['nickname']);
    $this->db->set('Gradelevel', $array['Grade_lvl']);
    $this->db->set('Birth_Date', $array['b-date']);
    $this->db->set('Age', $array['age']);
    $this->db->set('Birth_Date', $array['b-date']);
    $this->db->set('Gender', $array['gender']);
    $this->db->set('Birth_Place', $array['b-place']);
    $this->db->set('Religion', $array['religion']);
    $this->db->set('Nationality', $array['nationality']);
    $this->db->set('Alien', $array['alien_num']);
    $this->db->set('Mobile_No', $array['mobile_num']);
    $this->db->set('Phone_No', $array['phone_num']);
    $this->db->set('Address_No', $array['house_no']);
    $this->db->set('Address_Street', $array['street']);
    $this->db->set('Subdivision', $array['subdivision']);
    $this->db->set('Barangay', $array['barangay']);
    $this->db->set('City', $array['city_muni']);
    $this->db->set('Zip_Code', $array['zip']);
    $this->db->set('Province', $array['province']);
    $this->db->set('Parent_Status', $array['parent_status']);
    $this->db->set('Father_Name', $array['fathers_name']);
    $this->db->set('Father_Status', $array['father_status']);
    $this->db->set('Father_Birthdate', $array['father_bday']);
    $this->db->set('Father_Age', $array['father_Age']);
    $this->db->set('Father_Employer', $array['father_employer']);
    $this->db->set('Father_Income', $array['father_avg_income']);
    $this->db->set('Father_Position', $array['father_position']);
    $this->db->set('Father_Address', $array['father_address']);
    $this->db->set('Father_City', $array['father_city']);
    $this->db->set('Father_Municipality', $array['father_province']);
    $this->db->set('Father_Country', $array['father_country']);
    $this->db->set('Father_Zipcode', $array['father_zip']);
    $this->db->set('Father_Phoneno', $array['father_Telephone']);
    $this->db->set('Father_Email', $array['father_email']);
    $this->db->set('Father_Mobileno', $array['father_mobile']);
    $this->db->set('Mother_Name', $array['mother_name']);
    $this->db->set('Mother_Status', $array['mother_status']);
    $this->db->set('Mother_Birthdate', $array['mother_bday']);
    $this->db->set('Mother_Age', $array['mother_age']);
    $this->db->set('Mother_Employer', $array['mother_employer']);
    $this->db->set('Mother_Education', $array['mother_lvl_education']);
    $this->db->set('Mother_Address', $array['mother_adrress']);
    $this->db->set('Mother_City', $array['mother_city']);
    $this->db->set('Mother_Municipality', $array['mother_province']);
    $this->db->set('Mother_Country', $array['mother_country']);
    $this->db->set('Mother_Zipcode', $array['mother_zip']);
    $this->db->set('Mother_Phoneno', $array['mother_telephone']);
    $this->db->set('Mother_Email', $array['mother_email']);
    $this->db->set('Mother_Mobileno', $array['mother_mobile']);
    $this->db->set('Guardian_Name', $array['guardian_name']);
    $this->db->set('Guardian_Status', $array['guardian_status']);
    $this->db->set('Guardian_Birthdate', $array['guardian_bday']);
    $this->db->set('Guardian_Age', $array['guardian_age']);
    $this->db->set('Guardian_Employer', $array['guardian_employer']);
    $this->db->set('Guardian_Income', $array['guardian_avg_income']);
    $this->db->set('Guardian_Position', $array['guardian_position']);
    $this->db->set('Guardian_Education', $array['guardian_lvl_education']);
    $this->db->set('Guardian_Address', $array['guardian_address']);
    $this->db->set('Guardian_City', $array['guardian_city']);
    $this->db->set('Guardian_Municipality', $array['guardian_province']);
    $this->db->set('Guardian_Country', $array['guardian_country']);
    $this->db->set('Guardian_Zipcode', $array['guardian_zip']);
    $this->db->set('Guardian_Phoneno', $array['guardian_telephone']);
    $this->db->set('Guardian_Email', $array['guardian_email']);
    $this->db->set('Guardian_Mobileno', $array['guardian_mobile']);
    $this->db->set('Previous_School_Name1', $array['name_of_school1']);
    $this->db->set('Previous_School_Level1', $array['level1']);
    $this->db->set('Previous_School_Years1', $array['year_attended1']);
    $this->db->set('Previous_School_Awards1', $array['awards1']);
    $this->db->set('Previous_School_Name2', $array['name_of_school2']);
    $this->db->set('Previous_School_Level2', $array['level2']);
    $this->db->set('Previous_School_Years2', $array['year_attended2']);
    $this->db->set('Previous_School_Awards2', $array['awards2']);
    $this->db->set('Previous_School_Name3', $array['name_of_school3']);
    $this->db->set('Previous_School_Level3', $array['level3']);
    $this->db->set('Previous_School_Years3', $array['year_attended3']);
    $this->db->set('Previous_School_Awards3', $array['awards3']);
    $this->db->set('Best_Subject1', $array['subject_best1']);
    $this->db->set('Best_Subject2', $array['subject_best2']);
    $this->db->set('Best_Subject3', $array['subject_best3']);
    $this->db->set('Best_Subject4', $array['subject_best4']);
    $this->db->set('Least_Subject1', $array['least_best1']);
    $this->db->set('Least_Subject2', $array['least_best2']);
    $this->db->set('Least_Subject3', $array['least_best3']);
    $this->db->set('Least_Subject4', $array['least_best4']);
    $this->db->set('Organization_Name1', $array['name_of_org1']);
    $this->db->set('Organization_Position1', $array['postion1']);
    $this->db->set('Organization_Year1', $array['year1']);
    $this->db->set('Organization_Name2', $array['name_of_org2']);
    $this->db->set('Organization_Position2', $array['postion2']);
    $this->db->set('Organization_Year2', $array['year2']);
    $this->db->set('Others_Know_SDCA', $array['otk']);
    $this->db->set('Others_Relative_Stats', $array['Relatives']);
    $this->db->set('Others_Relative_Name', $array['Relative_name']);
    $this->db->set('Others_Relative_Department', $array['relative_department']);
    $this->db->set('Others_Relative_Relationship', $array['relative_relationship']);
    $this->db->set('Others_Relative_Contact', $array['relative_contact']);
    $this->db->where('Reference_Number', $array['ref_num']);
    $this->db->update('Basiced_Studentinfo');

    $query_log = $this->db->last_query();
    return $query_log;
  }
}
