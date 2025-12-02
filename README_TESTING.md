# PHPUnit Testing Setup - ITS MentorMatch

## 📋 Overview

PHPUnit testing untuk proses **Registration** ITS MentorMatch dengan fokus pada:
- **Controllers** - Logic registrasi
- **Views** - Tampilan blade templates
- **Models** - User model relationships dan attributes

Database menggunakan **in-memory SQLite** untuk testing (tidak menyentuh production database).

---

## 🚀 Quick Start

### Instalasi Dependencies

Pastikan package code coverage sudah terinstall:

```bash
composer install
composer update
```

Atau jika sudah ada `phpunit/php-code-coverage` di `composer.json`, cukup:

```bash
composer update phpunit/php-code-coverage
```

---

## 🧪 Menjalankan Tests

### Option 1: Menggunakan Script Helper

#### Windows (PowerShell/CMD):
```bash
# Jalankan semua tests
.\run-tests.bat

# Jalankan tests dengan HTML coverage report
.\run-tests.bat coverage

# Jalankan hanya registration tests
.\run-tests.bat register

# Hapus coverage report lama
.\run-tests.bat clean
```

#### Linux/Mac:
```bash
# Jalankan semua tests
./run-tests.sh

# Jalankan tests dengan HTML coverage report
./run-tests.sh coverage

# Jalankan hanya registration tests
./run-tests.sh register

# Hapus coverage report lama
./run-tests.sh clean
```

### Option 2: Menggunakan PHP Artisan Langsung

```bash
# Jalankan semua tests
php artisan test

# Jalankan semua tests dengan verbose output
php artisan test --verbose

# Jalankan tests dengan HTML coverage report
php artisan test --coverage

# Jalankan hanya registration tests
php artisan test tests/Feature/Auth tests/Unit/Models/UserModelTest.php

# Jalankan specific test file
php artisan test tests/Feature/Auth/RegisterControllerTest.php

# Jalankan specific test method
php artisan test --filter=test_registration_form_can_be_displayed

# Jalankan dengan coverage report untuk file tertentu
php artisan test --coverage-filter=app/Models/User.php
```

---

## 📊 Melihat Coverage Report HTML

Setelah menjalankan `php artisan test --coverage` atau `run-tests.bat coverage`:

1. **Coverage report akan dibuat di folder:** `coverage/`
2. **Buka file HTML:**
   - Klik dua kali `coverage/index.html`
   - Atau buka di browser: `file:///C:/xampp/htdocs/its_mentormatch/coverage/index.html`

### Coverage Report Menampilkan:
- ✅ Percentage of code covered
- ✅ Lines covered vs not covered
- ✅ Methods coverage
- ✅ Classes coverage
- ✅ File-by-file breakdown
- ✅ Color coding:
  - 🟢 Green: Well covered (>80%)
  - 🟡 Yellow: Partially covered (50-80%)
  - 🔴 Red: Not covered (<50%)

---

## 📁 Test Structure

```
tests/
├── Feature/
│   ├── Auth/
│   │   ├── RegisterControllerTest.php     (19 tests - Controller logic)
│   │   ├── RegisterViewTest.php           (19 tests - Blade view)
│   │   └── AuthTestCase.php               (Helper base class)
│   ├── ExampleTest.php
│   └── ProfileTest.php
├── Unit/
│   ├── Models/
│   │   └── UserModelTest.php              (18 tests - User model)
│   └── ExampleTest.php
└── TestCase.php                           (Base test class)
```

---

## 📝 Test Coverage Breakdown

### RegisterControllerTest.php (19 tests)
Controller logic untuk registration:
- Form display
- Valid data registration
- Field validation (required, format, length)
- Duplicate email/student_id validation
- Password validation
- Redirect behavior
- Authenticated user behavior

### RegisterViewTest.php (19 tests)
Blade view rendering:
- Form fields presence
- Labels dan placeholders
- Input types
- Form method dan action
- CSRF token
- Department options
- Styling classes
- Error preservation
- Links

### UserModelTest.php (18 tests)
User model:
- Creation dengan fillable attributes
- Hidden attributes (password, token)
- Datetime casts
- Relationships (sessions, reviews, goal)
- Queries (by email, by student_id)
- Update dan delete operations
- Default values

**Total: 56 tests untuk registration process**

---

## 🔧 Konfigurasi PHPUnit

File: `phpunit.xml`

### Coverage Settings:
```xml
<coverage processUncoveredFiles="true" ignoreDeprecatedCodeUnitsFromCodeCoverage="true">
    <report>
        <!-- HTML report dengan color coding -->
        <html outputDirectory="coverage" lowUpperBound="50" highLowerBound="80"/>
        <!-- Console report -->
        <text outputFile="php://stdout" showUncoveredFiles="true"/>
    </report>
</coverage>
```

