<!-- Message Error -->
<?php if ($this->session->flashdata('f_request')): ?>
    <div class="msg msg-ok boxwidth">
        <p><strong><?php echo $this->session->flashdata('f_request'); ?></strong></p>
    </div>
<?php endif; ?>

<!-- Box -->
<div class="box">
    <!-- Box Head -->
    <div class="box-head">
        <h2>Data Request from Sidebar</h2>
    </div>
    <!-- End Box Head -->

    <!--<form method="post">-->

        <!-- Form -->
        <div class="form">
            <p>
                <label>ID</label>
                <input type="text" class="field size1" name="name" value="<?php echo $request->id_request;?>" disabled="true"/>       
            </p>
            <p>
                <label>Nama</label>
                <input type="text" class="field size1" name="name" value="<?php echo $request->nama_request;?>" disabled="true"/>
            </p>
            <p>
                <label>Telepon</label>
                <input type="text" class="field size1" name="name" disabled value="<?php echo $request->telp_request;?>"/>       
            </p>
		  <p>
                <label>Mata Pelajaran</label>
                <input type="text" class="field size1" name="name" disabled value="<?php echo $request->matpel_request;?>"/>       
            </p>
		  <p>
                <label>Email</label>
                <input type="text" class="field size1" name="name" disabled value="<?php echo $request->email_request;?>"/>       
            </p>
		  <p>
                <label>Lokasi</label>
                <textarea rows="10" cols="100"><?php echo $request->lokasi_request;?></textarea>       
            </p>
		  <p>
                <label>Request</label>
                <textarea rows="10" cols="100"><?php echo $request->request_request;?></textarea>       
            </p>
        </div>
</div>