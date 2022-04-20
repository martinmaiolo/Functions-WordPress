/* MULTIPLE REDIRECTION FORM */
add_action( 'wp_footer', 'mycustom_wp_footer' );
function mycustom_wp_footer() {
?>

<script>
document.addEventListener( 'wpcf7submit', function( event ) {
  var lpLocation =  document.getElementById("deals").value;
  if (lpLocation == "opcion1") {
    location = 'https://google.com/';
  } else if (lpLocation == "opcion2") {
    location = 'https://facebook.com/';
  }
}, false )
</script>

<?php
}



/* NO SITIO MOVIL */

var viewMode = getCookie("view-mode");
if(viewMode == "desktop"){
viewport.setAttribute('content', 'width=1024');
}else if (viewMode == "mobile"){
viewport.setAttribute('content', 'width=device-width,initial-scale=1.0,maximum-scale=1.0,user-scalable=no');
}
Prueba ese pedazo de javascript, debería funcionar aunque WordPress es bastante rígido con ese tipo de cosas
