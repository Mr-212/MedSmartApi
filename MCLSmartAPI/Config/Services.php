<?php

include_once dirname(__FILE__).'./../Constants/ServiceTypeConstants.php';
include_once dirname(__FILE__).'./../Constants/OrderTypeConstants.php';

return array (
     ServiceTypeConstants::ConsumerCreditReport => array (
            OrderTypeConstants::CREATE_ORDER,
            OrderTypeConstants::REFRESH_ORDER,
     ),
);

