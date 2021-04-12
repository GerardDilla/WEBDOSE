<section class="content" style="background-color: #fff;">
	<div class="container-fluid">
		<div class="block-header">
			<h1>Blackboard API test area</h1>
		</div>
		<hr>
		<div class="row">
		
			<div class="col-md-1">
				<button class="btn btn-primary" id="course_add">Test Add Course</button>
			</div>

			<div class="col-md-1">
				<button class="btn btn-primary" id="student_add">Test Add Student</button>
			</div>
		
		</div>
		<br>
	</div>
</section>

<script>

$(document).ready(function(){

	console.log('script loaded');
	$('#course_add').click(function(){
		addcourse();
	});

});

function addcourse(){

	alert("Button Works");

	$.ajax({
        
		url: "https://stdominiccollege-test.blackboard.com/learn/api/public/v3/courses",
		type:'POST',
		data:coursedata(),
        success: function(response){

			response = JSON.parse(response);
			console.log(response);

        },
        fail: function(){
            
        }
	});
	
}

function coursedata(){


	data = {
		"externalId": "string",
		"dataSourceId": "string",
		"courseId": "string",
		"name": "string",
		"description": "string",
		"organization": true,
		"ultraStatus": "Undecided",
		"allowGuests": true,
		"closedComplete": true,
		"termId": "string",
		"availability": {
			"available": "Yes",
			"duration": {
			"type": "Continuous",
			"start": "2020-06-30T06:34:28.959Z",
			"end": "2020-06-30T06:34:28.959Z",
			"daysOfUse": 0
			}
		},
		"enrollment": {
			"type": "InstructorLed",
			"start": "2020-06-30T06:34:28.959Z",
			"end": "2020-06-30T06:34:28.959Z",
			"accessCode": "string"
		},
		"locale": {
			"id": "string",
			"force": true
		}
	}
	return data;

}

</script>
 