<?php
/**
 * Created by :
 * 
 * User: AndrewMalachel
 * Date: 4/17/15
 * Time: 1:35 PM
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
<!-- Question Box -->
<div class="box">
	<!-- Box Head -->
	<div class="box-head">
		<h2 class="left">Feedback Blaster Questions</h2>
	</div>
	<!-- End Box Head -->
	<div class="table">
		<table width="100%" border="0" cellspacing="0" cellpadding="0">
			<thead>
			<tr>
				<th>No</th>
				<th>Question Title</th>
				<th>The Question</th>
				<th>Type</th>
			</tr>
			</thead>
			<tbody>
<?php
	$no_q = 0;
	foreach($questions as $question):
		
?>
				<tr>
					<td><?php echo ++$no_q;?></td>
					<td><?php echo $question->title;?></td>
					<td><?php echo $question->question;?></td>
					<td><?php echo $question->type;?></td>
				</tr>
<?php
	endforeach;
?>
			</tbody>
		</table>
	</div>
</div>

<div class="box">
	<!-- Box Head -->
	<div class="box-head">
		<h2 class="left">Feedback Reciever</h2>
	</div>
	<!-- End Box Head -->
	<div class="table">
		<form method="post" action="<?php echo base_url()?>admin/feedback/blast">
		<input type="hidden" name="to_type" value="<?php echo $to_type;?>">
		<input type="hidden" name="to_id" value="<?php echo $to_id;?>">
		<input type="hidden" name="from_type" value="<?php echo $from_type;?>">
		<table width="100%" border="0" cellspacing="0" cellpadding="0">
			<thead>
			<tr>
				<th rowspan="2">Send<br /><input type="checkbox" id="selectall" title="Select All" /> </th>
				<th colspan="3">Participant</th>
				<th colspan="3">Sponsor</th>
				<th rowspan="2">Code</th>
			</tr>
			<tr>
				<th>ID</th>
				<th>Name</th>
				<th>Email</th>
				<th>ID</th>
				<th>Name</th>
				<th>Email</th>
			</tr>
			</thead>
			<tbody>
<?php $i=0; ?>
<?php
	$no_q = 0;
	foreach($participants as $participant):
		$code = !empty($responses[$participant->peserta_id])?$responses[$participant->peserta_id]:NULL;
?>
				<tr class="data-row<?php echo (($i++%2)!=0)?' odd':''?>" data-page="<?php echo ceil
				($i/20); 
				?>">
					<td><input type="checkbox" 
							   name="from_id[]"
							   value="<?php echo $participant->peserta_id;?>"
							   <?php echo empty($code)?'':'disabled="disabled" checked="checked"';?>></td>
					<td><?php echo $participant->peserta_id;?></td>
					<td><?php echo $participant->nama_peserta;?></td>
					<td><?php echo $participant->email_peserta;?></td>
					<td><?php echo $participant->pemesan_id;?></td>
					<td><?php echo $participant->nama_pemesan;?></td>
					<td><?php echo $participant->email_pemesan;?></td>
					<td><?php echo $code;?></td>
				</tr>
<?php
	endforeach;
?>
			</tbody>
			<tfoot>
			<tr>
				<td colspan="4" style="text-align: center">
					<button type="reset">Reset</button>
				</td>
				<td colspan="4" style="text-align: center">
					<button type="submit">Submit</button>
				</td>
			</tr>
			</tfoot>
		</table>
		</form>
	</div>
</div>

<script type="application/javascript">
	$(document).ready(function(){
		$('#selectall').click(function(e){
			if($(this).is(':checked')) {
				$('input[type="checkbox"]').attr({'checked':'checked'});
			} else {
				$('input[type="checkbox"][disabled!="disabled"]').removeAttr('checked');
			}
		});
		$('.fancybox.class').fancybox()
				.click(function(e){
					var c_id = $(this).data('class_id');
					e.preventDefault();
					$.get(
							base_url+'admin/teacher_driven/get_class_detail/'+c_id, 
							function(dt){
								if(dt.status == 'OK') {
									var fill = '';
									$.each(dt.data,function(idx, data){
										fill += '<tr><td style="font-weight: bolder;">'+idx+'</td>'+
												'<td>'+ (idx=='class_image'||idx=='vendor_logo'?
												'<img src="http://kelas.ruangguru.com/images/class/'+c_id+'/'+data+'"' +
														' style="width: 100%;" />'
												:data)
												+ '</td></tr>\n';
									});
									$('#class_detail table tbody').html(fill);
								}
							}
					);
				});
		$('.fancybox.attendance').fancybox()
				.click(function(e){
					e.preventDefault();
					var dt_type = $(this).data('attd_type');
					var c_id = $(this).data('class_id');
					var data = attd[dt_type][c_id];
					var print_out = '';
					if(data.length > 0){
						$.each(data, function(idx, dt){
							var fill = '';
							$.each(dt, function(idx2, dt2){
								fill += '<strong>'+idx2+'</strong>'+dt2+'<br />\n'
							});
							print_out += '<h2>'+idx+'</h2>'+fill+'<hr />\n';
						});
					} else {
						print_out = 'No data here!';
					}
					$('#detail_fill').html(print_out);
				})
	});
</script> 
