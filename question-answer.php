<?php

use QuestionAnswer\QuestionAnswerPlugin;

/**
 *
 * Plugin Name:       WP Question & Answer
 * Plugin URI:        https://processby.com/faq-plugin-wordpress/
 * Description:       Adds a question and answer page in WordPress.
 * Version:           1.0
 * Author:            Processby
 * Author URI:        https://processby.com/
 * License:           GPL-2.0+
 * License URI:       http://www.gnu.org/licenses/gpl-2.0.txt
 * Text Domain:       wp-question-answer
 * Domain Path:       /languages
 */

// If this file is called directly, abort.
if ( ! defined( 'WPINC' ) ) {
	die;
}

call_user_func( function () {

	require_once plugin_dir_path( __FILE__ ) . 'vendor/autoload.php';

	$main = new QuestionAnswerPlugin( __FILE__ );

	register_activation_hook( __FILE__, [ $main, 'activate' ] );

	register_deactivation_hook( __FILE__, [ $main, 'deactivate' ] );

	register_uninstall_hook( __FILE__, [ QuestionAnswerPlugin::class, 'uninstall' ] );

	$main->run();
} );