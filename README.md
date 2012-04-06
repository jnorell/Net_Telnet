Net_Telnet
==========

Net_Telnet provides a PHP implementation of the TELNET protocol.

RFCs
----

Net_Telnet implements the following:

* RFC 854  TELNET Protocol Specification
* RFC 855  TELNET Option Specification
* RFC 856  TELNET Binary Transmission
* RFC 857  TELNET ECHO Option
* RFC 858  TELNET SUPPRESS GO AHEAD option
* RFC 860  TELNET TIMING MARK option

Use
---

Net_Telnet has been used for short-running scripts, eg. to login to a device
and check status or reboot; I don't know how it would fair in handling
long-running connections or in more complex applications.  Also it has only
been used as a TELNET client, the initial options and other default behavior
would need to be reviewed to operate correctly as a TELNET server (and need to
add a listen() function).

    <?php
    require_once "Net/Telnet.php";

    try {
        $t = new Net_Telnet('10.15.20.25');
        $t->connect();

        echo $t->login( array(
            'login_prompt'  => '',
            'login_success' => '',
            'login_fail'    => '% Access denied',
            'login'         => '',
            'password'      => 'cisco_password',
            'prompt'        => 'Cisco>',
            )
        );

        echo $t->cmd('show version');

        $t->disconnect();

        echo $t->get_data();
        echo "\n";
    }
    catch (Exception $e) {
        echo "Caught Exception ('{$e->getMessage()}')\n{$e}\n";
    }

    exit();
    ?>

Code
----

Source Code is available at github:

    https://github.com/jnorell/Net_Telnet

There is currently no packaging for PEAR or otherwise.

Reporting Bugs
--------------

There's an Issue tracker on the github page if you want to report bugs.

PEAR
-------

I'll look at making this a full PEAR package eventually,
but it's a standalone project at the moment.

Author
------

Net_Telnet in current form was written by Jesse Norell <jesse@kci.net>.

License
-------

    Copyright 2012 Jesse Norell <jesse@kci.net>
    Copyright 2012 Kentec Communications, Inc.

    Licensed under the Apache License, Version 2.0 (the "License");
    you may not use this file except in compliance with the License.
    You may obtain a copy of the License at

        http://www.apache.org/licenses/LICENSE-2.0

    Unless required by applicable law or agreed to in writing, software
    distributed under the License is distributed on an "AS IS" BASIS,
    WITHOUT WARRANTIES OR CONDITIONS OF ANY KIND, either express or implied.
    See the License for the specific language governing permissions and
    limitations under the License.

