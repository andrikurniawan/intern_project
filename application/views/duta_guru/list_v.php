<!-- Message Error -->
<?php if ($this->session->flashdata('f_duta_guru')): ?>
    <div class="msg msg-ok boxwidth">
        <p><strong><?php echo $this->session->flashdata('f_duta_guru'); ?></strong></p>
    </div>
<?php endif; ?>


<!-- Box -->
<div class="box">
    <!-- Box Head -->
    <div class="box-head">
        <div class="right">
            <form action="<?php echo base_url();?>admin/duta_guru/search" method="post">
                <label>search guru</label>
                <input type="text" class="field small-field" name="duta_guru_name"/>
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
                <th>Nama</th>
                <th>Tanggal & Jam Daftar</th>
			 <th width="110">Control</th>
                
            </tr>
            <?php $i=0;?>
            <?php foreach($duta_guru->result() as $g):?>
            <tr <?php echo (($i++%2)!=0)?'class="odd"':'';?>>
                <td class="column_id">
                    <a href="<?php echo base_url().'admin/duta_guru/view/'.$g->duta_guru_id;?>">
                        <?php echo $g->duta_guru_id;?></td>
                    </a>
                </td>
                <td><?php echo $g->duta_guru_email;?></td>
                <td><?php echo $g->duta_guru_nama;?></td>
                <td><?php echo $g->duta_guru_daftar;?></td>
			 <td>
                    <a href="<?php echo base_url();?>admin/duta_guru/delete/<?php echo $g->duta_guru_id;?>" class="ico del" onclick="return confirm('Apakah Anda yakin akan menghapus Duta Guru ID = <?php echo $g->duta_guru_id ?>')">Delete</a>&nbsp;
                </td>
            </tr>
            <?php endforeach;?>
        </table>
        <!-- Pagging -->
        <div class="pagging">
            <div class="left">
                Showing <?php echo $start+1;?>-<?php echo $start+$duta_guru->num_rows();?> of <?php echo $count;?>
            </div>
            <div class="right">
                <?php if($page>1):?>
                <a href="<?php echo base_url();?>admin/duta_guru/page/<?php echo $page-1;?>">Previous</a>
                <?php endif;?>
                <?php if(($start+$duta_guru->num_rows()) < $count):?>
                <a href="<?php echo base_url();?>admin/duta_guru/page/<?php echo $page+1;?>">Next</a>
                <?php endif;?>
            </div>
        </div>
        <!-- End Pagging -->

    </div>
    <!-- Table -->

</div>
<!-- End Box -->