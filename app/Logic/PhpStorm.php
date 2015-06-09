<?php
/**
 * requestDataConverter.
 *
 * @author Wumouse <wumouse@qq.com>
 * @version $Id$
 */

namespace Logic;

use Library\StdRequest;

/**
 *
 *
 * @package Logic
 */
class PhpStorm implements RequestConverterInterface
{
    /**
     *
     *
     * @var \DOMDocument
     */
    protected $dom;

    /**
     * {@inheritdoc}
     */
    public function getRequest($contents)
    {
        $stdRequest = new StdRequest();
        $xml = simplexml_load_string($contents);
        $options = $xml->option;
        foreach ($options as $key => $option) {
            $name = $option['name'];
            switch ($name) {
                case 'httpMethod':
                    $stdRequest->setMethod($option);
                    break;
                case 'urlBase':
                    $stdRequest->setUrlBase($option);
                    break;
                case 'urlPath':
                    $stdRequest->setUrlPath($option);
                    break;
                case 'headers':
                    foreach ($option->list->KeyValuePair->option as $keyValuePair) {
                        $stdRequest->addHeader(
                            $keyValuePair['key'],
                            $keyValuePair['value']
                        );
                    }
                    break;
                case 'parameters':
                    if ($option->list->lenght) {
                        foreach ($option->list->KeyValuePair->option as $keyValuePair) {
                            $stdRequest->addPostField($keyValuePair['name'], $keyValuePair['value']);
                        }
                    }
                    break;
                case 'biscuits':
                    foreach ($option->list->Biscuit as $biscuit) {
                        $_data = array();
                        foreach ($biscuit->option as $_option) {
                            $name = $option['name'];
                            $value = $option['value'];
                            $_data[$name] = $value;
                        }
                        $stdRequest->addCookie(
                            $_data['name'],
                            $_data['value'],
                            $_data['date'],
                            $_data['domain'],
                            $_data['path']
                        );
                    }
                    break;
            }
        }
        return $stdRequest;
    }

    /**
     * {@inheritdoc}
     */
    public function setRequest(StdRequest $request)
    {
        $dom = new \DOMDocument('1.0', 'utf-8');
        $restClientRequest = $dom->createElement('RestClientRequest');
        $option = $dom->createElement('option');

        $restClientRequest->appendChild($this->getBiscuit($request, $dom));

        $methodOption = clone $option;
        $methodOption->setAttribute('name', 'httpMethod');
        $methodOption->setAttribute('value', $request->getMethod());
        $restClientRequest->appendChild($methodOption);

        $urlBaseOption = clone $option;
        $urlBaseOption->setAttribute('name', 'urlBase');
        $urlBaseOption->setAttribute('value', $request->getUrlBase());
        $restClientRequest->appendChild($urlBaseOption);

        $urlPathOption = clone $option;
        $urlPathOption->setAttribute('name', 'urlPath');
        $urlPathOption->setAttribute('value', $request->getUrlPath());
        $restClientRequest->appendChild($urlPathOption);

        $restClientRequest->appendChild($option);
        $restClientRequest->appendChild($this->getHeaders($request, $dom));

        $dom->appendChild($restClientRequest);
        $this->dom = $dom;
    }

    /**
     * {@inheritdoc}
     */
    public function getContent()
    {
        $this->dom->formatOutput = true;
        return $this->dom->saveXML();
    }

    /**
     * 获取cookie的字段
     *
     * @param StdRequest $request
     * @param \DOMDocument $dom
     * @return \DOMElement
     */
    private function getBiscuit(StdRequest $request, \DOMDocument $dom)
    {
        $list = $dom->createElement('list');
        foreach ($request->getCookies() as $name => $cookie) {
            $biscuit = $dom->createElement('Biscuit');
            foreach ($cookie as $_name => $item) {
                $option = $dom->createElement('option');
                $_name == 'expires' && $_name = 'date';
                $option->setAttribute('name', $_name);
                $option->setAttribute('value', $item);
                $biscuit->appendChild($option);
            }
            $list->appendChild($biscuit);
        }
        $outerOption = $dom->createElement('option');
        $outerOption->setAttribute('name', 'biscuits');
        $outerOption->appendChild($list);

        return $outerOption;
    }

    /**
     * 获取 header 元素
     *
     * @param StdRequest $request
     * @param \DOMDocument $dom
     * @return \DOMElement
     */
    private function getHeaders(StdRequest $request, \DOMDocument $dom)
    {
        $list = $dom->createElement('list');
        foreach ($request->getHeaders() as $key => $value) {
            $keyValuePair = $dom->createElement('KeyValuePair');
            $optionKey = $dom->createElement('option');
            $optionValue = clone $optionKey;
            $optionKey->setAttribute('name', 'key');
            $optionKey->setAttribute('value', $key);

            $optionValue->setAttribute('name', 'value');
            $optionValue->setAttribute('value', $value);
            $keyValuePair->appendChild($optionKey);
            $keyValuePair->appendChild($optionValue);

            $list->appendChild($keyValuePair);
        }

        $outOption = $dom->createElement('option');
        $outOption->setAttribute('name', 'headers');
        $outOption->appendChild($list);

        return $outOption;
    }
}
