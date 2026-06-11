<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=yes">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>FarmSense Pro | IoT Peternakan</title>
    <!-- Font Awesome 6 -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <!-- Google Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Inter:opsz,wght@14..32,300;400;500;600;700;800&family=Space+Grotesk:wght@400;500;600&display=swap" rel="stylesheet">
    <!-- Chart.js -->
    <script src="https://cdn.jsdelivr.net/npm/chart.js@4.4.0/dist/chart.umd.min.js"></script>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Inter', 'Space Grotesk', sans-serif;
            background: #0C121C;
            color: #EFF3F8;
            overflow-x: hidden;
        }

        /* TOP BAR NAVIGATION (Horizontal) */
        .top-nav {
            background: rgba(12, 20, 28, 0.85);
            backdrop-filter: blur(16px);
            border-bottom: 1px solid rgba(74, 222, 128, 0.2);
            padding: 12px 32px;
            display: flex;
            justify-content: space-between;
            align-items: center;
            position: sticky;
            top: 0;
            z-index: 100;
        }

        .logo-area {
            display: flex;
            align-items: center;
            gap: 12px;
        }

        .logo-icon {
            background: linear-gradient(135deg, #4ADE80, #22C55E);
            width: 40px;
            height: 40px;
            border-radius: 12px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 20px;
            color: #0A1F12;
        }

        .logo-area h2 {
            font-size: 1.3rem;
            font-weight: 700;
            background: linear-gradient(135deg, #FFFFFF, #A3E8B0);
            background-clip: text;
            -webkit-background-clip: text;
            color: transparent;
        }

        /* Menu container di kanan */
        .nav-menu {
            display: flex;
            gap: 8px;
            align-items: center;
        }

        .nav-item {
            display: flex;
            align-items: center;
            gap: 8px;
            padding: 10px 20px;
            border-radius: 40px;
            color: #B0C4D9;
            transition: all 0.2s;
            cursor: pointer;
            font-weight: 500;
            font-size: 0.9rem;
        }

        .nav-item i {
            font-size: 1rem;
        }

        .nav-item.active {
            background: rgba(74, 222, 128, 0.15);
            color: #4ADE80;
        }

        .nav-item:hover:not(.active) {
            background: rgba(255, 255, 255, 0.05);
            color: #E2F0E8;
        }

        /* Live status di pojok kanan atas (bersamaan menu) */
        .live-status {
            background: rgba(0, 0, 0, 0.4);
            backdrop-filter: blur(8px);
            padding: 6px 16px;
            border-radius: 40px;
            display: flex;
            align-items: center;
            gap: 10px;
            border: 1px solid rgba(74, 222, 128, 0.3);
            margin-left: 16px;
        }

        .live-dot {
            width: 8px;
            height: 8px;
            background: #4ADE80;
            border-radius: 50%;
            box-shadow: 0 0 8px #4ADE80;
            animation: pulse 1.5s infinite;
        }

        @keyframes pulse {
            0% { opacity: 0.5; transform: scale(0.8);}
            100% { opacity: 1; transform: scale(1.2);}
        }

        /* MAIN CONTENT */
        .main-content {
            padding: 28px 32px;
            min-height: calc(100vh - 64px);
            background: radial-gradient(circle at 10% 20%, rgba(10, 25, 20, 0.4), rgba(8, 18, 24, 0.6));
        }

        .page-title {
            margin-bottom: 28px;
        }

        .page-title h1 {
            font-size: 1.8rem;
            font-weight: 700;
            letter-spacing: -0.5px;
        }

        /* SENSOR GRID (2 kolom besar) */
        .sensor-grid {
            display: grid;
            grid-template-columns: repeat(2, 1fr);
            gap: 32px;
            margin-bottom: 32px;
        }

        .card {
            background: rgba(18, 28, 38, 0.65);
            backdrop-filter: blur(12px);
            border-radius: 32px;
            border: 1px solid rgba(74, 222, 128, 0.2);
            padding: 32px 28px;
            transition: all 0.3s;
            box-shadow: 0 8px 20px rgba(0, 0, 0, 0.2);
        }

        .card:hover {
            transform: translateY(-5px);
            border-color: rgba(74, 222, 128, 0.6);
            background: rgba(22, 34, 46, 0.75);
        }

        .card-header {
            display: flex;
            justify-content: space-between;
            margin-bottom: 20px;
        }

        .card-header i {
            font-size: 40px;
            color: #4ADE80;
            filter: drop-shadow(0 0 5px #4ADE8066);
        }

        .chip {
            background: #1F2E3A;
            padding: 4px 14px;
            border-radius: 40px;
            font-size: 0.75rem;
            font-weight: 500;
        }

        .value {
            font-size: 3.8rem;
            font-weight: 800;
            font-family: 'Space Grotesk', monospace;
            letter-spacing: -1px;
            margin: 12px 0 8px;
        }

        .unit {
            font-size: 1rem;
            font-weight: 400;
            color: #9BB8A8;
            margin-left: 4px;
        }

        .sub {
            font-size: 0.8rem;
            text-transform: uppercase;
            color: #A1C2B2;
            letter-spacing: 0.5px;
        }

        .badge-sm {
            display: inline-block;
            font-size: 0.75rem;
            font-weight: 600;
            padding: 6px 14px;
            border-radius: 24px;
            margin-top: 8px;
        }

        .badge-safe { background: #0F4020; color: #B0F5C2; }
        .badge-warn { background: #7C3A0A; color: #FFE1B3; }
        .badge-danger { background: #911A1A; color: #FFC2C2; }

        .row-metrics {
            display: flex;
            justify-content: space-between;
            gap: 16px;
            margin-top: 16px;
        }

        .metric-box {
            flex: 1;
            background: rgba(0, 0, 0, 0.25);
            border-radius: 20px;
            padding: 14px 8px;
            text-align: center;
        }

        .metric-value {
            font-size: 1.8rem;
            font-weight: 700;
        }

        /* CHART PANEL (monitoring) */
        .chart-panel, .about-panel {
            background: rgba(18, 28, 38, 0.6);
            backdrop-filter: blur(12px);
            border-radius: 32px;
            border: 1px solid rgba(74, 222, 128, 0.2);
            padding: 28px;
            margin-top: 20px;
        }

        .section-title {
            font-size: 1.2rem;
            font-weight: 600;
            margin-bottom: 24px;
            display: flex;
            align-items: center;
            gap: 12px;
            border-left: 3px solid #4ADE80;
            padding-left: 16px;
        }

        canvas {
            max-height: 300px;
            width: 100%;
        }

        /* KONTROL PANEL */
        .control-panel {
            background: rgba(18, 28, 38, 0.6);
            backdrop-filter: blur(12px);
            border-radius: 32px;
            border: 1px solid rgba(74, 222, 128, 0.2);
            padding: 28px;
        }

        .actuator-buttons {
            display: flex;
            flex-direction: column;
            gap: 20px;
        }

        .actuator-item {
            background: rgba(0, 0, 0, 0.25);
            border-radius: 24px;
            padding: 18px 20px;
            display: flex;
            justify-content: space-between;
            align-items: center;
            flex-wrap: wrap;
        }

        .actuator-info {
            display: flex;
            align-items: center;
            gap: 14px;
            font-size: 1.1rem;
            font-weight: 500;
        }

        .actuator-info i {
            font-size: 28px;
            color: #4ADE80;
        }

        .toggle-btn {
            background: #2D3E48;
            border: none;
            padding: 10px 28px;
            border-radius: 40px;
            color: white;
            font-weight: 600;
            cursor: pointer;
            transition: 0.2s;
            display: flex;
            align-items: center;
            gap: 8px;
            font-size: 0.9rem;
        }

        .toggle-btn.active {
            background: #4ADE80;
            color: #0A2F1F;
            box-shadow: 0 0 12px #4ADE80;
        }

        /* About Page / Tentang */
        .team-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
            gap: 24px;
            margin-top: 20px;
        }

        .team-card {
            background: rgba(0, 0, 0, 0.3);
            border-radius: 24px;
            padding: 24px;
            text-align: center;
            border: 1px solid rgba(74, 222, 128, 0.2);
            transition: 0.2s;
        }

        .team-card:hover {
            border-color: rgba(74, 222, 128, 0.5);
            background: rgba(74, 222, 128, 0.05);
        }

        .team-avatar {
            width: 80px;
            height: 80px;
            background: linear-gradient(135deg, #2D5A3B, #1A3A28);
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            margin: 0 auto 16px;
            font-size: 32px;
            color: #4ADE80;
        }

        .team-name {
            font-size: 1.2rem;
            font-weight: 700;
            margin-bottom: 6px;
        }

        .team-role {
            font-size: 0.8rem;
            color: #9BB8A8;
            margin-bottom: 12px;
        }

        .team-desc {
            font-size: 0.85rem;
            color: #C0D9CC;
            line-height: 1.4;
        }

        .project-goal {
            background: rgba(0, 0, 0, 0.25);
            border-radius: 24px;
            padding: 24px;
            margin-bottom: 28px;
            border-left: 4px solid #4ADE80;
        }

        .footer {
            text-align: center;
            font-size: 0.7rem;
            color: #6A8F7C;
            margin-top: 32px;
            padding-top: 16px;
            border-top: 1px solid rgba(74, 222, 128, 0.1);
        }

        @media (max-width: 900px) {
            .top-nav {
                flex-direction: column;
                gap: 12px;
                padding: 12px 20px;
            }
            .nav-menu {
                flex-wrap: wrap;
                justify-content: center;
            }
            .live-status {
                margin-left: 0;
            }
            .sensor-grid {
                grid-template-columns: 1fr;
                gap: 24px;
            }
            .main-content {
                padding: 20px;
            }
            .value {
                font-size: 2.8rem;
            }
        }
    </style>
</head>
<body>
<div class="app-wrapper">
    <!-- TOP NAVIGATION BAR -->
    <nav class="top-nav">
        <div class="logo-area">
            <div class="logo-icon"><i class="fas fa-leaf"></i></div>
            <h2>Farm<span style="font-weight:400">Sense</span></h2>
        </div>
        <div class="nav-menu">
            <div class="nav-item active" data-nav="dashboard">
                <i class="fas fa-tachometer-alt"></i> Dashboard
            </div>
            <div class="nav-item" data-nav="monitoring">
                <i class="fas fa-chart-line"></i> Monitoring
            </div>
            <div class="nav-item" data-nav="actuators">
                <i class="fas fa-sliders-h"></i> Kontrol
            </div>
            <div class="nav-item" data-nav="history">
                <i class="fas fa-history"></i> Riwayat
            </div>
            <div class="nav-item" data-nav="about">
                <i class="fas fa-info-circle"></i> Tentang
            </div>
            <div class="live-status">
                <div class="live-dot"></div>
                <span style="font-size:0.75rem;">Live</span>
            </div>
        </div>
    </nav>

    <main class="main-content">
        <div class="page-title">
            <h1><span id="mainTitle">Dashboard Peternakan</span></h1>
        </div>

        @yield('content')

        <div class="footer">
            <i class="fas fa-shield-alt"></i> Peternakan Cerdas · Sensor MQ-136, MQ-137, BME280, PMS5003
        </div>
    </main>
</div>
@yield('scripts')
</body>
</html>