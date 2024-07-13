<?php
$deviceId = "";
while(strlen($deviceId) !== 5) {
    $characters = "qwertyuiopasdfghjklzxcvbnm1234567890";
    $deviceId .= $characters[mt_rand(0, strlen($characters) - 1)];
}
$deviceKey = "ULxlVAAVMhZ2GeqZA/X1GgqEEIP1ibcd3S+42pkWfmk=";
echo "DeviceId=$deviceId\nDeviceKey=$deviceKey";
?>