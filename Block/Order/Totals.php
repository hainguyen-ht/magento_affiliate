<?php
namespace Mageplaza\Affiliate\Block\Order;
use Magento\Sales\Block\Order;

class Totals extends \Magento\Framework\View\Element\AbstractBlock
{
    public function __construct(
        \Magento\Framework\App\RequestInterface $request,
        \Magento\Framework\View\Element\Template\Context $context,
        \Magento\Sales\Model\OrderFactory $orderFactory,
        \Mageplaza\Affiliate\Model\HistoryFactory $historyFactory,
        array $data = []
    )
    {
        $this->orderFactory = $orderFactory;
        $this->request = $request;
        $this->historyFactory = $historyFactory;
        parent::__construct($context, $data);
    }
    public function initTotals()
    {
        $history = $this->historyFactory->create();
//    //get block parent Magento\Sales\Block\Adminhtml\Order\Totals
        $orderTotalsBlock = $this->getParentBlock();
        $order = $orderTotalsBlock->getOrder();
        $orderDetail = $this->orderFactory->create()->load($order->getId())->getData();
        $valueReferral = $orderDetail['base_discount_referral_affiliate'];
        if($historyCms = $history->load($order->getId(), 'order_id')->getData()){
            $valueCommisstion = $historyCms['amount'];
        }
            $orderTotalsBlock->addTotal(new \Magento\Framework\DataObject([
                'code'       => 'referral',
                'label'      => __('Referral'),
                'value'      => $valueReferral ?? 0,
            ]), 'subtotal');

            $orderTotalsBlock->addTotal(new \Magento\Framework\DataObject([
                'code'       => 'commisstion',
                'label'      => __('Commisstion'),
                'value'      => $valueCommisstion ?? 0,
            ]), 'subtotal');
    }
}
