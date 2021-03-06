<<<<<<< .
<?php if ($this->session->flashdata('f_kelas')): ?>
    <div class="msg msg-ok boxwidth">
        <p><strong><?php echo $this->session->flashdata('f_kelas'); ?></strong></p>
    </div>
<?php endif; ?>

<!-- Box -->
<div class="box">
    <!-- Box Head -->
    <div class="box-head">
        <h2 class="left">Event</h2>
    </div>
    <!-- End Box Head -->	

    <!-- Table -->
    <div class="table">
        <table width="100%" border="0" cellspacing="0" cellpadding="0">
            <tr>
                <th>No.</th>
                <th>Nama</th>
                <th>Telp</th>
                <th>Terdaftar sbg</th>
                <th>Email</th>
			 <th>Is Verified</th>
                <th>Ikut Coaching Clinic?</th>
                <th>Tiket Terkirim</th>
                <th class="center" colspan="2">Action</th>
            </tr>
            <?php if($page== 1){ $i=0; } else { $i=$start; } ?>
            <?php foreach($event->result() as $g):?>
            <tr <?php echo (($i++%2)!=0)?'class="odd"':'';?>>
                <td class="column_id">
                    <a href="<?php echo base_url().'admin/event/view/'.$g->id_registrasi;?>"><?php echo $i;?></a>
                </td>
			 <td class="column_id">
                    <a href="<?php echo base_url().'admin/event/view/'.$g->id_registrasi;?>"><?php echo $g->nama_registrasi;?></a>
                </td>
			 <td class="column_id">
                   <?php echo $g->telepon_registrasi;?>
                </td>
			 <td class="column_id">
                   <?php if($g->status_registrasi == 1){ 
						echo "Guru";
					}elseif($g->status_registrasi == 2){
						echo "Murid";
					}elseif($g->status_registrasi == 3){
						echo "Duta";
					}elseif($g->status_registrasi == 4){
						echo "Umum";
					}
			    ?>
                </td>
			 <td class="column_id"><?php echo $g->email_registrasi?></td>
                <td class="column_id">
				<?php 
					if($g->is_verified == 0){
						echo "Unverified";
					}else{ ?>
						<a href="<?php echo base_url().'admin/event/send_email_invitation/'.$g->id_registrasi;?>">Send ticket</a>
				<?php } ?>
			 </td>
			 <td class="column_id">
				<?php 
					if($g->follow_coaching == 0){
						echo "No";
					}else{
						echo "Yes"; 
					} ?>
			 </td>
			 <td class="column_id">
				<?php 
					if($g->send_ticket == 0){
						echo "No";
					}else{
						echo "Yes"; 
					} ?>
			 </td>
			 <td class="center">
                    <a href="<?php echo base_url();?>admin/event/delete/<?php echo $g->id_registrasi;?>" class="ico del">Delete</a>
                </td>
            </tr>
            <?php endforeach;?>
        </table>
        <!-- Pagging -->
        <div class="pagging">
            <div class="left">
                Showing <?php echo $start+1;?>-<?php echo $start+$event->num_rows();?> of <?php echo $count;?>
            </div>
            <div class="right">
                <?php if($page>1):?>
                <a href="<?php echo base_url();?>admin/event/page/<?php echo $page-1;?>">Previous</a>
                <?php endif;?>
                <?php if(($start+$event->num_rows()) < $count):?>
                <a href="<?php echo base_url();?>admin/event/page/<?php echo $page+1;?>">Next</a>
                <?php endif;?>
            </div>
        </div>
        <!-- End Pagging -->

    </div>
    <!-- Table -->

</div>
=======
<?php if ($this->session->flashdata('f_kelas')): ?>
    <div class="msg msg-ok boxwidth">
        <p><strong><?php echo $this->session->flashdata('f_kelas'); ?></strong></p>
    </div>
<?php endif; ?>

<!-- Box -->
<div class="box">
    <!-- Box Head -->
    <div class="box-head">
        <h2 class="left">Event</h2>
    </div>
    <!-- End Box Head -->	

    <!-- Table -->
    <div class="table">
        <table width="100%" border="0" cellspacing="0" cellpadding="0">
            <tr>
                <th>No.</th>
                <th>Nama</th>
                <th>Telp</th>
                <th>Terdaftar sbg</th>
			 <th>Is Verified (send ticket jika status verified)</th>
                <th>Ikut Coaching Clinic?</th>
                <th class="center" colspan="2">Action</th>
            </tr>
            <?php if($page== 1){ $i=0; } else { $i=$start; } ?>
            <?php foreach($event->result() as $g):?>
            <tr <?php echo (($i++%2)!=0)?'class="odd"':'';?>>
                <td class="column_id">
                    <a href="<?php echo base_url().'admin/event/view/'.$g->id_registrasi;?>"><?php echo $i;?></a>
                </td>
			 <td class="column_id">
                    <a href="<?php echo base_url().'admin/event/view/'.$g->id_registrasi;?>"><?php echo $g->nama_registrasi;?></a>
                </td>
			 <td class="column_id">
                   <?php echo $g->telepon_registrasi;?>
                </td>
			 <td class="column_id">
                   <?php if($g->status_registrasi == 1){ 
						echo "Guru";
					}elseif($g->status_registrasi == 2){
						echo "Murid";
					}elseif($g->status_registrasi == 3){
						echo "Duta";
					}elseif($g->status_registrasi == 4){
						echo "Umum";
					}
			    ?>
                </td>
                <td class="column_id">
				<?php 
					if($g->is_verified == 0){
						echo "Unverified";
					}else{ ?>
						<a href="<?php echo base_url().'admin/event/send_email_invitation/'.$g->id_registrasi;?>">Send ticket</a>
				<?php } ?>
			 </td>
			 <td class="column_id">
				<?php 
					if($g->follow_coaching == 0){
						echo "No";
					}else{
						echo "Yes"; 
					} ?>
			 </td>
			 <td class="center">
                    <a href="<?php echo base_url();?>admin/event/delete/<?php echo $g->id_registrasi;?>" class="ico del">Delete</a>
                </td>
            </tr>
            <?php endforeach;?>
        </table>
        <!-- Pagging -->
        <div class="pagging">
            <div class="left">
                Showing <?php echo $start+1;?>-<?php echo $start+$event->num_rows();?> of <?php echo $count;?>
            </div>
            <div class="right">
                <?php if($page>1):?>
                <a href="<?php echo base_url();?>admin/event/page/<?php echo $page-1;?>">Previous</a>
                <?php endif;?>
                <?php if(($start+$event->num_rows()) < $count):?>
                <a href="<?php echo base_url();?>admin/event/page/<?php echo $page+1;?>">Next</a>
                <?php endif;?>
            </div>
        </div>
        <!-- End Pagging -->

    </div>
    <!-- Table -->

</div>
>>>>>>> .r88
<!-- End Box -->