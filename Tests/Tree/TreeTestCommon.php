<?php
/**
 * This program is free software; you can redistribute it and/or
 * modify it under the terms of the GNU General Public License
 * as published by the Free Software Foundation; under version 2
 * of the License (non-upgradable).
 *
 * This program is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 * GNU General Public License for more details.
 *
 * You should have received a copy of the GNU General Public License
 * along with this program; if not, write to the Free Software
 * Foundation, Inc., 51 Franklin Street, Fifth Floor, Boston, MA  02110-1301, USA.
 *
 * Copyright (c) 2016 (original work) Open Assessment Technologies SA;
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
