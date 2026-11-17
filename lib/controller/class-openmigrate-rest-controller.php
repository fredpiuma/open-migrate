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

class OpenMigrate_Rest_Controller {

	const REST_NAMESPACE = 'open-migrate/v1';

	/**
	 * Register all REST API routes
	 *
	 * @return void
	 */
	public static function register_routes() {
		// Regex bounds:
		//   job_id — openmigrate_storage_folder() emits uniqid() = 13 lowercase hex chars;
		//     allow {13,40} as a small safety margin for future changes.
		//   name — bound the overall match to 255 chars (common filesystem limit)
		//     including the .wpress suffix.
		$job_id_path = '(?P<job_id>[a-f0-9]{13,40})';
		$name_path   = '(?P<name>[a-zA-Z0-9._-]{1,247}\.wpress)';

		$secret_key_arg = array(
			'secret_key' => array(
				'type'        => 'string',
				'required'    => false,
				'description' => 'Shared-secret auth fallback for status/log polling after an import has invalidated the Application Password.',
			),
		);

		$password_arg = array(
			'password' => array(
				'type'        => 'string',
				'required'    => false,
				'description' => 'Archive password. For exports: enables encryption. For imports: used to decrypt an encrypted archive.',
			),
		);

		// Discovery
		register_rest_route(
			self::REST_NAMESPACE,
			'/capabilities',
			array(
				'methods'             => 'GET',
				'callback'            => array( __CLASS__, 'capabilities' ),
				'permission_callback' => array( __CLASS__, 'can_export' ),
			)
		);

		// Export operations
		register_rest_route(
			self::REST_NAMESPACE,
			'/exports',
			array(
				'methods'             => 'POST',
				'callback'            => array( __CLASS__, 'create_export' ),
				'permission_callback' => array( __CLASS__, 'can_export' ),
				'args'                => array_merge(
					$password_arg,
					array(
						'options'      => array( 'type' => 'object', 'required' => false ),
						'find_replace' => array(
							'type'     => 'array',
							'required' => false,
							'items'    => array(
								'type'                 => 'object',
								'required'             => array( 'find', 'replace' ),
								'properties'           => array(
									'find'    => array( 'type' => 'string' ),
									'replace' => array( 'type' => 'string' ),
								),
								'additionalProperties' => false,
							),
						),
					)
				),
			)
		);

		register_rest_route(
			self::REST_NAMESPACE,
			'/exports/' . $job_id_path,
			array(
				'methods'             => 'GET',
				'callback'            => array( __CLASS__, 'get_export_status' ),
				'permission_callback' => array( __CLASS__, 'can_poll_export' ),
				'args'                => $secret_key_arg,
			)
		);

		register_rest_route(
			self::REST_NAMESPACE,
			'/exports/' . $job_id_path . '/log',
			array(
				'methods'             => 'GET',
				'callback'            => array( __CLASS__, 'get_export_log' ),
				'permission_callback' => array( __CLASS__, 'can_poll_export' ),
				'args'                => $secret_key_arg,
			)
		);

		register_rest_route(
			self::REST_NAMESPACE,
			'/exports/' . $job_id_path,
			array(
				'methods'             => 'DELETE',
				'callback'            => array( __CLASS__, 'cancel_job' ),
				'permission_callback' => array( __CLASS__, 'can_export' ),
			)
		);

		// Import operations
		register_rest_route(
			self::REST_NAMESPACE,
			'/imports',
			array(
				'methods'             => 'POST',
				'callback'            => array( __CLASS__, 'create_import' ),
				'permission_callback' => array( __CLASS__, 'can_import' ),
			)
		);

		register_rest_route(
			self::REST_NAMESPACE,
			'/imports/' . $job_id_path . '/file',
			array(
				'methods'             => 'POST',
				'callback'            => array( __CLASS__, 'upload_import_file' ),
				'permission_callback' => array( __CLASS__, 'can_upload_import_file' ),
				'args'                => array(
					'auto_confirm' => array( 'type' => 'boolean', 'required' => false ),
				),
			)
		);

		register_rest_route(
			self::REST_NAMESPACE,
			'/imports/' . $job_id_path,
			array(
				'methods'             => 'GET',
				'callback'            => array( __CLASS__, 'get_import_status' ),
				'permission_callback' => array( __CLASS__, 'can_poll_import' ),
				'args'                => $secret_key_arg,
			)
		);

		register_rest_route(
			self::REST_NAMESPACE,
			'/imports/' . $job_id_path . '/confirm',
			array(
				'methods'             => 'POST',
				'callback'            => array( __CLASS__, 'confirm_import' ),
				'permission_callback' => array( __CLASS__, 'can_import' ),
				'args'                => array_merge(
					$password_arg,
					array(
						'proceed' => array( 'type' => 'boolean', 'required' => true ),
					)
				),
			)
		);

		register_rest_route(
			self::REST_NAMESPACE,
			'/imports/' . $job_id_path . '/log',
			array(
				'methods'             => 'GET',
				'callback'            => array( __CLASS__, 'get_import_log' ),
				'permission_callback' => array( __CLASS__, 'can_poll_import' ),
				'args'                => $secret_key_arg,
			)
		);

		register_rest_route(
			self::REST_NAMESPACE,
			'/imports/' . $job_id_path,
			array(
				'methods'             => 'DELETE',
				'callback'            => array( __CLASS__, 'cancel_job' ),
				'permission_callback' => array( __CLASS__, 'can_import' ),
			)
		);

		// Backup management
		register_rest_route(
			self::REST_NAMESPACE,
			'/backups',
			array(
				'methods'             => 'GET',
				'callback'            => array( __CLASS__, 'list_backups' ),
				'permission_callback' => array( __CLASS__, 'can_export' ),
			)
		);

		register_rest_route(
			self::REST_NAMESPACE,
			'/backups/' . $name_path,
			array(
				'methods'             => 'GET',
				'callback'            => array( __CLASS__, 'get_backup' ),
				'permission_callback' => array( __CLASS__, 'can_export' ),
			)
		);

		register_rest_route(
			self::REST_NAMESPACE,
			'/backups/' . $name_path,
			array(
				'methods'             => 'PATCH',
				'callback'            => array( __CLASS__, 'update_backup_label' ),
				'permission_callback' => array( __CLASS__, 'can_import' ),
				'args'                => array(
					'label' => array(
						'type'              => 'string',
						'required'          => false,
						'sanitize_callback' => 'sanitize_text_field',
						'validate_callback' => array( __CLASS__, 'validate_label_length' ),
					),
				),
			)
		);

		register_rest_route(
			self::REST_NAMESPACE,
			'/backups/' . $name_path,
			array(
				'methods'             => 'DELETE',
				'callback'            => array( __CLASS__, 'delete_backup' ),
				'permission_callback' => array( __CLASS__, 'can_import' ),
			)
		);

		register_rest_route(
			self::REST_NAMESPACE,
			'/backups/' . $name_path . '/download',
			array(
				'methods'             => 'GET',
				'callback'            => array( __CLASS__, 'download_backup' ),
				'permission_callback' => array( __CLASS__, 'can_export' ),
			)
		);
	}

