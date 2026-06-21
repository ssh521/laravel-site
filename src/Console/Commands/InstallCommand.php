<?php

namespace Ssh521\LaravelSite\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\File;
use InvalidArgumentException;
use Ssh521\LaravelSite\Support\DesignLibrary;

class InstallCommand extends Command
{
    protected $signature = 'laravel-site:install
        {--design=essential : Design library item to install}
        {--force : Overwrite existing generated site scaffold files}
        {--skip-route-include : Do not add the routes/site.php require line to routes/web.php}';

    protected $description = 'Install an editable responsive public site scaffold into the host Laravel app.';

    public function handle(): int
    {
        $this->info('Installing Laravel Site scaffold...');

        $design = $this->selectedDesign();
        $copied = $this->designLibrary()->installBase($this, (bool) $this->option('force'));
        $copied += $this->designLibrary()->installDesign($this, $design, (bool) $this->option('force'));
        $this->designLibrary()->ensureViteInputs($this);

        if (! $this->option('skip-route-include')) {
            $this->ensureSiteRouteIsLoaded();
        }

        $this->newLine();
        $this->info("Laravel Site install complete. Design [{$design}], {$copied} file(s) copied.");
        $this->line('Edit resources/views/site, resources/views/components/site, resources/css/site.css, and design.md for customer-specific work.');

        return self::SUCCESS;
    }

    private function selectedDesign(): string
    {
        $design = trim((string) $this->option('design'));

        if ($design === '') {
            return $this->designLibrary()->defaultDesign();
        }

        if (! $this->designLibrary()->has($design)) {
            throw new InvalidArgumentException(
                'Unknown Laravel Site design ['.$design.']. Available designs: '.implode(', ', $this->designLibrary()->names()).'.'
            );
        }

        return $design;
    }

    private function ensureSiteRouteIsLoaded(): void
    {
        $routesWebPath = base_path('routes/web.php');
        $includeLine = "require __DIR__.'/site.php';";

        File::ensureDirectoryExists(dirname($routesWebPath));

        if (! File::exists($routesWebPath)) {
            File::put($routesWebPath, "<?php\n\n{$includeLine}\n");
            $this->line("Created route loader: {$routesWebPath}");

            return;
        }

        $contents = File::get($routesWebPath);

        if (str_contains($contents, "routes/site.php") || str_contains($contents, "__DIR__.'/site.php'")) {
            $this->line('Site route loader already exists.');

            return;
        }

        File::append($routesWebPath, "\n{$includeLine}\n");
        $this->line("Updated route loader: {$routesWebPath}");
    }

    private function designLibrary(): DesignLibrary
    {
        return app(DesignLibrary::class);
    }
}
