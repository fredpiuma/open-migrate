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

class OpenMigrate_Import_Blogs {

	public static function execute( $params ) {

		// Set progress
		OpenMigrate_Status::info( __( 'Preparing blogs...', 'open-migrate' ) );

		$blogs = array();

		// Check multisite.json file
		if ( true === is_file( openmigrate_multisite_path( $params ) ) ) {

			// Read multisite.json file
			$handle = openmigrate_open( openmigrate_multisite_path( $params ), 'r' );

			// Parse multisite.json file
			$multisite = openmigrate_read( $handle, filesize( openmigrate_multisite_path( $params ) ) );
			$multisite = json_decode( $multisite, true );

			// Close handle
			openmigrate_close( $handle );

			// Validate
			if ( empty( $multisite['Network'] ) ) {
				if ( isset( $multisite['Sites'] ) && ( $sites = $multisite['Sites'] ) ) {
					if ( count( $sites ) === 1 && ( $subsite = current( $sites ) ) ) {

						// Set internal Site URL (backward compatibility)
						if ( empty( $subsite['InternalSiteURL'] ) ) {
							$subsite['InternalSiteURL'] = null;
						}

						// Set internal Home URL (backward compatibility)
						if ( empty( $subsite['InternalHomeURL'] ) ) {
							$subsite['InternalHomeURL'] = null;
						}

						// Set active plugins (backward compatibility)
						if ( empty( $subsite['Plugins'] ) ) {
							$subsite['Plugins'] = array();
						}

						// Set active template (backward compatibility)
						if ( empty( $subsite['Template'] ) ) {
							$subsite['Template'] = null;
						}

						// Set active stylesheet (backward compatibility)
						if ( empty( $subsite['Stylesheet'] ) ) {
							$subsite['Stylesheet'] = null;
						}

						// Set uploads path (backward compatibility)
						if ( empty( $subsite['Uploads'] ) ) {
							$subsite['Uploads'] = null;
						}

						// Set uploads URL path (backward compatibility)
						if ( empty( $subsite['UploadsURL'] ) ) {
							$subsite['UploadsURL'] = null;
						}

						// Set uploads path (backward compatibility)
						if ( empty( $subsite['WordPress']['Uploads'] ) ) {
							$subsite['WordPress']['Uploads'] = null;
						}

						// Set uploads URL path (backward compatibility)
						if ( empty( $subsite['WordPress']['UploadsURL'] ) ) {
							$subsite['WordPress']['UploadsURL'] = null;
						}

						// Set blog items
						$blogs[] = array(
							'Old' => array(
								'BlogID'          => $subsite['BlogID'],
								'SiteURL'         => $subsite['SiteURL'],
								'HomeURL'         => $subsite['HomeURL'],
								'InternalSiteURL' => $subsite['InternalSiteURL'],
								'InternalHomeURL' => $subsite['InternalHomeURL'],
								'Plugins'         => $subsite['Plugins'],
								'Template'        => $subsite['Template'],
								'Stylesheet'      => $subsite['Stylesheet'],
								'Uploads'         => $subsite['Uploads'],
								'UploadsURL'      => $subsite['UploadsURL'],
								'WordPress'       => $subsite['WordPress'],
							),
							'New' => array(
								'BlogID'          => null,
								'SiteURL'         => site_url(),
								'HomeURL'         => home_url(),
								'InternalSiteURL' => site_url(),
								'InternalHomeURL' => home_url(),
								'Plugins'         => $subsite['Plugins'],
								'Template'        => $subsite['Template'],
								'Stylesheet'      => $subsite['Stylesheet'],
								'Uploads'         => get_option( 'upload_path' ),
								'UploadsURL'      => get_option( 'upload_url_path' ),
								'WordPress'       => array(
									'UploadsURL' => openmigrate_get_uploads_url(),
								),
							),
						);
					} else {
						throw new OpenMigrate_Import_Exception( esc_html__( 'The archive must contain only a single WordPress site. The process cannot continue. Please revisit your export settings.', 'open-migrate' ) );
					}
				} else {
					throw new OpenMigrate_Import_Exception( esc_html__( 'The archive must contain at least one WordPress site. The process cannot continue. Please check your export settings.', 'open-migrate' ) );
				}
			} else {
				throw new OpenMigrate_Import_Exception( esc_html__( 'Could not import a WordPress Network into a single WordPress site. The process cannot continue. Please check your import settings.', 'open-migrate' ) );
			}
		}

		// Write blogs.json file
		$handle = openmigrate_open( openmigrate_blogs_path( $params ), 'w' );
		openmigrate_write( $handle, json_encode( $blogs ) );
		openmigrate_close( $handle );

		// Set progress
		OpenMigrate_Status::info( __( 'Blogs prepared.', 'open-migrate' ) );

		return $params;
	}
}
