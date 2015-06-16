<!-- End Box -->
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
    <head>
        <meta http-equiv="Content-type" content="text/html; charset=utf-8" />
        <title>Ruangguru Administration</title>
        <link rel="stylesheet" href="<?php echo base_url();?>css_rg/admin.css" type="text/css" media="all" />
    </head>
    <body>
        <!-- Header -->
        <div id="header">
            <div class="shell">
                <!-- Logo + Top Nav -->
                <div id="top">
                    <h1><a href="<?php echo base_url(); ?>">Ruangguru</a></h1>

                </div>
                <!-- End Logo + Top Nav -->


            </div>
        </div>
        <!-- End Header -->

        <!-- Container -->
        <div id="container">
            <div class="shell">

                <!-- Small Nav -->
                <div class="small-nav">
                    <a href="<?php echo base_url(); ?>admin">Administration</a>
                    <span>&gt;</span>
                    Login
                </div>
                <!-- End Small Nav -->
                
                <!-- Message Error -->
                <?php if ($this->session->flashdata('f_login')):?>
                <div class="msg <?php echo ($this->session->flashdata('f_login_status')=='ok')?'msg-ok':'msg-error';?> boxwidth">
                    <p><strong><?php echo $this->session->flashdata('f_login');?></strong></p>
                </div>
                <?php endif;?>

                <br />
                <!-- Main -->
                <div id="main">
                    <div class="cl">&nbsp;</div>

                    <!-- Content -->
                    <div id="content">
                        <!-- Box -->
                        <div class="box">
                            <!-- Box Head -->
                            <div class="box-head">
                                <h2>Login</h2>
                            </div>
                            <!-- End Box Head -->

                            <form action="<?php echo base_url(); ?>admin/user/login_submit" method="post">

                                <!-- Form -->
                                <div class="form">
                                    <p>
                                        <label>Username</label>
                                        <input type="text" class="field size1" name="username" />
                                    </p>
                                    <p>
                                        <label>Password</label>
                                        <input type="password" class="field size1" name="password"/>
                                    </p>

                                </div>
                                <!-- End Form -->

                                <!-- Form Buttons -->
                                <div class="buttons">
                                    <input type="submit" class="button" value="submit" />
                                </div>
                                <!-- End Form Buttons -->
                            </form>
                        </div>
                        </div>
                    </div>

                    <div class="cl">&nbsp;</div>			
                </div>
                <!-- Main -->
            </div>
        </div>
        <!-- End Container -->

        <!-- Footer -->
        <div id="footer" style="position: absolute;bottom: 0;width: 100%">
            <div class="shell">
                <span class="left">&copy; 2014 - Ruangguru.com</span>
                <span class="right">
                    <!--Created by Yudi Retanto</a> -->
                </span>
            </div>
        </div>
        <!-- End Footer -->
    </body>
</html>