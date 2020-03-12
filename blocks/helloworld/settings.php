<?php

$settings->add(new admin_setting_heading(
    'headerconfig',
    get_string('helloworld:headerconfig', 'block_helloworld'),
    get_string('helloworld:descconfig', 'block_helloworld')
));

$settings->add(new admin_setting_configcheckbox(
    'helloworld/Colored_Text',
    get_string('helloworld:labelcoloredtext', 'block_helloworld'),
    get_string('helloworld:desccoloredtext', 'block_helloworld'),
    '0'
));