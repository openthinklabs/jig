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

/**
 * TreeInterface
 *
 * @author Dieter Raber <dieter@taotesting.com>
 * @package doc-converter

 * @license GPL-2.0
 */
interface TreeInterface
{

    /**
     * Stores the tree data in a file
     *
     * @throws \Exception
     */
    public function save();

    /**
     * Retrieves the tree
     * @return array
     * @throws \Exception
     */
    public function getTree();

    /**
     * Returns the value array of said branch or an empty array on failure
     *
     * @param $branchId
     * @return array
     */
    public function getBranch($branchId);

    /**
     * Adds a new branch in the alphabetically correct position;
     *
     * @param $branchId
     * @param $branch
     */
    public function insertBranch($branchId, $branch);

    /**
     * Update a branch or insert it if it doesn't exist
     *
     * @param $branchId
     * @param $branch
     */
    public function updateBranch($branchId, $branch);

    /**
     * Removes a branch from the tree
     *
     * @param $branchId
     */
    public function removeBranch($branchId);
}
