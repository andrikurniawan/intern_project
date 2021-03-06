    <!-- Box -->
    <div class="box">
        <!-- Box Head -->
        <div class="box-head">
            <h2>Daftar NPWP Guru</h2>
        </div>
        <!-- End Box Head -->
        <!-- Form -->
        <div class="table">
            <table style="width: 100%">
                <thead>
                    <tr class="center">
                        <th>No</th>
                        <th>ID Guru</th>
                        <th>Nama Guru</th>
                        <th>Email</th>
                        <th>File</th>
                        <th>Status</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                    <?php $index = 1; foreach($npwp->result_array() as $data) { ?>
                        <tr>
                            <td><?php echo $index; ?></td>
                            <td><?php echo $data['guru_id']; ?></td>
                            <td><a href="<?php echo base_url();?>admin/guru/view/<?php echo $data['guru_id'];?>">
                                <?php echo $data['guru_nama'];?>
                            </a></td>
                            <td><?php echo $data['guru_email']; ?></td>
                            <td><a href="<?php echo base_url()?>files/npwp/<?php echo $data['guru_npwp_image'];?>" target="_blank"><i class="glyphicon glyphicon-search"></i>&nbsp;View</a></td>
                            <td><a href="<?php echo base_url()?>admin/utilities/change_status_npwp/<?php echo $data['guru_id']?>/<?php echo $data['guru_npwp_verified']?>/<?php echo $page?>">
                                <?php if($data['guru_npwp_verified']==1){ echo "Confirmed"; } else { echo "Unconfirmed"; } ?></a></td>
                            <td><a href="<?php echo base_url()?>admin/utilities/hapus_npwp/<?php echo $data['guru_id']?>/<?php echo $page?>"><i class="glyphicon glyphicon-trash"></i>&nbsp; Hapus</a></td>     
                        </tr>
                    <?php $index++; } ?>
                </tbody>
            </table>
            <div class="pagging">
                <div class="left">
                    <?php if($page>1):?>
                    <a href="<?php echo base_url();?>admin/utilities/npwp_guru/<?php echo $page-1;?>">Previous</a>
                    <?php endif;?>
                </div>
                <div class="right">
                    <?php if(($start+$npwp->num_rows()) < $count):?>
                    <a href="<?php echo base_url();?>admin/utilities/npwp_guru/<?php echo $page+1;?>">Next</a>
                    <?php endif;?>
                </div>
            </div>
        </div>
    </div>
    <!-- End Box -->