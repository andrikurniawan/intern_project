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
<link rel="stylesheet" href="//code.jquery.com/ui/1.11.4/themes/smoothness/jquery-ui.css">
<script src="//code.jquery.com/jquery-1.10.2.js"></script>
<script src="//code.jquery.com/ui/1.11.4/jquery-ui.js"></script>

<script type="application/javascript" src="<?php echo base_url();?>js/jquery.fancybox.js"></script>
<link rel="stylesheet" type="text/css" href="<?php echo base_url();?>css/jquery.fancybox.css" media="screen" />
<script type="application/javascript" src="<?php echo base_url();?>js/jquery.fancybox-media.js?v=1.0.6"></script>
<script type="application/javascript">
	var base_url = "<?php echo base_url()?>";
</script>
<script type="application/javascript" src="<?php echo base_url();?>assets/js/utility.js"></script>
<div class="box">
	<!-- Box Head -->
	<div class="box-head">
		<h2 class="left">Feedback Management - Question</h2>
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
				<th>Title</th>
				<th>Question</th>
				<th>Type</th>
				<th>Action</th>
			</tr>
			</thead>
			<tbody id="sortme">
<?php $i=0;?>
<?php foreach($questions as $question):
	
?>
			<tr class="data-row<?php echo (($i++%2)!=0)?' odd':''?>" 
				data-page="<?php echo ceil($i/20); ?>"
				id="sort[]_<?php echo $question->id; ?>">
				<td>
					<span><?php echo $question->title;?></span>
				</td>
				<td>
					<span><?php echo $question->question;?></span>
				</td>
				<td><?php echo $question->type?></td>
				<td>
					<span class="ok">
						<a class="ico edit fancybox" 
						   href="#edit_question"
						   data-id="<?php echo $question->id?>"
						   data-title="<?php echo $question->title;?>"
						   data-question="<?php echo $question->question;?>"
						   data-type="<?php echo $question->type;?>">
							edit
						</a><br />
						<a class="ico delete"
						   onclick="return checkers(this);"
						   data-id="<?php echo $question->id?>">
							delete
						</a>
					</span>
				</td>
			</tr>
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
				<a href="#edit_question" class="fancybox add_new" >[ Add new Question ]</a>
				<span>&nbsp;&nbsp;&nbsp;&nbsp;</span>
				<button disabled="disabled" id="data-previous">Previous</button>
				<button disabled="disabled" id="data-next">Next</button>
			</div>
		</div>
		<!-- End Pagging -->

	</div>
	<!-- Table -->

</div>
<!-- End Box -->
<div id="edit_question" class="col-md-4" 
	 style="min-width:500px;display: none;height:500px;overflow-x:hidden;">
	<h2>Question Editor</h2>
	<hr />
	<div id="detail_fill">
		<form id="q_editor" action="<?php echo base_url()?>admin/feedback/submit_question">
			<input type="hidden" name="id" id="qid" value="" />
			<input type="hidden" name="to" value="<?php echo $to;?>" />
			<input type="hidden" name="from" value="<?php echo $from;?>" />
			<table>
				<tr>
					<td>Type</td>
					<td style="width: 50%">
						<select name="type" id="qtype" style="width: 50%">
							<option value="text" id="qtype_text">Text</option>
							<option value="rate" id="qtype_rate">Rate</option>
							<option value="both" id="qtype_both" selected="selected">Both</option>
						</select>
					</td>
				</tr>
				<tr>
					<td>Title</td>
					<td style="width: 80%"><input type="text" name="title" style="width: 100%" id="qtitle" /></td>
				</tr>
				<tr>
					<td>Question</td>
					<td style="width: 100%"><textarea name="question" style="width: 100%" id="qquestion" rows="7" ></textarea></td>
				</tr>
			</table>
			<button type="submit">Submit</button>
			<button type="button" id="btnClose">Cancel</button>
		</form>
	</div>
</div>
<script type="application/javascript">
	var page=1;
	var total_page=<?php echo ceil($i/20);?>;
	var total_count=<?php echo $i;?>;
	var data_start=1;
	var data_end=<?php echo $i>20?'20':$i;?>;

	function checkers(elm) {
		var $elm = $(elm);
		var test_seg = hashGenerator(8);
		var test = prompt('Confirm by entering this code:\n'+test_seg);
		if(test.toUpperCase()==test_seg.toUpperCase()){
			elm.href = base_url+'admin/feedback/delete_question/'+$elm.data('id');
			return true;
		} else {
			alert('FAILED!');
			return false;
		}
	}
	
	$(document).ready(function(){

		$('#sortme').sortable({
			'update': function(e, ui) {
				var sort_data = $(this).sortable('serialize', {key: 'sort[]'});
				console.log(sort_data);
				window.setTimeout("window.location" +
						".href=base_url+" +
						"'admin/feedback/question_reorder" +
						"?<?php echo "from={$from}&to={$to}";?>&"+sort_data+"'",5);
			}
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
//*
		$('#btnClose').click(function(e){
			e.preventDefault()
			$.fancybox.close();
			return false;
		});
// */
		$('.fancybox')
				.fancybox()
//*
				.click(function(e) {
					if($(this).hasClass('add_new')) {
						$('#qid').val('');
						$('#qtitle').val('');
						$('#qquestion').val('');
						$('#qtype option').removeAttr('selected');
						$('#qtype').val('both');
					} else if($(this).hasClass('edit')) {
						console.log($(this).data('type'));
						$('#qid').val($(this).data('id'));
						$('#qtitle').val($(this).data('title'));
						$('#qquestion').val($(this).data('question'));
						$('#qtype option').removeAttr('selected');
						$('#qtype').val($(this).data('type'));
//						$('#qtype_'+$(this).data('type')).attr({'selected':null});
					}
				});
// */
	});
</script>