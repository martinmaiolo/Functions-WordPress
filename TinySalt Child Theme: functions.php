<?php
	add_action('wp_enqueue_scripts', 'tinysalt_child_enqueue_scripts');
	function tinysalt_child_enqueue_scripts(){
		wp_enqueue_style( 'tinysalt-child-theme-style', get_stylesheet_uri(), array( 'tinysalt-theme-style' ) );
	}

	add_filter( 'tinysalt_front_inline_styles_handler', 'tinysalt_child_inline_style_handler', 999 );
	function tinysalt_child_inline_style_handler( $handler ) {
		return 'tinysalt-child-theme-style';
	}
	
	add_filter( 'searchwp_live_search_query_args', 'fix_searchwp_query_args' );
	function fix_searchwp_query_args( $args ) {
		$args['post_status'] = 'inherit,publish';
		return $args;
	}
	
	//Schema Functions
	
//	add_filter( 'wpseo_schema_article', 'change_article_to_social_posting' );

	/**
	 * Changes @type of Article Schema data.
	 *
	 * @param array $data Schema.org Article data array.
	 *
	 * @return array Schema.org Article data array.
	 */
//	function change_article_to_social_posting( $data ) {
//	    $data['@type'] = 'Article';
//	
//	    return $data;
//	}

/**
* Modificaciones a menu de mi cuenta de woocommerce
*/

 function my_account_menu_order() {
 	$menuOrder = array(
 		'dashboard'          => __( 'Dashboard', 'woocommerce' ),
 		'escritorio'          => __( 'Mis Cursos', 'woocommerce' ),
 		'orders'             => __( 'Mis Pedidos', 'woocommerce' ),
 		'lista-de-deseos'       => __( 'Mis Favoritos', 'woocommerce' ),
 		'edit-address'       => __( 'Mis Direcciones', 'woocommerce' ), 
 		'edit-account'    	=> __( 'Detalles de la cuenta', 'woocommerce' ),
 		'customer-logout'    => __( 'Logout', 'woocommerce' ),
 	);
 	return $menuOrder;
 }
 add_filter ( 'woocommerce_account_menu_items', 'my_account_menu_order' );
 
 /* Unificando contenido de pestañas */
 
// Primero ocultamos la pestaña a juntar (edit-address en este ejemplo) aunque podriamos haberla comentado arriba, pero asi es mas bonito :P
 
add_filter( 'woocommerce_account_menu_items', 'sacar_direcciones_woocommerce', 999 );
  
function sacar_direcciones_woocommerce( $items ) {
unset($items['edit-address']);
return $items;
}
 
// Luego mostramos el contenido de las direcciones en otra pestaña ——> la de editar cuenta
 
add_action( 'woocommerce_account_edit-account_endpoint', 'woocommerce_account_edit_address' );


/** Modificacion de Slug Estructural de Mis cursos **/
/*
function tutor_parent_course_tag( $default_uri, $native_slug, $post ) {
	if ( in_array( $post->post_type, array( 'lesson', 'tutor_quiz', 'tutor_assignments' ) ) ) {
		$post_id   = $post->ID;
		$course_id = null;
		if ( $post->post_type === 'lesson' ) {
			$course_id = get_post_meta( $post_id, '_tutor_course_id_for_lesson', true );
		} else if ( $post->post_type === 'tutor_quiz' ) {
			$course_id = get_post($post->post_parent)->post_parent;
		} else if ( $post->post_type === 'tutor_assignments' ) {
			$course_id = get_post_meta( $post_id, '_tutor_course_id_for_assignments', true );
		}
		$course_uri = '';
		if ( $course_id ) {
			$course = get_post( $course_id );
			if ( $course ) {
				$course_uri = get_relative_permalink( get_permalink( $course_id ) );
			}
		}
		$default_uri = str_replace( '%parent_course%', $course_uri, $default_uri );

		return $default_uri;
	}

	return $default_uri;
}

add_filter( 'permalink_manager_filter_default_post_uri', 'tutor_parent_course_tag', 10, 3 );

function wpccps_th_add_custom_rewrite_rule() {
	$post_types = get_post_types( array( '_builtin' => false, 'publicly_queryable' => true, 'show_ui' => true ) );
	foreach ($post_types as $post_type => $slug) {
		if(!empty(  $slug) ){
			$args = get_post_type_object($post_type);
			$args->rewrite["slug"] = $slug;
			register_post_type($args->name, $args);
		}
	}

} // end wpccps_th_add_custom_rewrite_rule
add_action('init', 'wpccps_th_add_custom_rewrite_rule');


*/

