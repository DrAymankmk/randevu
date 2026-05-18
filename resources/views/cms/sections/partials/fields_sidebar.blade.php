<div class="card">
    <div class="card-header">
        <h5 class="card-title mb-0">{{ __('Section Settings') }}</h5>
    </div>
    <div class="card-body">
        <div class="mb-3">
            <label class="form-label">{{ __('Page') }} <span class="text-danger">*</span></label>
            <select class="form-select @error('cms_page_id') is-invalid @enderror" 
                    name="cms_page_id" required>
                <option value="">{{ __('Select Page') }}</option>
                @foreach($pages as $page)
                <option value="{{ $page->id }}" {{ old('cms_page_id', isset($section) ? $section->cms_page_id : ($selectedPageId ?? '')) == $page->id ? 'selected' : '' }}>
                    {{ $page->name }}
                </option>
                @endforeach
            </select>
            @error('cms_page_id')
            <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>

        <div class="mb-3">
            <label class="form-label">{{ __('Internal Name') }} <span class="text-danger">*</span></label>
            <input type="text" 
                   class="form-control @error('name') is-invalid @enderror" 
                   name="name" 
                   value="{{ old('name', $section->name ?? '') }}"
                   required>
            @error('name')
            <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>

        <div class="mb-3">
            <label class="form-label">{{ __('Type') }} <span class="text-danger">*</span></label>
            <select class="form-select @error('type') is-invalid @enderror" name="type" required>
                <option value="default" {{ old('type', $section->type ?? '') == 'default' ? 'selected' : '' }}>{{ __('Default') }}</option>
                <option value="hero" {{ old('type', $section->type ?? '') == 'hero' ? 'selected' : '' }}>{{ __('Hero') }}</option>
                <option value="gallery" {{ old('type', $section->type ?? '') == 'gallery' ? 'selected' : '' }}>{{ __('Gallery') }}</option>
                <option value="testimonial" {{ old('type', $section->type ?? '') == 'testimonial' ? 'selected' : '' }}>{{ __('Testimonial') }}</option>
                <option value="features" {{ old('type', $section->type ?? '') == 'features' ? 'selected' : '' }}>{{ __('Features') }}</option>
                <option value="cta" {{ old('type', $section->type ?? '') == 'cta' ? 'selected' : '' }}>{{ __('Call to Action') }}</option>
                <option value="content" {{ old('type', $section->type ?? '') == 'content' ? 'selected' : '' }}>{{ __('Content') }}</option>
            </select>
            @error('type')
            <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>

        <div class="mb-3">
            <label class="form-label">{{ __('Template') }}</label>
            <input type="text" 
                   class="form-control" 
                   name="template" 
                   value="{{ old('template', $section->template ?? '') }}"
                   placeholder="sections.hero">
            <small class="text-muted">{{ __('Blade template name') }}</small>
        </div>

        <div class="mb-3">
            <label class="form-label">{{ __('Order') }}</label>
            <input type="number" 
                   class="form-control" 
                   name="order" 
                   value="{{ old('order', $section->order ?? 0) }}">
        </div>

        <div class="mb-3">
            <div class="form-check form-switch">
                <input type="checkbox" 
                       class="form-check-input" 
                       name="is_active" 
                       id="is_active"
                       value="1"
                       {{ old('is_active', $section->is_active ?? true) ? 'checked' : '' }}>
                <label class="form-check-label" for="is_active">{{ __('Active') }}</label>
            </div>
        </div>

        <div class="d-grid">
            <button type="submit" class="btn btn-primary">
                <i class="mdi mdi-content-save"></i> {{ isset($section) ? __('Update Section') : __('Save Section') }}
            </button>
        </div>
    </div>
</div>
