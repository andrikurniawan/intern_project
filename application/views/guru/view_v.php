<!-- Message Error -->
<?php if ($this->session->flashdata('f_guru')): ?>
    <div class="msg msg-ok boxwidth">
        <p><strong><?php echo $this->session->flashdata('f_guru'); ?></strong></p>
    </div>
<?php endif; ?>
<script src="<?php echo base_url(); ?>js/profile.js" type="text/javascript" charset="utf-8"></script>
<style>
    .checkbox {
        float : left;
        margin-right: 5px !important;
    }

    .label-check {
        float:left;
        width:105px;
    }

    .label-check p {
        padding-top:3px;
        padding-bottom: 0px;
    }

    .field {
        margin-bottom: 5px;
    }

    li a {
        color: white;
    }

    .header {
        margin-left:-10px;
        font-size:16px !important;
        padding:10px;
        background-color: #eaeaea;
        border-radius: 10px;
    }

</style>
<script>
    $(document).ready(function(){
        var kualifikasi_count=<?php echo sizeof($kualifikasi)+0?>;
        var pengalaman_count = <?php echo sizeof($pengalaman)+0?>;
        var total_matpel = <?php echo sizeof($gurus->matpel->result_array())+0 ?>;
        if(kualifikasi_count==0) kualifikasi_count++;
        if(pengalaman_count==0) pengalaman_count++;

        $('.bfcs-list .bfcs-tarif').click(function(){
            obj = $(this).siblings(".bfcs-form-tarif");
            if(!$(obj).is(':visible')){
                $(".bfcs-form-tarif").hide('slow');
            }
            $(obj).slideToggle('slow');
        });

        $("#tambah-kualifikasi-button").click(function(event){
            event.preventDefault();
            kualifikasi_count++;
            var kelas = "even";
            if(kualifikasi_count%2 != 0) kelas = "ganjil";
            $("#data-kualifikasi").append(
                '<div class="col-xs-12 '+kelas+'" style="padding-top:15px;padding-bottom:15px;">'+
                    '<div class="col-xs-1" style="padding-top:5px;">'+
                        '<label>'+kualifikasi_count+'.</label>'+
                    '</div>'+
                    '<div class="col-xs-8">' +
                        '<input type="text" name="kualifikasi[]" '+
                            'placeholder="Contoh : Finalis Olimpiade Sains Komputer Indonesia " ' +
                            'class="col-xs-12 field">' +
                    '</div>' +
                    '<div class="col-xs-3">' +
                        '<input type="file" name="file_kualifikasi_'+kualifikasi_count+'" class="field col-xs-12" />' +
                    '</div>'+
                '</div>');
        });

        $("#tambah-pengalaman-button").click(function(event){
            event.preventDefault();
            pengalaman_count++;
            $("#data-pengalaman").append(
                '<div class="col-xs-12 pengalaman-field">'+
                        '<div class="col-xs-1" style="padding-top:5px;">'+
                            '<label>'+pengalaman_count+'.</label>' +
                        '</div>'+
                        '<div class="col-xs-11">'+
                            '<input type="text" name="pengalaman[]" ' +
                                'placeholder="Contoh : Asisten Dosen Kalkulus II Universitas Indonesia 2009" ' +
                                'class="col-xs-12 field">' +
                        '</div>' +
                    '</div>'
                );
        });

        $(".matpel-check").click(function(){
            var id = $(this).val();
            var check = $(this).prop('checked');
            console.log(check);
            if(check) {
                if(total_matpel<25) {
                    $("#price_"+id).css('display','inline');
                    $("#disable_matpel_"+id).css("display","inline");
                    $("#text_matpel_"+id).html("Tarif Perjam");
                    total_matpel++;
                } else {
                    $("#warningMatpel").modal('show');
                    $(this).attr('checked',false);
                }
            } else {
                $("#price_"+id).css('display','none');
                $("#matpel_check_"+id).css("display","inline");
                $("#text_matpel_"+id).html("Pilih");
                total_matpel--;
            }
        });

        $(".disable-matpel").click(function(){
            event.preventDefault();
            var id = $(this).val();
            $(this).css('display','none');
            $("#price_"+id).attr('type','hidden');
            $("#matpel_check_"+id).css("display","inline");
            $("#matpel_check_"+id).attr("checked",false);
            $("#text_matpel_"+id).html("Pilih");
        });

        $.post("<?php echo base_url()?>main/get_matpel/1",{},
            function(data){
                var option = "";
                for(var i=0;i<data.length;i++){
                    option += "<option value='"+data[i]['matpel_id']+"'>"+data[i]['matpel_title']+"</option>";
                }

                $("#select-matpel-02").html(option);
            },'json');

        $("#select-jenjang-02").change(function(){
            var id = $(this).val();
            console.log(id);
            $.post("<?php echo base_url()?>main/get_matpel/"+id,{},
                function(data){
                    var option = "";
                    for(var i=0;i<data.length;i++){
                        option += "<option value='"+data[i]['matpel_id']+"'>"+data[i]['matpel_title']+"</option>";
                    }

                    $("#select-matpel-02").html(option);
                },'json');
        });

        update_matpel();
        update_total_karakter($('#personal_message'),'total-karakter-personal');
    });

    function jadwal_box_clicks(obj){
            checkbox = $(obj).children('.jadwal-checkbox');
            if(checkbox.prop('checked')){
                $(obj).addClass('selected');
            }else{
                $(obj).removeClass('selected');
            }
        }
