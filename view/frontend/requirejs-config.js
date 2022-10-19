var config = {
    config: {
        mixins: {
            'Magento_Swatches/js/swatch-renderer': {
                'MageSuite_LowestPriceLoggerFrontend/js/swatch-renderer-recent-lowest-price': true,
            },
            'MageSuite_ServerSideSwatches/js/swatch-renderer': {
                'MageSuite_LowestPriceLoggerFrontend/js/swatch-renderer-recent-lowest-price': true,
            }
        }
    }
}
