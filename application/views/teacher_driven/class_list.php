<?php
/**
 * Created by :
 * 
 * User: AndrewMalachel
 * Date: 2/5/15
 * Time: 4:00 PM
 * Proj: prod-new
 */
if ($this->session->flashdata('f_class')): ?>
	<div class="msg msg-ok boxwidth">
		<p><strong><?php echo $this->session->flashdata('f_class'); ?></strong></p>
	</div>
<?php endif; 
if ($this->session->flashdata('f_class_error')): ?>
	<div class="msg msg-error boxwidth">
		<p><strong><?php echo $this->session->flashdata('f_class_error'); ?></strong></p>
	</div>
<?php endif; ?>
<!-- Box -->
<script type="application/javascript" src="<?php echo base_url();?>js/jquery.fancybox.js"></script>
<link rel="stylesheet" type="text/css" href="<?php echo base_url();?>css/jquery.fancybox.css" media="screen" />
<script type="application/javascript" src="<?php echo base_url();?>js/jquery.fancybox-media.js?v=1.0.6"></script>
<script type="application/javascript">
	var base_url = "<?php echo base_url()?>";
</script>
<div class="box">
	<!-- Box Head -->
	<div class="box-head">
		<h2 class="left">Class Management</h2>
		<div class="right">
			<form action="<?php echo base_url();?>admin/teacher_driven/class_search" method="post">
				<label>search class by name</label>
				<input type="text" class="field small-field" name="class_name" placeholder="search all words" />
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
				<th>Name (URI)</th>
				<th>Vendor name</th>
				<th>Peserta (min/max)</th>
				<th>Category</th>
				<th>Level</th>
				<th>Session</th>
				<th>Status</th>
				<th>Active</th>
				<th class="center">Action</th>
			</tr>
<?php $i=0;?>
<?php foreach($class as $g):?>
				<tr class="data-row<?php echo (($i++%2)!=0)?' odd':''?>" data-page="<?php echo ceil
				($i/20); 
				?>">
					<td class="column_id">
						<a href="<?php echo base_url()?>vendor/kelas/detil/<?php echo $g->id;?>" target="_blank">
							<?php echo $g->id;?>
						</a>
					</td>
					<td>
						<?php echo $g->class_nama; ?> (<?php echo $g->class_uri;?>)
					</td>
					<td>
						<a class="ico fancybox" data-sub="vendor" 
						   href="#detail_vendor" data-id="<?php echo $g->vendor_id;?>">
						   <?php echo $g->vendor_name." ({$g->vendor_id})"; ?> 
						</a>
					</td>
					<td><?php echo $g->class_peserta_min;?>/<?php echo $g->class_peserta_max;?></td>
					<td>
						<?php echo $g->category_name?>
					</td>
					<td><?php echo $g->level_name;?></td>
					<td><?php echo $g->session_count;?></td>
					<td><?php if($g->class_status==1):?>
							<span class="ok">Approved</span>
						<?php elseif($g->class_status==4):
								if($g->active==1):
							?>
							<span class="no">Request for Unpublish</span>
						<?php elseif($g->active==0):?>
							<span class="no">Request for Publish</span>
						<?php endif;?>
						<?php elseif($g->class_status==0):?>
							<span class="no">Pending</span>
						<?php else:?>
							<span class="no">BANNED!</span>
						<?php endif;?>
					</td>
					<td><?php if($g->active==1):?>
							<span class="ok">Published</span>
							<sub>
								<a href="<?php echo base_url();
							?>admin/teacher_driven/force_unpublish_class/<?php
							echo $g->id;?>"
							onclick="return confirm('You are about to force unpublish this class\nwithout the vendor ' +
							 'knowledge!\n Are you sure?');"
									>[Force&nbsp;Unpublish]</a>
							</sub>
						<?php else:?>
							<span class="no">Draft</span><br />
							<sub>
								<a href="<?php echo base_url();
							?>admin/teacher_driven/force_publish_class/<?php
							echo $g->id;?>"
							onclick="return confirm('You are about to force publish this class\nwithout the vendor ' +
							 'knowledge!\n Are you sure?');"
									>[Force&nbsp;Publish]</a>
							</sub>
						<?php endif;?>
					</td>
					<td class="center">
						<a class="ico fancybox" data-sub="class" href="#detail_class" data-id="<?php echo $g->id;
						?>">Detail</a> 
<?php 
if($g->class_status==1):
?>
						<span class="ok">
							<a class="ico edit" href="<?php echo base_url();
							?>admin/teacher_driven/deactivate_class/<?php
							echo $g->id;?>"
							onclick="return confirm('WARNING!\nThis action CANNOT BE UNDO!\nAre you sure?');"
								>BAN!!</a>
						</span>
<?php 
	if($g->active==1):
