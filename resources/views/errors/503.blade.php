<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="icon" type="image/png" href="{{ asset('images/logo-mi-tarbiyah.png') }}">
    <title>Maintenance — MI TARBIYAH ISLAMIYAH</title>
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=inter:400,500,600,700,800,900&display=swap" rel="stylesheet" />
    <style>
        *, *::before, *::after { box-sizing: border-box; margin: 0; padding: 0; }
        body {
            font-family: 'Inter', sans-serif;
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            background: linear-gradient(135deg, #ecfdf5 0%, #d1fae5 50%, #a7f3d0 100%);
            padding: 1.5rem;
            overflow: hidden;
        }
        .mesh-orb {
            position: absolute;
            border-radius: 50%;
            filter: blur(80px);
            pointer-events: none;
        }
        .mesh-orb-1 { width: 400px; height: 400px; top: -100px; left: -100px; background: rgba(16, 185, 129, 0.25); }
        .mesh-orb-2 { width: 350px; height: 350px; bottom: -80px; right: -80px; background: rgba(5, 150, 105, 0.2); }
        .mesh-orb-3 { width: 250px; height: 250px; top: 40%; left: 60%; background: rgba(110, 231, 183, 0.15); }

        .card {
            position: relative;
            z-index: 10;
            max-width: 480px;
            width: 100%;
            background: rgba(255, 255, 255, 0.92);
            backdrop-filter: blur(20px);
            border: 1px solid rgba(255, 255, 255, 0.9);
            border-radius: 2rem;
            padding: 3rem 2.5rem;
            text-align: center;
            box-shadow: 0 25px 60px -12px rgba(5, 150, 105, 0.12), 0 4px 6px -4px rgba(0,0,0,0.05);
            animation: fadeUp 0.7s cubic-bezier(0.16, 1, 0.3, 1);
        }

        @keyframes fadeUp {
            from { opacity: 0; transform: translateY(30px); }
            to { opacity: 1; transform: translateY(0); }
        }

        @keyframes float {
            0%, 100% { transform: translateY(0px); }
            50% { transform: translateY(-12px); }
        }

        @keyframes pulse-ring {
            0% { transform: scale(0.8); opacity: 1; }
            100% { transform: scale(1.8); opacity: 0; }
        }

        .icon-wrap {
            position: relative;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            width: 96px;
            height: 96px;
            margin-bottom: 1.5rem;
            animation: float 4s ease-in-out infinite;
        }
        .icon-bg {
            position: absolute;
            inset: 0;
            border-radius: 1.5rem;
            background: linear-gradient(135deg, #34d399, #059669);
            box-shadow: 0 10px 30px rgba(5, 150, 105, 0.3);
        }
        .icon-ring {
            position: absolute;
            inset: -8px;
            border-radius: 1.75rem;
            border: 2px solid rgba(16, 185, 129, 0.3);
            animation: pulse-ring 2.5s cubic-bezier(0.4, 0, 0.6, 1) infinite;
        }
        .icon-svg {
            position: relative;
            z-index: 2;
            width: 48px;
            height: 48px;
            color: white;
        }

        h1 {
            font-size: 1.5rem;
            font-weight: 900;
            color: #0f172a;
            letter-spacing: -0.02em;
            margin-bottom: 0.5rem;
        }
        .subtitle {
            font-size: 0.8rem;
            color: #64748b;
            line-height: 1.7;
            margin-bottom: 2rem;
        }

        .info-box {
            background: #f0fdf4;
            border: 1px solid #bbf7d0;
            border-radius: 1rem;
            padding: 1rem 1.25rem;
            margin-bottom: 1.5rem;
        }
        .info-box-title {
            font-size: 0.7rem;
            font-weight: 800;
            color: #059669;
            text-transform: uppercase;
            letter-spacing: 0.08em;
            margin-bottom: 0.25rem;
        }
        .info-box-text {
            font-size: 0.75rem;
            color: #047857;
            font-weight: 500;
        }

        .timer {
            display: flex;
            justify-content: center;
            gap: 0.75rem;
            margin-bottom: 1.5rem;
        }
        .timer-item {
            display: flex;
            flex-direction: column;
            align-items: center;
            background: #ecfdf5;
            border: 1px solid #a7f3d0;
            border-radius: 0.75rem;
            padding: 0.6rem 1rem;
            min-width: 60px;
        }
        .timer-value {
            font-size: 1.5rem;
            font-weight: 900;
            color: #059669;
            font-variant-numeric: tabular-nums;
        }
        .timer-label {
            font-size: 0.55rem;
            font-weight: 700;
            color: #6ee7b7;
            text-transform: uppercase;
            letter-spacing: 0.1em;
        }

        .footer {
            font-size: 0.65rem;
            font-weight: 600;
            color: #94a3b8;
            text-transform: uppercase;
            letter-spacing: 0.1em;
            margin-top: 1.5rem;
        }
        .refresh-btn {
            display: inline-flex;
            align-items: center;
            gap: 0.5rem;
            padding: 0.75rem 1.75rem;
            background: linear-gradient(135deg, #10b981, #059669);
            color: white;
            font-size: 0.8rem;
            font-weight: 700;
            border: none;
            border-radius: 1rem;
            cursor: pointer;
            box-shadow: 0 6px 20px rgba(5, 150, 105, 0.3);
            transition: all 0.2s;
            text-decoration: none;
        }
        .refresh-btn:hover {
            transform: translateY(-2px);
            box-shadow: 0 10px 30px rgba(5, 150, 105, 0.4);
        }
    </style>
</head>
<body>
    <div class="mesh-orb mesh-orb-1"></div>
    <div class="mesh-orb mesh-orb-2"></div>
    <div class="mesh-orb mesh-orb-3"></div>

    <div class="card">
        <div class="icon-wrap">
            <div class="icon-ring"></div>
            <div class="icon-bg"></div>
            <svg class="icon-svg" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.8">
                <path stroke-linecap="round" stroke-linejoin="round" d="M11.42 15.17l-5.657-5.657C4.422 8.172 4.222 6.36 5.636 4.948l.707-.707c1.414-1.414 3.225-1.214 4.567.128l5.657 5.657M11.42 15.17l2.121 2.121M11.42 15.17l-2.121 2.121M13.54 17.29l1.415 1.414a2 2 0 002.827 0l.708-.707a2 2 0 000-2.828l-1.414-1.414M19.5 12c0 7.142-7.5 11.25-7.5 11.25S4.5 19.142 4.5 12a7.5 7.5 0 0115 0z" />
            </svg>
        </div>

        <h1>🔧 Sedang Dalam Pemeliharaan</h1>
        <p class="subtitle">
            Sistem Presensi Guru sedang dalam proses pemeliharaan rutin untuk memastikan kinerja yang optimal. Mohon bersabar, kami akan segera kembali online.
        </p>

        <div class="info-box">
            <div class="info-box-title">📋 Informasi</div>
            <div class="info-box-text">
                Semua data absensi aman & tersimpan. Tidak ada data yang hilang selama proses maintenance.
            </div>
        </div>

        <div class="timer" id="countdown">
            <div class="timer-item">
                <span class="timer-value" id="timer-h">00</span>
                <span class="timer-label">Jam</span>
            </div>
            <div class="timer-item">
                <span class="timer-value" id="timer-m">30</span>
                <span class="timer-label">Menit</span>
            </div>
            <div class="timer-item">
                <span class="timer-value" id="timer-s">00</span>
                <span class="timer-label">Detik</span>
            </div>
        </div>

        <a href="/" class="refresh-btn" onclick="event.preventDefault(); location.reload();">
            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5">
                <path stroke-linecap="round" stroke-linejoin="round" d="M16.023 9.348h4.992v-.001M2.985 19.644v-4.992m0 0h4.992m-4.993 0l3.181 3.183a8.25 8.25 0 0013.803-3.7M4.031 9.865a8.25 8.25 0 0113.803-3.7l3.181 3.182" />
            </svg>
            Coba Muat Ulang
        </a>

        <div class="footer">
            MI Tarbiyah Islamiyah — Benda, Kota Tangerang © {{ date('Y') }}
        </div>
    </div>

    <script>
        // Countdown timer (estimasi 30 menit)
        let totalSeconds = 30 * 60;
        function updateTimer() {
            const h = Math.floor(totalSeconds / 3600);
            const m = Math.floor((totalSeconds % 3600) / 60);
            const s = totalSeconds % 60;
            document.getElementById('timer-h').textContent = String(h).padStart(2, '0');
            document.getElementById('timer-m').textContent = String(m).padStart(2, '0');
            document.getElementById('timer-s').textContent = String(s).padStart(2, '0');
            if (totalSeconds > 0) {
                totalSeconds--;
                setTimeout(updateTimer, 1000);
            } else {
                location.reload();
            }
        }
        updateTimer();

        // Auto-refresh every 60 seconds to check if maintenance is over
        setInterval(() => {
            fetch(window.location.href, { method: 'HEAD' })
                .then(res => { if (res.ok) location.reload(); })
                .catch(() => {});
        }, 60000);
    </script>
</body>
</html>
