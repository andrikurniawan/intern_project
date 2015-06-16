<link rel="stylesheet" href="<?php echo base_url();?>css_rg/validation.css" type="text/css" media="all" />
<link rel="stylesheet" href="<?php echo base_url();?>css_rg/ui-lightness/jquery-ui-1.10.3.custom.min.css">

<script src="<?php echo base_url(); ?>js/jquery.validationEngine.js" type="text/javascript" charset="utf-8"></script>
<script src="<?php echo base_url(); ?>js/jquery.validationEngine-en.js" type="text/javascript" charset="utf-8"></script>
<script src="<?php echo base_url(); ?>js/jquery-ui-1.10.3.custom.min.js" type="text/javascript" charset="utf-8"></script>
<script src="<?php echo base_url(); ?>js/bootbox.min.js" type="text/javascript" charset="utf-8"></script>

<script type="text/javascript">
    function update_harga(){
    	total_harga = document.getElementById("total_harga");
    	harga = document.getElementById("harga");
    	total_jam = document.getElementById("total_jam");
    	jml_harga = harga * total_jam;

    	if(jml_harga != $total_harga){
    		alert("Perkalian jumlah jam dan harga salah!");
    	}
    	
    	
    }

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

    $(document).ready(function(){
        $("#add-pertemuan").validationEngine();
        $("#date").datepicker({ dateFormat: "yy-mm-dd" });
        $("#date_verified").datepicker({ dateFormat: "yy-mm-dd" });
        $("#date_verified_edit").datepicker({dateFormat: "yy-mm-dd" });
        $("#date_verified_kedua").datepicker({ dateFormat: "yy-mm-dd" });
        $("#date_payment1").datepicker({ dateFormat: "yy-mm-dd" });
        $("#date_payment2").datepicker({ dateFormat: "yy-mm-dd" });
        $("#date_pembayaran_guru").datepicker({ dateFormat: "yy-mm-dd" });
        $("#date_pembayaran_guru_edit").datepicker({ dateFormat: "yy-mm-dd" });
        $("#mulai").datepicker();
        $("#mulai_invoice").datepicker();
        update_matpel();
        update_provinsi();
        var isActive = 0;

        $("#tambah-invoice").click(function(){
            $("#modalAddInvoice").modal('show');
        });

        $(".submit-pembayaran").click(function(event){
            event.preventDefault();
            $("#submit_invoice_id").val($(this).attr('value'));
            $("#pembayaranModal").modal('show');
        });

        $("#tambah-pembayaran-guru").click(function(){
           $("#PembayaranGuruModal").modal('show'); 
        });

        $("#kirim-pembayaran").click(function(){
            $("#kirim-pembayaran-modal").modal("show");
        });

        $("#vtmake").click(function(){

        });

        $(".jadwal-kelas").click(function () {
            var id = $(this).attr('id');

            if(!$(this).hasClass('selected')){
                $(this).addClass('selected');
                $("#ckbox-"+id).attr('checked','')
            } else {
                $(this).removeClass('selected');
                $("#ckbox-"+id).removeAttr('checked')
            }
        });

        $(".durasi-invoice").change(function(){
            var id = $(this).attr('id').replace(/[^0-9\.]+/g, '');

            $("#total_jam_"+id).val($(this).val()*$("#total_pertemuan_"+id).val());
            $("#total_semua_"+id).val($(this).val()*$("#total_pertemuan_"+id).val()*$("#harga_"+id).val());
            $("#total_harga_"+id).val($(this).val()*$("#total_pertemuan_"+id).val()*$("#harga_"+id).val()-$("#discount_"+id).val());
        });

        $(".pertemuan-invoice").change(function(){
            var id = $(this).attr('id').replace(/[^0-9\.]+/g, '');

            $("#total_jam_"+id).val($(this).val()*$("#durasi_"+id).val());
            $("#total_semua_"+id).val($(this).val()*$("#durasi_"+id).val()*$("#harga_"+id).val());
            $("#total_harga_"+id).val($(this).val()*$("#durasi_"+id).val()*$("#harga_"+id).val()-$("#discount_"+id).val());
        });

        $(".harga-invoice").change(function(){
           var id = $(this).attr('id').replace(/[^0-9\.]+/g, '');

           $("#total_harga_"+id).val($(this).val()*$("#total_pertemuan_"+id).val()*$("#durasi_"+id).val()-$("#discount_"+id).val());
           $("#total_semua_"+id).val($(this).val()*$("#total_pertemuan_"+id).val()*$("#durasi_"+id).val());
        });

        $(".disc").change(function(){
            var id = $(this).attr('id').replace(/[^0-9\.]+/g, '');
            var total = $("#total_semua_"+id).val();
            $("#total_harga_"+id).val(total - $(this).val());
        });

        $(".status-kelas").change(function(){
            $.post("<?php echo base_url()?>admin/kelas/ubah_status", {"status" : $(this).val(), "id" : $("#id-kelas-status").val()},
                function(data){
                    window.location.reload();
                });
        });

        $(".deleteInvoiceButton").click(function(event){
            event.preventDefault();
            var id = $(this).attr('value');
            var href = $(this).attr('href');
            console.log(id);
            bootbox.confirm("Apakah anda yakin untuk menghapus invoice "+id+"?", function(result) {
                if(result){
                    window.location.assign(href);
                }
            }); 
        })

        $(".modal-edit-invoice").click(function(event){
            event.preventDefault();
            var href = $(this).attr('href');
            var id = href.substr(1);
            $.post("<?php echo base_url()?>admin/kelas/json_pembayaran_murid",{"id_pembayaran": id},
                function(data){
                    console.log(data);
                    $("#id_pembayaran").val(id);
                    $("#pembayaran_murid_edit").val(data['jumlah']);
                    $("#diskon_pembayaran_edit").val(data['diskon']);
                    $("#date_verified_edit").val(data['waktu_pembayaran']);
                    $("#no_rek_murid_edit").val(data['rekening']);

                    $("#EditPembayaranModal").modal("show");
                },"json");
        });

        $(".kirim-pembayaran").click(function(event){
            event.preventDefault();
            var href = $(this).attr('href');
            var id = href.substr(1);
            $.post("<?php echo base_url()?>admin/kelas/json_pembayaran_murid",{"id_pembayaran": id},
                function(data){
                    console.log(data);
                    $("#send_invoice_id").val(data['invoice_id']);
                    $("#send_diskon").val(data['diskon']);
                    $("#send_jumlah").val(data['jumlah']);
                    $("#send_murid_nama").val(data['murid_nama']);

                    $("#kirim-pembayaran-modal").modal("show");
                },"json");
        });

        $(".delete_pembayaran").click(function(event){
            event.preventDefault();
            var id = $(this).attr('value');
            var href = $(this).attr('href');
            console.log(id);
            bootbox.confirm("Apakah anda yakin untuk menghapus pembayaran "+id+"?", function(result) {
                if(result){
                    window.location.assign(href);
                }
            }); 
        });

        $(".delete-pembayaran-guru").click(function(event){
            event.preventDefault();
            var id = $(this).attr('value');
            var href = $(this).attr('href');
            console.log(id);
            bootbox.confirm("Apakah anda yakin untuk menghapus pembayaran guru ke-"+id+"?", function(result) {
                if(result){
                    window.location.assign(href);
                }
            }); 
        });

        $(".edit-pembayaran-guru").click(function(event){
            event.preventDefault();
            var href = $(this).attr('href');
            var id = href.substr(1);
            var jumlah = parseFloat($(this).attr('data-jumlah'));
            var pph = parseFloat($(this).attr('data-pph'));
            var tanggal = $(this).attr('data-tanggal');

            $("#id_pembayaran_guru").val(id);
            $("#jumlah_pembayaran_guru_edit").val(jumlah/(1-(pph/100)));
            $("#total_dibayar_guru_edit").val(jumlah);
            $("#nominal_pph_guru_edit").val((jumlah/(1-(pph/100)))-jumlah);
            
            $("#pembayaran_guru_pph_0_edit").prop('checked', false);
            $("#pembayaran_guru_pph_3_edit").prop('checked', false);
            $("#pembayaran_guru_pph_2_edit").prop('checked', false);
            
            if(pph==3){
                $("#pembayaran_guru_pph_3_edit").prop('checked',true);
                
            } else if(pph==2.5){
                $("#pembayaran_guru_pph_2_edit").prop('checked',true);
            } else {
                $("#pembayaran_guru_pph_0_edit").prop('checked',true);
            }
            
            $("#date_pembayaran_guru_edit").val(tanggal);

            $("#EditPembayaranGuruModal").modal('show');
        });
        
        $("#jumlah_pembayaran_guru").change(function(){
            var jumlah = parseFloat($(this).val());
            if($("#pembayaran_guru_pph_3").is(':checked')){
                jumlah -= jumlah*0.03;
            }if($("#pembayaran_guru_pph_2").is(':checked')){
                jumlah -= jumlah*0.025;
            }
            
            $("#total_dibayar_guru").val(jumlah);
            $("#nominal_pph_guru").val(parseFloat($(this).val())-jumlah);
        });
        
        $(".pembayaran_guru_pph").change(function(){
            var jumlah = parseFloat($("#jumlah_pembayaran_guru").val());
            
            console.log(jumlah);
            if($("#pembayaran_guru_pph_3").is(':checked')){
                jumlah -= jumlah*0.03;
            }if($("#pembayaran_guru_pph_2").is(':checked')){
                jumlah -= jumlah*0.025;
            }
            
            $("#total_dibayar_guru").val(jumlah);
            $("#nominal_pph_guru").val(parseFloat($("#jumlah_pembayaran_guru").val())-jumlah);
        });
        
        $("#jumlah_pembayaran_guru_edit").change(function(){
            var jumlah = parseFloat($(this).val());
            if($("#pembayaran_guru_pph_3_edit").is(':checked')){
                jumlah -= jumlah*0.03;
            }if($("#pembayaran_guru_pph_2_edit").is(':checked')){
                jumlah -= jumlah*0.025;
            }
            
            $("#total_dibayar_guru_edit").val(jumlah);
            $("#nominal_pph_guru_edit").val(parseFloat($(this).val())-jumlah);
        });
        
        $(".pembayaran_guru_pph_edit").change(function(){
            var jumlah = parseFloat($("#jumlah_pembayaran_guru_edit").val());
            
            console.log(jumlah);
            if($("#pembayaran_guru_pph_3_edit").is(':checked')){
                jumlah -= jumlah*0.03;
            }if($("#pembayaran_guru_pph_2_edit").is(':checked')){
                jumlah -= jumlah*0.025;
            }
            
            $("#total_dibayar_guru_edit").val(jumlah);
            $("#nominal_pph_guru_edit").val(parseFloat($("#jumlah_pembayaran_guru_edit").val())-jumlah);
        });
    });
