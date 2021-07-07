
<!-- SUBJECT CHOICE -->
<div class="modal fade" id="studentsearch_modal" tabindex="-1" role="dialog">
	<div class="modal-dialog" role="document">
		<div class="modal-content">
			<div class="modal-header">
				<h2 id="largeModalLabel">Search Student</h2>
			</div>
			<div class="modal-body">
				<br><br>
				<div class="row">
          <div class="col-md-12">
            <div id="clipboardcopy" class="alert bg-green alert-dismissible" role="alert" style="display:none">
                <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">×</span></button>
                Copied to Clipboard
            </div>
          </div>
					<div class="col-md-9">
						<div class="row">
              <div class="col-md-12">
							<select class="form-control show-tick" id="search_education_type">
                <option value="college">College</option>
                <option value="basiced">Basic Education / SHS</option>
              </select>
							</div>
							<div class="col-md-12">
                <input id="url" type="hidden" value="<?php echo base_url(); ?>index.php/StudentSearch" />
								<input id="student_searchkey" autofocus class="form-control" placeholder="Search By Student Number / Reference Number / Name..." type="text" />
							</div>
						</div>
					</div>

					<div class="col-md-3" style="padding 50% 0px 50% 0px">
						<button class="btn btn-lg btn-info" id="schedSearchSubmit" tabindex="-1" type="button" onclick="search_student()" autofocus>SEARCH</button>
          </div>

				</div>
				<hr>
				<div class="col-md-12 searchloader" style="padding: 1%; display:none">
					LOADING <img src="<?php echo base_url(); ?>img/ajax-loader.gif" />
				</div>
				<div class="table panel panel-danger" style="overflow-x:auto; max-height:250px">
					<table class="table table-bordered">
						<thead>
							<tr class="danger">
								<th>Student Number</th>
								<th>Reference Number</th>
								<th>Full Name</th>
							</tr>
						</thead>
						<tbody id="student_search_table">
							<tr>
								<td colspan="10" align="center">No Data</td>
							</tr>
						</tbody>
					</table>
				</div>
				<br>
				<div id="student_search_pagination"></div>
			</div>
		</div>
	</div>
</div>
<!-- /SUBJECT CHOICE -->

<!-- Privacy Policy -->
<div class="modal fade" id="privacy_policy_modal"  tabindex="-1" role="dialog">
	<div class="modal-dialog" role="document">
		<div class="modal-content">
			<div class="modal-header">
				<h2 id="largeModalLabel">Privacy Policy</h2>
			</div>
			<div class="modal-body">

        <!-- Set Values here -->
        <input type="hidden" id="privacy_id" value="<?php echo $this->admin_data['userid']; ?>">
        <input type="hidden" id="privacy_system" value="WEBDOSE">
        <input type="hidden" id="privacy_base_url" value="<?php echo base_url(); ?>">

        <div id="PolicyContainer" style="overflow-y: scroll; max-height:300px; padding: 15px 0px 15px 0px; color:#000">
          <p>
            I <u><strong><?php echo $this->admin_data['fullname']; ?></strong></u> of legal age, hereby voluntarily and knowingly authorize St. Dominic College of Asia to collect, process or release my personal and sensitive information that may be used for internal and external school official and legal transactions.
            I agree on the following conditions:
          </p>
          <ol>
            <li>Personal Information will be released unless written notice of revocation is received by the Data Privacy Office of St. Dominic College of Asia.</li>
            <li>Personal information may be released for school official and legal purposes only.</li>
            <li>Sensitive information will be kept confidential unless the school deemed it necessary to release on valid and legal purposes only. </li>
            <li>Updating and modifying of incorrect, inaccurate or incomplete personal information will be done upon submission of letter of request to St. Dominic College of Asia.</li>
            <li>St. Dominic College of Asia and its officials and employees are not held liable for the collection and release of any information that I voluntarily provided.</li>
          </ol>
          <p>
           I have read this form, understood its contents and consent to the collecting, processing and releasing of my personal data. I understand that my consent does not preclude the existence of other criteria for lawful processing of personal data, and does not waive any of my rights under the Data Privacy Act of 2012 and other applicable laws.
          </p>
        </div>
			</div>
      <div class="modal-footer row">
        <div id="policy_options">
          <div class="col-md-12" style="text-align:left; padding: 0px 25px 0px 25px">
            <p>By Clicking '<u>Proceed</u>' You Agree to The Privacy Policy Stated Above.</p>
          </div>
          <div class="col-md-12">
            <a href="<?php echo base_url(); ?>index.php/Admin/logout" class="btn btn-link waves-effect pull-left">BACK</a>
            <button type="button" id="policy_agree" value="" class="btn btn-success pull-right" onclick="policy_agree()"></button>
          </div>
        </div>
      </div>
		</div>
	</div>
