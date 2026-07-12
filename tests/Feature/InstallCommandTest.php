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
        $this->assertStringContainsString('Laravel Starter Kit 위에', File::get(base_path('resources/views/site/home.blade.php')));
        $this->assertStringContainsString('Public Site', File::get(base_path('resources/views/site/home.blade.php')));
        $this->assertStringContainsString('공개 사이트를 만든 뒤 관리자와 기능 패키지로 확장합니다', File::get(base_path('resources/views/site/home.blade.php')));
        $this->assertStringContainsString('composer require ssh521/laravel-admin', File::get(base_path('resources/views/site/home.blade.php')));
        $this->assertStringContainsString('php artisan laravel-admin:install --with=users,file', File::get(base_path('resources/views/site/home.blade.php')));
        $this->assertStringContainsString("'preset' => env('LARAVEL_SITE_PRESET', 'package-guide')", File::get(base_path('config/laravel-site.php')));
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

    public function test_yaver_studio_initializes_jarallax_video_hero(): void
    {
        $this->artisan('laravel-site:design', [
            'design' => 'yaver-studio',
            '--force' => true,
        ])->assertExitCode(0);

        $layout = File::get(base_path('resources/views/components/layouts/site.blade.php'));
        $hero = File::get(base_path('resources/views/components/site/hero.blade.php'));
        $script = File::get(base_path('resources/js/site.js'));

        $this->assertStringContainsString('jarallax@2/dist/jarallax.css', $layout);
        $this->assertStringContainsString('jarallax@2/dist/jarallax.min.js', $layout);
        $this->assertStringContainsString('data-site-header', File::get(base_path('resources/views/components/site/header.blade.php')));
        $this->assertStringContainsString('data-jarallax', $hero);
        $this->assertStringContainsString('jarallax-img', $hero);
        $this->assertStringContainsString('site-hero-stage', $hero);
        $this->assertStringContainsString('media/yaver-studio-hero.mp4', $hero);
        $this->assertStringContainsString('function updateSiteHeaderOffset()', $script);
        $this->assertStringContainsString('function watchSiteHeaderOffset()', $script);
        $this->assertStringContainsString('ResizeObserver', $script);
        $this->assertStringContainsString('--site-header-height', $script);
        $this->assertStringContainsString('function initSiteJarallax()', $script);
        $this->assertStringContainsString('window.jarallax(elements)', $script);
    }

    public function test_yaver_studio_ships_cinematic_sections_without_scroll_decorations(): void
    {
        $this->artisan('laravel-site:design', [
            'design' => 'yaver-studio',
            '--force' => true,
        ])->assertExitCode(0);

        $layout = File::get(base_path('resources/views/components/layouts/site.blade.php'));
        $hero = File::get(base_path('resources/views/components/site/hero.blade.php'));
        $cta = File::get(base_path('resources/views/components/site/cta.blade.php'));
        $home = File::get(base_path('resources/views/site/home.blade.php'));
        $css = File::get(base_path('resources/css/site.css'));
        $script = File::get(base_path('resources/js/site.js'));

        $this->assertStringContainsString('site-snap-container', $layout);
        $this->assertStringContainsString('site-snap-section', $hero);
        $this->assertStringNotContainsString('x-site.scroll-indicator', $hero);
        $this->assertStringNotContainsString('실시간 제작', $hero);
        $this->assertStringNotContainsString('rounded-full bg-fuchsia-400', $hero);
        $this->assertFileDoesNotExist(base_path('resources/views/components/site/scroll-indicator.blade.php'));
        $this->assertStringContainsString('media/yaver-studio-coverr-61.mp4', $home);
        $this->assertStringContainsString('media/yaver-studio-coverr-01.mp4', $home);
        $this->assertStringContainsString('site-service-index', $home);
        $this->assertStringContainsString('필요한 범위를 함께 정하고 바로 만듭니다.', $home);
        $this->assertStringContainsString('site-snap-content', $home);
        $this->assertStringContainsString('scroll-padding-top: var(--site-header-height)', $css);
        $this->assertStringContainsString('min-height: calc(100svh - var(--site-header-height))', $css);
        $this->assertStringContainsString('height: calc(100svh - var(--site-header-height))', $css);
        $this->assertStringNotContainsString('scroll-margin-top: var(--site-header-height)', $css);
        $this->assertStringContainsString('scroll-snap-type: y mandatory', $css);
        $this->assertStringContainsString('scroll-snap-stop: always', $css);
        $this->assertStringContainsString('site-terminal-cta', $cta);
        $this->assertStringContainsString('.site-terminal-cta', $css);
        $this->assertStringContainsString('scroll-snap-align: start', $css);
        $this->assertStringContainsString('scroll-snap-stop: normal', $css);
        $this->assertStringNotContainsString('site-snap-section', $cta);
        $this->assertStringNotContainsString('data-jarallax', $cta);
        $this->assertStringNotContainsString('function initSiteScrollLinks()', $script);
        $this->assertStringContainsString("prefers-reduced-motion: reduce", $script);
        $this->assertStringContainsString("window.jarallax(elements, 'destroy')", $script);
        $this->assertStringContainsString('video.pause()', $script);
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
import tailwindcss from '@tailwindcss/vite';
import laravel from 'laravel-vite-plugin';

export default defineConfig({
    plugins: [
        tailwindcss(),
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
import tailwindcss from '@tailwindcss/vite';
import laravel from 'laravel-vite-plugin';

export default defineConfig({
    plugins: [
        tailwindcss(),
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

    public function test_install_command_can_install_yaver_design(): void
    {
        $this->artisan('laravel-site:install', ['--design' => 'yaver'])
            ->assertExitCode(0);

        $home = File::get(base_path('resources/views/site/home.blade.php'));
        $script = File::get(base_path('resources/js/site.js'));

        $this->assertStringContainsString('설치되는 앱, 신뢰받는 사이트.', $home);
        $this->assertStringContainsString("'preset' => env('LARAVEL_SITE_PRESET', 'yaver')", File::get(base_path('config/laravel-site.php')));
        $this->assertStringContainsString('function initSiteReveals()', $script);
        $this->assertStringContainsString('prefers-reduced-motion: reduce', $script);
        $this->assertStringContainsString('focusableSelector', $script);
        $this->assertFileExists(base_path('resources/views/components/site/dropdown.blade.php'));
        $this->assertFileExists(base_path('public/media/yaver-team.webp'));
        $this->assertFileExists(base_path('public/media/yaver-app-install.webp'));
        $this->assertFileExists(base_path('public/media/yaver-web-development.webp'));
        $this->assertFileExists(base_path('design.md'));
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
            ->expectsOutput('- package-guide')
            ->expectsOutput('- portfolio-editorial')
            ->expectsOutput('- saas-product')
            ->expectsOutput('- yaver')
            ->expectsOutput('- yaver-studio')
            ->assertExitCode(0);
    }

    public function test_new_designs_can_be_applied(): void
    {
        $expectations = [
            'corporate-trust' => 'Present your company with clarity',
            'local-business' => 'Help nearby customers call',
            'clinic-clean' => 'Create a calm path',
            'package-guide' => 'Public Site',
            'portfolio-editorial' => 'Give the work room',
            'saas-product' => 'Explain the product',
            'yaver' => '설치되는 앱, 신뢰받는 사이트.',
            'yaver-studio' => '아이디어를 실제 서비스로 연결합니다.',
            'event-promo' => 'Give visitors the reason',
        ];

        foreach ($expectations as $design => $headline) {
            $this->artisan('laravel-site:design', [
                'design' => $design,
                '--force' => true,
            ])->assertExitCode(0);

            $this->assertStringContainsString($headline, File::get(base_path('resources/views/site/home.blade.php')));
        }

        $this->assertFileExists(base_path('public/media/yaver-studio-hero.mp4'));
        $this->assertFileExists(base_path('public/media/yaver-studio-coverr-61.mp4'));
        $this->assertFileExists(base_path('public/media/yaver-studio-coverr-01.mp4'));

        $this->artisan('laravel-site:design', [
            'design' => 'yaver',
            '--force' => true,
        ])->assertExitCode(0);

        $this->assertStringContainsString("'preset' => env('LARAVEL_SITE_PRESET', 'yaver')", File::get(base_path('config/laravel-site.php')));
        $this->assertFileExists(base_path('public/media/yaver-team.webp'));
        $this->assertFileExists(base_path('public/media/yaver-app-install.webp'));
        $this->assertFileExists(base_path('public/media/yaver-web-development.webp'));
    }

    public function test_designs_ship_distinct_functional_sections(): void
    {
        $expectations = [
            'conversion' => ['Lead form placeholder', 'Remove the objections'],
            'corporate-trust' => ['Company profile', 'Trust library'],
            'local-business' => ['Business hours', 'Map embed area'],
            'clinic-clean' => ['Dr. Example Name', 'Reduce anxiety'],
            'portfolio-editorial' => ['Selected work', 'Studio facts'],
            'saas-product' => ['Show the product shape early', 'Pricing'],
            'yaver' => ['앱 설치는 안내부터 시작됩니다.', '개발 사이트는 신뢰를 설명하는 도구입니다.'],
            'event-promo' => ['Event details', 'Speakers'],
            'yaver-studio' => ['필요한 범위를 함께 정하고 바로 만듭니다.', '결정이 필요한 순간마다 결과물을 확인합니다.'],
        ];

        foreach ($expectations as $design => $markers) {
            $this->artisan('laravel-site:design', [
                'design' => $design,
                '--force' => true,
            ])->assertExitCode(0);

            $home = File::get(base_path('resources/views/site/home.blade.php'));

            foreach ($markers as $marker) {
                $this->assertStringContainsString($marker, $home);
            }
        }
    }

    public function test_design_stubs_do_not_ship_tailwind_v3_configuration_patterns(): void
    {
        $forbiddenPatterns = [
            '@tailwind base',
            '@tailwind components',
            '@tailwind utilities',
            'tailwind.config',
            'content: [',
            'theme: {',
            'extend: {',
        ];

        foreach (File::allFiles(dirname(__DIR__, 2).'/designs') as $file) {
            $contents = File::get($file->getPathname());

            foreach ($forbiddenPatterns as $pattern) {
                $this->assertStringNotContainsString(
                    $pattern,
                    $contents,
                    "Unexpected Tailwind v3 pattern [{$pattern}] in {$file->getRelativePathname()}."
                );
            }
        }
    }

    public function test_design_stubs_use_tailwind_v4_css_variable_shorthand(): void
    {
        foreach (File::allFiles(dirname(__DIR__, 2).'/designs') as $file) {
            $contents = File::get($file->getPathname());

            $this->assertStringNotContainsString(
                '[var(--site-color',
                $contents,
                "Use Tailwind v4 CSS variable shorthand in {$file->getRelativePathname()}."
            );
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

    public function test_install_command_removes_single_line_starter_welcome_home_route(): void
    {
        File::ensureDirectoryExists(base_path('routes'));
        File::put(base_path('routes/web.php'), <<<'PHP'
<?php

use Illuminate\Support\Facades\Route;

Route::view('/', 'welcome')->name('home');
Route::view('/dashboard', 'dashboard')->middleware(['auth', 'verified'])->name('dashboard');
PHP);

        $this->artisan('laravel-site:install')
            ->assertExitCode(0);

        $contents = File::get(base_path('routes/web.php'));

        $this->assertStringNotContainsString("Route::view('/', 'welcome')->name('home');", $contents);
        $this->assertStringContainsString("Route::view('/dashboard', 'dashboard')->middleware(['auth', 'verified'])->name('dashboard');", $contents);
        $this->assertStringContainsString("require __DIR__.'/site.php';", $contents);
    }

    public function test_install_command_removes_multi_line_laravel_starter_welcome_route(): void
    {
        File::ensureDirectoryExists(base_path('routes'));
        File::put(base_path('routes/web.php'), <<<'PHP'
<?php

use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::view('/dashboard', 'dashboard')->middleware(['auth', 'verified'])->name('dashboard');
PHP);

        $this->artisan('laravel-site:install')
            ->assertExitCode(0);

        $contents = File::get(base_path('routes/web.php'));

        $this->assertStringNotContainsString("return view('welcome');", $contents);
        $this->assertStringContainsString("Route::view('/dashboard', 'dashboard')->middleware(['auth', 'verified'])->name('dashboard');", $contents);
        $this->assertStringContainsString("require __DIR__.'/site.php';", $contents);
    }

    public function test_install_command_removes_inertia_starter_welcome_home_route(): void
    {
        File::ensureDirectoryExists(base_path('routes'));
        File::put(base_path('routes/web.php'), <<<'PHP'
<?php

use Illuminate\Support\Facades\Route;
use Inertia\Inertia;

Route::get('/', function () {
    return Inertia::render('welcome', [
        'canLogin' => Route::has('login'),
        'canRegister' => Route::has('register'),
    ]);
})->name('home');

Route::middleware(['auth', 'verified'])->group(function () {
    Route::view('dashboard', 'dashboard')->name('dashboard');
});
PHP);

        $this->artisan('laravel-site:install')
            ->assertExitCode(0);

        $contents = File::get(base_path('routes/web.php'));

        $this->assertStringNotContainsString("Inertia::render('welcome'", $contents);
        $this->assertStringNotContainsString("->name('home')", $contents);
        $this->assertStringContainsString("Route::view('dashboard', 'dashboard')->name('dashboard');", $contents);
        $this->assertStringContainsString("require __DIR__.'/site.php';", $contents);
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

    public function test_install_command_removes_starter_home_route_and_keeps_home_route_name_available(): void
    {
        File::ensureDirectoryExists(base_path('routes'));

        File::put(base_path('routes/web.php'), "<?php\n\nuse Illuminate\\Support\\Facades\\Route;\n\nRoute::view('/', 'welcome')->name('home');\n");

        $this->artisan('laravel-site:install')
            ->assertExitCode(0);

        $routesWeb = File::get(base_path('routes/web.php'));

        $this->assertStringNotContainsString("Route::view('/', 'welcome')->name('home');", $routesWeb);
        $this->assertStringContainsString("require __DIR__.'/site.php';", $routesWeb);
        $this->assertStringContainsString("'home_name' => env('LARAVEL_SITE_HOME_NAME', 'site.home')", File::get(base_path('config/laravel-site.php')));
        $this->assertStringContainsString("->name(config('laravel-site.routes.home_name', 'site.home'))", File::get(base_path('routes/site.php')));
    }

    public function test_force_install_keeps_namespaced_site_home_route_default(): void
    {
        File::ensureDirectoryExists(base_path('routes'));

        File::put(base_path('routes/web.php'), "<?php\n\nrequire __DIR__.'/site.php';\n");
        File::put(base_path('config/laravel-site.php'), "<?php\n\nreturn ['routes' => ['home_name' => 'custom.home']];\n");
        File::put(base_path('routes/site.php'), "<?php\n\n// custom route file\n");

        $this->artisan('laravel-site:install', ['--force' => true])
            ->assertExitCode(0);

        $this->assertStringContainsString("'home_name' => env('LARAVEL_SITE_HOME_NAME', 'site.home')", File::get(base_path('config/laravel-site.php')));
        $this->assertStringContainsString("->name(config('laravel-site.routes.home_name', 'site.home'))", File::get(base_path('routes/site.php')));
    }

    public function test_install_command_keeps_welcome_route_when_site_home_path_is_not_root(): void
    {
        config(['laravel-site.routes.home_path' => '/landing']);

        File::ensureDirectoryExists(base_path('routes'));
        File::put(base_path('routes/web.php'), <<<'PHP'
<?php

use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});
PHP);

        $this->artisan('laravel-site:install')
            ->assertExitCode(0);

        $contents = File::get(base_path('routes/web.php'));

        $this->assertStringContainsString("return view('welcome');", $contents);
        $this->assertStringContainsString("require __DIR__.'/site.php';", $contents);
    }

    public function test_install_command_keeps_welcome_route_when_site_loader_already_exists(): void
    {
        File::ensureDirectoryExists(base_path('routes'));
        File::put(base_path('routes/web.php'), <<<'PHP'
<?php

use Illuminate\Support\Facades\Route;

require __DIR__.'/site.php';

Route::view('/', 'welcome')->name('home');
PHP);

        $this->artisan('laravel-site:install')
            ->assertExitCode(0);

        $contents = File::get(base_path('routes/web.php'));

        $this->assertStringContainsString("Route::view('/', 'welcome')->name('home');", $contents);
        $this->assertSame(1, substr_count($contents, "require __DIR__.'/site.php';"));
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

        $this->assertStringContainsString('Public Site', File::get(base_path('resources/views/site/home.blade.php')));
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
            base_path('public/media/yaver-studio-hero.mp4'),
            base_path('public/media/yaver-studio-coverr-61.mp4'),
            base_path('public/media/yaver-studio-coverr-01.mp4'),
            base_path('public/media/yaver-team.webp'),
            base_path('public/media/yaver-app-install.webp'),
            base_path('public/media/yaver-web-development.webp'),
            base_path('design.md'),
        ];
    }
}
