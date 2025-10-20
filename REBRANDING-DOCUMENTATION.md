# 📚 RedaTudo - Documentação de Componentes do Rebranding 2.0

## 🎯 Visão Geral

Este documento apresenta todos os componentes, shortcodes e recursos implementados no tema RedaTudo para suportar o rebranding 2.0, focado em conversão e identidade visual moderna.

---

## 📦 Arquivos do Sistema

### CSS
- `assets/css/variables.css` - Sistema de design variables (cores, tipografia, espaçamentos)
- `assets/css/components.css` - Componentes de UI (botões, cards, badges, etc.)

### JavaScript
- `assets/js/interactions.js` - Animações e interações (ripple effects, smooth scroll, lazy loading)

### PHP
- `functions.php` - Enqueue de assets e registro de shortcodes

---

## 🎨 Sistema de Cores

### Cores Principais
```css
--primary-purple: #7C3AED    /* Roxo principal */
--electric-blue: #3B82F6     /* Azul energia */
--success-green: #10B981     /* Verde conversão */
--warning-orange: #F59E0B    /* Laranja urgência */
```

### Cores por Ferramenta (13 ferramentas)
```css
--tool-gerador-titulos: #8B5CF6
--tool-humanizador: #06B6D4
--tool-shopcopy: #10B981
--tool-temas-tcc: #3B82F6
--tool-reformulador: #6366F1
--tool-posts-instagram: #EC4899
--tool-corretor-abnt: #8B5CF6
--tool-hashtags: #F59E0B
--tool-conclusao: #14B8A6
--tool-frases-instagram: #A855F7
--tool-nomes-livros: #F43F5E
--tool-username: #06B6D4
--tool-ideias-conteudo: #84CC16
```

### Gradientes
```css
--gradient-hero: linear-gradient(135deg, #7C3AED 0%, #3B82F6 100%)
--gradient-cta: linear-gradient(135deg, #10B981 0%, #059669 100%)
--gradient-premium: linear-gradient(135deg, #F59E0B 0%, #D97706 100%)
--gradient-urgent: linear-gradient(135deg, #F59E0B 0%, #DC2626 100%)
```

---

## 🔧 Shortcodes Disponíveis

### 1. Tool Card (Card de Ferramenta)

Exibe um card de ferramenta com visual do rebranding.

**Uso:**
```
[tool_card 
    name="Gerador de Títulos" 
    description="Crie títulos criativos para livros, vídeos e posts em segundos" 
    icon="💡" 
    color="#8B5CF6" 
    badge="hot" 
    stats="12.4k gerações" 
    rating="4.9"
    url="/gerador-titulos"
]
```

