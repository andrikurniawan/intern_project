<!-- Message Error -->
<?php if ($this->session->flashdata('f_guru')): ?>
    <div class="msg msg-ok boxwidth">
        <p><strong><?php echo $this->session->flashdata('f_guru'); ?></strong></p>
    </div>
<?php endif; ?>

<!-- Box -->
<div class="box">
    <!-- Box Head -->
    <div class="box-head">
        <h2>Edit Rating Guru</h2>
    </div>
    <!-- End Box Head -->

    <form action="<?php echo base_url();?>admin/guru/rating_submit" method="post" >

        <!-- Form -->
        <div class="form">
            <p>
                <label>Nama Guru</label>
                <input type="text" class="field size1" name="name" value="<?php echo $guru->guru_nama;?>" disabled="true"/>
                <input type="hidden" class="field size1" name="id" value="<?php echo $guru->guru_id;?>"/>
            </p>
            <div class="table">
                <table>
                    <thead>
                        <tr>
                            <th class="center">Kategori</th>
                            <th class="center">Value</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td>Lulusan SMA</td>
                            <td>
                                <?php $config = 'class="checkbox"';?>
                                <?php echo form_radio('sma', '0', ($guru->guru_rating_sma==0), $config);?> Tidak
                                <?php echo form_radio('sma', '1', ($guru->guru_rating_sma==1), $config);?> Ya
                            </td>
                        </tr>
                        <tr>
                            <td>Lulusan Diploma</td>
                            <td>
                                <?php echo form_radio('diploma', '0', ($guru->guru_rating_diploma==0), $config);?> Tidak
                                <?php echo form_radio('diploma', '1', ($guru->guru_rating_diploma==1), $config);?> IPK < 3.0
                                <?php echo form_radio('diploma', '2', ($guru->guru_rating_diploma==2), $config);?> IPK 3.0 - 3.5
                                <?php echo form_radio('diploma', '3', ($guru->guru_rating_diploma==3), $config);?> IPK IPK 3.5 - 4.0
                            </td>
                        </tr>
                        <tr>
                            <td>Lulusan S1 UI/ UGM/ ITB/ PT Luar Negeri</td>
                            <td>
                                <?php echo form_radio('s1_top', '0', ($guru->guru_rating_s1_top==0), $config);?> Tidak
                                <?php echo form_radio('s1_top', '1', ($guru->guru_rating_s1_top==1), $config);?> Ya
                            </td>
                        </tr>
                        <tr>
                            <td>Lulusan S1</td>
                            <td>
                                <?php echo form_radio('s1', '0', ($guru->guru_rating_s1==0), $config);?> Tidak
                                <?php echo form_radio('s1', '1', ($guru->guru_rating_s1==1), $config);?> IPK < 3.0
                                <?php echo form_radio('s1', '2', ($guru->guru_rating_s1==2), $config);?> IPK 3.0 - 3.5
                                <?php echo form_radio('s1', '3', ($guru->guru_rating_s1==3), $config);?> IPK IPK 3.5 - 4.0
                            </td>
                        </tr>
                        <tr>
                            <td>Lulusan S2 UI/ UGM/ ITB/ PT Luar Negeri</td>
                            <td>
                                <?php echo form_radio('s2_top', '0', ($guru->guru_rating_s2_top==0), $config);?> Tidak
                                <?php echo form_radio('s2_top', '1', ($guru->guru_rating_s2_top==1), $config);?> Ya
                            </td>
                        </tr>
                        <tr>
                            <td>Lulusan S2</td>
                            <td>
                                <?php echo form_radio('s2', '0', ($guru->guru_rating_s2==0), $config);?> Tidak
                                <?php echo form_radio('s2', '1', ($guru->guru_rating_s2==1), $config);?> IPK < 3.0
                                <?php echo form_radio('s2', '2', ($guru->guru_rating_s2==2), $config);?> IPK 3.0 - 3.5
                                <?php echo form_radio('s2', '3', ($guru->guru_rating_s2==3), $config);?> IPK IPK 3.5 - 4.0
                            </td>
                        </tr>
                        <tr>
                            <td>Lulusan S3 UI/ UGM/ ITB/ PT Luar Negeri</td>
                            <td>
                                <?php echo form_radio('s3_top', '0', ($guru->guru_rating_s3_top==0), $config);?> Tidak
                                <?php echo form_radio('s3_top', '1', ($guru->guru_rating_s3_top==1), $config);?> Ya
                            </td>
                        </tr>
                        <tr>
                            <td>Lulusan S3</td>
                            <td>
                                <?php echo form_radio('s3', '0', ($guru->guru_rating_s3==0), $config);?> Tidak
                                <?php echo form_radio('s3', '1', ($guru->guru_rating_s3==1), $config);?> Ya
                            </td>
                        </tr>
                        <tr>
                            <td>Beasiswa saat kuliah</td>
                            <td>
                                <?php echo form_radio('beasiswa', '0', ($guru->guru_rating_beasiswa==0), $config);?> Tidak
                                <?php echo form_radio('beasiswa', '1', ($guru->guru_rating_beasiswa==1), $config);?> Ya
                            </td>
                        </tr>
                        <tr>
                            <td>Sertifikat Pelatihan</td>
                            <td>
                                <?php echo form_radio('sertifikat', '0', ($guru->guru_rating_sertifikat==0), $config);?> Tidak
                                <?php echo form_radio('sertifikat', '1', ($guru->guru_rating_sertifikat==1), $config);?> Ya
                            </td>
                        </tr>
                        <tr>
                            <td>Nilai TOEFL IBT</td>
                            <td>
                                <?php echo form_radio('toefl_ibt', '0', ($guru->guru_rating_toefl_ibt==0), $config);?> Tidak
                                <?php echo form_radio('toefl_ibt', '1', ($guru->guru_rating_toefl_ibt==1), $config);?> > 600/ 667
                            </td>
                        </tr>
                        <tr>
                            <td>Nilai TOEFL ITP</td>
                            <td>
                                <?php echo form_radio('toefl_itp', '0', ($guru->guru_rating_toefl_itp==0), $config);?> Tidak
                                <?php echo form_radio('toefl_itp', '1', ($guru->guru_rating_toefl_itp==1), $config);?> > 100/ 120    
                            </td>
                        </tr>
                        <tr>
                            <td>Nilai IELTS</td>
                            <td>
                                <?php echo form_radio('ielts', '0', ($guru->guru_rating_ielts==0), $config);?> Tidak
                                <?php echo form_radio('ielts', '1', ($guru->guru_rating_ielts==1), $config);?> > 7.0/ 9.0     
                            </td>
                        </tr>
                        <tr>
                            <td>Nilai GRE</td>
                            <td>
                                <?php echo form_radio('gre', '0', ($guru->guru_rating_gre==0), $config);?> Tidak
                                <?php echo form_radio('gre', '1', ($guru->guru_rating_gre==1), $config);?> > 1400/1600 atau > 322/340    
                            </td>
                        </tr>
                        <tr>
                            <td>Nilai GMAT</td>
                            <td>
                                <?php echo form_radio('gmat', '0', ($guru->guru_rating_gmat==0), $config);?> Tidak
                                <?php echo form_radio('gmat', '1', ($guru->guru_rating_gmat==1), $config);?> > 700/800     
                            </td>
                        </tr>
                        <tr>
                            <td>Nilai CFA</td>
                            <td>
                                <?php echo form_radio('cfa', '0', ($guru->guru_rating_cfa==0), $config);?> Tidak
                                <?php echo form_radio('cfa', '1', ($guru->guru_rating_cfa==1), $config);?> Level 1     
                            </td>
                        </tr>
                        
                    </tbody>
                </table>
            </div>
        </div>
        <!-- End Form -->
        
        <!-- Form Buttons -->
        <div class="buttons">
            <input type="submit" class="button" value="submit" />
        </div>
        <!-- End Form Buttons -->
    </form>
</div>
<!-- End Box -->
