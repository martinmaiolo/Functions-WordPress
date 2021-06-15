<?php
/**
 * output pixel facebook
 * EDIT "XXXXXXXXXXXXXXX" WITH FB ID'S
 */
add_action( 'wp_head', 'jmr_head_fbpixel', 10 );

if ( ! function_exists( 'jmr_head_fbpixel' ) ) {
	function jmr_head_fbpixel() {
	echo "\n";
	echo "\n";
	echo "<!-- This Facebook Pixel Code is developed by 1024Mbits.com - https://wwww.1024mbits.com -->
<script>
!function(f,b,e,v,n,t,s){if(f.fbq)return;n=f.fbq=function(){n.callMethod?n.callMethod.apply(n,arguments):n.queue.push(arguments)};
if(!f._fbq)f._fbq=n;n.push=n;n.loaded=!0;n.version='2.0';
n.queue=[];t=b.createElement(e);t.async=!0;
t.src=v;s=b.getElementsByTagName(e)[0];
s.parentNode.insertBefore(t,s)}(window,document,'script','https://connect.facebook.net/en_US/fbevents.js');
fbq('init', 'XXXXXXXXXXXXXXX');
fbq('track', 'PageView');
</script>
<noscript><img height=\"1\" width=\"1\" src=\"https://www.facebook.com/tr?id=XXXXXXXXXXXXXXX&ev=PageView&noscript=1\"/></noscript>
<!-- End Facebook Pixel Code -->" . "\n";
	echo "\n";
	}
}
