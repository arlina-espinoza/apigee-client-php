<?php

/*
 * Copyright 2019 Google LLC
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

namespace Apigee\Edge\HttpClient\Plugin;

use Apigee\Edge\Exception\InvalidArgumentException;
use Http\Client\Common\Plugin;
use Http\Promise\Promise;
use Psr\Http\Message\RequestInterface;
use Psr\Http\Message\UriInterface;

/**
 * HybridRequestPlugin plugin to handle tweaks needed for Hybrid API.
 */
final class HybridRequestPlugin implements Plugin
{
    /**
     * The base URI.
     *
     * @var string
     */
    private $baseUri;

    /**
     * HybridRequestPlugin constructor.
     *
     * @param \Psr\Http\Message\UriInterface $baseUri
     *   The base URI.
     */
    public function __construct(UriInterface $uri)
    {
        if ('' === $uri->getPath()) {
            throw new InvalidArgumentException('URI path cannot be empty');
        }

        if ('/' === substr($uri->getPath(), -1)) {
            $uri = $uri->withPath(rtrim($uri->getPath(), '/'));
        }

        $this->baseUri = $request->getUri()->getPath();
    }

    /**
     * {@inheritdoc}
     */
    public function handleRequest(RequestInterface $request, callable $next, callable $first): Promise
    {
        $path = $request->getUri()->getPath();

        if ($this->baseUri) {
            $path = substr($request->getUri()->getPath(), strlen($this->baseUri));
        }

//        if ($this->startsWith($path, ))

        return $next($request);
    }

    /**
     * Check string starting with given substring.
     *
     * @param $string
     * @param $startString
     *
     * @return bool
     */
    private function startsWith($string, $startString)
    {
        return (substr($string, 0, strlen($startString)) === $startString);
    }
}
