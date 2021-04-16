<?php
/**
 * Copyright © 2015 Magento. All rights reserved.
 * See COPYING.txt for license details.
 */
namespace Mageplaza\Affiliate\Model\Quote;

class Discount extends \Magento\Quote\Model\Quote\Address\Total\AbstractTotal
{
    /**
     * Discount calculation object
     *
     * @var \Magento\SalesRule\Model\Validator
     */
    protected $calculator;

    /**
     * Core event manager proxy
     *
     * @var \Magento\Framework\Event\ManagerInterface
     */
    protected $eventManager = null;

    /**
     * @var \Magento\Store\Model\StoreManagerInterface
     */
    protected $storeManager;
    protected $amountRefer;
    /**
     * @var \Magento\Framework\Pricing\PriceCurrencyInterface
     */
    protected $priceCurrency;

    /**
     * @param \Magento\Framework\Event\ManagerInterface $eventManager
     * @param \Magento\Store\Model\StoreManagerInterface $storeManager
     * @param \Magento\SalesRule\Model\Validator $validator
     * @param \Magento\Framework\Pricing\PriceCurrencyInterface $priceCurrency
     */
    public function __construct(
        \Magento\Framework\Event\ManagerInterface $eventManager,
        \Magento\Store\Model\StoreManagerInterface $storeManager,
        \Magento\SalesRule\Model\Validator $validator,
        \Magento\Framework\Pricing\PriceCurrencyInterface $priceCurrency,
        \Magento\Framework\App\Config\ScopeConfigInterface $scopeConfig,
        \Magento\Checkout\Model\Session $checkoutSession
    ) {
        $this->eventManager = $eventManager;
        $this->calculator = $validator;
        $this->storeManager = $storeManager;
        $this->priceCurrency = $priceCurrency;
        $this->scopeConfig = $scopeConfig;
        $this->checkoutSession = $checkoutSession;
    }

    /**
     * Collect address discount amount
     *
     * @param \Magento\Quote\Model\Quote $quote
     * @param \Magento\Quote\Api\Data\ShippingAssignmentInterface $shippingAssignment
     * @param \Magento\Quote\Model\Quote\Address\Total $total
     * @return $this
     * @SuppressWarnings(PHPMD.CyclomaticComplexity)
     */
    public function collect(
        \Magento\Quote\Model\Quote $quote,
        \Magento\Quote\Api\Data\ShippingAssignmentInterface $shippingAssignment,
        \Magento\Quote\Model\Quote\Address\Total $total
    )
    {
        parent::collect($quote, $shippingAssignment, $total);
        //tinh toan
        $typeApply = $this->scopeConfig->getValue('affiliate/affiliate_rule/apply_discount_to_customer',
            \Magento\Store\Model\ScopeInterface::SCOPE_STORE);
        $discountValue = $this->scopeConfig->getValue('affiliate/affiliate_rule/discount_value',
            \Magento\Store\Model\ScopeInterface::SCOPE_STORE);
        $key = $this->scopeConfig->getValue('affiliate/general/url_key',
            \Magento\Store\Model\ScopeInterface::SCOPE_STORE);
        //Check refer
        if(isset($_COOKIE[$key])){
            switch ($typeApply){
                case 'fixed':
                    $amount = $discountValue;
                    break;
                case 'percentage':
                    $amount = $total->getData()['subtotal'] * ($discountValue / 100) ;
                    break;
                default:
                    $amount = 0;
            }
        }else {
            $amount = 0;
        }
        // set amount
        $amount = 0- $amount;
//        $amount = 1000;
        if($total->getData()['subtotal'] <= abs($amount)){
            $amount = 0 - $total->getData()['subtotal'];
        }

//        $writer = new \Zend\Log\Writer\Stream(BP . '/var/log/test.log');
//        $logger = new \Zend\Log\Logger();
//        $logger->addWriter($writer);
//        $logger->info($_COOKIE[$key]);

        $total->addTotalAmount($this->getCode(), $amount);
        $this->amountRefer = $amount;

        return $this;
    }
    /**
     * Add discount total information to address
     *
     * @param \Magento\Quote\Model\Quote $quote
     * @param \Magento\Quote\Model\Quote\Address\Total $total
     * @return array|null
     */
    public function fetch(\Magento\Quote\Model\Quote $quote, \Magento\Quote\Model\Quote\Address\Total $total)
    {
        // hien thi
//        if($this->amountRefer > 0){
            return $result = [
                'code' => $this->getCode(),
                'title' => __('Referral'),
                'value' => $this->amountRefer
            ];
//        }
    }
}
