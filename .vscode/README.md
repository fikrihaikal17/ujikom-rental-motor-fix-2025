# VS Code Configuration for Laravel Blade Files

This project includes VS Code configuration to properly handle Laravel Blade templates and reduce false positive linting errors.

## Included Configuration

### `.vscode/settings.json`

-   Configures file associations for `.blade.php` files
-   Disables JavaScript/TypeScript validation for Blade files
-   Reduces CSS validation warnings for inline styles

### `.vscode/extensions.json`

-   Recommends useful extensions for Laravel development
-   Includes Blade syntax highlighting and IntelliSense

## Recommended Extensions

The following VS Code extensions are recommended for working with this Laravel project:

1. **Laravel Blade** - Syntax highlighting for Blade templates
2. **Laravel Extra IntelliSense** - Auto-completion for Laravel
3. **Laravel Artisan** - Artisan command integration
4. **Laravel Blade Spacer** - Better formatting for Blade files
5. **Tailwind CSS IntelliSense** - Auto-completion for Tailwind classes

## Notes

-   Some warnings about Blade directives like `@json()` being treated as JavaScript decorators are expected and can be ignored
-   The configuration helps reduce false positives while maintaining useful error detection
-   CSS warnings about `vertical-align` on block elements in Tailwind CSS are framework-related and can be ignored
