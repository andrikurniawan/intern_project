<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/*
| -------------------------------------------------------------------------
| URI ROUTING
| -------------------------------------------------------------------------
| This file lets you re-map URI requests to specific controller functions.
|
| Typically there is a one-to-one relationship between a URL string
| and its corresponding controller class/method. The segments in a
| URL normally follow this pattern:
|
|	example.com/class/method/id/
|
| In some instances, however, you may want to remap this relationship
| so that a different class/function is called than the one
| corresponding to the URL.
|
| Please see the user guide for complete details:
|
|	http://codeigniter.com/user_guide/general/routing.html
|
| -------------------------------------------------------------------------
| RESERVED ROUTES
| -------------------------------------------------------------------------
|
| There area two reserved routes:
|
|	$route['default_controller'] = 'welcome';
|
| This route indicates which controller class should be loaded if the
| URI contains no data. In the above example, the "welcome" class
| would be loaded.
|
|	$route['404_override'] = 'errors/page_missing';
|
| This route will tell the Router what URI segments to use if those provided
| in the URL cannot be matched to a valid route.
|
*/

switch ($_SERVER['HTTP_HOST']) {
    case 'kelas.ruangguru.com':
        $route['default_controller'] = "kelas"; 
        break;
    case 'ruangguru.com':
    case 'www.ruangguru.com':
    default:
        $route['default_controller'] = "main";
        break;
}

// if($_SERVER['HTTP_HOST']!='kelas.ruangguru.com' && 
//		(strpos($_SERVER['REQUEST_URI'],'API')<1 &&
//		strpos($_SERVER['REQUEST_URI'],'payment')<1) ) 
// 	$route['(:any)'] = "main";

// $route['default_controller'] = "main";
$route['4dm1nzqu'] = "admin/user";
$route['4dm1nzqu/login'] = "admin/user/login";
$route['4dm1nzqu/logout'] = "admin/user/logout";
$route['vendor/login'] = "vendor/auth/logreg";
$route['kebijakan-pembayaran'] = "kebijakan_pembayaran";
$route['kebijakan'] = "kebijakan_pembayaran";
$route['konfirmasi'] = "payment/transfer/confirm";
$route['konfirmasi/(:any)'] = "payment/transfer/confirm/$1";
$route['kelas/all'] = "kelas/index/all";
$route['vendor/detail/(:any)'] = "vendor/main/detail/$1";

$route['404_override'] = 'main/not_found';
$route['search/p/([a-z-]+)/c/([a-z-]+)/k/([a-z-]+)/s/([a-z-]+)'] = "cari/index/$1/$2/$3/$4/";
$route['search/p/([a-z-]+)/c/([a-z-]+)/k/([a-z-]+)/s/([a-z-]+)/(:any)'] = "cari/index/$1/$2/$3/$4/$5";
$route['belajar-privat'] = "cari_guru";

