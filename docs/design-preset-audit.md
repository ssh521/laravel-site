# Laravel Site Existing Preset Audit

## 기준일

2026-07-12

## 요약

현재 프리셋은 11개다. `yaver-studio`를 제외하면 Desktop navigation 대부분이 `classic-horizontal`, Mobile navigation은 모두 `right-drawer`에 집중되어 있다.

가장 큰 중복은 다음과 같다.

- header markup과 breakpoint가 유사하다.
- Mobile navigation이 오른쪽 sliding panel로 통일되어 있다.
- hero가 left copy + right visual 또는 일반 텍스트 block에 집중되어 있다.
- section이 equal card grid와 split layout을 반복한다.
- 업종은 다르지만 실제 화면 리듬의 차이가 작다.

## 프리셋별 감사

| Preset | Category | Style | Desktop nav | Mobile nav | Hero | Motion | 판단 |
| --- | --- | --- | --- | --- | --- | ---: | --- |
| `package-guide` | package, docs | technical, neutral | classic-horizontal | right-drawer | package-introduction | 2 | 유지, catalog 기준 화면 |
| `essential` | general service | minimal, neutral | classic-horizontal | right-drawer | asymmetric-media | 2 | 개선 필요, 범용 기준 |
| `conversion` | campaign | direct, conversion | classic-horizontal | right-drawer | conversion-form | 2 | 유지, form 전환성 강화 |
| `corporate-trust` | corporate, B2B | structured, trust | two-tier-corporate | accordion-drawer | asymmetric-media | 2 | 개선 완료 |
| `local-business` | local store | friendly, practical | classic-horizontal | right-drawer | local-action | 2 | header-dropdown으로 개선 후보 |
| `clinic-clean` | clinic, professional | calm, trust | classic-horizontal | right-drawer | asymmetric-media | 2 | nav보다 콘텐츠 신뢰 구조 강화 |
| `portfolio-editorial` | portfolio | editorial, gallery | sidebar-rail | push-content | editorial-type | 4 | 개선 완료 |
| `saas-product` | SaaS, app | product, technical | transparent-overlay | bottom-sheet | product-device | 4 | 개선 완료 |
| `event-promo` | event, campaign | promotional, bold | transparent-overlay | header-dropdown | event-summary | 4 | 개선 완료 |
| `yaver` | app, agency | minimal, technical | centered-logo-split | bottom-sheet | asymmetric-media | 4 | 개선 완료 |
| `yaver-studio` | agency, studio | cinematic, dark | desktop-offcanvas | fullscreen-takeover | full-bleed-video | 8 | 개선 완료 |

## 중복 위험도

### 높음

- `essential` ↔ `corporate-trust`
- `essential` ↔ `clinic-clean`
- `saas-product` ↔ `yaver`

### 중간

- `conversion` ↔ `event-promo`
- `local-business` ↔ `clinic-clean`

### 낮음

- `yaver-studio` ↔ 다른 프리셋
- `package-guide` ↔ 고객용 프리셋
- `portfolio-editorial` ↔ 전환형 프리셋

## 권장 Navigation 재배치

| Preset | 현재 | 권장 Desktop | 권장 Mobile |
| --- | --- | --- | --- |
| `package-guide` | classic/right-drawer | classic-horizontal | header-dropdown |
| `essential` | classic/right-drawer | classic-horizontal | right-drawer |
| `conversion` | classic/right-drawer | floating-island | bottom-sheet |
| `corporate-trust` | classic/right-drawer | two-tier-corporate | accordion-drawer |
| `local-business` | classic/right-drawer | classic-horizontal | header-dropdown |
| `clinic-clean` | classic/right-drawer | centered-logo-split | accordion-drawer |
| `portfolio-editorial` | classic/right-drawer | sidebar-rail | push-content |
| `saas-product` | classic/right-drawer | transparent-overlay | bottom-sheet |
| `event-promo` | classic/right-drawer | transparent-overlay | header-dropdown |
| `yaver` | classic/right-drawer | centered-logo-split | bottom-sheet |
| `yaver-studio` | overlay/right-drawer | desktop-offcanvas | fullscreen-takeover |

## 우선 개선 순서

1. `portfolio-editorial`: sidebar rail + push-content
2. `corporate-trust`: two-tier corporate + accordion drawer
3. `saas-product`: transparent overlay + bottom sheet
4. `yaver-studio`: desktop offcanvas + fullscreen takeover
5. `event-promo`: overlay + compact dropdown
6. `yaver`: app/web dual-track composition

## Phase 0 기준선 결과

- 11개 프리셋의 desktop 1440x900, tablet 820x1180, mobile 390x844 screenshot을 생성했다.
- screenshot은 `laravel-site-preview/public/screenshots/{design}/{desktop|tablet|mobile}.webp`가 소유한다.
- `yaver` 상세 및 iframe preview에서 console error가 없음을 확인했다.
- `yaver`의 desktop/mobile 첫 화면에서 핵심 제목과 CTA가 노출되고 390px 가로 overflow가 없음을 확인했다.

## 후속 브라우저 감사 항목

- 나머지 프리셋의 메뉴 열기·닫기, Escape, focus restore 전수 검사
- light/dark 지원 프리셋의 양쪽 테마 screenshot
- CTA 줄바꿈과 horizontal overflow 자동 검사 결과 기록
- navigation 다양화 이후 기준 screenshot 재생성

스크린샷은 `laravel-site-preview` 앱이 생성하고 소유한다.
