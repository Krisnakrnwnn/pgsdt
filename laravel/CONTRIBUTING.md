# Contributing to PGSDT

Terima kasih atas minat Anda untuk berkontribusi pada proyek Para Gotra Santana Dalem Tarukan! 🙏

## 📋 Code of Conduct

Dengan berpartisipasi dalam proyek ini, Anda diharapkan untuk menjunjung tinggi nilai-nilai:
- Saling menghormati
- Komunikasi yang konstruktif
- Fokus pada tujuan bersama
- Menjaga kerahasiaan data member

## 🚀 Cara Berkontribusi

### Melaporkan Bug

Jika Anda menemukan bug, silakan buat issue dengan informasi:
1. **Deskripsi bug** - Jelaskan apa yang terjadi
2. **Langkah reproduksi** - Bagaimana cara memunculkan bug
3. **Expected behavior** - Apa yang seharusnya terjadi
4. **Screenshots** - Jika memungkinkan
5. **Environment** - Browser, OS, PHP version, dll

### Mengusulkan Fitur Baru

Untuk mengusulkan fitur baru:
1. Cek dulu apakah fitur sudah ada di roadmap (CHANGELOG.md)
2. Buat issue dengan label "enhancement"
3. Jelaskan use case dan manfaatnya
4. Diskusikan dengan maintainer sebelum mulai coding

### Pull Request Process

1. **Fork** repository ini
2. **Clone** fork Anda ke local
   ```bash
   git clone https://github.com/your-username/pgsdt.git
   ```

3. **Buat branch** untuk fitur/fix Anda
   ```bash
   git checkout -b feature/nama-fitur
   # atau
   git checkout -b fix/nama-bug
   ```

4. **Commit** perubahan dengan pesan yang jelas
   ```bash
   git commit -m "feat: menambahkan fitur X"
   git commit -m "fix: memperbaiki bug Y"
   ```

5. **Push** ke fork Anda
   ```bash
   git push origin feature/nama-fitur
   ```

6. **Buat Pull Request** ke branch `main`

### Commit Message Convention

Gunakan format berikut:
- `feat:` - Fitur baru
- `fix:` - Bug fix
- `docs:` - Perubahan dokumentasi
- `style:` - Formatting, missing semicolons, dll
- `refactor:` - Refactoring code
- `test:` - Menambah test
- `chore:` - Update dependencies, dll

Contoh:
```
feat: menambahkan export PDF untuk member card
fix: memperbaiki validasi NIK di form registrasi
docs: update README dengan panduan deployment
```

## 💻 Development Guidelines

### Coding Standards

#### PHP
- Follow PSR-12 coding standard
- Use type hints untuk parameter dan return types
- Gunakan Eloquent ORM, hindari raw queries
- Tambahkan docblock untuk method yang kompleks

```php
/**
 * Get active members with pagination
 *
 * @param int $perPage
 * @return \Illuminate\Pagination\LengthAwarePaginator
 */
public function getActiveMembers(int $perPage = 15): LengthAwarePaginator
{
    return User::where('role', 'member')
        ->where('member_status', 'active')
        ->paginate($perPage);
}
```

#### Blade Templates
- Gunakan `@` directives daripada `<?php ?>`
- Escape output dengan `{{ }}` bukan `{!! !!}` kecuali HTML yang aman
- Pisahkan logic dari view (gunakan Controller/ViewModel)

#### JavaScript
- Gunakan ES6+ syntax
- Tambahkan comments untuk logic yang kompleks
- Hindari inline JavaScript di Blade

#### CSS
- Gunakan Tailwind utility classes
- Untuk custom CSS, tambahkan di `resources/css/app.css`
- Follow mobile-first approach

### Database

#### Migrations
- Buat migration untuk setiap perubahan schema
- Gunakan nama yang deskriptif
- Selalu sediakan method `down()` untuk rollback

```bash
php artisan make:migration add_phone_to_users_table
```

#### Models
- Gunakan `$fillable` atau `$guarded`
- Definisikan relationships
- Tambahkan scopes untuk query yang sering dipakai
- Gunakan accessors/mutators untuk data transformation

### Testing

Sebelum submit PR, pastikan:
- [ ] Code berjalan tanpa error
- [ ] Tidak ada breaking changes
- [ ] Validasi form bekerja dengan baik
- [ ] Responsive di mobile dan desktop
- [ ] Browser compatibility (Chrome, Firefox, Safari)

### Security

⚠️ **PENTING**: Jangan pernah commit:
- File `.env`
- Credentials atau API keys
- Data member yang sensitif
- Private keys atau certificates

Selalu:
- Validasi input dari user
- Escape output untuk mencegah XSS
- Gunakan parameterized queries (Eloquent)
- Implementasi CSRF protection
- Rate limiting untuk endpoints sensitif

## 📝 Documentation

Jika Anda menambahkan fitur baru:
- Update README.md jika perlu
- Tambahkan entry di CHANGELOG.md
- Buat/update dokumentasi API jika ada
- Tambahkan comments di code untuk logic kompleks

## 🧪 Testing Checklist

Sebelum submit PR, test:
- [ ] Registrasi member baru
- [ ] Login/logout
- [ ] CRUD operations (News, Events, Members)
- [ ] Email notifications
- [ ] File uploads
- [ ] Form validations
- [ ] Responsive design
- [ ] Browser compatibility

## 🤝 Review Process

1. Maintainer akan review PR Anda
2. Mungkin ada request untuk perubahan
3. Setelah approved, PR akan di-merge
4. Perubahan akan masuk ke changelog

## 📞 Butuh Bantuan?

Jika ada pertanyaan:
- Buat issue dengan label "question"
- Email: pgsdtpusat1969@gmail.com
- WhatsApp: 081283144560

## 🙏 Terima Kasih

Setiap kontribusi, sekecil apapun, sangat berarti untuk kemajuan PGSDT!

**Om Swastyastu** 🙏
