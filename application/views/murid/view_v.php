<link rel="stylesheet" href="<?php echo base_url();?>css_rg/validation.css" type="text/css" media="all" />
<link rel="stylesheet" href="<?php echo base_url();?>css_rg/ui-lightness/jquery-ui-1.10.3.custom.min.css">


<script src="<?php echo base_url(); ?>js/jquery.validationEngine.js" type="text/javascript" charset="utf-8"></script>
<script src="<?php echo base_url(); ?>js/jquery.validationEngine-en.js" type="text/javascript" charset="utf-8"></script>
<script src="<?php echo base_url(); ?>js/jquery-ui-1.10.3.custom.min.js" type="text/javascript" charset="utf-8"></script>

<script>
    $(document).ready(function(){
        $("#datebirth").datepicker({ 
            dateFormat: "yy-mm-dd" 
        });

        //$("#datebirth").datepicker('setDate', new Date(1990,1,1));
        //$("#datebirth").datepicker('update');
        //$("#datebirth").val('');

        $("#provinsi").change(function(){
            var id = $(this).val();
            $.post('<?php echo base_url()?>admin/request/get_kota/', {'provinsi':id},
                function(data){
                    var option = "";
                    for(var i=0;i<data.length;i++){
                        option += "<option value='"+data[i]['lokasi_id']+"'>"+data[i]['lokasi_title']+"</option>";
                    }

                    $("#kota").html(option);
                },'json');
        });
    });
</script>
<style>
    .form-field{
        margin-bottom: 5px;
    }
</style>
<!-- Message Error -->
<?php if ($this->session->flashdata('f_murid')): ?>
    <div class="msg msg-ok boxwidth">
        <p><strong><?php echo $this->session->flashdata('f_murid'); ?></strong></p>
    </div>
<?php endif; ?>

<!-- Box -->
<div class="box">
    <!-- Box Head -->
    <div class="box-head">
        <h2>Data Murid</h2>
    </div>
    <!-- End Box Head -->

    <form method="post" action="<?php echo base_url()?>admin/murid/edit_profil">

        <!-- Form -->
        <div class="row field form form-group" style="margin:0px;">
            <div class="form-field col-xs-12">
                <div class="col-xs-3">
                    <label>ID</label>
                </div>
                <div class="col-xs-9">
                    <input type="text" class="field col-xs-12" value="<?php echo $murid->murid_id;?>" disabled="true"/>       
                </div>
            </div>
            <div class="form-field col-xs-12">
                <div class="col-xs-3">
                    <label>Nama Murid</label>
                </div>
                <div class="col-xs-9">
                    <input type="text" class="field col-xs-12" name="nama" value="<?php echo $murid->murid_nama;?>" required="required"/>
                    <input type="hidden" class="field col-xs-12" name="id" value="<?php echo $murid->murid_id;?>"/>
                </div>
            </div>
            <div class="form-field col-xs-12">
                <div class="col-xs-3">
                    <label>Email</label>
                </div>
                <div class="col-xs-9">
                    <input type="text" class="field col-xs-12" name="email" value="<?php echo $murid->murid_email;?>"  required="required"/>       
                </div>
            </div>
            <div class="form-field col-xs-12">
                <div class="col-xs-3">
                    <label>No. Ponsel 1</label>
                </div>
                <div class="col-xs-9">
                    <input type="text" class="field col-xs-12" name="hp" value="<?php echo $murid->murid_hp;?>" required="required"/>       
                </div>
            </div>
            <div class="form-field col-xs-12">
                <div class="col-xs-3">
                    <label>No. Ponsel 2</label>
                </div>
                <div class="col-xs-9">
                    <input type="text" class="field col-xs-12" name="hp_2" value="<?php echo $murid->murid_hp_2;?>"/>       
                </div>
            </div>
            <div class="form-field col-xs-12">
                <div class="col-xs-3">
                    <label>No. Telp Rumah</label>
                </div>
                <div class="col-xs-9">
                    <input type="text" class="field col-xs-12" name="telp_rumah" value="<?php echo $murid->murid_telp_rumah;?>"/>       
                </div>
            </div>  
            <div class="form-field col-xs-12">
                <div class="col-xs-3">
                    <label>No. Telp Kantor</label>
                </div>
                <div class="col-xs-9">
                    <input type="text" class="field col-xs-12" name="telp_kantor" value="<?php echo $murid->murid_telp_kantor;?>"/>       
                </div>
            </div>
            <div class="form-field col-xs-12">
                <div class="col-xs-3">
                    <label>Gender</label>
                </div>
                <div class="col-xs-9">
                    <select name="sex" class="field col-xs-12" required="required">
                        <option value="1" <?php echo ($murid->murid_gender==1)?'selected':'';?> >Pria</option>
                        <option value="2" <?php echo ($murid->murid_gender==2)?'selected':'';?> >Wanita</option>
                    </select>
                </div>
            </div>
            <div class="form-field col-xs-12">
                <div class="col-xs-3">
                    <label>Tempat Lahir</label>
                </div>
                <div class="col-xs-9">
                    <input type="text" class="field col-xs-12" name="tempat_lahir" value="<?php echo $murid->murid_tempatlahir;?>"/>       
                </div>
            </div>
            <div class="form-field col-xs-12">
                <div class="col-xs-3">
                    <label>Tanggal Lahir</label>
                </div>
                <div class="col-xs-9">
                    <input type="text" id="datebirth" class="field col-xs-12" name="tgl_lahir" 
                        value="<?php if ($murid->murid_lahir!='0000-00-00') echo $murid->murid_lahir; ?>"/>       
                </div>
            </div>
            <div class="form-field col-xs-12">
                <div class="col-xs-3">
                    <label>Alamat</label>
                </div>
                <div class="col-xs-9">
                    <textarea rows="5" class="field col-xs-12" name="alamat" required="required"><?php echo $murid->murid_alamat;?></textarea>
                </div>
            </div>
            <div class="form-field col-xs-12">
                <div class="col-xs-3">
                    <label>Alamat Domisili</label>
                </div>
                <div class="col-xs-9">
                    <textarea rows="5" class="field col-xs-12" name="alamat_domisili"><?php echo $murid->murid_alamat_domisili;?></textarea>
                </div>
            </div>
            <div class="form-field col-xs-12">
                <div class="col-xs-3">
                    <label>Lokasi</label>
                </div>
                <div class="col-xs-9">
                    <select id="provinsi" class="field col-xs-6">
                        <?php foreach($provinsi->result() as $p){ ?>
                            <option value="<?php echo $p->provinsi_id?>" 
                                <?php echo ($p->provinsi_id==$murid->provinsi_id)?'selected':''; ?>>
                                    <?php echo $p->provinsi_title?>
                            </option>
                        <?php } ?>
                    </select>
                    <select id="kota" name="lokasi" class="field col-xs-6" required="required">
                        <?php foreach($lokasi->result() as $l){ ?>
                            <option value="<?php echo $l->lokasi_id?>" 
                                <?php echo ($l->lokasi_id==$murid->lokasi_id)?'selected':''; ?> > <?php echo $l->lokasi_title ?> </option>
                        <?php } ?>
                    </select>
                </div>
            </div>
            <div class="form-field col-xs-12">
                <div class="col-xs-3">
                    <label>Referral id</label>
                </div>
                <div class="col-xs-9">
                    <input type="text" class="field col-xs-12" name="referal" 
                        value="<?php echo ($murid->murid_referral==0)?'':$murid->murid_referral;?>"/>       
                </div>
            </div>
            <div class="form-field col-xs-12">
                <div class="col-xs-3">
                    <label>Mengetahui Ruangguru Dari</label>
                </div>
                <?php $info_source = "";?>
                <?php $from = "";?>
                <?php $info = explode(",",$murid->source_info_id);?>
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
                    if(strlen($from)>0) {
                		if($i != $n){
                			$info_source .= $from.", ";
                		}else{
                			$info_source .= $from;
                		}
                    }
                  }
                }?>
                <div class="col-xs-9">
                    <input type="text" class="field col-xs-12" name="source" value="<?php echo $info_source;?>"/>       
                </div>
            </div>
            <div class="form-field col-xs-12">
                <div class="col-xs-3">
                    <label>Waktu &amp; Tanggal Daftar</label>
                </div>
                <div class="col-xs-9">
                    <input type="text" class="field col-xs-12" name="name" value="<?php echo $murid->murid_daftar;?>"/>       
                </div>
            </div>
            <div class="col-xs-12" style="text-align:right;margin-top:20px;margin-bottom:10px;">
                <button type="submit" class="btn btn-primary">Submit</button>
            </div>
        </div>
    </form>
