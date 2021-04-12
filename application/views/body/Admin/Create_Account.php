
<section  id="top" class="content" >
	<div class="container-fluid"><!-- CONTENT GRID-->

		<!-- MODULE TITLE-->
		<div class="block-header">
			<h1> <i class="material-icons" style="font-size:100%">system_update_alt</i>Account Creation</h1>
		</div>
		<!--/ MODULE TITLE-->

  
         <!--/ CARD -->
        <div class="card">
             <div class="body">
                <div class="row"> 
                    <div class="col-md-12">
                        <div class="pull-right">
                            <button class="btn btn-lg btn-success" data-toggle="modal" data-target="#defaultModal">Add Account</button>
                            
                        </div>  
                    </div>  
                    <div class="col-md-4">
                        <form id="sign_up" method="POST">
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
                                
                        </form>
                    </div>
                    <div class="col-md-8">
                        <div class="table panel panel-danger">
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
                        </div>   
                    </div>
                 </div>
                    



             </div><!--/ CARD  BODY-->
        </div><!--/ CARD -->
	</div><!--/CONTENT GRID-->	
</section>




     <!-- CREATE ACCOUNT MODAL -->
     <div class="modal fade" id="defaultModal" tabindex="-1"  role="dialog">
                <div class="modal-dialog modal-lg" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h2 class="modal-title" id="defaultModalLabel">Account Creation</h2>
                        </div>
                        <div class="modal-body" style="padding-right: 100px; padding-left: 100px;">
                                <form id="sign_up" method="POST">
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
                                        
                                </form>
    
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-link waves-effect">SAVE CHANGES</button>
                            <button type="button" class="btn btn-link waves-effect" data-dismiss="modal">CLOSE</button>
                        </div>
                    </div>
                </div>
            </div>

	


