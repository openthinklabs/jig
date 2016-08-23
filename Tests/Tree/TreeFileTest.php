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

namespace Jig\Tests\HelpIndexer;

use Jig\Tree\TreeFile;
use Symfony\Component\Yaml\Yaml;
use Jig\Tests\Tree\TreeTestCommon;


class TreeFileTest extends TreeTestCommon
{

    public function testWriteJson()
    {
        $file = $this->getTreeDir() . '/tree.json';
        (new TreeFile())->write($file, $this->tree);
        $this->assertEquals(file_exists($file), true);
        $this->assertJsonStringEqualsJsonFile($file, json_encode($this->tree));
    }

    public function testWriteYml()
    {
        $file = $this->getTreeDir() . '/tree.yml';
        (new TreeFile())->write($file, $this->tree);
        $this->assertEquals(file_exists($file), true);
        $this->assertEquals(Yaml::parse(file_get_contents($file)), $this->tree);
    }

    public function testWritePhp()
    {
        $file = $this->getTreeDir() . '/tree.php';
        (new TreeFile())->write($file, $this->tree);
        $this->assertEquals(file_exists($file), true);
    }


    public function testReadJson()
    {
        $file = $this->getTreeDir() . '/tree.json';
        $handle = new TreeFile();
        $handle->write($file, $this->tree);
        $this->assertEquals($handle->read($file), $this->tree);
    }

    public function testReadYml()
    {
        $file = $this->getTreeDir() . '/tree.yml';
        $handle = new TreeFile();
        $handle->write($file, $this->tree);
        $this->assertEquals($handle->read($file), $this->tree);
    }

    public function testReadPhp()
    {
        $file = $this->getTreeDir() . '/tree.php';
        $handle = new TreeFile();
        $handle->write($file, $this->tree);
        $this->assertEquals($handle->read($file), $this->tree);
    }
}
