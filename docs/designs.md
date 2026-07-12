# Laravel Site Design Presets

`ssh521/laravel-site`는 런타임 빌더가 아니라 디자인 프리셋을 호스트 앱에 복사하는 패키지입니다.

이 문서는 패키지 안의 `designs/{name}` 원본을 추가하거나 수정할 때 따르는 기준입니다.

디자인 카탈로그, navigation 패턴 다양화, 별도 미리보기 앱 구축 계획은 [디자인 카탈로그 및 미리보기 사이트 작업지시서](design-catalog-preview-work-order.md)를 따릅니다.

신규 프리셋의 차별성 판정은 [Design Differentiation Contract](design-differentiation-contract.md)를 따르며, 기존 프리셋의 기준선은 [Existing Preset Audit](design-preset-audit.md)에 기록합니다.

## Why There Is No Root `design.md`

루트 `design.md`는 만들지 않습니다.

`design.md`는 `laravel-site:install` 후 호스트 앱에 생성되는 산출물입니다. 패키지 원본에서는 각 디자인 프리셋의 `design.md.stub`가 해당 역할을 합니다.

```text
designs/package-guide/design.md.stub  ->  host-app/design.md
designs/essential/design.md.stub      ->  host-app/design.md
```

패키지 레벨의 디자인 제작 기준은 이 파일(`docs/designs.md`)에 둡니다.

## Preset Directory Contract

각 디자인은 가능한 한 완결된 public site 표면을 제공해야 합니다.

```text
designs/{name}/
├── config/laravel-site.php.stub
├── design.md.stub
├── resources/css/site.css.stub
├── resources/js/site.js.stub
├── resources/views/site/home.blade.php.stub
├── resources/views/components/layouts/site.blade.php.stub
└── resources/views/components/site/*.blade.php.stub
```

미디어 자산이 필요한 디자인은 `public/media/...` 아래에 포함합니다.

## Preset Responsibilities

각 프리셋은 다음을 명확히 제공해야 합니다.

- 첫 화면의 목적과 대상 고객
- header, mobile menu, footer
- hero, CTA, 주요 섹션 구성
- CSS 변수 기반 색상/톤
- public 전용 JS hook
- 호스트 앱에 복사될 `design.md` AI/developer reference

## Existing Presets

| Design | Purpose |
| --- | --- |
| `package-guide` | 기본 설치 화면, 패키지 설명 및 설치/추가 방법 안내 |
| `essential` | 범용 회사/서비스 소개형 |
| `conversion` | 광고 유입, 상담 신청, 문의 전환형 |
| `corporate-trust` | B2B 회사, 제조, 전문 서비스 신뢰형 |
| `local-business` | 식당, 학원, 미용실, 오프라인 매장형 |
| `clinic-clean` | 병원, 상담센터, 법률/세무/노무 전문직형 |
| `portfolio-editorial` | 스튜디오, 작가, 브랜드 포트폴리오형 |
| `saas-product` | SaaS, 앱, API, 디지털 제품 소개형 |
| `event-promo` | 세미나, 강의, 컨퍼런스, 단기 프로모션형 |
| `yaver` | 앱 설치 안내와 개발 사이트 소개를 위한 절제된 디지털 제작사형 |
| `yaver-studio` | yaver.com 스타일의 스튜디오/디지털 제작사 소개형 |

## Adding A Preset

1. 새 디렉터리를 `designs/{name}`에 만든다.
2. 기존 프리셋 중 가장 가까운 것을 복사해서 시작한다.
3. `config/laravel-site.php.stub`의 preset/name/menus를 새 디자인에 맞춘다.
4. `design.md.stub`에 목적, 토큰, 컴포넌트, AI 제작 기준을 적는다.
5. `resources/css/site.css.stub`는 Tailwind CSS v4와 CSS 변수 중심으로 유지한다.
6. `resources/js/site.js.stub`는 public site 동작만 담는다.
7. `README.md`의 디자인 목록과 명령 예시를 갱신한다.
8. 필요하면 `tests/Feature/InstallCommandTest.php`에 설치 검증을 추가한다.

## Default Design

기본 설치 디자인은 `src/Support/DesignLibrary.php`의 `defaultDesign()`이 결정합니다.

현재 기본값은 `package-guide`입니다. Laravel Starter Kit 설치 직후 사용자가 패키지 설명과 다음 단계 안내를 볼 수 있게 하기 위한 선택입니다.

기본값을 바꿀 때는 다음을 함께 확인합니다.

- `README.md` 설치 설명
- `config/laravel-site.php`
- `tests/Feature/InstallCommandTest.php`
- `DesignLibrary::defaultDesign()`

## Verification

프리셋 변경 후 최소 검증:

```bash
php -l src/Support/DesignLibrary.php
php -l src/Console/Commands/InstallCommand.php
php -l config/laravel-site.php
git diff --check
/Users/ssh521/Projects/Packagist/adminTest/vendor/bin/phpunit --configuration phpunit.xml.dist
```
