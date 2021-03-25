<?php

/**
 * The file that defines the core plugin class
 *
 * A class definition that includes attributes and functions used across both the
 * public-facing side of the site and the admin area.
 *
 * @link       https://github.com/denisbosire
 * @since      1.0.0
 *
 * @package    Co_Author_Menu
 * @subpackage Co_Author_Menu/includes
 */

/**
 * The core plugin menu class.
 *
 * This is used to define internationalization, admin-specific hooks, and
 * public-facing site hooks.
 *
 * Also maintains the unique identifier of this plugin as well as the current
 * version of the plugin.
 *
 * @since      1.0.0
 * @package    Co_Author_Menu
 * @subpackage Co_Author_Menu/includes
 * @author     Denis Bosire <denischweya@gmail.com>
 */
class Co_Author_Menu_Add_Menu {

	/**
	 * The loader that's responsible for maintaining and registering all hooks that power
	 * the plugin.
	 *
	 * @since    1.0.0
	 * @access   protected
	 * @var      Co_Author_Menu_Loader    $loader    Maintains and registers all hooks for the plugin.
	 */
	protected $loader;

	/**
	 * The unique identifier of this plugin.
	 *
	 * @since    1.0.0
	 * @access   protected
	 * @var      string    $plugin_name    The string used to uniquely identify this plugin.
	 */
	protected $plugin_name;

	/**
	 * The current version of the plugin.
	 *
	 * @since    1.0.0
	 * @access   protected
	 * @var      string    $version    The current version of the plugin.
	 */
	protected $version;

	function admin_bar_menu_item ( WP_Admin_Bar $admin_bar ) {
		if ( ! current_user_can( 'manage_options' ) ) {
			return;
		}
		$admin_bar->add_menu( array(
			'id'    => 'parent-menu-id',
			'parent' => null,
			'group'  => null,
			'title' => __('Co Authors', 'co-author-menu'), //you can use img tag with image link. it will show the image icon Instead of the title.
			'href'  => admin_url('users.php?page=view-guest-authors'),
			'meta' => [
				'title' => __( 'Menu Title', 'co-author-menu' ), //This title will show on hover
			]
		) );
		$admin_bar->add_menu( array(
			'id'    => 'menu-id',
			'parent' => 'parent-menu-id',
			'group'  => null,
			'title' => __('Gues Authors', 'co-author-menu'), //you can use img tag with image link. it will show the image icon Instead of the title.
			'href'  => admin_url('users.php?page=view-guest-authors'),
			'meta' => [
				'title' => __( 'Menu Title', 'co-author-menu' ), //This title will show on hover
			]
		) );
	}

	function co_author_menu_frontend(){
		if ( ! function_exists( 'twenty_twenty_one_posted_on' ) ) :
			/**
			 * Integrate Co-Authors Plus with TwentyTen by replacing twentyten_posted_on() with this function.
			 */
			function twenty_twenty_one_posted_on() {
				if ( function_exists( 'coauthors_posts_links' ) ) :
					printf(
						__( '<span class="%1$s">Posted on</span> %2$s <span class="meta-sep">by</span> %3$s', 'twentyten' ),
						'meta-prep meta-prep-author',
						sprintf(
							'<a href="%1$s" title="%2$s" rel="bookmark"><span class="entry-date">%3$s</span></a>',
							get_permalink(),
							esc_attr( get_the_time() ),
							get_the_date()
						),
						coauthors_posts_links( null, null, null, null, false )
					);
				else:
					printf(
						__( '<span class="%1$s"<Posted on</span> %2$s <span class="meta-sep">by</span> %3$s', 'twentyten' ),
						'meta-prep meta-prep-author',
						sprintf(
							'<a href="%1$s" title="%2$s" rel="bookmark"><span class="entry-date">%3$s</span></a>',
							get_permalink(),
							esc_attr( get_the_time() ),
							get_the_date()
						),
						sprintf(
							'<span class="author vcard"><a class="url fn n" href="%1$s" title="%2$s">%3$s</a></span>',
							get_author_posts_url( get_the_author_meta( 'ID' ) ),
							esc_attr( sprintf( __( 'View all posts by %s', 'twentyten' ), get_the_author() ) ),
							get_the_author()
						)
					);
				endif;
			}
		endif;
	}
}
