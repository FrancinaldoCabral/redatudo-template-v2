<?php

function prefix_subscriptions_checkout_button( $args = array() ) {

    $button_arr = wp_parse_args( $args, array(
        'variation_id'  => 0,
        'btn_class'     => array( 'button', 'button-primary' ),
        'btn_text'      => __( 'Sign Up' ),
        'btn_atts'      => array(),
    ) );

    $button_arr['btn_url'] = do_shortcode( '[add_to_cart_url id="' . intval( $button_arr['variation_id'] ) . '"]' );

    if( is_user_logged_in() && function_exists( 'wcs_get_users_subscriptions' ) ) {

        // Grab an array of user subscriptions
        $user_subscriptions = wcs_get_users_subscriptions();

        if( ! empty( $user_subscriptions ) ) {

            // Array( 'Subscription ID' => WC_Subscriptions Object );
            foreach( $user_subscriptions as $user_subscription_id => $subscription ) {

                // Loop through the users subscription order items to get the subscription order line item
                foreach( $subscription->get_items() as $item_line_number => $item_arr ) {

                    if( $user_subscription_id == $item_arr['order_id'] ) {

                        if( $item_arr['variation_id'] == $button_arr['variation_id'] ) {

                            // Change button based on status
                            switch( $subscription->get_status() ) {

                                case 'on-hold':
                                    $button_arr['btn_text']     = __( 'On Hold' );
                                    $button_arr['btn_class']    = array( 'button', 'button-secondary' );
                                    $button_arr['btn_url']      = 'javascript:void(0);';
                                  break;

                                case 'active':
                                    $button_arr['btn_text']     = __( 'Current' );
                                    $button_arr['btn_class']    = array( 'button', 'button-secondary' );
                                    $button_arr['btn_url']      = 'javascript:void(0);';
                                  break;

                                default:
                                    $button_arr['btn_url'] = add_query_arg( array(
                                            'add-to-cart'           => $item_arr['product_id'],
                                            'switch-subscription'   => $user_subscription_id,
                                            'variation_id'          => $button_arr['variation_id'],
                                            'item'                  => $item_line_number,
                                            '_wcsnonce'             => wp_create_nonce( 'wcs_switch_request' )
                                        ),
                                        wc_get_cart_url()
                                    );
                            }

                        }

                    }

                }

            }

        }

    }

    // Create button attributes
    $button_atts = '';
    if( ! empty( $button_arr['btn_atts'] ) && is_array( $button_arr['btn_atts'] ) ) {
        foreach( $button_arr['btn_atts'] as $attribute => $value ) {
            $button_atts .= sprintf( ' %1$s="%2$s"', esc_attr( $attribute ), esc_attr( $value ) );
        }
    }

    // Create button Classes
    if( ! empty( $button_arr['btn_class'] ) && is_array( $button_arr['btn_class'] ) ) {
        array_walk( $button_arr['btn_class'], 'esc_attr' );
        $button_arr['btn_class'] = implode( ' ', $button_arr['btn_class'] );
    }

    // Display Button
    printf( '<a href="%1$s" class="%2$s"%3$s>%4$s</a>',
        $button_arr['btn_url'],
        esc_attr( $button_arr['btn_class'] ),
        ( ! empty( $button_atts ) ) ? $button_atts : '',
        $button_arr['btn_text']
    );

}
?>