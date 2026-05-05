/**
 * Redatudo Logout Compartilhado - Snippet JavaScript
 * 
 * Use este código nos seus apps (ebook.redatudo.online, hub.redatudo.online, chat.redatudo.online)
 * para fazer logout compartilhado com a aplicação principal (redatudo.online)
 */

// ============================================
// MÉTODO 1: Logout Simples (SEM redirecionamento de volta)
// ============================================
function redatuoLogout() {
  const mainDomain = 'https://redatudo.online';
  
  // Redireciona para fazer logout e volta para home
  window.location.href = `${mainDomain}/?do_logout=1`;
}

// Exemplo de uso:
// <button onclick="redatuoLogout()">Logout</button>


// ============================================
// MÉTODO 2: Logout com Redirecionamento de Volta pro App (RECOMENDADO)
// ============================================
function redatuoLogoutWithRedirect() {
  const mainDomain = 'https://redatudo.online';
  const currentApp = window.location.origin; // Obtém URL atual (ex: https://hub.redatudo.online)
  
  // Constrói URL de logout com redirecionamento
  const logoutUrl = `${mainDomain}/?do_logout=1&redirect_to=${encodeURIComponent(currentApp)}`;
  
  // Redireciona para fazer logout
  window.location.href = logoutUrl;
}

// Exemplo de uso:
// <button onclick="redatuoLogoutWithRedirect()">Logout</button>


// ============================================
// MÉTODO 3: Logout com Callback (Para casos específicos)
// ============================================
async function redatuoLogoutWithCallback() {
  const mainDomain = 'https://redatudo.online';
  const currentApp = window.location.origin;
  
  // Notifica antes de fazer logout (opcional)
  if (!confirm('Você será deslogado. Continuar?')) {
    return;
  }
  
  const logoutUrl = `${mainDomain}/?do_logout=1&redirect_to=${encodeURIComponent(currentApp)}`;
  
  // Redireciona
  window.location.href = logoutUrl;
}

// Exemplo de uso:
// <button onclick="redatuoLogoutWithCallback()">Logout</button>


// ============================================
// MÉTODO 4: Setup Automático de Button com ID
// ============================================
document.addEventListener('DOMContentLoaded', function() {
  // Encontra todos os botões com classe 'redatudo-logout'
  const logoutButtons = document.querySelectorAll('.redatudo-logout');
  
  logoutButtons.forEach(btn => {
    btn.addEventListener('click', function(e) {
      e.preventDefault();
      redatuoLogoutWithRedirect();
    });
  });
});

// Exemplo de uso no HTML:
// <button class="redatudo-logout">Logout</button>
// <a href="#" class="redatudo-logout">Fazer Logout</a>


// ============================================
// MÉTODO 5: React / Vue Component Hook
// ============================================

// Para React:
/*
import { useNavigate } from 'react-router-dom';

function LogoutButton() {
  const navigate = useNavigate();

  const handleLogout = () => {
    const mainDomain = 'https://redatudo.online';
    const currentApp = window.location.origin;
    const logoutUrl = `${mainDomain}/?do_logout=1&redirect_to=${encodeURIComponent(currentApp)}`;
    window.location.href = logoutUrl;
  };

  return <button onClick={handleLogout}>Logout</button>;
}
*/

// Para Vue:
/*
export default {
  methods: {
    handleLogout() {
      const mainDomain = 'https://redatudo.online';
      const currentApp = window.location.origin;
      const logoutUrl = `${mainDomain}/?do_logout=1&redirect_to=${encodeURIComponent(currentApp)}`;
      window.location.href = logoutUrl;
    }
  },
  template: `<button @click="handleLogout">Logout</button>`
}
*/


// ============================================
// MÉTODO 6: Com Verificação de Status (Seguro)
// ============================================
async function redatuoLogoutSafe() {
  const mainDomain = 'https://redatudo.online';
  const currentApp = window.location.origin;
  
  try {
    const logoutUrl = `${mainDomain}/?do_logout=1&redirect_to=${encodeURIComponent(currentApp)}`;
    
    // Avisa que será redirecionado
    console.log('Redirecionando para logout...', logoutUrl);
    
    // Redireciona
    window.location.href = logoutUrl;
    
    // Timeout como fallback caso redirecionamento falhe
    setTimeout(() => {
      console.warn('Logout redirecionamento levou muito tempo');
    }, 5000);
    
  } catch (error) {
    console.error('Erro ao fazer logout:', error);
    // Fallback: redireciona para home da aplicação principal
    window.location.href = mainDomain;
  }
}

// Exemplo de uso:
// <button onclick="redatuoLogoutSafe()">Logout Seguro</button>


// ============================================
// EXEMPLO: Integração com Menu de Conta
// ============================================
/*
<div class="account-dropdown" id="accountMenu">
  <button id="accountBtn">Minha Conta</button>
  <div id="accountDropdown" class="dropdown-content" style="display: none;">
    <a href="/profile">Editar Perfil</a>
    <a href="/settings">Configurações</a>
    <hr>
    <button class="redatudo-logout" style="width: 100%; text-align: left;">
      Logout
    </button>
  </div>
</div>

<script>
// Toggle dropdown
document.getElementById('accountBtn').addEventListener('click', function() {
  const dropdown = document.getElementById('accountDropdown');
  dropdown.style.display = dropdown.style.display === 'none' ? 'block' : 'none';
});

// Setup logout button com classe
document.addEventListener('DOMContentLoaded', function() {
  const logoutButtons = document.querySelectorAll('.redatudo-logout');
  logoutButtons.forEach(btn => {
    btn.addEventListener('click', function(e) {
      e.preventDefault();
      redatuoLogoutWithRedirect();
    });
  });
});
</script>
*/


// ============================================
// TESTES / DEBUG
// ============================================

// Para testar no console do navegador:
// 1. Abra o console (F12)
// 2. Digite: redatuoLogoutWithRedirect()
// 3. Pressione Enter
// 4. Você será redirecionado para logout

console.log('✓ Redatudo Logout Compartilhado carregado');
console.log('Use: redatuoLogoutWithRedirect() para fazer logout');
