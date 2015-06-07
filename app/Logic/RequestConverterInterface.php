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
interface RequestConverterInterface
{

    /**
     *
     *
     * @param string $contents
     * @return StdRequest
     */
    public function getRequest($contents);

    /**
     *
     *
     * @param StdRequest $request
     */
    public function setRequest(StdRequest $request);

    /**
     *
     *
     * @return string
     */
    public function getContent();
}
