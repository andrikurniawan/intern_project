<link rel="stylesheet" href="<?php echo base_url();?>css_rg/validation.css" type="text/css" media="all" />
<script src="<?php echo base_url(); ?>js/jquery-migrate-1.2.1.min.js" type="text/javascript" charset="utf-8"></script>
<script src="<?php echo base_url(); ?>js/jquery.validationEngine.js" type="text/javascript" charset="utf-8"></script>
<script src="<?php echo base_url(); ?>js/jquery.validationEngine-en.js" type="text/javascript" charset="utf-8"></script>
<script type="text/javascript">
$(document).ready(function(){
    $("#add-kelas").validationEngine({
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
        <h2>Add Feedback</h2>
    </div>
    <!-- End Box Head -->

    <form id="add-kelas" action="<?php echo base_url().'admin/kelas/add_feedback_submit/'.$id_kelas;?>" method="post" enctype="multipart/form-data">

        <!-- Form -->
        <div class="form">
            <p>
                <label>Seberapa efektif guru dalam cara mengajar pelajaran tersebut?</label>
                <input type="radio" name="efektifitas" value="1">Sangat tidak efektif&nbsp;&nbsp;&nbsp;<input type="radio" name="efektifitas" value="2">Tidak efektif&nbsp;&nbsp;&nbsp;<input type="radio" name="efektifitas" value="3">Netral&nbsp;&nbsp;&nbsp;<input type="radio" name="efektifitas" value="4">Efektif&nbsp;&nbsp;&nbsp;<input type="radio" name="efektifitas" value="5">Sangat efektif
		  </p>
            <p>
                <label>Seberapa efektif material yang dipersiapkan oleh guru?</label>
                <input type="radio" name="materi" value="1">Sangat tidak efektif&nbsp;&nbsp;&nbsp;<input type="radio" name="materi" value="2">Tidak efektif&nbsp;&nbsp;&nbsp;<input type="radio" name="materi" value="3">Netral&nbsp;&nbsp;&nbsp;<input type="radio" name="materi" value="4">Efektif&nbsp;&nbsp;&nbsp;<input type="radio" name="materi" value="5">Sangat efektif
            </p>
		  <p>
                <label>Seberapa efektif komunikasi guru kepada murid/orang tua?</label>
                <input type="radio" name="komunikasi" value="1">Sangat tidak efektif&nbsp;&nbsp;&nbsp;<input type="radio" name="komunikasi" value="2">Tidak efektif&nbsp;&nbsp;&nbsp;<input type="radio" name="komunikasi" value="3">Netral&nbsp;&nbsp;&nbsp;<input type="radio" name="komunikasi" value="4">Efektif&nbsp;&nbsp;&nbsp;<input type="radio" name="komunikasi" value="5">Sangat efektif
            </p>
		  <p>
                <label>Apakah guru ini selalu bersikap profesional (sopan, tepat waktu, dan lain lain)?</label>
			 <input type="radio" name="profesionalitas" value="1">Sangat tidak profesional&nbsp;&nbsp;&nbsp;<input type="radio" name="profesionalitas" value="2">Tidak profesional&nbsp;&nbsp;&nbsp;<input type="radio" name="profesionalitas" value="3">Netral&nbsp;&nbsp;&nbsp;<input type="radio" name="profesionalitas" value="4">Profesional&nbsp;&nbsp;&nbsp;<input type="radio" name="profesionalitas" value="5">Sangat profesional
            </p>
		  <p>
                <label>Apakah Anda akan merekomendasikan guru ini kepada calon murid lain?</label>
			 <input type="radio" name="recommend" value="1">Sangat tidak merekomendasikan&nbsp;&nbsp;&nbsp;<input type="radio" name="recommend" value="2">Tidak merekomendasikan&nbsp;&nbsp;&nbsp;<input type="radio" name="recommend" value="3">Netral&nbsp;&nbsp;&nbsp;<input type="radio" name="recommend" value="4">Merekomendasikan&nbsp;&nbsp;&nbsp;<input type="radio" name="recommend" value="5">Sangat merekomendasikan
            </p>
		  <p>
                <label>Secara keseluruhan, seberapa efektifkah guru ini?</label>
			 <input type="radio" name="efektif_all" value="1">Sangat tidak efektif&nbsp;&nbsp;&nbsp;<input type="radio" name="efektif_all" value="2">Tidak efektif&nbsp;&nbsp;&nbsp;<input type="radio" name="efektif_all" value="3">Netral&nbsp;&nbsp;&nbsp;<input type="radio" name="efektif_all" value="4">Efektif&nbsp;&nbsp;&nbsp;<input type="radio" name="efektif_all" value="5">Sangat efektif
            </p>
            <p>
                <label>Testimoni untuk guru</label>
                <textarea class="field size1" rows="10" cols="30" name="testimoni"></textarea>
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