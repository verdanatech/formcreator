<?php

// autoload_static.php @generated by Composer

namespace Composer\Autoload;

class ComposerStaticInit7a47bed0adb1d96344c21f91602ebeb9
{
    public static $prefixLengthsPsr4 = array (
        'X' => 
        array (
            'Xylemical\\Expressions\\' => 22,
        ),
        'S' => 
        array (
            'Symfony\\Component\\Finder\\' => 25,
        ),
        'G' => 
        array (
            'Gregwar\\' => 8,
        ),
    );

    public static $prefixDirsPsr4 = array (
        'Xylemical\\Expressions\\' => 
        array (
            0 => __DIR__ . '/..' . '/xylemical/php-expressions/src',
        ),
        'Symfony\\Component\\Finder\\' => 
        array (
            0 => __DIR__ . '/..' . '/symfony/finder',
        ),
        'Gregwar\\' => 
        array (
            0 => __DIR__ . '/..' . '/gregwar/captcha/src/Gregwar',
        ),
    );

    public static $classMap = array (
        'Composer\\InstalledVersions' => __DIR__ . '/..' . '/composer/InstalledVersions.php',
        'Gregwar\\Captcha\\CaptchaBuilder' => __DIR__ . '/..' . '/gregwar/captcha/src/Gregwar/Captcha/CaptchaBuilder.php',
        'Gregwar\\Captcha\\CaptchaBuilderInterface' => __DIR__ . '/..' . '/gregwar/captcha/src/Gregwar/Captcha/CaptchaBuilderInterface.php',
        'Gregwar\\Captcha\\ImageFileHandler' => __DIR__ . '/..' . '/gregwar/captcha/src/Gregwar/Captcha/ImageFileHandler.php',
        'Gregwar\\Captcha\\PhraseBuilder' => __DIR__ . '/..' . '/gregwar/captcha/src/Gregwar/Captcha/PhraseBuilder.php',
        'Gregwar\\Captcha\\PhraseBuilderInterface' => __DIR__ . '/..' . '/gregwar/captcha/src/Gregwar/Captcha/PhraseBuilderInterface.php',
        'Symfony\\Component\\Finder\\Comparator\\Comparator' => __DIR__ . '/..' . '/symfony/finder/Comparator/Comparator.php',
        'Symfony\\Component\\Finder\\Comparator\\DateComparator' => __DIR__ . '/..' . '/symfony/finder/Comparator/DateComparator.php',
        'Symfony\\Component\\Finder\\Comparator\\NumberComparator' => __DIR__ . '/..' . '/symfony/finder/Comparator/NumberComparator.php',
        'Symfony\\Component\\Finder\\Exception\\AccessDeniedException' => __DIR__ . '/..' . '/symfony/finder/Exception/AccessDeniedException.php',
        'Symfony\\Component\\Finder\\Exception\\DirectoryNotFoundException' => __DIR__ . '/..' . '/symfony/finder/Exception/DirectoryNotFoundException.php',
        'Symfony\\Component\\Finder\\Finder' => __DIR__ . '/..' . '/symfony/finder/Finder.php',
        'Symfony\\Component\\Finder\\Gitignore' => __DIR__ . '/..' . '/symfony/finder/Gitignore.php',
        'Symfony\\Component\\Finder\\Glob' => __DIR__ . '/..' . '/symfony/finder/Glob.php',
        'Symfony\\Component\\Finder\\Iterator\\CustomFilterIterator' => __DIR__ . '/..' . '/symfony/finder/Iterator/CustomFilterIterator.php',
        'Symfony\\Component\\Finder\\Iterator\\DateRangeFilterIterator' => __DIR__ . '/..' . '/symfony/finder/Iterator/DateRangeFilterIterator.php',
        'Symfony\\Component\\Finder\\Iterator\\DepthRangeFilterIterator' => __DIR__ . '/..' . '/symfony/finder/Iterator/DepthRangeFilterIterator.php',
        'Symfony\\Component\\Finder\\Iterator\\ExcludeDirectoryFilterIterator' => __DIR__ . '/..' . '/symfony/finder/Iterator/ExcludeDirectoryFilterIterator.php',
        'Symfony\\Component\\Finder\\Iterator\\FileTypeFilterIterator' => __DIR__ . '/..' . '/symfony/finder/Iterator/FileTypeFilterIterator.php',
        'Symfony\\Component\\Finder\\Iterator\\FilecontentFilterIterator' => __DIR__ . '/..' . '/symfony/finder/Iterator/FilecontentFilterIterator.php',
        'Symfony\\Component\\Finder\\Iterator\\FilenameFilterIterator' => __DIR__ . '/..' . '/symfony/finder/Iterator/FilenameFilterIterator.php',
        'Symfony\\Component\\Finder\\Iterator\\LazyIterator' => __DIR__ . '/..' . '/symfony/finder/Iterator/LazyIterator.php',
        'Symfony\\Component\\Finder\\Iterator\\MultiplePcreFilterIterator' => __DIR__ . '/..' . '/symfony/finder/Iterator/MultiplePcreFilterIterator.php',
        'Symfony\\Component\\Finder\\Iterator\\PathFilterIterator' => __DIR__ . '/..' . '/symfony/finder/Iterator/PathFilterIterator.php',
        'Symfony\\Component\\Finder\\Iterator\\RecursiveDirectoryIterator' => __DIR__ . '/..' . '/symfony/finder/Iterator/RecursiveDirectoryIterator.php',
        'Symfony\\Component\\Finder\\Iterator\\SizeRangeFilterIterator' => __DIR__ . '/..' . '/symfony/finder/Iterator/SizeRangeFilterIterator.php',
        'Symfony\\Component\\Finder\\Iterator\\SortableIterator' => __DIR__ . '/..' . '/symfony/finder/Iterator/SortableIterator.php',
        'Symfony\\Component\\Finder\\SplFileInfo' => __DIR__ . '/..' . '/symfony/finder/SplFileInfo.php',
        'Xylemical\\Expressions\\Context' => __DIR__ . '/..' . '/xylemical/php-expressions/src/Context.php',
        'Xylemical\\Expressions\\Evaluator' => __DIR__ . '/..' . '/xylemical/php-expressions/src/Evaluator.php',
        'Xylemical\\Expressions\\ExpressionException' => __DIR__ . '/..' . '/xylemical/php-expressions/src/ExpressionException.php',
        'Xylemical\\Expressions\\ExpressionFactory' => __DIR__ . '/..' . '/xylemical/php-expressions/src/ExpressionFactory.php',
        'Xylemical\\Expressions\\Lexer' => __DIR__ . '/..' . '/xylemical/php-expressions/src/Lexer.php',
        'Xylemical\\Expressions\\LexerException' => __DIR__ . '/..' . '/xylemical/php-expressions/src/LexerException.php',
        'Xylemical\\Expressions\\MathInterface' => __DIR__ . '/..' . '/xylemical/php-expressions/src/MathInterface.php',
        'Xylemical\\Expressions\\Math\\BcMath' => __DIR__ . '/..' . '/xylemical/php-expressions/src/Math/BcMath.php',
        'Xylemical\\Expressions\\Operator' => __DIR__ . '/..' . '/xylemical/php-expressions/src/Operator.php',
        'Xylemical\\Expressions\\Parser' => __DIR__ . '/..' . '/xylemical/php-expressions/src/Parser.php',
        'Xylemical\\Expressions\\ParserException' => __DIR__ . '/..' . '/xylemical/php-expressions/src/ParserException.php',
        'Xylemical\\Expressions\\Procedure' => __DIR__ . '/..' . '/xylemical/php-expressions/src/Procedure.php',
        'Xylemical\\Expressions\\Token' => __DIR__ . '/..' . '/xylemical/php-expressions/src/Token.php',
        'Xylemical\\Expressions\\Value' => __DIR__ . '/..' . '/xylemical/php-expressions/src/Value.php',
    );

    public static function getInitializer(ClassLoader $loader)
    {
        return \Closure::bind(function () use ($loader) {
            $loader->prefixLengthsPsr4 = ComposerStaticInit7a47bed0adb1d96344c21f91602ebeb9::$prefixLengthsPsr4;
            $loader->prefixDirsPsr4 = ComposerStaticInit7a47bed0adb1d96344c21f91602ebeb9::$prefixDirsPsr4;
            $loader->classMap = ComposerStaticInit7a47bed0adb1d96344c21f91602ebeb9::$classMap;

        }, null, ClassLoader::class);
    }
}
