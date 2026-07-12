<?php

return [
    'name' => 'event-promo',
    'label' => 'Event Promo',
    'summary' => '세미나, 강의, 컨퍼런스 등록을 위한 단기 프로모션 사이트',
    'categories' => ['event', 'campaign', 'education'],
    'styles' => ['promotional', 'bold', 'focused'],
    'language' => 'en',
    'theme' => 'light',
    'accent' => 'orange',
    'density' => 5,
    'motion' => 4,
    'variance' => 7,
    'navigation' => ['desktop' => 'transparent-overlay', 'mobile' => 'header-dropdown'],
    'hero' => 'event-summary',
    'sections' => ['event-details', 'speaker-grid', 'schedule', 'registration-cta'],
    'preview' => ['path' => 'previews/event-promo', 'thumbnail' => 'screenshots/event-promo/desktop.webp'],
];
