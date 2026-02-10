{{-- resources/views/students-quickview.blade.php --}}
@php
  $title = 'STUDENTS QUICKVIEW';
@endphp
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8"/>
  <meta name="viewport" content="width=device-width, initial-scale=1"/>
  <title>{{ $title }}</title>
  <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;600;700;800&display=swap" rel="stylesheet">
  <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

  <style>
    :root{
      --ink:#222831; --ink-dim:#4b5563; --muted:#9aa3af; --line:#e5e7eb; --surface:#f7f8fa;
      --white:#fff; --home:#3b82f6; --good:#51c351; --radius:18px;
    }
    *{box-sizing:border-box}
    body{margin:0;background:#f1f3f6;font-family:Inter,system-ui,-apple-system,Segoe UI,Roboto,Arial,sans-serif;color:var(--ink)}
    .wrap{margin:0 auto}
    .card{background:var(--white);border-radius:var(--radius);box-shadow:0 6px 16px rgba(0,0,0,.06);border:1px solid var(--line)}
    header{display:flex;align-items:center;justify-content:space-between;margin-bottom:14px}
    .title{font-weight:800;letter-spacing:.5px;font-size:28px;color:#344054}
    .toolbar{display:flex;gap:12px;align-items:center}
    .search{position:relative}
    .search input{height:36px;border:1px solid var(--line);border-radius:10px;padding:0 34px 0 12px;outline:none;background:#fff;min-width:280px}
    .search svg{position:absolute;right:10px;top:50%;transform:translateY(-50%);width:18px;height:18px;color:var(--muted)}
    .icon-btn{display:inline-grid;place-items:center;width:36px;height:36px;border:1px solid var(--line);border-radius:10px;background:#fff;cursor:pointer}

    .panel{padding:18px}
    .headline{font-size:20px;color:#4b5563;margin:0 0 18px}

    /* quick stats */
    .stats{display:grid;grid-template-columns:repeat(3,1fr);gap:18px;margin-bottom:8px}
    .stat{display:flex;align-items:center;gap:14px;border-right:1px solid var(--line);padding-right:14px}
    .stat:last-child{border-right:0}
    .stat .glyph{flex:0 0 44px;height:44px;border-radius:12px;display:grid;place-items:center;background:var(--surface)}
    .stat .big{font-size:34px;font-weight:800;line-height:1}
    .stat .sub{font-size:12px;letter-spacing:.4px;color:var(--ink-dim);text-transform:uppercase}

    /* charts */
    .charts{display:grid;grid-template-columns:360px 1fr;gap:22px;margin-top:14px;min-width:0}
    .chart-card{padding:16px;min-width:0;overflow:hidden}
    .chart-area{position:relative;width:100%;min-width:0}
    .chart-area canvas{display:block;width:100% !important;height:220px !important}
    .legend{margin-top:6px}
    .legend li{display:flex;align-items:center;gap:10px;margin:10px 0;color:#475569}
    .legend .sw{width:12px;height:12px;border-radius:3px;display:inline-block}
    .legend .pct{margin-left:auto;color:#111827;font-weight:700}
    .muted{color:#9aa3af}

    /* students table (new design) */
    .students{margin-top:18px}
    .students-head{display:flex;justify-content:space-between;align-items:center;margin-bottom:8px}
    .pill{font-size:12px;border:1px solid var(--line);border-radius:8px;padding:6px 10px;background:#fff}
    .students-table{width:100%;border-collapse:separate;border-spacing:0 10px}
    .students-table thead th{
      font-size:11px;letter-spacing:.06em;text-transform:uppercase;color:#64748b;
      font-weight:700;padding:0 16px 4px;white-space:nowrap
    }
    .students-table tbody tr{background:#f3f4f6;transition:.15s}
    .students-table tbody tr:hover{background:#e9eaee}
    .students-table td{padding:14px 16px;vertical-align:middle}
    .students-table td:first-child{border-top-left-radius:12px;border-bottom-left-radius:12px}
    .students-table td:last-child{border-top-right-radius:12px;border-bottom-right-radius:12px}
    .td-right{text-align:right}
    .name{font-weight:700;color:#2563eb;text-decoration:none}
    .dash{color:#9aa3af}

    @media (max-width:1020px){
      .stats{grid-template-columns:1fr}
      .stat{border-right:0;border-bottom:1px solid var(--line);padding-bottom:14px}
      .stat:last-child{border-bottom:0}
      .charts{grid-template-columns:1fr}
      .students-table thead{display:none}
      .students-table, .students-table tbody, .students-table tr, .students-table td{display:block;width:100%}
      .students-table tbody tr{border-radius:12px}
      .students-table td{display:flex;justify-content:space-between;gap:10px}
      .students-table td::before{
        content:attr(data-col);color:#6b7280;font-size:12px;text-transform:uppercase;letter-spacing:.04em
      }
      .td-right{text-align:left}
    }
  </style>
</head>
<body>
<div class="wrap">

  <header>
    <div class="title">{{ $title }}</div>
    <div class="toolbar">
      <div class="search">
        <input type="text" placeholder="Looking for a specific student?">
        <svg viewBox="0 0 24 24" fill="none"><path d="m21 21-4.5-4.5m1.5-4.5a6 6 0 1 1-12 0 6 6 0 0 1 12 0Z" stroke="currentColor" stroke-width="1.6" stroke-linecap="round"/></svg>
      </div>
      <button class="icon-btn" title="Print">
        <svg viewBox="0 0 24 24" width="18" height="18" fill="none">
          <path d="M6 9V4h12v5M6 18h12v2H6v-2Z" stroke="currentColor" stroke-width="1.6"/>
          <rect x="4" y="9" width="16" height="8" rx="2" stroke="currentColor" stroke-width="1.6"/>
        </svg>
      </button>
    </div>
  </header>

  <section class="card panel">
    <h3 class="headline">In the last 30 days, your students have…</h3>

    <div class="stats">
      <div class="stat">
        <div class="glyph">
          <svg width="22" height="22" viewBox="0 0 24 24" fill="none">
            <path d="M4 17l6-6 4 4 6-6" stroke="#111827" stroke-width="1.6" stroke-linecap="round"/>
            <path d="M4 21h16" stroke="#9ca3af" stroke-width="1.6"/>
          </svg>
        </div>
        <div>
          <div class="big">{{ number_format($stats['answered'] ?? 0) }}</div>
          <div class="sub">Answered Questions</div>
        </div>
      </div>

      <div class="stat">
        <div class="glyph">
          <svg width="22" height="22" viewBox="0 0 24 24" fill="none">
            <circle cx="12" cy="12" r="8" stroke="#111827" stroke-width="1.6"/>
            <path d="M12 8v5l3 2" stroke="#111827" stroke-width="1.6" stroke-linecap="round"/>
          </svg>
        </div>
        <div>
          <div class="big">{{ $stats['spent'] ?? '0 hr 0 min' }}</div>
          <div class="sub">Spent Practicing</div>
        </div>
      </div>

      <div class="stat">
        <div class="glyph">
          <svg width="22" height="22" viewBox="0 0 24 24" fill="none">
            <path d="M10 4 4 10l6 6 6-6-6-6Zm6 6 4 4" stroke="#111827" stroke-width="1.6" stroke-linecap="round" stroke-linejoin="round"/>
          </svg>
        </div>
        <div>
          <div class="big">{{ number_format($stats['skills_progressed'] ?? 0) }}</div>
          <div class="sub">Made Progress in Skills</div>
        </div>
      </div>
    </div>

    <div class="charts">
      {{-- Practice by Category --}}
      <div class="card chart-card">
        <div class="headline" style="margin:0 0 6px">
          Practice by Category <small class="muted">(share of tests)</small>
        </div>
        <div class="chart-area"><canvas id="catChart"></canvas></div>

        <ul class="legend">
          @php $legendColors=['#22c55e','#06b6d4','#f59e0b','#60a5fa','#a78bfa','#6b7280']; @endphp
          @forelse(($categories ?? []) as $i => $cat)
            <li>
              <span class="sw" style="background:{{ $legendColors[$i % count($legendColors)] }}"></span>
              <span>{{ $cat['label'] }}</span>
              <span class="pct">{{ $cat['pct'] }}%</span>
            </li>
          @empty
            <li><span class="pct">No data</span></li>
          @endforelse
        </ul>
      </div>

      {{-- Practice by Day --}}
      <div class="card chart-card">
        <div class="headline" style="margin:0 0 6px">Practice by Day</div>
        <div class="muted" style="margin-bottom:6px;font-size:12px">
          <span style="display:inline-flex;align-items:center;gap:6px">
            <i class="sw" style="background:var(--home)"></i> All students
          </span>
        </div>
        <div class="chart-area"><canvas id="dayChart"></canvas></div>
      </div>
    </div>

    {{-- Students table --}}
    <section class="card panel students">
      <div class="students-head">
        <div class="headline" style="margin:0">Students</div>
        <div style="display:flex;gap:10px;align-items:center">
          <!-- WORKING FILTERS -->
          <select class="pill" id="sortSelect">
            <option value="name_asc">Sort by: Name (A–Z)</option>
            <option value="name_desc">Name (Z–A)</option>
            <option value="questions_desc">Questions (High→Low)</option>
            <option value="time_desc">Time Spent (High→Low)</option>
            <option value="last_desc">Last Practiced (Newest)</option>
            <option value="last_asc">Last Practiced (Oldest)</option>
          </select>

          <select class="pill" id="weekSelect">
            <option value="">Show: All time</option>
            {{-- week options will be injected by JS --}}
          </select>
        </div>
      </div>

      <table class="students-table">
        <thead>
          <tr>
            <th>Name</th>
            <th class="td-right">Total Questions</th>
            <th class="td-right">Total Time Spent</th>
            <th class="td-right">Last Practiced</th>
          </tr>
        </thead>
        <tbody>
        @foreach($schoolAdminStudents as $s)
          @php
            $name = trim($s->display_name ?: $s->user_login);
            $tSecs = (int) ($s->total_time_sec ?? 0);
            $hours = (int) floor($tSecs / 3600);
            $mins  = (int) floor(($tSecs % 3600) / 60);
            $timeHuman = $tSecs > 0 ? sprintf('%d hr %d min', $hours, $mins) : '—';
            $lastPracticed = !empty($s->last_practiced_at) ? \Carbon\Carbon::parse($s->last_practiced_at) : null;
          @endphp
          <tr class="student-row"
              data-name="{{ strtolower($name) }}"
              data-questions="{{ (int) ($s->total_questions ?? 0) }}"
              data-seconds="{{ $tSecs }}"
              data-last="{{ $lastPracticed ? $lastPracticed->toDateString() : '' }}">
            <td data-col="Name">
              <span class="name">{{ $name }}</span>
            </td>
            <td data-col="Total Questions" class="td-right">
              {{ number_format((int) ($s->total_questions ?? 0)) }}
            </td>
            <td data-col="Total Time Spent" class="td-right">
              {!! $tSecs > 0 ? e($timeHuman) : '<span class="dash">—</span>' !!}
            </td>
            <td data-col="Last Practiced" class="td-right">
              @if($lastPracticed)
                <span title="{{ $lastPracticed->format('d M Y, h:i A') }}">{{ $lastPracticed->diffForHumans() }}</span>
              @else
                <span class="dash">—</span>
              @endif
            </td>
          </tr>
        @endforeach
        </tbody>
      </table>
    </section>

  </section>
</div>

<script>
  // ---------- Category doughnut ----------
  const catEl = document.getElementById('catChart');
  if (catEl) {
    const cats = @json($categories ?? []);
    const labels = cats.map(c => c.label);
    const counts = cats.map(c => c.count);
    const colors = ['#22c55e','#06b6d4','#f59e0b','#60a5fa','#a78bfa','#6b7280'];
    const bg = labels.map((_,i)=>colors[i%colors.length]);

    new Chart(catEl.getContext('2d'), {
      type: 'doughnut',
      data: { labels, datasets: [{ data: counts, backgroundColor: bg, borderColor: '#fff', borderWidth: 2, hoverOffset: 4 }] },
      options: { cutout: '68%', plugins: { legend: { display:false } } }
    });
  }

  // ---------- Practice by day (BAR) ----------
  (function () {
    const el = document.getElementById('dayChart');
    if (!el) return;

    const labels = @json($byDayLabels ?? []);
    const totalsRaw = @json($byDayTotals ?? []);
    if (!labels.length) return;

    const totals = (totalsRaw || []).map(v => Number(v) || 0);
    const css = getComputedStyle(document.documentElement);
    let color = (css.getPropertyValue('--home') || '').trim();
    if (!color) color = '#3b82f6';

    const ctx = el.getContext('2d');
    if (el._chart) { el._chart.destroy(); }

    el._chart = new Chart(ctx, {
      type: 'bar',
      data: {
        labels,
        datasets: [{
          label: 'All students',
          data: totals,
          backgroundColor: color,
          borderColor: color,
          borderWidth: 1.5,
          borderRadius: 6,
          maxBarThickness: 18,
          barPercentage: 0.8,
          categoryPercentage: 0.9
        }]
      },
      options: {
        responsive: true,
        maintainAspectRatio: true,
        plugins: {
          legend: { display: false },
          tooltip: { callbacks: { label: (ctx) => `${ctx.parsed.y ?? 0} questions` } }
        },
        scales: {
          x: { grid: { display: false }, ticks: { autoSkip: true, maxRotation: 0, minRotation: 0 } },
          y: {
            beginAtZero: true,
            grid: { color: '#eef0f3' },
            ticks: { callback: (val) => Number.isInteger(val) ? val : '' }
          }
        }
      }
    });
  })();

  // ---------- Students table: Sort + Week filters ----------
  document.addEventListener('DOMContentLoaded', function () {
    const tbody    = document.querySelector('.students-table tbody');
    const rows     = Array.from(tbody.querySelectorAll('.student-row'));
    const sortSel  = document.getElementById('sortSelect');
    const weekSel  = document.getElementById('weekSelect');

    // Build last 12 weeks (Mon–Sun)
    (function buildWeeks(){
      if (!weekSel) return;

      const fmt = (d) => d.toLocaleDateString(undefined, { month: 'short', day: 'numeric' });
      const pad = (n) => String(n).padStart(2, '0');
      const toISO = (d) => `${d.getFullYear()}-${pad(d.getMonth()+1)}-${pad(d.getDate())}`;
      const startOfWeek = (date) => {
        const d = new Date(date.getFullYear(), date.getMonth(), date.getDate());
        const weekdayMon0 = (d.getDay() + 6) % 7; // Monday=0
        d.setDate(d.getDate() - weekdayMon0);
        d.setHours(0,0,0,0);
        return d;
      };

      const today = new Date();
      let start = startOfWeek(today);
      for (let i = 0; i < 12; i++) {
        const end = new Date(start); end.setDate(end.getDate() + 6);
        const opt = document.createElement('option');
        opt.value = toISO(start); // YYYY-MM-DD
        opt.textContent = `Week of ${fmt(start)} – ${fmt(end)}`;
        weekSel.appendChild(opt);
        start.setDate(start.getDate() - 7);
      }
    })();

    function apply() {
      // Filter by week
      const weekVal = weekSel ? weekSel.value : '';
      const start = weekVal ? new Date(weekVal + 'T00:00:00') : null;
      const end   = start ? new Date(start) : null;
      if (end) end.setDate(end.getDate() + 7); // exclusive

      rows.forEach(tr => {
        const lastISO = tr.dataset.last || '';
        const last = lastISO ? new Date(lastISO + 'T00:00:00') : null;
        const show = !start || (last && last >= start && last < end);
        tr.style.display = show ? '' : 'none';
      });

      // Sort the visible rows
      const mode = sortSel ? sortSel.value : 'name_asc';
      const collator = new Intl.Collator(undefined, { sensitivity: 'base' });

      const valueOf = (tr) => ({
        name: tr.dataset.name || '',
        questions: Number(tr.dataset.questions || 0),
        seconds: Number(tr.dataset.seconds || 0),
        last: tr.dataset.last ? Date.parse(tr.dataset.last + 'T00:00:00') : 0
      });

      const visible = rows.filter(tr => tr.style.display !== 'none');
      visible.sort((a, b) => {
        const A = valueOf(a), B = valueOf(b);
        switch (mode) {
          case 'name_desc':      return collator.compare(B.name, A.name);
          case 'questions_desc': return (B.questions - A.questions) || collator.compare(A.name, B.name);
          case 'time_desc':      return (B.seconds - A.seconds)   || collator.compare(A.name, B.name);
          case 'last_desc':      return B.last - A.last;
          case 'last_asc':       return A.last - B.last;
          case 'name_asc':
          default:               return collator.compare(A.name, B.name);
        }
      });

      visible.forEach(tr => tbody.appendChild(tr));
    }

    sortSel && sortSel.addEventListener('change', apply);
    weekSel && weekSel.addEventListener('change', apply);
    apply(); // initial
  });
</script>
</body>
</html>