</script>
<!-- Box -->
<div class="box">
    <!-- Box Head -->
    <div class="box-head">
        <ul id="myTab" class="nav nav-tabs" style="width:850px">
            <li class="active"><a href="#bio" data-toggle="tab">Data Pribadi</a></li>
            <li><a href="#fullbio" data-toggle="tab">Data Publik</a></li>
            <li><a href="#matpel" data-toggle="tab">Informasi Kursus</a></li>
            <li><a href="#rating" data-toggle="tab">Rating Guru</a></li>
            <li><a href="#poin" data-toggle="tab">Poin Guru</a></li>
            <li><a href="#status" data-toggle="tab">Status Guru</a></li>
            <li><a href="#feedback" data-toggle="tab">Feedback</a></li>
        </ul>
    </div>
    <!-- End Box Head -->
    <div id="myTabContent" class="tab-content row">
        <div class="tab-pane fade in active edit-content" id="bio">
            <div class="content" style="margin-top:30px;">
                <form id="change-bio-form" enctype="multipart/form-data" class="profile-form"
                        action="<?php echo base_url(); ?>admin/guru/biodata_submit" method="post">
                    <!-- Form -->
                    <div class="row form">
                        <div class="col-xs-12">
                            <div class="col-xs-3">
                                <label>ID</label>
                            </div>
                            <div class="col-xs-9">
                                <input type="text" class="field col-xs-12" value="<?php echo $guru->guru_id;?>" disabled="true"/>
                            </div>
                        </div>
                        <div class="col-xs-12">
                            <div class="col-xs-3">
                                <label>Nama Guru</label>
                            </div>
                            <div class="col-xs-9">
                                <input type="text" class="field col-xs-12" name="nama" value="<?php echo $guru->guru_nama;?>" required="required"/>
                                <input type="hidden" class="field size1" name="id" value="<?php echo $guru->guru_id;?>"/>
                            </div>
                        </div>
                        <div class="col-xs-12">
                            <div class="col-xs-3">
                                <label>Email</label>
                            </div>
                            <div class="col-xs-9">
                                <input type="text" class="field col-xs-12" name="email" value="<?php echo $guru->guru_email;?>" required="required"/>
                            </div>
                        </div>
                        <div class="col-xs-12">
                            <div class="col-xs-3">
                                <label>No. Ponsel 1</label>
                            </div>
                            <div class="col-xs-9">
                                <input type="text" class="field col-xs-12" name="hp" value="<?php echo $guru->guru_hp;?>" required="required"/>
                            </div>
                        </div>
            		    <div class="col-xs-12">
                            <div class="col-xs-3">
                                <label>No. Ponsel 2</label>
                            </div>
                            <div class="col-xs-9">
                                <input type="text" class="field col-xs-12" name="hp_2" value="<?php echo $guru->guru_hp_2;?>" required="required"/>
                            </div>
                        </div>
            		    <div class="col-xs-12">
                            <div class="col-xs-3">
                                <label>No. Telp Rumah</label>
                            </div>
                            <div class="col-xs-9">
                                <input type="text" class="field col-xs-12" name="telp_rumah" value="<?php echo $guru->guru_telp_rumah;?>"/>
                            </div>
                        </div>
            		    <div class="col-xs-12">
                            <div class="col-xs-3">
                                <label>No. Telp Kantor</label>
                            </div>
                            <div class="col-xs-9">
                                <input type="text" class="field col-xs-12" name="telp_kantor" value="<?php echo $guru->guru_telp_kantor;?>"/>
                            </div>
                        </div>
                        <div class="col-xs-12">
                            <div class="col-xs-3">
                                <label>NIK</label>
                            </div>
                            <div class="col-xs-9">
                                <input type="text" class="field col-xs-12" name="nik" value="<?php echo $guru->guru_nik;?>"/>
                            </div>
                        </div>
                        <div class="col-xs-12">
                            <div class="col-xs-3">
                                <label>Scan NIK</label>
                            </div>
                            <div class="col-xs-9" style="margin-bottom:0px;">
                                <?php if(!empty($guru->guru_nik_image)):?>
                                <img src="<?php echo base_url().'images/nik/'.$guru->guru_nik_image;?>" alt="nik" style="max-width:200px"/><br/>
                                <?php else:?>
                                <span>Tidak tersedia<br/></span>
                                <?php endif;?>
                                <p style="float:left"> Upload Scan NIK : &nbsp;</p> <input type="file" name="nik_file"/>
                            </div>
                        </div>
                        <div class="col-xs-12">
                            <div class="col-xs-3">
                                <label>NPWP</label>
                            </div>
                            <div class="col-xs-9">
                                <input type="text" class="field col-xs-12" name="nik" value="<?php echo $guru->guru_npwp;?>"/>
                            </div>
                        </div>
                        <div class="col-xs-12">
                            <div class="col-xs-3">
                                <label>Scan NPWP</label>
                            </div>
                            <div class="col-xs-9" style="margin-bottom:0px;">
                                <?php if(!empty($guru->guru_npwp_image)):?>
                                <img src="<?php echo base_url().'files/npwp/'.$guru->guru_npwp_image;?>" alt="nik" style="max-width:200px;  "/><br/>
                                <?php else:?>
                                <span>Tidak tersedia<br/></span>
                                <?php endif;?>
                                <p style="float:left"> Upload Scan NPWP : &nbsp;</p> <input type="file" name="npwp_file"/>
                            </div>
                        </div>
                        <div class="col-xs-12">
                            <div class="col-xs-3">
                                <label>Gender</label>
                            </div>
                            <div class="col-xs-9">
                                <select name="gender" required="required" class="field col-xs-12">
                                    <option value="1" <?php echo ($guru->guru_gender==1)?'selected':'';?> >Pria</option>
                                    <option value="2" <?php echo ($guru->guru_gender==2)?'selected':'';?> >Wanita</option>
                                </select>
                            </div>
                        </div>
                        <div class="col-xs-12">
                            <div class="col-xs-3">
                                <label>Tempat Lahir</label>
                            </div>
                            <div class="col-xs-9">
                                <input type="text" class="field col-xs-12" name="tmpt_lahir" value="<?php echo $guru->guru_tempatlahir;?>"/>
                            </div>
                        </div>
                        <div class="col-xs-12">
                            <div class="col-xs-3">
                                <label>Tanggal Lahir</label>
                            </div>
                            <div class="col-xs-9">
                                <input type="text" class="field col-xs-12" name="tgl_lahir" value="<?php echo $guru->guru_lahir;?>"/>
                            </div>
                        </div>
                        <div class="col-xs-12">
                            <div class="col-xs-3">
                                <label>Alamat</label>
                            </div>
                            <div class="col-xs-9">
                                <textarea rows="5" class="field col-xs-12" name="alamat"><?php echo $guru->guru_alamat;?></textarea>
                            </div>
                        </div>
            		    <div class="col-xs-12">
                            <div class="col-xs-3">
                                <label>Alamat Domisili</label>
                            </div>
                            <div class="col-xs-9">
                                <textarea rows="5" class="field col-xs-12" name="alamat_domisili"><?php echo $guru->guru_alamat_domisili;?></textarea>
                            </div>
                        </div>
                        <div class="col-xs-12">
                            <div class="col-xs-3">
                                <label>FB</label>
                            </div>
                            <div class="col-xs-9">
                                <input type="text" class="field col-xs-12" name="fb" value="<?php echo $guru->guru_fb;?>"/>
                            </div>
                        </div>
                        <div class="col-xs-12">
                            <div class="col-xs-3">
                                <label>Twitter</label>
                            </div>
                            <div class="col-xs-9">
                                <input type="text" class="field col-xs-12" name="twitter" value="<?php echo $guru->guru_twitter;?>"/>
                            </div>
                        </div>
                        <div class="col-xs-12">
                            <div class="col-xs-3">
                                <label>Referral id</label>
                            </div>
                            <div class="col-xs-9">
                                <input type="text" class="field col-xs-12" name="referral" value="<?php echo ($guru->guru_referral==0)?'':$guru->guru_referral;?>"/>
                            </div>
                        </div>
                        <div class="col-xs-12">
                            <div class="col-xs-3">
                                <label>Nama Bank</label>
                            </div>
                            <div class="col-xs-9">
                                <select name="bank" class="field col-xs-12">
                                    <option value="0">---- Pilih Nama Bank -- </option>
                                    <?php foreach($bank->result() as $b) { ?>
                                        <option value="<?php echo $b->bank_id?>" <?php echo ($b->bank_id==$guru->bank_id)?'selected':''; ?>>
                                                <?php echo $b->bank_title?></option>
                                    <?php }?>
                                </select>
                                <!-- <input type="text" class="field col-xs-12" name="bank" value="<?php echo $guru->bank_title;?>"/>        -->
                            </div>
                        </div>
                        <div class="col-xs-12">
                            <div class="col-xs-3">
                                <label>No. Rekening</label>
                            </div>
                            <div class="col-xs-9">
                                <input type="text" class="field col-xs-12" name="rekening" value="<?php echo $guru->guru_bank_rekening;?>"/>
                            </div>
                        </div>
                        <div class="col-xs-12">
                            <div class="col-xs-3">
                                <label>Pemilik Rekening</label>
                            </div>
                            <div class="col-xs-9">
                                <input type="text" class="field col-xs-12" name="nama_rekening" value="<?php echo $guru->guru_bank_pemilik;?>"/>
                            </div>
                        </div>
                        <div class="col-xs-12">
                            <div class="col-xs-3">
                                <label>Mengetahui Ruangguru Dari</label>
                            </div>
                            <div class="col-xs-9">
            			 <?php $info_source = ""; $from = "";?>
            			 <?php $info = explode(",",$guru->source_info_id);?>
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
                                <input type="text" class="field col-xs-12" name="source" value="<?php echo $info_source;?>"/>
                            </div>
                        </div>
                        <div class="col-xs-12">
                            <div class="col-xs-3">
                                <label>Waktu &amp; Tanggal Daftar</label>
                            </div>
                            <div class="col-xs-9">
                                <input type="text" class="field col-xs-12" name="daftar " value="<?php echo $guru->guru_daftar;?>" disabled="true"/>
                            </div>
                        </div>
                        <div class="col-xs-12">
                            <div class="col-xs-3">
                                <label>Surat Keterangan Pajak</label>
                            </div>
                            <div class="col-xs-9" style="margin-top:5px">
                                <?php if(!empty($guru->guru_ket_pajak_image)):?>
                                    <a href="<?php echo base_url();?>files/keterangan_pajak/<?php echo $guru->guru_ket_pajak_image?>" target="_blank" class="button button-larger" style="font-size:14px;">
                                                    <i class="glyphicon glyphicon-search"></i> View File </a><br/>
                                <?php else:?>
                                <span>Tidak tersedia<br/></span>
                                <?php endif;?>
                                <p style="float:left"> Upload Scan Keterangan Pajak : &nbsp;</p> <input type="file" name="ket_pajak_file"/>
                            </div>
                        </div>
                        <div class="col-xs-12" style="text-align:right;margin-right:-10px;">
                            <button type="submit" class="btn btn-primary" style="margin-right:15px;">Submit</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
        <div class="tab-pane fade edit-content" id="fullbio">
            <div class="content" style="margin-top:10px;">
                <form id="change-bio-form" enctype="multipart/form-data" class="profile-form"
                        action="<?php echo base_url(); ?>admin/guru/fullbio_submit" method="post">

                        <input type="hidden" class="field size1" name="id" value="<?php echo $guru->guru_id;?>"/>
                    <div class="pgc-section col-xs-12 row" style="margin:0px;margin-left:20px;width:95%;min-width:920px;">
                        <div class="header col-xs-12" style="text-align:left;">
                            <span>Lokasi Mengajar</span>
                        </div>
                        <div class="col-md-12 input-div">
                            <div class="col-xs-12" style="margin-left:0px;padding:0px;">
                            <?php $n = 0;
                                foreach ($lokasi_jkt->result() as $row) {
                                    if(($n%3 == 0)){
                                        echo "<span class='inline-block col-xs-4'>"; } ?>
                                            <input type="checkbox" name="lokasi[<?php echo $row->lokasi_id; ?>]"
                                                value="<?php echo $row->lokasi_id; ?>"
                                                    <?php echo(!empty($lokasis[$row->lokasi_id])) ? 'checked' : ''; ?>/>

                                                    <?php echo "&nbsp;&nbsp;".$row->lokasi_title; ?><br/>
                                        <?php $n++;
                                            if(($n%3 == 0)){echo "</span>"; }?>
                            <?php } ?>
                            </div><br/><br/>
                            <p style="margin-top:30px;margin-bottom:10px;margin-left:20px;font-style:italic;font-weight:bold;">atau pilih kota lain</p>
                            <div>
                                <div class="form-group col-xs-12">
                                    <div class="col-xs-4 form-label">
                                        <label>Pilih Provinsi</label>
                                    </div>
                                    <div class="col-xs-8 input-div">
                                        <select id="Provinsi" name="provinsi" class="field col-xs-12">
                                            <option value="-1" selected>--Pilih Provinsi--</option>
                                            <?php foreach ($this->guru_model->get_table('provinsi')->result() as $row): ?>
                                                <option value="<?php echo $row->provinsi_id; ?>" ><?php echo $row->provinsi_title; ?></option>
                                            <?php endforeach; ?>
                                        </select>
                                    </div>
                                </div>
                                <div class="form-group col-xs-12">
                                    <div class="col-xs-4 form-label">
                                        <label>Pilih Kota</label>
                                    </div>
                                    <div class="col-xs-8 input-div">
                                        <select id="lokasi_lainnya" name="lokasi_lain" class="field col-xs-12">
                                            <option value="-1" selected>--Pilih Kota--</option>
                                            <?php foreach ($lokasi_lain->result() as $row): ?>
                                                <option value="<?php echo $row->lokasi_id; ?>" <?php echo(!empty($lokasi[$row->lokasi_id])) ? 'selected' : ''; ?>><?php echo $row->lokasi_title; ?></option>
                                            <?php endforeach; ?>
                                        </select>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="header col-xs-12" style="text-align:left;">
                            <span>Sejarah Pendidikan</span>
                        </div>
                        <?php foreach($history_pendidikan as $hp) { ?>
                            <div class="row pendidikan-terakhir col-md-12" style="margin-bottom:10px;">
                                <div style="margin-bottom:40px;">
                                    <div class="col-md-4">Jenjang Pendidikan</div>
                                    <div class="col-md-8">
                                        <select name="pendidikan[]" class="field col-md-12" style="height:30px;">
                                            <?php foreach ($pendidikan->result() as $row): ?>
                                                <option value="<?php echo $row->pendidikan_id; ?>"
                                                    <?php echo($row->pendidikan_id==$hp['pendidikan_id'])?'selected':'';?>>
                                                    <?php echo $row->pendidikan_title; ?>
                                                </option>
                                            <?php endforeach; ?>
                                        </select>
                                    </div>
                                </div>
                                <div>
                                    <div class="col-md-4">Instansi Pendidikan</div>
                                    <div class="col-md-8">
                                        <textarea name="instansi[]" class="field col-md-12 col-xs-12"><?php echo $hp['instansi'] ?></textarea>
                                    </div>
                                </div>
                            </div>
                        <?php } ?>
                        <div class="col-xs-12" style="font-weight:bold;text-align:left;">Tambah Sejarah Pendidikan</div>
                        <div class="row pendidikan-terakhir col-md-12" style="margin-top:20px;">
                            <div style="margin-bottom:40px;">
                                <div class="col-md-4">Jenjang Pendidikan</div>
                                <div class="col-md-8">
                                    <select name="pendidikan[]" class="field col-md-12" style="height:30px;">
                                        <?php foreach ($pendidikan->result() as $row): ?>
                                            <option value="<?php echo $row->pendidikan_id; ?>" >
                                                <?php echo $row->pendidikan_title; ?>
                                            </option>
                                        <?php endforeach; ?>
                                    </select>
                                </div>
                            </div>
                            <div>
                                <div class="col-md-4">Instansi Pendidikan</div>
                                <div class="col-md-8">
                                    <textarea name="instansi[]" class="field col-md-12 col-xs-12"></textarea>
                                </div>
                            </div>
                        </div> <br/><br/>
                        <div class="col-md-12" style="margin-top:10px;padding:0px;">
                            <div class="col-md-4 form-label">
                                <label>Pekerjaan/Kategori<span class="red-notif"> * </span></label>
                            </div>
                            <div class="col-md-8 input-div" style="padding:3px;">
                                <select name="kategori" class="field col-xs-11">
                                    <?php foreach ($kategori->result() as $row): ?>
                                        <option value="<?php echo $row->kategori_id; ?>" <?php echo ($guru->kategori_id == $row->kategori_id) ? 'selected' : ''; ?>><?php echo $row->kategori_title; ?></option>
                                    <?php endforeach; ?>
                                </select>
                            </div>
                        </div><br/><br/><br/>

                        <div class="header col-xs-12" style="text-align:left;margin-top:20px;">
                            <span>Bio Singkat <span class="red-notif"> * </span></span>
                            <p class="info2" style="font-size:11px;margin-left:15px;">
                                200 karakter bio singkat yang mendeskripsikan diri dan kemampuan anda
                            </p>
                        </div>
                        <div class="content" style="margin-top:-20px;">
                            <textarea name="bio_singkat" class="validate[required] field col-xs-12"
                                rows="5" maxlength="200" style="margin-left:-10px;"><?php echo $guru->bio_singkat?></textarea>
                        </div>

                        <div class="header col-xs-12" style="text-align:left;margin-top:20px;">
                            <span>Tentang Saya <span class="red-notif"> * </span></span>
                        </div>
                        <div class="content">
                            <table class="col-xs-12">
                                <tr>
                                    <td colspan="2">
                                        <textarea oninput="update_total_karakter(this,'total-karakter-personal')"
                                            name="personal_message" class="validate[required] field col-xs-12"
                                            rows="5" maxlength="1500" style="margin-left:-10px;"><?php echo $guru->guru_bio; ?></textarea>
                                    </td>
                                </tr>
                                <tr>
                                    <td colspan="2">
                                        <p>
                                            Total karakter: <span id="total-karakter-personal">0</span>
                                        </p>
                                    </td>
                                </tr>
                            </table>
                        </div>

                        <div class="header col-xs-12" style="text-align:left;margin-top:10px">
                            <span>Pengalaman Mengajar</span>
                        </div>
                        <div class="content" style="margin-top:-20px;">
                            <table class="col-xs-12">
                                <tr>
                                    <td colspan="2">
                                        <p class="info2">
                                            Sebutkan pengalaman mengajar yang anda miliki disini.<br/>
                                        </p>
                                <br/>
                                    </td>
                                </tr>
                                <tr>
                                    <td colspan="2">
                                        <div id="data-pengalaman">
                                            <?php if(sizeof($pengalaman)>0) {
                                                $counter_lagi = 1;
                                                foreach($pengalaman as $p) { ?>
                                                    <div class="col-xs-12 pengalaman-field">
                                                        <div class="col-xs-1" style="padding-top:5px;">
                                                            <label><?php echo $counter_lagi ?>.</label>
                                                        </div>
                                                        <div class="col-xs-11">
                                                            <input type="text" name="pengalaman[]"
                                                                placeholder="Contoh : Asisten Dosen Kalkulus II Universitas Indonesia 2009"
                                                                value="<?php echo $p['pengalaman']?>"
                                                                class="col-xs-12 field">
                                                        </div>
                                                    </div>
                                                <?php $counter_lagi++;
                                                }
                                            } else { ?>
                                                <div class="col-xs-12 pengalaman-field">
                                                    <div class="col-xs-1" style="padding-top:5px;">
                                                        <label>1.</label>
                                                    </div>
                                                    <div class="col-xs-11">
                                                        <input type="text" name="pengalaman[]"
                                                            placeholder="Contoh : Asisten Dosen Kalkulus II Universitas Indonesia 2009"
                                                            class="col-xs-12 field">
                                                    </div>
                                                </div>
                                            <?php } ?>
                                        </div>
                                        <div class="col-xs-12" style="text-align:right;padding:25px;">
                                            <button id="tambah-pengalaman-button" type="button" class="button">+ Pengalaman</button>
                                        </div>
                                    </td>
                                </tr>
                            </table>
                        </div><br/>
                        <div class="header col-xs-12" style="text-align:left;margin-top:20px;">
                            <span>Kualifikasi dan Sertifikat <span class="red-notif"> * </span></span>
                        </div>
                        <div class="content" style="margin-top:-20px;">
                            <table class="col-xs-12">
                                <tr>
                                    <td colspan="2">
                                        <p class="info2">
                                            Jelaskan Kualifikasi anda disini. Anda dapat menjelaskan pelatihan atau sertifikat yang anda miliki.<br/>
                                            Untuk mendapatkan rating, Anda bisa mengunggah hasil pindai ijazah, sertifikat dan transkrip Anda di halaman profile Anda nanti.
                                        </p><br/>
                                    </td>
                                </tr>
                                <tr>
                                    <td colspan="2">
                                        <div id="data-kualifikasi">
                                            <?php
                                            if(sizeof($kualifikasi)>0) {
                                                $counter = 1;
                                                foreach($kualifikasi as $k) { ?>
                                                    <div class="col-xs-12 <?php if($counter%2!=0) { echo 'ganjil'; } else { echo 'even'; } ?>"
                                                            style="padding-top:15px;padding-bottom:15px;">
                                                        <div class="col-xs-1" style="padding-top:5px;">
                                                            <label><?php echo $counter?>.</label>
                                                        </div>
                                                        <div class="col-xs-6">
                                                            <input type="text" name="kualifikasi_<?php echo $k['id']?>"
                                                                placeholder="Contoh : Finalis Olimpiade Sains Komputer Indonesia "
                                                                class="col-xs-12 field"
                                                                value="<?php echo $k['kualifikasi']?>">
                                                        </div>
                                                        <div class="col-xs-3">
                                                            <input type="file" name="file_kualifikasi_<?php echo $counter?>" class="field col-xs-12"/>
                                                        </div>
                                                        <div class="col-xs-1" style="padding:0px;margin-top:5px;">
                                                            <a href="<?php echo base_url()?>files/sertifikat/<?php echo $k['sertifikat'] ?>"  target="_blank">
                                                                <i class="glyphicon glyphicon-search"></i>View</a>
                                                        </div>
                                                        <div class="col-xs-1" style="padding:0px;margin-top:5px;">
                                                            <a href="<?php echo base_url()?>admin/guru/delete_sertifikat/<?php echo $k['id'] ?>/<?php echo $guru->guru_id?>">
                                                                <i class="glyphicon glyphicon-trash"></i>Delete</a>
                                                        </div>
                                                    </div>
                                            <?php
                                                $counter++;
                                                }
                                            } else { ?>
                                                <div class="col-xs-12">
                                                    <div class="col-xs-1" style="padding-top:5px;">
                                                        <label>1.</label>
                                                    </div>
                                                    <div class="col-xs-8">
                                                        <input type="text" name="kualifikasi[]"
                                                            placeholder="Contoh : Finalis Olimpiade Sains Komputer Indonesia "
                                                            class="col-xs-12 field">
                                                    </div>
                                                    <div class="col-xs-3">
                                                        <input type="file" name="file_kualifikasi_1" class="field col-xs-12" />
                                                    </div>
                                                </div>
                                            <?php } ?>
                                        </div>
                                        <div class="col-xs-12" style="text-align:right;padding:25px;">
                                            <button id="tambah-kualifikasi-button" type="button" class="button">+ Kualifikasi</button>
                                        </div>
                                    </td>
                                </tr>
                            </table>
                        </div>
                        <div class="col-xs-12" style="text-align:right;margin-right:-10px;margin-top:10px;margin-bottom:20px;">
                            <button class="button" type="submit" style="margin-right:-15px;height:40px;width:100px;">Simpan</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
        <div class="tab-pane fade edit-content" id="rating">
            <div class="content" style="margin-top:0px;margin-left:20px;">
                <form action="<?php echo base_url();?>admin/guru/rating_submit" method="post" >
                    <input type="hidden" class="field size1" name="id" value="<?php echo $guru->guru_id;?>"/>
                    <!-- Form -->
                    <div class="form">
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
                                        <td>Lulusan SMA</td>
                                        <td>
                                            <?php $config = 'class="checkbox"';?>
                                            <label class="label-check"><?php echo form_radio('sma', '0', ($guru->guru_rating_sma==0), $config);?><p>Tidak</p></label>
                                            <label class="label-check"><?php echo form_radio('sma', '1', ($guru->guru_rating_sma==1), $config);?><p>Ya</p></label>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>Lulusan Diploma</td>
                                        <td>
                                            <label class="label-check"><?php echo form_radio('diploma', '0', ($guru->guru_rating_diploma==0), $config);?><p>Tidak</p></label>
                                            <label class="label-check"><?php echo form_radio('diploma', '1', ($guru->guru_rating_diploma==1), $config);?><p>IPK < 3.0</p></label>
                                            <label class="label-check"><?php echo form_radio('diploma', '2', ($guru->guru_rating_diploma==2), $config);?><p>IPK 3.0 - 3.5</p></label>
                                            <label class="label-check"><?php echo form_radio('diploma', '3', ($guru->guru_rating_diploma==3), $config);?><p>IPK IPK 3.5 - 4.0</p></label>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>Lulusan S1 UI/ UGM/ ITB/ PT Luar Negeri</td>
                                        <td>
                                            <label class="label-check"><?php echo form_radio('s1_top', '0', ($guru->guru_rating_s1_top==0), $config);?><p>Tidak</p></label>
                                            <label class="label-check"><?php echo form_radio('s1_top', '1', ($guru->guru_rating_s1_top==1), $config);?><p>Ya</p></label>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>Lulusan S1</td>
                                        <td>
                                            <label class="label-check"><?php echo form_radio('s1', '0', ($guru->guru_rating_s1==0), $config);?><p>Tidak</p></label>
                                            <label class="label-check"><?php echo form_radio('s1', '1', ($guru->guru_rating_s1==1), $config);?><p>IPK < 3.0</p></label>
                                            <label class="label-check"><?php echo form_radio('s1', '2', ($guru->guru_rating_s1==2), $config);?><p>IPK 3.0 - 3.5</p></label>
                                            <label class="label-check"><?php echo form_radio('s1', '3', ($guru->guru_rating_s1==3), $config);?><p>IPK IPK 3.5 - 4.0</p></label>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>Lulusan S2 UI/ UGM/ ITB/ PT Luar Negeri</td>
                                        <td>
                                            <label class="label-check"><?php echo form_radio('s2_top', '0', ($guru->guru_rating_s2_top==0), $config);?><p>Tidak</p></label>
                                            <label class="label-check"><?php echo form_radio('s2_top', '1', ($guru->guru_rating_s2_top==1), $config);?><p>Ya</p></label>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>Lulusan S2</td>
                                        <td>
                                            <label class="label-check"><?php echo form_radio('s2', '0', ($guru->guru_rating_s2==0), $config);?><p>Tidak</p></label>
                                            <label class="label-check"><?php echo form_radio('s2', '1', ($guru->guru_rating_s2==1), $config);?><p>IPK < 3.0</p></label>
                                            <label class="label-check"><?php echo form_radio('s2', '2', ($guru->guru_rating_s2==2), $config);?><p>IPK 3.0 - 3.5</p></label>
                                            <label class="label-check"><?php echo form_radio('s2', '3', ($guru->guru_rating_s2==3), $config);?><p>IPK IPK 3.5 - 4.0</p></label>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>Lulusan S3 UI/ UGM/ ITB/ PT Luar Negeri</td>
                                        <td>
                                            <label class="label-check"><?php echo form_radio('s3_top', '0', ($guru->guru_rating_s3_top==0), $config);?><p>Tidak</p></label>
                                            <label class="label-check"><?php echo form_radio('s3_top', '1', ($guru->guru_rating_s3_top==1), $config);?><p>Ya</p></label>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>Lulusan S3</td>
                                        <td>
                                            <label class="label-check"><?php echo form_radio('s3', '0', ($guru->guru_rating_s3==0), $config);?><p>Tidak</p></label>
                                            <label class="label-check"><?php echo form_radio('s3', '1', ($guru->guru_rating_s3==1), $config);?><p>Ya</p></label>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>Beasiswa saat kuliah</td>
                                        <td>
                                            <label class="label-check"><?php echo form_radio('beasiswa', '0', ($guru->guru_rating_beasiswa==0), $config);?><p>Tidak</p></label>
                                            <label class="label-check"><?php echo form_radio('beasiswa', '1', ($guru->guru_rating_beasiswa==1), $config);?><p>Ya</p></label>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>Sertifikat Pelatihan</td>
                                        <td>
                                            <label class="label-check"><?php echo form_radio('sertifikat', '0', ($guru->guru_rating_sertifikat==0), $config);?><p>Tidak</p></label>
                                            <label class="label-check"><?php echo form_radio('sertifikat', '1', ($guru->guru_rating_sertifikat==1), $config);?><p>Ya</p></label>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>Nilai TOEFL IBT</td>
                                        <td>
                                            <label class="label-check"><?php echo form_radio('toefl_ibt', '0', ($guru->guru_rating_toefl_ibt==0), $config);?><p>Tidak</p></label>
                                            <label class="label-check"><?php echo form_radio('toefl_ibt', '1', ($guru->guru_rating_toefl_ibt==1), $config);?> ><p>600/ 667</p></label>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>Nilai TOEFL ITP</td>
                                        <td>
                                            <label class="label-check"><?php echo form_radio('toefl_itp', '0', ($guru->guru_rating_toefl_itp==0), $config);?><p>Tidak</p></label>
                                            <label class="label-check"><?php echo form_radio('toefl_itp', '1', ($guru->guru_rating_toefl_itp==1), $config);?> ><p>100/ 120</p></label>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>Nilai IELTS</td>
                                        <td>
                                            <label class="label-check"><?php echo form_radio('ielts', '0', ($guru->guru_rating_ielts==0), $config);?><p>Tidak</p></label>
                                            <label class="label-check"><?php echo form_radio('ielts', '1', ($guru->guru_rating_ielts==1), $config);?><p>7.0/ 9.0</p></label>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>Nilai GRE</td>
                                        <td>
                                            <label class="label-check"><?php echo form_radio('gre', '0', ($guru->guru_rating_gre==0), $config);?><p>Tidak</p></label>
                                            <label class="label-check" style="width:300px;"><?php echo form_radio('gre', '1', ($guru->guru_rating_gre==1), $config);?><p>1400/1600 atau > 322/340</p></label>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>Nilai GMAT</td>
                                        <td>
                                            <label class="label-check"><?php echo form_radio('gmat', '0', ($guru->guru_rating_gmat==0), $config);?><p>Tidak</p></label>
                                            <label class="label-check"><?php echo form_radio('gmat', '1', ($guru->guru_rating_gmat==1), $config);?><p>700/800</p></label>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>Nilai CFA</td>
                                        <td>
                                            <label class="label-check"><?php echo form_radio('cfa', '0', ($guru->guru_rating_cfa==0), $config);?><p>Tidak</p></label>
                                            <label class="label-check"><?php echo form_radio('cfa', '1', ($guru->guru_rating_cfa==1), $config);?><p>Level 1</p></label>
                                        </td>
                                    </tr>

                                </tbody>
                            </table>
                        </div>
                    </div>
                    <!-- End Form -->

                    <!-- Form Buttons -->
                    <div class="buttons" style="width:98.5%">
                        <input type="submit" class="button" value="submit" />
                    </div>
                    <!-- End Form Buttons -->
                </form>
            </div>
        </div>
        <div class="tab-pane fade edit-content" id="status">
            <div class="content" style="margin-top:0px;margin-left:20px;">
                <form action="<?php echo base_url();?>admin/guru/edit_submit" method="post" >
                    <!-- Form -->
                    <div class="form">
                        <input type="hidden" class="field size1" name="id" value="<?php echo $guru->guru_id;?>"/>
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
                                        <td>Non-Aktifkan Guru</td>
                                        <td>
                                            <?php $config = 'class="checkbox"';?>
                                            <label class="label-check"><?php echo form_radio('blocked', '0', ($guru->guru_blocked==0), $config);?><p>Tidak</p></label>
                                            <label class="label-check"><?php echo form_radio('blocked', '1', ($guru->guru_blocked==1), $config);?><p>Ya</p></label>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>ID Verified</td>
                                        <td>
                                            <?php $config = 'class="checkbox"';?>
                                            <label class="label-check"><?php echo form_radio('id_verified', '0', ($guru->guru_nik_verified==0), $config);?><p>Tidak</p></label>
                                            <label class="label-check"><?php echo form_radio('id_verified', '1', ($guru->guru_nik_verified==1), $config);?><p>Ya</p></label>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>Last Education Verified</td>
                                        <td>
                                            <?php $config = 'class="checkbox"';?>
                                            <label class="label-check"><?php echo form_radio('edu_verified', '0', ($guru->guru_pendidikan_verified==0), $config);?><p>Tidak</p></label>
                                            <label class="label-check"><?php echo form_radio('edu_verified', '1', ($guru->guru_pendidikan_verified==1), $config);?><p>Ya</p></label>
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                    <!-- End Form -->

                    <!-- Form Buttons -->
                    <div class="buttons" style="width:98.5%">
                        <input type="submit" class="button" value="submit" />
                    </div>
                    <!-- End Form Buttons -->
                </form>
            </div>
        </div>
        <div class="tab-pane fade edit-content" id="poin">
            <div class="content" style="margin-top:0px;margin-left:20px;">
                <div class="col-xs-12">
                    <form method="post" action="<?php echo base_url()?>admin/guru/add_poin/">
                        <div class="col-xs-12" style="margin-top:20px;">
                            <div class="col-xs-3">
                                <input type="text" name="poin" placeholder="Jumlah Poin" required class="col-xs-12 field" />
                                <input type="hidden" name="id" value="<?php echo $guru->guru_id?>">
                            </div>
                            <div class="col-xs-9">
                                <input type="text" name="keterangan" placeholder="Keterangan Penambahan Poin" required class="col-xs-12 field" />
                            </div>
                        </div>
                        <div class="col-xs-12" style="text-align:right;">
                            <button type="submit" class="btn btn-primary" style="margin-right:15px;">Submit</button>
                        </div>
                    </form>
                </div>
                <div class="col-xs-12" style="margin-top:20px; text-align:right;">
                    <h4 style="margin-right:30px;">Total Poin Guru : <?php echo $total_poin ?> </h4>
                </div>
                <div class="col-xs-12 table">
                    <table class="table table-hovered" style="width:98.5%">
                        <thead>
                            <tr>
                                <th>Tanggal</th>
                                <th>Jumlah Poin</th>
                                <th>Keterangan</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach($guru_poin->result_array() as $gp){ ?>
                                <tr>
                                    <td><?php echo date('d-M-Y H:i:s', strtotime($gp['date_created']))?></td>
                                    <td><?php echo $gp['point']?></td>
                                    <td><?php echo $gp['keterangan']?></td>
                                    <td><a href="<?php echo base_url() ?>admin/guru/delete_poin/<?php echo $guru->guru_id?>/<?php echo $gp['id']?>">Delete</a></td>
                                </tr>
                            <?php } ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
        <div class="tab-pane fade edit-content" id="matpel">
            <div class="content" style="margin-top: 0px;">
                <form id="change-bio-form" enctype="multipart/form-data" class="profile-form" action="<?php echo base_url(); ?>admin/guru/matpel_submit" method="post">
                    <input type="hidden" class="field size1" name="id" value="<?php echo $guru->guru_id;?>"/>
                    <div class="pgc-section col-xs-12" style="margin-left:10px;width:99%;min-width:920px;">
                        <div class="header" style="text-align:left;">
                            <span>Mata Pelajaran</span>
                        </div>

                        <div class="content row" style="margin-bottom:10px;">
                            <div class="col-xs-12">
                                <?php foreach($jenjang->result_array() as $j) { ?>
                                    <div class="col-xs-12" style="padding:5px; background: #EAEAEA; border-left: 3px solid #34B9D8; margin: 3px;">
                                        <a data-toggle="collapse" href="#matpel-jenjang-<?php echo $j['jenjang_pendidikan_id']?>"
                                                aria-expanded="false" aria-controls="collapseExample">
                                            <h5 style="color: #000; font-weight: bold;"><?php echo $j['jenjang_pendidikan_title'] ?></h5>
                                        </a>
                                    </div>
                                    <div class="collapse" id="matpel-jenjang-<?php echo $j['jenjang_pendidikan_id']?>">
                                        <table class="col-xs-12 table table-bordered table-condensed" style="margin-top: -3px; margin-left: 3px;">

                                        <?php
                                            $matpel = $this->guru_model->get_matpel($j['jenjang_pendidikan_id'])->result_array();
                                            $divider = sizeof($matpel)+0;
                                            $rowspan = 1;
                                            while($divider>4){
                                                $divider = ceil($divider/2);
                                            }
                                            $rowspan = ceil(sizeof($matpel)/$divider);
                                            ?>
                                                <tr>
                                                    <?php for($mm=0;$mm<$divider;$mm++) {
                                                        $tarif = $this->profile_model->get_tarif_matpel($guru->guru_id,$matpel[$mm]['matpel_id']);?>
                                                        <td class="matpel-title">
                                                            <label style="font-weight: normal; text-align: left; margin-left: 10px;">
                                                                <input type="checkbox" name="matpel_data[]" value="<?php echo $matpel[$mm]['matpel_id']; ?>"
                                                                    class="matpel-check" id="matpel_check_<?php echo $matpel[$mm]['matpel_id']; ?>"
                                                                    <?php if($tarif>0) echo "checked='checked'" ?> >
                                                                <?php echo $matpel[$mm]['matpel_title'] ?>
                                                            </label>
                                                        </td>
                                                    <?php } ?>
                                                </tr>
                                                <tr>
                                                    <?php for($mm=0;$mm<$divider;$mm++) {
                                                        $tarif = $this->profile_model->get_tarif_matpel($guru->guru_id,$matpel[$mm]['matpel_id']);?>
                                                        <td class="matpel-title disable">
                                                            <div class="col-xs-12" id="price_<?php echo $matpel[$mm]['matpel_id']; ?>" style="display:<?php if($tarif>0) {echo 'inline';} else { echo 'none'; }?>">
                                                                <label  style="font-weight: normal; float: left; margin-left: 10px; margin-top: 5px;">Tarif Perjam :&nbsp;&nbsp;</label>
                                                                <input type="text" class="field-price" placeholder="min. 50000"
                                                                    name="matpel_price_<?php echo $matpel[$mm]['matpel_id']; ?>"
                                                                    value="<?php echo $tarif?>" style="margin-top:4px"/>
                                                            </div>
                                                        </td>
                                                    <?php } ?>
                                                </tr>
                                                <?php for($ii=1;$ii<$rowspan;$ii++){ ?>
                                                    <tr>
                                                        <?php for($aa=$divider*$ii;$aa<$divider*($ii+1);$aa++) {
                                                            if($aa<sizeof($matpel)) {
                                                                $tarif = $this->profile_model->get_tarif_matpel($guru->guru_id,$matpel[$aa]['matpel_id']); ?>
                                                                <?php if($aa==sizeof($matpel)-1) { ?>
                                                                    <td colspan="<?php $a = 5 - ($aa % 5); echo $a; ?>" class="matpel-title">
                                                                        <label style="font-weight: normal; text-align: left; margin-left: 10px;">
                                                                            <input type="checkbox" name="matpel_data[]" value="<?php echo $matpel[$aa]['matpel_id']; ?>"
                                                                                class="matpel-check" id="matpel_check_<?php echo $matpel[$aa]['matpel_id']; ?>"
                                                                                <?php if($tarif>0) echo "checked='checked'" ?> >
                                                                            <?php echo $matpel[$aa]['matpel_title'] ?>
                                                                        </label>
                                                                    </td>
                                                                <?php } else { ?>
                                                                    <td class="matpel-title">
                                                                         <label style="font-weight: normal; text-align: left; margin-left: 10px;">
                                                                            <input type="checkbox" name="matpel_data[]" value="<?php echo $matpel[$aa]['matpel_id']; ?>"
                                                                                class="matpel-check" id="matpel_check_<?php echo $matpel[$aa]['matpel_id']; ?>"
                                                                                <?php if($tarif>0) echo "checked='checked'" ?> >
                                                                            <?php echo $matpel[$aa]['matpel_title'] ?>
                                                                        </label>
                                                                    </td>
                                                                <?php } ?>
                                                            <?php } else { break; } ?>
                                                        <?php } ?>
                                                    </tr>
                                                    <tr>
                                                        <?php for($ss=$divider*$ii;$ss<$divider*($ii+1);$ss++) {
                                                            if($ss<sizeof($matpel)) {
                                                                $tarif = $this->profile_model->get_tarif_matpel($guru->guru_id,$matpel[$ss]['matpel_id']);?>
                                                                <?php if($ss==sizeof($matpel)-1) { ?>
                                                                    <td colspan="<?php $a = 5 - ($ss % 5); echo $a; ?>" class="matpel-title disable">
                                                                        <div class="col-xs-12" id="price_<?php echo $matpel[$ss]['matpel_id']; ?>"  style="display:<?php if($tarif>0) {echo 'inline';} else { echo 'none'; }?>">
                                                                            <label style="font-weight: normal; float: left; margin-left: 10px;  margin-top: 5px;">Tarif Perjam :&nbsp;&nbsp;</label>
                                                                            <input type="text" class="field-price" name="matpel_price_<?php echo $matpel[$ss]['matpel_id']; ?>"
                                                                                placeholder="min. 50000" value="<?php echo $tarif?>" style="margin-top:4px"/>
                                                                        </div>
                                                                <?php } else { ?>
                                                                    <td class="matpel-title disable">
                                                                        <div class="col-xs-12" id="price_<?php echo $matpel[$ss]['matpel_id']; ?>"  style="display:<?php if($tarif>0) {echo 'inline';} else { echo 'none'; }?>">
                                                                            <label style="font-weight: normal; float: left; margin-left: 10px;  margin-top: 5px;">Tarif Perjam :&nbsp;&nbsp;</label>
                                                                            <input type="text" class="field-price" name="matpel_price_<?php echo $matpel[$ss]['matpel_id']; ?>"
                                                                                placeholder="min. 50000" value="<?php echo $tarif?>" style="margin-top:4px"/>
                                                                        </div>
                                                                    </td>
                                                                <?php } ?>
                                                            <?php } else { break; } ?>
                                                        <?php } ?>
                                                    </tr>
                                                <?php } ?>
                                        </table>
                                    </div>
                                <?php } ?>
                            </div>
                        </div>
                        <div class="header" style="text-align:left;">
                            <span>Jadwal Ketersediaan Mengajar <span class="red-notif"> * </span></span>
                        </div>
                        <div class="content">
                            <table class="col-xs-12">
                                <tr>
                                    <td colspan="2">
                                        <p class="info2">
                                            Pilih preferensi waktu mengajar yang Anda dengan meng-klik tabel dibawah. <br/>
                                            Warna jingga berarti Anda bersedia untuk mengajar murid pada jam tersebut. <br/>
                                            Pastikan informasi ini seakurat mungkin, karena murid akan menyesuaikan dengan waktu mengajar Anda.
                                        </p><br/>
                                    </td>
                                </tr>
                                <tr>
                                    <td colspan="2">
                                        <table id="jadwal-guru-table-form" class="table col-xs-12">
                                            <tr>
                                                <th style="width: 45px;">Jam</th>
                                                <?php foreach ($days as $value): ?>
                                                    <th>
                                                        <?php echo $value; ?>
                                                    </th>
                                                <?php endforeach; ?>
                                            </tr>
                                            <?php for ($i = 7; $i < 22; $i++): ?>
                                                <tr>
                                                    <th class="small text-center"><?php echo sprintf('%02s', $i); ?>:00</th>
                                                    <?php for ($j = 0; $j < 7; $j++): ?>
                                                        <?php $hour = (array_key_exists($j, $gurus->jadwal) ? $gurus->jadwal[$j] : array()); ?>
                                                        <td onclick="jadwal_box_clicks(this)" class="<?php echo (array_key_exists($i, $hour) ? 'selected' : ''); ?>">
                                                            <input class="jadwal-checkbox none" type="checkbox"
                                                                name="jadwal[<?php echo $j; ?>][<?php echo $i; ?>]"
                                                                <?php echo (array_key_exists($i, $hour) ? 'checked' : ''); ?>/>
                                                        </td>
                                                    <?php endfor; ?>
                                                </tr>
                                            <?php endfor; ?>
                                        </table>
                                        <div class="_blank" style="height: 10px;"></div>
                                        <p class="jadwal-guru-info"><img src="<?php echo base_url();?>images/jadwal-available-icon.png" alt="biru"/> Tersedia </p>
                                        <p class="jadwal-guru-info"><img src="<?php echo base_url();?>images/jadwal-notavailable-icon.png" alt="abu-abu"/> Tidak Tersedia </p>
                                    </td>
                                </tr>
                            </table>
                        </div>
                    </div>
                    <div class="col-xs-12" style="text-align:right;">
                        <button class="button" type="submit" >Simpan</button>
                    </div>
                </form>
            </div>
        </div>
        <div class="tab-pane fade edit-content" id="feedback">
            <div class="content" style="margin-top:0px;margin-left:20px;">
                <div class="row" style="width:98.5%">
                    <div class="col-xs-12 table">
                        <table class="table">
                            <thead>
                                <tr>
                                    <td>ID Kelas</td>
                                    <td>Mata Pelajaran</td>
                                    <td>Nama Murid</td>
                                    <td>Tanggal Mulai</td>
                                    <td>Status</td>
                                    <td>Total Jam</td>
                                    <td>Feedback</td>
                                </tr>
                            </thead>
                            <tbody style="font-style:normal;">
                                <?php foreach($feedback as $f) { ?>
                                    <tr>
                                        <td><?php echo $f['kelas_id']?></td>
                                        <td><?php echo $f['matpel_title']?></td>
                                        <td><?php echo $f['murid_nama']?></td>
                                        <td><?php echo $f['kelas_mulai']?></td>
                                        <td><?php echo ($f['kelas_status']==0 ? 'Telah Selesai' : 'Masih Berlangsung'); ?></td>
                                        <td><?php echo $f['total_jam']?></td>
                                        <td><?php echo number_format($f['scores'],2,'.',',')?></td>
                                    </tr>
                                <?php } ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- Box -->
