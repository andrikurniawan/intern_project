<link rel="stylesheet" href="<?php echo base_url();?>css_rg/ui-lightness/jquery-ui-1.10.3.custom.min.css">
<script src="<?php echo base_url(); ?>js/jquery-ui-1.10.3.custom.min.js" type="text/javascript" charset="utf-8"></script>
<script>
$(document).ready(function(){
     $("#date_verified").datepicker({ minDate: new Date(),dateFormat: "yy-mm-dd" });
});
</script>
<!-- Message Error -->
<?php if ($this->session->flashdata('f_duta_guru')): ?>
    <div class="msg msg-ok boxwidth">
        <p><strong><?php echo $this->session->flashdata('f_duta_guru'); ?></strong></p>
    </div>
<?php endif; ?>

<!-- Box -->
<div class="box">
    <!-- Box Head -->
    <div class="box-head">
        <h2>Data Duta Guru</h2>
    </div>
    <!-- End Box Head -->

    <form method="post" >

        <!-- Form -->
        <div class="form">
            <p>
                <label>ID</label>
                <input type="text" class="field size1" name="name" value="<?php echo $duta_guru->duta_guru_id;?>" disabled="true"/>       
            </p>
            <p>
                <label>Nama Duta Guru</label>
                <input type="text" class="field size1" name="name" value="<?php echo $duta_guru->duta_guru_nama;?>" disabled="true"/>
                <input type="hidden" class="field size1" name="id" value="<?php echo $duta_guru->duta_guru_id;?>"/>
            </p>
            <p>
                <label>Email</label>
                <input type="text" class="field size1" name="name" value="<?php echo $duta_guru->duta_guru_email;?>" disabled="true"/>       
            </p>
            <p>
                <label>No. Ponsel 1</label>
                <input type="text" class="field size1" name="name" value="<?php echo $duta_guru->duta_guru_hp;?>" disabled="true"/>       
            </p>
            <p>
                <label>No. Ponsel 2</label>
                <input type="text" class="field size1" name="name" value="<?php echo $duta_guru->duta_guru_hp_2;?>" disabled="true"/>       
            </p>
            <p>
                <label>No. Telp Rumah</label>
                <input type="text" class="field size1" name="name" value="<?php echo $duta_guru->duta_guru_telp_rumah;?>" disabled="true"/>       
            </p>
            <p>
                <label>No. Telp Kantor</label>
                <input type="text" class="field size1" name="name" value="<?php echo $duta_guru->duta_guru_telp_kantor;?>" disabled="true"/>       
            </p>
            <p>
                <label>Gender</label>
                <input type="text" class="field size1" name="name" value="<?php echo ($duta_guru->duta_guru_gender==1)?'Pria':'Wanita';?>" disabled="true"/>       
            </p>
            <p>
                <label>Tempat Lahir</label>
                <input type="text" class="field size1" name="name" value="<?php echo $duta_guru->duta_guru_tempatlahir;?>" disabled="true"/>       
            </p>
            <p>
                <label>Tanggal Lahir</label>
                <input type="text" class="field size1" name="name" value="<?php echo $duta_guru->duta_guru_lahir;?>" disabled="true"/>       
            </p>
            <p>
                <label>Alamat</label>
                <textarea disabled="true" rows="10" cols="30" class="field size1"><?php echo $duta_guru->duta_guru_alamat;?></textarea>
            </p>
		  <p>
                <label>Alamat Domisili</label>
                <textarea disabled="true" rows="10" cols="30" class="field size1"><?php echo $duta_guru->duta_guru_alamat_domisili;?></textarea>
            </p>
            <p>
                <label>Nama Bank</label>
                <input type="text" class="field size1" name="name" value="<?php echo $duta_guru->bank_title;?>" disabled="true"/>       
            </p>
            <p>
                <label>No. Rekening</label>
                <input type="text" class="field size1" name="name" value="<?php echo $duta_guru->duta_guru_bank_rekening;?>" disabled="true"/>       
            </p>
            <p>
                <label>Pemilik Rekening</label>
                <input type="text" class="field size1" name="name" value="<?php echo $duta_guru->duta_guru_bank_pemilik;?>" disabled="true"/>       
            </p>
            <p>
                <label>Lokasi</label>
                <input type="text" class="field size1" name="name" value="<?php echo $duta_guru->lokasi_title;?>" disabled="true"/>       
            </p>
            <p>
                <label>Mengetahui Ruangguru Dari</label>
			 <?php $info_source = "";?>
			 <?php $info = explode(",",$duta_guru->source_info_id);?>
			 <?php $n = count($info); $i = 0;?>
			 <?php foreach($info as $in){ ?>
			 <?php if($in != ""){ ?>
			 <?php switch ($in){
					case "1":
						$from= "Duta";
						break;
					case "2":
						$from= "Facebook";
						break;
					case "3":
						$from = "Twitter";
						break;
					case "4":
						$from= "Lainnya";
						break;
					case "5":
						$from = "Pameran";
						break;
					case "6":
						$from = "Roadshow";
						break;
					case "7":
						$from= "Media";
						break;
					}
					$i++;
					if($i != $n-1){
						$info_source .= $from.", ";
					}else{
						$info_source .= $from;
					}
				  }
				}
				?>
                <input type="text" class="field size1" name="name" value="<?php echo $info_source;?>" disabled="true"/>       
            </p>
		  <p>
                <label>Waktu & Tanggal Daftar</label>
                <input type="text" class="field size1" name="name" value="<?php echo $duta_guru->duta_guru_daftar;?>" disabled="true"/>       
            </p>
        </div>
    </form>
