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
?>

<div class="openmigrate-field-set">
	<div class="openmigrate-accordion openmigrate-expandable">
		<h4>
			<i class="openmigrate-icon-arrow-right"></i>
			<?php esc_html_e( 'Advanced options', 'open-migrate' ); ?>
			<small><?php esc_html_e( '(click to expand)', 'open-migrate' ); ?></small>
		</h4>
		<ul>
			<li><strong><?php esc_html_e( 'Security Options', 'open-migrate' ); ?></strong></li>
			<?php if ( openmigrate_can_encrypt() ) : ?>
				<li class="openmigrate-encrypt-backups-container">
					<label for="openmigrate-encrypt-backups">
						<input type="checkbox" id="openmigrate-encrypt-backups" name="options[encrypt_backups]" />
						<?php esc_html_e( 'Encrypt this backup with a password', 'open-migrate' ); ?>
					</label>
					<div class="openmigrate-encrypt-backups-passwords-toggle">
						<div class="openmigrate-encrypt-backups-passwords-container">
							<div class="openmigrate-input-password-container">
								<input type="password" placeholder="<?php esc_attr_e( 'Enter a password', 'open-migrate' ); ?>" name="options[encrypt_password]" id="openmigrate-backup-encrypt-password">
								<a href="#openmigrate-backup-encrypt-password" class="openmigrate-toggle-password-visibility openmigrate-icon-eye-blocked"></a>
								<div class="openmigrate-error-message"><?php esc_html_e( 'A password is required', 'open-migrate' ); ?></div>
							</div>
							<div class="openmigrate-input-password-container">
								<input type="password" name="options[encrypt_password_confirmation]" placeholder="<?php esc_attr_e( 'Repeat the password', 'open-migrate' ); ?>" id="openmigrate-backup-encrypt-password-confirmation">
								<a href="#openmigrate-backup-encrypt-password-confirmation" class="openmigrate-toggle-password-visibility openmigrate-icon-eye-blocked"></a>
								<div class="openmigrate-error-message"><?php esc_html_e( 'The passwords do not match', 'open-migrate' ); ?></div>
							</div>
						</div>
					</div>
				</li>
			<?php else : ?>
				<li class="openmigrate-encrypt-backups-container-disabled">
					<input type="checkbox" id="openmigrate-encrypt-backups" name="options[encrypt_backups]" disabled />
					<?php esc_html_e( 'Password-protect and encrypt backups', 'open-migrate' ); ?>

				</li>
			<?php endif; ?>

			<?php do_action( 'openmigrate_export_compression_types' ); ?>

			<li><strong><?php esc_html_e( 'Database Options', 'open-migrate' ); ?></strong></li>
			<li>
				<label for="openmigrate-no-spam-comments">
					<input type="checkbox" id="openmigrate-no-spam-comments" name="options[no_spam_comments]" />
					<?php esc_html_e( 'Exclude spam comments', 'open-migrate' ); ?>
				</label>
			</li>
			<li>
				<label for="openmigrate-no-post-revisions">
					<input type="checkbox" id="openmigrate-no-post-revisions" name="options[no_post_revisions]" />
					<?php esc_html_e( 'Exclude post revisions', 'open-migrate' ); ?>
				</label>
			</li>
			<li>
				<label for="openmigrate-no-database">
					<input type="checkbox" id="openmigrate-no-database" name="options[no_database]" />
					<?php esc_html_e( 'Exclude database', 'open-migrate' ); ?>
				</label>
			</li>
			<li>
				<label for="openmigrate-no-email-replace">
					<input type="checkbox" id="openmigrate-no-email-replace" name="options[no_email_replace]" />
					<?php
					echo wp_kses(
						__( 'Do <strong>not</strong> replace email domain', 'open-migrate' ),
						openmigrate_allowed_html_tags()
					);
					?>
				</label>
			</li>

			<?php do_action( 'openmigrate_export_exclude_db_tables' ); ?>

			<?php do_action( 'openmigrate_export_include_db_tables' ); ?>

			<li><strong><?php esc_html_e( 'File Options', 'open-migrate' ); ?></strong></li>
			<li>
				<label for="openmigrate-no-media">
					<input type="checkbox" id="openmigrate-no-media" name="options[no_media]" />
					<?php esc_html_e( 'Exclude media library', 'open-migrate' ); ?>
				</label>
			</li>
			<li>
				<label for="openmigrate-no-themes">
					<input type="checkbox" id="openmigrate-no-themes" name="options[no_themes]" />
					<?php esc_html_e( 'Exclude themes', 'open-migrate' ); ?>
				</label>
			</li>

			<?php do_action( 'openmigrate_export_inactive_themes' ); ?>

			<li>
				<label for="openmigrate-no-muplugins">
					<input type="checkbox" id="openmigrate-no-muplugins" name="options[no_muplugins]" />
					<?php esc_html_e( 'Exclude must-use plugins', 'open-migrate' ); ?>
				</label>
			</li>

			<li>
				<label for="openmigrate-no-plugins">
					<input type="checkbox" id="openmigrate-no-plugins" name="options[no_plugins]" />
					<?php esc_html_e( 'Exclude plugins', 'open-migrate' ); ?>
				</label>
			</li>

			<?php do_action( 'openmigrate_export_inactive_plugins' ); ?>

			<?php do_action( 'openmigrate_export_cache_files' ); ?>

			<?php do_action( 'openmigrate_export_advanced_settings' ); ?>

		</ul>
	</div>
</div>