add_filter('tutor_courses_base_slug', 'change_tutor_course_slug');
/**
 * @param $slug
 * @return string
 */
if ( ! function_exists('change_tutor_course_slug')){
    function change_tutor_course_slug($slug){
        $slug = 'cursos';
        return $slug;
    }
}
/*
add_filter('tutor_lesson_base_slug', 'change_tutor_lesson_slug');

if ( ! function_exists('change_tutor_lesson_slug')){
    function change_tutor_lesson_slug($slug){
        $slug = 'lecciones';
        return $slug;
    }
}
*/


/** End **/
 
/*Custom Shortcode para filtros*/

function shortcode_filtros_custom($args, $content = null) {

	extract(shortcode_atts(array(
     "tags" => 'bebidas,bizcochos,bombones y trufas,brownie,bundt cakes,cereales,crepes y similares,cupcakes,flanes,galletas,gelatinas,gofres,gominolas,hojaldres,mermeladas,mousses,muffins,mug cakes,panes,pasteles y tartas,postres en vasitos,rosquillas y donuts,sorbetes y helados',
     "cocina" => 'Española,Italiana,Francesa,Americana,Inglesa',
     "ocacion" => 'Cumpleaños,Fin de año,Halloween,Navidad,San Juan,San Valentín,Semana Santa,Verano',
     "ingredientes" => 'aguacate,albaricoque,almendras,arándanos,arroz,avellanas,avena,boniato,cabello de ángel,cacahuetes,café,calabacín,calabaza,castañas,cerezas,chía,chocolate,chocolate blanco,claras de huevo,coco,crema pastelera,espelta,frambuesas,fresas,huevos,jengibre,kiwi,leche,lima,limón,mandarina,mango,manzana,melocotón,melón,naranja,nutella,pera ,piña,pistachos,plátano,queso,té verde,turrón,zanahoria',
     "order" => 'DESC',
    ), $args));
	
    $html = '
			<div class="recipe-filters">
				<div class="filter-wrapper filter-category" data-filter="category">
					<button class="recipe-filter-button"><span class="filter-text" data-default="Categorías">Categorías</span>
			            <span class="remove-button"></span></button>
					<div class="filter-content">
						<span class="filter-content-item" data-term-id="264">
			            Deporte y actividad física                                
						</span>                               
					</div>
				</div>
			</div>';
	$html .='<form action="'. site_url() .'/wp-admin/admin-ajax.php" method="POST" id="filter">';
	$tax = 'post_tag';
	$terms = get_terms( $tax );
	$count = count( $terms );
	if (isset($tags)) {
		$array_buscados = explode(',', $tags);
	}
	//TAGS
	if ( $count > 0 ):
//	if( $terms = wp_get_post_terms(  'post_tag' )) : 
			$html .= '<select name="tagsfilter"><option value="">Select Categoria…</option>';
			foreach ( $terms as $term ) :
				if (in_array(strtolower($term->name), array_map('strtolower', $array_buscados))) {
					$html .='<option value="' . $term->term_id . '">' . ucwords($term->name) . '</option>';
				}
				// ID of the category as the value of an option
			endforeach;
			$html .= '</select><br>';
	endif;
	//COCINA
	if (isset($cocina)) {
		$array_buscados = explode(',', $cocina);
	}
	if ( $count > 0 ):
//	if( $terms = wp_get_post_terms(  'post_tag' )) : 
			$html .= '<select name="cocinafilter"><option value="">Select Cocina</option>';
			foreach ( $terms as $term ) :
				if (in_array(strtolower($term->name), array_map('strtolower', $array_buscados))) {
					$html .='<option value="' . $term->term_id . '">' . ucwords($term->name) . '</option>';
				}
				// ID of the category as the value of an option
			endforeach;
			$html .= '</select><br>';
	endif;
	//OCACION
	if (isset($ocacion)) {
		$array_buscados = explode(',', $ocacion);
	}
	if ( $count > 0 ):
//	if( $terms = wp_get_post_terms(  'post_tag' )) : 
			$html .= '<select name="ocacionfilter"><option value="">Select Ocación</option>';
			foreach ( $terms as $term ) :
				if (in_array(strtolower($term->name), array_map('strtolower', $array_buscados))) {
					$html .='<option value="' . $term->term_id . '">' . ucwords($term->name) . '</option>';
				}
				// ID of the category as the value of an option
			endforeach;
			$html .= '</select><br>';
	endif;
	//INGREDIENTES
	if (isset($ingredientes)) {
		$array_buscados = explode(',', $ingredientes);
	}
	if ( $count > 0 ):
//	if( $terms = wp_get_post_terms(  'post_tag' )) : 
			$html .= '<select name="ingredientefilter"><option value="">Select Ingrediente</option>';
			foreach ( $terms as $term ) :
				if (in_array(strtolower($term->name), array_map('strtolower', $array_buscados))) {
					$html .='<option value="' . $term->term_id . '">' . ucwords($term->name) . '</option>';
				}
				// ID of the category as the value of an option
			endforeach;
			$html .= '</select><br>';
	endif;
	$html .= '
		
		<input type="hidden" name="action" value="myfilter">
		<input type="hidden" name="date" value="'.$order.'">
		</form>
		<div id="response"></div>
	';
// 	<button>Mandale Gas a los filtros turro</button>
//	<label>
//		<input type="radio" name="date" value="ASC" /> Date: Ascending
//	</label>
//	<label>
//		<input type="radio" name="date" value="DESC" selected="selected" /> Date: Descending
//	</label>

	$html .= 
	'<script type="text/javascript">
		jQuery(document).on("ready", function(){
			jQuery(function($){
				$("#filter").on("change", function(){
					jQuery(this).trigger("submit");
				});
				$("#filter").submit(function(){
					var filter = $("#filter");
					$.ajax({
						url:filter.attr("action"),
						data:filter.serialize(), // form data
						type:filter.attr("method"), // POST
						beforeSend:function(xhr){
							filter.find("button").text("Processing…"); // changing the button label
						},
						success:function(data){
							//filter.find("button").text("Mandale Gas a los filtros turro"); // changing the button label back
							$("#response").html(data); // insert data
						}
					});
					return false;
				});
			});
		});
	</script>';

    	
    return $html;
}
add_shortcode('filtros_custom', 'shortcode_filtros_custom');