//provinsi, kota, jenjang
$route['search/p/(:any)/c/(:any)/k/(:any)'] = "cari/custom_cari_tujuh/$1/$2/$3/";
$route['search/p/(:any)/c/(:any)/k/(:any)/(:any)'] = "cari/custom_cari_tujuh/$1/$2/$3";
//provinsi, kategori, dan matpel
$route['search/p/(:any)/k/(:any)/s/(:any)'] = "cari/custom_cari_lima/$1/$2/$3/";
$route['search/p/(:any)/k/(:any)/s/(:any)/(:any)'] = "cari/custom_cari_lima/$1/$2/$3";
//provinsi, kota, dan matpel
$route['search/p/(:any)/c/(:any)/s/(:any)'] = "cari/custom_cari_enam/$1/$2/$3/";
$route['search/p/(:any)/c/(:any)/s/(:any)/(:any)'] = "cari/custom_cari_enam/$1/$2/$3";
//provinsi dan jenjang
$route['search/p/(:any)/k/(:any)'] = "cari/custom_cari_empat/$1/$2/";
$route['search/p/(:any)/k/(:any)/(:any)'] = "cari/custom_cari_empat/$1/$2/$3";
//provinsi dan matpel
$route['search/p/(:any)/s/(:any)'] = "cari/custom_cari_tiga/$1/$2/";
$route['search/p/(:any)/s/(:any)/(:any)'] = "cari/custom_cari_tiga/$1/$2/$3";
//provinsi dan kota
$route['search/p/(:any)/c/(:any)'] = "cari/custom_cari/$1/$2/";
$route['search/p/(:any)/c/(:any)/(:any)'] = "cari/custom_cari/$1/$2/$3";
//kategori dan subject
$route['search/k/(:any)/s/(:any)'] = "cari/custom_cari_sembilan/$1/$2/";
$route['search/k/(:any)/s/(:any)/(:any)'] = "cari/custom_cari_sembilan/$1/$2/$3";
//provinsi
$route['search/p/(:any)'] = "cari/custom_cari_dua/$1/";
$route['search/p/(:any)/(:any)'] = "cari/custom_cari_dua/$1/$2/";
//kategori
$route['search/k/(:any)'] = "cari/custom_cari_delapan/$1/";
$route['search/k/(:any)/(:any)'] = "cari/custom_cari_delapan/$1/$2";
//subject
$route['search/s/(:any)'] = "cari/custom_cari_sepuluh/$1/";
$route['search/s/(:any)/(:any)'] = "cari/custom_cari_sepuluh/$1/$2";
//form 01 (provinsi/kota)
// $route['search/p/dki-jakarta/c/jakarta-utara'] = "cari/footer_form_satu/1/1/";
// $route['search/p/dki-jakarta/c/jakarta-utara/(:any)'] = "cari/footer_form_satu/1/1/$1";
// $route['search/p/dki-jakarta/c/jakarta-selatan'] = "cari/footer_form_satu/1/2/";
// $route['search/p/dki-jakarta/c/jakarta-selatan/page/(:any)'] = "cari/footer_form_satu/1/2/$1";
// $route['search/p/dki-jakarta/c/jakarta-timur'] = "cari/footer_form_satu/1/3/";
// $route['search/p/dki-jakarta/c/jakarta-timur/page/(:any)'] = "cari/footer_form_satu/1/3/$1";
// $route['search/p/dki-jakarta/c/jakarta-barat'] = "cari/footer_form_satu/1/4/";
// $route['search/p/dki-jakarta/c/jakarta-barat/page/(:any)'] = "cari/footer_form_satu/1/4/$1";
// $route['search/p/dki-jakarta/c/jakarta-pusat'] = "cari/footer_form_satu/1/5/";
// $route['search/p/dki-jakarta/c/jakarta-pusat/page/(:any)'] = "cari/footer_form_satu/1/5/$1";
// $route['search/p/banten/c/tangerang'] = "cari/footer_form_satu/16/8/";
// $route['search/p/banten/c/tangerang/page/(:any)'] = "cari/footer_form_satu/16/8/$1";
// $route['search/p/banten/c/tangerang-selatan'] = "cari/footer_form_satu/16/386/";
// $route['search/p/banten/c/tangerang-selatan/page/(:any)'] = "cari/footer_form_satu/16/386/$1";
// $route['search/p/jawa-barat/c/bekasi'] = "cari/footer_form_satu/12/9/";
// $route['search/p/jawa-barat/c/bekasi/page/(:any)'] = "cari/footer_form_satu/12/9/$1";
// $route['search/p/jawa-barat/c/depok'] = "cari/footer_form_satu/12/9/";
// $route['search/p/jawa-barat/c/depok/page/(:any)'] = "cari/footer_form_satu/12/9/$1";
// $route['search/p/jawa-barat/c/bandung'] = "cari/footer_form_satu/12/21/";
// $route['search/p/jawa-barat/c/bandung/page/(:any)'] = "cari/footer_form_satu/12/21/$1";

