<?php

/**
 * @package ShaderWPMusic
 * @version 1.0
 */
/*
Plugin Name: Shader WP Music
Plugin URI: 
Description: 
Author: sdutwsl
Version: 1.0
Author URI: 
*/

function hello_dolly_get_lyric()
{
    /** These are the lyrics to Hello Dolly */
    $lyrics = "Hello, Dolly
Dolly'll never go away again";

    // Here we split it into lines
    $lyrics = explode("\n", $lyrics);

    // And then randomly choose a line
    return wptexturize($lyrics[mt_rand(0, count($lyrics) - 1)]);
}

// This just echoes the chosen line, we'll position it later
function hello_dolly()
{
    $chosen = hello_dolly_get_lyric();
    echo "<p id='dolly'>$chosen</p>";
}

// Now we set that function up to execute when the admin_notices action is called
add_action('admin_notices', 'hello_dolly');

// We need some CSS to position the paragraph
function dolly_css()
{
    // This makes sure that the positioning is also good for right-to-left languages
    $x = is_rtl() ? 'left' : 'right';

    echo "
	<style type='text/css'>
	#dolly {
		float: $x;
		padding-$x: 15px;
		padding-top: 5px;		
		margin: 0;
		font-size: 11px;
	}
	</style>
	";
}

add_action('admin_head', 'dolly_css');



function SWP_add_admin_menu(  ) { 

	add_submenu_page( 'tools.php', 'ShaderWPMusic', 'ShaderWPMusic', 'manage_options', 'shaderwpmusic', 'SWP_options_page' );

}


function SWP_settings_init(  ) { 

	register_setting( 'pluginPage', 'SWP_settings' );

	add_settings_section(
		'SWP_pluginPage_section', 
		__( 'Your section description', 'SWP' ), 
		'SWP_settings_section_callback', 
		'pluginPage'
	);

	add_settings_field( 
		'SWP_select_field_0', 
		__( 'Settings field description', 'SWP' ), 
		'SWP_select_field_0_render', 
		'pluginPage', 
		'SWP_pluginPage_section' 
	);

	add_settings_field( 
		'SWP_select_field_1', 
		__( 'Settings field description', 'SWP' ), 
		'SWP_select_field_1_render', 
		'pluginPage', 
		'SWP_pluginPage_section' 
	);

	add_settings_field( 
		'SWP_text_field_2', 
		__( 'Settings field description', 'SWP' ), 
		'SWP_text_field_2_render', 
		'pluginPage', 
		'SWP_pluginPage_section' 
	);


}


function SWP_select_field_0_render(  ) { 

	$options = get_option( 'SWP_settings' );
	?>
	<select name='SWP_settings[SWP_select_field_0]'>
		<option value='1' <?php selected( $options['SWP_select_field_0'], 1 ); ?>>Option 1</option>
		<option value='2' <?php selected( $options['SWP_select_field_0'], 2 ); ?>>Option 2</option>
	</select>

<?php

}


function SWP_select_field_1_render(  ) { 

	$options = get_option( 'SWP_settings' );
	?>
	<select name='SWP_settings[SWP_select_field_1]'>
		<option value='1' <?php selected( $options['SWP_select_field_1'], 1 ); ?>>Option 1</option>
		<option value='2' <?php selected( $options['SWP_select_field_1'], 2 ); ?>>Option 2</option>
	</select>

<?php

}


function SWP_text_field_2_render(  ) { 

	$options = get_option( 'SWP_settings' );
	?>
	<input type='text' name='SWP_settings[SWP_text_field_2]' value='<?php echo $options['SWP_text_field_2']; ?>'>
	<?php

}


function SWP_settings_section_callback(  ) { 

	echo __( 'This section description', 'SWP' );

}


function SWP_options_page(  ) { 

		?>
		<form action='options.php' method='post'>

			<h2>ShaderWPMusic</h2>

			<?php
			settings_fields( 'pluginPage' );
			do_settings_sections( 'pluginPage' );
			submit_button();
			?>

		</form>
		<?php

}


add_action( 'admin_menu', 'SWP_add_admin_menu' );
add_action( 'admin_init', 'SWP_settings_init' );
