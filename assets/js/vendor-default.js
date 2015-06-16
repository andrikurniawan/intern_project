/**
 * Created by AndrewMalachel on 10/8/14.
 */
function set_loc(data) {
	$('#class_maps').val(data);
	var dt = data.split('||');
	$('#img_preview').attr('src','https://maps.googleapis.com/maps/api/staticmap?size=250x180&maptype=roadmap&markers=color:red%7C'+dt[0]);
}
var loc_window = null;
$(document).ready(function(){
	$('#btn_search_maps').click(function(e){
		e.preventDefault();
		if(loc_window == null || loc_window.closed) {
			loc_window = window.open(base_url+"vendor/kelas/get_address_geo/?address="+encodeURIComponent($('#class_map_search').val()), "_blank", "height=520, width=960, status=no, toolbar=no, menubar=no, location=no,addressbar=no");
		} else {
			loc_window.focus()
		}
		return false;
	});
});
