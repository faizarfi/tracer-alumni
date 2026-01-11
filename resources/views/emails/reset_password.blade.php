<!doctype html>
<html>
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width,initial-scale=1">
    <title>{{ config('app.name') }} - Reset Password</title>
    <style>
      body { background-color: #f4f6f8; margin: 0; padding: 0; font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, 'Helvetica Neue', Arial; }
      .container { max-width: 680px; margin: 32px auto; padding: 24px; }
      .card { background: linear-gradient(180deg,#ffffff 0%,#f8fbff 100%); border-radius: 12px; box-shadow: 0 8px 30px rgba(20,30,50,0.08); overflow: hidden; }
      .header { padding: 20px 24px; text-align: center; background: #ffffff; color: #0f1724; border-bottom: 1px solid #eef2f7; }
      .brand { font-size: 20px; font-weight: 700; letter-spacing: 0.2px; display:inline-block; vertical-align:middle; }
      .logo { height:48px; display:inline-block; vertical-align:middle; margin-right:12px; }
      .body { padding: 28px; color: #0f1724; }
      h1 { margin: 0 0 12px 0; font-size: 22px; }
      p { margin: 0 0 18px 0; color: #475569; line-height: 1.5; }
      .btn-wrap { text-align: center; margin: 20px 0 8px 0; }
      .btn { display: inline-block; text-decoration: none; background: #0b6b2d; color: #ffffff; padding: 12px 22px; border-radius: 8px; font-weight: 600; }
      .muted { color: #64748b; font-size: 13px; }
      .footer { padding: 18px 24px; text-align: center; font-size: 13px; color: #94a3b8; }
      .small { font-size: 12px; color: #94a3b8; }
      @media (max-width:520px){ .container{padding:12px} .body{padding:18px} .header{padding:14px} }
    </style>
  </head>
  <body>
    <div class="container">
      <div class="card">
        <div class="header" style="text-align:center;">
          <img src="{{ asset('img/uin.png') }}" alt="logo" class="logo" style="height:48px;vertical-align:middle;">
          <div class="brand">{{ config('app.name', 'Tracer Alumni') }}</div>
        </div>

        <div class="body">
          <h1>Halo {{ optional($notifiable)->name ?? 'teman' }},</h1>
          <p>
            Kami menerima permintaan untuk mengatur ulang kata sandi akun <strong>{{ config('app.name', 'Tracer Alumni') }}</strong> Anda. Klik tombol di bawah untuk membuat kata sandi baru. Tautan ini akan kadaluarsa dalam {{ $expire }} menit.
          </p>

          <div class="btn-wrap">
            <a href="{{ $url }}" class="btn" style="background:#0b6b2d;color:#fff;text-decoration:none;padding:12px 22px;border-radius:8px;display:inline-block">Atur Ulang Kata Sandi</a>
          </div>

          <p class="muted small">Jika tombol tidak berfungsi, salin dan tempel tautan berikut ke peramban Anda:</p>
          <p class="small" style="word-break:break-all;color:#0f1724">{{ $url }}</p>

          <hr style="border:none;border-top:1px solid #eef2f7;margin:22px 0">

          <p class="muted">Jika Anda tidak meminta pengaturan ulang kata sandi, Anda dapat mengabaikan email ini. Jika perlu bantuan, balas email ini.</p>
        </div>

        <div class="footer">
          <div class="small">© {{ date('Y') }} {{ config('app.name', 'Tracer Alumni') }}. All rights reserved.</div>
        </div>
      </div>
    </div>
  </body>
</html>
