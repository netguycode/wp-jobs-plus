<?php

/**
 * Author: Hoang Ngo
 */
class JobsExpert_Core_Shortcode_Buttons extends JobsExperts_Shortcode {
	public $plugin;

	public function  __construct() {
		$buttons = array(
			'jbp-expert-post-btn'    => 'expert_add',
			'jbp-job-post-btn'       => 'job_add',
			'jbp-job-browse-btn'     => 'job_list',
			'jbp-expert-profile-btn' => 'my_profile',
			'jbp-my-job-btn'         => 'my_jobs',
			'jbp-expert-browse-btn'  => 'expert_list',
		);

		foreach ( $buttons as $key => $val ) {
			$this->_add_shortcode( $key, $val );
		}

		$this->_add_action( 'wp_enqueue_scripts', 'scripts', 999 );
		$this->plugin = JobsExperts_Plugin::instance();
	}

	function scripts() {
		wp_register_style( 'jbp_shortcode', $this->plugin->_module_url . 'assets/css/job-plus-shortcode.css' );
	}

	/**
	 *
	 * This shortcode will render Add new Job button
	 *
	 * Shortcode attributes list
	 * text - The text below button
	 * view - both|loggedin|loggedout
	 * template - template to override this shortcode ability, not recommend to changes, the template location will be inside
	 *              current theme folder
	 * class - dark|bright|none
	 *
	 *
	 * @category JobsExperts
	 * @package  Shorcode
	 *
	 * @since    1.0.0
	 */
	function expert_add( $atts ) {
		wp_enqueue_style( 'jbp_shortcode' );
		$plugin      = JobsExperts_Plugin::instance();
		$page_module = $plugin->page_module();
		extract( shortcode_atts( array(
			'text'     => sprintf( __( 'Add an %s', JBP_TEXT_DOMAIN ), $plugin->get_expert_type()->labels->singular_name ),
			'view'     => 'both', //loggedin, loggedout, both
			'class'    => $plugin->settings()->theme,
			'template' => ''
		), $atts ) );
		//check does this can view
		if ( ! $this->can_view( $view ) ) {
			return '';
		}

		if ( ! empty( $template ) && locate_template( $template ) ) {
			return $this->custom_template( $template );
		}

		//todo update url
		$url = get_permalink( $page_module->page( $page_module::EXPERT_ADD ) );

		$ob = sprintf( '<a class="jbp-shortcode-button jbp-add-pro %s" href="%s">
			%s
		</a>', esc_attr( $class ), $url, esc_html( $text ) );

		return apply_filters( 'jbp_pro_post_btn_output', $ob );
	}

	/**
	 * This shortcode will render Add new Job button
	 *
	 * Shortcode attributes list
	 * text - The text below button
	 * view - both|loggedin|loggedout
	 * template - template to override this shortcode ability, not recommend to changes, the template location will be inside
	 *              current theme folder
	 * class - dark|bright|none
	 *
	 * @category JobsExperts
	 * @package  Shorcode
	 *
	 * @since    1.0.0
	 */
	function job_add( $atts ) {
		wp_enqueue_style( 'jbp_shortcode' );
		$plugin      = JobsExperts_Plugin::instance();
		$page_module = $plugin->page_module();
		extract( shortcode_atts( array(
			'text'     => sprintf( __( 'Post a %s', JBP_TEXT_DOMAIN ), $plugin->get_job_type()->labels->singular_name ),
			'view'     => 'both', //loggedin, loggedout, both
			'class'    => $plugin->settings()->theme,
			'template' => ''
		), $atts ) );
		//check does this can view
		if ( ! $this->can_view( $view ) ) {
			return '';
		}

		if ( ! empty( $template ) && locate_template( $template ) ) {
			return $this->custom_template( $template );
		}

		$url = get_permalink( $page_module->page( $page_module::JOB_ADD ) );
		$ob  = sprintf( '<a class="jbp-shortcode-button jbp-add-job %s" href="%s">
			%s
		</a>', esc_attr( $class ), $url, esc_html( $text ) );

		return apply_filters( 'jbp_job_post_btn_output', $ob );
	}

	/**
	 * This shortcode will render Listing Job Button
	 *
	 * Shortcode attributes list
	 * text - The text below button
	 * view - both|loggedin|loggedout
	 * template - template to override this shortcode ability, not recommend to changes, the template location will be inside
	 *              current theme folder
	 * class - dark|bright|none
	 *
	 * @category JobsExperts
	 * @package  Shorcode
	 *
	 * @since    1.0.0
	 */

	function expert_list( $atts ) {
		wp_enqueue_style( 'jbp_shortcode' );
		$plugin = JobsExperts_Plugin::instance();
		extract( shortcode_atts( array(
			'text'     => sprintf( __( 'Browse %s', JBP_TEXT_DOMAIN ), $plugin->get_expert_type()->labels->name ),
			'view'     => 'both', //loggedin, loggedout, both
			'class'    => $plugin->settings()->theme,
			'template' => ''
		), $atts ) );
		//check does this can view
		if ( ! $this->can_view( $view ) ) {
			return '';
		}

		if ( ! empty( $template ) && locate_template( $template ) ) {
			return $this->custom_template( $template );
		}
		//todo update url
		$url = get_post_type_archive_link( 'jbp_pro' );
		$ob  = sprintf( '<a class="jbp-shortcode-button jbp-browse-pro %s" href="%s">
			%s
		</a>', esc_attr( $class ), $url, esc_html( $text ) );

		return $ob;
	}

	/**
	 * This shortcode will render My Jobs Button
	 *
	 * Shortcode attributes list
	 * text - The text below button
	 * view - both|loggedin|loggedout
	 * template - template to override this shortcode ability, not recommend to changes, the template location will be inside
	 *              current theme folder
	 * class - dark|bright|none
	 *
	 *
	 * @category JobsExperts
	 * @package  Shorcode
	 *
	 * @since    1.0.0
	 */
	function job_list( $atts ) {
		wp_enqueue_style( 'jbp_shortcode' );
		$plugin = JobsExperts_Plugin::instance();
		extract( shortcode_atts( array(
			'text'     => sprintf( __( 'Browse %s', JBP_TEXT_DOMAIN ), $plugin->get_job_type()->labels->name ),
			'view'     => 'both', //loggedin, loggedout, both
			'class'    => $plugin->settings()->theme,
			'template' => ''
		), $atts ) );
		//check does this can view
		if ( ! $this->can_view( $view ) ) {
			return '';
		}

		if ( ! empty( $template ) && locate_template( $template ) ) {
			return $this->custom_template( $template );
		}

		//todo update url
		$url = get_post_type_archive_link( 'jbp_job' );
		$ob  = sprintf( '<a class="jbp-shortcode-button jbp-list-job %s" href="%s">
			%s
		</a>', esc_attr( $class ), $url, esc_html( $text ) );

		return apply_filters( 'jbp_job_list_btn_output', $ob );
	}

	function my_profile( $atts ) {
		wp_enqueue_style( 'jbp_shortcode' );
		$plugin = JobsExperts_Plugin::instance();
		$page_module = $plugin->page_module();
		extract( shortcode_atts( array(
			'text'     => __( 'My Profile', JBP_TEXT_DOMAIN ),
			'view'     => 'both', //loggedin, loggedout, both
			'class'    => $plugin->settings()->theme,
			'template' => ''
		), $atts ) );
		//check does this can view
		if ( ! $this->can_view( $view ) ) {
			return '';
		}
		//Don't display unless they have a profile.
		if ( $this->count_user_posts_by_type( get_current_user_id(), 'jbp_pro' ) < 1 ) {
			//return '';
		}

		if ( ! empty( $template ) && locate_template( $template ) ) {
			return $this->custom_template( $template );
		}

		//todo update url
		$url = get_permalink( $page_module->page( $page_module::MY_EXPERT ) );
		$ob  = sprintf( '<a class="jbp-shortcode-button jbp-profile-pro %s" href="%s">
			%s
		</a>', esc_attr( $class ), $url, esc_html( $text ) );

		return apply_filters( 'jbp_expert_profile_btn_output', $ob );
	}

	function my_jobs( $atts ) {
		wp_enqueue_style( 'jbp_shortcode' );
		$plugin      = JobsExperts_Plugin::instance();
		$page_module = $plugin->page_module();
		extract( shortcode_atts( array(
			'text'     => __( 'My Jobs', JBP_TEXT_DOMAIN ),
			'view'     => 'both', //loggedin, loggedout, both
			'class'    => $plugin->settings()->theme,
			'template' => ''
		), $atts ) );
		//check does this can view
		if ( ! $this->can_view( $view ) ) {
			return '';
		}
		//Don't display unless they have a posted a job.
		if ( $this->count_user_posts_by_type( get_current_user_id(), 'jbp_job' ) < 1 ) {
			return '';
		}

		if ( ! empty( $template ) && locate_template( $template ) ) {
			return $this->custom_template( $template );
		}

		$url = get_permalink( $page_module->page( $page_module::MY_JOB ) );
		$ob  = sprintf( '<a class="jbp-shortcode-button jbp-list-job %s" href="%s">
			%s
		</a>', esc_attr( $class ), $url, esc_html( $text ) );

		return apply_filters( 'jbp_job_list_btn_output', $ob );
	}
}

new JobsExpert_Core_Shortcode_Buttons();