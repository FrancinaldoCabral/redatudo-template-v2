<?php
function isPageCreditCopy($product){
	if( $product->get_type() != 'variable-subscription') {
		return true;
	}else {
		return false;
	}
}

function has_active_subscription( $user_id='' ) {
	// When a $user_id is not specified, get the current user Id
	if( '' == $user_id && is_user_logged_in() ) 
			$user_id = get_current_user_id();
	// User not logged in we return false
	if( $user_id == 0 ) 
			return false;

	return wcs_user_has_subscription( $user_id, '', 'active' );
}

function buyCreditCopyIsPermited($product){
	if(isPageCreditCopy($product) && (!is_user_logged_in( ) || !has_active_subscription())){
		return 'disabled';
	}else{
		return '';
	}
}
