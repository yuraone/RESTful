<?php
/**
 * Zend Framework (http://framework.zend.com/)
 *
 * @link      http://github.com/zendframework/ZendSkeletonApplication for the canonical source repository
 * @copyright Copyright (c) 2005-2015 Zend Technologies USA Inc. (http://www.zend.com)
 * @license   http://framework.zend.com/license/new-bsd New BSD License
 */

namespace Application\Controller;

use Zend\Mvc\Controller\AbstractActionController;
use Zend\View\Model\ViewModel;

/**
 * Class IndexController
 * @package Application\Controllerf
 * это контроллер
 */
class IndexController extends AbstractActionController
{
    /**
     * @return ViewModel
     * это экшн.
     */
    public function indexAction()
    {
        /**
         * это логика для экшена...
         */
        $a = 2;
        $b = 3;
        $z = $a*$b;
        return new ViewModel([
            'YurecVariable' => $z
        ]);
    }

    public function yurecAction()
    {
       return new ViewModel();
    }

    
}
