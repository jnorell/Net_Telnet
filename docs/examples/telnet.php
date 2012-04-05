<?php
/* vim: set expandtab softtabstop=4 tabstop=4 shiftwidth=4: */

/**
 * telnet.php is an exmple of the Net_Telnet module
 * providing a simple line-mode telnet client.  There's
 * no pty control, etc. - this is not /usr/bin/telnet !
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

try {
    // These settings worked with Allied Telesis cpe:
    $t = new Net_Telnet(array(
        'host'              =>  '10.20.30.40',
        'login_prompt'      =>  'Login: ',
        'password_prompt'   =>  'Password: ',
        'login_success'     =>  'Login successful',
        'prompt'            =>  '-->',
        'debug'             =>  false,
    ));

    echo $t->login( array(
        'login'             =>  'manager',
        'password'          =>  'friend',
        )
    );

    // our terminal displays chars, so disable echo
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
