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

class OpenMigrate_Import_Content {

	public static function execute( $params ) {

		// Set decryption password
		$decryption_password = null;
		if ( isset( $params['decryption_password'] ) ) {
			$decryption_password = $params['decryption_password'];
		}

		// Set archive bytes offset
		if ( isset( $params['archive_bytes_offset'] ) ) {
			$archive_bytes_offset = (int) $params['archive_bytes_offset'];
		} else {
			$archive_bytes_offset = 0;
		}

		// Set file bytes offset
		if ( isset( $params['file_bytes_offset'] ) ) {
			$file_bytes_offset = (int) $params['file_bytes_offset'];
		} else {
			$file_bytes_offset = 0;
		}

		// Set file bytes written
		if ( isset( $params['file_bytes_written'] ) ) {
			$file_bytes_written = (int) $params['file_bytes_written'];
		} else {
			$file_bytes_written = 0;
		}

		// Get processed files size
		if ( isset( $params['processed_files_size'] ) ) {
			$processed_files_size = (int) $params['processed_files_size'];
		} else {
			$processed_files_size = 0;
		}

		// Get total files size
		if ( isset( $params['total_files_size'] ) ) {
			$total_files_size = (int) $params['total_files_size'];
		} else {
			$total_files_size = 1;
		}

		// Get total files count
		if ( isset( $params['total_files_count'] ) ) {
			$total_files_count = (int) $params['total_files_count'];
		} else {
			$total_files_count = 1;
		}

		// Read blogs.json file
		$handle = openmigrate_open( openmigrate_blogs_path( $params ), 'r' );

		// Parse blogs.json file
		$blogs = openmigrate_read( $handle, filesize( openmigrate_blogs_path( $params ) ) );
		$blogs = json_decode( $blogs, true );

		// Close handle
		openmigrate_close( $handle );

		// Read package.json file
		$handle = openmigrate_open( openmigrate_package_path( $params ), 'r' );

		// Parse package.json file
		$config = openmigrate_read( $handle, filesize( openmigrate_package_path( $params ) ) );
		$config = json_decode( $config, true );

		// Close handle
		openmigrate_close( $handle );

		// What percent of files have we processed?
		$progress = (int) min( ( $processed_files_size / $total_files_size ) * 100, 100 );

		// Set progress
		/* translators: 1: Number of files, 2: Progress. */
		OpenMigrate_Status::info( sprintf( __( 'Restoring %1$d files...<br />%2$d%% complete', 'open-migrate' ), $total_files_count, $progress ) );

		// Flag to hold if file data has been processed
		$completed = true;

		// Start time
		$start = microtime( true );

		// Get compression type
		$compression_type = null;
		if ( ! empty( $config['Compression']['Enabled'] ) ) {
			$compression_type = $config['Compression']['Type'];
		}

		// Open the archive file for reading
		$archive = new OpenMigrate_Extractor( openmigrate_archive_path( $params ), $decryption_password, $compression_type );

		// Set the file pointer to the one that we have saved
		$archive->set_file_pointer( $archive_bytes_offset );

		$old_paths = array( 'plugins', 'themes' );
		$new_paths = array( openmigrate_get_plugins_dir(), get_theme_root() );

		// Set extract paths
		foreach ( $blogs as $blog ) {
			if ( openmigrate_is_mainsite( $blog['Old']['BlogID'] ) === false ) {
				if ( defined( 'UPLOADBLOGSDIR' ) ) {
					// Old files dir style
					$old_paths[] = openmigrate_blog_files_relpath( $blog['Old']['BlogID'] );
					$new_paths[] = openmigrate_blog_files_abspath( $blog['New']['BlogID'] );

					// Old blogs.dir style
					$old_paths[] = openmigrate_blog_blogsdir_relpath( $blog['Old']['BlogID'] );
					$new_paths[] = openmigrate_blog_blogsdir_abspath( $blog['New']['BlogID'] );

					// New sites dir style
					$old_paths[] = openmigrate_blog_sites_relpath( $blog['Old']['BlogID'] );
					$new_paths[] = openmigrate_blog_files_abspath( $blog['New']['BlogID'] );
				} else {
					// Old files dir style
					$old_paths[] = openmigrate_blog_files_relpath( $blog['Old']['BlogID'] );
					$new_paths[] = openmigrate_blog_sites_abspath( $blog['New']['BlogID'] );

					// Old blogs.dir style
					$old_paths[] = openmigrate_blog_blogsdir_relpath( $blog['Old']['BlogID'] );
					$new_paths[] = openmigrate_blog_sites_abspath( $blog['New']['BlogID'] );

					// New sites dir style
					$old_paths[] = openmigrate_blog_sites_relpath( $blog['Old']['BlogID'] );
					$new_paths[] = openmigrate_blog_sites_abspath( $blog['New']['BlogID'] );
				}
			}
		}

		// Set base site extract paths (should be added at the end of arrays)
		foreach ( $blogs as $blog ) {
			if ( openmigrate_is_mainsite( $blog['Old']['BlogID'] ) === true ) {
				if ( defined( 'UPLOADBLOGSDIR' ) ) {
					// Old files dir style
					$old_paths[] = openmigrate_blog_files_relpath( $blog['Old']['BlogID'] );
					$new_paths[] = openmigrate_blog_files_abspath( $blog['New']['BlogID'] );

					// Old blogs.dir style
					$old_paths[] = openmigrate_blog_blogsdir_relpath( $blog['Old']['BlogID'] );
					$new_paths[] = openmigrate_blog_blogsdir_abspath( $blog['New']['BlogID'] );

					// New sites dir style
					$old_paths[] = openmigrate_blog_sites_relpath( $blog['Old']['BlogID'] );
					$new_paths[] = openmigrate_blog_files_abspath( $blog['New']['BlogID'] );
				} else {
					// Old files dir style
					$old_paths[] = openmigrate_blog_files_relpath( $blog['Old']['BlogID'] );
					$new_paths[] = openmigrate_blog_sites_abspath( $blog['New']['BlogID'] );

					// Old blogs.dir style
					$old_paths[] = openmigrate_blog_blogsdir_relpath( $blog['Old']['BlogID'] );
					$new_paths[] = openmigrate_blog_sites_abspath( $blog['New']['BlogID'] );

					// New sites dir style
					$old_paths[] = openmigrate_blog_sites_relpath( $blog['Old']['BlogID'] );
					$new_paths[] = openmigrate_blog_sites_abspath( $blog['New']['BlogID'] );
				}
			}
		}

		$old_paths[] = openmigrate_blog_sites_relpath();
		$new_paths[] = openmigrate_blog_sites_abspath();

		while ( $archive->has_not_reached_eof() ) {
			$file_bytes_read = 0;

			// Exclude WordPress files
			$exclude_files = array_keys( _get_dropins() );

			// Exclude plugin files
			$exclude_files = array_merge(
				$exclude_files,
				array(
					OPENMIGRATE_PACKAGE_NAME,
					OPENMIGRATE_MULTISITE_NAME,
					OPENMIGRATE_DATABASE_NAME,
					OPENMIGRATE_MUPLUGINS_NAME,
				)
			);

			// Exclude theme files
			$exclude_files = array_merge( $exclude_files, array( OPENMIGRATE_THEMES_FUNCTIONS_NAME ) );

			// Exclude Elementor files
			$exclude_files = array_merge( $exclude_files, array( OPENMIGRATE_ELEMENTOR_CSS_NAME ) );

			// Exclude CiviCRM config, regenerable caches and temp files. These are
			// environment specific and rebuilt on the destination, so restoring them
			// would carry over the source paths, URLs and DB credentials. Real data
			// under custom/, persist/ and ext/ is restored untouched.
			$exclude_files = array_merge(
				$exclude_files,
				array(
					OPENMIGRATE_CIVICRM_SETTINGS_NAME,
					OPENMIGRATE_CIVICRM_TEMPLATES_C_NAME,
					OPENMIGRATE_CIVICRM_CONFIG_AND_LOG_NAME,
					OPENMIGRATE_CIVICRM_UPLOAD_NAME,
					OPENMIGRATE_CIVICRM_DYNAMIC_NAME,
				)
			);

			// Preserve the destination SQLite path, including when restoring older backups
			$exclude_files[] = OPENMIGRATE_SQLITE_DATABASE_PATH_NAME;

			// Exclude content extensions
			$exclude_extensions = array(
				OPENMIGRATE_LESS_CACHE_EXTENSION,
				OPENMIGRATE_SQLITE_DATABASE_EXTENSION,
				OPENMIGRATE_SQLITE_DATABASE_EXTENSION . '-wal',
				OPENMIGRATE_SQLITE_DATABASE_EXTENSION . '-shm',
				OPENMIGRATE_SQLITE_DATABASE_EXTENSION . '-journal',
			);

			// Extract a file from archive to WP_CONTENT_DIR
			if ( ( $completed = $archive->extract_one_file_to( WP_CONTENT_DIR, $exclude_files, $exclude_extensions, $old_paths, $new_paths, $file_bytes_read, $file_bytes_offset, $file_bytes_written ) ) ) {
				$file_bytes_offset = $file_bytes_written = 0;
			}

			// Get archive bytes offset
			$archive_bytes_offset = $archive->get_file_pointer();

			// Increment processed files size
			$processed_files_size += $file_bytes_read;

			// What percent of files have we processed?
			$progress = (int) min( ( $processed_files_size / $total_files_size ) * 100, 100 );

			// Set progress
			/* translators: 1: Number of files, 2: Progress. */
			OpenMigrate_Status::info( sprintf( __( 'Restoring %1$d files...<br />%2$d%% complete', 'open-migrate' ), $total_files_count, $progress ) );

			// More than 10 seconds have passed, break and do another request
			if ( ( $timeout = apply_filters( 'openmigrate_completed_timeout', 10 ) ) ) {
				if ( ( microtime( true ) - $start ) > $timeout ) {
					$completed = false;
					break;
				}
			}
		}

		// End of the archive?
		if ( $archive->has_reached_eof() ) {

			// Unset archive bytes offset
			unset( $params['archive_bytes_offset'] );

			// Unset file bytes offset
			unset( $params['file_bytes_offset'] );

			// Unset file bytes written
			unset( $params['file_bytes_written'] );

			// Unset processed files size
			unset( $params['processed_files_size'] );

			// Unset total files size
			unset( $params['total_files_size'] );

			// Unset total files count
			unset( $params['total_files_count'] );

			// Unset completed flag
			unset( $params['completed'] );

		} else {

			// Set archive bytes offset
			$params['archive_bytes_offset'] = $archive_bytes_offset;

			// Set file bytes offset
			$params['file_bytes_offset'] = $file_bytes_offset;

			// Set file bytes written
			$params['file_bytes_written'] = $file_bytes_written;

			// Set processed files size
			$params['processed_files_size'] = $processed_files_size;

			// Set total files size
			$params['total_files_size'] = $total_files_size;

			// Set total files count
			$params['total_files_count'] = $total_files_count;

			// Set completed flag
			$params['completed'] = $completed;
		}

		// Close the archive file
		$archive->close();

		return $params;
	}
}
