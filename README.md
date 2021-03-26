## Co Author Menu 
This plugin adds a custom menu on the admin bar for the RainMaker platform since users don't have access to the admin sidebar menu

## How it works:
I used `WP_Admin_Bar::add_menu( array $node )` , the $node is an array with the menu details, I had to create two menus, one parent and another one child. This could have worked without the child element.

Then added the hook `$this->loader->add_action( 'admin_bar_menu',$author_menu, 'admin_bar_menu_item', 500 );` to run when the admin_bar_bar function is called.

The plugin only works when Co-Author Plus is active, if it's deactivated it prevents this plugin from being initiated. This check is attached to an admin notice hook for the admin notice to show.

This plugin could have been one single file but decided to go the OOP way, this allows for extendability and it's easier to manage.

## Displaying on FrontEnd
As long as a post has a guest author assigned, it'll add this info below the post automatically. This has been tested with Genesis using Atmosphere Pro & Rainmaker Pro child themes.
