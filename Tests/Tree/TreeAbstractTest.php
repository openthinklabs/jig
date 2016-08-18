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

use Jig\Tests\Tree\TreeTestCommon;
use Jig\Tree\TreeAbstract;


class TreeAbstractTest extends TreeTestCommon
{

    protected function buildMock()
    {
        $treePath = $this->getTreeDir();
        file_put_contents($treePath . '/tree.json', json_encode($this->tree));
        return $this->getMockBuilder(TreeAbstract::class)
            ->setMethods(['__construct'])
            ->setConstructorArgs([[], $treePath . '/tree.json', 'some-version'])
            ->getMock();
    }


    public function testGetTree()
    {
        $mock = $this->buildMock();
        $this->assertEquals($mock->getTree(), $this->tree);
        $this->assertEquals($mock->getTree(), $this->tree);
    }

    public function testGetBranch()
    {
        $mock = $this->buildMock();
        $this->assertEquals($mock->getBranch('e'), ['eA', 'eB']);
    }

    public function testInsertBranch()
    {
        // should be first
        $mock = $this->buildMock();
        $mock->insertBranch('c', 'some-branch');
        $tree = $mock->getTree();
        $this->assertEquals(array_keys($tree), ['c', 'd', 'e', 'M', 'N']);
        $this->assertEquals($tree['c'], 'some-branch');
        $this->assertCount(5, $tree);

        // should go to the middle
        $mock = $this->buildMock();
        $mock->insertBranch('G', 'some-branch');
        $tree = $mock->getTree();
        $this->assertEquals(array_keys($tree), ['d', 'e', 'G', 'M', 'N']);
        $this->assertEquals($tree['G'], 'some-branch');
        $this->assertCount(5, $tree);

        // should go to the end
        $mock = $this->buildMock();
        $mock->insertBranch('z', 'some-branch');
        $tree = $mock->getTree();
        $this->assertEquals(array_keys($tree), ['d', 'e', 'M', 'N', 'z']);
        $this->assertEquals($tree['z'], 'some-branch');
        $this->assertCount(5, $tree);
    }

    public function testRemoveBranch()
    {
        // existing branch
        $mock = $this->buildMock();
        $mock->removeBranch('M');
        $this->assertArrayNotHasKey('M', $mock->getTree());

        // non existing branch
        $mock = $this->buildMock();
        $mock->removeBranch('non-existing');
        $this->assertCount(4, $mock->getTree());
    }

    public function testUpdateBranch()
    {
        $branch = [
            'an' => [
                'array' => [
                    'with' => [
                        'a' => [
                            'bunch' => [
                                'of' => [
                                    'layers'
                                ]
                            ]
                        ]
                    ]
                ]
            ]
        ];
        // non existing branch -> insert
        $mock = $this->buildMock();
        $mock->updateBranch('o', $branch);
        $this->assertArrayHasKey('o', $mock->getTree());

        // now existing -> update
        $branch['an']['array']['with']['a']['bunch']['of'] = 'levels';
        $mock->updateBranch('o', $branch);
        $tree = $mock->getTree();
        $this->assertEquals($tree['o']['an']['array']['with']['a']['bunch']['of'], 'levels');
    }

}

