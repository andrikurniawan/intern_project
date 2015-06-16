<!-- Message Error -->
<?php if ($this->session->flashdata('f_sertifikat')): ?>
    <div class="msg msg-ok boxwidth">
        <p><strong><?php echo $this->session->flashdata('f_sertifikat'); ?></strong></p>
    </div>
<?php endif; ?>

<!-- Box -->
<div class="box">
    <!-- Box Head -->
    <div class="box-head">
        <h2>+ Panduan Guru</h2>
    </div>
    <!-- End Box Head -->   
    <div class="table row" style="padding-bottom:20px;">
        <div class="col-xs-12">
            <form class="col-xs-11 col-xs-offset-1" action="<?php echo base_url()?>admin/utilities/add_panduan/"
                    method="post" enctype="multipart/form-data">
                <div class="col-xs-12" style="margin-top:10px;">
                    <div class="col-xs-2">
                        <label>Nama Dokumen</label>
                    </div>
                    <div class="col-xs-8">
                        <input type="text" name="nama_dokumen" class="col-xs-12" required="required"/>
                    </div>
                </div>
                <div class="col-xs-12" style="margin-top:10px;">
                    <div class="col-xs-2">
                        <label>Keterangan</label>
                    </div>
                    <div class="col-xs-8">
                        <textarea type="text" name="keterangan_dokumen" class="col-xs-12" required="required"></textarea>
                    </div>
                </div>
                <div class="col-xs-12" style="margin-top:10px;">
                    <div class="col-xs-2">
                        <label>File</label>
                    </div>
                    <div class="col-xs-8">
                        <input type="file" name="userfile" class="col-xs-12" required="required" />
                    </div>
                </div>
                <div class="col-xs-10" style="text-align:right">
                    <button type="submit" class="btn btn-primary">Submit</button>
                </div>
            </form>
        </div>
    </div>
    <!-- Box Head -->
    <div class="box-head">
        <h2>List Dokumen Panduan Guru</h2>
    </div>
    <!-- End Box Head -->   

    <!-- Table -->
    <div class="table">
        <table width="100%" border="0" cellspacing="0" cellpadding="0">
            <thead>
                <tr>
                    <th>#</th>
                    <th>Nama Dokumen</th>
                    <th>Keterangan</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
                <?php $counter = 0; foreach($dokumen as $d) { ?>
                <tr>
                    <td><?php echo ++$counter ?></td>
                    <td><?php echo $d['nama_dokumen'] ?></td>
                    <td><?php echo $d['keterangan'] ?></td>
                    <td>
                        <a href="<?php echo base_url()?>files/panduan/<?php echo $d['url']?>" target="_blank">
                            <i class="glyphicon glyphicon-save"></i>
                        </a>
                        <a href="<?php echo base_url()?>admin/utilities/hapus_panduan/<?php echo $d['id']?>">
                            <i class="glyphicon glyphicon-trash"></i>
                        </a>
                    </td>
                </tr>
                <?php } ?>
            </tbody>
        </table>
    </div>
    <!-- Table -->

</div>
<!-- End Box -->