</div>

<!-- Box -->
<div class="box">
    <!-- Box Head -->
    <div class="box-head">
        <h2>Edit Status Duta Guru</h2>
    </div>
    <!-- End Box Head -->

    <form action="<?php echo base_url();?>admin/duta_guru/edit_submit" method="post" >

        <!-- Form -->
        <div class="form">
            <input type="hidden" class="field size1" name="id" value="<?php echo $duta_guru->duta_guru_id;?>"/>
            <div class="table">
                <table>
                    <thead>
                        <tr>
                            <th class="center">Kategori</th>
                            <th class="center">Value</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td>Is Active</td>
                            <td>
                                <?php $config = 'class="checkbox"';?>
                                <?php echo form_radio('active', '0', ($duta_guru->duta_guru_active==0), $config);?> Tidak
                                <?php echo form_radio('active', '1', ($duta_guru->duta_guru_active==1), $config);?> Ya
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
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

<!-- Box -->
<div class="box">
    <!-- Box Head -->
    <div class="box-head">
        <h2>List Guru</h2>
    </div>
    <!-- End Box Head -->	
    <!-- Table -->
    <div class="table">
        <table width="100%" border="0" cellspacing="0" cellpadding="0">
            <tr>
                <th>ID</th>
                <th>Email</th>
                <th>Name</th>
            </tr>
            <?php $i=0;?>
            <?php foreach($guru->result() as $g):?>
            <tr <?php echo (($i++%2)!=0)?'class="odd"':'';?>>
                <td class="column_id">
                    <a href="<?php echo base_url().'admin/guru/view/'.$g->guru_id;?>">
                        <?php echo $g->guru_id;?></td>
                    </a>
                </td>
                <td><?php echo $g->guru_email;?></td>
                <td><?php echo $g->guru_nama;?></td>
            </tr>
            <?php endforeach;?>
        </table>
    </div>
    <!-- Table -->
</div>
<!-- End Box -->

<div class="box">
    <!-- Box Head -->
    <div class="box-head">
        <h2>List Murid</h2>
    </div>
    <!-- End Box Head -->	
    <!-- Table -->
    <div class="table">
        <table width="100%" border="0" cellspacing="0" cellpadding="0">
            <tr>
                <th>ID</th>
                <th>Email</th>
                <th>Name</th>
            </tr>
            <?php $i=0;?>
            <?php foreach($murid->result() as $g):?>
            <tr <?php echo (($i++%2)!=0)?'class="odd"':'';?>>
                <td class="column_id">
                    <a href="<?php echo base_url().'admin/murid/view/'.$g->murid_id;?>">
                        <?php echo $g->murid_id;?></td>
                    </a>
                </td>
                <td><?php echo $g->murid_email;?></td>
                <td><?php echo $g->murid_nama;?></td>
            </tr>
            <?php endforeach;?>
        </table>
    </div>
    <!-- Table -->
