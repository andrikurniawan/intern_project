<?php 
    date_default_timezone_set("Asia/Jakarta");
    $date_1 = new DateTime($tanggal);
    $date_2 = new DateTime($tanggal);

    $last = strtotime($tanggal);
    $now = strtotime(date("Y-m-d H:i:s"));
    $minute = ceil(abs($now - $last) / 60);
    $time = "";
    if($minute > 60){
        $jam = floor($minute/60);
        if($jam > 24){
            $hari = ceil($jam/24);
            if($hari > 30){
                $bulan = ceil($hari/30);
                $time = $bulan." Bulan yang Lalu";
            } else {
                $time = $hari." Hari yang Lalu";
            }
        } else {
            $time = "Hari Ini";
        }
    } else {
        $time = "Hari Ini";
    }
?>
<!-- Message Error -->
<?php if ($this->session->flashdata('f_user')): ?>
    <div class="msg msg-ok boxwidth">
        <p><strong><?php echo $this->session->flashdata('f_user'); ?></strong></p>
    </div>
<?php endif; ?>


<!-- Box -->
<div class="box">
    <!-- Box Head -->
    <div class="box-head">
        <h2>Notifikasi <?php echo $time?></h2>
    </div>
    <!-- End Box Head -->

    <div class="row" style="margin:0px;">
        <div class="col-xs-12" style="padding:0px;">
            <table class="table">
                <thead>
                    <tr>
                        <th>No</th>
                        <th>Pesan</th>
                        <th>Waktu Notifikasi</th>
                        <th>Tindak Lanjut Oleh</th>
                        <th>Status</th>
                    </tr>
                </thead>
                <tbody>
                    <?php $count = 0; foreach($notifications as $notif){ ?>
                        <tr>
                            <td><?php echo ++$count; ?></td>
                            <td><a href="<?php echo base_url().'admin/user/read_notif/'.$notif['id']?>"><?php echo $notif['pesan']?></a></td>
                            <td><?php echo date('d-M-Y H:i:s', strtotime($notif['date_created']))?></td>
                            <td>
                                <select name='ops' onchange='if(this.value != 0) { this.form.submit(); }' disabled="">
                                    <option value='0' <?php if($notif['tindak_lanjut_oleh'] == 0){ echo "selected";} ?>>-</option>
                                    <option value='1' <?php if($notif['tindak_lanjut_oleh'] == 1){ echo "selected";} ?>>NF</option>
                                    <option value='2' <?php if($notif['tindak_lanjut_oleh']== 2){ echo "selected";} ?>>MR</option>
                                    <option value='3' <?php if($notif['tindak_lanjut_oleh']== 3){ echo "selected";} ?>>PW</option>
                                    <option value='4' <?php if($notif['tindak_lanjut_oleh']== 4){ echo "selected";} ?>>MH</option>
                                </select>
                            <td><?php if($notif['status']==0){echo 'Belum di baca';} else { echo 'Sudah di baca';}?></td>
                        </tr>
                    <?php } ?>
                </tbody>
            </table>
        </div>
        <div class="col-xs-12" style="padding:10px;">
            <div class="col-xs-3" style="float:left;">
                <button type="button" id="next-tanggal-button" class="button <?php if($time=="Hari Ini") echo 'disabled'?>" 
                    style="height:30px;width:100px;font-size:12px;"
                    <?php if($time=="Hari Ini") echo 'disabled'?> ><< Next</button>
            </div>
            <div class="col-xs-3" style="float:right;text-align:right;">
                <button type="button" id="prev-tanggal-button" class="button" 
                    style="height:30px;width:100px;font-size:12px;">Previous >></button>
            </div>
        </div>
    </div>
</div>
<!-- End Box -->
<script>
    $(document).ready(function(){
        $("#prev-tanggal-button").click(function(){
            console.log('<?php echo $date_1->format('Y-m-d')?>');
            var tanggal = '<?php echo $date_1->sub(new DateInterval('P1D'))->format('Y-m-d')?>';
            console.log(tanggal);
            window.location.replace("<?php echo base_url()?>"+"admin/user/notifications/"+tanggal);
        });

        $("#next-tanggal-button").click(function(){
            console.log('<?php echo $date_2->format('Y-m-d')?>');
            var tanggal_besok = '<?php echo $date_2->add(new DateInterval('P1D'))->format('Y-m-d')?>';
            console.log(tanggal_besok);
            window.location.replace("<?php echo base_url()?>"+"admin/user/notifications/"+tanggal_besok);
        });
    });
</script>