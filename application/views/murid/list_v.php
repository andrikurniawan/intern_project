<!-- Message Error -->
<?php if ($this->session->flashdata('f_murid')): ?>
    <div class="msg msg-ok boxwidth">
        <p><strong><?php echo $this->session->flashdata('f_murid'); ?></strong></p>
    </div>
<?php endif; ?>

<!-- Box -->
<div class="box">
    <!-- Box Head -->
    <div class="box-head">
        <div class="right">
            <form action="<?php echo base_url();?>admin/murid/search" method="post">
                <label>search murid</label>
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
                <th>Email</th>
                <th>Name</th>
                <th>HP</th>
                <th>Lokasi</th>
                <th>Tanggal & Jam Daftar</th>
			 <th width="50">Progress</th>
			 <th width="50">Status Call</th>
			 <th width="50">Ops</th>
			 <th width="50">Control</th>
            </tr>
            <?php $i=0;?>
            <?php foreach($murid->result() as $g):?>
            <tr <?php echo (($i++%2)!=0)?'class="odd"':'';?>>
                <td class="column_id">
                    <a href="<?php echo base_url().'admin/murid/view/'.$g->murid_id;?>"><?php echo $g->murid_id;?></a>
                </td>
                <td><?php echo $g->murid_email;?></td>
                <td><?php echo $g->murid_nama;?></td>
                <td><?php echo $g->murid_hp;?></td>
                <td><?php echo $g->lokasi_title;?></td>
                <td><?php echo $g->murid_daftar;?></td>
                <td><a href="<?php echo base_url().'admin/murid/change_progress/'.$g->murid_id.'/'.$page;?>"><?php if ($g->murid_call_progress == 1){ echo "Success";} else {echo "In progress";};?></a></td>
                <td><a href="<?php echo base_url().'admin/murid/change_call/'.$g->murid_id.'/'.$page;?>"><?php if ($g->murid_call_status == 1){ echo "Active";} else {echo "Inactive";};?></a></td>
                <td>
				<form method="post" action="<?php echo base_url().'admin/murid/change_ops/'.$g->murid_id.'/'.$page;?>">
					<select name='ops' onchange='if(this.value != 0) { this.form.submit(); }'>
						<option value='0' <?php if($g->murid_handle_by == 0){ echo "selected";} ?>>-</option>
						<option value='1' <?php if($g->murid_handle_by == 1){ echo "selected";} ?>>NF</option>
						<option value='2' <?php if($g->murid_handle_by == 2){ echo "selected";} ?>>MR</option>
						<option value='3' <?php if($g->murid_handle_by == 3){ echo "selected";} ?>>PW</option>
						<option value='4' <?php if($g->murid_handle_by == 4){ echo "selected";} ?>>MH</option>
					</select>
				</form>
			 </td>
			 <td>
                    <a href="<?php echo base_url();?>admin/murid/delete/<?php echo $g->murid_id;?>" class="ico del" onclick="return confirm('Apakah Anda yakin akan menghapus Murid ID = <?php echo $g->murid_id ?>')">Delete</a>&nbsp;
                </td>
            </tr>
            <?php endforeach;?>
        </table>
        <!-- Pagging -->
        <div class="pagging">
            <div class="left">
                Showing <?php echo $start+1;?>-<?php echo $start+$murid->num_rows();?> of <?php echo $count;?>
            </div>
            <div class="right">
                <?php if($page>1):?>
                <a href="<?php echo base_url();?>admin/murid/page/<?php echo $page-1;?>">Previous</a>
                <?php endif;?>
                <?php if(($start+$murid->num_rows()) < $count):?>
                <a href="<?php echo base_url();?>admin/murid/page/<?php echo $page+1;?>">Next</a>
                <?php endif;?>
            </div>
        </div>
        <!-- End Pagging -->

    </div>
    <!-- Table -->

</div>
<!-- End Box -->