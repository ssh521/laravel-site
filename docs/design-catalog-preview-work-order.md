# Laravel Site 디자인 카탈로그 및 미리보기 사이트 작업지시서

## 1. 문서 목적

이 문서는 `ssh521/laravel-site`를 다양한 고객용 public website 프리셋을 지속적으로 생산할 수 있는 디자인 카탈로그로 확장하고, 각 프리셋을 데스크톱·태블릿·모바일에서 확인할 수 있는 별도 미리보기 사이트를 구축하기 위한 작업지시서다.

단순히 프리셋 수를 늘리는 것이 아니라 다음 문제를 해결하는 것을 목표로 한다.

- 기존 프리셋 사이의 시각적·구조적 차이가 작다.
- 데스크톱 header와 모바일 메뉴가 비슷한 형태로 반복된다.
- 업종 이름은 다르지만 hero, 카드, CTA 리듬이 유사하다.
- 설치 전 디자인을 비교할 공식 미리보기 화면이 없다.
- 새 디자인이 기존 프리셋과 얼마나 다른지 판단하는 기준이 없다.

## 2. 저장소 및 패키지 경계

### 2.1 `laravel-site`가 소유하는 범위

- 설치 가능한 public site 디자인 프리셋
- 디자인 카탈로그 메타데이터
- 프리셋 제작용 navigation, hero, section 패턴 원본
- 프리셋 설치·교체 command
- 프리셋 계약 및 검증 테스트

### 2.2 `laravel-site`가 소유하지 않는 범위

- 관리자 화면
- 인증 화면
- CMS CRUD
- 런타임 drag-and-drop 페이지 빌더
- 고객이 운영 중인 사이트에서 즉시 조합하는 테마 편집기

관리자와 콘텐츠 운영 기능은 기존 `ssh521/laravel-admin` 및 기능 패키지가 담당한다.

### 2.3 미리보기 사이트 경계

미리보기 사이트는 패키지 자체에 런타임 기능으로 포함하지 않고 별도 Laravel 앱으로 구축한다.

권장 프로젝트:

```text
/Users/ssh521/Projects/Packagist/laravel-site-preview
```

권장 패키지 역할:

```text
laravel-site          프리셋, 패턴, 카탈로그 메타데이터 소유
laravel-site-preview  프리셋 빌드, 목록, 검색, iframe preview, 스크린샷 소유
adminTest             패키지 통합 및 실제 설치 검증
```

## 3. 핵심 원칙

1. 최종 프리셋은 계속 `designs/{name}` 아래에 완전한 형태로 둔다.
2. 호스트 앱에 설치된 결과는 외부 패턴 파일 없이 독립적으로 수정 가능해야 한다.
3. 패턴 라이브러리는 프리셋 제작용이며 런타임 페이지 빌더가 아니다.
4. 새 프리셋은 색상이나 문구만 바꾼 기존 프리셋이 되어서는 안 된다.
5. 데스크톱 navigation과 모바일 navigation을 각각 독립적인 디자인 축으로 관리한다.
6. 모든 프리셋은 Laravel Blade, Tailwind CSS v4, vanilla JavaScript를 기본으로 한다.
7. 기존 Laravel Starter Kit 인증 화면은 수정하지 않는다.
8. 기본 설치 디자인은 별도 요청 전까지 `package-guide`를 유지한다.
9. 루트 `design.md`를 만들지 않는다. 호스트 앱용 문서는 각 프리셋의 `design.md.stub`에 둔다.
10. 실제 설치 파일과 미리보기 결과가 다르면 실제 설치 결과를 기준으로 수정한다.

## 4. 목표 산출물

### 4.1 패키지 저장소

