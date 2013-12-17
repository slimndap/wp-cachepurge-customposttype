<?php
/*
Plugin Name: Purge Page Cache for Custom Post Types
Plugin URI: http://wordpress.org/plugins/wp-mailinglijst/
Description: Integrate Mailinglijst sign-up forms into your website.
Author: Jeroen Schmit, Slim & Dapper
Version: 0.1
Author URI: http://slimndap.com/
Text Domain: purgepagecache-customposttype
*/

global $purgepagecache_customposttype;

require_once(__DIR__ . '/options.php');

class WP_purgepagecache_customposttype {
	function __construct() {
		
		$this->options = get_option('purgepagecache-customposttype');
		
		add_action('plugins_loaded', function(){
			load_plugin_textdomain('purgepagecache-customposttype', false, dirname( plugin_basename( __FILE__ ) ) . '/languages/' );
		});

	}
}

$purgepagecache_customposttype = new WP_purgepagecache_customposttype();
?>
