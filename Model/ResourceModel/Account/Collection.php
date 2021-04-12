<?php
namespace Mageplaza\Affiliate\Model\ResourceModel\Account;

class Collection extends \Magento\Framework\Model\ResourceModel\Db\Collection\AbstractCollection
{
    protected $_idFieldName = 'account_id';
    protected $_eventPrefix = 'affiliate_account_collection';
    protected $_eventObject = 'account_collection';

    /**
     * Define resource model
     *
     * @return void
     */
    protected function _construct()
    {
        $this->_init('Mageplaza\Affiliate\Model\Account', 'Mageplaza\Affiliate\Model\ResourceModel\Account');
    }

}
