<?php

/**
 * The admin-specific functionality of the plugin.
 *
 * @link       #
 * @since      1.0.0
 *
 * @package    Hs_Od
 * @subpackage Hs_Od/admin
 */

/**
 * The admin-specific functionality of the plugin.
 *
 * Defines the plugin name, version, and two examples hooks for how to
 * enqueue the admin-specific stylesheet and JavaScript.
 *
 * @package    Hs_Od
 * @subpackage Hs_Od/admin
 * @author     HomeScript <homescript1@gmail.com>
 */
class Hs_Od_Admin {

	/**
	 * The ID of this plugin.
	 *
	 * @since    1.0.0
	 * @access   private
	 * @var      string    $plugin_name    The ID of this plugin.
	 */
	private $plugin_name;

	/**
	 * The version of this plugin.
	 *
	 * @since    1.0.0
	 * @access   private
	 * @var      string    $version    The current version of this plugin.
	 */
	private $version;

	/**
	 * Initialize the class and set its properties.
	 *
	 * @since    1.0.0
	 * @param      string    $plugin_name       The name of this plugin.
	 * @param      string    $version    The version of this plugin.
	 */
	public function __construct( $plugin_name, $version ) {

		$this->plugin_name = $plugin_name;
		$this->version = $version;

	}

	/**
	 * Register the stylesheets for the admin area.
	 *
	 * @since    1.0.0
	 */
	public function enqueue_styles() {

		/**
		 * This function is provided for demonstration purposes only.
		 *
		 * An instance of this class should be passed to the run() function
		 * defined in Hs_Od_Loader as all of the hooks are defined
		 * in that particular class.
		 *
		 * The Hs_Od_Loader will then create the relationship
		 * between the defined hooks and the functions defined in this
		 * class.
		 */

		wp_enqueue_style( $this->plugin_name, plugin_dir_url( __FILE__ ) . 'css/hs-od-admin.css', array(), $this->version, 'all' );

	}

	/**
	 * Register the JavaScript for the admin area.
	 *
	 * @since    1.0.0
	 */
	public function enqueue_scripts() {

		/**
		 * This function is provided for demonstration purposes only.
		 *
		 * An instance of this class should be passed to the run() function
		 * defined in Hs_Od_Loader as all of the hooks are defined
		 * in that particular class.
		 *
		 * The Hs_Od_Loader will then create the relationship
		 * between the defined hooks and the functions defined in this
		 * class.
		 */

		wp_enqueue_script( $this->plugin_name, plugin_dir_url( __FILE__ ) . 'js/hs-od-admin.js', array( 'jquery' ), $this->version, false );
		wp_localize_script(
			$this->plugin_name,
			'hs_od_ajax_object',
			[
				'hs_od_ajax_url'      => admin_url( 'admin-ajax.php' ),
				'hs_od_ajax_security' => wp_create_nonce( 'hs-od-ajax-nonce' ),
			]
		);
	}

	//TODO : ajouter une metabox dans la commande parente
	public function add_meta_box(){
		add_meta_box('hs_od', __('Duplicate this order', 'hs_od'), array($this, 'meta_box_content'), 'shop_order','side',"high");
	}

	public function meta_box_content(){
		?>
			<p class="hs_od">
		<?php
		homescript_button('hs_od',array(
			'class' => array('hs_od_label'),
			'value' => __('Duplicate this order','hs_od') , 
			'label' => __('Duplicate this order : ','hs_od'),
			'label_class' => array('hs_od'),
			'id' => 'hs_od'
		));
		?>
			</p>
		<?php
	}

	public function duplicate_order(){
		if ( $_POST['post_id'] && wp_verify_nonce( $_POST['security'], 'hs-od-ajax-nonce' ) ){
			$wc_order_id = wp_unslash($_POST['post_id']);
			$wc_order_obj = wc_get_order($wc_order_id);
			global $woocommerce;
			
			
			//billing data
			$billing_name = $wc_order_obj->get_formatted_billing_full_name();
			$billing_phone = $wc_order_obj->get_billing_phone();
			$billing_post_code = $wc_order_obj->get_billing_postcode();
			$billing_adress1 = $wc_order_obj->get_billing_address_1();
			$billing_adress2 = $wc_order_obj->get_billing_address_2();
			$billing_city = $wc_order_obj->get_billing_city();
			$billing_company = $wc_order_obj->get_billing_company();
			$billing_email = $wc_order_obj->get_billing_email();
			$billing_state = $wc_order_obj->get_billing_state();
			$billing_country = $wc_order_obj->get_billing_country();
			

			
			$billing_data = array(
				'first_name' => $billing_name,
				'last_name'  => '',
				'company'    => $billing_company,
				'email'      => $billing_email,
				'phone'      => $billing_phone,
				'address_1'  => $billing_adress1,
				'address_2'  => $billing_adress2,
				'city'       => $billing_city,
				'state'      => $billing_state,
				'postcode'   => $billing_post_code,
				'country'    => $billing_country
			);

			
			//shipping data

			$shipping_name = $wc_order_obj->get_formatted_shipping_full_name();
			$shipping_post_code = $wc_order_obj->get_shipping_postcode();
			$shipping_adress1 = $wc_order_obj->get_shipping_address_1();
			$shipping_adress2 = $wc_order_obj->get_shipping_address_2();
			$shipping_city = $wc_order_obj->get_shipping_city();
			$shipping_email = $wc_order_obj->get_shipping_address_map_url();
			$shipping_state = $wc_order_obj->get_shipping_state();
			$shipping_country = $wc_order_obj->get_shipping_country();
			$shipping_company_name = $wc_order_obj->get_shipping_company();


			$shipping_data = array(
				'first_name' => $shipping_name,
				'last_name'  => '',
				'company'    => $shipping_company_name,
				'email'      => $shipping_email,
				'address_1'  => $shipping_adress1,
				'address_2'  => $shipping_adress2,
				'city'       => $shipping_city,
				'state'      => $shipping_state,
				'postcode'   => $shipping_post_code,
				'country'    => $shipping_country
			);


			$order_items = $wc_order_obj->get_items();
			$new_wc_order_id = wc_create_order(array(
				'status' => apply_filters('woocommerce_default_order_status', 'processing'),
			));

			foreach($order_items as $item_id => $item_data){
				$product = $item_data->get_product();
				$product_id = $product->get_id();

				$item_quantity = $item_data->get_quantity(); // Get the item quantity
				
				 $new_wc_order_id->add_product(wc_get_product($product_id), $item_quantity);
				
		   
			}
			$new_wc_order_id->set_address( $billing_data, 'billing' );
			$new_wc_order_id->set_address( $billing_data, 'shipping' );
			$new_wc_order_id->calculate_totals();
			
			$final_order_id = $new_wc_order_id->get_id();
			echo "This order is duplicated succesfully, you can access it by following the following link  : ". get_site_url().'/wp-admin/post.php?post='.$final_order_id.'&action=edit';
		}
		wp_die();
	}
}
