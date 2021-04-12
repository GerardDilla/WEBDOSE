<section  id="top" class="content" style="background-color: #fff;">
	<!-- CONTENT GRID-->
    <div class="container-fluid">
	
        <div class="row clearfix">
			<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                <div class="card">
                    <div class="header">
						<h2 class="red">SHS Enrolled Student Payment</h2>         
                    </div>  
                    <br>
					<div class="body"><!--start div Body-->

						<?php if($this->session->flashdata('message_error') || $this->session->flashdata('message_success')): ?>
						<br>
							<h3 class="col-red">
								<?php echo $this->session->flashdata('message_error'); ?>
							</h3>
							<h3 class="col-green">
								<?php echo $this->session->flashdata('message_success'); ?>
							</h3>
						<br>
						<?php endif; ?>
						<form method="post" id="selectStudentForm" action="<?php echo site_url(); ?>/Cashier/shs_form_select_student">

						<div class="row">
							<div class="col-md-5">
								<div class="input-group">
									<span class="input-group-addon">
										<i class="material-icons">person</i>
									</span>
									<b class="red">Please Type Reference/Student Number:</b>
									<div class="form-line">
										<input type="number" id="studentNumber" name="stud_ref_number" class="form-control InfoEnabled" value="<?php echo $this->input->post('stud_ref_number'); ?>" >
									</div>
									
								</div>
							</div>

							<div class="col-md-2">
								<div class="input-group">
									<b class="red">Please Select Grade Level:</b>
									<select class="form-control show-tick"  name="grade_level">
										<option value="G11"> Grade 11 </option>
										<option value="G12"> Grade 12 </option>
									</select>
								</div>
							</div>

							<div class="col-md-2">
								<div class="input-group">
									<b class="red">Please Select School Year:</b>
									<select class="form-control show-tick"  name="school_year">
											<option value="<?php echo ($this->date_year - 1).'-'.$this->date_year; ?>"> <?php echo ($this->date_year - 1).'-'.$this->date_year; ?> </option>
											<option value="<?php echo $this->date_year.'-'.($this->date_year + 1); ?>"> <?php echo $this->date_year.'-'.($this->date_year + 1); ?> </option>
											
									</select>
									
								</div>
							</div>
						</div>
						<div class="row">
							<?php if($this->data['track_list']): ?>
							<div class="col-md-3">
								<div class="input-group">
									<b class="red">Please Select Track:</b>
									<select id="track" class="form-control show-tick"  name="track">
										<option disabled selected>
											Select Track
										</option>
										<?php foreach ($this->data['track_list'] as $key => $track) { ?>
										<option value="<?php print $track['ID']; ?>"> <?php print $track['Track']; ?> </option>
										<?php } ?>
									</select>
								</div>
							</div> 
							<?php endif; ?>

							<div class="col-md-3">
								<div class="input-group">
									<b class="red">Please Select Strand:</b>
									<div id="strandDiv"> </div>

									<span class="input-group-addon">
										<i class="material-icons">send</i>
									</span>
								</div>
							</div>

							<div class="col-md-2">
								<button class="btn btn-danger btn-lg" id="selectBEDStudentSubmit" name="" type="submit">SEARCH</button>
							</div>

						</div>             
						
						</form> 
						<?php if($this->data['student_info']):  ?>
						<?php foreach ($this->data['student_info'] as $key => $student_info) { ?>
						<!--start Nav tabs -->
						<ul class="nav nav-tabs" role="tablist">
							<li role="presentation" class="active">
								<a href="#tab_student_info" data-toggle="tab" aria-expanded="false">
									<i class="material-icons">face</i> Personal Information
								</a>
							</li>
							<li role="presentation" class="">
								<a href="#tab_reservation_payments" data-toggle="tab" aria-expanded="false">
									<i class="material-icons">perm_identity</i> Reservation Payment List
								</a>
							</li>
							<li role="presentation" class="">
								<a href="#tab_matriculation_payments" data-toggle="tab" aria-expanded="false">
									<i class="material-icons">school</i> Matriculation Payment List
								</a>
							</li>
							<li role="presentation" class="">
								<a href="#tab_reservation" data-toggle="tab" aria-expanded="false">
									<i class="material-icons">school</i> Reservation
								</a>
							</li>
							<?php if($this->data['fees_enrolled']):  ?>
							<li role="presentation" class="">
								<a href="#tab_matriculation" data-toggle="tab" aria-expanded="false">
									<i class="material-icons">school</i> Matriculation
								</a>
							</li>
							<?php endif; ?>
						</ul>	
						<!--end Nav tabs -->

						<!--start Tab panes -->
						<div class="tab-content">

							<div role="tabpanel" class="tab-pane fade active in" id="tab_student_info">
								<div class="row">
									<div class="col-md-4">
										<div class="form-line">
											<b class="red">Reference Number:</b>
											<input type="text"   class="form-control" disabled value="<?php echo $student_info['Reference_Number'];  ?>">
											
										</div>
									</div>
									<div class="col-md-4">
										<div class="form-line">
											<b class="red">Student Number:</b>
											<input type="text" class="form-control" disabled value="<?php echo $student_info['Student_Number'];  ?>">
											
										</div>
									</div>
								</div>
								<div class="row">
									<div class="col-md-4">
										<div class="form-line">
											<b class="red">First Name:</b>
											<input type="text" class="form-control InfoEnabled" value="<?php echo $student_info['First_Name']; ?>" disabled>
										</div>
									</div>
									<div class="col-md-4">
										<div class="form-line">
											<b class="red">Middle Name:</b>
											<input type="text" class="form-control InfoEnabled"  value="<?php echo $student_info['Middle_Name']; ?>" disabled>
										</div>
									</div>
									<div class="col-md-4">
										<div class="form-line">
											<b class="red">Last Name:</b>
											<input type="text" class="form-control InfoEnabled" value="<?php echo $student_info['Last_Name']; ?>" disabled>
										</div>
									</div>
								</div>
								<div class="row">
									<div class="col-md-4">
										<div class="form-line">
											<b class="red">Grade Level:</b>
											<input type="text" disabled class="form-control InfoEnabled" value="<?php echo $student_info['Gradelevel'];  ?>" >
											
										</div>
									</div>
									<div class="col-md-4">
										<div class="form-line">
											<b class="red">Track:</b>
											<input type="text" disabled class="form-control InfoEnabled" value="<?php echo $student_info['track_name'];  ?>" >
											
										</div>
									</div>
									<div class="col-md-4">
										<div class="form-line">
											<b class="red">Strand:</b>
											<input type="text" disabled class="form-control InfoEnabled" value="<?php echo $student_info['Strand'];  ?>" >
											
										</div>
									</div>
								</div>  
								<div class="row">
									<div class="col-md-4">
										<div class="form-line">
											<b class="red">Admitted School Year:</b>
											<input type="text" disabled class="form-control InfoEnabled" value="<?php echo $student_info['AdmittedSY'];  ?>" >
											
										</div>
									</div>
								</div>  
							</div><!--end tabpanel personal info -->

							<div role="tabpanel" class="tab-pane fade" id="tab_reservation_payments">

								<div class="table panel panel-danger" style="overflow-x:auto; max-height:500px">
									<table id="tableSelectSchedule" class="table table-bordered">
										<thead>
											<tr class="danger">
												<th>OR Number</th>
												<th>Amount</th>
												<th>Payment Type</th>
												<th>Description</th>
												<th>Cashier</th>
												<th>Payment Date</th>
												
											</tr>
										</thead>
										<tbody>
										<?php if($this->data['reservation_payments_to_apply']):  ?>
											<?php foreach ($this->data['reservation_payments_to_apply'] as $key => $reservation) { ?>
												<tr>
													<td align="center"><?php print $reservation['OR_Number'] ?></td>
													<td align="center"><?php print $reservation['Amount'] ?></td>
													<td align="center"><?php print $reservation['Payment_Type'] ?></td>
													<td align="center"><?php print $reservation['Description'] ?></td>
													<td align="center"><?php print $reservation['cashier_name'] ?></td>
													<td align="center"><?php print $reservation['Append_Date'] ?></td>
												</tr>
											<?php }?>
										<?php else: ?>
											<tr>
												<td colspan="10" align="center">No Data</td>
											</tr>
										<?php endif; ?>
										</tbody>
									</table>
								</div>

							</div><!--end tabpanel reservation payment -->

							<div role="tabpanel" class="tab-pane fade" id="tab_matriculation_payments">

								<div class="table panel panel-danger" style="overflow-x:auto; max-height:500px">
									<table id="tableSelectSchedule" class="table table-bordered">
										<thead>
											<tr class="danger">
												<th>OR Number</th>
												<th>Amount</th>
												<th>Transaction Type</th>
												<th>Payment Type</th>
												<th>Description</th>
												<th>Cashier</th>
												<th>Payment Date</th>
												
											</tr>
										</thead>
										<tbody>
										<?php if($this->data['payments_list']):  ?>
											<?php foreach ($this->data['payments_list'] as $key => $payment) { ?>
												<tr>
													<td align="center"><?php print $payment['OR_Number'] ?></td>
													<td align="center"><?php print $payment['AmountofPayment'] ?></td>
													<td align="center"><?php print $payment['Transaction_Item'] ?></td>
													<td align="center"><?php print $payment['Transaction_Type'] ?></td>
													<td align="center"><?php print $payment['description'] ?></td>
													<td align="center"><?php print $payment['cashier_name'] ?></td>
													<td align="center"><?php print $payment['Date'] ?></td>
												</tr>
											<?php }?>
										<?php else: ?>
											<tr>
												<td colspan="10" align="center">No Data</td>
											</tr>
										<?php endif; ?>
										</tbody>
									</table>
								</div>

							</div><!--end tabpanel matriculation payment -->

							<div role="tabpanel" class="tab-pane fade" id="tab_reservation">
							<form method="post" id="insertReservation" action="<?php echo site_url(); ?>/Cashier/shs_reservation">
								<div class="row">
									<div class="col-md-4">
										<div class="form-line">
											<b class="red">Selected Grade Level:</b>
											<input type="text" id="gradeLevelRes" readonly name="grade_level" class="form-control InfoEnabled" value="<?php echo $this->data['grade_level'];  ?>" >
											<input type="hidden" id="referenceNoRes" name="reference_no" readonly value="<?php echo $this->data['student_info'][0]['Reference_Number'];  ?>" >
											<input id="trackRes" type="hidden" name="track" value="<?php print $this->data['track']; ?>">
											<input id="strandRes" type="hidden" name="strand" value="<?php print $this->data['strand']; ?>">
											<input type="hidden" id="transactionType" name="transaction_type" value="RESERVATION">
										</div>
									</div>
									<div class="col-md-4">
										<div class="form-line">
											<b class="red">Selected School Year:</b>
											<input type="text" id="schoolYearRes" name="school_year" readonly class="form-control InfoEnabled" value="<?php echo $this->data['school_year'];  ?>" >
											
										</div>
									</div>
								</div>
								<div class="row">
									<div class="col-md-4">
										<div class="form-line">
											<b class="red">Payment Type:</b>
											<select id="paymentTypeRes" name="payment_type" class="form-control show-tick">
												<option disabled selected>
													Select Payment Type
												</option>
												<option value="CASH">Cash</option>
												<option value="CHEQUE">Checque</option>
												<option value="DIRECT BANK DEPOSIT">Direct Bank Deposit</option>
												<option value="CREDIT CARD">Credit Card</option>
												<option value="SM">SM</option>
												<option value="VOUCHER">Voucher</option>

											</select>
										</div>
									</div>
									<div class="col-md-4">
										<div class="form-line">
											<b class="red">OR #:</b>
											<input id="orNoRes" name="or_no" type="text"  class="form-control InfoEnabled" >
											
										</div>
									</div>
								</div>
								<div class="row">
									<div class="col-md-4">
										<div class="form-line">
											<b class="red">Description:</b>
											<input id="descriptionRes" name="description" type="text"  class="form-control InfoEnabled" >
										</div>
									</div>
									<div class="col-md-4">
										<div class="form-line">
											<b class="red">Amount:</b>
											<input id="amountRes" name="amount" type="number"  class="form-control InfoEnabled">
											
										</div>
									</div>
								</div>
							</form>
								<div class="row">
									<div class="col-md-4">
										<div class="form-line">
											<button class="btn btn-danger" id="shsReservationInsertButton"> Insert </button>
										</div>
									</div>
								</div>
							
							</div><!--end tabpanel reservation -->

							<div role="tabpanel" class="tab-pane fade" id="tab_matriculation">
							<form method="post" id="insertMatriculation" action="<?php echo site_url(); ?>/Cashier/shs_matriculation_input">
								<div class="row">
									<div class="col-md-4">
										<div class="form-line">
											<b class="red">Selected Grade Level:</b>
											<input type="text" id="gradeLevel" readonly name="grade_level" class="form-control InfoEnabled" value="<?php echo $this->data['grade_level'];  ?>" >
											<input type="hidden" id="referenceNo" name="reference_no" readonly value="<?php echo $this->data['student_info'][0]['Reference_Number'];  ?>" >
											<input type="hidden" name="track" value="<?php print $this->data['track']; ?>">
											<input type="hidden" name="strand" value="<?php print $this->data['strand']; ?>">
										</div>
									</div>
									<div class="col-md-4">
										<div class="form-line">
											<b class="red">Selected School Year:</b>
											<input type="text" id="schoolYear" name="school_year" readonly class="form-control InfoEnabled" value="<?php echo $this->data['school_year'];  ?>" >
											
										</div>
									</div>
								</div>
								<div class="row">
									<div class="col-md-4">
										<div class="form-line">
											<b class="red">Total Tuition:</b>
											<input type="text"  disabled class="form-control InfoEnabled" value="<?php echo $this->data['total_tuition_fee'];  ?>" >
										</div>
									</div>
								</div>
								<div class="row">
									<div class="col-md-4">
										<div class="form-line">
											<b class="red">Total Paid:</b>
											<input type="text"  disabled class="form-control InfoEnabled" value="<?php echo $this->data['total_payment'];  ?>" >
										</div>
									</div>
									<div class="col-md-4">
										<div class="form-line">
											<b class="red">Balance:</b>
											<input type="text"  disabled class="form-control InfoEnabled" value="<?php echo $this->data['balance'];  ?>" >
											
										</div>
									</div>
								</div>

								<?php foreach ($this->data['fees_enrolled'] as $key => $fees_enrolled) { ?>
								<div class="row">
									<div class="col-md-4">
										<div class="form-line">
											<b class="red">Payment Scheme:</b>
											<input type="text"  disabled class="form-control InfoEnabled" value="<?php echo $this->data['fees_enrolled'][0]['Payment_Scheme'];  ?>" >
										</div>
									</div>
									
								</div>
								<div class="row">
									<div class="col-md-4">
										<div class="form-line">
											<b class="red">Initial Payment:</b>
											<input type="text"  disabled class="form-control InfoEnabled" value="<?php echo $fees_enrolled['Initial_Payment'];  ?>" >
										</div>
									</div>
									<div class="col-md-4">
										<div class="form-line">
											<b class="red">First Payment:</b>
											<input type="text"  disabled class="form-control InfoEnabled" value="<?php echo $fees_enrolled['First_Payment'];  ?>" >
											
										</div>
									</div>
									<div class="col-md-4">
										<div class="form-line">
											<b class="red">Second Payment:</b>
											<input type="text"  disabled class="form-control InfoEnabled" value="<?php echo $fees_enrolled['Second_Payment'];  ?>" >
										</div>
									</div>
								</div>
								<div class="row">
									<div class="col-md-4">
										<div class="form-line">
											<b class="red">Third Payment:</b>
											<input type="text"  disabled class="form-control InfoEnabled" value="<?php echo $fees_enrolled['Third_Payment'];  ?>" >
											
										</div>
									</div>
									<div class="col-md-4">
										<div class="form-line">
											<b class="red">Fourth Payment:</b>
											<input type="text"  disabled class="form-control InfoEnabled" value="<?php echo $fees_enrolled['Fourth_Payment'];  ?>" >
											
										</div>
									</div>
									<div class="col-md-4">
										<div class="form-line">
											<b class="red">Fifth Payment:</b>
											<input type="text"  disabled class="form-control InfoEnabled" value="<?php echo $fees_enrolled['Fifth_Payment'];  ?>" >
											
										</div>
									</div>
								</div>
								<div class="row">
									<div class="col-md-4">
										<div class="form-line">
											<b class="red">Sixth Payment:</b>
											<input type="text"  disabled class="form-control InfoEnabled" value="<?php echo $fees_enrolled['Sixth_Payment'];  ?>" >
											
										</div>
									</div>
									<div class="col-md-4">
										<div class="form-line">
											<b class="red">Seventh Payment:</b>
											<input type="text"  disabled class="form-control InfoEnabled" value="<?php echo $fees_enrolled['Seventh_Payment'];  ?>" >
											
										</div>
									</div>
									
								</div>
								<?php } ?>
								<div class="row">
									<div class="col-md-4">
										<div class="form-line">
											<b class="red">Payment Type:</b>
											<select id="paymentType" name="payment_type" class="form-control show-tick">
												<option disabled selected>
													Select Payment Type
												</option>
												<option value="CASH">Cash</option>
												<option value="CHEQUE">Checque</option>
												<option value="DIRECT BANK DEPOSIT">Direct Bank Deposit</option>
												<option value="CREDIT CARD">Credit Card</option>
												<option value="SM">SM</option>
												<option value="VOUCHER">Voucher</option>

											</select>
										</div>
									</div>
									<div class="col-md-4">
										<div class="form-line">
											<b class="red">OR #:</b>
											<input id="orNo" name="or_no" type="text"  class="form-control InfoEnabled" >
											
										</div>
									</div>
								</div>
								<div class="row">
									<div class="col-md-4">
										<div class="form-line">
											<b class="red">Description:</b>
											<input id="description" name="description" type="text"  class="form-control InfoEnabled" >
											<input type="hidden" id="transactionType" name="transaction_type" value="MATRICULATION">
										</div>
									</div>
									<div class="col-md-4">
										<div class="form-line">
											<b class="red">Amount:</b>
											<input id="amount" name="amount" type="number"  class="form-control InfoEnabled">
											
										</div>
									</div>
								</div>
							</form>
								<div class="row">
									<div class="col-md-4">
										<div class="form-line">
											<button class="btn btn-danger" id="shsMatriculationInsertButton"> Insert </button>
										</div>
									</div>
								</div>
							</form>
							</div><!--end tabpanel tab_matriculation -->

						</div><!--end tab-content -->


						<?php }?>
						<?php endif; ?>

					</div> <!--end div Body-->           
                </div><!--end div card-->
            </div><!--end col-lg-12 col-md-12 col-sm-12 col-xs-12 -->
        </div><!-- end row clear fix-->

     </DIV><!--END CONTENT GRID-->   
		
		<input type="hidden" id="addressUrl" value="<?php print site_url().'/Cashier'; ?>" />


       