add_action('wp_ajax_myfilter', 'custom_filter_function'); // wp_ajax_{ACTION HERE} 
add_action('wp_ajax_nopriv_myfilter', 'custom_filter_function');
 
function custom_filter_function(){
	$args = array(
		'orderby' => 'date', // we will sort posts by date
		'order'	=> $_POST['date'] // ASC or DESC
	);
 
	// for taxonomies / categories
	$tagsfilter = $_POST['tagsfilter'] ? $_POST['tagsfilter'].',' : '';
	$cocinafilter = $_POST['cocinafilter'] ? $_POST['cocinafilter'].',' : '';
	$ocacionfilter = $_POST['ocacionfilter'] ? $_POST['ocacionfilter'].',' : '';
	$ingredientefilter = $_POST['ingredientefilter'] ? $_POST['ingredientefilter'].',' : '';
	
	$preTerms =  $tagsfilter.$cocinafilter.$ocacionfilter.$ingredientefilter;
	$terms = explode(',', $preTerms);
	array_pop( $terms );
	$termQuery = array();
	foreach ($terms as $term) {
		$termQuery[] = array(
				'taxonomy' => 'post_tag',
				'field' => 'id',
				'terms' => $term
			);
	}
	if( isset( $terms ) && !empty($terms) )
		$args['tax_query'] = array(
			$termQuery,
			'relation' => 'AND',
		);
//		print_r('<pre>');
//	print_r($args['tax_query']);
//	print_r('</pre>');
 	/*
	// create $args['meta_query'] array if one of the following fields is filled
	if( isset( $_POST['price_min'] ) && $_POST['price_min'] || isset( $_POST['price_max'] ) && $_POST['price_max'] || isset( $_POST['featured_image'] ) && $_POST['featured_image'] == 'on' )
		$args['meta_query'] = array( 'relation'=>'AND' ); // AND means that all conditions of meta_query should be true
 
	// if both minimum price and maximum price are specified we will use BETWEEN comparison
	if( isset( $_POST['price_min'] ) && $_POST['price_min'] && isset( $_POST['price_max'] ) && $_POST['price_max'] ) {
		$args['meta_query'][] = array(
			'key' => '_price',
			'value' => array( $_POST['price_min'], $_POST['price_max'] ),
			'type' => 'numeric',
			'compare' => 'between'
		);
	} else {
		// if only min price is set
		if( isset( $_POST['price_min'] ) && $_POST['price_min'] )
			$args['meta_query'][] = array(
				'key' => '_price',
				'value' => $_POST['price_min'],
				'type' => 'numeric',
				'compare' => '>'
			);
 
		// if only max price is set
		if( isset( $_POST['price_max'] ) && $_POST['price_max'] )
			$args['meta_query'][] = array(
				'key' => '_price',
				'value' => $_POST['price_max'],
				'type' => 'numeric',
				'compare' => '<'
			);
	}
 
 
	// if post thumbnail is set
	if( isset( $_POST['featured_image'] ) && $_POST['featured_image'] == 'on' )
		$args['meta_query'][] = array(
			'key' => '_thumbnail_id',
			'compare' => 'EXISTS'
		);
	// if you want to use multiple checkboxed, just duplicate the above 5 lines for each checkbox
 	*/
	$query = new WP_Query( $args );
 
	if( $query->have_posts() ) :
		while( $query->have_posts() ): $query->the_post();
//			$class = get_post_class();
			echo '<article ';
			post_class();
			echo '>';
			echo '<h2>'. $query->post->post_title . '</h2>';
			echo '</article>';
			echo '<div class="featured-img">';
			the_post_thumbnail();
		   /* tinysalt_list_featured_image( 'background' );
		    tinysalt_list_date( $metas );
		    tinysalt_list_format_label();
		    tinysalt_list_like( $metas );*/
		    echo '</div>';
//			echo $html;
/*
			print_r('<pre>');
			print_r($query->post);
			print_r('</pre>');
*/			
			
			/*	
			$style = tinysalt_get_post_list_prop( 'style', 'normal' );
			$metas = tinysalt_get_post_list_prop( 'post_meta', array() ); ?>
			
		
		<article <?php post_class(); ?>><?php
		    if ( 'style-overlay' === $style ) :
		        if ( has_post_thumbnail() ) : ?>
		            <div class="featured-img"><?php tinysalt_list_featured_image( 'background' ); ?></div><?php
		        else : ?>
		            <div class="post-bg"></div><?php
		        endif;
		        tinysalt_list_date( $metas );
		        tinysalt_list_format_label();
		        tinysalt_list_like( $metas ); ?>
		
		        <div class="post-content">
		            <header class="post-header">
		                <h2 class="post-title">
		                    <a href="<?php the_permalink(); ?>"><?php the_title(); ?></a>
		                </h2>
		                <?php tinysalt_list_author( $metas ); ?>
		    			<?php tinysalt_list_category( $metas ); ?>
		                <?php tinysalt_list_comment( $metas ); ?>
		            </header>
		            <?php tinysalt_list_excerpt( $metas ); ?>
		        </div><?php
		    else :
		        if ( has_post_thumbnail() ) : ?>
		         	<div class="featured-img"><?php
		                tinysalt_list_featured_image( 'background' );
		                tinysalt_list_date( $metas );
		                tinysalt_list_format_label();
		                tinysalt_list_like( $metas ); ?>
		        	</div><?php
		        endif; ?>
		    	<div class="post-content">
		    		<header class="post-header">
		    			<h2 class="post-title">
		    				<a href="<?php the_permalink(); ?>"><?php the_title(); ?></a>
		    			</h2>
		                <?php tinysalt_list_author( $metas ); ?>
		    			<?php tinysalt_list_category( $metas ); ?>
		                <?php tinysalt_list_comment( $metas ); ?>
		    		</header><?php
		            tinysalt_list_excerpt( $metas );
		            if ( in_array( 'read-more', $metas ) ) : ?>
		    		      <footer class="post-footer"><?php tinysalt_list_more_btn( $metas ); ?></footer><?php
		            endif; ?>
		    	</div><?php
		    endif; ?>
		</article>
		*/
			
			
		endwhile;
		wp_reset_postdata();
	else :
		echo 'No Encontre nada :P ';
	endif;
 
	die();
}
                            

