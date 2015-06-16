<?php
/**
 * Created by :
 * 
 * User: AndrewMalachel
 * Date: 4/13/15
 * Time: 5:21 PM
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
<link rel="stylesheet" href="//code.jquery.com/ui/1.11.4/themes/smoothness/jquery-ui.css">
<script src="//code.jquery.com/jquery-1.10.2.js"></script>
<script src="//code.jquery.com/ui/1.11.4/jquery-ui.js"></script>
<script type="application/javascript">
	var base_url = "<?php echo base_url()?>";
</script>
<div class="box">
	<!-- Box Head -->
	<div class="box-head">
		<h2 class="left">Hacking : Sertifikasi</h2>
		<div class="right">
			<form action="<?php echo base_url();?>admin/hacked/sertifikat" method="get">
				<label>search sertifikat by guru id</label>
				<input type="text" class="field small-field" name="key" placeholder="guru id" />
				<input type="submit" class="button" value="search" />
			</form>
		</div>
	</div>
	<!-- End Box Head -->

	<!-- Table -->
	<div class="table">
		<table width="100%" border="0" cellspacing="0" cellpadding="0">
			<thead>
			<tr>
				<th>ID Guru</th>
				<th>ID File</th>
				<th>File</th>
				<th>Kualifikasi</th>
				<th>Action</th>
			</tr>
			</thead>
			<tbody>
<?php $i=0;?>
<?php 
$check_id = array();
foreach($data as $id => $user):
	if(!is_numeric($id)) {
		echo $id;continue;
	}
	$id=(int)$id;
	if(empty($check_id[$id])) {
		$check_id[$id] = array();
	}
	foreach($user as $file => $kualifikasi):
		$kualifikasi_id = $kualifikasi['id'];
		while(in_array($kualifikasi_id,$check_id[$id])) {
			$kualifikasi_id++;
		}
		$check_id[$id][] = $kualifikasi_id;
		if(empty($kualifikasi['id'])) $kualifikasi['id'] = '';
?>
			<tr class="data-row<?php echo (($i++%2)!=0)?' odd':''?>" 
				data-page="<?php echo ceil($i/20); ?>"
				>
				<form id="form_<?php echo "{$id}_{$kualifikasi_id}";?>">
				<input type="hidden" name="file" value="<?php echo rawurlencode($file);?>" />
				<input type="hidden" name="guru_id" value="<?php echo $id;?>" />
				<input type="hidden" name="kualifikasi_id" value="<?php echo $kualifikasi_id;?>" />
				<input type="hidden" name="form_id" value="<?php echo "{$id}_{$kualifikasi_id}";?>" />
				<td>
					<span id="guruid_<?php echo "{$id}_{$kualifikasi_id}";?>"><?php echo $id?></span>
				</td>
				<td>
					<span id="kualifikasiid_<?php echo "{$id}_{$kualifikasi_id}";?>"><?php echo $kualifikasi['id']?></span>
				</td>
				<td>
					<span id="file_<?php echo "{$id}_{$kualifikasi_id}";?>">
						<a id="filelink_<?php echo "{$id}_{$kualifikasi_id}";?>" 
						   href="http://ruangguru.com/files/sertifikat/<?php echo rawurlencode($file);?>" 
						   target="_blank">
							<?php echo strlen($file)>30?substr($file, 0,27).'...':$file;?>
						</a>
					</span>
				</td>
				<td><input type="text" 
						   style="width: 100%" 
						   id="kualifikasi_<?php echo "{$id}_{$kualifikasi_id}";?>"
						   name="kualifikasi" 
						   placeholder="Cnth: Sertifikasi Kemahiran menanam jagung"
						   value="<?php echo $kualifikasi['text']?>" />
				</td>
				<td>
<?php 
	if(!empty($kualifikasi['id']) && $kualifikasi['id'] > 0):
?>
					<span class="ok">
						<a href="#" class="update_form"
						   data-id="<?php echo "{$id}_{$kualifikasi_id}"?>">
							Update
					   </a>
					</span>
<?php 
	else:
?>
					<span class="ok">
						<a href="#" class="copy_form"
						   data-id="<?php echo "{$id}_{$kualifikasi_id}"?>">
							Copy
						</a>
					</span>
<?php endif; ?>
					<br />
				</td>
				</form>
			</tr>
<?php endforeach;?>
<?php endforeach;?>
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
	<!-- Table -->

</div>
<!-- End Box -->
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

		$('.update_form').click(function(e) {
			e.preventDefault();
			var $id = $(this).data('id');
			var $dt = $('form#form_'+$id).serialize();
			console.log($dt);
			$.get(base_url+'admin/hacked/sertifikat_update?'+$dt,function(a,b) {
				if(a.status == 'OK') {
				} else {
					console.log('error');
				}
				console.log(a);
			});
			return false;
		});

		$('.copy_form').click(function(e) {
			e.preventDefault();
			var $id = $(this).data('id');
			var $dt = $('form#form_'+$id).serialize();
			console.log($dt);
			$.get(base_url+'admin/hacked/sertifikat_copy?'+$dt,function(a,b) {
				if(a.status == 'OK') {
					$('a#filelink_'+$id)
							.attr('href', 'http://ruangguru.com/files/sertifikat/'+ a.data.file_to)
							.text(a.data.file_to);
					$('#kualifikasi_'+$id).val(a.data.kualifikasi);
					$('#kualifikasiid_'+$id).text(a.data.kualifikasi_id);
					$('form#form_'+$id+' span.ok a.copy_form')
							.addClass('update_form')
							.removeClass('copy_form')
							.text('Update');
				} else {
					console.log('error');
				}
				console.log(a);
			});
			return false;
		});

		$('#btnClose').click(function(e){
			e.preventDefault()
			$.fancybox.close();
			return false;
		});
/*
		$('.add_new')
				.fancybox()
				.click(function(e){
					$('#qtitle').val('');
					$('#qquestion').val('');
					$('#qtype option').removeAttr('selected');
					$('#qtype_both').attr({'selected':'selected'})
					return false;
				});
/*
		$('.edit')
				.fancybox()
				.click(function(e){
					$('#qtitle').val($(this).data('title'));
					$('#qquestion').val($(this).data('question'));
					$('#qtype option').removeAttr('selected');
					$('#qtype_'+$(this).data('type')).attr({'selected':'selected'})
					return false;
				});
// */
	});
</script>