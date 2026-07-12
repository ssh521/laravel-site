# Laravel Site Existing Preset Audit

## 기준일

2026-07-12

## 요약

Phase 0 기준선은 11개 프리셋으로 시작했다. navigation 다양화와 `app-launch` 추가 후 현재 프리셋은 12개이며, 각 대표 프리셋은 목적에 맞는 desktop과 mobile navigation family를 사용한다.

가장 큰 중복은 다음과 같다.

- header markup과 breakpoint가 유사하다.
- Mobile navigation이 오른쪽 sliding panel로 통일되어 있다.
- hero가 left copy + right visual 또는 일반 텍스트 block에 집중되어 있다.
- section이 equal card grid와 split layout을 반복한다.
- 업종은 다르지만 실제 화면 리듬의 차이가 작다.

## 프리셋별 감사

| Preset | Category | Style | Desktop nav | Mobile nav | Hero | Motion | 판단 |
| --- | --- | --- | --- | --- | --- | ---: | --- |
| `app-launch` | app, consumer | editorial, bright | compact-floating | bottom-action-sheet | asymmetric-device-showcase | 6 | 신규 대표 프리셋 |
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

## App Launch 차별성 검토

| 비교 항목 | `app-launch` | 가장 가까운 기존 프리셋 | 차이 설명 |
| --- | --- | --- | --- |
| Target audience | 앱 설치를 결정하는 최종 사용자 | `saas-product`: SaaS 구매자, `yaver`: 개발 의뢰 고객 | 개발·구매 설명보다 설치 행동에 집중 |
| Desktop nav | compact floating bar | transparent overlay, centered logo split | page edge에서 분리된 짧은 floating navigation |
| Mobile nav | bottom action sheet + 고정 설치 CTA | bottom sheet | 메뉴와 별도로 설치 행동을 viewport 하단에 유지 |
| Hero | 실제 앱 화면 비대칭 device showcase | product device, asymmetric media | 생성된 실제 제품 screenshot이 주 시각 자산 |
| Typography | 굵은 한국어 sans display | 영문 technical, 절제된 Korean sans | 소비자용 짧은 문장과 큰 한국어 제목 |
| Color/material | cool off-white + coral | indigo product, cobalt trust | 보라색 없이 coral 단일 accent와 light theme 고정 |
| Section rhythm | screen gallery, feature index, lifestyle scene, quote, FAQ | mock product, split service | 6개 섹션에 5개 layout family 사용 |
| Image direction | 앱 screenshot 2종 + 실제 사용 장면 | fake product UI, agency photography | div 기반 dashboard 없이 생성 이미지 사용 |
| CTA | `앱 설치하기` 고정 | trial, consultation | 모든 설치 목적 CTA를 한 문구로 통일 |
| Motion | one-shot reveal과 action sheet | basic reveal | 정보 순서와 메뉴 상태 전환에만 motion 사용 |

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

- 2026-07-13 기준 기존 11개 프리셋의 메뉴 열기, Escape 닫기, focus restore를 전수 검사했고 모두 통과했다.
- 390x844, 820x1180, 1440x900에서 초기 제목과 CTA 노출, 가로 overflow를 검사했다.
- `package-guide`의 390px overflow와 데스크톱 초기 CTA 이탈을 발견해 hero 높이, grid min-width, page overflow를 보정했다.
- auto theme 프리셋 `yaver`는 light와 dark 양쪽에서 overflow 0, primary CTA 대비 5.82:1과 5.86:1, console error 0건을 확인했다.
- CTA 줄바꿈 자동 검사와 양쪽 테마 비교는 후속 자동화 단계에서 계속한다.
- navigation 다양화 이후 기준 screenshot 재생성

스크린샷은 `laravel-site-preview` 앱이 생성하고 소유한다.
