@extends('layout_new.mainlayout')

@section('content')
    <div  class="page-wrapper" style="padding:10px">
	<!-- Page Title -->
	<div class="row">
		<div class="col-12">
			<div class="page-title-box">
				<div class="page-title-right">
					<a href="{{ route('cms.items.index') }}" class="btn btn-secondary">
						<i class="mdi mdi-arrow-left"></i> {{ __('Back') }}
					</a>
				</div>
				<h4 class="page-title">{{ __('Edit Item') }}</h4>
			</div>
		</div>
	</div>

	<form action="{{ route('cms.items.update', $item) }}" method="POST" enctype="multipart/form-data">
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
									type="button" role="tab">
									{{ $lang->flag ?? '' }}
									{{ $lang->name }}
								</button>
							</li>
							@endforeach
						</ul>

						<div class="tab-content pt-3" id="languageTabsContent">
							@foreach($languages as $index => $lang)
							@php
							$translation =
							$item->translations->where('locale',
							$lang->code)->first();
							@endphp
							<div class="tab-pane fade {{ $index === 0 ? 'show active' : '' }}"
								id="content-{{ $lang->code }}"
								role="tabpanel">

								<div class="mb-3">
									<label class="form-label">
										{{ __('Title') }}
										({{ $lang->name }})
										<span
											class="text-danger">*</span>
									</label>
									<input type="text"
										class="form-control @error('translations.'.$lang->code.'.title') is-invalid @enderror"
										name="translations[{{ $lang->code }}][title]"
										value="{{ old('translations.'.$lang->code.'.title', $translation->title ?? '') }}"
										dir="{{ $lang->direction }}">
									@error('translations.'.$lang->code.'.title')
									<div class="invalid-feedback">
										{{ $message }}</div>
									@enderror
								</div>

								<div class="mb-3">
									<label class="form-label">{{ __('Subtitle') }}
										({{ $lang->name }})</label>
									<input type="text"
										class="form-control"
										name="translations[{{ $lang->code }}][sub_title]"
										value="{{ old('translations.'.$lang->code.'.sub_title', $translation->sub_title ?? '') }}"
										dir="{{ $lang->direction }}">
								</div>

								@include('components.rich-text-editor',
								[
								'inputId' => 'item_content_' .
								$lang->code,
								'inputName' => 'translations[' .
								$lang->code . '][content]',
								'label' => __('Content') . ' (' .
								$lang->name . ')',
								'value' =>
								old('translations.'.$lang->code.'.content',
								$translation->content ?? ''),
								'direction' => $lang->direction,
								'placeholder' => __('Enter content...')
								])

								<div class="mb-3">
									<label class="form-label">{{ __('Icon') }}
										({{ $lang->name }})</label>
									@include('components.icon-picker',
									[
									'inputId' => 'icon_' .
									$lang->code,
									'inputName' => 'translations['
									. $lang->code . '][icon]',
									'value' => old('translations.'
									. $lang->code . '.icon',
									$translation->icon ?? '')
									])
								</div>

								<!-- Image Upload Fields for this Language -->
								<hr class="my-3">
								<h6 class="mb-3">{{ __('Images') }}
									({{ $lang->name }})</h6>

								@include('components.image-upload',
								[
								'inputId' => 'item_image_' .
								$lang->code,
								'inputName' => 'translations[' .
								$lang->code . '][image]',
								'collection' => 'images_' . $lang->code,
								'label' => __('Main Image'),
								'existingImage' =>
								$item->getFirstMediaUrl('images_' .
								$lang->code)
								])

								@include('components.image-upload',
								[
								'inputId' => 'item_icon_' . $lang->code,
								'inputName' => 'translations[' .
								$lang->code . '][icon_image]',
								'collection' => 'icons_' . $lang->code,
								'label' => __('Icon Image'),
								'existingImage' =>
								$item->getFirstMediaUrl('icons_' .
								$lang->code)
								])
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
						<h5 class="card-title mb-0">{{ __('Item Settings') }}</h5>
					</div>
					<div class="card-body">
						<div class="mb-3">
							<label class="form-label">{{ __('Slug') }}</label>
							<input type="text"
								class="form-control @error('slug') is-invalid @enderror"
								name="slug"
								value="{{ old('slug', $item->slug) }}">
							@error('slug')
							<div class="invalid-feedback">{{ $message }}</div>
							@enderror
						</div>

						<div class="mb-3">
							<label class="form-label">{{ __('Section') }}
							</label>
							<select class="form-select @error('cms_section_id') is-invalid @enderror"
								name="cms_section_id">
								<option value="">
									{{ __('Select Section') }}
								</option>
								@foreach($sections as $section)
								<option value="{{ $section->id }}"
									{{ old('cms_section_id', $item->cms_section_id) == $section->id ? 'selected' : '' }}>
									{{ $section->page->name ?? '' }}
									- {{ $section->name }}
								</option>
								@endforeach
							</select>
							@error('cms_section_id')
							<div class="invalid-feedback">{{ $message }}</div>
							@enderror
						</div>

						<div class="mb-3">
							<label
								class="form-label">{{ __('Order') }}</label>
							<input type="number" class="form-control"
								name="order"
								value="{{ old('order', $item->order) }}">
						</div>

						<div class="mb-3">
							<div class="form-check form-switch">
								<input type="checkbox"
									class="form-check-input"
									name="is_active"
									id="is_active" value="1"
									{{ old('is_active', $item->is_active) ? 'checked' : '' }}>
								<label class="form-check-label"
									for="is_active">{{ __('Active') }}</label>
							</div>
						</div>

						<div class="d-grid">
							<button type="submit" class="btn btn-primary">
								<i class="mdi mdi-content-save"></i>
								{{ __('Update Item') }}
							</button>
						</div>
					</div>
				</div>

				<!-- Item Info -->
				<div class="card mt-3">
					<div class="card-header">
						<h5 class="card-title mb-0">{{ __('Item Info') }}</h5>
					</div>
					<div class="card-body">
						<p class="mb-1"><strong>{{ __('Section') }}:</strong>
							{{ $item->section->name ?? '-' }}</p>
						<p class="mb-1"><strong>{{ __('Created') }}:</strong>
							{{ $item->created_at->format('Y-m-d H:i') }}</p>
						<p class="mb-0"><strong>{{ __('Updated') }}:</strong>
							{{ $item->updated_at->format('Y-m-d H:i') }}</p>
					</div>
				</div>
			</div>
		</div>


		<!-- Gallery Section -->
		<div class="col-lg-12 mt-3">
			<div class="card">
				<div class="card-header">
					<h5 class="card-title mb-0">{{ __('Gallery') }}</h5>
				</div>
				<div class="card-body">
					@include('components.gallery-upload', [
					'inputId' => 'item_gallery',
					'inputName' => 'gallery',
					'collection' => 'gallery',
					'label' => __('Gallery Images'),
					'existingImages' => $item->getMedia('gallery')
					])
				</div>
			</div>
		</div>

	</form>
</div>
@endsection
