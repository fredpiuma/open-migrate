<?php
/**
 * Copyright (C) 2026 Frederico de Castro
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

if ( defined( 'WP_CLI' ) ) {

	/**
	 * Open Migrate commands. Runs the same export/import filter chain as the admin screens,
	 * inside the CLI process (no loopback HTTP requests and no time limit).
	 */
	class OpenMigrate_WP_CLI_Command extends WP_CLI_Command {

		/**
		 * Creates a new backup in the backups folder.
		 *
		 * ## OPTIONS
		 *
		 * [--list]
		 * : List the existing backups instead of creating one.
		 *
		 * [--exclude-spam-comments]
		 * : Do not export spam comments.
		 *
		 * [--exclude-post-revisions]
		 * : Do not export post revisions.
		 *
		 * [--exclude-media]
		 * : Do not export the media library.
		 *
		 * [--exclude-themes]
		 * : Do not export themes.
		 *
		 * [--exclude-inactive-themes]
		 * : Do not export inactive themes.
		 *
		 * [--exclude-muplugins]
		 * : Do not export must-use plugins.
		 *
		 * [--exclude-plugins]
		 * : Do not export plugins.
		 *
		 * [--exclude-inactive-plugins]
		 * : Do not export inactive plugins.
		 *
		 * [--exclude-cache]
		 * : Do not export cache files.
		 *
		 * [--exclude-database]
		 * : Do not export the database.
		 *
		 * [--exclude-email-replace]
		 * : Do not replace the email domain.
		 *
		 * [--replace=<find>]
		 * : Text to find in the database. Use together with --with.
		 *
		 * [--with=<replace>]
		 * : Replacement for --replace. Both options can be repeated through the arguments: wp openmigrate backup "from1" "to1" "from2" "to2" --replace-pairs
		 *
		 * [--replace-pairs]
		 * : Treat the positional arguments as pairs of find/replace values.
		 *
		 * [--password=<password>]
		 * : Encrypt the backup with this password.
		 *
		 * [--compress=<type>]
		 * : Compress the backup (gzip or bzip2, when supported by PHP).
		 *
		 * ## EXAMPLES
		 *
		 *     wp openmigrate backup
		 *     wp openmigrate backup --exclude-media --password=secret
		 *     wp openmigrate backup "http://old.test" "https://new.test" --replace-pairs
		 *
		 * @subcommand backup
		 */
		public function backup( $args = array(), $assoc_args = array() ) {
			$this->ensure_supported();
			$this->ensure_folders();

			if ( isset( $assoc_args['list'] ) ) {
				return $this->list_backups();
			}

			$params = array( 'options' => array() );

			$flags = array(
				'exclude-spam-comments'    => 'no_spam_comments',
				'exclude-post-revisions'   => 'no_post_revisions',
				'exclude-media'            => 'no_media',
				'exclude-themes'           => 'no_themes',
				'exclude-inactive-themes'  => 'no_inactive_themes',
				'exclude-muplugins'        => 'no_muplugins',
				'exclude-plugins'          => 'no_plugins',
				'exclude-inactive-plugins' => 'no_inactive_plugins',
				'exclude-cache'            => 'no_cache',
				'exclude-database'         => 'no_database',
				'exclude-email-replace'    => 'no_email_replace',
			);

			foreach ( $flags as $flag => $option ) {
				if ( isset( $assoc_args[ $flag ] ) ) {
					$params['options'][ $option ] = true;
				}
			}

			if ( isset( $assoc_args['replace'], $assoc_args['with'] ) ) {
				$params['options']['replace']['old_value'][] = $assoc_args['replace'];
				$params['options']['replace']['new_value'][] = $assoc_args['with'];
			}

			if ( isset( $assoc_args['replace-pairs'] ) ) {
				for ( $i = 0; $i + 1 < count( $args ); $i += 2 ) {
					$params['options']['replace']['old_value'][] = $args[ $i ];
					$params['options']['replace']['new_value'][] = $args[ $i + 1 ];
				}
			}

			if ( ! empty( $assoc_args['password'] ) ) {
				if ( ! openmigrate_can_encrypt() ) {
					WP_CLI::error( __( 'Encrypting backups is not supported on this server.', 'open-migrate' ) );
				}

				$params['options']['encrypt_backups']  = true;
				$params['options']['encrypt_password'] = $assoc_args['password'];
			}

			if ( ! empty( $assoc_args['compress'] ) ) {
				if ( ! openmigrate_has_compression_type( $assoc_args['compress'] ) ) {
					WP_CLI::error( __( 'This compression type is not available on this server.', 'open-migrate' ) );
				}

				$params['options']['compression_type'] = $assoc_args['compress'];
			}

			$params['secret_key'] = get_option( OPENMIGRATE_SECRET_KEY );

			WP_CLI::log( __( 'Backup in progress...', 'open-migrate' ) );

			add_filter( 'openmigrate_completed_timeout', '__return_zero' );

			try {
				$params = OpenMigrate_Export_Controller::export( $params );
			} catch ( Exception $e ) {
				WP_CLI::error( $e->getMessage() );
			}

			WP_CLI::log( __( 'Backup complete.', 'open-migrate' ) );
			WP_CLI::log( sprintf( /* translators: Backup path. */ __( 'Backup location: %s', 'open-migrate' ), openmigrate_backup_path( $params ) ) );
		}

		/**
		 * Creates a new backup. Alias of "backup".
		 *
		 * @subcommand export
		 */
		public function export( $args = array(), $assoc_args = array() ) {
			$this->backup( $args, $assoc_args );
		}

		/**
		 * Lists the backups in the backups folder (including those made by the original plugin).
		 *
		 * ## EXAMPLES
		 *
		 *     wp openmigrate list-backups
		 *
		 * @subcommand list-backups
		 */
		public function list_backups( $args = array(), $assoc_args = array() ) {
			$this->ensure_folders();

			$model = new OpenMigrate_Backups();
			$items = array();
			foreach ( $model->get_files() as $backup ) {
				$items[] = array(
					'name' => $backup['filename'],
					'date' => sprintf( /* translators: Human time diff. */ __( '%s ago', 'open-migrate' ), human_time_diff( $backup['mtime'] ) ),
					'size' => is_null( $backup['size'] ) ? '-' : size_format( $backup['size'], 2 ),
				);
			}

			WP_CLI\Utils\format_items( 'table', $items, array( 'name', 'date', 'size' ) );
		}

		/**
		 * Restores a backup that is in the backups folder.
		 *
		 * ## OPTIONS
		 *
		 * <file>
		 * : Backup file name, as shown by list-backups.
		 *
		 * [--yes]
		 * : Do not ask for confirmation.
		 *
		 * [--password=<password>]
		 * : Decryption password for encrypted backups.
		 *
		 * ## EXAMPLES
		 *
		 *     wp openmigrate restore example-20260101-120000-123.wpress --yes
		 *
		 * @subcommand restore
		 */
		public function restore( $args = array(), $assoc_args = array() ) {
			$this->ensure_supported();
			$this->ensure_folders();

			if ( empty( $args[0] ) || basename( $args[0] ) !== $args[0] || ! is_file( OPENMIGRATE_BACKUPS_PATH . DIRECTORY_SEPARATOR . $args[0] ) ) {
				WP_CLI::error_multi_line(
					array(
						__( 'A valid backup name must be provided in order to proceed with the restore process.', 'open-migrate' ),
						__( 'Example: wp openmigrate restore example-20260101-120000-123.wpress', 'open-migrate' ),
					)
				);
				exit( 1 );
			}

			$this->run_import(
				array(
					'storage'                    => openmigrate_storage_folder(),
					'archive'                    => $args[0],
					'openmigrate_manual_restore' => true,
				),
				$assoc_args
			);
		}

		/**
		 * Imports a .wpress file from any local path. Meant for very large files:
		 * the file is linked into the storage folder, not copied.
		 *
		 * ## OPTIONS
		 *
		 * <path>
		 * : Path of the .wpress file.
		 *
		 * [--yes]
		 * : Do not ask for confirmation.
		 *
		 * [--password=<password>]
		 * : Decryption password for encrypted backups.
		 *
		 * ## EXAMPLES
		 *
		 *     wp openmigrate import /data/site.wpress --yes
		 *
		 * @subcommand import
		 */
		public function import( $args = array(), $assoc_args = array() ) {
			$this->ensure_supported();
			$this->ensure_folders();

			if ( empty( $args[0] ) || ! is_file( $args[0] ) || ! is_readable( $args[0] ) ) {
				WP_CLI::error( __( 'Provide the path of a readable .wpress file.', 'open-migrate' ) );
			}

			$source  = realpath( $args[0] );
			$archive = basename( $source );

			if ( ! openmigrate_is_filename_supported( $archive ) || ! openmigrate_is_filedata_supported( $source ) ) {
				WP_CLI::error( __( 'Invalid file. Please provide a .wpress backup.', 'open-migrate' ) );
			}

			$params = array(
				'storage' => openmigrate_storage_folder(),
				'archive' => $archive,
			);

			// A file inside the backups folder is restored in place
			if ( dirname( $source ) === realpath( OPENMIGRATE_BACKUPS_PATH ) ) {
				$params['openmigrate_manual_restore'] = true;
			} else {
				$target = openmigrate_archive_path( $params );
				if ( ! @symlink( $source, $target ) ) {
					WP_CLI::warning( __( 'Could not link the file; copying it to the storage folder instead.', 'open-migrate' ) );
					if ( ! @copy( $source, $target ) ) {
						WP_CLI::error( __( 'Could not copy the file to the storage folder.', 'open-migrate' ) );
					}
				}
			}

			$this->run_import( $params, $assoc_args );
		}

		/**
		 * Deletes a backup from the backups folder.
		 *
		 * ## OPTIONS
		 *
		 * <file>
		 * : Backup file name.
		 *
		 * ## EXAMPLES
		 *
		 *     wp openmigrate delete example-20260101-120000-123.wpress
		 *
		 * @subcommand delete
		 */
		public function delete( $args = array(), $assoc_args = array() ) {
			if ( empty( $args[0] ) || basename( $args[0] ) !== $args[0] || ! openmigrate_is_filename_supported( $args[0] ) ) {
				WP_CLI::error( __( 'A valid backup name must be provided.', 'open-migrate' ) );
			}

			$path = OPENMIGRATE_BACKUPS_PATH . DIRECTORY_SEPARATOR . $args[0];
			if ( ! is_file( $path ) ) {
				WP_CLI::error( __( 'Backup not found.', 'open-migrate' ) );
			}

			$model = new OpenMigrate_Backups();
			$model->delete_file( $args[0] );

			WP_CLI::success( __( 'Backup deleted.', 'open-migrate' ) );
		}

		/**
		 * Runs the import filter chain in this process.
		 *
		 * @param  array $params     Import parameters
		 * @param  array $assoc_args Command options
		 * @return void
		 */
		protected function run_import( $params, $assoc_args ) {
			if ( empty( $assoc_args['yes'] ) ) {
				WP_CLI::confirm( __( 'Importing will replace the content of this site (database and files). Proceed?', 'open-migrate' ), $assoc_args );
			}

			$params['openmigrate_confirmed'] = 1;
			$params['secret_key']            = get_option( OPENMIGRATE_SECRET_KEY );
			$params['priority']              = 10;

			if ( ! empty( $assoc_args['password'] ) ) {
				$params['decryption_password'] = $assoc_args['password'];
			}

			WP_CLI::log( __( 'Import in progress...', 'open-migrate' ) );

			add_filter( 'openmigrate_completed_timeout', '__return_zero' );

			try {
				$params = OpenMigrate_Import_Controller::import( $params );
			} catch ( Exception $e ) {
				WP_CLI::error( $e->getMessage() );
			}

			WP_CLI::success( __( 'Import complete.', 'open-migrate' ) );
		}

		/**
		 * Stops on setups that are not supported.
		 *
		 * @return void
		 */
		protected function ensure_supported() {
			if ( is_multisite() ) {
				WP_CLI::error( __( 'Open Migrate does not support WordPress Multisite yet.', 'open-migrate' ) );
			}

			if ( PHP_INT_SIZE < 8 ) {
				WP_CLI::error( __( 'A 64-bit PHP is required to handle backups larger than 2 GB.', 'open-migrate' ) );
			}
		}

		/**
		 * Creates the storage and backups folders.
		 *
		 * @return void
		 */
		protected function ensure_folders() {
			foreach ( array( OPENMIGRATE_STORAGE_PATH, OPENMIGRATE_BACKUPS_PATH ) as $folder ) {
				if ( ! is_dir( $folder ) && ! mkdir( $folder, 0777, true ) ) {
					/* translators: Folder path. */
					WP_CLI::error( sprintf( __( 'Could not create the folder %s. Create it and grant read/write permissions.', 'open-migrate' ), $folder ) );
				}
			}
		}
	}
}
