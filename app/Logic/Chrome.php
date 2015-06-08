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
class Chrome implements RequestConverterInterface
{

    /**
     * {@inheritdoc}
     */
    public function getRequest($contents)
    {
        $stdRequest = new StdRequest();
        return $stdRequest;
    }

    /**
     *
     *
     * @param StdRequest $request
     */
    public function setRequest(StdRequest $request)
    {
        // TODO: Implement setRequest() method.
    }

    /**
     *
     *
     * @return string
     */
    public function getContent()
    {
        // TODO: Implement getContent() method.
    }
}
