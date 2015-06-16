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
        <h2>Add Guru Unggulan</h2>
    </div>
    <!-- End Box Head -->
    
    <form action="<?php echo base_url();?>admin/home/guru_unggulan_submit" method="post" >

        <!-- Form -->
        <div class="form">
            <p>
                <label>Guru Unggulan</label>
                <table>
                    <tr>
                          <td style="padding-left: 20px;"><label>ID Guru Unggulan</label></td>
				      <td><input type="text" class="field size2" name="id_guru" id="id_guru" value="" /></td>
                    </tr>
				<tr>
                          <td style="padding-left: 20px;"><label>Nama Guru Unggulan</label></td>
				      <td><input type="text" class="field size1" name="nama_guru" id="nama_guru" value="" /></td>
                    </tr>
				<tr>
                          <td style="padding-left: 20px;"><label>Prestasi Guru Unggulan</label></td>
				      <td><textarea class="field size1" rows="10" cols="30" name="prestasi" value=""></textarea></td>
                    </tr>
				<tr><td>&nbsp;</td></tr>
                </table>
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