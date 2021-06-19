//Delete orphaned files in wp-content/uploads that are not wordpress attachments
function clean_uploads_from_nonattachments(){
	$uploads_dir = wp_upload_dir(); 
	$search = $uploads_dir['basedir'];
	$replace = $uploads_dir['baseurl'];
	//You may want to take it by bites if your uploads is rather large (over 5 gb for example)
	//$uploads_dir = ( $uploads_dir['basedir'] . '/2015/' ); 
	$uploads_dir = ( $uploads_dir['basedir']); 
	$root = $uploads_dir;
	//Going through directiry recursevely
	$iter = new RecursiveIteratorIterator(
		new RecursiveDirectoryIterator($root, RecursiveDirectoryIterator::SKIP_DOTS),
		RecursiveIteratorIterator::SELF_FIRST,
		RecursiveIteratorIterator::CATCH_GET_CHILD // Ignore "Permission denied"
	);
	foreach ($iter as $fileinfo) {
		//get files only
		if ($fileinfo->isFile()) {	
			$image = $fileinfo->getPathname();
			$image_url = str_replace($search, $replace, $image);
			//Core WP function to retrieve attachment ID by URL
			$attachment_id = attachment_url_to_postid($image_url);
				//Not found - then delete file 
				if (!$attachment_id){
					unlink($image);	
				}
				else {
					//List of found attachments
					echo $attachment_id.': '.$image; 			   
				}	
		}
	}			
}
