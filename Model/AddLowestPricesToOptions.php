<?php

namespace MageSuite\LowestPriceLoggerFrontend\Model;

class AddLowestPricesToOptions
{
    protected \MageSuite\LowestPriceLogger\Model\ResourceModel\PriceHistoryLog $priceHistoryLog;
    protected \Magento\Store\Model\StoreManagerInterface $storeManager;
    protected \Magento\Customer\Model\Session $customerSession;

    public function __construct(
        \MageSuite\LowestPriceLogger\Model\ResourceModel\PriceHistoryLog $priceHistoryLog,
        \Magento\Store\Model\StoreManagerInterface $storeManager,
        \Magento\Customer\Model\Session $customerSession
    ) {
        $this->priceHistoryLog = $priceHistoryLog;
        $this->storeManager = $storeManager;
        $this->customerSession = $customerSession;
    }

    public function execute($optionPrices)
    {
        if (empty($optionPrices)) {
            return $optionPrices;
        }

        $childProductIds = array_keys($optionPrices);

        $lowestPrices = $this->priceHistoryLog->getLowestPrices(
            $childProductIds,
            $this->storeManager->getStore()->getWebsiteId(),
            $this->customerSession->getCustomerGroupId()
        );

        foreach ($optionPrices as $productId => $prices) {
            $lowestPrice = $this->findPrice($productId, $lowestPrices);

            if ($lowestPrice === null) {
                continue;
            }

            $optionPrices[$productId]['recentLowestPrice']['amount'] = (float)$lowestPrice['price'];
        }

        return $optionPrices;
    }

    protected function findPrice($productId, $prices): ?array
    {
        if (empty($prices)) {
            return null;
        }

        foreach ($prices as $price) {
            if ($price['product_id'] == $productId) {
                return $price;
            }
        }

        return null;
    }
}
