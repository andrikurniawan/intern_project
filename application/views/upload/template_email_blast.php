<html>
    <body>
        <p style="font-size:14px;"><strong>Kpd. <?php echo $content['nama'];?></strong>,</p>
        <?php echo $content['nl2br']?nl2br($content['content']):$content['content'];?>
	   <p>
	       <strong>Ini pesan email otomatis, jangan membalas secara langsung</strong>. <strong>Jika Anda memiliki pertanyaan</strong>, silakan hubungi Tim Ruangguru melalui email ke <a href="mailto:info@ruangguru.com" class="normal-link"/>info@ruangguru.com</a> atau menelepon ke 021-9200-3040 pada saat jam kerja. Terima kasih.
	   </p><br/>
        <p>
            Salam,<br/><br/>
            <b>Tim Ruangguru</b>
        </p>
        <p>
            <a href="https://www.facebook.com/ruanggurucom?ref=hl" class="normal-link"><img src="<?php echo base_url().'images/fb-email.png'?>"/></a>&nbsp;<a href="https://twitter.com/ruangguru" class="normal-link"><img src="<?php echo base_url().'images/twitter-email.png'?>"/></a>&nbsp;<a href="http://www.youtube.com/channel/UCbc1RY0McnikiEMD8Box5Ig" class="normal-link"><img src="<?php echo base_url().'images/youtube-email.png'?>"/></a>&nbsp;<a href="http://ruangguru.tumblr.com/" class="normal-link"><img src="<?php echo base_url().'images/tumblr-email.png'?>"/></a>
        </p>
    </body>
</html>