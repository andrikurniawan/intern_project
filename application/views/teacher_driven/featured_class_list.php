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
<link rel="stylesheet" href="//code.jquery.com/ui/1.11.4/themes/smoothness/jquery-ui.css">
<script src="//code.jquery.com/jquery-1.10.2.js"></script>
<script src="//code.jquery.com/ui/1.11.4/jquery-ui.js"></script>
<div class="box">
	<!-- Box Head -->
	<div class="box-head">
		<h2 class="left">Featured Class Management</h2>
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
			<thead>
			<tr>
				<th>Sort</th>
				<th>ID</th>
				<th>Name (URI)</th>
				<th class="center">Action</th>
			</tr>
			</thead>
			<tbody id="sortme">
<?php $i=0;
$class_ids = array();
?>
<?php if(count($featured) > 0):?>
<?php foreach($featured as $g):
	$class_ids[]=$g->id;
?>
			<tr class="data-row<?php echo (($i++%2)!=0)?' odd':''?>" 
				data-page="<?php echo ceil($i/20); ?>" 
				id="sort[]_<?php echo $g->id; ?>">
				<td><?php echo $i;?></td>
				<td class="column_id">
					<a href="<?php echo base_url()?>vendor/kelas/detil/<?php echo $g->id;?>" target="_blank">
						<?php echo $g->id;?>
					</a>
				</td>
				<td>
					<?php echo $g->class_nama; ?> (<?php echo $g->class_uri;?>)
				</td>
				<td>
					<a href="<?php echo base_url().'admin/teacher_driven/unset_class_featured/'.$g->id?>" >
						[Remove from featured]</a>
				</td>
			</tr>
<?php endforeach; ?>
<?php else: ?>
			<tr>
				<td colspan="4" style="text-align: center;">No Featured Class available! Add one from the list 
					below!</td>
			</tr>
<?php endif; ?>
			</tbody>
		</table>
	</div>
</div>


<div class="box">
	<div class="box-head">
		<h2 class="left">Class Available</h2>
		<div class="right">
			<form action="<?php echo base_url();?>admin/teacher_driven/class_search" method="post">
				<label>search class by name</label>
				<input type="text" class="field small-field" name="class_name" placeholder="search all words" />
				<input type="submit" class="button" value="search" />
			</form>
		</div>
	</div>
	<div class="table">
		<table width="100%" border="0" cellspacing="0" cellpadding="0">
			<tr>
				<th>ID</th>
				<th>Name (URI)</th>
				<th class="center">Action</th>
			</tr>
<?php $i=0;?>
<?php foreach($class as $g):
	if(in_array($g->id, $class_ids)) continue;
	if(count($class_ids) < 6) {
		$link = base_url().'admin/teacher_driven/set_class_featured/'.$g->id;
	} else {
		$link = '#max_capacity';
	}
?>
				<tr class="data-row<?php echo (($i++%2)!=0)?' odd':''?>" data-page="<?php echo ceil($i/20); ?>">
					<td class="column_id">
						<a href="<?php echo base_url()?>vendor/kelas/detil/<?php echo $g->id;?>" target="_blank">
							<?php echo $g->id;?>
						</a>
					</td>
					<td>
						<?php echo $g->class_nama; ?> (<?php echo $g->class_uri;?>)
					</td>
					<td class="center">
						<a href="<?php echo $link;?>" >
							[Add as Featured]</a>
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
	 style="max-width:500px;display: none;height:100%;overflow-x:hidden;">
	<h2>Vendor Detail!</h2>
	<hr />
	<div id="detail_fill"></div>
</div>
<div id="detail_class" class="col-md-12" 
	 style="max-width:500px;display: none;height:100%;overflow-x:hidden;">
	<h2>Class Detail!</h2>
	<hr />
	<div id="detail_fill"></div>
</div>
<script type="application/javascript">
	var wTO = null;
	var page=1;
	var total_page=<?php echo ceil($i/20);?>;
	var total_count=<?php echo $i;?>;
	var data_start=1;
	var data_end=<?php echo $i>20?'20':$i;?>;
	$(document).ready(function(){
		
		$('#sortme').sortable({
			'update': function(e, ui) {
				var sort_data = $(this).sortable('serialize', {key: 'sort[]'});
				console.log(sort_data);
				window.setTimeout("window.location" +
						".href=base_url+'admin/teacher_driven/featured_reorder?"+sort_data+"'",5);
			}
		});
		
		$('a[href="#max_capacity"]').click(function(e){
			e.preventDefault();
			alert('Maximum Featured Class has reached! Please remove on of the active featured class above to add ' +
					'this one...\nTengkyu!');
			return false;
		});
		
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
		var cl1 = 0;
		
	});
</script>