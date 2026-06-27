# AGENTS.md

## Package Boundary

`ssh521/laravel-site` owns public website scaffolding for Laravel Starter Kit apps.

It does not own admin screens, auth screens, CMS CRUD, or runtime page builder behavior. Use `ssh521/laravel-admin` and feature packages such as `laravel-page`, `laravel-blog`, or `laravel-file` for those responsibilities.

## Source Of Truth

- Package behavior: `README.md` and `PRD.md`
- Design preset rules: `docs/designs.md`
- Design registry and default design: `src/Support/DesignLibrary.php`
- Install command behavior: `src/Console/Commands/InstallCommand.php`
- Package config defaults: `config/laravel-site.php`
- Install verification: `tests/Feature/InstallCommandTest.php`

## Design Presets

Design source files live under `designs/{design-name}/`.

Each preset should install a complete public site surface:

- `config/laravel-site.php.stub`
- `design.md.stub`
- `resources/views/site/home.blade.php.stub`
- `resources/views/components/layouts/site.blade.php.stub`
- `resources/views/components/site/*.blade.php.stub`
- `resources/css/site.css.stub`
- `resources/js/site.js.stub`
- public media when the design requires it

Do not add a root `design.md` to this repository. `design.md` is a generated host-app artifact copied from each preset's `design.md.stub`.

## Change Rules

- Add a new customer-facing look as a new directory under `designs/` unless the request explicitly says to replace an existing preset.
- Keep the default install design controlled by `DesignLibrary::defaultDesign()`.
- Keep `laravel-site:install --design={name}` and `laravel-site:design {name}` behavior aligned with the design registry.
- When adding or renaming a preset, update `README.md`, `docs/designs.md`, and `tests/Feature/InstallCommandTest.php` when applicable.
- Preserve Laravel Starter Kit auth pages. This package should only scaffold the public site area.
- Use Tailwind CSS v4 conventions. Do not introduce `tailwind.config.js` or v3 `@tailwind base/components/utilities` output.

## Verification

Run the fastest relevant checks after changes:

```bash
php -l src/Support/DesignLibrary.php
php -l src/Console/Commands/InstallCommand.php
php -l config/laravel-site.php
git diff --check
/Users/ssh521/Projects/Packagist/adminTest/vendor/bin/phpunit --configuration phpunit.xml.dist
```

If package-local `vendor/bin/phpunit` is unavailable, use the shared `adminTest` runner above.