```text
laravel-site/
├── catalog/
│   └── designs/
│       ├── package-guide.php
│       ├── essential.php
│       └── {design-name}.php
├── designs/
│   └── {design-name}/
│       ├── config/laravel-site.php.stub
│       ├── design.md.stub
│       ├── public/media/*
│       └── resources/...
├── patterns/
│   ├── navigation/
│   │   ├── desktop/
│   │   └── mobile/
│   ├── hero/
│   └── sections/
├── docs/
│   ├── designs.md
│   ├── design-catalog-preview-work-order.md
│   └── design-differentiation-contract.md
└── src/Support/
    ├── DesignLibrary.php
    └── DesignCatalog.php
```

`catalog/`과 `patterns/`는 호스트 앱에 복사하지 않는다.

### 4.2 미리보기 앱

```text
laravel-site-preview/
├── app/Console/Commands/BuildDesignPreviews.php
├── app/Services/DesignPreviewBuilder.php
├── resources/views/designs/index.blade.php
├── resources/views/designs/show.blade.php
├── public/previews/{design-name}/
├── public/screenshots/{design-name}/
└── tests/Feature/DesignCatalogTest.php
```

## 5. 디자인 카탈로그 메타데이터 계약

프리셋 설치 디렉터리 안에 카탈로그 파일을 넣으면 호스트 앱으로 복사될 수 있으므로, 메타데이터는 `catalog/designs/{name}.php`에서 관리한다.

예시:

```php
<?php

return [
    'name' => 'yaver',
    'label' => 'Yaver Digital Studio',
    'summary' => '앱 설치 안내와 개발 사이트 소개를 위한 디지털 제작사형',
    'categories' => ['app', 'agency', 'service'],
    'styles' => ['minimal', 'technical', 'trust'],
    'language' => 'ko',
    'theme' => 'auto',
    'accent' => 'cobalt',
    'density' => 4,
    'motion' => 4,
    'variance' => 6,
    'navigation' => [
        'desktop' => 'classic-horizontal',
        'mobile' => 'right-drawer',
    ],
    'hero' => 'asymmetric-media',
    'sections' => [
        'trust-strip',
        'service-split',
        'asymmetric-process',
        'contact-cta',
    ],
    'preview' => [
        'path' => 'previews/yaver',
        'thumbnail' => 'screenshots/yaver/desktop.webp',
    ],
];
```

### 5.1 필수 필드

- `name`
- `label`
- `summary`
- `categories`
- `styles`
- `language`
- `theme`
- `navigation.desktop`
- `navigation.mobile`
- `hero`
- `sections`
- `preview.path`
- `preview.thumbnail`

### 5.2 `DesignCatalog` 책임

- 모든 프리셋의 메타데이터 조회
- 이름, 카테고리, 스타일, navigation 유형별 필터
- `DesignLibrary::names()`와 catalog 항목의 일치 여부 검증
- 미리보기 앱에서 소비할 배열 또는 JSON 제공
- 존재하지 않는 프리셋이나 중복 이름 거부

### 5.3 CLI 확장 후보

```bash
php artisan laravel-site:design --list
php artisan laravel-site:design --list --json
php artisan laravel-site:design:info yaver
```

기존 command 동작은 깨지지 않아야 한다.

## 6. 디자인 차별성 계약

새 프리셋은 기존 프리셋과 최소 5개 항목에서 명확히 달라야 한다.

1. 데스크톱 navigation
2. 모바일 navigation
3. hero 구성
4. 타이포그래피 성격
5. 색상과 표면 재질
6. 섹션 리듬
7. 이미지 방향
8. CTA 구성
9. 콘텐츠 밀도
10. 모션 방식

색상, 업종명, 문구만 변경한 프리셋은 신규 디자인으로 인정하지 않는다.

신규 프리셋 PR 또는 작업 보고에는 다음 비교표를 포함한다.

| 비교 항목 | 신규 프리셋 | 가장 가까운 기존 프리셋 | 차이 |
| --- | --- | --- | --- |
| Desktop nav |  |  |  |
| Mobile nav |  |  |  |
| Hero |  |  |  |
| Typography |  |  |  |
| Color/material |  |  |  |
| Section rhythm |  |  |  |
| Motion |  |  |  |

