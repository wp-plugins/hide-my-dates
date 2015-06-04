<?php
/*
Plugin Name: Hide My Dates
Plugin URI: https://wordpress.org/plugins/hide-my-dates/
Description: The plugin hides post and comment publishing dates from Google. Read more in the <a href="options-general.php?page=hide-my-dates.php">Help</a> section on the plugin page.
Version: 1.01
Author: Flector
Author URI: https://profiles.wordpress.org/flector#content-plugins
*/ 
  

$pluginpage = $_SERVER["REQUEST_URI"];
if(strpos($pluginpage, 'hide-my-dates.php') == true){
if ( isset($_POST['submit']) ) {
	if (!isset($_POST['opt_date'])) $opt_date = '0'; else $opt_date = '1';
    if (!isset($_POST['opt_modifieddate'])) $opt_modifieddate = '0'; else $opt_modifieddate = '1';
	if (!isset($_POST['opt_comments'])) $opt_comments = '0'; else $opt_comments = '1';
    update_option('hmd_opt_date', $opt_date);
	update_option('hmd_opt_modifieddate', $opt_modifieddate);
	update_option('hmd_opt_comments', $opt_comments);
}}

function hmd_init() {
    $opt_date = '1';
	$opt_modifieddate = '1';
	$opt_comments = '1';
    add_option('hmd_opt_date', $opt_date);
	update_option('hmd_opt_date', $opt_date);
	add_option('hmd_opt_modifieddate', $opt_modifieddate);
	update_option('hmd_opt_modifieddate', $opt_modifieddate);
	add_option('hmd_opt_comments', $opt_comments);
	update_option('hmd_opt_comments', $opt_comments);
}
add_action('activate_hide-my-dates/hide-my-dates.php', 'hmd_init');

function hmd_setup(){
    load_plugin_textdomain('hide-my-dates', null, dirname( plugin_basename( __FILE__ ) ) . '/lang' );
}
add_action('init', 'hmd_setup');

function hmd_stylesheet() {
	$purl = plugins_url();
    $myStyleUrl = $purl . '/hide-my-dates/hide-my-dates.css';
    wp_register_style('hide-my-dates', $myStyleUrl);
    wp_enqueue_style( 'hide-my-dates');
}
add_action('wp_print_styles', 'hmd_stylesheet');

function hide_date($tdate = '') {
if ( !is_admin() ) {
	$opt_date = get_option('hmd_opt_date');
	if ($opt_date == "1") {
		$tdate = '<span class="sdata" title="' .  $tdate . '"></span>';
	} 
	}
return $tdate;
}

function hide_modifieddate($tdate = '') {
if ( !is_admin() ) {
	$opt_modifieddate = get_option('hmd_opt_modifieddate');
	if ($opt_modifieddate == "1") {
		$tdate = '<span class="sdata2" title="' .  $tdate . '"></span>';
	} 
	}
return $tdate;
}

function hide_comments($tdate = '') {
if ( !is_admin() ) {
	$opt_comments = get_option('hmd_opt_comments');
	if ($opt_comments == "1") {
		$tdate = '<span class="sdata3" title="' .  $tdate . '"></span>';
	} 
	}
return $tdate;
}

