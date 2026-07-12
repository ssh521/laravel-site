<?php

namespace Ssh521\LaravelSite\Support;

use Illuminate\Support\Facades\File;
use InvalidArgumentException;
use LogicException;

class DesignCatalog
{
    /**
     * @return array<int, array<string, mixed>>
     */
    public function all(): array
    {
        return collect(File::files($this->catalogRoot()))
            ->filter(fn ($file): bool => $file->getExtension() === 'php')
            ->map(function ($file): array {
                $design = require $file->getPathname();

                if (! is_array($design)) {
                    throw new LogicException("Laravel Site catalog entry [{$file->getFilename()}] must return an array.");
                }

                $this->validateEntry($design, $file->getPathname());

                return $design;
            })
            ->sortBy('name')
            ->values()
            ->all();
    }

    /**
     * @return array<int, string>
     */
    public function names(): array
    {
        return array_column($this->all(), 'name');
    }

    /**
     * @return array<string, mixed>
     */
    public function find(string $name): array
    {
        $design = collect($this->all())->firstWhere('name', $name);

        if (! is_array($design)) {
            throw new InvalidArgumentException("Unknown Laravel Site catalog design [{$name}].");
        }

        return $design;
    }

    /**
     * @param  array<string, string>  $criteria
     * @return array<int, array<string, mixed>>
     */
    public function filter(array $criteria): array
    {
        return collect($this->all())
            ->filter(function (array $design) use ($criteria): bool {
                foreach ($criteria as $key => $value) {
                    if ($value === '') {
                        continue;
                    }

                    $matches = match ($key) {
                        'category' => in_array($value, $design['categories'], true),
                        'style' => in_array($value, $design['styles'], true),
                        'desktop_navigation' => $design['navigation']['desktop'] === $value,
                        'mobile_navigation' => $design['navigation']['mobile'] === $value,
                        default => ($design[$key] ?? null) === $value,
                    };

                    if (! $matches) {
                        return false;
                    }
                }

                return true;
            })
            ->values()
            ->all();
    }

    public function assertMatches(DesignLibrary $library): void
    {
        $catalogNames = $this->names();
        $designNames = $library->names();

        if ($catalogNames !== $designNames) {
            throw new LogicException(
                'Laravel Site catalog entries must match design directories. Catalog: '.implode(', ', $catalogNames).'. Designs: '.implode(', ', $designNames).'.'
            );
        }
    }

    private function catalogRoot(): string
    {
        return dirname(__DIR__, 2).'/catalog/designs';
    }

    /**
     * @param  array<string, mixed>  $design
     */
    private function validateEntry(array $design, string $path): void
    {
        $required = [
            'name',
            'label',
            'summary',
            'categories',
            'styles',
            'language',
            'theme',
            'accent',
            'density',
            'motion',
            'variance',
            'navigation',
            'hero',
            'sections',
            'preview',
        ];

        foreach ($required as $key) {
            if (! array_key_exists($key, $design)) {
                throw new LogicException("Laravel Site catalog entry [{$path}] is missing [{$key}].");
            }
        }

        foreach (['desktop', 'mobile'] as $key) {
            if (! isset($design['navigation'][$key])) {
                throw new LogicException("Laravel Site catalog entry [{$path}] is missing navigation [{$key}].");
            }
        }

        foreach (['path', 'thumbnail'] as $key) {
            if (! isset($design['preview'][$key])) {
                throw new LogicException("Laravel Site catalog entry [{$path}] is missing preview [{$key}].");
            }
        }
    }
}
