<?php

return [
    'name' => 'yaver-studio',
    'label' => 'Yaver Studio',
    'summary' => '영상과 한 화면 스크롤을 사용하는 디지털 제작 스튜디오 사이트',
    'categories' => ['agency', 'studio', 'service'],
    'styles' => ['cinematic', 'dark', 'immersive'],
    'language' => 'ko',
    'theme' => 'dark',
    'accent' => 'purple',
    'density' => 3,
    'motion' => 8,
    'variance' => 9,
    'navigation' => ['desktop' => 'desktop-offcanvas', 'mobile' => 'fullscreen-takeover'],
    'hero' => 'full-bleed-video',
    'sections' => ['video-service', 'video-process', 'proof-grid', 'contact-cta'],
    'preview' => ['path' => 'previews/yaver-studio', 'thumbnail' => 'screenshots/yaver-studio/desktop.webp'],
];
