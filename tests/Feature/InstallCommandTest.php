<?php

namespace Ssh521\LaravelSite\Tests\Feature;

use Illuminate\Support\Facades\File;
use Ssh521\LaravelSite\Tests\TestCase;

class InstallCommandTest extends TestCase
{
    protected function setUp(): void
    {
        parent::setUp();

        foreach ($this->generatedPaths() as $path) {
            if (File::isDirectory($path)) {
                File::deleteDirectory($path);

                continue;
            }

            File::delete($path);
        }
    }

    protected function tearDown(): void
    {
        foreach ($this->generatedPaths() as $path) {
            if (File::isDirectory($path)) {
                File::deleteDirectory($path);

                continue;
            }

            File::delete($path);
        }

        parent::tearDown();
    }

    public function test_install_command_creates_site_scaffold(): void
    {
        $this->artisan('laravel-site:install')
            ->assertExitCode(0);

        $this->assertFileExists(base_path('app/Http/Controllers/Site/HomeController.php'));
        $this->assertFileExists(base_path('routes/site.php'));
        $this->assertFileExists(base_path('resources/views/site/home.blade.php'));
        $this->assertFileExists(base_path('resources/views/components/layouts/site.blade.php'));
        $this->assertFileExists(base_path('resources/views/components/site/header.blade.php'));
        $this->assertFileExists(base_path('resources/css/site.css'));
        $this->assertFileExists(base_path('resources/js/site.js'));
        $this->assertFileExists(base_path('design.md'));

        $this->assertStringContainsString("require __DIR__.'/site.php';", File::get(base_path('routes/web.php')));
        $this->assertStringContainsString('Build responsive customer websites faster.', File::get(base_path('resources/views/site/home.blade.php')));
    }

    public function test_installed_site_script_initializes_mobile_menu_after_dom_is_ready(): void
    {
        $this->artisan('laravel-site:install')
            ->assertExitCode(0);

        $script = File::get(base_path('resources/js/site.js'));

        $this->assertStringContainsString('function initSiteMobileMenu()', $script);
        $this->assertStringContainsString("document.readyState === 'loading'", $script);
        $this->assertStringContainsString('DOMContentLoaded', $script);
        $this->assertStringContainsString("menu.classList.toggle('hidden', !isOpen)", $script);
        $this->assertStringContainsString("panel?.classList.toggle('translate-x-full', !isOpen)", $script);
    }

    public function test_mobile_menu_is_rendered_outside_the_sticky_header(): void
    {
        $this->artisan('laravel-site:install')
            ->assertExitCode(0);

        $header = File::get(base_path('resources/views/components/site/header.blade.php'));

        $this->assertMatchesRegularExpression('/<\/header>\s*<x-site\.mobile-menu :items="\$items" \/>/', $header);
    }

    public function test_install_command_adds_site_assets_to_vite_inputs(): void
    {
        File::put(base_path('vite.config.js'), <<<'JS'
import { defineConfig } from 'vite';
import laravel from 'laravel-vite-plugin';

export default defineConfig({
    plugins: [
        laravel({
            input: ['resources/css/app.css', 'resources/js/app.js'],
            refresh: true,
        }),
    ],
});
JS);

        $this->artisan('laravel-site:install')
            ->assertExitCode(0);

        $viteConfig = File::get(base_path('vite.config.js'));

        $this->assertStringContainsString("'resources/css/site.css'", $viteConfig);
        $this->assertStringContainsString("'resources/js/site.js'", $viteConfig);
    }

    public function test_install_command_does_not_duplicate_site_vite_inputs(): void
    {
        File::put(base_path('vite.config.js'), <<<'JS'
import { defineConfig } from 'vite';
import laravel from 'laravel-vite-plugin';

export default defineConfig({
    plugins: [
        laravel({
            input: [
                'resources/css/app.css',
                'resources/js/app.js',
                'resources/css/site.css',
                'resources/js/site.js',
            ],
            refresh: true,
        }),
    ],
});
JS);

        $this->artisan('laravel-site:install')
            ->assertExitCode(0);

        $viteConfig = File::get(base_path('vite.config.js'));

        $this->assertSame(1, substr_count($viteConfig, 'resources/css/site.css'));
        $this->assertSame(1, substr_count($viteConfig, 'resources/js/site.js'));
    }