## 7. Navigation 패턴 작업

### 7.1 데스크톱 필수 패턴

| ID | 구조 | 권장 용도 |
| --- | --- | --- |
| `classic-horizontal` | 왼쪽 로고, 가로 메뉴, 오른쪽 CTA | 범용 회사·서비스 |
| `centered-logo-split` | 중앙 로고, 좌우 분할 메뉴 | 패션·브랜드·스튜디오 |
| `transparent-overlay` | hero 위 투명 header, 스크롤 후 표면 표시 | 앱·숙박·이벤트 |
| `desktop-offcanvas` | 데스크톱에서도 메뉴 버튼과 전체 화면 메뉴 사용 | 스튜디오·포트폴리오 |
| `sidebar-rail` | 왼쪽 또는 오른쪽 고정 세로 메뉴 | 포트폴리오·에디토리얼 |
| `two-tier-corporate` | utility bar와 주요 메뉴 분리 | 제조·법인·기관 |

후속 후보:

- `mega-menu`
- `floating-island`
- `bottom-floating`
- `section-index`

### 7.2 모바일 필수 패턴

| ID | 구조 | 권장 용도 |
| --- | --- | --- |
| `right-drawer` | 오른쪽에서 들어오는 패널 | 범용 |
| `fullscreen-takeover` | 전체 화면 메뉴 | 스튜디오·브랜드 |
| `bottom-sheet` | 화면 아래에서 올라오는 메뉴 | 앱·모바일 서비스 |
| `header-dropdown` | header 아래로 펼쳐지는 compact 메뉴 | 메뉴가 적은 사이트 |
| `accordion-drawer` | 하위 메뉴를 접고 펴는 drawer | 기업·다중 메뉴 |
| `push-content` | 메뉴가 본문을 밀어내는 구조 | 에디토리얼·포트폴리오 |

### 7.3 공통 접근성 계약

모든 navigation 패턴은 다음을 만족해야 한다.

- 키보드로 모든 링크 접근 가능
- 현재 메뉴의 `aria-current` 지원
- 열기 버튼의 `aria-expanded`와 `aria-controls` 제공
- Escape 닫기
- 메뉴가 닫힌 뒤 열기 버튼으로 포커스 복귀
- modal 성격의 메뉴는 포커스 트랩 제공
- backdrop 클릭 닫기
- body scroll lock과 복구
- reduced motion 대응
- 320px 이상의 모바일 폭에서 가로 스크롤 없음
- 데스크톱 navigation 한 줄 유지
- 최대 header 높이 규칙 문서화

### 7.4 패턴 소스 규칙

각 navigation 패턴 디렉터리는 다음 내용을 포함한다.

```text
patterns/navigation/{desktop|mobile}/{pattern-name}/
├── README.md
├── header.blade.php.stub 또는 mobile-menu.blade.php.stub
├── site.css.stub
├── site.js.stub
└── test-contract.md
```

패턴은 그대로 설치하지 않는다. 새 프리셋 제작 시 선택한 패턴을 프리셋 안에 복사하고 디자인에 맞게 수정한다.

## 8. Hero 및 Section 패턴 작업

### 8.1 Hero 필수 패턴

- `asymmetric-media`
- `editorial-type`
- `full-bleed-image`
- `full-bleed-video`
- `product-device`
- `split-service`
- `case-study-led`
- `conversion-form`

### 8.2 Section 필수 패턴

- 서비스 인덱스
- 사례 소개
- 이미지 갤러리
- 단계형 프로세스
- 타임라인
- 비교 영역
- 후기·신뢰 근거
- 가격·패키지
- 위치·영업 정보
- 이벤트 일정
- FAQ
- 문의 CTA