	// ── Permission callbacks ────────────────────────────────────────────

	/**
	 * @return bool
	 */
	protected static function can_run_on_network() {
		return ! is_multisite() || is_super_admin();
	}

	/**
	 * @return bool
	 */
	public static function can_export() {
		return self::can_run_on_network() && current_user_can( 'openmigrate_export_site' );
	}

	/**
	 * @return bool
	 */
	public static function can_import() {
		return self::can_run_on_network() && current_user_can( 'openmigrate_import_site' );
	}

	/**
	 * Poll/log endpoints: accept either the normal user capability OR a valid
	 * secret_key. Mirrors the wp_ajax_nopriv_openmigrate_status pattern so clients
	 * can keep polling after the import replaces the users table and the
	 * original Application Password stops authenticating.
	 *
	 * @param  WP_REST_Request<array<string, mixed>> $request
	 * @return bool
	 */
	public static function can_poll_export( $request ) {
		return self::can_export() || self::has_valid_secret_key( $request );
	}

	/**
	 * @param  WP_REST_Request<array<string, mixed>> $request
	 * @return bool
	 */
	public static function can_poll_import( $request ) {
		return self::can_import() || self::has_valid_secret_key( $request );
	}

	/**
	 * Upload endpoint gate: require import capability AND that the job_id was
	 * issued by create_import for the current user (prevents cross-user job
	 * clobber). Returns a 404 WP_Error on unknown/foreign job ids rather than
	 * 403 — refusing to confirm whether another user's job exists.
	 *
	 * @param  WP_REST_Request<array<string, mixed>> $request
	 * @return bool|WP_Error
	 */
	public static function can_upload_import_file( $request ) {
		if ( ! self::can_import() ) {
			return false;
		}

		$job_id    = $request->get_param( 'job_id' );
		$issued_to = get_transient( 'openmigrate_rest_import_' . $job_id );
		if ( $issued_to === false || (int) $issued_to !== get_current_user_id() ) {
			return new WP_Error( 'not_found', __( 'Import job not found.', 'open-migrate' ), array( 'status' => 404 ) );
		}

		return true;
	}

