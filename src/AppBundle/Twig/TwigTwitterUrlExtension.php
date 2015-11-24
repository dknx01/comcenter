<?php

namespace AppBundle\Twig;
use Twig_Extension;
use Twig_SimpleFunction;

class TwigTwitterUrlExtension extends Twig_Extension
{

    public function getFunctions()
    {
        return array(new Twig_SimpleFunction($this->getName(), array($this, 'twitterUserUrl')));
    }

    public function twitterUserUrl($name)
    {
        return 'https://twitter.com/search?q=%40' . $name;
    }

    public function getName()
    {
        return 'twitterUserUrl';
    }
}