#!/bin/bash
# Script untuk menjalankan PHPUnit tests dengan HTML coverage report
# Gunakan: ./run-tests.sh [option]
# Options:
#   test        - Jalankan semua tests (default)
#   coverage    - Jalankan tests dengan coverage report HTML
#   register    - Jalankan hanya registration tests
#   clean       - Hapus coverage report lama

if [ "$1" == "clean" ]; then
    echo "Menghapus coverage report lama..."
    if [ -d "coverage" ]; then
        rm -rf coverage
        echo "✓ Coverage report dihapus"
    else
        echo "Coverage folder tidak ditemukan"
    fi
    exit 0
fi

if [ "$1" == "coverage" ]; then
    echo "Menjalankan tests dengan coverage report..."
    [ -d "coverage" ] && rm -rf coverage
    php artisan test --coverage
    echo ""
    echo "✓ Coverage report telah dibuat di folder: coverage/"
    echo "Buka file ini di browser: coverage/index.html"
    exit 0
fi

if [ "$1" == "register" ]; then
    echo "Menjalankan registration tests..."
    php artisan test tests/Feature/Auth tests/Unit/Models/UserModelTest.php --verbose
    exit 0
fi

if [ -z "$1" ]; then
    echo "Menjalankan semua tests..."
    php artisan test
    exit 0
fi

echo "Usage: ./run-tests.sh [option]"
echo "Options:"
echo "  test        - Jalankan semua tests (default)"
echo "  coverage    - Jalankan tests dengan coverage report HTML"
echo "  register    - Jalankan hanya registration tests"
echo "  clean       - Hapus coverage report lama"
