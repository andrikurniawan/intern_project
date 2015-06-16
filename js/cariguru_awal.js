
$(document).ready(function(){


    /* wish list */
    //action for bookmark button on search results
    $(".bookmark-guru-sgr").click(function(event){
        event.stopPropagation();

        if ($(this).attr('data-login') == "false") {
            //ask for login
            $('#login-murid-popup #add-login-msg').html('Silahkan login terlebih dahulu untuk menambahkan wishlist');
            $('#login-murid-popup').modal('show');
        } else {
            var id = $(this).attr("data-guru-id");
            var theMarkWrapper = $(this);
            var theMarkButton = $(this).find('img');
            //if not bookmarked, bookmark, else unbookmark
            if (!$(this).hasClass('bookmarked-guru-sgr')) {
                $.post(base_url+"murid/add_wishlist/", {id_guru : id})
                    .done(function(data){
                        $(theMarkWrapper).addClass('bookmarked-guru-sgr'); //change style to bookmarked
                        $(theMarkButton).attr('src', base_url + 'images/icon_bookmarked.png');
                        $(theMarkButton).popover('destroy');   
                        $(theMarkButton).popover({
                            content: '<span style="font-family: Ubuntu; color: black;">telah ditambahkan<br>ke wishlist</span>',   
                            html: true,
                            template: '<div class="popover" role="tooltip"><div class="arrow"></div><div class="popover-content" style="width: 150px; text-align: left;"></div></div>',
                            placement: 'right',
                            container: 'body'
                        });
                        $(theMarkButton).popover('show');
                        setTimeout(function () {
                            $(theMarkButton).popover('destroy');
                        }, 2000);
                        $(theMarkButton).attr('title', 'hapus dari wishlist');
                    }); 
            } else {
                $.post(base_url+"murid/remove_wishlist/", {id_guru : id})
                    .done(function(data){
                        $(theMarkWrapper).removeClass('bookmarked-guru-sgr');
                        $(theMarkButton).attr('src', base_url + 'images/icon_bookmark.png');
                        $(theMarkButton).popover('destroy');   
                        $(theMarkButton).popover({
                            content: '<span style="font-family: Ubuntu; color: black;">telah dihapus<br>dari wishlist</span>', 
                            html: true,
                            template: '<div class="popover" role="tooltip"><div class="arrow"></div><div class="popover-content" style="width: 150px; text-align: left;"></div></div>',
                            placement: 'right',
                            container: 'body'
                        });
                        $(theMarkButton).popover('show');
                        setTimeout(function () {
                            $(theMarkButton).popover('destroy');
                        }, 2000);
                        $(theMarkButton).attr('title', 'tambahkan ke wishlist');
                    }); 
            }
        }
            
    });

    //action for bookmark button on individual popup
    $("#tentang-bookmark-btn").click(function(event){

        if ($(this).attr('data-login') == "false") {
            //ask for login
            $('#login-murid-popup #add-login-msg').html('Silahkan login terlebih dahulu untuk menambahkan wishlist');
            $('#guru-popup-sgr').modal('hide');
            $('#login-murid-popup').modal('show');
        } else {
            var id = $(this).attr("data-guru-id");
            var theMarkWrapper = $(this);
            var theMarkButton = $(this).find('img');
            //if not bookmarked, bookmark, else unbookmark
            if (!$(this).hasClass('tentang-bookmarked-btn')) {
                $.post(base_url+"murid/add_wishlist/", {id_guru : id})
                    .done(function(data){
                        $(theMarkWrapper).addClass('tentang-bookmarked-btn'); //change style to bookmarked
                        $(theMarkButton).attr('src', base_url + 'images/icon_bookmarked.png');
                        $(".bookmark-guru-sgr[data-guru-id="+ id +"]").addClass('bookmarked-guru-sgr');
                        $(".bookmark-guru-sgr[data-guru-id="+ id +"] img").attr('src', base_url + 'images/icon_bookmarked.png');
                        $(theMarkButton).popover('destroy');   
                        $(theMarkButton).popover({
                            content: '<span style="font-family: Ubuntu; color: black;">telah ditambahkan<br>ke wishlist</span>',   
                            html: true,
                            template: '<div class="popover" role="tooltip"><div class="arrow"></div><div class="popover-content" style="width: 150px; text-align: left;"></div></div>',
                            placement: 'right',
                            container: '#guru-popup-sgr'
                        });
                        $(theMarkButton).popover('show');
                        setTimeout(function () {
                            $(theMarkButton).popover('destroy');
                        }, 2000);
                        $(theMarkButton).attr('title', 'hapus dari wishlist');
                        $(".bookmark-guru-sgr[data-guru-id="+ id +"] img").attr('title', 'hapus dari wishlist');
                    });
            } else {
                $.post(base_url+"murid/remove_wishlist/", {id_guru : id})
                    .done(function(data){
                        $(theMarkWrapper).removeClass('tentang-bookmarked-btn');
                        $(theMarkButton).attr('src', base_url + 'images/icon_bookmark.png');
                        $(".bookmark-guru-sgr[data-guru-id="+ id +"]").removeClass('bookmarked-guru-sgr');
                        $(".bookmark-guru-sgr[data-guru-id="+ id +"] img").attr('src', base_url + 'images/icon_bookmark.png');
                        $(theMarkButton).popover('destroy');   
                        $(theMarkButton).popover({
                            content: '<span style="font-family: Ubuntu; color: black;">telah dihapus<br>dari wishlist</span>', 
                            html: true,
                            template: '<div class="popover" role="tooltip"><div class="arrow"></div><div class="popover-content" style="width: 150px; text-align: left;"></div></div>',
                            placement: 'right',
                            container: '#guru-popup-sgr'
                        });
                        $(theMarkButton).popover('show');
                        setTimeout(function () {
                            $(theMarkButton).popover('destroy');
                        }, 2000);
                        $(theMarkButton).attr('title', 'tambahkan ke wishlist');
                        $(".bookmark-guru-sgr[data-guru-id="+ id +"] img").attr('title', 'tambahkan ke wishlist');
                    });
            }
        }

            
            
    });
    /* -- -- */

    /* popup data guru */
    //get data when try to show popup
    //insert the data to corresponding spaces
    $('#guru-popup-sgr').on('show.bs.modal', function (e) {
        var guru_id = $(e.relatedTarget).attr('data-guru-id');
        $.post(base_url + 'guru/data_guru_json/' + guru_id + '/',{},
                function(data){
                    //connect pilih button
                    $('#tentang-pilih-btn').attr('data-guru-id', guru_id);
                    $('#tentang-pilih-btn').attr('data-guru-nama', data['guru_nama']);
                    $('#tentang-pilih-btn').attr('data-guru-gender', data['guru_jeniskelamin']);
                    
                    //insert nama
                    $('#tentang-guru-nama').append('<h4 style="display: inline; text-decoration: underline;">' + data['guru_nama'].toUpperCase() + '</h4>');
                    $('#tentang-guru-nama').attr('href', base_url+'guru/profil/' + guru_id);

                    //insert badge
                    if (data['guru_badge'] !== 0) {
                        $('#tentang-guru-badge').append('<img style="width: 48px; margin-top: -1px;" src="' + data['guru_badge'] + '" />');
                        if (data['guru_tipe'] <= 0.1) {
                            $('#tentang-guru-badge img').attr('title', 'termasuk 10% guru dengan rating tertinggi di Ruangguru');
                        } else if (data['guru_tipe'] <= 0.3) {
                            $('#tentang-guru-badge img').attr('title', 'termasuk 30% guru dengan rating tertinggi di Ruangguru');
                        } else if (data['guru_tipe'] <= 0.5) {
                            $('#tentang-guru-badge img').attr('title', 'termasuk 50% guru dengan rating tertinggi di Ruangguru');
                        }
                    }

                    //insert verified
                    if (data['guru_verified'] == 1) {
                        $('#tentang-guru-verified').append('<img style="height:28px; padding: 3px 4px 3px 8px; margin-top: -7px;" title="terverifikasi" src="' + base_url + 'images/icon_verified.png" />');   
                    }

                    //connect wishlist button
                    if ($('#tentang-bookmark-btn').attr('data-login') != 'false') {
                        $('#tentang-bookmark-btn').attr('data-guru-id', guru_id);
                        if (data['guru_in_wishlist'] == 1) {
                            $('#tentang-bookmark-btn').addClass('tentang-bookmarked-btn');
                            $('#tentang-bookmark-btn').append('<img src="' +base_url+ 'images/icon_bookmarked.png" style="height: 28px; padding: 3px 4px; margin-top: -7px;" title="hapus dari wishlist" />');
                        } else {
                            $('#tentang-bookmark-btn').removeClass('tentang-bookmarked-btn');
                            $('#tentang-bookmark-btn').append('<img src="' +base_url+ 'images/icon_bookmark.png" style="height: 28px; padding: 3px 4px; margin-top: -7px;" title="tambahkan ke wishlist" />');
                        }
                    } else {
                        $('#tentang-bookmark-btn').removeClass('tentang-bookmarked-btn');
                        $('#tentang-bookmark-btn').append('<img src="' +base_url+ 'images/icon_bookmark.png" style="height: 28px; padding: 3px 4px; margin-top: -7px;" title="tambahkan ke wishlist" />');
                    }

                    //insert tagline
                    $('#tentang-guru-tagline').append(data['guru_tagline']);
                               
                    //insert video
                    // if (data['guru_video'].length > 0) {
                    //     if (data['guru_jenis_video'] == 0) {
                    //         $('#tentang-guru-video').append('<iframe width="500" height="281" src="//www.youtube.com/embed/' + data["guru_video"] + '" frameborder="0" allowfullscreen></iframe>');
                    //     } else {
                    //         $('#tentang-guru-video').append('<iframe src="//player.vimeo.com/video/' + data["guru_video"] + '" width="500" height="281" frameborder="0" webkitallowfullscreen mozallowfullscreen allowfullscreen></iframe>');
                    //     }
                    // } else {
                    //     $('#tentang-guru-video').append('-');
                    // }

                    //insert foto
                    var imgsrc = base_url + "images/pp/" + guru_id + ".jpg";
                    if (!fileExists(imgsrc)) {
                        if (data['guru_jeniskelamin'] == 1)
                            imgsrc = base_url + "images/avatarboy.jpg";
                        else
                            imgsrc = base_url + "images/avatargirl.jpg";
                    }
                    $('#tentang-guru-foto').append('<img src="'+ imgsrc +'">');

                    //insert tentang/bio
                    $('#tentang-guru-tentang').append(data['guru_tentang'] != null && data['guru_tentang'].length > 0 ? data['guru_tentang'] : '-');

                    //insert umur
                    $('#tentang-guru-umur').append(data['guru_umur'] + " tahun");

                    //insert jenis kelamin
                    $('#tentang-guru-jeniskelamin').append((data['guru_jeniskelamin'] == 1) ? 'Laki-laki' : 'Perempuan');

                    //insert profesi
                    $('#tentang-guru-profesi').append(data['guru_profesi']);

                    //insert lokasi
                    $('#tentang-guru-lokasi').append(data['guru_lokasi']);

                    //insert metode mengajar
                    var metodehtml = '';
                    if (data['guru_metode'] != null && data['guru_metode'].length > 0) {
                        var metode = data['guru_metode'].split(',');
                        for (var i=0; i<metode.length; i++) {
                            if (metode[i] == '1') {
                                metodehtml += 'online';
                            } else if (metode[i] == '2') {
                                metodehtml += 'tatap muka';
                            }
                            if (i+2 < metode.length) {
                                metodehtml += ', ';
                            }
                        }
                        $('#tentang-guru-metode').append(metodehtml);
                    } else {
                        $('#tentang-guru-metode').append('online, tatap muka');
                    }

                    //popover question sign
                    $('#question-rating').mouseover(function() {
                        $(this).popover({
                            content: '<span style="font-family: Ubuntu; color: black;">Rating dihitung berdasarkan credentials dan review pengalaman guru bersama kami</span>',   
                            html: true,
                            template: '<div class="popover" role="tooltip" style="position: fixed;"><div class="arrow"></div><div class="popover-content" style="width: 220px; text-align: left;"></div></div>',
                            placement: 'bottom',
                            container: '#tentang-guru4'
                        });
                        $(this).popover('show');
                    });
                    $('#question-rating').mouseleave(function() {
                        $(this).popover('destroy');
                    });

                    $('#question-review').mouseover(function() {
                        $(this).popover({
                            content: '<span style="font-family: Ubuntu; color: black;">' +
                                    'Penilaian performa guru berdasarkan feedback yang diberikan oleh murid.' +
                                '</span>',   
                            html: true,
                            template: '<div class="popover" role="tooltip" style="position: fixed;"><div class="arrow"></div><div class="popover-content" style="width: 220px; text-align: left;"></div></div>',
                            placement: 'bottom',
                            container: '#tentang-guru4'
                        });
                        $(this).popover('show');
                    });
                    $('#question-review').mouseleave(function() {
                        $(this).popover('destroy');
                    });

                    //popover question sign
                    $('#question-jam').mouseover(function() {
                        $(this).popover({
                            content: '<span style="font-family: Ubuntu; color: black;">Akumulasi jam mengajar guru di Ruangguru.com</span>',   
                            html: true,
                            template: '<div class="popover" role="tooltip" style="position: fixed;"><div class="arrow"></div><div class="popover-content" style="width: 220px; text-align: left;"></div></div>',
                            placement: 'bottom',
                            container: '#tentang-guru4'
                        });
                        $(this).popover('show');
                    });
                    $('#question-jam').mouseleave(function() {
                        $(this).popover('destroy');
                    });

                    //insert jadwal guru
                    $('#tentang-guru-jadwal').append(
                        '<table class="table table-condensed table-bordered" border="0" cellpadding="2" cellspacing="1" style="width:100%">\
                                <tbody>\
                                    <tr>\
                                        <th width="10"></th>\
                                        <th width="50" class="small center">Sen</th>\
                                        <th width="50" class="small center">Sel</th>\
                                        <th width="50" class="small center">Rab</th>\
                                        <th width="50" class="small center">Kam</th>\
                                        <th width="50" class="small center">Jum</th>\
                                        <th width="50" class="small center">Sab</th>\
                                        <th width="50" class="small center">Min</th>\
                                    </tr>'
                                    + data['guru_jadwal'] +
                                '</tbody>\
                            </table>'
                    );

                    //insert riwayat pendidikan
                    var riwayat = '';
                    for (var ii=0; ii<data['guru_riwayat_pendidikan'].length; ii++) {
                        riwayat += '<div class="text-points">' + data['guru_riwayat_pendidikan'][ii]['pendidikan_title'] + '<br>' + data['guru_riwayat_pendidikan'][ii]['instansi'] + '</div>';
                    }

                    if (riwayat == '') {
                        riwayat = '-';
                    }

                    $('#tentang-guru-pendidikan').append(riwayat);
                    
                    //insert kualifikasi
                    var kualifikasi = "";
                    for(var kk=0;kk<data['guru_kualifikasi'].length;kk++){
                        kualifikasi += '<div class="text-points">' + data['guru_kualifikasi'][kk]['kualifikasi']+'</div>';
                    }

                    if(kualifikasi==""){
                        kualifikasi = "-";
                    }

                    $('#tentang-guru-kualifikasi').html(kualifikasi);
                    
                    //insert pengalaman
                    var pengalaman = "";
                    for(var pp=0;pp<data['guru_pengalaman'].length;pp++){
                        pengalaman += '<div class="text-points">' + data['guru_pengalaman'][pp]['pengalaman']+'</div>';
                    }

                    if(pengalaman==""){
                        pengalaman = "-";
                    }

                    $('#tentang-guru-pengalaman').html(pengalaman);

                    //insert tarif
                    var tarif = "";

                    if(data['guru_tarif'] != null && data['guru_tarif'].length>0){
                        var jenjangTitle ='';
                        var jenjangTitlePrev ='';
                        for(var i=0;i<data['guru_tarif'].length;i++){
                            jenjangTitle = data['guru_tarif'][i]['jenjang_pendidikan_title'];
                            tarif += "<tr>";
                            if (jenjangTitle == jenjangTitlePrev) {
                                tarif += '<td style="border-top: 0;"></td>';
                            } else {
                                tarif += "<td>"+ jenjangTitle +"</td>";
                            }
                            tarif += "<td>"+data['guru_tarif'][i]['matpel_title']+"</td>";
                            tarif += "<td>Rp. "+data['guru_tarif'][i]['guru_matpel_tarif'].toString().replace(/\B(?=(\d{3})+(?!\d))/g, ",")+"</td>";
                            tarif += "</tr>";
                            jenjangTitlePrev = jenjangTitle;
                        }
                    }
                    $('#tentang-guru-tarif').append(tarif);

                    //insert lama mengajar
                    var lama_mengajar = "Kurang dari setahun";
                    if(data['lama_mengajar']>36){
                        lama_mengajar = "Lebih dari 3 Tahun"
                    } else if (data['lama_mengajar']>24){
                        lama_mengajar = "Lebih dari 2 Tahun"
                    } else if (data['lama_mengajar']>12){
                        lama_mengajar = "Lebih dari 1 Tahun"
                    }
                    $("#tentang-guru-lamamengajar").append(lama_mengajar);

                    //insert rating
                    $('#tentang-guru-rating').append(data['guru_rating']);

                    //insert jumlah jam
                    $('#tentang-guru-jam').append(data['jumlah_jam_mengajar']+' jam');

                    //insert reviews
                    var review_all = '';
                    for(var aa=0;aa<data['guru_review'].length;aa++){
                        review_murid = 
                        '<div class="col col-xs-12">' +
                        '<div class="tentang-guru-reviewer">' +
                            '<div class="row">' +
                                '<div class="col col-xs-2">';

                        if (data['guru_review'][aa]['murid_gender'] == 1) {
                            review_murid += 
                                    '<img style="width: 72px; float: right;" src="' + base_url + 'images/avatarboy.jpg" />';
                        } else {
                            review_murid += 
                                    '<img style="width: 72px; float: right;" src="' + base_url + 'images/avatargirl.jpg" />';
                        }
                           
                        review_murid +=
                                '</div>' +
                                '<div class="col col-xs-10">' +
                                    '<div style="font-weight: bold;">' +
                                        data['guru_review'][aa]['murid_nama'] +
                                    '</div>' +
                                    '<div style="position: absolute; right: 10px; margin-top: -20px;">';

                        review_murid += '<i class="glyphicon glyphicon-star"></i> ' + data['guru_review'][aa]['feedback_score'];
                        var penjelasan = "tidak ada penjelasan";
                        if(data['guru_review'][aa]['kelas_testimoni'].length>0){
                            penjelasan = data['guru_review'][aa]['kelas_testimoni'];
                        }
                        review_murid +=
                                    '</div>' +
                                    '<div class="col-xs-12" style="font-weight:bold;padding-left:0px;">'+data['guru_review'][aa]['matpel_title']+'</div>'+
                                    '<div>' +
                                        '<p style="color: #000;font-style:normal;text-align:justify">'+penjelasan+'</p>' +
                                    '</div>' +
                                '</div>' +
                            '</div>' +
                        '</div>' +
                        '</div>';

                        review_all += review_murid;

                        //if(aa>3) break;
                    }

                    $('#tentang-guru-review').append(review_all);

                    if (data['guru_review'].length > 0) {


                        $('#tentang-guru-star').append('<strong style="color: #34B9D8;"><i class="glyphicon glyphicon-star"></i>' + data['guru_review_total_score']) + '</strong>';

                        $('#tentang-guru-star').append(
                            ' (' +
                            data['guru_review'].length +
                            ' review)'
                        );
                    } else {

                        $('#tentang-guru-star').append('<em style="color: #BBB;">Belum ada review</em>');

                    }

                }, "json");
    });

    //clean the popup interface when it's closed
    $('#guru-popup-sgr').on('hidden.bs.modal', function (e) {
        $("#tentang-bookmark-btn img").popover('destroy');
        $("#tentang-guru-nama,\
            #tentang-guru-badge,\
            #tentang-guru-verified,\
            #tentang-bookmark-btn,\
            #tentang-guru-tagline,\
            #tentang-guru-pendidikan,\
            #tentang-guru-tentang,\
            #tentang-guru-foto,\
            #tentang-guru-umur,\
            #tentang-guru-jeniskelamin,\
            #tentang-guru-profesi,\
            #tentang-guru-lokasi,\
            #tentang-guru-metode,\
            #tentang-guru-jadwal,\
            #tentang-guru-riwayat,\
            #tentang-guru-tarif,\
            #tentang-guru-lamamengajar,\
            #tentang-guru-kualifikasi,\
            #tentang-guru-pengalaman,\
            #tentang-guru-rating,\
            #tentang-guru-star,\
            #tentang-guru-review,\
            #tentang-guru-jam").empty();
    });

    /* popup confirmation to request guru */
    $('#guru-popup-next-sgr').on('show.bs.modal', function (e) {

        $('#guru-popup-sgr').modal('hide');
        
        var guru_id = $(e.relatedTarget).attr('data-guru-id');
        var guru_name = $(e.relatedTarget).attr('data-guru-nama');
        var guru_gender = $(e.relatedTarget).attr('data-guru-gender');
        var murid_id = $(e.relatedTarget).attr('data-murid-id');

        //insert name 
        $('#calon-guru-nama').append(guru_name);

        //insert photo
        var imgsrc = base_url + "images/pp/" + guru_id + ".jpg";
        if (!fileExists(imgsrc)) {
            if (guru_gender == 1)
                imgsrc = base_url + "images/avatarboy.jpg";
            else 
                imgsrc = base_url + "images/avatargirl.jpg";
        }
        $('#calon-guru-foto').append('<img style="width: 150px; margin: 0px auto; display: block; float: none;" src="'+ imgsrc +'">');
        
        //insert matapelajaran
        $.post(base_url+'guru/get_jenjang_matpel_guru/',{'guru_id' : guru_id},
            function(data){
                var select = "";
                var cur_jenjang = 0;

                for(var i=0;i<data.length;i++){
                    if(i==0){
                        cur_jenjang = data[i]['jenjang_pendidikan_id'];
                    }
                    select += "<option value='"+data[i]['jenjang_pendidikan_id']+"'>"+data[i]['jenjang_pendidikan_title']+"</option>";
                }

                $("#jenjang-id").html(select);

                $.post(base_url+'guru/get_mata_pelajaran/',{'guru_id' : guru_id, 'jenjang_id' : cur_jenjang},
                    function(data){
                        var matpel = "";
                        var tarif = "";
                        for(var i=0;i<data.length;i++){
                            if(i==0){
                                tarif = data[i]['guru_matpel_tarif'].toString().replace(/\B(?=(\d{3})+(?!\d))/g, ".");
                            }
                            matpel += "<option value='"+data[i]['matpel_id']+"'>"+data[i]['matpel_title']+"</option>";
                        }

                        $("#matpel-id").html(matpel);

                        $("#tarif-id").html(tarif);
                    },"json");
            },"json");

        //insert form data to be sent
        $('#calon-guru-id').val(guru_id);
        $('#calon-murid-id').val(murid_id);
    });

    $("#matpel-id").change(function(){
        var matpel_id = $(this).val();
        var guru_id = $("#calon-guru-id").val();

        $.post(base_url+'guru/get_tarif_matpel/',{'guru_id' : guru_id, 'matpel_id' : matpel_id},
            function(data){
                $("#tarif-id").html(data.toString().replace(/\B(?=(\d{3})+(?!\d))/g, "."));
            });
    });

    $("#jenjang-id").change(function(){
        var jenjang_id = $(this).val();
        var guru_id = $("#calon-guru-id").val();
        console.log(jenjang_id);
        $.post(base_url+'guru/get_mata_pelajaran/',{'guru_id' : guru_id, 'jenjang_id' : jenjang_id},
            function(data){
                var matpel = "";
                var tarif = "";
                for(var i=0;i<data.length;i++){
                    if(i==0){
                        tarif = data[i]['guru_matpel_tarif'].toString().replace(/\B(?=(\d{3})+(?!\d))/g, ".");
                    }
                    matpel += "<option value='"+data[i]['matpel_id']+"'>"+data[i]['matpel_title']+"</option>";
                }

                console.log(matpel);

                $("#matpel-id").html(matpel);

                $("#tarif-id").html(tarif);
            },"json");
    });

    $('#guru-popup-next-sgr').on('hidden.bs.modal', function (e) {
        $("#calon-guru-nama, #calon-guru-foto").empty();
        $('#calon-guru-id').val('');
        $('#calon-murid-id').val('');
    });


});


function fileExists(url) {
    var http = new XMLHttpRequest();
    http.open('HEAD', url, false);
    http.send();
    return http.status!=404;
}