	/**
	 * Cap backup label length at 255 chars to keep the wp_options row bounded.
	 *
	 * @param  mixed $label
	 * @return bool|WP_Error
	 */
	public static function validate_label_length( $label ) {
		if ( is_string( $label ) && strlen( $label ) <= 255 ) {
			return true;
		}

		return new WP_Error( 'label_too_long', __( 'Label must be 255 characters or fewer.', 'open-migrate' ), array( 'status' => 400 ) );
	}

	/**
	 * @param  WP_REST_Request<array<string, mixed>> $request
	 * @return bool
	 */
	private static function has_valid_secret_key( $request ) {
		$provided = $request->get_param( 'secret_key' );
		if ( empty( $provided ) || ! is_string( $provided ) ) {
			return false;
		}

		try {
			openmigrate_verify_secret_key( $provided );
			return true;
		} catch ( OpenMigrate_Not_Valid_Secret_Key_Exception $e ) {
			return false;
		}
	}

	/**
	 * Clear WordPress's authentication error for read-only poll/log routes that
	 * carry a valid secret_key. Once an import replaces wp_users/wp_usermeta the
	 * client's Application Password (or login cookie) stops authenticating, and
	 * core rejects the request at the rest_authentication_errors layer before the
	 * route's permission_callback runs. Returning null lets the request reach
	 * can_poll_*, which re-checks the secret_key. Registered at priority 1000 so
	 * it runs after core's application-password (90) and cookie (100) handlers.
	 *
	 * @param  WP_Error|null|true $result Current authentication result
	 * @return WP_Error|null|true
	 */
	public static function allow_secret_key_auth( $result ) {
		// Only act once WordPress has already rejected authentication.
		if ( ! is_wp_error( $result ) ) {
			return $result;
		}

		// Poll/log endpoints are GET only.
		if ( ! isset( $_SERVER['REQUEST_METHOD'] ) || $_SERVER['REQUEST_METHOD'] !== 'GET' ) {
			return $result;
		}

		// Limit to the import status and log routes. Export never replaces
		// wp_users/wp_usermeta, so the client's credentials stay valid and this
		// fallback is not needed there.
		$route = isset( $GLOBALS['wp']->query_vars['rest_route'] ) ? $GLOBALS['wp']->query_vars['rest_route'] : '';
		if ( ! preg_match( '#^/' . self::REST_NAMESPACE . '/imports/[a-f0-9]{13,40}(/log)?$#', $route ) ) {
			return $result;
		}

		// Require a valid secret key supplied as a query parameter.
		$provided = isset( $_GET['secret_key'] ) ? stripslashes_deep( $_GET['secret_key'] ) : '';
		if ( ! is_string( $provided ) || $provided === '' ) {
			return $result;
		}

		try {
			openmigrate_verify_secret_key( $provided );
		} catch ( OpenMigrate_Not_Valid_Secret_Key_Exception $e ) {
			return $result;
		}

		return null;
	}

	// ── Discovery ───────────────────────────────────────────────────────

	/**
	 * GET /capabilities
	 *
	 * @param  WP_REST_Request<array<string, mixed>> $request
	 * @return WP_REST_Response
	 */
	public static function capabilities( $request ) {
		$capabilities = array(
			'export'                => self::can_export(),
			'import'                => self::can_import(),
			'max_upload_size'       => wp_max_upload_size(),
			'max_upload_size_human' => size_format( wp_max_upload_size() ),
			'wordpress_version'     => get_bloginfo( 'version' ),
			'php_version'           => PHP_VERSION,
			'plugin_version'        => OPENMIGRATE_VERSION,
			'site_url'              => site_url(),
			'storage_path_writable' => is_writable( OPENMIGRATE_STORAGE_PATH ),
			'available_space'       => openmigrate_disk_free_space( OPENMIGRATE_STORAGE_PATH ),
			'available_space_human' => size_format( openmigrate_disk_free_space( OPENMIGRATE_STORAGE_PATH ) ),
			'encryption_supported'  => openmigrate_can_encrypt(),
		);

		return new WP_REST_Response( apply_filters( 'openmigrate_rest_capabilities', $capabilities ), 200 );
	}

	// ── Export operations ───────────────────────────────────────────────

	/**
	 * POST /exports
	 *
	 * @param  WP_REST_Request<array<string, mixed>> $request
	 * @return WP_REST_Response|WP_Error
	 */
	public static function create_export( $request ) {
		$params = self::build_export_params( $request );

		try {
			$params = OpenMigrate_Export_Controller::export( $params );
		} catch ( Exception $e ) {
			return new WP_Error( 'export_failed', $e->getMessage(), array( 'status' => 500 ) );
		}

		$response = new WP_REST_Response(
			array(
				'job_id'     => $params['storage'],
				'status'     => 'running',
				'message'    => __( 'Preparing export...', 'open-migrate' ),
				'secret_key' => $params['secret_key'],
			),
			202
		);
		$response->header( 'Location', rest_url( self::REST_NAMESPACE . '/exports/' . $params['storage'] ) );

		return $response;
	}

