<!-- Box -->
<div class="box">
    <!-- Box Head -->
    <div class="box-head">
        <h2>ID Terbaru</h2>
    </div>
    <!-- End Box Head -->	

    <!-- Table -->
    <div class="table">
        <table width="100%" border="0" cellspacing="0" cellpadding="0">
            <tr>
                <th>ID</th>
                <th>Email</th>
                <th>Name</th>
                <th>ID Modified Date</th>
                <th width="110" class="ac">Control</th>
            </tr>
            <?php $i=0;?>
            <?php foreach($guru->result() as $g):?>
            <tr <?php echo (($i++%2)!=0)?'class="odd"':'';?>>
                <td class="column_id">
                    <a href="<?php echo base_url().'admin/guru/view/'.$g->guru_id;?>"><?php echo $g->guru_id;?></a>
                </td>
                <td><?php echo $g->guru_email;?></td>
                <td><?php echo $g->guru_nama;?></td>
                <td><?php echo $g->guru_nik_image_modified;?></td>
                <td>
                    <a href="<?php echo base_url();?>admin/guru/edit/<?php echo $g->guru_id;?>" class="ico edit">Edit</a>
                    <a href="<?php echo base_url();?>admin/guru/sertifikat/<?php echo $g->guru_id;?>" class="ico file">Sertifikat</a>
                    <a href="<?php echo base_url();?>admin/guru/rating/<?php echo $g->guru_id;?>" class="ico rating">Rating</a>
                </td>
            </tr>
            <?php endforeach;?>
        </table>
        <!-- Pagging -->
        <div class="pagging">
            <div class="left">
                Showing <?php echo $start+1;?>-<?php echo $start+$guru->num_rows();?> of <?php echo $count;?>
            </div>
            <div class="right">
                <?php if($page>1):?>
                <a href="<?php echo base_url();?>admin/utilities/nik/<?php echo $page-1;?>">Previous</a>
                <?php endif;?>
                <?php if(($start+$guru->num_rows()) < $count):?>
                <a href="<?php echo base_url();?>admin/utilities/nik/<?php echo $page+1;?>">Next</a>
                <?php endif;?>
            </div>
        </div>
        <!-- End Pagging -->

    </div>
    <!-- Table -->

</div>
<!-- End Box -->