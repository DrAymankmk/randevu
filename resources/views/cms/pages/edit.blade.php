@extends('layout_new.mainlayout')

@section('content')
<div  class="page-wrapper" style="padding:10px">
    <!-- Page Title -->
    <div class="row">
        <div class="col-12">
            <div class="page-title-box">
                <div class="page-title-right">
                    <a href="{{ route('cms.pages.index') }}" class="btn btn-secondary">
                        <i class="mdi mdi-arrow-left"></i> {{ __('Back') }}
                    </a>
                    <a href="{{ route('cms.pages.builder.edit', $page->id) }}" class="btn btn-primary">
                        <i class="mdi mdi-view-dashboard-variant"></i> {{ __('Page builder') }}
                    </a>
                </div>
                <h4 class="page-title">{{ __('Edit Page') }}: {{ $page->name }}</h4>
            </div>
        </div>
    </div>

    <form action="{{ route('cms.pages.update', $page->id) }}" method="POST">
        @csrf
        @method('PUT')
        
        <div class="row">
            <!-- Main Content -->
            <div class="col-lg-8">
                <div class="card">
                    <div class="card-header">
                        <h5 class="card-title mb-0">{{ __('Translations') }}</h5>
                    </div>
                    <div class="card-body">
                        <!-- Language Tabs -->
                        <ul class="nav nav-tabs" id="languageTabs" role="tablist">
                            @foreach($languages as $index => $lang)
                            <li class="nav-item" role="presentation">
                                <button class="nav-link {{ $index === 0 ? 'active' : '' }}" 
                                        id="tab-{{ $lang->code }}" 
                                        data-bs-toggle="tab" 
                                        data-bs-target="#content-{{ $lang->code }}" 
                                        type="button" 
                                        role="tab">
                                    {{ $lang->flag ?? '' }} {{ $lang->name }}
                                    @if($lang->is_default)
                                    <span class="badge bg-success ms-1">{{ __('Default') }}</span>
                                    @endif
                                </button>
                            </li>
                            @endforeach
                        </ul>
                        
                        <div class="tab-content pt-3" id="languageTabsContent">
                            @foreach($languages as $index => $lang)
                            @php
                                $translation = $page->translations->where('locale', $lang->code)->first();
                            @endphp
                            <div class="tab-pane fade {{ $index === 0 ? 'show active' : '' }}" 
                                 id="content-{{ $lang->code }}" 
                                 role="tabpanel">
                                
                                <div class="mb-3">
                                    <label class="form-label">
                                        {{ __('Title') }} ({{ $lang->name }}) 
                                        <span class="text-danger">*</span>
                                    </label>
                                    <input type="text" 
                                           class="form-control @error('translations.'.$lang->code.'.title') is-invalid @enderror" 
                                           name="translations[{{ $lang->code }}][title]" 
                                           value="{{ old('translations.'.$lang->code.'.title', $translation->title ?? '') }}"
                                           dir="{{ $lang->direction }}"
                                           required>
                                    @error('translations.'.$lang->code.'.title')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                @include('components.rich-text-editor', [
                                    'inputId' => 'page_meta_description_' . $lang->code,
                                    'inputName' => 'translations[' . $lang->code . '][meta_description]',
                                    'label' => __('Meta Description') . ' (' . $lang->name . ')',
                                    'value' => old('translations.'.$lang->code.'.meta_description', $translation->meta_description ?? ''),
                                    'direction' => $lang->direction,
                                    'placeholder' => __('Enter meta description...')
                                ])

                                <div class="mb-3">
                                    <label class="form-label">{{ __('Meta Keywords') }} ({{ $lang->name }})</label>
                                    <input type="text" 
                                           class="form-control" 
                                           name="translations[{{ $lang->code }}][meta_keywords]" 
                                           value="{{ old('translations.'.$lang->code.'.meta_keywords', $translation->meta_keywords ?? '') }}"
                                           dir="{{ $lang->direction }}"
                                           placeholder="{{ __('keyword1, keyword2, keyword3') }}">
                                </div>
                            </div>
                            @endforeach
                        </div>
                    </div>
                </div>
            </div>



            <!-- Sidebar -->
            <div class="col-lg-4">
                <div class="card">
                    <div class="card-header">
                        <h5 class="card-title mb-0">{{ __('Page Settings') }}</h5>
                    </div>
                    <div class="card-body">
                        <div class="mb-3">
                            <label class="form-label">{{ __('Internal Name') }} <span class="text-danger">*</span></label>
                            <input type="text" 
                                   class="form-control @error('name') is-invalid @enderror" 
                                   name="name" 
                                   value="{{ old('name', $page->name) }}"
                                   required>
                            <small class="text-muted">{{ __('For admin identification only') }}</small>
                            @error('name')
                            <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label class="form-label">{{ __('Slug') }} <span class="text-danger">*</span></label>
                            <input type="text" 
                                   class="form-control @error('slug') is-invalid @enderror" 
                                   name="slug" 
                                   value="{{ old('slug', $page->slug) }}"
                                   required>
                            <small class="text-muted">{{ __('URL-friendly identifier') }}</small>
                            @error('slug')
                            <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label class="form-label">{{ __('Order') }}</label>
                            <input type="number" 
                                   class="form-control" 
                                   name="order" 
                                   value="{{ old('order', $page->order) }}">
                        </div>

                        <div class="mb-3">
                            <div class="form-check form-switch">
                                <input type="checkbox" 
                                       class="form-check-input" 
                                       name="is_active" 
                                       id="is_active"
                                       value="1"
                                       {{ old('is_active', $page->is_active) ? 'checked' : '' }}>
                                <label class="form-check-label" for="is_active">{{ __('Active') }}</label>
                            </div>
                        </div>

                        <div class="d-grid">
                            <button type="submit" class="btn btn-primary">
                                <i class="mdi mdi-content-save"></i> {{ __('Update Page') }}
                            </button>
                        </div>
                    </div>
                </div>

                <!-- Page Info -->
                <div class="card mt-3">
                    <div class="card-header">
                        <h5 class="card-title mb-0">{{ __('Page Info') }}</h5>
                    </div>
                    <div class="card-body">
                        <p class="mb-1"><strong>{{ __('Created') }}:</strong> {{ $page->created_at->format('Y-m-d H:i') }}</p>
                        <p class="mb-1"><strong>{{ __('Updated') }}:</strong> {{ $page->updated_at->format('Y-m-d H:i') }}</p>
                        <p class="mb-0"><strong>{{ __('Sections') }}:</strong> 
                            <a href="{{ route('cms.sections.index', ['page_id' => $page->id]) }}">
                                {{ $page->sections->count() }} {{ __('sections') }}
                            </a>
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </form>
</div>
@endsection


