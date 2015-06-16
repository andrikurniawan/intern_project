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
        <h2>Edit Feedback</h2>
    </div>
    <!-- End Box Head -->

    <form id="add-kelas" action="<?php echo base_url().'admin/kelas/edit_feedback_submit/'.$id_kelas;?>" method="post" enctype="multipart/form-data">

        <!-- Form -->
        <div class="form">
            <p>
                <label>Seberapa efektif guru dalam cara mengajar pelajaran tersebut?</label>
                <input type="radio" name="efektifitas" value="1" <?php if($feedback[0]['feedback_answer_id']==1) echo "checked"; ?>>Sangat tidak efektif&nbsp;&nbsp;&nbsp;
                <input type="radio" name="efektifitas" value="2" <?php if($feedback[0]['feedback_answer_id']==2) echo "checked"; ?>>Tidak efektif&nbsp;&nbsp;&nbsp;
                <input type="radio" name="efektifitas" value="3" <?php if($feedback[0]['feedback_answer_id']==3) echo "checked"; ?>>Netral&nbsp;&nbsp;&nbsp;
                <input type="radio" name="efektifitas" value="4" <?php if($feedback[0]['feedback_answer_id']==4) echo "checked"; ?>>Efektif&nbsp;&nbsp;&nbsp;
                <input type="radio" name="efektifitas" value="5" <?php if($feedback[0]['feedback_answer_id']==5) echo "checked"; ?>>Sangat efektif
		  </p>
            <p>
                <label>Seberapa efektif material yang dipersiapkan oleh guru?</label>
                <input type="radio" name="materi" value="1" <?php if($feedback[1]['feedback_answer_id']==1) echo "checked"; ?>>Sangat tidak efektif&nbsp;&nbsp;&nbsp;
                <input type="radio" name="materi" value="2" <?php if($feedback[1]['feedback_answer_id']==2) echo "checked"; ?>>Tidak efektif&nbsp;&nbsp;&nbsp;
                <input type="radio" name="materi" value="3" <?php if($feedback[1]['feedback_answer_id']==3) echo "checked"; ?>>Netral&nbsp;&nbsp;&nbsp;
                <input type="radio" name="materi" value="4" <?php if($feedback[1]['feedback_answer_id']==4) echo "checked"; ?>>Efektif&nbsp;&nbsp;&nbsp;
                <input type="radio" name="materi" value="5" <?php if($feedback[1]['feedback_answer_id']==5) echo "checked"; ?>>Sangat efektif
            </p>
		  <p>
                <label>Seberapa efektif komunikasi guru kepada murid/orang tua?</label>
                <input type="radio" name="komunikasi" value="1" <?php if($feedback[2]['feedback_answer_id']==1) echo "checked"; ?>>Sangat tidak efektif&nbsp;&nbsp;&nbsp;
                <input type="radio" name="komunikasi" value="2" <?php if($feedback[2]['feedback_answer_id']==2) echo "checked"; ?>>Tidak efektif&nbsp;&nbsp;&nbsp;
                <input type="radio" name="komunikasi" value="3" <?php if($feedback[2]['feedback_answer_id']==3) echo "checked"; ?>>Netral&nbsp;&nbsp;&nbsp;
                <input type="radio" name="komunikasi" value="4" <?php if($feedback[2]['feedback_answer_id']==4) echo "checked"; ?>>Efektif&nbsp;&nbsp;&nbsp;
                <input type="radio" name="komunikasi" value="5" <?php if($feedback[2]['feedback_answer_id']==5) echo "checked"; ?>>Sangat efektif
            </p>
		  <p>
                <label>Apakah guru ini selalu bersikap profesional (sopan, tepat waktu, dan lain lain)?</label>
			 <input type="radio" name="profesionalitas" value="1" <?php if($feedback[3]['feedback_answer_id']==1) echo "checked"; ?>>Sangat tidak profesional&nbsp;&nbsp;&nbsp;
             <input type="radio" name="profesionalitas" value="2" <?php if($feedback[3]['feedback_answer_id']==2) echo "checked"; ?>>Tidak profesional&nbsp;&nbsp;&nbsp;
             <input type="radio" name="profesionalitas" value="3" <?php if($feedback[3]['feedback_answer_id']==3) echo "checked"; ?>>Netral&nbsp;&nbsp;&nbsp;
             <input type="radio" name="profesionalitas" value="4" <?php if($feedback[3]['feedback_answer_id']==4) echo "checked"; ?>>Profesional&nbsp;&nbsp;&nbsp;
             <input type="radio" name="profesionalitas" value="5" <?php if($feedback[3]['feedback_answer_id']==5) echo "checked"; ?>>Sangat profesional
            </p>
		  <p>
                <label>Apakah Anda akan merekomendasikan guru ini kepada calon murid lain?</label>
			 <input type="radio" name="recommend" value="1" <?php if($feedback[4]['feedback_answer_id']==1) echo "checked"; ?>>Sangat tidak merekomendasikan&nbsp;&nbsp;&nbsp;
             <input type="radio" name="recommend" value="2" <?php if($feedback[4]['feedback_answer_id']==2) echo "checked"; ?>>Tidak merekomendasikan&nbsp;&nbsp;&nbsp;
             <input type="radio" name="recommend" value="3" <?php if($feedback[4]['feedback_answer_id']==3) echo "checked"; ?>>Netral&nbsp;&nbsp;&nbsp;
             <input type="radio" name="recommend" value="4" <?php if($feedback[4]['feedback_answer_id']==4) echo "checked"; ?>>Merekomendasikan&nbsp;&nbsp;&nbsp;
             <input type="radio" name="recommend" value="5" <?php if($feedback[4]['feedback_answer_id']==5) echo "checked"; ?>>Sangat merekomendasikan
            </p>
		  <p>
                <label>Secara keseluruhan, seberapa efektifkah guru ini?</label>
			 <input type="radio" name="efektif_all" value="1" <?php if($feedback[5]['feedback_answer_id']==1) echo "checked"; ?>>Sangat tidak efektif&nbsp;&nbsp;&nbsp;
             <input type="radio" name="efektif_all" value="2" <?php if($feedback[5]['feedback_answer_id']==2) echo "checked"; ?>>Tidak efektif&nbsp;&nbsp;&nbsp;
             <input type="radio" name="efektif_all" value="3" <?php if($feedback[5]['feedback_answer_id']==3) echo "checked"; ?>>Netral&nbsp;&nbsp;&nbsp;
             <input type="radio" name="efektif_all" value="4" <?php if($feedback[5]['feedback_answer_id']==4) echo "checked"; ?>>Efektif&nbsp;&nbsp;&nbsp;
             <input type="radio" name="efektif_all" value="5" <?php if($feedback[5]['feedback_answer_id']==5) echo "checked"; ?>>Sangat efektif
            </p>
            <p>
                <label>Testimoni untuk guru</label>
                <input type="hidden" name="kelas_id" value="<?php echo $feedback[0]['kelas_id']?>" />
                <textarea class="field size1" rows="10" cols="30" name="testimoni"><?php echo $feedback[0]['kelas_testimoni']?></textarea>
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