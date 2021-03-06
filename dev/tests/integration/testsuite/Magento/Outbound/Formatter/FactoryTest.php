<?php
/**
 * \Magento\Outbound\Formatter\Factory
 *
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
 * @copyright          Copyright (c) 2013 X.commerce, Inc. (http://www.magentocommerce.com)
 * @license            http://opensource.org/licenses/osl-3.0.php  Open Software License (OSL 3.0)
 */

namespace Magento\Outbound\Formatter;

use Magento\Outbound\Formatter\Factory as FormatterFactory;
use Magento\Outbound\EndpointInterface;

class FactoryTest extends \PHPUnit_Framework_TestCase
{
    /** @var FormatterFactory */
    protected $_formatterFactory;

    protected function setUp()
    {
        $this->_formatterFactory = \Magento\TestFramework\Helper\Bootstrap::getObjectManager()
            ->create('Magento\Outbound\Formatter\Factory', array(
                    'formatterMap' => array(
                        EndpointInterface::FORMAT_JSON => 'Magento\Outbound\Formatter\Json'
                    )
                ));
    }

    public function testGetFormatter()
    {
        $formatter = $this->_formatterFactory->getFormatter(EndpointInterface::FORMAT_JSON);
        $this->assertInstanceOf('Magento\Outbound\Formatter\Json', $formatter);
    }

    public function testGetFormatterIsCached()
    {
        $formatter = $this->_formatterFactory->getFormatter(EndpointInterface::FORMAT_JSON);
        $formatter2 = $this->_formatterFactory->getFormatter(EndpointInterface::FORMAT_JSON);
        $this->assertSame($formatter, $formatter2);
    }
}
