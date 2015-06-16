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
        <h2 class="left">+ <a href="<?php echo base_url();?>admin/blog/add" class="top_box_link">Add Posts</a></h2>
    </div>
    <!-- End Box Head -->
    <div class="table">
        <table width="100%" border="0" cellspacing="0" cellpadding="0">
            <tr>
                <th class="center">No.</th>
                <th>Judul Post</th>
                <th width="300">Status<th>
                <th width="110" colspan="2">Control</th>
            </tr>
            <?php $i=0;?>
            <?php foreach($posts->result() as $row):?>
            <tr <?php echo (($i++%2)!=0)?'class="odd"':'';?>>
                <td class="center"><?php echo $i;?></td>
                <td><?php echo $row->blog_title;?></td>
                <td><?php if($row->blog_status == 1){ echo "Publish";} else { echo "Unpublish";}?></td>
                <td>
                    <a href="<?php echo base_url();?>admin/blog/edit/<?php echo $row->blog_id;?>" class="ico edit">Edit</a>
                </td>
			 <td>
                    <a href="<?php echo base_url();?>admin/blog/delete/<?php echo $row->blog_id;?>" class="ico del">Delete</a>
                </td>
            </tr>
            <?php endforeach;?>
        </table>
	</div>
</div>
<!-- End Box -->
