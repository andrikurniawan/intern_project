<!-- Message Error -->
<?php if ($this->session->flashdata('f_home')): ?>
    <div class="msg msg-ok boxwidth">
        <p><strong><?php echo $this->session->flashdata('f_home'); ?></strong></p>
    </div>
<?php endif; ?>

<!-- Box -->
<div class="box">
    <!-- Box Head -->
    <div class="box-head">
        <h2>Edit Guru Unggulan</h2>
    </div>
    <!-- End Box Head -->

    <form action="<?php echo base_url();?>admin/home/edit_guru_unggulan_submit" method="post" >

        <!-- Form -->
        <div class="form">
            <p>
                <label>ID Guru Unggulan</label>
                <input type="text" class="field size1" name="id_guru<?php echo $guru_unggulan->guru_unggulan_id;?>" value="<?php echo $guru_unggulan->guru_id;?>"/>
                <input type="hidden" name="id" value="<?php echo $guru_unggulan->guru_unggulan_id;?>"/>
		  </p>
		  <p>
		      <label>Nama Guru Unggulan</label>
                <input type="text" class="field size1" name="nama_guru<?php echo $guru_unggulan->guru_unggulan_id;?>" value="<?php echo $guru_unggulan->nama_guru_unggulan;?>"/>
		  </p>
		  <p>
		      <label>Prestasi Guru Unggulan</label>
                <textarea class="field size1" rows="10" cols="30" name="prestasi<?php echo $guru_unggulan->guru_unggulan_id;?>"><?php echo $guru_unggulan->prestasi_guru_unggulan;?></textarea>
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