</section>


<?php if($this->data['student_info'] && $this->data['fees_enrolled']):  ?>
<!-- Large Size -->
<div class="modal fade" id="enrollmentModal" tabindex="-1" role="dialog">
	<div class="modal-dialog modal-lg" style="width:100%" role="document">
		<div class="modal-content">
			<div class="modal-header">
					<h2 id="largeModalLabel">Enrolled Student Payment (Enrollment)</h2>
			</div>
			
			<div class="modal-body">
			<form method="post" id="insertMatriculation" action="<?php echo site_url(); ?>/Cashier/shs_matriculation_input">
			<?php foreach ($this->data['student_info'] as $key => $student_info) { ?>
				<br> <br>

				<div class="row">
					<div class="col-md-2">
						<h4>Name:</h4>
					</div>
					<div class="col-md-2">
						<input type="text" disabled class="form-control InfoEnabled" value="<?php echo $student_info['Last_Name'].", ".$student_info['First_Name']." ".$student_info['Middle_Name'];  ?>" >
					</div>
				</div>
				<div class="row">
					<div class="col-md-2">
						<h4>Grade Level:</h4>
					</div>
					<div class="col-md-2">
						<input type="text" readonly class="form-control InfoEnabled" value="<?php echo $student_info['Gradelevel'];  ?>" >
					</div>

				</div>

				<div class="row">
					<div class="col-md-2">
						<h4>Student Number:</h4>
					</div>
					<div class="col-md-2">
						<input type="text" disabled class="form-control InfoEnabled" value="<?php echo $student_info['Student_Number'];  ?>" >
					</div>

					<div class="col-md-2">
						<h4>Reference Number:</h4>
					</div>
					<div class="col-md-2">
						<input type="text" id="referenceNo" name="reference_no" readonly class="form-control InfoEnabled" value="<?php echo $student_info['Reference_Number'];  ?>" >
					</div>

				</div>

			<?php }// end of foreach?>
					
				<div class="row">
						
					<div class="col-md-2">
						<h4>Selected Grade Level:</h4>
					</div>
					<div class="col-md-2">
						<input type="text" id="gradeLevel" readonly name="grade_level" class="form-control InfoEnabled" value="<?php echo $this->data['grade_level'];  ?>" >
					</div>
				</div>
				
				<div class="row">

					<div class="col-md-2">
						<h4>Selected School Year:</h4>
					</div>
					<div class="col-md-2">
						<input type="text" id="schoolYear" name="school_year" readonly class="form-control InfoEnabled" value="<?php echo $this->data['school_year'];  ?>" >
					</div>
					<input type="hidden" name="track" value="<?php print $this->data['track']; ?>">
					<input type="hidden" name="strand" value="<?php print $this->data['strand']; ?>">

				</div>



				<div class="row">
					<div class="col-md-2">
						<h4>Total Tuition:</h4>
					</div>
					<div class="col-md-2">
						<input type="text"  disabled class="form-control InfoEnabled" value="<?php echo $this->data['total_tuition_fee'];  ?>" >
					</div>
				</div>

				<div class="row">
					<div class="col-md-2">
						<h4>Total Paid:</h4>
					</div>
					<div class="col-md-2">
						<input type="text"  disabled class="form-control InfoEnabled" value="<?php echo $this->data['total_payment'];  ?>" >
					</div>
				</div>

				<div class="row">
					<div class="col-md-2">
						<h4>Balance:</h4>
					</div>
					<div class="col-md-2">
						<input type="text"  disabled class="form-control InfoEnabled" value="<?php echo $this->data['balance'];  ?>" >
					</div>
				</div>

				<?php foreach ($this->data['fees_enrolled'] as $key => $fees_enrolled) { ?>
				<div class="row">
					<div class="col-md-2">
						<h4>Payment Scheme:</h4>
					</div>
					<div class="col-md-2">
						<input type="text"  disabled class="form-control InfoEnabled" value="<?php echo $this->data['fees_enrolled'][0]['Payment_Scheme'];  ?>" >
					</div>
				</div>

				<div class="row">
					<div class="col-md-2">
						<h4>Initial Payment:</h4>
					</div>
					<div class="col-md-2">
						<input type="text"  disabled class="form-control InfoEnabled" value="<?php echo $fees_enrolled['Initial_Payment'];  ?>" >
					</div>
				</div>

				<div class="row">
					<div class="col-md-2">
						<h4>First Payment:</h4>
					</div>
					<div class="col-md-2">
						<input type="text"  disabled class="form-control InfoEnabled" value="<?php echo $fees_enrolled['First_Payment'];  ?>" >
					</div>
				</div>

				<div class="row">
					<div class="col-md-2">
						<h4>Second Payment:</h4>
					</div>
					<div class="col-md-2">
						<input type="text"  disabled class="form-control InfoEnabled" value="<?php echo $fees_enrolled['Second_Payment'];  ?>" >
					</div>
				</div>

				<div class="row">
					<div class="col-md-2">
						<h4>Third Payment:</h4>
					</div>
					<div class="col-md-2">
						<input type="text"  disabled class="form-control InfoEnabled" value="<?php echo $fees_enrolled['Third_Payment'];  ?>" >
					</div>
				</div>

				<div class="row">
					<div class="col-md-2">
						<h4>Fourth Payment:</h4>
					</div>
					<div class="col-md-2">
						<input type="text"  disabled class="form-control InfoEnabled" value="<?php echo $fees_enrolled['Fourth_Payment'];  ?>" >
					</div>
				</div>

				<div class="row">
					<div class="col-md-2">
						<h4>Fifth Payment:</h4>
					</div>
					<div class="col-md-2">
						<input type="text"  disabled class="form-control InfoEnabled" value="<?php echo $fees_enrolled['Fifth_Payment'];  ?>" >
					</div>
				</div>

				<div class="row">
					<div class="col-md-2">
						<h4>Sixth Payment:</h4>
					</div>
					<div class="col-md-2">
						<input type="text"  disabled class="form-control InfoEnabled" value="<?php echo $fees_enrolled['Sixth_Payment'];  ?>" >
					</div>
				</div>

				<div class="row">
					<div class="col-md-2">
						<h4>Seventh Payment:</h4>
					</div>
					<div class="col-md-2">
						<input type="text"  disabled class="form-control InfoEnabled" value="<?php echo $fees_enrolled['Seventh_Payment'];  ?>" >
					</div>
				</div>

				<?php }// end of foreach?>


				<div class="row">

					<div class="col-md-2">
						<h4>Payment Type:</h4>
					</div>
					<div class="col-md-3">
						<select id="paymentType" name="payment_type" class="form-control show-tick" data-live-search="true">
							<option disabled selected>
								Select Payment Type
							</option>
							<option value="CASH">Cash</option>
							<option value="CHEQUE">Checque</option>
							<option value="DIRECT BANK DEPOSIT">Direct Bank Deposit</option>
							<option value="CREDIT CARD">Credit Card</option>
							<option value="SM">SM</option>
							<option value="VOUCHER">Voucher</option>

						</select>
					
					</div>
					

				</div>

				<div class="row">
					<div class="col-md-2">
						<h4>OR #:</h4>
					</div>
					<div class="col-md-2">
						<input id="orNo" name="or_no" type="text"  class="form-control InfoEnabled" >
					</div>

				</div>

				<div class="row">
					<div class="col-md-2">
						<h4>Description #:</h4>
					</div>
					<div class="col-md-2">
						<input id="orNo" name="description" type="text"  class="form-control InfoEnabled" >
						<input type="hidden" id="transactionType" name="transaction_type" value="MATRICULATION">
					</div>

				</div>

				<div class="row">
					<div class="col-md-2">
						<h4>Amount:</h4>
					</div>
					<div class="col-md-2">
						<input id="amount" name="amount" type="number"  class="form-control InfoEnabled">
					</div>

				</div>
			</form>
				<div class="row">
					
					<div class="col-md-2">
						<button class="btn btn-danger" id="shsMatriculationInsertButton"> Insert </button>
					</div>


				</div>


				
			
			
			</div>

				
			
			
			<div class="modal-footer" id="AddSched_Button_Panel">
					<!-- Will only show if block section. Function: toggleAddAllButton() -->
			</div>
		</div>
	</div>
