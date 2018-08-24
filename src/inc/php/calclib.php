<?php 
// apicall function
function apiclient($url,$conn) {
    // set connection option
    curl_setopt_array($conn, array(
        CURLOPT_RETURNTRANSFER => 1,
        CURLOPT_URL => $url,
    ));
    // return the response
    return curl_exec($conn);
};

// generate output function
function result($desc0,$resval0,$desc1,$resval1){
    echo '<div class="row-detail">';
    echo '  <div class="w-100"></div>';
    echo '  <div class="col align-self-start"><h6 class="text-center">'.$desc0.'</h5></div>';
    echo '  <div class="col"><h6 class="text-center">'.$desc1.'</h5></div>';
    echo '  <div class="w-100"></div>';
    echo '  <div class="col align-self-start"><h5 class="text-center">'.$resval0.'</div>';
    echo '  <div class="col"><h5 class="text-center">'.$resval1.'</div>';
    echo '</div>';
}
?>