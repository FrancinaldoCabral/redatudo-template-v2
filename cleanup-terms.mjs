/**
 * RedaTudo — Limpeza de tags e categorias via WordPress REST API
 *
 * Pré-requisito: WordPress Application Password
 *   Painel WP → Usuários → seu usuário → Application Passwords → gerar
 *   (o formato gerado é "xxxx xxxx xxxx xxxx" — use com os espaços)
 *
 * Configuração: edite a seção CONFIG abaixo
 *
 * Uso:
 *   node cleanup-terms.mjs               → simulação (não altera nada)
 *   node cleanup-terms.mjs --apply       → execução real
 */

// ─── CONFIG ──────────────────────────────────────────────────────────────────

const WP_URL   = 'https://redatudo.online';   // sem barra final
const WP_USER  = 'admin';                     // usuário WP
const WP_PASS  = 'xxxx xxxx xxxx xxxx xxxx xxxx'; // Application Password gerado no painel

// Categorias permitidas (exatamente como estão no WP)
const APPROVED_CATEGORIES = [
  'Tecnologia & IA',
  'Marketing Digital & SEO',
  'Redes Sociais',
  'Negócios & Startups',
  'Tendências de Conteúdo',
  'Ciência & Inovação',
  'Economia Criativa',
  'Segurança & Privacidade',
];

// Tags permitidas
const APPROVED_TAGS = [
  'Google', 'Instagram', 'TikTok', 'ChatGPT', 'OpenAI', 'Midjourney',
  'SEO', 'Algoritmo', 'IA Generativa', 'Automação', 'Vídeos',
  'Copywriting', 'Notícia', 'Análise', 'Tutorial', 'Case de Sucesso',
  'Lista', 'Startups', 'Criadores de Conteúdo', 'Marketing', 'Programação',
];

// Mapa semântico: substring no nome do termo → tag aprovada de destino
const TAG_MAP = {
  'instagram': 'Instagram', 'tiktok': 'TikTok', 'reels': 'Vídeos',
  'shorts': 'Vídeos', 'youtube': 'Vídeos', 'vídeo': 'Vídeos', 'video': 'Vídeos',
  'google': 'Google', 'chatgpt': 'ChatGPT', 'openai': 'OpenAI',
  'gpt': 'ChatGPT', 'midjourney': 'Midjourney', 'dall-e': 'Midjourney',
  'stable diff': 'Midjourney', 'seo': 'SEO', 'algoritmo': 'Algoritmo',
  'inteligência': 'IA Generativa', ' ia ': 'IA Generativa',
  'automação': 'Automação', 'automac': 'Automação', 'n8n': 'Automação',
  'zapier': 'Automação', 'copy': 'Copywriting', 'escrita': 'Copywriting',
  'redação': 'Copywriting', 'notícia': 'Notícia', 'noticia': 'Notícia',
  'análise': 'Análise', 'analise': 'Análise', 'tutorial': 'Tutorial',
  'como ': 'Tutorial', 'guia': 'Tutorial', 'startup': 'Startups',
  'empreend': 'Startups', 'marketing': 'Marketing', 'tráfego': 'Marketing',
  'ads': 'Marketing', 'programação': 'Programação', 'código': 'Programação',
  'python': 'Programação', 'javascript': 'Programação',
  'criador': 'Criadores de Conteúdo', 'creator': 'Criadores de Conteúdo',
  'influenc': 'Criadores de Conteúdo', 'lista': 'Lista', 'ranking': 'Lista',
  'melhores': 'Lista', 'case': 'Case de Sucesso', 'sucesso': 'Case de Sucesso',
};

const CAT_MAP = {
  'tecnologia': 'Tecnologia & IA', 'tech': 'Tecnologia & IA',
  'inteligência': 'Tecnologia & IA', ' ia': 'Tecnologia & IA',
  'marketing': 'Marketing Digital & SEO', 'seo': 'Marketing Digital & SEO',
  'digital': 'Marketing Digital & SEO', 'social': 'Redes Sociais',
  'redes': 'Redes Sociais', 'instagram': 'Redes Sociais', 'tiktok': 'Redes Sociais',
  'negócio': 'Negócios & Startups', 'negocio': 'Negócios & Startups',
  'startup': 'Negócios & Startups', 'empreend': 'Negócios & Startups',
  'ciência': 'Ciência & Inovação', 'inovação': 'Ciência & Inovação',
  'economia': 'Economia Criativa', 'criativa': 'Economia Criativa',
  'segurança': 'Segurança & Privacidade', 'privacidade': 'Segurança & Privacidade',
  'tendência': 'Tendências de Conteúdo', 'conteúdo': 'Tendências de Conteúdo',
  'conteudo': 'Tendências de Conteúdo', 'blog': 'Tendências de Conteúdo',
  'uncategorized': 'Tecnologia & IA', 'sem categoria': 'Tecnologia & IA',
  'geral': 'Tecnologia & IA',
};

