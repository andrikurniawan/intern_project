<!-- Box -->
<div class="box">
    <!-- Box Head -->
    <div class="box-head">
        <h2>Upload data</h2>
    </div>
    <!-- End Box Head -->

    <form id="add-kelas" action="<?php echo base_url();?>admin/upload/submit" method="post" enctype="multipart/form-data">

        <!-- Form -->
        <div class="form">
            <p>
                <label>Upload data</label>
                <input id="tobe_duta" type="file" class="field size1" name="tobe_duta"/>
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