</div>
<!-- /Privacy Policy -->
<!-- Privacy Policy Script -->
<script src="<?php echo base_url(); ?>js/privacy_policy.js"></script>  
<script>
//Checks if user already agreed
$( document ).ready(function() {

  policy_agree_check();

});
</script>
<!-- /Privacy Policy Script -->

</section>
  <!--
   <script src="<?php echo base_url(); ?>js/js/bootstrap.js"></script>  
   <script src="<?php echo base_url(); ?>js/js/bootstrap.min.js"></script>
   <script src="<?php echo base_url(); ?>js/js/jquery-3.1.1.min.js"></script>
   -->


<script src="<?php echo base_url(); ?>js/js/PrintJS.js"></script>
<script>
  $('body').addClass('ls-closed');
</script>
<!--FOR SCHEDULE EDITING: GERARD---------------------->
<script>
function showedit(coursetitle,schedcode){

  var htmldata = '<h4>'+coursetitle+': '+schedcode+'</h4>';
      htmldata += '<input type="hidden" name="schedcode" value="'+schedcode+'">';

  $('#schedcode_hidden_input').html(htmldata);
  $( "#edit_pane" ).show();
}
function closeedit(){
  $( "#edit_pane" ).hide();
}
//IN CHARGE OF APPENDING TIME CHOICES, AJAX: GERARD
function get_time(){
  var url = '<?php echo base_url(); ?>/index.php/Registrar/get_time_choices';
  
  $.ajax({
      type: 'POST',
      url: url,
      dataType:"json",
      success: function (data) {

        $('#starttime1').html('');
        $('#endtime1').html('');
        $('#starttime1').append('<option disabled selected>Select Start Time</option>');
        $('#endtime1').append('<option disabled selected>Select End Time</option>');
        $.each(data , function(index, val) { 
          console.log(val['Schedule_Time'])
          $('#starttime1').append('<option value="'+val['Time_From']+'">'+val['Schedule_Time']+'</option>');
          $('#endtime1').append('<option value="'+val['Time_From']+'">'+val['Schedule_Time']+'</option>');
          $(".selectpicker").selectpicker('refresh');
        })
        //$('#starttime').append('<option value="<?php echo $row['Time_From'];?>">');

      },
      error: function (data) {
          console.log('An error occurred.');
          console.log(data);
      }
      
  });
}
//IN CHARGE OF APPENDING ROOM CHOICES, AJAX: GERARD
function get_rooms(){
  var url = '<?php echo base_url(); ?>/index.php/Registrar/get_room_choices';
  
  $.ajax({
      type: 'POST',
      url: url,
      dataType:"json",
      success: function (data) {

        $('#room1').html('');
        $('#room1').append('<option disabled selected>Select Room</option>');
        $.each(data , function(index, val) { 
          console.log(val['Schedule_Time'])
          $('#room1').append('<option value="'+val['ID']+'">'+val['Room']+'</option>');
          $(".selectpicker").selectpicker('refresh');
        })
        //$('#starttime').append('<option value="<?php echo $row['Time_From'];?>">');

      },
      error: function (data) {
          console.log('An error occurred.');
          console.log(data);
      }
      
  });
}
//IN CHARGE OF APPENDING INSTRUCTOR CHOICES, AJAX: GERARD
function get_instructors(){
  var url = '<?php echo base_url(); ?>/index.php/Registrar/get_instructor_choices';
  
  $.ajax({
      type: 'POST',
      url: url,
      dataType:"json",
      success: function (data) {

        $('#instructor1').html('');
        $('#instructor1').append('<option disabled selected>Select Instructor</option>');
        $.each(data , function(index, val) { 
          //console.log(val['Schedule_Time'])
          $('#instructor1').append('<option value="'+val['Instructor_ID']+'">'+val['Instructor_Name']+'</option>');
          $(".selectpicker").selectpicker('refresh');
        })

      },
      error: function (data) {
          console.log('An error occurred.');
          console.log(data);
      }
      
  });
}
</script>
<!--FOR SCHEDULE EDITING: GERARD --------------->


