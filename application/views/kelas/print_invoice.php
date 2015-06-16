<link rel="stylesheet" href="<?php echo base_url();?>css_rg/bootstrap/css/bootstrap.min.css" />
<link rel="stylesheet" href="<?php echo base_url();?>css_rg/invoice.css" />

<style type="text/css" media="print">
    @page { 
        size: 8.5in 11in;  /* width height */ 
        margin-top:0px;
    }
</style>

<div class="modal-content"  style="margin-top:0px; font-family: Ubuntu;width:100%">
    <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title" id="myModalLabel">Invoice</h4>
    </div>
    <div class="modal-body" style="text-align:left; padding: 30px;">
        <img id="logo" src="<?php echo base_url()?>images/logo-ruangguru.png">
        <div class="row">
            
            <div id="invoice-wrap" class="col col-xs-9">
                <table class="table table-bordered tabel-condensed">
                <tr>
                    <td class="warning" style="width: 200px;">No. Invoice</td>
                    <td class="info" id="no_inv"><?php echo $invoice['id']?></td>
                </tr>
                <tr>
                    <td class="warning">Ditujukan kepada</td>
                    <td class="info" id="tujuan"><?php echo $invoice['murid_nama']?></td>
                </tr>
                <tr>
                    <td>Nama Guru</td>
                    <td id="nama-guru"><?php echo $this->guru_model->nama_guru($invoice['guru_nama'])?></td>
                </tr>
                <tr>
                    <td>Mata Pelajaran</td>
                    <td id="matpel-id"><?php echo $invoice['matpel_title']?></td>
                </tr>
                <tr>
                    <td>Kode Kelas</td>
                    <td id="kelas-id"><?php echo $invoice['kelas_id']?></td>
                </tr>
                <tr>
                    <td>Jumlah Sesi</td>
                    <td id="jumlah-sesi"><?php echo $invoice['frekuensi']?></td>
                </tr>
                <tr>
                    <td>Jumlah Jam/Sesi</td>
                    <td id="jumlah-durasi"><?php echo $invoice['durasi']?></td>
                </tr>
                <tr>
                    <td>Harga Perjam</td>
                    <td id="total-perjam"><?php echo "Rp.".number_format($invoice['harga_perjam'],0,",",".");?></td>
                </tr>
                <tr>
                    <td>Total Biaya</td>
                    <td id="total-biaya"><?php echo "Rp.".number_format($invoice['harga_perjam']*$invoice['durasi']*$invoice['frekuensi'],0,",",".");?></td>
                </tr>
                <tr>
                    <td>Diskon</td>
                    <td id="total-diskon"><?php echo "Rp.".number_format($invoice['diskon'],0,",",".")?></td>
                </tr>
                <tr>
                    <td>Total yang Harus Dibayar</td>
                    <td id="total-terbayar"><?php echo "Rp.".number_format($invoice['harga_total'],0,",",".");?></td>
                </tr>
                </table>
            </div>

            <div class="col-xs-12">
                <div id="cc_bayar_tab">
                    <p>Klik link berikut untuk melakukan pembayaran via Credit Card</p>
                    <a id="link_bayar" href="<?php echo $invoice['url']?>"><?php echo $invoice['url']?></a>
                    <br/>
                    <p>Atau melalui transfer rekening melalui bank-bank berikut ini :</p>
                </div>
                <div id="transfer_bayar_tab" class="tab-pane">
                    <div role="tabpanel">
                        <div class="tab-content" style="padding: 30px; background: #EAEAEA;">
                            <div class="tab-pane active" id="bca">
                                <strong>Bank BCA</strong><br>
                                <table>
                                <tr>
                                    <td>No. Rekening</td>
                                    <td>: 2611-3655-11</td>
                                </tr>
                                <tr>
                                    <td>Atas nama</td>
                                    <td>: PT. RUANG RAYA INDONESIA </td>
                                </tr>
                                </table>
                            </div>
                            <div id="mandiri">
                                <strong>Bank Mandiri</strong><br>
                                <table>
                                <tr>
                                    <td>No. Rekening</td>
                                    <td>: 157-00-0398209-8</td>
                                </tr>
                                <tr>
                                    <td>Atas nama</td>
                                    <td>: PT. RUANG RAYA INDONESIA </td>
                                </tr>
                                </table>
                            </div>
                            <div id="bni">
                                <strong>Bank BNI</strong><br>
                                <table>
                                <tr>
                                    <td>No. Rekening</td>
                                    <td>:  033-1469330</td>
                                </tr>
                                <tr>
                                    <td>Atas nama</td>
                                    <td>: PT. RUANG RAYA INDONESIA </td>
                                </tr>
                                </table>
                            </div>
                            <div id="bri">
                                <strong>Bank BRI</strong><br>
                                <table>
                                <tr>
                                    <td>No. Rekening</td>
                                    <td>: 2080-01-000124-30-3</td>
                                </tr>
                                <tr>
                                    <td>Atas nama</td>
                                    <td>: PT. RUANG RAYA INDONESIA </td>
                                </tr>
                                </table>
                            </div>
                            <div id="permata">
                                <strong>Bank Permata</strong><br>
                                <table>
                                <tr>
                                    <td>No. Rekening</td>
                                    <td>: 411-0463893</td>
                                </tr>
                                <tr>
                                    <td>Atas nama</td>
                                    <td>: PT. RUANG RAYA INDONESIA </td>
                                </tr>
                                </table>
                            </div>
                        </div>
                    </div>
                    <br>
                    <p>Setelah transfer, Anda dapat melakukan konfirmasi pembayaran pada website ruangguru dan menghubungi pihak Ruangguru atau dengan mengirimkan bukti transfer pembayaran ke email <a href="mailto:bayar@ruangguru.com" class="normal-link bold">bayar@ruangguru.com</a></p>
                </div>

                <div id="cash_bayar_tab" class="tab-pane">
                    <p>Kami juga menerima pembayaran melalui Mandiri ClickPay dan Virtual Account.</p>	
                    <p>Atau anda dapat melakukan pembayaran langsung ke:</p>
                    <strong>Ruangguru.com HQ</strong><br>
                    d/a Jalan Tebet Raya 32A Jakarta Selatan<br>
                    (patokan: depan Wisma Tebet)<br>
                    Telp: 021-9200-3040<br>
                </div>
            </div>
        </div>
        </div>
    </div>
</div>
<script type="text/javascript" src="<?php echo base_url();?>js/jquery-1.9.1.min.js"></script>
<script>
    $(document).ready(function(){
        window.print();
    });
</script>