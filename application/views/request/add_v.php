<link rel="stylesheet" href="<?php echo base_url();?>css_rg/ui-lightness/jquery-ui-1.10.3.custom.min.css">
<script src="<?php echo base_url(); ?>js/jquery-ui-1.10.3.custom.min.js" type="text/javascript" charset="utf-8"></script>
<style>
	.ceklis{ cursor:pointer; }
	.jadwal.ceklis.selected {background-color: #d5df26 !important;}
	.none{visibility:hidden;}
</style>

<script type="text/javascript">
function update_matpel(){
    id=$("#jenjangP").val();
    $.getJSON(base_url+"cari_guru/get_matpel/"+id,function(data){
	html = '';
        $.each(data,function(i,item){
		  html+= '<option value="'+item.matpel_id+'">'+item.matpel_title+'</option>';
        });
        $("#matpel").html(html);
    })
}

function update_provinsi(){
    id=$("#ddProvinsi").val();
        $.getJSON(base_url+"service/get_lokasi/"+id,function(data){
	   html = '';
        $.each(data,function(i,item){
		  html+= '<option value="'+item.lokasi_id+'">'+item.lokasi_title+'</option>';
        });
        $("#ddLokasi").html(html);
        })
}

function jadwal_box_click(obj){
    checkbox = $(obj).children('.jadwal-checkbox');
    if(checkbox.is(':checked')){
        checkbox.attr('checked', false);
        $(obj).removeClass('selected');
    }else{
        checkbox.attr('checked', true);
        $(obj).addClass('selected');
	   $(obj).toogleClass('selected');
    }
}

$(document).ready(function(){
     $("#mulai").datepicker({ minDate: new Date(),dateFormat: "yy-mm-dd" });
    update_matpel();
    update_provinsi();
});
</script>
<!-- Message Error -->
<?php if ($this->session->flashdata('f_request')): ?>
    <div class="msg msg-ok boxwidth">
        <p><strong><?php echo $this->session->flashdata('f_request'); ?></strong></p>
    </div>
<?php endif; ?>

<!-- Box -->
<div class="box">
    <!-- Box Head -->
    <div class="box-head">
        <h2 class="left">Add Request</h2>
    </div>
    <!-- End Box Head -->	

<!--<form method="post">-->
    <form method="post" action="<?php echo base_url(); ?>admin/request/add_request_submit">

        <!-- Form -->
        <div class="form">
            <p>
                <label>Guru ID</label>
                <input type="text" class="field size2" name="id_guru" />       
            </p>
            <p>
                <label>Murid ID</label>
                <input type="text" class="field size2" name="id_murid"/>
            </p>
		  <p>
                <label>Referral Code (Duta Murid)</label>
			 <input type="text" class="field size2" name="duta_murid"/> 
            </p>
		  <p>
                <label>Tingkat Pendidikan</label>
                <select class="inline-field size5" name="pendidikan" onchange="update_matpel()" id="jenjangP">
                     <?php foreach($this->guru_model->get_jenjang()->result() as $item):
					if($matpel->jenjang_pendidikan_id == $item->jenjang_pendidikan_id){
				 ?>
                         <option value="<?php echo $item->jenjang_pendidikan_id;?>" selected><?php echo $item->jenjang_pendidikan_title;?></option>
				 <?php } else { ?>
					<option value="<?php echo $item->jenjang_pendidikan_id;?>"><?php echo $item->jenjang_pendidikan_title;?></option>
                     <?php }
					endforeach;
				 ?>
                </select>
            </p>
            <p class="inline-field">
                <label>Mata Pelajaran</label>
                <select class="select" id="matpel" name="matpel">
                </select>
            </p>
		  <p>
                <label>Provinsi</label>
                <select class="inline-field size5" name="provinsi" onchange="update_provinsi()" id="ddProvinsi">
                      <?php foreach ($this->guru_model->get_provinsi('provinsi')->result() as $item):
					if($lokasi->provinsi_id == $item->provinsi_id){
				 ?>
                         <option value="<?php echo $item->provinsi_id;?>" selected><?php echo $item->provinsi_title;?></option>
				 <?php } else { ?>
					<option value="<?php echo $item->provinsi_id;?>"><?php echo $item->provinsi_title;?></option>
                     <?php }
					endforeach;
				 ?>
                </select>
            </p>
            <p class="inline-field">
                <label>Lokasi</label>
                <select class="select" id="ddLokasi" name="lokasi">
                </select>
            </p>
		  <p>
                <label>Jumlah pertemuan</label>
                <input type="text" class="field size2" name="request_frek"/>       
            </p>
            <p>
                <label>Budget</label>
                <input type="text" class="field size2" name="budget"/>       
            </p>
		  <p>
                <label>Jadwal Pilihan Murid</label>   
			 <table class="availability center" border="0" cellpadding="0" cellspacing="1" width="450">
				<tbody>
					<tr>
						<th></th>
						<?php foreach($days as $hari){?>
							<th width="50px"><?php echo $hari?></th>
						<?php } ?>
					</tr>
					<?php for($i=7;$i<24;$i++):?>
					<tr>
						<th height="30px"><?php echo sprintf('%02s', $i); ?>:00</th>
							<?php for($j=0;$j<7;$j++):?>
							<td onclick="jadwal_box_click(this)" class="jadwal ceklis" style="background-color: #EBEBEB;">
								<input class="none jadwal-checkbox" type="checkbox" name="catch_jadwal[]" value="<?php echo $i.','.$j;?>"/>
							</td>
							<?php endfor;?>
					</tr>
					<?php endfor;?>
				</tbody>
			</table>
            </p>
            <p>
                <label>Mulai</label>
                <input type="text" class="field size2" name="mulai" id="mulai"/>       
            </p>
		  <p>
                <label>Preferensi Gender</label>
                <select class="inline-field size5" name="gender">
                    <option value="1">Bebas</option>
                    <option value="2">Laki-laki</option>
                    <option value="3">Perempuan</option>
                </select>
            </p>
		  <p>
                <label>Diskon (ada duta murid dan transaksi >= Rp 1.000.000,-)</label>
                <select class="inline-field size5" name="disc">
                    <option value="1">Ya</option>
                    <option value="0">Tidak</option>
                </select>
            </p>
            <p>
                <label>Catatan</label>
                <textarea class="field size1" rows="10" cols="30" name="catatan"></textarea>
			 <input type="hidden" class="field size2" name="requested_by" id="requested_by" value="0"/>      
            </p>
        </div>

    <div class="buttons">
          <input type="submit" class="button" value="submit" />
     </div>
	</form>
</div>

</div>
<!-- End Box -->