</div>

<!-- Box -->
<div class="box">
    <!-- Box Head -->
    <div class="box-head">
        <h2>Edit Status Murid</h2>
    </div>
    <!-- End Box Head -->

    <form action="<?php echo base_url();?>admin/murid/edit_submit" method="post" >

        <!-- Form -->
        <div class="form">
            <input type="hidden" class="field size1" name="id" value="<?php echo $murid->murid_id;?>"/>
            <div class="table" style="width:400px;">
                <table>
                    <thead>
                        <tr>
                            <th class="center">Kategori</th>
                            <th class="center" colspan="2" width="120px;">Value</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td>Is Active</td>
                            <td>
                                <?php $config = 'class="checkbox"';?>
                                <label><?php echo form_radio('active', '0', ($murid->murid_active==0), $config);?><span>Tidak</span></label>                                
                            </td>
                            <td>
                                <label><?php echo form_radio('active', '1', ($murid->murid_active==1), $config);?><span>Ya</span></label>
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
        <h2>Poin Murid</h2>
    </div>
   <div class="content row" style="margin-top:0px;margin-left:20px;">
        <div class="col-xs-12">
            <form method="post" action="<?php echo base_url()?>admin/murid/add_poin/">
                <div class="col-xs-12" style="margin-top:20px;">
                    <div class="col-xs-3">
                        <input type="text" name="poin" placeholder="Jumlah Poin" required class="col-xs-12 field" />
                        <input type="hidden" name="id" value="<?php echo $murid->murid_id?>">
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
            <h4 style="margin-right:30px;">Total Poin Murid : <?php echo $total_poin ?> </h4>
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
                    <?php foreach($murid_poin->result_array() as $gp){ ?>
                        <tr>
                            <td><?php echo date('d-M-Y H:i:s', strtotime($gp['date_created']))?></td>
                            <td><?php echo $gp['point']?></td>
                            <td><?php echo $gp['keterangan']?></td>
                            <td><a href="<?php echo base_url() ?>admin/murid/delete_poin/<?php echo $murid->murid_id?>/<?php echo $gp['id']?>">Delete</a></td>
                        </tr>
                    <?php } ?>
                </tbody>
            </table>
        </div>
    </div>
</div>
<!-- End Box -->

<!-- Box -->
<div class="box">
    <!-- Box Head -->
    <div class="box-head">
        <h2>Delete Murid</h2>
    </div>
    <!-- End Box Head -->

        <div class="form">
            <p>
                <a href="<?php echo base_url().'admin/murid/delete/'.$murid->murid_id;?>" class="del">
                    <button class="button">
                        Delete Murid
                    </button>
                </a>
            </p>
        </div>
</div>
<!-- End Box -->
