@php
    $deferGalleryInit = $deferGalleryInit ?? false;
@endphp
<div class="mb-3">
    <label class="form-label">{{ $label ?? __('Gallery') }}</label>
    <div class="gallery-upload-container" data-collection="{{ $collection }}">
        <input type="file" 
               id="{{ $inputId }}" 
               name="{{ $inputName }}[]" 
               class="form-control gallery-input" 
               accept="image/*" 
               multiple>
        
        <div class="gallery-preview mt-3" id="gallery-preview-{{ $inputId }}">
            @if(isset($existingImages) && $existingImages->count() > 0)
                @foreach($existingImages as $image)
                <div class="gallery-item" data-media-id="{{ $image->id }}">
                    <img src="{{ $image->getUrl('thumb') ?? $image->getUrl() }}" alt="{{ $image->name }}" class="img-thumbnail">
                    <button type="button" class="btn btn-sm btn-danger gallery-remove-existing" data-media-id="{{ $image->id }}" data-collection="{{ $collection }}">
                        <i class="mdi mdi-delete"></i>
                    </button>
                </div>
                @endforeach
            @endif
        </div>
    </div>
</div>

@once
@push('styles')
<style>
    .gallery-preview {
        display: flex;
        flex-wrap: wrap;
        gap: 10px;
    }
    .gallery-item {
        position: relative;
        display: inline-block;
    }
    .gallery-item img {
        width: 150px;
        height: 150px;
        object-fit: cover;
    }
    .gallery-item .btn {
        position: absolute;
        top: 5px;
        right: 5px;
    }
</style>
@endpush
@endonce

@unless($deferGalleryInit)
@push('scripts')
<script>
    (function() {
        var inputId = '{{ $inputId }}';
        var input = document.getElementById(inputId);
        var previewContainer = document.getElementById('gallery-preview-' + inputId);
        var collection = '{{ $collection }}';
        var selectedFiles = [];
        
        function initGallery() {
            if (!input || !previewContainer) {
                return;
            }
            
            // Handle new file selection
            input.addEventListener('change', function(e) {
                var files = Array.from(e.target.files);
                files.forEach(function(file, index) {
                    if (file.type.startsWith('image/')) {
                        selectedFiles.push(file);
                        var reader = new FileReader();
                        reader.onload = (function(file) {
                            return function(e) {
                                var galleryItem = document.createElement('div');
                                galleryItem.className = 'gallery-item';
                                galleryItem.setAttribute('data-file-name', file.name);
                                galleryItem.innerHTML = `
                                    <img src="${e.target.result}" alt="Preview" class="img-thumbnail">
                                    <button type="button" class="btn btn-sm btn-danger gallery-remove-new">
                                        <i class="mdi mdi-delete"></i>
                                    </button>
                                `;
                                previewContainer.appendChild(galleryItem);
                                
                                // Remove button functionality
                                galleryItem.querySelector('.gallery-remove-new').addEventListener('click', function() {
                                    // Remove from selectedFiles array
                                    selectedFiles = selectedFiles.filter(function(f) {
                                        return f.name !== file.name;
                                    });
                                    
                                    // Update input files
                                    var dt = new DataTransfer();
                                    selectedFiles.forEach(function(f) {
                                        dt.items.add(f);
                                    });
                                    input.files = dt.files;
                                    
                                    galleryItem.remove();
                                });
                            };
                        })(file);
                        reader.readAsDataURL(file);
                    }
                });
            });
        }
        
        // Handle removal of existing images
        function initExistingImageRemoval() {
            var removeButtons = document.querySelectorAll('.gallery-remove-existing[data-collection="' + collection + '"]');
            removeButtons.forEach(function(button) {
                button.addEventListener('click', function() {
                    var mediaId = this.getAttribute('data-media-id');
                    var galleryItem = this.closest('.gallery-item');
                    
                    Swal.fire({
                        title: '{{ __("Are you sure?") }}',
                        text: '{{ __("You won't be able to revert this!") }}',
                        icon: 'warning',
                        showCancelButton: true,
                        confirmButtonColor: '#3085d6',
                        cancelButtonColor: '#d33',
                        confirmButtonText: '{{ __("Yes, delete it!") }}'
                    }).then((result) => {
                        if (result.isConfirmed) {
                            // Delete via AJAX
                            fetch('{{ route("cms.media.index") }}/' + mediaId, {
                                method: 'DELETE',
                                headers: {
                                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
                                    'Accept': 'application/json'
                                }
                            })
                            .then(response => response.json())
                            .then(data => {
                                if (data.success) {
                                    galleryItem.remove();
                                    Swal.fire('{{ __("Deleted!") }}', data.message, 'success');
                                } else {
                                    Swal.fire('{{ __("Error!") }}', data.message || '{{ __("An error occurred") }}', 'error');
                                }
                            })
                            .catch(error => {
                                Swal.fire('{{ __("Error!") }}', '{{ __("An error occurred") }}', 'error');
                            });
                        }
                    });
                });
            });
        }
        
        if (document.readyState === 'loading') {
            document.addEventListener('DOMContentLoaded', function() {
                initGallery();
                initExistingImageRemoval();
            });
        } else {
            initGallery();
            initExistingImageRemoval();
        }
    })();
</script>
@endpush
@endunless

