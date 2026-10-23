<?php
defined('BASEPATH') OR exit('No direct script access allowed');

$route['default_controller'] = 'HalamanUtama';
$route['404_override'] = '';
$route['translate_uri_dashes'] = FALSE;

$route['validasi'] = 'HalamanLogin/proses_login';
$route['login'] = 'HalamanLogin';

// Reset Password Routes
$route['reset_password'] = 'ResetPassword';
$route['reset_password/request_reset'] = 'ResetPassword/request_reset';
$route['reset_password/process'] = 'ResetPassword/process';
$route['reset_password/do_reset'] = 'ResetPassword/do_reset';

$route['plh'] = 'HalamanPengaturan/get_plh_data';
$route['user'] = 'HalamanPengaturan/get_user_data';
$route['profil'] = 'HalamanPengaturan/get_profil_data';
$route['app'] = 'HalamanPengaturan/get_app_data';
$route['client'] = 'HalamanPengaturan/get_client_data';
$route['mpp'] = 'HalamanPengaturan/get_mpp_data';

$route['simpan_data_user'] = 'HalamanPengaturan/simpan_data_user';
$route['simpan_data_profil'] = 'HalamanPengaturan/simpan_data_profil';
$route['simpan_plh'] = 'HalamanPengaturan/simpan_plh';
$route['simpan_mpp'] = 'HalamanPengaturan/simpan_mpp';
$route['simpan_config'] = 'HalamanPengaturan/simpan_config';
$route['simpan_pegawai'] = 'HalamanPegawai/simpan';
$route['simpan_jabatan'] = 'HalamanJabatan/simpan';
$route['simpan_pangkat'] = 'HalamanPangkat/simpan';
$route['simpan_user'] = 'HalamanUser/simpan';
$route['simpan_lokasi'] = 'HalamanPengaturan/simpan_lokasi';

$route['pilih_role'] = 'HalamanLogin/pilih_role';
$route['role_plh'] = 'HalamanLogin/role_plh';
$route['role_user'] = 'HalamanLogin/role_user';

$route['daftar_pegawai'] = 'HalamanPegawai';
$route['daftar_jabatan'] = 'HalamanJabatan';
$route['daftar_pangkat'] = 'HalamanPangkat';
$route['daftar_user'] = 'HalamanUser';
$route['ticketing'] = 'HalamanTicketing';
$route['ticketing_form'] = 'HalamanTicketing/form';
$route['simpan_ticket'] = 'HalamanTicketing/simpan_ticket';
$route['ticketing_detail'] = 'HalamanTicketing/detail';
$route['update_tindak_lanjut'] = 'HalamanTicketing/update_tindak_lanjut';
$route['ticketing_export_pdf'] = 'HalamanTicketing/export_pdf';

$route['edit_plh'] = 'HalamanPengaturan/edit_plh';
$route['edit_mpp'] = 'HalamanPengaturan/edit_mpp';

$route['hapus_plh/(:any)'] = 'HalamanPengaturan/hapus_plh/$1';
$route['hapus_plh_js'] = 'HalamanPengaturan/hapus_plh_js';
$route['hapus_jabatan/(:any)'] = 'HalamanJabatan/hapus/$1';
$route['hapus_pangkat/(:any)'] = 'HalamanPangkat/hapus/$1';
$route['reset_perangkat/(:any)'] = 'HalamanUser/reset_perangkat/$1';

$route['keluar'] = 'HalamanLogin/logout';

$route['show_form'] = 'HalamanLogin/show_form';
$route['show_pegawai'] = 'HalamanPegawai/show';
$route['show_jabatan'] = 'HalamanJabatan/show';
$route['show_pangkat'] = 'HalamanPangkat/show';
$route['show_user'] = 'HalamanUser/show';

$route['get_nip'] = 'HalamanUser/get_pegawai_nip';
$route['get_lokasi'] = 'HalamanPengaturan/get_lokasi';

$route['api_update']['patch'] = 'apiclient/pembaharuan_data';
$route['api_audittrail']['post'] = 'apiclient/audittrail';
$route['api_get_seleksi']['get'] = 'apiclient/get_data_seleksi';
$route['api_get_seleksi2']['get'] = 'apiclient/get_data_seleksi2';
$route['api_simpan_data']['post'] = 'apiclient/simpan_data';
$route['api/pegawai/(:num)']['get'] = 'apiclient/get_pegawai_by_id/$1';
$route['api/pegawai']['get'] = 'apiclient/get_all_pegawai';

$route['generate_qrcode'] = 'HalamanPengaturan/generate_qrcode';
$route['generate_qrcode_pegawai'] = 'HalamanPengaturan/generate_qrcode_pegawai';
$route['kartu_pegawai/(:num)'] = 'HalamanKartuPegawai/kartu_pegawai/$1';

$route['kalender_pegawai'] = 'HalamanUtama/kalender_pegawai';
$route['get_cuti_kalender'] = 'HalamanUtama/get_cuti_kalender';

$route['detail_pegawai'] = 'HalamanPegawai/detail_pegawai';