**Parâmetros:**
- `name` (obrigatório) - Nome da ferramenta
- `description` (obrigatório) - Descrição breve
- `icon` - Emoji ou ícone (padrão: ✨)
- `color` - Cor da ferramenta em hex (padrão: #7C3AED)
- `badge` - Tipo de badge: `hot`, `new`, `trending` (opcional)
- `stats` - Estatísticas de uso (padrão: "12.4k gerações")
- `rating` - Avaliação (padrão: "4.9")
- `url` - Link da ferramenta (padrão: #)

**Exemplo de resultado:**
- Card com hover animado
- Borda superior colorida
- Badge de popularidade
- Estatísticas e avaliação
- Botão "Experimentar grátis →"

---

### 2. Tools Grid (Grade de Ferramentas)

Container para organizar múltiplos tool cards em grade responsiva.

**Uso:**
```
[tools_grid]
    [tool_card name="Gerador de Títulos" ...]
    [tool_card name="Humanizador de Texto" ...]
    [tool_card name="ShopCopy" ...]
[/tools_grid]
```

**Características:**
- Grid responsivo: 3 colunas (desktop), 2 colunas (tablet), 1 coluna (mobile)
- Espaçamento automático
- Animação de entrada dos cards

---

### 3. Social Proof Toast

Exibe notificações flutuantes de prova social (usuários usando ferramentas).

**Uso:**
```
[social_proof interval="8000"]
```

**Parâmetros:**
- `interval` - Intervalo entre mensagens em milissegundos (padrão: 8000)

**Características:**
- Aparece no canto inferior esquerdo
- Animação de slide
- Mensagens rotativas automáticas
- Avatar com iniciais
- Timestamp relativo

**Mensagens incluídas:**
- "João M. gerou 12 títulos há 3s"
- "Maria S. humanizou 850 palavras há 12s"
- "Carlos P. criou descrição para loja há 28s"
- (E mais 5 variações)

---

### 4. Countdown Timer

Timer de contagem regressiva renovável diariamente.

**Uso:**
```
[countdown_timer message="Promoção termina em:"]
```

**Parâmetros:**
- `message` - Mensagem antes do timer (padrão: "Promoção termina em:")
- `renew` - Tipo de renovação: `daily`, `weekly`, `monthly` (padrão: daily)

**Características:**
- Renovação automática às 23:59:59
- Visual de urgência (fundo vermelho claro)
- Contagem em horas:minutos:segundos
- Atualização em tempo real

---

### 5. Stats Display

Exibe estatísticas do RedaTudo em formato visual.

**Uso:**
```
[stats_display users="287.432" rating="4.9" active="12.4k"]
```

**Parâmetros:**
- `users` - Total de conteúdos criados (padrão: "287.432")
- `rating` - Avaliação média (padrão: "4.9")
- `active` - Criadores ativos (padrão: "12.4k")

**Características:**
- Grid responsivo (3 colunas desktop, 1 coluna mobile)
- Números em destaque com cor roxa
- Animação de contador (quando visível na tela)
- Labels descritivas

---

## 🎨 Classes CSS Disponíveis

### Botões

#### Botão Primário (Conversão)
```html
<a href="#" class="btn btn-primary">
    Começar Grátis Agora
    <span class="subtext">5 gerações/dia • Sem cartão</span>
</a>
```

#### Botão Secundário
```html
<button class="btn btn-secondary">Ver Todas as Ferramentas</button>
```

#### Botão de Urgência
```html
<button class="btn btn-urgent">🔥 50% OFF - Só Hoje</button>
```

#### Tamanhos
```html
<button class="btn btn-primary btn-small">Pequeno</button>
<button class="btn btn-primary">Normal</button>
<button class="btn btn-primary btn-large">Grande</button>
```

### Badges

```html
<span class="badge badge-hot">🔥 Mais usado</span>
<span class="badge badge-new">✨ Novo</span>
<span class="badge badge-trending">📈 Em alta</span>
<span class="badge badge-premium">👑 Premium</span>
<span class="badge badge-limit">5/5 grátis hoje</span>
<span class="badge badge-users">12.4k usando agora</span>
```

### Utilitários de Gradiente

```html
<h1 class="gradient-text">Texto com gradiente roxo-azul</h1>
<div class="gradient-bg-hero">Fundo gradiente hero</div>
<div class="gradient-bg-cta">Fundo gradiente CTA</div>
<div class="gradient-bg-premium">Fundo gradiente premium</div>
<div class="gradient-bg-urgent">Fundo gradiente urgente</div>
```

### Loading States

```html
<div class="loading-state">
    <div class="spinner"></div>
    <p class="loading-message">Analisando seu pedido...</p>
    <p class="loading-tip">💡 Dica: Seja específico para melhores resultados</p>
</div>
```

### Success State

```html
<div class="success-animation">
    ✨ <span>Pronto! Seu conteúdo foi gerado</span>
</div>
```

---

## 📝 Exemplos de Uso Completos

### Exemplo 1: Homepage com Grid de Ferramentas

```html
<!-- Hero Section -->
<div style="text-align: center; padding: 4rem 2rem;">
    <h1 style="font-size: 3rem; margin-bottom: 1rem;">
        <span class="gradient-text">13 Ferramentas de IA.</span><br/>
        1 Assinatura. Infinitas Criações.
    </h1>
    
    <p style="font-size: 1.25rem; color: #6B7280; max-width: 700px; margin: 0 auto 3rem;">
        Do TCC ao Instagram. Do e-commerce ao ebook.<br/>
        Crie conteúdo profissional em segundos, não horas.
    </p>
    
    <div style="display: flex; gap: 1rem; justify-content: center; margin-bottom: 3rem;">
        <a href="/cadastro" class="btn btn-primary btn-large">
            Começar Grátis Agora
            <span class="subtext">5 gerações/dia • Sem cartão</span>
        </a>
        <button class="btn btn-secondary btn-large">Ver Todas as 13 Ferramentas ↓</button>
    </div>
    
    [stats_display users="287.432" rating="4.9" active="12.4k"]
</div>

<!-- Grid de Ferramentas -->
[tools_grid]
    [tool_card 
        name="Gerador de Títulos" 
        description="Crie títulos criativos para livros, vídeos e posts em segundos"
        icon="💡"
        color="#8B5CF6"
        badge="hot"
        stats="12.4k gerações hoje"
        rating="4.9"
        url="/gerador-titulos"
    ]
    
    [tool_card 
        name="Humanizador de Texto" 
        description="Transforme texto de IA em conteúdo natural e autêntico"
        icon="✍️"
        color="#06B6D4"
        badge="trending"
        stats="8.2k gerações hoje"
        rating="4.8"
        url="/humanizador"
    ]
    
    [tool_card 
        name="ShopCopy" 
        description="Descrições de produtos que vendem para e-commerce"
        icon="🛍️"
        color="#10B981"
        badge="new"
        stats="5.1k gerações hoje"
        rating="4.9"
        url="/shopcopy"
    ]
    
    <!-- Adicionar as outras 10 ferramentas -->
[/tools_grid]

<!-- Social Proof -->
[social_proof interval="8000"]

<!-- Countdown de Urgência -->
<div style="text-align: center; margin: 3rem 0;">
    [countdown_timer message="⚡ Promoção 50% OFF termina em:"]
</div>
```

### Exemplo 2: Página de Produto/Ferramenta

```html
<div style="max-width: 1200px; margin: 0 auto; padding: 2rem;">
    
    <!-- Header da Ferramenta -->
    <div style="text-align: center; margin-bottom: 3rem;">
        <span class="badge badge-hot">🔥 Mais usado hoje</span>
        <h1 style="font-size: 3rem; margin: 1rem 0;">Gerador de Títulos</h1>
        <p style="font-size: 1.25rem; color: #6B7280;">
            Crie títulos criativos e impactantes para livros, vídeos, posts e TCCs
        </p>
        
        <div style="margin: 2rem 0;">
            <a href="#gerar" class="btn btn-primary btn-large">
                Gerar Meu Primeiro Título Grátis
            </a>
        </div>
        
        [stats_display users="12.4k" rating="4.9" active="hoje"]
    </div>
    
    <!-- Área de Geração -->
    <div id="gerar">
        <!-- Seu formulário/interface de geração aqui -->
    </div>
    
    <!-- Social Proof -->
    [social_proof]
    
</div>
```

### Exemplo 3: Página de Pricing

```html
<div style="max-width: 1400px; margin: 0 auto; padding: 4rem 2rem;">
    
    <!-- Header -->
    <div style="text-align: center; margin-bottom: 3rem;">
        [countdown_timer message="⏰ Promoção termina em:"]
        
        <h1 style="font-size: 3rem; margin: 2rem 0;">Escolha Seu Plano</h1>
        <p style="font-size: 1.25rem; color: #6B7280;">
            Todas as 13 ferramentas incluídas em todos os planos
        </p>
    </div>
    
    <!-- Cards de Pricing -->
    <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(300px, 1fr)); gap: 2rem;">
        
        <!-- Plano Grátis -->
        <div class="pricing-card">
            <h3>Grátis</h3>
            <div class="price">
                <span class="amount">R$ 0</span>
                <span class="period">/mês</span>
            </div>
            <ul class="features">
                <li>✅ 5 gerações/dia por ferramenta</li>
                <li>✅ Acesso às 13 ferramentas</li>
                <li>❌ Sem histórico</li>
                <li>❌ Com marca d'água</li>
            </ul>
            <button class="btn btn-secondary" style="width: 100%;">Começar Grátis</button>
        </div>
        
        <!-- Plano Pro (Destaque) -->
        <div class="pricing-card pricing-featured">
            <span class="badge badge-popular badge-hot">🔥 Mais Popular</span>
            <h3>Pro</h3>
            <div class="price">
                <span class="old-price">R$ 19</span>
                <span class="amount">R$ 9</span>
                <span class="period">/mês</span>
            </div>
            <span class="discount">50% OFF - Primeiros 100</span>
            <ul class="features">
                <li>✅ Gerações ILIMITADAS</li>
                <li>✅ Todas as 13 ferramentas</li>
                <li>✅ Histórico infinito</li>
                <li>✅ Sem marca d'água</li>
                <li>✅ Exportar PDF/DOCX</li>
                <li>✅ API Access</li>
                <li>✅ Suporte prioritário</li>
            </ul>
            <button class="btn btn-primary" style="width: 100%;">
                Assinar Agora - 50% OFF
                <span class="subtext">Cancele quando quiser</span>
            </button>
            <span class="trust">🔒 Pagamento seguro • Cancele a qualquer momento</span>
        </div>
        
        <!-- Plano Business -->
        <div class="pricing-card">
            <h3>Business</h3>
            <div class="price">
                <span class="amount">R$ 29</span>
                <span class="period">/mês</span>
            </div>
            <ul class="features">
                <li>✅ Tudo do Pro +</li>
                <li>✅ 5 usuários</li>
                <li>✅ White-label</li>
                <li>✅ Gerente de conta</li>
            </ul>
            <button class="btn btn-secondary" style="width: 100%;">Falar com Vendas</button>
        </div>
        
    </div>
    
    [social_proof]
    
</div>
```

---

## 🎯 Funcionalidades JavaScript

### Animações Automáticas

**Tool Cards:**
- Fade-in quando aparecem na tela
- Hover com elevação e borda colorida
- Efeito de brilho ao passar o mouse

**Botões:**
- Efeito ripple ao clicar
- Transições suaves

**Stats:**
- Contador animado quando visível
- Apenas números < 10.000 são animados

### Smooth Scrolling

Qualquer link com `href="#..."` terá scroll suave automático.

### Lazy Loading

Imagens com `data-src` em vez de `src` serão carregadas apenas quando visíveis:
```html
<img data-src="imagem-grande.jpg" alt="Descrição" />
```

### Parallax (Opcional)

Adicione `data-parallax="0.5"` para efeito parallax:
```html
<div data-parallax="0.5" style="background-image: url(...)">
    <!-- Conteúdo -->
</div>
```

---

## 📱 Responsividade

Todos os componentes são 100% responsivos:

### Breakpoints
- **Mobile:** < 640px
- **Tablet:** 640px - 1024px
- **Desktop:** > 1024px

### Adaptações Automáticas

**Tools Grid:**
- Desktop: 3 colunas
- Tablet: 2 colunas
- Mobile: 1 coluna

**Hero Stats:**
- Desktop: 3 colunas horizontal
- Mobile: 1 coluna vertical

**Pricing Cards:**
- Desktop: 3 colunas
- Mobile: 1 coluna empilhada

**Social Proof Toast:**
- Desktop: Canto inferior esquerdo
- Mobile: Full width na parte inferior

---

## ♿ Acessibilidade

### Navegação por Teclado

- Todos os botões e links são acessíveis via Tab
- Foco visível apenas em navegação por teclado (não mouse)
- Classe `.keyboard-focus` adicionada automaticamente

### ARIA Labels

Use `aria-label` em botões sem texto:
```html
<button class="btn btn-primary" aria-label="Começar grátis agora">
    <svg>...</svg>
</button>
```

---

## 🚀 Performance

### Otimizações Implementadas

1. **CSS Variables:** Altere cores globalmente sem recarregar
2. **Lazy Loading:** Imagens carregadas sob demanda
3. **Debounce:** Scroll events otimizados
4. **IntersectionObserver:** Animações eficientes
5. **CSS Transitions:** GPU acelerado

### Lighthouse Score Esperado

- **Performance:** 90+
- **Accessibility:** 95+
- **Best Practices:** 90+
- **SEO:** 95+

---

## 🔍 Troubleshooting

### CSS não está sendo aplicado

1. Limpe o cache do navegador (Ctrl + Shift + R)
2. Verifique se o enqueue está correto em `functions.php`
3. Confirme que não há conflitos com outros plugins

### Shortcodes não funcionam

1. Verifique se está usando a sintaxe correta
2. Certifique-se de que os parâmetros estão entre aspas
3. Teste shortcodes um por vez

### Animações não aparecem

1. Confirme que o JavaScript está carregando (`assets/js/interactions.js`)
2. Verifique se jQuery está ativo
3. Abra o console do navegador (F12) e veja se há erros

---

## 📞 Suporte

Para dúvidas ou problemas:
1. Revise esta documentação
2. Verifique os exemplos de código
3. Teste em ambiente de staging primeiro

---

## 🎉 Próximos Passos Recomendados

1. ✅ Criar página inicial com grid de ferramentas
2. ✅ Implementar pricing page com urgência
3. ✅ Adicionar social proof em páginas principais
4. ✅ Personalizar cores por ferramenta
5. ✅ Testar responsividade em dispositivos reais
6. ✅ Otimizar imagens e assets
7. ✅ Configurar Google Analytics 4
8. ✅ Implementar testes A/B de CTAs

---

**Versão:** 2.0.0  
**Última atualização:** Janeiro 2025  
**Compatibilidade:** WordPress 5.0+, WooCommerce 5.0+
