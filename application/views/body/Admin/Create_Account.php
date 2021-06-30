<link href="<?php echo base_url(); ?>plugins/waitme/waitMe.min.css" rel="stylesheet">

<style>
#usertable td{
    overflow-y:auto;
}

.is-invalid input.form-control{
    /* border:2px solid maroon; */
    border-bottom:1px solid maroon;
}
.is-invalid .bootstrap-select{
    border-bottom: 1px solid maroon !important;
}
.invalid-feedback{
    color:maroon;
    font-weight:bold;
    display:none;
}
.is-invalid .invalid-feedback{
    display:inline-block;
}
.col-lg-6{
    width:50%!important;
}
.col-lg-9{
    width:80%!important;
}
.col-lg-3{
    width:20%!important;
}
.flex-center{
    display: flex;
    align-items: center;
    justify-content: center;
}
.accesiblity-label{
    margin-top:12px;
    color:black;
    font-weight:bold;
}
</style>
<section  id="top" class="content" >
	<div class="container-fluid"><!-- CONTENT GRID-->

		<!-- MODULE TITLE-->
		<div class="block-header">
			<h1> <i class="material-icons" style="font-size:100%">system_update_alt</i>Account Creation / Update</h1>
		</div>
		<!--/ MODULE TITLE-->

  
         <!--/ CARD -->
        <div class="card">
             <div class="body">
                <div class="row"> 
                    <div class="col-md-12">
                        <div class="pull-right">
                        <!-- &nbsp;<button Class="btn btn-danger btn-lg">Remove Account </button> -->
                            <button class="btn btn-lg btn-success" data-toggle="modal" data-target="#defaultModal">Add Account</button>
                            
                        </div>  
                    </div>
                    <div class="table panel panel-danger col-md-12">
                            <table class="table table-bordered" id="usertable">
                                <thead>
                                    <tr class="text-center danger">
                                        <th class="text-center" width="10%">User ID</th>
                                        <th class="text-center" width="35%">Name</th>
                                        <th class="text-center" width="25%">Username</th>
                                        <th class="text-center" width="15%">Status</th>
                                        <th class="text-center" width="15%">Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <!-- <tr>
                                        <td class="text-center">1</td>
                                        <td class="text-center">Oneal </td>
                                        <td class="text-center">Username</th>
                                        <th class="text-center">1</th>
                                        <th class="text-center">
                                            <button type="button" class="btn btn-info" onclick="openModal('1')">Update </button>
                                        </th>
                                    </tr> -->
                                </tbody>
                            </table>
                        </div>     
                    <div class="col-md-4">
                        <!-- <form id="sign_up" method="POST">
                            <div class="msg"></div>
                                <div class="input-group">
                                        <span class="input-group-addon">
                                            <i class="material-icons">format_list_numbered</i>
                                        </span>
                                        <div class="form-line">
                                            <input type="text" class="form-control" name="userid" placeholder="User ID:" required autofocus>
                                        </div>
                                </div>
                                <div class="input-group">
                                        <span class="input-group-addon">
                                            <i class="material-icons">person</i>
                                        </span>
                                        <div class="form-line">
                                            <input type="text" class="form-control" name="fullname" placeholder="Full Name:" required>
                                        </div>
                                </div>
                                <div class="input-group">
                                        <span class="input-group-addon">
                                            <i class="material-icons">account_box</i>
                                        </span>
                                        <div class="form-line">
                                            <input type="text" class="form-control" name="username"  placeholder="Username:" required>
                                        </div>
                                </div>
                                <div class="input-group">
                                        <span class="input-group-addon">
                                            <i class="material-icons">group_work</i>
                                        </span>
                                        <div class="form-line">
                                            <input type="text" class="form-control" name="department"  placeholder="Department: " required>
                                        </div>
                                </div>
                                <div class="input-group">
                                        <span class="input-group-addon">
                                            <i class="material-icons">grade</i>
                                        </span>
                                        <div class="form-line">
                                            <input type="text" class="form-control" name="position"  placeholder="Position: " required>
                                        </div>
                                </div>
                                <div class="input-group">
                                        <span class="input-group-addon">
                                            <i class="material-icons">lock</i>
                                        </span>
                                        <div class="form-line">
                                            <input type="number" class="form-control" name="position"  placeholder="Password: " required>
                                        </div>
                                </div>
                                <div class="input-group">
                                        <span class="input-group-addon">
                                            <i class="material-icons">account_balance</i>
                                        </span>
                                        <div class="form-line">
                                            <input type="text" class="form-control" name="Access Type"  placeholder="Position: " required>
                                        </div>
                                </div>
                                
                        </form> -->
                    </div>
                    <div class="col-md-8">
                        <!-- <div class="table panel panel-danger">
                            <table class="table table-bordered">
                                <thead>
                                    <tr class="text-center danger">
                                        <th class="text-center">User ID</th>
                                        <th class="text-center">Name</th>
                                        <th class="text-center">Username</th>
                                        <th class="text-center">Valid</th>
                                        <th class="text-center">Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr>
                                        <td class="text-center">1</td>
                                        <td class="text-center">Oneal </td>
                                        <td class="text-center">Username</th>
                                        <th class="text-center">1</th>
                                        <th class="text-center">
                                            <button Class="btn btn-danger">Remove Account </button>
                                        </th>
                                    </tr>
                                </tbody>
                            </table>
                        </div>    -->
                    </div>
                 </div>
                    



             </div><!--/ CARD  BODY-->
        </div><!--/ CARD -->
	</div><!--/CONTENT GRID-->	
