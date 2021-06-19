function sz_image_size_name($sizes) {
   unset( $sizes['thumbnail']);
   unset( $sizes['medium']);
   $myCustomImgsizes = array(        
        'sz-post-desktop' => __('Large Single')
   );
   $newimgsizes = array_merge($sizes, $myCustomImgsizes);
   return $newimgsizes;
}
add_filter('image_size_names_choose', 'sz_image_size_name'); 
