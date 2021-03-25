## Co Author Menu 
This plugin adds a custom menu on the admin bar for the RainMaker platform since users don't have access to the admin sidebar menu

## How it works:
I used `WP_Admin_Bar::add_menu( array $node )` , the $node is an array with the menu details, I had to create two menus, one parent and another one child. This could have worked without the child element.

Then added the hook `$this->loader->add_action( 'admin_bar_menu',$author_menu, 'admin_bar_menu_item', 500 );` to run when the admin_bar_bar function is called.

The plugin only works when Co-Author Plus is active, if it's deactivated it prevents this plugin from being initiated. This check is attached to an admin notice hook for the admin notice to show.

This plugin could have been one single file but decided to go the OOP way, this allows for extendability and it's easier to manage.

## Displaying on FrontEnd
To display this on the frontend, you can use these two methods;
- Add this in your template `<?php do_action('show_co_authors'); ?> `

To add co authors directly next to the default author list, you can use this code (example use for Twenty Twenty One Theme)

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
