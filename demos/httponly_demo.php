<?php
// This file demonstrates HttpOnly cookies
// Save as: httponly_demo.php

// Cookie WITHOUT HttpOnly (vulnerable)
setcookie("vulnerable_cookie", "can_be_stolen", [
    'expires' => time() + 3600,
    'path' => '/'
]);

// Cookie WITH HttpOnly (secure)
setcookie("secure_cookie", "protected_by_httponly", [
    'expires' => time() + 3600,
    'httponly' => true,
    'path' => '/'
]);
?>
<!DOCTYPE html>
<html>
<head>
    <title>HttpOnly Cookie Demonstration</title>
</head>
<body>
    <h2>Countermeasure 1: HttpOnly Cookies</h2>
    
    <div style="background-color: #ffcccc; padding: 10px; margin: 10px;">
        <h3>❌ Vulnerable Cookie (No HttpOnly)</h3>
        <p>Cookie Name: <strong>vulnerable_cookie</strong></p>
        <p>JavaScript can access this: <span id="js-access"></span></p>
    </div>
    
    <div style="background-color: #ccffcc; padding: 10px; margin: 10px;">
        <h3>✅ Secure Cookie (HttpOnly Enabled)</h3>
        <p>Cookie Name: <strong>secure_cookie</strong></p>
        <p>JavaScript CANNOT access this cookie</p>
    </div>
    
    <h3>JavaScript Test Results:</h3>
    <pre id="results"></pre>
    
    <script>
    // Try to access both cookies
    const allCookies = document.cookie;
    const results = document.getElementById('results');
    
    results.innerHTML = 
        "=== COOKIE ACCESS TEST ===\n" +
        "All cookies visible to JavaScript:\n" +
        allCookies + "\n\n" +
        "Note: Only 'vulnerable_cookie' appears here.\n" +
        "'secure_cookie' is protected by HttpOnly flag.";
    
    // Show what JavaScript can see
    document.getElementById('js-access').textContent = 
        allCookies.includes('vulnerable_cookie') ? "YES (VULNERABLE)" : "NO";
    </script>
    
    <p><strong>Explanation:</strong> HttpOnly flag prevents JavaScript from accessing the cookie,
    stopping XSS attacks from stealing session tokens.</p>
</body>
</html>
