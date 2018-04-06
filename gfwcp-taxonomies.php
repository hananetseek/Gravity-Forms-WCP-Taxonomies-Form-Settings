<?php
/*
 * Plugin Name: 	Gravity Forms + WCP Taxonomies Form Settings
 * Plugin URI: 		https://www.netseek.com.au/
 * Description: 	Display WCP Taxonomy terms as checkbox fields that shows hierarchy.
 * Version: 		1.0.0.3
 * Author: 			Netseek Pty Ltd
 * Author URI: 		https://www.netseek.com.au/
 * License:    		GPL2
 * License URI:		https://www.gnu.org/licenses/gpl-2.0.html
 */
if ( ! defined( 'WPINC' ) ) { die(); }

if( !defined('GFWCP_BASE_DIR') ) { define('GFWCP_BASE_DIR', dirname(__FILE__)); }
if( !defined('GFWCP_BASE_URL') ) { define('GFWCP_BASE_URL', plugins_url( '', __FILE__ ) ); }

 class GFWCP_Taxonomies_Form {
	function __construct() {
		add_filter( 'gform_form_settings', array( $this, 'wcp_taxonomies_form_setting' ), 10, 2 );
		add_action( 'gform_pre_form_settings_save', array( $this, 'wcp_taxonomies_save_form_setting' ) );
		add_filter( 'gform_pre_render', array( $this, 'wcp_populate_checkbox' ), 999, 3 );
		add_filter( 'gform_pre_validation', array( $this, 'wcp_populate_checkbox' ), 999, 3 );
		add_filter( 'gform_pre_submission_filter', array( $this, 'wcp_populate_checkbox' ), 999, 3 );
		add_filter( 'gform_admin_pre_render', array( $this, 'wcp_populate_checkbox' ), 999, 3 );
		add_action( 'gform_after_create_post', array( $this, 'wcp_set_post_content' ), 999, 3 );
	}
	
	public function wcp_taxonomies_form_setting( $settings, $form ) {
		if ( ! is_array( $form['fields'] ) ) {
			return;
		}
		$select_options_all = array( '' => '-- Select --' );
		foreach ( $form['fields'] as $field ) {
			if( $field['type'] == 'checkbox' ){
				$field_id = $field['id'];
				$select_options_all[$field_id] = $field['label'];
			}
		}
		
		if( count( $select_options_all ) >= 2 ){
			$select_options_1 = '';
			$wcp_taxonomies_setting_1_value = rgar($form, 'wcp_taxonomies_setting_1');
			foreach( $select_options_all as $select_options_id => $select_options_label ){
				$select_options_1 .= '<option value="' . $select_options_id . '" '.selected( $wcp_taxonomies_setting_1_value, $select_options_id, false ).'>'.$select_options_label.'</option>';
			}
			$settings['WCP Form Options']['wcp_taxonomies_setting_1'] = '
				<tr>
					<th><label for="wcp_taxonomies_setting_1">WCP - '.get_option( 'ndf_category_1_filter_label', 'Category 1' ).'</label></th>
					<td><select name="wcp_taxonomies_setting_1">'.$select_options_1.'</select></td>
				</tr>';
			
			$select_options_2 = '';
			$wcp_taxonomies_setting_2_value = rgar($form, 'wcp_taxonomies_setting_2');
			foreach( $select_options_all as $select_options_id => $select_options_label ){
				$select_options_2 .= '<option value="' . $select_options_id . '" '.selected( $wcp_taxonomies_setting_2_value, $select_options_id, false ).'>'.$select_options_label.'</option>';
			}
			$settings['WCP Form Options']['wcp_taxonomies_setting_2'] = '
				<tr>
					<th><label for="wcp_taxonomies_setting_2">WCP - '.get_option( 'ndf_category_2_filter_label', 'Category 2' ).'</label></th>
					<td><select name="wcp_taxonomies_setting_2">'.$select_options_2.'</select></td>
				</tr>';
				
			$select_options_3 = '';
			$wcp_taxonomies_setting_3_value = rgar($form, 'wcp_taxonomies_setting_3');
			foreach( $select_options_all as $select_options_id => $select_options_label ){
				$select_options_3 .= '<option value="' . $select_options_id . '" '.selected( $wcp_taxonomies_setting_3_value, $select_options_id, false ).'>'.$select_options_label.'</option>';
			}
			$settings['WCP Form Options']['wcp_taxonomies_setting_3'] = '
				<tr>
					<th><label for="wcp_taxonomies_setting_3">WCP - '.get_option( 'ndf_category_3_filter_label', 'Category 3' ).'</label></th>
					<td><select name="wcp_taxonomies_setting_3">'.$select_options_3.'</select></td>
				</tr>';
			
			$select_options_4 = '';
			$wcp_taxonomies_setting_4_value = rgar($form, 'wcp_taxonomies_setting_4');
			foreach( $select_options_all as $select_options_id => $select_options_label ){
				$select_options_4 .= '<option value="' . $select_options_id . '" '.selected( $wcp_taxonomies_setting_4_value, $select_options_id, false ).'>'.$select_options_label.'</option>';
			}
			$settings['WCP Form Options']['wcp_taxonomies_setting_4'] = '
				<tr>
					<th><label for="wcp_taxonomies_setting_4">WCP - '.get_option( 'ndf_category_4_filter_label', 'Category 4' ).'</label></th>
					<td><select name="wcp_taxonomies_setting_4">'.$select_options_4.'</select></td>
				</tr>';

			$select_options_5 = '';
			$wcp_taxonomies_setting_5_value = rgar($form, 'wcp_taxonomies_setting_5');
			foreach( $select_options_all as $select_options_id => $select_options_label ){
				$select_options_5 .= '<option value="' . $select_options_id . '" '.selected( $wcp_taxonomies_setting_5_value, $select_options_id, false ).'>'.$select_options_label.'</option>';
			}
			$settings['WCP Form Options']['wcp_taxonomies_setting_5'] = '
				<tr>
					<th><label for="wcp_taxonomies_setting_5">WCP - '.get_option( 'ndf_category_5_filter_label', 'Category 5' ).'</label></th>
					<td><select name="wcp_taxonomies_setting_5">'.$select_options_5.'</select></td>
				</tr>';
				

		}
		
		$wcp_more_info_settings_value = rgar($form, 'wcp_more_info_settings');
		$settings['WCP Form Options']['wcp_more_info_settings'] = '
			<tr>
				<th><label for="wcp_more_info_settings">Form has WCP More Info Fields</label></th>
				<td><select name="wcp_more_info_settings"><option value="No" '.selected( $wcp_more_info_settings_value, "No", false ).'>No</option><option value="Yes" '.selected( $wcp_more_info_settings_value, "Yes", false ).'>Yes</option></select></td>
			</tr>';
			
		return $settings;
	}

	public function wcp_taxonomies_save_form_setting($form) {		
		$form['wcp_taxonomies_setting_1'] = rgpost( 'wcp_taxonomies_setting_1' );
		$form['wcp_taxonomies_setting_2'] = rgpost( 'wcp_taxonomies_setting_2' );
		$form['wcp_taxonomies_setting_3'] = rgpost( 'wcp_taxonomies_setting_3' );
		$form['wcp_taxonomies_setting_4'] = rgpost( 'wcp_taxonomies_setting_4' );
		$form['wcp_taxonomies_setting_5'] = rgpost( 'wcp_taxonomies_setting_5' );
		$form['wcp_more_info_settings'] = rgpost( 'wcp_more_info_settings' );
		return $form;
	}
	
	public function wcp_populate_checkbox( $form ) {
		
		$wcp_settings = array();
		$wcp_taxonomies_setting_1 = rgar($form, 'wcp_taxonomies_setting_1');
		if( !empty( $wcp_taxonomies_setting_1 ) ){
			$wcp_settings[$wcp_taxonomies_setting_1] = 1;
		}
		$wcp_taxonomies_setting_2 = rgar($form, 'wcp_taxonomies_setting_2');
		if( !empty( $wcp_taxonomies_setting_2 ) ){
			$wcp_settings[$wcp_taxonomies_setting_2] = 2;
		}
		$wcp_taxonomies_setting_3 = rgar($form, 'wcp_taxonomies_setting_3');
		if( !empty( $wcp_taxonomies_setting_3 ) ){
			$wcp_settings[$wcp_taxonomies_setting_3] = 3;
		}
		$wcp_taxonomies_setting_4 = rgar($form, 'wcp_taxonomies_setting_4');
		if( !empty( $wcp_taxonomies_setting_4 ) ){
			$wcp_settings[$wcp_taxonomies_setting_4] = 4;
		}
		$wcp_taxonomies_setting_5 = rgar($form, 'wcp_taxonomies_setting_5');
		if( !empty( $wcp_taxonomies_setting_5 ) ){
			$wcp_settings[$wcp_taxonomies_setting_5] = 5;
		}
		
		foreach( $form['fields'] as &$field )  {			
			if ( !array_key_exists( $field->id, $wcp_settings) ) {
				continue;
			}
			$choices = array();
			$inputs = array();
			$field_id = $field->id;
			$field_id_category = $wcp_settings[$field_id];

			$terms = $this->wcp_get_taxonomy_hierarchy( 'ndf_category_'.$field_id_category );
			$input_id = 1;
			foreach( $terms as $k => $term ) {

				if ( $input_id % 10 == 0 ) {
					$input_id++;
				}
				$choices[] = array( 'text' => $term['name'], 'value' => $k );
				$inputs[] = array( 'label' => $term['name'], 'id' => "{$field_id}.{$input_id}" );
				$input_id++;
				
				if( array_key_exists('children', $term ) ){
					$term['children'];
					foreach( $term['children'] as $t => $y ){
						if( array_key_exists('name', $y ) ){
							if ( $input_id % 10 == 0 ) {
								$input_id++;
							}
							
							$choices[] = array( 'text' => '--'.$y['name'], 'value' => $t );
							$inputs[] = array( 'label' => $y['name'], 'id' => "{$field_id}.{$input_id}" );
							$input_id++;
						}
					}
				}

			}
			
			$field->choices = $choices;
			$field->inputs = $inputs;
			$field->populateTaxonomy = 'ndf_category_'.$field_id_category;

		}

		return $form;
	}
	

	public function wcp_set_post_content( $post_id, $entry, $form ) {
		$post = get_post( $post_id );
		if ( isset ( $entry['post_id'] ) ) {
			if($post->post_type != 'ndf_data')
				return $post_id;

			// get all assigned terms
			$array_of_taxonomies = array( 'ndf_category_1', 'ndf_category_2', 'ndf_category_3', 'ndf_category_4', 'ndf_category_5' );
			foreach( $array_of_taxonomies as $wcp_tax ){
				$terms = wp_get_post_terms($post_id, $wcp_tax );
				foreach($terms as $term){
					while($term->parent != 0 && !has_term( $term->parent, $wcp_tax, $post )){
						// move upward until we get to 0 level terms
						wp_set_post_terms($post_id, array($term->parent), $wcp_tax, true);
						$term = get_term($term->parent, $wcp_tax);
					}
				}
			}
		}
	}
	
	public function wcp_get_taxonomy_hierarchy( $taxonomy, $parent = 0 ) {
		$taxonomy = is_array( $taxonomy ) ? array_shift( $taxonomy ) : $taxonomy;
		$terms = get_terms( $taxonomy, array( 'parent' => $parent, 'hide_empty' => false ) );

		$children = array();
		foreach ( $terms as $term ){
			$term->children = $this->wcp_get_taxonomy_hierarchy( $taxonomy, $term->term_id );
			if( empty( $term->children ) ){
				$children[$term->term_id] = array( 'name' => $term->name );
			}
			else{
				$children[$term->term_id] = array( 'name' => $term->name, 'children' => $term->children );
			}
		}
		return $children;
	}
}
new GFWCP_Taxonomies_Form();

/*
 * Plugin Updater.
 *
 * @since 1.0.0.2
 */
require_once( GFWCP_BASE_DIR . '/vendor/plugin-update-checker/plugin-update-checker.php' );

/**
 * Check for plugin updates.
 * 
 * @since 1.0.0.2
 */
function gfwcp_check_plugin_updates() {
	$ndf_UpdateChecker = Puc_v4_Factory::buildUpdateChecker(
		'https://github.com/hananetseek/Gravity-Forms-WCP-Taxonomies-Form-Settings',
		__FILE__,
		'gravity-forms-wcp-taxonomies'
	);

	$ndf_UpdateChecker->setBranch('master');
}
add_action( 'admin_init', 'gfwcp_check_plugin_updates' );