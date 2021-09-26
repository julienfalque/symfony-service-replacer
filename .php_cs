<?php

declare(strict_types=1);

$finder = PhpCsFixer\Finder::create()
    ->in(__DIR__.'/src')
    ->append([__FILE__])
    ->exclude('Test/SymfonyApp/var')
;

return PhpCsFixer\Config::create()
    ->setRiskyAllowed(true)
    ->setRules([
        '@DoctrineAnnotation' => true,
        '@PHP56Migration' => true,
        '@PHP56Migration:risky' => true,
        '@PHP70Migration' => true,
        '@PHP70Migration:risky' => true,
        '@PHP71Migration' => true,
        '@PHP71Migration:risky' => true,
        '@PHP73Migration' => true,
        '@PHP74Migration' => true,
        '@PHP74Migration:risky' => true,
        '@Symfony' => true,
        '@Symfony:risky' => true,
        'align_multiline_comment' => [
            'comment_type' => 'all_multiline',
        ],
        'array_indentation' => true,
        'array_push' => false,
        'array_syntax' => [
            'syntax' => 'short',
        ],
        'backtick_to_shell_exec' => true,
        'blank_line_before_statement' => [
            'statements' => ['break', 'continue', 'declare', 'return', 'throw', 'try'],
        ],
        'class_attributes_separation' => true,
        'concat_space' => true,
        'combine_consecutive_issets' => true,
        'combine_consecutive_unsets' => true,
        'comment_to_phpdoc' => true,
        'compact_nullable_typehint' => true,
        'escape_implicit_backslashes' => [
            'single_quoted' => true,
        ],
        'explicit_indirect_variable' => true,
        'explicit_string_variable' => true,
        'fopen_flag_order' => false,
        'fopen_flags' => false,
        'fully_qualified_strict_types' => true,
        'function_to_constant' => [
            'functions' => ['get_called_class', 'get_class', 'php_sapi_name', 'phpversion', 'pi'],
        ],
        'global_namespace_import' => [
            'import_constants' => true,
            'import_functions' => true,
        ],
        'group_import' => true,
        'header_comment' => [
            'header' => '',
        ],
        'heredoc_to_nowdoc' => true,
        'linebreak_after_opening_tag' => true,
        'list_syntax' => [
            'syntax' => 'short',
        ],
        'logical_operators' => true,
        'method_argument_space' => [
            'on_multiline' => 'ensure_fully_multiline',
            'after_heredoc' => true,
        ],
        'multiline_comment_opening_closing' => true,
        'multiline_whitespace_before_semicolons' => [
            'strategy' => 'new_line_for_chained_calls',
        ],
        'no_alias_functions' => [
            'sets' => ['@all'],
        ],
        'no_alternative_syntax' => true,
        'no_binary_string' => true,
        'no_extra_blank_lines' => [
            'tokens' => ['case', 'continue', 'default', 'extra', 'return', 'switch', 'throw'],
        ],
        'no_homoglyph_names' => false,
        'no_mixed_echo_print' => true,
        'no_null_property_initialization' => true,
        'no_php4_constructor' => true,
        'no_superfluous_elseif' => true,
        'no_superfluous_phpdoc_tags' => [
            'remove_inheritdoc' => true,
        ],
        'no_unreachable_default_argument_value' => true,
        'no_unset_cast' => true,
        'no_unset_on_property' => true,
        'no_useless_else' => true,
        'no_useless_return' => true,
        'non_printable_character' => [
            'use_escape_sequences_in_strings' => true,
        ],
        'nullable_type_declaration_for_default_null_value' => true,
        'operator_linebreak' => true,
        'ordered_imports' => true,
        'php_unit_dedicate_assert_internal_type' => true,
        'php_unit_method_casing' => [
            'case' => 'snake_case',
        ],
        'php_unit_set_up_tear_down_visibility' => true,
        'php_unit_test_annotation' => true,
        'php_unit_test_case_static_method_calls' => [
            'call_type' => 'self',
        ],
        'phpdoc_line_span' => [
            'const' => 'single',
            'property' => 'single',
        ],
        'phpdoc_no_empty_return' => true,
        'phpdoc_order' => true,
        'phpdoc_order_by_value' => true,
        'phpdoc_tag_casing' => true,
        'phpdoc_tag_type' => true,
        'phpdoc_to_param_type' => true,
        'phpdoc_to_return_type' => true,
        'phpdoc_trim_consecutive_blank_line_separation' => true,
        'phpdoc_types_order' => [
            'null_adjustment' => 'always_last',
            'sort_algorithm' => 'none',
        ],
        'phpdoc_var_annotation_correct_order' => true,
        'protected_to_private' => true,
        'random_api_migration' => true,
        'regular_callable_call' => true,
        'return_assignment' => true,
        'self_static_accessor' => true,
        'single_import_per_statement' => false,
        'simple_to_complex_string_variable' => true,
        'simplified_if_return' => true,
        'single_line_comment_style' => true,
        'single_line_throw' => false,
        'space_after_semicolon' => [
            'remove_in_empty_for_expressions' => true,
        ],
        'static_lambda' => true,
        'strict_comparison' => true,
        'strict_param' => true,
        'string_line_ending' => true,
        'void_return' => false,
        'yoda_style' => false,
    ])
    ->setFinder($finder)
;
