<?php
require_once __DIR__ . '/config.php';

if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

if (empty($_SESSION['csrf_token'])) {
    $_SESSION['csrf_token'] = bin2hex(random_bytes(32));
}

$csrfToken = $_SESSION['csrf_token'];
$delivery_mode = DEFAULT_TRANSPORT;
if (!in_array($delivery_mode, array('auto', 'smtp', 'api', 'server'), true)) {
    $delivery_mode = 'auto';
}

// Initialize default variables
$message_base = "Message Here";
$action = "";
$emaillist = "your_email@yahoo.com";
$ssl_port = "587";
$smtp_timeout = "30";
$my_smtp = "";
$nrotat = "0";
$reconnect = "0";
$isbcc = "";
$nbcc = "50";
$pause = "0";
$pemails = "0";
$from_base = "";
$realname_base = "Support";
$lase = true;
$replyto = "";
$repaslog = true;
$reading = false;
$epriority = "";
$subject_base = "Subject Here";
$encodety = "no";

// Include backend code only when sending
$output = '';
if(!empty($_POST['action']) && $_POST['action'] == 'send') {
    // Capture output for display in result section
    ob_start();
    include 'backend.php';
    $output = ob_get_clean();
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>PHP Mailer</title>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <style>
        @import url('https://fonts.googleapis.com/css2?family=IBM+Plex+Mono:wght@400;500&family=Space+Grotesk:wght@400;500;700&display=swap');

        :root {
            --bg: #f4efe6;
            --bg-accent: #dfeff2;
            --surface: rgba(255, 255, 255, 0.92);
            --surface-strong: #ffffff;
            --surface-soft: #f6f8f6;
            --line: rgba(13, 42, 52, 0.1);
            --line-strong: rgba(13, 42, 52, 0.18);
            --text: #13262f;
            --muted: #60707a;
            --accent: #0e7490;
            --accent-2: #f97316;
            --success: #14865f;
            --danger: #c43d2f;
            --shadow: 0 28px 60px rgba(19, 38, 47, 0.12);
            --radius-xl: 28px;
            --radius-lg: 20px;
            --radius-md: 16px;
            --radius-sm: 12px;
        }

        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        html {
            scroll-behavior: smooth;
        }

        body {
            min-height: 100vh;
            font-family: 'Space Grotesk', 'Trebuchet MS', sans-serif;
            color: var(--text);
            background:
                radial-gradient(circle at top left, rgba(14, 116, 144, 0.18), transparent 28%),
                radial-gradient(circle at top right, rgba(249, 115, 22, 0.16), transparent 24%),
                linear-gradient(180deg, var(--bg) 0%, #fbfaf6 40%, var(--bg-accent) 100%);
            padding: 24px;
        }

        body::before,
        body::after {
            content: '';
            position: fixed;
            border-radius: 999px;
            filter: blur(8px);
            pointer-events: none;
            z-index: 0;
        }

        body::before {
            width: 220px;
            height: 220px;
            background: rgba(14, 116, 144, 0.08);
            top: 14%;
            left: -60px;
        }

        body::after {
            width: 280px;
            height: 280px;
            background: rgba(249, 115, 22, 0.08);
            right: -90px;
            bottom: 12%;
        }

        .container {
            position: relative;
            z-index: 1;
            max-width: 1380px;
            margin: 0 auto;
            background: rgba(255, 255, 255, 0.65);
            backdrop-filter: blur(20px);
            border: 1px solid rgba(255, 255, 255, 0.7);
            border-radius: 32px;
            box-shadow: var(--shadow);
            overflow: hidden;
        }

        .header {
            position: relative;
            display: flex;
            justify-content: space-between;
            gap: 28px;
            padding: 34px 38px;
            cursor: pointer;
            background:
                linear-gradient(135deg, rgba(14, 116, 144, 0.12), rgba(255, 255, 255, 0.6)),
                linear-gradient(120deg, rgba(249, 115, 22, 0.14), transparent 42%);
            border-bottom: 1px solid rgba(19, 38, 47, 0.08);
        }

        .header::after {
            content: '';
            position: absolute;
            inset: auto 38px 0;
            height: 1px;
            background: linear-gradient(90deg, transparent, rgba(19, 38, 47, 0.12), transparent);
        }

        .hero-copy {
            max-width: 760px;
        }

        .hero-kicker {
            display: inline-flex;
            align-items: center;
            gap: 10px;
            padding: 8px 14px;
            border-radius: 999px;
            background: rgba(255, 255, 255, 0.74);
            border: 1px solid rgba(14, 116, 144, 0.14);
            color: var(--accent);
            font-size: 12px;
            font-weight: 700;
            letter-spacing: 0.08em;
            text-transform: uppercase;
            margin-bottom: 18px;
        }

        .hero-kicker::before {
            content: '';
            width: 10px;
            height: 10px;
            border-radius: 999px;
            background: linear-gradient(135deg, var(--accent), var(--accent-2));
            box-shadow: 0 0 0 6px rgba(14, 116, 144, 0.08);
        }

        .hero-title {
            font-size: clamp(2rem, 4vw, 3.3rem);
            line-height: 1;
            font-weight: 700;
            letter-spacing: -0.04em;
            margin-bottom: 12px;
        }

        .hero-subtitle {
            max-width: 60ch;
            color: var(--muted);
            font-size: 15px;
            line-height: 1.7;
        }

        .hero-side {
            display: grid;
            align-content: space-between;
            justify-items: end;
            gap: 18px;
            min-width: 230px;
        }

        .hero-badges {
            display: flex;
            flex-wrap: wrap;
            justify-content: flex-end;
            gap: 10px;
        }

        .hero-badge {
            display: inline-flex;
            align-items: center;
            gap: 8px;
            padding: 10px 14px;
            border-radius: 999px;
            background: rgba(255, 255, 255, 0.72);
            border: 1px solid rgba(19, 38, 47, 0.08);
            color: var(--text);
            font-size: 12px;
            font-weight: 600;
        }

        .hero-badge strong {
            color: var(--accent);
            font-size: 13px;
        }

        .hero-toggle {
            display: inline-flex;
            align-items: center;
            gap: 10px;
            font-size: 13px;
            color: var(--text);
            font-weight: 600;
        }

        .hero-toggle::after {
            content: 'Open guide';
            padding: 10px 14px;
            border-radius: 999px;
            background: linear-gradient(135deg, var(--accent), #0f9bbf);
            color: #fff;
            box-shadow: 0 14px 28px rgba(14, 116, 144, 0.18);
        }

        #instructionPanel {
            padding: 26px 38px !important;
            background:
                linear-gradient(180deg, rgba(255, 255, 255, 0.78), rgba(246, 248, 246, 0.92)) !important;
            border-bottom: 1px solid rgba(19, 38, 47, 0.08) !important;
        }

        .content {
            padding: 34px 38px 38px;
        }

        .workspace-grid {
            display: grid;
            grid-template-columns: minmax(320px, 0.98fr) minmax(0, 1.12fr);
            gap: 24px;
            align-items: start;
        }

        .section {
            background: linear-gradient(180deg, rgba(255, 255, 255, 0.94), rgba(248, 250, 249, 0.96));
            border: 1px solid var(--line);
            border-radius: var(--radius-xl);
            padding: 26px;
            margin-bottom: 24px;
            box-shadow: 0 18px 34px rgba(19, 38, 47, 0.06);
        }

        .workspace-grid > .section {
            height: 100%;
            margin-bottom: 0;
        }

        .section-title {
            display: flex;
            align-items: center;
            gap: 12px;
            font-size: 17px;
            font-weight: 700;
            color: var(--text);
            margin-bottom: 22px;
            padding-bottom: 16px;
            border-bottom: 1px solid rgba(19, 38, 47, 0.08);
            letter-spacing: -0.02em;
        }

        .section-title::before {
            content: '';
            width: 12px;
            height: 12px;
            border-radius: 999px;
            background: linear-gradient(135deg, var(--accent), var(--accent-2));
            box-shadow: 0 0 0 7px rgba(14, 116, 144, 0.08);
        }

        .two-column {
            display: grid;
            grid-template-columns: repeat(2, minmax(0, 1fr));
            gap: 24px;
        }

        .form-group {
            margin-bottom: 18px;
        }

        .form-group label {
            display: block;
            font-size: 12px;
            text-transform: uppercase;
            letter-spacing: 0.08em;
            color: var(--muted);
            margin-bottom: 9px;
            font-weight: 700;
        }

        .section .form-group > div[style*="display: flex"] {
            display: flex !important;
            align-items: flex-start !important;
            gap: 12px !important;
            flex-wrap: wrap;
        }

        .section .form-group > div[style*="display: flex"] > label {
            flex: 0 0 104px;
            min-width: 104px !important;
            margin: 14px 0 0 !important;
            white-space: normal !important;
        }

        .section .form-group > div[style*="display: flex"] > .form-control,
        .section .form-group > div[style*="display: flex"] > select.form-control,
        .section .form-group > div[style*="display: flex"] > input.form-control {
            flex: 1 1 240px;
            width: auto !important;
            min-width: 0;
        }

        .form-control {
            width: 100%;
            border: 1px solid rgba(19, 38, 47, 0.12);
            border-radius: var(--radius-md);
            background: rgba(255, 255, 255, 0.96);
            color: var(--text);
            min-height: 52px;
            padding: 13px 16px;
            font-size: 14px;
            font-family: inherit;
            transition: border-color 0.2s ease, box-shadow 0.2s ease, transform 0.2s ease;
            box-shadow: inset 0 1px 0 rgba(255, 255, 255, 0.8);
        }

        .form-control::placeholder {
            color: #97a5ac;
        }

        .form-control:hover {
            border-color: rgba(14, 116, 144, 0.22);
        }

        .form-control:focus {
            outline: none;
            border-color: rgba(14, 116, 144, 0.55);
            box-shadow: 0 0 0 5px rgba(14, 116, 144, 0.12);
            transform: translateY(-1px);
        }

        .form-control:disabled {
            background: rgba(224, 230, 232, 0.78);
            color: #809098;
        }

        select.form-control {
            appearance: none;
            background-image:
                linear-gradient(45deg, transparent 50%, var(--muted) 50%),
                linear-gradient(135deg, var(--muted) 50%, transparent 50%);
            background-position:
                calc(100% - 22px) calc(50% - 3px),
                calc(100% - 16px) calc(50% - 3px);
            background-size: 6px 6px, 6px 6px;
            background-repeat: no-repeat;
            padding-right: 44px;
        }

        textarea.form-control {
            min-height: 148px;
            resize: vertical;
            line-height: 1.65;
        }

        .checkbox-inline {
            display: inline-flex;
            align-items: center;
            gap: 9px;
            padding: 10px 14px;
            border-radius: 999px;
            background: rgba(250, 250, 249, 0.96);
            border: 1px solid rgba(19, 38, 47, 0.1);
            margin-right: 10px;
            margin-bottom: 10px;
        }

        .checkbox-inline input {
            margin: 0;
            accent-color: var(--accent);
        }

        .checkbox-inline label {
            margin: 0;
            font-size: 13px;
            color: var(--text);
            font-weight: 600;
            text-transform: none;
            letter-spacing: normal;
            cursor: pointer;
        }

        .btn {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            gap: 10px;
            min-height: 48px;
            padding: 12px 18px;
            border: 0;
            border-radius: 999px;
            font-family: inherit;
            font-size: 13px;
            font-weight: 700;
            letter-spacing: 0.02em;
            cursor: pointer;
            transition: transform 0.18s ease, box-shadow 0.18s ease, opacity 0.18s ease;
            box-shadow: 0 14px 26px rgba(19, 38, 47, 0.12);
        }

        .btn:hover {
            transform: translateY(-2px);
        }

        .btn:active {
            transform: translateY(0);
        }

        .btn-primary {
            background: linear-gradient(135deg, var(--accent), #0f9bbf);
            color: white;
        }

        .btn-success {
            background: linear-gradient(135deg, var(--success), #1aa36f);
            color: white;
        }

        .btn-danger {
            background: linear-gradient(135deg, var(--danger), #da604a);
            color: white;
        }

        .btn-danger:disabled {
            background: linear-gradient(135deg, #f0b5ad, #e7cdc7);
            color: #6f2d24;
            opacity: 0.75;
            cursor: not-allowed;
            transform: none;
            box-shadow: none;
        }

        .btn-info {
            background: linear-gradient(135deg, #0f172a, #2a415e);
            color: white;
        }

        .inline-group {
            display: flex;
            align-items: center;
            gap: 10px;
            flex-wrap: wrap;
            padding: 14px;
            background: rgba(248, 250, 249, 0.94);
            border: 1px solid rgba(19, 38, 47, 0.08);
            border-radius: var(--radius-md);
        }

        .inline-group label {
            min-width: 138px;
            margin: 0 !important;
        }

        .inline-group input[type="text"],
        .inline-group input[type="number"],
        .inline-group select {
            flex: 1 1 110px;
            min-width: 92px;
            width: auto;
        }

        .inline-group span {
            font-size: 12px;
            color: var(--muted);
            font-weight: 600;
            text-transform: uppercase;
            letter-spacing: 0.05em;
        }

        #instructionPanel ul {
            list-style: none;
        }

        #instructionPanel strong {
            color: var(--text);
        }

        #instructionPanel a {
            color: var(--accent);
            text-decoration: none;
            font-weight: 700;
        }

        #instructionPanel a:hover {
            text-decoration: underline;
        }

        #instructionPanel > div,
        #instructionPanel > ul {
            max-width: 980px;
        }

        #instructionPanel > div[style*="padding-top"] {
            margin-top: 18px !important;
            padding-top: 18px !important;
            border-top: 1px solid rgba(19, 38, 47, 0.08) !important;
        }

        .help-text {
            font-size: 13px;
            color: var(--muted);
            margin-top: 8px;
            line-height: 1.6;
        }

        .result-box {
            background:
                linear-gradient(180deg, rgba(9, 17, 20, 0.98), rgba(16, 23, 28, 0.98)),
                linear-gradient(180deg, rgba(14, 116, 144, 0.08), transparent);
            border: 1px solid rgba(77, 111, 124, 0.36);
            border-radius: 22px;
            padding: 22px;
            min-height: 240px;
            max-height: 460px;
            overflow-y: auto;
            font-family: 'IBM Plex Mono', monospace;
            font-size: 13px;
            line-height: 1.7;
            color: #dffbe8;
            white-space: pre-wrap;
            word-break: break-word;
            box-shadow: inset 0 1px 0 rgba(255, 255, 255, 0.04);
        }

        #my_smtp {
            font-family: 'IBM Plex Mono', monospace;
            font-size: 12px;
            background: linear-gradient(180deg, #fbfcfc, #f4f8f9);
        }

        #countEmails,
        #countSmtp {
            min-width: 54px;
            padding-inline: 18px !important;
        }

        input[type="file"].form-control {
            padding: 10px 12px;
        }

        @media (max-width: 1160px) {
            .workspace-grid,
            .two-column {
                grid-template-columns: 1fr;
            }

            .hero-side {
                justify-items: start;
            }

            .hero-badges {
                justify-content: flex-start;
            }
        }

        @media (max-width: 780px) {
            body {
                padding: 14px;
            }

            .header,
            #instructionPanel,
            .content {
                padding-left: 20px !important;
                padding-right: 20px !important;
            }

            .header {
                padding-top: 24px;
                padding-bottom: 24px;
                flex-direction: column;
            }

            .hero-title {
                font-size: 2.2rem;
            }

            .hero-toggle::after {
                content: 'Guide';
            }

            .section {
                padding: 20px;
                border-radius: 22px;
            }

            .section .form-group > div[style*="display: flex"] > label {
                flex: 1 1 100%;
                min-width: 100% !important;
                margin-top: 0 !important;
            }

            .section .form-group > div[style*="display: flex"] > .form-control,
            .section .form-group > div[style*="display: flex"] > select.form-control,
            .section .form-group > div[style*="display: flex"] > input.form-control {
                flex-basis: 100%;
                width: 100% !important;
            }

            .inline-group {
                align-items: stretch;
            }

            .inline-group label,
            .inline-group span {
                width: 100%;
                min-width: 100%;
            }

            .btn:not(#countEmails):not(#countSmtp) {
                width: 100%;
            }

            .form-group .btn + .btn {
                margin-top: 10px;
                margin-left: 0 !important;
            }

            .checkbox-inline {
                width: 100%;
                justify-content: flex-start;
            }
        }

        @media (max-width: 520px) {
            .hero-kicker,
            .hero-badge {
                width: 100%;
                justify-content: center;
            }

            .result-box {
                min-height: 220px;
                padding: 18px;
            }
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="header" onclick="toggleInstruction()">
            <div class="hero-copy">
                <span class="hero-kicker">Responsive Mail Console</span>
                <h1 class="hero-title">Mailler Workspace</h1>
                <p class="hero-subtitle">
                    Une interface plus propre pour piloter SMTP, API delivery, sender identity, attachments,
                    and live sending logs from one Railway-ready dashboard.
                </p>
            </div>
            <div class="hero-side">
                <div class="hero-badges">
                    <span class="hero-badge"><strong>4</strong> modes</span>
                    <span class="hero-badge"><strong>Live</strong> logs</span>
                    <span class="hero-badge"><strong>100%</strong> responsive</span>
                </div>
                <span class="hero-toggle">Click anywhere here to toggle the guide</span>
            </div>
        </div>
        
        <!-- INSTRUCTION PANEL -->
        <div id="instructionPanel" style="display: none; padding: 20px; background: #f8f9fa; border-bottom: 1px solid #dee2e6;">
            <div style="margin-bottom: 15px;">
                <strong>How to use:</strong> <a href="#" style="color: #007bff;">Tutorial</a>
            </div>
            
            <ul style="list-style: none; padding-left: 0; font-size: 13px; color: #495057;">
                <li style="margin-bottom: 8px;">
                    <strong>[-email-]</strong> : Receiver Email (emailuser@emaildomain.com)
                    <ul style="margin-left: 20px; margin-top: 5px;">
                        <li><strong>[-emailuser-]</strong> : Email User (emailuser)</li>
                        <li><strong>[-emaildomain-]</strong> : Email User (emaildomain.com)</li>
                    </ul>
                </li>
                <li style="margin-bottom: 8px;"><strong>[-time-]</strong> : Date and Time (03/04/2021 02:41:23 pm)</li>
                <li style="margin-bottom: 8px;"><strong>[-randomstring-]</strong> : Random string (0-9,a-z)</li>
                <li style="margin-bottom: 8px;"><strong>[-randomnumber-]</strong> : Random number (0-9)</li>
                <li style="margin-bottom: 8px;"><strong>[-randomletters-]</strong> : Random Letters(a-z)</li>
                <li style="margin-bottom: 8px;"><strong>[-randommd5-]</strong> : Random MD5</li>
            </ul>
            
            <div style="margin-top: 15px; padding-top: 15px; border-top: 1px solid #dee2e6;">
                <strong style="display: block; margin-bottom: 8px;">example</strong>
                <div style="font-size: 13px; color: #495057;">
                    <p style="margin-bottom: 8px;">Receiver Email = <strong>user@domain.com</strong></p>
                    <ul style="list-style: disc; padding-left: 20px;">
                        <li>hello <strong>[-emailuser-]</strong> = hello <strong>user</strong></li>
                        <li>your domain is <strong>[-emaildomain-]</strong> = Your Domain is <strong>domain.com</strong></li>
                        <li>your code is <strong>[-randommd5-]</strong> = your code is <strong>e10adc3949ba59abbe56e057f20f883e</strong></li>
                    </ul>
                </div>
            </div>
            
            <div style="margin-top: 15px; padding-top: 15px; border-top: 1px solid #dee2e6;">
                <strong style="display: block; margin-bottom: 8px;">Generateur</strong>
                <div style="display: flex; gap: 10px; align-items: center; flex-wrap: wrap;">
                    <div class="checkbox-inline">
                        <input type="checkbox" id="gen_az">
                        <label for="gen_az">(a-z)</label>
                    </div>
                    <div class="checkbox-inline">
                        <input type="checkbox" id="gen_AZ">
                        <label for="gen_AZ">(A-Z)</label>
                    </div>
                    <div class="checkbox-inline">
                        <input type="checkbox" id="gen_09">
                        <label for="gen_09">(0-9)</label>
                    </div>
                    <input type="text" id="gen_length" class="form-control" placeholder="Length" style="width: 80px;">
                    <input type="text" id="gen_pattern" class="form-control" placeholder="Pattern" style="width: 200px;" readonly>
                    <button type="button" class="btn btn-primary" id="getPattern">Get Pattern</button>
                </div>
                <p style="font-size: 12px; color: #6c757d; margin-top: 8px;">You can use the the generated pattern in your message.</p>
            </div>
        </div>
        
        <div class="content">
            <form method="post" action="" enctype="multipart/form-data">
                <input type="hidden" name="csrf_token" id="csrf_token" value="<?php echo htmlspecialchars($csrfToken, ENT_QUOTES, 'UTF-8'); ?>">
                
                <div class="workspace-grid">
                <!-- SERVER SETUP -->
                <div class="section">
                    <div class="section-title">Server Setup</div>
                    <div class="form-group">
                        <div style="display: flex; align-items: center; gap: 10px; flex-wrap: wrap;">
                            <label for="delivery_mode" style="margin: 0; white-space: nowrap; min-width: 90px;">Mode</label>
                            <select name="delivery_mode" id="delivery_mode" class="form-control" style="max-width: 280px;">
                                <option value="auto" <?php if($delivery_mode === 'auto') echo 'selected'; ?>>Auto</option>
                                <option value="smtp" <?php if($delivery_mode === 'smtp') echo 'selected'; ?>>SMTP only</option>
                                <option value="api" <?php if($delivery_mode === 'api') echo 'selected'; ?>>API (Resend)</option>
                                <option value="server" <?php if($delivery_mode === 'server') echo 'selected'; ?>>Server mail only</option>
                            </select>
                        </div>
                        <div class="help-text" id="deliveryHint">Auto uses SMTP when available, then Resend API if configured, then server mail.</div>
                    </div>
                    
                    <div class="two-column">
                        <!-- Left Column -->
                        <div>
                            <div class="form-group">
                                <div style="display: flex; align-items: center; gap: 10px;">
                                    <label style="margin: 0; white-space: nowrap; min-width: 90px;">SMTP Host</label>
                                    <input type="text" id="ip" name="ip" class="form-control" placeholder="SMTP Host">
                                </div>
                            </div>
                            
                            <div class="form-group">
                                <div style="display: flex; align-items: center; gap: 10px;">
                                    <label style="margin: 0; white-space: nowrap; min-width: 90px;">Username</label>
                                    <input type="text" id="user" name="user" class="form-control" placeholder="SMTP Username">
                                </div>
                            </div>
                            
                            <div class="form-group">
                                <div style="display: flex; align-items: center; gap: 10px;">
                                    <label style="margin: 0; white-space: nowrap; min-width: 90px;">Password</label>
                                    <input type="password" id="pass" name="pass" class="form-control" placeholder="SMTP Password">
                                </div>
                            </div>
                            
                            <div class="form-group">
                                <div style="display: flex; align-items: center; gap: 10px;">
                                    <label style="margin: 0; white-space: nowrap; min-width: 90px;">Port</label>
                                    <input type="text" name="ssl_port" id="ssl_port" value="<?php echo $ssl_port;?>" class="form-control" placeholder="587">
                                </div>
                            </div>
                            
                            <div class="form-group">
                                <div style="display: flex; align-items: center; gap: 10px;">
                                    <label style="margin: 0; white-space: nowrap; min-width: 90px;">Security</label>
                                    <div>
                                        <div class="checkbox-inline">
                                            <input type="radio" name="SSLTLS" value="TLS" id="tls" checked>
                                            <label for="tls">TLS</label>
                                        </div>
                                        <div class="checkbox-inline">
                                            <input type="radio" name="SSLTLS" value="SSL" id="ssl">
                                            <label for="ssl">SSL</label>
                                        </div>
                                        <div class="checkbox-inline">
                                            <input type="radio" name="SSLTLS" value="NON" id="non">
                                            <label for="non">None</label>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            
                            <div class="form-group">
                                <div style="display: flex; align-items: center; gap: 10px;">
                                    <label style="margin: 0; white-space: nowrap; min-width: 90px;">Is bcc</label>
                                    <div class="checkbox-inline">
                                        <input type="checkbox" name="isbcc" value="true" id="isbcc" <?php if($isbcc=="true") echo "checked"; ?>>
                                        <label for="isbcc">Yes</label>
                                    </div>
                                </div>
                            </div>
                            
                            <div class="form-group">
                                <button type="button" class="btn btn-primary" id="add">Add SMTP</button>
                            </div>
                        </div>
                        
                        <!-- Right Column -->
                        <div>
                            <div class="form-group">
                                <label>SMTP list</label>
                                <div style="background: #f8f9fa; border: 1px solid #ced4da; border-radius: 4px 4px 0 0; padding: 8px 10px; font-size: 11px; color: #6c757d; font-weight: 500;">
                                    SMTP Host | Port | Username | Password | Security | IsBcc
                                </div>
                                <textarea name="my_smtp" id="my_smtp" class="form-control" style="border-radius: 0 0 4px 4px; border-top: none; min-height: 100px; max-height: 150px; font-family: monospace; font-size: 12px; resize: vertical;"><?php echo $my_smtp;?></textarea>
                                <div style="margin-top: 5px; display: flex; gap: 8px; align-items: center;">
                                    <button type="button" class="btn btn-info" id="reset">Reset</button>
                                    <button type="button" class="btn btn-info" id="countSmtp" style="font-size: 12px; padding: 4px 8px;">
                                        <span id="smtpCount">0</span>
                                    </button>
                                </div>
                            </div>
                            
                            <div class="form-group">
                                <div class="inline-group">
                                    <label style="min-width: 140px;">Change SMTP every</label>
                                    <input name="nrotat" type="text" value="<?php echo $nrotat;?>" class="form-control">
                                    <span>Email</span>
                                </div>
                            </div>
                            
                            <div class="form-group">
                                <div class="inline-group">
                                    <label style="min-width: 140px;">Pause</label>
                                    <input type="text" name="pause" value="<?php echo $pause;?>" class="form-control">
                                    <span>Seconds every</span>
                                    <input type="text" name="pemails" value="<?php echo $pemails;?>" class="form-control">
                                </div>
                            </div>
                            
                            <div class="form-group">
                                <label>Email (1 bcc = 1 email)</label>
                            </div>
                            
                            <div class="form-group">
                                <div class="inline-group">
                                    <label style="min-width: 140px;">Reconnect after</label>
                                    <input type="text" name="reconnect" value="<?php echo $reconnect;?>" class="form-control">
                                    <span>Emails</span>
                                </div>
                            </div>

                            <div class="form-group">
                                <div class="inline-group">
                                    <label style="min-width: 140px;">SMTP timeout</label>
                                    <input type="number" min="5" max="300" name="smtp_timeout" id="smtp_timeout" value="<?php echo $smtp_timeout;?>" class="form-control">
                                    <span>Seconds</span>
                                </div>
                            </div>
                            
                            <div class="form-group">
                                <div class="inline-group">
                                    <label style="min-width: 140px;">Num of emails in bcc</label>
                                    <input type="text" name="nbcc" value="<?php echo $nbcc;?>" class="form-control">
                                    <span>Emails</span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- MESSAGE SETUP -->
                <div class="section">
                    <div class="section-title">Message Setup</div>
                    
                    <div class="two-column">
                        <!-- Left Column -->
                        <div>
                            <div class="form-group">
                                <div style="display: flex; align-items: center; gap: 15px;">
                                    <label style="margin: 0; white-space: nowrap; min-width: 90px;">Sender email</label>
                                    <input type="text" name="from" id="from" value="<?php if(!$lase) echo $from_base;?>" class="form-control" placeholder="Sender email" <?php if($lase) echo "disabled"?> style="width: 250px;">
                                    <div class="checkbox-inline">
                                        <input type="checkbox" name="lase" value="true" id="lase" <?php if($lase) echo "checked"; ?> checked>
                                        <label for="lase">Sender email as login</label>
                                    </div>
                                </div>
                            </div>
                            
                            <div class="form-group">
                                <div style="display: flex; align-items: center; gap: 15px;">
                                    <label style="margin: 0; white-space: nowrap; min-width: 90px;">Reply-To</label>
                                    <input type="text" name="replyto" id="replyto" value="<?php if(!$repaslog) echo $replyto;?>" class="form-control" placeholder="Reply-To Email" <?php if($repaslog) echo "disabled";?> style="width: 250px;">
                                    <div class="checkbox-inline">
                                        <input type="checkbox" name="repaslog" value="true" id="repaslog" <?php if($repaslog) echo "checked"; ?> checked>
                                        <label for="repaslog">Reply-To as login</label>
                                    </div>
                                </div>
                            </div>
                            
                            <div class="form-group">
                                <div style="display: flex; align-items: center; gap: 15px;">
                                    <label style="margin: 0; white-space: nowrap; min-width: 90px;">Subject</label>
                                    <input type="text" name="subject" id="subject" value="<?php echo $subject_base;?>" class="form-control" placeholder="Subject Here" style="width: 250px;">
                                    <div class="checkbox-inline">
                                        <input type="checkbox" name="readingconf" value="true" id="readingconf" <?php if($reading) echo "checked"; ?>>
                                        <label for="readingconf">Debug Mode</label>
                                    </div>
                                </div>
                            </div>
                            
                            <div class="form-group">
                                <label>Message</label>
                                <textarea name="message" id="message" class="form-control" placeholder="Message Here"><?php echo $message_base;?></textarea>
                            </div>
                            
                            <div class="form-group">
                                <div class="checkbox-inline">
                                    <input type="radio" name="contenttype" value="plain" id="plain">
                                    <label for="plain">Text</label>
                                </div>
                                <div class="checkbox-inline">
                                    <input type="radio" name="contenttype" value="html" id="html" checked>
                                    <label for="html">Html</label>
                                </div>
                            </div>
                            
                            <div class="form-group">
                                <button type="button" class="btn btn-success" id="sendBtn">Send message</button>
                                <button type="button" class="btn btn-danger" id="stopBtn" style="display: none; margin-left: 10px;">Stop Sending</button>
                            </div>
                        </div>
                        
                        <!-- Right Column -->
                        <div>
                            <div class="form-group">
                                <div style="display: flex; align-items: center; gap: 10px;">
                                    <label style="margin: 0; white-space: nowrap; min-width: 90px;">Sender name</label>
                                    <input type="text" name="realname" id="realname" value="<?php echo $realname_base;?>" class="form-control" placeholder="Support">
                                </div>
                            </div>
                            
                            <div class="form-group">
                                <div style="display: flex; align-items: center; gap: 10px;">
                                    <label style="margin: 0; white-space: nowrap; min-width: 90px;">Priority</label>
                                    <select name="epriority" id="epriority" class="form-control">
                                        <option value="" <?php if(strlen($epriority)< 1){print "selected";} ?>>NO PRIORITY</option>
                                        <option value="1" <?php if($epriority == "1"){print "selected";} ?>>High</option>
                                        <option value="3" <?php if($epriority == "3"){print "selected";} ?>>Normal</option>
                                        <option value="5" <?php if($epriority == "5"){print "selected";} ?>>Low</option>
                                    </select>
                                </div>
                            </div>
                            
                            <div class="form-group">
                                <div style="display: flex; align-items: center; gap: 10px;">
                                    <label style="margin: 0; white-space: nowrap; min-width: 90px; line-height: 1.2;">Encoding /<br>Charset</label>
                                    <div style="display: flex; gap: 10px; flex: 1;">
                                        <select name="encodety" id="encodety" class="form-control">
                                            <option value="no" <?php if($encodety == "no"){print "selected";} ?>>NO</option>
                                            <option value="8bit" <?php if($encodety == "8bit"){print "selected";} ?>>8bit</option>
                                            <option value="7bit" <?php if($encodety == "7bit"){print "selected";} ?>>7bit</option>
                                            <option value="binary" <?php if($encodety == "binary"){print "selected";} ?>>Binary</option>
                                            <option value="base64" <?php if($encodety == "base64"){print "selected";} ?>>Base64</option>
                                            <option value="quoted-printable" <?php if($encodety == "quoted-printable"){print "selected";} ?>>Quoted-Printable</option>
                                        </select>
                                        <select name="charset" class="form-control">
                                            <option value="">NO CHARSET</option>
                                            <option value="utf-8">Unicode -> utf-8</option>
                                            <option value="utf-7">Unicode -> utf-7</option>
                                            <option value="us-ascii">Unicode -> us-ascii</option>
                                            <option value="iso-10646-ucs-2">Unicode -> iso-10646-ucs-2</option>
                                            <option value="iso-8859-6">Arabic -> iso-8859-6</option>
                                            <option value="x-mac-arabic">Arabic -> x-mac-arabic</option>
                                            <option value="windows-1256">Arabic -> windows-1256</option>
                                            <option value="iso-8859-4">Baltic -> iso-8859-4</option>
                                            <option value="windows-1257">Baltic -> windows-1257</option>
                                            <option value="iso-8859-2">Central European -> iso-8859-2</option>
                                            <option value="x-mac-ce">Central European -> x-mac-ce</option>
                                            <option value="windows-1250">Central European -> windows-1250</option>
                                            <option value="euc-cn">Chinese -> euc-cn</option>
                                            <option value="gb2312">Chinese -> gb2312</option>
                                            <option value="hz-gb-2312">Chinese -> hz-gb-2312</option>
                                            <option value="x-mac-chinesesimp">Chinese -> x-mac-chinesesimp</option>
                                            <option value="cp-936">Chinese -> cp-936</option>
                                            <option value="big5">Chinese -> big5</option>
                                            <option value="x-mac-chinesetrad">Chinese -> x-mac-chinesetrad</option>
                                            <option value="cp-950">Chinese -> cp-950</option>
                                            <option value="cp-932">Chinese -> cp-932</option>
                                            <option value="euc-tw">Chinese -> euc-tw</option>
                                            <option value="x-chinese-cns">Chinese -> x-chinese-cns</option>
                                            <option value="x-chinese-eten">Chinese -> x-chinese-eten</option>
                                            <option value="iso-8859-5">Cyrillic -> iso-8859-5</option>
                                            <option value="koi8-r">Cyrillic -> koi8-r</option>
                                            <option value="windows-1251">Cyrillic -> windows-1251</option>
                                            <option value="x-mac-cyrillic">Cyrillic -> x-mac-cyrillic</option>
                                            <option value="iso-8859-7">Greek -> iso-8859-7</option>
                                            <option value="windows-1253">Greek -> windows-1253</option>
                                            <option value="x-mac-greek">Greek -> x-mac-greek</option>
                                            <option value="iso-8859-8">Hebrew -> iso-8859-8</option>
                                            <option value="windows-1255">Hebrew -> windows-1255</option>
                                            <option value="euc-jp">Japanese -> euc-jp</option>
                                            <option value="shift_jis">Japanese -> shift_jis</option>
                                            <option value="iso-2022-jp">Japanese -> iso-2022-jp</option>
                                            <option value="euc-kr">Korean -> euc-kr</option>
                                            <option value="iso-2022-kr">Korean -> iso-2022-kr</option>
                                            <option value="iso-8859-10">Nordic -> iso-8859-10</option>
                                            <option value="iso-8859-3">South European -> iso-8859-3</option>
                                            <option value="iso-8859-15">Western European -> iso-8859-15</option>
                                            <option value="iso-8859-1">Western European -> iso-8859-1</option>
                                            <option value="windows-1252">Western European -> windows-1252</option>
                                        </select>
                                    </div>
                                </div>
                            </div>
                            
                            <div class="form-group">
                                <div style="display: flex; align-items: center; gap: 10px;">
                                    <label style="margin: 0; white-space: nowrap; min-width: 90px;">Attachment</label>
                                    <input name="userfile" type="file" class="form-control">
                                </div>
                            </div>
                            
                            <div class="form-group">
                                <label>Emails</label>
                                <textarea name="emaillist" id="emaillist" class="form-control" placeholder="Emails Here"><?php echo $emaillist;?></textarea>
                                <div style="margin-top: 5px;">
                                    <button type="button" class="btn btn-info" id="countEmails" style="font-size: 12px; padding: 4px 8px;">
                                        <span id="emailCount">0</span>
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                </div>

                <!-- RESULT -->
                <div class="section" id="resultSection" style="display: none;">
                    <div class="section-title">Result</div>
                    <div class="result-box" id="resultBox">
                        <!-- Results will appear here -->
                    </div>
                </div>

                <input type="hidden" name="action" value="send">
                <input type="hidden" name="dbg" value="0">
            </form>
        </div>
    </div>

    <script>
        function toggleInstruction() {
            var panel = document.getElementById('instructionPanel');
            if(panel.style.display === 'none') {
                panel.style.display = 'block';
            } else {
                panel.style.display = 'none';
            }
        }

        $(document).ready(function(){
            const csrfToken = <?php echo json_encode($csrfToken); ?>;
            const defaultDeliveryMode = <?php echo json_encode($delivery_mode); ?>;
            let resultStreamBuffer = '';

            function normalizeResultChunk(text) {
                if (typeof text !== 'string' || text.length === 0) {
                    return '';
                }

                if (text.indexOf('<') === -1 && text.indexOf('&') === -1) {
                    return text;
                }

                var normalized = text
                    .replace(/<br\s*\/?>/gi, '\n')
                    .replace(/<\/div\s*>/gi, '\n')
                    .replace(/<\/p\s*>/gi, '\n')
                    .replace(/<\/li\s*>/gi, '\n');

                var temp = document.createElement('div');
                temp.innerHTML = normalized;

                var parsed = temp.textContent || temp.innerText || '';
                parsed = parsed.replace(/\u00a0/g, ' ');
                parsed = parsed.replace(/\n{3,}/g, '\n\n');

                return parsed;
            }

            function appendResultChunk(text) {
                if (typeof text !== 'string' || text.length === 0) {
                    return;
                }

                resultStreamBuffer += normalizeResultChunk(text);
                $('#resultBox').text(resultStreamBuffer);

                var resultBox = document.getElementById('resultBox');
                resultBox.scrollTop = resultBox.scrollHeight;
            }

            function resetResultBox() {
                resultStreamBuffer = '';
                $('#resultBox').text('');
            }

            function updateDeliveryModeState() {
                var mode = $('#delivery_mode').val() || defaultDeliveryMode;
                var forceManualSender = mode === 'server' || mode === 'api';
                var hint = 'Auto uses SMTP when available, then Resend API if configured, then server mail.';

                if (mode === 'smtp') {
                    hint = 'SMTP only uses your SMTP list first, then environment SMTP when it is configured on Railway.';
                } else if (mode === 'api') {
                    hint = 'API mode sends through Resend with RESEND_API_KEY. This is the recommended non-SMTP option on Railway.';
                } else if (mode === 'server') {
                    hint = 'Server mail uses PHP mail()/local mail transport. On Railway this only works when the runtime supports mail sending.';
                }

                $('#deliveryHint').text(hint);

                if (forceManualSender) {
                    $('input[name=lase]').prop('checked', false);
                    $('input[name=repaslog]').prop('checked', false);
                }

                $('input[name=lase]').prop('disabled', forceManualSender);
                $('input[name=repaslog]').prop('disabled', forceManualSender);

                if ($('input[name=lase]').prop('checked') && !forceManualSender) {
                    $('#from').attr('disabled', 'disabled');
                    $('#from').val('');
                } else {
                    $('#from').removeAttr('disabled');
                }

                if ($('input[name=repaslog]').prop('checked') && !forceManualSender) {
                    $('#replyto').attr('disabled', 'disabled');
                    $('#replyto').val('');
                } else {
                    $('#replyto').removeAttr('disabled');
                }
            }

            // Pattern Generator in Instruction
            $("#getPattern").click(function(){
                if($("#gen_az").prop("checked") || $("#gen_AZ").prop("checked") || $("#gen_09").prop("checked") && $("#gen_length").val() != "") {
                    var pattern = "##";
                    if($("#gen_az").prop("checked")) {
                        pattern += "az-";
                    }
                    if($("#gen_AZ").prop("checked")) {
                        pattern += "AZ-";
                    }
                    if($("#gen_09").prop("checked")) {
                        pattern += "09-";
                    }
                    if($("#gen_length").val() != "") {
                        pattern += "{"+$("#gen_length").val()+ "}";
                    }
                    pattern += "##";
                    $("#gen_pattern").val(pattern);
                } else {
                    $("#gen_pattern").val("");
                }
            });

            // Ensure TLS is selected by default when nothing stored
            $('input[name=SSLTLS][value="TLS"]').prop('checked', true);

            // Load saved data
            loadFormData();
            updateDeliveryModeState();

            // Clean up any legacy SMTP entries (e.g. undefined security values)
            sanitizeSmtpList({ skipSave: true, skipCounts: true });

            // Add SMTP
            $("#add").click(function(){
                var host = $('#ip').val().trim();
                var port = $('#ssl_port').val().trim() || '587';
                var username = $('#user').val().trim();
                var password = $('#pass').val();
                var security = $('input[name=SSLTLS]:checked').val();

                if(host === '' || username === '' || password === '') {
                    alert('Please fill SMTP host, username, and password before adding.');
                    return;
                }
                if(port === '' || isNaN(port)) {
                    alert('Please provide a valid numeric port.');
                    return;
                }
                if(!security) {
                    security = 'TLS';
                    $('input[name=SSLTLS][value="TLS"]').prop('checked', true);
                }

                security = security.toUpperCase();
                if(security === 'NONE') {
                    security = 'NON';
                } else if(security === 'STARTTLS' || security === 'START_TLS') {
                    security = 'TLS';
                }

                var smtpLine = host + '|' + port + '|' + username + '|' + password + '|' + security;
                if($('input[name=isbcc]').prop('checked')) {
                    smtpLine += '|BCC';
                } else {
                    smtpLine += '|NOBCC';
                }
                
                var current = $('#my_smtp').val().trim();
                if(current === "") {
                    $('#my_smtp').val(smtpLine);
                } else {
                    $('#my_smtp').val(current + '\n' + smtpLine);
                }
                
                $('#ip').val('');
                $('#user').val('');
                $('#pass').val('');
                $('#ssl_port').val(port);
                $('input[name=SSLTLS][value="'+security+'"]').prop('checked', true);
                countSmtp(); // Update SMTP count
                saveFormData();
            });

            // Reset SMTP
            $("#reset").click(function(){
                $('#my_smtp').val('');
                countSmtp(); // Update SMTP count
                saveFormData();
            });

            // Sender email as login
            $("input[name=lase]").click(function(){
                updateDeliveryModeState();
                saveFormData();
            });

            // Reply-To as login
            $("input[name=repaslog]").click(function(){
                updateDeliveryModeState();
                saveFormData();
            });

            $('#delivery_mode').on('change', function() {
                updateDeliveryModeState();
                saveFormData();
            });

            // Count emails - only valid emails with @
            function countEmails() {
                var emailText = $('#emaillist').val().trim();
                if(emailText === '') {
                    $('#emailCount').text('0');
                    return;
                }
                var emails = emailText.split('\n').filter(function(line) {
                    var email = line.trim();
                    // Count only non-empty lines that contain @
                    return email !== '' && email.indexOf('@') !== -1;
                });
                $('#emailCount').text(emails.length);
            }
            
            // Count SMTP servers
            function countSmtp() {
                var smtpText = $('#my_smtp').val().trim();
                if(smtpText === '') {
                    $('#smtpCount').text('0');
                    return;
                }
                var smtps = smtpText.split('\n').filter(function(line) {
                    return line.trim() !== '';
                });
                $('#smtpCount').text(smtps.length);
            }

            function sanitizeSmtpList(options) {
                var raw = $('#my_smtp').val();
                if(typeof raw !== 'string' || raw.trim() === '') {
                    if(!(options && options.skipCounts)) {
                        $('#smtpCount').text('0');
                    }
                    return false;
                }

                var lines = raw.split(/\r?\n/);
                var changed = false;
                var sanitized = lines.map(function(line) {
                    var trimmedLine = line.trim();
                    if(trimmedLine === '') {
                        return '';
                    }
                    var parts = trimmedLine.split('|');
                    if(parts.length < 4) {
                        return trimmedLine;
                    }

                    var port = (parts[1] || '').toString().trim();
                    var securityToken = (parts[4] || '').toString().trim().toUpperCase();

                    if(securityToken === 'NONE') {
                        securityToken = 'NON';
                    } else if(securityToken === 'STARTTLS' || securityToken === 'START_TLS') {
                        securityToken = 'TLS';
                    }

                    if(['SSL', 'TLS', 'NON', ''].indexOf(securityToken) === -1) {
                        if(port === '465') {
                            securityToken = 'SSL';
                        } else if(port === '587') {
                            securityToken = 'TLS';
                        } else {
                            securityToken = 'NON';
                        }
                    }

                    if(parts[4] !== securityToken) {
                        parts[4] = securityToken;
                        changed = true;
                    }

                    return parts.join('|');
                }).filter(function(line) {
                    return line !== '';
                });

                if(changed) {
                    $('#my_smtp').val(sanitized.join('\n'));
                    if(!(options && options.skipCounts)) {
                        countSmtp();
                    }
                    if(!(options && options.skipSave)) {
                        saveFormData();
                    }
                }

                return changed;
            }
            
            // Update count on textarea change
            $('#emaillist').on('input', function() {
                countEmails();
            });
            
            $('#my_smtp').on('input', function() {
                countSmtp();
            });
            
            // Initial counts
            countEmails();
            countSmtp();
            
            // Auto-save
            $('input, textarea, select').on('change', function() {
                saveFormData();
            });

            // Save to localStorage
            function saveFormData() {
                var sanitized = sanitizeSmtpList({ skipSave: true, skipCounts: true });
                if(sanitized) {
                    countSmtp();
                }

                var formData = {
                    ip: $('#ip').val(),
                    ssl_port: $('#ssl_port').val(),
                    user: $('#user').val(),
                    my_smtp: $('#my_smtp').val(),
                    delivery_mode: $('#delivery_mode').val(),
                    nrotat: $('input[name=nrotat]').val(),
                    reconnect: $('input[name=reconnect]').val(),
                    smtp_timeout: $('#smtp_timeout').val(),
                    isbcc: $('input[name=isbcc]').prop('checked'),
                    nbcc: $('input[name=nbcc]').val(),
                    pause: $('input[name=pause]').val(),
                    pemails: $('input[name=pemails]').val(),
                    SSLTLS: $('input[name=SSLTLS]:checked').val(),
                    from: $('#from').val(),
                    realname: $('#realname').val(),
                    lase: $('input[name=lase]').prop('checked'),
                    replyto: $('#replyto').val(),
                    repaslog: $('input[name=repaslog]').prop('checked'),
                    readingconf: $('input[name=readingconf]').prop('checked'),
                    epriority: $('#epriority').val(),
                    subject: $('#subject').val(),
                    encodety: $('#encodety').val(),
                    charset: $('select[name=charset]').val(),
                    message: $('#message').val(),
                    emaillist: $('#emaillist').val(),
                    contenttype: $('input[name=contenttype]:checked').val()
                };
                localStorage.setItem('mailerFormData', JSON.stringify(formData));
            }

            // Load from localStorage
            function loadFormData() {
                var sanitized = false;
                var savedData = localStorage.getItem('mailerFormData');
                if(savedData) {
                    var formData = JSON.parse(savedData);
                    
                    $('#ip').val(formData.ip || '');
                    $('#ssl_port').val(formData.ssl_port || '587');
                    $('#user').val(formData.user || '');
                    $('#my_smtp').val(formData.my_smtp || '');
                    $('#delivery_mode').val(formData.delivery_mode || defaultDeliveryMode);
                    sanitized = sanitizeSmtpList({ skipSave: true, skipCounts: true }) || sanitized;
                    $('#smtp_timeout').val(formData.smtp_timeout || '30');
                    $('input[name=nrotat]').val(formData.nrotat || '0');
                    $('input[name=reconnect]').val(formData.reconnect || '0');
                    $('input[name=isbcc]').prop('checked', formData.isbcc || false);
                    $('input[name=nbcc]').val(formData.nbcc || '50');
                    $('input[name=pause]').val(formData.pause || '0');
                    $('input[name=pemails]').val(formData.pemails || '0');
                    
                    if(formData.SSLTLS) {
                        $('input[name=SSLTLS][value="'+formData.SSLTLS+'"]').prop('checked', true);
                    }
                    
                    $('#from').val(formData.from || '');
                    $('#realname').val(formData.realname || 'Support');
                    
                    // Set lase checkbox - default to true if not set
                    if(formData.hasOwnProperty('lase')) {
                        $('input[name=lase]').prop('checked', formData.lase);
                    } else {
                        $('input[name=lase]').prop('checked', true);
                    }
                    
                    $('#replyto').val(formData.replyto || '');
                    
                    // Set repaslog checkbox - default to true if not set
                    if(formData.hasOwnProperty('repaslog')) {
                        $('input[name=repaslog]').prop('checked', formData.repaslog);
                    } else {
                        $('input[name=repaslog]').prop('checked', true);
                    }
                    
                    $('input[name=readingconf]').prop('checked', formData.readingconf || false);
                    
                    $('#epriority').val(formData.epriority || '');
                    $('#subject').val(formData.subject || 'Subject Here');
                    $('#encodety').val(formData.encodety || 'no');
                    $('select[name=charset]').val(formData.charset || '');
                    $('#message').val(formData.message || 'Message Here');
                    $('#emaillist').val(formData.emaillist || 'your_email@yahoo.com');
                    
                    if(formData.contenttype) {
                        $('input[name=contenttype][value="'+formData.contenttype+'"]').prop('checked', true);
                    }
                }

                if(sanitized) {
                    countSmtp();
                    saveFormData();
                }

                updateDeliveryModeState();
            }

            // Stop Sending Handler
            $('#stopBtn').click(function(e) {
                e.preventDefault();
                
                // Disable stop button to prevent multiple clicks
                $('#stopBtn').prop('disabled', true).text('Stopping...');
                
                // Send stop signal to backend
                $.post('check_stop.php', { action: 'stop', csrf_token: csrfToken }, function(response) {
                    appendResultChunk('\n[WARN] Stop signal sent. Waiting for the current email to finish.\n');
                }).fail(function() {
                    appendResultChunk('\n[ERROR] Failed to send stop signal.\n');
                    $('#stopBtn').prop('disabled', false).text('Stop Sending');
                });
            });

            // AJAX Email Sending with Real-Time Streaming
            $('#sendBtn').click(function(e) {
                e.preventDefault();
                
                // Show result section
                $('#resultSection').show();
                resetResultBox();
                
                // Disable send button and show stop button
                $('#sendBtn').prop('disabled', true).text('Sending...');
                $('#stopBtn').show().prop('disabled', false).text('Stop Sending');
                
                // Prepare form data
                var sanitizedDuringSend = sanitizeSmtpList({ skipSave: true, skipCounts: true });
                if(sanitizedDuringSend) {
                    countSmtp();
                    saveFormData();
                }

                var formData = new FormData();
                formData.append('action', 'send');
                formData.append('csrf_token', csrfToken);
                formData.append('dbg', '0');
                formData.append('delivery_mode', $('#delivery_mode').val());
                formData.append('from', $('input[name=from]').val());
                formData.append('realname', $('input[name=realname]').val());
                formData.append('replyto', $('input[name=replyto]').val());
                formData.append('subject', $('input[name=subject]').val());
                formData.append('message', $('textarea[name=message]').val());
                formData.append('emaillist', $('textarea[name=emaillist]').val());
                formData.append('my_smtp', $('textarea[name=my_smtp]').val());
                formData.append('ssl_port', $('input[name=ssl_port]').val());
                formData.append('nrotat', $('input[name=nrotat]').val());
                formData.append('reconnect', $('input[name=reconnect]').val());
                formData.append('smtp_timeout', $('#smtp_timeout').val());
                formData.append('nbcc', $('input[name=nbcc]').val());
                formData.append('pause', $('input[name=pause]').val());
                formData.append('pemails', $('input[name=pemails]').val());
                formData.append('epriority', $('select[name=epriority]').val());
                formData.append('encodety', $('select[name=encodety]').val());
                formData.append('contenttype', $('input[name=contenttype]:checked').val());
                
                if($('input[name=lase]').prop('checked')) {
                    formData.append('lase', 'true');
                }
                if($('input[name=repaslog]').prop('checked')) {
                    formData.append('repaslog', 'true');
                }
                if($('input[name=readingconf]').prop('checked')) {
                    formData.append('readingconf', 'true');
                }
                if($('input[name=isbcc]').prop('checked')) {
                    formData.append('isbcc', 'true');
                }
                
                // Add file if selected
                var fileInput = $('input[name=userfile]')[0];
                if(fileInput.files.length > 0) {
                    formData.append('userfile', fileInput.files[0]);
                }
                
                // Use fetch API for streaming support
                fetch('send.php', {
                    method: 'POST',
                    body: formData
                }).then(response => {
                    if(!response.ok || !response.body) {
                        throw new Error('HTTP ' + response.status);
                    }

                    const reader = response.body.getReader();
                    const decoder = new TextDecoder();
                    
                    function readStream() {
                        reader.read().then(({done, value}) => {
                            if (done) {
                                const finalChunk = decoder.decode();
                                if(finalChunk) {
                                    appendResultChunk(finalChunk);
                                }
                                $('#sendBtn').prop('disabled', false).text('Send message');
                                $('#stopBtn').hide();
                                return;
                            }
                            
                            // Decode and append new content
                            const text = decoder.decode(value, {stream: true});
                            appendResultChunk(text);
                            
                            // Continue reading
                            readStream();
                        });
                    }
                    
                    readStream();
                }).catch(error => {
                    resetResultBox();
                    appendResultChunk('[ERROR] ' + error);
                    $('#sendBtn').prop('disabled', false).text('Send message');
                    $('#stopBtn').hide();
                });
            });
        });
    </script>
</body>
</html>
