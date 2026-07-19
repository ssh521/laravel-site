# ssh521/laravel-site

[![Latest Version on Packagist](https://img.shields.io/packagist/v/ssh521/laravel-site.svg?style=flat-square)](https://packagist.org/packages/ssh521/laravel-site)
[![Total Downloads](https://img.shields.io/packagist/dt/ssh521/laravel-site.svg?style=flat-square)](https://packagist.org/packages/ssh521/laravel-site)
[![License](https://img.shields.io/packagist/l/ssh521/laravel-site.svg?style=flat-square)](LICENSE)

Laravel Starter Kit 애플리케이션에 편집 가능한 반응형 공개 사이트를 설치하는 디자인 프리셋 패키지입니다.

런타임 페이지 빌더가 아니라, 선택한 프리셋의 Blade, CSS, JavaScript와 설정 파일을 호스트 애플리케이션으로 생성합니다. 설치 후 생성된 파일을 프로젝트 요구에 맞게 자유롭게 수정할 수 있습니다.

## 주요 기능

- 13개의 반응형 사이트 디자인 프리셋
- Blade 컴포넌트, Tailwind CSS와 JavaScript를 포함한 완성형 스캐폴드
- Laravel Starter Kit 인증 화면과 분리된 공개 사이트 영역
- `site.home` 이름을 사용하는 충돌 방지형 홈 route
- 설치 후 모든 생성 파일을 호스트 애플리케이션이 소유하는 구조
- 프리셋별 디자인 의도와 확장 규칙을 담은 `design.md`

## 요구 사항

- PHP `^8.3`
- Laravel/Illuminate `^13.0`
- Livewire `^3.0` 또는 `^4.0`
- Tailwind CSS `^4.0`과 Laravel Vite가 구성된 Starter Kit 애플리케이션

`resources/css/app.css`는 Tailwind v4의 `@import "tailwindcss";` 방식을 사용해야 합니다. 이 패키지는 `tailwind.config.js` 또는 Tailwind v3 지시어를 생성하지 않습니다.

## 설치

```bash
composer require ssh521/laravel-site
php artisan laravel-site:install
npm install
npm run build
```

기본 프리셋은 `package-guide`입니다. 설치 명령은 공개 사이트 route, Blade 화면과 컴포넌트, CSS, JavaScript, 설정, 미디어와 `design.md`를 생성하고 Vite input을 갱신합니다.

> `--force`는 기존에 생성된 사이트 파일을 덮어씁니다. 커스터마이징한 프로젝트에서는 먼저 Git 변경 상태를 확인하고 복구 가능한 커밋을 만든 뒤 사용하십시오.

## 디자인 선택

설치할 때 프리셋을 지정할 수 있습니다.

```bash
php artisan laravel-site:install --design=essential
php artisan laravel-site:install --design=app-launch
php artisan laravel-site:install --design=swiss-corporate
```

사용 가능한 프리셋은 명령으로 확인합니다.

```bash
php artisan laravel-site:design --list
```

설치 후 디자인 파일만 교체하려면 다음 명령을 사용합니다.

```bash
php artisan laravel-site:design corporate-trust --force
```

이 명령도 기존 사이트 디자인 파일을 덮어쓰므로 변경 내용을 먼저 확인하십시오.

## 디자인 프리셋

| 프리셋 | 용도 |
|---|---|
| `package-guide` | 패키지 기능과 설치 흐름을 설명하는 기본 안내형 |
| `app-launch` | 소비자 앱 출시와 설치 전환형 |
| `clinic-clean` | 병원, 상담센터, 법률·세무·노무 전문직형 |
| `conversion` | 광고 유입과 상담·문의 전환형 |
| `corporate-trust` | B2B, 제조와 전문 서비스 신뢰형 |
| `essential` | 범용 회사·서비스 소개형 |
| `event-promo` | 세미나, 강의, 컨퍼런스와 단기 프로모션형 |
| `local-business` | 식당, 학원, 미용실과 오프라인 매장형 |
| `portfolio-editorial` | 스튜디오, 작가와 브랜드 포트폴리오형 |
| `saas-product` | SaaS, 앱, API와 디지털 제품 소개형 |
| `swiss-corporate` | 강한 그리드와 타이포 중심의 기술·제조 기업형 |
| `yaver` | 앱 설치 안내와 디지털 제작사 소개형 |
| `yaver-studio` | 스튜디오·디지털 제작사 소개형 |

프리셋 제작과 확장 규칙은 [디자인 프리셋 문서](docs/designs.md)를 참고하십시오.

## 생성 파일

```text
app/Http/Controllers/Site/HomeController.php
routes/site.php
config/laravel-site.php
resources/views/site/home.blade.php
resources/views/components/layouts/site.blade.php
resources/views/components/site/*.blade.php
resources/css/site.css
resources/js/site.js
public/media/*
design.md
```

`routes/web.php`에는 다음 route loader가 자동으로 추가됩니다.

```php
require __DIR__.'/site.php';
```

route loader를 직접 관리하려면 설치할 때 `--skip-route-include`를 사용합니다.

```bash
php artisan laravel-site:install --skip-route-include
```

생성되는 홈 route 이름은 기본적으로 `site.home`입니다. 필요한 경우 `LARAVEL_SITE_HOME_NAME` 환경변수로 변경할 수 있습니다.

## 커스터마이징

- 메인 페이지: `resources/views/site/home.blade.php`
- 사이트 컴포넌트: `resources/views/components/site`
- 레이아웃: `resources/views/components/layouts/site.blade.php`
- 메뉴와 브랜드 설정: `config/laravel-site.php`
- 색상과 레이아웃: `resources/css/site.css`
- 모바일 메뉴 동작: `resources/js/site.js`
- 프리셋 의도와 AI 확장 기준: `design.md`

생성 파일은 패키지 업데이트로 자동 덮어쓰지 않습니다. 프리셋을 다시 적용할 때는 호스트 애플리케이션의 커스터마이징과 새 프리셋의 차이를 직접 병합하십시오.

## 관리자 기능 추가

`laravel-site`는 방문자용 공개 사이트만 생성합니다. 관리자 인증, 역할·권한과 메뉴가 필요하면 공개 코어 패키지를 별도로 설치합니다.

```bash
composer require ssh521/laravel-admin
php artisan laravel-admin:install
npm run build
```

현재 설치 가능한 `ssh521/*` 패키지는 [Packagist 검색 결과](https://packagist.org/search/?query=ssh521)에서 확인할 수 있습니다.

## 인증 화면

로그인, 회원가입, 비밀번호 재설정과 같은 인증 화면은 Laravel Starter Kit이 계속 소유합니다. `laravel-site`는 공개 사이트 route와 화면만 생성합니다.

## 개발과 테스트

```bash
composer test
git diff --check
```

프리셋을 변경한 경우 설치 명령, Vite build, route 충돌, 데스크톱·모바일 반응형과 생성 파일의 재현성을 함께 확인해야 합니다.

## 지원과 보안

버그와 기능 요청은 [GitHub Issues](https://github.com/ssh521/laravel-site/issues)에 등록해 주십시오. 보안 취약점은 공개 이슈 대신 [GitHub Security Advisory](https://github.com/ssh521/laravel-site/security/advisories/new)로 제보해 주십시오.

## 라이선스

이 패키지는 [MIT License](LICENSE)로 배포됩니다.
