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

<div class="openmigrate-container">
	<div class="openmigrate-row">
		<div class="openmigrate-left">
			<div class="openmigrate-holder">
				<h1>
					<i class="openmigrate-icon-export"></i>
					<?php esc_html_e( 'Backups', 'open-migrate' ); ?>
				</h1>

				<?php if ( is_readable( OPENMIGRATE_BACKUPS_PATH ) && is_writable( OPENMIGRATE_BACKUPS_PATH ) ) : ?>
					<div id="openmigrate-backups-list">
						<?php require_once OPENMIGRATE_TEMPLATES_PATH . '/backups/backups-list.php'; ?>
					</div>

					<form action="" method="post" id="openmigrate-export-form" class="openmigrate-clear">
						<div id="openmigrate-backups-create">
							<p class="openmigrate-backups-empty-spinner-holder openmigrate-hide">
								<span class="spinner"></span>
								<?php esc_html_e( 'Refreshing backup list...', 'open-migrate' ); ?>
							</p>
							<p class="openmigrate-backups-empty <?php echo empty( $backups ) ? null : 'openmigrate-hide'; ?>">
								<?php esc_html_e( 'No backups found. Create a new one?', 'open-migrate' ); ?>
							</p>
							<p>
								<a href="#" id="openmigrate-create-backup" class="openmigrate-button-green">
									<i class="openmigrate-icon-export"></i>
									<?php esc_html_e( 'Create backup', 'open-migrate' ); ?>
								</a>
							</p>
						</div>
						<input type="hidden" name="openmigrate_manual_export" value="1" />
					</form>

					<?php do_action( 'openmigrate_backups_left_end' ); ?>

				<?php else : ?>

					<?php require_once OPENMIGRATE_TEMPLATES_PATH . '/backups/backups-permissions.php'; ?>

				<?php endif; ?>
			</div>

			<div id="openmigrate-backups-list-archive-browser">
				<archive-browser></archive-browser>
			</div>

		</div>

		<?php require_once OPENMIGRATE_TEMPLATES_PATH . '/common/sidebar-right.php'; ?>

	</div>
</div>