	/**
	 * GET /exports/{job_id}
	 *
	 * @param  WP_REST_Request<array<string, mixed>> $request
	 * @return WP_REST_Response
	 */
	public static function get_export_status( $request ) {
		return self::read_job_status( $request->get_param( 'job_id' ) );
	}

	/**
	 * GET /exports/{job_id}/log
	 *
	 * @param  WP_REST_Request<array<string, mixed>> $request
	 * @return WP_REST_Response
	 */
	public static function get_export_log( $request ) {
		return self::read_job_log( $request->get_param( 'job_id' ) );
	}

	// ── Import operations ───────────────────────────────────────────────

	/**
	 * POST /imports
	 *
	 * @param  WP_REST_Request<array<string, mixed>> $request
	 * @return WP_REST_Response
	 */
	public static function create_import( $request ) {
		$job_id = openmigrate_storage_folder();

		// Record that this job id was issued to the current user, so /file uploads
		// can't target a job id belonging to another in-flight export/import.
		// TTL auto-expires if the client never calls /file.
		set_transient( 'openmigrate_rest_import_' . $job_id, get_current_user_id(), HOUR_IN_SECONDS );

		return new WP_REST_Response(
			array(
				'job_id' => $job_id,
				'status' => 'awaiting_upload',
			),
			201
		);
	}

	/**
	 * POST /imports/{job_id}/file (multipart/form-data with upload_file field)
	 *
	 * @param  WP_REST_Request<array<string, mixed>> $request
	 * @return WP_REST_Response|WP_Error
	 */
	public static function upload_import_file( $request ) {
		$job_id = $request->get_param( 'job_id' );

		// Ownership already validated in can_upload_import_file; consume the
		// one-shot transient so the job id cannot be reused.
		delete_transient( 'openmigrate_rest_import_' . $job_id );

		// Prefer the REST abstraction; fall back to $_FILES for WP versions /
		// request paths where get_file_params() is unavailable or empty.
		$files       = $request->get_file_params();
		$upload_file = isset( $files['upload_file'] ) ? $files['upload_file'] : ( isset( $_FILES['upload_file'] ) ? $_FILES['upload_file'] : null );

		if ( ! is_array( $upload_file ) ) {
			return new WP_Error(
				'no_file',
				__( 'No file attached. Use the "upload_file" multipart field.', 'open-migrate' ),
				array( 'status' => 400 )
			);
		}

		$upload_error = isset( $upload_file['error'] ) ? (int) $upload_file['error'] : UPLOAD_ERR_OK;
		switch ( $upload_error ) {
			case UPLOAD_ERR_OK:
				break;
			case UPLOAD_ERR_INI_SIZE:
			case UPLOAD_ERR_FORM_SIZE:
				return new WP_Error( 'file_too_large', self::upload_limit_message(), array( 'status' => 413 ) );
			case UPLOAD_ERR_NO_FILE:
				return new WP_Error(
					'no_file',
					__( 'No file was uploaded.', 'open-migrate' ),
					array( 'status' => 400 )
				);
			case UPLOAD_ERR_PARTIAL:
				return new WP_Error(
					'upload_incomplete',
					__( 'The uploaded file was only partially received.', 'open-migrate' ),
					array( 'status' => 400 )
				);
			case UPLOAD_ERR_NO_TMP_DIR:
			case UPLOAD_ERR_CANT_WRITE:
			case UPLOAD_ERR_EXTENSION:
			default:
				return new WP_Error(
					'upload_failed',
					__( 'The server could not accept the uploaded file. Check the server logs.', 'open-migrate' ),
					array( 'status' => 500 )
				);
		}

		if ( empty( $upload_file['tmp_name'] ) ) {
			return new WP_Error(
				'upload_failed',
				__( 'The upload finished without producing a readable file.', 'open-migrate' ),
				array( 'status' => 500 )
			);
		}

		$params = array(
			'storage' => $job_id,
			'archive' => sanitize_file_name( $upload_file['name'] ),
		);

		if ( $request->get_param( 'auto_confirm' ) ) {
			$params['openmigrate_confirmed'] = 1;
		}

		// Start import pipeline at priority 5 (Import_Upload handles validation + copy)
		$params['priority']   = 5;
		$params['secret_key'] = get_option( OPENMIGRATE_SECRET_KEY );

		try {
			$params = OpenMigrate_Import_Controller::import( $params );
		} catch ( OpenMigrate_Upload_Exception $e ) {
			$message = ( $e->getCode() === 413 ) ? self::upload_limit_message() : $e->getMessage();

			return new WP_Error( 'upload_error', $message, array( 'status' => $e->getCode() ) );
		} catch ( OpenMigrate_Not_Decryptable_Exception $e ) {
			// Check_Encryption halted the pipeline (encrypted archive, bad password, or no decrypt support).
			// Storage preserved; client reads type/status from the status option.
			return self::read_job_status( $job_id );
		} catch ( Exception $e ) {
			return new WP_Error( 'import_failed', $e->getMessage(), array( 'status' => 500 ) );
		}

		$response = new WP_REST_Response(
			array(
				'job_id'     => $job_id,
				'status'     => 'running',
				'message'    => __( 'Importing...', 'open-migrate' ),
				'secret_key' => $params['secret_key'],
			),
			202
		);
		$response->header( 'Location', rest_url( self::REST_NAMESPACE . '/imports/' . $job_id ) );

		return $response;
	}