한 페이지에서 같은 layout family를 반복하지 않는다. 각 프리셋은 최소 4개 이상의 서로 다른 section layout family를 사용한다.

## 9. 기존 프리셋 감사 작업

### 9.1 감사 대상

- `package-guide`
- `essential`
- `conversion`
- `corporate-trust`
- `local-business`
- `clinic-clean`
- `portfolio-editorial`
- `saas-product`
- `event-promo`
- `yaver`
- `yaver-studio`

### 9.2 감사 항목

각 프리셋별로 다음 표를 작성한다.

| 항목 | 값 |
| --- | --- |
| 대상 업종 |  |
| 스타일 |  |
| Desktop nav |  |
| Mobile nav |  |
| Hero |  |
| Section families |  |
| Theme |  |
| Accent |  |
| Typography |  |
| Motion |  |
| 가장 유사한 프리셋 |  |
| 유지·개선·통합 판단 |  |

### 9.3 처리 원칙

- 기존 프리셋은 즉시 삭제하거나 이름을 변경하지 않는다.
- 차이가 약한 프리셋은 기존 설치 호환성을 유지하면서 개선한다.
- 완전히 새로운 방향은 기존 프리셋 덮어쓰기보다 새 이름으로 추가한다.
- deprecated 처리가 필요하면 최소 한 번의 minor release 동안 문서에 안내한다.

## 10. 미리보기 사이트 요구사항

### 10.1 디자인 목록

- 대표 screenshot 카드
- 디자인 이름과 한 줄 설명
- 업종 필터
- 스타일 필터
- desktop navigation 필터
- mobile navigation 필터
- light, dark, auto theme 필터
- 한국어·영어 필터 확장 가능 구조
- 설치 명령 복사

### 10.2 디자인 상세

- 전체 화면 미리보기
- desktop, tablet, mobile viewport 전환
- light, dark 모드 전환
- 사용된 navigation, hero, section 정보
- 색상 token 미리보기
- 주요 breakpoint 정보
- 설치 명령
- 관련 디자인 추천

### 10.3 미리보기 표시 방식

정적 preview를 iframe으로 표시하는 방식을 기본으로 한다.

이유:

- 모든 프리셋이 같은 `x-site.*` component 이름을 사용한다.
- 한 Laravel 요청에서 여러 프리셋의 component와 config를 동시에 전환하면 충돌 가능성이 높다.
- 실제 설치·빌드 결과를 그대로 보여줄 수 있다.
- CDN 또는 정적 hosting으로 배포하기 쉽다.

### 10.4 정적 preview 빌드 흐름

```text
DesignCatalog에서 프리셋 목록 조회
    ↓
프리셋별 임시 Laravel Starter Kit 작업공간 생성 또는 초기화
    ↓
laravel-site:install --design={name} --force
    ↓
Vite production build
    ↓
Playwright로 실제 페이지 렌더링
    ↓
정적 HTML과 필요한 public 자산 수집
    ↓
public/previews/{name}/ 생성
    ↓
390px, 820px, 1440px screenshot 생성
    ↓
catalog index 갱신
```

### 10.5 preview route 제안

```text
GET /designs
GET /designs/{design}
GET /previews/{design}/
```

query string은 catalog UI 상태에만 사용한다.

```text
/designs?category=app&nav=bottom-sheet
/designs/yaver?viewport=mobile&theme=dark
```

## 11. 신규 대표 프리셋 후보

첫 확장에서는 업종만 다른 디자인보다 시각 언어가 확실히 다른 프리셋을 우선한다.

| 이름 | 핵심 스타일 | Desktop nav | Mobile nav |
| --- | --- | --- | --- |
| `app-launch` | 제품 장치 중심, 선명한 제품 소개 | transparent overlay | bottom sheet |
| `swiss-corporate` | 강한 그리드와 타이포그래피 | two-tier corporate | accordion drawer |
| `studio-cinematic` | full-bleed media와 큰 여백 | desktop offcanvas | fullscreen takeover |
| `portfolio-sidebar` | 작업 중심 비정형 갤러리 | sidebar rail | push content |
| `editorial-service` | 콘텐츠 중심 에디토리얼 | centered logo split | header dropdown |
| `technical-industrial` | 제조·기술·사양 중심 | mega menu | accordion drawer |

