<?php
/**
 * Created by :
 * 
 * User: AndrewMalachel
 * Date: 2/6/15
 * Time: 11:17 AM
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
	<div class="table">
		<table width="100%" border="0" cellspacing="0" cellpadding="0">
			<thead>
			<tr>
				<th>Class ID</th>
				<th>Min<br />Attd.</th>
				<th>Max<br />Attd.</th>
				<th>Register</th>
				<th>Paid</th>
				<th>Status</th>
				<th class="center">Action</th>
				<th class="center">Feedback</th>
			</tr>
			</thead>
			<tbody>
<?php $i=0;?>
<?php
$attd_reg = array();
	foreach($class as $c):
		$paid_qty = $c->attendance_paid->num_rows();
		$reg_qty = $c->attendance_register->num_rows();
		if($paid_qty < $c->class_peserta_min)
			$stat = 'Insufficient Attendance';
		elseif($paid_qty == $c->class_peserta_max)
			$stat = 'Maximum Class Capacity';
		else $stat = 'Registration Open';
		$attd_reg[$c->id] = $c->attendance_register->result();
		$attd_paid[$c->id] = $c->attendance_paid->result();
		
		if($c->registration_days['max_date'] == '1970-01-01' && $c->registration_days['days_left'] == -9999) {
			$stat .= ' (Not Available)';
		}else{
			if($c->registration_days['days_left'] <= 0) {
				$stat = 'Registration CLOSED';
			}
			$stat .= ' ('.$c->registration_days['max_date'].')';
		}
		$stat = str_replace(' ', '&nbsp;', $stat);
		if(strlen($c->class_uri) > 30) {
			$part1 = substr($c->class_uri, 0, 12);
			$part2 = substr($c->class_uri, -12);
			$uri = $part1.'...'.$part2;
		} else {
			$uri = $c->class_uri;
		}
?>
				<tr title="<?php echo $c->class_nama?>">
					<td>
						<span title="<?php echo $c->class_nama?>">
							<a class="fancybox class" 
							   data-attd_type="class" 
							   data-class_id="<?php echo $c->id; ?>"
							   href="#class_detail">
								<?php echo $c->id?>
							</a>
							(<?php echo $uri?>)
						</span>
					</td>
					<td><?php echo $c->class_peserta_min;?></td>
					<td><?php echo $c->class_peserta_max;?></td>
					<td><a class="fancybox attendance" data-attd_type="reg" data-class_id="<?php echo $c->id; ?>" 
						   href="#detail_attendance"><?php echo $c->attendance_register->num_rows();?></a></td>
					<td><a class="fancybox attendance" data-attd_type="paid" data-class_id="<?php echo $c->id; ?>" 
						   href="#detail_attendance"><?php echo $c->attendance_paid->num_rows();?></a></td>
					<td><?php echo $stat;?></td>
					<td>
						<a href="http://ruangguru.com/admin/donlot/attendance_paid/<?php echo $c->id;?>" >
							Download!
						</a>
					</td>
					<td>
						| <a href="<?php echo base_url()?>admin/feedback/class_attendance/<?php echo $c->id;?>" >p@k.rg</a> 
						| <a href="<?php echo base_url()?>admin/feedback/class_vendor/<?php echo $c->id;?>" >v@k.rg</a> 
						|
					</td>
				</tr>
<?php
	endforeach;
?>
			</tbody>
		</table>
	</div>
</div>

<div id="detail_attendance" class="col-md-12" 
	 style="max-width:500px;display: none;height:100%;overflow-x:hidden;">
	<h2>Details!</h2>
	<hr />
	<div id="detail_fill"></div>
</div>
<div id="class_detail" style="width: 500px; min-height: 600px; display: none;" >
	<h3>Detail kelas:</h3>
	<table>
		<thead>
		<tr>
			<th>Name</th>
			<th>Description</th>
		</tr>
		</thead>
		<tbody>
		</tbody>
	</table>
</div>
<script type="application/javascript">
	var attd = [];
	attd['paid'] = <?php echo json_encode($attd_paid);?>;
	attd['reg'] = <?php echo json_encode($attd_reg);?>;
	$(document).ready(function(){
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
