<?php

namespace Package\DefaultsBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Symfony\Component\HttpFoundation\Request;

/**
 * @Route("/")
 */
class PagesController extends Controller
{
    /**
     * @Route("/",
     *     name="PackageDefaultsBundle:Pages:Index"
     * )
     *
     * @Template
     */
    public function indexAction()
    {
        return array();
    }

    /**
     * @Route("/version",
     *     name="PackageDefaultsBundle:Pages:Version"
     * )
     * 
     * @Template
     */
    public function versionAction()
    {
        return array();
    }
}