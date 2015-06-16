<?php if ($this->session->flashdata('f_kelas')): ?>
    <div class="msg msg-ok boxwidth">
        <p><strong><?php echo $this->session->flashdata('f_kelas'); ?></strong></p>
    </div>
<?php endif; ?>

<!-- Box -->
<div class="box">
    <!-- Box Head -->
    <div class="box-head">
        <h2 class="left">Reminder</h2>
    </div>
    <!-- End Box Head -->	

    <!-- Table -->
    <div class="table">
        <table width="100%" border="0" cellspacing="0" cellpadding="0">
            <tr>
                <th>No.</th>
                <th>Keterangan</th>
                <th>ID Kelas</th>
                <th>Tanggal Keterangan</th>
                <th class="center" colspan="2">Action</th>
            </tr>
            <?php if($page== 1){ $i=0; } else { $i=$start; } ?>
            <?php foreach($notif->result() as $g):?>
            <tr <?php echo (($i++%2)!=0)?'class="odd"':'';?>>
                <td class="column_id">
                    <a href="<?php echo base_url().'admin/reminder/view/'.$g->kelas_notif_id;?>"><?php echo $i;?></a>
                </td>
			 <td><?php echo $g->kelas_ket;?></td>
                <td><a href="<?php echo base_url().'admin/kelas/edit/'.$g->kelas_id;?>"><?php echo $g->kelas_id;?></a></td>
                <td><?php echo $g->kelas_tgl;?></td>
                <td class="center">
                    <a href="<?php echo base_url();?>admin/reminder/edit/<?php echo $g->kelas_notif_id;?>" class="ico edit">Edit</a>
                </td>
			 <td class="center">
                    <a href="<?php echo base_url();?>admin/reminder/delete/<?php echo $g->kelas_notif_id;?>" class="ico del">Delete</a>
                </td>
            </tr>
            <?php endforeach;?>
        </table>
        <!-- Pagging -->
        <div class="pagging">
            <div class="left">
                Showing <?php echo $start+1;?>-<?php echo $start+$notif->num_rows();?> of <?php echo $count;?>
            </div>
            <div class="right">
                <?php if($page>1):?>
                <a href="<?php echo base_url();?>admin/reminder/page/<?php echo $page-1;?>">Previous</a>
                <?php endif;?>
                <?php if(($start+$notif->num_rows()) < $count):?>
                <a href="<?php echo base_url();?>admin/reminder/page/<?php echo $page+1;?>">Next</a>
                <?php endif;?>
            </div>
        </div>
        <!-- End Pagging -->

    </div>
    <!-- Table -->

</div>
<!-- End Box -->