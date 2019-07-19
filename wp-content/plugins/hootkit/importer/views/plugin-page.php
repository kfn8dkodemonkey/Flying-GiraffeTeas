<?php
/**
 * The plugin page view - the "settings" page of the plugin.
 *
 * @package ocdi
 */

namespace HKOCDI;

$predefined_themes = $this->import_files;

if ( ! empty( $this->import_files ) && isset( $_GET['import-mode'] ) && 'manual' === $_GET['import-mode'] ) {
	$predefined_themes = array();
}

?>

<div class="ocdi  wrap  about-wrap">

	<?php ob_start(); ?>
		<h1 class="ocdi__title  dashicons-before  dashicons-upload"><?php esc_html_e( '1 Click Content Install', 'hootkit' ); ?></h1>
	<?php
	$plugin_title = ob_get_clean();

	// Display the plugin title (can be replaced with custom title text through the filter below).
	echo wp_kses_post( apply_filters( 'hkocdi/plugin_page_title', $plugin_title ) );

	// Display warrning if PHP safe mode is enabled, since we wont be able to change the max_execution_time.
	if ( ini_get( 'safe_mode' ) ) {
		printf(
			esc_html__( '%sWarning: your server is using %sPHP safe mode%s. This means that you might experience server timeout errors.%s', 'hootkit' ),
			'<div class="notice  notice-warning  is-dismissible"><p>',
			'<strong>',
			'</strong>',
			'</p></div>'
		);
	}

	// Start output buffer for displaying the plugin intro text.
	ob_start();
	?>

	<div id="ocdi-hk">
	<div class="ocdi-hk-left">

	<div class="ocdi__intro-text">
		<p class="about-description">
			<?php
			if ( !empty( $predefined_themes ) && is_array( $predefined_themes ) ) : foreach ( $predefined_themes as $index => $import_file ) :
				$linkstart = ( !empty( $import_file['preview_url'] ) ) ? '<a href="' . esc_url( $import_file['preview_url'] ) . '" target="_blank">' : '';
				$linkend = ( !empty( $import_file['preview_url'] ) ) ? '</a>' : '';
				break;
			endforeach; else:
				$linkstart = $linkend = '';
			endif;
			/* Translators: 1 is the link start markup, 2 is link markup end */
			printf( esc_html__( 'Installing demo content (post, pages, images, theme settings, ...) is the easiest way to setup your theme and make it look exactly like the %1$sDemo Site%2$s.', 'hootkit' ), $linkstart, $linkend );
			echo '<br />';
			esc_html_e( 'It will allow you to quickly edit everything instead of creating content from scratch.', 'hootkit' );
			?>
		</p>
		<p class="ulhead"><?php esc_html_e( 'It is recommended to install demo content on a fresh new site:', 'hootkit' ); ?></p>
		<ul>
			<li><?php esc_html_e( 'Your existing content (posts, pages, categories, images etc) will NOT be deleted or modified.', 'hootkit' ); ?></li>
			<li><?php printf( esc_html__( 'Demo Posts, Pages, Images, Widgets, Menus and other theme settings will get imported and installed. This action cannot be undone.%1$s%2$sIf you already have existing posts/pages, the extra content may lead to confusion. Hence it is recommended to install demo content only on a new site.%3$s', 'hootkit' ), '<br />', '<em>', '</em>' ); ?></li>
			<li><?php printf( esc_html__( 'Type %1$sAccept%2$s in this field before clicking the Install button below.', 'hootkit' ), '<strong>', '</strong>' ); ?> <input name="hkocdiaccept" type="text" id="hkocdiaccept"><p id="ocdi__hk-acceptnotice" class="ocdi__hk-hide"><?php printf( esc_html__( 'Please type %1$sAccept%2$s in this field to continue.', 'hootkit' ), '<strong>', '</strong>' ); ?></p></li>
		</ul>

		<?php if ( ! empty( $this->import_files ) ) : ?>
			<?php if ( empty( $_GET['import-mode'] ) || 'manual' !== $_GET['import-mode'] ) : ?>
				<a href="<?php echo esc_url( add_query_arg( array( 'page' => $this->plugin_page_setup['menu_slug'], 'import-mode' => 'manual' ), admin_url( $this->plugin_page_setup['parent_slug'] ) ) ); ?>" class="ocdi__import-mode-switch"><?php esc_html_e( 'Switch to manual import!', 'hootkit' ); ?></a>
			<?php else : ?>
				<a href="<?php echo esc_url( add_query_arg( array( 'page' => $this->plugin_page_setup['menu_slug'] ), admin_url( $this->plugin_page_setup['parent_slug'] ) ) ); ?>" class="ocdi__import-mode-switch"><?php esc_html_e( 'Switch back to theme predefined imports!', 'hootkit' ); ?></a>
			<?php endif; ?>
		<?php endif; ?>

		<hr>
	</div>

	<?php
	$plugin_intro_text = ob_get_clean();

	// Display the plugin intro text (can be replaced with custom text through the filter below).
	echo $plugin_intro_text; // echo wp_kses_post( apply_filters( 'hkocdi/plugin_intro_text', $plugin_intro_text ) );
	?>

	<?php if ( empty( $this->import_files ) ) : ?>
		<div class="notice  notice-info  is-dismissible">
			<p><?php esc_html_e( 'There are no predefined import files available in this theme. Please upload the import files manually!', 'hootkit' ); ?></p>
		</div>
	<?php endif; ?>

	<?php if ( empty( $predefined_themes ) ) : ?>

		<div class="ocdi__file-upload-container">
			<h2><?php esc_html_e( 'Manual demo files upload', 'hootkit' ); ?></h2>

			<div class="ocdi__file-upload">
				<h3><label for="content-file-upload"><?php esc_html_e( 'Choose a XML file for content import:', 'hootkit' ); ?></label></h3>
				<input id="ocdi__content-file-upload" type="file" name="content-file-upload">
			</div>

			<div class="ocdi__file-upload">
				<h3><label for="widget-file-upload"><?php esc_html_e( 'Choose a WIE or JSON file for widget import:', 'hootkit' ); ?></label></h3>
				<input id="ocdi__widget-file-upload" type="file" name="widget-file-upload">
			</div>

			<div class="ocdi__file-upload">
				<h3><label for="customizer-file-upload"><?php esc_html_e( 'Choose a DAT file for customizer import:', 'hootkit' ); ?></label></h3>
				<input id="ocdi__customizer-file-upload" type="file" name="customizer-file-upload">
			</div>

			<?php if ( class_exists( 'ReduxFramework' ) ) : ?>
			<div class="ocdi__file-upload">
				<h3><label for="redux-file-upload"><?php esc_html_e( 'Choose a JSON file for Redux import:', 'hootkit' ); ?></label></h3>
				<input id="ocdi__redux-file-upload" type="file" name="redux-file-upload">
				<div>
					<label for="redux-option-name" class="ocdi__redux-option-name-label"><?php esc_html_e( 'Enter the Redux option name:', 'hootkit' ); ?></label>
					<input id="ocdi__redux-option-name" type="text" name="redux-option-name">
				</div>
			</div>
			<?php endif; ?>
		</div>

		<p class="ocdi__button-container">
			<button class="ocdi__button  button  button-hero  button-primary  js-ocdi-import-data"><?php esc_html_e( 'Import Demo Data', 'hootkit' ); ?></button>
		</p>

	<?php elseif ( 1 === count( $predefined_themes ) ) : ?>

		<?php
		if ( is_array( $predefined_themes ) && ! empty( $predefined_themes[0]['import_notice'] ) ) {
			echo '<div class="ocdi__demo-import-notice ocdi__hk-noticebox js-ocdi-demo-import-notice">' . wp_kses_post( $predefined_themes[0]['import_notice'] ) . '</div>';
		}
		?>

		<div class="ocdi__hk-noticebox warningbox"><?php printf( esc_html__( 'Please click on the Install button only once and wait.%1$sIt may take a couple of minutes depending upon the size of the content.', 'hootkit' ), '<br />'); ?></div>

		<p class="ocdi__button-container">
			<button class="ocdi__button  button  button-hero  button-primary  js-ocdi-import-data"><?php esc_html_e( 'Install Demo Content', 'hootkit' ); ?></button>
		</p>

	<?php else : ?>

		<!-- HKOCDI grid layout -->
		<div class="ocdi__gl  js-ocdi-gl">
		<?php
			// Prepare navigation data.
			$categories = Helpers::get_all_demo_import_categories( $predefined_themes );
		?>
			<?php if ( ! empty( $categories ) ) : ?>
				<div class="ocdi__gl-header  js-ocdi-gl-header">
					<nav class="ocdi__gl-navigation">
						<ul>
							<li class="active"><a href="#all" class="ocdi__gl-navigation-link  js-ocdi-nav-link"><?php esc_html_e( 'All', 'hootkit' ); ?></a></li>
							<?php foreach ( $categories as $key => $name ) : ?>
								<li><a href="#<?php echo esc_attr( $key ); ?>" class="ocdi__gl-navigation-link  js-ocdi-nav-link"><?php echo esc_html( $name ); ?></a></li>
							<?php endforeach; ?>
						</ul>
					</nav>
					<div clas="ocdi__gl-search">
						<input type="search" class="ocdi__gl-search-input  js-ocdi-gl-search" name="ocdi-gl-search" value="" placeholder="<?php esc_html_e( 'Search demos...', 'hootkit' ); ?>">
					</div>
				</div>
			<?php endif; ?>
			<div class="ocdi__gl-item-container  wp-clearfix  js-ocdi-gl-item-container">
				<?php foreach ( $predefined_themes as $index => $import_file ) : ?>
					<?php
						// Prepare import item display data.
						$img_src = isset( $import_file['import_preview_image_url'] ) ? $import_file['import_preview_image_url'] : '';
						// Default to the theme screenshot, if a custom preview image is not defined.
						if ( empty( $img_src ) ) {
							$theme = wp_get_theme();
							$img_src = $theme->get_screenshot();
						}

					?>
					<div class="ocdi__gl-item js-ocdi-gl-item" data-categories="<?php echo esc_attr( Helpers::get_demo_import_item_categories( $import_file ) ); ?>" data-name="<?php echo esc_attr( strtolower( $import_file['import_file_name'] ) ); ?>">
						<div class="ocdi__gl-item-image-container">
							<?php if ( ! empty( $img_src ) ) : ?>
								<img class="ocdi__gl-item-image" src="<?php echo esc_url( $img_src ) ?>">
							<?php else : ?>
								<div class="ocdi__gl-item-image  ocdi__gl-item-image--no-image"><?php esc_html_e( 'No preview image.', 'hootkit' ); ?></div>
							<?php endif; ?>
						</div>
						<div class="ocdi__gl-item-footer<?php echo ! empty( $import_file['preview_url'] ) ? '  ocdi__gl-item-footer--with-preview' : ''; ?>">
							<h4 class="ocdi__gl-item-title" title="<?php echo esc_attr( $import_file['import_file_name'] ); ?>"><?php echo esc_html( $import_file['import_file_name'] ); ?></h4>
							<button class="ocdi__gl-item-button  button  button-primary  js-ocdi-gl-import-data" value="<?php echo esc_attr( $index ); ?>"><?php esc_html_e( 'Import', 'hootkit' ); ?></button>
							<?php if ( ! empty( $import_file['preview_url'] ) ) : ?>
								<a class="ocdi__gl-item-button  button" href="<?php echo esc_url( $import_file['preview_url'] ); ?>" target="_blank"><?php esc_html_e( 'Preview', 'hootkit' ); ?></a>
							<?php endif; ?>
						</div>
					</div>
				<?php endforeach; ?>
			</div>
		</div>

		<div id="js-ocdi-modal-content"></div>

	<?php endif; ?>

	<p class="ocdi__ajax-loader  js-ocdi-ajax-loader">
		<span class="spinner"></span> <?php printf( esc_html__( 'Installing, please wait!%1$sThis may take a few minutes.%1$sDo not navigate away from this page while the content is being installed.', 'hootkit' ), '<br />&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;' ); ?>
	</p>

	<div class="ocdi__response  js-ocdi-ajax-response"></div>

	</div><!-- .ocdi-hk-left -->

	<?php
	if ( !empty( $predefined_themes ) && is_array( $predefined_themes ) ) :
	foreach ( $predefined_themes as $index => $import_file ) :
		if ( function_exists( 'hoot_data' ) ) {
			$prvwname = hoot_data( 'template_name' );
			$prvwvers = hoot_data( 'template_version' );
			$prvwauth = hoot_data( 'template_author' );
		} else {
			$theme = wp_get_theme();
			if ( is_child_theme() ) {
				$prvwname = $theme->parent()->get( 'Name' );
				$prvwvers = $theme->parent()->get( 'Version' );
				$prvwauth = $theme->parent()->get( 'Author' );
			} else {
				$prvwname = $theme->get( 'Name' );
				$prvwvers = $theme->get( 'Version' );
				$prvwauth = $theme->get( 'Author' );
			}
		}
		echo '<div class="ocdi-hk-right">';
			if ( !empty( $import_file['import_preview_image_url'] ) )
				echo '<div class="ocdi-hk-previmg"><img src="' . esc_url( $import_file['import_preview_image_url'] ) . '" /></div>';
			echo '<div class="ocdi-hk-prvwdata">';
				if ( $prvwname ) echo '<div class="ocdi-hk-prvwname"><strong>' . esc_html( 'Theme Name:', 'hootkit' ) . ' ' . esc_html( $prvwname ) . '</strong></div>';
				if ( $prvwvers ) echo '<div class="ocdi-hk-prvwvers"><strong>' . esc_html( 'Theme Version:', 'hootkit' ) . ' ' . esc_html( $prvwvers ) . '</strong></div>';
				if ( $prvwauth ) echo '<div class="ocdi-hk-prvwauth"><strong>' . esc_html( 'Theme Author:', 'hootkit' ) . ' ' . esc_html( $prvwauth ) . '</strong></div>';
				if ( !empty( $import_file['preview_url'] ) )
					echo '<div class="ocdi-hk-prvwlink"><a class="button" href="' . esc_url( $import_file['preview_url'] ) . '" target="_blank">' . esc_html( 'View Demo', 'hootkit' ) . '</a> <a class="button" href="https://wphoot.com/support/" target="_blank">' . esc_html( 'Get Support', 'hootkit' ) . '</a></div>';
			echo '</div>';
		echo '</div><!-- .ocdi-hk-right -->';
	break;
	endforeach;
	endif;
	?>

	</div><!-- #ocdi-hk -->
</div>
