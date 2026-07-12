<?php

return [
    'name' => 'app-launch',
    'label' => 'App Launch',
    'summary' => '앱 화면과 사용 장면으로 설치 행동을 이끄는 한국어 소비자 앱 랜딩',
    'categories' => ['app', 'consumer', 'product'],
    'styles' => ['editorial', 'bright', 'product-showcase'],
    'language' => 'ko',
    'theme' => 'light',
    'accent' => 'coral',
    'density' => 4,
    'motion' => 6,
    'variance' => 8,
    'navigation' => ['desktop' => 'compact-floating', 'mobile' => 'bottom-action-sheet'],
    'hero' => 'asymmetric-device-showcase',
    'sections' => ['screen-story', 'feature-index', 'lifestyle-scene', 'testimonial', 'faq', 'install-cta'],
    'preview' => ['path' => 'previews/app-launch', 'thumbnail' => 'screenshots/app-launch/desktop.webp'],
];
