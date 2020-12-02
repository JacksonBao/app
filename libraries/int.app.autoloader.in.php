<?php
if(ENV == 'PRODUCTION'){
    header("Content-Security-Policy: default-src 'none'; font-src 'self' https://*.njofa.com https://fonts.gstatic.com;img-src 'self' blob: https://*.njofa.com https://code.jquery.com https://cdnjs.cloudflare.com; object-src 'none'; script-src 'self' https://*.njofa.com https://js.stripe.com https://code.jquery.com https://cdn.jsdelivr.net https://cdnjs.cloudflare.com https://stackpath.bootstrapcdn.com 'unsafe-inline'; style-src 'self' https://*.njofa.com https://njofa.com   https://stackpath.bootstrapcdn.com https://cdnjs.cloudflare.com  https://fonts.googleapis.com 'unsafe-inline'; connect-src 'self' https://*.njofa.com https://ipinfo.io;manifest-src 'self' https://*.njofa.com; frame-src 'self' https://js.stripe.com");
    }
    