<script src="<?php echo base_url(); ?>js/jquery-ui-1.10.3.custom.min.js" type="text/javascript" charset="utf-8"></script>
<link rel="stylesheet" href="<?php echo base_url();?>css_rg/ui-lightness/jquery-ui-1.10.3.custom.min.css">
<script>
$(document).ready(function(){
    $("#date").datepicker({ dateFormat: "yy-mm-dd" });
});
</script>
<!-- Message Error -->
<?php if ($this->session->flashdata('f_home')): ?>
    <div class="msg msg-ok boxwidth">
        <p><strong><?php echo $this->session->flashdata('f_kelas'); ?></strong></p>
    </div>
<?php endif; ?>

<div class="box">
    <!-- Box Head -->
    <div class="box-head">
        <h2>Edit Pertemuan</h2>
    </div>
    <!-- End Box Head -->

    <form id="add-pertemuan" action="<?php echo base_url();?>admin/kelas/edit_kelas_pertemuan_submit" method="post" >

        <!-- Form -->
        <div class="form">
            <p>
                <label>Tanggal Pertemuan</label>
                <input id="date" type="text" class="field size2" name="date" value="<?php echo $kelas_pertemuan->kelas_pertemuan_date;?>"/>
                <input type="hidden" name="id" value="<?php echo $kelas_pertemuan->kelas_id;?>"/>
                <input type="hidden" name="id_pertemuan" value="<?php echo $kelas_pertemuan->kelas_pertemuan_id;?>"/>
            </p>
            <p>
                <label>Jam Mulai</label>
			 <?php $begin = explode(":",$kelas_pertemuan->kelas_pertemuan_jam_mulai);?>
                <select class="inline-field size5" name="mulai_jam">
                    <?php for($i=6;$i<24;$i++):?>
                    <option value="<?php echo $i;?>" <?php if($begin[0] == $i){echo "selected";}?>><?php echo str_pad($i, 2,"0",STR_PAD_LEFT);?></option>
                    <?php endfor;?>
                </select>
                <select class="inline-field size5" name="mulai_menit">
                    <option value="00" <?php if($begin[1] == "00"){echo "selected";}?>>00</option>
                    <option value="15" <?php if($begin[1] == "15"){echo "selected";}?>>15</option>
                    <option value="30" <?php if($begin[1] == "30"){echo "selected";}?>>30</option>
                    <option value="45" <?php if($begin[1] == "30"){echo "selected";}?>>45</option>
                </select>
            </p>
            <p>
                <label>Jam Selesai</label>
			 <?php $ends = explode(":",$kelas_pertemuan->kelas_pertemuan_jam_selesai);?>
                <select class="inline-field size5" name="selesai_jam">
                    <?php for($i=6;$i<24;$i++):?>
                    <option value="<?php echo $i;?>" <?php if($ends[0] == $i){echo "selected";}?>><?php echo str_pad($i, 2,"0",STR_PAD_LEFT);?></option>
                    <?php endfor;?>
                </select>
                <select class="inline-field size5" name="selesai_menit">
                    <option value="00" <?php if($ends[1] == "00"){echo "selected";}?>>00</option>
                    <option value="15" <?php if($ends[1] == "15"){echo "selected";}?>>15</option>
                    <option value="30" <?php if($ends[1] == "30"){echo "selected";}?>>30</option>
                    <option value="45" <?php if($ends[1] == "45"){echo "selected";}?>>45</option>
                </select>
                <span class="clear"></span>
            </p>
		  <p>
			<label>Status Pertemuan</label>
			<select class="inline-field size3" name="status_pertemuan">
                    <option value="1" <?php if($kelas_pertemuan->kelas_pertemuan_status_id == 1){echo "selected";}?>>Belum Selesai</option>
                    <option value="2" <?php if($kelas_pertemuan->kelas_pertemuan_status_id == 2){echo "selected";}?>>Sudah Selesai</option>
                    <option value="3" <?php if($kelas_pertemuan->kelas_pertemuan_status_id == 3){echo "selected";}?>>Batal</option>
                </select>
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