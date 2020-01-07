<?php
/*
 * Plugin Name: HD Piano Plugin
 * Plugin URI: https://www.marcswebstudio.com
 * Description: This is the hypothetical assignment for HD Piano.
 * Author: Marc R. Miller
 * Version: 1.0
*/

// Creating a lesson custom post type
function lesson_custom_post_type() {
	$labels = array(
		'name'                => __( 'Lesson' ),
		'singular_name'       => __( 'Lesson'),
		'menu_name'           => __( 'Lesson'),
		'parent_item_colon'   => __( 'Parent Lesson'),
		'all_items'           => __( 'All Lessons'),
		'view_item'           => __( 'View Lesson'),
		'add_new_item'        => __( 'Add New Lesson'),
		'add_new'             => __( 'Add New'),
		'edit_item'           => __( 'Edit Lesson'),
		'update_item'         => __( 'Update Lesson'),
		'search_items'        => __( 'Search Lesson'),
		'not_found'           => __( 'Not Found'),
		'not_found_in_trash'  => __( 'Not found in Trash')
	);
	$args = array(
		'label'               => __( 'lesson'),
		'description'         => __( 'HD Piano Lesson'),
		'labels'              => $labels,
		'supports'            => array( 'title', 'editor', 'excerpt', 'author', 'thumbnail', 'revisions', 'custom-fields'),
		'public'              => true,
		'hierarchical'        => false,
		'show_ui'             => true,
		'show_in_menu'        => true,
		'show_in_nav_menus'   => true,
		'show_in_admin_bar'   => true,
		'has_archive'         => true,
		'can_export'          => true,
		'exclude_from_search' => false,
	        'yarpp_support'       => true,
		'taxonomies' 	      => array('post_tag'),
		'publicly_queryable'  => true,
		'capability_type'     => 'page'
);
	register_post_type( 'lesson', $args );
}
add_action( 'init', 'lesson_custom_post_type', 0 );


// Taxonomy for custom post type
add_action( 'init', 'create_genre_custom_taxonomy', 0 );
 
//Create a custom taxonomy and call it 'genre'
function create_genre_custom_taxonomy() {
 
  $labels = array(
    'name' => _x( 'Genre', 'taxonomy general name' ),
    'singular_name' => _x( 'Genre', 'taxonomy singular name' ),
    'search_items' =>  __( 'Search Genre' ),
    'all_items' => __( 'All Genres' ),
    'parent_item' => __( 'Parent Genre' ),
    'parent_item_colon' => __( 'Parent Genre:' ),
    'edit_item' => __( 'Edit Genre' ), 
    'update_item' => __( 'Update Genre' ),
    'add_new_item' => __( 'Add New Genre' ),
    'new_item_name' => __( 'New Genre Name' ),
    'menu_name' => __( 'Genre' ),
  ); 	
 
  register_taxonomy('genre',array('lesson'), array(
    'hierarchical' => true,
    'labels' => $labels,
    'show_ui' => true,
    'show_admin_column' => true,
    'query_var' => true,
    'rewrite' => array( 'slug' => 'genre' ),
  ));
}

if ( ! function_exists('lessons_shortcode') ) {

    function lesson_shortcode() {
    	$args   =   array(
                	'post_type'         =>  'lesson',
                	'post_status'       =>  'publish',
                	'order' => 'ASC',
                	'posts_per_page' => 10,
    	            );
    	            
        $postslist = new WP_Query( $args );
        global $post;

        if ( $postslist->have_posts() ) :
        $events   .= '<div class="lesson-list">';
		
            while ( $postslist->have_posts() ) : $postslist->the_post();         
                $events    .= '<div class="lessons">';
                $events    .= '<a href="'. get_permalink() .'">'. get_the_title() .'</a>';
                $events    .= '</div>';            
            endwhile;
            wp_reset_postdata();
            $events  .= '</div>';			
        endif;    
        return $events;
    }
    add_shortcode( 'lesson', 'lesson_shortcode' );
}