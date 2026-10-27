<?php
/**
 * Copyright (C) 2014-2025 ServMask Inc.
 *
 * This program is free software: you can redistribute it and/or modify
 * it under the terms of the GNU General Public License as published by
 * the Free Software Foundation, either version 3 of the License, or
 * (at your option) any later version.
 *
 * This program is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 * GNU General Public License for more details.
 *
 * You should have received a copy of the GNU General Public License
 * along with this program.  If not, see <http://www.gnu.org/licenses/>.
 *
 * Attribution: This code is part of the All-in-One WP Migration plugin, developed by
 *
 * ███████╗███████╗██████╗ ██╗   ██╗███╗   ███╗ █████╗ ███████╗██╗  ██╗
 * ██╔════╝██╔════╝██╔══██╗██║   ██║████╗ ████║██╔══██╗██╔════╝██║ ██╔╝
 * ███████╗█████╗  ██████╔╝██║   ██║██╔████╔██║███████║███████╗█████╔╝
 * ╚════██║██╔══╝  ██╔══██╗╚██╗ ██╔╝██║╚██╔╝██║██╔══██║╚════██║██╔═██╗
 * ███████║███████╗██║  ██║ ╚████╔╝ ██║ ╚═╝ ██║██║  ██║███████║██║  ██╗
 * ╚══════╝╚══════╝╚═╝  ╚═╝  ╚═══╝  ╚═╝     ╚═╝╚═╝  ╚═╝╚══════╝╚═╝  ╚═╝
 */

if ( ! defined( 'ABSPATH' ) ) {
	die( 'Kangaroos cannot jump here' );
}

class OpenMigrate_Feedback_Controller {

	public static function feedback( $params = array() ) {
		openmigrate_setup_environment();

		// Set params
		if ( empty( $params ) ) {
			$params = stripslashes_deep( $_POST );
		}

		// Set secret key
		$secret_key = null;
		if ( isset( $params['secret_key'] ) ) {
			$secret_key = trim( $params['secret_key'] );
		}

		// Set type
		$type = null;
		if ( isset( $params['openmigrate_type'] ) ) {
			$type = trim( $params['openmigrate_type'] );
		}

		// Set e-mail
		$email = null;
		if ( isset( $params['openmigrate_email'] ) ) {
			$email = trim( $params['openmigrate_email'] );
		}

		// Set message
		$message = null;
		if ( isset( $params['openmigrate_message'] ) ) {
			$message = trim( $params['openmigrate_message'] );
		}

		// Set terms
		$terms = false;
		if ( isset( $params['openmigrate_terms'] ) ) {
			$terms = (bool) $params['openmigrate_terms'];
		}

		try {
			// Ensure that unauthorized people cannot access feedback action
			openmigrate_verify_secret_key( $secret_key );
		} catch ( OpenMigrate_Not_Valid_Secret_Key_Exception $e ) {
			exit;
		}

		$extensions = OpenMigrate_Extensions::get();

		// Exclude File Extension
		if ( defined( 'OPENMIGRATETE_PLUGIN_NAME' ) ) {
			unset( $extensions[ OPENMIGRATETE_PLUGIN_NAME ] );
		}

		$purchases = array();
		foreach ( $extensions as $extension ) {
			$purchases[] = $extension['key'];
		}

		try {
			OpenMigrate_Feedback::add( $type, $email, $message, $terms, implode( PHP_EOL, $purchases ) );
		} catch ( OpenMigrate_Feedback_Exception $e ) {
			openmigrate_json_response( array( 'errors' => array( $e->getMessage() ) ) );
			exit;
		}

		openmigrate_json_response( array( 'errors' => array() ) );
		exit;
	}
}
