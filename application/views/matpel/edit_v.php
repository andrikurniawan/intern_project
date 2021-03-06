<link rel="stylesheet" href="<?php echo base_url();?>css_rg/validation.css" type="text/css" media="all" />
<link rel="stylesheet" href="<?php echo base_url();?>css_rg/ui-lightness/jquery-ui-1.10.3.custom.min.css">
<script src="<?php echo base_url(); ?>js/jquery-migrate-1.2.1.min.js" type="text/javascript" charset="utf-8"></script>
<script src="<?php echo base_url(); ?>js/jquery.validationEngine.js" type="text/javascript" charset="utf-8"></script>
<script src="<?php echo base_url(); ?>js/jquery.validationEngine-en.js" type="text/javascript" charset="utf-8"></script>
<script src="<?php echo base_url(); ?>js/jquery-ui-1.10.3.custom.min.js" type="text/javascript" charset="utf-8"></script>
<script type="text/javascript">
$(document).ready(function(){
    $("#edit-kelas").validationEngine({
        ajaxFormValidation: false,
        ajaxFormValidationMethod: 'post'
    });
});
</script>
<!-- Message Error -->
<?php if ($this->session->flashdata('f_kelas')): ?>
    <div class="msg msg-ok boxwidth">
        <p><strong><?php echo $this->session->flashdata('f_kelas'); ?></strong></p>
    </div>
<?php endif; ?>

<!-- Box -->
<div class="box">
    <!-- Box Head -->
    <div class="box-head">
        <h2>Ubah Mata Pelajaran</h2>
    </div>
    <!-- End Box Head -->

    <form id="edit-kelas" action="<?php echo base_url();?>admin/matpel/edit_matpel_submit" method="post" >

        <!-- Form -->
        <div class="form">
            <p class="inline-field">
                <label>Matpel</label>
                <input id="matpel_label" type="text" class="field size5 validate[required]" name="matpel_label" value="<?php echo $matpel->matpel_title?>"/>
                <input id="matpel_id" type="hidden" name="matpel_id" value="<?php echo $matpel->matpel_id?>"/>
                <input id="pend_id" type="hidden" name="pend_id" value="<?php echo $matpel->jenjang_pendidikan_id?>"/>
            </p>
			<p class="inline-field">
                <label>Jenjang Pendidikan</label>
				<input id="pend_label" type="text" disabled name="pend_label" class="field size5" value="<?php echo $jenjang->jenjang_pendidikan_title;?>"/>
            </p>
        </div>
        <!-- End Form -->
        
        <!-- Form Buttons -->
        <div class="buttons">
            <input type="submit" class="button" value="submit" />
        </div>
        <!-- End Form Buttons -->
    </form>
</div>
<!-- End Box -->