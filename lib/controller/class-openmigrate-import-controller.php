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

class OpenMigrate_Import_Controller {

	public static function index() {
		OpenMigrate_Template::render( 'import/index' );
	}

	public static function import( $params = array() ) {
		global $openmigrate_params;

		// Set params
		if ( empty( $params ) ) {
			$params = stripslashes_deep( array_merge( $_GET, $_POST ) );
		}

		// Set priority
		if ( ! isset( $params['priority'] ) ) {
			$params['priority'] = 10;
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
			// Ensure that unauthorized people cannot access import action
			openmigrate_verify_secret_key( $secret_key );
		} catch ( OpenMigrate_Not_Valid_Secret_Key_Exception $e ) {
			exit;
		}

		// Error handling is set up for the authorised request, after the secret-key check.
		openmigrate_setup_errors();

		// Release the caller before the work starts
		openmigrate_close_connection( $params );

		// Loop over filters
		if ( ( $filters = openmigrate_get_filters( 'openmigrate_import' ) ) ) {
			while ( $hooks = current( $filters ) ) {
				if ( intval( $params['priority'] ) === key( $filters ) ) {
					foreach ( $hooks as $hook ) {
						try {

							// Run function hook
							$params = call_user_func_array( $hook['function'], array( $params ) );

						} catch ( OpenMigrate_Upload_Exception $e ) {
							do_action( 'openmigrate_status_upload_error', $params, $e );

							if ( defined( 'WP_CLI' ) ) {
								/* translators: 1: Error code, 2: Error message. */
								WP_CLI::error( sprintf( __( 'Import failed. Code: %1$s. %2$s', 'open-migrate' ), $e->getCode(), $e->getMessage() ) );
							}

							// REST API: write job-scoped error so poll clients see the terminal state, then re-throw
							if ( defined( 'REST_REQUEST' ) && REST_REQUEST ) {
								OpenMigrate_Status::error( __( 'Import failed', 'open-migrate' ), $e->getMessage() );
								throw $e;
							}

							status_header( $e->getCode() );
							openmigrate_json_response( array( 'errors' => array( array( 'code' => $e->getCode(), 'message' => $e->getMessage() ) ) ) );
							exit;
						} catch ( OpenMigrate_Database_Exception $e ) {
							do_action( 'openmigrate_status_import_error', $params, $e );

							if ( defined( 'WP_CLI' ) ) {
								/* translators: 1: Error code, 2: Error message. */
								WP_CLI::error( sprintf( __( 'Import failed (database error). Code: %1$s. %2$s', 'open-migrate' ), $e->getCode(), $e->getMessage() ) );
							}

							// REST API: write job-scoped error so poll clients see the terminal state, then re-throw
							if ( defined( 'REST_REQUEST' ) && REST_REQUEST ) {
								OpenMigrate_Status::error( __( 'Import failed', 'open-migrate' ), $e->getMessage() );
								throw $e;
							}

							status_header( $e->getCode() );
							openmigrate_json_response( array( 'errors' => array( array( 'code' => $e->getCode(), 'message' => $e->getMessage() ) ) ) );
							exit;
						} catch ( OpenMigrate_Not_Decryptable_Exception $e ) {
							// Check_Encryption signals pipeline halt; storage/status preserved for retry via /confirm
							if ( defined( 'REST_REQUEST' ) && REST_REQUEST ) {
								throw $e;
							}

							exit;
						} catch ( Exception $e ) {
							do_action( 'openmigrate_status_import_error', $params, $e );

							if ( defined( 'WP_CLI' ) ) {
								/* translators: Error message. */
								WP_CLI::error( sprintf( __( 'Import failed: %s', 'open-migrate' ), $e->getMessage() ) );
							}

							// Write job-scoped error first so REST poll clients see the terminal state
							if ( $e instanceof OpenMigrate_CRC_Exception ) {
								OpenMigrate_Status::left_error( __( 'Import failed', 'open-migrate' ), $e->getMessage() );
							} else {
								OpenMigrate_Status::error( __( 'Import failed', 'open-migrate' ), $e->getMessage() );
							}

							// REST API: re-throw so the handler can return a WP_Error
							if ( defined( 'REST_REQUEST' ) && REST_REQUEST ) {
								throw $e;
							}

							OpenMigrate_Notification::error( __( 'Import failed', 'open-migrate' ), $e->getMessage() );
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

						if ( isset( $params['openmigrate_manual_import'] ) || isset( $params['openmigrate_manual_restore'] ) ) {
							openmigrate_json_response( $params );
							exit;
						}

						wp_remote_request(
							apply_filters( 'openmigrate_http_import_url', add_query_arg( array( 'openmigrate_import' => 1 ), admin_url( 'admin-ajax.php?action=openmigrate_import' ) ) ),
							array(
								'method'    => apply_filters( 'openmigrate_http_import_method', 'POST' ),
								'timeout'   => apply_filters( 'openmigrate_http_import_timeout', 10 ),
								'blocking'  => apply_filters( 'openmigrate_http_import_blocking', false ),
								'sslverify' => apply_filters( 'openmigrate_http_import_sslverify', false ),
								'headers'   => apply_filters( 'openmigrate_http_import_headers', array() ),
								'body'      => apply_filters( 'openmigrate_http_import_body', $params ),
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
		$active_filters = array();
		$static_filters = array();

		// All-in-One WP Migration
		if ( defined( 'OPENMIGRATE_PLUGIN_NAME' ) ) {
			$active_filters[] = apply_filters( 'openmigrate_import_file', OpenMigrate_Template::get_content( 'import/button-file' ) );
		} else {
			$static_filters[] = apply_filters( 'openmigrate_import_file', OpenMigrate_Template::get_content( 'import/button-file' ) );
		}

		// Add Google Drive Extension
		if ( defined( 'OPENMIGRATEGE_PLUGIN_NAME' ) ) {
			$active_filters[] = apply_filters( 'openmigrate_import_gdrive', OpenMigrate_Template::get_content( 'import/button-gdrive' ) );
		} else {
			$static_filters[] = apply_filters( 'openmigrate_import_gdrive', OpenMigrate_Template::get_content( 'import/button-gdrive' ) );
		}

		// Add FTP Extension
		if ( defined( 'OPENMIGRATEFE_PLUGIN_NAME' ) ) {
			$active_filters[] = apply_filters( 'openmigrate_import_ftp', OpenMigrate_Template::get_content( 'import/button-ftp' ) );
		} else {
			$static_filters[] = apply_filters( 'openmigrate_import_ftp', OpenMigrate_Template::get_content( 'import/button-ftp' ) );
		}

		// Add Dropbox Extension
		if ( defined( 'OPENMIGRATEDE_PLUGIN_NAME' ) ) {
			$active_filters[] = apply_filters( 'openmigrate_import_dropbox', OpenMigrate_Template::get_content( 'import/button-dropbox' ) );
		} else {
			$static_filters[] = apply_filters( 'openmigrate_import_dropbox', OpenMigrate_Template::get_content( 'import/button-dropbox' ) );
		}

		// Add URL Extension
		if ( defined( 'OPENMIGRATELE_PLUGIN_NAME' ) ) {
			$active_filters[] = apply_filters( 'openmigrate_import_url', OpenMigrate_Template::get_content( 'import/button-url' ) );
		} else {
			$static_filters[] = apply_filters( 'openmigrate_import_url', OpenMigrate_Template::get_content( 'import/button-url' ) );
		}

		// Add Amazon S3 Extension
		if ( defined( 'OPENMIGRATESE_PLUGIN_NAME' ) ) {
			$active_filters[] = apply_filters( 'openmigrate_import_s3', OpenMigrate_Template::get_content( 'import/button-s3' ) );
		} else {
			$static_filters[] = apply_filters( 'openmigrate_import_s3', OpenMigrate_Template::get_content( 'import/button-s3' ) );
		}

		// Add OneDrive Extension
		if ( defined( 'OPENMIGRATEOE_PLUGIN_NAME' ) ) {
			$active_filters[] = apply_filters( 'openmigrate_import_onedrive', OpenMigrate_Template::get_content( 'import/button-onedrive' ) );
		} else {
			$static_filters[] = apply_filters( 'openmigrate_import_onedrive', OpenMigrate_Template::get_content( 'import/button-onedrive' ) );
		}

		// Add pCloud Extension
		if ( defined( 'OPENMIGRATEPE_PLUGIN_NAME' ) ) {
			$active_filters[] = apply_filters( 'openmigrate_import_pcloud', OpenMigrate_Template::get_content( 'import/button-pcloud' ) );
		} else {
			$static_filters[] = apply_filters( 'openmigrate_import_pcloud', OpenMigrate_Template::get_content( 'import/button-pcloud' ) );
		}

		// Add S3 Client Extension
		if ( defined( 'OPENMIGRATENE_PLUGIN_NAME' ) ) {
			$active_filters[] = apply_filters( 'openmigrate_import_s3_client', OpenMigrate_Template::get_content( 'import/button-s3-client' ) );
		} else {
			$static_filters[] = apply_filters( 'openmigrate_import_s3_client', OpenMigrate_Template::get_content( 'import/button-s3-client' ) );
		}

		// Add Google Cloud Storage Extension
		if ( defined( 'OPENMIGRATECE_PLUGIN_NAME' ) ) {
			$active_filters[] = apply_filters( 'openmigrate_import_gcloud_storage', OpenMigrate_Template::get_content( 'import/button-gcloud-storage' ) );
		} else {
			$static_filters[] = apply_filters( 'openmigrate_import_gcloud_storage', OpenMigrate_Template::get_content( 'import/button-gcloud-storage' ) );
		}

		// Add DigitalOcean Spaces Extension
		if ( defined( 'OPENMIGRATEIE_PLUGIN_NAME' ) ) {
			$active_filters[] = apply_filters( 'openmigrate_import_digitalocean', OpenMigrate_Template::get_content( 'import/button-digitalocean' ) );
		} else {
			$static_filters[] = apply_filters( 'openmigrate_import_digitalocean', OpenMigrate_Template::get_content( 'import/button-digitalocean' ) );
		}

		// Add Mega Extension
		if ( defined( 'OPENMIGRATEEE_PLUGIN_NAME' ) ) {
			$active_filters[] = apply_filters( 'openmigrate_import_mega', OpenMigrate_Template::get_content( 'import/button-mega' ) );
		} else {
			$static_filters[] = apply_filters( 'openmigrate_import_mega', OpenMigrate_Template::get_content( 'import/button-mega' ) );
		}

		// Add Backblaze B2 Extension
		if ( defined( 'OPENMIGRATEAE_PLUGIN_NAME' ) ) {
			$active_filters[] = apply_filters( 'openmigrate_import_b2', OpenMigrate_Template::get_content( 'import/button-b2' ) );
		} else {
			$static_filters[] = apply_filters( 'openmigrate_import_b2', OpenMigrate_Template::get_content( 'import/button-b2' ) );
		}

		// Add Box Extension
		if ( defined( 'OPENMIGRATEBE_PLUGIN_NAME' ) ) {
			$active_filters[] = apply_filters( 'openmigrate_import_box', OpenMigrate_Template::get_content( 'import/button-box' ) );
		} else {
			$static_filters[] = apply_filters( 'openmigrate_import_box', OpenMigrate_Template::get_content( 'import/button-box' ) );
		}

		// Add Microsoft Azure Extension
		if ( defined( 'OPENMIGRATEZE_PLUGIN_NAME' ) ) {
			$active_filters[] = apply_filters( 'openmigrate_import_azure_storage', OpenMigrate_Template::get_content( 'import/button-azure-storage' ) );
		} else {
			$static_filters[] = apply_filters( 'openmigrate_import_azure_storage', OpenMigrate_Template::get_content( 'import/button-azure-storage' ) );
		}

		// Add WebDAV Extension
		if ( defined( 'OPENMIGRATEWE_PLUGIN_NAME' ) ) {
			$active_filters[] = apply_filters( 'openmigrate_import_webdav', OpenMigrate_Template::get_content( 'import/button-webdav' ) );
		} else {
			$static_filters[] = apply_filters( 'openmigrate_import_webdav', OpenMigrate_Template::get_content( 'import/button-webdav' ) );
		}

		// Add Amazon Glacier Extension
		if ( defined( 'OPENMIGRATERE_PLUGIN_NAME' ) ) {
			$active_filters[] = apply_filters( 'openmigrate_import_glacier', OpenMigrate_Template::get_content( 'import/button-glacier' ) );
		} else {
			$static_filters[] = apply_filters( 'openmigrate_import_glacier', OpenMigrate_Template::get_content( 'import/button-glacier' ) );
		}

		return array_merge( $active_filters, $static_filters );
	}

	public static function pro() {
		return OpenMigrate_Template::get_content( 'import/pro' );
	}

	public static function max_chunk_size() {
		return min(
			openmigrate_parse_size( ini_get( 'post_max_size' ), OPENMIGRATE_MAX_CHUNK_SIZE ),
			openmigrate_parse_size( ini_get( 'upload_max_filesize' ), OPENMIGRATE_MAX_CHUNK_SIZE ),
			openmigrate_parse_size( OPENMIGRATE_MAX_CHUNK_SIZE )
		);
	}
}