<script>
function subject(value, addressUrl) {
  
  console.log(value); 
  console.log(addressUrl); 
  ajax = $.ajax({
              url: addressUrl,
              type: 'GET',
              data: {ID: value},
              success: function(response){
                  
              var output = JSON.parse(response);   
              //alert(response);
              document.getElementById("coursetitle").innerHTML = output[0];
              document.getElementById("courselecunit").innerHTML = output[1];
              document.getElementById("courselabunit").innerHTML = output[2];
              //$("#searchKeyword").empty();
              //$("#searchKeyword").append($('<input/>').attr({ type: 'text', class: 'form-control',  name: 'searchKeyword', readonly}));
              //ajax.done(processCourseID);
              }
          });
    
        //ajax.done(processCourseID);

}
</script>



<script>
function programsection(value1, addressUrl1) {
  console.log(value1);
  console.log(addressUrl1);
  ajax = $.ajax({
      type: 'GET',
      url: addressUrl1,
      data: { Program_ID: value1 },
      success: function(response) {
        var section = '<?php echo $this->session->flashdata("section"); ?>';
        //alert(section);
        console.log(section);
        var output = JSON.parse(response);
          $("#section").html('');
        $.each(output, function(key, value) {
            
  /*
              $("#section").append($('<option>', {
                value: value["Program_ID"],
                text: value["Section_Name"]
              }));
  */
            if(section == value["Section_ID"]){
              $("#section").append('<option value="'+value["Section_ID"]+'" selected>'+value["Section_Name"]+'</option>')
            }
            else{
            $("#section").append('<option value="'+value["Section_ID"]+'">'+value["Section_Name"]+'</option>')
            }
            
             $("#section").selectpicker('refresh');
            console.log(value["Section_Name"]);
          }
        )
      }
      
        //console.log(value['cityId']);
        //console.log(value['cityName']);
      });
  }
</script>

<!--- AJAX SCHED CHECKER: GERARD -->
<script>
function FormValidate(php_url){
  var frm = $('#schedform');
  var msgarray;
  $.ajax({
      type: frm.attr('method'),
      url: php_url,
      data: frm.serialize(),
      success: function (data) {
      
        if(data == ''){
          $("#schedule_error").html('');
          $("#confirmation").modal('show');
        }
        else{
          $("#schedule_error").html('<br><br><hr><strong>'+data+'</strong><hr>');
          $("#confirmation").modal('hide');
        }
      },
      error: function (data) {
          console.log('An error occurred.');
          console.log(data);
          //$("#feedback_msg").html(data);
      },
  });
}
</script>
<!--- AJAX SCHED CHECKER: GERARD -->

<!-- LOADING DURING AJAX -->
<script>
$(document).ajaxStart(function() {
  $(".searchloader").show();
});
$(document).ajaxStop(function() {
  $(".searchloader").hide();
});
</script>
<!--
  <script src="//cdn.datatables.net/1.10.19/js/jquery.dataTables.min.js"></script>
  <script src="//cdn.datatables.net/1.10.19/css/jquery.dataTables.min.css"></script>
-->

<script>
  $(document).ready(function(){
  $('#import_form').on('submit', function(event){
    event.preventDefault();
    $.ajax({
    url:"<?php echo base_url(); ?>Ccao/Import_Reports",
    method:"POST",
    data:new FormData(this),
    contentType:false,
    cache:false,
    processData:false,
    success:function(data){
      $('#file').val('');
      load_data();
      alert(data);
    }
    })
  });

  });
</script>

