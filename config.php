<?php
/**
 * Mailler Configuration for Railway + Local
 * Set these as Railway environment variables or standard process env vars.
 */

if (!function_exists('mailler_env')) {
    function mailler_env($keys, $default = '')
    {
        foreach ((array) $keys as $key) {
            if (!is_string($key) || $key === '') {
                continue;
            }

            $value = $_ENV[$key] ?? $_SERVER[$key] ?? getenv($key);
            if ($value !== false && $value !== null && $value !== '') {
                return $value;
            }
        }

        return $default;
    }
}

if (!function_exists('mailler_bool_env')) {
    function mailler_bool_env($keys, $default = false)
    {
        $value = mailler_env($keys, $default ? '1' : '0');
        return filter_var($value, FILTER_VALIDATE_BOOLEAN);
    }
}

if (!function_exists('mailler_default_sender_domain')) {
    function mailler_default_sender_domain()
    {
        $railwayUrl = (string) mailler_env(array('RAILWAY_STATIC_URL', 'RAILWAY_PUBLIC_DOMAIN'), '');
        $appUrl = (string) mailler_env(array('APP_URL'), '');

        $host = '';
        foreach (array($appUrl, $railwayUrl) as $url) {
            if ($url === '') {
                continue;
            }

            $candidateHost = parse_url($url, PHP_URL_HOST);
            if (!empty($candidateHost)) {
                $host = $candidateHost;
                break;
            }

            if (strpos($url, '.') !== false && strpos($url, '://') === false) {
                $host = $url;
                break;
            }
        }

        if ($host === '') {
            $host = 'localhost.localdomain';
        }

        return strtolower(trim($host));
    }
}

if (!defined('SMTP_HOST')) {
    define('SMTP_HOST', (string) mailler_env(array('SMTP_HOST', 'smtp_server'), ''));
}
if (!defined('SMTP_PORT')) {
    define('SMTP_PORT', (string) mailler_env(array('SMTP_PORT', 'smtp_port'), '587'));
}
if (!defined('SMTP_USER')) {
    define('SMTP_USER', (string) mailler_env(array('SMTP_USER', 'smtp_username'), ''));
}
if (!defined('SMTP_PASS')) {
    define('SMTP_PASS', (string) mailler_env(array('SMTP_PASS', 'smtp_password'), ''));
}
if (!defined('SMTP_SECURE')) {
    define('SMTP_SECURE', strtolower((string) mailler_env(array('SMTP_SECURE', 'smtp_secure'), 'tls')));
}
if (!defined('DEFAULT_TRANSPORT')) {
    define('DEFAULT_TRANSPORT', strtolower((string) mailler_env(array('DEFAULT_TRANSPORT', 'MAIL_TRANSPORT'), 'auto')));
}
if (!defined('RESEND_API_KEY')) {
    define('RESEND_API_KEY', (string) mailler_env(array('RESEND_API_KEY'), ''));
}
if (!defined('RESEND_API_URL')) {
    define('RESEND_API_URL', (string) mailler_env(array('RESEND_API_URL'), 'https://api.resend.com/emails'));
}
if (!defined('RESEND_FROM_EMAIL')) {
    define('RESEND_FROM_EMAIL', (string) mailler_env(array('RESEND_FROM_EMAIL'), 'onboarding@resend.dev'));
}
if (!defined('RESEND_FROM_NAME')) {
    define('RESEND_FROM_NAME', (string) mailler_env(array('RESEND_FROM_NAME'), 'Mailler API'));
}

if (!defined('FALLBACK_SENDER')) {
    define('FALLBACK_SENDER', (string) mailler_env(array('FALLBACK_SENDER', 'MAIL_FROM'), 'no-reply@' . mailler_default_sender_domain()));
}
if (!defined('FALLBACK_NAME')) {
    define('FALLBACK_NAME', (string) mailler_env(array('FALLBACK_NAME', 'MAIL_FROM_NAME'), 'Mailler Service'));
}
if (!defined('BOUNCE_EMAIL')) {
    define('BOUNCE_EMAIL', (string) mailler_env(array('BOUNCE_EMAIL', 'MAIL_RETURN_PATH'), ''));
}

if (!defined('DKIM_DOMAIN')) {
    define('DKIM_DOMAIN', (string) mailler_env(array('DKIM_DOMAIN'), ''));
}
if (!defined('DKIM_SELECTOR')) {
    define('DKIM_SELECTOR', (string) mailler_env(array('DKIM_SELECTOR'), ''));
}
if (!defined('DKIM_PRIVATE_KEY')) {
    define('DKIM_PRIVATE_KEY', (string) mailler_env(array('DKIM_PRIVATE_KEY'), ''));
}
if (!defined('DKIM_PASSPHRASE')) {
    define('DKIM_PASSPHRASE', (string) mailler_env(array('DKIM_PASSPHRASE'), ''));
}
if (!defined('DKIM_IDENTITY')) {
    define('DKIM_IDENTITY', (string) mailler_env(array('DKIM_IDENTITY'), ''));
}

if (!defined('MAX_EMAILS_PER_MINUTE')) {
    define('MAX_EMAILS_PER_MINUTE', (int) mailler_env(array('MAX_EMAILS_PER_MINUTE'), 60));
}
if (!defined('RATE_LIMIT_WINDOW')) {
    define('RATE_LIMIT_WINDOW', (int) mailler_env(array('RATE_LIMIT_WINDOW'), 60));
}
if (!defined('MAX_ATTACHMENT_SIZE_MB')) {
    define('MAX_ATTACHMENT_SIZE_MB', (int) mailler_env(array('MAX_ATTACHMENT_SIZE_MB'), 10));
}

if (!defined('IS_RAILWAY')) {
    define(
        'IS_RAILWAY',
        mailler_env(array('RAILWAY_ENVIRONMENT', 'RAILWAY_GIT_COMMIT_SHA', 'RAILWAY_PROJECT_ID'), '') !== ''
    );
}
if (!defined('DEBUG_MODE')) {
    define('DEBUG_MODE', mailler_bool_env(array('DEBUG_MODE'), false));
}

if (DEBUG_MODE) {
    error_log(
        'Config loaded: SMTP=' . (SMTP_HOST !== '' ? 'YES' : 'NO') .
        ', transport=' . DEFAULT_TRANSPORT .
        ', Railway=' . (IS_RAILWAY ? 'YES' : 'NO')
    );
}
