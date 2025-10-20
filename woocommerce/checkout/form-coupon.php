<?php
/**
 * Checkout coupon form
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/checkout/form-coupon.php.
 *
 * HOWEVER, on occasion WooCommerce will need to update template files and you
 * (the theme developer) will need to copy the new files to your theme to
 * maintain compatibility. We try to do this as little as possible, but it does
 * happen. When this occurs the version of the template file will be bumped and
 * the readme will list any important changes.
 *
 * @see https://docs.woocommerce.com/document/template-structure/
 * @package WooCommerce\Templates
 * @version 7.0.1
 */

defined( 'ABSPATH' ) || exit;

if ( ! wc_coupons_enabled() ) { // @codingStandardsIgnoreLine.
	return;
}

?>
<div class="container">
	<div class="row justify-content-center">
		<div class="text-sm" style="max-width: 730px; margin: 0 auto; padding: 1.2em 0; font-family: 'Orbitron', Arial, sans-serif;">
		<div class="woocommerce-form-coupon-toggle bg-transparent pt-4">
			<?php wc_print_notice( apply_filters( 'woocommerce_checkout_coupon_message', esc_html__( 'Have a coupon?', 'woocommerce' ) . ' <a class="showcoupon" style="cursor: pointer">' . esc_html__( 'Click here to enter your code', 'woocommerce' ) . '</a>' ), 'notice' ); ?>
		</div>

		<form class="checkout_coupon woocommerce-form-coupon" method="post" style="display:none">

			<p><?php esc_html_e( 'If you have a coupon code, please apply it below.', 'woocommerce' ); ?></p>

			<p class="form-group">
				<label for="coupon_code"><?php esc_html_e( 'Coupon:', 'woocommerce' ); ?></label>
				<input type="text" name="coupon_code" class="form-control form-control-lg" placeholder="<?php esc_attr_e( 'Coupon code', 'woocommerce' ); ?>" id="coupon_code" value="" />
			</p>

			<p class="form-group">
				<button type="submit" class="btn btn-light btn-lg form-control" name="apply_coupon" value="<?php esc_attr_e( 'Apply coupon', 'woocommerce' ); ?>"><?php esc_html_e( 'Apply coupon', 'woocommerce' ); ?></button>
			</p>

			<div class="clear"></div>
		</form>
		</div>
	</div>
</div>
