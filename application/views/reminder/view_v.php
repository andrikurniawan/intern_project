<link rel="stylesheet" href="<?php echo base_url();?>css_rg/validation.css" type="text/css" media="all" />
<link rel="stylesheet" href="<?php echo base_url();?>css_rg/ui-lightness/jquery-ui-1.10.3.custom.min.css">
<script src="<?php echo base_url(); ?>js/jquery-migrate-1.2.1.min.js" type="text/javascript" charset="utf-8"></script>
<script src="<?php echo base_url(); ?>js/jquery.validationEngine.js" type="text/javascript" charset="utf-8"></script>
<script src="<?php echo base_url(); ?>js/jquery.validationEngine-en.js" type="text/javascript" charset="utf-8"></script>
<script src="<?php echo base_url(); ?>js/jquery-ui-1.10.3.custom.min.js" type="text/javascript" charset="utf-8"></script>
<script type="text/javascript">
$(document).ready(function(){
    $("#add-reminder").validationEngine({
        ajaxFormValidation: false,
        ajaxFormValidationMethod: 'post'
    });
    $("#tanggal").datepicker({dateFormat: "yy-mm-dd"});
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
        <h2>View Reminder Kelas</h2>
    </div>
    <!-- End Box Head -->

    <form id="add-kelas" action="" method="post" >

        <!-- Form -->
        <div class="form">
            <p class="inline-field">
                <label>Tanggal Mulai</label>
                <input id="tanggal" type="text" class="field size2 validate[required]" name="tanggal" value="<?php echo $kelas->kelas_tgl?>" disabled="true"/>
            </p>
            <p>
                <label>Catatan</label>
                <textarea class="field size1" rows="10" cols="30" name="keterangan"  disabled="true"><?php echo $kelas->kelas_ket?></textarea>
            </p>
        </div>
        <!-- End Form -->
    </form>
</div>
<!-- End Box -->