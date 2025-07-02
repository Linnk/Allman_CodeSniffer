# Allman CodeSniffer

This is a continuation of my previous fixer [PHP_Allman](https://github.com/Linnk/PHP-Allman), this time based on [PHP_CodeSniffer](https://github.com/PHPCSStandards/PHP_CodeSniffer), which is proven to be more powerful and flexible in the long run.

The principles are the same for this standard:

1. I believe in [Allman indent style](https://en.wikipedia.org/wiki/Indent_style#Allman_style).
2. I believe in tabs instead of spaces.

Example:

```
while (x == y)
{
	something();
	something_else();

	if (true)
	{
		one_more();
	}
}

final_thing();
```

## Installation

Using composer in your projects:

```bash
# Require PHP_CodeSniffer and this Allman_CodeSniffer (standard)
composer require squizlabs/php_codesniffer
composer require linnk/allman-codesniffer

# Add Allman standard to install_paths
vendor/bin/phpcs --config-set installed_paths vendor/linnk/allman-codesniffer/

# Set Allman as default :)
vendor/bin/phpcs --config-set default_standard Allman

# Verifying
vendor/bin/phpcs -e
```

## How to use:

```bash
$ composer/bin/phpcs path/to/your/code
```

**Global installation** for general purposes:

```bash
# Global installation
composer global require squizlabs/php_codesniffer
composer global require linnk/allman-codesniffer

# Set `phpcs` and `phpcbf` in PATH
export PATH="$PATH:$HOME/.composer/vendor/bin"

# Set installed_paths
phpcs --config-set installed_paths ~/.composer/vendor/linnk/allman-codesniffer/

# Set Allman as default
phpcs --config-set default_standard Allman
```

## Contributing

```bash
# Clone repo
$ git clone https://github.com/Linnk/Allman_CodeSniffer.git

# Installation
$ composer install

# Configuration
$ composer/bin/phpcs --config-set installed_paths /full/path/to/Allman_CodeSniffer/
$ composer/bin/phpcs --config-set default_standard Allman
$ composer/bin/phpcs --config-set report_width auto
```
**Notice**: ^ Our composer folder here is `composer` instead of `vendor`. The irony of following standards.

TO-DO: Add instructions for podman container
