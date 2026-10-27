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

class OpenMigrate_Extensions {

	/**
	 * Get active extensions
	 *
	 * @return array
	 */
	public static function get() {
		$extensions = array();

		// Add Microsoft Azure Extension
		if ( defined( 'OPENMIGRATEZE_PLUGIN_NAME' ) ) {
			$extensions[ OPENMIGRATEZE_PLUGIN_NAME ] = array(
				'key'      => OPENMIGRATEZE_PURCHASE_ID,
				'title'    => OPENMIGRATEZE_PLUGIN_TITLE,
				'about'    => OPENMIGRATEZE_PLUGIN_ABOUT,
				'check'    => OPENMIGRATEZE_PLUGIN_CHECK,
				'basename' => OPENMIGRATEZE_PLUGIN_BASENAME,
				'version'  => OPENMIGRATEZE_VERSION,
				'requires' => '1.57',
				'short'    => OPENMIGRATEZE_PLUGIN_SHORT,
			);
		}

		// Add Backblaze B2 Extension
		if ( defined( 'OPENMIGRATEAE_PLUGIN_NAME' ) ) {
			$extensions[ OPENMIGRATEAE_PLUGIN_NAME ] = array(
				'key'      => OPENMIGRATEAE_PURCHASE_ID,
				'title'    => OPENMIGRATEAE_PLUGIN_TITLE,
				'about'    => OPENMIGRATEAE_PLUGIN_ABOUT,
				'check'    => OPENMIGRATEAE_PLUGIN_CHECK,
				'basename' => OPENMIGRATEAE_PLUGIN_BASENAME,
				'version'  => OPENMIGRATEAE_VERSION,
				'requires' => '1.63',
				'short'    => OPENMIGRATEAE_PLUGIN_SHORT,
			);
		}

		// Add Backup Plugin
		if ( defined( 'OPENMIGRATEVE_PLUGIN_NAME' ) ) {
			$extensions[ OPENMIGRATEVE_PLUGIN_NAME ] = array(
				'key'      => OPENMIGRATEVE_PURCHASE_ID,
				'title'    => OPENMIGRATEVE_PLUGIN_TITLE,
				'about'    => OPENMIGRATEVE_PLUGIN_ABOUT,
				'check'    => OPENMIGRATEVE_PLUGIN_CHECK,
				'basename' => OPENMIGRATEVE_PLUGIN_BASENAME,
				'version'  => OPENMIGRATEVE_VERSION,
				'requires' => '1.0',
				'short'    => OPENMIGRATEVE_PLUGIN_SHORT,
			);
		}

		// Add Box Extension
		if ( defined( 'OPENMIGRATEBE_PLUGIN_NAME' ) ) {
			$extensions[ OPENMIGRATEBE_PLUGIN_NAME ] = array(
				'key'      => OPENMIGRATEBE_PURCHASE_ID,
				'title'    => OPENMIGRATEBE_PLUGIN_TITLE,
				'about'    => OPENMIGRATEBE_PLUGIN_ABOUT,
				'check'    => OPENMIGRATEBE_PLUGIN_CHECK,
				'basename' => OPENMIGRATEBE_PLUGIN_BASENAME,
				'version'  => OPENMIGRATEBE_VERSION,
				'requires' => '1.73',
				'short'    => OPENMIGRATEBE_PLUGIN_SHORT,
			);
		}

		// Add DigitalOcean Spaces Extension
		if ( defined( 'OPENMIGRATEIE_PLUGIN_NAME' ) ) {
			$extensions[ OPENMIGRATEIE_PLUGIN_NAME ] = array(
				'key'      => OPENMIGRATEIE_PURCHASE_ID,
				'title'    => OPENMIGRATEIE_PLUGIN_TITLE,
				'about'    => OPENMIGRATEIE_PLUGIN_ABOUT,
				'check'    => OPENMIGRATEIE_PLUGIN_CHECK,
				'basename' => OPENMIGRATEIE_PLUGIN_BASENAME,
				'version'  => OPENMIGRATEIE_VERSION,
				'requires' => '1.73',
				'short'    => OPENMIGRATEIE_PLUGIN_SHORT,
			);
		}

		// Add Direct Extension
		if ( defined( 'OPENMIGRATEXE_PLUGIN_NAME' ) ) {
			$extensions[ OPENMIGRATEXE_PLUGIN_NAME ] = array(
				'key'      => OPENMIGRATEXE_PURCHASE_ID,
				'title'    => OPENMIGRATEXE_PLUGIN_TITLE,
				'about'    => OPENMIGRATEXE_PLUGIN_ABOUT,
				'check'    => OPENMIGRATEXE_PLUGIN_CHECK,
				'basename' => OPENMIGRATEXE_PLUGIN_BASENAME,
				'version'  => OPENMIGRATEXE_VERSION,
				'requires' => '1.42',
				'short'    => OPENMIGRATEXE_PLUGIN_SHORT,
			);
		}

		// Add Dropbox Extension
		if ( defined( 'OPENMIGRATEDE_PLUGIN_NAME' ) ) {
			$extensions[ OPENMIGRATEDE_PLUGIN_NAME ] = array(
				'key'      => OPENMIGRATEDE_PURCHASE_ID,
				'title'    => OPENMIGRATEDE_PLUGIN_TITLE,
				'about'    => OPENMIGRATEDE_PLUGIN_ABOUT,
				'check'    => OPENMIGRATEDE_PLUGIN_CHECK,
				'basename' => OPENMIGRATEDE_PLUGIN_BASENAME,
				'version'  => OPENMIGRATEDE_VERSION,
				'requires' => '3.98',
				'short'    => OPENMIGRATEDE_PLUGIN_SHORT,
			);
		}

		// Add File Extension
		if ( defined( 'OPENMIGRATETE_PLUGIN_NAME' ) ) {
			$extensions[ OPENMIGRATETE_PLUGIN_NAME ] = array(
				'key'      => OPENMIGRATETE_PURCHASE_ID,
				'title'    => OPENMIGRATETE_PLUGIN_TITLE,
				'about'    => OPENMIGRATETE_PLUGIN_ABOUT,
				'check'    => OPENMIGRATETE_PLUGIN_CHECK,
				'basename' => OPENMIGRATETE_PLUGIN_BASENAME,
				'version'  => OPENMIGRATETE_VERSION,
				'requires' => '1.5',
				'short'    => OPENMIGRATETE_PLUGIN_SHORT,
			);
		}

		// Add FTP Extension
		if ( defined( 'OPENMIGRATEFE_PLUGIN_NAME' ) ) {
			$extensions[ OPENMIGRATEFE_PLUGIN_NAME ] = array(
				'key'      => OPENMIGRATEFE_PURCHASE_ID,
				'title'    => OPENMIGRATEFE_PLUGIN_TITLE,
				'about'    => OPENMIGRATEFE_PLUGIN_ABOUT,
				'check'    => OPENMIGRATEFE_PLUGIN_CHECK,
				'basename' => OPENMIGRATEFE_PLUGIN_BASENAME,
				'version'  => OPENMIGRATEFE_VERSION,
				'requires' => '2.98',
				'short'    => OPENMIGRATEFE_PLUGIN_SHORT,
			);
		}

		// Add Google Cloud Storage Extension
		if ( defined( 'OPENMIGRATECE_PLUGIN_NAME' ) ) {
			$extensions[ OPENMIGRATECE_PLUGIN_NAME ] = array(
				'key'      => OPENMIGRATECE_PURCHASE_ID,
				'title'    => OPENMIGRATECE_PLUGIN_TITLE,
				'about'    => OPENMIGRATECE_PLUGIN_ABOUT,
				'check'    => OPENMIGRATECE_PLUGIN_CHECK,
				'basename' => OPENMIGRATECE_PLUGIN_BASENAME,
				'version'  => OPENMIGRATECE_VERSION,
				'requires' => '1.66',
				'short'    => OPENMIGRATECE_PLUGIN_SHORT,
			);
		}

		// Add Google Drive Extension
		if ( defined( 'OPENMIGRATEGE_PLUGIN_NAME' ) ) {
			$extensions[ OPENMIGRATEGE_PLUGIN_NAME ] = array(
				'key'      => OPENMIGRATEGE_PURCHASE_ID,
				'title'    => OPENMIGRATEGE_PLUGIN_TITLE,
				'about'    => OPENMIGRATEGE_PLUGIN_ABOUT,
				'check'    => OPENMIGRATEGE_PLUGIN_CHECK,
				'basename' => OPENMIGRATEGE_PLUGIN_BASENAME,
				'version'  => OPENMIGRATEGE_VERSION,
				'requires' => '2.104',
				'short'    => OPENMIGRATEGE_PLUGIN_SHORT,
			);
		}

		// Add Amazon Glacier Extension
		if ( defined( 'OPENMIGRATERE_PLUGIN_NAME' ) ) {
			$extensions[ OPENMIGRATERE_PLUGIN_NAME ] = array(
				'key'      => OPENMIGRATERE_PURCHASE_ID,
				'title'    => OPENMIGRATERE_PLUGIN_TITLE,
				'about'    => OPENMIGRATERE_PLUGIN_ABOUT,
				'check'    => OPENMIGRATERE_PLUGIN_CHECK,
				'basename' => OPENMIGRATERE_PLUGIN_BASENAME,
				'version'  => OPENMIGRATERE_VERSION,
				'requires' => '1.59',
				'short'    => OPENMIGRATERE_PLUGIN_SHORT,
			);
		}

		// Add Mega Extension
		if ( defined( 'OPENMIGRATEEE_PLUGIN_NAME' ) ) {
			$extensions[ OPENMIGRATEEE_PLUGIN_NAME ] = array(
				'key'      => OPENMIGRATEEE_PURCHASE_ID,
				'title'    => OPENMIGRATEEE_PLUGIN_TITLE,
				'about'    => OPENMIGRATEEE_PLUGIN_ABOUT,
				'check'    => OPENMIGRATEEE_PLUGIN_CHECK,
				'basename' => OPENMIGRATEEE_PLUGIN_BASENAME,
				'version'  => OPENMIGRATEEE_VERSION,
				'requires' => '1.68',
				'short'    => OPENMIGRATEEE_PLUGIN_SHORT,
			);
		}

		// Add Multisite Extension
		if ( defined( 'OPENMIGRATEME_PLUGIN_NAME' ) ) {
			$extensions[ OPENMIGRATEME_PLUGIN_NAME ] = array(
				'key'      => OPENMIGRATEME_PURCHASE_ID,
				'title'    => OPENMIGRATEME_PLUGIN_TITLE,
				'about'    => OPENMIGRATEME_PLUGIN_ABOUT,
				'check'    => OPENMIGRATEME_PLUGIN_CHECK,
				'basename' => OPENMIGRATEME_PLUGIN_BASENAME,
				'version'  => OPENMIGRATEME_VERSION,
				'requires' => '4.68',
				'short'    => OPENMIGRATEME_PLUGIN_SHORT,
			);
		}

		// Add OneDrive Extension
		if ( defined( 'OPENMIGRATEOE_PLUGIN_NAME' ) ) {
			$extensions[ OPENMIGRATEOE_PLUGIN_NAME ] = array(
				'key'      => OPENMIGRATEOE_PURCHASE_ID,
				'title'    => OPENMIGRATEOE_PLUGIN_TITLE,
				'about'    => OPENMIGRATEOE_PLUGIN_ABOUT,
				'check'    => OPENMIGRATEOE_PLUGIN_CHECK,
				'basename' => OPENMIGRATEOE_PLUGIN_BASENAME,
				'version'  => OPENMIGRATEOE_VERSION,
				'requires' => '1.88',
				'short'    => OPENMIGRATEOE_PLUGIN_SHORT,
			);
		}

		// Add pCloud Extension
		if ( defined( 'OPENMIGRATEPE_PLUGIN_NAME' ) ) {
			$extensions[ OPENMIGRATEPE_PLUGIN_NAME ] = array(
				'key'      => OPENMIGRATEPE_PURCHASE_ID,
				'title'    => OPENMIGRATEPE_PLUGIN_TITLE,
				'about'    => OPENMIGRATEPE_PLUGIN_ABOUT,
				'check'    => OPENMIGRATEPE_PLUGIN_CHECK,
				'basename' => OPENMIGRATEPE_PLUGIN_BASENAME,
				'version'  => OPENMIGRATEPE_VERSION,
				'requires' => '1.60',
				'short'    => OPENMIGRATEPE_PLUGIN_SHORT,
			);
		}

		// Add Pro Plugin
		if ( defined( 'OPENMIGRATEKE_PLUGIN_NAME' ) ) {
			$extensions[ OPENMIGRATEKE_PLUGIN_NAME ] = array(
				'key'      => OPENMIGRATEKE_PURCHASE_ID,
				'title'    => OPENMIGRATEKE_PLUGIN_TITLE,
				'about'    => OPENMIGRATEKE_PLUGIN_ABOUT,
				'check'    => OPENMIGRATEKE_PLUGIN_CHECK,
				'basename' => OPENMIGRATEKE_PLUGIN_BASENAME,
				'version'  => OPENMIGRATEKE_VERSION,
				'requires' => '1.45',
				'short'    => OPENMIGRATEKE_PLUGIN_SHORT,
			);
		}

		// Add S3 Client Extension
		if ( defined( 'OPENMIGRATENE_PLUGIN_NAME' ) ) {
			$extensions[ OPENMIGRATENE_PLUGIN_NAME ] = array(
				'key'      => OPENMIGRATENE_PURCHASE_ID,
				'title'    => OPENMIGRATENE_PLUGIN_TITLE,
				'about'    => OPENMIGRATENE_PLUGIN_ABOUT,
				'check'    => OPENMIGRATENE_PLUGIN_CHECK,
				'basename' => OPENMIGRATENE_PLUGIN_BASENAME,
				'version'  => OPENMIGRATENE_VERSION,
				'requires' => '1.60',
				'short'    => OPENMIGRATENE_PLUGIN_SHORT,
			);
		}

		// Add Amazon S3 Extension
		if ( defined( 'OPENMIGRATESE_PLUGIN_NAME' ) ) {
			$extensions[ OPENMIGRATESE_PLUGIN_NAME ] = array(
				'key'      => OPENMIGRATESE_PURCHASE_ID,
				'title'    => OPENMIGRATESE_PLUGIN_TITLE,
				'about'    => OPENMIGRATESE_PLUGIN_ABOUT,
				'check'    => OPENMIGRATESE_PLUGIN_CHECK,
				'basename' => OPENMIGRATESE_PLUGIN_BASENAME,
				'version'  => OPENMIGRATESE_VERSION,
				'requires' => '3.99',
				'short'    => OPENMIGRATESE_PLUGIN_SHORT,
			);
		}

		// Add Unlimited Extension
		if ( defined( 'OPENMIGRATEUE_PLUGIN_NAME' ) ) {
			$extensions[ OPENMIGRATEUE_PLUGIN_NAME ] = array(
				'key'      => OPENMIGRATEUE_PURCHASE_ID,
				'title'    => OPENMIGRATEUE_PLUGIN_TITLE,
				'about'    => OPENMIGRATEUE_PLUGIN_ABOUT,
				'check'    => OPENMIGRATEUE_PLUGIN_CHECK,
				'basename' => OPENMIGRATEUE_PLUGIN_BASENAME,
				'version'  => OPENMIGRATEUE_VERSION,
				'requires' => '2.89',
				'short'    => OPENMIGRATEUE_PLUGIN_SHORT,
			);
		}

		// Add URL Extension
		if ( defined( 'OPENMIGRATELE_PLUGIN_NAME' ) ) {
			$extensions[ OPENMIGRATELE_PLUGIN_NAME ] = array(
				'key'      => OPENMIGRATELE_PURCHASE_ID,
				'title'    => OPENMIGRATELE_PLUGIN_TITLE,
				'about'    => OPENMIGRATELE_PLUGIN_ABOUT,
				'check'    => OPENMIGRATELE_PLUGIN_CHECK,
				'basename' => OPENMIGRATELE_PLUGIN_BASENAME,
				'version'  => OPENMIGRATELE_VERSION,
				'requires' => '2.83',
				'short'    => OPENMIGRATELE_PLUGIN_SHORT,
			);
		}

		// Add WebDAV Extension
		if ( defined( 'OPENMIGRATEWE_PLUGIN_NAME' ) ) {
			$extensions[ OPENMIGRATEWE_PLUGIN_NAME ] = array(
				'key'      => OPENMIGRATEWE_PURCHASE_ID,
				'title'    => OPENMIGRATEWE_PLUGIN_TITLE,
				'about'    => OPENMIGRATEWE_PLUGIN_ABOUT,
				'check'    => OPENMIGRATEWE_PLUGIN_CHECK,
				'basename' => OPENMIGRATEWE_PLUGIN_BASENAME,
				'version'  => OPENMIGRATEWE_VERSION,
				'requires' => '1.54',
				'short'    => OPENMIGRATEWE_PLUGIN_SHORT,
			);
		}

		return $extensions;
	}
}
