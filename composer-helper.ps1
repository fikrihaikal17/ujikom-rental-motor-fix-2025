# Laravel Rental Motor Project - Composer Helper
# 
# This PowerShell profile addition helps you run Composer commands without
# seeing the yellow deprecation warnings caused by PHP 8.4.x compatibility issues.
#
# Usage examples:
#   composer-quiet install
#   composer-quiet update
#   composer-quiet require vendor/package
#   composer-quiet dump-autoload

function composer-quiet {
    param(
        [Parameter(ValueFromRemainingArguments=$true)]
        [string[]]$Arguments
    )
    
    Write-Host "Running Composer (deprecation warnings suppressed)..." -ForegroundColor Green
    & powershell -ExecutionPolicy Bypass -File ".\composer-quiet.ps1" @Arguments
}

# Example usage shown in comments above
Write-Host "Composer helper loaded! Use 'composer-quiet' instead of 'composer' to avoid deprecation warnings." -ForegroundColor Yellow