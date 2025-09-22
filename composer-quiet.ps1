# PowerShell script to run Composer with suppressed deprecation warnings
param(
    [Parameter(ValueFromRemainingArguments=$true)]
    [string[]]$Arguments
)

# Run composer and filter out deprecation notices
& php "C:\laragon\bin\composer\composer.phar" @Arguments 2>&1 | Where-Object { 
    $_ -notmatch "Deprecation Notice:" 
}