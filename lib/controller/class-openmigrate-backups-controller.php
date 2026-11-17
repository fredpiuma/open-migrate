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

class OpenMigrate_Backups_Controller {

	public static function index() {
		OpenMigrate_Template::render(
			'backups/index',
			array(
				'backups'      => OpenMigrate_Backups::get_files(),
				'labels'       => OpenMigrate_Backups::get_labels(),
				'downloadable' => OpenMigrate_Backups::are_downloadable(),
			)
		);
	}

	/**
	 * Render the bulk delete button below the backups list
	 *
	 * Hooked to openmigrate_backups_left_end, which is fired by both the Backups page of the
	 * plugin and the Reset page of the paid extensions, so that the button follows the
	 * backups list wherever the list is rendered.
	 *
	 * @return void
	 */
	public static function bulk_delete_button() {
		OpenMigrate_Template::render( 'backups/backups-bulk-delete' );
	}

	public static function clean( $params = array() ) {
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

		try {
			// Ensure that unauthorized people cannot access backups list action
			openmigrate_verify_secret_key( $secret_key );
		} catch ( OpenMigrate_Not_Valid_Secret_Key_Exception $e ) {
			exit;
		}

		// Delete storage files
		OpenMigrate_Directory::delete( openmigrate_storage_path( $params ) );
		exit;
	}

	public static function delete( $params = array() ) {
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

		// Set archives
		$archives = array();
		if ( isset( $params['archives'] ) && is_array( $params['archives'] ) ) {
			$archives = array_map( 'trim', $params['archives'] );
		} elseif ( isset( $params['archive'] ) ) {
			$archives = array( trim( $params['archive'] ) );
		}

		try {
			openmigrate_verify_secret_key( $secret_key );
		} catch ( OpenMigrate_Not_Valid_Secret_Key_Exception $e ) {
			exit;
		}

		$deleted = array();
		$failed  = array();

		try {
			foreach ( $archives as $archive ) {
				if ( OpenMigrate_Backups::delete_file( $archive ) ) {
					$deleted[] = $archive;
				} else {
					$failed[] = $archive;
				}
			}

			OpenMigrate_Backups::delete_labels( $deleted );
		} catch ( OpenMigrate_Backups_Exception $e ) {
			openmigrate_json_response( array( 'deleted' => $deleted, 'errors' => array( $e->getMessage() ) ) );
			exit;
		}

		$errors = array();
		if ( $failed ) {
			$errors[] = sprintf(
				_n(
					'%d backup could not be deleted. Please verify the file permissions of your backups folder.',
					'%d backups could not be deleted. Please verify the file permissions of your backups folder.',
					count( $failed ),
					'open-migrate'
				),
				count( $failed )
			);
		}

		openmigrate_json_response( array( 'deleted' => $deleted, 'errors' => $errors ) );
		exit;
	}

	public static function add_label( $params = array() ) {
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

		// Set archive
		$archive = null;
		if ( isset( $params['archive'] ) ) {
			$archive = trim( $params['archive'] );
		}

		// Set backup label
		$label = null;
		if ( isset( $params['label'] ) ) {
			$label = trim( $params['label'] );
		}

		try {
			// Ensure that unauthorized people cannot access add label action
			openmigrate_verify_secret_key( $secret_key );
		} catch ( OpenMigrate_Not_Valid_Secret_Key_Exception $e ) {
			exit;
		}

		try {
			OpenMigrate_Backups::set_label( $archive, $label );
		} catch ( OpenMigrate_Backups_Exception $e ) {
			openmigrate_json_response( array( 'errors' => array( $e->getMessage() ) ) );
			exit;
		}

		openmigrate_json_response( array( 'errors' => array() ) );
		exit;
	}

	public static function backup_list( $params = array() ) {
		openmigrate_setup_environment();

		// Set params
		if ( empty( $params ) ) {
			$params = stripslashes_deep( $_GET );
		}

		// Set secret key
		$secret_key = null;
		if ( isset( $params['secret_key'] ) ) {
			$secret_key = trim( $params['secret_key'] );
		}

		try {
			// Ensure that unauthorized people cannot access backups list action
			openmigrate_verify_secret_key( $secret_key );
		} catch ( OpenMigrate_Not_Valid_Secret_Key_Exception $e ) {
			exit;
		}

		OpenMigrate_Template::render(
			'backups/backups-list',
			array(
				'backups'      => OpenMigrate_Backups::get_files(),
				'labels'       => OpenMigrate_Backups::get_labels(),
				'downloadable' => OpenMigrate_Backups::are_downloadable(),
			)
		);
		exit;
	}

	public static function backup_get_config( $params = array() ) {
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

		try {
			// Ensure that unauthorized people cannot access backups list action
			openmigrate_verify_secret_key( $secret_key );
		} catch ( OpenMigrate_Not_Valid_Secret_Key_Exception $e ) {
			exit;
		}

		try {
			// Open the archive file for reading
			$archive = new OpenMigrate_Extractor( openmigrate_backup_path( $params ) );
			$archive->extract_by_files_array( openmigrate_storage_path( $params ), array( OPENMIGRATE_PACKAGE_NAME ) );
			$archive->close();
		} catch ( Exception $e ) {
			openmigrate_json_response( array( 'errors' => array( $e->getMessage() ) ) );
			exit;
		}

		openmigrate_json_response( array( 'errors' => array() ) );
		exit;
	}