</div>

<?php endif ?>


<?php if($this->data['student_info']):  ?>

<!-- Large Size -->
<div class="modal fade" id="reservationModal" tabindex="-1" role="dialog">
		<div class="modal-dialog modal-lg" style="width:100%" role="document">
				<div class="modal-content">
					<div class="modal-header">
							<h2 id="largeModalLabel">Enrolled Student Payment (RESERVATION)</h2>
					</div>
					
					<div class="modal-body">
					<form method="post" id="insertReservation" action="<?php echo site_url(); ?>/Cashier/shs_reservation">
					<?php foreach ($this->data['student_info'] as $key => $student_info) { ?>
						<br> <br>
						<div class="row">
							<div class="col-md-2">
								<h4>Name:</h4>
							</div>
							<div class="col-md-2">
								<input type="text" disabled class="form-control InfoEnabled" value="<?php echo $student_info['Last_Name'].", ".$student_info['First_Name']." ".$student_info['Middle_Name'];  ?>" >
							</div>
						</div>
						
						<div class="row">
							<div class="col-md-2">
								<h4>Reference Number:</h4>
							</div>
							<div class="col-md-2">
								<input type="text" id="referenceNoRes" name="reference_no" readonly class="form-control InfoEnabled" value="<?php echo $student_info['Reference_Number'];  ?>" >
							</div>
						</div>

						<div class="row">
							<div class="col-md-2">
								<h4>Student Number:</h4>
							</div>
							<div class="col-md-2">
								<input type="text" disabled class="form-control InfoEnabled" value="<?php echo $student_info['Student_Number'];  ?>" >
							</div>


						</div>

						<?php }// end of foreach?>

						<div class="row">
						
							<div class="col-md-2">
								<h4>Selected Grade Level:</h4>
							</div>
							<div class="col-md-2">
								<input type="text" id="gradeLevelRes" readonly name="grade_level" class="form-control InfoEnabled" value="<?php echo $this->data['grade_level'];  ?>" >
							</div>
						</div>
						
						<div class="row">

							<div class="col-md-2">
								<h4>Selected School Year:</h4>
							</div>
							<div class="col-md-2">
								<input type="text" id="schoolYearRes" name="school_year" readonly class="form-control InfoEnabled" value="<?php echo $this->data['school_year'];  ?>" >
							</div>
							<input id="trackRes" type="hidden" name="track" value="<?php print $this->data['track']; ?>">
							<input id="strandRes" type="hidden" name="strand" value="<?php print $this->data['strand']; ?>">

						</div>

						<div class="row">

							<div class="col-md-2">
								<h4>Payment Type:</h4>
							</div>
							<div class="col-md-3">
								<select id="paymentTypeRes" name="payment_type" class="form-control show-tick" data-live-search="true">
									<option disabled selected>
										Select Payment Type
									</option>
									<option value="CASH">Cash</option>
									<option value="CHEQUE">Checque</option>
									<option value="DIRECT BANK DEPOSIT">Direct Bank Deposit</option>
									<option value="CREDIT CARD">Credit Card</option>
									<option value="SM">SM</option>
									<option value="VOUCHER">Voucher</option>

								</select>
							
							</div>
							

						</div>

						<div class="row">
							<div class="col-md-2">
								<h4>OR #:</h4>
							</div>
							<div class="col-md-2">
								<input id="orNoRes" name="or_no" type="text"  class="form-control InfoEnabled" >
							</div>

						</div>

						<div class="row">
							<div class="col-md-2">
								<h4>Description:</h4>
							</div>
							<div class="col-md-2">
								<input id="" name="description" type="text"  class="form-control InfoEnabled" >
								<input type="hidden" id="transactionTypeRes" name="transaction_type" value="MATRICULATION">
							</div>

						</div>

						<div class="row">
							<div class="col-md-2">
								<h4>Amount:</h4>
							</div>
							<div class="col-md-2">
								<input id="amountRes" name="amount" type="number"  class="form-control InfoEnabled">
							</div>

						</div>
					</form>
						<div class="row">
							
							<div class="col-md-2">
								<button class="btn btn-danger" id="shsReservationInsertButton"> Insert </button>
							</div>


						</div>


						
					
					
					</div>

						
					
					
					<div class="modal-footer" id="AddSched_Button_Panel">
							<!-- Will only show if block section. Function: toggleAddAllButton() -->
					</div>
				</div>
		</div>
