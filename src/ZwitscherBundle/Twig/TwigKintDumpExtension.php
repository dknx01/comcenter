<?php

namespace ZwitscherBundle\Twig;

use Kint;
use Twig_Extension;
use Twig_SimpleFunction;

class TwigKintDumpExtension extends Twig_Extension
{
    private $env;

    public function __construct($env)
    {
        $this->env = $env;
    }

    public function getFunctions()
    {
        return array(new Twig_SimpleFunction($this->getName(), array($this, 'kintDump')));
    }

    public function kintDump($data)
    {
        if ($this->env == 'dev') {
            Kint::dump($data);
        }
    }

    public function getName()
    {
        return 'kintDump';
    }

}