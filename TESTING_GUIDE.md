# PHPUnit Testing Setup & Documentation

## Overview

Setup PHPUnit testing untuk proses register ITS MentorMatch dengan fokus pada:
- Views (blade templates)
- Models (User model)
- Controllers (RegisterController)

Database menggunakan in-memory SQLite untuk testing (tanpa menyentuh production database).

## Struktur Test

```
tests/
├── Feature/
│   ├── Auth/
│   │   ├── RegisterControllerTest.php    # Testing controller logic
│   │   ├── RegisterViewTest.php           # Testing blade view rendering
│   │   └── AuthTestCase.php               # Base class untuk auth tests
│   └── ...
├── Unit/
│   ├── Models/
│   │   └── UserModelTest.php             # Testing User model
│   └── ...
└── TestCase.php                          # Base test class
```

## Test Files

### 1. **RegisterControllerTest.php** (19 tests)
Menguji logic controller untuk proses registrasi.

**Test Coverage:**
- ✅ Form dapat ditampilkan
- ✅ Registrasi dengan data valid
- ✅ Validasi field required (name, email, student_id, department, password)
- ✅ Validasi format email
- ✅ Validasi panjang password (min 8 chars)
- ✅ Validasi password confirmation
- ✅ Validasi unique email
- ✅ Validasi unique student_id
- ✅ Phone number optional
- ✅ Redirect ke home setelah registrasi
- ✅ Authenticated user tidak bisa register
- ✅ Validasi panjang field (name max 255, student_id max 20, phone max 20)

**Cara Menjalankan:**
```bash
php artisan test tests/Feature/Auth/RegisterControllerTest.php
```

### 2. **RegisterViewTest.php** (19 tests)
Menguji view blade untuk tampilan registrasi.

**Test Coverage:**
- ✅ View terbuka dengan status 200
- ✅ View berisi form registration
- ✅ Form berisi semua input fields (name, email, student_id, dll)
- ✅ Form berisi semua labels
- ✅ Form berisi submit button
- ✅ Form berisi login link
- ✅ Form menggunakan POST method
- ✅ Form posts ke register route
- ✅ Form berisi CSRF token
- ✅ View berisi ITS MentorMatch branding
- ✅ View menampilkan department options
- ✅ View memiliki Tailwind styling
- ✅ View preserves old input pada error
- ✅ Input fields memiliki placeholder yang tepat
- ✅ Input fields memiliki type yang benar
- ✅ Required fields memiliki required attribute

**Cara Menjalankan:**
```bash
php artisan test tests/Feature/Auth/RegisterViewTest.php
```

### 3. **UserModelTest.php** (18 tests)
Menguji User model logic.

**Test Coverage:**
- ✅ User dapat dibuat dengan fillable attributes
- ✅ Fillable attributes sudah benar
- ✅ Password hidden dari array
- ✅ Remember token hidden dari array
- ✅ Email verified at di-cast ke datetime
- ✅ User dapat memiliki multiple sessions
- ✅ User dapat memiliki multiple reviews
- ✅ User dapat memiliki one goal
- ✅ Email verified at null by default
- ✅ Required attributes tidak null
- ✅ Phone dapat null
- ✅ User dapat diambil berdasarkan email
- ✅ User dapat diambil berdasarkan student_id
- ✅ User dapat diupdate
- ✅ User dapat dihapus

**Cara Menjalankan:**
```bash
php artisan test tests/Unit/Models/UserModelTest.php
```

## Menjalankan Tests

### Jalankan Semua Tests
```bash
php artisan test
```

### Jalankan Tests dengan Verbose Output
```bash
php artisan test --verbose
```

### Jalankan Tests untuk Registrasi Saja
```bash
php artisan test tests/Feature/Auth
php artisan test tests/Unit/Models/UserModelTest.php
```

### Jalankan Tests dengan Coverage Report (Optional)
```bash
php artisan test --coverage
```

### Jalankan Specific Test Method
```bash
php artisan test --filter=test_registration_form_can_be_displayed
```

## Database Configuration untuk Testing

Konfigurasi di `phpunit.xml`:

