<?php

return [
    'name' => 'local-business',
    'label' => 'Local Business',
    'summary' => '방문, 전화, 예약이 중요한 오프라인 매장용 사이트',
    'categories' => ['local', 'store', 'service'],
    'styles' => ['friendly', 'practical', 'local'],
    'language' => 'en',
    'theme' => 'light',
    'accent' => 'green',
    'density' => 5,
    'motion' => 2,
    'variance' => 3,
    'navigation' => ['desktop' => 'classic-horizontal', 'mobile' => 'right-drawer'],
    'hero' => 'local-action',
    'sections' => ['service-grid', 'business-hours', 'map-area', 'contact-cta'],
    'preview' => ['path' => 'previews/local-business', 'thumbnail' => 'screenshots/local-business/desktop.webp'],
];
