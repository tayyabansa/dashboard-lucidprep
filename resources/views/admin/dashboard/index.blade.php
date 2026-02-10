@extends('admin.layouts.app')
@section('title', 'Luciderp | Dashboard')
@section('content')
<style>
/* ==== Themeable vars (tweak if your brand updates) ==== */
:root{
  --card-radius: 22px;
  --tile-min-h: 220px;
  --brand-surface: #F5F7FA;
  --ink: #101319;
  --ink-dim: #3b3f46;
  --ring: rgba(47,130,255,.25); /* LucidPrep-like blue focus */
}

/* Container + toolbar (unchanged basics) */
.student-dashboard{font-family:system-ui,-apple-system,Segoe UI,Roboto,Arial,sans-serif;color:var(--ink)}
.sd-toolbar{display:flex;align-items:center;justify-content:space-between;gap:1rem;flex-wrap:wrap}
.sd-title{
  background:#fffd66;border:1.5px solid #e7df00;padding:.7rem 1rem;border-radius:12px;
  font-weight:800;letter-spacing:.2px
}
.sd-icons{display:flex;gap:.6rem}
.sd-icon{
  display:grid;place-items:center;width:46px;height:46px;border:1px solid #e6e6e9;border-radius:12px;
  background:#fff;color:var(--ink);text-decoration:none;font-weight:700;font-size:20px;
  box-shadow:0 2px 8px rgba(16,19,25,.04)
}
.sd-icon:hover{transform:translateY(-2px);box-shadow:0 8px 20px rgba(16,19,25,.10)}
.sd-icon:focus-visible{outline:3px solid var(--ring);outline-offset:2px}

/* Grid */
.sd-grid{
  margin-top:1.25rem;display:grid;grid-template-columns:repeat(4,minmax(220px,1fr));gap:24px
}
@media (max-width:1100px){.sd-grid{grid-template-columns:repeat(2,minmax(220px,1fr))}}
@media (max-width:560px){.sd-grid{grid-template-columns:1fr}}

/* ===== Tile base ===== */
.sd-tile{
  position:relative;display:block;min-height:var(--tile-min-h);text-decoration:none;isolation:isolate;
  background:var(--brand-surface);border-radius:var(--card-radius);overflow:hidden;
  box-shadow:0 10px 30px rgba(16,19,25,.06), inset 0 1px 0 rgba(255,255,255,.6);
  transition:transform .2s ease, box-shadow .2s ease, background .2s ease;
}
.sd-tile:hover{transform:translateY(-4px);box-shadow:0 18px 40px rgba(16,19,25,.12)}
.sd-tile:focus-visible{outline:4px solid var(--ring);outline-offset:3px}

/* Inner surface + light grain */
.sd-surface{
  position:absolute;inset:0;border-radius:inherit;overflow:hidden;
  background:
     radial-gradient(1200px 400px at -20% -20%, rgba(255,255,255,.22), transparent 40%),
     radial-gradient(800px 300px at 120% 120%, rgba(0,0,0,.08), transparent 45%),
     /* subtle grain */
     repeating-linear-gradient(135deg, rgba(255,255,255,.03) 0 2px, rgba(0,0,0,.03) 2px 4px);
  backdrop-filter: saturate(115%);
}
.sd-green::after,.sd-orange::after,.sd-blue::after,.sd-purple::after{
  content:""; position:absolute; inset:1px; border-radius:calc(var(--card-radius) - 1px);
  box-shadow: inset 0 0 0 1px rgba(255,255,255,.28), inset 0 12px 28px rgba(255,255,255,.15);
}