	/**
	 * GET /imports/{job_id}
	 *
	 * @param  WP_REST_Request<array<string, mixed>> $request
	 * @return WP_REST_Response
	 */
	public static function get_import_status( $request ) {
		return self::read_job_status( $request->get_param( 'job_id' ) );
	}

	/**
	 * POST /imports/{job_id}/confirm
	 *
	 * @param  WP_REST_Request<array<string, mixed>> $request
	 * @return WP_REST_Response|WP_Error
	 */
	public static function confirm_import( $request ) {
		$job_id = $request->get_param( 'job_id' );

		// Verify job is actually waiting for confirmation
		$status      = get_option( 'openmigrate_status_' . $job_id, array() );
		$status_type = isset( $status['type'] ) ? $status['type'] : '';
		if ( ! in_array( $status_type, array( 'confirm', 'disk_space_confirm', 'backup_is_encrypted' ), true ) ) {
			return new WP_Error(
				'conflict',
				__( 'Import is not waiting for confirmation.', 'open-migrate' ),
				array( 'status' => 409 )
			);
		}

		if ( ! $request->has_param( 'proceed' ) ) {
			return new WP_Error(
				'missing_proceed',
				__( 'The proceed parameter is required. Use DELETE /imports/{id} to cancel.', 'open-migrate' ),
				array( 'status' => 400 )
			);
		}

		if ( ! $request->get_param( 'proceed' ) ) {
			// Explicit proceed=false — cancel the import
			self::cleanup_job( $job_id );
			return new WP_REST_Response(
				array(
					'job_id' => $job_id,
					'status' => 'canceled',
				),
				200
			);
		}

		$params = array(
			'storage'         => $job_id,
			// Recover the archive name from status; the confirm halt dropped it from request params
			'archive'         => isset( $status['archive'] ) ? $status['archive'] : '',
			'openmigrate_confirmed' => 1,
			// Resume priority: encrypted backup resumes decrypt stage, others skip confirm
			'priority'        => ( $status_type === 'backup_is_encrypted' ) ? 75 : 150,
			'secret_key'      => get_option( OPENMIGRATE_SECRET_KEY ),
		);

		$password = $request->get_param( 'password' );
		if ( ! empty( $password ) && is_string( $password ) ) {
			$params['decryption_password'] = $password;
		}

		try {
			OpenMigrate_Import_Controller::import( $params );
		} catch ( OpenMigrate_Not_Decryptable_Exception $e ) {
			// Wrong password (or still-missing one) on resume — status option already reflects it
			return self::read_job_status( $job_id );
		} catch ( Exception $e ) {
			return new WP_Error( 'import_failed', $e->getMessage(), array( 'status' => 500 ) );
		}

		return new WP_REST_Response(
			array(
				'job_id'     => $job_id,
				'status'     => 'running',
				'message'    => __( 'Importing...', 'open-migrate' ),
				'secret_key' => $params['secret_key'],
			),
			200
		);
	}

	/**
	 * GET /imports/{job_id}/log
	 *
	 * @param  WP_REST_Request<array<string, mixed>> $request
	 * @return WP_REST_Response
	 */
	public static function get_import_log( $request ) {
		return self::read_job_log( $request->get_param( 'job_id' ) );
	}

	// ── Shared job operations ───────────────────────────────────────────

	/**
	 * DELETE /exports/{job_id} or /imports/{job_id}
	 *
	 * @param  WP_REST_Request<array<string, mixed>> $request
	 * @return WP_REST_Response
	 */
	public static function cancel_job( $request ) {
		$job_id = $request->get_param( 'job_id' );

		// Write cancel marker to status
		update_option(
			'openmigrate_status_' . $job_id,
			array(
				'type'    => 'canceled',
				'title'   => __( 'Canceled', 'open-migrate' ),
				'message' => __( 'Operation canceled by REST API.', 'open-migrate' ),
			),
			false
		);

		// Clean up storage folder and log file
		self::cleanup_job( $job_id );

		return new WP_REST_Response(
			array(
				'job_id' => $job_id,
				'status' => 'canceled',
			),
			200
		);
	}

