param(
    [string]$QrToken = "TESTTOKEN_HARIINI"
)

$login = Invoke-RestMethod -Uri "http://127.0.0.1:8000/api/login" -Method Post -Body (@{email="meta@absensi.test"; password="password"} | ConvertTo-Json) -ContentType "application/json"
$token = $login.token
Write-Host "Token login: $token"
Write-Host "QR Token yang dites: $QrToken"

try {
    $scan = Invoke-RestMethod -Uri "http://127.0.0.1:8000/api/attendance/scan" -Method Post -Headers @{Authorization="Bearer $token"} -Body (@{qr_token=$QrToken} | ConvertTo-Json) -ContentType "application/json"
    Write-Host "SUCCESS:"
    $scan | ConvertTo-Json
} catch {
    Write-Host "ERROR STATUS:" $_.Exception.Response.StatusCode.value__
    $stream = $_.Exception.Response.GetResponseStream()
    $reader = New-Object System.IO.StreamReader($stream)
    $body = $reader.ReadToEnd()
    Write-Host "ERROR BODY:"
    Write-Host $body
}