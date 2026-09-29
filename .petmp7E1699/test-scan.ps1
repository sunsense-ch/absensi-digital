<#
  Tes endpoint POST /api/attendance/scan (Pertemuan 8: QR + GPS + Haversine)

  Contoh pemakaian:
    .\test-scan.ps1 -QrToken "TOKEN_HARI_INI" -Latitude -6.123456 -Longitude 108.123456

  Contoh tes koordinat tidak valid (harus ditolak 422):
    .\test-scan.ps1 -QrToken "TOKEN_HARI_INI" -Latitude 200 -Longitude 500

  Kalau HP/server beda alamat:
    .\test-scan.ps1 -QrToken "..." -Latitude -6.1 -Longitude 108.1 -BaseUrl "http://192.168.1.10:8000/api"
#>
param(
    [Parameter(Mandatory = $true)]
    [string]$QrToken,

    [Parameter(Mandatory = $true)]
    [double]$Latitude,

    [Parameter(Mandatory = $true)]
    [double]$Longitude,

    [string]$Email    = "meta@absensi.test",
    [string]$Password = "password",
    [string]$BaseUrl  = "http://127.0.0.1:8000/api"
)

# Mengirim request JSON dan mengembalikan status + body,
# baik saat sukses (2xx) maupun saat ditolak server (4xx/5xx).
function Send-Json {
    param(
        [string]$Uri,
        [hashtable]$Payload,
        [hashtable]$Headers = @{}
    )

    $Headers["Accept"] = "application/json"
    $json = $Payload | ConvertTo-Json

    try {
        $res = Invoke-WebRequest -Uri $Uri -Method Post -Headers $Headers `
            -Body $json -ContentType "application/json" -UseBasicParsing
        return @{ Status = [int]$res.StatusCode; Body = $res.Content }
    }
    catch {
        $status = 0
        $body   = $_.Exception.Message

        if ($_.Exception.Response) {
            $status = [int]$_.Exception.Response.StatusCode
        }

        if ($_.ErrorDetails -and $_.ErrorDetails.Message) {
            # PowerShell 7
            $body = $_.ErrorDetails.Message
        }
        elseif ($_.Exception.Response) {
            # Windows PowerShell 5.1
            try {
                $reader = New-Object System.IO.StreamReader($_.Exception.Response.GetResponseStream())
                $body = $reader.ReadToEnd()
            } catch { }
        }

        return @{ Status = $status; Body = $body }
    }
}

function Show-Body {
    param([string]$Body)
    try {
        $Body | ConvertFrom-Json | ConvertTo-Json -Depth 10
    }
    catch {
        Write-Host $Body
    }
}

# 1. Login
Write-Host "== LOGIN ($Email) =="
$login = Send-Json -Uri "$BaseUrl/login" -Payload @{ email = $Email; password = $Password }

if ($login.Status -ne 200) {
    Write-Host "Login gagal. HTTP $($login.Status)" -ForegroundColor Red
    Show-Body $login.Body
    exit 1
}

$token = ($login.Body | ConvertFrom-Json).token
if (-not $token) {
    Write-Host "Login berhasil tapi response tidak berisi 'token'." -ForegroundColor Red
    Show-Body $login.Body
    exit 1
}
Write-Host "Login OK. Token: $token"

# 2. Scan (QR + GPS)
Write-Host ""
Write-Host "== SCAN =="
Write-Host "qr_token  : $QrToken"
Write-Host "latitude  : $Latitude"
Write-Host "longitude : $Longitude"

$scan = Send-Json -Uri "$BaseUrl/attendance/scan" `
    -Headers @{ Authorization = "Bearer $token" } `
    -Payload @{
        qr_token  = $QrToken
        latitude  = $Latitude
        longitude = $Longitude
    }

Write-Host ""
if ($scan.Status -ge 200 -and $scan.Status -lt 300) {
    Write-Host "HASIL: VALID (HTTP $($scan.Status))" -ForegroundColor Green
}
else {
    Write-Host "HASIL: DITOLAK (HTTP $($scan.Status))" -ForegroundColor Yellow
}
Show-Body $scan.Body
