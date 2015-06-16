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
				<input type="text" class="field small-field" name="class_name" placeholder="search all words" />
				<input type="submit" class="button" value="search" />
			</form>
		</div>
	</div>
	<div class="table">
		<table width="100%" border="0" cellspacing="0" cellpadding="0">
			<thead>
			<tr>
				<th>Code</th>
				<th>Bank Pengirim</th>
				<th>Bank Penerima</th>
				<th>Tanggal Transfer</th>
				<th>Bukti Transfer</th>
				<th>Tagihan</th>
				<th class="center">Action</th>
			</tr>
			</thead>
			<tbody>
<?php 
	$i = 0;
	$inv = array();
	foreach($invoice as $bill):
		$inv[$bill->code] = $bill;
		$path1 = substr($bill->code, 0,1);
		$path2 = substr($bill->code, 1,1);
		$path = strtolower("images/payment/transfer/{$path1}/{$path2}/{$bill->code}/");
		$img_link = 'http://kelas.ruangguru.com/'.$path.$bill->status_3_upload_file;
?>
			<tr class="data-row<?php echo (($i++%2)!=0)?' odd':''?>" 
				data-page="<?php echo ceil($i/20); ?>">
				<td><?php echo $bill->code ?></td>
				<td>
						<?php echo $bill->bank_from ?>
				</td>
				<td>
						<?php echo $bill->bank_to ?>
				</td>
				<td><?php echo $bill->status_3 ?></td>
				<td>
					<a href="<?php echo $img_link;?>" target="_blank">
						<?php echo $bill->status_3_upload_file; ?>
					</a>
				</td>
				<td>Rp <?php echo number_format($bill->total, 0, ',','.'); ?>,-</td>
				<td>
<?php /*
					<span class="no">
						<a class="ico delete" href="<?php echo base_url();
						?>admin/teacher_driven/cancel_invoice/<?php echo $bill->code;?>"
						   onclick="return confirm('WARNING!\nThis action CANNOT BE UNDO!\nAre you sure?');"
								>reject</a>
					</span>
// */ ?>
					<span class="ok">
						<a class="ico delete" href="#checkers"
						   data-code="<?php echo $bill->code;?>"
						   onclick="return checkers(this);"
								>confirm</a>
					</span>
					<span class="ok">
						<a class="ico delete" 
						   onclick="return confirm('Are you sure you want to delete pament confirmation for:\n<?php echo $bill->code;?>')"
						   href="<?php echo base_url()?>admin/teacher_driven/reject_payment_confirm/<?php echo $bill->code;?>">
							reject</a>
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
	
	var hashSeed = "23456789ABCDEFGHJKLMNPQRSTUVWXY";
	var hashGenerator = function(length) {
		if( ! length) length = 8;
		var i=0;
		var hash='';
		while(i++ < length) {
			var pos = Math.floor((Math.random()*hashSeed.length));
			hash += hashSeed.charAt(pos);
		}
		return hash;
	};
	
	var test_seg = hashGenerator(8);
	
	function checkers(elm) {
		$elm = $(elm);
		var test_seg = hashGenerator(8);
		var test = prompt('Confirm by entering this code:\n'+test_seg);
		if(test.toUpperCase()==test_seg.toUpperCase()){
			elm.href = base_url+'admin/teacher_driven/do_payment_confirm/'+$elm.data('code');
			return true;
		} else {
			alert('FAILED!');
			return false;
		}
	}
	
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
			data_end = total_count > data_end+20?total_count:(data_end+20);
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