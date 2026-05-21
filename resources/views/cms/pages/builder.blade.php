@extends('layout_new.mainlayout')

@php
$isEdit = $page !== null;
@endphp

@section('content')
<div class="page-wrapper" style="padding:10px">
	<div class="row">
		<div class="col-12">
			<div
				class="page-title-box d-flex flex-wrap justify-content-between align-items-center gap-2">
				<h4 class="page-title mb-0">
					{{ $isEdit ? __('cms.page_builder') . ': ' . $page->name : __('cms.new_page_builder') }}
				</h4>
				<div class="d-flex flex-wrap gap-2">
					<a href="{{ route('cms.pages.index') }}"
						class="btn btn-secondary btn-sm">
						<i class="mdi mdi-arrow-left"></i> {{ __('cms.back') }}
					</a>
					@if($isEdit)
					<a href="{{ route('cms.pages.edit', $page->id) }}"
						class="btn btn-outline-secondary btn-sm">{{ __('cms.page_settings_only') }}</a>
					@endif
				</div>
			</div>
		</div>
	</div>

	@if(session('success'))
	<div class="alert alert-success alert-dismissible fade show" role="alert">
		{{ session('success') }}
		<button type="button" class="btn-close" data-bs-dismiss="alert"></button>
	</div>
	@endif

	@if ($errors->any())
	<div class="alert alert-danger">
		<ul class="mb-0">
			@foreach ($errors->all() as $err)
			<li>{{ $err }}</li>
			@endforeach
		</ul>
	</div>
	@endif

	@include('components.rich-text-editor-assets')

	<form method="post"
		action="{{ $isEdit ? route('cms.pages.builder.update', $page->id) : route('cms.pages.builder.store') }}"
		id="page-builder-form" enctype="multipart/form-data" novalidate>
		@csrf
		@if($isEdit)
		@method('PUT')
		@endif

		<div class="row">
			<div class="col-lg-8 position-relative" style="z-index:2">
				<div class="card mb-3">
					<div class="card-header">
						<h5 class="card-title mb-0">{{ __('cms.page_content_seo') }}
						</h5>
					</div>
					<div class="card-body">
						@if($languages->isEmpty())
						<div class="alert alert-warning mb-0">
							{{ __('cms.no_active_cms_languages') }}
						</div>
						@else
						<div data-role="page-lang-tabs" class="cms-lang-tabs">
							<ul class="nav nav-tabs mb-2" role="tablist">
								@foreach($languages as $index => $lang)
								<li class="nav-item"
									role="presentation">
									<button class="nav-link {{ $index === 0 ? 'active' : '' }}"
										id="pt-tab-{{ $lang->code }}"
										type="button"
										data-bs-toggle="tab"
										data-bs-target="#pt-{{ $lang->code }}"
										role="tab"
										aria-controls="pt-{{ $lang->code }}"
										aria-selected="{{ $index === 0 ? 'true' : 'false' }}">{{ $lang->flag ?? '' }}
										{{ $lang->name }}</button>
								</li>
								@endforeach
							</ul>
							<div class="tab-content pt-3">
								@foreach($languages as $index => $lang)
								@php
								$pt = $isEdit ?
								$page->translations->where('locale',
								$lang->code)->first() : null;
								@endphp
								<div class="tab-pane fade {{ $index === 0 ? 'show active' : '' }}"
									id="pt-{{ $lang->code }}"
									role="tabpanel"
									aria-labelledby="pt-tab-{{ $lang->code }}">
									<div class="mb-3">
										<label
											class="form-label">{{ __('cms.title') }}
											({{ $lang->code }})
											*</label>
										<input type="text"
											class="form-control"
											name="translations[{{ $lang->code }}][title]"
											value="{{ old('translations.'.$lang->code.'.title', $pt->title ?? '') }}"
											dir="{{ $lang->direction }}">
									</div>
									<div class="mb-3">
										<label
											class="form-label">{{ __('cms.meta_description') }}</label>
										<textarea class="form-control"
											rows="2"
											name="translations[{{ $lang->code }}][meta_description]"
											dir="{{ $lang->direction }}">{{ old('translations.'.$lang->code.'.meta_description', $pt->meta_description ?? '') }}</textarea>
									</div>
									<div class="mb-0">
										<label
											class="form-label">{{ __('cms.meta_keywords') }}</label>
										<input type="text"
											class="form-control"
											name="translations[{{ $lang->code }}][meta_keywords]"
											value="{{ old('translations.'.$lang->code.'.meta_keywords', $pt->meta_keywords ?? '') }}"
											dir="{{ $lang->direction }}">
									</div>
								</div>
								@endforeach
							</div>
						</div>
						@endif
					</div>
				</div>

				<div class="card mb-3">
					<div
						class="card-header d-flex justify-content-between align-items-center">
						<h5 class="card-title mb-0">{{ __('cms.page_links') }}</h5>
						<button type="button" class="btn btn-sm btn-outline-primary"
							id="btn-add-page-link">{{ __('cms.add_link') }}</button>
					</div>
					<div class="card-body" id="page-links-wrap">
						@if($isEdit && $page->links->isNotEmpty())
						@foreach($page->links->sortBy('order') as $pli => $plink)
						@include('cms.pages.partials.builder-link-row', [
						'languages' => $languages,
						'namePrefix' => 'page_links['.$loop->index.']',
						'link' => $plink,
						])
						@endforeach
						@endif
					</div>
				</div>

				<div class="d-flex justify-content-between align-items-center mb-2">
					<h5 class="mb-0">{{ __('cms.sections_items') }}</h5>
					<button type="button" class="btn btn-primary" id="btn-add-section">
						<i class="mdi mdi-plus"></i> {{ __('cms.add_section') }}
					</button>
				</div>
				<div id="sections-container">
					@if($isEdit)
					@foreach($page->sections as $sidx => $section)
					@include('cms.pages.partials.builder-section', [
					'languages' => $languages,
					'sidx' => $loop->index,
					'section' => $section,
					'pageSlug' => $page->slug ?? '',
					])
					@endforeach
					@endif
				</div>
			</div>

			<div class="col-lg-4">
				<div class="card sticky-top" style="top:10px; z-index:1;">
					<div class="card-header">
						<h5 class="card-title mb-0">{{ __('cms.publish') }}</h5>
					</div>
					<div class="card-body">
						<div class="mb-3">
							<label class="form-label">{{ __('cms.internal_name') }}
								*</label>
							<input type="text" class="form-control" required
								name="name"
								value="{{ old('name', $isEdit ? $page->name : '') }}">
						</div>
						<div class="mb-3">
							<label class="form-label">{{ __('cms.slug') }}
								*</label>
							<input type="text" class="form-control" required
								name="slug"
								value="{{ old('slug', $isEdit ? $page->slug : '') }}">
						</div>
						<div class="mb-3">
							<label
								class="form-label">{{ __('cms.order') }}</label>
							<input type="number" class="form-control"
								name="order"
								value="{{ old('order', $isEdit ? $page->order : 0) }}">
						</div>
						<div
							class="d-flex align-items-center justify-content-between gap-3 mb-3">
							<label class="form-label mb-0 flex-grow-1"
								for="page-active">{{ __('cms.page_active') }}</label>
							<div
								class="form-check form-switch m-0 flex-shrink-0">
								<input class="form-check-input"
									type="checkbox" role="switch"
									name="is_active" value="1"
									id="page-active"
									{{ old('is_active', $isEdit ? $page->is_active : true) ? 'checked' : '' }}>
							</div>
						</div>
						<button type="submit" class="btn btn-success w-100">
							<i class="mdi mdi-content-save"></i>
							{{ $isEdit ? __('cms.save_page_builder') : __('cms.create_page') }}
						</button>
					</div>
				</div>
			</div>
		</div>
	</form>

	<div id="section-prototype" class="d-none" aria-hidden="true">
		@include('cms.pages.partials.builder-section', ['sidx' => '__SIDX__', 'section' => null, 'languages'
		=> $languages, 'pageSlug' => $page->slug ?? ''])
	</div>
	<div id="item-prototype" class="d-none" aria-hidden="true">
		@include('cms.pages.partials.builder-item', ['sidx' => '__SIDX__', 'iidx' => '__IIDX__', 'item' =>
		null, 'languages' => $languages])
	</div>
	<div id="link-prototype" class="d-none" aria-hidden="true">
		@include('cms.pages.partials.builder-link-row', ['namePrefix' => '__PREFIX__', 'link' => null,
		'languages' => $languages])
	</div>
