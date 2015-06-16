<?php if ($this->session->flashdata('f_kelas')): ?>
    <div class="msg msg-ok boxwidth">
        <p><strong><?php echo $this->session->flashdata('f_kelas'); ?></strong></p>
    </div>
<?php endif; ?>

<!-- Box -->
<div class="box">
    <!-- Box Head -->
    <div class="box-head">
        <h2 class="left">+ <a href="<?php echo base_url();?>admin/kelas/add_kelas" class="top_box_link">Add Kelas</a></h2>
	   <div class="right">
            <form action="<?php echo base_url();?>admin/kelas/search" method="post">
                <label>search by murid</label>
                <input type="text" class="field small-field" name="murid_name"/>
                <input type="submit" class="button" value="search" />
            </form>
        </div>
    </div>
    <!-- End Box Head -->	

    <!-- Table -->
    <div class="table">
        <table width="100%" border="0" cellspacing="0" cellpadding="0">
            <tr>
                <th>ID</th>
                <th>Murid</th>
                <th>Guru</th>
                <th>Mata Pelajaran</th>
                <th>Mulai</th>
                <th>Lokasi</th>
                <th>Discount</th>
                <th>Status</th>
                <th class="center">Action</th>
            </tr>
            <?php $i=0;?>
            <?php foreach($kelas->result() as $g):?>
            <tr <?php echo (($i++%2)!=0)?'class="odd"':'';?>>
                <td class="column_id">
                    <a href="<?php echo base_url().'admin/kelas/edit/'.$g->kelas_id;?>"><?php echo $g->kelas_id;?></a>
					<?php $x = $this->kelas_model->get_reminder_kelas($g->kelas_id);
					foreach($x->result() as $k){
						if(strtotime(date("Y-m-d")) == strtotime($k->kelas_tgl)){
							if(($x->num_rows()) > 0){ ?>
								<a href="<?php echo base_url().'admin/reminder/view/'.$k->kelas_notif_id;?>" class="nounderline"><span class="badge">N</span></a>
							<?php } ?>
						<?php } ?>
					<?php } ?>
                </td>
                <td>
                    <a href="<?php echo base_url().'admin/murid/view/'.$g->murid_id;?>"><?php echo $g->murid_nama;?></a>
                </td>
                <td>
                    <a href="<?php echo base_url().'admin/guru/view/'.$g->guru_id;?>"><?php echo $g->guru_nama;?></a>
                </td>
                <td><?php echo $g->matpel_title;?></td>
                <td><?php echo $g->kelas_mulai;?></td>
                <td><?php echo $g->lokasi_title;?></td>
                <td><?php if($g->kelas_discount==0){ echo "Tidak";} else { echo "Ya";} ?></td>
                <td>
                    <?php if($g->kelas_status==1):?>
                    <span class="ok">
                        Active
                    </span>
                    <?php else:?>
                    <span class="no">
                        Closed
                    </span>
                    <?php endif;?>
                </td>
                <td class="center">
                    <?php if($g->kelas_status==1):?>
                    <span class="ok">
                        <a class="ico edit" href="<?php echo base_url();?>admin/kelas/change_kelas_status/<?php echo $g->kelas_id;?>/0">Close</a>
                    </span>
                    <?php else:?>
                    <span class="no">
                        <a class="ico edit" href="<?php echo base_url();?>admin/kelas/change_kelas_status/<?php echo $g->kelas_id;?>/1">Open</a>
                    </span>
                    <?php endif;?>
                    <a href="<?php echo base_url();?>admin/kelas/delete_kelas/<?php echo $g->kelas_id;?>" class="ico del">Delete</a>
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