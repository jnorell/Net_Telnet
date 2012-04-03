<?php
/* vim: set expandtab softtabstop=4 tabstop=4 shiftwidth=4: */

/**
 * cisco.php is an exmple of the Net_Telnet module
 * demonstrating Cisco router compatible options
 * and use of page prompt.
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

$router='router1';
$password='ubersecret';
$enable_secret='evenmoreso';

try {
    $t = new Net_Telnet($router);
    $t->connect();

    echo $t->login( array(
        'login_prompt'  => '',
        'login_success' => '',
        'login'         => '',
        'password'      => $password,
        'prompt'        => "{$router}>",
        )
    );

    // Cisco page prompt
    $t->page_prompt("\n --More-- ", " ");

    echo $t->cmd('show version');
    echo $t->cmd('traceroute github.com');

    # send enable command
    $t->println("enable");

    # reuse login() to send enable secret
    echo $t->login( array(
        'password'      => $enable_secret,
        'prompt'        => "{$router}#",
        )
    );

    echo $t->cmd('show running-config');

    $t->disconnect();

    // catch any buffered data
    echo $t->get_data();
    echo "\n";
}
catch (Exception $e) {
    echo "Caught Exception ('{$e->getMessage()}')\n{$e}\n";
}

exit();
?>