</div>
<!-- End Box -->

<div class="box">
    <!-- Box Head -->
    <div class="box-head">
        <h2>List Pembayaran</h2>
    </div>
    <!-- End Box Head -->	
    <!-- Table -->
    <div class="table">
        <table width="100%" border="0" cellspacing="0" cellpadding="0">
            <tr>
                <th>ID</th>
                <th>Title</th>
                <th>Amount</th>
                <th>Pengguna <i>Referral Code</i></th>
                <th>Status</th>
                <th>Control</th>
            </tr>
            <?php $i=0;?>
            <?php foreach($pembayaran->result() as $g):?>
            <tr <?php echo (($i++%2)!=0)?'class="odd"':'';?>>
                <td class="column_id"><?php echo $g->pembayaran_id;?></td>
                <td><?php echo $g->pembayaran_title;?></td>
                <td><?php echo $g->pembayaran_amount;?></td>
                <td><?php if($g->pembayaran_user_referral == 1) { echo "Duta Guru";} else { echo "Duta Murid"; }?></td>
                <td><?php echo $g->pembayaran_status_title;?></td>
			<td>
                    <a href="<?php echo base_url();?>admin/duta_guru/edit_pembayaran/<?php echo $duta_guru->duta_guru_id."/".$g->pembayaran_id;?>" class="ico edit">Edit</a>&nbsp;<a href="<?php echo base_url();?>admin/duta_guru/delete_pembayaran/<?php echo $duta_guru->duta_guru_id."/".$g->pembayaran_id;?>" class="ico del" onclick="return confirm('Apakah Anda yakin akan menghapus Duta Guru ID = <?php echo $g->pembayaran_id ?>')">Delete</a>&nbsp;
                </td>
            </tr>
            <?php endforeach;?>
        </table>
    </div>
    <!-- Table -->
</div>
<!-- End Box -->


<!-- Box -->
<div class="box">
    <!-- Box Head -->
    <div class="box-head">
        <h2>Add Pembayaran</h2>
    </div>
    <!-- End Box Head -->

    <form id="add-pertemuan" action="<?php echo base_url();?>admin/duta_guru/add_pembayaran_submit" method="post" >

        <!-- Form -->
        <div class="form">
		  <p>
                <label>Pengguna <i>Referral Code</i></label>
				<input class="radio" name="user_referral" type="radio" value="1" checked><span>Guru</span>&nbsp;&nbsp;&nbsp;&nbsp;
				<input class="radio" name="user_referral" type="radio" value="2"><span>Murid</span>
            </p>
		  <p>
                <label>Kelas ID</label>
                <input id="id_kelas" type="text" class="field size2 validate[required]" name="id_kelas" />
            </p>
            <p>
                <label>Title Pembayaran</label>
                <input id="date" type="text" class="field validate[required]" name="title" />
                <input type="hidden" name="id" value="<?php echo $duta_guru->duta_guru_id;?>"/>
            </p>
            <p>
                <label>Amount</label>
                <input id="date" type="text" class="field size2 validate[required,custom[onlyNumberSp]]" name="amount" />
            </p>
		  <p>
                <label>Tanggal Verifikasi Pembayaran</label>
                <input id="date_verified" type="text" class="field size2" name="date_verified" value="" />
            </p>
            <p>
                <label>Status</label>
                <select class="inline-field size5" name="status">
                    <?php foreach($this->utilities_model->get_table('pembayaran_status')->result() as $row):?>
                    <option value="<?php echo $row->pembayaran_status_id;?>"><?php echo $row->pembayaran_status_title;?></option>
                    <?php endforeach;?>
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


<!-- Box -->
<div class="box">
    <!-- Box Head -->
    <div class="box-head">
        <h2>Delete Duta Guru</h2>
    </div>
    <!-- End Box Head -->

        <div class="form">
            <p>
                <a href="<?php echo base_url().'admin/duta_guru/delete/'.$duta_guru->duta_guru_id;?>" class="del">
                    <button class="button">
                        Delete Duta Guru
                    </button>
                </a>
            </p>
        </div>
</div>
<!-- End Box -->