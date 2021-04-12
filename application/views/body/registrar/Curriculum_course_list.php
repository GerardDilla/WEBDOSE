<section class="content" style="background-color: #fff;">
	<div class="container-fluid">
		<div class="block-header">
			<h1>Course</h1>
		</div><!-- Basic Example -->
		<br>

                              
          <div class="body table-responsive" style="overflow-y: auto; height: 500px;">
              <table class="table table-condensed">
                    <thead>
                        <tr class="danger">
                            <th>#</th>
                            <th class="text-center">Course Code</th>
                            <th class="text-center">Course Title</th>
                             <th class="text-center">Course Semester</th>
                         </tr>
                    </thead>
                     <tbody>
                            <?php 
                            $count = 1;
                            foreach($this->data['curriculum_course_list']->result_array()  as $row)  {  
                            ?>
                                 <tr>
                                   <td><?php echo $count ?></td>
                                   <td class="text-center"><?php echo $row['Course_Code'] ?></td>
                                   <td class="text-center"><?php echo $row['Course_Title'] ?></td>
                                   <td class="text-center"><?php echo $row['Curriculum_Semester'] ?></td>

                                </tr>
                            <?php $count = $count + 1;  } ?>
                                
                       </tbody>
                </table>
            </div>

		
		    
	</div>
</section>


 