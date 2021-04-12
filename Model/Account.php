<?php
namespace Mageplaza\Affiliate\Model;

class Account extends \Magento\Framework\Model\AbstractModel implements \Magento\Framework\DataObject\IdentityInterface
{
    const CACHE_TAG = 'affiliate_account';

    protected $_cacheTag = 'affiliate_account';

    protected $_eventPrefix = 'affiliate_account';

    protected function _construct()
    {
        $this->_init('Mageplaza\Affiliate\Model\ResourceModel\Account');
    }

    public function getIdentities()
    {
        return [self::CACHE_TAG . '_' . $this->getId()];
    }

    public function getDefaultValues()
    {
        $values = [];

        return $values;
    }
}