/*END*/ 


function shortcode_search_custom() {
	
	if ( tinysalt_module_enabled( 'tinysalt_site_header_show_mobile_search_icon' ) ) : 
		$html =  '<div class="site-header-search" style="right: unset; top: 3px;">';
		$html .= '<img src="/wp-content/uploads/2021/05/lupa.svg" alt="" width="24" height="24" />';
//		$html .= '<span class="toggle-button"><span class="screen-reader-text">';
//		$html .= '<svg width="24px" height="24px" viewBox="0 0 24 24">
//    <path d="M12,10.5 C13.6568542,10.5 15,9.15685425 15,7.5 C15,5.84314575 13.6568542,4.5 12,4.5 C10.3431458,4.5 9,5.84314575 9,7.5 C9,9.15685425 10.3431458,10.5 12,10.5 Z M12,12.5 C9.23857625,12.5 7,10.2614237 7,7.5 C7,4.73857625 9.23857625,2.5 12,2.5 C14.7614237,2.5 17,4.73857625 17,7.5 C17,10.2614237 14.7614237,12.5 12,12.5 Z M5,21.5 L3,21.5 C3,17.6340068 7.02943725,14.5 12,14.5 C16.9705627,14.5 21,17.6340068 21,21.5 L19,21.5 C19,18.8641562 15.9603707,16.5 12,16.5 C8.03962935,16.5 5,18.8641562 5,21.5 Z"></path>
//</svg>';
//		$html .= esc_html_e( 'Search', 'tinysalt' );
		
//		$html .= '</span></span>';
		$html .= '</div>';
		return $html;
	endif;
	
}