?>
						<span class="ok">
							<a class="ico edit" href="<?php echo base_url();
							?>admin/teacher_driven/do_class_sold_out/<?php echo $g->id;?>">sold out!</a>
						</span>
<?php 
	endif;
elseif($g->class_status==4):
	if($g->active==1):
?>
						<span class="ok">
							<a class="ico edit" href="<?php echo base_url();
							?>admin/teacher_driven/approve_unpublish_class/<?php echo $g->id;?>">accept</a>
						</span>
						<span class="no">
							<a class="ico delete" href="<?php echo base_url();
							?>admin/teacher_driven/reject_unpublish_class/<?php echo $g->id;?>">reject</a>
						</span>
<?php 
	elseif($g->active==0):
?>
						<span class="ok">
							<a class="ico edit" href="<?php echo base_url();
							?>admin/teacher_driven/approve_publish_class/<?php echo $g->id;?>">accept</a>
						</span>
						<span class="no">
							<a class="ico delete" href="<?php echo base_url();
							?>admin/teacher_driven/reject_publish_class/<?php echo $g->id;?>">reject</a>
						</span>
<?php 
	endif;
elseif($g->class_status==0):?>
						<span class="ok">
							<a class="ico edit" href="<?php echo base_url();
							?>admin/teacher_driven/do_class_confirm/<?php echo $g->id;?>">accept</a>
						</span>
						<span class="no">
							<a class="ico delete" href="<?php echo base_url();
							?>admin/teacher_driven/reject_class_confirm/<?php echo $g->id;?>"
							   onclick="return confirm('WARNING!\nThis action CANNOT BE UNDO!\nAre you sure?');"
									>BAN!!</a>
						</span>
<?php 
else:
?>
						<span class="no">
							BANNED!
						</span>
<?php 
endif;
?>
					</td>
				</tr>
<?php endforeach;?>
		</table>
		<!-- Pagging -->
		<div class="pagination" style="height:20px; padding:8px 10px; line-height:19px; color:#949494;">
			<div class="left">
				<div>
					Showing <span id="data-start"></span>-<span id="data-end"></span> of <span 
						id="total-count"></span>
				</div>
			</div>
			<div class="right">
				<button disabled="disabled" id="data-previous">Previous</button>
				<button disabled="disabled" id="data-next">Next</button>
			</div>
		</div>
		<!-- End Pagging -->

	</div>
	<!-- Table -->

</div>
<!-- End Box -->
<div id="detail_vendor" class="col-md-12" 
	 style="width:700px;display: none;height:100%;overflow-x:hidden;">
	<h2>Vendor Detail!</h2>
	<hr />
	<div id="detail_fill"></div>
</div>
<div id="detail_class" class="col-md-12" 
	 style="width:700px;display: none;height:100%;overflow-x:hidden;">
	<h2>Class Detail!</h2>
	<hr />
	<div id="detail_fill"></div>
</div>
<script type="application/javascript">
	var page=1;
	var total_page=<?php echo ceil($i/20);?>;
	var total_count=<?php echo $i;?>;
	var data_start=1;
	var data_end=<?php echo $i>20?'20':$i;?>;
	$(document).ready(function(){
		if(total_page > 1) $('#data-next').removeAttr('disabled');
		$('#data-next').click(function(e){
			e.preventDefault();
			page++;
			if(page==total_page) $('#data-next').attr({'disabled':'disabled'});
			$('#data-previous').removeAttr('disabled');
			data_start += 20;
			data_end = total_count > data_end+20?data_end+20:total_count;
			paging_write();
		});
		$('#data-previous').click(function(e){
			e.preventDefault();
			page--;
			if(page==1) $('#data-previous').attr({'disabled':'disabled'});
			$('#data-next').removeAttr('disabled');
			var data_range = data_end - data_start +1;
			data_start = data_start-20 < 1?1:(data_start-20);
			data_end -= data_range;
			paging_write();
		});
		function paging_write() {
			$('#data-start').text(data_start);
			$('#data-end').text(data_end);
			$('#total-count').text(total_count);
			$('tr.data-row').hide();
			$('tr[data-page="'+page+'"]').show();
		}
		paging_write();
		var cl1 = 0;
		$('.fancybox')
				.fancybox()
				.click(function(){
					var section = $(this).data('sub');
					var _id = $(this).data('id');
					$.get(
							base_url+'admin/teacher_driven/get_'+section+'_detail/'+_id, 
							function(dt){
								if(dt.status == 'OK') {
									var fill = '';
									$.each(dt.data,function(idx, data){
										fill += '<strong>'+idx+'</strong>'+
												' : '+ (idx=='class_image'||idx=='vendor_logo'?
												'<img src="'+data+'" style="width: 100%;" />'
												:data)
												+ '<br />\n';
									});
									$('#detail_'+section+' #detail_fill').html(fill);
								}
							}
					);
				})
		;
		
	});
</script>