@echo off
REM Script untuk menjalankan PHPUnit tests dengan HTML coverage report
REM Gunakan: run-tests.bat [option]
REM Options:
REM   test        - Jalankan semua tests (default)
REM   coverage    - Jalankan tests dengan coverage report HTML
REM   register    - Jalankan hanya registration tests
REM   clean       - Hapus coverage report lama

setlocal enabledelayedexpansion

if "%1"=="clean" (
    echo Menghapus coverage report lama...
    if exist coverage (
        rmdir /s /q coverage
        echo ✓ Coverage report dihapus
    ) else (
        echo Coverage folder tidak ditemukan
    )
    exit /b 0
)

if "%1"=="coverage" (
    echo Menjalankan tests dengan coverage report...
    if exist coverage rmdir /s /q coverage
    php artisan test --coverage
    echo.
    echo ✓ Coverage report telah dibuat di folder: coverage/
    echo Buka file ini di browser: coverage/index.html
    exit /b 0
)

if "%1"=="register" (
    echo Menjalankan registration tests...
    php artisan test tests/Feature/Auth tests/Unit/Models/UserModelTest.php --verbose
    exit /b 0
)

if "%1"=="" (
    echo Menjalankan semua tests...
    php artisan test
    exit /b 0
)

echo Usage: run-tests.bat [option]
echo Options:
echo   test        - Jalankan semua tests (default)
echo   coverage    - Jalankan tests dengan coverage report HTML
echo   register    - Jalankan hanya registration tests
echo   clean       - Hapus coverage report lama
