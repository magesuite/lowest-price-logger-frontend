<?php

namespace MageSuite\LowestPriceLoggerFrontend\Plugin\MageSuite\PerformanceProduct\Model\Command\Swatches\GetOptionPrices;

class AddLowestPricesToSwatchesConfiguration
{
    protected \MageSuite\LowestPriceLoggerFrontend\Model\AddLowestPricesToOptions $addLowestPricesToOptions;

    public function __construct(\MageSuite\LowestPriceLoggerFrontend\Model\AddLowestPricesToOptions $addLowestPricesToOptions)
    {
        $this->addLowestPricesToOptions = $addLowestPricesToOptions;
    }

    public function afterExecute(\MageSuite\PerformanceProduct\Model\Command\Swatches\GetOptionPrices $subject, $result)
    {
        if (empty($result)) {
            return $result;
        }

        return $this->addLowestPricesToOptions->execute($result);
    }
}
