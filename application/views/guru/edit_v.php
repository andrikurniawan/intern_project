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
        <h2>Edit Rating Guru</h2>
    </div>
    <!-- End Box Head -->

    <form action="<?php echo base_url();?>admin/guru/edit_profile_submit" method="post" >

        <!-- Form -->
        <div class="form">
            <p>
                <label>Nama Guru</label>
                <input type="text" class="field size1" name="name" value="<?php echo $guru->guru_nama;?>" disabled="true"/>
                <input type="hidden" class="field size1" name="id" value="<?php echo $guru->guru_id;?>"/>
            </p>
		  <p>
                <label>Tentang Saya</label>
                <textarea class="field size1" cols="10" rows="10" name="personal"  style="overflow-y:auto;"><?php echo $guru->guru_bio;?></textarea>
            </p>
		  <p>
                <label>Kualifikasi</label>
                <textarea class="field size1" cols="10" rows="10" name="kualifikasi"  style="overflow-y:auto;"><?php echo $guru->guru_kualifikasi;?></textarea>
            </p>
		 <p>
                <label>Pengalaman</label>
                <textarea class="field size1" cols="10" rows="10" name="pengalaman"  style="overflow-y:auto;"><?php echo $guru->guru_pengalaman;?></textarea>
            </p>
        </div>
        <!-- End Form -->
        
        <!-- Form Buttons -->
        <div class="buttons">
            <input type="submit" class="button" value="submit" />
		  <a href="<?php echo base_url().'admin/guru/report_profile/'.$guru->guru_id; ?>" class="button">Report Profile</a>
        </div>
        <!-- End Form Buttons -->
    </form>
</div>
<!-- End Box -->
