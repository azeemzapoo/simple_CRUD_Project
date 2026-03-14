#!/usr/bin/env bash
cd "$(dirname "$0")"

echo "=== 1. Running migrations (create tables) ==="
php migration/migrate.php
echo ""

echo "=== 2. Seeding data (users, families, instruments, orders) ==="
php migration/seed.php
echo ""

echo "=== 3. Starting PHP server at http://localhost:8000 ==="
echo "    Open in browser: http://localhost:8000/"
echo "    Press Ctrl+C to stop"
echo ""
php -S localhost:8000 -t public
