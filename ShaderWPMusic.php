<?php

/**
 * @package ShaderWPMusic
 * @version 1.0
 */
/*
Plugin Name: Shader WP Music
Plugin URI: https://github.com/sdutwsl/shader-wpmusic
Description: a simple music play for netease/qq/kugou music
Author: sdutwsl
Version: 1.0
Author URI: https://www.sdutwsl.moe
*/

add_action('admin_menu', 'SWP_add_admin_menu');
add_action('admin_init', 'SWP_settings_init');
add_action('wp_head', 'SWP_add_head');
add_action('wp_footer', 'SWP_add_footer');

function SWP_add_footer()
{
    $settings = get_option('SWP_settings');
    $platform = $settings['SWP_select_field_platform'];
    $music_type = $settings['SWP_select_field_music_type'];
    $music_id = $settings['SWP_select_field_music_id'];
    echo '
        <script async>
            function loadScript(src) {
                let script = document.createElement("script");
                script.src = src;
                script.defer = true;
                document.body.append(script);
            }
            loadScript("https://cdn.bootcdn.net/ajax/libs/aplayer/1.10.1/APlayer.min.js")
            loadScript("https://cdn.bootcdn.net/ajax/libs/meting/2.0.1/Meting.min.js")
        </script>
    ';
    echo '<meting-js server="' . $platform . '" type="' . $music_type . '" id="' . $music_id . '" fixed="true"></meting-js>';
    // echo $platform . $music_type . $music_id;
}

function SWP_add_head()
{
    echo '<link rel="stylesheet" href="https://cdn.bootcdn.net/ajax/libs/aplayer/1.10.1/APlayer.min.css">';
}

function SWP_add_admin_menu()
{

    add_submenu_page('plugins.php', 'ShaderWPMusic', 'ShaderWPMusic', 'manage_options', 'shaderwpmusic', 'SWP_options_page');
}


function SWP_settings_init()
{

    register_setting('pluginPage', 'SWP_settings');

    add_settings_section(
        'SWP_pluginPage_section',
        __('设置你的音乐', 'SWP'),
        'SWP_settings_section_callback',
        'pluginPage'
    );

    add_settings_field(
        'SWP_select_field_platform',
        __('平台', 'SWP'),
        'SWP_select_field_platform_render',
        'pluginPage',
        'SWP_pluginPage_section'
    );

    add_settings_field(
        'SWP_select_field_music_type',
        __('音乐类型', 'SWP'),
        'SWP_select_field_music_type_render',
        'pluginPage',
        'SWP_pluginPage_section'
    );

    add_settings_field(
        'SWP_select_field_music_id',
        __('音乐ID', 'SWP'),
        'SWP_select_field_music_id_render',
        'pluginPage',
        'SWP_pluginPage_section'
    );
}


function SWP_select_field_platform_render()
{

    $options = get_option('SWP_settings');
?>
    <select name='SWP_settings[SWP_select_field_platform]'>
        <option value='netease' <?php selected($options['SWP_select_field_platform'], 'netease'); ?>>网易云</option>
        <option value='tencent' <?php selected($options['SWP_select_field_platform'], 'tencent'); ?>>QQ音乐</option>
        <option value='kugou' <?php selected($options['SWP_select_field_platform'], 'kugou'); ?>>酷狗音乐</option>
    </select>

<?php

}


function SWP_select_field_music_type_render()
{

    $options = get_option('SWP_settings');
?>
    <select name='SWP_settings[SWP_select_field_music_type]'>
        <option value='song' <?php selected($options['SWP_select_field_music_type'], 'song'); ?>>歌曲</option>
        <option value='playlist' <?php selected($options['SWP_select_field_music_type'], 'playlist'); ?>>歌单Playlist</option>
        <option value='album' <?php selected($options['SWP_select_field_music_type'], 'album'); ?>>专辑Album</option>
    </select>

<?php

}


function SWP_select_field_music_id_render()
{

    $options = get_option('SWP_settings');
?>
    <input type='text' placeholder='歌单/歌曲/列表 ID' name='SWP_settings[SWP_select_field_music_id]' value='<?php echo $options['SWP_select_field_music_id']; ?>'>
<?php

}


function SWP_settings_section_callback()
{

    echo __('This section description', 'SWP');
}


function SWP_options_page()
{

?>
    <form action='options.php' method='post'>

        <h2>ShaderWPMusic</h2>

        <?php
        settings_fields('pluginPage');
        do_settings_sections('pluginPage');
        submit_button();
        ?>

    </form>
<?php

}