</script>
<style>
    .edit-content {
        margin-left:20px;
        margin-top:20px;
    }

    .form-input {
        margin-bottom:10px;
    }

    label {
        font-size:14px;
    }

    .nav-tabs>li>a {
        color: white;
    }

    .box-head {
        height:30px;
        border-radius:5px;
    }

    .box-head h2 {
        font-size:18px;
        padding-top:5px;
    }

    .jadwal-kelas {
        cursor: hand;
    }

    .jadwal-checkbox{
        visibility: hidden;
    }

    .selected {
        background-color: red;
    }

    .active a{
        background-color: #FBFCFC !important;
    }

    tr,td,th{
        text-align: center !important;
    }
    
    .nav-tabs>li>a:hover {
        color :black;
    }
</style>

<!-- Message Error -->
<?php if ($this->session->flashdata('f_kelas')): ?>
    <div class="msg msg-ok boxwidth">
        <p><strong><?php echo $this->session->flashdata('f_kelas'); ?></strong></p>
    </div>
<?php endif; ?>

<!-- Box -->
<div class="box">
    <!-- Box Head -->
    <div class="box-head" style="height:42px">
        <ul id="myTab" class="nav nav-tabs" style="width:100%; min-width:960px;">
            <li class="active"><a href="#detail-kelas" data-toggle="tab">Data Kelas</a></li>
            <li ><a href="#invoices" data-toggle="tab">Invoice dan Pembayaran</a></li>
            <!--<li><a href="#payment-murid" data-toggle="tab">Pembayaran Murid</a></li> -->
            <li><a href="#kelas-pertemuan" data-toggle="tab">Jadwal Kelas</a></li>
            <li ><a href="#kelas-feedback" data-toggle="tab">Feedback</a></li>
            <li ><a href="#payment-guru" data-toggle="tab">Pembayaran Guru</a></li>
            <li><a href="#status-kelas" data-toggle="tab">Status Kelas</a></li>
        </ul>
    </div>
    <!-- End Box Head -->
    <div id="myTabContent" class="tab-content row">
        <div class="tab-pane fade in active edit-content" id="detail-kelas">
            <form id="add-kelas" action="<?php echo base_url();?>admin/kelas/update_kelas_submit/<?php echo $kelas->kelas_id;?>" method="post" >
                <!-- Form -->
                <div class="row">
                    <div class="col-xs-12 form-input">
                        <div class="col-xs-3">
                            <label>ID Kelas</label>
                        </div>
                        <div class="col-xs-9">
                            <input type="text" class="field" size="15px"  name="id" disabled value="<?php echo $kelas->kelas_id;?>" readonly/>
                        </div>
                    </div>
                    <div class="col-xs-12 form-input">
                        <div class="col-xs-3">
                            <label>Nama Guru</label>
                        </div>
                        <div class="col-xs-9">
                            <input id="guru" type="text" class="field size1" name="guru" value="<?php echo $kelas->guru_nama;?>"/>
                        </div>
                    </div>
                    <div class="col-xs-12 form-input">
                        <div class="col-xs-3">
                            <label>Nama Murid</label>
                        </div>
                        <div class="col-xs-9">
                            <input id="murid" type="text" class="field size1" name="murid" disabled value="<?php echo $kelas->murid_nama;?>"/>
                        </div>
                    </div>
                    <div class="col-xs-12 form-input">
                        <div class="col-xs-3">
                            <label>Nama Duta Guru</label>
                        </div>
                        <div class="col-xs-9">
                            <input id="murid" type="text" class="field size1" name="duta" disabled value="<?php if(!empty($kelas->duta_guru_id)){ echo $kelas->duta_guru_nama; }else{ echo ""; }?>"/>
                            <input id="duta_murid" type="hidden" name="duta_murid" disabled value="<?php echo $kelas->duta_guru_id;?>"/>
                            <input id="duta_guru" type="hidden" name="duta_guru" disabled value="<?php echo $kelas->duta_murid_id;?>"/>
                        </div>
                    </div>
                    <div class="col-xs-12 form-input">
                        <div class="col-xs-3">
                            <label>Nama Duta Murid</label>
                        </div>
                        <div class="col-xs-9">
                            <?php $duta_guru = $this->kelas_model->get_duta_info($kelas->duta_murid_id);?>
                            <input id="murid" type="text" class="field size1" name="duta" disabled value="<?php if($kelas->duta_murid_id!=null && $kelas->duta_murid_id>0){ echo $kelas->duta_guru_nama; }else{ echo ""; }?>"/>
                        </div>

                    </div>
                    <div class="col-xs-12 form-input" style="display:none">
                        <div class="col-xs-3">
                            <label>Dapat Diskon  <br/> <span style="font-size:11px;">(ada duta murid dan transaksi >= Rp 1.000.000,-)</span></label>
                        </div>
                        <div class="col-xs-9">
                            <select class="field size2" id="disc" name="disc">
                				<option value="1" <?php if($request->request_get_disc==1){ echo "selected";}?>>Ya</option>
                				<option value="0" <?php if($request->request_get_disc==0){ echo "selected";}?>>Tidak</option>
                            </select>
                        </div>
                    </div>
                    <div class="col-xs-12 form-input">
                        <div class="col-xs-3">
                            <label>Tingkat Pendidikan</label>
                        </div>
                        <div class="col-xs-9">
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
                        </div>
                    </div>
                    <div class="col-xs-12 form-input">
                        <div class="col-xs-3">
                            <label>Mata Pelajaran</label>
                        </div>
                        <div class="col-xs-9">
            			    <input type="hidden" id="sesi_matpel" value="<?php echo $kelas->matpel_id; ?>"/>
                            <select class="select" id="matpel" name="matpel">
                            </select>
                        </div>
                    </div>
                    <div class="col-xs-12 form-input">
                        <div class="col-xs-3">
                            <label>Provinsi</label>
                        </div>
                        <div class="col-xs-9">
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
                        </div>
                    </div>
                    <div class="col-xs-12 form-input">
                        <div class="col-xs-3">
                            <label>Lokasi</label>
                        </div>
                        <div class="col-xs-9">
                			<input type="hidden" id="sesi_lokasi" value="<?php echo $lokasi->lokasi_id;?>"/>
                            <select class="select" id="ddLokasi" name="lokasi">
                            </select>
                        </div>
                    </div>
                    <div class="col-xs-12 form-input">
                        <div class="col-xs-3">
                            <label>Tanggal Mulai</label>
                        </div>
                        <div class="col-xs-9">
                            <input id="mulai" name="mulai" type="text" class="field" size="15px" value="<?php echo $kelas->kelas_mulai;?>"/>
                        </div>
                    </div>
                    <div class="col-xs-12 form-input">
                        <div class="col-xs-3">
                            <label>Catatan</label>
                        </div>
                        <div class="col-xs-9">
                            <textarea class="field col-xs-10" rows="4" cols="10" name="catatan"><?php echo $kelas->kelas_catatan;?></textarea>
                        </div>
                    </div>
                </div>
                <!-- End Form -->
                <!-- Form Buttons -->
                <div class="buttons" style="width:98.5%">
                    <input type="submit" class="button" value="Submit" style="width:100px;height:30px;font-size:13px;" />
                </div>
                <!-- End Form Buttons -->
            </form>
        </div>

        <div class="tab-pane fade edit-content row col-xs-12" id="invoices">
            <div class="row" style="text-align:right;padding-bottom:10px;margin:0px;background:rgb(239, 202, 75);padding-top:10px;
                                        width:96.5%;padding-right:20px;">
                <button id="tambah-invoice" class="button buttom-smaller">+ Tambah Invoice</button>
                <a href="<?php echo base_url().'admin/reminder/add/'.$kelas->kelas_id;?>" class="button">Add Reminder</a>
            </div>
            <div id="new-invoice" class="row" style="margin:0px;display:none;width:96.5%">
                
            </div>
            
            <?php if(sizeof($invoice)>0) {
                foreach($invoice as $inv) { ?>
                <div class="row" style="width:96.5%;margin:10px 0px 10px 0px;">
                    <div class="col-xs-6" style="padding:0px;">
                        <div class="col-xs-12" style="text-align:right">
                            <a href="#" class="submit-pembayaran" value="<?php echo $inv['id']?>"><i class="glyphicon glyphicon-upload"></i>Submit Pembayaran</a>
                            <a type="button" class="printInvoiceButton" value="<?php echo $inv['id']?>" style="width:70px;"
                                href="<?php echo base_url()?>admin/kelas/print_invoice/<?php echo $inv['id']?>" target="_blank">
                                <i class="glyphicon glyphicon-print"></i>&nbsp;Print&nbsp;
                            </a>
                            <a type="button" class="deleteInvoiceButton" value="<?php echo $inv['id']?>"  style="width:70px;"
                                href="<?php echo base_url()?>admin/kelas/delete_invoice/<?php echo $inv['id']?>/<?php echo $kelas->kelas_id ?>">
                                <i class="glyphicon glyphicon-trash"></i>&nbsp;Hapus
                            </a>
                        </div>
                        <form id="add-kelas" action="<?php echo base_url();?>admin/kelas/invoice_edit" method="post" style="margin-bottom:10px;">
                            <!-- Form -->
                            <div class="row" style="margin:0px;width:98.5%;background:rgb(238, 238, 238)">
                                <div class="col-xs-12 form-input" style="padding-top:10px;">
                                    <div class="col-xs-5">
                                        <label>ID Invoice</label>
                                    </div>
                                    <div class="col-xs-7">
                                        <input id="id_invoice" type="text" class="field col-xs-3" value="<?php echo $inv['id']; ?>" disabled="disabled"/>
                                        <input type="hidden" name="id" value="<?php echo $inv['id'];?>"/>
                                        <input type="hidden" name="kelas_id" value="<?php echo $inv['kelas_id'];?>"/>
                                    </div>
                                </div>
                                <div class="col-xs-12 form-input">
                                    <div class="col-xs-5">
                                        <label>Lama Belajar</label>
                                    </div>
                                    <div class="col-xs-7">
                                        <input id="total_pertemuan_<?php echo $inv['id']?>" type="text" class="pertemuan-invoice field col-xs-3" name="total_pertemuan" 
                                            value="<?php echo $inv['frekuensi']; ?>" />
                                        <p class="col-xs-9" style="margin-top:5px;margin-left:-10px;">&nbsp;Pertemuan</p>
                                    </div>
                                </div>
                                <div class="col-xs-12 form-input">
                                    <div class="col-xs-5">
                                        <label>Lama Jam Belajar</label>
                                    </div>
                                    <div class="col-xs-7">
                                        <input id="durasi_<?php echo $inv['id']?>" type="text" class="durasi-invoice field col-xs-3" name="durasi" value="<?php if($inv['durasi'] == 0) { echo "0"; } 
                                            else { echo $inv['durasi']; } ?>"/>
                                        <p class="col-xs-9" style="margin-top:5px;margin-left:-10px;">&nbsp;Jam / Pertemuan</p>
                                    </div>
                                </div>
                                <div class="col-xs-12 form-input">
                                    <div class="col-xs-5">
                                        <label>Harga per Jam</label>
                                    </div>
                                    <div class="col-xs-7">
                                        <input id="harga_<?php echo $inv['id']?>" type="text" class="harga-invoice field col-xs-5" name="harga" value="<?php echo $inv['harga_perjam'];?>" />
                                    </div>
                                </div>
                                <div class="col-xs-12 form-input">
                                    <div class="col-xs-5">
                                        <label>Total Jam Belajar<br/><span style="font-size:11px">(Lama Belajar x Lama Jam Belajar per Minggu)</span></label>
                                    </div>
                                    <div class="col-xs-7">
                                        <input id="total_jam_<?php echo $inv['id']?>" type="text" class="field col-xs-3"  name="total_jam" value="<?php echo $inv['total_jam'];?>" />
                                        <p class="col-xs-9" style="margin-top:5px;margin-left:-10px;">&nbsp;Jam</p>
                                    </div>
                                </div>
                                <div class="col-xs-12 form-input">
                                    <div class="col-xs-5">
                                        <label>Total Harga<br/><span style="font-size:11px">(Total Jam Belajar x Harga per Jam)</span></label>
                                    </div>
                                    <div class="col-xs-7">
                                        <input id="total_semua_<?php echo $inv['id']?>" type="text" class="field col-xs-5" name="total_semua" value="<?php echo $inv['total_jam']*$inv['harga_perjam'];?>" />
                                    </div>
                                </div>
                                <div class="col-xs-12 form-input">
                                    <div class="col-xs-5">
                                        <label>Dapat Diskon  <br/> <span style="font-size:11px;">(ada duta murid dan transaksi >= Rp 1.000.000,-)</span></label>
                                    </div>
                                    <div class="col-xs-7">
                                        <input type="text" class="field size2 col-xs-5 disc" id="discount_<?php echo $inv['id']?>" name="disc" value="<?php echo $inv['diskon']?>">
                                    </div>
                                </div>
                                <div class="col-xs-12 form-input">
                                    <div class="col-xs-5">
                                        <label>Total yang Harus Dibayar<br/><span style="font-size:11px">(Total Jam Belajar x Harga per Jam)</span></label>
                                    </div>
                                    <div class="col-xs-7">
                                        <input id="total_harga_<?php echo $inv['id']?>" type="text" class="field col-xs-5" name="total_harga" value="<?php echo $inv['harga_total'];?>" />
                                    </div>
                                </div>
                                <div class="col-xs-12 form-input">
                                    <div class="col-xs-5">
                                        <label>Link Pembayaran</label>
                                    </div>
                                    <div class="col-xs-7">
                                        <a href="<?php echo $inv['url']?>" target="_blank" style="background-color:transparent !important;word-wrap:break-word;"><?php echo $inv['url']?></a>
                                    </div>
                                </div>		  
                            </div>
                            <!-- End Form -->
                            
                            <!-- Form Buttons -->
                            <div class="buttons" style="width:98.5%">
                                <a href="<?php echo base_url()?>admin/kelas/email_invoice/<?php echo $inv['id']?>/<?php echo $inv['kelas_id']?>">
                                    <button type="button" class="button" style="width:100px;height:30px;font-size:13px;">Email Invoice</button></a>
                                <input type="submit" class="button" value="Simpan" style="width:100px;height:30px;font-size:13px;" />
                            </div>
                            <!-- End Form Buttons -->
                        </form>
                    </div>
                    <div class="col-xs-6" style="padding:0px">
                        <div class="row" style="margin:0px;width:98.5%;">
                            <!-- Form -->
                            <?php
                                $total_harga = $inv['harga_total'];
                            ?>
                            <table class="table" style="width:100%">
                                <thead>
                                    <th>Waktu</th>
                                    <th>Jumlah</th>
                                    <th>Diskon</th>
                                    <th>Rekening</th>
                                    <th>Disubmit Oleh</th>
                                    <th>Status</th>
                                    <th>Action</th>
                                </thead>
                                <tbody>

                                <?php 
                                    $total_terbayar = 0;
                                    $count = 0;
                                    if(sizeof($pembayaran)>0) {
                                    foreach($pembayaran as $data) {
                                        $count = 0; 
                                        if($data['invoice_id']==$inv['id']) {
                                            $total_harga = $data['harga_total'];
                                            $total_terbayar += $data['jumlah']; ?>
                                            <tr id="payment-<?php echo $data['id'] ?>">
                                                <td><?php echo date('d-m-Y', strtotime($data['waktu_pembayaran'])) ?></td>
                                                <td><?php $val = number_format($data['jumlah'],0,",","."); echo 'Rp. '.$val; ?></td>
                                                <td><?php $disc = number_format($data['diskon'],0,",","."); echo 'Rp. '.$disc; ?></td>
                                                <td><?php echo $data['rekening'] ?></td>
                                                <td>
                                                    <?php if($data['submit_by']==0){
                                                        echo 'Murid';
                                                    } else {
                                                        echo 'Admin';
                                                    } ?>
                                                </td>
                                                <td><a href="<?php echo base_url()?>admin/kelas/ubah_status_pembayaran/<?php echo $data['id'] ?>/<?php echo $data['kelas_id'] ?>" style="color:black">
                                                    <?php if($data['is_confirm']==1){ echo '<span style="color:green">Confirmed</span>';} else { echo 'Unconfirmed'; } ?></a>
                                                </td>
                                                <td width="70px;">
                                                    <?php if(file_exists('./'.$data['bukti']) && strlen($data['bukti'])>0) {?>
                                                        <a href="<?php echo base_url().$data['bukti']?>" title="Pembayaran" target="_blank">
                                                            <i class="glyphicon glyphicon-search"></i>
                                                        </a>
                                                    <?php } ?>
                                                    <a href="#<?php echo $data['id'] ?>" class="kirim-pembayaran" title="Email Bukti Pembayaran"><i class="glyphicon glyphicon-envelope"></i></a>
                                                    <a href="#<?php echo $data['id'] ?>" class="modal-edit-invoice" title="Edit Pembayaran"><i class="glyphicon glyphicon-pencil"></i></a>
                                                    <a href="<?php echo base_url()?>admin/kelas/delete_pembayaran/<?php echo $data['id']?>/<?php echo $kelas->kelas_id?>" class="delete_pembayaran" 
                                                        value="<?php echo $data['id'] ?>" title="Delete Pembayaran"><i class="glyphicon glyphicon-remove" style="color:red"></i></a>
                                                </td>
                                            </tr>
                                    <?php $count++; } 
                                            } 
                                        } ?>
                                    <?php if ($count==0) {
                                        echo '<td colspan="7" style="text-align:center;font-style:italic">Belum ada pembayaran dari murid</td>';
                                    } ?>
                                    <tr style="font-weight:bold;background-color:rgb(254, 247, 228);">
                                        <td colspan="4" style="text-align:center;font-weight:bold;font-style:italic">Total Terbayar</td>
                                        <td colspan="3"><?php echo 'Rp. '.number_format($total_terbayar,2,",",".") ?></td>
                                    </tr>
                                    <tr style="font-weight:bold;background-color:rgb(254, 247, 228);">
                                        <td colspan="4" style="text-align:center;font-weight:bold;font-style:italic">Sisa Pembayaran</td>
                                        <td colspan="3"><?php if($total_harga - $total_terbayar <0 ) { echo '0'; } else { echo 'Rp. '.number_format($total_harga - $total_terbayar,2,",","."); } ?></td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
                <?php } 
        } ?>
            </div>
        <div class="tab-pane fade edit-content" id="payment-murid">
            <div class="row" style="margin:0px;width:98.5%">
                <!-- Form -->
                <?php
                    $total_harga = 0;
                    foreach($invoice as $inv){
                        $total_harga += $inv['harga_total'];
                    }
                ?>
                <div style="text-align:right;margin:10px;font-weight:bold;font-size:14px;">
                    Progress Pembayaran : <?php if($total_harga > 0) echo number_format(($total_terbayar/$total_harga)*100,2) ?>%
                </div>
                <table class="table" style="width:100%">
                    <thead>
                        <th>Pembayaran Ke-</th>
                        <th>Jumlah Pembayaran</th>
                        <th>Waktu Pembayaran</th>
                        <th>Rekening Pembayaran</th>
                        <th>Bukti Pembayaran</th>
                        <th>Disubmit Oleh</th>
                        <th>Status</th>
                    </thead>
                    <tbody>

                    <?php $count = 1; 
                        if(sizeof($pembayaran)>0) {
                        foreach($pembayaran as $data) { ?>
                        <tr id="payment-<?php echo $data['id'] ?>">
                            <td><?php echo $count ?></td>
                            <td><?php $val = number_format($data['jumlah'],0,",","."); echo 'Rp. '.$val; ?></td>
                            <td><?php echo $data['waktu_pembayaran'] ?></td>
                            <td><?php echo $data['rekening'] ?></td>
                            <td style="text-align:center">
                                <?php if(file_exists('./'.$data['bukti'])) {?>
                                    <img src="<?php echo base_url().$data['bukti']?>" style="height:50px;">
                                <?php } else { echo '&nbsp;'; } ?>
                            </td>
                            <td>
                                <?php if($data['submit_by']==0){
                                    echo 'Murid';
                                } else {
                                    echo 'Admin';
                                } ?>
                            </td>
                            <td><a href="<?php echo base_url()?>admin/kelas/ubah_status_pembayaran/<?php echo $data['id'] ?>/<?php echo $data['kelas_id'] ?>">
                                <?php if($data['is_confirm']==1){ echo 'Confirmed';} else { echo 'Belum Dikonfirmasi'; } ?></a>
                            </td>
                        </tr>
                    <?php $count++; } ?>
                    <?php } else {
                        echo '<td colspan="6" style="text-align:center;font-style:italic">Belum ada pembayaran dari murid</td>';
                        } ?>
                        <tr style="font-weight:bold;background-color:rgb(254, 247, 228);">
                            <td colspan="4" style="text-align:center;font-weight:bold;font-style:italic">Total Terbayar</td>
                            <td colspan="3"><?php echo 'Rp. '.number_format($total_terbayar,2,",",".") ?></td>
                        </tr>
                        <tr style="font-weight:bold;background-color:rgb(254, 247, 228);">
                            <td colspan="4" style="text-align:center;font-weight:bold;font-style:italic">Sisa Pembayaran</td>
                            <td colspan="3"><?php echo 'Rp. '.number_format($total_harga - $total_terbayar,2,",",".") ?></td>
                        </tr>
                    </tbody>
                </table>
            </div>
            <div class="box-head" style="width:98.5%;height:30px;border-radius:5px;">
                <h4 style="padding-top:5px;">Update Status Pembayaran Murid</h4>
            </div>
            <!-- End Box Head -->            
        </div>
        <div class="tab-pane fade edit-content" id="payment-guru">
            <!-- End Box Head -->
            <div class="row" style="text-align:right;padding-bottom:10px;margin:0px;background:rgb(239, 202, 75);padding-top:10px;
                                        width:98.5%;padding-right:20px;">
                <button id="tambah-pembayaran-guru" class="button buttom-smaller">Submit Pembayaran</button>
            </div>
            <!-- Form -->
            <div class="form row">
                <table class="col-xs-12 table" style="width:98.5%">
                    <thead>
                        <tr>
                            <th>Nomor</th>
                            <th>Tanggal Pembayaran</th>
                            <th>Jumlah Pembayaran</th>
                            <th>PPH</th>
                            <th>Nominal PPH</th>
                            <th>Jumlah Terkirim</th>
                            <th>Bukti Pembayaran</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php $count = 0; foreach($pembayaran_guru as $pguru){ ?>
                            <tr>
                                <td><?php echo ++$count; ?></td>
                                <td><?php if($pguru['tanggal']!='0000-00-00') {  echo date('d-m-Y', strtotime($pguru['tanggal'])); } else { echo '00-00-0000';} ?></td>
                                <td><?php echo number_format($pguru['jumlah']/(1-($pguru['pph'])/100),2,',','.') ?></td>
                                <td><?php echo number_format($pguru['pph'],2,',','.') ?>%</td>
                                <td><?php echo number_format($pguru['jumlah']/(1-($pguru['pph'])/100)-$pguru['jumlah'],2,',','.') ?></td>
                                <td><?php echo number_format($pguru['jumlah'],2,',','.') ?></td>
                                <td><?php if(strlen($pguru['bukti_pembayaran'])>0 && $pguru['bukti_pembayaran']!=null) { ?> 
                                        <center class="field col-xs-12" style="height:34px">
                                            <a href="<?php echo base_url()?>files/payment_guru/<?php echo $pguru['bukti_pembayaran'] ?>" target="_blank"><i class="glyphicon glyphicon-search"></i>View<br/></a>
                                        </center>
                                    <?php } ?>
                                </td>
                                <td>
                                    <a href="<?php echo base_url()?>admin/kelas/email_pembayaran_guru/<?php echo $pguru['kelas_id']?>/<?php echo $pguru['id']?>/">
                                        <i class="glyphicon glyphicon-envelope"></i> Email
                                    </a>
                                    <a href="#<?php echo $pguru['id']; ?>" class="edit-pembayaran-guru" 
                                        data-jumlah="<?php echo $pguru['jumlah']?>"
                                        data-tanggal="<?php echo $pguru['tanggal']?>"
                                        data-pph="<?php echo $pguru['pph']?>">
                                        <i class="glyphicon glyphicon-pencil"></i> Edit
                                    </a>
                                    <a href="<?php echo base_url()?>admin/kelas/hapus_pembayaran_guru/<?php echo $pguru['kelas_id']?>/<?php echo $pguru['id']?>/"
                                        class="delete-pembayaran-guru" value="<?php echo $count?>">
                                        <i class="glyphicon glyphicon-trash"></i> Hapus</a>
                                </td>
                            </tr>                
                        <?php } ?>        
                    </tbody>
                </table>
                <div class="row">
                    <div class="col-xs-12" style="margin-left:20px">
                        <em>Keterangan : </em></br>
                        <em><input type="checkbox" disabled <?php echo (!empty($guru->guru_npwp_image) && strlen($guru->guru_npwp_image)>0 ? 'checked' : ''); ?> > 
                                Guru <?php echo !empty($guru->guru_npwp_image) && strlen($guru->guru_npwp_image)>0 ? '' : 'Tidak'; ?> Memiliki 
                                <?php if(!empty($guru->guru_npwp_image) && strlen($guru->guru_npwp_image)>0) { ?>
                                    <a href="<?php echo base_url()?>files/npwp/<?php echo $guru->guru_npwp_image?>" target="_blank">NPWP</a>&nbsp;
                                    <?php if($guru->guru_npwp_verified==0) { ?>
                                        (Belum diverifikasi)
                                    <?php } ?>
                                <?php } else { ?>
                                    NPWP
                                <?php } ?> 
                        </em></br>
                        <em><input type="checkbox" disabled <?php echo (!empty($guru->guru_ket_pajak_image) && strlen($guru->guru_ket_pajak_image)>0?'checked' : ''); ?>> 
                                Guru Guru <?php echo (!empty($guru->guru_ket_pajak_image) && strlen($guru->guru_ket_pajak_image)>0 ? '' : 'Tidak'); ?> Memiliki 
                                <?php if(!empty($guru->guru_ket_pajak_image) && strlen($guru->guru_ket_pajak_image)>0) { ?>
                                    <a href="<?php echo base_url()?>files/keterangan_pajak/<?php echo $guru->guru_ket_pajak_image?>" target="_blank">Surat Pernyataan</a>&nbsp;
                                    <?php if($guru->guru_ket_pajak_verified==0) { ?>
                                        (Belum diverifikasi)
                                    <?php } ?>
                                <?php } else { ?>
                                    Surat Pernyataan
                                <?php } ?>
                        </em></br>
                    </div>
                </div>
            </div>    
        </div>
        <div class="tab-pane fade edit-content" id="payment-duta"> 
            <!-- Box Head -->
            <div style="width:98.5%">
                <div class="box-head">
                    <h2>Pembayaran Duta Guru</h2>
                </div>
                <!-- End Box Head -->

                <form id="add-kelas" action="<?php echo base_url();?>admin/kelas/update_pembayaran_dutaguru_submit" method="post" >

                    <!-- Form -->
                    <div class="form">
                        <p>
                         <?php $cek_duta = $this->kelas_model->get_status_pembayaran_duta($kelas->guru_id, $kelas->duta_guru_id);?>
                            <label>Jumlah Terbayar Ke Duta dari Guru (Manual)</label>
                          <p>(3% Total Harga) </p>
                         <input type="hidden" name="id" value="<?php echo $kelas->kelas_id;?>"/>
                            <input type="text" class="field size2" id="to_duta_guru" name="to_duta_guru"  value="<?php echo $kelas->kelas_pembayaran_duta_guru;?>"  style="float:left;"/>&nbsp;<?php if(!empty($cek_duta) && ($cek_duta->kelas_id != $kelas->kelas_id)){ ?><img src="<?php echo base_url().'images/sudah-dibayar.png' ?>" width="100px"/><?php  }  ?>
                        </p>
                    </div>
                    <!-- End Form -->
                    
                    <!-- Form Buttons -->
                    <div class="buttons">
                        <input type="submit" class="button" value="Submit" />&nbsp;<a href="<?php echo base_url().'admin/kelas/send_invoice_duta/'.$kelas->kelas_id;?>" class="button">Kirim Bukti Pembayaran ke Duta Guru</a>
                    </div>
                    <!-- End Form Buttons -->
                </form>
                <!-- Box Head -->
                <div class="box-head">
                    <h2>Pembayaran Duta Murid</h2>
                </div>
                <!-- End Box Head -->

                <form id="add-kelas" action="<?php echo base_url();?>admin/kelas/update_pembayaran_dutamurid_submit" method="post" >

                    <!-- Form -->
                    <div class="form">
            		  <p>
                            <label>Jumlah Terbayar Ke Duta dari Murid (Manual)</label>
            			  <p>(3% Total Harga)</p>
            			 <input type="hidden" name="id" value="<?php echo $kelas->kelas_id;?>"/>
                            <input type="text" class="field size2" id="to_duta_murid" name="to_duta_murid"  value="<?php echo $kelas->kelas_pembayaran_duta_murid;?>"  />
                        </p>
                    </div>
                    <!-- End Form -->
                    
                    <!-- Form Buttons -->
                    <div class="buttons">
                        <input type="submit" class="button" value="Submit" />&nbsp;<a href="<?php echo base_url().'admin/kelas/send_invoice_duta_murid/'.$kelas->kelas_id;?>" class="button">Kirim Bukti Pembayaran ke Duta Murid</a>
                    </div>
                    <!-- End Form Buttons -->
                </form>
            </div>
        </div>
        <div  class="tab-pane fade edit-content row" id="kelas-pertemuan">
            <div style="width:98.5%">
                <div class="col-xs-5">
                    <!-- Box Head -->
                    <div class="box-head"  style="background-color:rgb(239, 202, 75);border-radius:0px;">
                        <h2>Generate Jadwal</h2>
                    </div>
                    <!-- End Box Head -->   
                    <form id="fom-generate-jadwal" action="<?php echo base_url();?>admin/kelas/generate_jadwal/" method="post">
                        <!-- Table -->
                        <div class="col-xs-12" style="margin-bottom:10px;margin-top:10px;">
                            <div class="col-xs-12">
                                <div class="col-xs-6">
                                    <label>Tanggal Mulai</label>
                                </div>
                                <div class="col-xs-6">
                                    <input id="mulai_invoice" type="text" style="text-indent:5px;" name="mulai" value="<?php echo $kelas->kelas_mulai?>" />
                                </div>
                            </div>
                            <div class="col-xs-12">
                                <div class="col-xs-6">
                                    <label>Lama Pertemuan</label>
                                </div>
                                <div class="col-xs-6">
                                    <input type="text" name="lama" style="width:50px;text-align:center;" value="<?php echo $kelas->kelas_durasi?>" /> Jam
                                </div>
                            </div>
                            <div class="col-xs-12">
                                <div class="col-xs-6">
                                    <label>Frekuensi</label>
                                </div>
                                <div class="col-xs-6">
                                    <input type="text" name="frekuensi" style="width:50px;text-align:center;" value="<?php echo $kelas->kelas_frekuensi?>" /> Pertemuan
                                </div>
                            </div>
                        </div>
                        <br/>
                        <div class="col-xs-12 table-responsive">
                            <table id="jadwal-guru-table-form" class="table-bordered" style="width:100%">
                                <tr style="height:15px;">
                                    <th style="width: 45px;">Jam</th>
                                    <?php foreach ($days as $value): ?>
                                        <th style="text-align:center;">
                                            <?php echo $value; ?>
                                        </th>
                                    <?php endforeach; ?>
                                </tr>
                                <?php for ($i = 7; $i < 22; $i++): ?>
                                    <tr>
                                        <th style="text-align:center;"><?php echo sprintf('%02s', $i); ?>:00</th>
                                        <?php for ($j = 0; $j < 7; $j++): ?>
                                            <td class="jadwal-kelas" id="<?php echo $i.$j; ?>">
                                                <input type="checkbox" class="jadwal-checkbox" id="ckbox-<?php echo $i.$j; ?>" 
                                                    value="<?php $hari = $j+1; echo $hari.",".$i; ?>" name="jadwal[]"/>
                                            </td>
                                        <?php endfor; ?>
                                    </tr>
                                <?php endfor; ?>
                            </table>
                        </div>
                        <div class="col-xs-12" style="text-align:right;margin-bottom:20px;margin-top:10px;">
                            <input type="hidden" name="id_kelas" value="<?php echo $this->session->userdata('u_last_kelas_id') ?>" />
                            <button type="submit" class="button" style="width:100px;height:30px;font-size:13px;">Generate</button>
                        </div>
                    </form>
                </div>
                
                <div class="col-xs-7">
                    <!-- Box Head -->
                    <div class="box-head" style="background-color:rgb(239, 202, 75);border-radius:0px;">
                        <h2>Kelas Pertemuan</h2>
                    </div>
                    <!-- End Box Head -->   

                    <!-- Table -->
                    <div class="table">
                        <table width="100%" border="0" cellspacing="0" cellpadding="0">
                            <tr>
                                <th>No</th>
                                <th>Tanggal</th>
                                <th>Mulai</th>
                                <th>Selesai</th>
                                <th>Status</th>
                                <th class="center" colspan="2">Action</th>
                            </tr>
                            <?php $i=0;?>
                            <?php foreach($pertemuan->result() as $g):?>
                            <tr <?php echo (($i++%2)!=0)?'class="odd"':'';?>>
                                <td><?php echo $i;?></td>
                                <td><?php echo date('d-M-Y',strtotime($g->kelas_pertemuan_date));?></td>
                                <td><?php echo $g->kelas_pertemuan_jam_mulai;?></td>
                                <td><?php echo $g->kelas_pertemuan_jam_selesai;?></td>
                                <td>
                                    <?php echo $g->kelas_pertemuan_status_title;?>
                                </td>
                            <td class="center">
                                    <a href="<?php echo base_url();?>admin/kelas/edit_kelas_pertemuan/<?php echo $g->kelas_pertemuan_id;?>" class="ico edit">edit</a>
                                </td>
                                <td class="center">
                                    <a href="<?php echo base_url();?>admin/kelas/delete_kelas_pertemuan/<?php echo $g->kelas_pertemuan_id;?>" class="ico del">delete</a>
                                </td>
                            </tr>
                            <?php endforeach;?>
                        </table>

                    </div>
                    <!-- Table -->
                    
                </div>
                <!--
                <form id="add-pertemuan" action="<?php echo base_url();?>admin/kelas/add_pertemuan_submit" method="post" >

                    <!-- Form -->
                    <!--
                    <div class="form">
                        <p>
                            <label>Tanggal Pertemuan</label>
                            <input id="date" type="text" class="field size2 validate[required]" name="date" />
                            <input type="hidden" name="id" value="<?php echo $kelas->kelas_id;?>"/>
                        </p>
                        <p>
                            <label>Jam Mulai</label>
                            <select class="inline-field size5" name="mulai_jam">
                                <?php for($i=6;$i<24;$i++):?>
                                <option value="<?php echo $i;?>"><?php echo str_pad($i, 2,"0",STR_PAD_LEFT);?></option>
                                <?php endfor;?>
                            </select>
                            <select class="inline-field size5" name="mulai_menit">
                                <option value="00">00</option>
                                <option value="15">15</option>
                                <option value="30">30</option>
                                <option value="45">45</option>
                            </select>
                        </p>
                        <p>
                            <label>Jam Selesai</label>
                            <select class="inline-field size5" name="selesai_jam">
                                <?php for($i=6;$i<24;$i++):?>
                                <option value="<?php echo $i;?>"><?php echo str_pad($i, 2,"0",STR_PAD_LEFT);?></option>
                                <?php endfor;?>
                            </select>
                            <select class="inline-field size5" name="selesai_menit">
                                <option value="00">00</option>
                                <option value="15">15</option>
                                <option value="30">30</option>
                                <option value="45">45</option>
                            </select>
                            <span class="clear"></span>
                        </p>
                    </div> -->
                    <!-- End Form -->
                    
                    <!--
                    <div class="buttons">
                        <input type="submit" class="button" value="submit" />
                    </div>
                </form> -->
            </div>
        </div>
        <div class="tab-pane fade edit-content" id="kelas-feedback">
            <div style="width:98.5%">
                <!-- Table -->
                <div class="col-xs-12" style="text-align:right;background-color:rgb(239, 202, 75);height:40px;">
                    <a href="<?php echo base_url().'admin/kelas/request_feedback/'.$kelas->kelas_id;?>" style="background-color:transparent !important;">
                        <button class="button" style="margin-top:10px;margin-right:10px;"> Request Feedback </button>
                    </a>
                    <a href="<?php echo base_url().'admin/kelas/add_feedback/'.$kelas->kelas_id;?>" style="background-color:transparent !important;">
                        <button class="button" style="margin-top:10px"> Add Feedback </button>
                    </a>
                    <?php if($feedback->num_rows() > 0) {  ?>
                    <a href="<?php echo base_url().'admin/kelas/edit_feedback/'.$kelas->kelas_id;?>" style="background-color:transparent !important;">
                        <button class="button" style="margin-top:10px"> Edit Feedback </button>
                    </a>
                    <?php } ?>
                </div>
                <div class="form col-xs-12">
                    <table cellspacing="10" class="table">
                		<tr>
                			<th>No.</th>
                			<th>Pertanyaan</th>
                			<th>Feedback dari Murid</th>
                			<th>Skor Feedback</th>
                		</tr>
                		<?php 
                			$i = 1;
                			if($feedback->num_rows() > 0) { 
                			foreach($feedback->result() as $row):
                		?>
                    		<tr>
                    			<td class="center"><?php echo $i++;?></td>
                    			<td><?php echo $row->feedback_question_title;?></td>
                    			<td style="padding-left:22px;"><?php echo $row->feedback_answer_title;?></td>
                    			<td class="center">
                                    <?php $score = floatval($row->feedback_answer_score);
                                        echo $row->feedback_answer_sort;
                                        $rate = $row->feedback_answer_sort;;
                    				?>
                    			</td>
                    		</tr>
                    		<?php $total_feedback[]= $rate;?>
                    		<?php endforeach;?>
                    		<tr>
                    			<td>&nbsp;</td>
                    			<td>&nbsp;</td>
                    			<?php $avg1 = ($total_feedback[0]+$total_feedback[1]+$total_feedback[2]+$total_feedback[3])/4;?>
                    			<?php $avg2 = ($total_feedback[0]+$total_feedback[1]+$total_feedback[2]
                                                +$total_feedback[3]+$total_feedback[4]+$total_feedback[5])/6;?>
                    			<td style="padding-left:22px;"><strong>Total Skor Feedback</strong></td>
                    			<td class="center"><strong><?php echo round($avg2, 2);?></strong></td>
                    		</tr>
                    		<tr>
                    			<td>&nbsp;</td>
                    			<td>&nbsp;</td>
                    			<td style="padding-left:22px;"><strong>Rating Guru</strong></td>
                    			<td class="center"><strong><?php echo floatval($kelas->guru_rating);?></strong></td>
                    		</tr>
                    		<tr>
                    			<td>&nbsp;</td>
                    			<td>&nbsp;</td>
                    			<td style="padding-left:22px;"><strong>Total Rating Guru</strong></td>
                    			<td class="center"><strong>
                                    <?php 
                                        $total_rate = floatval($kelas->guru_rating) + 0.1*$avg2*$row->kelas_frekuensi*$row->kelas_durasi; 
                                        echo round($total_rate, 2);
                                    ?>
                                </strong></td>
                    		</tr>
                    		<?php } else { ?>
                    		<tr>
                    			<td class="center">-</td>
                    			<td class="center">-</td>
                    			<td>Belum ada feedback dari murid</td>
                    			<td class="center">0</td>
                    		</tr>
                		<?php } ?>
                    </table>
                    <br/>
                    <div class="col-xs-12" style="background-color:rgb(251, 252, 252);padding-bottom:10px;">
                        <div class="col-xs-2">
                            <label>Testimoni</label>
                        </div>
                        <div class="col-xs-10">
                            <textarea class="field col-xs-12" rows="5" cols="30" name="testimoni" disabled><?php echo $kelas->kelas_testimoni;?>
                            </textarea>
                        </div>
                    </div>
            	   
            	    <form action="<?php echo base_url().'admin/kelas/update_rating/'.$kelas->guru_id; ?>" method="post">
                		<?php if($feedback->num_rows() > 0) { ?>
                            <input type="hidden" id="skor" name="skor" value="<?php echo round($total_rate, 2);?>"/>
                            <input type="hidden" id="kelas_id" name="kelas_id" value="<?php echo $kelas->kelas_id;?>"/>
                		<?php }else{ ?>
                            <input type="hidden" id="skor" name="skor" value=""/>
                            <input type="hidden" id="kelas_id" name="kelas_id" value="<?php echo $kelas->kelas_id;?>"/>
                		<?php }?>
                        <div class="buttons">
                           <input type="submit" class="button" value="Update Rating" style="width:100px;height:30px;font-size:12px;margin-top:10px;"/>
                        </div>
            	   </form>
                </div>
            </div>
        </div>
        <div class="tab-pane fade edit-content" id="status-kelas">
            <div style="width:98.5%">
                <div class="table col-xs-12">
                    <table class="table">
                        <thead>
                            <tr>
                                <th colspan="2"> Status Kelas</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td>
                                    <label><input type="radio" name="status[]" value="1" class="status-kelas"
                                                <?php if($kelas->kelas_status==1) echo 'checked';?> >Aktif</label>
                                </td>
                                <td>
                                    <label><input type="radio" name="status[]" value="0" class="status-kelas"
                                                <?php if($kelas->kelas_status==0) echo 'checked';?>>Tidak Aktif</label>
                                    <input type="hidden" id="id-kelas-status" value="<?php echo $kelas->kelas_id?>">
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="modalAddInvoice" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title">Tambah Invoice</h4>
            </div>
            <!-- Form -->
            <form id="add-kelas" action="<?php echo base_url();?>admin/kelas/invoice_add" method="post" 
                    style="margin-bottom:10px;width:100%">
                <div class="modal-body">
                    <div class="row" style="margin:0px;background:rgb(238, 238, 238);padding-top:10px;">
                        <div class="col-xs-12 form-input">
                            <div class="col-xs-5">
                                <label>Lama Belajar</label>
                            </div>
                            <div class="col-xs-7">
                                <input type="hidden" id="kelas_id" name="kelas_id" value="<?php echo $kelas->kelas_id ?>" />
                                <input id="total_pertemuan_" type="text" class="pertemuan-invoice field col-xs-3" name="total_pertemuan" 
                                    value="0" />
                                <p class="col-xs-9" style="margin-top:5px;margin-left:-10px;">&nbsp;Pertemuan</p>
                            </div>
                        </div>
                        <div class="col-xs-12 form-input">
                            <div class="col-xs-5">
                                <label>Lama Jam Belajar</label>
                            </div>
                            <div class="col-xs-7">
                                <input id="durasi_" type="text" class="durasi-invoice field col-xs-3" name="durasi" value="0"/>
                                <p class="col-xs-9" style="margin-top:5px;margin-left:-10px;">&nbsp;Jam / Pertemuan</p>
                            </div>
                        </div>
                        <div class="col-xs-12 form-input">
                            <div class="col-xs-5">
                                <label>Harga per Jam</label>
                            </div>
                            <div class="col-xs-7">
                                <input id="harga_" type="text" class="harga-invoice field col-xs-5" name="harga" value="0" />
                            </div>
                        </div>
                        <div class="col-xs-12 form-input">
                            <div class="col-xs-5">
                                <label>Total Jam Belajar<br/><span style="font-size:11px">(Lama Belajar x Lama Jam Belajar per Minggu)</span></label>
                            </div>
                            <div class="col-xs-7">
                                <input id="total_jam_" type="text" class="field col-xs-3"  name="total_jam" value="0" />
                                <p class="col-xs-9" style="margin-top:5px;margin-left:-10px;">&nbsp;Jam</p>
                            </div>
                        </div>
                        <div class="col-xs-12 form-input">
                            <div class="col-xs-5">
                                <label>Total Harga<br/><span style="font-size:11px">(Total Jam Belajar x Harga per Jam)</span></label>
                            </div>
                            <div class="col-xs-7">
                                <input id="total_harga_" type="text" class="field col-xs-5" name="total_harga" value="0" />
                            </div>
                        </div>
                        <div class="col-xs-12 form-input">
                            <div class="col-xs-5">
                                <label>Dapat Diskon  <br/> <span style="font-size:11px;">(ada duta murid dan transaksi >= Rp 1.000.000,-)</span></label>
                            </div>
                            <div class="col-xs-7">
                                <input type="text" id="discount_" name="disc" class="field col-xs-5 disc" value="0">
                                <!-- <select class="field size2 col-xs-5" id="disc" name="disc">
                                    <option value="1">Ya</option>
                                    <option value="0" selected>Tidak</option>
                                </select> -->
                            </div>
                        </div>
                        <div class="col-xs-12 form-input">
                            <div class="col-xs-5">
                                <label>Link Pembayaran</label>
                            </div>
                            <div class="col-xs-7">
                                <!-- no link yet -->
                            </div>
                        </div>        
                    </div>
                    <!-- End Form -->
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-primary">Submit</button>
                </div>
            </form>
        </div><!-- /.modal-content -->
    </div><!-- /.modal-dialog -->
