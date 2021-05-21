<section  id="top" class="content" style="background-color: #fff;">
	<!-- CONTENT GRID-->
    <div class="container-fluid">
	
        <div class="row clearfix">
			<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                <div class="card">
					
					<div class="header">
						<h2 class="red"> 
							<?php if($this->data['school_level'] === "SHS"): ?>
							SHS Enrolled Student Payment
							<?php elseif($this->data['school_level'] === "BED"): ?>
							Basic Education Enrolled Student Payment
							<?php else: ?>
							BED/SHS Enrolled Student Payment
							<?php endif; ?>

						</h2>         
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
						<?php endIf; ?>
						<form method="post" id="selectStudentForm" action="<?php echo site_url(); ?>/Cashier/basiced_form_select_student">

						<div class="row">

							<div class="col-md-5">
								<div class="input-group">
									<span class="input-group-addon">
										<i class="material-icons">person</i>
									</span>
									<b class="red">Please Type Reference/Student Number:</b>
									<div class="form-line">
										<input type="number" id="studentNumber" name="stud_ref_number" class="form-control InfoEnabled" value="<?php $ref_no = ($this->data['student_info']) ? $this->data['student_info'][0]['Reference_Number'] : "" ; echo $ref_no;  ?>" >
									</div>
									
								</div>
							</div>

							

							<div class="col-md-2">
								<div class="input-group">
									<b class="red">Please Select School Year:</b>
									<select id="selectSchoolYear" class="form-control show-tick"  name="school_year">
										<option value="<?php echo ($this->date_year - 1).'-'.$this->date_year; ?>" <?php echo intval(date('m'))<5?' selected':'';?>> <?php echo ($this->date_year - 1).'-'.$this->date_year; ?> </option>
										<option value="<?php echo $this->date_year.'-'.($this->date_year + 1); ?>" <?php echo intval(date('m'))>=5?' selected':'';?>> <?php echo $this->date_year.'-'.($this->date_year + 1); ?> </option>
											
									</select>
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
							<?php if($this->data['fees_enrolled'] && ($this->data['array_balance_checker']['payment_approval'] === 1)):  ?>
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
											<b class="black">Reference Number:</b>
											<input type="text"   class="form-control" disabled value="<?php echo $student_info['Reference_Number'];  ?>">
											
										</div>
									</div>
									<div class="col-md-4">
										<div class="form-line">
											<b class="black">Student Number:</b>
											<input type="text" class="form-control" disabled value="<?php echo $student_info['Student_Number'];  ?>">
											
										</div>
									</div>
								</div>
								<div class="row">
									<div class="col-md-4">
										<div class="form-line">
											<b class="black">First Name:</b>
											<input type="text" class="form-control InfoEnabled" value="<?php echo $student_info['First_Name']; ?>" disabled>
										</div>
									</div>
									<div class="col-md-4">
										<div class="form-line">
											<b class="black">Middle Name:</b>
											<input type="text" class="form-control InfoEnabled"  value="<?php echo $student_info['Middle_Name']; ?>" disabled>
										</div>
									</div>
									<div class="col-md-4">
										<div class="form-line">
											<b class="black">Last Name:</b>
											<input type="text" class="form-control InfoEnabled" value="<?php echo $student_info['Last_Name']; ?>" disabled>
										</div>
									</div>
								</div>
								<div class="row">
									<div class="col-md-4">
										<div class="form-line">
											<b class="black">Grade Level:</b>
											<input type="text" disabled class="form-control InfoEnabled" value="<?php echo $student_info['Gradelevel'];  ?>" >
											
										</div>
									</div>
									<?php if($this->data['school_level'] === "SHS"): ?>
										<div class="col-md-4">
										<div class="form-line">
											<b class="black">Track:</b>
											<input type="text" disabled class="form-control InfoEnabled" value="<?php echo $student_info['track_name'];  ?>" >
											
										</div>
									</div>
									<div class="col-md-4">
										<div class="form-line">
											<b class="black">Strand:</b>
											<input type="text" disabled class="form-control InfoEnabled" value="<?php echo $student_info['Strand'];  ?>" >
											
										</div>
									</div>
									<?php endif; ?>
								</div>  
								<div class="row">
									<div class="col-md-4">
										<div class="form-line">
											<b class="black">Admitted School Year:</b>
											<input type="text" disabled class="form-control InfoEnabled" value="<?php echo $student_info['AdmittedSY'];  ?>" >
											
										</div>
									</div>
								</div>
								<input type="hidden" id="selectedSchoolYear" value="<?php echo $this->data['school_year'];  ?>" >  
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
							<form method="post" id="insertReservation" action="<?php echo site_url(); ?>/Cashier/bed_reservation">
								<div class="row">
									
									<div class="col-md-4">
										<div class="form-line">
											<b class="black">Selected School Year:</b>
											<input type="text" id="schoolYearRes" name="school_year" readonly class="form-control InfoEnabled" value="<?php echo $this->data['school_year'];  ?>" >
											<input type="hidden" id="referenceNoRes" name="reference_no" readonly value="<?php echo $this->data['student_info'][0]['Reference_Number'];  ?>" >
											<input type="hidden" id="transactionType" name="transaction_type" value="RESERVATION">
										</div>
									</div>
								</div>
								<div class="row">
									<div class="col-md-4">
										<div class="form-line">
											<b class="red">*</b><b class="black">Payment Type:</b>
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
											<b class="red">*</b><b class="black">OR #:</b>
											<input id="orNoRes" name="or_no" type="text"  class="form-control InfoEnabled" >
											
										</div>
									</div>
								</div>
								<div class="row">
									<div class="col-md-4">
										<div class="form-line">
											<b class="black">Description:</b>
											<input id="descriptionRes" name="description" type="text"  class="form-control InfoEnabled" >
										</div>
									</div>
									<div class="col-md-4">
										<div class="form-line">
											<b class="red">*</b><b class="black">Amount:</b>
											<input id="amountRes" name="amount" type="number"  class="form-control InfoEnabled">
											
										</div>
									</div>
								</div>
							</form>
								<div class="row">
									<div class="col-md-4">
										<div class="form-line">
											<button class="btn btn-danger" id="bedReservationInsertButton"> Insert </button>
										</div>
									</div>
								</div>
							
							</div><!--end tabpanel reservation -->

							<div role="tabpanel" class="tab-pane fade" id="tab_matriculation">
							<form method="post" id="insertMatriculation" action="<?php echo site_url(); ?>/Cashier/bed_matriculation_input">
								<div class="row">
									
									<div class="col-md-4">
										<div class="form-line">
											<b class="black">Selected School Year:</b>
											<input type="text" id="schoolYear" name="school_year" readonly class="form-control InfoEnabled" value="<?php echo $this->data['school_year'];  ?>" >
											<input type="hidden" id="referenceNo" name="reference_no" readonly value="<?php echo $this->data['student_info'][0]['Reference_Number'];  ?>" >
										</div>
									</div>
								</div>
								<div class="row">
									<div class="col-md-4">
										<div class="form-line">
											<b class="black">Total Tuition:</b>
											<input type="text"  disabled class="form-control InfoEnabled" value="<?php echo $this->data['total_tuition_fee'];  ?>" >
										</div>
									</div>
								</div>
								<div class="row">
									<div class="col-md-4">
										<div class="form-line">
											<b class="black">Total Paid:</b>
											<input type="text"  disabled class="form-control InfoEnabled" value="<?php echo $this->data['total_payment'];  ?>" >
										</div>
									</div>
									<div class="col-md-4">
										<div class="form-line">
											<b class="black">Balance:</b>
											<input type="text"  disabled class="form-control InfoEnabled" value="<?php $balance = ($this->data['balance'] > 0) ? $this->data['balance'] : 0.00 ; echo $balance;  ?>" >
										</div>
									</div>
									<?php if($this->data['balance'] < 0): ?>
									<div class="col-md-4">
										<div class="form-line">
											<b class="black">Excess Payment:</b>
											<input type="text"  disabled class="form-control InfoEnabled" value="<?php echo ($this->data['balance'] * -1);  ?>" >
										</div>
									</div>
									<?php endif; ?>
								</div>

								<?php foreach ($this->data['fees_enrolled'] as $key => $fees_enrolled) { ?>
								<div class="row">
									<div class="col-md-4">
										<div class="form-line">
											<b class="black">Payment Scheme:</b>
											<input type="text"  disabled class="form-control InfoEnabled" value="<?php echo $this->data['fees_enrolled'][0]['Payment_Scheme'];  ?>" >
										</div>
									</div>
									
								</div>
								<div class="row">
									<div class="col-md-4">
										<div class="form-line">
											<b class="black">Initial Payment:</b>
											<input type="text"  disabled class="form-control InfoEnabled" value="<?php echo $fees_enrolled['Initial_Payment'];  ?>" >
										</div>
									</div>
									<div class="col-md-4">
										<div class="form-line">
											<b class="black">First Payment:</b>
											<input type="text"  disabled class="form-control InfoEnabled" value="<?php echo $fees_enrolled['First_Payment'];  ?>" >
											
										</div>
									</div>
									<div class="col-md-4">
										<div class="form-line">
											<b class="black">Second Payment:</b>
											<input type="text"  disabled class="form-control InfoEnabled" value="<?php echo $fees_enrolled['Second_Payment'];  ?>" >
										</div>
									</div>
								</div>
								<div class="row">
									<div class="col-md-4">
										<div class="form-line">
											<b class="black">Third Payment:</b>
											<input type="text"  disabled class="form-control InfoEnabled" value="<?php echo $fees_enrolled['Third_Payment'];  ?>" >
											
										</div>
									</div>
									<div class="col-md-4">
										<div class="form-line">
											<b class="black">Fourth Payment:</b>
											<input type="text"  disabled class="form-control InfoEnabled" value="<?php echo $fees_enrolled['Fourth_Payment'];  ?>" >
											
										</div>
									</div>
									<div class="col-md-4">
										<div class="form-line">
											<b class="black">Fifth Payment:</b>
											<input type="text"  disabled class="form-control InfoEnabled" value="<?php echo $fees_enrolled['Fifth_Payment'];  ?>" >
											
										</div>
									</div>
								</div>
								<div class="row">
									<div class="col-md-4">
										<div class="form-line">
											<b class="black">Sixth Payment:</b>
											<input type="text"  disabled class="form-control InfoEnabled" value="<?php echo $fees_enrolled['Sixth_Payment'];  ?>" >
											
										</div>
									</div>
									<div class="col-md-4">
										<div class="form-line">
											<b class="black">Seventh Payment:</b>
											<input type="text"  disabled class="form-control InfoEnabled" value="<?php echo $fees_enrolled['Seventh_Payment'];  ?>" >
											
										</div>
									</div>
									
								</div>
								<?php } ?>
								<?php if($this->data['balance'] > 0): ?>
								<div class="row">
									<div class="col-md-4">
										<div class="form-line">
											<b class="red">*</b><b class="black">Payment Type:</b>
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
											<b class="red">*</b><b class="black">OR #:</b>
											<input id="orNo" name="or_no" type="text"  class="form-control InfoEnabled" >
											
										</div>
									</div>
								</div>
								<div class="row">
									<div class="col-md-4">
										<div class="form-line">
											<b class="black">Description:</b>
											<input id="description" name="description" type="text"  class="form-control InfoEnabled" >
											<input type="hidden" id="transactionType" name="transaction_type" value="MATRICULATION">
										</div>
									</div>
									<div class="col-md-4">
										<div class="form-line">
											<b class="red">*</b><b class="black">Amount:</b>
											<input id="amount" name="amount" type="number"  class="form-control InfoEnabled">
											
										</div>
									</div>
								</div>
								<?php endif; ?>
							</form>
								<?php if($this->data['balance'] > 0): ?>
								<div class="row">
									<div class="col-md-4">
										<div class="form-line">
											<button class="btn btn-danger" id="bedMatriculationInsertButton"> Insert </button>
										</div>
									</div>
								</div>
								<?php endif; ?>
							</div><!--end tabpanel tab_matriculation -->

						</div><!--end tab-content -->

						<!--end Tab panes -->

						<?php } ?>
						<?php endif ?>


					</div> <!--end div Body-->         
                </div><!--end div card-->
            </div><!--end col-lg-12 col-md-12 col-sm-12 col-xs-12 -->
        </div><!-- end row clear fix-->
	</div>
		
		<input type="hidden" id="addressUrl" value="<?php print site_url().'/Cashier'; ?>" />


       
</section>




<input type="hidden" id="addressUrl" value="<?php echo site_url().'/cashier'; ?>"/>
<script type="text/javascript" src="<?php echo base_url(); ?>js/cashier.js"></script>



