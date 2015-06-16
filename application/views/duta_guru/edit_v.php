<!-- Box -->
<div class="box">
    <!-- Box Head -->
    <div class="box-head">
        <h2>Edit Pembayaran</h2>
    </div>
    <!-- End Box Head -->

    <form id="add-pertemuan" action="<?php echo base_url();?>admin/duta_guru/edit_pembayaran_submit/<?php echo $pembayaran->pembayaran_id?>" method="post" >

        <!-- Form -->
        <div class="form">
            <p>
                <label>Title Pembayaran</label>
                <input id="date" type="text" class="field validate[required]" name="title" value="<?php echo $pembayaran->pembayaran_title;?>"/>
                <input type="hidden" name="id" value="<?php echo $pembayaran->pembayaran_id;?>"/>
                <input type="hidden" name="duta_id" value="<?php echo $duta_id?>"/>
            </p>
            <p>
                <label>Amount</label>
                <input id="date" type="text" class="field size2 validate[required,custom[onlyNumberSp]]" name="amount" value="<?php echo $pembayaran->pembayaran_amount;?>"/>
            </p>
		  <p>
                <label>Tanggal Verifikasi Pembayaran</label>
                <input id="date_verified" type="text" class="field size2" name="date_verified" value="<?php echo $pembayaran->pembayaran_date_verified;?>" />
            </p>
            <p>
                <label>Status</label>
                <select class="inline-field size5" name="status">
                    <option value="1" <?php if($pembayaran->pembayaran_status_id == 1){ echo "selected"; }?>>Belum Dibayar</option>
                    <option value="2" <?php if($pembayaran->pembayaran_status_id == 2){ echo "selected"; }?>>Sudah Dibayar</option>
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