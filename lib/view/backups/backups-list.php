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

<?php if ( $backups ) : ?>
	<form action="" method="post" id="openmigrate-backups-form" class="openmigrate-clear">
		<table class="openmigrate-backups">
			<thead>
				<tr>
					<th class="openmigrate-column-checkbox">
						<input type="checkbox" id="openmigrate-backup-select-all" aria-label="<?php esc_attr_e( 'Select all backups', 'open-migrate' ); ?>" />
					</th>
					<th class="openmigrate-column-name"><?php esc_html_e( 'Name', 'open-migrate' ); ?></th>
					<th class="openmigrate-column-date"><?php esc_html_e( 'Date', 'open-migrate' ); ?></th>
					<th class="openmigrate-column-size"><?php esc_html_e( 'Size', 'open-migrate' ); ?></th>
					<th class="openmigrate-column-actions"></th>
				</tr>
			</thead>
			<tbody>
				<tr class="openmigrate-backups-list-spinner-holder openmigrate-hide">
					<td colspan="5" class="openmigrate-backups-list-spinner">
						<span class="spinner"></span>
						<?php esc_html_e( 'Refreshing backup list...', 'open-migrate' ); ?>
					</td>
				</tr>

				<?php foreach ( $backups as $backup ) : ?>
				<tr>
					<td class="openmigrate-column-checkbox">
						<input type="checkbox" class="openmigrate-backup-checkbox" data-archive="<?php echo esc_attr( $backup['filename'] ); ?>" aria-label="<?php echo esc_attr( sprintf( __( 'Select backup %s', 'open-migrate' ), $backup['filename'] ) ); ?>" />
					</td>
					<td class="openmigrate-column-name">
						<?php if ( ! empty( $backup['path'] ) ) : ?>
							<i class="openmigrate-icon-folder"></i>
							<?php echo esc_html( $backup['path'] ); ?>
							<br />
						<?php endif; ?>
						<i class="openmigrate-icon-file-zip"></i>
						<span class="openmigrate-backup-filename">
							<?php echo esc_html( basename( $backup['filename'] ) ); ?>
						</span>
						<span class="openmigrate-backup-label-description openmigrate-hide <?php echo empty( $labels[ $backup['filename'] ] ) ? null : 'openmigrate-backup-label-selected'; ?>">
							<br />
							<?php esc_html_e( 'Click to label this backup', 'open-migrate' ); ?>
							<i class="openmigrate-icon-edit-pencil openmigrate-hide"></i>
						</span>
						<span class="openmigrate-backup-label-text <?php echo empty( $labels[ $backup['filename'] ] ) ? 'openmigrate-hide' : null; ?>">
							<br />
							<span class="openmigrate-backup-label-colored">
								<?php if ( ! empty( $labels[ $backup['filename'] ] ) ) : ?>
									<?php echo esc_html( $labels[ $backup['filename'] ] ); ?>
								<?php endif; ?>
							</span>
							<i class="openmigrate-icon-edit-pencil openmigrate-hide"></i>
						</span>
						<span class="openmigrate-backup-label-holder openmigrate-hide">
							<br />
							<input type="text" class="openmigrate-backup-label-field" data-archive="<?php echo esc_attr( $backup['filename'] ); ?>" data-value="<?php echo empty( $labels[ $backup['filename'] ] ) ? null : esc_attr( $labels[ $backup['filename'] ] ); ?>" value="<?php echo empty( $labels[ $backup['filename'] ] ) ? null : esc_attr( $labels[ $backup['filename'] ] ); ?>" />
						</span>
					</td>
					<td class="openmigrate-column-date">
						<?php echo esc_html( sprintf( /* translators: Human time diff */ __( '%s ago', 'open-migrate' ), human_time_diff( $backup['mtime'] ) ) ); ?>
					</td>
					<td class="openmigrate-column-size">
						<?php if ( ! is_null( $backup['size'] ) ) : ?>
							<?php echo esc_html( openmigrate_size_format( $backup['size'], 2 ) ); ?>
						<?php else : ?>
							<?php esc_html_e( 'Over 2GB', 'open-migrate' ); ?>
						<?php endif; ?>
					</td>
					<td class="openmigrate-column-actions openmigrate-backup-actions">
						<div>
							<a href="#" role="menu" aria-haspopup="true" class="openmigrate-backup-dots" title="<?php esc_attr_e( 'More', 'open-migrate' ); ?>" aria-label="<?php esc_attr_e( 'More', 'open-migrate' ); ?>">
								<i class="openmigrate-icon-dots-horizontal-triple"></i>
							</a>
							<div class="openmigrate-backup-dots-menu">
								<ul role="menu">
									<li>
										<a tabindex="-1" href="#" role="menuitem" class="openmigrate-backup-restore" data-archive="<?php echo esc_attr( $backup['filename'] ); ?>" data-size="<?php echo esc_attr( $backup['size'] ); ?>" aria-label="<?php esc_attr_e( 'Restore', 'open-migrate' ); ?>">
											<i class="openmigrate-icon-cloud-upload"></i>
											<span><?php esc_html_e( 'Restore', 'open-migrate' ); ?></span>
										</a>
									</li>
									<?php if ( $downloadable ) : ?>
										<li>
											<?php if ( openmigrate_direct_download_supported() ) : ?>
												<a tabindex="-1" href="<?php echo esc_url( openmigrate_backup_url( array( 'archive' => $backup['filename'] ) ) ); ?>" role="menuitem" download="<?php echo esc_attr( $backup['filename'] ); ?>" aria-label="<?php esc_attr_e( 'Download', 'open-migrate' ); ?>">
													<i class="openmigrate-icon-arrow-down"></i>
													<?php esc_html_e( 'Download', 'open-migrate' ); ?>
												</a>
											<?php else : ?>
												<a tabindex="-1" class="openmigrate-backup-download" href="#" role="menuitem" download="<?php echo esc_attr( $backup['filename'] ); ?>" aria-label="<?php esc_attr_e( 'Download', 'open-migrate' ); ?>">
													<i class="openmigrate-icon-arrow-down"></i>
													<?php esc_html_e( 'Download', 'open-migrate' ); ?>
												</a>
											<?php endif; ?>
										</li>
									<?php else : ?>
										<li class="openmigrate-disabled">
											<a tabindex="-1" href="#" role="menuitem" aria-label="<?php esc_attr_e( 'Downloading is not possible because backups directory is not accessible.', 'open-migrate' ); ?>" title="<?php esc_attr_e( 'Downloading is not possible because backups directory is not accessible.', 'open-migrate' ); ?>">
												<i class="openmigrate-icon-arrow-down"></i>
												<?php esc_html_e( 'Download', 'open-migrate' ); ?>
											</a>
										</li>
									<?php endif; ?>
									<li>
										<a tabindex="-1" href="#" class="openmigrate-backup-list-content" data-archive="<?php echo esc_attr( $backup['filename'] ); ?>" role="menuitem" aria-label="<?php esc_attr_e( 'Show backup content', 'open-migrate' ); ?>">
											<i class="openmigrate-icon-file-content"></i>
											<span><?php esc_html_e( 'List', 'open-migrate' ); ?></span>
										</a>
									</li>
									<li class="divider"></li>
									<li>
										<a tabindex="-1" href="#" class="openmigrate-backup-delete" data-archive="<?php echo esc_attr( $backup['filename'] ); ?>" role="menuitem" aria-label="<?php esc_attr_e( 'Delete', 'open-migrate' ); ?>">
											<i class="openmigrate-icon-close"></i>
											<span><?php esc_html_e( 'Delete', 'open-migrate' ); ?></span>
										</a>
									</li>
								</ul>
							</div>
						</div>
					</td>
				</tr>
				<?php endforeach; ?>
			</tbody>
		</table>
		<input type="hidden" name="openmigrate_manual_restore" value="1" />
	</form>
<?php endif; ?>
