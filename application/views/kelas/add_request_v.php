<link rel="stylesheet" href="<?php echo base_url();?>css_rg/validation.css" type="text/css" media="all" />
<link rel="stylesheet" href="<?php echo base_url();?>css_rg/ui-lightness/jquery-ui-1.10.3.custom.min.css">
<script src="<?php echo base_url(); ?>js/jquery-migrate-1.2.1.min.js" type="text/javascript" charset="utf-8"></script>
<script src="<?php echo base_url(); ?>js/jquery.validationEngine.js" type="text/javascript" charset="utf-8"></script>
<script src="<?php echo base_url(); ?>js/jquery.validationEngine-en.js" type="text/javascript" charset="utf-8"></script>
<script src="<?php echo base_url(); ?>js/jquery-ui-1.10.3.custom.min.js" type="text/javascript" charset="utf-8"></script>
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

function update_matpel(){
    id=$("#select-jenjang").val();
    $.getJSON(base_url+"service/get_matpel/"+id,function(data){
        html = '';
        $.each(data,function(i,item){
            html+= '<option value="'+item.matpel_id+'">'+item.matpel_title+'</option>';
        });
        $("#select-matpel").html(html);
    })
}

$(document).ready(function(){
    $("#add-kelas").validationEngine({
        ajaxFormValidation: false,
        ajaxFormValidationMethod: 'post'
    });

    update_matpel();
    update_provinsi(); 

    $("#mulai").datepicker({ minDate: new Date(),dateFormat: "yy-mm-dd" });
});

</script>

<!-- Message Error -->

<?php if ($this->session->flashdata('f_kelas')): ?>
    <div class="msg msg-ok boxwidth">
        <p><strong><?php echo $this->session->flashdata('f_kelas'); ?></strong></p>
    </div>
<?php endif; ?>
<!-- Box -->
<div class="box">
    <!-- Box Head -->
    <div class="box-head">
        <h2>Add Kelas</h2>
    </div>
    <!-- End Box Head -->
    <form id="add-kelas" action="<?php echo base_url();?>admin/kelas/add_kelas_submit" method="post" >
        <!-- Form -->
        <div class="form">
	   	  <p>
                <label>Request ID</label>
                <input id="request_id" type="text" class="field size2 validate[required,custom[onlyNumberSp]]" name="request_id"/>
            </p>
            <p>
                <label>Guru ID</label>
                <input id="guru" type="text" class="field size2 validate[required,custom[onlyNumberSp],ajax[ajaxCheckTableId]]" name="guru" />
            </p>
            <p>
                <label>Murid ID</label>
                <input id="murid" type="text" class="field size2 validate[required,custom[onlyNumberSp],ajax[ajaxCheckTableId]" name="murid" />
            </p>
		  <p>
                <label>Referral Code (Duta Guru ID)</label>
                <input id="duta_guru" type="text" class="field size2 validate[custom[onlyNumberSp],ajax[ajaxCheckTableId]" name="duta_guru" />
            </p>
		  <p>
                <label>Referral Code (Duta Murid ID)</label>
                <input id="duta_murid" type="text" class="field size2 validate[custom[onlyNumberSp],ajax[ajaxCheckTableId]" name="duta_murid" />
            </p>
            <p class="inline-field">
                <label>Jenjang Pendidikan</label>
                <select class="field size1" id="select-jenjang" name="jenjang" onchange="update_matpel()">
                    <?php foreach ($jenjang->result() as $item): ?>
                        <option value="<?php echo $item->jenjang_pendidikan_id; ?>"><?php echo $item->jenjang_pendidikan_title; ?></option>
                    <?php endforeach; ?>
                </select>
            </p>
            <p class="inline-field">
                <label>Mata Pelajaran</label>
                <select class="field size1" id="select-matpel" name="matpel">
                </select>
            </p>
            <p class="inline-field">
                <label>Tanggal Mulai</label>
                <input id="mulai" type="text" class="field size2 validate[required]" name="mulai" />
            </p>
            <p class="inline-field">
                <label>Provinsi</label>
                <select class="field size1" name="provinsi" id="ddProvinsi" onchange="update_provinsi()">
                    <?php foreach($provinsi->result() as $row):?>
                    <option value="<?php echo $row->provinsi_id;?>"><?php echo $row->provinsi_title;?></option>
                    <?php endforeach;?>
                </select>
            </p>
            <p class="inline-field">
                <label>Kota/Lokasi</label>
                <select class="field size1" name="lokasi" id="ddLokasi">
                </select>
            </p>
            <p>
                <label>Catatan</label>
                <textarea class="field size1" rows="10" cols="30" name="catatan"></textarea>
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