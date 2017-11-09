<?php 
/*
Plugin Name: Light Gallery
Plugin URI : http://tariqwebsolutions.com/lightgallery
Version: 1.1
Author: Tariq
Author URI: http://tariqwebsolutions.com
Description: Beautiful gallery plugin for WordPress. It is a light weight and powerful gallery plugin. 
*/
defined( 'ABSPATH' ) or die( 'No script kiddies please!' );
// Plugins CSS file include
function ltgallery_css(){
	wp_enqueue_style('lt-fancycss', plugins_url("css/jquery.fancybox.css", __FILE__), array(), false);
}
add_action('wp_enqueue_scripts','ltgallery_css');
// Plugis scripts files
function ltgallery_js() {
    wp_enqueue_script( 'lt-galleryjs', plugins_url( '/js/jquery.fancybox.pack.js', __FILE__ ), array(), false, true);
    wp_enqueue_script( 'lt-csomjs', plugins_url( '/js/jcscustom.js', __FILE__ ), array(), false, true);
}
add_action('wp_enqueue_scripts','ltgallery_js');
// Custom post for Carousel
function ltgallery_cpost(){
	register_post_type('ltcgalpost', array(
		'labels' => array(
			'name' => 'Gallery',
			'singular_name' => 'Gallery',
			'add_new ' => 'Add New image',
			'edit_item ' => 'Edit Gallery',
			'new_item' => 'New Image'
		),
		'menu_icon' =>'dashicons-format-gallery',
		'supports' => array('title','thumbnail','revisions'),
		'public' => true,
		'has_archive' => true
	));
}
add_action('init','ltgallery_cpost');
// Gallery shortcode [lt-gallery toptext="" title=""]
function ltgallery_srtcode( $atts ){
ob_start();
	extract( shortcode_atts(array(
		'toptext' => 'Our',
		'title' => 'Dishes'
	), $atts) );
?>
<div class="gallery">
	<div class="gdiv">
		<h3>Our</h3>
		<h1>Dishes</h1>
	</div>
	<?php $ltgaleryc = new WP_Query(array(
		'post_type' => 'ltcgalpost'	
	)); ?>
	<?php while( $ltgaleryc->have_posts() ) : $ltgaleryc->the_post(); ?>
	<div class="gdiv">
		<a class="fancybox" rel="group" title="<?php the_title(); ?>" href="<?php the_post_thumbnail_url(); ?>">
		<?php the_post_thumbnail(); ?>
		</a>
	</div>
	<?php endwhile; ?>
</div>
<?php
$ltgalp = ob_get_clean();
return $ltgalp;
}
add_shortcode('lt-gallery', 'ltgallery_srtcode');