//form 02 (provinsi/kota/matpel) - minus jenjang
// $route['search/p/dki-jakarta/c/jakarta-selatan/s/bahasa-inggris'] = "cari/footer_form_dua/1/2/44/";
// $route['search/p/dki-jakarta/c/jakarta-selatan/s/bahasa-inggris/(:any)'] = "cari/footer_form_dua/1/2/44/$1";
// $route['search/p/dki-jakarta/c/jakarta-utara/s/bahasa-inggris'] = "cari/footer_form_dua/1/1/44/";
// $route['search/p/dki-jakarta/c/jakarta-utara/s/bahasa-inggris/(:any)'] = "cari/footer_form_dua/1/1/44/$1";
// $route['search/p/dki-jakarta/c/jakarta-timur/s/bahasa-inggris'] = "cari/footer_form_dua/1/3/44/";
// $route['search/p/dki-jakarta/c/jakarta-timur/s/bahasa-inggris/(:any)'] = "cari/footer_form_dua/1/3/44/$1";
// $route['search/p/dki-jakarta/c/jakarta-barat/s/bahasa-inggris'] = "cari/footer_form_dua/1/4/44/";
// $route['search/p/dki-jakarta/c/jakarta-barat/s/bahasa-inggris/(:any)'] = "cari/footer_form_dua/1/4/44/$1";
// $route['search/p/dki-jakarta/c/jakarta-pusat/s/bahasa-inggris'] = "cari/footer_form_dua/1/5/44/";
// $route['search/p/dki-jakarta/c/jakarta-pusat/s/bahasa-inggris/(:any)'] = "cari/footer_form_dua/1/5/44/$1";

// $route['search/p/dki-jakarta/c/jakarta-selatan/s/matematika'] = "cari/footer_form_dua/1/2/42/";
// $route['search/p/dki-jakarta/c/jakarta-selatan/s/matematika/(:any)'] = "cari/footer_form_dua/1/2/42/$1";
// $route['search/p/dki-jakarta/c/jakarta-utara/s/matematika'] = "cari/footer_form_dua/1/1/42/";
// $route['search/p/dki-jakarta/c/jakarta-utara/s/matematika/(:any)'] = "cari/footer_form_dua/1/1/42/$1";
// $route['search/p/dki-jakarta/c/jakarta-timur/s/matematika'] = "cari/footer_form_dua/1/3/42/";
// $route['search/p/dki-jakarta/c/jakarta-timur/s/matematika/(:any)'] = "cari/footer_form_dua/1/3/42/$1";
// $route['search/p/dki-jakarta/c/jakarta-barat/s/matematika'] = "cari/footer_form_dua/1/4/42/";
// $route['search/p/dki-jakarta/c/jakarta-barat/s/matematika/(:any)'] = "cari/footer_form_dua/1/4/42/$1";
// $route['search/p/dki-jakarta/c/jakarta-pusat/s/matematika'] = "cari/footer_form_dua/1/5/42/";
// $route['search/p/dki-jakarta/c/jakarta-pusat/s/matematika/(:any)'] = "cari/footer_form_dua/1/5/42/$1";
// $route['search/p/banten/c/tangerang/s/matematika'] = "cari/footer_form_satu/16/8/42";
// $route['search/p/banten/c/tangerang/s/matematika/(:any)'] = "cari/footer_form_satu/16/8/42/$1";
// $route['search/p/banten/c/tangerang-selatan/s/matematika'] = "cari/footer_form_satu/16/386/42";
// $route['search/p/banten/c/tangerang-selatan/s/matematika/(:any)'] = "cari/footer_form_satu/16/386/42/$1";
// $route['search/p/jawa-barat/c/bekasi/s/matematika'] = "cari/footer_form_satu/12/9/42";
// $route['search/p/jawa-barat/c/bekasi/s/matematika/(:any)'] = "cari/footer_form_satu/12/9/42/$1";
// $route['search/p/jawa-barat/c/depok/s/matematika'] = "cari/footer_form_satu/12/9/42";
// $route['search/p/jawa-barat/c/depok/s/matematika/(:any)'] = "cari/footer_form_satu/12/9/42/$1";
// $route['search/p/jawa-barat/c/bandung/s/matematika'] = "cari/footer_form_satu/12/21/42";
// $route['search/p/jawa-barat/c/bandung/s/matematika/(:any)'] = "cari/footer_form_satu/12/21/42/$1";

//form 03 (provinsi/matpel)

