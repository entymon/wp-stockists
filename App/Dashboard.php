<?php

namespace Entymon\Stockists\App;

class Dashboard
{

	public function init()
	{
		add_action( 'init', [$this, 'jollyStockistsPost'], 0);
		add_action('init', [$this, 'jollyStockistCountry'], 0);
		add_action( 'init', [$this, 'jollyStockistRegion'], 0);
	}

	/**
	 * Custom post stockist
	 */
	public function jollyStockistsPost()
	{

		$labels = array(
			'name'                  => _x( 'Stockist', 'Post Type General Name', EN_STOCKIST_LANGUAGE_NAMESPACE ),
			'singular_name'         => _x( 'Stockist', 'Post Type Singular Name', EN_STOCKIST_LANGUAGE_NAMESPACE ),
			'menu_name'             => __( 'Stockists', EN_STOCKIST_LANGUAGE_NAMESPACE ),
			'name_admin_bar'        => __( 'Stockists', EN_STOCKIST_LANGUAGE_NAMESPACE ),
			'archives'              => __( 'Stockist Archives', EN_STOCKIST_LANGUAGE_NAMESPACE ),
			'attributes'            => __( 'Stockist Attributes', EN_STOCKIST_LANGUAGE_NAMESPACE ),
			'parent_item_colon'     => __( 'Parent Stockist:', EN_STOCKIST_LANGUAGE_NAMESPACE ),
			'all_items'             => __( 'All Stockists', EN_STOCKIST_LANGUAGE_NAMESPACE ),
			'add_new_item'          => __( 'Add New Stockist', EN_STOCKIST_LANGUAGE_NAMESPACE ),
			'add_new'               => __( 'Add New', EN_STOCKIST_LANGUAGE_NAMESPACE ),
			'new_item'              => __( 'New Stockist', EN_STOCKIST_LANGUAGE_NAMESPACE ),
			'edit_item'             => __( 'Edit Stockist', EN_STOCKIST_LANGUAGE_NAMESPACE ),
			'update_item'           => __( 'Update Stockist', EN_STOCKIST_LANGUAGE_NAMESPACE ),
			'view_item'             => __( 'View Stockist', EN_STOCKIST_LANGUAGE_NAMESPACE ),
			'view_items'            => __( 'View Stockists', EN_STOCKIST_LANGUAGE_NAMESPACE ),
			'search_items'          => __( 'Search Stockist', EN_STOCKIST_LANGUAGE_NAMESPACE ),
			'not_found'             => __( 'Not found', EN_STOCKIST_LANGUAGE_NAMESPACE ),
			'not_found_in_trash'    => __( 'Not found in Trash', EN_STOCKIST_LANGUAGE_NAMESPACE ),
			'featured_image'        => __( 'Featured Image', EN_STOCKIST_LANGUAGE_NAMESPACE ),
			'set_featured_image'    => __( 'Set featured image', EN_STOCKIST_LANGUAGE_NAMESPACE ),
			'remove_featured_image' => __( 'Remove featured image', EN_STOCKIST_LANGUAGE_NAMESPACE ),
			'use_featured_image'    => __( 'Use as featured image', EN_STOCKIST_LANGUAGE_NAMESPACE ),
			'insert_into_item'      => __( 'Insert into stockist', EN_STOCKIST_LANGUAGE_NAMESPACE ),
			'uploaded_to_this_item' => __( 'Uploaded to this item', EN_STOCKIST_LANGUAGE_NAMESPACE ),
			'items_list'            => __( 'Stockists list', EN_STOCKIST_LANGUAGE_NAMESPACE ),
			'items_list_navigation' => __( 'Stockists list navigation', EN_STOCKIST_LANGUAGE_NAMESPACE ),
			'filter_items_list'     => __( 'Filter stockists list', EN_STOCKIST_LANGUAGE_NAMESPACE ),
		);
		$args = array(
			'label'                 => __( 'Stockist', EN_STOCKIST_LANGUAGE_NAMESPACE ),
			'description'           => __( 'Stockist post for website', EN_STOCKIST_LANGUAGE_NAMESPACE ),
			'labels'                => $labels,
			'supports'              => array( 'title', 'thumbnail', 'author', 'page-attributes' ),
			'taxonomies'            => array(EN_STOCKIST_COUNTRY_TAXONOMY, EN_STOCKIST_REGION_TAXONOMY),
			'hierarchical'          => false,
			'public'                => true,
			'show_ui'               => true,
			'show_in_menu'          => true,
			'menu_position'         => 5,
			'menu_icon'             => 'dashicons-admin-site',
			'show_in_admin_bar'     => true,
			'show_in_nav_menus'     => true,
			'can_export'            => true,
			'has_archive'           => true,
			'exclude_from_search'   => false,
			'publicly_queryable'    => true,
			'capability_type'       => 'page',
			'show_in_rest'          => true,
//			'rest_base'             => 'rest',
//			'rest_controller_class' => 'add-later',
		);
		register_post_type( EN_STOCKIST_POST, $args );
	}

