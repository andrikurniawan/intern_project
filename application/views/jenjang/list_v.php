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
        <h2 class="left">+ <a href="<?php echo base_url();?>admin/matpel/add" class="top_box_link">Tambah Kategori Pendidikan</a></h2>
    </div>
    <!-- End Box Head -->
    <div class="table">
        <table width="100%" border="0" cellspacing="0" cellpadding="0">
            <tr>
                <th class="center">No.</th>
                <th class="center">Kategori Pendidikan</th>
                <th width="300">Urutan<th>
                <th width="110" colspan="4">Control</th>
            </tr>
            <?php $i=0;?>
            <?php foreach($jenjang->result() as $row):?>
            <tr <?php echo (($i++%2)!=0)?'class="odd"':'';?>>
                <td class="center"><?php echo $i;?></td>
                <td><?php echo $row->jenjang_pendidikan_title;?></td>
                <td><?php echo $row->jenjang_pendidikan_index;?></td>
                <td>
					<a href="<?php echo base_url();?>admin/matpel/up/<?php echo $row->jenjang_pendidikan_id;?>" class="ico up"></a>
					<a href="<?php echo base_url();?>admin/matpel/down/<?php echo $row->jenjang_pendidikan_id;?>" class="ico down"></a>
				</td>
				<td>
                    <a href="<?php echo base_url();?>admin/matpel/list_matpel/<?php echo $row->jenjang_pendidikan_id;?>" class="ico open">&nbsp;Open</a>
                </td>
                <td>
                    <a href="<?php echo base_url();?>admin/matpel/edit/<?php echo $row->jenjang_pendidikan_id;?>" class="ico edit">Edit</a>
                </td>
			    <td>
                    <a href="<?php echo base_url();?>admin/matpel/delete/<?php echo $row->jenjang_pendidikan_id;?>" class="ico del">Delete</a>
                </td>
            </tr>
            <?php endforeach;?>
        </table>
	</div>
</div>
<!-- End Box -->
