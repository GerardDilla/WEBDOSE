<!-- Sweet Alert Css -->
<link href="<?php echo base_url(); ?>plugins/multi-select/css/multi-select.css" rel="stylesheet" />

<section  id="top" class="content" style="background-color: #fff;">
	<!-- CONTENT GRID-->
    <div class="container-fluid">
	
        <div class="row clearfix">
			<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">

                <div class="card">
					<div class="header">
						<h2 class="red"> User Accessibility</h2>     
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
                        
                        
                        <div class="col-md-4">
                            <div class="input-group">
                                <span class="input-group-addon">
										<i class="material-icons">person</i>
                                </span>
                                
                                <select class="form-control show-tick"  id="searchBy">
                                    <option value="username"> Username </option>
                                    <option value="name"> Name </option>
									<option value="department"> Department </option>
									<option value="position"> Position </option>
                                </select>
                            </div>
                        </div>
						
						<div class="row">
							<div class="col-md-5">
								<div class="input-group">
									
									<div class="form-line">
										<input type="text" autofocus id="userSearchKey"  class="form-control InfoEnabled"  >
									</div>
									
								</div>
							</div>
							

							<div class="col-md-2">
								<button class="btn btn-danger btn-lg" id="selectStudentSubmit" name="" type="submit" onclick="searchUser()" autofocus>SEARCH</button>
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
										<th>Username</th>
										<th>Full Name</th>
										<th>Position</th>
										<th>Department</th>
										<th>Status</th>
										<th>Action</th>
									</tr>
								</thead>
								<tbody id="userSearchTable">
									<tr>
										<td colspan="10" align="center">No Data</td>
									</tr>
								</tbody>
							</table>
						</div>
						<br>
						<div id="userSearchPagination"></div>
						

						
						
                
                    </div><!--end div Body-->
                </div><!--end div card-->
            </div><!--end col-lg-12 col-md-12 col-sm-12 col-xs-12 -->
        

        </div><!-- end row clear fix-->
		
		<?php if($this->data['user_data']): ?>
        <div class="row clearfix">   
            
            
            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">

                <div class="card">
					<div class="header">
						<h2 class="red"> User Accessibility</h2>     
					</div>  
                    
                    
                
					<div class="body"><!--start div Body-->

						<h3 id="actionNotification" class="col-green"></h3>
						<h3 id="actionNotificationError" class="col-red"></h3>		
						
						<br>
						<div class="row">
							<div class="col-md-4">
								<div class="form-line">
									<b class="black">Username</b>
									<input type="text" class="form-control" disabled value="<?php echo $this->user->get_username();  ?>">
									<input type="hidden" id="userId" value="<?php echo $this->user->get_user_id(); ?>" >
								</div>
							</div>
							<div class="col-md-4">
								<div class="form-line">
									<b class="black">Name:</b>
									<input type="text"   class="form-control" disabled value="<?php echo $this->user->get_name();  ?>">
								</div>
							</div>
						</div>
                    
                        <select class="ms" multiple="multiple" id="accessTable" name="my-select[]">
							<?php foreach ($this->user_roles->get_array_roles() as $key => $role) {?>
								<?php if($role['selected'] === 1): ?>
									<option value='<?php print $role['parent_module_id']; ?>' selected><?php print $role['parent_alias']; ?> </option>
								<?php else: ?>
									<option value='<?php print $role['parent_module_id']; ?>'><?php print $role['parent_alias']; ?> </option>
								<?php endif; ?>
                            
							<?php } ?>
						</select>
						<br>
						<div class="row">
							<div class="col-md-2">
								<button class="btn btn-danger btn-lg" id="buttonRoleSubmit" disabled type="submit" onclick="submitRoleChange()" autofocus>Submit</button>
							</div>
						</div>
                            
                    </div> <!--end div Body-->     
                </div><!--end div card-->

            </div> <!--end col-lg-12 col-md-12 col-sm-12 col-xs-12 -->
		</div><!-- end row clear fix-->
		<?php endif; ?>

       
    </div><!-- end container-fluid-->
</section>

<script type="text/javascript" src="<?php echo base_url(); ?>plugins/multi-select/js/jquery.multi-select.js"></script>
<input type="hidden" id="addressUrl" value="<?php echo site_url().'/UserAccessibility'; ?>"/>
<script type="text/javascript" src="<?php echo base_url(); ?>js/userAccessibility.js"></script>