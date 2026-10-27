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

class OpenMigrate_Import_Mu_Plugins {

	public static function execute( $params ) {

		// Set progress
		OpenMigrate_Status::info( __( 'Activating mu-plugins...', 'open-migrate' ) );

		// Set decryption password
		$decryption_password = null;
		if ( isset( $params['decryption_password'] ) ) {
			$decryption_password = $params['decryption_password'];
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

		// List of must-use plugins
		$exclude_files = array(
			OPENMIGRATE_MUPLUGINS_NAME . DIRECTORY_SEPARATOR . OPENMIGRATE_ENDURANCE_PAGE_CACHE_NAME,
			OPENMIGRATE_MUPLUGINS_NAME . DIRECTORY_SEPARATOR . OPENMIGRATE_ENDURANCE_PHP_EDGE_NAME,
			OPENMIGRATE_MUPLUGINS_NAME . DIRECTORY_SEPARATOR . OPENMIGRATE_ENDURANCE_BROWSER_CACHE_NAME,
			OPENMIGRATE_MUPLUGINS_NAME . DIRECTORY_SEPARATOR . OPENMIGRATE_GD_SYSTEM_PLUGIN_NAME,
			OPENMIGRATE_MUPLUGINS_NAME . DIRECTORY_SEPARATOR . OPENMIGRATE_WP_STACK_CACHE_NAME,
			OPENMIGRATE_MUPLUGINS_NAME . DIRECTORY_SEPARATOR . OPENMIGRATE_WP_COMSH_LOADER_NAME,
			OPENMIGRATE_MUPLUGINS_NAME . DIRECTORY_SEPARATOR . OPENMIGRATE_WP_COMSH_HELPER_NAME,
			OPENMIGRATE_MUPLUGINS_NAME . DIRECTORY_SEPARATOR . OPENMIGRATE_WP_ENGINE_SYSTEM_PLUGIN_NAME,
			OPENMIGRATE_MUPLUGINS_NAME . DIRECTORY_SEPARATOR . OPENMIGRATE_WPE_SIGN_ON_PLUGIN_NAME,
			OPENMIGRATE_MUPLUGINS_NAME . DIRECTORY_SEPARATOR . OPENMIGRATE_WP_ENGINE_SECURITY_AUDITOR_NAME,
			OPENMIGRATE_MUPLUGINS_NAME . DIRECTORY_SEPARATOR . OPENMIGRATE_WP_CERBER_SECURITY_NAME,
			OPENMIGRATE_MUPLUGINS_NAME . DIRECTORY_SEPARATOR . OPENMIGRATE_SQLITE_DATABASE_INTEGRATION_NAME,
			OPENMIGRATE_MUPLUGINS_NAME . DIRECTORY_SEPARATOR . OPENMIGRATE_SQLITE_DATABASE_ZERO_NAME,
			OPENMIGRATE_MUPLUGINS_NAME . DIRECTORY_SEPARATOR . OPENMIGRATE_EOS_DEACTIVATE_PLUGINS_NAME,
		);

		// Open the archive file for reading
		$archive = new OpenMigrate_Extractor( openmigrate_archive_path( $params ), $decryption_password, $compression_type );

		// Unpack mu-plugins files
		$archive->extract_by_files_array( WP_CONTENT_DIR, array( OPENMIGRATE_MUPLUGINS_NAME ), $exclude_files );

		// Close the archive file
		$archive->close();

		// Set progress
		OpenMigrate_Status::info( __( 'Mu-plugins activated.', 'open-migrate' ) );

		return $params;
	}
}
