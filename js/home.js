function usernameClick(obj){
    if($(obj).val()=='masukkan email'){
        $(obj).val("");
    }
    if($(obj).val()=='masukkan nama'){
        $(obj).val("");
    }
}

function update_provinsi(){
    id=$("#ddProvinsi").val();
    sesi_kota=$("#sesi_kota").val();
    if(id==0){
	   if(id == sesi_kota){
        html = '<option value="0" selected>Pilih Semua</option>';
	   } else {
	   html = '<option value="0">Pilih Semua</option>';
	   }
        $("#ddLokasi").html(html);
    }else{
        $.getJSON(base_url+"service/get_lokasi/"+id,function(data){
	   if(sesi_kota == 0){
		html = '<option value="0" selected>Pilih Semua</option>';
	   }else{
		html = '<option value="0">Pilih Semua</option>';
	   }
        $.each(data,function(i,item){
		if(item.lokasi_id == sesi_kota){
            html+= '<option value="'+item.lokasi_id+'" selected>'+item.lokasi_title+'</option>';
		}else{
		  html+= '<option value="'+item.lokasi_id+'">'+item.lokasi_title+'</option>';
		}
        });
        $("#ddLokasi").html(html);
        })
    }
}

function update_lokasi(){
    id=$("#ddLokasi").val();
    if(id<=9){
        $("#jenjangP .9").show();
        $("#jenjangP .4").hide();
    }else if(id==21){
        $("#jenjangP .4").show();
        $("#jenjangP .9").hide();
    }else{
        $("#jenjangP .4").hide();
        $("#jenjangP .9").hide();
    }
}

function update_matpel(){
    id=$("#select-jenjang").val();
    sesi_matpel=$("#sesi_matpel").val();
     if(id==0){
	   if(id == sesi_matpel){
        html = '<option value="0" selected>Pilih Semua</option>';
	   } else {
	   html = '<option value="0">Pilih Semua</option>';
	   }
        $("#select-matpel").html(html);
    }else{
    $.getJSON(base_url+"cari_guru/get_matpel/"+id,function(data){
	if(sesi_matpel == 0){
        html = '<option value="0" selected>Pilih Semua</option>';
	}else{
	   html = '<option value="0">Pilih Semua</option>';
	}
        $.each(data,function(i,item){
		if(item.matpel_id == sesi_matpel){
            html+= '<option value="'+item.matpel_id+'" selected>'+item.matpel_title+'</option>';
		} else {
		  html+= '<option value="'+item.matpel_id+'">'+item.matpel_title+'</option>';
		}
        });
        $("#select-matpel").html(html);
    })
    }
}


function TwitterDateConverter(time){
    var date = new Date(time),
    diff = (((new Date()).getTime() - date.getTime()) / 1000),
    day_diff = Math.floor(diff / 86400);
 
    if ( isNaN(day_diff) || day_diff < 0 )
        return;
 
    return day_diff == 0 && (
        diff < 60 && "just now" ||
        diff < 120 && "1 minute ago" ||
        diff < 3600 && Math.floor( diff / 60 ) + " minutes ago" ||
        diff < 7200 && "1 hour ago" ||
        diff < 86400 && Math.floor( diff / 3600 ) + " hours ago") ||
    day_diff == 1 && "Yesterday" ||
    day_diff < 7 && day_diff + " days ago" ||
    day_diff < 31 && Math.ceil( day_diff / 7 ) + " weeks ago" ||
    day_diff > 31 && Math.ceil( day_diff / 30 ) + " month ago";
}

function close_overlay(){
    $("#default-overlay").hide();
    $("#overlayed-content").hide();
}

//add javascript
function update_provinsi_instan(){
    id=$("#provinsi").val();
    $.getJSON(base_url+"service/get_lokasi/"+id,function(data){
        html = '';
        $.each(data,function(i,item){
            html+= '<option value="'+item.lokasi_id+'">'+item.lokasi_title+'</option>';
        });
        $("#lokasi").html(html);
    })
}


function update_matpel_instan(){
    id=$("#select-kategori").val();
    $.getJSON(base_url+"cari_guru/get_matpel/"+id,function(data){
        html = '';
        $.each(data,function(i,item){
            html+= '<option value="'+item.matpel_id+'">'+item.matpel_title+'</option>';
        });
        $("#select-mp").html(html);
    })
}

