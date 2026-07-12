<?php

return [
    'name' => 'essential',
    'label' => 'Essential',
    'summary' => '범용 회사와 서비스 소개에 사용하는 기본 public site',
    'categories' => ['corporate', 'service', 'general'],
    'styles' => ['minimal', 'neutral', 'general'],
    'language' => 'en',
    'theme' => 'light',
    'accent' => 'indigo',
    'density' => 4,
    'motion' => 2,
    'variance' => 3,
    'navigation' => ['desktop' => 'classic-horizontal', 'mobile' => 'right-drawer'],
    'hero' => 'asymmetric-media',
    'sections' => ['feature-grid', 'service-list', 'content-split', 'contact-cta'],
    'preview' => ['path' => 'previews/essential', 'thumbnail' => 'screenshots/essential/desktop.webp'],
];
