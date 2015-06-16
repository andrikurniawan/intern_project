<link rel="stylesheet" href="<?php echo base_url();?>css_rg/bootstrap/css/bootstrap.min.css" />
<link rel="stylesheet" href="<?php echo base_url();?>css_rg/invoice.css" />

<style type="text/css" media="print">
    @page { 
        size: 8.5in 11in;  /* width height */ 
        margin-top:0px;
    }
</style>

<div class="modal-content"  style="margin-top:0px; font-family: Ubuntu;width:920px">
    <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title" id="myModalLabel">Bukti Penerimaan Pembayaran Murid</h4>
    </div>
    <div class="modal-body" style="text-align:left; padding: 30px;">
        <img id="logo" src="<?php echo base_url()?>images/logo-ruangguru.png">
        <div class="row">
            
            <div id="invoice-wrap" class="col col-xs-9">
                <table class="table table-bordered tabel-condensed">
                    <tr>
                        <td class="info" colspan="2">Telah Diterima Dari</td>
                    </tr>
                    <tr>
                        <td style="width: 200px;">Nama Customer</td>
                        <td id="tujuan"><?php echo $pembayaran['nama_customer']?></td>
                    </tr>
                    <tr>
                        <td class="info" colspan="2">Di Rekening</td>
                    </tr>
                    <tr>
                        <td>Bank</td>
                        <td id="nama-guru"><?php echo $pembayaran['bank']?></td>
                    </tr>
                    <tr>
                        <td>No. Rekening</td>
                        <td id="matpel-id"><?php echo $pembayaran['rekening']?></td>
                    </tr>
                    <tr>
                        <td>Dengan Jumlah</td>
                        <td id="kelas-id">Rp. <?php echo number_format($pembayaran['jumlah'],0,",",".")?></td>
                    </tr>
                    <tr>
                        <td>Dan Diskon</td>
                        <td id="kelas-id">Rp. <?php echo number_format($pembayaran['diskon'],0,",",".")?></td>
                    </tr>
                    <tr>
                        <td class="info" colspan="2">Dengan Rincian</td>
                    </tr>
                    <tr>
                        <table class="table table-condensed" style="margin-top:0px;">
                            <thead>
                                <tr class="info">
                                    <th>Deskripsi</th>
                                    <th>Jumlah Pertemuan</th>
                                    <th>Jam/ Pertemuan</th>
                                    <th>Total Jam</th>
                                    <th>Harga/Jam</th>
                                    <th>Total</th>
                                    <th>Diskon</th>
                                    <th>Total Akhir</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td>Pembayaran Kelas <?php echo $pembayaran['matpel_title']?></td>
                                    <td><?php echo $pembayaran['frekuensi'] ?></td>
                                    <td><?php echo $pembayaran['durasi'] ?></td>
                                    <td><?php echo $pembayaran['total_jam'] ?></td>
                                    <td><?php echo number_format($pembayaran['harga_perjam'],0,",",".") ?></td>
                                    <td><?php echo number_format($pembayaran['harga_perjam']*$pembayaran['total_jam'],0,",",".") ?></td>
                                    <td><?php echo number_format($pembayaran['diskon'],0,",",".") ?></td>
                                    <td><?php echo number_format($pembayaran['harga_total'],0,",",".") ?></td>
                                </tr>
                                <tr class="warning" style="font-weight:bold;">
                                    <td colspan="6">Total Penerimaan</td>
                                    <td colspan="2">Rp. <?php echo number_format($pembayaran['harga_total'],0,",",".") ?></td>
                                </tr>
                            </tbody>
                        </table>
                    </tr>
                </table>
            </div>
        </div>
        </div>
    </div>
</div>
<script type="text/javascript" src="<?php echo base_url();?>js/jquery-1.9.1.min.js"></script>