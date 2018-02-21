<?php
/**
 * CoreShop.
 *
 * This source file is subject to the GNU General Public License version 3 (GPLv3)
 * For the full copyright and license information, please view the LICENSE.md and gpl-3.0.txt
 * files that are distributed with this source code.
 *
 * @copyright  Copyright (c) 2015-2017 Dominik Pfaffenbauer (https://www.pfaffenbauer.at)
 * @license    https://www.coreshop.org/license     GNU General Public License version 3 (GPLv3)
 */

namespace CoreShop\Behat\Context\Transform;

use Behat\Behat\Context\Context;
use CoreShop\Component\Core\Repository\ProductRepositoryInterface;
use Webmozart\Assert\Assert;

final class ProductContext implements Context
{
    /**
     * @var ProductRepositoryInterface
     */
    private $productRepository;

    /**
     * @param ProductRepositoryInterface $productRepository
     */
    public function __construct(ProductRepositoryInterface $productRepository)
    {
        $this->productRepository = $productRepository;
    }

    /**
     * @Transform /^product(?:|s) "([^"]+)"$/
     */
    public function getProductByName($productName)
    {
        $list = $this->productRepository->getList();
        $list->setLocale('en');
        $list->setCondition('name = ?', [$productName]);
        $list->load();

        Assert::eq(
            count($list->getObjects()),
            1,
            sprintf('%d products has been found with name "%s".', count($list->getObjects()), $productName)
        );

        return reset($list->getObjects());
    }
}
