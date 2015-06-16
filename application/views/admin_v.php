<!DOCTYPE html>
<html>
    <head>
        <meta http-equiv="Content-type" content="text/html; charset=utf-8" />
        <title>Ruangguru Administration</title>

        <link rel="stylesheet" href="<?php echo base_url();?>css_rg/admin.css" type="text/css" media="all" />
        <link rel="stylesheet" href="<?php echo base_url();?>css_rg/bootstrap/css/bootstrap.min.css" type="text/css" media="all" />
        <script type="text/javascript" src="<?php echo base_url(); ?>js/jquery-1.9.1.min.js"></script>
        <script type="text/javascript" src="<?php echo base_url();?>css_rg/bootstrap/js/bootstrap.min.js"></script>
        <script type="text/javascript">
            var base_url = "<?php echo base_url();?>";
        </script>
        <script>
            $.post('<?php echo base_url() ?>admin/user/get_notification/', {},
                function(data){
                    //console.log(data);
                    var notif = "";
                    var count = 0;
                    for(var i=0; i<data.length;i++){
                        notif += "<li><a href=\"<?php echo base_url()?>admin/user/read_notif/"+data[i]['id']+"\" ";
                        if(data[i]['status']==0){
                            notif += "style='background-color:rgb(0,173,255)'";
                            count++;
                        }

                        notif += ">"+data[i]['pesan']+"</a></li>";

                        if(i>5){
                            break;
                        }
                    }

                    notif += "<li><a href=\"<?php echo base_url()?>admin/user/notifications/\">Lihat Semua Notifikasi</a></li>";

                    if(count>0){
                        $("#notif-transaksi").html(count);
                        $("#notif-transaksi").css('display','inline');
                    } else {
                        $("#notif-transaksi").css('display','none');
                    }
                    $("#notif").html(notif);
                },'json');
        </script>
        <style>
            .notification{
                color:white;
                background-color: red;
                border-radius: 5px;
                padding: 7px;
                margin-left:5px;
            }

            #notif .new-notif {
                background-color: rgb(0, 173, 255);
            }

            h2 {
                margin : 0px;
            }
        </style>
    </head>
    <body>
        <!-- Header -->
        <div id="header">
            <div class="shell">
                <!-- Logo + Top Nav -->
                <div id="top">
                    <h1 style="margin-top:0px;font-size:23px;"><a href="<?php echo base_url();?>admin">Ruangguru</a></h1>
                    <div id="top-navigation">
                        Welcome <strong><?php echo $this->session->userdata('admin_username');?></strong>
                        <span>|</span>
                        <a href="#">Help</a>
                        <span>|</span>
                        <a href="<?php echo base_url();?>admin/user/profile">Profile Settings</a>
                        <span>|</span>
                        <a href="<?php echo base_url();?>4dm1nzqu/logout">Log out</a>
                    </div>
                </div>
                <!-- End Logo + Top Nav -->
                
                <!-- Main Nav -->
				<div style="position: relative; top: -15px;">
                    <ul id="nav" style="margin-top:-6px">
                        <li><a href="<?php echo base_url();?>admin/guru" <?php echo ($active==1)?'class="active"':'';?>>Guru</a>
						<ul>
							<li><a href="<?php echo base_url();?>admin/guru" <?php echo ($active==1)?'class="active"':'';?>>Data Guru</a></li>
							<li><a href="<?php echo base_url();?>admin/utilities/nik" <?php echo ($active==98)?'class="active"':'';?>>ID Terbaru</a></li>
							<li><a href="<?php echo base_url();?>admin/utilities/sertifikat" <?php echo ($active==3)?'class="active"':'';?>>Sertifikat Terbaru</a></li>
							<li><a href="<?php echo base_url();?>admin/utilities/cs_email" <?php echo ($active==99)?'class="active"':'';?>>Coming Soon</a></li>
                            <li><a href="<?php echo base_url();?>admin/utilities/panduan_guru" <?php echo ($active==99)?'class="active"':'';?>>Panduan Guru</a></li>
                            <li><a href="<?php echo base_url();?>admin/utilities/ktp_guru" <?php echo ($active==101)?'class="active"':'';?>>KTP Terbaru</a></li>
                            <li><a href="<?php echo base_url();?>admin/utilities/npwp_guru" <?php echo ($active==101)?'class="active"':'';?>>NPWP Terbaru</a></li>
                            <li><a href="<?php echo base_url();?>admin/utilities/surat_keterangan_guru" <?php echo ($active==101)?'class="active"':'';?>>Surat Keterangan Terbaru</a></li>
						</ul>
				    </li>
				    <li>
						<a href="<?php echo base_url();?>admin/murid" <?php echo ($active==4)?'class="active"':'';?>>Murid</a>
						<ul>
							<li><a href="<?php echo base_url()?>admin/murid"><span>List</span></a></li>
							<li><a href="<?php echo base_url()?>admin/campaign"><span>Campaign List</span></a></li>
							<li><a href="<?php echo base_url()?>admin/campaign/report"><span>Campaign Report</span></a></li>
						</ul>
					</li>
<?php if($this->input->get('show_duta') == 'ok'): ?>
					<li><a href="<?php echo base_url();?>admin/duta_guru" <?php echo ($active==2)?'class="active"':'';?>><span>Duta Guru</span></a></li>
