<?php
namespace Mageplaza\Affiliate\Setup;

use Magento\Framework\Setup\UpgradeSchemaInterface;
use Magento\Framework\Setup\SchemaSetupInterface;
use Magento\Framework\Setup\ModuleContextInterface;

class UpgradeSchema implements UpgradeSchemaInterface
{
    public function upgrade( SchemaSetupInterface $setup, ModuleContextInterface $context ) {
        $installer = $setup;

        $installer->startSetup();
        if(version_compare($context->getVersion(), '2.0.0', '<')) {
            $installer->getConnection()
                ->addColumn(
                    $installer->getTable( 'sales_order' ),
                    'discount_referral_affiliate',
                    [
                        'type' => \Magento\Framework\DB\Ddl\Table::TYPE_DECIMAL,
                        'nullable' => false,
                        'length' => '20,4',
                        'comment' => 'Discount referral'
                    ]
                );
            $installer->getConnection()
                ->addColumn(
                    $installer->getTable( 'sales_order' ),
                    'base_discount_referral_affiliate',
                    [
                        'type' => \Magento\Framework\DB\Ddl\Table::TYPE_DECIMAL,
                        'nullable' => false,
                        'length' => '20,4',
                        'comment' => 'Base discount referral'
                    ]
                );
        }

        $installer->endSetup();
    }
}
