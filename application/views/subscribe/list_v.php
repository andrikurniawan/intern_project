<!-- Box -->
<div class="box">
    <!-- Box Head -->
    <div class="box-head">
        <div class="right">
            <form action="<?php echo base_url();?>admin/utilities/search_subscribe" method="post">
                <label>search</label>
                <input type="text" class="field small-field" name="search"/>
                <input type="submit" class="button" placeholder="search" />
            </form>
        </div>
    </div>
    <!-- End Box Head -->	

    <!-- Table -->
    <div class="table">
        <table width="100%" border="0" cellspacing="0" cellpadding="0">
            <tr>
                <th>No</th>
                <th>Nama</th>
                <th>Email</th>
            </tr>
            <?php $i=0;?>
            <?php foreach($subscriber->result() as $g):?>
            <tr <?php echo (($i++%2)!=0)?'class="odd"':'';?>>
                <td class="column_id"><?php echo $i;?></td>
                <td class="column_id"><?php echo $g->subscriber_nama;?></td>
                <td><?php echo $g->subscriber_email;?></td>
            </tr>
            <?php endforeach;?>
        </table>

    </div>
    <!-- Table -->

</div>
<!-- End Box -->