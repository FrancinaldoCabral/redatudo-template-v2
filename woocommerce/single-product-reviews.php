<?php
/**
 * Display single product reviews (comments)
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/single-product-reviews.php.
 *
 * HOWEVER, on occasion WooCommerce will need to update template files and you
 * (the theme developer) will need to copy the new files to your theme to
 * maintain compatibility. We try to do this as little as possible, but it does
 * happen. When this occurs the version of the template file will be bumped and
 * the readme will list any important changes.
 *
 * @see     https://docs.woocommerce.com/document/template-structure/
 * @package WooCommerce\Templates
 * @version 4.3.0
 */

defined( 'ABSPATH' ) || exit;

global $product;

if ( ! comments_open() ) {
	return;
}

?>

<style>
.woo-reviews-section {
  background: #0F0F1A;
  padding: 3rem 0;
  margin-top: 3rem;
  border-top: 1px solid rgba(75, 85, 99, 0.3);
}

.woo-reviews-container {
  max-width: 900px;
  margin: 0 auto;
  padding: 0 1rem;
}

.woo-reviews-title {
  font-family: 'Outfit', sans-serif;
  font-size: clamp(1.75rem, 3vw, 2.25rem);
  font-weight: 700;
  color: #FFFFFF;
  margin-bottom: 2rem;
  text-align: center;
  letter-spacing: -0.01em;
}