// $route['search/p/dki-jakarta/s/bahasa-mandarin'] = "cari/footer_form_tiga/1/73/";
// $route['search/p/dki-jakarta/s/bahasa-mandarin/(:any)'] = "cari/footer_form_tiga/1/73/$1";
// $route['search/p/dki-jakarta/s/bahasa-jerman'] = "cari/footer_form_tiga/1/71/";
// $route['search/p/dki-jakarta/s/bahasa-jerman/(:any)'] = "cari/footer_form_tiga/1/71/$1";
// $route['search/p/dki-jakarta/s/bahasa-jepang'] = "cari/footer_form_tiga/1/73/";
// $route['search/p/dki-jakarta/s/bahasa-jepang/(:any)'] = "cari/footer_form_tiga/1/73/$1";
// $route['search/p/dki-jakarta/s/bahasa-spanyol'] = "cari/footer_form_tiga/1/73/";
// $route['search/p/dki-jakarta/s/bahasa-spanyol/(:any)'] = "cari/footer_form_tiga/1/73/$1";
// $route['search/p/dki-jakarta/s/bahasa-perancis'] = "cari/footer_form_tiga/1/72/";
// $route['search/p/dki-jakarta/s/bahasa-perancis/(:any)'] = "cari/footer_form_tiga/1/72/$1";
// $route['search/p/dki-jakarta/s/bahasa-arab'] = "cari/footer_form_tiga/1/50/";
// $route['search/p/dki-jakarta/s/bahasa-arab/(:any)'] = "cari/footer_form_tiga/1/50/$1";
// $route['search/p/dki-jakarta/s/piano'] = "cari/footer_form_tiga/1/104/";
// $route['search/p/dki-jakarta/s/piano/(:any)'] = "cari/footer_form_tiga/1/104/$1";
// $route['search/p/dki-jakarta/s/biola'] = "cari/footer_form_tiga/1/107/";
// $route['search/p/dki-jakarta/s/biola/(:any)'] = "cari/footer_form_tiga/1/107/$1";
// $route['search/p/dki-jakarta/s/gitar'] = "cari/footer_form_tiga/1/119/";
// $route['search/p/dki-jakarta/s/gitar/(:any)'] = "cari/footer_form_tiga/1/119/$1";
// $route['search/p/dki-jakarta/s/programming'] = "cari/footer_form_tiga/1/297/";
// $route['search/p/dki-jakarta/s/programming/(:any)'] = "cari/footer_form_tiga/1/297/$1";
// $route['search/p/dki-jakarta/s/web-design'] = "cari/footer_form_tiga/1/132/";
// $route['search/p/dki-jakarta/s/web-design/(:any)'] = "cari/footer_form_tiga/1/132/$1";
// $route['search/p/dki-jakarta/s/photoshop'] = "cari/footer_form_tiga/1/125/";
// $route['search/p/dki-jakarta/s/photoshop/(:any)'] = "cari/footer_form_tiga/1/125/$1";
// $route['search/p/dki-jakarta/s/renang'] = "cari/footer_form_tiga/1/143/";
// $route['search/p/dki-jakarta/s/renang/(:any)'] = "cari/footer_form_tiga/1/143/$1";
// $route['search/p/dki-jakarta/s/basket'] = "cari/footer_form_tiga/1/171/";
// $route['search/p/dki-jakarta/s/basket/(:any)'] = "cari/footer_form_tiga/1/171/$1";
// $route['search/p/dki-jakarta/s/yoga'] = "cari/footer_form_tiga/1/146/";
// $route['search/p/dki-jakarta/s/yoga/(:any)'] = "cari/footer_form_tiga/1/146/$1";
// $route['search/p/dki-jakarta/s/mengaji'] = "cari/footer_form_tiga/1/193/";
// $route['search/p/dki-jakarta/s/mengaji/(:any)'] = "cari/footer_form_tiga/1/193/$1";


//form 04 (matpel)
// $route['search/s/toefl'] = "cari/footer_form_empat/135/";
// $route['search/s/toefl/(:any)'] = "cari/footer_form_empat/135/$1";
// $route['search/s/ielts'] = "cari/footer_form_empat/137/";
// $route['search/s/ielts/(:any)'] = "cari/footer_form_empat/137/$1";
// $route['search/s/snmptn'] = "cari/footer_form_empat/48/";
// $route['search/s/snmptn/(:any)'] = "cari/footer_form_empat/48/$1";
// $route['search/s/bahasa-indonesia-penutur-asing'] = "cari/footer_form_empat/234/";
// $route['search/s/bahasa-indonesia-penutur-asing/(:any)'] = "cari/footer_form_empat/234/$1";

