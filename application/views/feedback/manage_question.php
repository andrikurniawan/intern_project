<?php
/**
 * Created by :
 * 
 * User: AndrewMalachel
 * Date: 4/10/15
 * Time: 10:25 AM
 * Proj: prod-new
 */
$user = array();
foreach($usertype as $usr) {
	$user[$usr->id] = (array) $usr;
}

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
		<h2 class="left">Feedback Management</h2>
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
				<th>From</th>
				<th>To</th>
				<th># Question</th>
				<th>Action</th>
			</tr>
<?php $i=0;?>
<?php foreach($questions as $question):
	
?>
			<tr class="data-row<?php echo (($i++%2)!=0)?' odd':''?>" data-page="<?php echo ceil($i/20); ?>">
				<td>
					<span title="<?php echo $user[$question->from_type]['title']?>"><?php echo 
						$user[$question->from_type]['type']?></span>
				</td>
				<td>
					<span title="<?php echo $user[$question->to_type]['title']?>"><?php echo 
						$user[$question->to_type]['type']?></span>
				</td>
				<td><?php echo $question->cnt?></td>
				<td>
					<span class="ok">
						<a class="ico edit" 
						   href="<?php echo base_url()."admin/feedback/detail_question/{$question->from_type}/{$question->to_type}"?>">
						detail</a>
					</span>
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
<div id="detail_vendor" class="col-md-4" 
	 style="max-width:500px;display: none;height:100%;overflow-x:hidden;">
	<h2>Vendor Detail!</h2>
	<hr />
	<div id="detail_fill"></div>
</div>
<div id="detail_class" class="col-md-4" 
	 style="max-width:500px;display: none;height:100%;overflow-x:hidden;">
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