[CmdletBinding()]
param(
    [int]$Port = 8000
)

$ErrorActionPreference = 'Stop'
$ProjectRoot = Split-Path -Parent $PSScriptRoot
Set-Location $ProjectRoot

$php = Get-ChildItem 'C:\laragon\bin\php' -Directory -ErrorAction SilentlyContinue |
    Sort-Object Name -Descending |
    ForEach-Object { Join-Path $_.FullName 'php.exe' } |
    Where-Object { Test-Path $_ } |
    Select-Object -First 1

if (-not $php) {
    $phpCommand = Get-Command php -ErrorAction SilentlyContinue
    if ($phpCommand) {
        $php = $phpCommand.Source
    }
}

$ngrokCommand = Get-Command ngrok -ErrorAction SilentlyContinue
$ngrok = $null
if ($ngrokCommand) {
    $ngrok = $ngrokCommand.Source
}
if (-not $ngrok -and (Test-Path 'C:\laragon\bin\ngrok\ngrok.exe')) {
    $ngrok = 'C:\laragon\bin\ngrok\ngrok.exe'
}

if (-not $php) { throw 'PHP tidak ditemukan. Pastikan Laragon/PHP sudah terpasang.' }
if (-not $ngrok) { throw 'ngrok tidak ditemukan. Install ngrok lalu tambahkan ke PATH.' }

Write-Host "Project : $ProjectRoot" -ForegroundColor Cyan
Write-Host "PHP     : $php" -ForegroundColor DarkGray
Write-Host "Local   : http://localhost:$Port" -ForegroundColor Green
Write-Host 'Pastikan ngrok sudah login: ngrok config add-authtoken <TOKEN>' -ForegroundColor Yellow

$server = Start-Process -FilePath $php `
    -ArgumentList @('artisan', 'serve', '--host=0.0.0.0', "--port=$Port") `
    -WorkingDirectory $ProjectRoot `
    -PassThru

try {
    Write-Host "`nURL publik akan muncul di bawah. Tekan Ctrl+C untuk menutup tunnel dan server lokal.`n" -ForegroundColor Cyan
    & $ngrok http $Port
}
finally {
    if ($server -and -not $server.HasExited) {
        Stop-Process -Id $server.Id -Force -ErrorAction SilentlyContinue
    }
    Write-Host 'Server Laravel lokal dihentikan.' -ForegroundColor Yellow
}
