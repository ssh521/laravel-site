# Laravel Site PRD

## 개요

`ssh521/laravel-site`는 Laravel Starter Kit 기반 호스트 앱에 고객용 public 웹사이트 스캐폴드를 설치하는 디자인 라이브러리 패키지다.

목표는 런타임 페이지 빌더가 아니라, 웹에이전시 개발자가 `laravel-site:install --design={name}` 이후 생성된 파일을 직접 수정해서 고객 요구사항에 빠르게 맞출 수 있는 디자인별 기본 구조를 제공하는 것이다.

## 목표

- Laravel, Livewire, Tailwind CSS 스택에 맞는 public site 기본 구조 제공
- 반응형 header, desktop dropdown, mobile sliding menu, footer 제공
- 로고, 버튼, 섹션, hero, CTA 등 반복 UI를 Blade component로 제공
- CSS 변수 기반 디자인 토큰으로 전체 톤을 한 번에 변경 가능하게 제공
- AI 추가 제작을 위한 `design.md` 제공
- Laravel Starter Kit auth 화면과 충돌하지 않는 public site 영역 제공
- 여러 디자인 원본을 패키지 안에 보관하고 필요할 때 선택 설치 가능하게 제공

## 비목표

- v1에서 드래그앤드롭 페이지 빌더를 만들지 않는다.
- v1에서 관리자 CRUD로 메뉴/섹션을 관리하지 않는다.
- Laravel Starter Kit의 auth 화면을 대체하지 않는다.
- `laravel-page`의 정적 CMS 역할을 대체하지 않는다.

## v1 범위

- `laravel-site:install` command
- `laravel-site:design` command
- `--design={name}` 선택 설치
- 호스트 앱 파일 스캐폴딩
- config 기반 header/footer 메뉴
- desktop dropdown navigation
- mobile hamburger sliding menu
- footer component
- logo component
- landing homepage with hero and section slots
- reusable site components
- `essential`, `conversion`, `corporate-trust`, `local-business`, `clinic-clean`, `portfolio-editorial`, `saas-product`, `event-promo`, `yaver`, `yaver-studio`, `app-launch`, `package-guide` 디자인 원본
- 디자인별 design token, 홈 화면, 컴포넌트, `design.md`
- `design.md` AI/developer reference document

## 설치 후 생성 파일

- `app/Http/Controllers/Site/HomeController.php`
- `routes/site.php`
- `routes/web.php` route include line
- `config/laravel-site.php`
- `resources/views/site/home.blade.php`
- `resources/views/components/layouts/site.blade.php`
- `resources/views/components/site/*.blade.php`
- `resources/css/site.css`
- `resources/js/site.js`
- `design.md`

`routes/site.php`의 홈 라우트 이름은 기본적으로 `site.home`이어야 한다. `home`은 Laravel Starter Kit 또는 호스트 앱 전역 라우트와 충돌하기 쉬우므로, 사용자가 명시적으로 `LARAVEL_SITE_HOME_NAME`을 설정한 경우에만 변경한다.

## 수용 기준

- `php artisan laravel-site:install` 실행 시 기존 파일을 기본으로 덮어쓰지 않는다.
- `php artisan laravel-site:install --design=conversion` 실행 시 conversion 디자인 파일을 설치한다.
- `php artisan laravel-site:design --list` 실행 시 사용 가능한 디자인 목록을 보여준다.
- `php artisan laravel-site:design conversion --force` 실행 시 디자인 파일을 교체한다.
- `--force` 옵션을 사용하면 생성 대상 파일을 다시 쓴다.
- `/` 또는 설정된 home path에서 메인 랜딩 페이지를 렌더링할 수 있다.
- 데스크톱에서 드롭다운 메뉴가 동작한다.
- 모바일에서 햄버거 버튼으로 슬라이딩 메뉴를 열고 닫을 수 있다.
- CSS 변수 변경으로 사이트 전체 버튼, 배경, 텍스트, 강조색 톤이 함께 바뀐다.
- `design.md`가 컴포넌트, 토큰, 메뉴, AI 제작 규칙을 설명한다.
