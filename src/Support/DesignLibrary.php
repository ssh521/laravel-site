<?php

namespace Ssh521\LaravelSite\Support;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\File;
use InvalidArgumentException;
use SplFileInfo;

class DesignLibrary
{
    public function defaultDesign(): string
    {
        return 'essential';
    }

    /**
     * @return array<int, string>
     */
    public function names(): array
    {
        return collect(File::directories($this->designsRoot()))
            ->map(fn (string $path): string => basename($path))
            ->sort()
            ->values()
            ->all();
    }

    public function has(string $design): bool
    {
        return File::isDirectory($this->designPath($design));
    }

    public function installBase(Command $command, bool $force): int
    {
        return $this->copyDirectory($command, $this->stubsRoot(), base_path(), $force);
    }

    public function installDesign(Command $command, string $design, bool $force): int
    {
        if (! $this->has($design)) {
            $available = implode(', ', $this->names());

            throw new InvalidArgumentException("Unknown Laravel Site design [{$design}]. Available designs: {$available}.");
        }

        return $this->copyDirectory($command, $this->designPath($design), base_path(), $force);
    }

    private function copyDirectory(Command $command, string $sourceRoot, string $targetRoot, bool $force): int
    {
        $copied = 0;

        foreach (File::allFiles($sourceRoot) as $file) {
            $target = $this->targetPathFor($file, $sourceRoot, $targetRoot);

            if (File::exists($target) && ! $force) {
                $command->warn("Skipped existing file: {$target}");

                continue;
            }

            File::ensureDirectoryExists(dirname($target));
            File::copy($file->getPathname(), $target);

            $command->line("Copied: {$target}");
            $copied++;
        }

        return $copied;
    }

    private function targetPathFor(SplFileInfo $file, string $sourceRoot, string $targetRoot): string
    {
        $relativePath = ltrim(str_replace($sourceRoot, '', $file->getPathname()), DIRECTORY_SEPARATOR);

        if (str_ends_with($relativePath, '.stub')) {
            $relativePath = substr($relativePath, 0, -5);
        }

        return rtrim($targetRoot, DIRECTORY_SEPARATOR).DIRECTORY_SEPARATOR.$relativePath;
    }

    private function stubsRoot(): string
    {
        return dirname(__DIR__, 2).'/stubs';
    }

    private function designsRoot(): string
    {
        return dirname(__DIR__, 2).'/designs';
    }

    private function designPath(string $design): string
    {
        return $this->designsRoot().'/'.$design;
    }
}
