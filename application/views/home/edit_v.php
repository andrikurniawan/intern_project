<script src="<?php echo base_url(); ?>js/jquery-ui-1.10.3.custom.min.js" type="text/javascript" charset="utf-8"></script>
<link rel="stylesheet" href="<?php echo base_url();?>css_rg/ui-lightness/jquery-ui-1.10.3.custom.min.css">
<script type="text/javascript">
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
$(document).ready(function(){
	$("#date").datepicker({ dateFormat: "yy-mm-dd" });

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
    .form-field {
        margin-bottom: 10px;
    }
</style>
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
        <h2>Edit Request Guru</h2>
    </div>
    <!-- End Box Head -->

    <form action="<?php echo base_url();?>admin/home/edit_request_guru_submit" method="post" >

        <!-- Form -->
        <div class="form form-group row">
            <div class="form-field col-xs-12">
                <div class="col-xs-3">
                    <label>Title</label>
                </div>
                <div class="col-xs-9">
                    <input type="text" class="field col-xs-12" name="title" value="<?php echo $request_guru->request_guru_home_title;?>"/>
                    <input type="hidden" name="id" value="<?php echo $request_guru->request_guru_home_id;?>"/>
                </div>
            </div>
            <div class="form-field col-xs-12">
                <div class="col-xs-3">
                    <label>Lokasi</label>
                </div>
                <div class="col-xs-9">
                    <select class="field col-xs-6" name="provinsi" id="ddProvinsi" onchange="update_provinsi()">
                        <option value="-1" selected>--Pilih Provinsi--</option>
                        <?php foreach($provinsi->result() as $row):?>
                            <option value="<?php echo $row->provinsi_id;?>"><?php echo $row->provinsi_title;?></option>
                        <?php endforeach;?>
                    </select>
                    <select class="field col-xs-6" name="lokasi" id="ddLokasi">
                        <?php foreach($lokasi->result() as $row):?>
                        <option value="<?php echo $row->lokasi_id;?>" <?php echo ($row->lokasi_id==$request_guru->lokasi_id)?'selected':''; ?>><?php echo $row->lokasi_title;?></option>
                        <?php endforeach;?>
                    </select>
                </div>
            </div>
            <div class="form-field col-xs-12">
                <div class="col-xs-3">
                    <label>Mata Pelajaran</label>
                </div>
                <div class="col-xs-9">
                    <select id="jenjang_pendidikan" class="field col-xs-6" name="jenjang">
                        <option value="0">--Pilih Jenjang Pendidikan--</option>
                        <?php foreach($jenjang->result_array() as $p) { ?>
                            <option value="<?php echo $p['jenjang_pendidikan_id']?>" >
                                    <?php echo $p['jenjang_pendidikan_title'] ?></option>
                        <?php } ?>
                    </select>
                    <select id="matpel" class="field col-xs-6" name="matpel">
                        <?php foreach($matpel->result_array() as $m) {
                            if($m['matpel_id']==$request_guru->matpel_id) {
                                echo "<option value='".$m['matpel_id']."' selected>".$m['matpel_title']."</option>";
                            }
                        }?>
                    </select>
                </div>
            </div>
            <div class="form-field col-xs-12">
                <div class="col-xs-3">
                    <label>Keterangan</label>
                </div>
                <div class="col-xs-9">
                    <textarea class="field col-xs-12" rows="5" name="text"><?php echo $request_guru->request_guru_home_text;?></textarea>
                </div>
            </div>
            <div class="form-field col-xs-12">
                <div class="col-xs-3">
                    <label>Tanggal</label>
                </div>
                <div class="col-xs-9">
                    <input type="text" class="field col-xs-12" name="date" id="date" value="<?php echo $request_guru->request_guru_home_date;?>"/>
                </div>
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