```xml
<php>
    <env name="APP_ENV" value="testing"/>
    <env name="DB_CONNECTION" value="sqlite"/>
    <env name="DB_DATABASE" value=":memory:"/>
    ...
</php>
```

**Penjelasan:**
- `APP_ENV=testing`: Set environment ke testing mode
- `DB_CONNECTION=sqlite`: Gunakan SQLite untuk testing
- `DB_DATABASE=:memory:`: Database ada di memory (tidak menyentuh file atau production db)

## RefreshDatabase Trait

Semua test menggunakan `RefreshDatabase` trait yang:
1. Membuat database baru sebelum setiap test
2. Menjalankan migrations
3. Rollback database setelah test selesai

```php
use Illuminate\Foundation\Testing\RefreshDatabase;

class RegisterControllerTest extends TestCase
{
    use RefreshDatabase;
    // ...
}
```

## Test Best Practices yang Digunakan

### 1. **Descriptive Test Names**
```php
public function test_registration_fails_with_duplicate_email(): void
```

### 2. **One Assertion Per Test (atau related assertions)**
```php
public function test_user_can_be_created(): void
{
    $user = User::create($data);
    $this->assertNotNull($user->id);
    $this->assertEquals('John Doe', $user->name);
}
```

### 3. **Test Isolation**
Setiap test berdiri sendiri dan tidak bergantung pada test lainnya.

### 4. **Clear Arrange-Act-Assert Pattern**
```php
// Arrange
$userData = [...];

// Act
$response = $this->post('/register', $userData);

// Assert
$response->assertRedirect('/');
```

### 5. **Meaningful Test Data**
```php
$userData = [
    'name' => 'John Doe',
    'email' => 'john@example.com',
    'student_id' => '05111940000001',
    // ...
];
```

## Common Testing Assertions

### Response Assertions
```php
$response->assertStatus(200);                    // Status code
$response->assertRedirect('/');                  // Redirect
$response->assertViewIs('auth.register');        // View name
$response->assertSee('Join ITS MentorMatch');    // Text content
$response->assertSessionHasErrors(['email']);    // Validation errors
$response->assertSessionHas('success', '...');   // Session data
```

### Model Assertions
```php
$this->assertNotNull($user->id);
$this->assertEquals('John Doe', $user->name);
$this->assertNull($user->phone);
$this->assertCount(3, $user->sessions);
$this->assertTrue($user->sessions->contains($session));
```

## Troubleshooting

### Tests gagal karena CSRF token
**Solusi:** Gunakan `RefreshDatabase` dan pastikan middleware tidak memblock testing.

### Database lock errors
**Solusi:** Pastikan menggunakan `:memory:` SQLite database di `phpunit.xml`.

### Model factory tidak ditemukan
**Solusi:** Jalankan `php artisan make:factory` jika belum ada atau pastikan factory sudah dibuat.

## Tips & Tricks

### Buat test data dengan Factory
```php
$user = User::factory()->create();
```

### Buat multiple test data
```php
$users = User::factory(5)->create();
```

### Test dengan authenticated user
```php
$user = User::factory()->create();
$response = $this->actingAs($user)->get('/dashboard');
```

### Test dengan form data
```php
$response = $this->post('/register', [
    'name' => 'John Doe',
    'email' => 'john@example.com',
    // ...
]);
```

## Total Test Count

- **RegisterControllerTest**: 19 tests
- **RegisterViewTest**: 19 tests
- **UserModelTest**: 18 tests

**Total**: 56 tests untuk registration process

## Next Steps

Jika ingin menambah tests untuk fitur lain:
1. Buat controller/view test di `tests/Feature/`
2. Buat model test di `tests/Unit/Models/`
3. Gunakan pola yang sama dengan struktur Arrange-Act-Assert
4. Gunakan `RefreshDatabase` trait untuk database isolation

## Resources

- [Laravel Testing Documentation](https://laravel.com/docs/testing)
- [PHPUnit Documentation](https://phpunit.de/documentation.html)
- [Laravel Feature Tests](https://laravel.com/docs/testing#feature-tests)
- [Laravel Unit Tests](https://laravel.com/docs/testing#unit-tests)
