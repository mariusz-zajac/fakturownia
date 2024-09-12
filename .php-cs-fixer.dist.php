<?php

declare(strict_types=1);

$finder = (new PhpCsFixer\Finder())
    ->in(__DIR__)
    ->exclude(['vendor'])
;

/**
 * @link https://cs.symfony.com/doc/rules/index.html
 * @link https://cs.symfony.com/doc/ruleSets/index.html
 */
return (new PhpCsFixer\Config())
    ->setParallelConfig(PhpCsFixer\Runner\Parallel\ParallelConfigFactory::detect())
    ->setRules([
        '@Symfony' => true,
        'class_definition' => [
            'inline_constructor_arguments' => false,
            'multi_line_extends_each_single_line' => true,
        ],
        'concat_space' => [
            'spacing' => 'one',
        ],
        'operator_linebreak' => [
            'position' => 'beginning',
        ],
        'ordered_imports' => [
            'imports_order' =>  [
                'const',
                'class',
                'function',
            ],
        ],
        'align_multiline_comment' => true,
        'array_indentation' => true,
        'declare_strict_types' => true,
        'method_chaining_indentation' => true,
        'no_unreachable_default_argument_value' => true,
        'no_useless_return' => true,
        'phpdoc_annotation_without_dot' => false,
        'phpdoc_separation' => false,
        'phpdoc_summary' => false,
        'phpdoc_var_annotation_correct_order' => true,
        'protected_to_private' => false,
        'single_line_throw' => false,
        'yoda_style' => false,
        'increment_style' => false,
        'long_to_shorthand_operator' => false,
    ])
    ->setRiskyAllowed(true)
    ->setFinder($finder)
    ->setCacheFile(__DIR__ . '/.php-cs-fixer.cache')
;
