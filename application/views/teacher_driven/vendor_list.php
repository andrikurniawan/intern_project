<?php
/**
 * Created by :
 *
 * User: AndrewMalachel
 * Date: 2/5/15
 * Time: 10:57 AM
 * Proj: prod-new
 */

if ($this->session->flashdata('f_vendor')): ?>
	<div class="msg msg-ok boxwidth">
		<p><strong><?php echo $this->session->flashdata('f_vendor'); ?></strong></p>
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
		<h2 class="left">
			Vendor Management
			<small>
				<a style="color: #ccc;" href="http://ruangguru.com/admin/donlot/vendor_csv" target="_blank">
					Download List
				</a>
			</small>
		</h2>
		<div class="right">
			<form action="<?php echo base_url();?>admin/teacher_driven/vendor_search" method="get">
				<label>search vendor by name</label>
				<input type="text" class="field small-field" name="vendor_name" placeholder="search all words" />
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
				<th>Name (email)</th>
				<th>Phone</th>
				<th>Address</th>
				<th>Contact person (phone)</th>
				<th>Class room address</th>
				<th>Institute?</th>
				<th>Active</th>
				<th class="center">Action</th>
			</tr>
<?php $i=0;?>
<?php foreach($vendor->result() as $g):?>
				<tr class="data-row<?php echo (($i++%2)!=0)?' odd':''?>" data-page="<?php echo ceil
				($i/20); 
				?>">
					<td class="column_id">
						<?php echo $g->id;?>
					</td>
					<td>
						<?php echo $g->name; ?> (<?php echo $g->email;?>)
					</td>
					<td>
						<?php echo preg_replace('/\s/', '&nbsp;', $g->main_phone); ?>
					</td>
					<td><?php echo $g->address;?></td>
					<td>
						<a href="mailto:<?php echo $g->contact_person_email?>"><?php echo $g->contact_person_name?></a>
<?php if(!empty($g->contact_person_phone)):?>
						(<?php echo $g->contact_person_phone;?>)
<?php endif;?>
					</td>
					<td><?php echo $g->class_room_address;?></td>
					<td><?php if($g->is_institute==0){ echo "Tidak";} else { echo "Ya";} ?></td>
					<td><?php if($g->status==1):?>
							<span class="ok">Activated</span>
						<?php else:?>
							<span class="no">Not Activated</span>
						<?php endif;?>
					</td>
					<td class="center">
						<a class="ico fancybox" href="#detail_vendor" data-id="<?php echo $g->id;?>">Detail</a> 
<?php if($g->status==1):?>
						<span class="ok">
							<a class="ico edit" href="<?php echo base_url();?>admin/teacher_driven/deactivate_vendor/<?php
					echo $g->id;?>/0">deactivate</a>
						</span>
<?php elseif($g->status==0):?>
						<span class="ok">
							<a class="ico edit" href="<?php echo base_url();
							?>admin/teacher_driven/do_vendor_confirm/<?php echo $g->id;?>">accept</a>
						</span>
						<span class="no">
							<a class="ico delete" href="<?php echo base_url();
							?>admin/teacher_driven/reject_vendor_confirm/<?php echo $g->id;?>">reject</a>
						</span>
<?php else:?>
						<span class="no">
							REJECTED
						</span>
<?php endif;?>
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
	<h3>Vendor Detail!</h3>
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
					var v_id = $(this).data('id');
					$.get(
							base_url+'admin/teacher_driven/get_vendor_detail/'+v_id, 
							function(dt){
								if(dt.status == 'OK') {
									var fill = '';
									$.each(dt.data,function(idx, data){
										fill += '<strong>'+idx+'</strong>'+
												' : '+ (idx=='vendor_logo'?
												'<img src="'+data+'" style="width: 100%;" />'
												:data)
												+ '<br />\n';
									});
									$('#detail_fill').html(fill);
								}
							}
					);
				})
		;
		
	});
</script>