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
                <th>Guru</th>
                <th>Nama Kelas</th>
                <th>Mata Pelajaran</th>
                <th>Mulai</th>
                <th>Selesai</th>
                <th>Lokasi</th>
                <th>Status</th>
                <th class="center">Action</th>
            </tr>
            <?php $i=0;?>
            <?php foreach($kelas->result() as $g):?>
            <tr <?php echo (($i++%2)!=0)?'class="odd"':'';?>>
                <td><?php echo $i;?></td>
			 <?php $guru = $this->guru_model->get_guru_by_id($g->guru_id);?>
                <td><a href="<?php echo base_url()."admin/guru/view/".$guru->guru_id;?>"><?php echo $guru->guru_nama;?></a></td>
                <td><?php echo $g->kelas_guru_nama?></td>
                <td><?php echo $g->matpel_title;?></td>
                <td><?php echo $g->kelas_guru_tanggal_mulai;?></td>
                <td><?php echo $g->kelas_guru_tanggal_selesai;?></td>
                <td><?php echo $g->kelas_guru_lokasi;?></td>
                <td>
                    <?php if($g->kelas_guru_status==1):?>
                    <span class="ok">
                        <a href="<?php echo base_url().'admin/kelas_terbuka/change_status/'.$g->kelas_guru_id.'/0'?>">Active</a>
                    </span>
                    <?php else:?>
                    <span class="no">
                        <a href="<?php echo base_url().'admin/kelas_terbuka/change_status/'.$g->kelas_guru_id.'/1'?>">Inactive</a>
                    </span>
                    <?php endif;?>
                </td>
                <td class="center">
                    <a href="<?php echo base_url();?>admin/kelas/delete_kelas/<?php echo $g->kelas_guru_id;?>" class="ico del">Delete</a>
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