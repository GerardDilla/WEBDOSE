
<section  id="top" class="content" style="background-color: #fff;">
	<!-- CONTENT GRID-->
	<div class="container-fluid">

		<!-- MODULE TITLE-->
		<div class="block-header">
			<h1> <i class="material-icons" style="font-size:100%">assignment_returned</i> Student Record</h1>
		</div>
		<!--/ MODULE TITLE-->

		<div class="row">
			<div class="col-md-4">

			<!-- STUDENT SELECTION -->
				<div class="SBorder vertical_gap">
					<h4>Basic Education</h4><hr>
					<div class="form-line vertical_gap">
						<input class="form-control date" value="" placeholder="Student Number:" name="student_num" type="text" required>
					</div>
					<div class="text-center vertical_gap">
						<button  type="submit" class="btn btn-lg btn-info">SELECT</button>
					</div>
				</div>
			<!-- /STUDENT SELECTION -->

			<!-- INFO DISPLAY -->
                <div class="SBorder">
                    <div class="input-group">
                        <div class="form-line">
                            <input class="form-control date" disabled  type="text" id="name_view" placeholder="Name:  ">
                        </div>
                        <div class="form-line">
                            <input class="form-control date" disabled  type="text" id="program_view" placeholder="Grade level: ">
                        </div>
                    </div>
                </div>
             <!-- INFO DISPLAY -->
				<br>

			</div>


			<div class="col-md-8">
				<div class="row">
					<div class="col-md-12" >
						<div class="SBorder row">
                            <div class="form-line">
                                <input class="form-control date" disabled="" type="text"  placeholder="Remarks:  Sample ">
                            </div>
                            <div class="form-line">
                                <input class="form-control date" disabled="" type="text"  placeholder="Form 137 refno:  12312 ">
                            </div>
                            <div class="form-line">
                                <input class="form-control date" disabled="" type="text"  placeholder="Prepared by:  Sample">
                            </div>
                            <div class="form-line">
                                <input class="form-control date" disabled="" type="text"  placeholder="Approved by:  Sample">
                            </div>
                            <div class="form-line">
                                <input class="form-control date" disabled="" type="text"  placeholder="Released by:  Sample">
                            </div>
                            <div class="form-line">
                                <input class="form-control date" disabled="" type="text"  placeholder="Verified by:  Sample">
                            </div>
						</div>
					</div> 
				</div>
			</div>

		</div>
	</div>
	<!--/CONTENT GRID-->

</section>


<script>
	$("#schedSearchType").change(function(){
		console.log("test");
		$("#schedSearchSubmit").prop('disabled', false);


	});

	$( window ).load(function() {
		// Run code
		//displaySchedTable();
		displaySession();
	});
</script>

  
	


