<?php

$finder = PhpCsFixer\Finder::create()
    ->in(__DIR__)
    ->exclude('var')
;

return PhpCsFixer\Config::create()
    ->setRiskyAllowed(true)
        ->setRules([
            '@Symfony' => true,
            'array_syntax' => ['syntax' => 'short'],
            'class_definition' => false,
            'concat_space' => ['spacing' => 'one'],
            'phpdoc_align' => false,
            'phpdoc_annotation_without_dot' => false,
            'yoda_style' => false,
            'no_break_comment' => false,
            'self_accessor' => false,
            'phpdoc_add_missing_param_annotation' => ['only_untyped' => false],
            'phpdoc_trim' => true,
            'phpdoc_separation' => true,
            'no_extra_blank_lines' => false,
            'align_multiline_comment' => ['comment_type' => 'all_multiline'],
            'phpdoc_order' => true,
            'declare_strict_types' => true,
        ])
    ->setFinder($finder)
;
