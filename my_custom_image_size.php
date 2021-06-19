function sz_posts_image_sizes() {
  add_image_size('sz-post-desktop', 740); //for regular images in posts: 740px wide, height accordingly
  add_image_size('sz-post-desktop-preview', 227, 200, true); //for post thumbnails preview for archives: 227px wide and 200px tall, hard crop mode
  add_image_size('sz-post-mobile', 345); 
  add_image_size('sz-post-mobile-preview', 350, 242 , true); 

  //to remove default sizes 'thumbnail' and 'medium'
  remove_image_size('thumbnail');
  remove_image_size('medium');
}
add_action( 'after_setup_theme', 'sz_posts_image_sizes' );