	// ── Backup management ───────────────────────────────────────────────

	/**
	 * GET /backups
	 *
	 * @param  WP_REST_Request<array<string, mixed>> $request
	 * @return WP_REST_Response
	 */
	public static function list_backups( $request ) {
		$backups      = array();
		$files        = OpenMigrate_Backups::get_files();
		$labels       = OpenMigrate_Backups::get_labels();
		$downloadable = OpenMigrate_Backups::are_downloadable();

		foreach ( $files as $file ) {
			$backups[] = self::format_backup( $file, $labels, $downloadable );
		}

		return new WP_REST_Response( array( 'backups' => $backups ), 200 );
	}

	/**
	 * GET /backups/{name}
	 *
	 * @param  WP_REST_Request<array<string, mixed>> $request
	 * @return WP_REST_Response|WP_Error
	 */
	public static function get_backup( $request ) {
		$name = $request->get_param( 'name' );

		$backup_file = self::find_backup( $name );
		if ( $backup_file === false ) {
			return new WP_Error( 'not_found', __( 'Backup not found.', 'open-migrate' ), array( 'status' => 404 ) );
		}

		$backup = self::format_backup( $backup_file, OpenMigrate_Backups::get_labels(), OpenMigrate_Backups::are_downloadable() );

		// Extract config metadata from archive
		try {
			$config = self::extract_backup_config( $name );
			if ( $config !== false ) {
				$backup['config'] = $config;
			}
		} catch ( Exception $e ) {
			// Config extraction failed, continue without it
		}

		return new WP_REST_Response( $backup, 200 );
	}

	/**
	 * PATCH /backups/{name}
	 *
	 * @param  WP_REST_Request<array<string, mixed>> $request
	 * @return WP_REST_Response|WP_Error
	 */
	public static function update_backup_label( $request ) {
		$name = $request->get_param( 'name' );

		// Verify backup exists
		if ( self::find_backup( $name ) === false ) {
			return new WP_Error( 'not_found', __( 'Backup not found.', 'open-migrate' ), array( 'status' => 404 ) );
		}

		$label = $request->get_param( 'label' );
		$label = ! empty( $label ) ? sanitize_text_field( $label ) : '';

		if ( empty( $label ) ) {
			OpenMigrate_Backups::delete_label( $name );
		} else {
			OpenMigrate_Backups::set_label( $name, $label );
		}

		return new WP_REST_Response(
			array(
				'name'  => $name,
				'label' => empty( $label ) ? '' : $label,
			),
			200
		);
	}

	/**
	 * DELETE /backups/{name}
	 *
	 * @param  WP_REST_Request<array<string, mixed>> $request
	 * @return WP_REST_Response|WP_Error
	 */
	public static function delete_backup( $request ) {
		$name = $request->get_param( 'name' );

		// Verify backup exists
		if ( self::find_backup( $name ) === false ) {
			return new WP_Error( 'not_found', __( 'Backup not found.', 'open-migrate' ), array( 'status' => 404 ) );
		}

		try {
			OpenMigrate_Backups::delete_file( $name );
			OpenMigrate_Backups::delete_label( $name );
		} catch ( Exception $e ) {
			return new WP_Error( 'delete_failed', $e->getMessage(), array( 'status' => 500 ) );
		}

		return new WP_REST_Response( array( 'deleted' => true ), 200 );
	}

	/**
	 * GET /backups/{name}/download
	 *
	 * @param  WP_REST_Request<array<string, mixed>> $request
	 * @return WP_REST_Response|WP_Error
	 */
	public static function download_backup( $request ) {
		$name = $request->get_param( 'name' );

		$backup_file = self::find_backup( $name );
		if ( $backup_file === false ) {
			return new WP_Error( 'not_found', __( 'Backup not found.', 'open-migrate' ), array( 'status' => 404 ) );
		}

		if ( ! OpenMigrate_Backups::are_downloadable() ) {
			return new WP_Error(
				'not_downloadable',
				__( 'Backups are stored outside the web root on this host and cannot be downloaded via URL.', 'open-migrate' ),
				array( 'status' => 409 )
			);
		}

		return new WP_REST_Response(
			array(
				'name'         => $backup_file['filename'],
				'download_url' => openmigrate_backup_url( array( 'archive' => $backup_file['filename'] ) ),
				'size'         => $backup_file['size'],
				'size_human'   => size_format( $backup_file['size'] ),
			),
			200
		);
	}

	// ── Private helpers ─────────────────────────────────────────────────

