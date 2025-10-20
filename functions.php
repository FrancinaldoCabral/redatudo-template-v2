<?php
/**
 * Theme functions and definitions.
 */

if ( is_readable( __DIR__ . '/vendor/autoload.php' ) ) {
    require __DIR__ . '/vendor/autoload.php';
}
use Firebase\JWT\JWT;
require('setup.php');
//require('rd-coupon.php');
//require('util-switch.php');
function nuvemTagsShortcode(){
    $tags = get_tags();
    $html = '<div class="post_tags">';
    foreach ( $tags as $tag ) {
        $tag_link = get_tag_link( $tag->term_id );
                
        $html .= "<a href='{$tag_link}' title='{$tag->name} Tag' class='{$tag->slug}'>";
        $html .= "{$tag->name}</a>";
    }
    $html .= '</div>';
    echo $html;
}



function woo_rd_template($attr, $content=null){
    return woocommerce_content();
}


add_shortcode( 'ga4_sign_up_event', function(){
    $html = '<script>';
    $html .= 'gtag("event", "sign_up", { method: "Site" });';
    $html .= '</script>';
    echo $html;
} );

add_shortcode( 'countdown', function($attrs, $content = null){
    $html = '<script>';
    $html .= 'var countDownDate = new Date("Ago 30, 2022 00:00:00").getTime();';
    $html .= 'var x = setInterval(function() {';
    $html .= 'var now = new Date().getTime();';
    $html .= 'var distance = countDownDate - now;';
    $html .= 'var days = Math.floor(distance / (1000 * 60 * 60 * 24));';
    $html .= 'var hours = Math.floor((distance % (1000 * 60 * 60 * 24)) / (1000 * 60 * 60));';
    $html .= 'var minutes = Math.floor((distance % (1000 * 60 * 60)) / (1000 * 60));';
    $html .= 'var seconds = Math.floor((distance % (1000 * 60)) / 1000);';
    $html .= 'document.getElementById("countdown").innerHTML = "Preços expiram em " + days + " dias " + hours + ":" + minutes + ":" + seconds + "";';
    $html .= 'if (distance < 0) {';
    $html .= 'clearInterval(x);';
    $html .= 'document.getElementById("countdown").innerHTML = "Preço expirado.";';
    $html .= '}';
    $html .= '}, 1000);';
    $html .= '</script>';
    $html .= '<p><span id="countdown" class="badge bg-danger"></span></p>';
    return $html;
} );

/* function my_custom_action() { 
    echo '<p>This is my custom action function</p>';
};     
add_action( 'woocommerce_single_product_summary', 'my_custom_action', 15 ); 
function my_custom_title() { 
    echo '<p>This is my custom action function</p>';
};     
add_action( 'woocommerce_template_single_title', 'my_custom_title', 5 );  */

function starGeneraton($set_star){
  $star .= '';
  for ($i=0; $i < 5; $i++) { 
    if($i<$set_star){
        $star .='<i class="fa fa-star u-color"></i>';
    }else{
        $star .='<i class="fa fa-star-o u-color"></i>';
    }
  }
  return $star;
}

function cmp($a, $b)
{   
    $ratingA = intval( get_comment_meta( $a->comment_ID, 'rating', true ) );
    $ratingB = intval( get_comment_meta( $b->comment_ID, 'rating', true ) );
    if ($ratingA == $ratingB) {
    return 0;
    }
    return ($ratingA > $ratingB) ? -1 : 1;
}

function filterCommentsByLenght($comment){
 return strlen($comment->comment_content)>0;
}

function remove_duplicate_models( $comments ) {
    $models = array_map( function( $comment ) {
        return $comment->comment_content;
    }, $comments );

    $unique_models = array_unique( $models );

    return array_values( array_intersect_key( $comments, $unique_models ) );
}

