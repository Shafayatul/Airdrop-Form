<?php
session_start();

$api_url = 'http://airdrop-form.test/';
$auth_url = $api_url . 'oauth/';
$client_id = 2;
$redirect_uri = 'http://playground.test/oauth.php';
$client_secret = 'TsmyPvNCjdX2dH3MNlBg9oUVFurtqWCC8ijXAoUg';

$isUserLoggedIn = false;

if (isset($_GET['logout'])) {
  session_destroy();
  header("Refresh:0; url=oauth.php");
  exit(0);
}

function redirectToAuthorization()
{
    global $client_id, $redirect_uri, $auth_url;
    if (!isset($_GET['code'])) {
        $query = http_build_query([
          'client_id' => $client_id,
          'redirect_uri' => $redirect_uri,
          'response_type' => 'code',
          'scope' => 'email',
        ]);

        header('Location: ' . $auth_url . 'authorize' . '?' . $query);
        exit(0);
    }
}

function getAccessToken()
{
    global $client_id, $redirect_uri, $auth_url, $client_secret;
    if (isset($_GET['code'])) {
        // code is retrived exchange it to get token
        $data = [
          'grant_type' => 'authorization_code',
          'client_id' => $client_id,
          'client_secret' => $client_secret,
          'redirect_uri' => $redirect_uri,
          'code' => $_GET['code'],
        ];
        $params = http_build_query($data);
        //open connection
        $ch = curl_init();
        //set the url, number of POST vars, POST data
        curl_setopt($ch, CURLOPT_URL, $auth_url . 'token');
        curl_setopt($ch, CURLOPT_POST, count($data));
        curl_setopt($ch, CURLOPT_POSTFIELDS, $params);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        //execute post
        $result = curl_exec($ch);
        //close connection
        curl_close($ch);
        $token = json_decode($result, true);
        $_SESSION['access_token'] = $token;
        header("Refresh:0; url=oauth.php");
    }
}

if (isset($_SESSION['access_token'])) {
    $isUserLoggedIn = true;
} else {
    if (isset($_GET['auth'])) {
        redirectToAuthorization();
    }
    if (isset($_GET['code'])) {
        getAccessToken();
    }
}

function getUserDetails()
{
    global $api_url;
    $token = $_SESSION['access_token']['access_token'];
    $ch = curl_init();
    //set the url, number of POST vars, POST data
    curl_setopt($ch, CURLOPT_URL, $api_url . 'api/me');
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_HTTPHEADER, array(
      'Authorization: Bearer ' . $token,
      'Accept: application/json'
    ));
    //execute post
    $result = curl_exec($ch);
    //close connection
    curl_close($ch);
    return json_decode($result, true);
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta http-equiv="X-UA-Compatible" content="ie=edge">
  <title>Document</title>
</head>
<body>
<?php if ($isUserLoggedIn) {
  $user = getUserDetails();
?>
    Hello <?php echo $user['name'] ?>, <br />
    your Email is: <?php echo $user['email'] ?> <br />
    <a href="?logout=true">Logout</a>
<?php } else { ?>
    <a href="?auth=true">Login With Airdrop Form</a>
<?php } ?>
</body>
</html>
