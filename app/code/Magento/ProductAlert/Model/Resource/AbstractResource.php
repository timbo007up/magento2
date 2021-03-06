<?php
/**
 * Magento
 *
 * NOTICE OF LICENSE
 *
 * This source file is subject to the Open Software License (OSL 3.0)
 * that is bundled with this package in the file LICENSE.txt.
 * It is also available through the world-wide-web at this URL:
 * http://opensource.org/licenses/osl-3.0.php
 * If you did not receive a copy of the license and are unable to
 * obtain it through the world-wide-web, please send an email
 * to license@magentocommerce.com so we can send you a copy immediately.
 *
 * DISCLAIMER
 *
 * Do not edit or add to this file if you wish to upgrade Magento to newer
 * versions in the future. If you wish to customize Magento for your
 * needs please refer to http://www.magentocommerce.com for more information.
 *
 * @category    Magento
 * @package     Magento_ProductAlert
 * @copyright   Copyright (c) 2013 X.commerce, Inc. (http://www.magentocommerce.com)
 * @license     http://opensource.org/licenses/osl-3.0.php  Open Software License (OSL 3.0)
 */


/**
 * Product alert for back in abstract resource model
 *
 * @category    Magento
 * @package     Magento_ProductAlert
 * @author      Magento Core Team <core@magentocommerce.com>
 */
namespace Magento\ProductAlert\Model\Resource;

abstract class AbstractResource extends \Magento\Core\Model\Resource\Db\AbstractDb
{
    /**
     * Retrieve alert row by object parameters
     *
     * @param \Magento\Core\Model\AbstractModel $object
     * @return array|bool
     */
    protected function _getAlertRow(\Magento\Core\Model\AbstractModel $object)
    {
        $adapter = $this->_getReadAdapter();
        if ($object->getCustomerId() && $object->getProductId() && $object->getWebsiteId()) {
            $select = $adapter->select()
                ->from($this->getMainTable())
                ->where('customer_id = :customer_id')
                ->where('product_id  = :product_id')
                ->where('website_id  = :website_id');
            $bind = array(
                ':customer_id' => $object->getCustomerId(),
                ':product_id'  => $object->getProductId(),
                ':website_id'  => $object->getWebsiteId()
            );
            return $adapter->fetchRow($select, $bind);
        }
        return false;
    }

    /**
     * Load object data by parameters
     *
     * @param \Magento\Core\Model\AbstractModel $object
     * @return \Magento\ProductAlert\Model\Resource\AbstractResource
     */
    public function loadByParam(\Magento\Core\Model\AbstractModel $object)
    {
        $row = $this->_getAlertRow($object);
        if ($row) {
            $object->setData($row);
        }
        return $this;
    }

    /**
     * Delete all customer alerts on website
     *
     * @param \Magento\Core\Model\AbstractModel $object
     * @param int $customerId
     * @param int $websiteId
     * @return \Magento\ProductAlert\Model\Resource\AbstractResource
     */
    public function deleteCustomer(\Magento\Core\Model\AbstractModel $object, $customerId, $websiteId=null)
    {
        $adapter = $this->_getWriteAdapter();
        $where   = array();
        $where[] = $adapter->quoteInto('customer_id=?', $customerId);
        if ($websiteId) {
            $where[] = $adapter->quoteInto('website_id=?', $websiteId);
        }
        $adapter->delete($this->getMainTable(), $where);
        return $this;
    }
}
