@php
    $fb = config('app.fallback_locale', 'en');
    $locale = app()->getLocale();
    $st = $section->translation($locale) ?? $section->translation($fb);
    $title = $st?->title ?: __('Expert Doctors, Seamless Appointments, Quality Care');
    $sub = $st?->subtitle ?: __('About us');
    $desc = $st?->description ?: '<p class="fs-18 mb-30 wow fadeInUp" data-wow-delay=".1s">' . e(__('A belief that knowledge is power—we connect our patients with their results and quality care when they need it most.')) . '</p>';
    $img = $section->getMediaUrl('images', $locale, asset('frontend/assets/img/normal/about_1_1.jpg'), true);

    $specialists = \App\Models\Specialty::where('parent_id', null)->where('deleted_at', null)->get();

    $packages = $packages ?? \App\Models\Package::query()->where('status', 1)->orderBy('price')->get();
    $selectedPackageId = old('package', $selectedPackageId ?? (request()->filled('package') ? (int) request()->query('package') : null));
    if ($selectedPackageId) {
        $selectedPackageId = (int) $selectedPackageId;
    }
    $selectedPackage = $selectedPackage ?? ($selectedPackageId ? $packages->first(function ($pkg) use ($selectedPackageId) {
        return (int) $pkg->id === (int) $selectedPackageId;
    }) : null);

    $parseFeatures = static function (?string $text): array {
        if (blank($text)) {
            return [];
        }
        if (preg_match('/<li[^>]*>/i', $text)) {
            preg_match_all('/<li[^>]*>(.*?)<\/li>/is', $text, $matches);

            return collect($matches[1] ?? [])
                ->map(static fn ($line) => trim(strip_tags($line)))
                ->filter()
                ->values()
                ->all();
        }

        return collect(preg_split('/\r\n|\r|\n/', strip_tags($text)))
            ->map(static fn ($line) => trim($line))
            ->filter()
            ->values()
            ->all();
    };

    $formatPrice = static function ($value): string {
        if ($value === null || $value === '') {
            return '';
        }
        if (is_numeric($value)) {
            return rtrim(rtrim(number_format((float) $value, 2, '.', ''), '0'), '.');
        }

        return (string) $value;
    };

    $packageName = static function ($pkg) use ($locale) {
        return $locale === 'ar'
            ? ($pkg->name_ar ?: $pkg->name_en)
            : ($pkg->name_en ?: $pkg->name_ar);
    };

    if ($selectedPackage) {
        $selectedFeaturesRaw = $locale === 'ar'
            ? ($selectedPackage->features_ar ?: $selectedPackage->features_en)
            : ($selectedPackage->features_en ?: $selectedPackage->features_ar);
        $selectedFeatures = $parseFeatures($selectedFeaturesRaw);
        $selectedPrice = $formatPrice($selectedPackage->price_after_discount ?: $selectedPackage->price);
        $selectedOriginalPrice = filled($selectedPackage->price_after_discount)
            && (string) $selectedPackage->price_after_discount !== (string) $selectedPackage->price
            ? $formatPrice($selectedPackage->price)
            : null;
    }
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
//     if ($aboutButtons->isEmpty()) {
//         $aboutButtons->push([
//             'href' => url('/about'),
//             'label' => __('More About Us'),
//             'target' => '_self',
//             'rel' => null,
//             'icon' => 'fa-light fa-arrow-right-long ms-2',
//             'btnClass' => 'th-btn style2',
//         ]);
//     }
@endphp
<div class="about-area overflow-hidden space-bottom" style="padding: 80px 20px;" id="about-sec">
    <div class="container">
        <div class="row gy-4">
            <div class="col-xxl-6 col-xl-12 mb-30 mb-xl-0">
                <div class="title-area">
                    <span class="sub-title">{{ $sub }}</span>
                    <h2 class="sec-title text-anime-style-3">{!! $title !!}</h2>
                </div>
                <div class="img-box1">
                    <div class="about-wrapper">
                       
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

            <div class="col-xxl-6 col-xl-12 mb-30 mb-xl-0">
                    <form method="POST" action="{{ route('frontend.subscription.register') }}" enctype="multipart/form-data" id="clinic-registration-form">
                        @csrf
                        <h3 class="h4 mb-30 mt-n3">{{ __('main.checkout_form_title') }}</h3>

                        @if(session('success'))
                            <div class="alert alert-success">{{ session('success') }}</div>
                        @endif
                        @php
                            $registrationCauses = collect(session('registration_errors', []))
                                ->merge($errors->any() ? $errors->all() : [])
                                ->unique()
                                ->filter()
                                ->values();
                        @endphp
                        @if($registrationCauses->isNotEmpty())
                            <div class="alert alert-danger" role="alert">
                                <strong class="d-block mb-2">{{ session('registration_error_title', session('error', __('main.registration_failed'))) }}</strong>
                                <ul class="mb-0 ps-3">
                                    @foreach($registrationCauses as $cause)
                                        <li>{{ $cause }}</li>
                                    @endforeach
                                </ul>
                            </div>
                        @elseif(session('error'))
                            <div class="alert alert-danger" role="alert">{{ session('error') }}</div>
                        @endif

                        @if($selectedPackage)
                            <div class="selected-package-summary mb-30 p-4 border rounded" id="selected-package-summary">
                                <div class="d-flex flex-wrap justify-content-between align-items-start gap-2 mb-3">
                                    <div>
                                        <span class="sub-title d-block mb-1">{{ __('main.selected_package') }}</span>
                                        <h4 class="mb-0">{{ $packageName($selectedPackage) }}</h4>
                                    </div>
                                    <h4 class="mb-0 box-price">
                                        {{ $selectedPrice }}
                                        @if($selectedOriginalPrice)
                                            <small class="text-decoration-line-through opacity-75 ms-1">{{ $selectedOriginalPrice }}</small>
                                        @endif
                                        @if($selectedPackage->duration)
                                            <span class="fs-16 fw-normal">/ {{ __('main.duration') }}: {{ $selectedPackage->duration }} {{ __('main.days') }}</span>
                                        @endif
                                    </h4>
                                </div>
                                <!-- @if(filled($selectedPackage->discount))
                                    <p class="mb-2"><span class="badge bg-success">{{ __('admin.discount') }}: {{ $selectedPackage->discount }}%</span></p>
                                @endif
                                @if($selectedPackage->free_months > 0)
                                    <p class="mb-2"><span class="badge bg-info">{{ __('main.free_months') }}: {{ $selectedPackage->free_months }}</span></p>
                                @endif -->
                                @if(!empty($selectedFeatures))
                                    <ul class="mb-0 ps-3">
                                        @foreach($selectedFeatures as $feature)
                                            <li>{{ $feature }}</li>
                                        @endforeach
                                    </ul>
                                @elseif(!empty($selectedFeaturesRaw))
                                    <p class="mb-0">{!! nl2br(e(strip_tags($selectedFeaturesRaw))) !!}</p>
                                @endif
                            </div>
                        @endif

                        {{-- Step Indicators --}}
                        <div class="step-indicators mb-40">
                            <div class="step-indicator active" data-step="1">
                                <span class="step-number">1</span>
                                <span class="step-label">{{ __('main.clinic_main_info') }}</span>
                            </div>
                            <div class="step-indicator" data-step="2">
                                <span class="step-number">2</span>
                                <span class="step-label">{{ __('main.admin_info') }}</span>
                            </div>
                            <div class="step-indicator" data-step="3">
                                <span class="step-number">3</span>
                                <span class="step-label">{{ __('main.verification_info') }}</span>
                            </div>
                            <div class="step-indicator" data-step="4">
                                <span class="step-number">4</span>
                                <span class="step-label">{{ __('main.account_info') }}</span>
                            </div>
                        </div>

                        {{-- Step 1: Clinic Main Info --}}
                        <div class="form-step active" id="step-1">
                            <h5 class="mb-20"><i class="fal fa-hospital me-2"></i>{{ __('main.clinic_main_info') }}</h5>
                            <div class="row">
                                <div class="form-group col-12">
                                    <input type="text" class="form-control @error('clinic_name') is-invalid @enderror" name="clinic_name" value="{{ old('clinic_name') }}" placeholder="{{ __('main.clinic_name') }}" required>
                                    <i class="fal fa-clinic-medical"></i>
                                </div>
                                <div class="form-group col-12">
                                    <select name="specialist" class="form-select nice-select @error('specialist') is-invalid @enderror" required>
                                        <option value="" disabled @if(!old('specialist')) selected @endif hidden>{{ __('main.select_specialist') }}</option>
                                        @foreach($specialists as $specialist)
                                            <option value="{{ $specialist->id }}" @if((string) old('specialist') === (string) $specialist->id) selected @endif>{{ app()->getLocale() === 'ar' ? $specialist->name_ar : $specialist->name_en }}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="form-group col-12">
                                    <input type="text" class="form-control @error('address') is-invalid @enderror" name="address" value="{{ old('address') }}" placeholder="{{ __('main.address') }}" required>
                                    <i class="fal fa-map-marker-alt"></i>
                                </div>
                                <div class="form-group col-md-6">
                                    <input type="tel" class="form-control @error('phone_number') is-invalid @enderror" name="phone_number" value="{{ old('phone_number') }}" placeholder="{{ __('main.phone_number') }}" required>
                                    <i class="fal fa-phone"></i>
                                </div>
                                <div class="form-group col-md-6">
                                    <input type="tel" class="form-control @error('alternative_number') is-invalid @enderror" name="alternative_number" value="{{ old('alternative_number') }}" placeholder="{{ __('main.alternative_number') }}">
                                    <i class="fal fa-phone-alt"></i>
                                </div>
                            </div>
                        </div>

                        {{-- Step 2: Admin Info --}}
                        <div class="form-step" id="step-2">
                            <h5 class="mb-20"><i class="fal fa-user-shield me-2"></i>{{ __('main.admin_info') }}</h5>
                            <div class="row">
                                <div class="form-group col-12">
                                    <input type="text" class="form-control @error('admin_name') is-invalid @enderror" name="admin_name" value="{{ old('admin_name') }}" placeholder="{{ __('main.name') }}" required>
                                    <i class="fal fa-user"></i>
                                </div>
                                <div class="form-group col-md-6">
                                    <input type="email" class="form-control @error('admin_email') is-invalid @enderror" name="admin_email" value="{{ old('admin_email') }}" placeholder="{{ __('main.email') }}" required>
                                    <i class="fal fa-envelope"></i>
                                </div>
                                <div class="form-group col-md-6">
                                    <input type="tel" class="form-control @error('admin_phone') is-invalid @enderror" name="admin_phone" value="{{ old('admin_phone') }}" placeholder="{{ __('main.phone_number') }}" required>
                                    <i class="fal fa-phone"></i>
                                </div>
                            </div>
                        </div>

                        {{-- Step 3: Verification Info --}}
                        <div class="form-step" id="step-3">
                            <h5 class="mb-20"><i class="fal fa-file-certificate me-2"></i>{{ __('main.verification_info') }}</h5>
                            <div class="row">
                                <div class="form-group col-12">
                                    <input type="text" class="form-control @error('clinic_license_number') is-invalid @enderror" name="clinic_license_number" value="{{ old('clinic_license_number') }}" placeholder="{{ __('main.clinic_license_number') }}" required>
                                    <i class="fal fa-id-card"></i>
                                </div>
                                <div class="form-group col-12">
                                    <label class="form-label fw-medium">{{ __('main.medical_commercial_license') }}</label>
                                    <input type="file" class="form-control @error('medical_commercial_license') is-invalid @enderror" name="medical_commercial_license" accept="image/*,.pdf" required>
                                </div>
                            </div>
                        </div>

                        {{-- Step 4: Account Info --}}
                        <div class="form-step" id="step-4">
                            <h5 class="mb-20"><i class="fal fa-lock me-2"></i>{{ __('main.account_info') }}</h5>
                            <div class="row">
                                <div class="form-group col-12">
                                    <input type="email" class="form-control @error('email_address') is-invalid @enderror" name="email_address" value="{{ old('email_address') }}" placeholder="{{ __('main.email_address') }}" required>
                                    <i class="fal fa-envelope"></i>
                                </div>
                                <div class="form-group col-12">
                                    <input type="password" class="form-control @error('password') is-invalid @enderror" name="password" placeholder="{{ __('main.password') }}" required>
                                    <i class="fal fa-lock"></i>
                                </div>
                                <div class="form-group col-12">
                                    <label class="form-label fw-medium mb-2 d-block">{{ __('main.package') }}</label>
                                    <select name="package" id="checkout-package-select" class="form-select nice-select @error('package') is-invalid @enderror" required
                                            data-selected-package="{{ old('package', $selectedPackageId ?? '') }}">
                                        <option value="" disabled @if(!old('package', $selectedPackageId)) selected @endif hidden>{{ __('main.select_package') }}</option>
                                        @foreach($packages as $pkg)
                                            <option value="{{ $pkg->id }}" @if((int) old('package', $selectedPackageId) === (int) $pkg->id) selected @endif>
                                                {{ $packageName($pkg) }}
                                                —
                                                {{ $formatPrice($pkg->price_after_discount ?: $pkg->price) }}
                                                @if($pkg->duration)
                                                    ({{ $pkg->duration }} {{ __('main.days') }})
                                                @endif
                                            </option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                        </div>

                        {{-- Navigation Buttons --}}
                        <div class="form-navigation mt-30 d-flex justify-content-between">
                            <button type="button" class="th-btn th-border btn-prev" style="display:none;">
                                <i class="fal fa-arrow-right mx-2"></i>{{ __('main.previous') }}
                            </button>
                            <button type="button" class="th-btn btn-next ms-auto">
                                {{ __('main.next') }}<i class="fal fa-arrow-left mx-2"></i>
                            </button>
                            <button type="submit" class="th-btn btn-submit ms-auto" style="display:none;">
                                {{ __('main.submit_registration') }}<i class="fal fa-check ms-2"></i>
                            </button>
                        </div>
                        <p class="form-messages mb-0 mt-3"></p>
                    </form>

                    <style>
                        .step-indicators{display:flex;justify-content:space-between;position:relative}
                        .step-indicators::before{content:'';position:absolute;top:20px;left:0;right:0;height:2px;background:#e0e0e0;z-index:0}
                        .step-indicator{display:flex;flex-direction:column;align-items:center;position:relative;z-index:1;flex:1}
                        .step-number{width:40px;height:40px;border-radius:50%;background:#e0e0e0;display:flex;align-items:center;justify-content:center;font-weight:700;color:#666;margin-bottom:8px;transition:all .3s ease}
                        .step-indicator.active .step-number,.step-indicator.completed .step-number{background:var(--theme-color,#3b82f6);color:#fff}
                        .step-indicator.completed .step-number{background:#22c55e}
                        .step-label{font-size:12px;color:#666;text-align:center;white-space:nowrap}
                        .step-indicator.active .step-label{color:var(--theme-color,#3b82f6);font-weight:600}
                        .form-step{display:none}
                        .form-step.active{display:block;animation:stepFadeIn .3s ease}
                        @keyframes stepFadeIn{from{opacity:0;transform:translateY(10px)}to{opacity:1;transform:translateY(0)}}

                        #clinic-registration-form .form-group{position:relative}
                        #clinic-registration-form .form-group>i{position:absolute;top:50%;transform:translateY(-50%);color:#999;pointer-events:none;font-size:15px}

                        html[lang="ar"] #clinic-registration-form .form-group>i{left:35px;right:auto}
                        html[lang="ar"] #clinic-registration-form .form-group .form-control,
                        html[lang="ar"] #clinic-registration-form .form-group .form-select{padding-left:40px;padding-right:15px;text-align:right;direction:rtl}
                        html[lang="ar"] #clinic-registration-form .form-group .form-control::placeholder{text-align:right}
                        html[lang="ar"] #clinic-registration-form .form-group .form-select option{direction:rtl;text-align:right}

                        html:not([lang="ar"]) #clinic-registration-form .form-group>i{right:15px;left:auto}
                        html:not([lang="ar"]) #clinic-registration-form .form-group .form-control,
                        html:not([lang="ar"]) #clinic-registration-form .form-group .form-select{padding-right:40px;padding-left:15px}

                        .btn-prev,.btn-prev:hover,.btn-prev:focus,.btn-prev:active{background:transparent!important;color:var(--theme-color,#3b82f6)!important;border-color:var(--theme-color,#3b82f6)!important;box-shadow:none!important;transform:none!important}
                    </style>

                    <script>
                        document.addEventListener('DOMContentLoaded',function(){
                            var form=document.getElementById('clinic-registration-form');
                            if(!form)return;
                            var steps=form.querySelectorAll('.form-step');
                            var indicators=form.querySelectorAll('.step-indicator');
                            var btnPrev=form.querySelector('.btn-prev');
                            var btnNext=form.querySelector('.btn-next');
                            var btnSubmit=form.querySelector('.btn-submit');
                            var current=0;

                            function show(idx){
                                steps.forEach(function(s,i){
                                    s.classList.toggle('active',i===idx);
                                    indicators[i].classList.toggle('active',i===idx);
                                    indicators[i].classList.toggle('completed',i<idx);
                                });
                                btnPrev.style.display=idx===0?'none':'';
                                btnNext.style.display=idx===steps.length-1?'none':'';
                                btnSubmit.style.display=idx===steps.length-1?'':'none';
                                current=idx;
                            }

                            function validateStep(idx){
                                var fields=steps[idx].querySelectorAll('[required]');
                                var valid=true;
                                fields.forEach(function(f){
                                    if(f.type==='file'?!f.files.length:!f.value){
                                        f.classList.add('is-invalid');
                                        valid=false;
                                    }else{
                                        f.classList.remove('is-invalid');
                                    }
                                });
                                return valid;
                            }

                            btnNext.addEventListener('click',function(){
                                if(validateStep(current)&&current<steps.length-1)show(current+1);
                            });

                            btnPrev.addEventListener('click',function(){
                                if(current>0)show(current-1);
                            });

                            form.addEventListener('submit',function(e){
                                var valid=true;
                                for(var i=0;i<steps.length;i++){
                                    if(!validateStep(i))valid=false;
                                }
                                if(!valid){
                                    e.preventDefault();
                                    for(var j=0;j<steps.length;j++){
                                        if(!validateStep(j)){show(j);break;}
                                    }
                                }
                            });

                            show(0);

                            function syncCheckoutPackageSelect() {
                                var packageSelect = form.querySelector('#checkout-package-select');
                                if (!packageSelect || typeof jQuery === 'undefined' || !jQuery.fn.niceSelect) {
                                    return;
                                }
                                var selectedId = packageSelect.getAttribute('data-selected-package')
                                    || new URLSearchParams(window.location.search).get('package');
                                if (selectedId) {
                                    packageSelect.value = String(selectedId);
                                }
                                var $pkg = jQuery(packageSelect);
                                if ($pkg.next('.nice-select').length) {
                                    $pkg.niceSelect('destroy');
                                }
                                $pkg.niceSelect();
                            }

                            if (typeof jQuery !== 'undefined') {
                                jQuery(function () {
                                    syncCheckoutPackageSelect();
                                    setTimeout(syncCheckoutPackageSelect, 0);
                                });
                            }

                            if (new URLSearchParams(window.location.search).has('package')) {
                                var summary = document.getElementById('selected-package-summary');
                                if (summary) {
                                    summary.scrollIntoView({ behavior: 'smooth', block: 'nearest' });
                                }
                            }
                        });
                    </script>
                </div>

        </div>
    </div>
</div>
