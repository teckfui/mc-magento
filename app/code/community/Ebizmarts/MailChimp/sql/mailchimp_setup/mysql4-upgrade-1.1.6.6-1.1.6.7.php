<?php

$installer = $this;

try {
    $installer->run(
        "
ALTER TABLE `{$this->getTable('sales_flat_order')}` 
ADD INDEX `IDX_M4M_SALES_FLAT_ORDER_CUSTOMER_EMAIL` (`customer_email`);
"
    );
} catch (Exception $e) {
    Mage::log($e->getMessage(), null, 'MailChimp_Errors.log', true);
}

$installer->endSetup();