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

use Symfony\Component\Yaml\Yaml;
use Symfony\Component\Filesystem\Filesystem;

/**
 * File system handler for trees
 * 
 * @author Dieter Raber <dieter@taotesting.com>
 * @package doc-converter

 * @license GPL-2.0
 */
class TreeFile
{

    /**
     * Retrieve the contents of a tree and return them as array.
     * If the file does not exist an empty array is returned.
     *
     * @param $path
     * @return array
     * @throws \Exception
     *
     */
    public function read($path) {

        if (!file_exists($path)) {
            return array();
        }

        $format = strtolower(substr(strrchr($path, '.'), 1));

        ob_start();
        if($format === 'php') {
            $contents = include $path;
            ob_clean();
        }
        else {
            include $path;
            $contents = ob_get_clean();
        }

        switch($format) {
            case 'yml':
            case 'yaml':
                return Yaml::parse($contents);

            case 'json':
                return json_decode($contents, true);

            case 'php':
                return $contents;

            default:
                throw new \Exception($path . ' has invalid contents');

        }
    }


    /**
     * Write structure data to a tree file, create path if needed
     *
     * @param $path
     * @param array $data
     * @return int
     * @throws \Exception
     */
    public function write($path, array $data) {
        $format = strtolower(substr(strrchr($path, '.'), 1));
        switch($format) {
            case 'yml':
            case 'yaml':
                $contents = Yaml::dump($data);
                break;

            case 'json':
                $contents = json_encode($data);
                break;

            case 'php':
                $contents = '<?php return ' . var_export($data, 1) . ';';
                break;

            default:
                throw new \Exception($format . ' is not a valid format');

        }
        $fs = new Filesystem();
        $fs->dumpFile($path, $contents);
        return strlen($contents);
    }
}
