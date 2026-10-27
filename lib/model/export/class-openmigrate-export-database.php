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

class OpenMigrate_Export_Database {

	public static function execute( $params ) {

		// Set exclude database
		if ( isset( $params['options']['no_database'] ) ) {
			return $params;
		}

		// Set query offset
		if ( isset( $params['query_offset'] ) ) {
			$query_offset = (int) $params['query_offset'];
		} else {
			$query_offset = 0;
		}

		// Set table index
		if ( isset( $params['table_index'] ) ) {
			$table_index = (int) $params['table_index'];
		} else {
			$table_index = 0;
		}

		// Set table offset
		if ( isset( $params['table_offset'] ) ) {
			$table_offset = (int) $params['table_offset'];
		} else {
			$table_offset = 0;
		}

		// Set table rows
		if ( isset( $params['table_rows'] ) ) {
			$table_rows = (int) $params['table_rows'];
		} else {
			$table_rows = 0;
		}

		// Set total tables count
		if ( isset( $params['total_tables_count'] ) ) {
			$total_tables_count = (int) $params['total_tables_count'];
		} else {
			$total_tables_count = 1;
		}

		// What percent of tables have we processed?
		$progress = (int) ( ( $table_index / $total_tables_count ) * 100 );

		// Set progress
		/* translators: 1: Progress, 2: Number of records. */
		OpenMigrate_Status::info( sprintf( __( 'Exporting database...<br />%1$d%% complete<br />%2$s records saved', 'open-migrate' ), $progress, number_format_i18n( $table_rows ) ) );

		// Get tables list file
		$tables_list = openmigrate_open( openmigrate_tables_list_path( $params ), 'r' );

		// Loop over tables
		$tables = array();
		while ( ( $row = openmigrate_getcsv( $tables_list ) ) !== false ) {
			list( $table_name ) = $row;
			$tables[] = $table_name; // phpcs:ignore Generic.Formatting.MultipleStatementAlignment.NotSameWarning
		}

		// Close the tables list file
		openmigrate_close( $tables_list );

		// Get database client
		$db_client = OpenMigrate_Database_Utility::get_client();

		// Exclude spam comments
		if ( isset( $params['options']['no_spam_comments'] ) ) {
			$db_client->set_table_where_query( openmigrate_table_prefix() . 'comments', "`comment_approved` != 'spam'" )
				->set_table_where_query( openmigrate_table_prefix() . 'commentmeta', sprintf( "`comment_ID` IN ( SELECT `comment_ID` FROM `%s` WHERE `comment_approved` != 'spam' )", openmigrate_table_prefix() . 'comments' ) );
		}

		// Exclude post revisions
		if ( isset( $params['options']['no_post_revisions'] ) ) {
			$db_client->set_table_where_query( openmigrate_table_prefix() . 'posts', "`post_type` != 'revision'" )
				->set_table_where_query( openmigrate_table_prefix() . 'postmeta', sprintf( "`post_id` IN ( SELECT `ID` FROM `%s` WHERE `post_type` != 'revision' )", openmigrate_table_prefix() . 'posts' ) );
		}

		$old_table_prefixes = $old_column_prefixes = array();
		$new_table_prefixes = $new_column_prefixes = array();

		// Set table prefixes
		if ( openmigrate_table_prefix() ) {
			$old_table_prefixes[] = openmigrate_table_prefix();
			$new_table_prefixes[] = openmigrate_servmask_prefix();
		} else {
			foreach ( $tables as $table_name ) {
				$old_table_prefixes[] = $table_name;
				$new_table_prefixes[] = openmigrate_servmask_prefix() . $table_name;
			}
		}

		// Set column prefixes
		if ( strlen( openmigrate_table_prefix() ) > 1 ) {
			$old_column_prefixes[] = openmigrate_table_prefix();
			$new_column_prefixes[] = openmigrate_servmask_prefix();
		} else {
			foreach ( array( 'user_roles', 'capabilities', 'user_level', 'dashboard_quick_press_last_post_id', 'user-settings', 'user-settings-time' ) as $column_prefix ) {
				$old_column_prefixes[] = openmigrate_table_prefix() . $column_prefix;
				$new_column_prefixes[] = openmigrate_servmask_prefix() . $column_prefix;
			}
		}

		$db_client->set_tables( $tables )
			->set_old_table_prefixes( $old_table_prefixes )
			->set_new_table_prefixes( $new_table_prefixes )
			->set_old_column_prefixes( $old_column_prefixes )
			->set_new_column_prefixes( $new_column_prefixes );

		// Exclude column prefixes
		$db_client->set_reserved_column_prefixes( array( 'wp_force_deactivated_plugins', 'wp_page_for_privacy_policy', 'wp_rocket_settings', 'wp_rocket_dismiss_imagify_notice', 'wp_rocket_no_licence', 'wp_rocket_rocketcdn_old_url', 'wp_rocket_hide_deactivation_form' ) );

		// Exclude site options
		$db_client->set_table_where_query( openmigrate_table_prefix() . 'options', sprintf( "`option_name` NOT IN ('%s', '%s', '%s', '%s', '%s', '%s', '%s')", OPENMIGRATE_STATUS, OPENMIGRATE_SECRET_KEY, OPENMIGRATE_AUTH_USER, OPENMIGRATE_AUTH_PASSWORD, OPENMIGRATE_AUTH_HEADER, OPENMIGRATE_BACKUPS_LABELS, OPENMIGRATE_SITES_LINKS ) );

		// Set table select columns
		if ( ( $column_names = $db_client->get_column_names( openmigrate_table_prefix() . 'options' ) ) ) {
			if ( isset( $column_names['option_name'], $column_names['option_value'] ) ) {
				$column_names['option_value'] = sprintf( "(CASE WHEN option_name = '%s' THEN 'a:0:{}' WHEN (option_name = '%s' OR option_name = '%s') THEN '' ELSE option_value END) AS option_value", OPENMIGRATE_ACTIVE_PLUGINS, OPENMIGRATE_ACTIVE_TEMPLATE, OPENMIGRATE_ACTIVE_STYLESHEET );
			}

			$db_client->set_table_select_columns( openmigrate_table_prefix() . 'options', $column_names );
		}

		// Set table prefix columns
		$db_client->set_table_prefix_columns( openmigrate_table_prefix() . 'options', array( 'option_name' ) )
			->set_table_prefix_columns( openmigrate_table_prefix() . 'usermeta', array( 'meta_key' ) );

		// Export database
		if ( $db_client->export( openmigrate_database_path( $params ), $query_offset, $table_index, $table_offset, $table_rows ) ) {

			// Set progress
			OpenMigrate_Status::info( __( 'Database exported.', 'open-migrate' ) );

			// Unset query offset
			unset( $params['query_offset'] );

			// Unset table index
			unset( $params['table_index'] );

			// Unset table offset
			unset( $params['table_offset'] );

			// Unset table rows
			unset( $params['table_rows'] );

			// Unset total tables count
			unset( $params['total_tables_count'] );

			// Unset completed flag
			unset( $params['completed'] );

		} else {

			// What percent of tables have we processed?
			$progress = (int) ( ( $table_index / $total_tables_count ) * 100 );

			// Set progress
			/* translators: 1: Progress, 2: Number of records. */
			OpenMigrate_Status::info( sprintf( __( 'Exporting database...<br />%1$d%% complete<br />%2$s records saved', 'open-migrate' ), $progress, number_format_i18n( $table_rows ) ) );

			// Set query offset
			$params['query_offset'] = $query_offset;

			// Set table index
			$params['table_index'] = $table_index;

			// Set table offset
			$params['table_offset'] = $table_offset;

			// Set table rows
			$params['table_rows'] = $table_rows;

			// Set total tables count
			$params['total_tables_count'] = $total_tables_count;

			// Set completed flag
			$params['completed'] = false;
		}

		return $params;
	}
}
