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
 * HAR 转换
 *
 * @package Logic
 */
class Har implements RequestConverterInterface
{

    /**
     * {@inheritdoc}
     */
    public function getRequest($contents)
    {
        $stdRequest = new StdRequest();
        $json = json_decode($contents, true);
        if (!$json) {
            throw new Exception('Invalid har content');
        }

        $currentRequest = $json['log']['entries'][0]['request'];
        foreach ($currentRequest['headers'] as $header) {
            $stdRequest->addHeader($header['name'], $header['value']);
        }

        foreach ($currentRequest['cookies'] as $cookie) {
            $stdRequest->addCookie(
                $cookie['name'],
                $cookie['value']
            );
        }

        $urlPart = parse_url($currentRequest['url']);

        $stdRequest->setUrlBase($urlPart['scheme'] . '://' . $urlPart['host'] .
            (!empty($urlPart['port']) && ':' . $urlPart['port']));
        $stdRequest->setUrlPath($urlPart['path'] .
            (!empty($urlPart['query']) && '?' . $urlPart['query']));
        $stdRequest->setMethod($currentRequest['method']);

        return $stdRequest;
    }

    /**
     *
     *
     * @param StdRequest $request
     */
    public function setRequest(StdRequest $request)
    {
        throw new Exception('developing');
    }

    /**
     *
     *
     * @return string
     */
    public function getContent()
    {
        throw new Exception('developing');
    }
}
