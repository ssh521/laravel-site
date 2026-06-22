# Laravel Site

`ssh521/laravel-site`는 Laravel Starter Kit 기반 앱에 반응형 고객 웹사이트 스캐폴드를 설치하는 디자인 라이브러리 패키지입니다.

관리자 페이지나 런타임 빌더가 아니라, 웹에이전시 개발자가 디자인을 선택해 설치한 뒤 생성된 Blade, CSS, JS, config 파일을 직접 수정해서 고객 사이트를 빠르게 납품하는 흐름을 목표로 합니다.

## 요구 사항

- PHP `^8.3`
- Laravel `^13.0`
- Livewire `^3.0|^4.0`
- Tailwind CSS `^4.0`이 구성된 Laravel Starter Kit 앱

`resources/css/app.css`는 Tailwind v4 방식인 `@import "tailwindcss";`를 사용하고,
`vite.config.js`에는 `@tailwindcss/vite` 플러그인이 설정되어 있어야 합니다.
이 패키지는 `tailwind.config.js`나 v3의 `@tailwind base/components/utilities`
지시어를 생성하지 않습니다.

## 설치

```bash
composer require ssh521/laravel-site
php artisan laravel-site:install
```

기본 설치 디자인은 `package-guide`입니다. Laravel Starter Kit 설치 직후 실행하면 메인 화면이 `ssh521/laravel-site` 패키지 설명, 설치 방법, 생성 파일 안내 화면으로 바뀝니다.

## 관리자/기능 패키지로 확장

`laravel-site`는 방문자용 public site를 생성하는 패키지입니다. 고객 사이트에 관리자 화면과 운영 기능이 필요하면 `ssh521/laravel-admin`을 추가한 뒤 기능 패키지를 이어서 설치합니다.

```bash
# 공개 사이트
composer require ssh521/laravel-site
php artisan laravel-site:install

# 관리자 기반
composer require ssh521/laravel-admin
php artisan laravel-admin:install

# 자주 쓰는 관리자 기능 패키지
composer require ssh521/laravel-admin-users ssh521/laravel-file
php artisan laravel-admin:install --with=users,file

# 콘텐츠 기능 패키지 예시
composer require ssh521/laravel-blog ssh521/laravel-bbs
php artisan laravel-admin:install --with=blog,bbs
```

확장 패키지는 프로젝트 성격에 맞게 선택합니다.

| 패키지 | 용도 |
|--------|------|
| `ssh521/laravel-admin` | 관리자 레이아웃, 메뉴, 권한 기반 |
| `ssh521/laravel-admin-users` | 관리자 사용자 관리 |
| `ssh521/laravel-blog` | 블로그 콘텐츠 관리 |
| `ssh521/laravel-bbs` | 게시판/커뮤니티 |
| `ssh521/laravel-file` | 파일 관리 |
| `ssh521/laravel-page` | 정적/반정적 페이지 CMS |
| `ssh521/laravel-popup` | 팝업, 배너, 공지바 관리 |
| `ssh521/laravel-notification` | 알림 관리 |
| `ssh521/laravel-broadcast-notification` | 실시간 인앱 알림 |

디자인을 선택해서 설치:

```bash
php artisan laravel-site:install --design=essential
php artisan laravel-site:install --design=conversion
php artisan laravel-site:install --design=corporate-trust
```

기존 생성 파일을 다시 쓰려면:

```bash
php artisan laravel-site:install --force
```

route include를 자동으로 추가하지 않으려면:

```bash
php artisan laravel-site:install --skip-route-include
```

## 디자인 라이브러리

사용 가능한 디자인 목록:

```bash
php artisan laravel-site:design --list
```

설치 후 디자인 파일만 교체:

```bash
php artisan laravel-site:design clinic-clean --force
php artisan laravel-site:design corporate-trust --force
php artisan laravel-site:design package-guide --force
php artisan laravel-site:design conversion --force
php artisan laravel-site:design essential --force
php artisan laravel-site:design event-promo --force
php artisan laravel-site:design local-business --force
php artisan laravel-site:design portfolio-editorial --force
php artisan laravel-site:design saas-product --force
```

패키지의 디자인 원본은 다음 구조로 관리합니다.

```text
designs/
├── clinic-clean/
├── corporate-trust/
├── conversion/
├── essential/
├── event-promo/
├── local-business/
├── package-guide/
├── portfolio-editorial/
└── saas-product/
```

각 디자인은 `home.blade.php`, site component, `site.css`, `site.js`, `config/laravel-site.php`, `design.md`를 함께 가집니다.

기본 제공 디자인:

| 디자인 | 용도 |
|--------|------|
| `package-guide` | 기본 설치 화면, 패키지 설명 및 설치/추가 방법 안내 |
| `essential` | 범용 회사/서비스 소개형 |
| `conversion` | 광고 유입, 상담 신청, 문의 전환형 |
| `corporate-trust` | B2B 회사, 제조, 전문 서비스 신뢰형 |
| `local-business` | 식당, 학원, 미용실, 오프라인 매장형 |
| `clinic-clean` | 병원, 상담센터, 법률/세무/노무 전문직형 |
| `portfolio-editorial` | 스튜디오, 작가, 브랜드 포트폴리오형 |
| `saas-product` | SaaS, 앱, API, 디지털 제품 소개형 |
| `event-promo` | 세미나, 강의, 컨퍼런스, 단기 프로모션형 |

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
design.md
```

`routes/web.php`에는 다음 줄이 자동 추가됩니다.

```php
require __DIR__.'/site.php';
```

## 커스터마이징

- 메인 랜딩 페이지: `resources/views/site/home.blade.php`
- 공통 컴포넌트: `resources/views/components/site`
- 사이트 레이아웃: `resources/views/components/layouts/site.blade.php`
- 메뉴/브랜드/프리셋: `config/laravel-site.php`
- 전체 색상/톤: `resources/css/site.css`
- 모바일 메뉴 JS: `resources/js/site.js`
- AI 추가 제작 기준: `design.md`

## Auth

로그인, 회원가입, 비밀번호 재설정 같은 auth 화면은 Laravel Starter Kit이 제공하는 페이지를 그대로 사용합니다. `laravel-site`는 public website 영역만 담당합니다.

## 테스트

```bash
vendor/bin/phpunit --configuration phpunit.xml.dist
```
