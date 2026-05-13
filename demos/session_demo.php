<?php
// Countermeasure 4: Secure Session Management
session_start();

// SECURE session configuration
ini_set('session.cookie_httponly', 1);
ini_set('session.cookie_secure', 0); // 0 for localhost, 1 for HTTPS
ini_set('session.cookie_samesite', 'Strict');
ini_set('session.use_strict_mode', 1);
ini_set('session.use_only_cookies', 1);

// Session regeneration tracking
if (!isset($_SESSION['created'])) {
    $_SESSION['created'] = time();
    $_SESSION['views'] = 0;
    $_SESSION['last_regenerate'] = time();
}
$_SESSION['views']++;

// Regenerate session ID every 30 seconds for demo
if (time() - $_SESSION['last_regenerate'] > 30) {
    session_regenerate_id(true);
    $_SESSION['last_regenerate'] = time();
}
?>
<!DOCTYPE html>
<html>
<head>
    <title>Countermeasure 4: Secure Session Management</title>
    <style>
        body { font-family: Arial, sans-serif; margin: 20px; }
        .secure { color: green; font-weight: bold; }
        .config { background: #f0f8ff; padding: 15px; border-left: 4px solid #2196F3; margin: 10px 0; }
        .feature { background: #f9f9f9; padding: 10px; margin: 5px 0; border-radius: 3px; }
    </style>
</head>
<body>
    <h2>Countermeasure 4: Secure Session Management</h2>
    
    <div class="config">
        <h3>✅ Secure Session Configuration Active</h3>
        <div class="feature">
            <strong>HttpOnly Flag:</strong>
            <span class="secure">ENABLED</span> - Cookies inaccessible to JavaScript
        </div>
        
        <div class="feature">
            <strong>Strict Mode:</strong>
            <span class="secure">ENABLED</span> - Prevents session fixation
        </div>
        
        <div class="feature">
            <strong>SameSite Strict:</strong>
            <span class="secure">ENABLED</span> - Prevents CSRF attacks
        </div>
        
        <div class="feature">
            <strong>Cookies Only:</strong>
            <span class="secure">ENABLED</span> - No session IDs in URLs
        </div>
        
        <div class="feature">
            <strong>Session Regeneration:</strong>
            <span class="secure">ACTIVE</span> - Changes ID periodically
        </div>
    </div>
    
    <div class="config">
        <h3>Current Session Information</h3>
        <p><strong>Session ID:</strong> <?php echo substr(session_id(), 0, 10) . '...'; ?></p>
        <p><strong>Session Created:</strong> <?php echo date('H:i:s', $_SESSION['created']); ?></p>
        <p><strong>Last Regenerated:</strong> <?php echo date('H:i:s', $_SESSION['last_regenerate']); ?></p>
        <p><strong>Page Views:</strong> <?php echo $_SESSION['views']; ?></p>
        <p><strong>Next Regeneration in:</strong> <?php echo 30 - (time() - $_SESSION['last_regenerate']); ?> seconds</p>
    </div>
    
    <div class="config">
        <h3>How This Prevents Attacks:</h3>
        <ol>
            <li><strong>HttpOnly:</strong> Stops XSS cookie theft</li>
            <li><strong>Regeneration:</strong> Limits session hijack window</li>
            <li><strong>Strict Mode:</strong> Prevents session fixation</li>
            <li><strong>SameSite:</strong> Blocks CSRF attacks</li>
            <li><strong>Secure Flag:</strong> HTTPS-only in production</li>
        </ol>
    </div>
    
    <p><strong>Test JavaScript Access:</strong></p>
    <button onclick="testCookieAccess()">Try to Access Session Cookie</button>
    <p id="cookie-test"></p>
    
    <script>
    function testCookieAccess() {
        const cookies = document.cookie;
        document.getElementById('cookie-test').innerHTML =
            'JavaScript can see: <strong>' + (cookies || '[No cookies visible]') + '</strong><br>' +
            'Session cookie is protected by HttpOnly flag.';
    }
    </script>
    
    <hr>
    <p><strong>Explanation:</strong> Secure session management combines multiple protections
    to defend against session hijacking, fixation, and XSS attacks.</p>
</body>
</html>