	/**
	 * Build export params from a REST request
	 *
	 * @param  WP_REST_Request<array<string, mixed>> $request REST request
	 * @return array<string, mixed>                  Pipeline params
	 */
	private static function build_export_params( $request ) {
		$params = array(
			'secret_key' => get_option( OPENMIGRATE_SECRET_KEY ),
			'options'    => array(),
		);

		// Set export options (whitelist to prevent param injection)
		$options = $request->get_param( 'options' );
		if ( is_array( $options ) ) {
			$allowed = apply_filters(
				'openmigrate_rest_export_options_whitelist',
				array(
					'no_spam_comments',
					'no_post_revisions',
					'no_media',
					'no_themes',
					'no_inactive_themes',
					'no_muplugins',
					'no_plugins',
					'no_inactive_plugins',
					'no_cache',
					'no_database',
					'no_email_replace',
				)
			);
			foreach ( $allowed as $key ) {
				if ( isset( $options[ $key ] ) ) {
					$params['options'][ $key ] = $options[ $key ];
				}
			}
		}

		// Set find and replace (pipeline expects columnar shape: old_value[] / new_value[])
		$find_replace = $request->get_param( 'find_replace' );
		if ( is_array( $find_replace ) ) {
			$params['options']['replace'] = array( 'old_value' => array(), 'new_value' => array() );
			foreach ( $find_replace as $pair ) {
				if ( isset( $pair['find'], $pair['replace'] ) && is_string( $pair['find'] ) && is_string( $pair['replace'] ) ) {
					$params['options']['replace']['old_value'][] = $pair['find'];
					$params['options']['replace']['new_value'][] = $pair['replace'];
				}
			}
		}

		// Set archive password — pipeline gates encryption on encrypt_backups + encrypt_password
		$password = $request->get_param( 'password' );
		if ( ! empty( $password ) && is_string( $password ) ) {
			$params['options']['encrypt_backups']  = true;
			$params['options']['encrypt_password'] = $password;
		}

		// Apply premium plugin filters
		$params = apply_filters( 'openmigrate_rest_export_params', $params );

		return $params;
	}

	/**
	 * Read job-scoped status and augment for REST response
	 *
	 * @param  string $job_id Job ID (storage folder name)
	 * @return WP_REST_Response
	 */
	private static function read_job_status( $job_id ) {
		$data = get_option( 'openmigrate_status_' . $job_id, array() );

		// No status yet (race condition between POST and first loopback write)
		if ( empty( $data ) ) {
			return new WP_REST_Response(
				array(
					'job_id'  => $job_id,
					'type'    => 'progress',
					'status'  => 'running',
					'percent' => 0,
					'message' => __( 'Preparing...', 'open-migrate' ),
				),
				200
			);
		}

		// Augment with job_id
		$data['job_id'] = $job_id;

		// Derive simplified status from type
		$type = isset( $data['type'] ) ? $data['type'] : '';
		switch ( $type ) {
			case 'progress':
			case 'info':
				$data['status'] = 'running';
				break;
			case 'confirm':
			case 'disk_space_confirm':
			case 'backup_is_encrypted':
				$data['status'] = 'confirm';
				break;
			case 'done':
			case 'download':
				$data['status'] = 'complete';
				break;
			case 'error':
			case 'server_cannot_decrypt':
				$data['status'] = 'error';
				break;
			case 'canceled':
				$data['status'] = 'canceled';
				break;
			case 'blogs':
				$data['status']  = 'error';
				$data['message'] = __( 'Multisite blog selection is not supported via the REST API. Please use the admin interface.', 'open-migrate' );
				break;
			default:
				$data['status'] = 'running';
				break;
		}

		// Augment confirm type with archive_info from package.json
		if ( $type === 'confirm' ) {
			$archive_info = self::read_archive_info( $job_id );
			if ( $archive_info !== false ) {
				$data['archive_info'] = $archive_info;
			}
		}

		return new WP_REST_Response( $data, 200 );
	}

	/**
	 * Read job error log
	 *
	 * @param  string $job_id Job ID (storage folder name)
	 * @return WP_REST_Response
	 */
	private static function read_job_log( $job_id ) {
		$log_path = openmigrate_error_path( $job_id );

		$log = '';
		if ( file_exists( $log_path ) ) {
			$log = file_get_contents( $log_path );
		}

		return new WP_REST_Response(
			array(
				'job_id' => $job_id,
				'log'    => $log,
			),
			200
		);
	}