//form 05 (jenjang)
// $route['search/k/a-level'] = "cari/footer_form_lima/6/";
// $route['search/k/a-level/(:any)'] = "cari/footer_form_lima/6/$1";

// $route['cari-guru/bahasa-inggris-jakarta'] = "cari/eng_jkt";
// $route['cari-guru/matematika-jakarta'] = "cari/mtk_jkt";
// $route['cari-guru/fisika-jakarta'] = "cari/fisika_jkt";
// $route['cari-guru/kimia-jakarta'] = "cari/kimia_jkt";
// $route['cari-guru/bahasa-jepang-jakarta'] = "cari/jpn_jkt";
// $route['cari-guru/bahasa-inggris-surabaya'] = "cari/eng_sby";
// $route['cari-guru/fisika-surabaya'] = "cari/fisika_sby";
// $route['cari-guru/kimia-surabaya'] = "cari/kimia_sby";
// $route['cari-guru/matematika-surabaya'] = "cari/mtk_sby";
// $route['cari-guru/ekonomi-surabaya'] = "cari/eko_sby";
// $route['cari-guru/bahasa-inggris-bandung'] = "cari/eng_bdg";
// $route['cari-guru/matematika-bandung'] = "cari/mtk_bdg";
// $route['cari-guru/fisika-bandung'] = "cari/fisika_bdg";
// $route['cari-guru/kimia-bandung'] = "cari/kimia_bdg";
// $route['cari-guru/akuntansi-bandung'] = "cari/akuntansi_bdg";
// $route['openhouse'] = "event/index";
// $route['openhouse'] = "event";
// $route['openhouse/verifikasi'] = "event/verifikasi";

// $route['kebijakan-pembayaran'] = "tentang/kebijakan_pembayaran";
// $route['kebijakan-privasi'] = "kebijakan_privasi";
// $route['kontak-kami'] = "kontak_kami";
// $route['ruanggurulab'] = "tentang/ruanggurulab";
// $route['komunitas'] = "tentang/komunitas";
// $route['syarat-ketentuan'] = "syarat_ketentuan";
// $route['syarat-ketentuan/murid'] = "syarat_ketentuan/murid";
// $route['syarat-ketentuan/guru'] = "syarat_ketentuan/guru";

// $route['cari/dki-jakarta/jakarta-selatan']	= "search/p/dki-jakarta/c/jakarta-selatan";
// $route['cari/dki-jakarta/jakarta-timur']	= "search/p/dki-jakarta/c/jakarta-timur";
// $route['cari/dki-jakarta/jakarta-pusat']	= "search/p/dki-jakarta/c/jakarta-pusat";
// $route['cari/dki-jakarta/jakarta-barat']	= "search/p/dki-jakarta/c/jakarta-barat";
// $route['cari/dki-jakarta/jakarta-utara']	= "search/p/dki-jakarta/c/jakarta-utara";
// $route['cari/banten/tangerang']				= "search/p/banten/c/tangerang";
// $route['cari/banten/tangerang-selatan']		= "search/p/banten/c/tangerang-selatan";
// $route['cari/jawa-barat/bekasi']			= "search/p/jawa-barat/c/bekasi";
// $route['cari/jawa-barat/depok']				= "search/p/jawa-barat/c/depok";
// $route['cari/jawa-barat/bandung']			= "search/p/jawa-barat/c/bandung";

