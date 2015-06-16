<!-- Box -->
<div class="box">
    <!-- Box Head -->
    <div class="box-head">
        <div class="right">
            <form action="<?php echo base_url();?>admin/comingsoon/search" method="post">
                <label>search email</label>
                <input type="text" class="field small-field" name="email"/>
                <input type="submit" class="button" value="search" />
            </form>
        </div>
    </div>
    <!-- End Box Head -->	

    <!-- Table -->
    <div class="table">
        <table width="100%" border="0" cellspacing="0" cellpadding="0">
            <tr>
                <th>No</th>
                <th>Email</th>
            </tr>
            <?php $i=0;?>
            <?php foreach($email->result() as $g):?>
            <tr <?php echo (($i++%2)!=0)?'class="odd"':'';?>>
                <td class="column_id"><?php echo $i;?></td>
                <td><?php echo $g->email;?></td>
            </tr>
            <?php endforeach;?>
        </table>

    </div>
    <!-- Table -->

</div>
<!-- End Box -->