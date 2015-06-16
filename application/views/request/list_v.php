<?php date_default_timezone_set("Asia/Jakarta"); ?>
<script>
    $(document).ready(function(){
        $(".ubah-lowongan").click(function() {
            $("#id_request").val($(this).val());
            $("#modalLowongan").modal('show');
        });

        $.post('<?php echo base_url()?>admin/request/get_kota/', {'provinsi':1},
            function(data){
                var option = "";
                for(var i=0;i<data.length;i++){
                    option += "<option value='"+data[i]['lokasi_id']+"'>"+data[i]['lokasi_title']+"</option>";
                }

                $("#lokasi_kota").html(option);
            },'json');

        $("#lokasi_provinsi").change(function(){
            var id = $(this).val();

            $.post('<?php echo base_url()?>admin/request/get_kota/', {'provinsi':id},
                function(data){
                    var option = "";
                    for(var i=0;i<data.length;i++){
                        option += "<option value='"+data[i]['lokasi_id']+"'>"+data[i]['lokasi_title']+"</option>";
                    }

                    $("#lokasi_kota").html(option);
                },'json');
        });

        $.post('<?php echo base_url()?>admin/request/get_matpel/', {'jenjang':1},
                function(data){
                    var option = "<option value='0'>----</option>";
                    for(var i=0;i<data.length;i++){
                        option += "<option value='"+data[i]['matpel_id']+"'>"+data[i]['matpel_title']+"</option>";
                    }

                    $("#matpel").html(option);
                },'json');

        $("#jenjang_pendidikan").change(function(){
            var id = $(this).val();
            $.post('<?php echo base_url()?>admin/request/get_matpel/', {'jenjang':id},
                function(data){
                    var option = "<option value='0'>----</option>";
                    for(var i=0;i<data.length;i++){
                        option += "<option value='"+data[i]['matpel_id']+"'>"+data[i]['matpel_title']+"</option>";
                    }

                    $("#matpel").html(option);
                },'json');
        });
    });
