<!-- Message Error -->
<?php if ($this->session->flashdata('f_home')): ?>
    <div class="msg msg-ok boxwidth">
        <p><strong><?php echo $this->session->flashdata('f_home'); ?></strong></p>
    </div>
<?php endif; ?>

<!-- Box -->
<div class="box">
    <!-- Box Head -->
    <div class="box-head">
        <h2>Edit Posts</h2>
    </div>
    <!-- End Box Head -->
    
    <form action="<?php echo base_url();?>admin/blog/edit_submit" method="post" enctype="multipart/form-data">

        <!-- Form -->
        <div class="form">
            <p>
                <label>Blog Post</label>
                <table>
				<tr>
                          <td style="padding-left: 20px;"><label>Judul Post</label></td>
				      <td><input type="text" class="field size1" name="title" id="title" value="<?php echo $post->blog_title;?>"/></td>
				      <td><input type="hidden" class="field size1" name="id" id="id" value="<?php echo $post->blog_id;?>"/></td>
                    </tr>
				<tr>
                          <td style="padding-left: 20px;"><label>Konten</label></td>
				      <td><textarea class="field size1" rows="10" cols="30" name="content"><?php echo $post->blog_content;?></textarea></td>
                    </tr>
				 <tr>
                          <td class="center"><label>Image</label></td>
					 <td class="center" colspan="2"><input id="gambar" type="file" class="field size1" name="gambar" value="<?php echo $post->blog_image;?>"/></td>
                     </tr>
				 <tr>
                          <td class="center"><label>Status</label></td>
					 <td class="left">
						<input id="status" type="radio" name="status" value="1" <?php if($post->blog_status == 1){ echo "checked";}?>/>Publish<br/>
						<input id="status" type="radio" name="status" value="0" <?php if($post->blog_status == 0){ echo "checked";}?>/>Draft
					 </td>
                     </tr>
				<tr><td>&nbsp;</td></tr>
                </table>
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