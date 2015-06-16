<?php if ($this->session->flashdata('f_kelas')): ?>
    <div class="msg msg-ok boxwidth">
        <p><strong><?php echo $this->session->flashdata('f_kelas'); ?></strong></p>
    </div>
<?php endif; ?>

<!-- Box -->
<div class="box">
    <!-- Box Head -->
    <div class="box-head">
        <h2 class="left">+ <a href="<?php echo base_url();?>admin/matpel/add_matpel/<?php echo $jenjang->jenjang_pendidikan_id; ?>" class="top_box_link">Tambah Mata Pelajaran</a></h2>
    </div>
    <!-- End Box Head -->

    <!-- Table -->
    <div class="table">
        <table width="100%" border="0" cellspacing="0" cellpadding="0">
            <tr>
                <th>No.</th>
                <th>Kategori Pendidikan</th>
                <th>Matpel</th>
                <th class="center" colspan="2">Action</th>
            </tr>
			<?php $i=0;?>
            <?php foreach($matpel->result() as $g):?>
            <tr <?php echo (($i++%2)!=0)?'class="odd"':'';?>>
                <td class="column_id"><?php echo $i;?></td>
                <td class="column_id"><?php echo $jenjang->jenjang_pendidikan_title;?></td>
				<td class="column_id"><?php echo $g->matpel_title;?></td>
				<td class="center">
                    <a href="<?php echo base_url();?>admin/matpel/edit_matpel/<?php echo $g->matpel_id;?>" class="ico edit">Edit</a>
                </td>
				<td class="center">
                    <a href="<?php echo base_url();?>admin/matpel/delete_matpel/<?php echo $g->matpel_id;?>" class="ico del">Delete</a>
                </td>
            </tr>
            <?php endforeach;?>
        </table>
    </div>
    <!-- Table -->

</div>
<!-- End Box -->