</div><!-- /.modal -->

<div class="modal fade" id="pembayaranModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title">Submit Pembayaran</h4>
            </div>
            <form action="<?php echo base_url();?>admin/kelas/update_pembayaran_murid_submit" method="post" 
                    enctype="multipart/form-data">
                <div class="modal-body">
                <!-- Form -->
                    <div class="form row" style="margin:0px;background:rgb(238, 238, 238);padding-top:10px;">
                        <div class="col-xs-12 form-input">
                            <div class="col-xs-5">
                                <label>Invoice ID</label>
                            </div>
                            <div class="col-xs-7">
                                <input type="text" class="field col-xs-6" name="invoice_id" id="submit_invoice_id" required/>
                                <input type="hidden" name="kelas_id" value="<?php echo $kelas->kelas_id;?>"/>
                            </div>
                        </div>
                        <div class="col-xs-12 form-input">
                            <div class="col-xs-5">
                                <label>Jumlah Terbayar Dari Murid (Manual)</label>
                            </div>
                            <div class="col-xs-7">
                                <input type="text" class="field col-xs-6" id="pembayaran_murid" name="pembayaran_murid" 
                                    value="<?php echo $kelas->kelas_pembayaran_murid;?>"  required/>
                            </div>
                        </div>
                        <div class="col-xs-12 form-input">
                            <div class="col-xs-5">
                                <label>Diskon Pembayaran</label>
                            </div>
                            <div class="col-xs-7">
                                <input type="text" class="field col-xs-6" id="diskon_murid" name="diskon_murid" 
                                    value="0" required/>
                            </div>
                        </div>
                        <div class="col-xs-12 form-input">
                            <div class="col-xs-5">
                                <label>Tanggal Verifikasi Pembayaran (Manual)</label>
                            </div>
                            <div class="col-xs-7">
                                <input id="date_verified" type="text" class="field col-xs-6" name="date_verified" 
                                    value="" required/>
                            </div>
                        </div>
                        <div class="col-xs-12 form-input">
                            <div class="col-xs-5">
                                <label>No. Rekening Murid (Manual)</label>
                            </div>
                            <div class="col-xs-7">
                                <input id="no_rek_murid" type="text" class="field col-xs-6" 
                                    name="no_rek_murid" value="<?php echo $kelas->kelas_rek_murid;?>"/>
                            </div>
                        </div>
                        <div class="col-xs-12 form-input">
                            <div class="col-xs-5">
                                <label>Bukti Pembayaran</label>
                            </div>
                            <div class="col-xs-7">
                                <input type="file" class="col-xs-12" name="userfile" />
                            </div>
                        </div>
                    </div>
                    <!-- End Form -->
                
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-primary">Submit</button>
                </div>
            </form>
        </div><!-- /.modal-content -->
    </div><!-- /.modal-dialog -->
