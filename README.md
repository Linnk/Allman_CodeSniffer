# Allman CodeSniffer

This is kind of a continuation from my previous fixer [PHP_Allman](https://github.com/Linnk/PHP-Allman), but this time is based on [PHP_CodeSniffer](https://github.com/squizlabs/PHP_CodeSniffer), which is more powerful and flexible in my opinion.

The principles are the same, tho:

1. I believe in [Allman indent style](https://en.wikipedia.org/wiki/Indent_style#Allman_style).
2. I believe in tabs instead of spaces.

The good thing now, is that if you don't like one of those you can customize it easier.


# Installing

Using composer:

```
composer require --dev "linnk/Allman_CodeSniffer=1.0"
```

Usage:

```
$ vendor/bin/phpcs --standard=Allman path/to/your/code
```

# Installation for development

Clone it:

```
$ git clone https://github.com/Linnk/Allman_CodeSniffer.git
```

Compose it:

```
$ composer install
```

That simple.