</div>
<?php endif ?>

<div class="modal fade" id="unAppliedReservations" tabindex="-1" role="dialog">
		<div class="modal-dialog modal-lg" style="width:100%" role="document">
				<div class="modal-content">
						<div class="modal-header">
								<h2 id="largeModalLabel">Reservation payments to apply</h2>
						</div>
						<div class="modal-body">

							<br> <br>
							

							<div class="table panel panel-danger" style="overflow-x:auto; max-height:500px">
								<table id="tableSelectSchedule" class="table table-bordered">
									<thead>
										<tr class="danger">
											<th>OR Number</th>
											<th>Amount</th>
											<th>Payment Type</th>
											<th>Description</th>
											<th>Cashier</th>
											<th>Payment Date</th>
											
										</tr>
									</thead>
									<tbody>
									<?php if($this->data['reservation_payments_to_apply']):  ?>
										<?php foreach ($this->data['reservation_payments_to_apply'] as $key => $reservation) { ?>
											<tr>
												<td align="center"><?php print $reservation['OR_Number'] ?></td>
												<td align="center"><?php print $reservation['Amount'] ?></td>
												<td align="center"><?php print $reservation['Payment_Type'] ?></td>
												<td align="center"><?php print $reservation['Description'] ?></td>
												<td align="center"><?php print $reservation['cashier_name'] ?></td>
												<td align="center"><?php print $reservation['Append_Date'] ?></td>
											</tr>
										<?php }?>
									<?php else: ?>
										<tr>
											<td colspan="10" align="center">No Data</td>
										</tr>
									<?php endif; ?>
									</tbody>
								</table>
							</div>
							<br>
							<div id="openSchedPagination"> </div>

						</div>
						<div class="modal-footer" id="AddSched_Button_Panel">
								<!-- Will only show if block section. Function: toggleAddAllButton() -->
						</div>
				</div>
		</div>
