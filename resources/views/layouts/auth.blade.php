<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Authentification') - Boutique</title>
    
    <!-- Bootstrap 5 -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.0/font/bootstrap-icons.css">
    <!-- Google Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <!-- CSS Commun Global -->
    <link href="{{ asset('css/common.css') }}" rel="stylesheet">
    
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            font-family: 'Inter', -apple-system, BlinkMacSystemFont, sans-serif;
        }
        
        body {
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            background-color: #2C2416;
            background-image: 
                url('https://images.unsplash.com/photo-1441986300917-64674bd600d8?w=800&q=80'),
                url('https://images.unsplash.com/photo-1445205170230-053b83016050?w=600&q=80'),
                url('https://images.unsplash.com/photo-1472851294608-062f824d29cc?w=600&q=80'),
                url('https://images.unsplash.com/photo-1556905055-8f358a7a47b2?w=600&q=80');
            background-size: 
                60% auto,
                35% auto,
                30% auto,
                35% auto;
            background-position: 
                left center,
                right 10% top 20%,
                right 5% bottom 15%,
                left 15% bottom 10%;
            background-repeat: no-repeat;
            background-attachment: fixed;
            position: relative;
            overflow-y: auto;
            overflow-x: hidden;
            padding: 20px 0;
        }
        
        /* Overlay marron pour garder la cohérence */
        body::after {
            content: '';
            position: fixed;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background: linear-gradient(135deg, rgba(93, 78, 55, 0.85) 0%, rgba(139, 111, 71, 0.75) 50%, rgba(212, 165, 116, 0.7) 100%);
            z-index: 0;
            pointer-events: none;
        }
        
        /* Pattern animé par-dessus l'overlay */
        body::before {
            content: '';
            position: fixed;
            width: 200%;
            height: 200%;
            background: radial-gradient(circle, rgba(255,255,255,0.05) 1px, transparent 1px);
            background-size: 50px 50px;
            animation: moveBackground 20s linear infinite;
            opacity: 0.3;
            z-index: 0;
            pointer-events: none;
        }
        
        @keyframes gradientShift {
            0% { background-position: 0% 50%; }
            50% { background-position: 100% 50%; }
            100% { background-position: 0% 50%; }
        }
        
        @keyframes moveBackground {
            0% { transform: translate(0, 0); }
            100% { transform: translate(50px, 50px); }
        }
        
        .container {
            position: relative;
            z-index: 10;
            max-width: 450px;
            width: 100%;
            padding: 20px;
        }
        
        .auth-card {
            background: linear-gradient(135deg, #F5F1ED 0%, #FAF7F3 100%);
            backdrop-filter: blur(20px);
            border-radius: 20px;
            padding: 30px;
            box-shadow: 0 20px 60px rgba(93, 78, 55, 0.4);
            border: 2px solid var(--primary-brown);
            animation: slideUp 0.6s ease;
            margin: auto;
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
        
        .auth-header {
            text-align: center;
            margin-bottom: 20px;
        }
        
        .auth-header h1 {
            font-size: 1.75rem;
            font-weight: 700;
            color: var(--dark-brown);
            margin-bottom: 6px;
        }
        
        .auth-header p {
            color: var(--primary-brown);
            font-size: 0.95rem;
            font-weight: 500;
        }
        
        .form-label {
            font-weight: 600;
            color: var(--dark-brown);
            margin-bottom: 8px;
            font-size: 0.9rem;
        }
        
        .form-control {
            border: 2px solid var(--border-light);
            border-radius: 10px;
            padding: 10px 14px;
            font-size: 0.9rem;
            transition: all 0.3s ease;
            background-color: rgba(255, 255, 255, 0.9);
        }
        
        .form-control:focus {
            border-color: var(--primary-brown);
            box-shadow: 0 0 0 3px rgba(139, 111, 71, 0.15);
            outline: none;
            background-color: white;
        }
        
        .btn-auth {
            width: 100%;
            background: linear-gradient(135deg, #8B6F47 0%, #5D4E37 100%) !important;
            border: none !important;
            color: #FFFFFF !important;
            padding: 14px;
            border-radius: 12px;
            font-size: 1rem;
            font-weight: 700;
            letter-spacing: 0.5px;
            margin-top: 15px;
            transition: all 0.3s ease;
            cursor: pointer;
            box-shadow: 0 4px 15px rgba(93, 78, 55, 0.3);
        }
        
        .btn-auth:hover {
            transform: translateY(-3px);
            box-shadow: 0 10px 30px rgba(93, 78, 55, 0.5);
            background: linear-gradient(135deg, #5D4E37 0%, #8B6F47 100%) !important;
            color: #FFFFFF !important;
        }
        
        .btn-connect {
            font-size: 1.1rem;
            padding: 18px;
        }
        
        .divider {
            text-align: center;
            margin: 20px 0 15px 0;
            position: relative;
        }
        
        .divider::before {
            content: '';
            position: absolute;
            top: 50%;
            left: 0;
            right: 0;
            height: 1px;
            background: var(--border-light);
        }
        
        .divider span {
            background: var(--cream);
            padding: 0 15px;
            color: var(--primary-brown);
            font-size: 0.85rem;
            position: relative;
            font-weight: 500;
        }
        
        .auth-link {
            text-align: center;
            color: var(--text-muted);
            font-size: 0.9rem;
        }
        
        .auth-link a {
            color: var(--primary-brown);
            font-weight: 700;
            text-decoration: none;
            transition: color 0.3s;
        }
        
        .auth-link a:hover {
            color: var(--dark-brown);
            text-decoration: underline;
        }
        
        .alert {
            border-radius: 10px;
            border: none;
            padding: 12px 16px;
            margin-bottom: 20px;
            font-size: 0.9rem;
        }
        
        .invalid-feedback {
            font-size: 0.85rem;
            margin-top: 5px;
        }
        
        .is-invalid {
            border-color: #dc3545 !important;
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="auth-card">
            @yield('content')
        </div>
    </div>
    
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
