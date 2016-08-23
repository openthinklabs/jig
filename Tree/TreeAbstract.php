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

namespace Jig\Tree;

use Jig\Tree\TreeFile;


/**
 * TreeAbstract is the abstract base class for all tree models
 *
 * @author Dieter Raber <dieter@taotesting.com>
 * @package doc-converter

 * @license GPL-2.0
 */
abstract class TreeAbstract
{

    /**
     * @var array
     */
    protected $tree;

    /**
     * @var string
     */
    protected $treePath;

    /**
     * @var array
     */
    protected $config;

    /**
     * @var string
     */
    protected $version;

    /**
     * TreeAbstract constructor.
     *
     * @param array $config
     * @param $treePath
     * @param $version
     */
    public function __construct(array $config, $treePath, $version)
    {
        $this->version = $version;
        $this->treePath = $treePath;
        $this->config = $config;
        $this->tree = (new TreeFile())->read($this->treePath);
    }
    

    /**
     * Stores the tree data in a file
     *
     * @return $this
     */
    public function save() {
        (new TreeFile())->write($this->treePath, $this->tree);
        return $this;
    }

    /**
     * Sort the tree in a case insensitive manner
     *
     * @return $this
     */
    public function sort() {
        uksort($this->tree, 'strcasecmp');
        return $this;
    }

    /**
     * Retrieves the tree
     * @return array
     */
    public function getTree() {
        return $this->tree;
    }

    /**
     * Returns the value array of said branch or an empty array on failure
     *
     * @param $branchId
     * @return array
     */
    public function getBranch($branchId) {
        return isset($this->tree[$branchId]) ? $this->tree[$branchId] : array();
    }

    /**
     * Adds a new branch in the alphabetically correct position;
     *
     * @param $branchId
     * @param $branch
     * @return $this
     */
    public function insertBranch($branchId, $branch) {
        $this->tree[$branchId] = $branch;
        $this->sort();
        return $this;
    }

    /**
     * Removes a branch from the tree
     *
     * @param $branchId
     * @return $this
     */
    public function removeBranch($branchId) {
        if(isset($this->tree[$branchId])) {
            unset($this->tree[$branchId]);
        }
        return $this;
    }

    /**
     * Update a branch or insert it if it doesn't exist
     *
     * @param $branchId
     * @param $branch
     * @return $this
     */
    public function updateBranch($branchId, $branch) {
        if(!isset($this->tree[$branchId])) {
            $this->insertBranch($branchId, $branch);
            return $this;
        }
        $this->tree[$branchId] = array_merge($this->tree[$branchId], $branch);
        return $this;
    }
}
