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

namespace Apigee\Edge\Api\Management\Controller;

use Apigee\Edge\Api\Management\Entity\ApiProduct;
use Apigee\Edge\ClientInterface;
use Apigee\Edge\Controller\CpsLimitEntityController;
use Apigee\Edge\Controller\EntityCrudOperationsControllerTrait;
use Apigee\Edge\Controller\PaginationEntityListingControllerTrait;
use Apigee\Edge\Denormalizer\AttributesPropertyDenormalizer;
use Psr\Http\Message\UriInterface;

/**
 * Class ApiProductController.
 */
class ApiProductController extends CpsLimitEntityController implements ApiProductControllerInterface
{
    use AttributesAwareEntityControllerTrait;
    use EntityCrudOperationsControllerTrait;
    use PaginationEntityListingControllerTrait;

    /**
     * ApiProductController constructor.
     *
     * @param string $organization
     * @param \Apigee\Edge\ClientInterface $client
     * @param array $entityNormalizers
     * @param \Apigee\Edge\Api\Management\Controller\OrganizationControllerInterface|null $organizationController
     */
    public function __construct(
      string $organization,
      ClientInterface $client,
      $entityNormalizers = [],
      ?OrganizationControllerInterface $organizationController = null
    ) {
        $entityNormalizers[] = new AttributesPropertyDenormalizer();
        parent::__construct($organization, $client, $entityNormalizers,
        $organizationController);
    }

    /**
     * @inheritdoc
     */
    public function searchByAttribute(string $attributeName, string $attributeValue): array
    {
        $query_params = [
            'attributename' => $attributeName,
            'attributevalue' => $attributeValue,
        ];
        $uri = $this->getBaseEndpointUri()->withQuery(http_build_query($query_params));
        $response = $this->client->get($uri);

        return $this->responseToArray($response);
    }

    /**
     * @inheritdoc
     */
    protected function getBaseEndpointUri(): UriInterface
    {
        return $this->client->getUriFactory()->createUri("/organizations/{$this->organization}/apiproducts");
    }

    /**
     * @inheritdoc
     */
    protected function getEntityClass(): string
    {
        return ApiProduct::class;
    }
}
