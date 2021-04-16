<?php
namespace Mageplaza\Affiliate\Block\Order;
class Totals extends \Magento\Framework\View\Element\AbstractBlock
{
    public function __construct(
        \Magento\Framework\View\Element\Template\Context $context,
        array $data = []
    )
    {
        parent::__construct($context, $data);
    }
    public function getIdOrder()
    {
        return $this->request->getParam('id');
    }
    public function initTotals()
    {
    //get block parent Magento\Sales\Block\Adminhtml\Order\Totals
        $orderTotalsBlock = $this->getParentBlock();

//        $writer = new \Zend\Log\Writer\Stream(BP . '/var/log/test.log');
//        $logger = new \Zend\Log\Logger();
//        $logger->addWriter($writer);
//        $logger->info($order);

//        if ($order->getNewTotalAmount() > 0) {
            $orderTotalsBlock->addTotal(new \Magento\Framework\DataObject([
                'code'       => 'referral',
                'label'      => __('Referral'),
                'value'      => 2222,
//                'value'      => $order->getNewTotalAmount(),
//                'base_value' => $order->getNewTotalBaseAmount(),
                'base_value' => 2222,
            ]), 'subtotal');
//        }
    }
}