</div><!-- /.modal -->

<!-- modal dialog -->
<div class="modal fade" id="modalInvoice" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog" style="width: 800px;">
        <div class="modal-content"  style="margin-top:40px; font-family: Ubuntu;">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title" id="myModalLabel">Invoice</h4>
            </div>
            <div class="modal-body" style="text-align:left; padding: 30px;">
       
                <div class="row">
                    
                    <div id="invoice-wrap" class="col col-xs-9">
                        <table class="table table-bordered tabel-condensed">
                        <tr>
                            <td class="warning" style="width: 200px;">No. Invoice</td>
                            <td class="info" id="no_inv"></td>
                        </tr>
                        <tr>
                            <td class="warning">Ditujukan kepada</td>
                            <td class="info" id="tujuan"></td>
                        </tr>
                        <tr>
                            <td>Nama Guru</td>
                            <td id="nama-guru"></td>
                        </tr>
                        <tr>
                            <td>Mata Pelajaran</td>
                            <td id="matpel-id"></td>
                        </tr>
                        <tr>
                            <td>Kode Kelas</td>
                            <td id="kelas-id"></td>
                        </tr>
                        <tr>
                            <td>Jumlah Sesi</td>
                            <td id="jumlah-sesi"></td>
                        </tr>
                        <tr>
                            <td>Jumlah Jam/Sesi</td>
                            <td id="jumlah-durasi"></td>
                        </tr>
                        <tr>
                            <td>Total Biaya</td>
                            <td id="total-biaya"></td>
                        </tr>
                        <tr>
                            <td>Diskon</td>
                            <td id="total-diskon"></td>
                        </tr>
                        <tr>
                            <td>Total yang Harus Dibayar</td>
                            <td id="total-terbayar"></td>
                        </tr>
                        </table>
                    </div>
                    <div class="col col-xs-3">
                        <button id="printInvoiceButton" class="button button-smaller" style="width:100px;"><i class="glyphicon glyphicon-print"></i>&nbsp;&nbsp;&nbsp;Print</button>
                    </div>
                </div>
              
            </div>
        </div>
    </div>
