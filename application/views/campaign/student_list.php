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
<link rel="stylesheet" type="text/css" href="<?php echo base_url();?>assets/css/font-awesome.css" media="screen" />
<script type="application/javascript" src="<?php echo base_url();?>js/jquery.fancybox-media.js?v=1.0.6"></script>
<script type="application/javascript">
	var base_url = "<?php echo base_url()?>";
</script>
<div class="box">
	<!-- Box Head -->
	<div class="box-head">
		<h2 class="left">Campaign Management - Student List</h2>
		<div class="right">
			<form action="<?php echo base_url();?>admin/campaign/search_campaign" method="get">
				<label>search campaign by code</label>
				<input type="text" 
					   class="field small-field" 
					   name="campaign_code" 
<?php
	if(!empty($code)):
?>
					   value="<?php echo $code;?>" 
<?php
	endif;
?>
					   placeholder="search code" />
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
				<th>Name</th>
				<th>Email</th>
				<th>Register</th>
				<th>Action</th>
			</tr>
<?php $i=0;?>
<?php 
foreach($students as $student): 
?>
			<tr class="data-row<?php echo (($i++%2)!=0)?' odd':''?>" 
				data-page="<?php echo ceil($i/20); ?>">
				<td><?php echo $student->murid_id;?></td>
				<td><?php echo $student->murid_nama;?></td>
				<td><?php echo $student->murid_email;?></td>
				<td><?php echo $student->murid_daftar;?></td>
				<td>
					[none]
				</td>
			</tr>
<?php 
endforeach;
?>
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
<div id="detail_vendor" class="col-md-4" 
	 style="max-width:500px;display: none;height:100%;overflow-x:hidden;">
	<h2>Vendor Detail!</h2>
	<hr />
	<div id="detail_fill"></div>
</div>
<div id="detail_class" class="col-md-4" 
	 style="min-width:600px;min-height:400px;max-height:400px;display: none;height:100%;overflow-x:hidden;">
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