<#
Prepare-deploy helper for Render

Usage:
  .\prepare_deploy.ps1            # prepare files, generate APP_KEY, build assets
  .\prepare_deploy.ps1 -RunMigrations  # also run migrations (requires DB env set)
#>

param(
    [switch]$RunMigrations
)

function Exec($cmd) {
    Write-Host "-> $cmd"
    & cmd /c $cmd
    if ($LASTEXITCODE -ne 0) { Write-Warning "Command failed: $cmd" }
}

$repoRoot = (Get-Location).Path
$envFile = Join-Path $repoRoot '.env.production'
$envExample = Join-Path $repoRoot '.env.production.example'

if (-not (Test-Path $envFile)) {
    if (Test-Path $envExample) {
        Copy-Item $envExample $envFile
        Write-Host "Created .env.production from example. Please fill secrets if needed."
    } else {
        Write-Warning ".env.production.example not found. Create .env.production manually."
    }
} else {
    Write-Host ".env.production already exists."
}

# Generate APP_KEY and inject
try {
    $appKey = & php artisan key:generate --show 2>&1
    if ($LASTEXITCODE -eq 0 -and $appKey) {
        (Get-Content $envFile) -replace 'APP_KEY=.*', "APP_KEY=$appKey" | Set-Content $envFile
        Write-Host "APP_KEY written to .env.production"
    } else {
        Write-Warning "Failed to generate APP_KEY. Run 'php artisan key:generate --show' manually."
    }
} catch {
    Write-Warning "php not available or artisan failed. Ensure PHP is in PATH."
}

Write-Host "Reminder: edit .env.production and set DB_*, AWS_*, MAIL_* before pushing to Render. Do NOT commit secrets."

Write-Host "Running composer install (no dev)..."
Exec 'composer install --no-interaction --prefer-dist --optimize-autoloader'

Write-Host "Building frontend (npm)..."
if (Test-Path package.json) {
    Exec 'npm ci'
    Exec 'npm run build'
} else { Write-Host "No package.json found; skipping npm steps." }

Write-Host "Creating storage symlink..."
Exec 'php artisan storage:link'

if ($RunMigrations) {
    Write-Host "Running migrations..."
    Exec 'php artisan migrate --force'
} else {
    Write-Host "To run migrations on local/Render, run: php artisan migrate --force"
}

Write-Host "Prepare-deploy finished. Push branch to remote and create Render service using render.yaml."