<script>
$('.radioChoose').on('click', function(e) {
  //Displays name and Value in Logs
    console.log(e.currentTarget.name); 
    console.log(e.currentTarget.value); 

  //Runs ajax, gets choices from 'ccao_inquiry' table based on chosen school
    result = get_hed(e.currentTarget.value);
    console.log(result);//---Displays results in logs for debugging
  
  //Appends and displays results in dropdown
    display_choices(result);
    
});

$('#dropChoose').on('change', function(e) {
  //Gets Dropdown Value
  school = $('#dropChoose').val();

  //Runs ajax, gets choices from 'ccao_inquiry' table based on chosen school
    result = get_hed(school);
    console.log(result);//---Displays results in logs for debugging
  
  //Appends and displays results in dropdown
  dropdown_display_choices(result);
    
});

function get_hed(school = ''){


  url = '<?php echo base_url(); ?>';
  ajax = $.ajax({
      async: false,
      url: url+"index.php/Ccao/Dropdown_Data",
      type: 'GET',
      data: {school: school},
      success: function(response){

          result = JSON.parse(response);

      },
      fail: function(){
          alert('request failed');
      }
  });
  return result;

}

function display_choices(result){

  //Sets initial value of the variable for choices
  option1 = '<option disabled  selected>Select 1st Choice:</option>';
  option2 = '<option disabled  selected>Select 2nd Choice:</option>';
  option3 = '<option disabled  selected>Select 3rd Choice:</option>';
  //--

  console.log('display_choices');//--For debugging purpose

  //Foreach the result to produce the choices
  $.each(result, function(index, row){

    //console.log(row['first_choice']);
    option1 += '<option>'+row['first_choice']+'</option>';
    option2 += '<option>'+row['first_choice']+'</option>';
    option3 += '<option>'+row['first_choice']+'</option>';

  });
  //--

  //Puts choices in select
  $('#course_choices1').html(option1);
  $('#course_choices2').html(option2);
  $('#course_choices3').html(option3);
  //--
  //Refreshes select
  $("#course_choices1").selectpicker('refresh');
  $("#course_choices2").selectpicker('refresh');
  $("#course_choices3").selectpicker('refresh');
  //--
}


function dropdown_display_choices(result){

  //Sets initial value of the variable for choices
  option1 = '<option disabled  selected>Select 1st Choice:</option>';
  //--

  console.log('display_choices');//--For debugging purpose

  //Foreach the result to produce the choices
  $.each(result, function(index, row){

    //console.log(row['first_choice']);
    option1 += '<option>'+row['first_choice']+'</option>';

  });
  //--

  //Puts choices in select
  $('#SCourse').html(option1);
  //Refreshes select
  $("#SCourse").selectpicker('refresh');
}
</script>


<script>
  /*
  $('.test').on('click', function(e) {
    //Displays name and Value in Logs
      console.log(e.currentTarget.name); 
      console.log(e.currentTarget.value); 

    //Runs ajax, gets choices from 'ccao_inquiry' table based on chosen school
      result = get_hed(e.currentTarget.value);
      console.log(result);//---Displays results in logs for debugging
    
    //Appends and displays results in dropdown
      display_choices(result);
      
  });

  function get_hed(school = ''){


    url = '<?php echo base_url(); ?>';
    ajax = $.ajax({
        async: false,
        url: url+"index.php/Ccao/Dropdown_Data",
        type: 'GET',
        data: {school: school},
        success: function(response){

            result = JSON.parse(response);

        },
        fail: function(){
            alert('request failed');
        }
    });
    return result;

  }

  function display_choices(result){

    //Sets initial value of the variable for choices
    option1 = '<option disabled  selected>Select Course/Strand</option>';
    //--

    console.log('display_choices');//--For debugging purpose

    //Foreach the result to produce the choices
    $.each(result, function(index, row){

      //console.log(row['first_choice']);
      option1 += '<option>'+row['first_choice']+'</option>';
    });
    //--

    //Puts choices in select
    $('#SCourse').html(option1);

    //--
    //Refreshes select
    $("#SCourse").selectpicker('refresh');

    //--
  }
  */
</script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/izitoast/1.4.0/js/iziToast.min.js"></script>






</body>

</html>