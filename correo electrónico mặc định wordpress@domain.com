add_filter('wp_mail_from', 'new_mail_from');
add_filter('wp_mail_from_name', 'new_mail_from_name');
 
function new_mail_from($old) {
return 'info@nhadathoangha.vn';
}
function new_mail_from_name($old) {
return 'Nhà đất Hoàng Hà';
}
