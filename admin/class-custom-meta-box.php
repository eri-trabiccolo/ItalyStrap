<?php namespace ItalyStrap\Admin;
/**
 * Initialize custom meta box build with CMB2
 *
 * @package ItalyStrap\Admin
 * @version 1.0
 * @since   4.0.0
 */

/**
 * Add some custom meta box in many areas of WordPress
 */
class Custom_Meta_Box {

	/**
	 * CMB prefix
	 *
	 * @var string
	 */
	private $prefix = '';

	/**
	 * Init the constructor
	 */
	function __construct() {

		/**
		 * Start with an underscore to hide fields from custom fields list
		 *
		 * @var string
		 */
		$this->prefix = '_italystrap_';

	}

	/**
	 * Hook in and add a demo metabox. Can only happen on the 'cmb2_admin_init' or 'cmb2_init' hook.
	 */
	public function register_post_metabox() {

		/**
		 * Sample metabox to demonstrate each field type included
		 */
		$cmb = new_cmb2_box(
			array(
				'id'            => $this->prefix . 'metabox',
				'title'         => __( 'Advanced settings', 'ItalyStrap' ),
				'object_types'  => array( 'product', 'post' ),
				'context'    => 'side',
				'priority'   => 'low',
			)
		);

		$cmb->add_field(
			array(
				'name'		=> __( 'Layout options', 'ItalyStrap' ),
				'desc'		=> __( 'Advance layout setting for this page/post', 'ItalyStrap' ),
				'id'		=> 'layout_options',
				'type'		=> 'multicheck',
				'options'	=> array(
					'title'			=> __( 'Hide title', 'ItalyStrap' ),
					'meta'			=> __( 'Hide meta', 'ItalyStrap' ),
					'thumb'			=> __( 'Hide feautured image', 'ItalyStrap' ),
					'content'		=> __( 'Hide the content', 'ItalyStrap' ),
					'author'		=> __( 'Hide author', 'ItalyStrap' ),
					'social'		=> __( 'Hide builtin social sharing', 'ItalyStrap' ),
					'comments'		=> __( 'Hide comments', 'ItalyStrap' ),
					'comments_form'	=> __( 'Hide comments form', 'ItalyStrap' ),
					'sidebar'		=> __( 'Hide sidebar', 'ItalyStrap' ),
				),
			)
		);

	}
}

$metabox = new Custom_Meta_Box;
add_action( 'cmb2_admin_init', array( $metabox, 'register_post_metabox' ) );