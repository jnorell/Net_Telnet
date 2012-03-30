<?php
/* vim: set expandtab softtabstop=4 tabstop=4 shiftwidth=4: */

/**
 * http_get.php is an exmple of the Net_Telnet module
 * which simply sends an HTTP GET and prints the output.
 *
 * PHP version 5
 *
 *  Copyright 2012 Jesse Norell <jesse@kci.net>
 *  Copyright 2012 Kentec Communications, Inc.
 *
 *  Licensed under the Apache License, Version 2.0 (the "License");
 *  you may not use this file except in compliance with the License.
 *  You may obtain a copy of the License at
 *
 *    http://www.apache.org/licenses/LICENSE-2.0
 *
 *  Unless required by applicable law or agreed to in writing, software
 *  distributed under the License is distributed on an "AS IS" BASIS,
 *  WITHOUT WARRANTIES OR CONDITIONS OF ANY KIND, either express or implied.
 *  See the License for the specific language governing permissions and
 *  limitations under the License.
 *
 * @category    Networking
 * @version     0.1 alpha
 * @author      Jesse Norell <jesse@kci.net>
 * @copyright   2012 Jesse Norell <jesse@kci.net>
 * @copyright   2012 Kentec Communications, Inc.
 * @license     http://www.apache.org/licenses/LICENSE-2.0 Apache License
 * @link        https://github.com/jnorell/Net_Telnet
 */

require_once("Net/Telnet.php");

$www = "www.google.com";
$debug = false;

try {
    $t = new Net_Telnet( array('debug'=>$debug, 'telnet'=>false,) );
    $t->connect( array('host'=>$www, 'port'=>80,) );
    $t->println("GET / HTTP/1.1\nHost: {$www}\n\n");
    $t->read_stream();
    echo $t->get_data();
    $t->disconnect();
}
catch (Exception $e) {
    echo "Caught Exception ('{$e->getMessage()}')\n{$e}\n";
}

exit();

?>
