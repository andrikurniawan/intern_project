function update_provinsi(){
    id=$("#ddProvinsi").val();
    if(id>0){
        $("#lokasi10").attr('checked', true);
        $.getJSON(base_url+"service/get_lokasi/"+id,function(data){
            html = '';
            $.each(data,function(i,item){
                html+= '<option value="'+item.lokasi_id+'">'+item.lokasi_title+'</option>';
            });
            $("#lokasi_lainnya").html(html);
        });
    }else{
        $("#lokasi_lainnya").html("<option value=\"-1\" selected>--Pilih Kota--</option>");
        $("#lokasi10").attr('checked', false);
    }
}