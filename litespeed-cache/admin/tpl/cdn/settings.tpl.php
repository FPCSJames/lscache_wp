<?php defined( 'WPINC' ) || exit ; ?>
<?php

$home_url = home_url( '/' ) ;
$parsed = parse_url( $home_url ) ;
$home_url = str_replace( $parsed[ 'scheme' ] . ':', '', $home_url ) ;
$cdn_url = 'https://cdn.' . substr( $home_url, 2 ) ;

$cdn_mapping = LiteSpeed_Cache::config( LiteSpeed_Cache_Config::O_CDN_MAPPING ) ;


$this->form_action() ;
?>

<h3 class="litespeed-title-short">
	<?php echo __( 'CDN Settings', 'litespeed-cache' ) ; ?>
	<?php $this->learn_more( 'https://www.litespeedtech.com/support/wiki/doku.php/litespeed_wiki:cache:lscwp:configuration:cdn', false, 'litespeed-learn-more' ) ; ?>
</h3>

<table class="wp-list-table widefat striped"><tbody>
	<tr>
		<th>
			<?php $id = LiteSpeed_Cache_Config::O_CDN ; ?>
			<?php $this->title( $id ) ; ?>
		</th>
		<td>
			<?php $this->build_switch( $id ) ; ?>
			<div class="litespeed-desc">
				<?php echo __( 'Enable Content Delivery Network use.', 'litespeed-cache' ) ; ?>
				<?php echo sprintf( __( 'If using Cloudflare, leave this setting %s and use Cloudflare API setting below.', 'litespeed-cache' ), '<code>' . __( 'OFF', 'litespeed-cache' ) . '</code>' ) ; ?>
			</div>
		</td>
	</tr>

	<tr>
		<th class="litespeed-padding-left"></th>
		<td>
		<?php foreach ( $cdn_mapping as $v ) : ?>

			<div class="litespeed-block" data-litespeed-cdn-mapping="1">
				<div class='litespeed-cdn-mapping-col1'>
					<h4>
						<?php $id = LiteSpeed_Cache_Config::CDN_MAPPING_URL ; ?>
						<?php $this->title( $id ) ; ?>
						<button type="button" class="button litespeed-btn-danger" data-litespeed-cdn-mapping-del="1">X</button>
					</h4>

					<?php
						$this->build_input( LiteSpeed_Cache_Config::O_CDN_MAPPING . "[$id][]", 'litespeed-input-long', $v[ $id ] ) ;
					?>
					<div class="litespeed-desc">
						<?php echo sprintf( __( 'CDN URL to be used. For example, %s', 'litespeed-cache' ), '<code>' . $cdn_url . '</code>' ) ; ?>
					</div>
				</div>

				<div class='litespeed-cdn-mapping-col2'>
					<div class="litespeed-row">
						<div class="litespeed-cdn-mapping-inc">
							<?php $id = LiteSpeed_Cache_Config::CDN_MAPPING_INC_IMG ; ?>
							<?php $this->title( $id ) ; ?>
						</div>
					<?php
						$this->build_toggle( LiteSpeed_Cache_Config::O_CDN_MAPPING . "[$id][]", ! empty( $v[ $id ] ) ? true : false ) ;
					?>
					</div>
					<div class="litespeed-row">
						<div class="litespeed-cdn-mapping-inc">
							<?php $id = LiteSpeed_Cache_Config::CDN_MAPPING_INC_CSS ; ?>
							<?php $this->title( $id ) ; ?>
						</div>
					<?php
						$this->build_toggle( LiteSpeed_Cache_Config::O_CDN_MAPPING . "[$id][]", ! empty( $v[ $id ] ) ? true : false ) ;
					?>
					</div>
					<div class="litespeed-row">
						<div class="litespeed-cdn-mapping-inc">
							<?php $id = LiteSpeed_Cache_Config::CDN_MAPPING_INC_JS ; ?>
							<?php $this->title( $id ) ; ?>
						</div>
					<?php
						$this->build_toggle( LiteSpeed_Cache_Config::O_CDN_MAPPING . "[$id][]", ! empty( $v[ $id ] ) ? true : false ) ;
					?>
					</div>
				</div>

				<div class='litespeed-cdn-mapping-col3'>
					<div class="litespeed-row">
						<div class="litespeed-cdn-mapping-col3-title">
							<?php $id = LiteSpeed_Cache_Config::CDN_MAPPING_FILETYPE ; ?>
							<?php $this->title( $id ) ; ?>
						</div>
						<?php $this->build_textarea( LiteSpeed_Cache_Config::O_CDN_MAPPING . "[$id][]", 17, $v[ $id ] ) ; ?>
					</div>
				</div>
			</div>

		<?php endforeach ; ?>

			<p><button type="button" class="button litespeed-btn-success litespeed-btn-tiny" id="litespeed-cdn-mapping-add">+</button></p>

			<div class="litespeed-warning">
				<?php echo __('NOTE', 'litespeed-cache'); ?>:
				<?php echo __( 'To randomize CDN hostname, define multiple hostnames for the same resources.', 'litespeed-cache' ) ; ?>
			</div>

			<div class="litespeed-desc">
				<b><?php $this->title( LiteSpeed_Cache_Config::CDN_MAPPING_INC_IMG ) ; ?></b>:
				<?php echo sprintf( __( 'Serve all image files through the CDN. This will affect all attachments, HTML %s tags, and CSS %s attributes.', 'litespeed-cache' ), '<code>&lt;img</code>', '<code>url()</code>' ) ; ?>

				<br />
				<b><?php $this->title( LiteSpeed_Cache_Config::CDN_MAPPING_INC_CSS ) ; ?></b>:
				<?php echo __( 'Serve all CSS files through the CDN. This will affect all enqueued WP CSS files.', 'litespeed-cache' ) ; ?>

				<br />
				<b><?php $this->title( LiteSpeed_Cache_Config::CDN_MAPPING_INC_JS ) ; ?></b>:
				<?php echo __( 'Serve all JavaScript files through the CDN. This will affect all enqueued WP JavaScript files.', 'litespeed-cache' ) ; ?>

				<br />
				<b><?php $this->title( LiteSpeed_Cache_Config::CDN_MAPPING_FILETYPE ) ; ?></b>:
				<?php echo __( 'Static file type links to be replaced by CDN links.', 'litespeed-cache' ) ; ?>
				<?php LiteSpeed_Cache_Doc::one_per_line() ; ?>
				<?php echo sprintf( __( 'This will affect all tags containing attributes: %s %s %s.', 'litespeed-cache' ), '<code>src=""</code>', '<code>data-src=""</code>', '<code>href=""</code>' ) ; ?>
				<?php $this->learn_more( 'https://www.litespeedtech.com/support/wiki/doku.php/litespeed_wiki:cache:lscwp:configuration:cdn#include_file_types', __( 'Default value', 'litespeed-cache' ) ) ; ?>

				<br />
				<?php echo sprintf( __( 'If you turn any of the above settings OFF, please remove the related file types from the %s box.' ), '<b>' . __( 'Include File Types', 'litespeed-cache' ) . '</b>' ) ; ?>
				<?php $this->learn_more( 'https://www.litespeedtech.com/support/wiki/doku.php/litespeed_wiki:cache:lscwp:configuration:cdn#include_file_types' ) ; ?>
			</div>

		</td>
	</tr>

	<tr>
		<th class="litespeed-padding-left">
			<?php $id = LiteSpeed_Cache_Config::O_CDN_ORI ; ?>
			<?php $this->title( $id ) ; ?>
		</th>
		<td>
			<?php $this->build_textarea( $id ) ; ?>
			<div class="litespeed-desc">
				<?php echo sprintf( __( 'Site URL to be served through the CDN. Beginning with %1$s. For example, %2$s.', 'litespeed-cache' ), '<code>//</code>', '<code>' . $home_url . '</code>' ) ; ?>
				<br /><?php echo sprintf( __( 'Wildcard %1$s supported (match zero or more characters). For example, to match %2$s and %3$s, use %4$s.', 'litespeed-cache' ), '<code>*</code>', '<code>//www.aa.com</code>', '<code>//aa.com</code>', '<code>//*aa.com</code>' ) ; ?>
				<?php LiteSpeed_Cache_Doc::one_per_line() ; ?>
			</div>
		</td>
	</tr>

	<tr>
		<th class="litespeed-padding-left">
			<?php $id = LiteSpeed_Cache_Config::O_CDN_ORI_DIR ; ?>
			<?php $this->title( $id ) ; ?>
		</th>
		<td>
			<?php $this->build_textarea( $id, 40 ) ; ?>
			<?php $this->recommended( $id, true ) ; ?>
			<div class="litespeed-desc">
				<?php echo __( 'Only files within these directories will be pointed to the CDN.', 'litespeed-cache' ) ; ?>
				<?php LiteSpeed_Cache_Doc::one_per_line() ; ?>
			</div>
		</td>
	</tr>

	<tr>
		<th class="litespeed-padding-left">
			<?php $id = LiteSpeed_Cache_Config::O_CDN_EXC ; ?>
			<?php $this->title( $id ) ; ?>
		</th>
		<td>
			<?php $this->build_textarea( $id ) ; ?>
			<div class="litespeed-desc">
				<?php echo __( 'Paths containing these strings will not be served from the CDN.', 'litespeed-cache' ) ; ?>
				<?php LiteSpeed_Cache_Doc::one_per_line() ; ?>
			</div>
		</td>
	</tr>

	<tr>
		<th>
			<?php $id = LiteSpeed_Cache_Config::O_CDN_REMOTE_JQ ; ?>
			<?php $this->title( $id ) ; ?>
		</th>
		<td>
			<div class="litespeed-switch">
				<?php $this->build_radio(
					$id,
					LiteSpeed_Cache_Config::VAL_OFF,
					__( 'OFF', 'litespeed-cache' )
				) ; ?>

				<?php $this->build_radio(
					$id,
					LiteSpeed_Cache_Config::VAL_ON,
					'Google'
				) ; ?>

				<?php $this->build_radio(
					$id,
					LiteSpeed_Cache_Config::VAL_ON2,
					'Cdnjs'
				) ; ?>
			</div>
			<div class="litespeed-desc">
				<?php echo __( 'Improve page load time by loading jQuery from a remote CDN service instead of locally.', 'litespeed-cache' ) ; ?>
			</div>
		</td>
	</tr>

	<tr>
		<th>
			<?php $id = LiteSpeed_Cache_Config::O_CDN_QUIC ; ?>
			<?php $this->title( $id ) ; ?>
		</th>
		<td>
			<?php $this->build_switch( $id ) ; ?>
			<div class="litespeed-desc">
				<?php echo sprintf( __( 'Use %s API functionality.', 'litespeed-cache' ), 'QUIC.cloud' ) ; ?>

				<a id='litespeed_modal_href' href="https://quic.cloud" target="_blank">Register for free at QUIC.cloud</a>

				<!-- <link rel="stylesheet" href="<?php echo LSWCP_PLUGIN_URL ; ?>assets/css/iziModal.min.css"> -->
				<!-- <script src="<?php echo LSWCP_PLUGIN_URL ; ?>assets/js/iziModal.min.js"></script> -->
				<!-- <div id="litespeed_modal"></div> -->
				<script>
					// var litespeed_modal = jQuery("#litespeed_modal").iziModal({iframe: true});
					// jQuery("#litespeed_modal_href").click(function(event) {
					// 	event.preventDefault();
					// 	litespeed_modal.iziModal('open', event);
					// });;
				</script>
			</div>
			<div class="litespeed-block">
				<div class='litespeed-col'>
					<h4><?php echo __( 'Email Address', 'litespeed-cache' ) ; ?></h4>

					<?php $this->build_input( LiteSpeed_Cache_Config::O_CDN_QUIC_EMAIL ) ; ?>
					<div class="litespeed-desc">
						<?php echo sprintf( __( 'Your Email address on %s.', 'litespeed-cache' ), 'QUIC.cloud' ) ; ?>
					</div>
				</div>

				<div class='litespeed-col'>
					<h4><?php echo __( 'User API Key', 'litespeed-cache' ) ; ?></h4>

					<?php $this->build_input( LiteSpeed_Cache_Config::O_CDN_QUIC_KEY ) ; ?>
					<div class="litespeed-desc">
						<?php echo sprintf( __( 'Your API key is used to access %s APIs.', 'litespeed-cache' ), 'QUIC.cloud' ) ; ?>
						<?php echo sprintf( __( 'Get it from <a %1$s>%2$s</a>.', 'litespeed-cache' ), 'href="https://my.quic.cloud/dashboard" target="_blank"', 'QUIC.cloud' ) ; ?>
					</div>
				</div>

			</div>
		</td>
	</tr>

	<tr>
		<th>
			<?php $id = LiteSpeed_Cache_Config::O_CDN_CLOUDFLARE ; ?>
			<?php $this->title( $id ) ; ?>
		</th>
		<td>
			<?php $this->build_switch( $id ) ; ?>
			<div class="litespeed-desc">
				<?php echo sprintf( __( 'Use %s API functionality.', 'litespeed-cache' ), 'Cloudflare' ) ; ?>
				<?php echo sprintf( __( 'This can be managed from <a %2$s>%1$s</a>.', 'litespeed-cache' ), '<b>' . __( 'Manage', 'litespeed-cache' ) . '</b> -&gt; <b>' . __( 'CDN', 'litespeed-cache' ) . '</b>', 'href="admin.php?page=lscache-dash#cdn"' ) ; ?>
			</div>
			<div class="litespeed-block">
				<div class='litespeed-col'>
					<h4><?php echo __( 'Email Address', 'litespeed-cache' ) ; ?></h4>

					<?php $this->build_input( LiteSpeed_Cache_Config::O_CDN_CLOUDFLARE_EMAIL ) ; ?>
					<div class="litespeed-desc">
						<?php echo sprintf( __( 'Your Email address on %s.', 'litespeed-cache' ), 'Cloudflare' ) ; ?>
					</div>
				</div>

				<div class='litespeed-col'>
					<h4><?php echo __( 'Global API Key', 'litespeed-cache' ) ; ?></h4>

					<?php $this->build_input( LiteSpeed_Cache_Config::O_CDN_CLOUDFLARE_KEY ) ; ?>
					<div class="litespeed-desc">
						<?php echo sprintf( __( 'Your API key is used to access %s APIs.', 'litespeed-cache' ), 'Cloudflare' ) ; ?>
						<?php echo sprintf( __( 'Get it from <a %1$s>%2$s</a>.', 'litespeed-cache' ), 'href="https://www.cloudflare.com/a/profile" target="_blank"', 'Cloudflare' ) ; ?>
					</div>
				</div>

				<div class='litespeed-col'>
					<h4><?php echo __( 'Domain', 'litespeed-cache' ) ; ?></h4>

				<?php
					$cf_zone = LiteSpeed_Cache::config( LiteSpeed_Cache_Config::O_CDN_CLOUDFLARE_ZONE ) ;
					$cls = 	$cf_zone ? ' litespeed-input-success' : ' litespeed-input-warning' ;
					$this->build_input( LiteSpeed_Cache_Config::O_CDN_CLOUDFLARE_NAME, $cls ) ;
				?>
					<div class="litespeed-desc">
						<?php echo __( 'You can just type part of the domain.', 'litespeed-cache' ) ; ?>
						<?php echo __( 'Once saved, it will be matched with the current list and completed automatically.', 'litespeed-cache' ) ; ?>
					</div>
				</div>
			</div>
		</td>
	</tr>

</tbody></table>

<?php
$this->form_end() ;

