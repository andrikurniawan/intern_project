<link rel="stylesheet" href="<?php echo base_url();?>css_rg/ui-lightness/jquery-ui-1.10.3.custom.min.css">
<script src="<?php echo base_url(); ?>js/jquery-ui-1.10.3.custom.min.js" type="text/javascript" charset="utf-8"></script>
<style>
	.ceklis{ cursor:pointer; }
	.jadwal.ceklis.selected {background-color: #d5df26 !important;}
	.none{visibility:hidden;}
    .nav-tabs>li>a {
        color: white;
    }
</style>

<script type="text/javascript">
function update_matpel(){
    id=$("#jenjangP").val();
    sesi_matpel=$("#sesi_matpel").val();
    $.getJSON(base_url+"cari_guru/get_matpel/"+id,function(data){
	html = '';
        $.each(data,function(i,item){
	   if(item.matpel_id == sesi_matpel){
            html+= '<option value="'+item.matpel_id+'" selected>'+item.matpel_title+'</option>';
	   } else {
		  html+= '<option value="'+item.matpel_id+'">'+item.matpel_title+'</option>';
	   }
        });
        $("#matpel").html(html);
    })
}

function update_provinsi(){
    id=$("#ddProvinsi").val();
    sesi_kota=$("#sesi_lokasi").val();
        $.getJSON(base_url+"service/get_lokasi/"+id,function(data){
	   html = '';
        $.each(data,function(i,item){
		if(item.lokasi_id == sesi_kota){
            html+= '<option value="'+item.lokasi_id+'" selected>'+item.lokasi_title+'</option>';
		}else{
		  html+= '<option value="'+item.lokasi_id+'">'+item.lokasi_title+'</option>';
		}
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
<style>
    .form-field {
        margin-bottom: 10px;
    }
</style>

<!-- Message Error -->
<?php if ($this->session->flashdata('f_request')): ?>
    <div class="msg msg-ok boxwidth">
        <p><strong><?php echo $this->session->flashdata('f_request'); ?></strong></p>
    </div>
<?php endif; ?>

<!-- Box -->
<div class="box">
    <!-- Box Head -->
    <div class="box-head" style="height:42px">
        <ul id="myTab" class="nav nav-tabs" style="width:100%; min-width:960px;">
            <li class="active"><a href="#detail-request" data-toggle="tab">Data Request</a></li>
            <li><a href="#detail-guru" data-toggle="tab">Guru Request</a></li>
            <li><a href="#detail-status" data-toggle="tab">Status Request</a></li>
        </ul>
    </div>
    <!-- End Box Head -->
    <div id="myTabContent" class="tab-content row">
        <div class="tab-pane fade in active edit-content" id="detail-request">
            <!--<form method="post">-->
            <form method="post" action="<?php echo base_url(); ?>admin/request/edit_request_submit/<?php echo $request->request_id;?>">

                <!-- Form -->
                <div class="form form-group row" style="font-size:14px;">
                    <div class="col-xs-12 form-field">
                        <div class="col-xs-3">
                            <label>ID</label>
                        </div>
                        <div class="col-xs-9">
                            <input type="text" class="field col-xs-12" name="name" value="<?php echo $request->request_id;?>" disabled="true"/>       
                        </div>
                    </div>
                    <div class="col-xs-12 form-field">
                        <div class="col-xs-3">
                            <label>Kode Request</label>
                        </div>
                        <div class="col-xs-9">
                            <input type="text" class="field col-xs-12" name="name" value="<?php echo $request->request_code;?>" disabled="true"/>
                        </div>
                    </div>
                    <div class="col-xs-12 form-field">
                        <div class="col-xs-3">
                            <label>Murid</label>
                        </div>
                        <div class="col-xs-9">
                            <input type="text" class="field col-xs-12" name="name" disabled value="<?php echo $request->murid_nama;?>"/>       
                        </div>
                    </div>
                    <div class="col-xs-12 form-field">
                        <div class="col-xs-3">
                            <label>Tingkat Pendidikan</label>
                        </div>
                        <div class="col-xs-9">
                            <select class="field col-xs-12" name="pendidikan" onchange="update_matpel()" id="jenjangP">
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
                        </div>
                    </div>
                    <div class="col-xs-12 form-field">
                        <div class="col-xs-3">
                            <label>Mata Pelajaran</label>
                        </div>
                        <div class="col-xs-9">
                            <input type="hidden" id="sesi_matpel" value="<?php echo ($matpel !=null) ? $matpel->matpel_id : '';?>"/>
                            <select class="select field col-xs-12" id="matpel" name="matpel">
                            </select>
                        </div>
                    </div>
                    <?php if($request->requested_by == 0){ ?>
                        <div class="col-xs-12 form-field">
                            <div class="col-xs-3">
                                <label>Provinsi</label>
                            </div>
                            <div class="col-xs-9">
                                <select class="field col-xs-12" name="provinsi" onchange="update_provinsi()" id="ddProvinsi">
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
                            </div>
                        </div>
                        <div class="col-xs-12 form-field">
                            <div class="col-xs-3">
                                <label>Lokasi</label>
                            </div>
                            <div class="col-xs-9">
                                <input type="hidden" id="sesi_lokasi" value="<?php if($lokasi!= null) { echo $lokasi->lokasi_id; } ;?>"/>
                                <select class="select field col-xs-12" id="ddLokasi" name="lokasi">
                                </select>
                            </div>
                        </div>
                    <?php } ?>
                    <div class="col-xs-12 form-field">
                        <div class="col-xs-3">
                            <label>Jumlah pertemuan</label>
                        </div>
                        <div class="col-xs-9">
                            <input type="text" class="field col-xs-12" name="request_frek" value="<?php echo $request->request_frekuensi;?>"/>       
                        </div>
                    </div>
                    <div class="col-xs-12 form-field">
                        <div class="col-xs-3">
                            <label>Referral Code (Duta Murid)</label>
                        </div>
                        <div class="col-xs-9">
                            <input type="text" class="field col-xs-12" name="duta_murid" value="<?php echo $request->referal_code;?>"/> 
                        </div>
                    </div>
                    <div class="col-xs-12 form-field">
                        <div class="col-xs-3">
                            <label>Budget</label>
                        </div>
                        <div class="col-xs-9">
                            <input type="text" class="field col-xs-12" name="budget" value="<?php echo $request->request_budget;?>"/>       
                        </div>
                    </div>
                    <?php  if($request->requested_by == 0) {  $jyt = $this->request_model->convert_jadwal_kursus_admin($request->request_jadwal); //print_r($jyt);?>
                        <?php $jyt_cetak = $this->request_model->convert_jadwal_kursus($request->request_jadwal);?>
                        <?php  if($jyt_cetak["flag"] == 1) { 
                            $key = array_keys($jyt_cetak); //print_r($jyt);
                            $n = count($key);
                            $jadwal_kursus = "";
                            if($n >= 1){
                                for($j=0;$j<$n-1;$j++){
                                    $dd = sprintf('%d', $key[$j]); //print_r($key[$j]);
                                    $hari = $this->request_model->convert_day($dd);
                                    $jam = $this->request_model->convert_hour($jyt_cetak[$key[$j]]);
                                    $jadwal_kursus .= $hari." (".$jam.") ";
                                }
                            }
                            $jadwal_pilihan_murid = $jadwal_kursus;
                        }else{
                            $jadwal_pilihan_murid = $jyt_cetak[0];
                        } ?>
                        <div class="col-xs-12 form-field">
                            <div class="col-xs-3">
                                <label>Jadwal Pilihan Murid</label>
                            </div>
                            <div class="col-xs-9">
                                <textarea type="text" class="field size1" name="jyt"  disabled="true"><?php echo $jadwal_pilihan_murid;?></textarea>
                            </div>
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
                							<?php $hour = (array_key_exists($j, $jyt)?$jyt[$j]:array());?>
                							<td onclick="jadwal_box_click(this)" style="background-color: 
                                            <?php if($hour != null) { echo (array_key_exists($i, $hour)?'#AEE8FC':'#EBEBEB'); } else { echo '#EBEBEB'; }?>" class="jadwal ceklis">
                								<input class="none jadwal-checkbox" type="checkbox" name="catch_jadwal[]" value="<?php echo $i.','.$j;?>"/>
                							</td>
                							<?php endfor;?>
                					</tr>
                					<?php endfor;?>
                				</tbody>
                			</table>
                        </div>
                    <?php } ?>
                    <div class="col-xs-12 form-field">
                        <div class="col-xs-3">
                            <label>Mulai</label>
                        </div>
                        <div class="col-xs-9">
                            <input type="text" class="field col-xs-12" name="mulai" id="mulai" value="<?php echo $request->request_mulai;?>"/>       
                        </div>
                    </div>
                    <div class="col-xs-12 form-field">
                        <div class="col-xs-3">
                            <label>Preferensi Gender</label>
                        </div>
                        <div class="col-xs-9">
                            <select class="field col-xs-12" name="gender">
                                <option value="1" <?php if($request->request_gender == 1){ echo "selected";}?>>Bebas</option>
                                <option value="2" <?php if($request->request_gender == 2){ echo "selected";}?>>Laki-laki</option>
                                <option value="3" <?php if($request->request_gender == 3){ echo "selected";}?>>Perempuan</option>
                            </select>
                        </div>
                    </div>
                    <div class="col-xs-12 form-field">
                        <div class="col-xs-3">
                            <label>Diskon (ada duta murid dan transaksi >= Rp 1.000.000,-)</label>
                        </div>
                        <div class="col-xs-9">
                            <select class="field col-xs-12" name="disc">
                                <option value="1" <?php if($request->request_get_disc == 1){ echo "selected";}?>>Ya</option>
                                <option value="0" <?php if($request->request_get_disc == 0){ echo "selected";}?>>Tidak</option>
                            </select>
                        </div>
                    </div>
                    <!-- <div class="col-xs-12 form-field">
                        <div class="col-xs-3">
                            <label>Mulai Dibutuhkan</label>
                        </div>
                        <div class="col-xs-9">
                            <textarea class="field col-xs-12" rows="5" name="preferensi"><?php echo $request->preferensi;?></textarea>
                        </div>
                    </div> -->
                    <div class="col-xs-12 form-field">
                        <div class="col-xs-3">
                            <label>Catatan</label>
                        </div>
                        <div class="col-xs-9">
                            <textarea class="field col-xs-12" rows="5" name="catatan"><?php echo $request->request_catatan;?></textarea>
                        </div>
                    </div>
                </div>

                <div class="buttons">
                    <input type="submit" class="button" value="submit" />
                </div>
        	</form>
        </div>
        <div class="tab-pane fade edit-content" id="detail-guru">
            <!-- Box Head -->
            <!-- <div class="box-head">
                <h2>Status Guru</h2>
            </div> -->
            <!-- End Box Head -->   

            <!-- Table -->
            <div class="table col-xs-12">
                <table border="0" cellspacing="0" cellpadding="0" class="col-xs-12" style="margin-bottom:20px;">
                    <tr>
                        <th rowspan="2">ID Guru</th>
                        <th rowspan="2">Nama</th>
                        <th rowspan="2">Email</th>
                        <th rowspan="2">Telp.</th>
                        <th rowspan="2">Prioritas</th>
                        <th rowspan="2">Add Kelas</th>
                        <th rowspan="2" width="150px">Jadwal Pilihan Murid</th>
                        <th colspan="3" class="center">Response Status</th>
                        <th rowspan="2" class="center">Status Request</th>
                    </tr>
                    <tr>               
                        <th class="center">Belum Dijawab </th>
                        <th class="center">Ditolak </th>
                        <th class="center">Diterima </th>
                    </tr>
                    <?php $i=0;?>
                    <?php foreach($guru->result() as $row):?>
                        <tr <?php echo (($i++%2)!=0)?'class="odd"':'';?>>
                            <td class="column_id" >
                                <a href="<?php echo base_url().'admin/guru/view/'.$row->guru_id;?>"><?php echo $row->guru_id;?></a>&nbsp;<a href="<?php echo base_url();?>admin/request/delete_guru/<?php echo $row->request_id;?>/<?php echo $row->guru_id;?>" class="ico del" onclick="return confirm('Apakah Anda yakin akan menghapus guru tersebut dari request <?php echo $row->request_id; ?> ?')"></a>&nbsp;
                            </td>
                            <td><?php echo $row->guru_nama;?></td>
                            <td><?php echo $row->guru_email;?></td>
                            <td><?php echo $row->guru_hp;?></td>
                            <td class="center"><?php echo $row->request_guru_priority;?></td>
                            <td><a href="<?php echo base_url()."admin/kelas/add_kelas_request/". $request->request_id ."/" .$row->guru_id?>"><img src="<?php if($row->request_guru_status_title == "DITERIMA"){ echo base_url().'images/add_kelas.png'; } else { echo "";} ?>" width="70px"/></a></td>

                            <!-- JADWAL -->
                            <?php if($request->requested_by == 0){ ?>
                            <td><?php echo $jadwal_pilihan_murid;?></td>
                            <?php } else { ?>
                            <?php $jyt = $this->request_model->convert_jadwal($request->request_jadwal);?>
                            <?php if($jyt["flag"] == 1) {
                                $dd = array_keys($jyt[$row->guru_id]);
                                $n = count($dd);
                                $jadwal_kursus = "";
                                for($j=0;$j<$n;$j++){
                                    $hari = $this->request_model->convert_day($dd[$j]);
                                    $key = $dd[$j];
                                    $jam = $this->request_model->convert_hour($jyt[$row->guru_id][$key]);
                                    $jadwal_kursus .= $hari ." (". $jam .")<br/>"; 
                                } ?>
                                <?php } ?>
                                <td><?php if(isset($jadwal_kursus)) echo $jadwal_kursus;?></td>
                                <?php } ?>

                                <!-- END OF JADWAL -->

                                <td class="center">
                                    <a href="<?php echo base_url()."admin/request/change_status/". $request->request_id ."/" .$row->guru_id ."/1"?>"><img src="<?php if($row->request_guru_status_title == "BELUM DIJAWAB"){ echo base_url().'images/tick.png'; } else { echo base_url().'images/publish_x.png';} ?>"/></a>
                                </td>
                                <td class="center">
                                    <a href="<?php echo base_url()."admin/request/change_status/". $request->request_id ."/" .$row->guru_id ."/2"?>"><img src="<?php if($row->request_guru_status_title == "DITOLAK"){ echo base_url().'images/tick.png'; } else { echo base_url().'images/publish_x.png';} ?>"/></a>
                                </td>
                                <td class="center">
                                    <a href="<?php echo base_url()."admin/request/change_status/". $request->request_id ."/" .$row->guru_id ."/3"?>"><img src="<?php if($row->request_guru_status_title == "DITERIMA"){ echo base_url().'images/tick.png'; } else { echo base_url().'images/publish_x.png';} ?>"/></a>
                                </td>
                                <td class="center">
                                    <a href="<?php echo base_url()."admin/request/change_status_request/". $request->request_id ."/".$request->request_pilih_status;?>"><img src="<?php if($request->request_pilih_status == 1){ echo base_url().'images/tick.png'; } else { echo base_url().'images/publish_x.png';} ?>"/></a>
                                </td>
                            </tr>
                        <?php endforeach;?>
                    </table>
                    <form method="post" action="<?php echo base_url().'admin/request/add_guru/'.$request->request_id;?>"
                        style="margin-top:20px;padding-top:20px;">
                        <div class="col-xs-12">
                            <div class="col-xs-3">
                                <label>Masukkan ID Guru</label>
                            </div>
                            <div class="col-xs-5" style="padding:0px;">
                                <input type="text" class="field col-xs-12" name="id_guru"/>
                            </div>
                        </div>
                        <div class="col-xs-4 col-xs-offset-3" style="padding:5px">
                            <input type="submit" class="button" value="submit" style="height:30px;width:50px;" />
                        </div>
                    </form>
                </div>
                <!-- Table -->
        </div>
        <div class="tab-pane fade edit-content" id="detail-status">
            <form action="<?php echo base_url();?>admin/request/edit_submit" method="post" style="width:98.5%">

                <!-- Form -->
                <div class="form row" style="padding:0px;margin-left:5px;">
                    <input type="hidden" class="field size1" name="id" value="<?php echo $request->request_id;?>"/>
                    <div class="table col-xs-12">
                        <table class="col-xs-12">
                            <thead>
                                <tr>
                                    <th class="center">Kategori</th>
                                    <th>Value</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td class="center">Is Active</td>
                                    <td>
                                        <?php $config = 'class="checkbox col-xs-1"';?>
                                        <?php echo form_radio('active', '0', ($request->request_status==0), $config);?><span class="col-xs-2">Tidak</span>
                                        <?php echo form_radio('active', '1', ($request->request_status==1), $config);?><span class="col-xs-2">Ya</span>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
                <!-- End Form -->
                
                <!-- Form Buttons -->
                <div class="buttons" style="padding:10px 0px 10px 0px;margin-left:15px;">
                    <input type="submit" class="button" value="submit" style="margin-right:20px;width:100px;height:30px;" />
                </div>
                <!-- End Form Buttons -->
            </form>
        </div>
    </div>
</div>