첫 milestone에서는 `app-launch`, `swiss-corporate`, `studio-cinematic` 3개를 우선한다.

## 12. 단계별 작업 순서

### Phase 0. 기준선 확보

작업:

- 기존 프리셋 11개의 desktop, tablet, mobile screenshot 생성
- 현재 navigation, hero, section 유형 표 작성
- 중복 구조와 차별점 기록
- package 및 `adminTest`의 현재 테스트 결과 기록

완료 조건:

- 모든 기존 프리셋에 3개 viewport screenshot이 있다.
- 가장 유사한 프리셋 쌍과 중복 이유가 문서화되어 있다.

### Phase 1. DesignCatalog 구현

작업:

- `catalog/designs/*.php` 스키마 확정
- 기존 프리셋 전체 metadata 작성
- `DesignCatalog` 구현
- list JSON 및 info command 검토
- metadata와 design directory 일치 테스트 추가

완료 조건:

- catalog 항목 누락 및 중복이 테스트에서 실패한다.
- 기존 install 및 design command 테스트가 그대로 통과한다.

### Phase 2. Navigation 패턴 라이브러리

작업:

- desktop 6개 패턴 구현
- mobile 6개 패턴 구현
- 공통 접근성 테스트 항목 작성
- 각 패턴의 사용 대상과 금지 조건 문서화

완료 조건:

- 각 패턴이 독립적인 Blade, CSS, JS 예제를 가진다.
- mobile menu는 키보드, Escape, focus restore가 검증된다.
- 최소 6개 패턴이 실제 브라우저에서 서로 다르게 보인다.

### Phase 3. 기존 프리셋 다양화

작업:

- 감사 결과에 따라 기존 프리셋 navigation과 hero 개선
- 설치 호환성을 깨지 않는 범위에서 section rhythm 조정
- 모든 catalog metadata 갱신

완료 조건:

- 색상과 문구만 다른 프리셋 조합이 남지 않는다.
- 각 프리셋의 navigation 또는 hero가 최소 하나 이상 고유한 계열을 가진다.

### Phase 4. Preview 앱 구축

작업:

- 별도 Laravel Starter Kit 앱 생성
- package path repository 연결
- catalog index와 detail 구현
- responsive iframe controls 구현
- preview build command 구현
- 정적 preview 및 screenshot 생성

완료 조건:

- 모든 프리셋을 목록에서 검색·필터할 수 있다.
- desktop, tablet, mobile 전환이 가능하다.
- light, dark 지원 프리셋은 theme 전환이 가능하다.
- 설치 명령을 복사할 수 있다.

### Phase 5. 신규 대표 프리셋

작업:

- `app-launch` (완료)
- `swiss-corporate`
- `studio-cinematic`
- README, docs, catalog, tests 갱신

완료 조건:

- 신규 프리셋마다 차별성 비교표가 있다.
- 실제 `adminTest` 설치와 preview 앱 렌더링이 모두 통과한다.

### Phase 6. 자동화 및 배포

작업:

- catalog validation 자동화
- preview build 자동화
- screenshot 갱신 자동화
- 정적 preview 배포 workflow 작성

완료 조건:

- 새 프리셋 추가 시 catalog 누락을 CI가 감지한다.
- preview와 screenshot을 한 명령으로 재생성할 수 있다.
- 배포된 preview와 package version 또는 commit을 연결할 수 있다.

## 13. 테스트 및 검증 계약

### 13.1 패키지 테스트

