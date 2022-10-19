<?php

$objectManager = \Magento\TestFramework\Helper\Bootstrap::getObjectManager();

/** @var \Magento\Catalog\Api\ProductRepositoryInterface $productRepository */
$productRepository = $objectManager->create(\Magento\Catalog\Api\ProductRepositoryInterface::class);
/** @var \Magento\Store\Api\WebsiteRepositoryInterface $websiteRepository */
$websiteRepository = $objectManager->create(\Magento\Store\Api\WebsiteRepositoryInterface::class);

$defaultWebsiteId = $websiteRepository->get('base')->getId();

$productSimple10 = $productRepository->get('simple_10');
$productSimple20 = $productRepository->get('simple_20');

/** @var \MageSuite\LowestPriceLogger\Model\ResourceModel\PriceHistoryLog $priceHistoryLog */
$priceHistoryLog = $objectManager->get(\MageSuite\LowestPriceLogger\Model\ResourceModel\PriceHistoryLog::class);

$priceHistoryLog->addPricesToLog([
    [
        'product_id' => $productSimple10->getId(),
        'price' => 10,
        'website_id' => $defaultWebsiteId,
        'customer_group_id' => 0,
        'log_date' => (new DateTime())->modify('-2 day')->format('Y-m-d'),
        'price_type' => 1
    ],
    [
        'product_id' => $productSimple10->getId(),
        'price' => 20,
        'website_id' => $defaultWebsiteId,
        'customer_group_id' => 0,
        'log_date' => (new DateTime())->modify('-1 day')->format('Y-m-d'),
        'price_type' => 1
    ],
    [
        'product_id' => $productSimple20->getId(),
        'price' => 5,
        'website_id' => $defaultWebsiteId,
        'customer_group_id' => 0,
        'log_date' => (new DateTime())->modify('-2 day')->format('Y-m-d'),
        'price_type' => 1
    ],
    [
        'product_id' => $productSimple20->getId(),
        'price' => 10,
        'website_id' => $defaultWebsiteId,
        'customer_group_id' => 0,
        'log_date' => (new DateTime())->modify('-1 day')->format('Y-m-d'),
        'price_type' => 1
    ],
    [
        'product_id' => $productSimple20->getId(),
        'price' => 4.50,
        'website_id' => $defaultWebsiteId,
        'customer_group_id' => 0,
        'log_date' => (new DateTime())->modify('-31 day')->format('Y-m-d'),
        'price_type' => 1
    ],
]);
