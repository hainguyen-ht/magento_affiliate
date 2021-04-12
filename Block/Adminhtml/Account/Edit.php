<?php
namespace Mageplaza\Affiliate\Block\Adminhtml\Account;

class Edit extends \Magento\Backend\Block\Widget\Form\Container
{
    protected $_coreRegistry;

    public function __construct(
        \Magento\Framework\Registry $coreRegistry,
        \Magento\Backend\Block\Widget\Context $context,
        array $data = []
    )
    {
        $this->_coreRegistry = $coreRegistry;
        parent::__construct($context, $data);
    }
    protected function _construct()
    {
        $this->_objectId = 'account_id';
        $this->_blockGroup = 'Mageplaza_Affiliate';
        $this->_controller = 'adminhtml_account';
        parent::_construct();
    }
}
?>
