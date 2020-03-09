<?php

$finder = PhpCsFixer\Finder::create()
    ->exclude('spec')
    ->in(__DIR__)
;

return PhpCsFixer\Config::create()
    ->setFinder($finder)
    ->setRules([
        '@PSR2' => true,
    ])
;
