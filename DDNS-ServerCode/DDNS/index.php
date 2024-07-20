<?php
// Check if the request method is POST
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Get the IP address from the POST data
    if (isset($_POST['ip'])) {
        $ip = $_POST['ip'];
        $timestamp = $_POST['timestamp'];
        $secret = $_POST['xString'];
        $secret = base64_decode($secret);
        // Optionally, validate and sanitize the IP address
        if (filter_var($ip, FILTER_VALIDATE_IP) && $secret === "stillkonfuzed.com-gbrz") {
            date_default_timezone_set('Asia/Kolkata');
            $data = [
                'ip' => $ip,
                'last_request' => $timestamp,
                'last_updated'=> date('D d M Y g:i:s a')
            ];
    
            // Write the updated data back to the JSON file
            file_put_contents("ip.json", json_encode($data, JSON_PRETTY_PRINT));

            echo json_encode(['status' => 'success', 'message' => "IP address received", 'ipdata'=>json_encode($data)]);
        } else {
            echo json_encode(['status' => 'error', 'message' => 'Invalid IP address','ip'=>$ip]);
        }
    } else {
        echo json_encode(['status' => 'error', 'message' => 'No IP address provided']);
    }
} 
if($_SERVER['REQUEST_METHOD'] === 'GET'){
    $jsonData = file_get_contents('ip.json');
    $ipdata = json_decode($jsonData, true);
?>


<html>
  <!-- Hobby Project -->
<head>
    <meta name='viewport' content='width=device-width, initial-scale=2.0, maximum-scale=1.0, 
      user-scalable=0'>
    <title>DDNS | Stillkonfuzed.com</title>
    <link class="gfavicon" rel="icon" type="image/x-icon" href="">
    <link href="https://fonts.googleapis.com/css2?family=Alata&display=swap" rel="stylesheet">
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/css/bootstrap.min.css">
</head>
<body>
  <div class="container-fluid">
    
    <div class="row main-row">
        <div class="col-md-12 header">Server IP</div>
        <div class="col-md-4">Received</div>
        <div class="col-md-4">IP</div>
        <div class="col-md-4">Updated</div>
    </div>
    <div class="row main-row">
        <div class="col-md-4"><?php echo $ipdata['last_request'];?></div>
        <div class="col-md-4"><?php echo $ipdata['ip'];?></div>
        <div class="col-md-4"><?php echo $ipdata['last_updated'];?></div>
    </div>
  </div>
</body>
<script src="https://code.jquery.com/jquery-3.6.0.min.js" crossorigin="anonymous"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/js/bootstrap.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.29.1/moment.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/moment-timezone/0.5.34/moment-timezone-with-data.min.js"></script>
<style>
    body{
        font-family: 'Alata', 'sans-serif';
    }
    .row.main-row {
        text-align: center;
        background: linear-gradient(45deg, #a8e6ff, #fbd0f0);
        filter: drop-shadow(2px 4px 6px black);
        padding: 20px;
        color: white;
        font-size: 30px;
        margin: 0px 20px;
        border-radius: 3px;
    }
    .col-md-12.header {
        font-size: 80px;
        border-bottom: 2px solid white;
        padding-bottom: 20px;
        margin-bottom: 18px;
    }
    .container-fluid {
        margin-top: 35px;
    }
</style>
<?php } ?>