add_shortcode('search_custom', 'shortcode_search_custom');

function shortcode_menu_custom() {
//	$nav_before = '<div class="header-section menu">';
//    $nav_after = '</div>'; 
//    return tinysalt_primary_nav( array(), $nav_before, $nav_after ); 
	$html = '<button id="menu-toggle" class="menu-toggle" style="padding-top: 7px;"><img src="/wp-content/uploads/2021/05/hamburguesa.svg" alt="" width="24" height="24" /></button>';
    return $html;
}
add_shortcode('menu_custom', 'shortcode_menu_custom');


//SVG SUPORT
function add_file_types_to_uploads($file_types){
$new_filetypes = array();
$new_filetypes['svg'] = 'image/svg+xml';
$file_types = array_merge($file_types, $new_filetypes );
return $file_types;
}
add_filter('upload_mimes', 'add_file_types_to_uploads');


//shortcode for trusted sourced
function shortcode_trusted_source($args, $content = null) {

	extract(shortcode_atts(array(
     "link" => 'https://www.who.int/en/news-room/fact-sheets/detail/diabetes',
     "source" => 'World Health Organization',
     "text" => 'World Health Organization (WHO)',
     "description" => 'Highly respected international organization',
    ), $args));
	
    $html = '';
    $html = $link;
    
    $html = 	'
    <span class="popover__wrapper">
  		
  		<a href="'.$link.'" target="_blank" rel="noopener noreferrer" >
  			<span class="popover__title">'.$text.'</span>
  			<span class="trusted-source-after"><sup><i class="fas fa-check-circle green"></i></sup></span>
  		</a>
  		<div class="popover__content">
    		<div class="modal__area">
    			<span><i class="fas fa-check-circle green"></i> '.__("Trusted Source").'</span>
    			<h3 class="h3modal">'.$source.'</h3>
      			<p>
      				<svg xmlns="http://www.w3.org/2000/svg" width="12" height="12" fill="cyan" viewBox="0, 0, 40, 40"><path d="M13.3 37.41a2.5 2.5 0 0 1-2-.94L2.08 24.92A2.509 2.509 0 0 1 6 21.79l7.32 9.13 21.14-26.4a2.5 2.5 0 0 1 3.9 3.13L15.25 36.48a2.503 2.503 0 0 1-1.95.93z"></path></svg>
      				<span>'.$description.'.</span>
      			</p>
      			<p><a href="'.$link.'" target="_blank" rel="noopener noreferrer">'.__("Go to source").'</a></p>
      			
    		</div>
  		</div>
	</span>
		';
    
    /*
    <hl-trusted-source source="World Health Organization" rationale="Highly respected international organization" class="css-12hs4c5">
		<a href="https://www.who.int/en/news-room/fact-sheets/detail/diabetes" target="_blank" rel="noopener noreferrer" class="content-link css-5r4717">World Health Organization (WHO)<span class="css-1mdvjzu icon-hl-trusted-source-after"><span class="sro">Trusted Source</span></span></a><span>
		<div class="css-ynuhve">
			<div class="css-1lantv0">
				<div>
					<p class="css-655jmp"><a class="css-h7hhg7" data-event="|Top Sources|Process Link Click" href="/process"><span class="css-1u6l441 icon-hl-trusted-source"></span>Trusted Source</a></p>
					
					<h3 class="css-3di48">World Health Organization</h3>
					
					<ul class="css-rfilvb">
						<li class="css-423s2e">
							<svg xmlns="http://www.w3.org/2000/svg" width="12" height="12" fill="cyan" viewBox="0, 0, 40, 40">
								<path d="M13.3 37.41a2.5 2.5 0 0 1-2-.94L2.08 24.92A2.509 2.509 0 0 1 6 21.79l7.32 9.13 21.14-26.4a2.5 2.5 0 0 1 3.9 3.13L15.25 36.48a2.503 2.503 0 0 1-1.95.93z"></path>
							</svg> Highly respected international organization
						</li>
					</ul>
					
					<p class="css-6uhyyn"><a class="css-5r4717" target="_blank" rel="noopener noreferrer" data-event="|Top Sources|External Link Click" href="https://www.who.int/en/news-room/fact-sheets/detail/diabetes">Go to source</a></p>
				</div>
			</div>
		</div>
	</span>
	</hl-trusted-source>
	*/
    	
    return $html;
}
add_shortcode('trusted', 'shortcode_trusted_source');
