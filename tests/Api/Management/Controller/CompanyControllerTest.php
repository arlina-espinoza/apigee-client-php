<?php

/*
 * Copyright 2018 Google LLC
 *
 * Licensed under the Apache License, Version 2.0 (the "License");
 * you may not use this file except in compliance with the License.
 * You may obtain a copy of the License at
 *
 *      https://www.apache.org/licenses/LICENSE-2.0
 *
 * Unless required by applicable law or agreed to in writing, software
 * distributed under the License is distributed on an "AS IS" BASIS,
 * WITHOUT WARRANTIES OR CONDITIONS OF ANY KIND, either express or implied.
 * See the License for the specific language governing permissions and
 * limitations under the License.
 */

namespace Apigee\Edge\Tests\Api\Management\Controller;

use Apigee\Edge\Api\Management\Controller\CompanyController;
use Apigee\Edge\Api\Management\Entity\Company;
use Apigee\Edge\Controller\EntityControllerInterface;
use Apigee\Edge\Entity\EntityInterface;
use Apigee\Edge\Structure\AttributesProperty;
use Apigee\Edge\Tests\Test\Controller\OrganizationAwareEntityControllerValidatorTrait;
use Apigee\Edge\Tests\Test\Controller\PaginationEntityListingControllerValidator;
use Apigee\Edge\Tests\Test\TestClientFactory;

/**
 * Class CompanyControllerTest.
 *
 * @group controller
 */
class CompanyControllerTest extends PaginationEntityListingControllerValidator
{
    use OrganizationAwareEntityControllerValidatorTrait;

    /**
     * @inheritdoc
     */
    public static function sampleDataForEntityCreate(): EntityInterface
    {
        static $entity;
        if (null === $entity) {
            $isMock = TestClientFactory::isMockClient(static::$client);
            $entity = new Company([
                'name' => $isMock ? 'phpunit' : 'phpunit_' . static::$random->unique()->userName,
                'displayName' => $isMock ? 'A PHPUnit company' : static::$random->unique()->words(static::$random->numberBetween(1, 8), true),
                'attributes' => new AttributesProperty(['foo' => 'bar']),
            ]);
        }

        return $entity;
    }

    /**
     * @inheritdoc
     */
    public static function sampleDataForEntityUpdate(): EntityInterface
    {
        static $entity;
        if (null === $entity) {
            $isMock = TestClientFactory::isMockClient(static::$client);
            $entity = new Company([
                'displayName' => $isMock ? '(Edited) A PHPUnit company' : static::$random->unique()->words(static::$random->numberBetween(1, 8), true),
                'attributes' => new AttributesProperty(['foo' => 'foo', 'bar' => 'baz']),
            ]);
        }

        return $entity;
    }

    /**
     * We have to override this otherwise dependents of this function are being skipped.
     * Also, "@inheritdoc" is not going to work in case of "@depends" annotations so those must be repeated.
     *
     * @inheritdoc
     */
    public function testCreate()
    {
        return parent::testCreate(); // TODO: Change the autogenerated stub
    }

    /**
     * We have to override this otherwise dependents of this function are being skipped.
     * Also, "@inheritdoc" is not going to work in case of "@depends" annotations so those must be repeated.
     *
     * @depends testCreate
     *
     * @inheritdoc
     */
    public function testLoad(string $entityId)
    {
        return parent::testLoad($entityId);
    }

    /**
     * This is knowingly a duplicate.
     *
     * @depends testLoad
     *
     * @param string $entityId
     *
     * @see \Apigee\Edge\Tests\Api\Management\Controller\DeveloperControllerTest::testStatusChange()
     */
    public function testStatusChange(string $entityId): void
    {
        if (TestClientFactory::isMockClient(static::$client)) {
            $this->markTestSkipped(static::$onlyOnlineClientSkipMessage);
        }
        $entity = static::getEntityController()->load($entityId);
        static::getEntityController()->setStatus($entity->id(), Company::STATUS_INACTIVE);
        /** @var \Apigee\Edge\Api\Management\Entity\CompanyInterface $entity */
        $entity = static::getEntityController()->load($entity->id());
        $this->assertEquals($entity->getStatus(), Company::STATUS_INACTIVE);
        static::getEntityController()->setStatus($entity->id(), Company::STATUS_ACTIVE);
        /** @var \Apigee\Edge\Api\Management\Entity\CompanyInterface $entity */
        $entity = static::getEntityController()->load($entity->id());
        $this->assertEquals($entity->getStatus(), Company::STATUS_ACTIVE);
    }

    /**
     * @inheritdoc
     */
    public function cpsLimitTestIdFieldProvider(): array
    {
        return [['name']];
    }

    /**
     * @inheritdoc
     */
    protected static function getEntityController(): EntityControllerInterface
    {
        static $controller;
        if (!$controller) {
            $controller = new CompanyController(static::getOrganization(static::$client), static::$client);
        }

        return $controller;
    }
}
