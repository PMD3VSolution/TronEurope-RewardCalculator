function rewcalc(votes) {
    if (votes.length == 0) {
        document.getElementById("edtvotes").innerHTML = "";
        return;
    } else {
        var xmlhttp = new XMLHttpRequest();
        xmlhttp.onreadystatechange = function() {
            if (this.readyState == 4 && this.status == 200) {
                document.getElementById("edtvotes").innerHTML = this.responseText;
            }
        }
        xmlhttp.open("GET", "inc/php/calc.php?votes="+votes, true);
        xmlhttp.send();
    }
}
