<?php
/**
 * requestDataConverter.
 *
 * @author Wumouse <wumouse@qq.com>
 * @version $Id$
 */

namespace Logic;

use Phalcon\Text;

/**
 *
 *
 * @package Logic
 */
class RequestFactory
{

    /**
     * 根据类型获取累
     *
     * @param string $type
     * @return RequestConverterInterface
     */
    public static function get($type)
    {
        $typeClass = Text::camelize($type);
        $typeFQN = '\Logic\\' . $typeClass;
        return new $typeFQN;
    }
}
