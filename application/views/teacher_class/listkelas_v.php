<?php if ($this->session->flashdata('f_kelas')): ?>
    <div class="msg msg-ok boxwidth">
        <p><strong><?php echo $this->session->flashdata('f_kelas'); ?></strong></p>
    </div>
<?php endif; ?>

<!-- Box -->
<div class="box">
    <!-- Box Head -->
    <div class="box-head">
        <h2 class="left">+ <a href="<?php echo base_url();?>" class="top_box_link">Add Kelas</a></h2>
    </div>
    <!-- End Box Head -->	

    <!-- Table -->
    <div class="table">
        <table width="100%" border="0" cellspacing="0" cellpadding="0">
            <tr>
                <th>No.</th>
                <th>Nama Kelas</th>
                <th>Murid</th>
                <th class="center">Action</th>
            </tr>
            <?php $i=0;?>
            <?php foreach($kelas->result() as $g):?>
            <tr <?php echo (($i++%2)!=0)?'class="odd"':'';?>>
                <td><?php echo $i;?></td>
                <td><?php echo $g->kelas_guru_nama?></td>
                <td><a href="<?php echo base_url().'admin/murid/view/'.$g->murid_id;?>"><?php echo $g->murid_nama;?></a></td>
                <td class="center">
                    <a href="<?php echo base_url();?>admin/kelas_terbuka/delete/<?php echo $g->kelas_murid_id;?>" class="ico del">Delete</a>
                </td>
            </tr>
            <?php endforeach;?>
        </table>
        <!-- Pagging -->
        <div class="pagging">
            <div class="left">
                Showing <?php echo $start+1;?>-<?php echo $start+$kelas->num_rows();?> of <?php echo $count;?>
            </div>
            <div class="right">
                <?php if($page>1):?>
                <a href="<?php echo base_url();?>admin/kelas/page/<?php echo $page-1;?>">Previous</a>
                <?php endif;?>
                <?php if(($start+$kelas->num_rows()) < $count):?>
                <a href="<?php echo base_url();?>admin/kelas/page/<?php echo $page+1;?>">Next</a>
                <?php endif;?>
            </div>
        </div>
        <!-- End Pagging -->

    </div>
    <!-- Table -->

</div>
<!-- End Box -->