// // Semua guru bahasa
// $route['cari/dki-jakarta/jakarta-selatan/bahasa-inggris']	= "search/p/dki-jakarta/c/jakarta-selatan/s/bahasa-inggris";
// $route['cari/dki-jakarta/jakarta-timur/bahasa-inggris']		= "search/p/dki-jakarta/c/jakarta-timur/s/bahasa-inggris";
// $route['cari/dki-jakarta/jakarta-pusat/bahasa-inggris']		= "search/p/dki-jakarta/c/jakarta-pusat/s/bahasa-inggris";
// $route['cari/dki-jakarta/jakarta-barat/bahasa-inggris']		= "search/p/dki-jakarta/c/jakarta-barat/s/bahasa-inggris";
// $route['cari/dki-jakarta/jakarta-utara/bahasa-inggris']		= "search/p/dki-jakarta/c/jakarta-utara/s/bahasa-inggris";
// $route['cari/dki-jakarta/bahasa-mandarin']					= "search/p/jakarta/s/bahasa-mandarin";
// $route['cari/dki-jakarta/bahasa-jerman']					= "search/p/jakarta/s/bahasa-jerman";
// $route['cari/dki-jakarta/bahasa-jepang']					= "search/p/jakarta/s/bahasa-jepang";
// $route['cari/dki-jakarta/bahasa-spanyol']					= "search/p/jakarta/s/bahasa-spanyol";
// $route['cari/dki-jakarta/bahasa-perancis']					= "search/p/jakarta/s/bahasa-perancis";
// $route['cari/dki-jakarta/bahasa-arab']						= "search/p/jakarta/s/bahasa-arab";

// // Semua guru matematika
// $route['cari/dki-jakarta/jakarta-selatan/matematika']	= "search/p/dki-jakarta/c/jakarta-selatan/s/matematika";
// $route['cari/dki-jakarta/jakarta-timur/matematika']		= "search/p/dki-jakarta/c/jakarta-timur/s/matematika";
// $route['cari/dki-jakarta/jakarta-pusat/matematika']		= "search/p/dki-jakarta/c/jakarta-pusat/s/matematika";
// $route['cari/dki-jakarta/jakarta-barat/matematika']		= "search/p/dki-jakarta/c/jakarta-barat/s/matematika";
// $route['cari/dki-jakarta/jakarta-utara/matematika']		= "search/p/dki-jakarta/c/jakarta-utara/s/matematika";
// $route['cari/banten/tangerang/matematika']				= "search/p/banten/c/tangerang/s/matematika";
// $route['cari/banten/tangerang-selatan/matematika']		= "search/p/banten/c/tangerang-selatan/s/matematika";
// $route['cari/jawa-barat/bekasi/matematika']				= "search/p/jawa-barat/c/bekasi/s/matematika";
// $route['cari/jawa-barat/depok/matematika']				= "search/p/jawa-barat/c/depok/s/matematika";
// $route['cari/jawa-barat/bandung/matematika']			= "search/p/jawa-barat/c/bandung/s/matematika";

// $route['cari/dki-jakarta/piano']				= "search/p/dki-jakarta/s/piano";
// $route['cari/dki-jakarta/biola']				= "search/p/dki-jakarta/s/biola";
// $route['cari/dki-jakarta/gitar']				= "search/p/dki-jakarta/s/gitar";
// $route['cari/dki-jakarta/programming']			= "search/p/dki-jakarta/s/programming";
// $route['cari/dki-jakarta/web-design']			= "search/p/dki-jakarta/s/web-desing";
// $route['cari/dki-jakarta/photoshop']			= "search/p/dki-jakarta/s/photoshop";
// $route['cari/dki-jakarta/renang']				= "search/p/dki-jakarta/s/renang";
// $route['cari/dki-jakarta/basket']				= "search/p/dki-jakarta/s/basket";
// $route['cari/dki-jakarta/yoga']					= "search/p/dki-jakarta/s/yoga";
// $route['cari/dki-jakarta/mengaji']				= "search/p/dki-jakarta/s/mengaji";

// $route['cari/toefl']							= "search/s/toefl";
// $route['cari/ielts']							= "search/s/ielts";
// $route['cari/un-sd']							= "search/k/sd";
// $route['cari/un-smp']							= "search/k/smp";
// $route['cari/un-sma']							= "search/k/sma";
// $route['cari/snmptn']							= "search/s/snmptn";
// $route['cari/sbmptn']							= "search/s/sbmptn";
// $route['cari/simak-ui']							= "search/k/universitas";
// $route['cari/a-level']							= "search/k/a-level";
// $route['cari/bahasa-indonesia-penutur-asing']	= "search/s/bahasa-indonesia-penutur-asing";


// Semua guru privat

