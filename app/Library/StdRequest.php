<?php
/**
 * requestDataConverter.
 *
 * @author Wumouse <wumouse@qq.com>
 * @version $Id$
 */

namespace Library;

/**
 *
 *
 * @package Library
 */
class StdRequest
{
    /**
     *
     *
     * @var string
     */
    protected $method = 'GET';
    /**
     *
     *
     * @var
     */
    protected $urlBase;
    /**
     *
     *
     * @var
     */
    protected $urlPath;
    /**
     *
     *
     * @var
     */
    protected $headers;
    /**
     *
     *
     * @var
     */
    protected $parameters;

    protected $cookies;

    protected $postFields;

    /**
     * @return string
     */
    public function getMethod()
    {
        return $this->method;
    }

    /**
     * @param string $method
     */
    public function setMethod($method)
    {
        $this->method = $method;
    }

    /**
     * @return mixed
     */
    public function getUrlBase()
    {
        return $this->urlBase;
    }

    /**
     * @param mixed $urlBase
     */
    public function setUrlBase($urlBase)
    {
        $this->urlBase = $urlBase;
    }

    /**
     * @return mixed
     */
    public function getUrlPath()
    {
        return $this->urlPath;
    }

    /**
     * @param mixed $urlPath
     */
    public function setUrlPath($urlPath)
    {
        $this->urlPath = $urlPath;
    }

    /**
     * @return mixed
     */
    public function getHeaders()
    {
        return $this->headers;
    }

    /**
     * @param mixed $headers
     */
    public function setHeaders($headers)
    {
        $this->headers = $headers;
    }

    /**
     * @return mixed
     */
    public function getParameters()
    {
        return $this->parameters;
    }

    /**
     * @param mixed $parameters
     */
    public function setParameters($parameters)
    {
        $this->parameters = $parameters;
    }

    /**
     *
     *
     * @param string $name
     * @param string $value
     */
    public function addCookie($name, $value)
    {
        $this->cookies[$name] = $value;
    }

    public function addPostField($name, $value)
    {
        $this->postFields[$name] = $value;
    }

    public function addHeader($name, $value)
    {
        $this->headers[$name] = $value;
    }
}
