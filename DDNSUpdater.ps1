$ipServiceUrl = 'https://api.ipify.org?format=json'
# Fetch the IP address
$response = Invoke-RestMethod -Uri $ipServiceUrl
$ip = $response.ip
Write-Output "Got External IP : $ip"

$serverUrl = 'https://stillkonfuzed.com/DDNS/index.php'

# Send the IP address to the server using Invoke-RestMethod and capture the HTTP response
$timestamp = (Get-Date).ToString("yyyy-MM-ddTHH:mm:ssZ")
$secret = [System.Text.Encoding]::UTF8.GetBytes("stillkonfuzed.com-gbrz")
$base64Secret = [System.Convert]::ToBase64String($secret)
$responseX = Invoke-RestMethod -Uri $serverUrl -Method Post -Body @{
    ip = $ip
    timestamp = $timestamp
    xString = $base64Secret
}

# Output the response
Write-Output "Server response: $responseX"

# Append the response to the log file
$logFilePath = "ip.txt"
"$(Get-Date) - Server response: $responseX" | Out-File -FilePath $logFilePath -Append


# Define the task name and stop it
$taskName = "ExternalIPUpdater"
Stop-ScheduledTask -TaskName $taskName
