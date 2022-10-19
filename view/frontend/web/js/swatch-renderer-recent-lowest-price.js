/**
 * Origin: swatch-renderer from Magento_Swatches/MageSuite_ServerSideSwatches
 * Modification type: extend
 * List of modifications:
 * - update recent lowest price custom element
 */
 define(['jquery', 'priceUtils'], function ($, priceUtils) {
    'use strict';

    return function (swatchRenderer) {
        $.widget('mage.SwatchRenderer', swatchRenderer, {
            options: {
                recentLowestPriceSelector: '.cs-recent-lowest-price',
            },

            /**
             * Extend to update recent lowest price
             */
            _UpdatePrice: function () {
                this._super();
                this.updateRecentLowestPrice();
            },

            /**
             * MageSuite feature
             * - Show recent lowest price when the final product is selected.
             */
            updateRecentLowestPrice: function () {
                var $product = this.element.parents(this.options.selectorProduct);
                var $lowestPriceBox = $product.find(`.product-info-price ${this.options.recentLowestPriceSelector}`);
                var $lowestPriceElement = $lowestPriceBox.find(`${this.options.recentLowestPriceSelector}__value`);

                if (!$lowestPriceElement.length) {
                    return;
                }

                var selectedProductId = this.getProductId();
                var selectedProductPrices = selectedProductId ? this.options.jsonConfig.optionPrices[selectedProductId] : null;
                var isSelectedProductDiscounted = false;

                if (selectedProductPrices) {
                    var finalPrice = selectedProductPrices['finalPrice']?.amount;
                    var oldPrice = selectedProductPrices['oldPrice']?.amount;

                    isSelectedProductDiscounted = oldPrice && finalPrice && oldPrice - finalPrice > 0;
                }

                if (selectedProductPrices && isSelectedProductDiscounted) {
                    var recentLowestPrice = selectedProductPrices['recentLowestPrice']?.amount || null;

                    if (recentLowestPrice) {
                        $lowestPriceElement.text(
                            priceUtils.formatPrice(recentLowestPrice, this.options.jsonConfig.currencyFormat)
                        );
                        $lowestPriceBox.show();
                    }
                } else {
                    $lowestPriceElement.text($lowestPriceElement.data('default-price'));
                    $lowestPriceBox.hide();
                }
            },
        });

        return $.mage.SwatchRenderer;
    };
});
