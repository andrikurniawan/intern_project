<!-- Message Error -->
<?php if ($this->session->flashdata('f_sertifikat')): ?>
    <div class="msg msg-ok boxwidth">
        <p><strong><?php echo $this->session->flashdata('f_sertifikat'); ?></strong></p>
    </div>
<?php endif; ?>

<!-- Box -->
<div class="box">
    <!-- Box Head -->
    <div class="box-head">
        <h2>Sertifikat</h2>
    </div>
    <!-- End Box Head -->	

    <!-- Table -->
    <div class="table">
        <table width="100%" border="0" cellspacing="0" cellpadding="0">
            <tr>
                <th>ID</th>
                <th>Nama Guru</th>
                <th>Name Sertifikat</th>
                <th>File</th>
                <th class="center">Checked</th>
                <th width="110" class="ac">Control</th>
            </tr>
            <?php $i=0;?>
<?php foreach($sertifikat->result() as $g):
	
?>
            <?php if($g->sertifikat != null && strlen($g->sertifikat)>0 && file_exists('./files/sertifikat/'.$g->sertifikat.'')){ ?>
            <tr <?php echo (($i++%2)!=0)?'class="odd"':'';?>>
                <td class="column_id"><?php echo $g->id;?></td>
                <td>
                    <a href="<?php echo base_url();?>admin/guru/view/<?php echo $g->guru_id;?>">
                        <?php echo $g->guru_nama;?>
                    </a>
                </td>
                <td><?php echo $g->kualifikasi?></td>
                <td>
<?php if(!empty($g->sertifikat)):?>
                    <a href="<?php echo base_url();?>files/sertifikat/<?php echo $g->sertifikat;?>" target="_blank">
                        <?php echo substr($g->sertifikat, 0, 20)." ...";?>
                    </a>
<?php else: ?>
					<span>Sertifikat tidak tersedia</span>
<?php endif;?>
                </td>
                <td class="center">
                    <?php if($g->is_checked==1):?>
                    <span class="ok">
                        Yes
                    </span>
                    <?php else:?>
                    <span class="no">
                        No
                    </span>
                    <?php endif;?>
                </td>
                <td class="center">
                    <?php if($g->is_checked==1):?>
                    <span class="ok">
                        <a class="ico edit" href="<?php echo base_url();?>admin/utilities/change_sertifikat_status/<?php echo $g->id;?>/0/<?php echo $page;?>">Uncheck</a>
                    </span>
                    <?php else:?>
                    <span class="no">
                        <a class="ico edit" href="<?php echo base_url();?>admin/utilities/change_sertifikat_status/<?php echo $g->id;?>/1/<?php echo $page;?>">Check</a>
                    </span>
                    <?php endif;?>
                    <a href="<?php echo base_url();?>admin/utilities/sertifikat_delete/<?php echo $g->guru_id.'/'.$g->id;?>/<?php echo $page;?>" class="ico del">delete</a>
                </td>
            </tr>
            <?php } ?>
            <?php endforeach;?>
        </table>
        <!-- Pagging -->
        <div class="pagging">
            <div class="left">
                Showing <?php echo $start+1;?>-<?php echo $start+$sertifikat->num_rows();?> of <?php echo $count;?>
            </div>
            <div class="right">
                <?php if($page>1):?>
                <a href="<?php echo base_url();?>admin/utilities/sertifikat/<?php echo $page-1;?>">Previous</a>
                <?php endif;?>
                <?php if(($start+$sertifikat->num_rows()) < $count):?>
                <a href="<?php echo base_url();?>admin/utilities/sertifikat/<?php echo $page+1;?>">Next</a>
                <?php endif;?>
            </div>
        </div>
        <!-- End Pagging -->
    </div>
    <!-- Table -->

</div>
<!-- End Box -->