<!-- <div class="box">
    <div class="box-head">
        <h2>Daftar Sertifikat Guru</h2>
    </div>
    <div class="form">
        <p>
            <label>Nama Guru</label>
            <input type="text" class="field size1" name="name" value="<?php echo $guru->guru_nama; ?>" disabled="true"/>
            <input type="hidden" class="field size1" name="id" value="<?php echo $guru->guru_id; ?>"/>
        </p>
    </div>
    <div class="table">
        <table style="width: 100%">
            <thead>
                <tr class="center">
                    <th>No</th>
                    <th>Nama Sertifikat</th>
                    <th>File</th>
                </tr>
            </thead>
            <tbody>
                <?php $i = 1; ?>
                <?php foreach ($sertifikat->result() as $row): ?>
                    <tr>
                        <td><?php echo $i++; ?></td>
                        <td>
                            <?php echo $row->guru_sertifikat_title; ?>
                        </td>
                        <td>
                            <a href="<?php echo base_url() . 'files/sertifikat/' . $row->guru_sertifikat_file; ?>" target="_blank">Open</a>
                        </td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
        <div class="pagging">
            <div class="left">
                Showing <?php echo $sertifikat->num_rows(); ?> Certificates
            </div>
        </div>
    </div>
</div> -->
<!-- End Box -->
