<?php

return [
    'name' => 'corporate-trust',
    'label' => 'Corporate Trust',
    'summary' => 'B2B 기업과 전문 서비스의 정보를 안정적으로 전달하는 회사형 사이트',
    'categories' => ['corporate', 'b2b', 'service'],
    'styles' => ['corporate', 'structured', 'trust'],
    'language' => 'en',
    'theme' => 'light',
    'accent' => 'navy',
    'density' => 6,
    'motion' => 2,
    'variance' => 3,
    'navigation' => ['desktop' => 'two-tier-corporate', 'mobile' => 'accordion-drawer'],
    'hero' => 'asymmetric-media',
    'sections' => ['company-profile', 'capability-grid', 'trust-library', 'contact-cta'],
    'preview' => ['path' => 'previews/corporate-trust', 'thumbnail' => 'screenshots/corporate-trust/desktop.webp'],
];
