# Security Policy

## 🔒 Keamanan PGSDT

Keamanan data member dan sistem adalah prioritas utama kami. Dokumen ini menjelaskan kebijakan keamanan dan cara melaporkan vulnerability.

## 📋 Supported Versions

Kami menyediakan security updates untuk versi berikut:

| Version | Supported          |
| ------- | ------------------ |
| 2.0.x   | ✅ Yes             |
| 1.0.x   | ⚠️ Limited support |
| < 1.0   | ❌ No              |

## 🛡️ Security Features

### Implemented Security Measures

#### Authentication & Authorization
- ✅ Bcrypt password hashing
- ✅ Email verification untuk member baru
- ✅ Role-based access control (Admin/Member)
- ✅ Session management dengan secure cookies
- ✅ Rate limiting untuk login (5 attempts/minute)
- ✅ Rate limiting untuk registrasi (3 attempts/minute)

#### Data Protection
- ✅ CSRF protection pada semua forms
- ✅ SQL Injection protection (Eloquent ORM)
- ✅ XSS protection (Blade escaping)
- ✅ Soft delete untuk data penting
- ✅ Input validation dan sanitization
- ✅ File upload validation (type, size, dimensions)

#### Infrastructure
- ✅ HTTPS/SSL enforcement (production)
- ✅ Secure headers (X-Frame-Options, X-Content-Type-Options)
- ✅ Environment variables untuk credentials
- ✅ Logging untuk security events
- ✅ Regular dependency updates

### Planned Security Enhancements
- [ ] Two-factor authentication (2FA)
- [ ] Password strength meter
- [ ] Account lockout after failed attempts
- [ ] Security audit logging
- [ ] Automated vulnerability scanning
- [ ] Content Security Policy (CSP)
- [ ] Subresource Integrity (SRI)

## 🚨 Reporting a Vulnerability

### Jangan Laporkan di Public!

**PENTING**: Jika Anda menemukan security vulnerability, **JANGAN** buat public issue di GitHub.

### Cara Melaporkan

Kirim laporan ke:
- **Email**: pgsdtpusat1969@gmail.com
- **Subject**: [SECURITY] Deskripsi singkat vulnerability

### Informasi yang Dibutuhkan

Sertakan informasi berikut:
1. **Deskripsi vulnerability** - Jelaskan masalahnya
2. **Severity level** - Critical/High/Medium/Low
3. **Steps to reproduce** - Cara memunculkan vulnerability
4. **Potential impact** - Apa dampaknya jika dieksploitasi
5. **Suggested fix** - Jika ada (optional)
6. **Your contact info** - Untuk follow-up

### Response Timeline

- **24 jam**: Konfirmasi penerimaan laporan
- **72 jam**: Initial assessment dan severity rating
- **7 hari**: Update progress atau patch
- **30 hari**: Public disclosure (setelah fix deployed)

### Responsible Disclosure

Kami menghargai responsible disclosure:
- Berikan waktu untuk fix sebelum public disclosure
- Jangan eksploitasi vulnerability di production
- Jangan akses/modifikasi data member tanpa izin
- Jangan lakukan DoS attack untuk testing

### Recognition

Kontributor yang melaporkan valid security issue akan:
- Disebutkan di CHANGELOG (jika diinginkan)
- Mendapat ucapan terima kasih dari tim
- Dipertimbangkan untuk bug bounty (jika tersedia)

## 🔐 Security Best Practices untuk Developer

### Environment Variables
```bash
# JANGAN commit file .env
# Gunakan .env.example sebagai template
# Gunakan strong passwords
DB_PASSWORD=use_strong_password_here
```

### Password Policy
```php
// Minimum 8 karakter
'password' => 'required|string|min:8|confirmed'

// Recommended: tambahkan complexity rules
'password' => [
    'required',
    'string',
    'min:8',
    'confirmed',
    'regex:/[a-z]/',      // lowercase
    'regex:/[A-Z]/',      // uppercase
    'regex:/[0-9]/',      // numbers
    'regex:/[@$!%*#?&]/', // special chars
]
```

### Input Validation
```php
// Selalu validate input
$request->validate([
    'email' => 'required|email|max:255',
    'nik' => ['required', 'string', 'size:16', 'regex:/^[0-9]{16}$/'],
]);

// Sanitize output
{{ $user->name }} // Auto-escaped
{!! $trustedHtml !!} // Only for trusted content
```

### File Upload Security
```php
$request->validate([
    'image' => [
        'required',
        'image',
        'mimes:jpeg,png,jpg,webp',
        'max:2048', // 2MB
        'dimensions:min_width=100,min_height=100,max_width=2000,max_height=2000'
    ],
]);

// Store dengan nama random
$path = $request->file('image')->store('members', 'public');
```

### Database Security
```php
// ✅ GOOD: Eloquent (parameterized)
User::where('email', $email)->first();

// ❌ BAD: Raw query dengan concatenation
DB::select("SELECT * FROM users WHERE email = '$email'");

// ✅ GOOD: Raw query dengan binding
DB::select("SELECT * FROM users WHERE email = ?", [$email]);
```

### Authentication
```php
// Gunakan middleware
Route::middleware(['auth'])->group(function() {
    // Protected routes
});

// Check authorization
if (Auth::user()->role !== 'admin') {
    abort(403);
}

// Atau gunakan Gate/Policy
Gate::authorize('update', $post);
```

## 🔍 Security Checklist untuk Production

### Pre-Deployment
- [ ] `APP_DEBUG=false`
- [ ] `APP_ENV=production`
- [ ] Strong `APP_KEY` generated
- [ ] Strong database passwords
- [ ] HTTPS/SSL configured
- [ ] Firewall rules configured
- [ ] File permissions correct (755/775)
- [ ] `.env` not in git
- [ ] Dependencies updated
- [ ] Security headers configured

### Post-Deployment
- [ ] Test authentication flows
- [ ] Test authorization rules
- [ ] Verify HTTPS redirect
- [ ] Check error pages (don't leak info)
- [ ] Monitor logs for suspicious activity
- [ ] Setup automated backups
- [ ] Configure monitoring/alerting

## 📊 Security Monitoring

### Logs to Monitor
```bash
# Application logs
tail -f storage/logs/laravel.log

# Web server logs
tail -f /var/log/nginx/access.log
tail -f /var/log/nginx/error.log

# Failed login attempts
grep "Failed login" storage/logs/laravel.log
```

### Suspicious Activities
Monitor untuk:
- Multiple failed login attempts
- Unusual file uploads
- SQL injection attempts
- XSS attempts
- Brute force attacks
- Unauthorized access attempts

## 🆘 Security Incident Response

Jika terjadi security breach:

1. **Isolate** - Matikan sistem jika perlu
2. **Assess** - Tentukan scope dan impact
3. **Contain** - Stop the breach
4. **Eradicate** - Remove vulnerability
5. **Recover** - Restore dari backup
6. **Document** - Catat semua detail
7. **Notify** - Inform affected users
8. **Review** - Post-mortem analysis

## 📞 Security Contact

Untuk security concerns:
- **Email**: pgsdtpusat1969@gmail.com
- **Subject**: [SECURITY] Your concern
- **Response time**: Within 24 hours

## 📚 Resources

- [OWASP Top 10](https://owasp.org/www-project-top-ten/)
- [Laravel Security Best Practices](https://laravel.com/docs/security)
- [PHP Security Cheat Sheet](https://cheatsheetseries.owasp.org/cheatsheets/PHP_Configuration_Cheat_Sheet.html)

---

**Last Updated**: May 2, 2026

**Om Swastyastu** 🙏
