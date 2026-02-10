<!-- ======================= STUDENT DASHBOARD + INLINE ACT PANELS ======================= -->
<!-- Inject dynamic metrics from Laravel (KEEP THIS LINE) -->
<script>window.STUDENT_METRICS = @json($studentMetrics ?? []);</script>

<style>
/* ==== Themeable vars (tweak if your brand updates) ==== */
:root{
  --card-radius: 22px;
  --tile-min-h: 220px;
  --brand-surface: #F5F7FA;
  --ink: #101319;
  --ink-dim: #3b3f46;
  --ring: rgba(47,130,255,.25);
  --ink-2:#3b3f46; --surface:#f6f7fb; --card:#ffffff; --shadow:0 12px 32px rgba(16,19,25,.10);
  --blue:#5d6cf6; --blue2:#3c9be8; --purple:#a855f7; --good:#2cb66d; --warn:#f3a43a; --bad:#ef4444;
}

/* Container + toolbar */
.student-dashboard{font-family:system-ui,-apple-system,Segoe UI,Roboto,Arial,sans-serif;color:var(--ink)}
.sd-toolbar{display:flex;align-items:center;justify-content:space-between;gap:1rem;flex-wrap:wrap}

/* Compact header chip */
.sd-home-card{display:flex;align-items:center;gap:10px;padding:10px 18px;border-radius:14px;
  background:rgba(255,255,255,0.25);backdrop-filter:blur(12px);box-shadow:0 4px 10px rgba(0,0,0,0.08);
  border:1px solid rgba(255,255,255,0.4);font-weight:700;font-size:16px;color:#222}
.sd-home-icon{font-size:20px}
.sd-home-card:hover{transform:translateY(-2px);box-shadow:0 8px 20px rgba(0,0,0,0.12)}

.sd-icons{display:flex;gap:.6rem}
.sd-icon{display:grid;place-items:center;width:46px;height:46px;border:1px solid #e6e6e9;border-radius:12px;
  background:#fff;color:var(--ink);text-decoration:none;font-weight:700;font-size:20px;box-shadow:0 2px 8px rgba(16,19,25,.04)}
.sd-icon:hover{transform:translateY(-2px);box-shadow:0 8px 20px rgba(16,19,25,.10)}
.sd-icon:focus-visible{outline:3px solid var(--ring);outline-offset:2px}

/* Grid of tiles */
.sd-grid{margin-top:1.25rem;display:grid;grid-template-columns:repeat(4,minmax(220px,1fr));gap:24px}
@media (max-width:1100px){.sd-grid{grid-template-columns:repeat(2,minmax(220px,1fr))}}
@media (max-width:560px){.sd-grid{grid-template-columns:1fr}}

/* Tile base */
.sd-tile{position:relative;display:block;min-height:var(--tile-min-h);text-decoration:none;isolation:isolate;
  background:var(--brand-surface);border-radius:var(--card-radius);overflow:hidden;
  box-shadow:0 10px 30px rgba(16,19,25,.06), inset 0 1px 0 rgba(255,255,255,.6);
  transition:transform .2s ease, box-shadow .2s ease, background .2s ease; cursor:pointer}
.sd-tile:hover{transform:translateY(-4px);box-shadow:0 18px 40px rgba(16,19,25,.12)}
.sd-tile:focus-visible{outline:4px solid var(--ring);outline-offset:3px}

/* Inner surface + light grain */
.sd-surface{position:absolute;inset:0;border-radius:inherit;overflow:hidden;
  background:radial-gradient(1200px 400px at -20% -20%, rgba(255,255,255,.22), transparent 40%),
             radial-gradient(800px 300px at 120% 120%, rgba(0,0,0,.08), transparent 45%),
             repeating-linear-gradient(135deg, rgba(255,255,255,.03) 0 2px, rgba(0,0,0,.03) 2px 4px);
  backdrop-filter:saturate(115%)}
.sd-green::after,.sd-orange::after,.sd-blue::after,.sd-purple::after,.sd-ccr::after{
  content:""; position:absolute; inset:1px; border-radius:calc(var(--card-radius) - 1px);
  box-shadow: inset 0 0 0 1px rgba(255,255,255,.28), inset 0 12px 28px rgba(255,255,255,.15)}
.sd-green{background:linear-gradient(180deg,#54cf86 0%,#1c6e39 100%)}
.sd-orange{background:linear-gradient(180deg,#f3a062 0%,#b45420 100%)}
.sd-blue{background:linear-gradient(180deg,#66c5f1 0%,#0c6a97 100%)}
.sd-purple{background:linear-gradient(180deg,#cc6aed 0%,#6d1f97 100%)}
/* new CCR gradient */
.sd-ccr{background:linear-gradient(180deg,#7ad0f0 0%,#1f6b88 100%)}
.sd-art{position:absolute;inset:0;width:100%;height:100%;mix-blend-mode:soft-light}

/* Label + chevron */
.sd-label{position:absolute;left:20px;bottom:18px;z-index:2;color:#fff;text-shadow:0 2px 8px rgba(0,0,0,.35);
  font-weight:900;letter-spacing:.3px;line-height:1.05;font-size:26px}
.sd-chevron{position:absolute;right:18px;bottom:14px;z-index:2;color:#fff;font-size:34px;
  text-shadow:0 2px 8px rgba(0,0,0,.35);font-weight:600;transform:translateX(0);transition:transform .2s ease}
.sd-tile:hover .sd-chevron{transform:translateX(4px)}

/* -------- Inline subject content container -------- */
.subject-content{grid-column:1 / -1; margin-top:20px; animation:fadeIn .3s ease}
.subject-content[hidden]{display:none !important}
@keyframes fadeIn{from{opacity:0;transform:translateY(8px)} to{opacity:1;transform:translateY(0)}}

/* ===== Panel styles ===== */
.actx.wrap{max-width:1200px;margin:0 auto;padding:6px}
.actx-head{display:flex;align-items:center;justify-content:space-between;gap:12px;margin-bottom:12px}
.chip{display:inline-flex;align-items:center;gap:.6rem;padding:.55rem .9rem;border-radius:999px;
  background:linear-gradient(90deg,rgba(93,108,246,.12),rgba(168,85,247,.12));
  border:1px solid rgba(93,108,246,.35);font-weight:800;color:var(--ink)}
.chip-icon{display:grid;place-items:center;width:28px;height:28px;border-radius:50%;
  background:linear-gradient(180deg,#7f88ff 0%,#5d6cf6 100%);color:#fff;box-shadow:0 6px 20px rgba(93,108,246,.35)}
.pill{padding:.45rem .8rem;border-radius:999px;font-weight:700}
.pill--good{background:rgba(44,182,109,.14);color:#0b7a44;border:1px solid rgba(44,182,109,.35)}
.pill--warn{background:rgba(243,164,58,.14);color:#9b5a11;border:1px solid rgba(243,164,58,.35)}
.pill--bad{background:rgba(239,68,68,.14);color:#8d1e1e;border:1px solid rgba(239,68,68,.35)}
.pill--neutral{background:rgba(0,0,0,.06);color:#333;border:1px solid rgba(0,0,0,.08)}

.grid{display:grid;gap:18px}
.grid.kpis{grid-template-columns:repeat(4,minmax(200px,1fr));margin:12px 0 6px}
.grid.two{grid-template-columns:repeat(2,minmax(0,1fr));margin:6px 0}
@media (max-width:1100px){.grid.kpis{grid-template-columns:repeat(3,1fr)}}
@media (max-width:700px){.grid.kpis,.grid.two{grid-template-columns:1fr}}

.card{background:var(--card);border-radius:20px;box-shadow:var(--shadow);padding:16px}
.card header{font-weight:800;margin-bottom:10px;color:var(--ink)}
.muted{color:var(--ink-2);opacity:.7}

/* KPI cards */
.kpi .kpi-top{display:flex;align-items:end;justify-content:space-between;margin-bottom:10px}
.kpi span{color:var(--ink-2);font-weight:600}
.kpi strong{font-size:28px;letter-spacing:.2px}
.spark{height:28px;background:linear-gradient(180deg,#eef3ff 0,#e9f6ff 100%);border-radius:10px;position:relative;overflow:hidden}

/* progress bars */
.bar{height:10px;background:#eef2f7;border-radius:999px;overflow:hidden}
.bar--accent{background:linear-gradient(90deg,#e9efff,#dff5ff)}
.bar--soft{background:#f0f3f9}
.bar .bar-fill{height:100%;width:var(--v);background:linear-gradient(90deg,var(--blue),var(--blue2));border-radius:inherit}

/* Gauges */
.gauge{display:flex;flex-direction:column;gap:8px}
.gauge-svg{display:block}
.gauge-legend{display:flex;gap:8px;justify-content:flex-end}
.legend{font-size:12px;padding:.15rem .5rem;border-radius:999px;border:1px solid rgba(0,0,0,.08)}
.l--bad{background:rgba(239,68,68,.12);color:#8d1e1e}
.l--warn{background:rgba(243,164,58,.12);color:#9b5a11}
.l--good{background:rgba(44,182,109,.12);color:#0b7a44}

/* ===== Quick gauge cards row (replaces old "Actions") ===== */
.quick-cards{display:grid;grid-template-columns:repeat(5,minmax(140px,1fr));gap:14px;margin-top:12px}
@media (max-width:1200px){.quick-cards{grid-template-columns:repeat(3,1fr)}}
@media (max-width:680px){.quick-cards{grid-template-columns:repeat(2,1fr)}}
.qc{background:var(--card);border-radius:16px;box-shadow:var(--shadow);padding:10px 10px 12px;text-align:center}
.qc .gauge-svg{width:100%;height:auto;display:block}
.qc-title{margin-top:6px;font-weight:800;color:var(--ink)}
.qc-sub{font-size:12px;color:var(--ink-2);opacity:.75}
</style>

<div class="student-dashboard">
  <!-- Toolbar -->
  <div class="sd-toolbar">
    <div class="sd-home-card" aria-hidden="true">
      <span class="sd-home-icon">🏠</span>
      <span class="sd-home-text">Student Dashboard</span>
    </div>
  </div>

  <!-- Tiles -->
  <div class="sd-grid">
    <!-- ACT ENGLISH -->
    <a class="sd-tile" id="englishTile" role="button" tabindex="0" aria-controls="englishContent" aria-expanded="false">
      <div class="sd-surface sd-green">
        <svg viewBox="0 0 720 420" aria-hidden="true" class="sd-art">
          <defs>
            <linearGradient id="engG" x1="0" y1="0" x2="0" y2="1">
              <stop offset="0%" stop-color="#4FC878"/><stop offset="100%" stop-color="#1D6F3A"/>
            </linearGradient>
            <linearGradient id="glass" x1="0" y1="0" x2="0.9" y2="1">
              <stop offset="0" stop-color="rgba(255,255,255,.65)"/><stop offset="1" stop-color="rgba(255,255,255,0)"/>
            </linearGradient>
          </defs>
          <rect x="0" y="0" width="720" height="420" rx="28" fill="url(#engG)"/>
          <path d="M0,290 C120,210 210,340 330,270 C450,200 540,330 720,250 L720,420 L0,420 Z" fill="rgba(255,255,255,.10)"/>
          <rect x="0" y="0" width="720" height="160" rx="28" fill="url(#glass)"/>
        </svg>
      </div>
      <span class="sd-label">ACT ENGLISH</span><span class="sd-chevron">›</span>
    </a>

    <!-- ACT MATH -->
    <a class="sd-tile" id="mathTile" role="button" tabindex="0" aria-controls="mathContent" aria-expanded="false">
      <div class="sd-surface sd-orange">
        <svg viewBox="0 0 720 420" aria-hidden="true" class="sd-art">
          <defs><linearGradient id="mathG" x1="0" y1="0" x2="0" y2="1">
            <stop offset="0%" stop-color="#F6A767"/><stop offset="100%" stop-color="#B85B22"/></linearGradient></defs>
          <rect x="0" y="0" width="720" height="420" rx="28" fill="url(#mathG)"/>
          <polygon points="220,70 500,70 650,210 500,350 220,350 70,210" fill="rgba(255,255,255,.10)"/>
        </svg>
      </div>
      <span class="sd-label">ACT<br> MATH</span><span class="sd-chevron">›</span>
    </a>

    <!-- ACT READING -->
    <a class="sd-tile" id="readingTile" role="button" tabindex="0" aria-controls="readingContent" aria-expanded="false">
      <div class="sd-surface sd-blue">
        <svg viewBox="0 0 720 420" aria-hidden="true" class="sd-art">
          <defs><linearGradient id="readG" x1="0" y1="0" x2="0" y2="1">
            <stop offset="0%" stop-color="#64C2F0"/><stop offset="100%" stop-color="#0D6A97"/></linearGradient></defs>
          <rect x="0" y="0" width="720" height="420" rx="28" fill="url(#readG)"/>
          <polygon points="220,90 500,90 620,210 500,330 220,330 100,210" fill="rgba(255,255,255,.12)"/>
        </svg>
      </div>
      <span class="sd-label">ACT<br> READING</span><span class="sd-chevron">›</span>
    </a>

    <!-- ACT SCIENCE -->
    <a class="sd-tile" id="scienceTile" role="button" tabindex="0" aria-controls="scienceContent" aria-expanded="false">
      <div class="sd-surface sd-purple">
        <svg viewBox="0 0 720 420" aria-hidden="true" class="sd-art">
          <defs><linearGradient id="sciG" x1="0" y1="0" x2="0" y2="1">
            <stop offset="0%" stop-color="#CC6AED"/><stop offset="100%" stop-color="#6E1F97"/></linearGradient></defs>
          <rect x="0" y="0" width="720" height="420" rx="28" fill="url(#sciG)"/>
          <circle cx="175" cy="330" r="12" fill="rgba(255,255,255,.12)"/><circle cx="205" cy="350" r="10" fill="rgba(255,255,255,.12)"/>
        </svg>
      </div>
      <span class="sd-label">ACT SCIENCE</span><span class="sd-chevron">›</span>
    </a>

    <!-- NEW: College & Career Readiness tile -->
    <a class="sd-tile" id="ccrTile" role="button" tabindex="0" aria-controls="ccrContent" aria-expanded="false">
      <div class="sd-surface sd-ccr">
        <svg viewBox="0 0 720 420" aria-hidden="true" class="sd-art">
          <defs>
            <linearGradient id="ccrG" x1="0" y1="0" x2="0" y2="1">
              <stop offset="0%" stop-color="#7ad0f0"/><stop offset="100%" stop-color="#1f6b88"/></linearGradient>
          </defs>
          <rect x="0" y="0" width="720" height="420" rx="28" fill="url(#ccrG)"/>
          <path d="M60,300 C160,220 260,340 380,270 C500,200 600,330 720,260 L720,420 L0,420 Z" fill="rgba(255,255,255,.08)"/>
        </svg>
      </div>
      <span class="sd-label">College &amp; Career<br> Readiness</span><span class="sd-chevron">›</span>
    </a>

    <!-- ===== English Content ===== -->
    <div id="englishContent" class="subject-content" hidden>
      <section class="actx wrap">
        <header class="actx-head">
          <div class="chip"><span class="chip-icon">📘</span><span class="chip-text">ACT English — Performance Tracker</span></div>
          <div id="trackPill" class="pill pill--neutral">Calculating status…</div>
        </header>

        <!-- KPI cards -->
        <div class="grid kpis">
          <article class="card kpi"><div class="kpi-top"><span>Overall Score</span><strong id="kpiScore">—</strong></div><div class="spark" data-points=""></div></article>
          <article class="card kpi"><div class="kpi-top"><span>Accuracy</span><strong id="kpiAccuracy">—</strong></div><div class="bar bar--accent"><div class="bar-fill" style="--v:0%"></div></div></article>
          <article class="card kpi"><div class="kpi-top"><span>Practice Tests</span><strong id="kpiTests">—</strong></div><div class="bar"><div class="bar-fill" style="--v:0%"></div></div></article>
          <article class="card kpi"><div class="kpi-top"><span>Questions / Week</span><strong id="kpiQ">—</strong></div><div class="spark" data-points=""></div></article>
        </div>

        <!-- Gauges -->
        <div class="grid two">
          <article class="card gauge">
            <header>Overall Test Score Rate</header>
            <svg class="gauge-svg" viewBox="0 0 120 60" width="100%" height="auto" data-value="0" data-good="80" data-warn="60"></svg>
            <footer class="gauge-legend"><span class="legend l--bad">Off Track</span><span class="legend l--warn">Behind</span><span class="legend l--good">Ahead</span></footer>
          </article>
          <article class="card gauge">
            <header>Time on ACT English</header>
            <!-- label will be hr:min -->
            <svg class="gauge-svg" viewBox="0 0 120 60" width="100%" height="auto" data-value="0" data-good="90" data-warn="60" data-mode="time" data-minutes="0"></svg>
            <footer class="gauge-legend"><span class="legend l--bad">Low</span><span class="legend l--warn">OK</span><span class="legend l--good">Great</span></footer>
          </article>
        </div>

        <!-- Quick performance tiles -->
       <section class="quick-cards">
  <article class="qc">
    <svg class="gauge-svg" viewBox="0 0 120 60" data-value="0" data-good="80" data-warn="60"></svg>
    <div class="qc-title">Quiz Scores</div><div class="qc-sub">avg. accuracy</div>
  </article>

  <article class="qc">
    <svg class="gauge-svg" viewBox="0 0 120 60" data-value="0" data-good="90" data-warn="60" data-mode="number" data-number="0"></svg>
    <div class="qc-title">Video Tutorials</div><div class="qc-sub">videos watched</div>
  </article>

  <article class="qc">
    <svg class="gauge-svg" viewBox="0 0 120 60" data-value="0" data-good="75" data-warn="50"></svg>
    <div class="qc-title">Grammar Hammers</div><div class="qc-sub">weekly activity</div>
  </article>

  <!-- Flash Cards now shows weekly count -->
  <article class="qc">
    <svg class="gauge-svg" viewBox="0 0 120 60" 
         data-value="0" data-good="75" data-warn="50" 
         data-mode="number" data-number="0"></svg>
    <div class="qc-title">Flash Cards</div>
    <div class="qc-sub" id="flashcardsSub">weekly activity</div>
  </article>

  <article class="qc">
    <svg class="gauge-svg" viewBox="0 0 120 60" data-value="0" data-good="80" data-warn="60"></svg>
    <div class="qc-title">ACT Guide Book</div><div class="qc-sub">completion</div>
  </article>
</section>
      </section>
    </div>

    <!-- ===== Math Content ===== -->
    <div id="mathContent" class="subject-content" hidden>
      <section class="actx wrap">
        <header class="actx-head">
          <div class="chip"><span class="chip-icon">➗</span><span class="chip-text">ACT Math — Performance Tracker</span></div>
          <div id="trackPillMath" class="pill pill--neutral">Calculating status…</div>
        </header>

        <div class="grid kpis">
          <article class="card kpi"><div class="kpi-top"><span>Overall Score</span><strong>—</strong></div><div class="spark" data-points=""></div></article>
          <article class="card kpi"><div class="kpi-top"><span>Accuracy</span><strong>—</strong></div><div class="bar bar--accent"><div class="bar-fill" style="--v:0%"></div></div></article>
          <article class="card kpi"><div class="kpi-top"><span>Practice Tests</span><strong>—</strong></div><div class="bar"><div class="bar-fill" style="--v:0%"></div></div></article>
          <article class="card kpi"><div class="kpi-top"><span>Questions / Week</span><strong>—</strong></div><div class="spark" data-points=""></div></article>
        </div>

        <div class="grid two">
          <article class="card gauge"><header>Overall Test Score Rate</header><svg class="gauge-svg" viewBox="0 0 120 60" data-value="0" data-good="80" data-warn="60"></svg><footer class="gauge-legend"><span class="legend l--bad">Off Track</span><span class="legend l--warn">Behind</span><span class="legend l--good">Ahead</span></footer></article>
          <article class="card gauge"><header>Time on ACT Math</header><svg class="gauge-svg" viewBox="0 0 120 60" data-value="0" data-good="90" data-warn="60" data-mode="time" data-minutes="0"></svg><footer class="gauge-legend"><span class="legend l--bad">Low</span><span class="legend l--warn">OK</span><span class="legend l--good">Great</span></footer></article>
        </div>

        <section class="quick-cards">
          <article class="qc"><svg class="gauge-svg" viewBox="0 0 120 60" data-value="0" data-good="80" data-warn="60"></svg><div class="qc-title">Quiz Scores</div><div class="qc-sub">avg. accuracy</div></article>
          <article class="qc"><svg class="gauge-svg" viewBox="0 0 120 60" data-value="0" data-good="90" data-warn="60" data-mode="number" data-number="0"></svg><div class="qc-title">Video Tutorials</div><div class="qc-sub">videos watched</div></article>
          <article class="qc"><svg class="gauge-svg" viewBox="0 0 120 60" data-value="0" data-good="75" data-warn="50"></svg><div class="qc-title">Formula Drills</div><div class="qc-sub">weekly activity</div></article>
          <article class="qc"><svg class="gauge-svg" viewBox="0 0 120 60" data-value="0" data-good="75" data-warn="50"></svg><div class="qc-title">Flash Cards</div><div class="qc-sub">weekly activity</div></article>
          <article class="qc"><svg class="gauge-svg" viewBox="0 0 120 60" data-value="0" data-good="80" data-warn="60"></svg><div class="qc-title">ACT Guide Book</div><div class="qc-sub">completion</div></article>
        </section>
      </section>
    </div>

    <!-- ===== Reading Content ===== -->
    <div id="readingContent" class="subject-content" hidden>
      <section class="actx wrap">
        <header class="actx-head">
          <div class="chip"><span class="chip-icon">📖</span><span class="chip-text">ACT Reading — Performance Tracker</span></div>
          <div id="trackPillRead" class="pill pill--neutral">Calculating status…</div>
        </header>

        <div class="grid kpis">
          <article class="card kpi"><div class="kpi-top"><span>Overall Score</span><strong>—</strong></div><div class="spark" data-points=""></div></article>
          <article class="card kpi"><div class="kpi-top"><span>Accuracy</span><strong>—</strong></div><div class="bar bar--accent"><div class="bar-fill" style="--v:0%"></div></div></article>
          <article class="card kpi"><div class="kpi-top"><span>Passages / Week</span><strong>—</strong></div><div class="spark" data-points=""></div></article>
          <article class="card kpi"><div class="kpi-top"><span>Practice Tests</span><strong>—</strong></div><div class="bar"><div class="bar-fill" style="--v:0%"></div></div></article>
        </div>

        <div class="grid two">
          <article class="card gauge"><header>Overall Test Score Rate</header><svg class="gauge-svg" viewBox="0 0 120 60" data-value="0" data-good="80" data-warn="60"></svg><footer class="gauge-legend"><span class="legend l--bad">Off Track</span><span class="legend l--warn">Behind</span><span class="legend l--good">Ahead</span></footer></article>
          <article class="card gauge"><header>Time on ACT Reading</header><svg class="gauge-svg" viewBox="0 0 120 60" data-value="0" data-good="90" data-warn="60" data-mode="time" data-minutes="0"></svg><footer class="gauge-legend"><span class="legend l--bad">Low</span><span class="legend l--warn">OK</span><span class="legend l--good">Great</span></footer></article>
        </div>

        <section class="quick-cards">
          <article class="qc"><svg class="gauge-svg" viewBox="0 0 120 60" data-value="0" data-good="80" data-warn="60"></svg><div class="qc-title">Quiz Scores</div><div class="qc-sub">avg. accuracy</div></article>
          <article class="qc"><svg class="gauge-svg" viewBox="0 0 120 60" data-value="0" data-good="90" data-warn="60" data-mode="number" data-number="0"></svg><div class="qc-title">Video Tutorials</div><div class="qc-sub">videos watched</div></article>
          <article class="qc"><svg class="gauge-svg" viewBox="0 0 120 60" data-value="0" data-good="75" data-warn="50"></svg><div class="qc-title">Reading Drills</div><div class="qc-sub">weekly activity</div></article>
          <article class="qc"><svg class="gauge-svg" viewBox="0 0 120 60" data-value="0" data-good="75" data-warn="50"></svg><div class="qc-title">Flash Cards</div><div class="qc-sub">weekly activity</div></article>
          <article class="qc"><svg class="gauge-svg" viewBox="0 0 120 60" data-value="0" data-good="80" data-warn="60"></svg><div class="qc-title">ACT Guide Book</div><div class="qc-sub">completion</div></article>
        </section>
      </section>
    </div>

    <!-- ===== Science Content ===== -->
    <div id="scienceContent" class="subject-content" hidden>
      <section class="actx wrap">
        <header class="actx-head">
          <div class="chip"><span class="chip-icon">🔬</span><span class="chip-text">ACT Science — Performance Tracker</span></div>
          <div id="trackPillSci" class="pill pill--neutral">Calculating status…</div>
        </header>

        <div class="grid kpis">
          <article class="card kpi"><div class="kpi-top"><span>Overall Score</span><strong>—</strong></div><div class="spark" data-points=""></div></article>
          <article class="card kpi"><div class="kpi-top"><span>Accuracy</span><strong>—</strong></div><div class="bar bar--accent"><div class="bar-fill" style="--v:0%"></div></div></article>
          <article class="card kpi"><div class="kpi-top"><span>Experiments / Week</span><strong>—</strong></div><div class="spark" data-points=""></div></article>
          <article class="card kpi"><div class="kpi-top"><span>Practice Tests</span><strong>—</strong></div><div class="bar"><div class="bar-fill" style="--v:0%"></div></div></article>
        </div>

        <div class="grid two">
          <article class="card gauge"><header>Overall Test Score Rate</header><svg class="gauge-svg" viewBox="0 0 120 60" data-value="0" data-good="80" data-warn="60"></svg><footer class="gauge-legend"><span class="legend l--bad">Off Track</span><span class="legend l--warn">Behind</span><span class="legend l--good">Ahead</span></footer></article>
          <article class="card gauge"><header>Time on ACT Science</header><svg class="gauge-svg" viewBox="0 0 120 60" data-value="0" data-good="90" data-warn="60" data-mode="time" data-minutes="0"></svg><footer class="gauge-legend"><span class="legend l--bad">Low</span><span class="legend l--warn">OK</span><span class="legend l--good">Great</span></footer></article>
        </div>

        <section class="quick-cards">
          <article class="qc"><svg class="gauge-svg" viewBox="0 0 120 60" data-value="0" data-good="80" data-warn="60"></svg><div class="qc-title">Quiz Scores</div><div class="qc-sub">avg. accuracy</div></article>
          <article class="qc"><svg class="gauge-svg" viewBox="0 0 120 60" data-value="0" data-good="90" data-warn="60" data-mode="number" data-number="0"></svg><div class="qc-title">Video Tutorials</div><div class="qc-sub">videos watched</div></article>
          <article class="qc"><svg class="gauge-svg" viewBox="0 0 120 60" data-value="0" data-good="75" data-warn="50"></svg><div class="qc-title">Science Drills</div><div class="qc-sub">weekly activity</div></article>
          <article class="qc"><svg class="gauge-svg" viewBox="0 0 120 60" data-value="0" data-good="75" data-warn="50"></svg><div class="qc-title">Flash Cards</div><div class="qc-sub">weekly activity</div></article>
          <article class="qc"><svg class="gauge-svg" viewBox="0 0 120 60" data-value="0" data-good="80" data-warn="60"></svg><div class="qc-title">ACT Guide Book</div><div class="qc-sub">completion</div></article>
        </section>
      </section>
    </div>

    <!-- ===== College & Career Readiness Content (NEW) ===== -->
    <div id="ccrContent" class="subject-content" hidden>
      <section class="actx wrap">
        <header class="actx-head">
          <div class="chip"><span class="chip-icon">🎯</span><span class="chip-text">College &amp; Career Readiness — Performance Tracker</span></div>
          <div id="trackPillCcr" class="pill pill--neutral">Calculating status…</div>
        </header>

        <div class="grid kpis">
          <article class="card kpi"><div class="kpi-top"><span>Overall Score</span><strong>—</strong></div><div class="spark" data-points=""></div></article>
          <article class="card kpi"><div class="kpi-top"><span>Accuracy</span><strong>—</strong></div><div class="bar bar--accent"><div class="bar-fill" style="--v:0%"></div></div></article>
          <article class="card kpi"><div class="kpi-top"><span>Practice Work</span><strong>—</strong></div><div class="bar"><div class="bar-fill" style="--v:0%"></div></div></article>
          <article class="card kpi"><div class="kpi-top"><span>Questions / Week</span><strong>—</strong></div><div class="spark" data-points=""></div></article>
        </div>

        <div class="grid two">
          <article class="card gauge"><header>Overall Readiness Rate</header><svg class="gauge-svg" viewBox="0 0 120 60" data-value="0" data-good="80" data-warn="60"></svg><footer class="gauge-legend"><span class="legend l--bad">Off Track</span><span class="legend l--warn">Behind</span><span class="legend l--good">Ahead</span></footer></article>
          <article class="card gauge"><header>Time on CCR</header><svg class="gauge-svg" viewBox="0 0 120 60" data-value="0" data-good="90" data-warn="60" data-mode="time" data-minutes="0"></svg><footer class="gauge-legend"><span class="legend l--bad">Low</span><span class="legend l--warn">OK</span><span class="legend l--good">Great</span></footer></article>
        </div>

        <section class="quick-cards">
          <article class="qc"><svg class="gauge-svg" viewBox="0 0 120 60" data-value="0" data-good="80" data-warn="60"></svg><div class="qc-title">Quiz Scores</div><div class="qc-sub">avg. accuracy</div></article>
          <article class="qc"><svg class="gauge-svg" viewBox="0 0 120 60" data-value="0" data-good="90" data-warn="60" data-mode="number" data-number="0"></svg><div class="qc-title">Video Tutorials</div><div class="qc-sub">videos watched</div></article>
          <!--<article class="qc"><svg class="gauge-svg" viewBox="0 0 120 60" data-value="0" data-good="75" data-warn="50"></svg><div class="qc-title">College Prep</div><div class="qc-sub">weekly activity</div></article>-->
          <article class="qc"><svg class="gauge-svg" viewBox="0 0 120 60" data-value="0" data-good="75" data-warn="50"></svg><div class="qc-title">Flash Cards</div><div class="qc-sub">weekly activity</div></article>
          <article class="qc"><svg class="gauge-svg" viewBox="0 0 120 60" data-value="0" data-good="80" data-warn="60"></svg><div class="qc-title">Milestones</div><div class="qc-sub">completion</div></article>
        </section>
      </section>
    </div>
  </div>
</div>

<!-- ======================= JS: toggle + gauges/sparklines ======================= -->
<!-- ======================= JS: toggle + gauges/sparklines ======================= -->
<script>
/*
  Dashboard script with flashcard totals (all-time).
  - Expects server to provide:
      window.STUDENT_METRICS  (per-subject metrics)
      window.FLASHCARD_METRICS (this script will populate it via blade json)
*/

window.STUDENT_METRICS = window.STUDENT_METRICS || {};

window.FLASHCARD_METRICS = {
  total_system: @json($flashcards_total_system ?? 0),
  views_total_all: @json($flashcard_views_total_all ?? 0),
  distinct_seen_all: @json($flashcards_distinct_seen_all ?? 0),
  user_seen_distinct: @json($user_seen_distinct ?? 0),
  user_seen_count: @json($user_seen_count ?? 0)
};

(function(){
  const MET = (window.STUDENT_METRICS && typeof window.STUDENT_METRICS === 'object') ? window.STUDENT_METRICS : {};
  const FLASH = (window.FLASHCARD_METRICS && typeof window.FLASHCARD_METRICS === 'object') ? window.FLASHCARD_METRICS : {};

  // ---------- utilities ----------
  const setText = (el, v, suffix='') => {
    if (!el) return;
    const hasValue = v === 0 || (v !== null && v !== undefined && v !== '');
    el.textContent = hasValue ? `${v}${suffix}` : '—';
  };

  // format minutes -> "X hr Y min"
  const formatHM = (mins=0) => {
    mins = Math.max(0, +mins|0);
    const h = Math.floor(mins/60), m = mins % 60;
    return h ? `${h} hr ${m} min` : `${m} min`;
  };

  // small sparkline renderer
  function renderSparklines(scope){
    document.querySelectorAll(scope+' .spark').forEach(el=>{
      const pts = (el.dataset.points||'').split(',').map(n=>+n).filter(n=>!Number.isNaN(n));
      if(!pts.length){ el.innerHTML=''; return; }
      const w = el.clientWidth || 220, h = el.clientHeight || 28;
      const min = Math.min(...pts), max = Math.max(...pts);
      const nx = i => (i/(pts.length-1))*w, ny = v => h - ((v-min)/(max-min||1))*h;
      const d  = pts.map((v,i)=> (i?'L':'M') + nx(i) + ' ' + ny(v)).join(' ');
      const NS = 'http://www.w3.org/2000/svg';
      const svg = document.createElementNS(NS,'svg');
      svg.setAttribute('viewBox',`0 0 ${w} ${h}`); svg.setAttribute('width','100%'); svg.setAttribute('height','100%');
      const path = document.createElementNS(NS,'path'); path.setAttribute('d', d); path.setAttribute('fill','none'); path.setAttribute('stroke','#5d6cf6'); path.setAttribute('stroke-width','2');
      const fill = document.createElementNS(NS,'path'); fill.setAttribute('d', d + ` L ${w} ${h} L 0 ${h} Z`); fill.setAttribute('fill','rgba(93,108,246,.18)');
      el.innerHTML=''; svg.appendChild(fill); svg.appendChild(path); el.appendChild(svg);
    });
  }

  // semicircle gauge renderer with label modes
  function renderGauges(scope){
    const list = (typeof scope === 'string') ? document.querySelectorAll(scope+' .gauge-svg')
                                             : (scope.querySelectorAll ? scope.querySelectorAll('.gauge-svg') : []);
    list.forEach(svg=>{
      const val  = Math.max(0, Math.min(100, +svg.dataset.value || 0));
      const good = +svg.dataset.good || 80;
      const warn = +svg.dataset.warn || 60;

      const mode    = svg.dataset.mode || 'percent';  // 'percent' | 'time' | 'number'
      const minutes = +svg.dataset.minutes || 0;
      const number  = svg.dataset.number;

      const NS='http://www.w3.org/2000/svg';
      const arc=(p,r=50,cx=60,cy=60)=>{const a=Math.PI*(1-p);return [cx+r*Math.cos(a), cy+r*Math.sin(a)]};
      const mkPath=p=>{const [x1,y1]=arc(0),[x2,y2]=arc(p);const large=p>0.5?1:0;return `M ${x1} ${y1} A 50 50 0 ${large} 1 ${x2} ${y2}`;}
      while (svg.firstChild) svg.removeChild(svg.firstChild);

      const bg=document.createElementNS(NS,'path');
      bg.setAttribute('d',mkPath(1));
      bg.setAttribute('fill','none'); bg.setAttribute('stroke','#e9eef6'); bg.setAttribute('stroke-width','10');
      svg.appendChild(bg);

      const color = val>=good ? '#2cb66d' : val>=warn ? '#f3a43a' : '#ef4444';
      const fg=document.createElementNS(NS,'path');
      fg.setAttribute('d',mkPath(val/100));
      fg.setAttribute('fill','none'); fg.setAttribute('stroke',color);
      fg.setAttribute('stroke-linecap','round'); fg.setAttribute('stroke-width','10');
      svg.appendChild(fg);

      const [dx,dy]=arc(val/100);
      const dot=document.createElementNS(NS,'circle');
      dot.setAttribute('cx',dx); dot.setAttribute('cy',dy);
      dot.setAttribute('r','3.5'); dot.setAttribute('fill',color);
      svg.appendChild(dot);

      const txt=document.createElementNS(NS,'text');
      txt.setAttribute('x','60'); txt.setAttribute('y','55');
      txt.setAttribute('text-anchor','middle'); txt.setAttribute('font-size','10'); txt.setAttribute('font-weight','700');

      if (mode === 'time')      txt.textContent = formatHM(minutes);
      else if (mode === 'number') txt.textContent = (number ?? 0);
      else                        txt.textContent = val + '%';

      svg.appendChild(txt);
    });
  }

  // map subject metrics to the 6 quick gauges
   function fillQuickCards(panelSelector, m){
    const pctFromScore36 = (s)=> s ? Math.round((s/36)*100) : 0;
    const pctFromWeekly = (w, cap=200)=> w ? Math.min(100, Math.round((w/cap)*100)) : 0;

    const values = [
      m?.accuracy ?? 0,                 // Quiz Scores (card 0)
      pctFromScore36(m?.score ?? 0),    // Test Score (card 1)
      m?.time_pct ?? 0,                 // Video percent fallback (card 2)
      pctFromWeekly(m?.questions_week), // Drills proxy (card 3)
      pctFromWeekly(m?.questions_week), // Flash Cards proxy (card 4)
      pctFromWeekly(m?.questions_week)  // Guide Book proxy (card 5)
    ];

    // set basic percent mode for all gauges (fallback)
    const svgs = Array.from(document.querySelectorAll(panelSelector+' .quick-cards .gauge-svg') || []);
    svgs.forEach((svg, i)=>{
      svg.dataset.value = values[i] || 0;
      svg.dataset.mode = 'percent';
      svg.removeAttribute('data-number');
      svg.removeAttribute('data-minutes');
    });

    // Instead of using fixed indices, find the card by its title text so ordering won't break.
    const findSvgByTitle = (title) => {
      const cards = document.querySelectorAll(panelSelector + ' .quick-cards .qc');
      for (const card of cards) {
        const t = (card.querySelector('.qc-title') || {}).textContent || '';
        if (t.trim().toLowerCase() === title.trim().toLowerCase()) {
          return card.querySelector('.gauge-svg');
        }
      }
      return null;
    };

    // VIDEO: show videos watched as number on the card titled "Video Tutorials"
    const videoSvg = findSvgByTitle('Video Tutorials') || svgs[1] || null;
    if (videoSvg) {
      videoSvg.dataset.mode = 'number';
      const vids = (m?.videos_watched ?? m?.video_views ?? 0);
      videoSvg.dataset.number = vids;
    }

    // FLASHCARDS: show explicit distinct seen numbers on "Flash Cards" card
    const flashSvg = findSvgByTitle('Flash Cards') || svgs[3] || null;
    if (flashSvg) {
      flashSvg.dataset.mode = 'number';
      // prefer per-user metric from subject, fallback to global FLASH object
      const primary = (m?.flashcards_total_user_distinct ?? m?.flashcards_seen ?? FLASH.user_seen_distinct ?? FLASH.user_seen_distinct ?? 0);
      flashSvg.dataset.number = primary;
      // update subtext (if element with id flashcardsSub exists)
      const sub = document.getElementById('flashcardsSub');
      if (sub) {
        sub.textContent = `You: ${FLASH.user_seen_distinct ?? 0} seen • All: ${FLASH.distinct_seen_all ?? 0} total • Views: ${FLASH.views_total_all ?? 0}`;
      }
    }

    // finally render gauges so they pick up changes
    renderGauges(panelSelector+' .quick-cards');
  }

  // ---------- ENGLISH panel ----------
  const englishTile    = document.getElementById('englishTile');
  const englishContent = document.getElementById('englishContent');

  function openEnglish(){
    document.querySelectorAll('.subject-content').forEach(c => c.setAttribute('hidden',''));
    englishContent.removeAttribute('hidden');
    englishTile.setAttribute('aria-expanded','true');
    setTimeout(()=> englishContent.scrollIntoView({behavior:'smooth', block:'start'}), 0);
    if (!englishContent.dataset.inited){ initEnglishDashboard(); englishContent.dataset.inited = '1'; }
  }
  function handleActivate(e){
    if (e.type==='click' || (e.type==='keydown' && (e.key==='Enter' || e.key===' '))){ e.preventDefault(); openEnglish(); }
  }
  if (englishTile) {
    englishTile.addEventListener('click', handleActivate);
    englishTile.addEventListener('keydown', handleActivate);
  }

  function initEnglishDashboard(){
    const m = MET.english || {};
    setText(document.getElementById('kpiScore'),     m.score);
    setText(document.getElementById('kpiAccuracy'),  m.accuracy, '%');
    setText(document.getElementById('kpiTime'),      formatHM(m.time_minutes));
    setText(document.getElementById('kpiTests'),     m.tests);
    setText(document.getElementById('kpiQ'),         m.questions_week);

    const pill = document.getElementById('trackPill');
    const state = (m.status === 'good') ? 'good' : (m.status === 'bad') ? 'bad' : 'warn';
    if (pill) {
      pill.className = 'pill pill--' + state;
      pill.textContent = state==='good' ? 'Ahead of Schedule' : state==='bad' ? 'Off Track' : 'Behind Schedule';
    }

    // update progress bar width for accuracy card if present
    const accBar = document.querySelector('#englishContent .bar-fill');
    if (accBar && (m.accuracy || m.accuracy===0)) accBar.style.setProperty('--v', (m.accuracy)+'%');

    // spark + gauges
    document.querySelectorAll('#englishContent .spark').forEach(el=>{ el.dataset.points=(m.spark||[]).join(','); });
    const gauges = document.querySelectorAll('#englishContent .gauge-svg');
    if (gauges[0]) gauges[0].dataset.value = (m.accuracy ?? 0);
    if (gauges[1]) {
      gauges[1].dataset.value   = (m.time_pct ?? 0); // arc
      gauges[1].dataset.mode    = 'time';            // label -> hr:min
      gauges[1].dataset.minutes = (m.time_minutes || 0);
    }

    renderGauges('#englishContent');
    renderSparklines('#englishContent');
    fillQuickCards('#englishContent', m);
  }

  // ---------- generic binder for the other panels ----------
  function bindPanel(tileId, panelId, metricsKey, pillId){
    const t = document.getElementById(tileId);
    const p = document.getElementById(panelId);

    const open = e => {
      e.preventDefault();
      document.querySelectorAll('.subject-content').forEach(c => c.setAttribute('hidden',''));
      p.removeAttribute('hidden');
      // set aria-expanded on tiles (optional)
      document.querySelectorAll('.sd-tile').forEach(el => el.setAttribute('aria-expanded','false'));
      if (t) t.setAttribute('aria-expanded','true');
      setTimeout(()=> p.scrollIntoView({behavior:'smooth', block:'start'}), 0);
      if(!p.dataset.inited){ init(); p.dataset.inited='1'; }
    };
    if (t) {
      t.addEventListener('click', open);
      t.addEventListener('keydown', e => { if(e.key==='Enter' || e.key===' ') open(e); });
    }

    function init(){
      const m = MET[metricsKey] || {};
      // find the KPI strong elements (assuming same order as template)
      const strongs = p.querySelectorAll('.kpi strong');
      const scoreEl = strongs[0] || null;
      const accEl   = strongs[1] || null;

      setText(scoreEl, m.score);
      setText(accEl,  m.accuracy, '%');
      // If your markup differs, these mappings can be adapted per-panel
      p.querySelectorAll('.kpi').forEach((card, idx)=>{
        const strong = card.querySelector('strong');
        if (!strong) return;
        if (idx===0) setText(strong, m.score);
        else if (idx===1) setText(strong, m.accuracy, '%');
        else if (idx===2) setText(strong, m.tests);
        else if (idx===3) setText(strong, m.questions_week);
      });

      const pill = document.getElementById(pillId);
      if (pill) {
        const state = (m.status === 'good') ? 'good' : (m.status === 'bad') ? 'bad' : 'warn';
        pill.className = 'pill pill--' + state;
        pill.textContent = state==='good' ? 'Ahead of Schedule' : state==='bad' ? 'Off Track' : 'Behind Schedule';
      }

      // update accuracy bar if exists
      const accBar = p.querySelector('.bar-fill');
      if (accBar && (m.accuracy || m.accuracy===0)) accBar.style.setProperty('--v', (m.accuracy)+'%');

      p.querySelectorAll('.spark').forEach(el=>{ el.dataset.points=(m.spark||[]).join(','); });

      const gauges = p.querySelectorAll('.gauge-svg');
      if (gauges[0]) gauges[0].dataset.value = (m.accuracy ?? 0);
      if (gauges[1]) {
        gauges[1].dataset.value   = (m.time_pct ?? 0);
        gauges[1].dataset.mode    = 'time';
        gauges[1].dataset.minutes = (m.time_minutes || 0);
      }

      renderGauges('#'+panelId);
      renderSparklines('#'+panelId);
      fillQuickCards('#'+panelId, m);
    }
  }

  // Bind the other panels (math/reading/science)
  bindPanel('mathTile',    'mathContent',    'math',    'trackPillMath');
  bindPanel('readingTile', 'readingContent', 'reading', 'trackPillRead');
  bindPanel('scienceTile', 'scienceContent', 'science', 'trackPillSci');

  // Bind the new College & Career Readiness panel (metrics key = college_career_readiness)
  bindPanel('ccrTile', 'ccrContent', 'college_career_readiness', 'trackPillCcr');

  // If you want the dashboard to pre-open English on load (optional), uncomment:
  // openEnglish();

})();

</script>


