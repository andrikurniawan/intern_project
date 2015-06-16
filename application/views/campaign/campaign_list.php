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
<link rel="stylesheet" type="text/css" href="<?php echo base_url();?>css_rg/ui-lightness/jquery-ui-1.10.3.custom.min.css" media="screen" />
<script type="application/javascript" src="<?php echo base_url();?>js/jquery-ui-1.10.3.custom.min.js"></script>
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
		<h2 class="left">
			Campaign Management
			<small>
				<a class="fancybox" href="#add_new_campaign">Create new campaign</a>
			</small>
		</h2>
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
				<th>Code</th>
				<th>Due</th>
				<th>Max</th>
				<th>Value</th>
				<th>Usage</th>
				<th>Status</th>
				<th>Action</th>
			</tr>
<?php $i=0;?>
<?php 
foreach($campaigns as $campaign): 
	$status = '';
	if($campaign->due_start == "1970-01-01 00:00:00") {
		$due_start = "Date 0";
	} else {
		$due_start = $campaign->due_start;
		if(strtotime($campaign->due_start) > time()) {
			$status = 'Not yet!';
		}
	}
	if($campaign->due_end == "2200-12-31 23:59:59") {
		$due_end = "Eternity";
	} else {
		$due_end = $campaign->due_end;
		if(strtotime($campaign->due_end) < time()) {
			$status = 'Expired!';
		}
	}
	if(!empty($status)) $status .= ' - ';
	$status .= $campaign->active == 1?'Active':'Dead';
	$student_list_link = base_url()."admin/campaign/student_list/{$campaign->code}";
?>
			<tr class="data-row<?php echo (($i++%2)!=0)?' odd':''?>" 
				data-page="<?php echo ceil($i/20); ?>">
				<td>
					<a href="<?php echo $student_list_link;?>" target="_blank"><?php echo $campaign->code;?></a>
				</td>
				<td><?php echo "{$campaign->due_start} - {$campaign->due_end}"?></td>
				<td><?php echo "{$campaign->expected_qty}"?></td>
				<td><?php echo "{$campaign->value} - {$campaign->value_unit}";?></td>
				<td><?php echo $campaign->usage;?></td>
				<td><?php echo $status;?></td>
				<td>
<?php if($campaign->active == 1):?>
					<a href="<?php echo base_url("admin/campaign/deactivate_campaign/{$campaign->code}")?>">Deactivate</a><br />
<?php else: ?>
					<a href="<?php echo base_url("admin/campaign/reactivate_campaign/{$campaign->code}")?>">Reactivate</a><br />
<?php endif; ?>
					<a href="#detail" onclick="alert('Belum bisa!')">Details</a>
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
<div id="add_new_campaign" class="col-md-12" 
	 style="width: 600px;max-width:700px;display: none;height:100%;overflow-x:hidden;">
	<h2>Add new campaign</h2>
	<hr />
	<div id="detail_fill">
		<form action="<?php echo base_url()?>admin/campaign/submit_campaign" 
			  method="post" 
			  enctype="application/x-www-form-urlencoded">
			<table border="0">
				<tr>
					<th style="padding-right: 20px;">Campaign name <span style="color: red">*</span> </th>
					<td><input style="width: 100%;" type="text" name="code" required="required" /></td>
				</tr>
				<tr>
					<th style="padding-right: 20px;">Start from</th>
					<td><input style="width: 100%;" type="text" class="setDatepicker" name="due_start" /></td>
				</tr>
				<tr>
					<th style="padding-right: 20px;">Expire</th>
					<td><input style="width: 100%;" type="text" class="setDatepicker" name="due_end" /></td>
				</tr>
				<tr>
					<th style="padding-right: 20px;">Usage</th>
					<td><input style="width: 100%;" type="number" name="expected_qty" /></td>
				</tr>
				<tr>
					<th style="padding-right: 20px;">Value</th>
					<td>
						<input style="width: 60%;" type="number" name="value" />
						<select style="width: 30%;" name="value_unit" >
							<option value="idr">IDR</option><option value="percent">%</option>
						</select>
					</td>
				</tr>
				<tfoot>
				<tr>
					<td colspan="2" style="text-align: right;"><button type="submit">Submit</button></td>
				</tr>
				</tfoot>
			</table>
		</form>
	</div>
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
		
		$('.setDatepicker').datepicker({
			'dateFormat'	: 'yy-mm-dd'
		});
		
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
		$('.fancybox').fancybox();
		
	});
</script>