</div>
<div id="kirim-pembayaran-modal" tabindex="-1" class="modal fade" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog" style="width: 800px;">
        <div class="modal-content" style="margin-top:40px;">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title" id="myModalLabel">Bukti Penerimaan Pembayaran Murid</h4>
            </div>
            <form action="<?php echo base_url();?>admin/kelas/kirim_pembayaran_murid_submit" method="post" 
                        enctype="multipart/form-data">
            <div class="modal-body" style="text-align:left; padding: 30px;">
                <div class="row">
                    <div class="col col-xs-12">
                        <table class="table table-bordered tabel-condensed">
                            <tr>
                                <td class="info" colspan="2">Telah Diterima Dari</td>
                            </tr>
                            <tr>
                                <td style="width: 200px;">Nama Customer</td>
                                <td id="tujuan"><input type="text" id="send_murid_nama" name="nama_customer" class="field col-xs-12" placeholder="Nama Customer" required/></td>
                            </tr>
                            <tr>
                                <td>Untuk Invoice</td>
                                <td>
                                    <input type="text" id="send_invoice_id" name="invoice_id" class="field col-xs-12" placeholder="Nomor Invoice" required/>
                                    <input type="hidden" name="kelas_id" value="<?php echo $kelas->kelas_id;?>"/>
                                </td>
                            </tr>
                            <tr>
                                <td class="info" colspan="2">Di Rekening</td>
                            </tr>
                            <tr>
                                <td>Bank</td>
                                <td id="nama-guru"><input type="text" name="nama_bank" placeholder="Nama Bank Penerima. Misal : Mandiri" class="field col-xs-12" required/></td>
                            </tr>
                            <tr>
                                <td>No. Rekening</td>
                                <td id="matpel-id"><input type="text" name="nomor_rekening"  placeholder="Nomor Rekening" class="field col-xs-12" /></td>
                            </tr>
                            <tr>
                                <td>Atas Nama</td>
                                <td id="matpel-id"><input type="text" name="nama_rekening"  placeholder="Nama Pada Rekening" class="field col-xs-12" required/></td>
                            </tr>
                            <tr>
                                <td>Dengan Jumlah</td>
                                <td id="kelas-id"><input type="text" id="send_jumlah" name="jumlah" placeholder="Jumlah Terkirim (Angka Saja). Misal : 300000" class="field col-xs-12" required/></td>
                            </tr>
                            <tr>
                                <td>Dan Diskon</td>
                                <td id="kelas-id"><input type="text" id="send_diskon" name="diskon" placeholder="Jumlah Diskon (Angka Saja). Misal : 300000" class="field col-xs-12" value="0" required/></td>
                            </tr>
                        </table>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-primary">Submit</button>
                </div>
            </div>
            </form>
        </div>
    </div>
