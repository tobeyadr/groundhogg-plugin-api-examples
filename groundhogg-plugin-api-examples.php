<?php

/*
Plugin Name: Groundhogg - Plugin API Examples
Plugin URI: http://groundhogg.io
Description: Examples for how to utilise our plugin api benchmark and action for easier plugin development.
Version: 1.0
Author: Adrian Tobey
Author URI: http://groundhogg.io
License: A "Slug" license name e.g. GPL2
*/

####  PLUGIN API ACTION   ####

add_filter( 'add_one_to_custom_field', 'my_custom_action', 10, 2 );

/**
 * The custom action you want to run using the Plugin API Action
 *
 * @param $success bool whether the step completion was successful
 * @param $contact \Groundhogg\Contact the current contact record
 */
function my_custom_action( $success, $contact ) {

	if ( ! $success || is_wp_error( $success ) ) {
		return $success;
	}

	$value = absint( $contact->get_meta( 'our_custom_field' ) );

	$value += 1;

	$contact->update_meta( 'our_custom_field', $value );

	return true;
}

#### PLUGIN API BENCHMARK ####

add_action( 'my_custom_membership_plugin_new_member', 'my_handler_function' );

/**
 * A listener function for some arbitrary WordPress or plugin hook.
 *
 * @param $user_id int
 */
function my_handler_function( $user_id ) {

	$contact = \Groundhogg\create_contact_from_user( $user_id );

	// pass contact id, user id, email address
	\Groundhogg\do_plugin_api_benchmark( 'new_member', $contact->get_id() );

	//todo any followup code
	$contact->update_meta( 'some_field', 'my-data' );

}

