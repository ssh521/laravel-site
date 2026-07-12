<?php

return [
    'name' => 'saas-product',
    'label' => 'SaaS Product',
    'summary' => 'SaaS, 앱, API와 디지털 제품의 기능을 소개하는 제품 랜딩',
    'categories' => ['saas', 'app', 'product'],
    'styles' => ['product', 'technical', 'clean'],
    'language' => 'en',
    'theme' => 'light',
    'accent' => 'indigo',
    'density' => 5,
    'motion' => 4,
    'variance' => 7,
    'navigation' => ['desktop' => 'transparent-overlay', 'mobile' => 'bottom-sheet'],
    'hero' => 'product-device',
    'sections' => ['product-preview', 'feature-grid', 'pricing', 'trial-cta'],
    'preview' => ['path' => 'previews/saas-product', 'thumbnail' => 'screenshots/saas-product/desktop.webp'],
];
