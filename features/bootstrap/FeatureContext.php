<?php

use Behat\Behat\Context\Context;
use Behat\Behat\Hook\Scope\BeforeScenarioScope;
use Doctrine\Bundle\DoctrineBundle\Registry;
use Lexik\Bundle\JWTAuthenticationBundle\Services\JWTManager;
use PHPUnit\Framework\Assert;
use Ubirak\RestApiBehatExtension\Json\JsonInspector;
use Ubirak\RestApiBehatExtension\RestApiContext;

/**
 * Defines application features from the specific context.
 */
class FeatureContext implements Context
{
    /**
     * @var JsonInspector
     */
    private $jsonInspector;

    /**
     * @var RestApiContext
     */
    private $restContext;

    /**
     * @var Registry
     */
    private $manager;

    /**
     * @var JWTManager
     */
    private $jwtManager;

    /**
     * Initializes context.
     *
     * Every scenario gets its own context instance.
     * You can also pass arbitrary arguments to the
     * context constructor through behat.yml.
     * @param JsonInspector $jsonInspector
     * @param Registry $doctrine
     * @param JWTManager $jwtManager
     */
    public function __construct(JsonInspector $jsonInspector, Registry $doctrine, JWTManager $jwtManager)
    {
        $this->jsonInspector = $jsonInspector;
        $this->manager = $doctrine;
        $this->jwtManager = $jwtManager;
    }

    /**
     * @BeforeScenario
     * @login
     *
     * @param BeforeScenarioScope $scope
     */
    public function login(BeforeScenarioScope $scope)
    {
        $user = $this->manager->getRepository('App:Apk\User')->find(56);

        $token = $this->jwtManager->create($user);
        $this->restContext = $scope->getEnvironment()->getContext(RestApiContext::class);
        $this->restContext->iAddHeaderEqualTo('Authorization', "Bearer $token");
    }

    /**
     * @Then the each item of JSON path expression :pathExpression should be not empty
     */
    public function theEachItemOfJsonPathExpressionShouldBeNotEmpty($pathExpression)
    {
        $actualJsonItems = $this->jsonInspector->searchJsonPath($pathExpression);

        Assert::assertNotEmpty($actualJsonItems);
    }

    /**
     * @Then the each item of JSON path expression :pathExpression should be equal to :expectedJson
     */
    public function theEachItemOfJsonPathExpressionShouldBeEqualToJson($pathExpression, $expectedJson)
    {
        $actualJsonItems = $this->jsonInspector->searchJsonPath($pathExpression);

        foreach ($actualJsonItems as $actualJsonItem) {
            Assert::assertEquals($expectedJson, $actualJsonItem);
        }
    }

    /**
     * @Then the each item of JSON path expression :pathExpression should starts with :prefix
     */
    public function theEachItemOfJsonPathExpressionShouldStartsWith($pathExpression, $prefix)
    {
        $actualJsonItems = $this->jsonInspector->searchJsonPath($pathExpression);

        foreach ($actualJsonItems as $actualJsonItem) {
            Assert::assertStringStartsWith($prefix, $actualJsonItem);
        }
    }

    /**
     * @Then the each item of JSON path expression :pathExpression should contain :expectedString
     */
    public function theEachItemOfJsonPathExpressionShouldContain($pathExpression, $expectedString)
    {
        $actualJsonItems = $this->jsonInspector->searchJsonPath($pathExpression);

        foreach ($actualJsonItems as $actualJsonItem) {
            Assert::assertContains($expectedString, $actualJsonItem);
        }
    }

    /**
     * @Then the JSON path expression :pathExpression should contain :expectedString
     */
    public function theJsonPathExpressionShouldContain($pathExpression, $expectedString)
    {
        $actualJsonItems = $this->jsonInspector->searchJsonPath($pathExpression);

        Assert::assertContains($expectedString, $actualJsonItems);
    }
}