// $route['kebijakan-pembayaran'] = "tentang/kebijakan_pembayaran";
// $route['kebijakan-privasi'] = "kebijakan_privasi";
// $route['kontak-kami'] = "kontak_kami";
// $route['ruanggurulab'] = "tentang/ruanggurulab";
// $route['komunitas'] = "tentang/komunitas";
// $route['syarat-ketentuan'] = "syarat_ketentuan";
// $route['syarat-ketentuan/murid'] = "syarat_ketentuan/murid";
// $route['syarat-ketentuan/guru'] = "syarat_ketentuan/guru";

// $route['cari/dki-jakarta/jakarta-selatan']	= "search/p/dki-jakarta/c/jakarta-selatan";
// $route['cari/dki-jakarta/jakarta-timur']	= "search/p/dki-jakarta/c/jakarta-timur";
// $route['cari/dki-jakarta/jakarta-pusat']	= "search/p/dki-jakarta/c/jakarta-pusat";
// $route['cari/dki-jakarta/jakarta-barat']	= "search/p/dki-jakarta/c/jakarta-barat";
// $route['cari/dki-jakarta/jakarta-utara']	= "search/p/dki-jakarta/c/jakarta-utara";
// $route['cari/banten/tangerang']				= "search/p/banten/c/tangerang";
// $route['cari/banten/tangerang-selatan']		= "search/p/banten/c/tangerang-selatan";
// $route['cari/jawa-barat/bekasi']			= "search/p/jawa-barat/c/bekasi";
// $route['cari/jawa-barat/depok']				= "search/p/jawa-barat/c/depok";
// $route['cari/jawa-barat/bandung']			= "search/p/jawa-barat/c/bandung";

// // Semua guru bahasa
// $route['cari/dki-jakarta/jakarta-selatan/bahasa-inggris']	= "search/p/dki-jakarta/c/jakarta-selatan/s/bahasa-inggris";
// $route['cari/dki-jakarta/jakarta-timur/bahasa-inggris']		= "search/p/dki-jakarta/c/jakarta-timur/s/bahasa-inggris";
// $route['cari/dki-jakarta/jakarta-pusat/bahasa-inggris']		= "search/p/dki-jakarta/c/jakarta-pusat/s/bahasa-inggris";
// $route['cari/dki-jakarta/jakarta-barat/bahasa-inggris']		= "search/p/dki-jakarta/c/jakarta-barat/s/bahasa-inggris";
// $route['cari/dki-jakarta/jakarta-utara/bahasa-inggris']		= "search/p/dki-jakarta/c/jakarta-utara/s/bahasa-inggris";
// $route['cari/dki-jakarta/bahasa-mandarin']					= "search/p/jakarta/s/bahasa-mandarin";
// $route['cari/dki-jakarta/bahasa-jerman']					= "search/p/jakarta/s/bahasa-jerman";
// $route['cari/dki-jakarta/bahasa-jepang']					= "search/p/jakarta/s/bahasa-jepang";
// $route['cari/dki-jakarta/bahasa-spanyol']					= "search/p/jakarta/s/bahasa-spanyol";
// $route['cari/dki-jakarta/bahasa-perancis']					= "search/p/jakarta/s/bahasa-perancis";
// $route['cari/dki-jakarta/bahasa-arab']						= "search/p/jakarta/s/bahasa-arab";

// // Semua guru matematika
// $route['cari/dki-jakarta/jakarta-selatan/matematika']	= "search/p/dki-jakarta/c/jakarta-selatan/s/matematika";
// $route['cari/dki-jakarta/jakarta-timur/matematika']		= "search/p/dki-jakarta/c/jakarta-timur/s/matematika";
// $route['cari/dki-jakarta/jakarta-pusat/matematika']		= "search/p/dki-jakarta/c/jakarta-pusat/s/matematika";
// $route['cari/dki-jakarta/jakarta-barat/matematika']		= "search/p/dki-jakarta/c/jakarta-barat/s/matematika";
// $route['cari/dki-jakarta/jakarta-utara/matematika']		= "search/p/dki-jakarta/c/jakarta-utara/s/matematika";
// $route['cari/banten/tangerang/matematika']				= "search/p/banten/c/tangerang/s/matematika";
// $route['cari/banten/tangerang-selatan/matematika']		= "search/p/banten/c/tangerang-selatan/s/matematika";
// $route['cari/jawa-barat/bekasi/matematika']				= "search/p/jawa-barat/c/bekasi/s/matematika";
// $route['cari/jawa-barat/depok/matematika']				= "search/p/jawa-barat/c/depok/s/matematika";
// $route['cari/jawa-barat/bandung/matematika']			= "search/p/jawa-barat/c/bandung/s/matematika";

