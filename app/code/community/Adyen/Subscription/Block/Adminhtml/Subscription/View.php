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

class Adyen_Subscription_Block_Adminhtml_Subscription_View extends Mage_Adminhtml_Block_Widget_Form_Container
{
    public function __construct()
    {
        $this->_blockGroup = 'adyen_subscription';
        $this->_controller = 'adminhtml_subscription';
        $this->_mode = 'view';

        parent::__construct();

        $this->_removeButton('save');
        $this->_removeButton('reset');

        if ($this->getSubscription()->canCancel()) {
            $this->_addButton('stop_subscription', [
                'class'     => 'delete',
                'label'     => Mage::helper('adyen_subscription')->__('Stop Subscription'),
                'onclick'   => "setLocation('{$this->getUrl('*/*/cancel',
                    ['id' => $this->getSubscription()->getIncrementId()])}')",
            ], 10);
        }

        if ($this->getSubscription()->isCanceled()) {
            $this->_addButton('activate_subscription', [
                'label'     => Mage::helper('adyen_subscription')->__('Activate Subscription'),
                'onclick' => "deleteConfirm('" . Mage::helper('adminhtml')->__('Are you sure you want to do reactivate this subscription?')
                    . "', '" . $this->getUrl('*/*/activateSubscription', ['id' => $this->getSubscription()->getId()]) . "')",
            ], 10);
        }

        if ($this->getSubscription()->canCreateQuote()) {
            $this->_addButton('create_quote', [
                'label' => Mage::helper('adyen_subscription')->__('Schedule Order'),
                'class' => 'add',
                'onclick' => "setLocation('{$this->getUrl('*/*/createQuote',
                    ['id' => $this->getSubscription()->getId()])}')",
            ], 20);
        }

        if ($this->getSubscription()->canEditSubscription()) {
            $this->_addButton('edit_subscription', [
                'label' => Mage::helper('adyen_subscription')->__('Edit Subscription'),
                'class' => 'add',
                'onclick' => "setLocation('{$this->getUrl('*/*/editSubscription',
                    ['id' => $this->getSubscription()->getId()])}')",
            ], 30);
        }
    }

    public function getHeaderText()
    {
        $subscription = $this->getSubscription();

        if ($subscription->getId()) {
            return Mage::helper('adyen_subscription')->__('Subscription %s for %s',
                sprintf('<i>#%s</i>', $subscription->getIncrementId()),
                sprintf('<i>%s</i>', $subscription->getCustomerName())
            );
        }
        else {
            return Mage::helper('adyen_subscription')->__('New Subscription');
        }
    }

    /**
     * @return Adyen_Subscription_Model_Subscription
     */
    public function getSubscription()
    {
        return Mage::registry('adyen_subscription');
    }

    /**
     * Get URL for back (reset) button
     *
     * @return string
     */
    public function getBackUrl()
    {
        return $this->getUrl('*/*/');
    }
}