</div>

<!-- end of modal dialog -->
<div class="modal fade" id="EditPembayaranModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title">Edit Pembayaran Murid</h4>
            </div>
            <form action="<?php echo base_url();?>admin/kelas/edit_pembayaran_murid_submit" method="post" 
                    enctype="multipart/form-data">
                <div class="modal-body">
                <!-- Form -->
                    <div class="form row" style="margin:0px;background:rgb(238, 238, 238);padding-top:10px;">
                        <div class="col-xs-12 form-input">
                            <div class="col-xs-5">
                                <label>Jumlah Terbayar Dari Murid (Manual)</label>
                            </div>
                            <div class="col-xs-7">
                                <input type="text" class="field col-xs-6" id="pembayaran_murid_edit" name="pembayaran_murid" required/>
                                <input type="hidden" name="id_pembayaran" id="id_pembayaran">
                                <input type="hidden" name="kelas_id" value="<?php echo $kelas->kelas_id;?>"/>
                            </div>
                        </div>
                        <div class="col-xs-12 form-input">
                            <div class="col-xs-5">
                                <label>Diskon Pembayaran</label>
                            </div>
                            <div class="col-xs-7">
                                <input type="text" class="field col-xs-6" id="diskon_pembayaran_edit" name="diskon_murid" required/>
                            </div>
                        </div>
                        <div class="col-xs-12 form-input">
                            <div class="col-xs-5">
                                <label>Tanggal Verifikasi Pembayaran (Manual)</label>
                            </div>
                            <div class="col-xs-7">
                                <input id="date_verified_edit" type="text" class="field col-xs-6" name="date_verified" required/>
                            </div>
                        </div>
                        <div class="col-xs-12 form-input">
                            <div class="col-xs-5">
                                <label>No. Rekening Murid (Manual)</label>
                            </div>
                            <div class="col-xs-7">
                                <input id="no_rek_murid_edit" type="text" class="field col-xs-6" name="no_rek_murid" />
                            </div>
                        </div>
                        <div class="col-xs-12 form-input">
                            <div class="col-xs-5">
                                <label>Bukti Pembayaran</label>
                            </div>
                            <div class="col-xs-7">
                                <input type="file" class="col-xs-12" name="userfile" />
                            </div>
                        </div>
                    </div>
                    <!-- End Form -->
                
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-primary">Submit</button>
                </div>
            </form>
        </div><!-- /.modal-content -->
    </div><!-- /.modal-dialog -->
