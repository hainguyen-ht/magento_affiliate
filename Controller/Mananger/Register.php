<?php
namespace Mageplaza\Affiliate\Controller\Mananger;
die('x');
class Register extends \Magento\Backend\App\Action\Action{
    public function __construct(
        \Mageplaza\Affiliate\Model\AccountFactory $accountFactory
    )
    {
        $this->accountFactory = $accountFactory;
    }

    public function execute()
    {
        
    }
}
?>
