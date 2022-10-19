<?php

namespace MageSuite\LowestPriceLoggerFrontend\Plugin\ConfigurableProduct\Block\Product\View\Type\Configurable;

class AddLowestPricesToSwatchesConfiguration
{
    protected \MageSuite\LowestPriceLoggerFrontend\Model\AddLowestPricesToOptions $addLowestPricesToOptions;

    public function __construct(\MageSuite\LowestPriceLoggerFrontend\Model\AddLowestPricesToOptions $addLowestPricesToOptions)
    {
        $this->addLowestPricesToOptions = $addLowestPricesToOptions;
    }

    public function afterGetJsonConfig(\Magento\ConfigurableProduct\Block\Product\View\Type\Configurable $subject, $result)
    {
        $result = json_decode($result, true);

        if (!array_key_exists('optionPrices', $result)) {
            return json_encode($result);
        }

        $result['optionPrices'] = $this->addLowestPricesToOptions->execute($result['optionPrices']);

        return json_encode($result);
    }
}
