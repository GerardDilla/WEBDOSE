<style>
    .table-head{
        text-align:center;
        font-weight:bold;
        background:rgba(0,0,0,.05);
    }
</style>
<section id="top" class="content">
    <div class="container-fluid" id="base_url" data-baseurl="<?php echo base_url(); ?>">
        <div class="row clearfix">
            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                <div class="card">
                    <div class="header">
                        <h3>
                            <?= $title ?>
                        </h3>
                    </div>
                    <div class="body">
                        <div class="row">
                            <div class="col-md-12" align="right">
                                <button class="btn btn-default" onclick="openModal('')">Create New Question</button>
                            </div>
                            <div class="col-md-12">
                                <table class="table" width="100%">
                                    <thead>
                                        <tr>
                                            <th width="8%">no.</th>
                                            <th>Question</th>
                                            <th width="20%">Question Type</th>
                                            <th width="10%">Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php
                                        $row_header = "";
                                        $count = 0;
                                        foreach($area_description as $ad){
                                        if($ad['category_name']!=$row_header){
                                            $count = 0;
                                            $row_header = $ad['category_name'];
                                            echo '<tr class="table-head">';
                                            echo '<td colspan="4">'.$ad['category_name'].'</td>';
                                            echo '</tr>';
                                        }
                                        ++$count;
                                            ?>
                                        <tr>
                                            <td><?= $count ?></td>
                                            <td><?= $ad['question_name'] ?></td>
                                            <td><?= $ad['eval_type'] ?></td>
                                            <td><button class="btn btn-info btn-sm" onclick="openModal('<?= $ad['eval_id'] ?>')">Update</button></td>
                                        </tr>
                                        <?php
                                        }
                                            ?>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>                           
</section>
<div class="modal fade" id="sateFormModal" tabindex="1" role="dialog" aria-labelledby="myModalLabel">
    <div class="modal-dialog modal-dialog-scrollable  modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title" id="modalTitle"></h4>
                <!-- <button type="button" class="close btn btn-sm btn-default" >
                Close
                </button> -->
            </div>
        <form method="post" action="<?= base_url('index.php/EvaluationForm/updateSATEForm')?>">
        <div class="modal-body row">
            <input type="hidden" name="chosen_id" value="">
            <div class="col-md-12">
                <label class="input-label">Question Name</label>
                <textarea class="form-control is-invalid" name="name" value="" required></textarea>
            </div>
            <div class="col-md-12">
                <label class="input-label">Area</label>
                <select type="text" class="form-control show-tick" name="area">
                    <?php
                    foreach($area as $a_type){
                        ?>
                        <option value="<?= $a_type['id'] ?>"><?= $a_type['category_name'] ?></option>
                    <?php
                    }
                        ?>
                </select>
            </div>
            <div class="col-md-12">
                <label class="input-label">Evaluation Type</label>
                <select class="form-control show-tick" name="type">
                    <?php
                    foreach($eval_type as $e_type){
                        ?>
                        <option value="<?= $e_type['id'] ?>"><?= $e_type['eval_type'] ?></option>
                    <?php
                    }
                        ?>
                </select>
            </div>
            <div class="col-md-12">
                <label class="input-label">Status</label>
                <select class="form-control" name="question_status">
                    <option value="1">Active</option>
                    <option value="0">Inactive</option>
                </select>
            </div>
            <!-- <div class="col-md-12">
                <input style="text-align:right;" type="text" id="proofOfPaymentAmount" class="form-control number-format" value="" tabindex="15">
            </div>
            <div class="col-md-12">
                <label class="input-label"></label>
                <input type="text" class="form-control" name="pp_school_year" value="" readonly>
            </div>
            <div class="col-md-12">
                <label class="input-label"></label>
                <input type="text" class="form-control" name="pp_semester" value="" readonly>
            </div>    -->
        </div>
        </form>
        <div class="modal-footer" align="right">
            <button class="btn btn-danger" id="formSubmit">Submit</button>
        <!-- <button class="btn btn-default" data-dismiss="modal" aria-label="Close">Close</button><button type="button" class="btn btn-danger" onclick="rejectProofofPayment()">Reject</button><button type="button" class="btn btn-warning" onclick="clarifyProofOfPayment()">Clarify</button><button class="btn btn-info" onclick="verifyProofofPayment()">Submit</button> -->
        </div>
    </div>
</div>
<script>
    $('#formSubmit').on('click',function(){
        $('body').waitMe({
            effect : 'stretch',
            text : 'Please wait...',
            bg : 'rgba(255,255,255,0.7)',
            color : '#cc0000',
            maxSize : '',
            waitTime : -1,
            textPos : 'vertical',
            fontSize : '',
            source : '',
            onClose : function() {}
        });
        $('#sateFormModal form').submit();
    })
    function openModal(id){
        $('.form-control').val('');
        $('input[name=chosen_id]').val(id);
        $('select[name=question_status] option').attr('selected',false)
        if(id!=""){
            $('#modalTitle').text('Update SATE Question');
            $.ajax({
                url:'<?= base_url('index.php/EvaluationForm/getAreaDescriptionInfo') ?>',
                method:'POST',
                data:{
                    id:id
                },
                dataType:'JSON',
                success:function(response){
                    console.log(response)
                    alert(response.active_question)
                    $('textarea[name=name]').val(response.question_name);
                    $('select[name=type]').val(response.evaluation_type_id);
                    $('select[name=area]').val(response.area_id);
                    $('select[name=question_status]').val(response.active_question)
                    // $(`select[name=question_status] option[value=${response.active_question}]`).prop('selected',true)
                },
                error:function(response){

                }
            })
        }
        else{
            $('#modalTitle').text('Create new SATE Question');
        }
        $('#sateFormModal').modal('show');
    }
</script>
<?php
echo '<script>';
if (!empty($this->session->flashdata('error'))) {
	echo "iziToast.error({
          title: 'Error: ',
          message: '" . $this->session->flashdata('error') . "',
          position: 'topRight'
        });";
	$this->session->set_flashdata('error', '');
} else if (!empty($this->session->flashdata('success'))) {
	echo "iziToast.success({
          title: 'Success: ',
          message: '" . $this->session->flashdata('success') . "',
          position: 'topRight'
        });";
	$this->session->set_flashdata('success', '');
}
echo '</script>'; 
?>