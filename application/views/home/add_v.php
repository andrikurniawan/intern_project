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
    update_provinsi(); 
});
</script>
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
        <h2>Add Request Guru</h2>
    </div>
    <!-- End Box Head -->

    <form action="<?php echo base_url();?>admin/home/add_request_guru_submit" method="post" >

        <!-- Form -->
        <div class="form">
            <p>
                <label>Title</label>
                <input type="text" class="field size1" name="title" />
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
                <label>Text</label>
                <textarea class="field size1" rows="10" cols="30" name="text"></textarea>
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