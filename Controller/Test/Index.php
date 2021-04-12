<?php
namespace Mageplaza\Affiliate\Controller\Test;

class Index extends \Magento\Framework\App\Action\Action
{
    public function __construct(
        \Magento\Framework\App\Action\Context $context,
        \Mageplaza\Affiliate\Model\AccountFactory $accountFactory
    )
    {
        $this->accountFactory = $accountFactory;
        return parent::__construct($context);
    }

    public function execute(){

        $data = $this->accountFactory->create();
        foreach ($data->getCollection() as $item) {
            echo "<pre>";
            print_r($item->getData());
            echo "</pre>";
        }
        die();
    }

}
?>