- 모든 catalog 이름이 실제 `designs/{name}` 디렉터리와 일치
- 모든 design directory에 필수 파일 존재
- 모든 catalog 항목에 필수 metadata 존재
- `laravel-site:install --design={name}` 성공
- `laravel-site:design {name} --force` 성공
- catalog 파일이 호스트 앱으로 복사되지 않음
- 기본 디자인 `package-guide` 유지
- Tailwind v3 패턴 금지

### 13.2 브라우저 검증

viewport:

- mobile: 390x844
- tablet: 820x1180
- desktop: 1440x900

확인 항목:

- header와 hero 초기 화면
- navigation 열기·닫기
- 키보드 포커스
- Escape 닫기
- 가로 스크롤 여부
- CTA 줄바꿈
- light·dark 대비
- reduced motion
- 이미지 CLS
- 콘솔 오류

### 13.3 필수 명령

```bash
php -l src/Support/DesignLibrary.php
php -l src/Support/DesignCatalog.php
php -l src/Console/Commands/InstallCommand.php
php -l config/laravel-site.php
git diff --check
/Users/ssh521/Projects/Packagist/adminTest/vendor/bin/phpunit --configuration phpunit.xml.dist
```

## 14. 완료 정의

전체 작업은 다음 조건을 모두 만족할 때 완료한다.

- 프리셋과 catalog metadata가 일치한다.
- 최소 6개의 desktop navigation 계열이 있다.
- 최소 6개의 mobile navigation 계열이 있다.
- 기존 프리셋의 중복 구조가 감사·개선되었다.
- preview 앱에서 모든 프리셋을 비교할 수 있다.
- 3개 viewport screenshot이 자동 생성된다.
- 신규 프리셋 3개가 기존 디자인과 명확히 구분된다.
- 기본 설치 디자인은 `package-guide`로 유지된다.
- 관리자, 인증, CMS CRUD가 `laravel-site`에 추가되지 않는다.
- package와 preview 앱 검증이 모두 통과한다.

## 15. 작업 단위 및 커밋 권장안

변경 범위가 크므로 다음 단위로 분리한다.

1. `docs: define design catalog and preview contracts`
2. `feat: add design catalog metadata`
3. `feat: add navigation pattern library`
4. `refactor: diversify existing design presets`
5. `feat: build laravel-site preview app`
6. `feat: add first distinct design set`
7. `ci: automate preview and screenshot builds`

패키지와 preview 앱은 서로 다른 저장소에서 각각 커밋한다.

## 16. 결정 필요 항목

다음 항목은 Phase 4 착수 전 확정한다.

### 16.1 Preview 앱 저장소 이름

권장안:

```text
ssh521/laravel-site-preview
```

대안:

- `ssh521/laravel-site-showcase`
- `ssh521/laravel-site-gallery`

### 16.2 Preview 공개 주소

권장안:

```text
site-preview.yaver.net
```

실제 운영 도메인이 없다면 초기에는 로컬 Herd와 GitHub Actions artifact만 사용한다.

### 16.3 기존 프리셋 변경 전략

권장안:

- URL과 design name은 유지한다.
- 약한 디자인은 점진적으로 개선한다.
- 큰 시각 변경은 새 프리셋으로 추가한다.

### 16.4 Preview 빌드 저장 방식

권장안:

- 생성된 static preview와 screenshot은 preview 앱이 소유한다.
- `laravel-site` 패키지에는 원본 프리셋과 metadata만 둔다.
- CI artifact와 배포 결과는 preview 앱에서 관리한다.

## 17. 첫 실행 작업

다음 작업부터 시작한다.

1. 기존 프리셋 11개 screenshot 기준선 생성
2. `docs/design-differentiation-contract.md` 작성
3. `catalog/designs/*.php` schema prototype 작성
4. 기존 프리셋 감사표 작성
5. navigation pattern 12개 상세 사양 작성

이 5개 작업이 완료되기 전에는 신규 프리셋을 대량 추가하지 않는다.