### Database Configuration:
```xml
<env name="DB_CONNECTION" value="sqlite"/>
<env name="DB_DATABASE" value=":memory:"/>
```
- Menggunakan SQLite in-memory (tidak ada file database)
- Setiap test mendapat database fresh
- Data tidak persisten antar test

---

## 💾 Test Database

### Mengapa In-Memory SQLite?

```xml
<!-- Di phpunit.xml -->
<env name="DB_CONNECTION" value="sqlite"/>
<env name="DB_DATABASE" value=":memory:"/>
```

**Keuntungan:**
- ✅ Tidak menyentuh production database
- ✅ Tidak perlu migration untuk setiap test
- ✅ Super cepat (in-memory)
- ✅ Clean slate untuk setiap test
- ✅ Isolation antar tests

**Cara Kerjanya:**
1. Database dibuat di memory sebelum test
2. Migration dijalankan
3. Test berjalan
4. Database dihapus/rollback setelah test
5. (Repeat untuk test berikutnya)

### RefreshDatabase Trait

Semua test menggunakan `RefreshDatabase` trait:

```php
use Illuminate\Foundation\Testing\RefreshDatabase;

class RegisterControllerTest extends TestCase
{
    use RefreshDatabase;
    
    public function test_user_can_register(): void
    {
        // Database fresh, siap untuk test
        $this->post('/register', [...]);
    }
}
```

---

## 📚 Common Test Commands

```bash
# Jalankan tests dengan output warna
php artisan test

# Jalankan tests dengan info detail setiap test
php artisan test --verbose

# Jalankan tests dan hentikan di test pertama yang fail
php artisan test --stop-on-failure

# Jalankan tests dan tampilkan 5 tests paling lambat
php artisan test --slowest=5

# Jalankan specific test suite
php artisan test tests/Feature/Auth

# Run tests matching pattern
php artisan test --filter=Controller

# Generate coverage report dalam berbagai format
php artisan test --coverage
php artisan test --coverage-html coverage
php artisan test --coverage-xml coverage.xml
php artisan test --coverage-cobertura coverage.xml
```

---

## 🐛 Troubleshooting

### Problem: "Tests tidak ditemukan"
**Solution:** Pastikan file test ada di `tests/Feature/` atau `tests/Unit/`

### Problem: "Database locked"
**Solution:** Pastikan tidak ada test yang berjalan bersamaan, atau gunakan in-memory database

### Problem: "Coverage report tidak terbuat"
**Solution:** Install `phpunit/php-code-coverage`:
```bash
composer require --dev phpunit/php-code-coverage
```

### Problem: "CSRF token error"
**Solution:** Gunakan `RefreshDatabase` trait dan pastikan middleware tidak memblock testing

### Problem: "Factory not found"
**Solution:** Pastikan factory sudah ada di `database/factories/`

---

## 📖 File Documentation

- **TESTING_GUIDE.md** - Dokumentasi detail testing strategy
- **phpunit.xml** - Konfigurasi PHPUnit
- **composer.json** - Dependencies termasuk PHPUnit
- **run-tests.bat** - Helper script untuk Windows
- **run-tests.sh** - Helper script untuk Linux/Mac

---

## 🎯 Next Steps

### Untuk Menambah Tests

1. **Buat test file baru:**
   ```bash
   php artisan make:test Feature/Auth/LoginControllerTest
   ```

2. **Gunakan pola yang sama:**
   ```php
   use Illuminate\Foundation\Testing\RefreshDatabase;
   
   class NewFeatureTest extends TestCase
   {
       use RefreshDatabase;
       
       public function test_feature(): void
       {
           // Arrange
           // Act
           // Assert
       }
   }
   ```

3. **Jalankan tests:**
   ```bash
   php artisan test tests/Feature/Auth/NewFeatureTest.php
   ```

---

## 📊 Integration dengan CI/CD

Untuk GitHub Actions, GitLab CI, dll:

```yaml
# Example: .github/workflows/tests.yml
- name: Run tests with coverage
  run: php artisan test --coverage
```

---

## 🔗 Resources

- [Laravel Testing](https://laravel.com/docs/testing)
- [PHPUnit Documentation](https://phpunit.de/)
- [Code Coverage in PHPUnit](https://docs.phpunit.de/en/11.0/code-coverage.html)
- [Laravel Feature Tests](https://laravel.com/docs/testing#feature-tests)

---

## ✅ Setup Checklist

- [x] PHPUnit v11.5.3 installed
- [x] php-code-coverage installed
- [x] phpunit.xml configured with coverage
- [x] Tests created for registration process
- [x] RefreshDatabase trait implemented
- [x] In-memory SQLite database configured
- [x] Helper scripts created (run-tests.bat/.sh)
- [x] HTML coverage report ready
- [x] .gitignore updated untuk /coverage
- [x] Documentation complete

✨ **Setup Selesai! Siap untuk testing.**
