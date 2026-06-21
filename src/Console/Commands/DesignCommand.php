<?php

namespace Ssh521\LaravelSite\Console\Commands;

use Illuminate\Console\Command;
use Ssh521\LaravelSite\Support\DesignLibrary;

class DesignCommand extends Command
{
    protected $signature = 'laravel-site:design
        {design? : Design library item to apply}
        {--list : List available Laravel Site designs}
        {--force : Overwrite existing site design files}';

    protected $description = 'List or apply an editable Laravel Site design scaffold.';

    public function handle(): int
    {
        if ($this->option('list')) {
            $this->line('Available Laravel Site designs:');

            foreach ($this->designLibrary()->names() as $design) {
                $this->line("- {$design}");
            }

            return self::SUCCESS;
        }

        $design = trim((string) ($this->argument('design') ?: $this->designLibrary()->defaultDesign()));
        $copied = $this->designLibrary()->installDesign($this, $design, (bool) $this->option('force'));
        $this->designLibrary()->ensureViteInputs($this);

        $this->newLine();
        $this->info("Laravel Site design [{$design}] applied. {$copied} file(s) copied.");

        return self::SUCCESS;
    }

    private function designLibrary(): DesignLibrary
    {
        return app(DesignLibrary::class);
    }
}