/* Color tints to harmonize with your theme */
.sd-green{background:linear-gradient(180deg,#54cf86 0%,#1c6e39 100%)}
.sd-orange{background:linear-gradient(180deg,#f3a062 0%,#b45420 100%)}
.sd-blue{background:linear-gradient(180deg,#66c5f1 0%,#0c6a97 100%)}
.sd-purple{background:linear-gradient(180deg,#cc6aed 0%,#6d1f97 100%)}

/* SVGs fill the tile, with soft highlight */
.sd-art{position:absolute;inset:0;width:100%;height:100%;mix-blend-mode:soft-light}

/* Label + chevron */
.sd-label{
  position:absolute;left:20px;bottom:18px;z-index:2;color:#fff;text-shadow:0 2px 8px rgba(0,0,0,.35);
  font-weight:900;letter-spacing:.3px;line-height:1.05;font-size:26px
}
.sd-chevron{
  position:absolute;right:18px;bottom:14px;z-index:2;color:#fff;font-size:34px;
  text-shadow:0 2px 8px rgba(0,0,0,.35);font-weight:600;transform:translateX(0);transition:transform .2s ease
}
.sd-tile:hover .sd-chevron{transform:translateX(4px)}

    .bg-primary-soft {
  background-color: rgba(0, 123, 255, 0.1); /* light blue shade */
}

/* Title and subtitle text styling */
.welcome-title {
  font-size: 1.75rem;
  font-weight: 600;
  color: #0d427f; /* dark-blue text */
}
.welcome-subtitle {
  font-size: 1rem;
  color: #3a3a3a;
}

/* Icon wrapper to match your theme's button style */
.icon-wrapper {
  width: 48px;
  height: 48px;
  font-size: 1.25rem;
  
}

.sd-home-card {
    display: flex;
    align-items: center;
    gap: 10px;
    padding: 10px 18px;
    border-radius: 14px;
    background: rgba(255, 255, 255, 0.25);
    backdrop-filter: blur(12px);
    box-shadow: 0 4px 10px rgba(0,0,0,0.08);
    border: 1px solid rgba(255, 255, 255, 0.4);
    font-weight: 700;
    font-size: 16px;
    color: #222;
    transition: all 0.2s ease;
}
.sd-home-card:hover {
    transform: translateY(-2px);
    box-shadow: 0 8px 20px rgba(0,0,0,0.12);
}

.sd-home-icon {
    font-size: 20px;
}

.sd-home-text {
    letter-spacing: 0.3px;
}

</style>
<div class="content-body">
    <!-- row -->
    <div class="container-fluid">
      @if ($isAdmin)

        <div class="row">
            <div class="col-xl-4 col-xxl-4 col-sm-6">
                <div class="widget-stat card bg-primary">
                    <div class="card-body">
                        <div class="media">
                            <span class="me-3">
                                <i class="la la-users"></i>
                            </span>
                            <div class="media-body text-white">
                                <p class="mb-1">Total Students</p>
                                <h3 class="text-white">{{ count($totalStudents) }}</h3>
                                <div class="progress mb-2 bg-white">
                                    <div class="progress-bar progress-animated bg-white" style="width: {{ $percentageIncrease20 }}%"></div>
                                </div>
                                <small>{{ $percentageIncrease20 }}% Increase in Last 20 Days</small>
                            </div>
                        </div>
                        
                    </div>
                </div>
            </div>
            <div class="col-xl-4 col-xxl-4 col-sm-6">
                <div class="widget-stat card bg-warning">
                    <div class="card-body">
                        <div class="media">
                            <span class="me-3">
                                <i class="la la-user"></i>
                            </span>
                            <div class="media-body text-white">
                                <p class="mb-1">New Students</p>
                                <h3 class="text-white">{{ $studentsLast25DaysCount }}</h3>
                                <div class="progress mb-2 bg-white">
                                    <div class="progress-bar progress-animated bg-white" style="width: {{ min($percentageIncrease25, 100) }}%"></div>
                                </div>
                                <small>{{ round($percentageIncrease25, 2) }}% Increase in 25 Days</small>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-xl-4 col-xxl-4 col-sm-6">
                <div class="widget-stat card bg-secondary">
                    <div class="card-body">
                        <div class="media">
                            <span class="me-3">
                                <i class="la la-graduation-cap"></i>
                            </span>
                            <div class="media-body text-white">
                                <p class="mb-1">Total Course</p>
                                <h3 class="text-white">{{ $totalUniqueCourses }}</h3>
                                <div class="progress mb-2 bg-white">
                                    <div class="progress-bar progress-animated bg-white" style="width: 76%"></div>
                                </div>
                                <small>76% Increase in 20 Days</small>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            {{-- <div class="col-xl-4 col-xxl-4 col-sm-6">
                <div class="widget-stat card bg-danger">
                    <div class="card-body">
                        <div class="media">
                            <span class="me-3">
                                <i class="la la-dollar"></i>
                            </span>
                            <div class="media-body text-white">
                                <p class="mb-1">Fees Collection</p>
                                <h3 class="text-white">25160$</h3>
                                <div class="progress mb-2 bg-white">
                                    <div class="progress-bar progress-animated bg-white" style="width: 30%"></div>
                                </div>
                                <small>30% Increase in 30 Days</small>
                            </div>
                        </div>
                    </div>
                </div>
            </div> --}}
    
            {{-- <div class="col-xl-12 col-xxl-12 col-lg-12 col-md-12 col-sm-12">
                <div class="card">
                    <div class="card-header">
                        <h4 class="card-title">New Student List</h4>
                    </div>
                    <div class="card-body pt-2">
                        <div class="table-responsive recentOrderTable">
                            <table class="table verticle-middle text-nowrap table-responsive-md">
                                <thead>
                                    <tr>
                                        <th scope="col">No.</th>
                                        <th scope="col">Name</th>
                                        <th scope="col">Assigned Professor</th>
                                        <th scope="col">Date Of Admit</th>
                                        <th scope="col">Status</th>
                                        <th scope="col">Subject</th>
                                        <th scope="col">Fees</th>
                                        <th scope="col">Edit</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @php
                                        $i = 1;
                                    @endphp
                                    @foreach ($totalStudents as $student)
                                    <tr>
                                        <td>{{ $i++ }}</td>
                                        <td>{{ $student->user_login }}</td>
                                        <td>Airi Satou</td>
                                        <td>{{ \Carbon\Carbon::parse($student->user_registered)->format('d M Y, h:i A') }}</td>
                                        <td>
                                            <span class="badge badge-rounded {{ $student->user_status == 1 ? 'badge-success' : 'badge-danger' }}">
                                                {{ $student->user_status == 1 ? 'Active' : 'Inactive' }}
                                            </span>
                                        </td>
                                        
                                        <td>Commerce</td>
                                        <td>120$</td>
                                        <td>
                                            <a href="#" class="btn btn-xs sharp btn-primary"><i class="fa fa-pencil"></i></a>
                                            <a href="#" class="btn btn-xs sharp btn-danger"><i class="fa fa-trash"></i></a>
                                        </td>
                                    </tr>
                                    @endforeach
                                   
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div> --}}
        </div>
 @elseif ($isSchoolAdmin)
@include('admin.include.school-admin-dashboard')
@elseif ($isStudent)

@include('admin.include.student-dashboard')

@else

<div class="welcome-card bg-primary-soft rounded-3 shadow-sm p-4 mb-4">
  <div class="d-flex align-items-center">
    <div class="icon-wrapper bg-primary text-white rounded-circle d-flex justify-content-center align-items-center me-3">
      <i class="la la-smile fs-3"></i>
    </div>
    <div>
      <h2 class="welcome-title mb-1">Welcome, {{ Auth::user()->display_name ?? Auth::user()->user_login }}</h2>
      <p class="welcome-subtitle mb-0">We're excited you're here — let's get started!</p>
    </div>
  </div>
</div>
@endif
    </div>
</div>
@endsection