<!-- Box -->
<div class="box">
    <!-- Box Head -->
    <div class="box-head">
        <h2>Upload data</h2>
    </div>
    <!-- End Box Head -->

    <form id="add-kelas" action="<?php echo base_url();?>admin/upload/send_all" method="post" enctype="multipart/form-data">

        <!-- Form -->
        <div class="form">
            <p>
                <label>Upload data</label>
                <input id="data_email" type="file" class="field size1" name="data_email"/>&nbsp;&nbsp;&nbsp;
				<label for="nl2br"><input type="checkbox" name="nl2br" value="1" />&nbsp;&nbsp;nl2br</label>
            </p>
        </div>
        <!-- End Form -->
        
        <!-- Form Buttons -->
        <div class="buttons">
            <input type="submit" class="button" value="submit" />
        </div>
        <!-- End Form Buttons -->
    </form>
</div>
<!-- End Box -->