@echo off
REM Suppress PHP deprecation warnings for Composer commands
php -d error_reporting="E_ALL & ~E_DEPRECATED & ~E_STRICT" "C:\laragon\bin\composer\composer.phar" %*