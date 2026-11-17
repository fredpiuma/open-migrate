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

class OpenMigrate_Import_Check_Compression {

	public static function execute( $params ) {

		// Read package.json file
		$handle = openmigrate_open( openmigrate_package_path( $params ), 'r' );

		// Parse package.json file
		$package = openmigrate_read( $handle, filesize( openmigrate_package_path( $params ) ) );
		$package = json_decode( $package, true );

		// Close handle
		openmigrate_close( $handle );

		// No compression provided
		if ( empty( $package['Compression']['Enabled'] ) || empty( $package['Compression']['Type'] ) ) {
			return $params;
		}

		// Check if server supports decompression
		if ( ! openmigrate_has_compression_type( $package['Compression']['Type'] ) ) {
			throw new OpenMigrate_Import_Exception(
				wp_kses(
					sprintf(
						__(
							'Importing a compressed backup is not supported on this server.
							Please ensure <strong>%s</strong> extension is enabled.',
							'open-migrate'
						),
						$package['Compression']['Type']
					),
					openmigrate_allowed_html_tags()
				)
			);
		}

		// Set progres
		OpenMigrate_Status::info( __( 'Compressed backup detected. Compression will be handled automatically.', 'open-migrate' ) );

		return $params;
	}
}
