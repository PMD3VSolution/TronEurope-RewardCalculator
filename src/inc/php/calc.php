<?php
// parsing var
$votes = $_GET['votes'];
// ext.libary
include './calclib.php';
// init curl connection
$curlconn = curl_init();
// user values
$address = 'TMEQ4hu7DtLTHPn6qPsYktk1QGdTbAyTEK';
// rewardsquote 1 = 100%
$rewardsfactor = 1;   
// default values
$starttimestamp = (round( microtime(true) * 1000)) - 21600000;
$url[0] = 'https://api.tronscan.org/api/vote/current-cycle';
$url[1] = 'https://api.tronscan.org/api/witness';
$url[2] = 'https://api.tronscan.org/api/block';
$timestamp = (round( microtime(true) * 1000));
$tronsrreward = 115200;
$confblk = 0;
$prodblk = 0;
$totalvotes = 0;
$page = 0;
$i = 0;
// procedure start
foreach ($url as $call) {
// export data
if ($i == 0){
// parsing response into json
$jresponse = json_decode(apiclient($url[$i],$curlconn),true);
// extract data - votes
foreach ($jresponse['candidates'] as $value) {
    if ($value['address'] == $address){
        $srvotes = $value['votes'];
        }
    }
}

else if ($i == 1){
// parsing response into json
$jresponse = json_decode(apiclient($url[$i],$curlconn),true);
    // extract data - votes
    foreach ($jresponse as $value) {
        $totalvotes =  $totalvotes + $value['votes'];
    }
}
// extract data - block
else {
    while($timestamp > $starttimestamp){
        $urladdress=$url[$i].'?producer='.$address.'&sort=-number&start='.$page.'&limit=50';
        // parsing response into json
        $jresponse = json_decode(apiclient($urladdress,$curlconn),true);
        // extract data - votes
        foreach ($jresponse['data'] as $value) {
            if ($starttimestamp <= $value['timestamp']) {
                    if ($value['confirmed'] == 'true') {
                        $prodblk++;
                    }
                    else {
                        $confblk++;
                    }
                }
            $timestamp = $value['timestamp'];
            }
          $page=$page+50;
        }
}
    $i++;
}
// close request to clear up some resources
curl_close($curlconn);

// calc trx - 32 TRX per block
$availible_trx=(($prodblk)*32)*$rewardsfactor;
// calc voting rewards
$votingrewards=($tronsrreward/$totalvotes)*$srvotes;
// estimated rewards
$rewards=((($availible_trx+$votingrewards)/($srvotes+$votes))*$votes);
// additional outputs
//result('TOTAL SR VOTES',$totalvotes,'TRON-EUROPE VOTES',$srvotes);
//result('PERCENT',round($srvotes/$totalvotes*100,4).' %','TOTAL REWARDS',$tronsrreward.' TRX');
//result('SR REWARDS',round($votingrewards,6).' TRX','PROD BLOCKS(6h)',$prodblk );
//result('Rewards per Block:','32 TRX','total Block Rewards:',$availible_trx.' TRX');
result('EST.REWARDS (EVERY 6H)',round($rewards,4).' TRX','EST.REWARDS (DAILY)',round($rewards*4,4).' TRX');
result('EST.REWARDS (WEEKLY)',round($rewards*4*7,4).' TRX','EST.REWARDS (YEARLY)',round($rewards*4*7*365,4).' TRX');
?>
