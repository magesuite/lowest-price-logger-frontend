<?php

namespace MageSuite\LowestPriceLoggerFrontend\Test\Integration\Plugin\ConfigurableProduct\Block\Product\View\Type\Configurable;

class AddLowestPricesToSwatchesConfigurationTest extends \PHPUnit\Framework\TestCase
{
    protected ?\Magento\Framework\App\ObjectManager $objectManager;
    protected ?\Magento\Swatches\Block\Product\Renderer\Configurable $swatchRenderer;
    protected ?\Magento\Catalog\Api\ProductRepositoryInterface $productRepository;
    protected ?\Magento\Framework\App\Request\Http $request;

    public function setUp(): void
    {
        $this->objectManager = \Magento\TestFramework\ObjectManager::getInstance();
        $this->swatchRenderer = $this->objectManager->create(\Magento\Swatches\Block\Product\Renderer\Configurable::class);
        $this->productRepository = $this->objectManager->create(\Magento\Catalog\Api\ProductRepositoryInterface::class);
        $this->request = $this->objectManager->get(\Magento\Framework\App\Request\Http::class);
    }

    /**
     * @magentoAppArea frontend
     * @magentoDbIsolation enabled
     * @magentoAppIsolation enabled
     * @magentoDataFixture Magento/ConfigurableProduct/_files/product_configurable.php
     * @magentoDataFixture MageSuite_LowestPriceLoggerFrontend::Test/Integration/_files/product_price_history.php
     */
    public function testItAddsLowestPrices()
    {
        $this->request->setRouteName('catalog');
        $this->request->setControllerName('product');
        $this->request->setActionName('view');

        $product = $this->productRepository->get('configurable');
        $swatchRenderer = $this->swatchRenderer->setProduct($product);

        $jsonConfig = $swatchRenderer->getJsonConfig();
        $jsonConfig = json_decode($jsonConfig, true);

        $this->assertEquals(10, $jsonConfig['optionPrices'][10]['recentLowestPrice']['amount']);
        $this->assertEquals(5, $jsonConfig['optionPrices'][20]['recentLowestPrice']['amount']);
    }
}
