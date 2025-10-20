<?php 
if ( ! defined( 'ABSPATH' ) ) { exit; }
?>

<style>
:root {
  --roxo-ia: #7f00ff;
  --azul-tech: #00bfff;
  --preto-fundo: #101022;
  --azul-glow: #00ffd0;
}
/* Layout principal */
.redatudo-login-clean {
  max-width: 870px;
  margin: 48px auto 64px auto;
  padding: 0;
  border-radius: 32px;
  background: linear-gradient(120deg, #181736 65%, #101022 100%);
  box-shadow: 0 3px 22px #7f00ff13, 0 2px 14px #00bfff19 inset;
  overflow: hidden;
  display: flex;
  align-items: stretch;
  position: relative;
}
@media (max-width: 900px) {
  .redatudo-login-clean { flex-direction:column; box-shadow:0 2px 24px #7f00ff23; }
}
/* Social login */
.rdt-login-social-min {
  flex: 1 1 220px;
  background: #15192a;
  padding: 2.4rem 1.3rem;
  display: flex;
  flex-direction: column;
  justify-content: center;
  align-items: center;
  min-width: 210px;
  border-right: 1px solid #23234a44;
}
@media (max-width: 900px) {
  .rdt-login-social-min { border-right: none; border-bottom: 1px solid #23234a44; }
}
.rdt-login-social-min .social-title {
  font-family: 'Orbitron', Arial, sans-serif;
  color: #b8e6ff;
  font-size: 1.1rem;
  margin-bottom: 1.1em;
  font-weight: 500;
  letter-spacing: 1.1px;
}
.rdt-login-social-min .mo-openid-app-icons,
.rdt-login-social-min .mo_btn-social,
.rdt-login-social-min .mo_btn-google,
.rdt-login-social-min .mo_btn-facebook {
  width: 100%;
  text-align: center;
  margin-bottom: 0.9em;
}
.rdt-login-social-min .mo_btn-social,
.rdt-login-social-min .mo_btn-google,
.rdt-login-social-min .mo_btn-facebook {
  background: #101022;
  border-radius: 15px;
  box-shadow: 0 2px 8px #00ffd013;
  border: none;
  color: #b8e6ff !important;
  font-family: 'Orbitron', Arial, sans-serif;
  font-size: 1.07rem;
  padding: 0.85em 0;
  margin-bottom: 0.8em;
  transition: background .18s, color .18s, box-shadow .18s;
}
.rdt-login-social-min .mo_btn-social:hover,
.rdt-login-social-min .mo_btn-google:hover,
.rdt-login-social-min .mo_btn-facebook:hover {
  background: linear-gradient(90deg,#00bfff44,#7f00ff38);
  color: #00ffd0 !important;
  box-shadow: 0 4px 20px #00ffd026;
}

/* Formulário */
.rdt-login-form-min {
  flex: 2 1 350px;
  padding: 2.7rem 2.4rem;
  display: flex;
  flex-direction: column;
  justify-content: center;
  min-width: 260px;
  background: transparent;
}
@media (max-width: 900px) {
  .rdt-login-form-min { padding:2.1rem 1.2rem; }
}
.rdt-login-title-min {
  font-family: 'Orbitron', Arial, sans-serif;
  text-transform: uppercase;
  background: linear-gradient(87deg, #00bfff 40%, #7f00ff 90%);
  -webkit-background-clip: text; -webkit-text-fill-color: transparent;
  font-size: 2rem; font-weight: 800; letter-spacing: 2px;
  margin-bottom: 0.2em;
  text-align: left;
}
.rdt-login-sub-min {
  font-family: 'Orbitron', Arial, sans-serif;
  color: #b8e6ff;
  font-size: 1.07rem;
  margin-bottom: 2.1em;
  text-align: left;
}
.rdt-login-tabs-min {
  display: flex;
  gap: 1em;
  margin-bottom: 2em;
}
.rdt-login-tab-btn-min {
  background: none;
  border: none;
  font-family: 'Orbitron', Arial, sans-serif;
  font-size: 1.06em;
  color: #b8e6ff;
  font-weight: bold;
  letter-spacing: 1px;
  padding: .6em 1.3em;
  border-radius: 14px 14px 0 0;
  box-shadow: none;
  transition: color .16s, background .22s;
}
.rdt-login-tab-btn-min.active, .rdt-login-tab-btn-min:focus, .rdt-login-tab-btn-min:hover {
  background: linear-gradient(91deg,#00ffd022,#7f00ff13 97%);
  color: #00ffd0 !important;
}

/* NOVO: Agrupamento vertical dos campos */
.rdt-form-min .input-group {
  display: flex;
  flex-direction: column;
  align-items: flex-start;
  margin-bottom: 1.3em;
  width: 100%;
}
.rdt-form-min label {
  font-family: 'Orbitron', Arial, sans-serif;
  color: #b8e6ff !important;
  font-size: 1em;
  font-weight: bold;
  margin-bottom: 0.38em;
  display: block;
  width: 100%;
}
.rdt-form-min input[type="email"],
.rdt-form-min input[type="text"],
.rdt-form-min input[type="password"] {
  background: rgba(22,28,46,0.94);
  border-radius: 11px !important;
  border: 1.2px solid #1efeb741;
  color: #00ffd0;
  font-family: 'Orbitron', Arial, sans-serif;
  font-size: 1.05em;
  padding: 0.9em 1em;
  width: 100%;
  box-shadow: 0 1px 8px #00ffd015;
  outline: none;
  margin-bottom: 0;
  transition: border .17s;
  display: block;
}
.rdt-form-min input:focus {
  border-color: #00ffd0;
}
.rdt-form-min .required { color: #00ffd0; font-weight: bold;}
.rdt-form-min .btn-login-rdt, .rdt-form-min .btn-register-rdt {
  background: linear-gradient(90deg, #7f00ff 60%, #00bfff 100%);
  color: #fff !important;
  border-radius: 13px !important;
  border: none;
  font-family: 'Orbitron', Arial, sans-serif;
  font-weight: bold;
  font-size: 1.11em;
  box-shadow: 0 2px 10px #00ffd030;
  margin-top: 0.5em;
  margin-bottom: .5em;
  transition: transform .18s, box-shadow .18s;
  padding: .7em 0;
  width: 100%;
}
.rdt-form-min .btn-login-rdt:hover, .rdt-form-min .btn-register-rdt:hover {
  background: linear-gradient(95deg, #00bfff 65%, #7f00ff 100%);
  color:#00ffd0!important; 
  transform: translateY(-2px) scale(1.03);
  box-shadow: 0 7px 28px #00ffd08a;
}
.rdt-form-min .checkbox {
  margin-bottom: 1em;
}
.rdt-form-min .checkbox label {
  color: #7f00ff; font-size: 1em; margin-left: 0.4em; font-family:'Orbitron';font-weight:600;
}
.rdt-form-min .woocommerce-LostPassword {
  margin-top: .7em;
  text-align: right;
  font-size: .99em;
}
.rdt-form-min .woocommerce-LostPassword a {
  color: #b8e6ff; text-decoration: underline;
  transition: color .13s;
}
.rdt-form-min .woocommerce-LostPassword a:hover { color: #7f00ff; }
.rdt-form-min .login-help {
  text-align: center;
  color: #b8e6ff; font-size: .95em;
  margin-top: 0.7em;
}
.rdt-form-min .login-help strong { color: var(--azul-glow);}
</style>

<div class="redatudo-login-clean">
  <!-- Social Login -->
  <div class="rdt-login-social-min">
    <div class="social-title">Entrar com:</div>
    <?php echo do_shortcode('[miniorange_social_login]'); ?>
  </div>
  <!-- Formulários -->
  <div class="rdt-login-form-min">
    <div class="rdt-login-title-min">Acesse sua conta</div>
    <div class="rdt-login-sub-min">Entre ou crie grátis para usar IA</div>
    <div class="rdt-login-tabs-min">
      <button class="rdt-login-tab-btn-min active" id="tab-login-btn" type="button" onclick="showLoginMin()">Entrar</button>
      <?php if ( get_option( 'woocommerce_enable_myaccount_registration' ) === 'yes' ) : ?>
      <button class="rdt-login-tab-btn-min" id="tab-register-btn" type="button" onclick="showRegisterMin()">Criar conta</button>
      <?php endif; ?>
    </div>
    <div id="tab-login-min" style="display:block">
      <form method="post" class="rdt-form-min login">
        <?php do_action( 'woocommerce_login_form_start' ); ?>
        <div class="input-group">
          <label for="login_email">E-mail <span class="required">*</span></label>
          <input type="text" name="username" id="login_email" autocomplete="username" placeholder="Seu email" value="<?php if ( ! empty( $_POST['username'] ) ) echo esc_attr( $_POST['username'] ); ?>">
        </div>
        <div class="input-group">
          <label for="login_pass">Senha <span class="required">*</span></label>
          <input type="password" name="password" id="login_pass" autocomplete="current-password" placeholder="Sua senha">
        </div>
        <button type="submit" id="lgin" name="login" class="btn btn-login-rdt"><?php esc_attr_e( 'Entrar', 'woocommerce' ); ?></button>
        <?php wp_nonce_field( 'woocommerce-login', 'woocommerce-login-nonce' ); ?>
        <div class="checkbox mb-2">
          <label>
            <input name="rememberme" type="checkbox" id="rememberme" value="forever" style="margin-right:7px;" /> Manter conectado
          </label>
        </div>
        <p class="woocommerce-LostPassword lost_password">
          <a href="<?php echo esc_url( wp_lostpassword_url() ); ?>">Esqueceu a senha?</a>
        </p>
        <?php do_action( 'woocommerce_login_form_end' ); ?>
        <div class="login-help">
          Não tem conta? <strong onclick="showRegisterMin()" style="cursor:pointer;">Criar Conta Grátis</strong>
        </div>
      </form>
    </div>
    <?php if ( get_option( 'woocommerce_enable_myaccount_registration' ) === 'yes' ) : ?>
    <div id="tab-register-min" style="display:none">
      <form method="post" class="rdt-form-min register">
        <?php do_action( 'woocommerce_register_form_start' ); ?>
        <?php if ( 'no' === get_option( 'woocommerce_registration_generate_username' ) ) : ?>
        <div class="input-group">
          <label for="reg_username">Usuário <span class="required">*</span></label>
          <input type="text" name="username" id="reg_username" placeholder="Usuário" value="<?php if ( ! empty( $_POST['username'] ) ) echo esc_attr( $_POST['username'] ); ?>">
        </div>
        <?php endif; ?>
        <div class="input-group">
          <label for="reg_email">E-mail <span class="required">*</span></label>
          <input type="email" name="email" id="reg_email" placeholder="Seu melhor email" value="<?php if ( ! empty( $_POST['email'] ) ) echo esc_attr( $_POST['email'] ); ?>" autocomplete="email">
        </div>
        <?php if ( 'no' === get_option( 'woocommerce_registration_generate_password' ) ) : ?>
        <div class="input-group">
          <label for="reg_password">Senha <span class="required">*</span></label>
          <input type="password" name="password" id="reg_password" placeholder="Crie uma senha forte" autocomplete="new-password">
        </div>
        <?php endif; ?>
        <?php do_action( 'woocommerce_register_form' ); ?>
        <?php do_action( 'register_form' ); ?>
        <button type="submit" class="btn btn-register-rdt" name="register" id="rd_register">Criar Conta Grátis</button>
        <?php wp_nonce_field( 'woocommerce-register', 'woocommerce-register-nonce' ); ?>
        <?php do_action( 'woocommerce_register_form_end' ); ?>
        <div class="login-help">
          Já tem conta? <strong onclick="showLoginMin()" style="cursor:pointer;">Entrar</strong>
        </div>
      </form>
    </div>
    <?php endif; ?>
  </div>
</div>

<script>
function showLoginMin() {
  document.getElementById('tab-login-min').style.display = 'block';
  document.getElementById('tab-register-min') && (document.getElementById('tab-register-min').style.display = 'none');
  document.getElementById('tab-login-btn').classList.add('active');
  document.getElementById('tab-register-btn') && document.getElementById('tab-register-btn').classList.remove('active');
}
function showRegisterMin() {
  document.getElementById('tab-login-min').style.display = 'none';
  document.getElementById('tab-register-min') && (document.getElementById('tab-register-min').style.display = 'block');
  document.getElementById('tab-register-btn').classList.add('active');
  document.getElementById('tab-login-btn').classList.remove('active');
}
// Social login minimal styling
document.addEventListener('DOMContentLoaded', function(){
  let btns = document.querySelectorAll('.mo_btn-google, .mo_btn-facebook, .mo_btn-social:not(.btn)');
  for(let btn of btns){
    btn.className = 'btn btn-lg form-control border-0 bg-transparent mb-2';
    btn.style.marginBottom = '0.6em';
    btn.style.color = '#b8e6ff';
    btn.style.fontFamily = 'Orbitron, Arial, sans-serif';
    btn.style.fontWeight = '600';
    btn.style.boxShadow = '0 2px 8px #00ffd033';
    btn.style.borderRadius = '15px';
    btn.style.background = '#101022';
  }
  let icons = document.getElementsByClassName('mo-openid-app-icons');
  for(let icon of icons){
    icon.classList.add('text-center','mb-3');
  }
});
</script>