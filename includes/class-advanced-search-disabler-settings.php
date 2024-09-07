<?php

class Advanced_Search_Disabler_Settings {

	private string $plugin_name;
	private array $disabler_mode;

	public function __construct( string $plugin_name ) {
		$this->plugin_name   = $plugin_name;
		$this->disabler_mode = array( 'full_page', 'logged_out_users', 'exclude_post_ids' );
	}

	/**
	 * Registers settings and options for the plugin.
	 */
	public function register_settings(): void {
		register_setting( $this->plugin_name, 'advanced_search_disabler_option', array( $this, 'sanitization_callback_options_page' ) );

		add_settings_section(
			'advanced_search_disabler_main_section',
			esc_html__( 'Default Settings', 'advanced-search-disabler' ),
			array( $this, 'render_sections_field' ),
			'advanced-search-disabler-settings-page'
		);

		add_settings_field(
			'advanced_search_disabler_mode_option',
			esc_html__( 'Deactivate search for', 'advanced-search-disabler' ),
			array( $this, 'render_disabler_mode_radio_field' ),
			'advanced-search-disabler-settings-page',
			'advanced_search_disabler_main_section'
		);

		add_settings_field(
			'advanced_search_disabler_page_ids_option',
			esc_html__( 'Excluded page IDs', 'advanced-search-disabler' ),
			array( $this, 'render_disabler_exclude_post_ids_text_field' ),
			'advanced-search-disabler-settings-page',
			'advanced_search_disabler_main_section'
		);
	}

	public function render_sections_field(): void {

		echo '<p class="description">' . esc_html__( 'Select your preferred options for the Advanced Search Disabler.', 'advanced-search-disabler' ) . '</p>';
	}

	public function render_disabler_mode_radio_field(): void {
		$options      = get_option( 'advanced_search_disabler_option' );
		$radio_option = $options['disabler_mode'] ?? '';

		echo '<input type="radio" name="advanced_search_disabler_option[disabler_mode]" value="full_page" ' . checked( 'full_page', $radio_option, false ) . '> ' . esc_html__( 'Entire website', 'advanced-search-disabler' ) . '<br>';
		echo '<input type="radio" name="advanced_search_disabler_option[disabler_mode]" value="logged_out_users" ' . checked( 'logged_out_users', $radio_option, false ) . '> ' . esc_html__( 'For logged out users', 'advanced-search-disabler' ) . '<br>';
		echo '<input type="radio" name="advanced_search_disabler_option[disabler_mode]" value="exclude_post_ids" ' . checked( 'exclude_post_ids', $radio_option, false ) . '> ' . esc_html__( 'Exclude post IDs', 'advanced-search-disabler' ) . '<br>';
	}

	public function render_disabler_exclude_post_ids_text_field(): void {
		$options = get_option( 'advanced_search_disabler_option' );

		if ( ! empty( $options['exclude_post_ids'] ) ) {
			$exclude_post_ids = $options['exclude_post_ids'];
		} else {
			$exclude_post_ids = '';
		}

		echo '<input type="text" id="exclude_post_ids" name="advanced_search_disabler_option[exclude_post_ids]" value="' . esc_attr( $exclude_post_ids ) . '" autocomplete="off">';
		echo '<p class="description">' . esc_html__( 'Here you can enter the post IDs you want to exclude from the search. Make sure to select the Exclude post IDs option at the top.', 'advanced-search-disabler' ) . '</p>';
	}

	public function sanitization_callback_options_page( $input ): array {
		$output = array();

		if ( ! empty( $input['disabler_mode'] ) && in_array( $input['disabler_mode'], $this->disabler_mode, true ) ) {
			$output['disabler_mode'] = sanitize_text_field( $input['disabler_mode'] );
		} else {
			$output['disabler_mode'] = 'full_page';
		}

		if ( ! empty( $input['exclude_post_ids'] ) ) {
			$exclude_post_ids           = preg_replace( '/[^0-9,]/', '', sanitize_text_field( $input['exclude_post_ids'] ) );
			$exclude_post_ids           = trim( $exclude_post_ids, ',' );
			$exclude_post_ids           = preg_replace( '/,+/', ',', $exclude_post_ids );
			$output['exclude_post_ids'] = $exclude_post_ids;
		} else {
			$output['exclude_post_ids'] = '';
		}

		return $output;
	}

	public static function install_default_settings(): void {

		if ( ! current_user_can( 'manage_options' ) ) {
			return;
		}

		$options = get_option( 'advanced_search_disabler_option', array() );

		if ( empty( $options['disabler_mode'] ) ) {
			$options['disabler_mode'] = 'full_page';
		}

		if ( ! isset( $options['exclude_post_ids'] ) || ! is_string( $options['exclude_post_ids'] ) ) {
			$options['exclude_post_ids'] = '';
		}

		update_option( 'advanced_search_disabler_option', $options );
	}

	public function display_options_page(): void {
		if ( ! current_user_can( 'manage_options' ) ) {
			return;
		}

		?>
		<div class="wrap">
			<h2><?php echo esc_html( get_admin_page_title() ); ?></h2>
			<form action="options.php" method="post">
				<?php
				settings_fields( 'advanced-search-disabler' );
				do_settings_sections( 'advanced-search-disabler-settings-page' );
				submit_button();
				?>
			</form>
		</div>
		<?php
	}
}
