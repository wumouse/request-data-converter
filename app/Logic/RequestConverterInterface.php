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
 * 请求转换接口
 *
 * @package Logic
 */
interface RequestConverterInterface
{

    /**
     * 获取标准转换的Request
     *
     * @param string $contents
     * @return StdRequest
     */
    public function getRequest($contents);

    /**
     * 设置标准转换的接口
     *
     * @param StdRequest $request
     */
    public function setRequest(StdRequest $request);

    /**
     * 获取内容的字符串表示
     *
     * @return string
     */
    public function getContent();
}
