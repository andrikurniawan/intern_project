<?php
/**
 * Created by :
 * 
 * User: AndrewMalachel
 * Date: 2/9/15
 * Time: 7:15 AM
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
	<div class="box-head">
		<h2 class="left">Invoice List</h2>
		<div class="right">
			<form action="<?php echo base_url();?>admin/teacher_driven/invoice_search" method="post">
				<label>search invoice by code</label>
				<input type="text" class="field small-field" name="invoice_code" placeholder="search code" />
				<input type="submit" class="button" value="search" />
			</form>
		</div>
	</div>
	<div class="table">
		<table width="100%" border="0" cellspacing="0" cellpadding="0">
			<thead>
			<tr>
				<th>Code</th>
				<th>Invoice Date</th>
				<th>Pemesan ID</th>
				<th>Peserta ID</th>
				<th>Subtotal</th>
				<th>Discount</th>
				<th>Total</th>
				<th>Status</th>
				<th class="center">Action</th>
			</tr>
			</thead>
			<tbody>
<?php 
	$i = 0;
	$inv = array();
	foreach($invoice as $bill):
		$inv[$bill->code] = $bill;
		switch($bill->status){
			case	1:
				$stat = 'Cart Submitted';
				break;
			case	2:
				$stat = 'Invoice Created';
				break;
			case	3:
				$stat = 'Payment Transfered';
				break;
			case	4:
				$stat = 'Payment Confirmed';
				break;
			default	 :
				$stat = 'Unknown! Check Details!';
				break;
		}
?>
			<tr class="data-row<?php echo (($i++%2)!=0)?' odd':''?>" 
				data-page="<?php echo ceil($i/20); ?>">
				<td>
<?php 
if($bill->status >= 2 && $bill->total > 0):
	$str1 = substr($bill->code,0,1);
	$str2 = substr($bill->code,1,1);
	if(file_exists(FCPATH.'/documents/invoice/'.$str1.'/'.$str2.'/'.$bill->code.'.pdf')):
echo '<a href="'.base_url().'documents/invoice/'.$str1.'/'.$str2.'/'.$bill->code.'.pdf" target="_blank">'.$bill->code.'</a>';
	else:
		echo $bill->code ;
	endif;
else:
echo $bill->code ;
endif;
?>
				</td>
				<td><?php echo $bill->status_2; ?></td>
				<td><a href="#details" class="fancybox" data-section="pemesan" data-id="<?php echo $bill->pemesan_id ?>">
						<?php echo $bill->pemesan_id ?>
					</a>
				</td>
				<td><a href="#details" class="fancybox" data-section="student" data-id="<?php echo $bill->student_id 
					?>">
						<?php echo $bill->student_id ?>
					</a>
				</td>
				<td><?php echo $bill->subtotal ?></td>
				<td><?php echo $bill->discount ?></td>
				<td><?php echo $bill->total ?></td>
				<td>
					<a href="#details" class="fancybox" data-section="status" data-id="<?php echo $bill->code ?>">
					<?php echo $stat ?>
					</a>
				</td>
				<td>
					<span class="no">
						<a class="ico delete" href="<?php echo base_url();
						?>admin/teacher_driven/cancel_invoice/<?php echo $bill->code;?>"
<?php /*
						   onclick="return confirm('WARNING!\nThis action CANNOT BE UNDO!\nAre you sure?');"
// */ ?>
								>reject</a>
					</span>
				</td>
			</tr>
<?php 
	endforeach;
?>
			</tbody>
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
</div>
<div class="col-md-6" id="details"
	 style="max-width:500px;display: none;height:100%;overflow-x:hidden;">
	<h2>Details!</h2>
	<hr />
	<div id="detail_fill"></div>
</div>
<script type="application/javascript">
	var page=1;
	var total_page=<?php echo ceil($i/20);?>;
	var total_count=<?php echo $i;?>;
	var data_start=1;
	var data_end=<?php echo $i>20?'20':$i;?>;
	
	var _data = {
		'pemesan' : <?php echo json_encode($pemesan);?>,
		'student' : <?php echo json_encode($student);?>,
		'full'	  : <?php echo json_encode($inv);?>
	};
	
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
		$('.fancybox')
				.fancybox()
				.click(function(e){
					e.preventDefault();
					$('#detail_fill').empty();
					var section = $(this).data('section');
					var id = $(this).data('id');
					switch(section) {
						case 'pemesan'		:
						case 'student'		:
							$.each(_data[section][id], function(idx, dt){
								$('#detail_fill').append($('<strong>'+idx+'</strong>&nbsp;'+dt+'<br />\n'));
							});
							break;
						case 'status'		:
							$.each(_data['full'][id], function(idx, dt){
								$('#detail_fill').append($('<strong>'+idx+'</strong>&nbsp;'+dt+'<br />\n'));
							});
					}
				});
	});
</script>