// ─── INTERNALS ───────────────────────────────────────────────────────────────

const DRY_RUN  = !process.argv.includes('--apply');
const BASE     = WP_URL + '/wp-json/wp/v2';
const AUTH     = 'Basic ' + Buffer.from(`${WP_USER}:${WP_PASS}`).toString('base64');
const HEADERS  = { Authorization: AUTH, 'Content-Type': 'application/json' };

const stats = { catKept:0, catDeleted:0, tagKept:0, tagDeleted:0, postsMoved:0, redirects:0 };
const redirectLines = [];

function findBestMatch(name, map) {
  const lower = name.toLowerCase();
  for (const [kw, target] of Object.entries(map)) {
    if (lower.includes(kw)) return target;
  }
  return null;
}

async function apiFetch(path, opts = {}) {
  const res = await fetch(BASE + path, { headers: HEADERS, ...opts });
  if (!res.ok) {
    const text = await res.text();
    throw new Error(`${opts.method || 'GET'} ${path} → ${res.status}: ${text.slice(0,200)}`);
  }
  // DELETE retorna 200 com body, outros retornam JSON
  const ct = res.headers.get('content-type') || '';
  if (ct.includes('json')) return res.json();
  return res.text();
}

async function getAllTerms(taxonomy) {
  const endpoint = taxonomy === 'category' ? '/categories' : '/tags';
  let page = 1, all = [];
  while (true) {
    const batch = await apiFetch(`${endpoint}?per_page=100&page=${page}&_fields=id,name,slug,count`);
    if (!Array.isArray(batch) || batch.length === 0) break;
    all = all.concat(batch);
    if (batch.length < 100) break;
    page++;
    process.stdout.write(`\r  Carregando ${taxonomy}: ${all.length} termos...`);
  }
  console.log();
  return all;
}

async function getPostsWithTerm(termId, taxonomy) {
  const taxParam = taxonomy === 'category' ? 'categories' : 'tags';
  let page = 1, ids = [];
  while (true) {
    const batch = await apiFetch(`/posts?${taxParam}=${termId}&per_page=100&page=${page}&_fields=id`);
    if (!Array.isArray(batch) || batch.length === 0) break;
    ids = ids.concat(batch.map(p => p.id));
    if (batch.length < 100) break;
    page++;
  }
  return ids;
}

async function ensureTerm(name, taxonomy) {
  const endpoint = taxonomy === 'category' ? '/categories' : '/tags';
  // Busca por nome exato
  const found = await apiFetch(`${endpoint}?search=${encodeURIComponent(name)}&_fields=id,name`);
  const exact = found.find(t => t.name.toLowerCase() === name.toLowerCase());
  if (exact) return exact.id;
  if (DRY_RUN) return 0;
  const created = await apiFetch(endpoint, {
    method: 'POST',
    body: JSON.stringify({ name }),
  });
  console.log(`  ✚ Criado(a): "${name}"`);
  return created.id;
}

async function assignTermToPost(postId, termId, taxonomy) {
  const endpoint = `/posts/${postId}`;
  const field    = taxonomy === 'category' ? 'categories' : 'tags';
  // Busca os termos atuais
  const post = await apiFetch(`${endpoint}?_fields=id,${field}`);
  const current = post[field] || [];
  if (current.includes(termId)) return;
  await apiFetch(endpoint, {
    method: 'POST',
    body: JSON.stringify({ [field]: [...current, termId] }),
  });
}

async function deleteTerm(termId, taxonomy) {
  const endpoint = taxonomy === 'category' ? '/categories' : '/tags';
  await apiFetch(`${endpoint}/${termId}?force=true`, { method: 'DELETE' });
}

