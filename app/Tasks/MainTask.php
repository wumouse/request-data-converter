<?php
/**
 * requestDataConverter.
 *
 * @author Wumouse <wumouse@qq.com>
 * @version $Id$
 */

namespace Tasks;

use Logic\Chrome;
use Logic\RequestFactory;
use Phalcon\CLI\Task;

/**
 *
 *
 * @package Tasks
 */
class MainTask extends Task
{

    /**
     */
    public function mainAction()
    {
        $from = $this->parameter->getOpt('f', 'chrome');
        $to = $this->parameter->getOpt('t');
        if (!$to) {
            echo '-t option required!';
        }

        $fromContentFile = $this->parameter->getOpt('i');
        if (!$fromContentFile) {
            echo '-i option required!';
        }
        if (!stream_resolve_include_path($fromContentFile)) {
            echo '-i must be a exists file include request content';
        }

        $fromLogic = RequestFactory::get($from);
        $toLogic = RequestFactory::get($to);

        $request = $fromLogic->getRequest(file_get_contents($fromContentFile));
        $toLogic->setRequest($request);

        $output = $this->parameter->getOpt('o');
        $content = $toLogic->getContent();
        if ($output) {
            file_put_contents($output, $content);
            echo 'file wrote to ' . realpath($output);
        } else {
            echo $content;
        }
    }
}
