/**
 * RedaTudo — Limpeza de tags e categorias via banco MySQL
 *
 * Mais rápido que a REST API — opera direto nas tabelas wp_terms / wp_term_taxonomy
 *
 * Configuração: edite a seção CONFIG abaixo com os dados do wp-config.php
 *
 * Uso:
 *   node cleanup-terms-db.mjs               → simulação (não altera nada)
 *   node cleanup-terms-db.mjs --apply       → execução real
 */

import mysql from 'mysql2/promise';
import { writeFileSync } from 'fs';

// ─── CONFIG ──────────────────────────────────────────────────────────────────

const DB = {
  host    : 'srv500.hstgr.io',   // ou IP do servidor MySQL
  port    : 3306,
  user    : 'u959252524_6PZiJ',        // DB_USER do wp-config.php
  password: 'NolTvwIyjM',       // DB_PASSWORD do wp-config.php
  database: 'u959252524_3sEtu',   // DB_NAME do wp-config.php
};

// Prefixo das tabelas (DB_TABLE_PREFIX do wp-config.php, normalmente "wp_")
const PREFIX = 'wp_';

// Categorias permitidas (nomes exatos)
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

// Tags permitidas (nomes exatos)
const APPROVED_TAGS = [
  'Google', 'Instagram', 'TikTok', 'ChatGPT', 'OpenAI', 'Midjourney',
  'SEO', 'Algoritmo', 'IA Generativa', 'Automação', 'Vídeos',
  'Copywriting', 'Notícia', 'Análise', 'Tutorial', 'Case de Sucesso',
  'Lista', 'Startups', 'Criadores de Conteúdo', 'Marketing', 'Programação',
];

// Mapa semântico: substring (lowercase, sem acentos) → tag aprovada de destino
// Nota: as chaves são normalizadas (sem acentos) para bater com o normalize() abaixo
const TAG_MAP = {
  // Redes sociais
  'instagram': 'Instagram', 'tiktok': 'TikTok', 'reels': 'Vídeos',
  'shorts': 'Vídeos', 'youtube': 'Vídeos', 'video': 'Vídeos',
  // Ferramentas
  'google': 'Google', 'chatgpt': 'ChatGPT', 'openai': 'OpenAI',
  'gpt': 'ChatGPT', 'midjourney': 'Midjourney', 'dall-e': 'Midjourney',
  'stable diff': 'Midjourney', 'gemini': 'IA Generativa', 'claude': 'IA Generativa',
  'llm': 'IA Generativa', 'llms': 'IA Generativa',
  // SEO
  'seo': 'SEO', 'algoritmo': 'Algoritmo', 'serp': 'SEO', 'ranke': 'SEO',
  'backlink': 'SEO', 'keyword': 'SEO', 'palavra-chave': 'SEO',
  // IA — palavras curtas exigem match de string completa (tratado no findBestMatch)
  'inteligencia artificial': 'IA Generativa',
  'inteligência artificial': 'IA Generativa',
  'ia generativa': 'IA Generativa',
  'ai generativ': 'IA Generativa',
  'artificial intelligence': 'IA Generativa',
  'machine learning': 'IA Generativa',
  'deep learning': 'IA Generativa',
  'ferrament': 'IA Generativa',   // "ferramentas de ia", "ferramentas de criação"
  'criacao de conteudo': 'IA Generativa',
  'criação de conteudo': 'IA Generativa',
  'conteudo com ia': 'IA Generativa',
  'content creation': 'IA Generativa',
  'redatudo': 'IA Generativa',
  // Automação
  'automacao': 'Automação', 'automac': 'Automação', 'n8n': 'Automação',
  'zapier': 'Automação', 'workflow': 'Automação', 'make.com': 'Automação',
  'productividade': 'Automação', 'produtividade': 'Automação',
  // Copywriting
  'copy': 'Copywriting', 'escrita': 'Copywriting', 'redacao': 'Copywriting',
  'texto': 'Copywriting', 'writing': 'Copywriting',
  // Notícia / Análise
  'noticia': 'Notícia', 'notícia': 'Notícia', 'news': 'Notícia',
  'analise': 'Análise', 'análise': 'Análise', 'review': 'Análise', 'comparativ': 'Análise',
  // Tutorial
  'tutorial': 'Tutorial', 'como ': 'Tutorial', 'guia': 'Tutorial',
  'passo a passo': 'Tutorial', 'aprenda': 'Tutorial', 'dicas': 'Tutorial',
  // Negócios
  'startup': 'Startups', 'empreend': 'Startups', 'negocio': 'Startups',
  // Marketing
  'marketing': 'Marketing', 'trafego': 'Marketing', 'ads': 'Marketing',
  'anuncio': 'Marketing', 'campanha': 'Marketing', 'social media': 'Marketing',
  // Programação
  'programacao': 'Programação', 'codigo': 'Programação', 'python': 'Programação',
  'javascript': 'Programação', 'typescript': 'Programação', 'developer': 'Programação',
  'desenvolvimento': 'Programação', 'api': 'Programação',
  // Criadores
  'criador': 'Criadores de Conteúdo', 'creator': 'Criadores de Conteúdo',
  'influenc': 'Criadores de Conteúdo', 'youtuber': 'Criadores de Conteúdo',
  'blogueiro': 'Criadores de Conteúdo', 'streamer': 'Criadores de Conteúdo',
  // Listas
  'lista': 'Lista', 'ranking': 'Lista', 'melhores': 'Lista', 'top ': 'Lista',
  // Cases
  'case': 'Case de Sucesso', 'sucesso': 'Case de Sucesso', 'resultado': 'Case de Sucesso',
};

