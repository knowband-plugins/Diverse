<?php

/**
 * Dashboard Controller
 *
 * This file is application-wide controller file. You can put all
 * application-wide controller-related methods here.
 *
 * Licensed under The MIT License
 * For full copyright and license information, please see the LICENSE.txt
 * Redistributions of files must retain the above copyright notice.
 *
 * @copyright     Copyright (c) Velocity Software Solutions (http://www.velsof.com)
 * @link          http://www.mockingfish.com MockingFish Project
 * @since         3 Feb 2015
 * @license       http://www.opensource.org/licenses/mit-license.php MIT License
 * @version		 1.0
 * @todo
 */
class ErrorController extends AppController {

    public function beforeFilter() {
        parent::beforeFilter();
        $this->Auth->allow('error404');
    }

    public function error404() {
        //$this->layout = 'default';
    }

}

?>