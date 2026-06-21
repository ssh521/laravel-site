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

    public function ensureViteInputs(Command $command): void
    {
        $viteConfigPath = base_path('vite.config.js');

        if (! File::exists($viteConfigPath)) {
            $command->warn('Skipped Vite input update: vite.config.js was not found.');

            return;
        }

        $contents = File::get($viteConfigPath);
        $updated = $this->addViteInputs($contents, [
            'resources/css/site.css',
            'resources/js/site.js',
        ]);

        if ($updated === $contents) {
            $command->line('Vite inputs already include Laravel Site assets.');

            return;
        }

        File::put($viteConfigPath, $updated);
        $command->line("Updated Vite inputs: {$viteConfigPath}");
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

    /**
     * @param  array<int, string>  $assets
     */
    private function addViteInputs(string $contents, array $assets): string
    {
        if (! preg_match('/input\s*:\s*\[(?<inputs>.*?)\]/s', $contents, $matches, PREG_OFFSET_CAPTURE)) {
            return $contents;
        }

        $inputBody = $matches['inputs'][0];
        $missingAssets = array_values(array_filter(
            $assets,
            fn (string $asset): bool => ! str_contains($inputBody, "'{$asset}'")
                && ! str_contains($inputBody, "\"{$asset}\"")
        ));

        if ($missingAssets === []) {
            return $contents;
        }

        $lineIndent = $this->viteInputIndent($inputBody);
        $insert = '';

        foreach ($missingAssets as $asset) {
            $insert .= ",\n{$lineIndent}'{$asset}'";
        }

        $insertOffset = $matches['inputs'][1] + strlen($inputBody);

        return substr($contents, 0, $insertOffset).$insert.substr($contents, $insertOffset);
    }

    private function viteInputIndent(string $inputBody): string
    {
        if (preg_match('/\n(?<indent>\s*)[\'"]/', $inputBody, $matches)) {
            return $matches['indent'];
        }

        return '                    ';
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