    public function test_install_command_can_select_a_design(): void
    {
        $this->artisan('laravel-site:install', ['--design' => 'conversion'])
            ->assertExitCode(0);

        $this->assertStringContainsString('Turn campaign traffic into qualified inquiries.', File::get(base_path('resources/views/site/home.blade.php')));
        $this->assertStringContainsString("'preset' => env('LARAVEL_SITE_PRESET', 'conversion')", File::get(base_path('config/laravel-site.php')));
    }

    public function test_design_command_lists_available_designs(): void
    {
        $this->artisan('laravel-site:design', ['--list' => true])
            ->expectsOutput('Available Laravel Site designs:')
            ->expectsOutput('- clinic-clean')
            ->expectsOutput('- conversion')
            ->expectsOutput('- corporate-trust')
            ->expectsOutput('- essential')
            ->expectsOutput('- event-promo')
            ->expectsOutput('- local-business')
            ->expectsOutput('- portfolio-editorial')
            ->expectsOutput('- saas-product')
            ->assertExitCode(0);
    }

    public function test_new_designs_can_be_applied(): void
    {
        $expectations = [
            'corporate-trust' => 'Present your company with clarity',
            'local-business' => 'Help nearby customers call',
            'clinic-clean' => 'Create a calm path',
            'portfolio-editorial' => 'Give the work room',
            'saas-product' => 'Explain the product',
            'event-promo' => 'Give visitors the reason',
        ];

        foreach ($expectations as $design => $headline) {
            $this->artisan('laravel-site:design', [
                'design' => $design,
                '--force' => true,
            ])->assertExitCode(0);

            $this->assertStringContainsString($headline, File::get(base_path('resources/views/site/home.blade.php')));
        }
    }

    public function test_install_command_does_not_overwrite_existing_files_without_force(): void
    {
        File::ensureDirectoryExists(base_path('resources/views/site'));
        File::put(base_path('resources/views/site/home.blade.php'), 'custom home');

        $this->artisan('laravel-site:install')
            ->assertExitCode(0);

        $this->assertSame('custom home', File::get(base_path('resources/views/site/home.blade.php')));
    }

    public function test_install_command_places_site_route_loader_after_existing_routes(): void
    {
        File::ensureDirectoryExists(base_path('routes'));
        File::put(base_path('routes/web.php'), "<?php\n\nuse Illuminate\\Support\\Facades\\Route;\n\nRoute::get('/', fn () => 'starter');\n");

        $this->artisan('laravel-site:install')
            ->assertExitCode(0);

        $contents = File::get(base_path('routes/web.php'));

        $this->assertGreaterThan(
            strpos($contents, "Route::get('/', fn () => 'starter');"),
            strpos($contents, "require __DIR__.'/site.php';")
        );
    }

    public function test_install_command_does_not_duplicate_route_loader(): void
    {
        File::ensureDirectoryExists(base_path('routes'));
        File::put(base_path('routes/web.php'), "<?php\n\nrequire __DIR__.'/site.php';\n");

        $this->artisan('laravel-site:install')
            ->assertExitCode(0);

        $this->assertSame(1, substr_count(File::get(base_path('routes/web.php')), "require __DIR__.'/site.php';"));
    }

    public function test_install_command_overwrites_existing_files_with_force(): void
    {
        File::ensureDirectoryExists(base_path('resources/views/site'));
        File::put(base_path('resources/views/site/home.blade.php'), 'custom home');

        $this->artisan('laravel-site:install', ['--force' => true])
            ->assertExitCode(0);

        $this->assertStringContainsString('<x-site.hero', File::get(base_path('resources/views/site/home.blade.php')));
    }

    public function test_design_command_applies_selected_design_with_force(): void
    {
        File::ensureDirectoryExists(base_path('resources/views/site'));
        File::put(base_path('resources/views/site/home.blade.php'), 'custom home');

        $this->artisan('laravel-site:design', [
            'design' => 'conversion',
            '--force' => true,
        ])->assertExitCode(0);

        $this->assertStringContainsString('Turn campaign traffic into qualified inquiries.', File::get(base_path('resources/views/site/home.blade.php')));
    }

    /**
     * @return array<int, string>
     */
    private function generatedPaths(): array
    {
        return [
            base_path('app/Http/Controllers/Site'),
            base_path('routes/site.php'),
            base_path('routes/web.php'),
            base_path('config/laravel-site.php'),
            base_path('vite.config.js'),
            base_path('resources/views/site'),
            base_path('resources/views/components/layouts/site.blade.php'),
            base_path('resources/views/components/site'),
            base_path('resources/css/site.css'),
            base_path('resources/js/site.js'),
            base_path('design.md'),
        ];
    }
}
