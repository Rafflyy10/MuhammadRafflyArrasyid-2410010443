<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard Aplikasi PHP - Docker</title>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 20px;
        }

        .container {
            max-width: 700px;
            width: 100%;
        }

        .card {
            background: white;
            border-radius: 16px;
            box-shadow: 0 20px 60px rgba(0, 0, 0, 0.3);
            overflow: hidden;
            animation: slideUp 0.6s ease-out;
        }

        @keyframes slideUp {
            from {
                opacity: 0;
                transform: translateY(30px);
            }

            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        .header {
            padding: 40px 30px;
            text-align: center;
        }

        .header.success {
            background: linear-gradient(135deg, #11998e 0%, #38ef7d 100%);
        }

        .header.error {
            background: linear-gradient(135deg, #ee0979 0%, #ff6a00 100%);
        }

        .header h1 {
            color: white;
            font-size: 32px;
            margin-bottom: 10px;
            font-weight: 700;
        }

        .header p {
            color: rgba(255, 255, 255, 0.9);
            font-size: 16px;
            margin-bottom: 5px;
        }

        .status-icon {
            font-size: 48px;
            margin-bottom: 15px;
            animation: pulse 2s infinite;
        }

        @keyframes pulse {

            0%,
            100% {
                opacity: 1;
            }

            50% {
                opacity: 0.7;
            }
        }

        .body {
            padding: 40px 30px;
            text-align: center;
        }

        .info-box {
            background: #f8f9fa;
            padding: 25px;
            border-radius: 12px;
            margin: 20px 0;
            border-left: 4px solid;
        }

        .info-box.success {
            border-left-color: #38ef7d;
            background: #f0fdf4;
        }

        .info-box.error {
            border-left-color: #ff6a00;
            background: #fef2f2;
        }

        .info-row {
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 12px 0;
            border-bottom: 1px solid rgba(0, 0, 0, 0.1);
        }

        .info-row:last-child {
            border-bottom: none;
        }

        .info-label {
            font-weight: 600;
            color: #495057;
            text-align: left;
        }

        .info-value {
            color: #212529;
            font-family: 'Courier New', monospace;
            font-weight: 500;
            text-align: right;
            word-break: break-all;
        }

        .success .info-label,
        .success .info-value {
            color: #166534;
        }

        .error .info-label,
        .error .info-value {
            color: #7c2d12;
        }

        .footer {
            padding: 20px 30px;
            background: #f8f9fa;
            text-align: center;
            font-size: 13px;
            color: #6c757d;
            border-top: 1px solid #dee2e6;
        }

        .tech-stack {
            display: flex;
            justify-content: center;
            gap: 15px;
            margin-top: 15px;
            flex-wrap: wrap;
        }

        .badge {
            background: #e7f5ff;
            color: #0066cc;
            padding: 6px 14px;
            border-radius: 20px;
            font-size: 12px;
            font-weight: 600;
        }

        .badge.docker {
            background: #e3f2fd;
            color: #1976d2;
        }

        .badge.php {
            background: #f3e5f5;
            color: #7b1fa2;
        }

        .badge.mysql {
            background: #fff3e0;
            color: #e65100;
        }

        @media (max-width: 600px) {
            .header h1 {
                font-size: 24px;
            }

            .header {
                padding: 30px 20px;
            }

            .body {
                padding: 30px 20px;
            }

            .info-row {
                flex-direction: column;
                align-items: flex-start;
            }

            .info-value {
                text-align: left;
                margin-top: 8px;
            }
        }
    </style>
</head>

<body>
    <div class="container">
        <?php
        $host = 'db';
        $user = 'root';
        $pass = 'root';
        $db = 'my_first_db';

        $conn = mysqli_connect($host, $user, $pass, $db);

        if (mysqli_connect_errno()) {
            echo '
            <div class="card">
                <div class="header error">
                    <div class="status-icon">⚠️</div>
                    <h1>Sistem Mengalami Gangguan</h1>
                    <p>Database tidak dapat diakses</p>
                </div>
                <div class="body">
                    <div class="info-box error">
                        <div class="info-row">
                            <span class="info-label">Error:</span>
                            <span class="info-value">' . mysqli_connect_error() . '</span>
                        </div>
                        <div class="info-row">
                            <span class="info-label">Host:</span>
                            <span class="info-value">' . $host . '</span>
                        </div>
                        <div class="info-row">
                            <span class="info-label">Database:</span>
                            <span class="info-value">' . $db . '</span>
                        </div>
                        <div class="info-row">
                            <span class="info-label">Saran:</span>
                            <span class="info-value">Periksa status container Docker</span>
                        </div>
                    </div>
                </div>
                <div class="footer">
                    <p>Silakan jalankan: <code>docker-compose up -d</code></p>
                </div>
            </div>
            ';
        } else {
            $version_query = mysqli_query($conn, "SELECT VERSION()");
            $version_row = mysqli_fetch_array($version_query);
            $mysql_version = $version_row[0];

            echo '
            <div class="card">
                <div class="header success">
                    <div class="status-icon">✅</div>
                    <h1>Sistem Aktif & Berjalan</h1>
                    <p>Konfigurasi Docker dan Database Sempurna</p>
                </div>
                <div class="body">
                    <div class="info-box success">
                        <div class="info-row">
                            <span class="info-label">Status Koneksi:</span>
                            <span class="info-value">🟢 Terhubung</span>
                        </div>
                        <div class="info-row">
                            <span class="info-label">Host Database:</span>
                            <span class="info-value">' . $host . '</span>
                        </div>
                        <div class="info-row">
                            <span class="info-label">Database:</span>
                            <span class="info-value">' . $db . '</span>
                        </div>
                        <div class="info-row">
                            <span class="info-label">MySQL Version:</span>
                            <span class="info-value">' . $mysql_version . '</span>
                        </div>
                    </div>

                    <div style="margin-top: 30px;">
                        <p style="margin-bottom: 15px; color: #495057; font-weight: 500;">Tech Stack:</p>
                        <div class="tech-stack">
                            <span class="badge php">PHP 8.2</span>
                            <span class="badge mysql">MySQL 8.0</span>
                            <span class="badge docker">Docker</span>
                            <span class="badge">Apache</span>
                        </div>
                    </div>
                </div>
                <div class="footer">
                    ✨ Selamat datang! Aplikasi Anda siap untuk dikembangkan.
                </div>
            </div>
            ';

            mysqli_close($conn);
        }
        ?>
    </div>
</body>

</html>