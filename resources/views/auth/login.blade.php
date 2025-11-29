{{-- resources/views/auth/login.blade.php --}}
<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="utf-8" />
  <meta name="viewport" content="width=device-width,initial-scale=1" />
  <title>Login - SI RT/RW</title>

  <script src="https://cdn.tailwindcss.com"></script>
  <script src="https://unpkg.com/lucide@latest"></script>
  <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800&display=swap" rel="stylesheet"/>

  <style>
    * { box-sizing: border-box; font-family: 'Inter', system-ui, -apple-system, 'Segoe UI', Roboto, sans-serif; }
    body { margin: 0; padding: 0; min-height: 100vh; background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); }
    .login-container { min-height: 100vh; display:flex; align-items:center; justify-content:center; padding:20px; }
    .login-card { width:100%; max-width:1100px; background:white; border-radius:24px; overflow:hidden; box-shadow:0 30px 60px rgba(0,0,0,0.3); display:grid; grid-template-columns:1fr 1fr; min-height:600px; }
    .login-left { background: linear-gradient(135deg, #10b981 0%, #059669 100%); padding:60px 50px; display:flex; flex-direction:column; justify-content:center; align-items:center; position:relative; overflow:hidden; }
    .login-left::before { content:''; position:absolute; width:400px; height:400px; background:rgba(255,255,255,0.1); border-radius:50%; top:-150px; left:-150px; }
    .login-left::after  { content:''; position:absolute; width:300px; height:300px; background:rgba(255,255,255,0.1); border-radius:50%; bottom:-100px; right:-100px; }
    .login-illustration { position:relative; z-index:2; text-align:center; color:white; }
    .logo-circle { width:120px; height:120px; background:white; border-radius:24px; display:flex; align-items:center; justify-content:center; margin:0 auto 30px; box-shadow:0 20px 40px rgba(0,0,0,0.2); animation: float 3s ease-in-out infinite; }
    @keyframes float { 0%,100%{transform:translateY(0)} 50%{transform:translateY(-10px)} }
    .logo-text { font-size:48px; font-weight:800; background:linear-gradient(135deg,#10b981,#059669); -webkit-background-clip:text; -webkit-text-fill-color:transparent; background-clip:text; }
    .login-right { padding:60px 50px; display:flex; flex-direction:column; justify-content:center; }
    .input-group { position:relative; margin-bottom:24px; }
    .input-icon { position:absolute; left:16px; top:50%; transform:translateY(-50%); color:#94a3b8; pointer-events:none; }
    .form-input { width:100%; padding:14px 16px 14px 48px; border:2px solid #e2e8f0; border-radius:12px; font-size:15px; transition:all .3s ease; background:#f8fafc; }
    .form-input:focus { outline:none; border-color:#10b981; background:white; box-shadow:0 0 0 4px rgba(16,185,129,0.1); }
    .login-btn { width:100%; padding:16px; background:linear-gradient(135deg,#10b981,#059669); color:white; border:none; border-radius:12px; font-size:16px; font-weight:600; cursor:pointer; transition:all .3s; box-shadow:0 10px 25px rgba(16,185,129,0.3); }
    .login-btn:hover { transform:translateY(-2px); box-shadow:0 15px 30px rgba(16,185,129,0.4); }
    .checkbox-container { display:flex; align-items:center; gap:8px; margin-bottom:24px; }
    .custom-checkbox { width:20px; height:20px; border:2px solid #e2e8f0; border-radius:6px; cursor:pointer; transition:all .2s; }
    @media (max-width:968px){ .login-card{ grid-template-columns:1fr; max-width:500px; } .login-left{ padding:40px 30px; min-height:300px} .login-right{ padding:40px 30px } .logo-circle{ width:90px; height:90px } .logo-text{ font-size:36px } }
    .feature-item { display:flex; align-items:center; gap:12px; margin-top:20px; color:white; font-size:14px; }
    .feature-icon { width:36px; height:36px; background:rgba(255,255,255,0.2); border-radius:8px; display:flex; align-items:center; justify-content:center; flex-shrink:0; }
    .error-message { background:#fee2e2; color:#dc2626; padding:12px 16px; border-radius:8px; font-size:14px; margin-bottom:20px; display:none; border-left:4px solid #dc2626; }
    .error-message.show { display:block; animation: slideDown 0.3s ease; }
    @keyframes slideDown { from{ opacity:0; transform:translateY(-10px) } to{ opacity:1; transform:translateY(0) } }
    .hidden { display:none !important; }
  </style>
</head>
<body>
  <div class="login-container">
    <div class="login-card">
      <!-- Left Side - Illustration -->
      <div class="login-left">
        <div class="login-illustration">
          <div class="logo-circle">
            <div class="logo-text">SI</div>
          </div>
          <h1 style="font-size:32px;font-weight:700;margin:0 0 12px 0;">Sistem Informasi RT/RW</h1>
          <p style="font-size:16px;opacity:0.9;margin:0 0 40px 0;line-height:1.6;">
            Platform digital terpadu untuk pengelolaan administrasi dan data warga RT/RW yang lebih efisien
          </p>

          <div style="width:100%; max-width:350px; text-align:left;">
            <div class="feature-item">
              <div class="feature-icon"><i data-lucide="users" class="w-5 h-5"></i></div>
              <span>Manajemen Data Warga</span>
            </div>
            <div class="feature-item">
              <div class="feature-icon"><i data-lucide="wallet" class="w-5 h-5"></i></div>
              <span>Kelola Keuangan RT/RW</span>
            </div>
            <div class="feature-item">
              <div class="feature-icon"><i data-lucide="calendar" class="w-5 h-5"></i></div>
              <span>Jadwal Kegiatan Terpadu</span>
            </div>
          </div>
        </div>
      </div>

      <!-- Right Side - Login Form -->
      <div class="login-right">
        <div>
          <h2 style="font-size:28px;font-weight:700;color:#0f172a;margin:0 0 8px 0;">Selamat Datang</h2>
          <p style="font-size:15px;color:#64748b;margin:0 0 32px 0;">Silakan masuk ke akun Anda untuk melanjutkan</p>

          {{-- Server-side error (session) --}}
          @if(session('error'))
            <div class="error-message show" id="serverError">
              <div style="display:flex;align-items:center;gap:8px;">
                <i data-lucide="alert-circle" class="w-4 h-4"></i>
                <span>{{ session('error') }}</span>
              </div>
            </div>
          @endif

          {{-- Validation errors --}}
          @if($errors->any())
            <div class="error-message show">
              <div style="display:flex;align-items:center;gap:8px;">
                <i data-lucide="alert-circle" class="w-4 h-4"></i>
                <div>
                  @foreach($errors->all() as $err)
                    <div>{{ $err }}</div>
                  @endforeach
                </div>
              </div>
            </div>
          @endif

          <form id="loginForm" method="POST" action="{{ route('login') }}">
            @csrf

            <div class="input-group">
              <i data-lucide="user" class="input-icon w-5 h-5"></i>
              <input
                type="text"
                name="username"
                class="form-input"
                placeholder="Username atau NIK"
                id="username"
                value="{{ old('username') }}"
                required
                autofocus
              />
            </div>

            <div class="input-group">
              <i data-lucide="lock" class="input-icon w-5 h-5"></i>
              <input
                type="password"
                name="password"
                class="form-input"
                placeholder="Password"
                id="password"
                required
              />
            </div>

            <div style="display:flex;justify-content:space-between;align-items:center;margin-bottom:28px;">
              <label class="checkbox-container" style="margin-bottom:0;display:flex;align-items:center;gap:8px;">
                <input type="checkbox" name="remember" class="custom-checkbox" id="rememberMe" {{ old('remember') ? 'checked' : '' }}/>
                <span style="font-size:14px;color:#64748b;">Ingat saya</span>
              </label>

              <a href="#" style="font-size:14px;color:#10b981;text-decoration:none;font-weight:500;">Lupa password?</a>
            </div>

            <button type="submit" class="login-btn">
              <span style="display:flex;align-items:center;justify-content:center;gap:8px;">
                Masuk
                <i data-lucide="arrow-right" class="w-5 h-5"></i>
              </span>
            </button>
          </form>

          <div style="margin-top:28px;text-align:center;">
            <p style="font-size:14px;color:#64748b;margin:0;">
              Belum punya akun?
              <a href="#" style="color:#10b981;text-decoration:none;font-weight:600;">Hubungi Ketua RT</a>
            </p>
          </div>

          <div style="margin-top:32px;padding-top:24px;border-top:1px solid #e2e8f0;">
            <div style="display:flex;align-items:center;gap:8px;font-size:13px;color:#94a3b8;">
              <i data-lucide="shield-check" class="w-4 h-4"></i>
              <span>Data Anda aman dan terenkripsi</span>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>

  <script>
    document.addEventListener('DOMContentLoaded', function() {
      if (window.lucide) lucide.createIcons();

      // client-side shake/display for better UX (optional)
      const loginForm = document.getElementById('loginForm');
      const serverError = document.getElementById('serverError');

      // optional: small client-side feedback when server returns error (server sets session('error'))
      if (serverError) {
        // highlight the form quickly
        loginForm.style.animation = 'shake 0.5s';
        setTimeout(() => loginForm.style.animation = '', 500);
      }

      // add shake animation keyframes
      const style = document.createElement('style');
      style.textContent = `
        @keyframes shake {
          0%,100% { transform: translateX(0); }
          25% { transform: translateX(-10px); }
          75% { transform: translateX(10px); }
        }
      `;
      document.head.appendChild(style);
    });
  </script>
</body>
</html>
