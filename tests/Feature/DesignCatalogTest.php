<?php

namespace Ssh521\LaravelSite\Tests\Feature;

use Illuminate\Support\Facades\File;
use Ssh521\LaravelSite\Support\DesignCatalog;
use Ssh521\LaravelSite\Support\DesignLibrary;
use Ssh521\LaravelSite\Tests\TestCase;

class DesignCatalogTest extends TestCase
{
    public function test_catalog_entries_match_design_directories(): void
    {
        $catalog = app(DesignCatalog::class);
        $library = app(DesignLibrary::class);

        $catalog->assertMatches($library);

        $this->assertSame($library->names(), $catalog->names());
    }

    public function test_catalog_entries_include_preview_and_navigation_metadata(): void
    {
        foreach (app(DesignCatalog::class)->all() as $design) {
            $this->assertNotEmpty($design['navigation']['desktop']);
            $this->assertNotEmpty($design['navigation']['mobile']);
            $this->assertNotEmpty($design['preview']['path']);
            $this->assertNotEmpty($design['preview']['thumbnail']);
            $this->assertNotEmpty($design['sections']);
        }
    }

    public function test_catalog_can_find_and_filter_designs(): void
    {
        $catalog = app(DesignCatalog::class);
        $yaver = $catalog->find('yaver');

        $this->assertSame('auto', $yaver['theme']);
        $this->assertSame('bottom-sheet', $yaver['navigation']['mobile']);

        $appDesigns = $catalog->filter(['category' => 'app', 'language' => 'ko']);

        $this->assertContains('yaver', array_column($appDesigns, 'name'));
    }

    public function test_diversified_presets_use_distinct_navigation_pairs(): void
    {
        $catalog = app(DesignCatalog::class);
        $expected = [
            'portfolio-editorial' => ['sidebar-rail', 'push-content'],
            'corporate-trust' => ['two-tier-corporate', 'accordion-drawer'],
            'saas-product' => ['transparent-overlay', 'bottom-sheet'],
            'yaver-studio' => ['desktop-offcanvas', 'fullscreen-takeover'],
            'event-promo' => ['transparent-overlay', 'header-dropdown'],
            'yaver' => ['centered-logo-split', 'bottom-sheet'],
        ];

        foreach ($expected as $name => [$desktop, $mobile]) {
            $design = $catalog->find($name);

            $this->assertSame($desktop, $design['navigation']['desktop']);
            $this->assertSame($mobile, $design['navigation']['mobile']);
        }
    }

    public function test_navigation_pattern_library_has_complete_sources(): void
    {
        $patterns = [
            'desktop' => ['classic-horizontal', 'centered-logo-split', 'transparent-overlay', 'desktop-offcanvas', 'sidebar-rail', 'two-tier-corporate'],
            'mobile' => ['right-drawer', 'fullscreen-takeover', 'bottom-sheet', 'header-dropdown', 'accordion-drawer', 'push-content'],
        ];

        foreach ($patterns as $type => $names) {
            foreach ($names as $name) {
                $root = dirname(__DIR__, 2)."/patterns/navigation/{$type}/{$name}";
                $component = $type === 'desktop' ? 'header.blade.php.stub' : 'mobile-menu.blade.php.stub';

                foreach (['README.md', $component, 'site.css.stub', 'site.js.stub', 'test-contract.md'] as $file) {
                    $this->assertTrue(File::exists("{$root}/{$file}"), "Missing navigation pattern source: {$type}/{$name}/{$file}");
                }
            }
        }
    }
}
