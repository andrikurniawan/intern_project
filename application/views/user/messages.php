<!-- Message Error -->
<?php if ($this->session->flashdata('f_user')): ?>
    <div class="msg msg-ok boxwidth">
        <p><strong><?php echo $this->session->flashdata('f_user'); ?></strong></p>
    </div>
<?php endif; ?>


<!-- Box -->
<div class="box">
    <!-- Box Head -->
    <div class="box-head">
        <h2>Pesan</h2>
    </div>
    <!-- End Box Head -->

    <div class="row" style="margin:0px;">
        <div class="col-xs-12" style="padding:0px;">
            <table class="table">
                <thead>
                    <tr>
                        <th>No</th>
                        <th>Subject</th>
                        <th>Waktu Pesan</th>
                        <th>Status</th>
                    </tr>
                </thead>
                <tbody>
                    <?php $count = 0; foreach($messages as $message){ ?>
                        <tr>
                            <td><?php echo ++$count; ?></td>
                            <td><a href="<?php echo base_url().'admin/user/read_message/'.$message['id']?>"><?php echo $message['subject']?></a></td>
                            <td><?php echo date('d-M-Y H:i:s', strtotime($message['date_created']))?></td>
                            <td><?php if($message['is_read']==0){echo 'Belum di baca';} else { echo 'Sudah di baca';}?></td>
                        </tr>
                    <?php } ?>
                </tbody>
            </table>
        </div>
    </div>
</div>
<!-- End Box -->