@php
    $fb = config('app.fallback_locale', 'en');
    $locale = app()->getLocale();
    $st = $section->translation($locale) ?? $section->translation($fb);
    $title = $st?->title ?: __('Expert Doctors, Seamless Appointments, Quality Care');
    $sub = $st?->subtitle ?: __('About us');
    $desc = $st?->description ?: '<p class="fs-18 mb-30 wow fadeInUp" data-wow-delay=".1s">' . e(__('A belief that knowledge is power—we connect our patients with their results and quality care when they need it most.')) . '</p>';
    $img = $section->getMediaUrl('images', $locale, asset('frontend/assets/img/normal/about_1_1.jpg'), true);
    $defaultSide = [
        asset('frontend/assets/img/normal/about_1_2.jpg'),
        asset('frontend/assets/img/normal/about_1_3.jpg'),
    ];
    $sidePool = collect();
    foreach ($section->getMedia('gallery') as $media) {
        $sidePool->push($media->getUrl());
    }
    $singleSectionImg = $section->getMediaUrl('images', $locale, '', true);
    if ($singleSectionImg !== '') {
        $sidePool->push($singleSectionImg);
    }
    $sidePool = $sidePool->unique()->values();
    $sideImg1 = $sidePool->get(0) ?? $defaultSide[0];
    $sideImg2 = $sidePool->get(1) ?? $defaultSide[1];
    $aboutAlt = strip_tags($title) ?: __('About');

    $resolveHref = static function (?string $raw): string {
        $raw = trim((string) $raw);
        if ($raw === '') {
            return '#';
        }
        if (preg_match('#^(https?:)?//#i', $raw) || str_starts_with($raw, 'mailto:') || str_starts_with($raw, 'tel:')) {
            return $raw;
        }

        return str_starts_with($raw, '/') ? url($raw) : url('/' . ltrim($raw, '/'));
    };

    $aboutButtons = collect();
    if ($section->relationLoaded('links')) {
        foreach ($section->links->where('is_active', true)->filter(static fn ($l) => filled(trim((string) ($l->link ?? ''))))->sortBy('order')->values() as $idx => $link) {
            $href = $resolveHref($link->link);
            $tr = null;
            if ($link->relationLoaded('translations')) {
                $tr = $link->translations->firstWhere('locale', $locale)
                    ?? $link->translations->firstWhere('locale', $fb)
                    ?? $link->translations->first();
            }
            $label = $tr?->name ?? $link->name ?? __('Link');
            $target = in_array($link->target, ['_blank', '_self'], true) ? $link->target : '_self';
            $rel = $target === '_blank' ? 'noopener noreferrer' : null;
            $icon = trim((string) ($link->icon ?? ''));
            $type = strtolower((string) ($link->type ?? ''));
            if (in_array($type, ['secondary', 'outline', 'border'], true)) {
                $btnClass = 'th-btn th-border';
            } elseif (in_array($type, ['primary', 'solid', 'main'], true)) {
                $btnClass = 'th-btn style2';
            } else {
                $btnClass = $idx === 0 ? 'th-btn style2' : 'th-btn th-border';
            }
            $aboutButtons->push(compact('href', 'label', 'target', 'rel', 'icon', 'btnClass'));
        }
    }
    // if ($aboutButtons->isEmpty()) {
    //     $aboutButtons->push([
    //         'href' => url('/about'),
    //         'label' => __('More About Us'),
    //         'target' => '_self',
    //         'rel' => null,
    //         'icon' => 'fa-light fa-arrow-right-long ms-2',
    //         'btnClass' => 'th-btn style2',
    //     ]);
    // }
@endphp
<div class="about-area overflow-hidden space-bottom" id="about-sec">
    <div class="container">
        <div class="row gy-4">
            <div class="col-xxl-8 mb-30 mb-xl-0">
                <div class="title-area">
                    <span class="sub-title">{{ $sub }}</span>
                    <h2 class="sec-title text-anime-style-3">{!! $title !!}</h2>
                </div>
                <div class="img-box1">
                    <div class="about-wrapper">
                        <!-- <div class="img1">
                            <img src="{{ $img }}" alt="{{ strip_tags($title) }}">
                            <a href="https://www.youtube.com/watch?v=i2pMEhEzbEs" class="play-btn popup-video"><i class="fa-solid fa-play"></i></a>
                        </div> -->
                        <div>
                            <div class="cms-about-desc">{!! $desc !!}</div>
                            <div class="btn-group mt-40 wow fadeInUp" data-wow-delay=".4s">
                                @foreach($aboutButtons as $btn)
                                    <a href="{{ $btn['href'] }}"
                                        class="{{ $btn['btnClass'] }}"
                                        @if(($btn['target'] ?? '_self') === '_blank') target="_blank" @endif
                                        @if(! empty($btn['rel'])) rel="{{ $btn['rel'] }}" @endif>
                                        {{ $btn['label'] }}
                                        @if(! empty($btn['icon']))
                                            <i class="{{ $btn['icon'] }}"></i>
                                        @endif
                                    </a>
                                @endforeach
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-xxl-4">
                <div class="img-box2">
                    <div class="img-box-wrapp">
                        <div class="img1 reveal">
                            <img src="{{ $sideImg1 }}" alt="{{ $aboutAlt }}" style="width: 100%; height: 300px; object-fit: cover;">
                        </div>
                        <div class="img2 reveal">
                            <img src="{{ $sideImg2 }}" alt="{{ $aboutAlt }}" style="width: 100%; height: 300px; object-fit: cover;">
                        </div>
                    </div>
                    <div class="about-wrapp">
                        <div class="discount-wrapp">
                            <div class="logo">
                                <img src="{{ asset('frontend/assets/img/shape/logo.svg') }}" alt="">
                            </div>
                            <div class="discount-tag">
                                <span class="discount-anime">Medova
                                    Medical clinic *
                                    Medical services *
                                </span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