</div><!-- /.modal -->

<!-- end of modal dialog -->
<div class="modal fade" id="PembayaranGuruModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title">Submit Pembayaran Guru</h4>
            </div>
            <form action="<?php echo base_url();?>admin/kelas/pembayaran_guru_submit" method="post" 
                    enctype="multipart/form-data">
                <div class="modal-body">
                <!-- Form -->
                    <div class="form row" style="margin:0px;background:rgb(238, 238, 238);padding-top:10px;">
                        <div class="col-xs-12 form-input">
                            <div class="col-xs-5">
                                <label>Jumlah Pembayaran</label>
                            </div>
                            <div class="col-xs-7">
                                <input type="text" class="field col-xs-12" id="jumlah_pembayaran_guru" placeholder="Jumlah Pembayaran, Angka Saja" required/>
                                <input type="hidden" name="kelas_id" value="<?php echo $kelas->kelas_id;?>"/>
                            </div>
                        </div>
                        <div class="col-xs-12 form-input">
                            <div class="col-xs-5">
                                <label>Pajak Penghasilan (PPH)</label>
                            </div>
                            <div class="col-xs-7">
                                <div class="col-xs-12"> 
                                    <input type="radio" id="pembayaran_guru_pph_0" class="pembayaran_guru_pph" name="pph" value="0"
                                        <?php echo ($pph==0)?'checked':''; ?> >0%&nbsp;&nbsp;
                                    <input type="radio" id="pembayaran_guru_pph_2" class="pembayaran_guru_pph" name="pph" value="2.5"
                                        <?php echo ($pph==2.5)?'checked':''; ?> >2.5%&nbsp;&nbsp;
                                    <input type="radio" id="pembayaran_guru_pph_3" class="pembayaran_guru_pph" name="pph" value="3"
                                        <?php echo ($pph==3)?'checked':''; ?> >3%&nbsp;&nbsp;
                                </div>
                            </div>
                        </div>
                        <div class="col-xs-12 form-input">
                            <div class="col-xs-5">
                                <label>Nominal PPH</label>
                            </div>
                            <div class="col-xs-7">
                                <input type="text" class="field col-xs-12" id="nominal_pph_guru" placeholder="Nominal PPH"/>
                            </div>
                        </div>
                        <div class="col-xs-12 form-input">
                            <div class="col-xs-5">
                                <label>Total yang Harus Dibayar</label>
                            </div>
                            <div class="col-xs-7">
                                <input type="text" class="field col-xs-12" id="total_dibayar_guru" name="jumlah_pembayaran" placeholder="Total yang harus dibayar" required/>
                            </div>
                        </div>
                        <div class="col-xs-12 form-input">
                            <div class="col-xs-5">
                                <label>Tanggal Pembayaran</label>
                            </div>
                            <div class="col-xs-7">
                                <input id="date_pembayaran_guru" type="text" class="field col-xs-12" name="tanggal" placeholder="Tanggal Pembayaran" required/>
                            </div>
                        </div>
                        <div class="col-xs-12 form-input">
                            <div class="col-xs-5">
                                <label>Bukti Pembayaran</label>
                            </div>
                            <div class="col-xs-7">
                                <input type="file" class="col-xs-12" name="userfile" />
                            </div>
                        </div>
                    </div>
                    <!-- End Form -->
                
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-primary">Submit</button>
                </div>
            </form>
        </div><!-- /.modal-content -->
    </div><!-- /.modal-dialog -->