// $route['cari/dki-jakarta/piano']				= "search/p/dki-jakarta/s/piano";
// $route['cari/dki-jakarta/biola']				= "search/p/dki-jakarta/s/biola";
// $route['cari/dki-jakarta/gitar']				= "search/p/dki-jakarta/s/gitar";
// $route['cari/dki-jakarta/programming']			= "search/p/dki-jakarta/s/programming";
// $route['cari/dki-jakarta/web-design']			= "search/p/dki-jakarta/s/web-desing";
// $route['cari/dki-jakarta/photoshop']			= "search/p/dki-jakarta/s/photoshop";
// $route['cari/dki-jakarta/renang']				= "search/p/dki-jakarta/s/renang";
// $route['cari/dki-jakarta/basket']				= "search/p/dki-jakarta/s/basket";
// $route['cari/dki-jakarta/yoga']					= "search/p/dki-jakarta/s/yoga";
// $route['cari/dki-jakarta/mengaji']				= "search/p/dki-jakarta/s/mengaji";

// $route['cari/toefl']							= "search/s/toefl";
// $route['cari/ielts']							= "search/s/ielts";
// $route['cari/un-sd']							= "search/k/sd";
// $route['cari/un-smp']							= "search/k/smp";
// $route['cari/un-sma']							= "search/k/sma";
// $route['cari/snmptn']							= "search/s/snmptn";
// $route['cari/sbmptn']							= "search/s/sbmptn";
// $route['cari/simak-ui']							= "search/k/universitas";
// $route['cari/a-level']							= "search/k/a-level";
// $route['cari/bahasa-indonesia-penutur-asing']	= "search/s/bahasa-indonesia-penutur-asing";

// Sitemap
$route['sitemap.xml']							= "sitemap";
$route['favicon.ico']							= "favicon";
$route['kebijakan-pembayaran'] = "tentang/kebijakan_pembayaran";
$route['kebijakan-privasi'] = "kebijakan_privasi";
$route['kontak-kami'] = "kontak_kami";
$route['ruanggurulab'] = "tentang/ruanggurulab";
$route['komunitas'] = "tentang/komunitas";
$route['apprentice'] = "main/internship";
$route['syarat-ketentuan'] = "syarat_ketentuan";
$route['syarat-ketentuan/murid'] = "syarat_ketentuan/murid";
$route['syarat-ketentuan/guru'] = "syarat_ketentuan/guru";
/*
$route['cari-guru/bahasa-inggris-jakarta'] = "cari/eng_jkt";
$route['cari-guru/matematika-jakarta'] = "cari/mtk_jkt";
$route['cari-guru/fisika-jakarta'] = "cari/fisika_jkt";
$route['cari-guru/kimia-jakarta'] = "cari/kimia_jkt";
$route['cari-guru/bahasa-jepang-jakarta'] = "cari/jpn_jkt";
$route['cari-guru/bahasa-inggris-surabaya'] = "cari/eng_sby";
$route['cari-guru/fisika-surabaya'] = "cari/fisika_sby";
$route['cari-guru/kimia-surabaya'] = "cari/kimia_sby";
$route['cari-guru/matematika-surabaya'] = "cari/mtk_sby";
$route['cari-guru/ekonomi-surabaya'] = "cari/eko_sby";
$route['cari-guru/bahasa-inggris-bandung'] = "cari/eng_bdg";
$route['cari-guru/matematika-bandung'] = "cari/mtk_bdg";
$route['cari-guru/fisika-bandung'] = "cari/fisika_bdg";
$route['cari-guru/kimia-bandung'] = "cari/kimia_bdg";
$route['cari-guru/akuntansi-bandung'] = "cari/akuntansi_bdg";
// */

/* End of file routes.php */
/* Location: ./application/config/routes.php */