<?php endif; ?>
					<li><a href="#"><span>Transaksi</span></a>
						<ul>
							<li><a href="<?php echo base_url();?>admin/request" <?php echo ($active==5)?'class="active"':'';?>>Request</a></li>
							<li><a href="<?php echo base_url();?>admin/utilities/request" <?php echo ($active==96)?'class="active"':'';?>>Request Sidebar</a></li>
							<li><a href="<?php echo base_url();?>admin/kelas" <?php echo ($active==7)?'class="active"':'';?>>Kelas</a></li>
						</ul>
					</li>
					<li><a href="<?php echo base_url();?>admin/home" <?php echo ($active==6)?'class="active"':'';?>><span>Home</span></a></li>
					<li><a href="<?php echo base_url();?>admin/utilities/subscribe" <?php echo ($active==97)?'class="active"':'';?>><span>Subscribe</span></a></li>
					<li><a href="#"><span>Tools</span></a>
						<ul>
							<li><a href="<?php echo base_url();?>admin/upload" <?php echo ($active==95)?'class="active"':'';?>>Duta Upload Data</a></li>
							<li><a href="<?php echo base_url();?>admin/upload/send_email" <?php echo ($active==95)?'class="active"':'';?>>Send Email</a></li>
							<li><a href="<?php echo base_url();?>admin/upload/edit_email" <?php echo ($active==95)?'class="active"':'';?>>Edit Template Email</a></li>
							<li><a href="<?php echo base_url();?>admin/reminder" <?php echo ($active==95)?'class="active"':'';?>>Reminder</a></li>
							<li><a href="<?php echo base_url();?>admin/event" <?php echo ($active==95)?'class="active"':'';?>>Event</a></li>
							<li><a href="<?php echo base_url();?>admin/matpel" <?php echo ($active==95)?'class="active"':'';?>>Kategori Pendidikan</a></li>
							<li><a href="<?php echo base_url();?>admin/matpel" <?php echo ($active==95)?'class="active"':'';?>>Matpel</a></li>
						</ul>
				    </li>
					<li>
						<a href="<?php echo base_url();?>admin/teacher_driven"><span>Teacher Driven</span></a>
						<ul>
							<li><a href="<?php echo base_url();?>admin/teacher_driven/vendor_confirm">Vendor Confirmation</a></li>
							<li><a href="<?php echo base_url();?>admin/teacher_driven/vendor_list">Vendor List</a></li>
							<li><a href="<?php echo base_url();?>admin/teacher_driven/class_confirm">Class Request</a></li>
							<li><a href="<?php echo base_url();?>admin/teacher_driven/class_list">Class List</a></li>
							<li><a href="<?php echo base_url();?>admin/teacher_driven/class_featured">Class Featured</a></li>
							<li><a href="<?php echo base_url();?>admin/teacher_driven/class_mail">Class Email Blast</a></li>
							<li><a href="<?php echo base_url();?>admin/teacher_driven/class_discount">Class Discount</a></li>
							<li><a href="<?php echo base_url();?>admin/teacher_driven/class_attendance">Class Attendance</a></li>
							<li><a href="<?php echo base_url();?>admin/teacher_driven/payment_invoice">Invoices</a></li>
							<li><a href="<?php echo base_url();?>admin/teacher_driven/payment_confirm">Payment Confirmation</a></li>
							<li><a href="<?php echo base_url();?>admin/teacher_driven/#not_yet">Veritrans Report</a></li>
							<li><a href="<?php echo base_url();?>admin/teacher_driven/#not_yet">Tickets</a></li>
						</ul>
					</li>
<?php if(!($this->input->get('show_duta') == 'ok')): ?>
					<li>
						<a href="<?php echo base_url();?>admin/feedback/"><span>Feedback</span></a>
						<ul>
							<li><a href="<?php echo base_url();?>admin/feedback/manage_question">Create Question</a></li>
							<li><a href="<?php echo base_url();?>admin/feedback/manage_answer">See Question</a></li>
							<li><a href="<?php echo base_url();?>admin/feedback/#not_yet">See Answer</a></li>
						</ul>
					</li>
<?php endif; ?>

					<li><a href="<?php echo base_url();?>admin/blog" <?php echo ($active==94)?'class="active"':'';?>><span>Blog</span></a></li>
					<li><a href="http://www.google.com/analytics/"><span>GA</span></a></li>
					<li>
						<a href="#"><span>Notification</span><span class="notification" id="notif-transaksi"></span></a>
						<ul id="notif">
							<!-- generated by jquery -->
						</ul>
					</li>
				</ul>
				</div>
				<!-- End Main Nav -->
			</div>
		</div>
        <!-- End Header -->

        <!-- Container -->
        <div id="container">
            <div class="shell">
                
                <?php if(isset($breadcumb)):?>
                <!-- Small Nav -->
                <div class="small-nav">
                    <?php echo $breadcumb; ?>
                </div>
                <!-- End Small Nav -->
                <?php endif;?>
				<div style="float: right;">
					Page load time: {elapsed_time} seconds!
				</div>
				<div style="clear: both;"></div>

                <!-- Main -->
                <div id="main">
                    <div class="cl">&nbsp;</div>

                    <!-- Content -->
                    <div id="content">
                        <?php echo $content;?>
                    </div>

                    <div class="cl">&nbsp;</div>
                </div>
                <!-- Main -->
            </div>
        </div>
        <!-- End Container -->

        <!-- Footer -->
        <div id="footer">
            <div class="shell">
                <span class="left">&copy; 2014 - Ruangguru.com</span>
                <span class="right">
                    <!--Created by Yudi Retanto</a> -->
                </span>
            </div>
        </div>
        <!-- End Footer -->
        <script type="text/javascript">
            $('a.column_delete').click(function(){
                return confirm("Are you sure want to delete this entries");
            });
            $('a.del').click(function(){
                return confirm("Are you sure want to delete this entries");
            });
        </script>

    </body>
</html>