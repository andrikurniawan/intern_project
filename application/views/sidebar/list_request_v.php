<!-- Message Error -->
<?php if ($this->session->flashdata('f_request')): ?>
    <div class="msg msg-ok boxwidth">
        <p><strong><?php echo $this->session->flashdata('f_request'); ?></strong></p>
    </div>
<?php endif; ?>
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

<!-- Box -->
<div class="box">
    <!-- Box Head -->
    <div class="box-head">
        <h2 class="left">Request Sidebar</h2>
    </div>
    <!-- End Box Head -->	

    <!-- Table -->
    <div class="table">
        <table width="100%" border="0" cellspacing="0" cellpadding="0">
            <tr>
                <th>ID</th>
                <th>Nama</th>
                <th>Telepon</th>
                <th>Matpel</th>
                <th>Email</th>
                <th>Tgl Request</th>
                <th class="center">Status</th>
                <th class="center">Progress</th>
                <th class="center">Ops</th>
			  <th width="50">Control</th>
                <th width="50">Action</th>
            </tr>
            <?php $i=0;?>
            <?php foreach($request->result() as $row):?>
            <tr <?php echo (($i++%2)!=0)?'class="odd"':'';?>>
                <td class="column_id">
                    <a href="<?php echo base_url().'admin/utilities/view_request/'.$row->id_request;?>"><?php echo $row->id_request;?></a>
                </td>
                <td><?php echo $row->nama_request;?></td>
			 <td><?php echo $row->telp_request;?></td>
			 <td><?php echo $row->matpel_request;?></td>
			 <td><?php echo $row->email_request;?></td>
			 <td><?php echo $row->date_request;?></td>
                <td class="center">
                    <?php if($row->status_request==1):?>
                    <a href="<?php echo base_url().'admin/utilities/change_request_status/0/'.$row->id_request.'/'.$page;?>"><span class="ok">
                        Active
                    </span></a>
                    <?php else:?>
                    <a href="<?php echo base_url().'admin/utilities/change_request_status/1/'.$row->id_request.'/'.$page;?>"><span class="no">
                        Closed
                    </span></a>
                    <?php endif;?>
                </td>
			 <td class="center">
				<a href="<?php echo base_url().'admin/utilities/change_progress/'.$row->id_request.'/'.$page;?>">
					<?php if($row->progress_request==1):?>
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
				<form method="post" action="<?php echo base_url().'admin/utilities/change_ops/'.$row->id_request.'/'.$page;?>">
					<select name='ops' onchange='if(this.value != 0) { this.form.submit(); }'>
						<option value='0' <?php if($row->handle_request == 0){ echo "selected";} ?>>-</option>
						<option value='1' <?php if($row->handle_request == 1){ echo "selected";} ?>>NF</option>
						<option value='2' <?php if($row->handle_request == 2){ echo "selected";} ?>>MR</option>
						<option value='3' <?php if($row->handle_request == 3){ echo "selected";} ?>>PW</option>
						<option value='4' <?php if($row->handle_request == 4){ echo "selected";} ?>>MH</option>
					</select>
				</form>
			 </td>
			 <td>
                    <a href="<?php echo base_url();?>admin/utilities/delete_request/<?php echo $row->id_request;?>" class="ico del" onclick="return confirm('Apakah Anda yakin akan menghapus Request ID = <?php echo $row->id_request; ?> ?')">Delete</a>&nbsp;
                </td>
                <td>
                    <?php 
                        $lowongan = $this->request_model->is_already_lowongan($row->id_request,"langsung"); 
                        if($lowongan==null) { ?>
                            <button class="ubah-lowongan button" value="<?php echo $row->id_request?>">Ubah ke Lowongan</button>
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
                <a href="<?php echo base_url();?>admin/utilities/page/<?php echo $page-1;?>">Previous</a>
                <?php endif;?>
                <?php if(($start+$request->num_rows()) <= $count):?>
                <a href="<?php echo base_url();?>admin/utilities/page/<?php echo $page+1;?>">Next</a>
                <?php endif;?>
            </div>
        </div>
        <!-- End Pagging -->

    </div>
    <!-- Table -->

</div>
<!-- End Box -->
<div class="modal fade" id="modalLowongan" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title" id="myModalLabel">Lowongan Form</h4>
            </div>
            <form method="post" action="<?php echo base_url()?>admin/utilities/lowongan/">
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