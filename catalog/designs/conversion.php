<?php

return [
    'name' => 'conversion',
    'label' => 'Conversion',
    'summary' => '광고 유입과 상담 신청을 빠르게 연결하는 전환형 랜딩',
    'categories' => ['campaign', 'landing', 'service'],
    'styles' => ['focused', 'direct', 'conversion'],
    'language' => 'en',
    'theme' => 'light',
    'accent' => 'blue',
    'density' => 5,
    'motion' => 2,
    'variance' => 3,
    'navigation' => ['desktop' => 'classic-horizontal', 'mobile' => 'right-drawer'],
    'hero' => 'conversion-form',
    'sections' => ['benefit-grid', 'objection-list', 'lead-form', 'contact-cta'],
    'preview' => ['path' => 'previews/conversion', 'thumbnail' => 'screenshots/conversion/desktop.webp'],
];
