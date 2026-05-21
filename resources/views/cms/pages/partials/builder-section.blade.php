@php
/** @var \Illuminate\Support\Collection<int, \App\Models\CmsLanguage> $languages */
	$section = $section ?? null;
	@endphp
	<div class="card mb-3 section-card border-primary" data-role="section-card">
		<div class="card-header d-flex justify-content-between align-items-center gap-2">
			<div class="d-flex align-items-center gap-2 flex-grow-1 min-w-0">
				<button type="button"
					class="btn btn-sm btn-light border px-1 py-0 flex-shrink-0"
					data-bs-toggle="collapse"
					data-bs-target="#section-collapse-{{ $sidx }}" aria-expanded="true"
					aria-controls="section-collapse-{{ $sidx }}"
					data-role="section-collapse-toggle"
					title="{{ __('cms.toggle_section') }}">
					<i class="mdi mdi-chevron-down"></i>
				</button>
				<strong class="text-truncate">{{ __('cms.section') }}</strong>
				@if($section)
				<span class="small text-muted text-truncate">— {{ $section->name }}</span>
				@endif
			</div>
			<button type="button" class="btn btn-sm btn-outline-danger flex-shrink-0"
				data-role="remove-section">{{ __('cms.remove_section') }}</button>
		</div>
		<div id="section-collapse-{{ $sidx }}" class="collapse show" data-role="section-collapse">
			<div class="card-body">
				@if($section)
				<input type="hidden" name="sections[{{ $sidx }}][id]"
					value="{{ $section->id }}">
				@endif
				<input type="hidden" name="sections[{{ $sidx }}][is_active]" value="0">
				<div class="row g-2 mb-2">
					<div class="col-md-3">
						<label class="form-label">{{ __('cms.internal_name') }}
							*</label>
						<input type="text" class="form-control"
							name="sections[{{ $sidx }}][name]"
							value="{{ old("sections.{$sidx}.name", $section?->name ?? '') }}">
					</div>
					<div class="col-md-2">
						<label class="form-label">{{ __('cms.type') }} *</label>
						@php
						$sectionTypeCanonical = ['default', 'hero', 'features',
						'about-us', 'services', 'why-choose-us', 'download-app',
						'gallery', 'testimonial', 'content', 'cta'];
						if (($pageSlug ?? '') === 'subscription') {
						$sectionTypeCanonical =
						array_values(array_unique(array_merge(['subscription',
						'checkout'], $sectionTypeCanonical)));
						}
						$tp = trim((string) old('sections.'.$sidx.'.type',
						$section?->type ?? 'default'));
						if ($tp === '') {
						$tp = 'default';
						}
						$sectionTypeOptions = $sectionTypeCanonical;
						if (! in_array($tp, $sectionTypeOptions, true)) {
						$sectionTypeOptions[] = $tp;
						}
						@endphp
						<select class="form-select"
							name="sections[{{ $sidx }}][type]">
							@foreach($sectionTypeOptions as $opt)
							<option value="{{ $opt }}"
								{{ $tp === $opt ? 'selected' : '' }}>
								{{ $opt }}</option>
							@endforeach
						</select>
					</div>
					<div class="col-md-2">
						<label class="form-label">{{ __('cms.template') }}</label>
						<input type="text" class="form-control"
							name="sections[{{ $sidx }}][template]"
							value="{{ old('sections.'.$sidx.'.template', $section?->template ?? '') }}">
					</div>
					<div class="col-md-1">
						<label class="form-label">{{ __('cms.order') }}</label>
						<input type="number" class="form-control"
							name="sections[{{ $sidx }}][order]"
							value="{{ old('sections.'.$sidx.'.order', $section?->order ?? 0) }}">
					</div>
					<div class="col-md-2">
						@php $sectionActiveId = 'section-active-'.$sidx; @endphp
						<div
							class="d-flex align-items-center justify-content-between gap-2 mt-4">
							<label class="form-label mb-0"
								for="{{ $sectionActiveId }}">{{ __('cms.active') }}</label>
							<div class="form-check form-switch m-0">
								<input type="checkbox"
									class="form-check-input"
									role="switch"
									id="{{ $sectionActiveId }}"
									name="sections[{{ $sidx }}][is_active]"
									value="1"
									{{ old('sections.'.$sidx.'.is_active', $section?->is_active ?? true) ? 'checked' : '' }}>
							</div>
						</div>
					</div>
				</div>
				<p class="text-muted small mb-1">{{ __('cms.section_translations') }}</p>
				@php $sectionTabPrefix = 'section-'.$sidx; @endphp
				@if($languages->isEmpty())
				<div class="alert alert-warning small mb-0">
					{{ __('cms.no_languages_configured') }}
				</div>
				@else
				<div data-role="section-lang-tabs" class="section-lang-tabs cms-lang-tabs">
					<ul class="nav nav-tabs mb-2" role="tablist">
						@foreach($languages as $index => $lang)
						<li class="nav-item" role="presentation">
							<button class="nav-link {{ $index === 0 ? 'active' : '' }}"
								id="{{ $sectionTabPrefix }}-tab-{{ $lang->code }}"
								data-bs-toggle="tab"
								data-bs-target="#{{ $sectionTabPrefix }}-pane-{{ $lang->code }}"
								type="button" role="tab">
								{{ $lang->flag ?? '' }}
								{{ $lang->name }}
							</button>
						</li>
						@endforeach
					</ul>
					<div class="tab-content">
						@foreach($languages as $index => $lang)
						@php
						$tr = $section ? $section->translations->where('locale',
						$lang->code)->first() :
						null;
						@endphp
						<div class="tab-pane fade {{ $index === 0 ? 'show active' : '' }}"
							id="{{ $sectionTabPrefix }}-pane-{{ $lang->code }}"
							role="tabpanel"
							aria-labelledby="{{ $sectionTabPrefix }}-tab-{{ $lang->code }}">
							<div class="row g-2 mb-2">
								<div class="col-md-4">
									<label
										class="form-label small mb-0">{{ __('cms.title') }}
										({{ $lang->code }})</label>
									<input type="text"
										class="form-control form-control-sm"
										name="sections[{{ $sidx }}][translations][{{ $lang->code }}][title]"
										value="{{ old('sections.'.$sidx.'.translations.'.$lang->code.'.title', $tr->title ?? '') }}"
										dir="{{ $lang->direction }}">
								</div>
								<div class="col-md-4">
									<label
										class="form-label small mb-0">{{ __('cms.subtitle') }}</label>
									<input type="text"
										class="form-control form-control-sm"
										name="sections[{{ $sidx }}][translations][{{ $lang->code }}][subtitle]"
										value="{{ old('sections.'.$sidx.'.translations.'.$lang->code.'.subtitle', $tr->subtitle ?? '') }}"
										dir="{{ $lang->direction }}">
								</div>
								<div class="col-12">
									<label
										class="form-label small mb-0">{{ __('cms.description') }}</label>
									<!-- <textarea class="form-control form-control-sm" rows="2"
									name="sections[{{ $sidx }}][translations][{{ $lang->code }}][description]"
									dir="{{ $lang->direction }}">{{ old('sections.'.$sidx.'.translations.'.$lang->code.'.description', $tr->description ?? '') }}</textarea> -->

									@include('components.rich-text-editor',
									[
									'inputId' =>
									'section-desc-'.$sidx.'-'.$lang->code,
									'inputName' =>
									'sections['.$sidx.'][translations]['.$lang->code.'][description]',
									'label' =>
									__('cms.description') .
									' (' . $lang->name . ')',
									'value' =>
									old("sections.{$sidx}.translations.{$lang->code}.description",
									$tr?->description ?? ''),
									'direction' =>
									$lang->direction,
									'placeholder' =>
									__('cms.enter_description'),
									'tabPaneId' =>
									$sectionTabPrefix.'-pane-'.$lang->code,
									])
								</div>
							</div>
						</div>
						@endforeach
					</div>
				</div>
				@endif
				@include('components.gallery-upload', [
				'deferGalleryInit' => true,
				'inputId' => 'section-gallery-'.$sidx,
				'inputName' => 'sections['.$sidx.'][gallery]',
				'collection' => 'gallery',
				'label' => __('cms.gallery_images'),
				'existingImages' => ($section ?? null) ? $section->getMedia('gallery') :
				collect([]),
				])
				<hr>
				<div class="d-flex justify-content-between align-items-center mb-2">
					<span class="fw-semibold">{{ __('cms.section_links') }}</span>
					<button type="button" class="btn btn-sm btn-outline-primary"
						data-role="add-section-link">{{ __('cms.add_link') }}</button>
				</div>
				<div class="section-links-wrap mb-3" data-role="section-links">
					@if($section && $section->relationLoaded('links') &&
					$section->links->isNotEmpty())
					@foreach($section->links->sortBy('order') as $lnk)
					@include('cms.pages.partials.builder-link-row', [
					'languages' => $languages,
					'namePrefix' => 'sections['.$sidx.'][links]['.$loop->index.']',
					'link' => $lnk,
					])
					@endforeach
					@endif
				</div>
				<div class="d-flex justify-content-between align-items-center mb-2">
					<span class="fw-semibold">{{ __('cms.items') }}</span>
					<button type="button" class="btn btn-sm btn-primary"
						data-role="add-item">{{ __('cms.add_item') }}</button>
				</div>
				<div class="items-wrap" data-role="items-wrap">
					@if($section && $section->relationLoaded('items') &&
					$section->items->isNotEmpty())
					@foreach($section->items->sortBy('order') as $it)
					@include('cms.pages.partials.builder-item', [
					'languages' => $languages,
					'sidx' => $sidx,
					'iidx' => $loop->index,
					'item' => $it,
					])
					@endforeach
					@endif
				</div>
			</div>
		</div>
	</div>
