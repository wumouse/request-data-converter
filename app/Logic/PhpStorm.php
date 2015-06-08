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
                    foreach ($option->list->KeyValuePair as $keyValuePair) {
                        $stdRequest->addHeader(
                            $keyValuePair[0]['value'],
                            $keyValuePair[1]['value']
                        );
                    }
                    break;
                case 'parameters':
                    foreach ($option->list->KeyValuePair as $keyValuePair) {
                        $stdRequest->addPostField($keyValuePair['name'], $keyValuePair['value']);
                    }
                    break;
                case 'biscuits':
                    foreach ($option->list->Biscuit->option as $item) {
                        $stdRequest->addCookie($item['name'], $item['value']);
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
        // TODO: Implement setRequest() method.
    }

    /**
     * {@inheritdoc}
     */
    public function getContent()
    {
        // TODO: Implement getContent() method.
    }
}
