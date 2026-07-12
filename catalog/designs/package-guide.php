<?php

return [
    'name' => 'package-guide',
    'label' => 'Package Guide',
    'summary' => 'Laravel Site 설치 직후 패키지 사용법과 확장 경로를 설명하는 기본 화면',
    'categories' => ['package', 'documentation', 'developer'],
    'styles' => ['documentation', 'technical', 'neutral'],
    'language' => 'ko',
    'theme' => 'light',
    'accent' => 'red',
    'density' => 6,
    'motion' => 2,
    'variance' => 3,
    'navigation' => ['desktop' => 'classic-horizontal', 'mobile' => 'right-drawer'],
    'hero' => 'package-introduction',
    'sections' => ['package-overview', 'install-guide', 'file-map', 'design-list'],
    'preview' => ['path' => 'previews/package-guide', 'thumbnail' => 'screenshots/package-guide/desktop.webp'],
];
