<!-- Box -->
<div class="box">
    <!-- Box Head -->
    <div class="box-head">
        <h2>Daftar Sertifikat Guru</h2>
    </div>
    <!-- End Box Head -->
    <!-- Form -->
    <div class="form">
        <p>
            <label>Nama Guru</label>
            <input type="text" class="field size1" name="name" value="<?php echo $guru->guru_nama; ?>" disabled="true"/>
            <input type="hidden" class="field size1" name="id" value="<?php echo $guru->guru_id; ?>"/>
        </p>
    </div>
    <div class="table">
        <table style="width: 100%">
            <thead>
                <tr class="center">
                    <th>No</th>
                    <th>Nama Sertifikat</th>
                    <th>File</th>
                </tr>
            </thead>
            <tbody>
                <?php $i = 1; ?>
                <?php foreach ($sertifikat->result() as $row): ?>
                    <tr>
                        <td><?php echo $i++; ?></td>
                        <td>
                            <?php echo $row->guru_sertifikat_title; ?>
                        </td>
                        <td>
                            <a href="<?php echo base_url() . 'files/sertifikat/' . $row->guru_sertifikat_file; ?>" target="_blank">Open</a>
                        </td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
        <div class="pagging">
            <div class="left">
                Showing <?php echo $sertifikat->num_rows(); ?> Certificates
            </div>
        </div>
    </div>
</div>
<!-- End Box -->