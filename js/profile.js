function jadwal_box_click(obj){
    checkbox = $(obj).children('.jadwal-checkbox');
    if(checkbox.is(':checked')){
        checkbox.attr('checked', false);
        $(obj).removeClass('selected');
    }else{
        checkbox.attr('checked', true);
        $(obj).addClass('selected');
    }
}

function update_total_karakter(obj,container_id){
    var total = $(obj).val();
    $("#"+container_id).html(total);
}

function update_matpel(){
    id=$("#select-jenjang").val();
    $.getJSON(base_url+"profile/get_matpel/"+id,function(data){
        html = '';
        $.each(data,function(i,item){
            html+= '<option value="'+item.matpel_id+'">'+item.matpel_title+'</option>';
        });
        $("#select-matpel").html(html);
    })
}

function update_matpel_all(){
    id=$("#select-jenjang").val();
    $.getJSON(base_url+"profile/get_matpel_all/"+id,function(data){
        html = '';
        $.each(data,function(i,item){
            html+= '<option value="'+item.matpel_id+'">'+item.matpel_title+'</option>';
        });
        $("#select-matpel").html(html);
    })
}

$(document).ready(function(){
    $("#Provinsi").change(function(){
        id=$("#Provinsi").val();
        console.log(id);
        if(id>0){
            $.getJSON(base_url+"service/get_lokasi/"+id,function(data){
                html = '';
                $.each(data,function(i,item){
                    html+= '<option value="'+item.lokasi_id+'">'+item.lokasi_title+'</option>';
                });
                $("#lokasi_lainnya").html(html);
            })
        }else{
            $("#lokasi_lainnya").html("<option value=\"-1\" selected>--Pilih Kota--</option>");
        }
    });
    
});