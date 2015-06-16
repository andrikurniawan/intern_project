<!-- Message Error -->
<?php if ($this->session->flashdata('f_guru')): ?>
    <div class="msg msg-ok boxwidth">
        <p><strong><?php echo $this->session->flashdata('f_guru'); ?></strong></p>
    </div>
<?php endif; ?>

<!-- Box -->
<div class="box">
    <!-- Box Head -->
    <div class="box-head">
        <h2>Edit Template Email</h2>
    </div>
    <!-- End Box Head -->

    <form action="<?php echo base_url();?>admin/upload/edit_email_submit" method="post" >

        <!-- Form -->
        <div class="form">
            <p>
                <label>Sender</label>
                <input type="text" class="field size1" name="sender" value="<?php echo $template->sender;?>"/>
            </p>
		  <p>
                <label>Subject Email</label>
                <input type="text" class="field size1" name="subject" value="<?php echo $template->subject; ?>"/>
            </p>
		  <p>
                <label>Template Email</label>
                <textarea class="field size1" cols="10" rows="10" name="content"  style="overflow-y:auto;"><?php echo $template->template_email; ?></textarea>
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
