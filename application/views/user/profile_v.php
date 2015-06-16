<!-- Message Error -->
<?php if ($this->session->flashdata('f_user')): ?>
    <div class="msg msg-ok boxwidth">
        <p><strong><?php echo $this->session->flashdata('f_user'); ?></strong></p>
    </div>
<?php endif; ?>


<!-- Box -->
<div class="box">
    <!-- Box Head -->
    <div class="box-head">
        <h2>Edit Profile</h2>
    </div>
    <!-- End Box Head -->

    <form action="<?php echo base_url();?>admin/user/profile_submit" method="post" enctype="multipart/form-data">

        <!-- Form -->
        <div class="form">
            <p>
                <label class="bold">CHANGE PASSWORD</label>
            </p>
            <p>
                <label>Old Password <span>(Required Field)</span></label>
                <input type="password" class="field size1" name="old"/>
            </p>
            <p>
                <label>New Password <span>(Required Field)</span></label>
                <input type="password" class="field size1" name="new"/>
            </p>
            <p>
                <label>Retype New Password <span>(Required Field)</span></label>
                <input type="password" class="field size1" name="new2"/>
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