	/**
	 * Clean up a job's storage folder and log file
	 *
	 * @param  string $job_id Job ID (storage folder name)
	 * @return void
	 */
	private static function cleanup_job( $job_id ) {
		$params = array( 'storage' => $job_id );

		try {
			OpenMigrate_Directory::delete( openmigrate_storage_path( $params ) );
		} catch ( Exception $e ) {
			// Storage may already be deleted
		}

		// Delete log file
		$log_path = openmigrate_error_path( $job_id );
		if ( file_exists( $log_path ) ) {
			openmigrate_unlink( $log_path );
		}

		delete_transient( 'openmigrate_rest_import_' . $job_id );
	}

	/**
	 * Format a backup file for REST response
	 *
	 * @param  array<string, mixed>  $file         Backup file from OpenMigrate_Backups::get_files()
	 * @param  array<string, string> $labels       Labels from OpenMigrate_Backups::get_labels()
	 * @param  boolean               $downloadable Whether direct download URLs are available
	 * @return array<string, mixed>
	 */
	private static function format_backup( $file, $labels, $downloadable ) {
		$backup = array(
			'name'         => $file['filename'],
			'size'         => $file['size'],
			'size_human'   => size_format( $file['size'] ),
			'created_at'   => gmdate( 'Y-m-d\TH:i:s\Z', $file['mtime'] ),
			'label'        => isset( $labels[ $file['filename'] ] ) ? $labels[ $file['filename'] ] : '',
			'downloadable' => $downloadable,
		);

		if ( $downloadable ) {
			$backup['download_url'] = openmigrate_backup_url( array( 'archive' => $file['filename'] ) );
		}

		return $backup;
	}

	/**
	 * Find a backup file by name
	 *
	 * @param  string                     $name Backup filename
	 * @return array<string, mixed>|false       Backup file info or false
	 */
	private static function find_backup( $name ) {
		$files = OpenMigrate_Backups::get_files();
		foreach ( $files as $file ) {
			if ( $file['filename'] === $name ) {
				return $file;
			}
		}

		return false;
	}

	/**
	 * Extract config metadata from backup's package.json
	 *
	 * @param  string                     $name Backup filename
	 * @return array<string, mixed>|false       Config data or false
	 */
	private static function extract_backup_config( $name ) {
		$params  = array( 'archive' => $name, 'storage' => openmigrate_storage_folder() );
		$storage = openmigrate_storage_path( $params );

		try {
			$archive = new OpenMigrate_Extractor( openmigrate_backup_path( $params ) );
			$archive->extract_by_files_array( $storage, array( OPENMIGRATE_PACKAGE_NAME ) );
			$archive->close();

			$config = self::parse_package( $storage . DIRECTORY_SEPARATOR . OPENMIGRATE_PACKAGE_NAME );

			OpenMigrate_Directory::delete( $storage );

			return $config;
		} catch ( Exception $e ) {
			try {
				OpenMigrate_Directory::delete( $storage );
			} catch ( Exception $e2 ) {
				// Ignore
			}
		}

		return false;
	}

	/**
	 * Read archive_info from the job's storage folder (package.json extracted by pipeline)
	 *
	 * @param  string                     $job_id Job ID
	 * @return array<string, mixed>|false
	 */
	private static function read_archive_info( $job_id ) {
		$params = array( 'storage' => $job_id );

		return self::parse_package( openmigrate_storage_path( $params ) . DIRECTORY_SEPARATOR . OPENMIGRATE_PACKAGE_NAME );
	}

	/**
	 * Parse package.json file into config array
	 *
	 * @param  string                     $path Path to package.json
	 * @return array<string, mixed>|false
	 */
	private static function parse_package( $path ) {
		if ( ! file_exists( $path ) ) {
			return false;
		}

		$contents = file_get_contents( $path );
		if ( $contents === false ) {
			return false;
		}

		$package = json_decode( $contents, true );
		if ( ! is_array( $package ) ) {
			return false;
		}

		return array(
			'wordpress_version' => isset( $package['WordPress']['Version'] ) ? $package['WordPress']['Version'] : null,
			'php_version'       => isset( $package['PHP']['Version'] ) ? $package['PHP']['Version'] : null,
			'plugin_version'    => isset( $package['Plugin']['Version'] ) ? $package['Plugin']['Version'] : null,
			'site_url'          => isset( $package['SiteURL'] ) ? $package['SiteURL'] : null,
			'encrypted'         => ! empty( $package['Encrypted'] ),
		);
	}

	/**
	 * Upload limit exceeded message (matches browser UI copy)
	 *
	 * @return string
	 */
	private static function upload_limit_message() {
		return sprintf(
			/* translators: Max upload file size */
			__( 'Your file exceeds the %s upload limit of this PHP/web server. Use the chunked upload in the admin screen, WP-CLI (wp openmigrate import) or place the file in the backups folder.', 'open-migrate' ),
			openmigrate_size_format( wp_max_upload_size() )
		);
	}
}