</div>
@endsection

@push('styles')
<style>
.section-card [data-role="section-collapse-toggle"] .mdi-chevron-down,
.item-card [data-role="item-collapse-toggle"] .mdi-chevron-down {
	transition: transform 0.2s ease;
	display: inline-block;
}

.section-card [data-role="section-collapse-toggle"].collapsed .mdi-chevron-down,
.item-card [data-role="item-collapse-toggle"].collapsed .mdi-chevron-down {
	transform: rotate(-90deg);
}
</style>
@endpush

@push('scripts')
<script>
(function($) {
	function syncSectionBuilderIds($card, si) {
		var base = 'section-' + si;
		var $langBlock = $card.find('[data-role="section-lang-tabs"]').first();
		if ($langBlock.length) {
			$langBlock.find('.nav.nav-tabs button[data-bs-toggle="tab"]').each(function() {
				var $b = $(this);
				var target = $b.attr('data-bs-target');
				if (!target || target.charAt(0) !== '#') {
					return;
				}
				var rest = target.slice(1);
				var idx = rest.indexOf('-pane-');
				if (idx === -1) {
					return;
				}
				var lang = rest.slice(idx + '-pane-'.length);
				var paneId = base + '-pane-' + lang;
				var tabId = base + '-tab-' + lang;
				$b.attr('id', tabId);
				$b.attr('data-bs-target', '#' + paneId);
			});
			$langBlock.find('.tab-content .tab-pane[role="tabpanel"]').each(function() {
				var $pane = $(this);
				var aria = $pane.attr('aria-labelledby');
				if (!aria) {
					return;
				}
				var parts = aria.split('-tab-');
				if (parts.length < 2) {
					return;
				}
				var lang = parts.slice(1).join('-tab-');
				var tabId = base + '-tab-' + lang;
				var paneId = base + '-pane-' + lang;
				$pane.attr('id', paneId);
				$pane.attr('aria-labelledby', tabId);
			});
		}
		$card.find('label[for^="section-active-"]').attr('for', 'section-active-' + si);
		$card.find('input[type="checkbox"][name*="[is_active]"]').filter(function() {
			return $(this).closest('.item-card').length === 0;
		}).attr('id', 'section-active-' + si);
		$card.find('.cms-quill-root').each(function() {
			var wrap = this;
			var $ta = $(wrap).find(
				'textarea[name*="[translations]"][name*="[description]"]'
			);
			if (!$ta.length) {
				return;
			}
			var n = $ta.attr('name');
			var m = n.match(
				/\[translations\]\[([^\]]+)\]\[description\]/
			);
			if (!m) {
				return;
			}
			var lang = m[1];
			var tid = 'section-desc-' + si + '-' + lang;
			var eid = 'editor-' + tid;
			wrap.setAttribute('data-quill-editor-id', eid);
			wrap.setAttribute('data-quill-textarea-id', tid);
			wrap.setAttribute('data-quill-tab-pane', base + '-pane-' +
				lang);
			$(wrap).find('div[id^="editor-"]').first().attr('id', eid);
			$ta.attr('id', tid);
		});
		var secCol = 'section-collapse-' + si;
		$card.find('[data-role="section-collapse"]').attr('id', secCol);
		$card.find('[data-role="section-collapse-toggle"]').attr('data-bs-target', '#' + secCol)
			.attr('aria-controls', secCol);
	}

	function syncItemBuilderIds($itemCard, si, ii) {
		var base = 'item-' + si + '-' + ii;
		var $langBlock = $itemCard.find('[data-role="item-lang-tabs"]').first();
		if ($langBlock.length) {
			$langBlock.find('.nav.nav-tabs button[data-bs-toggle="tab"]').each(function() {
				var $b = $(this);
				var target = $b.attr('data-bs-target');
				if (!target || target.charAt(0) !== '#') {
					return;
				}
				var rest = target.slice(1);
				var idx = rest.indexOf('-pane-');
				if (idx === -1) {
					return;
				}
				var lang = rest.slice(idx + '-pane-'.length);
				var paneId = base + '-pane-' + lang;
				var tabId = base + '-tab-' + lang;
				$b.attr('id', tabId);
				$b.attr('data-bs-target', '#' + paneId);
			});
			$langBlock.find('.tab-content .tab-pane[role="tabpanel"]').each(function() {
				var $pane = $(this);
				var aria = $pane.attr('aria-labelledby');
				if (!aria) {
					return;
				}
				var parts = aria.split('-tab-');
				if (parts.length < 2) {
					return;
				}
				var lang = parts.slice(1).join('-tab-');
				var tabId = base + '-tab-' + lang;
				var paneId = base + '-pane-' + lang;
				$pane.attr('id', paneId);
				$pane.attr('aria-labelledby', tabId);
			});
		}
		var ic = 'item-collapse-' + si + '-' + ii;
		$itemCard.find('[data-role="item-collapse"]').attr('id', ic);
		$itemCard.find('[data-role="item-collapse-toggle"]').attr('data-bs-target', '#' + ic)
			.attr('aria-controls', ic);
	}

	function reindexSections() {
		$('#sections-container .section-card').each(function(si) {
			var $card = $(this);
			$card.find('.cms-quill-root').each(function() {
				if (window
					.teardownCmsQuillRoot
				) {
					window.teardownCmsQuillRoot(
						this
					);
				}
			});
			$card.find('input, select, textarea').each(function() {
				var n = this.name;
				if (!n || n.indexOf(
						'sections['
					) !==
					0) return;
				this.name = n.replace(
					/sections\[\d+\]/,
					'sections[' +
					si + ']');
			});
			syncSectionBuilderIds($card, si);
			var sectionGid = 'section-gallery-' + si;
			$card.find('.gallery-upload-container').filter(function() {
					return $(this).closest(
							'.item-card'
						)
						.length === 0;
				}).find('input.gallery-input').attr('id',
					sectionGid).end()
				.find('.gallery-preview').attr('id',
					'gallery-preview-' + sectionGid);
			reindexItemImagesAndGallery($card);
		});
		if (window.initCmsQuillRoots) {
			var sc = document.getElementById('sections-container');
			if (sc) {
				window.initCmsQuillRoots(sc);
			}
		}
	}

	function rebuildSectionGalleryPreviews(input) {
		var $wrap = $(input).closest('.gallery-upload-container');
		var preview = $wrap.find('.gallery-preview')[0];
		if (!preview || !input.files) {
			return;
		}
		$(preview).find('.gallery-item[data-file-name]').remove();
		Array.from(input.files).forEach(function(file) {
			if (!file.type || !file.type.startsWith('image/')) {
				return;
			}
			var reader = new FileReader();
			reader.onload = function(e) {
				var div = document.createElement('div');
				div.className = 'gallery-item';
				div.setAttribute('data-file-name', file
					.name);
				div.innerHTML = '<img src="' + e.target
					.result +
					'" alt="" class="img-thumbnail">' +
					'<button type="button" class="btn btn-sm btn-danger gallery-remove-new"><i class="mdi mdi-delete"></i></button>';
				preview.appendChild(div);
			};
			reader.readAsDataURL(file);
		});
	}

	$('#sections-container').on('change', 'input.gallery-input', function() {
		rebuildSectionGalleryPreviews(this);
	});

	$('#sections-container').on('click', '.gallery-remove-new', function(e) {
		e.preventDefault();
		var $item = $(this).closest('.gallery-item');
		var name = $item.attr('data-file-name');
		var input = $item.closest('.gallery-upload-container').find(
			'input.gallery-input')[0];
		if (!input || !input.files) {
			$item.remove();
			return;
		}
		var dt = new DataTransfer();
		Array.from(input.files).forEach(function(f) {
			if (f.name !== name) {
				dt.items.add(f);
			}
		});
		input.files = dt.files;
		$item.remove();
	});

	$('#sections-container').on('click', '.gallery-remove-existing', function(e) {
		e.preventDefault();
		var btn = this;
		var mediaId = btn.getAttribute('data-media-id');
		var galleryItem = btn.closest('.gallery-item');
		if (!mediaId || !galleryItem) {
			return;
		}
		Swal.fire({
			title: '{{ __("Are you sure?") }}',
			text: '{{ __("You won'
			t be able to revert this!") }}',
			icon: 'warning',
			showCancelButton: true,
			confirmButtonColor: '#3085d6',
			cancelButtonColor: '#d33',
			confirmButtonText: '{{ __("Yes, delete it!") }}'
		}).then(function(result) {
			if (!result.isConfirmed) {
				return;
			}
			fetch('{{ route("cms.media.index") }}/' +
					mediaId, {
						method: 'DELETE',
						headers: {
							'X-CSRF-TOKEN': document
								.querySelector(
									'meta[name="csrf-token"]'
								)
								.getAttribute(
									'content'
								),
							'Accept': 'application/json'
						}
					})
				.then(function(response) {
					return response
						.json();
				})
				.then(function(data) {
					if (data
						.success
					) {
						galleryItem
							.remove();
						Swal.fire('{{ __("Deleted!") }}',
							data
							.message ||
							'',
							'success'
						);
					} else {
						Swal.fire('{{ __("Error!") }}',
							data
							.message ||
							'{{ __("An error occurred") }}',
							'error'
						);
					}
				})
				.catch(function() {
					Swal.fire('{{ __("Error!") }}',
						'{{ __("An error occurred") }}',
						'error'
					);
				});
		});
	});

	function reindexItemImagesAndGallery($section) {
		var si = $('#sections-container .section-card').index($section);
		$section.find('.items-wrap .item-card').each(function(ii) {
			var $card = $(this);
			var gid = 'item-gallery-s' + si + '-i' + ii;
			$card.find('.gallery-upload-container input.gallery-input')
				.attr('id', gid);
			$card.find('.gallery-upload-container .gallery-preview')
				.attr('id', 'gallery-preview-' + gid);
			$card.find('.image-upload-wrapper').each(function() {
				var $w = $(this);
				var $input = $w.find(
					'input[type=file]'
				).first();
				if (!$input.length) {
					return;
				}
				var name = $input.attr(
					'name');
				if (!name) {
					return;
				}
				var m = name.match(
					/\[translations\]\[([^\]]+)\]\[(image|icon_image)\]/
				);
				if (!m) {
					return;
				}
				var lang = m[1];
				var field = m[2];
				var newId = 'item-' + field +
					'-s' + si + '-i' +
					ii + '-' + lang;
				var previewId = 'preview_' +
					newId;
				$input.attr('id', newId);
				$input.attr('onchange',
					"previewImage(this, '" +
					previewId +
					"')");
				var $prev = $w.find(
						'.image-preview-container'
					)
					.first();
				$prev.attr('id', previewId);
				$prev.find('img').first()
					.attr('id',
						previewId +
						'_img');
				$w.find('.image-preview-container button')
					.attr('onclick',
						"removeImagePreview('" +
						previewId +
						"', '" +
						newId +
						"')");
			});
		});
	}

	function reindexItems($section) {
		var si = $('#sections-container .section-card').index($section);
		$section.find('.items-wrap .item-card').each(function(ii) {
			var $card = $(this);
			$card.find('input, select, textarea').each(function() {
				var n = this.name;
				if (!n || n.indexOf(
						'[items]['
					) ===
					-1) return;
				this.name = n.replace(
					/\[items\]\[\d+\]/,
					'[items][' +
					ii + ']');
			});
			$card.find('.item-links-wrap .link-block').each(function(
				li) {
				$(this).find(
						'input, select, textarea'
					)
					.each(function() {
						var n = this
							.name;
						if (!n || n
							.indexOf(
								'[links]['
							) ===
							-
							1
						)
							return;
						this.name =
							n
							.replace(/\[links\]\[\d+\]/,
								'[links][' +
								li +
								']'
							);
					});
			});
			syncItemBuilderIds($card, si, ii);
		});
		reindexItemImagesAndGallery($section);
	}

	function reindexSectionLinks($section) {
		$section.find('.section-links-wrap .link-block').each(function(li) {
			$(this).find('input, select, textarea').each(function() {
				var n = this.name;
				if (!n) return;
				var m = n.match(
					/^(sections\[\d+\]\[links])\[\d+\]/
				);
				if (m) this.name = n.replace(
					/^(sections\[\d+\]\[links])\[\d+\]/,
					m[1] +
					'[' + li +
					']');
			});
		});
	}

	function reindexPageLinks() {
		$('#page-links-wrap .link-block').each(function(li) {
			$(this).find('input, select, textarea').each(function() {
				var n = this.name;
				if (!n || n.indexOf(
						'page_links['
					) !==
					0) return;
				this.name = n.replace(
					/page_links\[\d+\]/,
					'page_links[' +
					li + ']');
			});
		});
	}

	function cloneFrom($proto, replacements) {
		var html = $proto.html();
		$.each(replacements, function(key, val) {
			html = html.split(key).join(val);
		});
		return $(html.trim());
	}

	$('#btn-add-section').on('click', function() {
		var si = $('#sections-container .section-card').length;
		var $el = cloneFrom($('#section-prototype'), {
			'__SIDX__': si
		});
		$el.find('input[name*="[name]"]').first().val('{{ __('
			Section ') }} ' + (si + 1));
		$('#sections-container').append($el);
		reindexSections();
	});

	$(document).on('click', '[data-role="remove-section"]', function() {
		$(this).closest('.section-card').remove();
		reindexSections();
	});

	$(document).on('click', '[data-role="add-item"]', function() {
		var $section = $(this).closest('.section-card');
		var si = $('#sections-container .section-card').index($section);
		var ii = $section.find('.item-card').length;
		var $item = cloneFrom($('#item-prototype'), {
			'__SIDX__': si,
			'__IIDX__': ii
		});
		var slug = 'item-' + Date.now();
		$item.find('input[name*="[slug]"]').val(slug);
		$section.find('.items-wrap').append($item);
		reindexItems($section);
	});

	$(document).on('click', '[data-role="remove-item"]', function() {
		var $section = $(this).closest('.section-card');
		$(this).closest('.item-card').remove();
		reindexItems($section);
	});

	function appendLink($wrap, prefix) {
		var li = $wrap.find('.link-block').length;
		var fullPrefix = prefix + '[' + li + ']';
		var $row = cloneFrom($('#link-prototype'), {
			'__PREFIX__': fullPrefix
		});
		$wrap.append($row);
	}

	$(document).on('click', '#btn-add-page-link', function() {
		appendLink($('#page-links-wrap'), 'page_links');
		reindexPageLinks();
	});

	$(document).on('click', '[data-role="add-section-link"]', function() {
		var $section = $(this).closest('.section-card');
		var si = $('#sections-container .section-card').index($section);
		appendLink($section.find('.section-links-wrap'), 'sections[' + si +
			'][links]');
		reindexSectionLinks($section);
	});

	$(document).on('click', '[data-role="add-item-link"]', function() {
		var $item = $(this).closest('.item-card');
		var $section = $item.closest('.section-card');
		var si = $('#sections-container .section-card').index($section);
		var ii = $section.find('.item-card').index($item);
		appendLink($item.find('.item-links-wrap'), 'sections[' + si +
			'][items][' + ii + '][links]');
		reindexItems($section);
	});

	$(document).on('click', '[data-role="remove-link"]', function() {
		var $row = $(this).closest('.link-block');
		var $section = $row.closest('.section-card');
		var $item = $row.closest('.item-card');
		$row.remove();
		if ($item.length) {
			reindexItems($section);
		} else if ($section.length) {
			reindexSectionLinks($section);
		} else {
			reindexPageLinks();
		}
	});
})(jQuery);
</script>
@endpush
