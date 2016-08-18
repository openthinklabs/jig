<?php
/**
 * Created by PhpStorm.
 * User: dieter-tao
 * Date: 29/07/2016
 * Time: 09:56
 */

namespace Jig\Tests\Tree;
use PHPUnit_Framework_TestCase;


abstract class TreeTestCommon extends PHPUnit_Framework_TestCase
{

    /**
     * @var array
     */
    protected $tree= [
        'd' => ['dA', 'dB'],
        'e' => ['eA', 'eB'],
        'M' => ['MA', 'MB'],
        'N' => ['NA', 'NB']
    ];

    /**
     * The tree related tests need to write data, this creates and returns a
     * temp directory.
     *
     * @return string
     */
    protected function getTreeDir() {
        $tmpDir = sys_get_temp_dir() . '/TreeTest';
        if(!is_dir($tmpDir)) {
            mkdir($tmpDir, 0777);
        }
        else {
            foreach(glob($tmpDir . '/*') as $file){
                unlink($file);
            }
        }
        return $tmpDir;
    }
}