const CAT_MAP = {
  'tecnologia': 'Tecnologia & IA', 'tech': 'Tecnologia & IA',
  'inteligência': 'Tecnologia & IA', 'ia': 'Tecnologia & IA',
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

// ─── UTILS ────────────────────────────────────────────────────────────────────

const DRY_RUN = !process.argv.includes('--apply');

/** Remove acentos e entidades HTML, converte para lowercase */
function normalize(str) {
  return str
    .replace(/&amp;/g, '&').replace(/&lt;/g, '<').replace(/&gt;/g, '>').replace(/&nbsp;/g, ' ')
    .toLowerCase()
    .normalize('NFD').replace(/[\u0300-\u036f]/g, '');
}

function findBestMatch(name, map) {
  const norm = normalize(name);
  // Tenta match exato primeiro (termo curto como "IA", "AI", "Tecnologia")
  const exactMatches = {
    'ia': 'IA Generativa', 'ai': 'IA Generativa', 'tecnologia': 'IA Generativa',
    'inovacao': 'IA Generativa', 'innovacao': 'IA Generativa',
    'trends': 'Tendências de Conteúdo', 'trend': 'Tendências de Conteúdo',
    'seguranca digital': 'Segurança & Privacidade',
    'privacidade': 'Segurança & Privacidade',
  };
  if (exactMatches[norm]) return exactMatches[norm];
  // Substring match nos mapas
  for (const [kw, target] of Object.entries(map)) {
    if (norm.includes(normalize(kw))) return target;
  }
  return null;
}

// ─── DB HELPERS ───────────────────────────────────────────────────────────────

async function getTerms(db, taxonomy) {
  const [rows] = await db.execute(`
    SELECT t.term_id, t.name, t.slug, tt.term_taxonomy_id, tt.count
    FROM ${PREFIX}terms t
    JOIN ${PREFIX}term_taxonomy tt ON tt.term_id = t.term_id
    WHERE tt.taxonomy = ?
    ORDER BY tt.count DESC
  `, [taxonomy]);
  return rows;
}

async function getOrCreateTerm(db, name, taxonomy) {
  // Busca por nome exato (case insensitive)
  const [found] = await db.execute(
    `SELECT t.term_id, tt.term_taxonomy_id, t.slug
     FROM ${PREFIX}terms t
     JOIN ${PREFIX}term_taxonomy tt ON tt.term_id = t.term_id
     WHERE LOWER(t.name) = LOWER(?) AND tt.taxonomy = ?
     LIMIT 1`,
    [name, taxonomy]
  );
  if (found.length > 0) return found[0];

  if (DRY_RUN) return { term_id: 0, term_taxonomy_id: 0, slug: '' };

  // Cria slug
  const slug = name.toLowerCase()
    .normalize('NFD').replace(/[\u0300-\u036f]/g, '')
    .replace(/[^a-z0-9]+/g, '-').replace(/^-|-$/g, '');

  const [r1] = await db.execute(
    `INSERT INTO ${PREFIX}terms (name, slug, term_group) VALUES (?, ?, 0)`,
    [name, slug]
  );
  const termId = r1.insertId;
  const [r2] = await db.execute(
    `INSERT INTO ${PREFIX}term_taxonomy (term_id, taxonomy, description, parent, count) VALUES (?, ?, '', 0, 0)`,
    [termId, taxonomy]
  );
  console.log(`  ✚ Criado(a): "${name}"`);
  return { term_id: termId, term_taxonomy_id: r2.insertId, slug };
}

async function reassignPosts(db, fromTtId, toTtId) {
  // Posts que têm o termo antigo mas não o novo
  const [posts] = await db.execute(`
    SELECT object_id FROM ${PREFIX}term_relationships
    WHERE term_taxonomy_id = ?
    AND object_id NOT IN (
      SELECT object_id FROM ${PREFIX}term_relationships WHERE term_taxonomy_id = ?
    )
  `, [fromTtId, toTtId]);

  if (posts.length === 0) return 0;

  const ids = posts.map(p => p.object_id);
  const placeholders = ids.map(() => '?').join(',');

  // Insere nova relação em batch
  const values = ids.map(id => `(${id}, ${toTtId})`).join(',');
  await db.execute(
    `INSERT IGNORE INTO ${PREFIX}term_relationships (object_id, term_taxonomy_id) VALUES ${values}`
  );

  // Atualiza contador do termo destino
  await db.execute(
    `UPDATE ${PREFIX}term_taxonomy SET count = (
      SELECT COUNT(*) FROM ${PREFIX}term_relationships WHERE term_taxonomy_id = ?
    ) WHERE term_taxonomy_id = ?`,
    [toTtId, toTtId]
  );

  return ids.length;
}

async function deleteTerm(db, termId, termTaxonomyId) {
  await db.execute(`DELETE FROM ${PREFIX}term_relationships WHERE term_taxonomy_id = ?`, [termTaxonomyId]);
  await db.execute(`DELETE FROM ${PREFIX}term_taxonomy WHERE term_taxonomy_id = ?`, [termTaxonomyId]);
  await db.execute(`DELETE FROM ${PREFIX}terms WHERE term_id = ?`, [termId]);
  await db.execute(`DELETE FROM ${PREFIX}termmeta WHERE term_id = ?`, [termId]);
}

// ─── PROCESSAMENTO ────────────────────────────────────────────────────────────

async function processTerms(db, taxonomy, approved, keywordMap) {
  const label    = taxonomy === 'category' ? 'CATEGORIAS' : 'TAGS';
  const slugPfx  = taxonomy === 'category' ? '/category/' : '/tag/';
  const approvedLower = approved.map(n => normalize(n));

  console.log(`\n┌─ ${label} ${'─'.repeat(50 - label.length)}`);

  // Garante que os termos aprovados existem
  const approvedIndex = {};
  for (const name of approved) {
    approvedIndex[name] = await getOrCreateTerm(db, name, taxonomy);
  }

  const all = await getTerms(db, taxonomy);
  console.log(`  Total encontrado: ${all.length}`);

  let kept = 0, deleted = 0, moved = 0;
  const redirects = [];
  const toDelete = [];

  // Fallback padrão quando não há match semântico
  const DEFAULT_FALLBACK = taxonomy === 'category' ? 'Tecnologia & IA' : 'IA Generativa';

  for (const term of all) {
    // Compara normalizando HTML entities E acentos
    if (approvedLower.includes(normalize(term.name))) {
      kept++;
      continue;
    }

    const best   = findBestMatch(term.name, keywordMap);
    const target = best || DEFAULT_FALLBACK;
    const targetInfo = approvedIndex[target];

    // Redirect apenas para termos com posts indexáveis
    if (term.count > 0) {
      const toSlug = targetInfo?.slug || '';
      const toUrl  = toSlug ? `${slugPfx}${toSlug}/` : '/blog/';
      redirects.push(`Redirect 301 ${slugPfx}${term.slug}/ ${toUrl}`);
    }

    toDelete.push({ ...term, target, targetInfo });
    deleted++;
  }

  if (DRY_RUN) {
    const withPosts = toDelete.filter(t => t.count > 0);
    const estimatedMoved = withPosts.reduce((sum, t) => sum + t.count, 0);
    console.log(`  Manter : ${kept}`);
    console.log(`  Excluir: ${deleted} (${withPosts.length} com posts)`);
    console.log(`  Posts a reatribuir (estimativa): ${estimatedMoved}`);
    withPosts.slice(0, 15).forEach(t => {
      const match = findBestMatch(t.name, keywordMap) || DEFAULT_FALLBACK;
      console.log(`  ✗ "${t.name}" (${t.count} posts) → ${match}`);
    });
    if (withPosts.length > 15) {
      console.log(`  ... e mais ${withPosts.length - 15} com posts`);
    }
    moved = estimatedMoved; // para o relatório final
  } else {
    // ── Reatribuição em lote, agrupada por tag-destino ──────────────────────
    const byTarget = new Map();
    for (const term of toDelete) {
      const info = term.targetInfo;
      if (!info?.term_taxonomy_id) continue;
      const key = info.term_taxonomy_id;
      if (!byTarget.has(key)) byTarget.set(key, { info, ids: [] });
      byTarget.get(key).ids.push(term.term_taxonomy_id);
    }

    process.stdout.write(`  Reatribuindo posts...`);
    const REASSIGN_BATCH = 500;
    for (const { info: tInfo, ids: sourceTtIds } of byTarget.values()) {
      for (let i = 0; i < sourceTtIds.length; i += REASSIGN_BATCH) {
        const chunk = sourceTtIds.slice(i, i + REASSIGN_BATCH);
        const ph = chunk.map(() => '?').join(',');
        const [r] = await db.execute(
          `INSERT IGNORE INTO ${PREFIX}term_relationships (object_id, term_taxonomy_id)
           SELECT object_id, ${tInfo.term_taxonomy_id}
           FROM ${PREFIX}term_relationships
           WHERE term_taxonomy_id IN (${ph})`,
          chunk
        );
        moved += r.affectedRows;
      }
      await db.execute(
        `UPDATE ${PREFIX}term_taxonomy SET count = (
          SELECT COUNT(*) FROM ${PREFIX}term_relationships WHERE term_taxonomy_id = ?
        ) WHERE term_taxonomy_id = ?`,
        [tInfo.term_taxonomy_id, tInfo.term_taxonomy_id]
      );
    }
    console.log(` ✓`);

    // ── Exclusão em lote ──────────────────────────────────────────────────
    const DEL_BATCH = 300;
    for (let i = 0; i < toDelete.length; i += DEL_BATCH) {
      const chunk = toDelete.slice(i, i + DEL_BATCH);
      const termIds = chunk.map(t => t.term_id);
      const ttIds   = chunk.map(t => t.term_taxonomy_id);
      const tph     = termIds.map(() => '?').join(',');
      const ttph    = ttIds.map(() => '?').join(',');
      await db.execute(`DELETE FROM ${PREFIX}term_relationships WHERE term_taxonomy_id IN (${ttph})`, ttIds);
      await db.execute(`DELETE FROM ${PREFIX}term_taxonomy    WHERE term_taxonomy_id IN (${ttph})`, ttIds);
      await db.execute(`DELETE FROM ${PREFIX}terms            WHERE term_id IN (${tph})`, termIds);
      await db.execute(`DELETE FROM ${PREFIX}termmeta         WHERE term_id IN (${tph})`, termIds);
      const done = Math.min(i + DEL_BATCH, toDelete.length);
      process.stdout.write(`\r  Excluindo termos... ${done}/${toDelete.length}`);
    }
    console.log(`\r  Excluídos: ${deleted} termos.                              ✓`);
    console.log(`  Posts reatribuídos: ${moved}`);
  }

  return { kept, deleted, moved, redirects };
}

// ─── MAIN ─────────────────────────────────────────────────────────────────────

async function main() {
  console.log('\n═══════════════════════════════════════════════════════');
  console.log(`  RedaTudo — Limpeza de Termos  |  ${DRY_RUN ? '🔍 SIMULAÇÃO' : '⚡ EXECUÇÃO REAL'}`);
  console.log('═══════════════════════════════════════════════════════');
  if (DRY_RUN) console.log('  Para aplicar: node cleanup-terms-db.mjs --apply\n');

  let db;
  try {
    db = mysql.createPool({ ...DB, charset: 'utf8mb4', connectionLimit: 5, connectTimeout: 60000, waitForConnections: true });
    await db.execute('SELECT 1'); // valida conexão
    console.log('  ✓ Conectado ao banco de dados');
  } catch (e) {
    console.error('\n❌ Falha na conexão com o banco:', e.message);
    console.error('   Verifique host, porta, usuário e senha na seção CONFIG do script.');
    process.exit(1);
  }

  try {
    const catResult = await processTerms(db, 'category', APPROVED_CATEGORIES, CAT_MAP);
    const tagResult = await processTerms(db, 'post_tag', APPROVED_TAGS, TAG_MAP);

    // Exporta arquivo de redirects
    const allRedirects = [...catResult.redirects, ...tagResult.redirects];
    if (allRedirects.length > 0) {
      const fileName = DRY_RUN ? 'redirects-preview.htaccess' : 'redirects-new.htaccess';
      const content = [
        `# RedaTudo - Redirects gerados em ${new Date().toISOString().slice(0,10)}`,
        '# Adicione ao .htaccess da raiz ANTES do bloco # BEGIN WordPress',
        '',
        ...allRedirects,
        '',
      ].join('\n');
      writeFileSync(fileName, content, 'utf8');
      console.log(`\n  📄 ${allRedirects.length} redirects exportados → ${fileName}`);
    }

    const totalMoved = catResult.moved + tagResult.moved;

    console.log('\n═══════════════════════════════════════════════════════');
    console.log('  RESULTADO');
    console.log('═══════════════════════════════════════════════════════');
    console.log(`  Categorias mantidas  : ${catResult.kept}`);
    console.log(`  Categorias excluídas : ${catResult.deleted}`);
    console.log(`  Tags mantidas        : ${tagResult.kept}`);
    console.log(`  Tags excluídas       : ${tagResult.deleted}`);
    console.log(`  Posts reatribuídos   : ${totalMoved}${DRY_RUN ? ' (estimativa)' : ''}`);
    console.log(`  Redirects 301        : ${allRedirects.length}`);
    console.log('═══════════════════════════════════════════════════════\n');

    if (!DRY_RUN) {
      console.log('  Próximos passos:');
      console.log('  1. Adicione redirects-new.htaccess ao .htaccess do WordPress');
      console.log('  2. Limpe o cache do WordPress/plugin de cache');
      console.log('  3. Envie sitemap atualizado no Google Search Console');
    }

  } finally {
    await db.end();
  }
}

main().catch(err => { console.error('\n❌', err.message); process.exit(1); });