function rd_reviews_products( $atts ) {
    // --- Ajuste dos parâmetros e segurança ---
    if ( empty( $atts ) || ! isset( $atts['id'] ) ) return '';

    $comments = get_comments( 'post_id=' . $atts['id'] );
    $count_comments = count($comments);
    if ( ! $comments ) return '';

    // Ordenações e filtros customizados, mantenha suas funções!
    usort($comments, 'cmp');
    $array_unique = remove_duplicate_models($comments);
    $comments_filtered = array_filter($array_unique, 'filterCommentsByLenght');

    // --- Estatísticas principais para badge média ---
    $somaRating = 0;
    foreach ( $comments as $comment ){
        $rating = intval( get_comment_meta( $comment->comment_ID, 'rating', true ) );
        $somaRating += $rating;
    }
    $average = $count_comments ? ($somaRating / $count_comments) : 0;

    // --- Início do HTML ---
    $html = '';
    $html .= '
    <style>
    .avaliacao-hero-titulo {
      font-family: "Orbitron", Arial, sans-serif;
      font-weight: bold;
      font-size: 2rem;
      margin-bottom: .4em;
      letter-spacing:1.2px;
      background: linear-gradient(90deg,#00ffd0,#7f00ff 80%);
      -webkit-background-clip:text;
      -webkit-text-fill-color:transparent;
      text-transform: uppercase;
    }
    .avaliacao-hero-desc {
      color: #b8e6ff;
      font-size: 1.06em;
      font-family: Orbitron,sans-serif;
      margin-bottom: 2.1em;
    }
    .badge.review-badge-glow {
      background: linear-gradient(90deg,#00bfff,#7f00ff);
      color:#fff;
      font-family:\'Orbitron\',sans-serif;
      font-size:1.09em;
      font-weight:700;
      border-radius:18px;
      padding:.51em 1.8em;
      box-shadow:0 6px 23px #00ffd0cc;
      text-transform:uppercase;
      letter-spacing:1.2px;
      display:inline-flex;
      align-items:center;
      gap:6px;
      animation: pulseGlow 4s infinite alternate;
    }
    @keyframes pulseGlow {
      0% { box-shadow:0 6px 38px #00ffd040,0 1px 2px #7f00ff13;}
      100% { box-shadow:0 10px 64px #00ffd07c,0 1px 18px #7f00ff11;}
    }
    .reviews-row-grid {
      display: grid;
      grid-template-columns: repeat(auto-fit, minmax(290px,1fr));
      gap: 2rem;
      margin-top: 1em;
      margin-bottom: 1em;
    }
    .avaliacao-card-glow {
      background: rgba(23,23,39,0.98);
      border-radius: 22px;
      box-shadow: 0 6px 38px #00ffd049;
      border: 1.5px solid #00bfff30;
      transition: transform .18s, box-shadow .16s;
      min-height:210px;
      display: flex;
      flex-direction: column;
      justify-content: flex-start;
    }
    .avaliacao-card-glow:hover {
      transform: translateY(-8px) scale(1.03);
      box-shadow: 0 16px 44px 0 #00ffd08f, 0 1px 2px #7f00ff23;
    }
    .avaliacao-avatar-hero {
      width:48px;height:48px;
      border-radius:50%;
      background:linear-gradient(135deg,#7f00ff 60%,#00bfff 100%);
      display:inline-flex;align-items:center;justify-content:center;
      color:#fff;font-size:1.27em;font-weight:bold;
      box-shadow:0 2px 8px #00ffd052;border:2px solid #191940;
      margin-right:10px;
      transition: box-shadow .18s;
    }
    .avaliacao-card-glow .fa-quote-left {
      font-size: 1.2rem;
      color: #00ffd0;
      margin-right: 7px;
      opacity: 0.87;
    }
    .avaliacao-autor-label {
      font-family:\'Orbitron\',Arial,sans-serif;
      font-size:1.06em;
      color:#00ffd0;
      font-weight:700;
      margin-bottom:0;
      display:block;
      line-height:1.2;
    }
    .avaliacao-txt {
      color: #e8f5ff;
      font-size: 1.11rem;
      line-height:1.5;
      flex:1;
      margin-bottom:10px;
    }
    .avaliacao-stars {
      color: #00ffd0;
      font-size: 1.04em;
    }
    @media (max-width: 768px) {
      .reviews-row-grid { grid-template-columns: 1fr; gap: 1.15rem;}
      .avaliacao-hero-titulo { font-size:1.19rem;}
    }
    </style>
    ';

    // Hero/copy inicial (coloque só na página principal de avaliações)
    if(empty($atts['nohero'])) {
    $html .= '
    <div class="col-12 text-center pb-2">
      <div style="font-size:2.1em;">✨</div>
      <div class="avaliacao-hero-titulo">Histórias que Inspiram</div>
      <p class="avaliacao-hero-desc mx-auto" style="max-width:540px;">
        Veja como <strong style="color:#00ffd0;">Redatudo</strong> está mudando o jogo para criadores, professores, agências e empreendedores.<br>
        <span style="color:#bbeff2;">Experimente uma nova era de produtividade com a força da IA e surpreenda-se com os resultados reais.</span>
      </p>
    </div>';
    }

    // Badge de avaliação média
    $html .= '
    <div class="col-12 mb-4 text-center">
      Nota média <b>'.round($average,2).'</b>
      <span style="font-weight:500;margin-left:1em;">('.$count_comments.' avaliações)</span> <br>
      <span class="badge review-badge-glow">
        '.starGeneraton(round($average)).'
      </span>
    </div>
    ';

    // Lista de avaliações com visual high-end
    $limit_comment = 0;
    $html .= '<div class="reviews-row-grid">';
    foreach ( $comments_filtered as $comment ) {
        $rating = intval( get_comment_meta( $comment->comment_ID, 'rating', true ) );
        $user_initial = strtoupper(mb_substr(get_comment_author($comment),0,1,"UTF-8"));
        $html .= '
        <div class="avaliacao-card-glow p-4 d-flex flex-column">
          <div class="d-flex align-items-center mb-3">
            <div class="avaliacao-avatar-hero">'.$user_initial.'</div>
            <div>
                <span class="avaliacao-autor-label">'.get_comment_author($comment).'</span>
                <span class="avaliacao-stars">'.starGeneraton($rating).'</span>
            </div>
          </div>
          <div class="avaliacao-txt">
            <i class="fa fa-quote-left"></i>
            '.esc_html($comment->comment_content).'
          </div>
        </div>
        ';
        $limit_comment += 1;
        if( !is_null($atts['limit']) && $limit_comment==$atts['limit']){
            break;
        }
    }
    $html .= '</div>';

    if(!is_null($atts['limit']))
        $html .='<div class="col-12 mt-3 mb-2 text-center"><a href="https://redatudo.online/avaliacoes" style="color:#00bfff;font-family:\'Orbitron\';font-weight:bold;">Veja todas as avaliações &raquo;</a></div>';

    return $html;
}

function post_recente( $atts, $content = null ) 
{
    $html = '<h6 class="mt-4">Postagens recentes:</h6>';
    $recent = get_posts(array(
        'orderby'        => 'date',
		'order'          => 'DESC',
		'posts_per_page' => 3,
		'offset'         => 1
	)); 
    
    if( !$recent )
        return 'Não há posts recentes';
        
    foreach( $recent as $post )
    {
        $html .= sprintf(
            '<p><a href="%s">%s</a></p>',
            get_permalink( $post->ID ),
            $post->post_title
            );
    }
    
    
    return $html;
}

/* function has_woocommerce_subscription($the_user_id, $the_product_id, $the_status) {
	$current_user = wp_get_current_user();
	if (empty($the_user_id)) {
		$the_user_id = $current_user->ID;
	}
	if (WC_Subscriptions_Manager::user_has_subscription( $the_user_id, $the_product_id, $the_status)) {
		return true;
	}
} */

function rd_categories($atts, $content = null){
    $html = '<h6 class="mt-4">Categorias:</h6>';
    $categories = get_categories( array(
        'orderby' => 'name',
        'order'   => 'ASC'
    ) );
    
    if( !$categories )
        return 'Não há categorias';
        
    foreach( $categories as $category )
    {
        $category_link = sprintf( 
            '<a href="%1$s" alt="%2$s">%3$s</a>',
            esc_url( get_category_link( $category->term_id ) ),
            esc_attr( sprintf( __( 'View all posts in %s', 'textdomain' ), $category->name ) ),
            esc_html( $category->name )
        );
        
        $html .= '<p>' . sprintf( esc_html__( '%s', 'textdomain' ), $category_link ) . '</p>';
    }
    return $html;
}


function wc_form_field_args($args, $key, $value) {
  if(preg_match('/billing_address_1/', $key ) || preg_match('/password/', $key ) 
  || preg_match('/billing_persontype/', $key ) || preg_match('/billing_cpf/', $key )){
    $args['class'] = array( 'form-group ml-4' );
    $args['input_class'] = array( 'form-control form-control-lg' );  
  }else {
    $args['class'] = array( 'form-group ml-4 col-lg-6' );
    $args['input_class'] = array( 'form-control form-control-lg' ); 
  }
  return $args;
}


function modelByTitle($slug){
    try {
        $hg = file_get_contents("https://hidden-crag-82241.herokuapp.com/api/public-models?offset=0&limit=1000");
        $json = json_decode($hg);
        $results = $json->results;
        $model = array_filter($results, function ($it) { return strcmp($it->slug, $slug)==0; }); 

        return $model[0];
        //return $results;
    }catch (\Exception $error){
        return $error;
    }
}

add_shortcode( 'use-case-2', function($attrs){
    $slug = $attrs['slug'];
    $model = modelByTitle($slug);
	//var_dump($model);
    get_template_part('use-case', '', array( 
     'data'  => $model
     ) );
} );

function page_title_sc( ){
    return get_the_title();
}
add_shortcode( 'page_title', 'page_title_sc' );
add_shortcode('banner', function($attr){
    require('banner.php');
});

//Início do código ----------------------------------------------------------

//Adicionando campos no registro do usuário

function wooc_extra_register_fields() {?>
    <div class="form-group row">
        <p class="form-group col-6">
            <label for="reg_billing_first_name"><?php _e( 'First name', 'woocommerce' ); ?>*</label>
            <input placeholder="Digite seu nome" type="text" class="form-control form-control-sm" name="billing_first_name" id="reg_billing_first_name" value="<?php if ( ! empty( $_POST['billing_first_name'] ) ) esc_attr_e( $_POST['billing_first_name'] ); ?>" />
        </p>
        <p class="form-group col-6">
            <label for="reg_billing_last_name"><?php _e( 'Last name', 'woocommerce' ); ?>*</label>
            <input placeholder="Digite seu sobrenome" type="text" class="form-control form-control-sm" name="billing_last_name" id="reg_billing_last_name" value="<?php if ( ! empty( $_POST['billing_last_name'] ) ) esc_attr_e( $_POST['billing_last_name'] ); ?>" />
        </p>
    </div>
    <p class="form-group">
        <label for="reg_billing_phone"><?php _e( 'Phone', 'woocommerce' ); ?>*</label>
        <input type="text" class="form-control form-control-sm phone" name="billing_phone" id="reg_billing_phone" value="<?php esc_attr_e( $_POST['billing_phone'] ); ?>" />
    </p>
    <div class="clear"></div>
    
    <?php
}
add_action( 'woocommerce_register_form_start', 'wooc_extra_register_fields' );
//Validando os campos obrigatórios preenchidos
function wooc_validate_extra_register_fields( $username, $email, $validation_errors ) {
   if ( isset( $_POST['billing_first_name'] ) && empty( $_POST['billing_first_name'] ) ) {
          $validation_errors->add( 'billing_first_name_error', __( 'O campo <strong>Nome</strong> é obrigatório!', 'woocommerce' ) );
   }
   if ( isset( $_POST['billing_last_name'] ) && empty( $_POST['billing_last_name'] ) ) {
          $validation_errors->add( 'billing_last_name_error', __( 'O campo <strong>Sobrenome</strong> é obrigatório!', 'woocommerce' ) );
   }
  if ( isset( $_POST['billing_phone'] ) && empty( $_POST['billing_phone'] ) ) {
          $validation_errors->add( 'billing_phone_error', __( 'O campo <strong>Telefone</strong> é obrigatório!', 'woocommerce' ) );
   }
      return $validation_errors;
}
add_action( 'woocommerce_register_post', 'wooc_validate_extra_register_fields', 10, 3 );
//Salvando os campos
function wooc_save_extra_register_fields( $customer_id ) {
   if ( isset( $_POST['billing_first_name'] ) ) {
          //Primeiro nome - campo padrão
          update_user_meta( $customer_id, 'first_name', sanitize_text_field( $_POST['billing_first_name'] ) );
          // Primeiro nome - campo do WooCommerce
          update_user_meta( $customer_id, 'billing_first_name', sanitize_text_field( $_POST['billing_first_name'] ) );
   }
   if ( isset( $_POST['billing_last_name'] ) ) {
          //Último nome - campo padrão
          update_user_meta( $customer_id, 'last_name', sanitize_text_field( $_POST['billing_last_name'] ) );
          //Último nome - campo do WooCommerce
          update_user_meta( $customer_id, 'billing_last_name', sanitize_text_field( $_POST['billing_last_name'] ) );
   }
  if ( isset( $_POST['billing_phone'] ) ) {
              //Telefone - campo do WooCommerce
              update_user_meta( $customer_id, 'billing_phone', sanitize_text_field( $_POST['billing_phone'] ) );
   }
}
add_action( 'woocommerce_created_customer', 'wooc_save_extra_register_fields' );
add_action(
    'wp_logout',
    function() {

        wp_redirect( 'https://chat.redatudo.online?logout=1' );
        exit;
    }
);
function so_266_your_function($user_login, $user) {
    wp_redirect( 'https://redatudo.online/minha-conta?login_app=chat');
}
add_action('wp_login', 'so_266_your_function', 10, 2);

// Adicione este código ao seu tema functions.php ou plugin personalizado

function redatudo_posts_recentes_shortcode($atts) {
    $atts = shortcode_atts(
        array(
            'quantidade' => 4,
            'categoria'  => '', // slug ou vazio para todas
        ), $atts, 'redatudo_artigos_recentes'
    );

    $args = array(
        'post_type'      => 'post',
        'posts_per_page' => intval($atts['quantidade']),
        'post_status'    => 'publish',
    );
    if (!empty($atts['categoria'])) {
        $args['category_name'] = $atts['categoria'];
    }
    $query = new WP_Query($args);

    ob_start();
    if ($query->have_posts()) : ?>
        <div class="redatudo-recentes-grid">
        <?php
        $count = 0;
        while ($query->have_posts()) : $query->the_post();
            $count++;
            // Destaque para o 1º post (caixa maior)
            $is_featured = $count === 1;
            ?>
            <article class="redatudo-artigo-card <?php if($is_featured){echo 'redatudo-destaque';} ?>">
                <?php if ($is_featured): ?>
                    <span class="redatudo-artigo-badge">Destaque</span>
                <?php endif; ?>
                <?php if (has_post_thumbnail()): ?>
                    <a href="<?php the_permalink(); ?>">
                        <img class="redatudo-artigo-img" src="<?php the_post_thumbnail_url($is_featured ? 'medium_large' : 'medium'); ?>" alt="<?php the_title_attribute(); ?>">
                    </a>
                <?php else: ?>
                    <a href="<?php the_permalink(); ?>">
                        <div class="redatudo-artigo-img redatudo-img-placeholder"></div>
                    </a>
                <?php endif; ?>
                <a href="<?php the_permalink(); ?>">
                    <h3 class="redatudo-artigo-title"><?php the_title(); ?></h3>
                </a>
                <p class="redatudo-artigo-exc">
                    <?php
                        $exc = get_the_excerpt();
                        echo wp_trim_words($exc, $is_featured ? 28 : 14, '...');
                    ?>
                </p>
                <a class="redatudo-artigo-lermais" href="<?php the_permalink(); ?>">
                    Ler mais &rarr;
                </a>
            </article>
        <?php endwhile; ?>
        </div>
    <?php
    wp_reset_postdata();
    else:
        echo '<p style="color:#b8e6ff">Sem artigos recentes no momento.</p>';
    endif;
    return ob_get_clean();
}
add_shortcode('redatudo_artigos_recentes', 'redatudo_posts_recentes_shortcode');


// CSS inline para facilitar (ajuste ou coloque no seu customizer/arquivo)
add_action('wp_head', function(){
    ?>
    <style>
    .redatudo-recentes-grid {
        display: grid;
        grid-template-columns: 1fr 1fr;
        gap: 2rem;
        margin-bottom: 2.3em;
    }
    @media(max-width:800px){
        .redatudo-recentes-grid { grid-template-columns: 1fr;}
    }
    .redatudo-artigo-card {
        background: rgba(23,20,56,0.98);
        border-radius: 22px;
        box-shadow: 0 2px 32px #7f00ff16;
        overflow: visible;
        position: relative;
        padding: 1.4rem 1.2rem 1.2rem 1.2rem;
        border:1.8px solid rgba(0,191,255,0.11);
        display: flex;
        flex-direction: column;
        align-items: flex-start;
        transition: box-shadow .20s,transform .19s;
    }
    .redatudo-artigo-card:hover {
        box-shadow: 0 10px 38px #7f00ff55,0 1px 2px #00ffd0cc;
        transform: translateY(-5px) scale(1.028);
    }
    .redatudo-artigo-img {
        display: block;
        width: 100%;
        max-height: 180px;
        min-height: 110px;
        border-radius: 14px;
        object-fit: cover;
        box-shadow: 0 2px 16px #00bfff44;
        margin-bottom: 1em;
        background: linear-gradient(90deg,#221841 60%,#00bfff10 100%);
        transition: box-shadow .13s;
    }
    .redatudo-img-placeholder {
        background: linear-gradient(90deg,#7f00ff 40%,#00bfff 100%);
        height: 110px;
        box-shadow: 0 2px 8px #00ffd040;
    }
    .redatudo-artigo-title {
        font-family: 'Orbitron', Arial, sans-serif;
        font-weight: bold;
        font-size: 1.18rem;
        margin-bottom: .6em;
        color: #fff;
        letter-spacing: .3px;
    }
    .redatudo-artigo-exc {
        color: #b8e6ff;
        font-size: 1.01em;
        min-height:36px;
        margin-bottom: .8em;
    }
    .redatudo-artigo-lermais {
        font-family: 'Orbitron', Arial, sans-serif;
        background: linear-gradient(90deg,#7f00ff 50%,#00bfff 100%);
        color: #fff;
        padding: 0.41em 1.16em;
        border-radius: 15px;
        font-size: 0.93em;
        font-weight: 600;
        letter-spacing: .9px;
        box-shadow:0 1px 8px #00bfff33;
        text-decoration: none !important;
        transition: transform .16s, box-shadow .17s;
        display: inline-block;
    }
    .redatudo-artigo-lermais:hover {
        background: linear-gradient(95deg,#00bfff 60%,#7f00ff 100%);
        box-shadow:0 3px 18px #00ffd044;
        transform: translateY(-1px) scale(1.04);
        color:#fff;
    }
    .redatudo-artigo-badge {
        position: absolute;
        top: -16px; left: 16px;
        background: linear-gradient(90deg,#00ffd0 55%,#00bfff 100%);
        color: #181733;
        font-family: 'Orbitron', Arial, sans-serif;
        font-size: .95rem;
        font-weight: bold;
        border-radius: 16px;
        padding: 0.24em 1em;
        letter-spacing: 1px;
        box-shadow: 0 2px 16px #00ffd085;
        z-index:100;
    }
    .redatudo-destaque {
        border:2.2px solid #00ffd0;
        background: linear-gradient(98deg, #221841 90%,#00ffd00f 100%);
        box-shadow:0 6px 24px #00ffd048,0 1px 2px #7f00ff10;
    }
    </style>
    <?php
});

function redatudo_blog_overflow( $atts ) {
    // Parâmetros aceitos
    $atts = shortcode_atts( array(
        'id'        => '',
        'category'  => '',
        'btntext'   => 'Leia no Blog',
        'btnurl'    => '',
    ), $atts );

    // Monta query: prioridade ao ID, senão pega último da categoria
    if( $atts['id'] ) {
        $query = new WP_Query( array( 'p' => intval($atts['id']) ) );
    } elseif( $atts['category'] ) {
        $query = new WP_Query( array(
            'posts_per_page' => 1,
            'category_name'  => sanitize_text_field($atts['category']),
            'post_status'    => 'publish'
        ));
    } else {
        $query = new WP_Query( array( 'posts_per_page' => 1, 'post_status' => 'publish' ));
    }

    if( !$query->have_posts() )
        return '';

    ob_start();

    while( $query->have_posts() ) : $query->the_post();
        $thumb = get_the_post_thumbnail_url(get_the_ID(), 'large');
        if(!$thumb) $thumb = 'https://redatudo-pt-storage-pull-zone.b-cdn.net/capa-blog-redatudo-default.png';

        $categories = get_the_category();
        $cat_name = $categories ? esc_html( $categories[0]->name ) : '';
        $cat_link = $categories ? get_category_link( $categories[0]->term_id ) : '';
        $excerpt = get_the_excerpt();
        if(strlen($excerpt) > 130) $excerpt = mb_substr($excerpt, 0, 127).'…';

        $post_url = get_permalink();
        $btn_text = esc_html($atts['btntext']);
        $btn_url  = $atts['btnurl'] ? esc_url($atts['btnurl']) : $post_url;
        ?>
        <style>
        .redatudo-blog-overflow {
            position: relative;
            width: 100%;
            height: 320px;
            border-radius: 24px;
            background: #141125;
            box-shadow: 0 6px 38px #00bfff33, 0 1px 2px #7f00ff18;
            margin-bottom: 2.2rem;
            overflow: hidden;
            transition: box-shadow .19s,transform .22s;
            min-height: 230px;
        }
        .redatudo-blog-overflow__bg {
            position: absolute;
            inset: 0;
            width: 100%; height: 100%;
            object-fit: cover;
            object-position: center;
            filter: brightness(0.74) blur(1.5px) saturate(1.4);
            z-index: 1;
            transition: filter .21s;
        }
        .redatudo-blog-overflow:hover .redatudo-blog-overflow__bg {
            filter: brightness(0.89) blur(0.5px) saturate(1.13);
        }
        .redatudo-blog-overflow__overlay {
            position: absolute;
            inset:0; z-index: 2;
            background: linear-gradient(0deg, #101022cc 66%, #10102330 99%, transparent 100%);
        }
        .redatudo-blog-overflow__content {
            position: absolute;
            left: 0; right: 0; bottom: 0;
            z-index: 3;
            padding: 2.1rem 1.7rem 1.3rem 2.1rem;
            color: #fff;
            max-width: 75vw;
        }
        .redatudo-blog-overflow .cat-badge {
            display: inline-block;
            font-family: 'Orbitron', Arial, sans-serif;
            font-size: 0.98rem;
            font-weight: 600;
            background: linear-gradient(87deg, #00ffd0 40%, #7f00ff 110%);
            color: #fff;
            border-radius: 14px;
            padding: 0.14em 0.7em;
            margin-bottom: 0.6em;
            letter-spacing: 1.1px;
            text-transform: uppercase;
            box-shadow: 0 2px 12px #00ffd050;
        }
        .redatudo-blog-overflow__title {
            font-family: 'Orbitron', Arial, sans-serif;
            font-size: 1.45rem;
            font-weight: 700;
            letter-spacing: 0.7px;
            margin-bottom: 0.66em;
            color: #fff;
            text-shadow: 0 6px 18px #101025ce;
            line-height: 1.18;
        }
        .redatudo-blog-overflow__desc {
            font-size: 1rem;
            color: #b8e6ff;
            max-width: 520px;
            margin-bottom: 1.1em;
            text-shadow: 0 2px 12px #0023a880;
        }
        .redatudo-blog-overflow__cta {
            background: linear-gradient(90deg, #7f00ff, #00bfff 90%);
            color: #fff!important;
            border-radius: 18px;
            border: none;
            padding: 0.53em 1.25em;
            font-size: 1.06rem;
            font-family: 'Orbitron', Arial, sans-serif;
            font-weight: 600;
            letter-spacing: 1.1px;
            box-shadow: 0 2px 12px #00bfff51;
            transition: background .19s, transform .15s, box-shadow .18s;
            display: inline-block;
            text-decoration: none !important;
        }
        .redatudo-blog-overflow__cta:hover {
            background: linear-gradient(95deg, #00bfff 80%, #7f00ff 100%);
            box-shadow: 0 6px 24px #00ffd099;
            transform: translateY(-2px) scale(1.04);
        }
        @media (max-width: 600px){
            .redatudo-blog-overflow {
                height: 210px !important;
                border-radius: 16px;
            }
            .redatudo-blog-overflow__content {
                padding: 1.3rem 0.6rem 0.9rem 1.05rem;
                font-size: 0.97rem;
                max-width: 97vw;
            }
            .redatudo-blog-overflow__title { font-size:1.01rem; }
            .redatudo-blog-overflow__desc { font-size:0.95rem;}
        }
        </style>
        <div class="redatudo-blog-overflow">
            <img class="redatudo-blog-overflow__bg" src="<?php echo esc_url($thumb); ?>" alt="<?php the_title_attribute(); ?>" />
            <span class="redatudo-blog-overflow__overlay"></span>
            <div class="redatudo-blog-overflow__content">
                <?php if($cat_name): ?>
                    <a href="<?php echo esc_url($cat_link); ?>" class="cat-badge"><?php echo $cat_name; ?></a>
                <?php endif; ?>
                <div class="redatudo-blog-overflow__title"><?php the_title(); ?></div>
                <div class="redatudo-blog-overflow__desc"><?php echo esc_html($excerpt); ?></div>
                <a href="<?php echo esc_url($btn_url); ?>" class="redatudo-blog-overflow__cta"><?php echo $btn_text; ?></a>
            </div>
        </div>
        <?php
    endwhile;
    wp_reset_postdata();

    return ob_get_clean();
}
add_shortcode('redatudo_overflow_blog', 'redatudo_blog_overflow');


function redatudo_sharelike_shortcode($atts) {
    ob_start();
    ?>
  
  <div class="redatudo-sharelike-wrapper" style="width:100%;display:flex;justify-content:center;">
  <div id="redatudo-share-like-widget-<?php echo uniqid(); ?>" style="width:100%;max-width:330px;">
    <style>
      .redatudo-sharelike-container {
        background: #171727;
        border-radius: 18px;
        box-shadow: 0 2px 17px #00bfff14;
        padding: 1em 0.7em 1em 0.7em;
        margin: 0.7em 0 1em 0;
        width:100%;
      }
      .redatudo-badge-custom {
        background: linear-gradient(90deg, #00bfff, #7f00ff 70%);
        color: #fff;
        text-transform: uppercase;
        font-family: 'Orbitron', Arial, sans-serif;
        letter-spacing: .9px;
        font-size: 0.98rem;
        font-weight: 700;
        border-radius: 11px;
        padding: 0.14em 0.7em;
        margin-bottom: .7em;
        box-shadow: 0 3px 9px #00ffd028;
        display: inline-block;
      }
      .redatudo-like-row {
        display: flex;
        align-items: center;
        gap: 0.6em;
        margin: .6em 0 0.4em 0.03em;
      }
      .redatudo-like-btn {
        background: linear-gradient(93deg, #00bfff 58%, #7f00ff 110%);
        color: #fff;
        font-family: 'Orbitron',Arial,sans-serif;
        font-weight: 600;
        border-radius: 13px;
        min-width: 36px;
        min-height: 28px;
        font-size: 0.97rem;
        padding: 0.27em 0.85em;
        display: flex;
        align-items: center;
        border: none;
        cursor: pointer;
        box-shadow: 0 1px 6px #00ffd032;
        transition: background .17s, color .12s, box-shadow .19s, transform .13s;
        text-shadow: 0 1px 3px #10102270;
        outline: none;
        position: relative;
      }
      .redatudo-like-btn.liked {
        background: linear-gradient(88deg, #7f00ff 42%, #00ffd0 100%);
        color: #00ffd0 !important;
        box-shadow: 0 2px 11px #00ffd063 !important;
      }
      .redatudo-like-btn:hover {
        background: linear-gradient(90deg, #7f00ff 20%, #00ffd0 100%);
        color: #00ffd0;
        transform: translateY(-1px) scale(1.03);
        box-shadow: 0 2px 14px #00ffd052;
      }
      .redatudo-like-icon {
        font-size: 1.09em;
        margin-right: 0.32em;
        color: #00ffd0;
        filter: drop-shadow(0 2px 7px #00bfff8e);
        transition: color .15s;
      }
      .redatudo-like-count {
        color: #00ffd0;
        font-family: 'Orbitron', Arial, sans-serif;
        font-weight: 700;
        font-size: .97em;
        margin-left: 0.19em;
        text-shadow: 0 2px 7px #00bfff20;
        line-height: 1.0;
      }
      .redatudo-like-label {
        color:#b8e6ff;
        font-size:0.91em;
        font-family:'Orbitron',Arial,sans-serif;
      }
  
      .redatudo-share-row {
        display: flex;
        flex-wrap: wrap;
        gap: 0.33em;
        align-items: center;
        margin-top: 0.53em;
        justify-content: center;
      }
      .redatudo-share-btn {
        display: flex;
        align-items: center;
        justify-content: center;
        border-radius: 11px;
        padding: 0.2em 0.82em;
        font-family: 'Orbitron', Arial, sans-serif;
        font-weight: 700;
        font-size: 0.92rem;
        color: #fff;
        cursor: pointer;
        border: none;
        background: linear-gradient(92deg, #7f00ff 60%, #00bfff 100%);
        box-shadow: 0 1px 4px #00ffd01a;
        letter-spacing: 0.4px;
        text-decoration: none !important;
        transition: background .15s, color .11s, box-shadow .14s, transform .13s;
        min-width: 82px;
        min-height: 30px;
        margin-right: 0;
      }
      .redatudo-share-btn:hover {
        background: linear-gradient(99deg,#00ffd0 25%, #7f00ff 100%);
        color: #171727;
        box-shadow: 0 2px 8px #00ffd035;
        transform: translateY(-1px) scale(1.03);
      }
      .redatudo-share-btn .redatudo-share-ico {
        font-size: 1.08em;
        margin-right: 0.28em;
        filter: drop-shadow(0 2px 6px #00bfff55);
      }
      .redatudo-share-btn.fb .redatudo-share-ico { color: #00bfff; }
      .redatudo-share-btn.tw .redatudo-share-ico { color: #1da1f2; }
      .redatudo-share-btn.wa .redatudo-share-ico { color: #1efeb7; }
      .redatudo-share-btn.in .redatudo-share-ico { color: #7f00ff; }
      .redatudo-share-btn.ig .redatudo-share-ico { color: #ea3a74; }
      .redatudo-share-btn.cp .redatudo-share-ico { color: #00ffd0; }
      @media (max-width:600px){
        .redatudo-sharelike-container{padding:0.6em 0.13em;}
        .redatudo-share-row{gap:0.16em;}
        .redatudo-share-btn{font-size:0.88rem;min-width:65px;padding:0.12em 0.41em;}
        .redatudo-like-btn{font-size:0.89rem;min-width:28px;min-height:22px;}
        .redatudo-badge-custom{font-size:0.89rem;padding:0.11em 0.44em;}
      }
    </style>
    
    <div class="redatudo-sharelike-container text-center">
  
      <div class="redatudo-badge-custom">Curtir & Compartilhar</div>
      
      <!-- Botão Curtir -->
      <div class="redatudo-like-row justify-content-center" style="justify-content:center;">
        <button class="redatudo-like-btn" id="redatudo-like-btn-<?php echo uniqid(); ?>" aria-label="Curtir">
          <span class="redatudo-like-icon">💜</span>
          Curtir
          <span class="redatudo-like-count" id="redatudo-like-count-<?php echo uniqid(); ?>">0</span>
        </button>
        <span class="redatudo-like-label"></span>
      </div>
      
      <!-- Botões Compartilhar -->
      <div class="redatudo-share-row justify-content-center" style="justify-content:center;">
        <a class="redatudo-share-btn fb" target="_blank" rel="noopener" href="#" id="share-facebook-<?php echo uniqid(); ?>">
          <span class="redatudo-share-ico">📘</span>
          FB
        </a>
        <a class="redatudo-share-btn tw" target="_blank" rel="noopener" href="#" id="share-twitter-<?php echo uniqid(); ?>">
          <span class="redatudo-share-ico">🐦</span>
          Tw
        </a>
        <a class="redatudo-share-btn wa" target="_blank" rel="noopener" href="#" id="share-whatsapp-<?php echo uniqid(); ?>">
          <span class="redatudo-share-ico">💬</span>
          Whats
        </a>
        <a class="redatudo-share-btn in" target="_blank" rel="noopener" href="#" id="share-linkedin-<?php echo uniqid(); ?>">
          <span class="redatudo-share-ico">💼</span>
          In
        </a>
        <button class="redatudo-share-btn cp" id="redatudo-share-copy-<?php echo uniqid(); ?>" aria-label="Copiar link">
          <span class="redatudo-share-ico">🔗</span>Copiar
        </button>
      </div>
    </div>
  
    <script>
        // Variação compacta UID
        (function(){
          var container = document.currentScript.previousElementSibling;
          var uids = [];
          container.querySelectorAll('[id^="redatudo-like-btn"],[id^="redatudo-like-count"],[id^="share-facebook"],[id^="share-twitter"],[id^="share-whatsapp"],[id^="share-linkedin"],[id^="redatudo-share-copy"]').forEach(function(el,i){
              var id = el.id.split('-').slice(-1)[0];
              uids.push(id);
          });
          var attUid = uids[0] || Math.floor(Math.random()*1000000);
          var likeBtn   = container.querySelector('[id^="redatudo-like-btn"]');
          var likeCount = container.querySelector('[id^="redatudo-like-count"]');
          var likeLabel = container.querySelector('.redatudo-like-label');
          var fbBtn     = container.querySelector('[id^="share-facebook"]');
          var twBtn     = container.querySelector('[id^="share-twitter"]');
          var waBtn     = container.querySelector('[id^="share-whatsapp"]');
          var inBtn     = container.querySelector('[id^="share-linkedin"]');
          var cpBtn     = container.querySelector('[id^="redatudo-share-copy"]');
  
          // LIKE LOCALSTORAGE
          var likeKey = 'redatudo_like_' + attUid + '_' + window.location.pathname;
          var countKey = likeKey + '_count';
          var initialCount = localStorage.getItem(countKey) ? parseInt(localStorage.getItem(countKey)) : 0;
          var liked = !!localStorage.getItem(likeKey);
          likeCount.textContent = initialCount;
          if(liked){
              likeBtn.classList.add('liked');
              likeLabel.innerText = 'Você já curtiu.';
          } else {
              likeLabel.innerText = '';
          }
          likeBtn.onclick = function(){
            if(liked) {
              if(initialCount>0) initialCount--;
              likeBtn.classList.remove('liked');
              localStorage.removeItem(likeKey);
              likeLabel.innerText = '';
            } else {
              initialCount++;
              likeBtn.classList.add('liked');
              localStorage.setItem(likeKey, 'y');
              likeLabel.innerText = 'Obrigado por curtir!';
            }
            likeCount.textContent = initialCount;
            liked = !liked;
            localStorage.setItem(countKey, initialCount);
            return false;
          };
  
          // COMPARTILHAR
          var pageUrl = encodeURIComponent(window.location.href);
          var pageTitle = encodeURIComponent(document.title);
          fbBtn.href = 'https://www.facebook.com/sharer/sharer.php?u='+pageUrl;
          twBtn.href = 'https://twitter.com/intent/tweet?url='+pageUrl+'&text='+pageTitle;
          waBtn.href = 'https://wa.me/?text='+pageTitle+'%20'+pageUrl;
          inBtn.href = 'https://www.linkedin.com/sharing/share-offsite/?url='+pageUrl;
          // Copiar link
          cpBtn.onclick = function(){
            navigator.clipboard.writeText(window.location.href)
            .then(()=>{
                cpBtn.innerHTML='<span class="redatudo-share-ico">✅</span>Copiado!';
                setTimeout(()=>cpBtn.innerHTML='<span class="redatudo-share-ico">🔗</span>Copiar', 1500);
            });
          };
        })();
    </script>
  </div>
  </div>
  
    <?php
    return ob_get_clean();
  }
  add_shortcode('redatudo_sharelike','redatudo_sharelike_shortcode');

// Customiza aparência dos campos Stripe Elements no WooCommerce para dark
add_filter( 'wc_stripe_elements_options', function( $elements_options ) {
    $elements_options['style'] = [
        'base' => [
            'color' => '#f2f6fa',
            'fontFamily' => 'Orbitron, Arial, sans-serif',
            'fontSmoothing' => 'antialiased',
            'fontSize' => '18px',
            '::placeholder' => [ 'color' => '#b8e6ff' ],
            'backgroundColor' => '#171727', // para plugins que suportam bg
        ],
        'invalid' => [
            'color' => '#ff007f',
        ]
    ];
    $elements_options['classes'] = [
        'base' => 'stripeRedatudoDark'
    ];
    return $elements_options;
} );

add_filter('woocommerce_product_single_add_to_cart_text', function($text) { 
  return 'Usar Agora';
});
add_filter('woocommerce_product_add_to_cart_text', function($text) { 
  return 'Adicionar ao Redatudo';
});

add_action('init', function() {
  if (
      isset($_POST['register']) &&
      isset($_POST['email']) &&
      wp_verify_nonce($_POST['woocommerce-register-nonce'], 'woocommerce-register')
  ) {
      $email    = sanitize_email($_POST['email']);
      $username = isset($_POST['username']) ? sanitize_user($_POST['username']) : '';
      $password = isset($_POST['password']) ? $_POST['password'] : '';

      // Auto-gera username se não existir campo
      if(empty($username)) {
          $username = strstr($email, '@', true);
      }

      if(email_exists($email)) {
          wc_add_notice( 'Este e-mail já está cadastrado.', 'error' );
          return;
      }

      if(username_exists($username)) {
          wc_add_notice( 'Este nome de usuário já existe.', 'error' );
          return;
      }

      $user_id = wc_create_new_customer($email, $username, $password);

      if (is_wp_error($user_id)) {
          wc_add_notice( $user_id->get_error_message(), 'error' );
          return;
      }

      // Loga o usuário automaticamente
      wp_set_current_user($user_id);
      wp_set_auth_cookie($user_id);

      // Captura o valor de login_app da query string
      $login_app = isset($_GET['login_app']) ? sanitize_text_field($_GET['login_app']) : 'chat';
      $redirect_url = 'https://redatudo.online/minha-conta?login_app=' . urlencode($login_app);

      wp_redirect($redirect_url);
      exit;
  }
});

/**
 * ========================================
 * REBRANDING 2.0 - ENQUEUE DE ASSETS
 * ========================================
 */

function redatudo_enqueue_rebranding_assets() {
    // CSS Variables do sistema de design
    wp_enqueue_style(
        'redatudo-variables',
        get_template_directory_uri() . '/assets/css/variables.css',
        array(),
        '2.0.0'
    );
    
    // Google Fonts - Outfit e Inter
    wp_enqueue_style(
        'redatudo-fonts',
        'https://fonts.googleapis.com/css2?family=Outfit:wght@600;700&family=Inter:wght@400;500;600&display=swap',
        array(),
        null
    );
    
    // Componentes de UI
    wp_enqueue_style(
        'redatudo-components',
        get_template_directory_uri() . '/assets/css/components.css',
        array('redatudo-variables'),
        '2.0.0'
    );
    
    // JavaScript para interações
    wp_enqueue_script(
        'redatudo-interactions',
        get_template_directory_uri() . '/assets/js/interactions.js',
        array('jquery'),
        '2.0.0',
        true
    );
    
    // Localizar script para AJAX se necessário
    wp_localize_script('redatudo-interactions', 'redatudoData', array(
        'ajaxUrl' => admin_url('admin-ajax.php'),
        'nonce' => wp_create_nonce('redatudo_nonce')
    ));
}
add_action('wp_enqueue_scripts', 'redatudo_enqueue_rebranding_assets', 20);

/**
 * ========================================
 * SHORTCODES DO REBRANDING 2.0
 * ========================================
 */

/**
 * Shortcode: Social Proof Toast
 * Uso: [social_proof]
 */
function redatudo_social_proof_shortcode($atts) {
    $atts = shortcode_atts(array(
        'interval' => '8000', // Intervalo entre mensagens em ms
    ), $atts);
    
    ob_start();
    ?>
    <div class="social-proof-toast" id="social-proof-container"></div>
    <script>
    (function() {
        const messages = [
            { user: "João M.", action: "gerou 12 títulos", time: "3s" },
            { user: "Maria S.", action: "humanizou 850 palavras", time: "12s" },
            { user: "Carlos P.", action: "criou descrição para loja", time: "28s" },
            { user: "Ana R.", action: "gerou 5 temas para TCC", time: "45s" },
            { user: "Pedro L.", action: "reformulou introdução", time: "1m" },
            { user: "Julia F.", action: "criou 3 posts para Instagram", time: "2m" },
            { user: "Roberto K.", action: "gerou 30 hashtags", time: "3m" },
            { user: "Camila B.", action: "criou nome para livro", time: "4m" }
        ];
        
        function showProof() {
            const toast = document.getElementById('social-proof-container');
            if (!toast) return;
            
            const msg = messages[Math.floor(Math.random() * messages.length)];
            const initials = msg.user.substring(0, 2).toUpperCase();
            
            toast.innerHTML = `
                <div class="avatar">${initials}</div>
                <div class="content">
                    <strong>${msg.user}</strong> ${msg.action}
                    <span class="time">há ${msg.time}</span>
                </div>
            `;
            
            toast.classList.add('show');
            setTimeout(() => toast.classList.remove('show'), 5000);
        }
        
        setInterval(showProof, <?php echo intval($atts['interval']); ?>);
        setTimeout(showProof, 2000); // Primeira aparição
    })();
    </script>
    <?php
    return ob_get_clean();
}
add_shortcode('social_proof', 'redatudo_social_proof_shortcode');

/**
 * Shortcode: Countdown Timer Renovável
 * Uso: [countdown_timer message="Promoção termina em:"]
 */
function redatudo_countdown_timer_shortcode($atts) {
    $atts = shortcode_atts(array(
        'message' => 'Promoção termina em:',
        'renew' => 'daily', // daily, weekly, monthly
    ), $atts);
    
    $unique_id = 'countdown-' . uniqid();
    
    ob_start();
    ?>
    <div class="countdown-timer" id="<?php echo esc_attr($unique_id); ?>">
        <span class="countdown-message"><?php echo esc_html($atts['message']); ?></span>
        <div class="countdown-display">
            <span><strong class="hours">23</strong>h</span>
            <span><strong class="minutes">59</strong>m</span>
            <span><strong class="seconds">59</strong>s</span>
        </div>
    </div>
    <script>
    (function() {
        const container = document.getElementById('<?php echo esc_js($unique_id); ?>');
        if (!container) return;
        
        function updateCountdown() {
            const now = new Date();
            const end = new Date();
            end.setHours(23, 59, 59, 999);
            
            const diff = end - now;
            if (diff < 0) return;
            
            const hours = Math.floor(diff / (1000 * 60 * 60));
            const minutes = Math.floor((diff % (1000 * 60 * 60)) / (1000 * 60));
            const seconds = Math.floor((diff % (1000 * 60)) / 1000);
            
            container.querySelector('.hours').textContent = hours;
            container.querySelector('.minutes').textContent = minutes;
            container.querySelector('.seconds').textContent = seconds;
        }
        
        updateCountdown();
        setInterval(updateCountdown, 1000);
    })();
    </script>
    <?php
    return ob_get_clean();
}
add_shortcode('countdown_timer', 'redatudo_countdown_timer_shortcode');

/**
 * Shortcode: Stats Display
 * Uso: [stats_display users="287.432" rating="4.9" active="12.4k"]
 */
function redatudo_stats_display_shortcode($atts) {
    $atts = shortcode_atts(array(
        'users' => '287.432',
        'rating' => '4.9',
        'active' => '12.4k',
    ), $atts);
    
    ob_start();
    ?>
    <div class="hero-stats">
        <div class="stat">
            <strong><?php echo esc_html($atts['users']); ?></strong>
            <span>conteúdos criados</span>
        </div>
        <div class="stat">
            <strong><?php echo esc_html($atts['rating']); ?>★</strong>
            <span>avaliação média</span>
        </div>
        <div class="stat">
            <strong><?php echo esc_html($atts['active']); ?></strong>
            <span>criadores ativos</span>
        </div>
    </div>
    <?php
    return ob_get_clean();
}
add_shortcode('stats_display', 'redatudo_stats_display_shortcode');

/**
 * Shortcode: Tool Card
 * Uso: [tool_card name="Gerador de Títulos" description="..." icon="💡" color="#8B5CF6" badge="hot" url="/ferramenta"]
 */
function redatudo_tool_card_shortcode($atts) {
    $atts = shortcode_atts(array(
        'name' => '',
        'description' => '',
        'icon' => '✨',
        'color' => '#7C3AED',
        'badge' => '', // hot, new, trending
        'stats' => '12.4k gerações',
        'rating' => '4.9',
        'url' => '#',
    ), $atts);
    
    if (empty($atts['name'])) return '';
    
    $badge_html = '';
    if ($atts['badge']) {
        $badge_class = 'badge-' . $atts['badge'];
        $badge_text = '';
        switch($atts['badge']) {
            case 'hot':
                $badge_text = '🔥 Mais usado';
                break;
            case 'new':
                $badge_text = '✨ Novo';
                break;
            case 'trending':
                $badge_text = '📈 Em alta';
                break;
        }
        $badge_html = '<span class="badge ' . esc_attr($badge_class) . '">' . $badge_text . '</span>';
    }
    
    ob_start();
    ?>
    <a href="<?php echo esc_url($atts['url']); ?>" class="tool-card" style="--tool-color: <?php echo esc_attr($atts['color']); ?>;">
        <?php echo $badge_html; ?>
        <div class="tool-icon"><?php echo esc_html($atts['icon']); ?></div>
        <h3><?php echo esc_html($atts['name']); ?></h3>
        <p><?php echo esc_html($atts['description']); ?></p>
        <div class="tool-stats">
            <span><?php echo esc_html($atts['stats']); ?></span>
            <span>⭐ <?php echo esc_html($atts['rating']); ?></span>
        </div>
        <button class="btn-tool">Experimentar grátis →</button>
    </a>
    <?php
    return ob_get_clean();
}
add_shortcode('tool_card', 'redatudo_tool_card_shortcode');

/**
 * Shortcode: Tools Grid Container
 * Uso: [tools_grid][tool_card ...][tool_card ...][/tools_grid]
 */
function redatudo_tools_grid_shortcode($atts, $content = null) {
    if (empty($content)) return '';
    
    return '<div class="tools-grid">' . do_shortcode($content) . '</div>';
}
add_shortcode('tools_grid', 'redatudo_tools_grid_shortcode');

/**
 * ========================================
 * HOOKS E FILTROS EXISTENTES
 * ========================================
 */

add_filter('woocommerce_form_field_args', 'wc_form_field_args',10,3);
add_filter( 'widget_text', 'do_shortcode' );
add_shortcode( 'recentes', 'post_recente' );
add_shortcode( 'list_categories', 'rd_categories' );
add_shortcode( 'product_reviews', 'rd_reviews_products' );
add_shortcode('woo_rd', 'woo_rd_template');
add_shortcode( 'nuvem_tags', 'nuvemTagsShortcode');
add_action('after_setup_theme', 'bs_after_setup_theme');
