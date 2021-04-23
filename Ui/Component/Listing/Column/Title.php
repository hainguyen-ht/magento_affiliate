<?php

namespace Mageplaza\Affiliate\Ui\Component\Listing\Column;

class Title implements \Magento\Framework\Option\ArrayInterface
{
    /**
     * Options getter
     *
     * @return array
     */
    public function __construct(\Mageplaza\Affiliate\Model\HistoryFactory $historyFactory)
    {
        $this->historyFactory = $historyFactory;
    }

    public function toOptionArray()
    {
        $history = $this->historyFactory->create();
//        $writer = new \Zend\Log\Writer\Stream(BP . '/var/log/test.log');
//        $logger = new \Zend\Log\Logger();
//        $logger->addWriter($writer);
//        $logger->info($history->load());

        return [
            ['value' => 1, 'label' => ('Changed by Admin')],
            ['value' => 0, 'label' => ('Created from order')]
        ];
    }
}
