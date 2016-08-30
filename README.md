# Allman CodeSniffer

This is kind of a continuation from my previous fixer [PHP_Allman](https://github.com/Linnk/PHP-Allman), but this time is based on [PHP_CodeSniffer](https://github.com/squizlabs/PHP_CodeSniffer), which is more powerful and flexible in my opinion.

The principles are the same, tho:

1. I believe in [Allman indent style](https://en.wikipedia.org/wiki/Indent_style#Allman_style).
2. I believe in tabs instead of spaces.

The good thing now, is that if you don't like one of those you can customize it easier.


## Install

Using composer:

```
composer require linnk/allman-codesniffer
```

Configuring Allman standard, you will need to add the whole path because it depends of the CakePHP standard in the repository:

```
vendor/bin/phpcs --config-set installed_paths vendor/linnk/allman-codesniffer/
vendor/bin/phpcs --config-set default_standard Allman
```

Usage:

```
$ vendor/bin/phpcs path/to/your/code
```


## Global install

Using composer:

```
composer global require linnk/allman-codesniffer
```

Make sure you have ~/.composer/vendor/bin/ in your PATH, so you can run **phpcs** and **phpcbf** as a command line. Then, configure the Allman standard:

```
phpcs --config-set installed_paths ~/.composer/vendor/linnk/allman-codesniffer/
phpcs --config-set default_standard Allman
```

If everything is ok, you can check it “explaining” the default_standard:

```
phpcs -e
```

You should see the Allman standard definition at the beginning.


## Development

Clone it:

```
$ git clone https://github.com/Linnk/Allman_CodeSniffer.git
```

Compose it:

```
$ composer install
```

That's it.
