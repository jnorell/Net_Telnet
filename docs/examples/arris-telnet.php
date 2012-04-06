<?php
/* vim: set expandtab softtabstop=4 tabstop=4 shiftwidth=4: */

/**
 * arris-telnet.php is an exmple of the Net_Telnet module
 * demonstrating expect/send usage then falling back to 
 * a simple line-mode telnet client.
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

require_once "Net/Telnet.php";

# Note this is used as both a hostname and as part of the command prompt
# (which works for our configuration, but check your own)
$cmts='arris-cmts';

try {
    $t = new Net_Telnet(array(
        'host'              =>  $cmts,
        'debug'             =>  false,
        'telnet_bugs'       =>  false,
    ));

    echo $t->login( array(
        'login_prompt'      =>  'Login: ',
        'login_success'     =>  "[{$cmts}]",
        'login_fail'        =>  'Login failed',
        'password_prompt'   =>  'Password: ',
        'prompt'            =>  ' remote1> ',
        'login'             =>  'root',
        'password'          =>  '',
        )
    );

    $t->page_prompt('Type: <space> to page; <return> advance 1 line; Q to quit ', ' ');

    if (   $t->send("manage\r")
        && $t->expect(" box#", "show\r")
        && $t->expect(" box#", "info\r")
        && $t->expect(" box#", "admin\r")
        && $t->expect(" admin#", "show\r")
        && $t->expect(" admin#", "info\r")
        && $t->expect(" admin#", "exit\r")
    ) {
        $t->read_stream();
        echo $t->get_data();
    } else {
        echo "ERROR looking up system information\n\n";
    }

    // Arris CMTS 1000 changes how it handles line endings in BINARY mode,
    // so just disable BINARY:
    $t->send_telcmd(TEL_DONT, TELOPT_BINARY);
    $t->send_telcmd(TEL_WONT, TELOPT_BINARY);

    // our terminal will print chars on screen, disable echo
    $t->echomode('none');

    while ($t->online() && ($s = fgets(STDIN)) !== false) {
        $t->println($s);
        if (($ret = $t->read_stream()) === false)
            break;
        echo $t->get_data();
    }

    $t->disconnect();

    // catch any buffered data
    echo $t->get_data();
}
catch (Exception $e) {
    echo "Caught Exception ('{$e->getMessage()}')\n{$e}\n";
}

exit();

?>
