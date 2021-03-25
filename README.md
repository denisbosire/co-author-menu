## Co Author Menu 
This plugin add a custom menu on the admin bar for the RainMaker platform since users don't have access to the admin sidebar menu

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