function hdm_options_page() {
$opt_date = get_option('hmd_opt_date');
$opt_modifieddate = get_option('hmd_opt_modifieddate');
$opt_comments = get_option('hmd_opt_comments');
?>
<?php if ( !empty($_POST ) ) : ?>
<div id="message" class="updated fade"><p><strong><?php _e('Options saved.', "hide-my-dates") ?></strong></p></div>
<?php endif; ?>
<div class="wrap">
<h2><?php _e('Hide My Dates Settings', 'hide-my-dates'); ?></h2>

<div class="metabox-holder" id="poststuff">
<div class="meta-box-sortables">

<div class="postbox">

    <h3 class="hndle"><span><?php _e("Do you use it ?", "hide-my-dates"); ?></span></h3>
    <div class="inside" style="display: block;">
        <img src="<?php echo WP_PLUGIN_URL. '/hide-my-dates/img/icon_coffee.png'; ?>" title="<?php _e("buy me a coffee", "hide-my-dates"); ?>" style=" margin: 5px; float:left;" />
		
        <p><?php _e("Hi! I'm <strong>Flector</strong>, developer of this plugin.", "hide-my-dates"); ?></p>
        <p><?php _e("I've been spending many hours to develop this plugin.", "hide-my-dates"); ?> <br />
		<?php _e("If you like and use this plugin, you can <strong>buy me a cup of coffee</strong>.", "hide-my-dates"); ?></p>
        <form action="https://www.paypal.com/cgi-bin/webscr" method="post">
            <input type="hidden" name="cmd" value="_s-xclick">
            <input type="hidden" name="encrypted" value="-----BEGIN PKCS7-----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-----END PKCS7-----">
            <input type="image" src="<?php echo WP_PLUGIN_URL. '/hide-my-dates/img/donate.gif'; ?>" border="0" name="submit" title="<?php _e("Donate with PayPal", "hide-my-dates"); ?>">
        </form>
        <div style="clear:both;"></div>
    </div>
</div>

<form action="" method="post">


<div class="postbox">

    <h3 class="hndle"><span><?php _e("Options", "hide-my-dates"); ?></span></h3>
    <div class="inside" style="display: block;">

        <table class="form-table">
            <tr>
                <th><?php _e("Hide date", "hide-my-dates") ?></th><td><input type="checkbox" name="opt_date" value="1" <?php if ($opt_date == '1') echo "checked='checked'"; ?> /> <?php _e("Post creation date (the_date or the_time) will be hidden from Google.", "hide-my-dates"); ?></td>
            </tr>
			<tr>
                <th><?php _e("Hide modified date", "hide-my-dates") ?></th><td><input type="checkbox" name="opt_modifieddate" value="1" <?php if ($opt_modifieddate == '1') echo "checked='checked'"; ?> /> <?php _e("The last modification date (the_modified_date or the_modified_time) will be hidden from Google.", "hide-my-dates"); ?></td>
            </tr>
			<tr>
                <th><?php _e("Hide dates of comments", "hide-my-dates") ?></th><td><input type="checkbox" name="opt_comments" value="1" <?php if ($opt_comments == '1') echo "checked='checked'"; ?> /> <?php _e("Comment creation dates will be hidden from Google.", "hide-my-dates") ?></td>
            </tr>	

           

            <tr>
                <th></th>
                <td>
                    <input type="submit" name="submit" class="button button-primary" value="<?php _e('Update options &raquo;', "hide-my-dates"); ?>" />
                </td>
            </tr>
        </table>

    </div>
</div>


<div class="postbox">

    <h3 class="hndle"><span><?php _e('Help', 'hide-my-dates'); ?></span></h3>
	  <div class="inside" style="display: block;"><p>
	  <?php _e('How it works:', 'hide-my-dates'); ?> <br /><br />
	  <?php _e('The plugin uses a CSS hack to show the date – your visitors see it, but Google takes it <br />for the “title” parameter of a “span” element and does not consider it to be a part of <br />the page content. Therefore, the publishing date is not shown in the search snippet.', 'hide-my-dates'); ?>
    </p>
	<p><img src="<?php echo WP_PLUGIN_URL. '/hide-my-dates/img/1.png'; ?>" title="Twenty Ten" style="border: 1px solid #CCC;" /></p>
	<p><?php _e('This hack will not work if dates in your theme are not shown directly through native <br />WordPress date functions – for instance, as in Twenty Eleven, Twenty Twelve <br />and later themes. Date hiding will <strong>not work</strong> in these themes!', 'hide-my-dates'); ?> </p>
	
	<p><?php _e('Some themes only show the date of the last post modification. Hide it from Google <br />if you don’t want it to appear in the search snippet.', 'hide-my-dates'); ?> </p>
	
	<p><?php _e('If Google doesn’t find the date in a post, it will take it from the first comment on the <br />page, so hiding comment creation dates is also a good idea.', 'hide-my-dates'); ?> </p>
	

      <p><?php _e('I hope you will find this plugin useful.', 'hide-my-dates'); ?></p>
    </div>
</div>
</form>
</div>
</div>
<?php 
}

function hdm_menu() {
	add_options_page('Hide My Dates', 'Hide My Dates', 'manage_options', 'hide-my-dates.php', 'hdm_options_page');
}

add_action('admin_menu', 'hdm_menu');

add_filter('get_the_time', 'hide_date');
add_filter('get_the_date', 'hide_date');

add_filter('get_the_modified_time', 'hide_modifieddate');
add_filter('get_the_modified_date', 'hide_modifieddate');

add_filter('get_comment_date', 'hide_comments');
add_filter('get_comment_time', 'hide_comments');

?>