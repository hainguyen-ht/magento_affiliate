<?php
namespace Mageplaza\Affiliate\Block\Adminhtml\Account\Edit\Tab;

use Magento\Backend\Block\Widget\Form\Generic;
use Magento\Backend\Block\Widget\Tab\TabInterface;

class Main extends \Magento\Backend\Block\Widget\Form\Generic implements \Magento\Backend\Block\Widget\Tab\TabInterface
{
    public function __construct(
        \Magento\Backend\Block\Template\Context $context,
        \Magento\Framework\Registry $registry,
        \Magento\Framework\Data\FormFactory $formFactory,
        \Mageplaza\Affiliate\Model\AccountFactory $accountFactory,
        array $data = []
    )
    {
        $this->accountFactory = $accountFactory;
        parent::__construct($context, $registry, $formFactory, $data);
    }

    protected function _prepareForm()
    {
        $model = $this->_coreRegistry->registry('affiliate_form_data');
//
        $form = $this->_formFactory->create();
        $account = $this->accountFactory->create();
        $id = $this->getRequest()->getParams('id');
//
//        $writer = new \Zend\Log\Writer\Stream(BP . '/var/log/test.log');
//        $logger = new \Zend\Log\Logger();
//        $logger->addWriter($writer);
//        $logger->info($model);
//
//
        $fieldset = $form->addFieldset('base_fieldset', ['legend' => __('Account Infomation')]);
        $fieldset->addField(
            'customer_id',
            'text', [
                    'name'     => 'customer_id',
                    'label'    => __('Customer ID'),
                    'title'    => __('customer_id'),
                    'required' => true
            ]
        );
        $fieldset->addField(
            'status',
            'select',
            [
                'label' => __('Status'),
                'title' => __('Status'),
                'name' => 'is_enabled',
                'required' => true,
                'options' => ['1' => ('Enabled'), '0' => ('Disabled')]
            ]
        );
        $fieldset->addField(
            'balance',
            'text', [
                'name'     => 'balance',
                'label'    => __('Balance'),
                'title'    => __('balance')
            ]
        );
//
        $this->setForm($form);
        return parent::_prepareForm();
    }
    public function getTabLabel()
    {
        return __('Gift card information');
    }
    public function getTabTitle()
    {
        return $this->getTabLabel();
    }
    public function canShowTab()
    {
        return true;
    }
    public function isHidden()
    {
        return false;
    }
}
?>

