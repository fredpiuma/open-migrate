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

class OpenMigrate_Export_Download {

	public static function execute( $params ) {

		// Get archive CRC value
		$archive_crc_value = null;
		if ( isset( $params['archive_crc_value'] ) ) {
			$archive_crc_value = $params['archive_crc_value'];
		}

		// Set progress
		OpenMigrate_Status::info( __( 'Renaming export file...', 'open-migrate' ) );

		// Open the archive file for writing
		$archive = new OpenMigrate_Compressor( openmigrate_archive_path( $params ) );

		// Append EOF block
		$archive->close( true, $archive_crc_value );

		// Rename archive file
		if ( rename( openmigrate_archive_path( $params ), openmigrate_backup_path( $params ) ) ) {
			$blog_id = null;

			// Get subsite Blog ID
			if ( isset( $params['options']['sites'] ) && ( $sites = $params['options']['sites'] ) ) {
				if ( count( $sites ) === 1 ) {
					$blog_id = array_shift( $sites );
				}
			}

			// Set archive details
			$file = openmigrate_archive_name( $params );
			$link = openmigrate_backup_url( $params );
			$size = openmigrate_backup_size( $params );
			$name = openmigrate_site_name( $blog_id );

			// Set progress
			if ( openmigrate_direct_download_supported() ) {
				OpenMigrate_Status::download(
					sprintf(
						/* translators: 1: Link to archive, 2: Archive title, 3: File name, 4: Archive title, 5: File size. */
						__(
							'<a href="%1$s" class="openmigrate-button-green openmigrate-emphasize openmigrate-button-download" title="%2$s" download="%3$s">
							<span>Download %2$s</span>
							<em>Size: %4$s</em>
							</a>',
							'open-migrate'
						),
						$link,
						$name,
						$file,
						$size
					)
				);
			} else {
				OpenMigrate_Status::download(
					sprintf(
						/* translators: 1: Archive title, 2: File name, 3: Archive title, 4: File size. */
						__(
							'<a href="#" class="openmigrate-button-green openmigrate-emphasize openmigrate-direct-download" title="%1$s" download="%2$s">
							<span>Download %3$s</span>
							<em>Size: %4$s</em>
							</a>',
							'open-migrate'
						),
						$name,
						$file,
						$name,
						$size
					)
				);
			}
		}

		do_action( 'openmigrate_status_export_done', $params );

		// Run manual on backup created hook
		if ( isset( $params['openmigrate_manual_backup'] ) ) {
			do_action( 'openmigrate_status_backup_created', $params );
		}

		return $params;
	}
}
