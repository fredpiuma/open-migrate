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

class OpenMigrate_Export_Enumerate_Content {

	public static function execute( $params ) {

		$exclude_filters = array_merge( array( openmigrate_get_uploads_dir(), openmigrate_get_plugins_dir() ), openmigrate_get_themes_dirs() );

		// Get total content files count
		if ( isset( $params['total_content_files_count'] ) ) {
			$total_content_files_count = (int) $params['total_content_files_count'];
		} else {
			$total_content_files_count = 1;
		}

		// Get total content files size
		if ( isset( $params['total_content_files_size'] ) ) {
			$total_content_files_size = (int) $params['total_content_files_size'];
		} else {
			$total_content_files_size = 1;
		}

		// Set progress
		OpenMigrate_Status::info( __( 'Gathering content files...', 'open-migrate' ) );

		// Exclude cache
		if ( isset( $params['options']['no_cache'] ) ) {
			$exclude_filters[] = 'cache';
		}

		// Exclude must-use plugins
		if ( isset( $params['options']['no_muplugins'] ) ) {
			$exclude_filters[] = 'mu-plugins';
		}

		// Exclude media
		if ( isset( $params['options']['no_media'] ) ) {
			$exclude_filters[] = 'blogs.dir';
		}

		// Exclude SQLite database and its journal files
		if ( defined( 'DB_PATH' ) ) {
			$exclude_filters[] = DB_PATH;
			$exclude_filters[] = DB_PATH . '-wal';
			$exclude_filters[] = DB_PATH . '-shm';
			$exclude_filters[] = DB_PATH . '-journal';
		} elseif ( defined( 'FQDB' ) ) {
			$exclude_filters[] = FQDB;
			$exclude_filters[] = FQDB . '-wal';
			$exclude_filters[] = FQDB . '-shm';
			$exclude_filters[] = FQDB . '-journal';
		}

		// Exclude SQLite storage files
		if ( defined( 'FQDBDIR' ) ) {
			if ( ( $sqlite_randomized_files = glob( FQDBDIR . '.ht.*' ) ) ) {
				foreach ( $sqlite_randomized_files as $sqlite_randomized_file ) {
					$exclude_filters[] = $sqlite_randomized_file;
				}
			}

			$exclude_filters[] = FQDBDIR . 'db-path.php';
		}

		// Exclude selected files
		if ( isset( $params['options']['exclude_files'], $params['excluded_files'] ) ) {
			if ( ( $excluded_files = explode( ',', $params['excluded_files'] ) ) ) {
				foreach ( $excluded_files as $excluded_path ) {
					$exclude_filters[] = WP_CONTENT_DIR . DIRECTORY_SEPARATOR . untrailingslashit( $excluded_path );
				}
			}
		}

		// Create content list file
		$content_list = openmigrate_open( openmigrate_content_list_path( $params ), 'w' );

		// Enumerate over content directory
		if ( isset( $params['options']['no_themes'], $params['options']['no_muplugins'], $params['options']['no_plugins'] ) === false ) {

			// Iterate over content directory
			$iterator = new OpenMigrate_Recursive_Directory_Iterator( WP_CONTENT_DIR );

			// Exclude content files
			$iterator = new OpenMigrate_Recursive_Exclude_Filter( $iterator, apply_filters( 'openmigrate_exclude_content_from_export', openmigrate_content_filters( $exclude_filters ) ) );

			// Recursively iterate over content directory
			$iterator = new OpenMigrate_Recursive_Iterator_Iterator( $iterator, RecursiveIteratorIterator::LEAVES_ONLY, RecursiveIteratorIterator::CATCH_GET_CHILD );

			// Write path line
			foreach ( $iterator as $item ) {
				if ( $item->isFile() ) {
					if ( openmigrate_putcsv( $content_list, array( $iterator->getPathname(), $iterator->getSubPathname(), $iterator->getSize(), $iterator->getMTime() ) ) ) {
						$total_content_files_count++;

						// Add current file size
						$total_content_files_size += $iterator->getSize();
					}
				}
			}
		}

		// Set progress
		OpenMigrate_Status::info( __( 'Content files gathered.', 'open-migrate' ) );

		// Set total content files count
		$params['total_content_files_count'] = $total_content_files_count;

		// Set total content files size
		$params['total_content_files_size'] = $total_content_files_size;

		// Close the content list file
		openmigrate_close( $content_list );

		return $params;
	}
}
