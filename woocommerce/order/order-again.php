<?php
/**
 * Order again button
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/order/order-again.php.
 *
 * HOWEVER, on occasion WooCommerce will need to update template files and you
 * (the theme developer) will need to copy the new files to your theme to
 * maintain compatibility. We try to do this as little as possible, but it does
 * happen. When this occurs the version of the template file will be bumped and
 * the readme will list any important changes.
 *
 * @see https://docs.woocommerce.com/document/template-structure/
 * @package WooCommerce\Templates
 * @version 3.5.0
 */

defined( 'ABSPATH' ) || exit;
?>

<div class="row">
	<div class="col">
		<p class="order-again">
			<?php echo $order_again_url ?>
			<a href="<?php echo esc_url( $order_again_url ); ?>" class="btn btn-success"><?php esc_html_e( 'Order again', 'woocommerce' ); ?></a>
		</p>
	</div>
</div>
