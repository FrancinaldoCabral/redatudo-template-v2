<?php
/**
 * Show messages
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/notices/notice.php.
 *
 * HOWEVER, on occasion WooCommerce will need to update template files and you
 * (the theme developer) will need to copy the new files to your theme to
 * maintain compatibility. We try to do this as little as possible, but it does
 * happen. When this occurs the version of the template file will be bumped and
 * the readme will list any important changes.
 *
 * @see     https://woocommerce.com/document/template-structure/
 * @package WooCommerce\Templates
 * @version 8.6.0
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

if ( ! $notices ) {
	return;
}

$info_style = 'background: linear-gradient(145deg, rgba(59, 130, 246, 0.15) 0%, rgba(37, 99, 235, 0.1) 100%); border: 2px solid rgba(59, 130, 246, 0.4); border-left: 5px solid #3B82F6; border-radius: 16px; padding: 1.25rem 1.5rem; margin-bottom: 1.5rem; font-family: Inter, sans-serif; font-size: 1.05rem; color: #BFDBFE; line-height: 1.6; box-shadow: 0 4px 12px rgba(59, 130, 246, 0.15);';

?>

<?php foreach ( $notices as $notice ) : ?>
	<div class="woocommerce-info" style="<?php echo esc_attr( $info_style ); ?>"<?php echo wc_get_notice_data_attr( $notice ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?>>
		<?php echo wc_kses_notice( $notice['notice'] ); ?>
	</div>
<?php endforeach; ?>
