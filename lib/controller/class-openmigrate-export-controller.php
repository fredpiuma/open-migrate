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

class OpenMigrate_Export_Controller {

	public static function index() {
		OpenMigrate_Template::render( 'export/index' );
	}

	public static function export( $params = array() ) {
		global $openmigrate_params;

		// Set params
		if ( empty( $params ) ) {
			$params = stripslashes_deep( array_merge( $_GET, $_POST ) );
		}

		// Set priority
		if ( ! isset( $params['priority'] ) ) {
			$params['priority'] = 5;
		}

		$openmigrate_params = $params;

		// Set job ID for per-job status tracking
		if ( isset( $params['storage'] ) ) {
			OpenMigrate_Status::$job_id = $params['storage'];
		}

		// Set secret key
		$secret_key = null;
		if ( isset( $params['secret_key'] ) ) {
			$secret_key = trim( $params['secret_key'] );
		}

		openmigrate_setup_environment();

		try {
			// Ensure that unauthorized people cannot access export action
			openmigrate_verify_secret_key( $secret_key );
		} catch ( OpenMigrate_Not_Valid_Secret_Key_Exception $e ) {
			exit;
		}

		// Error handling is set up for the authorised request, after the secret-key check.
		openmigrate_setup_errors();

		// Release the caller before the work starts
		openmigrate_close_connection( $params );

		// Loop over filters
		if ( ( $filters = openmigrate_get_filters( 'openmigrate_export' ) ) ) {
			while ( $hooks = current( $filters ) ) {
				if ( intval( $params['priority'] ) === key( $filters ) ) {
					foreach ( $hooks as $hook ) {
						try {

							// Run function hook
							$params = call_user_func_array( $hook['function'], array( $params ) );

						} catch ( OpenMigrate_Database_Exception $e ) {
							do_action( 'openmigrate_status_export_error', $params, $e );

							if ( defined( 'WP_CLI' ) ) {
								/* translators: 1: Error code, 2: Error message. */
								WP_CLI::error( sprintf( __( 'Export failed (database error). Code: %1$s. Message: %2$s', 'open-migrate' ), $e->getCode(), $e->getMessage() ) );
							}

							// REST API: write job-scoped error so poll clients see the terminal state, then re-throw
							if ( defined( 'REST_REQUEST' ) && REST_REQUEST ) {
								OpenMigrate_Status::error( __( 'Export failed', 'open-migrate' ), $e->getMessage() );
								throw $e;
							}

							status_header( $e->getCode() );
							openmigrate_json_response( array( 'errors' => array( array( 'code' => $e->getCode(), 'message' => $e->getMessage() ) ) ) );
							exit;
						} catch ( Exception $e ) {
							do_action( 'openmigrate_status_export_error', $params, $e );

							if ( defined( 'WP_CLI' ) ) {
								/* translators: 1: Error message. */
								WP_CLI::error( sprintf( __( 'Export failed: %s', 'open-migrate' ), $e->getMessage() ) );
							}

							// Write job-scoped error first so REST poll clients see the terminal state
							OpenMigrate_Status::error( __( 'Export failed', 'open-migrate' ), $e->getMessage() );

							// REST API: re-throw so the handler can return a WP_Error
							if ( defined( 'REST_REQUEST' ) && REST_REQUEST ) {
								throw $e;
							}

							OpenMigrate_Notification::error( __( 'Export failed', 'open-migrate' ), $e->getMessage() );
							exit;
						}
					}

					// Set completed
					$completed = true;
					if ( isset( $params['completed'] ) ) {
						$completed = (bool) $params['completed'];
					}

					// Do request
					if ( $completed === false || ( $next = next( $filters ) ) && ( $params['priority'] = key( $filters ) ) ) {
						if ( defined( 'WP_CLI' ) ) {
							if ( ! defined( 'DOING_CRON' ) ) {
								continue;
							}
						}

						if ( isset( $params['openmigrate_manual_export'] ) ) {
							openmigrate_json_response( $params );
							exit;
						}

						wp_remote_request(
							apply_filters( 'openmigrate_http_export_url', add_query_arg( array( 'openmigrate_import' => 1 ), admin_url( 'admin-ajax.php?action=openmigrate_export' ) ) ),
							array(
								'method'    => apply_filters( 'openmigrate_http_export_method', 'POST' ),
								'timeout'   => apply_filters( 'openmigrate_http_export_timeout', 10 ),
								'blocking'  => apply_filters( 'openmigrate_http_export_blocking', false ),
								'sslverify' => apply_filters( 'openmigrate_http_export_sslverify', false ),
								'headers'   => apply_filters( 'openmigrate_http_export_headers', array() ),
								'body'      => apply_filters( 'openmigrate_http_export_body', $params ),
							)
						);

						// REST API: return params instead of exit so the handler can build a response
						if ( defined( 'REST_REQUEST' ) && REST_REQUEST ) {
							return $params;
						}

						exit;
					}
				}

				next( $filters );
			}
		}

		return $params;
	}

	public static function buttons() {
		return array( apply_filters( 'openmigrate_export_file', OpenMigrate_Template::get_content( 'export/button-file' ) ) );
	}

	public static function cleanup() {
		try {
			// Iterate over storage directory
			$iterator = new OpenMigrate_Recursive_Directory_Iterator( OPENMIGRATE_STORAGE_PATH );

			// Exclude index.php
			$iterator = new OpenMigrate_Recursive_Exclude_Filter( $iterator, array( 'index.php', 'index.html' ) );

			// Loop over folders and files
			foreach ( $iterator as $item ) {
				try {
					if ( $item->isFile() && $item->getExtension() === 'log' ) {
						if ( $item->getMTime() < ( time() - OPENMIGRATE_MAX_LOG_CLEANUP ) ) {
							OpenMigrate_File::delete( $item->getPathname() );
						}
					} elseif ( $item->getMTime() < ( time() - OPENMIGRATE_MAX_STORAGE_CLEANUP ) ) {
						if ( $item->isDir() ) {
							delete_option( 'openmigrate_status_' . basename( $item->getPathname() ) );
							OpenMigrate_Directory::delete( $item->getPathname() );
						} else {
							OpenMigrate_File::delete( $item->getPathname() );
						}
					}
				} catch ( Exception $e ) {
				}
			}
		} catch ( Exception $e ) {
		}

		// Sweep orphan openmigrate_status_<job_id> options whose storage folder is gone.
		// Pipeline Clean stages delete the folder before this cron sees it, so the
		// folder-iterating loop above can't reach their option rows.
		global $wpdb;
		if ( $wpdb instanceof wpdb ) {
			$prefix       = 'openmigrate_status_';
			$prefix_len   = strlen( $prefix );
			$storage_root = OPENMIGRATE_STORAGE_PATH . DIRECTORY_SEPARATOR;
			$like         = $wpdb->esc_like( $prefix ) . '%';
			// $wpdb->options is a trusted property, not user input.
			// @phpstan-ignore-next-line argument.type
			$sql  = $wpdb->prepare( "SELECT option_name FROM {$wpdb->options} WHERE option_name LIKE %s", $like );
			$rows = $wpdb->get_col( $sql );
			if ( is_array( $rows ) ) {
				foreach ( $rows as $option_name ) {
					$job_id = substr( $option_name, $prefix_len );
					if ( ! preg_match( '/\A[a-zA-Z0-9_-]+\z/', $job_id ) ) {
						continue;
					}
					if ( ! is_dir( $storage_root . $job_id ) ) {
						delete_option( $option_name );
					}
				}
			}
		}
	}
}