</script>
<style>
    .new-request {
        border-left:solid 3px rgb(0, 216, 255);
        background-color:rgb(192, 245, 255);
    }

    .field {
        padding: 5px;
        margin-bottom:10px;
        border-radius: 5px;
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
    <div class="box-head">
        <h2 class="left">+ <a href="<?php echo base_url();?>admin/request/add_request" class="top_box_link">Add Request</a></h2>
	   <div class="right">
			<form action="<?php echo base_url();?>admin/request/search" method="post">
				<label>search by murid</label>
				<input type="text" class="field small-field" name="murid_name"/>
				<input type="submit" class="button" value="search" />
			</form>
		</div>
    </div>
    <!-- End Box Head -->	

    <!-- Table -->
    <div class="table">
        <table width="100%" border="0" cellspacing="0" cellpadding="0">
            <tr>
                <th>id</th>
                <th>Kode Request</th>
                <th>Pelajaran & Tingkat</th>
                <th>Murid</th>
                <th>Requested From</th>
                <th>Disc</th>
                <th>Tgl Request</th>
                <th class="center">Status</th>
                <th class="center">Progress</th>
                <th class="center">Ops</th>
                <th width="50">Control</th>
                <th width="50">Action</th>
            </tr>
            <?php $i=0;?>
            <?php foreach($request->result() as $row):
                $to_time = strtotime(date('Y-m-d H:i:s'));
                $from_time = strtotime($row->request_date);
                $diff = round(abs($to_time - $from_time) / 60,0);?>
            <tr <?php echo (($i++%2)!=0)?'class="odd"':'';?> class="<?php if ($row->request_status==1 && $row->request_progress==0 && $diff < 120) {echo 'new-request'; } ?>" id="req-<?php echo $row->request_id ?>">
                <td class="column_id">
                    <a href="<?php echo base_url().'admin/request/view/'.$row->request_id;?>"><?php echo $row->request_id;?></a>
                </td>
                <td><?php echo $row->request_code;?></td>
                <td><?php echo $row->matpel_title;?> (<?php echo $row->jenjang_pendidikan_title;?>) </td>
                <td>
                    <a href="<?php echo base_url().'admin/murid/view/'.$row->murid_id;?>">
                        <?php echo $row->murid_nama;?>
                    </a>
                </td>
			 <td><?php if(($row->requested_by) == 0){ echo "Request Guru"; } else {  echo "Cari Guru";}?></td>
			 <td><?php 
							if(($row->request_get_disc) == 1){ echo "Ya"; } else {  echo "Tidak";}
					?>
			 </td>
			 <td><?php echo $row->request_date;?>
			 </td>
                <td class="center">
                    <a href="<?php echo base_url().'admin/request/change_call/'.$row->request_id.'/'.$page;?>">
				<?php if($row->request_status==1):?>
                    <span class="ok">
                        Active
                    </span>
                    <?php else:?>
                    <span class="no">
                        Closed
                    </span>
                    <?php endif;?>
				</a>
                </td>
			 <td class="center">
				 <a href="<?php echo base_url().'admin/request/change_progress/'.$row->request_id.'/'.$page;?>">
                    <?php if($row->request_progress==1):?>
                    <span class="ok">
                        Success
                    </span>
                    <?php else:?>
                    <span class="no">
                        In Progress
                    </span>
                    <?php endif;?>
				</a>
                </td>
			 <td>
				<form method="post" action="<?php echo base_url().'admin/request/change_ops/'.$row->request_id.'/'.$page;?>">
					<select name='ops' onchange='if(this.value != 0) { this.form.submit(); }'>
						<option value='0' <?php if($row->request_handle_by == 0){ echo "selected";} ?>>-</option>
						<option value='1' <?php if($row->request_handle_by == 1){ echo "selected";} ?>>NF</option>
						<option value='2' <?php if($row->request_handle_by == 2){ echo "selected";} ?>>MR</option>
						<option value='3' <?php if($row->request_handle_by == 3){ echo "selected";} ?>>PW</option>
						<option value='4' <?php if($row->request_handle_by == 4){ echo "selected";} ?>>MH</option>
					</select>
				</form>
			 </td>
			 <td>
                    <a href="<?php echo base_url();?>admin/request/delete/<?php echo $row->request_id;?>" class="ico del" onclick="return confirm('Apakah Anda yakin akan menghapus Request ID = <?php echo $row->request_id; ?> ?')">Delete</a>&nbsp;
                </td>
                <td>
                    <?php 
                        $lowongan = $this->request_model->is_already_lowongan($row->request_id); 
                        if($lowongan==null) { ?>
                            <button class="ubah-lowongan button" value="<?php echo $row->request_id?>">Ubah ke Lowongan</button>
                        <?php } else { ?>
                            <a href="<?php echo base_url()?>admin/home/edit_request_guru/<?php echo $lowongan['request_guru_home_id']?>"
                                target="_blank">Lihat Lowongan</a>
                        <?php } ?>
                </td>
            </tr>
            <?php endforeach;?>
        </table>
        <!-- Pagging -->
        <div class="pagging">
            <div class="left">
                Showing <?php echo $start+1;?>-<?php echo $start+$request->num_rows();?> of <?php echo $count;?>
            </div>
            <div class="right">
                <?php if($page>1):?>
                <a href="<?php echo base_url();?>admin/request/page/<?php echo $page-1;?>">Previous</a>
                <?php endif;?>
                <?php if(($start+$request->num_rows()) < $count):?>
                <a href="<?php echo base_url();?>admin/request/page/<?php echo $page+1;?>">Next</a>
                <?php endif;?>
            </div>
        </div>
        <!-- End Pagging -->

    </div>
    <!-- Table -->
</div>
<!-- End Box -->
<!-- Modal -->
<div class="modal fade" id="modalLowongan" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title" id="myModalLabel">Lowongan Form</h4>
            </div>
            <form method="post" action="<?php echo base_url()?>admin/request/lowongan/">
            <div class="modal-body">
                <div class="row">
                    <div class="col-xs-12">
                        <div class="col-xs-3">
                            <label>Title</label>
                        </div>
                        <div class="col-xs-9">
                            <input type="text" name="title" required="required" placeholder="Contoh : Bahasa Inggris SMA"
                                class="col-xs-12 field">
                            <input type="hidden" id="id_request" name="id_request" />
                        </div>
                    </div>
                    <div class="col-xs-12">
                        <div class="col-xs-3">
                            <label>Keterangan</label>
                        </div>
                        <div class="col-xs-9">
                            <textarea name="keterangan" required="required" maxlength="200" rows="5" class="col-xs-12 field"></textarea>
                        </div>
                    </div>
                    <div class="col-xs-12">
                        <div class="col-xs-3">
                            <label>Lokasi</label>
                        </div>
                        <div class="col-xs-9">
                            <select id="lokasi_provinsi" class="field col-xs-6" name="provinsi">
                                <?php foreach($provinsi->result_array() as $p) { ?>
                                    <option value="<?php echo $p['provinsi_id']?>" <?php if($p['provinsi_id']==1) echo "selected"; ?>>
                                        <?php echo $p['provinsi_title'] ?></option>
                                <?php } ?>
                            </select>
                            <select id="lokasi_kota" class="field col-xs-6" name="lokasi" required="required">
                                <!--generated by ajax-->
                            </select>
                        </div>
                    </div>
                    <div class="col-xs-12">
                        <div class="col-xs-3">
                            <label>Mata Pelajaran</label>
                        </div>
                        <div class="col-xs-9">
                            <select id="jenjang_pendidikan" class="field col-xs-6" name="jenjang">
                                <?php foreach($jenjang->result_array() as $p) { ?>
                                    <option value="<?php echo $p['jenjang_pendidikan_id']?>" 
                                        <?php if($p['jenjang_pendidikan_id']==1) echo "selected"; ?>>
                                            <?php echo $p['jenjang_pendidikan_title'] ?></option>
                                <?php } ?>
                            </select>
                            <select id="matpel" class="field col-xs-6" name="matpel">
                                <!--generated by ajax-->
                            </select>
                        </div>
                    </div>
                    <div class="col-xs-12">
                        <div class="col-xs-3">
                            <label>Harga</label>
                        </div>
                        <div class="col-xs-9">
                            <input type="text" name="harga" placeholder="Contoh : 50.000 - 100.000" class="col-xs-12 field" />
                        </div>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                <button type="submit" class="btn btn-primary">Submit</button>
            </div>
            </form>
        </div>
    </div>
</div>