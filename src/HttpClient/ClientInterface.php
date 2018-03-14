<?php

/*
 * Copyright 2018 Google Inc.
 * Use of this source code is governed by a MIT-style license that can be found in the LICENSE file or
 * at https://opensource.org/licenses/MIT.
 */

namespace Apigee\Edge\HttpClient;

use Apigee\Edge\HttpClient\Utility\Journal;
use Http\Client\HttpClient;
use Http\Message\UriFactory;
use Psr\Cache\CacheItemPoolInterface;
use Psr\Http\Message\ResponseInterface;

/**
 * Interface ClientInterface.
 *
 * Describes the public methods of an Apigee Edge API client.
 */
interface ClientInterface extends HttpClient
{
    /**
     * Allows access to the last request, response and exception.
     *
     * @return \Apigee\Edge\HttpClient\Utility\Journal
     */
    public function getJournal(): Journal;

    /**
     * Returns the URI factory used by the Client.
     */
    public function getUriFactory(): UriFactory;

    /**
     * Returns the version of the API client.
     *
     * @return string
     */
    public function getClientVersion(): string;

    /**
     * Returns the user agent that the API client sends to Apigee Edge.
     *
     * @return string
     */
    public function getUserAgent(): string;

    /**
     * Add a custom prefix to the default SDK user agent.
     *
     * @param string $prefix
     */
    public function setUserAgentPrefix(string $prefix);

    /**
     * Returns the endpoint that the client currently communicates with.
     *
     * @return string
     */
    public function getEndpoint(): string;

    /**
     * Changes the endpoint that the client communicates.
     *
     * @param string $endpoint
     *
     * @return string
     */
    public function setEndpoint(string $endpoint): string;

    /**
     * Adds cache to the underlying HTTP client.
     *
     * @param CacheItemPoolInterface $cachePool
     * @param array $config
     */
    public function addCache(CacheItemPoolInterface $cachePool, array $config = []): void;

    /**
     * Removes cache from the underlying HTTP client.
     */
    public function removeCache(): void;

    /**
     * Sends a GET request.
     *
     * @param \Psr\Http\Message\UriInterface|string $uri
     * @param array $headers
     *
     * @return ResponseInterface
     */
    public function get($uri, array $headers = []): ResponseInterface;

    /**
     * Sends a HEAD request.
     *
     * @param \Psr\Http\Message\UriInterface|string $uri
     * @param array $headers
     *
     * @return ResponseInterface
     */
    public function head($uri, array $headers = []): ResponseInterface;

    /**
     * Sends a POST request.
     *
     * @param \Psr\Http\Message\UriInterface|string $uri
     * @param null|\Psr\Http\Message\StreamInterface|resource|string $body
     * @param array $headers
     *
     * @return ResponseInterface
     */
    public function post($uri, $body = null, array $headers = []): ResponseInterface;

    /**
     * Sends a PUT request.
     *
     * @param \Psr\Http\Message\UriInterface|string $uri
     * @param null|\Psr\Http\Message\StreamInterface|resource|string $body
     * @param array $headers
     *
     * @return ResponseInterface
     */
    public function put($uri, $body = null, array $headers = []): ResponseInterface;

    /**
     * Sends a DELETE request.
     *
     * @param \Psr\Http\Message\UriInterface|string $uri
     * @param null|\Psr\Http\Message\StreamInterface|resource|string $body
     * @param array $headers
     *
     * @return ResponseInterface
     */
    public function delete($uri, $body = null, array $headers = []): ResponseInterface;
}
