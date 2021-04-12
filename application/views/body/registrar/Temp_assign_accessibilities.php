
	
	
	
	<section class="content" style="background-color: #fff;">
		<div class="container-fluid" style="padding-top: 20px;">
		<h1>AcC0uNt AcTivatorxz</h1>
		
		<form action="<?php echo base_url(); ?>index.php/Admin/temp_assign_process" method="post">
		<input type="text" name="access_type_old" placeholder="Place Access type of old table (Users)">
		<hr>
		<?php 
		
		$options = array(
			'0'=> 'SELECT ACCESSIBILITY'
		);
		foreach($this->data['accessibilities'] AS $row){

			$options[$row['parent_module_id']] = $row['parent_module_name'];

		}
		

		echo form_dropdown('access_type_new', $options);
		
		?>
		<hr>
		<button type="submit" name="submit_access" value="1">Submit</button>
		<hr>
		</form>


		</div>
	</section>
