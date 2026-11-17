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

class OpenMigrate_Import_Check_Encryption {

	public static function execute( $params ) {

		// Read package.json file
		$handle = openmigrate_open( openmigrate_package_path( $params ), 'r' );

		// Parse package.json file
		$package = openmigrate_read( $handle, filesize( openmigrate_package_path( $params ) ) );
		$package = json_decode( $package, true );

		// Close handle
		openmigrate_close( $handle );

		// No encryption provided
		if ( empty( $package['Encrypted'] ) || empty( $package['EncryptedSignature'] ) ) {
			return $params;
		}

		// Check decryption support
		if ( ! openmigrate_can_decrypt() ) {
			if ( defined( 'WP_CLI' ) ) {
				WP_CLI::error( __( 'Importing an encrypted backup is not supported on this server. The process cannot continue.', 'open-migrate' ) );
			} else {
				OpenMigrate_Status::server_cannot_decrypt( __( 'Importing an encrypted backup is not supported on this server. The process cannot continue.', 'open-migrate' ) );

				// REST API: throw to halt the pipeline; controller preserves the status option
				if ( defined( 'REST_REQUEST' ) && REST_REQUEST ) {
					throw new OpenMigrate_Not_Decryptable_Exception( 'server_cannot_decrypt' );
				}

				exit;
			}
		}

		// Get WP CLI decryption password
		if ( defined( 'WP_CLI' ) && empty( $params['decryption_password'] ) ) {
			$params['decryption_password'] = readline( __( 'Backup is encrypted. Please provide decryption password: ', 'open-migrate' ) );
		}

		// Validate decryption password
		if ( ! empty( $params['decryption_password'] ) ) {
			if ( openmigrate_is_decryption_password_valid( $package['EncryptedSignature'], $params['decryption_password'] ) ) {

				// Set progress
				OpenMigrate_Status::info( __( 'Decryption password validated.', 'open-migrate' ) );

				return $params;
			}

			$decryption_password_error = __( 'The decryption password is not valid. The process cannot continue.', 'open-migrate' );

			if ( defined( 'WP_CLI' ) ) {
				WP_CLI::error( $decryption_password_error );
			} else {
				OpenMigrate_Status::backup_is_encrypted( $decryption_password_error );

				// REST API: throw to halt the pipeline; controller preserves the status option
				if ( defined( 'REST_REQUEST' ) && REST_REQUEST ) {
					throw new OpenMigrate_Not_Decryptable_Exception( 'invalid_password' );
				}

				exit;
			}
		}

		OpenMigrate_Status::backup_is_encrypted( null );

		// REST API: throw to halt the pipeline; controller preserves the status option
		if ( defined( 'REST_REQUEST' ) && REST_REQUEST ) {
			throw new OpenMigrate_Not_Decryptable_Exception( 'awaiting_password' );
		}

		exit;
	}
}
