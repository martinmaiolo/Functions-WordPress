// =========================================================================
// ADD FACEBOOK PIXEL TO WP_HEAD
// =========================================================================
function add_facebook_pixel() { ?>
   <!-- Facebook Pixel Code -->
    <script>
      !function(f,b,e,v,n,t,s)
      {if(f.fbq)return;n=f.fbq=function(){n.callMethod?
      n.callMethod.apply(n,arguments):n.queue.push(arguments)};
      if(!f._fbq)f._fbq=n;n.push=n;n.loaded=!0;n.version='2.0';
      n.queue=[];t=b.createElement(e);t.async=!0;
      t.src=v;s=b.getElementsByTagName(e)[0];
      s.parentNode.insertBefore(t,s)}(window, document,'script',
      'https://connect.facebook.net/en_US/fbevents.js');
      fbq('init', 'xxxxxxxxxxx');
      fbq('track', 'PageView');
    </script>
    <noscript><img height="1" width="1" style="display:none"
      src="https://www.facebook.com/tr?id=xxxxxxxxxxx&ev=PageView&noscript=1"
    /></noscript>
    <!-- End Facebook Pixel Code -->
<?php } 
add_action('wp_head', 'add_facebook_pixel');
 
 
// =========================================================================
// ADD FACEBOOK CONVERSION EVENT SNIPPET TO THANK YOU PAGE
// =========================================================================
function conversion_tracking_thank_you_page() { ?>
    <script>
        fbq('track', 'Purchase');
    </script>';
<?php }
add_action( 'woocommerce_thankyou', 'conversion_tracking_thank_you_page' );