</div><!-- /.modal -->

<!-- end of modal dialog -->
<div class="modal fade" id="EditPembayaranGuruModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title">Edit Pembayaran Guru</h4>
            </div>
            <form action="<?php echo base_url();?>admin/kelas/edit_pembayaran_guru_submit" method="post" 
                    enctype="multipart/form-data">
                <div class="modal-body">
                <!-- Form -->
                    <div class="form row" style="margin:0px;background:rgb(238, 238, 238);padding-top:10px;">
                        <div class="col-xs-12 form-input">
                            <div class="col-xs-5">
                                <label>Jumlah Pembayaran</label>
                            </div>
                            <div class="col-xs-7">
                                <input type="text" class="field col-xs-12" id="jumlah_pembayaran_guru_edit" placeholder="Jumlah Pembayaran, Angka Saja" required/>
                                <input type="hidden" id="id_pembayaran_guru" name="id" />
                                <input type="hidden" name="kelas_id" value="<?php echo $kelas->kelas_id;?>"/>
                            </div>
                        </div>
                        <div class="col-xs-12 form-input">
                            <div class="col-xs-5">
                                <label>Pajak Penghasilan (PPH)</label>
                            </div>
                            <div class="col-xs-7">
                                <div class="col-xs-12"> 
                                    <input type="radio" id="pembayaran_guru_pph_0_edit" class="pembayaran_guru_pph_edit" name="pph" value="0" checked>0%&nbsp;&nbsp;
                                    <input type="radio" id="pembayaran_guru_pph_2_edit" class="pembayaran_guru_pph_edit" name="pph" value="2.5">2.5%&nbsp;&nbsp;
                                    <input type="radio" id="pembayaran_guru_pph_3_edit" class="pembayaran_guru_pph_edit" name="pph" value="3">3%&nbsp;&nbsp;
                                </div>
                            </div>
                        </div>
                        <div class="col-xs-12 form-input">
                            <div class="col-xs-5">
                                <label>Nominal PPH</label>
                            </div>
                            <div class="col-xs-7">
                                <input type="text" class="field col-xs-12" id="nominal_pph_guru_edit" placeholder="Nominal PPH"/>
                            </div>
                        </div>
                        <div class="col-xs-12 form-input">
                            <div class="col-xs-5">
                                <label>Total yang Harus Dibayar</label>
                            </div>
                            <div class="col-xs-7">
                                <input type="text" class="field col-xs-12" id="total_dibayar_guru_edit" name="jumlah_pembayaran" placeholder="Total yang harus dibayar" required/>
                            </div>
                        </div>
                        <div class="col-xs-12 form-input">
                            <div class="col-xs-5">
                                <label>Tanggal Pembayaran</label>
                            </div>
                            <div class="col-xs-7">
                                <input id="date_pembayaran_guru_edit" type="text" class="field col-xs-12" name="tanggal" placeholder="Tanggal Pembayaran" required/>
                            </div>
                        </div>
                        <div class="col-xs-12 form-input">
                            <div class="col-xs-5">
                                <label>Bukti Pembayaran</label>
                            </div>
                            <div class="col-xs-7">
                                <input type="file" class="col-xs-12" name="userfile" />
                            </div>
                        </div>
                    </div>
                    <!-- End Form -->
                
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-primary">Submit</button>
                </div>
            </form>
        </div><!-- /.modal-content -->
    </div><!-- /.modal-dialog -->
</div><!-- /.modal -->