</div>


<div class="modal fade" id="paymentList" tabindex="-1" role="dialog">
		<div class="modal-dialog modal-lg" style="width:100%" role="document">
				<div class="modal-content">
						<div class="modal-header">
								<h2 id="largeModalLabel">Matriculation payments</h2>
						</div>
						<div class="modal-body">

							<br> <br>
							

							<div class="table panel panel-danger" style="overflow-x:auto; max-height:500px">
								<table id="tableSelectSchedule" class="table table-bordered">
									<thead>
										<tr class="danger">
											<th>OR Number</th>
											<th>Amount</th>
											<th>Transaction Type</th>
											<th>Payment Type</th>
											<th>Description</th>
											<th>Cashier</th>
											<th>Payment Date</th>
											
										</tr>
									</thead>
									<tbody>
									<?php if($this->data['payments_list']):  ?>
										<?php foreach ($this->data['payments_list'] as $key => $payment) { ?>
											<tr>
												<td align="center"><?php print $payment['OR_Number'] ?></td>
												<td align="center"><?php print $payment['AmountofPayment'] ?></td>
												<td align="center"><?php print $payment['Transaction_Item'] ?></td>
												<td align="center"><?php print $payment['Transaction_Type'] ?></td>
												<td align="center"><?php print $payment['description'] ?></td>
												<td align="center"><?php print $payment['cashier_name'] ?></td>
												<td align="center"><?php print $payment['Date'] ?></td>
											</tr>
										<?php }?>
									<?php else: ?>
										<tr>
											<td colspan="10" align="center">No Data</td>
										</tr>
									<?php endif; ?>
									</tbody>
								</table>
							</div>
							<br>
							<div id="openSchedPagination"> </div>

						</div>
						<div class="modal-footer" id="AddSched_Button_Panel">
								<!-- Will only show if block section. Function: toggleAddAllButton() -->
						</div>
				</div>
		</div>