.woo-reviews-title .gradient-text {
  background: linear-gradient(135deg, #A78BFA 0%, #60A5FA 100%);
  -webkit-background-clip: text;
  -webkit-text-fill-color: transparent;
  background-clip: text;
}

.woo-reviews-list {
  list-style: none;
  padding: 0;
  margin: 0 0 3rem 0;
}

.woo-review-item {
  background: linear-gradient(145deg, rgba(31, 41, 55, 0.8) 0%, rgba(17, 24, 39, 0.8) 100%);
  border: 2px solid rgba(75, 85, 99, 0.3);
  border-radius: 20px;
  padding: 2rem;
  margin-bottom: 1.5rem;
  transition: all 0.3s ease;
}

.woo-review-item:hover {
  border-color: rgba(124, 58, 237, 0.5);
  box-shadow: 0 8px 24px rgba(124, 58, 237, 0.2);
}

.woo-review-header {
  display: flex;
  justify-content: space-between;
  align-items: center;
  margin-bottom: 1rem;
  flex-wrap: wrap;
  gap: 1rem;
}

.woo-review-author {
  font-family: 'Outfit', sans-serif;
  font-size: 1.125rem;
  font-weight: 600;
  color: #FFFFFF;
}

.woo-review-rating {
  color: #FBBF24;
  font-size: 1.125rem;
}

.woo-review-date {
  font-family: 'Inter', sans-serif;
  font-size: 0.875rem;
  color: #9CA3AF;
}

.woo-review-text {
  font-family: 'Inter', sans-serif;
  font-size: 1.05rem;
  color: #E5E7EB;
  line-height: 1.7;
  margin-top: 1rem;
}

.woo-no-reviews {
  text-align: center;
  padding: 3rem 2rem;
  background: linear-gradient(145deg, rgba(31, 41, 55, 0.8) 0%, rgba(17, 24, 39, 0.8) 100%);
  border: 2px solid rgba(75, 85, 99, 0.3);
  border-radius: 20px;
}

.woo-no-reviews p {
  font-family: 'Inter', sans-serif;
  font-size: 1.125rem;
  color: #D1D5DB;
  margin: 0;
}

.woo-review-form-wrapper {
  background: linear-gradient(145deg, rgba(31, 41, 55, 0.8) 0%, rgba(17, 24, 39, 0.8) 100%);
  border: 2px solid rgba(75, 85, 99, 0.3);
  border-radius: 20px;
  padding: 2.5rem;
}

.woo-review-form-title {
  font-family: 'Outfit', sans-serif;
  font-size: 1.75rem;
  font-weight: 700;
  color: #FFFFFF;
  margin-bottom: 1.5rem;
}

.woo-review-form label {
  font-family: 'Inter', sans-serif;
  font-size: 1rem;
  font-weight: 600;
  color: #E5E7EB;
  display: block;
  margin-bottom: 0.5rem;
}

.woo-review-form input[type="text"],
.woo-review-form input[type="email"],
.woo-review-form textarea,
.woo-review-form select {
  width: 100%;
  background: rgba(17, 24, 39, 0.8);
  border: 2px solid rgba(75, 85, 99, 0.3);
  border-radius: 12px;
  padding: 0.875rem 1rem;
  font-size: 1rem;
  color: #FFFFFF;
  font-family: 'Inter', sans-serif;
  transition: all 0.3s ease;
  margin-bottom: 1.25rem;
}

.woo-review-form input[type="text"]:focus,
.woo-review-form input[type="email"]:focus,
.woo-review-form textarea:focus,
.woo-review-form select:focus {
  outline: none;
  border-color: rgba(124, 58, 237, 0.5);
  box-shadow: 0 4px 12px rgba(124, 58, 237, 0.2);
}

.woo-review-form textarea {
  min-height: 150px;
  resize: vertical;
}

.woo-review-form input[type="submit"],
.woo-review-form button[type="submit"] {
  background: linear-gradient(135deg, #7C3AED 0%, #3B82F6 100%);
  color: #FFFFFF;
  border: none;
  padding: 1rem 2.5rem;
  border-radius: 12px;
  font-weight: 700;
  font-size: 1.05rem;
  cursor: pointer;
  transition: all 0.3s ease;
  font-family: 'Inter', sans-serif;
  box-shadow: 0 4px 12px rgba(124, 58, 237, 0.3);
}

.woo-review-form input[type="submit"]:hover,
.woo-review-form button[type="submit"]:hover {
  transform: translateY(-2px);
  box-shadow: 0 8px 20px rgba(124, 58, 237, 0.4);
  filter: brightness(1.1);
}

.woo-review-form .required {
  color: #F87171;
}

.woocommerce-pagination {
  display: flex;
  justify-content: center;
  gap: 0.5rem;
  margin: 2rem 0;
  font-family: 'Inter', sans-serif;
}

.woocommerce-pagination ul {
  display: flex;
  gap: 0.5rem;
  list-style: none;
  padding: 0;
  margin: 0;
}

.woocommerce-pagination li {
  display: inline-block;
}

.woocommerce-pagination a,
.woocommerce-pagination span {
  display: inline-block;
  padding: 0.75rem 1.25rem;
  background: rgba(31, 41, 55, 0.8);
  border: 2px solid rgba(75, 85, 99, 0.3);
  border-radius: 12px;
  color: #FFFFFF;
  text-decoration: none;
  transition: all 0.3s ease;
  font-weight: 600;
}

.woocommerce-pagination a:hover {
  border-color: rgba(124, 58, 237, 0.5);
  background: rgba(124, 58, 237, 0.2);
}

.woocommerce-pagination .current {
  background: linear-gradient(135deg, #7C3AED 0%, #3B82F6 100%);
  border-color: transparent;
}

@media (max-width: 768px) {
  .woo-review-form-wrapper {
    padding: 1.5rem;
  }
  
  .woo-review-item {
    padding: 1.5rem;
  }
}
</style>

<div id="reviews" class="woo-reviews-section woocommerce-Reviews">
  <div class="woo-reviews-container">
    <div id="comments">
      <h2 class="woo-reviews-title">
        <?php
        $count = $product->get_review_count();
        if ( $count && wc_review_ratings_enabled() ) {
          /* translators: 1: reviews count 2: product name */
          echo '<span class="gradient-text">' . sprintf( esc_html( _n( '%1$s avaliação', '%1$s avaliações', $count, 'woocommerce' ) ), esc_html( $count ) ) . '</span> para ' . get_the_title();
        } else {
          echo '<span class="gradient-text">Avaliações</span>';
        }
        ?>
      </h2>

      <?php if ( have_comments() ) : ?>
        <ol class="woo-reviews-list commentlist">
          <?php wp_list_comments( apply_filters( 'woocommerce_product_review_list_args', array( 'callback' => 'woocommerce_comments' ) ) ); ?>
        </ol>

        <?php
        if ( get_comment_pages_count() > 1 && get_option( 'page_comments' ) ) :
          echo '<nav class="woocommerce-pagination">';
          paginate_comments_links(
            apply_filters(
              'woocommerce_comment_pagination_args',
              array(
                'prev_text' => '← Anterior',
                'next_text' => 'Próxima →',
                'type'      => 'list',
              )
            )
          );
          echo '</nav>';
        endif;
        ?>
      <?php else : ?>
        <div class="woo-no-reviews">
          <p><?php esc_html_e( 'Ainda não há avaliações. Seja o primeiro a avaliar!', 'woocommerce' ); ?></p>
        </div>
      <?php endif; ?>
    </div>

    <?php if ( get_option( 'woocommerce_review_rating_verification_required' ) === 'no' || wc_customer_bought_product( '', get_current_user_id(), $product->get_id() ) ) : ?>
      <div id="review_form_wrapper" class="woo-review-form-wrapper">
        <div id="review_form">
          <?php
          $commenter    = wp_get_current_commenter();
          $comment_form = array(
            'title_reply'         => have_comments() ? '<span class="woo-review-form-title">Adicionar uma avaliação</span>' : sprintf( '<span class="woo-review-form-title">Seja o primeiro a avaliar &ldquo;%s&rdquo;</span>', get_the_title() ),
            'title_reply_to'      => esc_html__( 'Responder para %s', 'woocommerce' ),
            'title_reply_before'  => '<div class="comment-reply-title">',
            'title_reply_after'   => '</div>',
            'comment_notes_after' => '',
            'label_submit'        => esc_html__( 'Enviar Avaliação', 'woocommerce' ),
            'logged_in_as'        => '',
            'comment_field'       => '',
            'class_form'          => 'woo-review-form',
          );

          $name_email_required = (bool) get_option( 'require_name_email', 1 );
          $fields              = array(
            'author' => array(
              'label'    => __( 'Nome', 'woocommerce' ),
              'type'     => 'text',
              'value'    => $commenter['comment_author'],
              'required' => $name_email_required,
            ),
            'email'  => array(
              'label'    => __( 'Email', 'woocommerce' ),
              'type'     => 'email',
              'value'    => $commenter['comment_author_email'],
              'required' => $name_email_required,
            ),
          );

          $comment_form['fields'] = array();

          foreach ( $fields as $key => $field ) {
            $field_html  = '<p class="comment-form-' . esc_attr( $key ) . '">';
            $field_html .= '<label for="' . esc_attr( $key ) . '">' . esc_html( $field['label'] );

            if ( $field['required'] ) {
              $field_html .= '&nbsp;<span class="required">*</span>';
            }

            $field_html .= '</label><input id="' . esc_attr( $key ) . '" name="' . esc_attr( $key ) . '" type="' . esc_attr( $field['type'] ) . '" value="' . esc_attr( $field['value'] ) . '" size="30" ' . ( $field['required'] ? 'required' : '' ) . ' /></p>';

            $comment_form['fields'][ $key ] = $field_html;
          }

          $account_page_url = wc_get_page_permalink( 'myaccount' );
          if ( $account_page_url ) {
            $comment_form['must_log_in'] = '<p class="must-log-in" style="color: #D1D5DB; font-family: Inter, sans-serif;">' . sprintf( esc_html__( 'Você precisa estar %1$slogado%2$s para avaliar.', 'woocommerce' ), '<a href="' . esc_url( $account_page_url ) . '" style="color: #A78BFA;">', '</a>' ) . '</p>';
          }

          if ( wc_review_ratings_enabled() ) {
            $comment_form['comment_field'] = '<div class="comment-form-rating"><label for="rating">' . esc_html__( 'Sua avaliação', 'woocommerce' ) . ( wc_review_ratings_required() ? '&nbsp;<span class="required">*</span>' : '' ) . '</label><select name="rating" id="rating" required>
              <option value="">' . esc_html__( 'Avalie...', 'woocommerce' ) . '</option>
              <option value="5">' . esc_html__( 'Perfeito ⭐⭐⭐⭐⭐', 'woocommerce' ) . '</option>
              <option value="4">' . esc_html__( 'Muito bom ⭐⭐⭐⭐', 'woocommerce' ) . '</option>
              <option value="3">' . esc_html__( 'Bom ⭐⭐⭐', 'woocommerce' ) . '</option>
              <option value="2">' . esc_html__( 'Regular ⭐⭐', 'woocommerce' ) . '</option>
              <option value="1">' . esc_html__( 'Ruim ⭐', 'woocommerce' ) . '</option>
            </select></div>';
          }

          $comment_form['comment_field'] .= '<p class="comment-form-comment"><label for="comment">' . esc_html__( 'Sua avaliação', 'woocommerce' ) . '&nbsp;<span class="required">*</span></label><textarea id="comment" name="comment" cols="45" rows="8" required placeholder="Conte sua experiência com este produto..."></textarea></p>';

          comment_form( apply_filters( 'woocommerce_product_review_comment_form_args', $comment_form ) );
          ?>
        </div>
      </div>
    <?php else : ?>
      <p class="woocommerce-verification-required" style="text-align: center; color: #D1D5DB; font-family: Inter, sans-serif; font-size: 1.05rem; padding: 2rem; background: rgba(31, 41, 55, 0.8); border-radius: 16px; border: 2px solid rgba(75, 85, 99, 0.3);">
        <?php esc_html_e( 'Apenas clientes que compraram este produto podem deixar uma avaliação.', 'woocommerce' ); ?>
      </p>
    <?php endif; ?>

    <div class="clear"></div>
  </div>
</div>
