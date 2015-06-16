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

    <div class="col-xs-12 row">
        <div class="col-xs-12">
            <h4><?php echo $pesan['subject'] ?></h4>
        </div>
        <div class="col-xs-12">
            <?php echo $pesan['pesan']?>
        </div>
    </div>
</div>
<!-- End Box -->