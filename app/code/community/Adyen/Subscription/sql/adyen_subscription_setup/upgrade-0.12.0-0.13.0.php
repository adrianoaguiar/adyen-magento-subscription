<?php
/**
 *                       ######
 *                       ######
 * ############    ####( ######  #####. ######  ############   ############
 * #############  #####( ######  #####. ######  #############  #############
 *        ######  #####( ######  #####. ######  #####  ######  #####  ######
 * ###### ######  #####( ######  #####. ######  #####  #####   #####  ######
 * ###### ######  #####( ######  #####. ######  #####          #####  ######
 * #############  #############  #############  #############  #####  ######
 *  ############   ############  #############   ############  #####  ######
 *                                      ######
 *                               #############
 *                               ############
 *
 * Adyen Subscription module (https://www.adyen.com/)
 *
 * Copyright (c) 2015 H&O (http://www.h-o.nl/)
 * See LICENSE.txt for license details.
 *
 * Author: Adyen <magento@adyen.com>, H&O <info@h-o.nl>
 */

/* @var $installer Mage_Core_Model_Resource_Setup */
$installer = $this;

$installer->startSetup();

/** @var Magento_Db_Adapter_Pdo_Mysql $connection */
$connection = $installer->getConnection();

$subscriptionTable = $installer->getTable('adyen_subscription/subscription');
$connection->addColumn($subscriptionTable, 'stock_id', [
    'type' => Varien_Db_Ddl_Table::TYPE_INTEGER,
    'length' => 5,
    'nullable' => false,
    'unsigned' => true,
    'comment' => 'Stock ID'
]);

$stockTable = $installer->getTable('cataloginventory/stock');
$connection->addForeignKey(
    $installer->getFkName($subscriptionTable, 'stock_id', $stockTable, 'stock_id'),
    $subscriptionTable, 'stock_id', $stockTable, 'stock_id'
);

$installer->endSetup();