	public static function backup_check_encryption( $params = array() ) {
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

		try {
			// Ensure that unauthorized people cannot access backups list action
			openmigrate_verify_secret_key( $secret_key );
		} catch ( OpenMigrate_Not_Valid_Secret_Key_Exception $e ) {
			exit;
		}

		// Read package.json file
		$handle = openmigrate_open( openmigrate_package_path( $params ), 'r' );

		// Parse package.json file
		$package = openmigrate_read( $handle, filesize( openmigrate_package_path( $params ) ) );
		$package = json_decode( $package, true );

		// Close handle
		openmigrate_close( $handle );

		// No encryption provided
		if ( empty( $package['Encrypted'] ) || empty( $package['EncryptedSignature'] ) ) {
			openmigrate_json_response( array( 'errors' => array() ) );
			exit;
		}

		// Check decryption support
		if ( ! openmigrate_can_decrypt() ) {
			openmigrate_json_response( array( 'errors' => array( __( 'Download a file from encrypted backup is not supported on this server. The process cannot continue.', 'open-migrate' ) ) ) );
			exit;
		}

		// Validate decryption password
		if ( ! empty( $params['decryption_password'] ) ) {
			if ( ! openmigrate_is_decryption_password_valid( $package['EncryptedSignature'], $params['decryption_password'] ) ) {
				openmigrate_json_response( array( 'errors' => array( __( 'The decryption password is not valid. The process cannot continue.', 'open-migrate' ) ) ) );
				exit;
			}

			openmigrate_json_response( array( 'errors' => array() ) );
			exit;
		}

		openmigrate_json_response( array( 'check' => true, 'errors' => array() ) );
		exit;
	}

	public static function backup_list_content( $params = array() ) {
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

		try {
			// Ensure that unauthorized people cannot access backups list action
			openmigrate_verify_secret_key( $secret_key );
		} catch ( OpenMigrate_Not_Valid_Secret_Key_Exception $e ) {
			exit;
		}

		$files = array();

		try {
			$archive = new OpenMigrate_Extractor( openmigrate_backup_path( $params ) );
			if ( ! $archive->is_valid() ) {
				throw new OpenMigrate_Backups_Exception(
					__( 'Could not list the backup content. Please ensure the backup file is accessible and not corrupted.', 'open-migrate' )
				);
			}

			$files = $archive->list_files();
			$archive->close();
		} catch ( Exception $e ) {
			openmigrate_json_response( array( 'errors' => $e->getMessage() ) );
			exit;
		}

		openmigrate_json_response( $files );
		exit;
	}

	public static function download_file( $params = array() ) {
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

		// Set decryption password
		$decryption_password = null;
		if ( isset( $params['decryption_password'] ) ) {
			$decryption_password = $params['decryption_password'];
		}

		// Set file name
		$file_name = null;
		if ( isset( $params['file_name'] ) ) {
			$file_name = trim( $params['file_name'] );
		}

		// Set file offset
		if ( isset( $params['file_offset'] ) ) {
			$file_offset = (int) $params['file_offset'];
		} else {
			$file_offset = 0;
		}

		try {
			// Ensure that unauthorized people cannot access backups list action
			openmigrate_verify_secret_key( $secret_key );
		} catch ( OpenMigrate_Not_Valid_Secret_Key_Exception $e ) {
			exit;
		}

		// Read package.json file
		$handle = openmigrate_open( openmigrate_package_path( $params ), 'r' );

		// Parse package.json file
		$config = openmigrate_read( $handle, filesize( openmigrate_package_path( $params ) ) );
		$config = json_decode( $config, true );

		// Close handle
		openmigrate_close( $handle );

		// Get compression type
		$compression_type = null;
		if ( ! empty( $config['Compression']['Enabled'] ) ) {
			$compression_type = $config['Compression']['Type'];
		}

		// Open the archive file for reading
		$archive = new OpenMigrate_Extractor( openmigrate_backup_path( $params ), $decryption_password, $compression_type );
		$archive->set_file_pointer( $file_offset );
		$archive->extract_one_file_to( openmigrate_storage_path( $params ) );
		$archive->close();

		try {
			// Validate file name and file path for directory traversal
			if ( path_is_absolute( $file_name ) || validate_file( $file_name ) !== 0 ) {
				exit;
			}

			// Download file
			if ( ( $file_handle = openmigrate_open( openmigrate_storage_path( $params ) . DIRECTORY_SEPARATOR . $file_name, 'rb' ) ) ) {
				while ( ! feof( $file_handle ) ) {
					$file_buffer = openmigrate_read( $file_handle, 1024 * 1024 );
					echo $file_buffer;
					ob_flush();
					flush();
				}

				openmigrate_close( $file_handle );
			}
		} catch ( Exception $e ) {
		}

		exit;
	}

	public static function download_backup( $params = array() ) {
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

		try {
			// Ensure that unauthorized people cannot access backups list action
			openmigrate_verify_secret_key( $secret_key );
		} catch ( OpenMigrate_Not_Valid_Secret_Key_Exception $e ) {
			exit;
		}

		try {
			// Download file
			if ( ( $file_handle = openmigrate_open( openmigrate_backup_path( $params ), 'rb' ) ) ) {
				while ( ! feof( $file_handle ) ) {
					$file_buffer = openmigrate_read( $file_handle, 1024 * 1024 );
					echo $file_buffer;
					ob_flush();
					flush();
				}

				openmigrate_close( $file_handle );
			}
		} catch ( Exception $e ) {
		}

		exit;
	}
}
