# Laravel Site Design Differentiation Contract

## 목적

새 디자인 프리셋이 기존 프리셋의 색상·문구 교체판으로 늘어나는 것을 방지한다. 고객이 미리보기 목록에서 각 프리셋을 한눈에 구분할 수 있어야 한다.

## 신규 프리셋 승인 기준

신규 프리셋은 가장 가까운 기존 프리셋과 다음 10개 축 중 최소 5개에서 명확히 달라야 한다.

1. Desktop navigation
2. Mobile navigation
3. Hero composition
4. Typography
5. Color and material
6. Section rhythm
7. Image direction
8. CTA composition
9. Content density
10. Motion behavior

다음 변경만으로는 신규 프리셋으로 인정하지 않는다.

- accent color만 변경
- 업종 이름과 문구만 변경
- 같은 header에서 메뉴 이름만 변경
- 같은 hero에서 사진만 변경
- 같은 card grid의 아이콘만 변경
- 동일한 오른쪽 drawer의 색상만 변경

## 필수 Design Read

구현 전에 다음을 기록한다.

```text
Reading this as: {page kind} for {audience}, with a {vibe} language, leaning toward {aesthetic family}.
DESIGN_VARIANCE: 1-10
MOTION_INTENSITY: 1-10
VISUAL_DENSITY: 1-10
```

추가로 다음 선택을 확정한다.

- 하나의 주 강조색
- 타이포그래피 스택
- 모서리 체계
- Desktop navigation family
- Mobile navigation family
- Hero family
- 최소 4개의 서로 다른 section layout family
- light, dark, auto 중 page theme

## 비교표

신규 프리셋 작업 보고와 리뷰에는 다음 표를 포함한다.

| 비교 항목 | 신규 프리셋 | 가장 가까운 기존 프리셋 | 차이 설명 |
| --- | --- | --- | --- |
| Target audience |  |  |  |
| Desktop nav |  |  |  |
| Mobile nav |  |  |  |
| Hero |  |  |  |
| Typography |  |  |  |
| Color/material |  |  |  |
| Section rhythm |  |  |  |
| Image direction |  |  |  |
| CTA |  |  |  |
| Motion |  |  |  |

## Navigation 다양성 기준

- 전체 프리셋의 60% 이상이 같은 Desktop navigation을 사용하면 신규 프리셋은 다른 family를 우선한다.
- 전체 프리셋의 60% 이상이 같은 Mobile navigation을 사용하면 신규 프리셋은 다른 family를 우선한다.
- 메뉴 유형은 catalog metadata의 `navigation.desktop`, `navigation.mobile`에 기록한다.
- 메뉴가 실제로 다른 구조와 동작을 가져야 한다. 이름만 다른 alias는 별도 family로 세지 않는다.

## Layout 다양성 기준

- 동일 크기 3-column feature card를 기본값으로 사용하지 않는다.
- image/text split을 3개 section 이상 연속으로 사용하지 않는다.
- 한 페이지에서 같은 section layout family를 반복하지 않는다.
- hero와 첫 CTA는 초기 viewport에서 목적과 행동이 확인되어야 한다.
- 페이지의 section이 8개라면 최소 4개 이상의 layout family를 사용한다.

## 시각 자산 기준

- hero는 실제 의미가 있는 image, video, product capture 중 하나를 사용한다.
- div로 만든 가짜 dashboard 또는 앱 screenshot을 사용하지 않는다.
- 이미지 위에 의미 없는 pill, version, 상태 점을 올리지 않는다.
- 생성 이미지는 프리셋 목적과 맞는 비율로 만들고 WebP로 최적화한다.
- 실제 고객 적용 시 생성 이미지를 고객 소유 또는 사용 허가가 있는 자산으로 교체할 수 있어야 한다.

## 접근성 기준

- WCAG AA 수준의 본문·버튼 대비
- 키보드 focus 표시
- 모바일 메뉴 Escape 닫기와 focus restore
- modal menu focus trap
- `prefers-reduced-motion` 대응
- 320px 이상에서 가로 overflow 없음
- 한국어 `word-break: keep-all` 검토
- CTA는 한 줄 유지

## 리뷰 판정

### 승인

- 최소 5개 차별성 축 충족
- navigation family가 실제 구조와 동작으로 구분됨
- catalog metadata와 실제 화면 일치
- 390, 820, 1440 viewport 검증 완료

### 수정 필요

- 색상과 문구 이외의 차이가 4개 이하
- 기존 프리셋과 동일한 header, hero, card rhythm 사용
- Mobile navigation이 metadata와 다름
- preview 결과가 실제 설치 결과와 다름

### 신규 프리셋 대신 기존 프리셋 개선

- 대상 업종만 다르고 구조가 같음
- 디자인 토큰 교체로 충분함
- 별도 이름으로 장기간 유지할 이유가 없음
