<?php
/**
 * Zend Framework (http://framework.zend.com/)
 *
 * @link      http://github.com/zendframework/zf2 for the canonical source repository
 * @copyright Copyright (c) 2005-2016 Zend Technologies USA Inc. (http://www.zend.com)
 * @license   http://framework.zend.com/license/new-bsd New BSD License
 */

namespace ZendTest\Code\TestAsset\Proxy;

use Zend\Code\Scanner\CachingFileScanner;

class CachingFileScannerProxy extends CachingFileScanner
{
    /**
     * @var CachingFileScanner
     */
    protected $cfs;

    public function __construct(CachingFileScanner $cfs)
    {
        $this->cfs = $cfs;
    }

    public function getCache()
    {
    }
}
