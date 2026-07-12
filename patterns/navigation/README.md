# Laravel Site Navigation Pattern Contract

이 디렉터리는 신규 프리셋 제작용 navigation 패턴 사양을 관리한다. 패턴은 런타임에서 조합하지 않으며, 최종 구현은 각 `designs/{name}` 안에 독립적으로 포함한다.

현재 desktop 6개와 mobile 6개 패턴에 Blade, CSS, JavaScript, 테스트 계약 원본이 준비되어 있다. 이 원본은 그대로 설치되지 않으며 새 프리셋 제작 또는 기존 프리셋 다양화 시 복사·조정한다.

## Desktop patterns

### `classic-horizontal`

- 왼쪽 logo
- 중앙 또는 오른쪽 horizontal links
- 끝에 primary CTA
- 1024px 이상에서 한 줄 유지
- 범용 회사·서비스에 사용

### `centered-logo-split`

- logo를 화면 중앙에 고정
- 주요 menu를 logo 좌우로 분리
- 홀수 menu 또는 긴 한글 label이면 구조 재검토
- 브랜드·스튜디오·전문 서비스에 사용

### `transparent-overlay`

- hero 위에서 투명 또는 반투명
- scroll 이후 solid surface로 전환
- hero와 header text contrast를 별도로 검증
- 앱, 이벤트, 숙박, cinematic landing에 사용

### `desktop-offcanvas`

- desktop에서도 logo와 menu button만 표시
- 전체 화면 또는 넓은 overlay menu 사용
- focus trap과 Escape 닫기 필수
- 스튜디오·포트폴리오에 사용

### `sidebar-rail`

- viewport 한쪽에 고정 vertical navigation
- main content와 landmark 분리
- mobile에서는 rail을 유지하지 않음
- 포트폴리오·에디토리얼에 사용

### `two-tier-corporate`

- utility navigation과 primary navigation 분리
- 전체 header 높이는 112px 이내 권장
- utility item은 primary item보다 시각적으로 약하게 처리
- 기업·제조·기관에 사용

## Mobile patterns

### `right-drawer`

- 오른쪽 panel
- backdrop, scroll lock, focus trap 제공
- 최대 폭과 edge spacing 명시

### `fullscreen-takeover`

- viewport 전체를 menu가 소유
- 큰 type scale과 명확한 close button
- 기존 page는 `aria-hidden` 또는 inert 처리 검토

### `bottom-sheet`

- 화면 아래에서 panel이 올라옴
- 작은 viewport에서도 CTA와 close control이 보여야 함
- drag gesture 없이도 button으로 완전 조작 가능

### `header-dropdown`

- header 바로 아래 compact panel
- 4개 이하의 얕은 menu에 적합
- page overlay 사용 여부를 pattern에서 고정

### `accordion-drawer`

- nested navigation을 accordion으로 표시
- button과 link 역할을 분리
- `aria-expanded`와 panel 연결 필수

### `push-content`

- menu가 main content를 옆으로 밀어냄
- transform 대상과 focus 순서를 일치
- overflow와 viewport 안정성 검증 필수

## 공통 파일 계약

각 실제 pattern 디렉터리는 다음 파일을 가진다.

```text
{pattern-name}/
├── README.md
├── header.blade.php.stub 또는 mobile-menu.blade.php.stub
├── site.css.stub
├── site.js.stub
└── test-contract.md
```

## 공통 접근성 체크

- `aria-expanded`
- `aria-controls`
- `aria-current`
- Escape close
- focus trap when modal
- focus restore
- backdrop close
- body scroll restoration
- reduced motion
- 320px horizontal overflow
- desktop single-line navigation
