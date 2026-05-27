<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'Student Portal')</title>
    <link href="https://fonts.googleapis.com/css2?family=DM+Sans:wght@400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
    <style>
        *{margin:0;padding:0;box-sizing:border-box}
        html,body{margin:0;padding:0;height:100%;width:100%;background:#f1f5f9}
        :root{--color-primary:#1e3a5f;--color-accent:#2563eb;--color-success:#059669;--color-warning:#d97706;--color-danger:#dc2626;--color-bg:#f1f5f9;--color-surface:#fff;--color-border:#e2e8f0;--color-text:#0f172a;--color-text-muted:#64748b;--radius:8px;--radius-lg:10px;--transition:.15s ease;--shadow-sm:0 1px 3px rgba(0,0,0,.06);--navbar-height:56px}
        body{font-family:'DM Sans',sans-serif;background:var(--color-bg);color:var(--color-text);display:flex;flex-direction:column;min-height:100vh;line-height:1.6;font-size:.875rem}
        .navbar{position:fixed;top:0;left:0;right:0;height:var(--navbar-height);background:var(--color-surface);border-bottom:1px solid var(--color-border);box-shadow:var(--shadow-sm);display:flex;align-items:center;padding:0 1.5rem;gap:2rem;z-index:1000}
        .navbar-brand{font-weight:700;font-size:1.125rem;color:var(--color-primary);text-decoration:none;display:flex;align-items:center;gap:.5rem;margin-right:auto}
        .navbar-brand::after{content:'';width:8px;height:8px;background:var(--color-accent);border-radius:50%;margin-left:.25rem}
        .navbar-nav{display:flex;gap:.5rem;align-items:center;list-style:none}
        .navbar-nav a{color:var(--color-text-muted);text-decoration:none;padding:.5rem .875rem;border-radius:var(--radius);font-weight:500;font-size:.875rem;transition:all var(--transition)}
        .navbar-nav a:hover,.navbar-nav a.active{background:var(--color-bg);color:var(--color-accent)}
        .main-content{flex:1;max-width:1080px;width:100%;margin:0 auto;padding:1.5rem;padding-top:calc(var(--navbar-height) + 1.5rem)}
        .page-header{display:flex;justify-content:space-between;align-items:flex-start;margin-bottom:2rem;gap:1.5rem;flex-wrap:wrap}
        .header-content{flex:1;min-width:0}
        .header-content h1{font-size:1.5rem;font-weight:700;color:var(--color-text);margin:0 0 .25rem 0;letter-spacing:-.02em}
        .header-subtitle{font-size:.85rem;color:var(--color-text-muted);font-weight:500;margin:0}
        .header-actions{display:inline-flex;flex-direction:row;gap:.5rem;align-items:center;flex-wrap:nowrap;white-space:nowrap;flex-shrink:0}
        .header-actions form{display:inline-flex!important;margin:0!important;padding:0!important}
        .header-actions form button{height:30px;padding:.3rem .7rem;font-size:.78rem;border-radius:5px;white-space:nowrap}
        .page-header-title{font-size:1.25rem;font-weight:700;color:var(--color-text);letter-spacing:-.02em}
        .stats-grid-large{display:grid;grid-template-columns:repeat(4,1fr);gap:1rem;margin-bottom:1rem}
        .stat-card-large{background:#fff;border:1px solid var(--color-border);border-radius:12px;padding:1rem;display:flex;flex-direction:column;gap:.6rem;min-height:140px;justify-content:space-between}
        .stat-icon-box{width:44px;height:44px;border-radius:10px;display:inline-flex;align-items:center;justify-content:center;color:#fff}
        .stat-number{font-size:36px;font-weight:800;color:var(--color-text)}
        .stat-label{color:var(--color-text-muted);font-weight:700}
        .stat-link{color:#6b21a8;text-decoration:none;font-weight:700}
        .stat-blue .stat-icon-box{background:#2563eb}.stat-green .stat-icon-box{background:#059669}.stat-purple .stat-icon-box{background:#7c3aed}.stat-amber .stat-icon-box{background:#d97706}
        .badge-pill{display:inline-block;padding:.25rem .6rem;border-radius:999px;font-weight:700;font-size:.78rem;color:#fff}.badge-bsit{background:#2563eb}.badge-hm{background:#7c3aed}.badge-default{background:#64748b}
        .bottom-grid{display:grid;grid-template-columns:2fr 1fr;gap:1rem;margin-top:1rem}
        .page-header-subtitle{font-size:.8rem;color:var(--color-text-muted);margin-top:.125rem;font-weight:500}
        .page-header .actions{gap:.5rem;flex-wrap:wrap;justify-content:flex-end}.page-header .actions form{display:inline!important}
        .card{background:var(--color-surface);border:1px solid var(--color-border);border-radius:var(--radius-lg);box-shadow:var(--shadow-sm);padding:1.5rem;transition:box-shadow var(--transition)}.card.card-centered{max-width:650px;margin:0 auto}.card:hover{box-shadow:0 4px 12px rgba(0,0,0,.08)}.card-body{padding:0}
        .table-wrapper{overflow-x:auto;border-radius:var(--radius-lg);border:1px solid var(--color-border)}
        table{width:100%;border-collapse:collapse;background:var(--color-surface)}
        table thead{background:#f8fafc}table th{padding:.6rem 1rem;text-align:left;font-size:.7rem;font-weight:600;text-transform:uppercase;letter-spacing:.06em;color:var(--color-text-muted);border-bottom:1px solid var(--color-border)}
        table td{padding:.6rem 1rem;height:44px;border-bottom:1px solid #f1f5f9;font-size:.875rem;color:var(--color-text)}
        table th:last-child,table td:last-child{width:200px;min-width:200px}table tbody tr:last-child td{border-bottom:none}table tbody tr:hover{background:#f8fafc;transition:background-color var(--transition)}
        .btn{display:inline-flex;align-items:center;justify-content:center;gap:.5rem;padding:.45rem 1rem;font-size:.8rem;font-weight:600;border:none;border-radius:var(--radius);cursor:pointer;text-decoration:none;transition:all .2s cubic-bezier(.4,0,.2,1);white-space:nowrap;position:relative;overflow:hidden}
        .btn-primary{background:var(--color-primary);color:var(--color-surface);box-shadow:0 2px 6px rgba(30,58,95,.15)}.btn-secondary{background:var(--color-bg);color:var(--color-text-muted);box-shadow:0 1px 3px rgba(0,0,0,.05)}.btn-success{background:var(--color-success);color:#fff;box-shadow:0 2px 6px rgba(5,150,105,.15)}.btn-success:hover{background:#047857;transform:translateY(-1px);box-shadow:0 4px 12px rgba(5,150,105,.2)}.btn-info{background:#0ea5e9;color:#fff;box-shadow:0 2px 6px rgba(14,165,233,.15)}.btn-info:hover{background:#0284c7}.btn-danger{background:#dc2626;color:#fff}.btn-outline-light{background:transparent;color:var(--color-surface);border:1px solid rgba(255,255,255,.15);padding:.35rem .85rem;border-radius:.5rem;box-shadow:none}
        .action-buttons{display:flex;flex-direction:column;gap:.4rem;align-items:stretch;width:100%}.action-form{display:flex;margin:0;padding:0}.action-form button{margin:0;width:100%}.action-buttons a{text-align:center;width:100%}
        .alert{padding:.65rem 1rem;border-radius:var(--radius);font-size:.85rem;margin-bottom:1rem;border-left:3px solid transparent}.alert-success{background:#f0fdf4;color:#14532d;border-left-color:var(--color-success)}.alert-danger{background:#fef2f2;color:#991b1b;border-left-color:var(--color-danger)}
        .form-group{display:flex;flex-direction:column;gap:.5rem;margin-bottom:1.5rem}.form-label{font-weight:600;font-size:.875rem;color:var(--color-text);letter-spacing:-.01em}.form-control{padding:.6rem .875rem;border:1.5px solid var(--color-border);border-radius:var(--radius);font-size:.875rem;font-family:inherit;background:var(--color-surface);color:var(--color-text);transition:all var(--transition)}.form-control:focus{outline:none;border-color:var(--color-accent);box-shadow:0 0 0 3px rgba(37,99,235,.1)}.form-control::placeholder{color:var(--color-text-muted)}.form-control.is-invalid{border-color:var(--color-danger);background:rgba(220,38,38,.02)}.form-control.is-invalid:focus{box-shadow:0 0 0 3px rgba(220,38,38,.1)}.text-danger{color:var(--color-danger);font-weight:500}.card-header{padding-bottom:1rem;border-bottom:1px solid var(--color-border);margin-bottom:1.5rem}.card-header .card-title{font-size:1.25rem;font-weight:700;color:var(--color-text);margin:0}.btn-block{width:100%;padding:.6rem 1.25rem;font-size:.95rem;font-weight:600}.btn-primary:hover{background:#163451;transform:translateY(-1px);box-shadow:0 4px 12px rgba(30,58,95,.25)}.btn-primary:active{transform:translateY(0)}.btn-secondary:hover{background:#e2e8f0;color:var(--color-accent)}.btn-info:hover{background:#0284c7;transform:translateY(-1px);box-shadow:0 4px 12px rgba(14,165,233,.2)}.btn-danger:hover{background:#b91c1c;transform:translateY(-1px);box-shadow:0 4px 12px rgba(220,38,38,.2)}
        .filter-input{padding:.6rem .875rem;border:1.5px solid var(--color-border);border-radius:var(--radius);font-size:.875rem;font-family:inherit;background:var(--color-surface);color:var(--color-text);transition:all var(--transition);width:100%}.filter-input:focus{outline:none;border-color:var(--color-accent);box-shadow:0 0 0 3px rgba(37,99,235,.1)}.filter-input::placeholder{color:var(--color-text-muted)}.filter-select{padding:.6rem .875rem;border:1.5px solid var(--color-border);border-radius:var(--radius);font-size:.875rem;font-family:inherit;background:var(--color-surface);color:var(--color-text);transition:all var(--transition)}.filter-select:focus{outline:none;border-color:var(--color-accent);box-shadow:0 0 0 3px rgba(37,99,235,.1)}.filter-group{display:flex;gap:.5rem;align-items:center;flex-wrap:wrap}.filter-actions{display:flex;gap:.5rem}
        .teacher-stats{grid-template-columns:repeat(3,1fr)}.course-board{display:grid;grid-template-columns:repeat(5,1fr);gap:.75rem;margin-bottom:1rem}.course-tile{display:flex;flex-direction:column;gap:.3rem;padding:.85rem;border:1px solid var(--color-border);border-radius:8px;background:#fff;color:var(--color-text);text-decoration:none;min-height:112px;box-shadow:var(--shadow-sm)}.course-tile:hover{border-color:var(--color-accent);transform:translateY(-1px)}.course-title{font-size:1rem;font-weight:800}.course-teacher{font-size:.74rem;color:var(--color-text-muted);line-height:1.25}.course-count{margin-top:auto;font-size:.78rem;font-weight:800;color:var(--color-accent)}.compact-card{padding:1rem}.section-heading{display:flex;align-items:center;justify-content:space-between;gap:1rem;margin-bottom:.75rem}.section-heading h2{font-size:1rem;margin:0}.compact-student-grid{display:grid;grid-template-columns:repeat(4,1fr);gap:.5rem}.student-chip{border:1px solid var(--color-border);border-radius:8px;padding:.55rem .65rem;background:#f8fafc;display:flex;justify-content:space-between;gap:.5rem;align-items:center;min-width:0}.student-chip strong{font-size:.82rem;white-space:nowrap;overflow:hidden;text-overflow:ellipsis}.student-chip span{font-size:.72rem;color:var(--color-text-muted);font-weight:700;white-space:nowrap}.course-workspace{display:grid;grid-template-columns:220px 1fr;gap:1rem;align-items:start}.course-list-panel,.course-detail-panel{background:#fff;border:1px solid var(--color-border);border-radius:8px;padding:1rem;box-shadow:var(--shadow-sm)}.course-list-panel h2,.course-detail-header h2{font-size:1rem;margin:0 0:.75rem 0}.course-list{display:flex;flex-direction:column;gap:.5rem}.course-list-item{display:flex;justify-content:space-between;align-items:center;gap:.5rem;padding:.6rem .7rem;border:1px solid var(--color-border);border-radius:8px;color:var(--color-text);text-decoration:none;font-weight:800}.course-list-item small{font-size:.7rem;color:var(--color-text-muted);font-weight:700}.course-list-item.active,.course-list-item:hover{border-color:var(--color-accent);background:#eff6ff;color:var(--color-accent)}.course-detail-header{display:flex;justify-content:space-between;align-items:flex-start;gap:1rem;margin-bottom:1rem}.course-detail-header p{margin:0;color:var(--color-text-muted)}.inline-add-form{display:flex;gap:.5rem;align-items:center;margin:0}.inline-add-form .form-control{min-width:220px;margin:0}.course-student-table table th,.course-student-table table td{padding:.48rem .7rem;height:38px}.course-student-table table th:last-child,.course-student-table table td:last-child{width:120px;min-width:120px}
        .footer{background:var(--color-primary);color:var(--color-surface);text-align:center;padding:1.5rem;font-size:.875rem;margin-top:auto}
        @media (max-width: 980px){.bottom-grid{grid-template-columns:1fr}.stats-grid-large{grid-template-columns:repeat(2,1fr)}}
        @media (max-width: 980px){.course-board{grid-template-columns:repeat(2,1fr)}.compact-student-grid{grid-template-columns:repeat(2,1fr)}.course-workspace{grid-template-columns:1fr}.course-list{display:grid;grid-template-columns:repeat(2,1fr)}}
        @media (max-width: 768px){.navbar{padding:0 1rem;gap:1rem}.navbar-nav{gap:.25rem}.navbar-nav a{padding:.4rem .7rem;font-size:.75rem}.main-content{padding:1rem;padding-top:calc(var(--navbar-height) + 1rem)}.card{padding:1rem}.stats-grid-large,.teacher-stats{grid-template-columns:1fr}.table-wrapper{font-size:.75rem}table th,table td{padding:.5rem}.course-board,.compact-student-grid,.course-list{grid-template-columns:1fr}.course-detail-header,.inline-add-form{flex-direction:column;align-items:stretch}.inline-add-form .form-control{min-width:0;width:100%}}
    </style>
</head>
<body>
    @if (!request()->routeIs('login'))
        <nav class="navbar">
            <a href="{{ url('/') }}" class="navbar-brand">Student Portal</a>
            <ul class="navbar-nav">
                @if(session('user_account_id'))
                    @if(session('role') === 'admin')
                        <li><a href="{{ url('/') }}" class="nav-link @if(request()->is('/')) active @endif"><i class="fas fa-gauge"></i> Dashboard</a></li>
                        <li><a href="{{ route('user.profile') }}" class="nav-link @if(request()->is('profile')) active @endif"><i class="fas fa-user"></i> Profile</a></li>
                        <li><a href="{{ route('about') }}" class="nav-link @if(request()->is('about')) active @endif"><i class="fas fa-circle-info"></i> About</a></li>
                    @elseif(session('role') === 'teacher')
                        <li><a href="{{ url('/') }}" class="nav-link @if(request()->is('/')) active @endif"><i class="fas fa-gauge"></i> Dashboard</a></li>
                        <li><a href="{{ route('user.profile') }}" class="nav-link @if(request()->is('profile')) active @endif"><i class="fas fa-user"></i> Profile</a></li>
                        <li><a href="{{ route('about') }}" class="nav-link @if(request()->is('about')) active @endif"><i class="fas fa-circle-info"></i> About</a></li>
                    @elseif(session('role') === 'student')
                        <li><a href="{{ url('/') }}" class="nav-link @if(request()->is('/')) active @endif"><i class="fas fa-gauge"></i> Dashboard</a></li>
                        <li><a href="{{ route('user.profile') }}" class="nav-link @if(request()->is('profile')) active @endif"><i class="fas fa-user"></i> Profile</a></li>
                        <li><a href="{{ route('about') }}" class="nav-link @if(request()->is('about')) active @endif"><i class="fas fa-circle-info"></i> About</a></li>
                    @endif
                @endif
            </ul>
            <div style="display:flex;align-items:center;gap:1rem;margin-left:auto;">
                @if(session('user_account_id'))
                    <span style="color:var(--color-text);font-size:.95rem;font-weight:700">{{ session('name') ?? session('username') }} ({{ strtoupper(session('role')) }})</span>
                    <form action="{{ route('logout') }}" method="POST" style="margin:0;">
                        @csrf
                        <button type="submit" class="btn btn-primary">Logout</button>
                    </form>
                @else
                    <a href="{{ route('login') }}" class="nav-link">Login</a>
                @endif
            </div>
        </nav>
    @endif

    <main class="main-content">
        @if (session('success'))
            <div class="alert alert-success" role="alert"><i class="fas fa-check-circle"></i> {{ session('success') }}</div>
        @endif
        @if (session('error'))
            <div class="alert alert-danger" role="alert"><i class="fas fa-exclamation-circle"></i> {{ session('error') }}</div>
        @endif
        @if ($errors->any())
            <div class="alert alert-danger" role="alert"><i class="fas fa-exclamation-circle"></i> Please fix the errors below.</div>
        @endif
        @yield('content')
    </main>

    <footer class="footer">
        <p>&copy; 2026 PSU Student Portal. All rights reserved.</p>
    </footer>
    @include('partials.scripts')
</body>
</html>
