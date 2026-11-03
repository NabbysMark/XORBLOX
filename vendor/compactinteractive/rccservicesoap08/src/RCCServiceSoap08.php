<?php

namespace CompactInteractive;

class RCCServiceSoap08 {
    public static $ip;
    public static $port;
    public static $url;
    public static $fullurl;

    // Error handling
    public static array $errors = [];

    public static function hasErrors() {
        if(empty(self::$errors)) {
            return true;
        }

        return false;
    }

    public static function getErrors() {
        foreach (self::$errors as $error) {
            return "Error: {$error} <br>";
        }
    }

    // Set the variables.
    public static function init($ip = "127.0.0.1", $port = 64989, $url = "roblox.com") {
        // Validate given variables.
        
        // ip check
        if(!filter_var($ip, FILTER_VALIDATE_IP)) {
            self::$errors[] = "Invalid IP address given.";
        }

        // port check
        if(!is_int($port) || $port < 1 || $port > 65535) {
            self::$errors[] = "Invalid port given.";
        }
        
        // url check
        if(str_starts_with($url, 'http://') || str_starts_with($url, 'https://')) {
            // remove the http or https
            $finalurl = str_replace(['http://', 'https://'], '', $url);
            $finalurl = rtrim($finalurl, '/');
        }else {
            $finalurl = $url;
        }

        if(empty(self::$errors)) {
            self::$ip = $ip;
            self::$port = $port;
            self::$url = $finalurl;
            self::$fullurl = "http://{$ip}:{$port}";

            return true;
        }

        return false;
    }

    public static function request($xml) {
        $ch = curl_init(self::$fullurl);

        curl_setopt($ch, CURLOPT_HTTPHEADER, [ "Content-Type: text/xml" ]);
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $xml);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, false);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);

        $response = curl_exec($ch);

        // Curl error handling
        if (curl_errno($ch)) {
            $error = curl_error($ch);
            self::$errors[] = "CURL Error: {$error}";
            return false;
        }
        // Status code check
        $status = curl_getinfo($ch, CURLINFO_HTTP_CODE);
    
        if ($status !== 200) {
            self::$errors[] = "CURL returned status code: {$status}";
            return false;
        }

        // Remove the gunk from RCC
        $result = str_replace(
            [
                "<ns1:value>",
                "</ns1:value>",
                "</ns1:OpenJobResult>",
                "<ns1:OpenJobResult>",
                "<ns1:type>",
                "</ns1:type>",
                "<ns1:table>",
                "</ns1:table>",
                "</ns1:OpenJobResult>",
                "</ns1:OpenJobResponse>",
                "</SOAP-ENV:Body>",
                "</SOAP-ENV:Envelope>"
            ],
            "",
            strstr(
                str_replace(
                    [
                        "LUA_TSTRING",
                        "LUA_TNUMBER",
                        "LUA_TBOOLEAN",
                        "LUA_TTABLE"
                    ],
                    "",
                    $response
                ),
                "<ns1:value>"
            )
        );

        $valuepos = strpos($result, "<ns1:LuaValue>");

        if ($valuepos !== false) {
            $result = substr($result, 0, $valuepos);
        }

        // dunno what this does but it looks cool
        clearstatcache();

        return $result;
    }

    public static function execute($script = 'print("No script given.")', $id = null, $expiration = 0.1) {
        if($id === null) {
            $id = bin2hex(random_bytes(16));
        }

        // Sanitize variables.
        $id = htmlspecialchars($id, ENT_XML1, 'UTF-8', false);
        $expiration = htmlspecialchars((string)$expiration, ENT_XML1, 'UTF-8', false);
        $script = htmlspecialchars($script, ENT_XML1, 'UTF-8', false);
        $url = self::$url;

        $xml = <<<XML
        <?xml version="1.0" encoding="UTF-8"?>
        <SOAP-ENV:Envelope xmlns:SOAP-ENV="http://schemas.xmlsoap.org/soap/envelope/" xmlns:SOAP-ENC="http://schemas.xmlsoap.org/soap/encoding/" xmlns:xsi="http://www.w3.org/2001/XMLSchema-instance" xmlns:xsd="http://www.w3.org/2001/XMLSchema" xmlns:ns1="http://{$url}/" xmlns:ns2="http://{$url}/RCCServiceSoap" xmlns:ns3="http://{$url}/RCCServiceSoap12">
            <SOAP-ENV:Body>
                <ns1:OpenJob>
                    <ns1:job>
                        <ns1:id>{$id}</ns1:id>
                        <ns1:expirationInSeconds>{$expiration}</ns1:expirationInSeconds>
                        <ns1:category>1</ns1:category>
                        <ns1:cores>321</ns1:cores>
                    </ns1:job>
                    <ns1:script>
                        <ns1:name>Script</ns1:name>
                        <ns1:script>
                            {$script}
                        </ns1:script>
                    </ns1:script>
                </ns1:OpenJob>
            </SOAP-ENV:Body>
        </SOAP-ENV:Envelope>
        XML;

        return self::request($xml);
    }

    public static function closeJob($jobID) {
        $jobID = htmlspecialchars($jobID, ENT_XML1, 'UTF-8', false);
        $url = self::$url;

        $xml = <<<XML
        <?xml version="1.0" encoding="UTF-8"?>
        <SOAP-ENV:Envelope
            xmlns:SOAP-ENV="http://schemas.xmlsoap.org/soap/envelope/"
            xmlns:SOAP-ENC="http://schemas.xmlsoap.org/soap/encoding/"
            xmlns:xsi="http://www.w3.org/2001/XMLSchema-instance"
            xmlns:xsd="http://www.w3.org/2001/XMLSchema"
            xmlns:ns1="http://{$url}/"
            xmlns:ns2="http://{$url}/RCCServiceSoap"
            xmlns:ns3="http://{$url}/RCCServiceSoap12">
            <SOAP-ENV:Body>
                <ns1:CloseJob>
                    <ns1:jobID>{$jobID}</ns1:jobID>
                </ns1:CloseJob>
            </SOAP-ENV:Body>
        </SOAP-ENV:Envelope>
        XML;

        return self::request($xml);
    }
}