</section>



    <!-- UPDATE ACCOUNT MODAL -->
    <div class="modal fade" id="updateAccountModal" tabindex="-1"  role="dialog">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h1 class="modal-title" style="text-align:center;" id="defaultModalLabel">Update User Account</h1>
                </div>
                <div class="modal-body" style="padding-right: 100px; padding-left: 100px;">
                        <form id="update_account" action="<?= base_url('index.php/UserAccessibility/updateAccountSubmit');?>" method="POST">
                            <div class="msg"></div>
                                <div class="col-lg-3 flex-center">
                                    <label class="form-label accesiblity-label">User ID</label>
                                </div>
                                <div class="col-lg-9 input-group useridUPDATE-div">
                                        <span class="input-group-addon">
                                            <i class="material-icons">format_list_numbered</i>
                                        </span>
                                        <div class="form-line"> 
                                            <!-- <label class="form-label">User ID</label> -->
                                            <input type="text" class="form-control" name="useridUPDATE" id="useridUPDATE" placeholder="User ID:" readonly autofocus>
                                        </div>
                                        <div class="invalid-feedback">
                                            This field is required!
                                        </div>
                                </div>
                                <div class="col-lg-3 flex-center">
                                    <label class="form-label accesiblity-label">Full Name</label>
                                </div>
                                <div class="col-lg-9 input-group fullnameUPDATE-div">
                                        <span class="input-group-addon">
                                            <i class="material-icons">person</i>
                                        </span>
                                        <div class="form-line">
                                            <!-- <label class="form-label">Full Name</label> -->
                                            <input type="text" class="form-control" name="fullnameUPDATE" id="fullnameUPDATE" placeholder="Full Name:" required>
                                        </div>
                                        <div class="invalid-feedback">
                                            This field is required!
                                        </div>
                                </div>
                                <div class="col-lg-3 flex-center">
                                    <label class="form-label accesiblity-label">Username</label>
                                </div>
                                <div class="col-lg-9 input-group usernameUPDATE-div">
                                        <span class="input-group-addon">
                                            <i class="material-icons">account_box</i>
                                        </span>
                                        <div class="form-line">
                                            <!-- <label class="form-label">Username</label> -->
                                            <input type="text" class="form-control" name="usernameUPDATE"  id="usernameUPDATE" placeholder="Username:" required>
                                        </div>
                                        <div class="invalid-feedback">
                                            This field is required!
                                        </div>
                                </div>
                                <div class="col-lg-3 flex-center">
                                    <label class="form-label accesiblity-label">Department</label>
                                </div>
                                <div class="col-lg-9 input-group departmentUPDATE-div">
                                        <span class="input-group-addon">
                                            <i class="material-icons">group_work</i>
                                        </span>
                                        <div class="form-line">
                                            <!-- <label class="form-label">Department</label> -->
                                            <input type="text" class="form-control" name="departmentUPDATE" id="departmentUPDATE"  placeholder="Department: " required>
                                        </div>
                                </div>
                                <div class="col-lg-3 flex-center">
                                    <label class="form-label accesiblity-label">Password</label>
                                </div>
                                <div class="col-lg-9 input-group positionUPDATE-div">
                                        <span class="input-group-addon">
                                            <i class="material-icons">grade</i>
                                        </span>
                                        <div class="form-line">
                                            <!-- <label class="form-label">Position</label> -->
                                            <input type="text" class="form-control" name="positionUPDATE" id="positionUPDATE" placeholder="Position: " required>
                                        </div>
                                        <div class="invalid-feedback">
                                            This field is required!
                                        </div>
                                </div>
                                <div class="col-lg-3 flex-center">
                                    <label class="form-label accesiblity-label">Password</label>
                                </div>
                                <div class="col-lg-9 input-group passwordUPDATE-div">
                                        <span class="input-group-addon">
                                            <i class="material-icons">lock</i>
                                        </span>
                                        <div class="form-line">
                                            <label class="form-label">(NOTE:Leave this empty if you dont need to change password.)</label>
                                            <input type="password" class="form-control" name="passwordUPDATE" id="passwordUPDATE" placeholder="Password: ">
                                        </div>
                                        <div class="invalid-feedback">
                                            This field is required!
                                        </div>
                                </div>
                                <!-- <div class="input-group">
                                        <span class="input-group-addon">
                                            <i class="material-icons">account_balance</i>
                                        </span>
                                        <div class="form-line">
                                            <input type="text" class="form-control" name="Access Type"  placeholder="Position: " required>
                                        </div>
                                </div> -->
                                <div class="col-lg-3 flex-center">
                                    <label class="form-label accesiblity-label">Access Type</label>
                                </div>
                                <div class="col-lg-9 input-group accessTypeUPDATE-div">
                                    <div class="input-group">
                                        <span class="input-group-addon">
                                                <i class="material-icons">accessibility</i>
                                        </span>
                                        <!-- <label class="form-label">Access Type</label> -->
                                        <select class="form-control show-tick" name="accessTypeUPDATE" id="accessTypeUPDATE">
                                            <option value=""> Access Type </option>
                                            <option value="Admin"> Admin </option>
                                            <option value="Staff"> Staff </option>
                                            <option value="OJT"> OJT </option>
                                        </select>
                                    </div>
                                    <div class="invalid-feedback">
                                        This field is required!
                                    </div>
                                </div>
                                <div class="col-lg-3 flex-center">
                                    <label class="form-label accesiblity-label">Account Status</label>
                                </div>
                                <div class="col-lg-9 input-group tabValidUPDATE-div">
                                    <span class="input-group-addon">
                                            <i class="material-icons">fact_check</i>
                                    </span>
                                    <!-- <label class="form-label">If Valid</label> -->
                                    <select class="form-control show-tick" name="tabValidUPDATE"  id="tabValidUPDATE" required>
                                        <!-- <option value=""> Valid </option> -->
                                        <!-- <option value="1"> Valid </option>
                                        <option value="0"> NOT Valid </option> -->
                                        <option value="1"> Activate </option>
                                        <option value="0"> Deactivate </option>
                                    </select>
                                    <div class="invalid-feedback">
                                        This field is required!
                                    </div>
                                </div>
                                
                        

                </div>
                </form>
                <div class="modal-footer">
                    <button type="button" id="saveChangesUpdate" class="btn btn-link waves-effect">SAVE CHANGES</button>
                    <button type="button" class="btn btn-link waves-effect" data-dismiss="modal">CLOSE</button>
                </div>
            </div>
        </div>
    </div>
     <!-- CREATE ACCOUNT MODAL -->
     <div class="modal fade" id="defaultModal" tabindex="-1"  role="dialog">
                <div class="modal-dialog modal-lg" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h1 class="modal-title" style="text-align:center;" id="defaultModalLabel">Account Creation</h1>
                        </div>
                        <div class="modal-body" style="padding-right: 100px; padding-left: 100px;">
                                <form id="account_creation" action="<?= base_url('index.php/UserAccessibility/createAccountSubmit');?>" method="POST">
                                    <div class="msg"></div>
                                        <!-- <div class="input-group">
                                                <span class="input-group-addon">
                                                    <i class="material-icons">format_list_numbered</i>
                                                </span>
                                                <div class="form-line">
                                                    <input type="text" class="form-control" name="userid" placeholder="User ID:" disabled autofocus>
                                                </div>
                                        </div> -->
                                        <div class="col-md-12 row">
                                            <div class="col-lg-3 flex-center">
                                                <label class="form-label accesiblity-label">Full Name</label>
                                            </div>
                                            <div class="col-lg-9 input-group fullname-div">
                                                    <span class="input-group-addon">
                                                        <i class="material-icons">person</i>
                                                    </span>
                                                    <div class="form-line">
                                                        <input type="text" class="form-control" name="fullname" id="fullname" placeholder="Full Name:" required>
                                                    </div>
                                                    <div class="invalid-feedback">
                                                        This field is required!
                                                    </div>
                                            </div>
                                            <div class="col-lg-3 flex-center">
                                                <label class="form-label accesiblity-label">Username</label>
                                            </div>
                                            <div class="col-lg-9 input-group username-div">
                                                    <span class="input-group-addon">
                                                        <i class="material-icons">account_box</i>
                                                    </span>
                                                    <div class="form-line">
                                                        <!-- <label class="form-label">Username</label> -->
                                                        <input type="text" class="form-control" name="username"  id="username" placeholder="Username:" required>
                                                    </div>
                                                    <div class="invalid-feedback">
                                                        This field is required!
                                                    </div>
                                            </div>
                                            <div class="col-lg-3 flex-center">
                                                <label class="form-label accesiblity-label">Department</label>
                                            </div>
                                            <div class="col-lg-9 input-group department-div">
                                                    <span class="input-group-addon">
                                                        <i class="material-icons">group_work</i>
                                                    </span>
                                                    <div class="form-line">
                                                        <!-- <label class="form-label">Department</label> -->
                                                        <input type="text" class="form-control" name="department"  id="department" placeholder="Department: " required>
                                                    </div>
                                                    <div class="invalid-feedback">
                                                        This field is required!
                                                    </div>
                                            </div>
                                            <div class="col-lg-3 flex-center">
                                                <label class="form-label accesiblity-label">Position</label>
                                            </div>
                                            <div class="col-lg-9 input-group position-div">
                                                    <span class="input-group-addon">
                                                        <i class="material-icons">grade</i>
                                                    </span>
                                                    <div class="form-line">
                                                        <!-- <label class="form-label">Position</label> -->
                                                        <input type="text" class="form-control" name="position"  id="position" placeholder="Position: " required>
                                                    </div>
                                                    <div class="invalid-feedback">
                                                        This field is required!
                                                    </div>
                                            </div>
                                            <div class="col-lg-3 flex-center">
                                                <label class="form-label accesiblity-label">Password</label>
                                            </div>
                                            <div class="col-lg-9 input-group password-div">
                                                    <span class="input-group-addon">
                                                        <i class="material-icons">lock</i>
                                                    </span>
                                                    <div class="form-line">
                                                        <!-- <label class="form-label">Password</label> -->
                                                        <input type="password" class="form-control" name="password" id="password" placeholder="Password: ">
                                                    </div>
                                                    <div class="invalid-feedback">
                                                        This field is required!
                                                    </div>
                                            </div>
                                            <!-- <div class="input-group">
                                                    <span class="input-group-addon">
                                                        <i class="material-icons">account_balance</i>
                                                    </span>
                                                    <div class="form-line">
                                                        <input type="text" class="form-control" name="Access Type"  placeholder="Position: " required>
                                                    </div>
                                            </div> -->
                                            <div class="col-lg-3 flex-center">
                                                <label class="form-label accesiblity-label">Password</label>
                                            </div>
                                            <div class="col-lg-9 input-group accessType-div">
                                                <div class="input-group">
                                                    <span class="input-group-addon">
                                                            <i class="material-icons">accessibility</i>
                                                    </span>
                                                    <!-- <label class="form-label">Access Type</label> -->
                                                    <select class="form-control show-tick" name="accessType" id="accessType" required>
                                                        <option value=""> Access Type </option>
                                                        <option value="Admin"> Admin </option>
                                                        <option value="Staff"> Staff </option>
                                                        <option value="OJT"> OJT </option>
                                                    </select>
                                                </div>
                                                <div class="invalid-feedback" style="text-indent:30px">
                                                    This field is required!
                                                </div>
                                            </div>
                                        </div>
                               
    
                        </div>
                        </form>
                        <div class="modal-footer">
                            <button type="button" id="saveChanges" class="btn btn-link waves-effect">SAVE CHANGES</button>
                            <button type="button" class="btn btn-link waves-effect" data-dismiss="modal">CLOSE</button>
                        </div>
                    </div>
                </div>
            </div>
            <script type="text/javascript" src="<?php echo base_url(); ?>plugins/waitme/waitMe.min.js"></script>
            <script type="text/javascript" src="<?php echo base_url(); ?>js/createAccount.js"></script>
            <script>
            // $('#myModal').modal('show')
            $('body').waitMe({
                effect : 'win8',
                text : '',
                bg : 'rgba(255,255,255,0.7)',
                color : 'maroon',
                maxSize : '',
                waitTime : -1,
                textPos : 'vertical',
                fontSize : '',
                source : '',
                onClose : function() {}
            });
            // iziToast.error({
            //     title: 'Error: ',
            //     message: 'Error',
            //     position: 'topCenter',
            // })
            // $('#usertable').DataTable({
            //     "ordering": true,
            //     "bPaginate": true,
            //     "bLengthChange": false,
            //     "responsive": false
            // });
            async function initUserTable(data){
                var html = "";
                data.forEach(row => {
                    // console.log(row);
                    html += `<tr>
                                <td class="text-center">${row.User_FullName}</td>
                                <td class="text-center">${row.User_Department}</td>
                                <td class="text-center">${row.UserName}</th>
                                <th class="text-center">${row.tabValid==0?'not active':'active'}</th>
                                <th class="text-center">
                                    <button type="button" class="btn btn-info" onclick="openModal('${row.User_ID}')">Update </button>
                                </th>
                            </tr>`
                })
                $('#usertable').append(html);
                $('#usertable').DataTable({
                    "ordering": true,
                    "bPaginate": true,
                    "bLengthChange": false,
                    "responsive": false
                });
            }
            async function hideWaitmeWhenFinished(){
                $('body').waitMe('hide');
            }
            getUserTable().then(result=>{
                initUserTable(result);
                hideWaitmeWhenFinished();
                // result.forEach(row => {
                //     console.log(row);
                // })
            });
            async function getUserTable(){
                return new Promise((resolve,reject)=>{
                    $.ajax({
                        url: "<?php echo base_url(); ?>index.php/UserAccessibility/getUserTable",
                        method: 'get',
                        dataType: 'json',
                        success: function(response) {
                            // console.log(response)
                            resolve(response);
                        },
                        error: function(response) {

                        }
                    });
                })
            }
            // s
            function openModal(id){
                $('#updateAccountModal').modal('show');
                $('input[name=useridUPDATE]').val('');
                $('input[name=fullnameUPDATE]').val('');
                $('input[name=usernameUPDATE]').val('');
                $('input[name=departmentUPDATE]').val('');
                $('input[name=positionUPDATE]').val('');
                $('input[name=passwordUPDATE]').val('');
                $('select[name=accessTypeUPDATE]').val('');
                $('select[name=tabValidUPDATE]').val('');
                $.ajax({
                    url: "<?php echo base_url(); ?>index.php/UserAccessibility/getUserInfo",
                    method: 'post',
                    dataType: 'json',
                    data:{
                        id:id
                    },
                    success: function(response) {
                        console.log(response)
                        // console.log()
                        $('input[name=useridUPDATE]').val(response.User_ID);
                        $('input[name=fullnameUPDATE]').val(response.User_FullName);
                        $('input[name=usernameUPDATE]').val(response.UserName);
                        $('input[name=departmentUPDATE]').val(response.User_Department);
                        $('input[name=positionUPDATE]').val(response.User_Position);
                        // $('input[name=passwordUPDATE]').val(response.Password);
                        // $('select[name=accessTypeUPDATE]').val(response.AccessType);
                        // $('select[name=tabValidUPDATE]').val(response.tabValid);
                        // resolve(`https://drive.google.com/uc?export=view&id=${response}`);
                        // storagedata
                        // $('select[name=accessTypeUPDATE]').val('Admin');
                        // alert(response.AccessType)
                        $('select[name=accessTypeUPDATE]').selectpicker('val', response.AccessType);
                        $('select[name=tabValidUPDATE]').selectpicker('val', response.tabValid);
                        // $(`select[name=accessTypeUPDATE] option[value=${response.AccessType}]`).attr('selected',true);
                    },
                    error: function(response) {
                        // reject(response);
                    }
                });
            }
            
            </script>
            <?php
                echo '<script>';
                if (!empty($this->session->flashdata('error'))) {
                    echo "iziToast.error({
                                title: 'Error: ',
                                message: '" . $this->session->flashdata('error') . "',
                                position: 'topCenter',
                            });";
                    $this->session->set_flashdata('error', '');
                } else if (!empty($this->session->flashdata('success'))) {
                    echo "iziToast.success({
                            title: 'Success: ',
                            message: '" . $this->session->flashdata('success') . "',
                            position: 'topCenter',
                        });";
                    // echo "OnloadImage();";
                    $this->session->set_flashdata('success', '');
                }
                echo '</script>';
            ?>

	