async function processTerms(taxonomy, approved, keywordMap) {
  const label    = taxonomy === 'category' ? 'CATEGORIAS' : 'TAGS';
  const approved_lower = approved.map(n => n.toLowerCase());

  console.log(`\n┌─ ${label} ${'─'.repeat(50 - label.length)}`);

  // Garante que todos os termos aprovados existem
  const approvedIds = {};
  for (const name of approved) {
    approvedIds[name] = await ensureTerm(name, taxonomy);
  }

  const all = await getAllTerms(taxonomy);
  const toDelete = [];

  for (const term of all) {
    if (approved_lower.includes(term.name.toLowerCase())) {
      stats[taxonomy === 'category' ? 'catKept' : 'tagKept']++;
      continue;
    }

    const best   = findBestMatch(term.name, keywordMap);
    const target = best || (taxonomy === 'category' ? 'Tecnologia & IA' : null);

    const slugPrefix = taxonomy === 'category' ? '/category/' : '/tag/';
    const fromUrl    = slugPrefix + term.slug + '/';

    if (term.count > 0) {
      const toUrl = target
        ? slugPrefix + (await apiFetch(
            (taxonomy === 'category' ? '/categories' : '/tags')
            + `?search=${encodeURIComponent(target)}&_fields=slug`
          ).then(r => r.find(t => t.name?.toLowerCase() === target.toLowerCase())?.slug || term.slug))
          + '/'
        : '/blog/';
      redirectLines.push(`Redirect 301 ${fromUrl} ${toUrl}`);
      stats.redirects++;

      if (!DRY_RUN) {
        const postIds = await getPostsWithTerm(term.id, taxonomy);
        if (target && approvedIds[target]) {
          for (const pid of postIds) {
            await assignTermToPost(pid, approvedIds[target], taxonomy);
            stats.postsMoved++;
          }
        }
      }
    }

    toDelete.push(term);
    stats[taxonomy === 'category' ? 'catDeleted' : 'tagDeleted']++;

    if (!DRY_RUN) {
      await deleteTerm(term.id, taxonomy);
      process.stdout.write(`\r  Excluindo... ${stats[taxonomy === 'category' ? 'catDeleted' : 'tagDeleted']}`);
    }
  }

  if (DRY_RUN) {
    console.log(`  A excluir: ${toDelete.length} ${label.toLowerCase()}`);
    toDelete.slice(0, 20).forEach(t =>
      console.log(`  ✗ "${t.name}" (${t.count} posts) → ${findBestMatch(t.name, keywordMap) || 'sem match → /blog/'}`)
    );
    if (toDelete.length > 20) console.log(`  ... e mais ${toDelete.length - 20}`);
  } else {
    console.log(`\n  ✓ ${toDelete.length} ${label.toLowerCase()} excluídas`);
  }
}

// ─── MAIN ─────────────────────────────────────────────────────────────────────

async function main() {
  console.log('\n═══════════════════════════════════════════════════════');
  console.log(`  RedaTudo — Limpeza de Termos  |  ${DRY_RUN ? '🔍 SIMULAÇÃO' : '⚡ EXECUÇÃO REAL'}`);
  console.log('═══════════════════════════════════════════════════════');
  if (DRY_RUN) console.log('  Para aplicar: node cleanup-terms.mjs --apply\n');

  // Testa autenticação
  try {
    await apiFetch('/users/me?_fields=id,name');
  } catch (e) {
    console.error('\n❌ Falha na autenticação. Verifique WP_USER e WP_PASS no script.');
    console.error('   Certifique-se de usar um Application Password (Painel → Usuários → Perfil → Application Passwords)');
    process.exit(1);
  }

  await processTerms('category', APPROVED_CATEGORIES, CAT_MAP);
  await processTerms('post_tag', APPROVED_TAGS, TAG_MAP);

  // Exporta redirects
  if (redirectLines.length > 0) {
    const { writeFileSync } = await import('fs');
    const fileName = DRY_RUN ? 'redirects-preview.htaccess' : 'redirects-new.htaccess';
    const content  = [
      `# RedaTudo - Redirects gerados em ${new Date().toISOString().slice(0,10)}`,
      '# Adicione ao .htaccess da raiz do WordPress, ANTES do bloco # BEGIN WordPress',
      '',
      ...redirectLines,
    ].join('\n');
    writeFileSync(fileName, content, 'utf8');
    console.log(`\n  📄 Redirects exportados → ${fileName}`);
  }

  console.log('\n═══════════════════════════════════════════════════════');
  console.log('  RESULTADO');
  console.log('═══════════════════════════════════════════════════════');
  console.log(`  Categorias mantidas  : ${stats.catKept}`);
  console.log(`  Categorias excluídas : ${stats.catDeleted}`);
  console.log(`  Tags mantidas        : ${stats.tagKept}`);
  console.log(`  Tags excluídas       : ${stats.tagDeleted}`);
  console.log(`  Posts reatribuídos   : ${stats.postsMoved}`);
  console.log(`  Redirects 301        : ${stats.redirects}`);
  console.log('═══════════════════════════════════════════════════════\n');

  if (!DRY_RUN) {
    console.log('  Próximos passos:');
    console.log('  1. Adicione redirects-new.htaccess ao .htaccess do WordPress');
    console.log('  2. Envie sitemap atualizado no Google Search Console');
  }
}

main().catch(err => { console.error('\n❌', err.message); process.exit(1); });