	/**
	 * Custom taxonomy - stockist country
	 */
	public function jollyStockistCountry() {

		$labels = array(
			'name'                       => _x( 'Countries', 'Taxonomy General Name', EN_STOCKIST_LANGUAGE_NAMESPACE ),
			'singular_name'              => _x( 'Country', 'Taxonomy Singular Name', EN_STOCKIST_LANGUAGE_NAMESPACE ),
			'menu_name'                  => __( 'Countries', EN_STOCKIST_LANGUAGE_NAMESPACE ),
			'all_items'                  => __( 'All Countries', EN_STOCKIST_LANGUAGE_NAMESPACE ),
			'parent_item'                => __( 'Parent Country', EN_STOCKIST_LANGUAGE_NAMESPACE ),
			'parent_item_colon'          => __( 'Parent Country:', EN_STOCKIST_LANGUAGE_NAMESPACE ),
			'new_item_name'              => __( 'New Country Name', EN_STOCKIST_LANGUAGE_NAMESPACE ),
			'add_new_item'               => __( 'Add Country Item', EN_STOCKIST_LANGUAGE_NAMESPACE ),
			'edit_item'                  => __( 'Edit Country', EN_STOCKIST_LANGUAGE_NAMESPACE ),
			'update_item'                => __( 'Update Country', EN_STOCKIST_LANGUAGE_NAMESPACE ),
			'view_item'                  => __( 'View Country', EN_STOCKIST_LANGUAGE_NAMESPACE ),
			'separate_items_with_commas' => __( 'Separate countries with commas', EN_STOCKIST_LANGUAGE_NAMESPACE ),
			'add_or_remove_items'        => __( 'Add or remove countries', EN_STOCKIST_LANGUAGE_NAMESPACE ),
			'choose_from_most_used'      => __( 'Choose from the most used', EN_STOCKIST_LANGUAGE_NAMESPACE ),
			'popular_items'              => __( 'Popular countries', EN_STOCKIST_LANGUAGE_NAMESPACE ),
			'search_items'               => __( 'Search countries', EN_STOCKIST_LANGUAGE_NAMESPACE ),
			'not_found'                  => __( 'Not Found', EN_STOCKIST_LANGUAGE_NAMESPACE ),
			'no_terms'                   => __( 'No countries', EN_STOCKIST_LANGUAGE_NAMESPACE ),
			'items_list'                 => __( 'Countries list', EN_STOCKIST_LANGUAGE_NAMESPACE ),
			'items_list_navigation'      => __( 'Countries list navigation', EN_STOCKIST_LANGUAGE_NAMESPACE ),
		);
		$args = array(
			'labels'                     => $labels,
			'hierarchical'               => true,
			'public'                     => true,
			'show_ui'                    => true,
			'show_admin_column'          => true,
			'show_in_nav_menus'          => true,
			'show_tagcloud'              => true,
		);
		if (!is_taxonomy(EN_STOCKIST_COUNTRY_TAXONOMY)) {
			register_taxonomy(EN_STOCKIST_COUNTRY_TAXONOMY, array(EN_STOCKIST_POST), $args);
		}
	}

	/**
	 * Custom taxonomy - stockist region
	 */
	public function jollyStockistRegion() {

		$labels = array(
			'name'                       => _x( 'Regions', 'Taxonomy General Name', EN_STOCKIST_LANGUAGE_NAMESPACE ),
			'singular_name'              => _x( 'Country', 'Taxonomy Singular Name', EN_STOCKIST_LANGUAGE_NAMESPACE ),
			'menu_name'                  => __( 'Regions', EN_STOCKIST_LANGUAGE_NAMESPACE ),
			'all_items'                  => __( 'All Regions', EN_STOCKIST_LANGUAGE_NAMESPACE ),
			'parent_item'                => __( 'Parent Region', EN_STOCKIST_LANGUAGE_NAMESPACE ),
			'parent_item_colon'          => __( 'Parent Region:', EN_STOCKIST_LANGUAGE_NAMESPACE ),
			'new_item_name'              => __( 'New Region Name', EN_STOCKIST_LANGUAGE_NAMESPACE ),
			'add_new_item'               => __( 'Add Region Item', EN_STOCKIST_LANGUAGE_NAMESPACE ),
			'edit_item'                  => __( 'Edit Region', EN_STOCKIST_LANGUAGE_NAMESPACE ),
			'update_item'                => __( 'Update Region', EN_STOCKIST_LANGUAGE_NAMESPACE ),
			'view_item'                  => __( 'View Region', EN_STOCKIST_LANGUAGE_NAMESPACE ),
			'separate_items_with_commas' => __( 'Separate regions with commas', EN_STOCKIST_LANGUAGE_NAMESPACE ),
			'add_or_remove_items'        => __( 'Add or remove regions', EN_STOCKIST_LANGUAGE_NAMESPACE ),
			'choose_from_most_used'      => __( 'Choose from the most used', EN_STOCKIST_LANGUAGE_NAMESPACE ),
			'popular_items'              => __( 'Popular regions', EN_STOCKIST_LANGUAGE_NAMESPACE ),
			'search_items'               => __( 'Search regions', EN_STOCKIST_LANGUAGE_NAMESPACE ),
			'not_found'                  => __( 'Not Found', EN_STOCKIST_LANGUAGE_NAMESPACE ),
			'no_terms'                   => __( 'No regions', EN_STOCKIST_LANGUAGE_NAMESPACE ),
			'items_list'                 => __( 'Regions list', EN_STOCKIST_LANGUAGE_NAMESPACE ),
			'items_list_navigation'      => __( 'Regions list navigation', EN_STOCKIST_LANGUAGE_NAMESPACE ),
		);
		$args = array(
			'labels'                     => $labels,
			'hierarchical'               => true,
			'public'                     => true,
			'show_ui'                    => true,
			'show_admin_column'          => true,
			'show_in_nav_menus'          => true,
			'show_tagcloud'              => true,
		);
		if (!is_taxonomy(EN_STOCKIST_REGION_TAXONOMY)) {
			register_taxonomy(EN_STOCKIST_REGION_TAXONOMY, array(EN_STOCKIST_POST), $args);
		}
	}
}