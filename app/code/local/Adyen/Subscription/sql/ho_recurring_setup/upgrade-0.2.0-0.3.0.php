<?php
/**
 *               _
 *              | |
 *     __ _   _ | | _  _   ___  _ __
 *    / _` | / || || || | / _ \| '  \
 *   | (_| ||  || || || ||  __/| || |
 *    \__,_| \__,_|\__, | \___||_||_|
 *                 |___/
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

$installer->run("

    -- Add entity ID column to profile quote and profile order tables

    ALTER TABLE `{$this->getTable('adyen_subscription/profile_quote')}`
		DROP FOREIGN KEY `adyen_subscription_profile_quote_profile_id`,
        MODIFY `profile_id` int(11) unsigned NOT NULL;
    ALTER TABLE `{$this->getTable('adyen_subscription/profile_quote')}`
        DROP PRIMARY KEY,
        ADD COLUMN `entity_id` int(11) unsigned DEFAULT NULL AUTO_INCREMENT FIRST,
        ADD PRIMARY KEY (`entity_id`),
        ADD CONSTRAINT `adyen_subscription_profile_quote_profile_id` FOREIGN KEY (`profile_id`) REFERENCES `adyen_subscription_profile` (`entity_id`) ON DELETE CASCADE ON UPDATE CASCADE;

    ALTER TABLE `{$this->getTable('adyen_subscription/profile_order')}`
		DROP FOREIGN KEY `adyen_subscription_profile_order_profile_id`,
        MODIFY `profile_id` int(11) unsigned NOT NULL;
    ALTER TABLE `{$this->getTable('adyen_subscription/profile_order')}`
        DROP PRIMARY KEY,
        ADD COLUMN `entity_id` int(11) unsigned DEFAULT NULL AUTO_INCREMENT FIRST,
        ADD PRIMARY KEY (`entity_id`),
        ADD CONSTRAINT `adyen_subscription_profile_order_profile_id` FOREIGN KEY (`profile_id`) REFERENCES `adyen_subscription_profile` (`entity_id`) ON DELETE CASCADE ON UPDATE CASCADE;

");

$installer->endSetup();
