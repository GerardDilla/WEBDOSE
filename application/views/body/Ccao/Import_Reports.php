


<section  id="top" class="content" style="background-color: #fff;">

	<!-- CONTENT GRID-->
	<div class="container-fluid">

		<!-- MODULE TITLE-->
		<div class="block-header">
			<h1> <i class="material-icons" style="font-size:100%">system_update_alt</i>Reports</h1>
		</div>
		<!--/ MODULE TITLE-->

  

   <div class="card">
            <div class="body">
            <form method="post" id="import_form" enctype="multipart/form-data" action="<?php echo base_url(); ?>index.php/Ccao/import">
                <p><label>Select Excel File</label>
                <input type="file" name="file" id="file" required accept=".xls, .xlsx" /></p>
                <br />
                <input type="submit" name="import" value="Import" class="btn btn-info" />
                 </form>
                <br><br>
                
        </div>


	</div>
	<!--/CONTENT GRID-->

</section>


	
<script type="text/javascript" src="<?php echo base_url(); ?>node_modules/simple-pagination.js/jquery.simplePagination.js"></script>
<link type="text/css" rel="stylesheet" href="<?php echo base_url(); ?>node_modules/simple-pagination.js/simplePagination.css"/>
<script type="text/javascript" src="<?php echo base_url(); ?>js/advising.js"></script>