</div>


<!-- Large Size -->
<div class="modal fade" id="largeModal" tabindex="-1" role="dialog">
		<div class="modal-dialog modal-lg" style="width:100%" role="document">
				<div class="modal-content">
						<div class="modal-header">
								<h2 id="largeModalLabel">Add Schedule</h2>
						</div>
						<div class="modal-body">

							<br> <br>
							<div class="row">
								<!--
								<div class="col-md-6">
											<input id="searchSched" onkeyup="searchSchedV2()" class="form-control" placeholder="Search Schedule..." type="text" />
									<br>
									</div>
									-->
								<div class="col-md-2">
									<select id="schedSearchType" class="form-control show-tick" data-live-search="true">
										<option disabled selected>
											Select Search Type
										</option>
										<option value="Course_Code">Course Code</option>
										<option value="Sched_Code">Sched Code</option>
										<option value="Course_Title">Course Title</option>

									</select>
								
								</div>
								<div class="col-md-2">
									<input id="schedSearchValue" class="form-control" placeholder="Search Schedule..." type="text" style="margin-top: 0px;" />
								</div>
								<div class="col-md-2">
									<button class="btn btn-lg btn-info" id="schedSearchSubmit" type="button" onclick="searchOpenSchedList()" disabled style="height: 34px;">SEARCH</button>
								</div>
								<div class="col-md-2 searchloader" style="padding: 1%; display:none">
									LOADING <img src="<?php echo base_url(); ?>img/ajax-loader.gif" />
								</div>
								<div class="col-md-2 pull-right">
									<h6 class="card-inside-title">Bypass Pre-Requisite <br>(Requires Program Chair Login)</h6>
									<div class="demo-switch">
										<div class="switch">
											<label>OFF<input type="checkbox" name="bypass_check" id="bypassCheck" value="1"><span class="lever"></span>ON</label>
										</div>
									</div>
									<br>
								</div>
							</div>

							<div class="table panel panel-danger" style="overflow-x:auto; max-height:500px">
								<table id="tableSelectSchedule" class="table table-bordered">
									<thead>
										<tr class="danger">
											<th>Sched Code</th>
											<th>Course Code</th>
											<th>Course Title</th>
											<th>Section</th>
											<th>Lec Unit</th>
											<th>Lab Unit</th>
											<th>Day</th>
											<th>Time</th>
											<th>Room</th>

											<th>Remaining Slot</th>
											<th>Instructor Name</th>
											<th></th>
										</tr>
									</thead>
									<tbody>
										<tr>
										<td colspan="10" align="center">No Data</td>
										</tr>
									</tbody>
								</table>
							</div>
							<br>
							<div id="openSchedPagination"> </div>

						</div>
						<div class="modal-footer" id="AddSched_Button_Panel">
								<!-- Will only show if block section. Function: toggleAddAllButton() -->
						</div>
				</div>
		</div>
</div>

<input type="hidden" id="addressUrl" value="<?php echo site_url().'/cashier'; ?>"/>
<script type="text/javascript" src="<?php echo base_url(); ?>js/cashier.js"></script>



