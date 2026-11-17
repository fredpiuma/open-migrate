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

class OpenMigrate_Import_Done {

	public static function execute( $params ) {
		global $wp_rewrite;

		// Check multisite.json file
		if ( is_file( openmigrate_multisite_path( $params ) ) ) {

			// Read multisite.json file
			$handle = openmigrate_open( openmigrate_multisite_path( $params ), 'r' );

			// Parse multisite.json file
			$multisite = openmigrate_read( $handle, filesize( openmigrate_multisite_path( $params ) ) );
			$multisite = json_decode( $multisite, true );

			// Close handle
			openmigrate_close( $handle );

			// Activate WordPress plugins
			if ( isset( $multisite['Plugins'] ) && ( $plugins = $multisite['Plugins'] ) ) {
				openmigrate_activate_plugins( $plugins );
			}

			// Deactivate WordPress SSL plugins
			if ( ! is_ssl() ) {
				openmigrate_deactivate_plugins(
					array(
						openmigrate_discover_plugin_basename( 'really-simple-ssl/rlrsssl-really-simple-ssl.php' ),
						openmigrate_discover_plugin_basename( 'wordpress-https/wordpress-https.php' ),
						openmigrate_discover_plugin_basename( 'wp-force-ssl/wp-force-ssl.php' ),
						openmigrate_discover_plugin_basename( 'force-https-littlebizzy/force-https.php' ),
					)
				);

				openmigrate_woocommerce_force_ssl( false );
			}

			// Deactivate WordPress plugins
			openmigrate_deactivate_plugins(
				array(
					openmigrate_discover_plugin_basename( 'invisible-recaptcha/invisible-recaptcha.php' ),
					openmigrate_discover_plugin_basename( 'wps-hide-login/wps-hide-login.php' ),
					openmigrate_discover_plugin_basename( 'hide-my-wp/index.php' ),
					openmigrate_discover_plugin_basename( 'hide-my-wordpress/index.php' ),
					openmigrate_discover_plugin_basename( 'mycustomwidget/my_custom_widget.php' ),
					openmigrate_discover_plugin_basename( 'lockdown-wp-admin/lockdown-wp-admin.php' ),
					openmigrate_discover_plugin_basename( 'rename-wp-login/rename-wp-login.php' ),
					openmigrate_discover_plugin_basename( 'wp-simple-firewall/icwp-wpsf.php' ),
					openmigrate_discover_plugin_basename( 'join-my-multisite/joinmymultisite.php' ),
					openmigrate_discover_plugin_basename( 'multisite-clone-duplicator/multisite-clone-duplicator.php' ),
					openmigrate_discover_plugin_basename( 'wordpress-mu-domain-mapping/domain_mapping.php' ),
					openmigrate_discover_plugin_basename( 'wordpress-starter/siteground-wizard.php' ),
					openmigrate_discover_plugin_basename( 'pro-sites/pro-sites.php' ),
					openmigrate_discover_plugin_basename( 'wpide/WPide.php' ),
					openmigrate_discover_plugin_basename( 'page-optimize/page-optimize.php' ),
					openmigrate_discover_plugin_basename( 'update-services/update-services.php' ),
				)
			);

			// Deactivate Swift Optimizer rules
			openmigrate_deactivate_swift_optimizer_rules(
				array(
					openmigrate_discover_plugin_basename( 'open-migrate/open-migrate.php' ),
					openmigrate_discover_plugin_basename( 'all-in-one-wp-migration/all-in-one-wp-migration.php' ),
					openmigrate_discover_plugin_basename( 'all-in-one-wp-migration-azure-storage-extension/all-in-one-wp-migration-azure-storage-extension.php' ),
					openmigrate_discover_plugin_basename( 'all-in-one-wp-migration-b2-extension/all-in-one-wp-migration-b2-extension.php' ),
					openmigrate_discover_plugin_basename( 'all-in-one-wp-migration-backup/all-in-one-wp-migration-backup.php' ),
					openmigrate_discover_plugin_basename( 'all-in-one-wp-migration-box-extension/all-in-one-wp-migration-box-extension.php' ),
					openmigrate_discover_plugin_basename( 'all-in-one-wp-migration-digitalocean-extension/all-in-one-wp-migration-digitalocean-extension.php' ),
					openmigrate_discover_plugin_basename( 'all-in-one-wp-migration-direct-extension/all-in-one-wp-migration-direct-extension.php' ),
					openmigrate_discover_plugin_basename( 'all-in-one-wp-migration-dropbox-extension/all-in-one-wp-migration-dropbox-extension.php' ),
					openmigrate_discover_plugin_basename( 'all-in-one-wp-migration-file-extension/all-in-one-wp-migration-file-extension.php' ),
					openmigrate_discover_plugin_basename( 'all-in-one-wp-migration-ftp-extension/all-in-one-wp-migration-ftp-extension.php' ),
					openmigrate_discover_plugin_basename( 'all-in-one-wp-migration-gcloud-storage-extension/all-in-one-wp-migration-gcloud-storage-extension.php' ),
					openmigrate_discover_plugin_basename( 'all-in-one-wp-migration-gdrive-extension/all-in-one-wp-migration-gdrive-extension.php' ),
					openmigrate_discover_plugin_basename( 'all-in-one-wp-migration-glacier-extension/all-in-one-wp-migration-glacier-extension.php' ),
					openmigrate_discover_plugin_basename( 'all-in-one-wp-migration-mega-extension/all-in-one-wp-migration-mega-extension.php' ),
					openmigrate_discover_plugin_basename( 'all-in-one-wp-migration-multisite-extension/all-in-one-wp-migration-multisite-extension.php' ),
					openmigrate_discover_plugin_basename( 'all-in-one-wp-migration-onedrive-extension/all-in-one-wp-migration-onedrive-extension.php' ),
					openmigrate_discover_plugin_basename( 'all-in-one-wp-migration-pcloud-extension/all-in-one-wp-migration-pcloud-extension.php' ),
					openmigrate_discover_plugin_basename( 'all-in-one-wp-migration-pro/all-in-one-wp-migration-pro.php' ),
					openmigrate_discover_plugin_basename( 'all-in-one-wp-migration-s3-client-extension/all-in-one-wp-migration-s3-client-extension.php' ),
					openmigrate_discover_plugin_basename( 'all-in-one-wp-migration-s3-extension/all-in-one-wp-migration-s3-extension.php' ),
					openmigrate_discover_plugin_basename( 'all-in-one-wp-migration-unlimited-extension/all-in-one-wp-migration-unlimited-extension.php' ),
					openmigrate_discover_plugin_basename( 'all-in-one-wp-migration-url-extension/all-in-one-wp-migration-url-extension.php' ),
					openmigrate_discover_plugin_basename( 'all-in-one-wp-migration-webdav-extension/all-in-one-wp-migration-webdav-extension.php' ),
				)
			);

			// Deactivate Revolution Slider
			openmigrate_deactivate_revolution_slider( openmigrate_discover_plugin_basename( 'revslider/revslider.php' ) );

			// Deactivate Jetpack modules
			openmigrate_deactivate_jetpack_modules( array( 'photon', 'sso' ) );

			// Flush Elementor cache
			openmigrate_elementor_cache_flush();

			// Initial DB version
			openmigrate_initial_db_version();

		} else {

			// Check package.json file
			if ( is_file( openmigrate_package_path( $params ) ) ) {

				// Read package.json file
				$handle = openmigrate_open( openmigrate_package_path( $params ), 'r' );

				// Parse package.json file
				$package = openmigrate_read( $handle, filesize( openmigrate_package_path( $params ) ) );
				$package = json_decode( $package, true );

				// Close handle
				openmigrate_close( $handle );

				// Activate WordPress plugins
				if ( isset( $package['Plugins'] ) && ( $plugins = $package['Plugins'] ) ) {
					openmigrate_activate_plugins( $plugins );
				}

				// Activate WordPress template
				if ( isset( $package['Template'] ) && ( $template = $package['Template'] ) ) {
					openmigrate_activate_template( $template );
				}

				// Activate WordPress stylesheet
				if ( isset( $package['Stylesheet'] ) && ( $stylesheet = $package['Stylesheet'] ) ) {
					openmigrate_activate_stylesheet( $stylesheet );
				}

				// Deactivate WordPress SSL plugins
				if ( ! is_ssl() ) {
					openmigrate_deactivate_plugins(
						array(
							openmigrate_discover_plugin_basename( 'really-simple-ssl/rlrsssl-really-simple-ssl.php' ),
							openmigrate_discover_plugin_basename( 'wordpress-https/wordpress-https.php' ),
							openmigrate_discover_plugin_basename( 'wp-force-ssl/wp-force-ssl.php' ),
							openmigrate_discover_plugin_basename( 'force-https-littlebizzy/force-https.php' ),
						)
					);

					openmigrate_woocommerce_force_ssl( false );
				}

				// Deactivate WordPress plugins
				openmigrate_deactivate_plugins(
					array(
						openmigrate_discover_plugin_basename( 'invisible-recaptcha/invisible-recaptcha.php' ),
						openmigrate_discover_plugin_basename( 'wps-hide-login/wps-hide-login.php' ),
						openmigrate_discover_plugin_basename( 'hide-my-wp/index.php' ),
						openmigrate_discover_plugin_basename( 'hide-my-wordpress/index.php' ),
						openmigrate_discover_plugin_basename( 'mycustomwidget/my_custom_widget.php' ),
						openmigrate_discover_plugin_basename( 'lockdown-wp-admin/lockdown-wp-admin.php' ),
						openmigrate_discover_plugin_basename( 'rename-wp-login/rename-wp-login.php' ),
						openmigrate_discover_plugin_basename( 'wp-simple-firewall/icwp-wpsf.php' ),
						openmigrate_discover_plugin_basename( 'join-my-multisite/joinmymultisite.php' ),
						openmigrate_discover_plugin_basename( 'multisite-clone-duplicator/multisite-clone-duplicator.php' ),
						openmigrate_discover_plugin_basename( 'wordpress-mu-domain-mapping/domain_mapping.php' ),
						openmigrate_discover_plugin_basename( 'wordpress-starter/siteground-wizard.php' ),
						openmigrate_discover_plugin_basename( 'pro-sites/pro-sites.php' ),
						openmigrate_discover_plugin_basename( 'wpide/WPide.php' ),
						openmigrate_discover_plugin_basename( 'page-optimize/page-optimize.php' ),
						openmigrate_discover_plugin_basename( 'update-services/update-services.php' ),
					)
				);

				// Deactivate Swift Optimizer rules
				openmigrate_deactivate_swift_optimizer_rules(
					array(
						openmigrate_discover_plugin_basename( 'open-migrate/open-migrate.php' ),
						openmigrate_discover_plugin_basename( 'all-in-one-wp-migration-azure-storage-extension/all-in-one-wp-migration-azure-storage-extension.php' ),
						openmigrate_discover_plugin_basename( 'all-in-one-wp-migration-b2-extension/all-in-one-wp-migration-b2-extension.php' ),
						openmigrate_discover_plugin_basename( 'all-in-one-wp-migration-backup/all-in-one-wp-migration-backup.php' ),
						openmigrate_discover_plugin_basename( 'all-in-one-wp-migration-box-extension/all-in-one-wp-migration-box-extension.php' ),
						openmigrate_discover_plugin_basename( 'all-in-one-wp-migration-digitalocean-extension/all-in-one-wp-migration-digitalocean-extension.php' ),
						openmigrate_discover_plugin_basename( 'all-in-one-wp-migration-direct-extension/all-in-one-wp-migration-direct-extension.php' ),
						openmigrate_discover_plugin_basename( 'all-in-one-wp-migration-dropbox-extension/all-in-one-wp-migration-dropbox-extension.php' ),
						openmigrate_discover_plugin_basename( 'all-in-one-wp-migration-file-extension/all-in-one-wp-migration-file-extension.php' ),
						openmigrate_discover_plugin_basename( 'all-in-one-wp-migration-ftp-extension/all-in-one-wp-migration-ftp-extension.php' ),
						openmigrate_discover_plugin_basename( 'all-in-one-wp-migration-gcloud-storage-extension/all-in-one-wp-migration-gcloud-storage-extension.php' ),
						openmigrate_discover_plugin_basename( 'all-in-one-wp-migration-gdrive-extension/all-in-one-wp-migration-gdrive-extension.php' ),
						openmigrate_discover_plugin_basename( 'all-in-one-wp-migration-glacier-extension/all-in-one-wp-migration-glacier-extension.php' ),
						openmigrate_discover_plugin_basename( 'all-in-one-wp-migration-mega-extension/all-in-one-wp-migration-mega-extension.php' ),
						openmigrate_discover_plugin_basename( 'all-in-one-wp-migration-multisite-extension/all-in-one-wp-migration-multisite-extension.php' ),
						openmigrate_discover_plugin_basename( 'all-in-one-wp-migration-onedrive-extension/all-in-one-wp-migration-onedrive-extension.php' ),
						openmigrate_discover_plugin_basename( 'all-in-one-wp-migration-pcloud-extension/all-in-one-wp-migration-pcloud-extension.php' ),
						openmigrate_discover_plugin_basename( 'all-in-one-wp-migration-pro/all-in-one-wp-migration-pro.php' ),
						openmigrate_discover_plugin_basename( 'all-in-one-wp-migration-s3-client-extension/all-in-one-wp-migration-s3-client-extension.php' ),
						openmigrate_discover_plugin_basename( 'all-in-one-wp-migration-s3-extension/all-in-one-wp-migration-s3-extension.php' ),
						openmigrate_discover_plugin_basename( 'all-in-one-wp-migration-unlimited-extension/all-in-one-wp-migration-unlimited-extension.php' ),
						openmigrate_discover_plugin_basename( 'all-in-one-wp-migration-url-extension/all-in-one-wp-migration-url-extension.php' ),
						openmigrate_discover_plugin_basename( 'all-in-one-wp-migration-webdav-extension/all-in-one-wp-migration-webdav-extension.php' ),
					)
				);

				// Deactivate Revolution Slider
				openmigrate_deactivate_revolution_slider( openmigrate_discover_plugin_basename( 'revslider/revslider.php' ) );

				// Deactivate Jetpack modules
				openmigrate_deactivate_jetpack_modules( array( 'photon', 'sso' ) );

				// Flush Elementor cache
				openmigrate_elementor_cache_flush();

				// Initial DB version
				openmigrate_initial_db_version();
			}
		}

		// Check blogs.json file
		if ( is_file( openmigrate_blogs_path( $params ) ) ) {

			// Read blogs.json file
			$handle = openmigrate_open( openmigrate_blogs_path( $params ), 'r' );

			// Parse blogs.json file
			$blogs = openmigrate_read( $handle, filesize( openmigrate_blogs_path( $params ) ) );
			$blogs = json_decode( $blogs, true );

			// Close handle
			openmigrate_close( $handle );

			// Loop over blogs
			foreach ( $blogs as $blog ) {

				// Activate WordPress plugins
				if ( isset( $blog['New']['Plugins'] ) && ( $plugins = $blog['New']['Plugins'] ) ) {
					openmigrate_activate_plugins( $plugins );
				}

				// Activate WordPress template
				if ( isset( $blog['New']['Template'] ) && ( $template = $blog['New']['Template'] ) ) {
					openmigrate_activate_template( $template );
				}

				// Activate WordPress stylesheet
				if ( isset( $blog['New']['Stylesheet'] ) && ( $stylesheet = $blog['New']['Stylesheet'] ) ) {
					openmigrate_activate_stylesheet( $stylesheet );
				}

				// Deactivate WordPress SSL plugins
				if ( ! is_ssl() ) {
					openmigrate_deactivate_plugins(
						array(
							openmigrate_discover_plugin_basename( 'really-simple-ssl/rlrsssl-really-simple-ssl.php' ),
							openmigrate_discover_plugin_basename( 'wordpress-https/wordpress-https.php' ),
							openmigrate_discover_plugin_basename( 'wp-force-ssl/wp-force-ssl.php' ),
							openmigrate_discover_plugin_basename( 'force-https-littlebizzy/force-https.php' ),
						)
					);

					openmigrate_woocommerce_force_ssl( false );
				}

				// Deactivate WordPress plugins
				openmigrate_deactivate_plugins(
					array(
						openmigrate_discover_plugin_basename( 'invisible-recaptcha/invisible-recaptcha.php' ),
						openmigrate_discover_plugin_basename( 'wps-hide-login/wps-hide-login.php' ),
						openmigrate_discover_plugin_basename( 'hide-my-wp/index.php' ),
						openmigrate_discover_plugin_basename( 'hide-my-wordpress/index.php' ),
						openmigrate_discover_plugin_basename( 'mycustomwidget/my_custom_widget.php' ),
						openmigrate_discover_plugin_basename( 'lockdown-wp-admin/lockdown-wp-admin.php' ),
						openmigrate_discover_plugin_basename( 'rename-wp-login/rename-wp-login.php' ),
						openmigrate_discover_plugin_basename( 'wp-simple-firewall/icwp-wpsf.php' ),
						openmigrate_discover_plugin_basename( 'join-my-multisite/joinmymultisite.php' ),
						openmigrate_discover_plugin_basename( 'multisite-clone-duplicator/multisite-clone-duplicator.php' ),
						openmigrate_discover_plugin_basename( 'wordpress-mu-domain-mapping/domain_mapping.php' ),
						openmigrate_discover_plugin_basename( 'wordpress-starter/siteground-wizard.php' ),
						openmigrate_discover_plugin_basename( 'pro-sites/pro-sites.php' ),
						openmigrate_discover_plugin_basename( 'wpide/WPide.php' ),
						openmigrate_discover_plugin_basename( 'page-optimize/page-optimize.php' ),
						openmigrate_discover_plugin_basename( 'update-services/update-services.php' ),
					)
				);

				// Deactivate Swift Optimizer rules
				openmigrate_deactivate_swift_optimizer_rules(
					array(
						openmigrate_discover_plugin_basename( 'open-migrate/open-migrate.php' ),
						openmigrate_discover_plugin_basename( 'all-in-one-wp-migration-azure-storage-extension/all-in-one-wp-migration-azure-storage-extension.php' ),
						openmigrate_discover_plugin_basename( 'all-in-one-wp-migration-b2-extension/all-in-one-wp-migration-b2-extension.php' ),
						openmigrate_discover_plugin_basename( 'all-in-one-wp-migration-backup/all-in-one-wp-migration-backup.php' ),
						openmigrate_discover_plugin_basename( 'all-in-one-wp-migration-box-extension/all-in-one-wp-migration-box-extension.php' ),
						openmigrate_discover_plugin_basename( 'all-in-one-wp-migration-digitalocean-extension/all-in-one-wp-migration-digitalocean-extension.php' ),
						openmigrate_discover_plugin_basename( 'all-in-one-wp-migration-direct-extension/all-in-one-wp-migration-direct-extension.php' ),
						openmigrate_discover_plugin_basename( 'all-in-one-wp-migration-dropbox-extension/all-in-one-wp-migration-dropbox-extension.php' ),
						openmigrate_discover_plugin_basename( 'all-in-one-wp-migration-file-extension/all-in-one-wp-migration-file-extension.php' ),
						openmigrate_discover_plugin_basename( 'all-in-one-wp-migration-ftp-extension/all-in-one-wp-migration-ftp-extension.php' ),
						openmigrate_discover_plugin_basename( 'all-in-one-wp-migration-gcloud-storage-extension/all-in-one-wp-migration-gcloud-storage-extension.php' ),
						openmigrate_discover_plugin_basename( 'all-in-one-wp-migration-gdrive-extension/all-in-one-wp-migration-gdrive-extension.php' ),
						openmigrate_discover_plugin_basename( 'all-in-one-wp-migration-glacier-extension/all-in-one-wp-migration-glacier-extension.php' ),
						openmigrate_discover_plugin_basename( 'all-in-one-wp-migration-mega-extension/all-in-one-wp-migration-mega-extension.php' ),
						openmigrate_discover_plugin_basename( 'all-in-one-wp-migration-multisite-extension/all-in-one-wp-migration-multisite-extension.php' ),
						openmigrate_discover_plugin_basename( 'all-in-one-wp-migration-onedrive-extension/all-in-one-wp-migration-onedrive-extension.php' ),
						openmigrate_discover_plugin_basename( 'all-in-one-wp-migration-pcloud-extension/all-in-one-wp-migration-pcloud-extension.php' ),
						openmigrate_discover_plugin_basename( 'all-in-one-wp-migration-pro/all-in-one-wp-migration-pro.php' ),
						openmigrate_discover_plugin_basename( 'all-in-one-wp-migration-s3-client-extension/all-in-one-wp-migration-s3-client-extension.php' ),
						openmigrate_discover_plugin_basename( 'all-in-one-wp-migration-s3-extension/all-in-one-wp-migration-s3-extension.php' ),
						openmigrate_discover_plugin_basename( 'all-in-one-wp-migration-unlimited-extension/all-in-one-wp-migration-unlimited-extension.php' ),
						openmigrate_discover_plugin_basename( 'all-in-one-wp-migration-url-extension/all-in-one-wp-migration-url-extension.php' ),
						openmigrate_discover_plugin_basename( 'all-in-one-wp-migration-webdav-extension/all-in-one-wp-migration-webdav-extension.php' ),
					)
				);

				// Deactivate Revolution Slider
				openmigrate_deactivate_revolution_slider( openmigrate_discover_plugin_basename( 'revslider/revslider.php' ) );

				// Deactivate Jetpack modules
				openmigrate_deactivate_jetpack_modules( array( 'photon', 'sso' ) );

				// Flush Elementor cache
				openmigrate_elementor_cache_flush();

				// Initial DB version
				openmigrate_initial_db_version();
			}
		}

		// Clear auth cookie (WP Cerber)
		if ( openmigrate_validate_plugin_basename( 'wp-cerber/wp-cerber.php' ) ) {
			wp_clear_auth_cookie();
		}

		$should_reset_permalinks = false;

		// Switch to default permalink structure
		if ( ( $should_reset_permalinks = openmigrate_should_reset_permalinks( $params ) ) ) {
			$wp_rewrite->set_permalink_structure( '' );
		}

		// Set progress
		if ( openmigrate_validate_plugin_basename( 'fusion-builder/fusion-builder.php' ) ) {
			OpenMigrate_Status::done( __( 'Your site has been imported successfully!', 'open-migrate' ), OpenMigrate_Template::get_content( 'import/avada', array( 'should_reset_permalinks' => $should_reset_permalinks ) ) );
		} elseif ( openmigrate_validate_plugin_basename( 'oxygen/functions.php' ) ) {
			OpenMigrate_Status::done( __( 'Your site has been imported successfully!', 'open-migrate' ), OpenMigrate_Template::get_content( 'import/oxygen', array( 'should_reset_permalinks' => $should_reset_permalinks ) ) );
		} else {
			OpenMigrate_Status::done( __( 'Your site has been imported successfully!', 'open-migrate' ), OpenMigrate_Template::get_content( 'import/done', array( 'should_reset_permalinks' => $should_reset_permalinks ) ) );
		}

		do_action( 'openmigrate_status_import_done', $params );

		return $params;
	}
}
