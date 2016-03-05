<?php
/*
 * Plugin Name: Easy Digital Downloads - Add Discount to Payment
 * Description: Allows store administrators to add a discount code to an existing payment.
 * Author: Pippin Williamson
 * Version: 1.0
 */

class PW_EDD_Add_Discount_To_Payment {
	
	public function __construct() {
		$this->init();
	}

	public function init() {
		add_action( 'edd_view_order_details_update_inner', array( $this, 'add_discount_field' ) );
		add_action( 'edd_updated_edited_purchase', array( $this, 'save_discount' ) );
	}

	public function add_discount_field( $payment_id = 0 ) {

		$payment   = new EDD_Payment( $payment_id );
		$discounts = empty( $payment->discounts ) || 'none' === $payment->discounts ? '' : $payment->discounts;
?>
		<script>jQuery(document).ready(function($){$('.edd-order-discount').remove();});</script>
		<div class="edd-order-discounts edd-admin-box-inside">
			<p>
				<span class="label"><?php _e( 'Discount Code:', 'easy-digital-downloads' ); ?></span>&nbsp;
				<input name="edd_discount" type="text" class="med-text" value="<?php echo esc_attr( $discounts ); ?>"/>
			</p>
		</div>
<?php
	}

	public function save_discount( $payment_id ) {

		$payment = new EDD_Payment( $payment_id );
		$payment->discounts = sanitize_text_field( $_POST['edd_discount'] );
		$payment->save();

	}

}

function pw_edd_add_discount_to_payment_load() {
	$plugin = new PW_EDD_Add_Discount_To_Payment;
	unset( $plugin );
}
add_action( 'plugins_loaded', 'pw_edd_add_discount_to_payment_load' );