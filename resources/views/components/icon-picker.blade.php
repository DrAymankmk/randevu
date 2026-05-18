{{-- Icon Picker Component --}}
{{-- Usage: @include('backend.components.icon-picker', ['inputId' => 'icon_field', 'inputName' => 'icon']) --}}

<div class="icon-picker-wrapper">
    <div class="input-group">
        <span class="input-group-text icon-preview" id="preview-{{ $inputId ?? 'icon' }}">
            <i class="mdi mdi-emoticon-outline"></i>
        </span>
        <input type="text" 
               class="form-control icon-picker-input" 
               id="{{ $inputId ?? 'icon' }}" 
               name="{{ $inputName ?? 'icon' }}" 
               value="{{ $value ?? '' }}"
               placeholder="{{ __('Click to select icon') }}"
               readonly
               data-bs-toggle="modal" 
               data-bs-target="#iconPickerModal-{{ $inputId ?? 'icon' }}">
        <button type="button" class="btn btn-outline-secondary clear-icon-btn" data-input="{{ $inputId ?? 'icon' }}">
            <i class="mdi mdi-close"></i>
        </button>
    </div>
</div>

{{-- Icon Picker Modal --}}
<div class="modal fade icon-picker-modal" id="iconPickerModal-{{ $inputId ?? 'icon' }}" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-scrollable">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">{{ __('Select Icon') }}</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                {{-- Search and Filter --}}
                <div class="row mb-3">
                    <div class="col-md-8">
                        <input type="text" 
                               class="form-control icon-search" 
                               data-target="{{ $inputId ?? 'icon' }}"
                               placeholder="{{ __('Search icons...') }}">
                    </div>
                    <div class="col-md-4">
                        <select class="form-select icon-library-filter" data-target="{{ $inputId ?? 'icon' }}">
                            <option value="all">{{ __('All Icons') }}</option>
                            <option value="mdi">Material Design Icons</option>
                            <option value="fa">Font Awesome</option>
                        </select>
                    </div>
                </div>

                {{-- Icon Grid --}}
                <div class="icon-grid" id="iconGrid-{{ $inputId ?? 'icon' }}">
                    {{-- Icons will be loaded here --}}
                </div>

                {{-- Loading --}}
                <div class="text-center py-4 icon-loading" id="iconLoading-{{ $inputId ?? 'icon' }}">
                    <div class="spinner-border text-primary" role="status">
                        <span class="visually-hidden">Loading...</span>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <div class="selected-icon-preview me-auto">
                    <span class="text-muted">{{ __('Selected') }}:</span>
                    <span class="selected-icon-display" id="selectedIconDisplay-{{ $inputId ?? 'icon' }}">
                        <i class="mdi mdi-emoticon-outline"></i>
                        <code class="ms-2">{{ __('None') }}</code>
                    </span>
                </div>
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">{{ __('Cancel') }}</button>
                <button type="button" class="btn btn-primary confirm-icon-btn" data-input="{{ $inputId ?? 'icon' }}" data-bs-dismiss="modal">
                    {{ __('Select') }}
                </button>
            </div>
        </div>
    </div>
</div>

@once
@push('styles')
<style>
.icon-picker-wrapper .icon-preview {
    font-size: 1.25rem;
    min-width: 45px;
    justify-content: center;
}
.icon-picker-wrapper .icon-picker-input {
    cursor: pointer;
    background-color: #fff;
}
.icon-picker-wrapper .clear-icon-btn {
    border-color: #ced4da;
}
.icon-grid {
    display: grid;
    grid-template-columns: repeat(auto-fill, minmax(60px, 1fr));
    gap: 8px;
    max-height: 400px;
    overflow-y: auto;
    padding: 5px;
}
.icon-grid-item {
    display: flex;
    flex-direction: column;
    align-items: center;
    justify-content: center;
    padding: 12px 8px;
    border: 2px solid transparent;
    border-radius: 8px;
    cursor: pointer;
    transition: all 0.2s ease;
    background: #f8f9fa;
}
.icon-grid-item:hover {
    background: #e9ecef;
    border-color: #6c757d;
}
.icon-grid-item.selected {
    background: #e7f1ff;
    border-color: #0d6efd;
}
.icon-grid-item i {
    font-size: 1.5rem;
    margin-bottom: 4px;
}
.icon-grid-item .icon-name {
    font-size: 0.65rem;
    text-align: center;
    color: #6c757d;
    word-break: break-all;
    line-height: 1.1;
    max-height: 2.2em;
    overflow: hidden;
}
.selected-icon-preview {
    display: flex;
    align-items: center;
    gap: 8px;
}
.selected-icon-display i {
    font-size: 1.5rem;
}
.icon-loading {
    display: none;
}
</style>
@endpush

@push('scripts')
<script>
// Icon data - popular icons from MDI and Font Awesome
const iconLibrary = {
    mdi: [
        'account', 'account-circle', 'account-group', 'account-plus', 'account-search',
        'alert', 'alert-circle', 'alert-outline', 'archive', 'arrow-left', 
        'arrow-right', 'arrow-up', 'arrow-down', 'bell', 'bell-outline',
        'bookmark', 'bookmark-outline', 'book', 'book-open', 'briefcase',
        'calendar', 'calendar-check', 'camera', 'cart', 'cart-outline',
        'chart-bar', 'chart-line', 'chart-pie', 'check', 'check-circle',
        'chevron-left', 'chevron-right', 'chevron-up', 'chevron-down', 'clock',
        'clock-outline', 'close', 'close-circle', 'cloud', 'cloud-download',
        'cloud-upload', 'code-tags', 'cog', 'cog-outline', 'comment',
        'comment-outline', 'content-copy', 'content-save', 'credit-card', 'delete',
        'delete-outline', 'download', 'email', 'email-outline', 'eye',
        'eye-off', 'facebook', 'file', 'file-document', 'file-image',
        'file-pdf-box', 'filter', 'flag', 'folder', 'folder-open',
        'format-bold', 'format-italic', 'format-underline', 'gift', 'github',
        'google', 'grid', 'heart', 'heart-outline', 'help',
        'help-circle', 'home', 'home-outline', 'image', 'image-multiple',
        'information', 'information-outline', 'instagram', 'key', 'keyboard',
        'language', 'layers', 'lightbulb', 'lightbulb-outline', 'link',
        'linkedin', 'list-box', 'location-enter', 'lock', 'lock-open',
        'login', 'logout', 'magnify', 'map', 'map-marker',
        'menu', 'message', 'message-text', 'microphone', 'minus',
        'minus-circle', 'monitor', 'music', 'note', 'notebook',
        'notification-clear-all', 'open-in-new', 'palette', 'paperclip', 'pause',
        'pencil', 'pencil-outline', 'phone', 'phone-outline', 'pin',
        'play', 'playlist-check', 'plus', 'plus-circle', 'power',
        'printer', 'puzzle', 'qrcode', 'refresh', 'reply',
        'rocket', 'rocket-launch', 'rss', 'share', 'share-variant',
        'shield', 'shield-check', 'shopping', 'shuffle', 'skip-next',
        'skip-previous', 'sort', 'speaker', 'square-edit-outline', 'star',
        'star-outline', 'stop', 'store', 'sync', 'table',
        'tablet', 'tag', 'tag-outline', 'target', 'text',
        'thumb-up', 'thumb-down', 'timer', 'toggle-switch', 'tools',
        'translate', 'trash-can', 'trending-up', 'trophy', 'twitter',
        'undo', 'upload', 'video', 'view-dashboard', 'volume-high',
        'wallet', 'web', 'whatsapp', 'wifi', 'wrench',
        'youtube', 'zip-box'
    ],
    fa: [
        'house', 'user', 'users', 'gear', 'magnifying-glass',
        'envelope', 'phone', 'location-dot', 'calendar', 'clock',
        'bell', 'heart', 'star', 'bookmark', 'comment',
        'share', 'link', 'image', 'file', 'folder',
        'download', 'upload', 'print', 'trash', 'pen',
        'check', 'xmark', 'plus', 'minus', 'circle-info',
        'triangle-exclamation', 'circle-check', 'circle-xmark', 'arrow-right', 'arrow-left',
        'arrow-up', 'arrow-down', 'chevron-right', 'chevron-left', 'chevron-up',
        'chevron-down', 'angles-right', 'angles-left', 'bars', 'grip-lines',
        'cart-shopping', 'bag-shopping', 'credit-card', 'money-bill', 'wallet',
        'chart-line', 'chart-bar', 'chart-pie', 'database', 'server',
        'lock', 'lock-open', 'key', 'shield-halved', 'eye',
        'eye-slash', 'globe', 'language', 'palette', 'brush',
        'code', 'laptop', 'desktop', 'mobile', 'tablet',
        'tv', 'camera', 'video', 'music', 'headphones',
        'microphone', 'volume-high', 'play', 'pause', 'stop',
        'forward', 'backward', 'shuffle', 'repeat', 'list',
        'table', 'grip', 'border-all', 'filter', 'sort',
        'bolt', 'fire', 'sun', 'moon', 'cloud',
        'snowflake', 'umbrella', 'tree', 'leaf', 'seedling',
        'gift', 'trophy', 'medal', 'crown', 'gem',
        'rocket', 'paperclip', 'thumbtack', 'tag', 'tags',
        'bookmark', 'flag', 'map', 'compass', 'route',
        'car', 'bus', 'train', 'plane', 'ship',
        'bicycle', 'motorcycle', 'helicopter', 'building', 'hospital',
        'school', 'graduation-cap', 'book', 'book-open', 'newspaper',
        'lightbulb', 'plug', 'battery-full', 'signal', 'wifi',
        'qrcode', 'barcode', 'fingerprint', 'id-card', 'address-card'
    ]
};

function initIconPicker(inputId) {
    const modal = document.getElementById('iconPickerModal-' + inputId);
    const grid = document.getElementById('iconGrid-' + inputId);
    const loading = document.getElementById('iconLoading-' + inputId);
    const searchInput = modal.querySelector('.icon-search');
    const libraryFilter = modal.querySelector('.icon-library-filter');
    const previewSpan = document.getElementById('preview-' + inputId);
    const inputField = document.getElementById(inputId);
    const selectedDisplay = document.getElementById('selectedIconDisplay-' + inputId);
    
    let selectedIcon = inputField.value || '';

    function renderIcons(filter = 'all', search = '') {
        grid.innerHTML = '';
        loading.style.display = 'block';

        setTimeout(() => {
            let icons = [];
            
            if (filter === 'all' || filter === 'mdi') {
                iconLibrary.mdi.forEach(icon => {
                    icons.push({ class: 'mdi mdi-' + icon, name: icon, library: 'mdi' });
                });
            }
            
            if (filter === 'all' || filter === 'fa') {
                iconLibrary.fa.forEach(icon => {
                    icons.push({ class: 'fa-solid fa-' + icon, name: icon, library: 'fa' });
                });
            }

            if (search) {
                const searchLower = search.toLowerCase();
                icons = icons.filter(icon => icon.name.toLowerCase().includes(searchLower));
            }

            icons.forEach(icon => {
                const item = document.createElement('div');
                item.className = 'icon-grid-item' + (icon.class === selectedIcon ? ' selected' : '');
                item.dataset.icon = icon.class;
                item.innerHTML = `<i class="${icon.class}"></i><span class="icon-name">${icon.name}</span>`;
                item.addEventListener('click', () => selectIcon(icon.class, inputId));
                grid.appendChild(item);
            });

            loading.style.display = 'none';
        }, 100);
    }

    function selectIcon(iconClass, inputId) {
        selectedIcon = iconClass;
        
        // Update grid selection
        grid.querySelectorAll('.icon-grid-item').forEach(item => {
            item.classList.toggle('selected', item.dataset.icon === iconClass);
        });

        // Update selected display
        selectedDisplay.innerHTML = `<i class="${iconClass}"></i><code class="ms-2">${iconClass}</code>`;
    }

    // Confirm button
    modal.querySelector('.confirm-icon-btn').addEventListener('click', () => {
        inputField.value = selectedIcon;
        previewSpan.innerHTML = selectedIcon ? `<i class="${selectedIcon}"></i>` : '<i class="mdi mdi-emoticon-outline"></i>';
    });

    // Search
    searchInput.addEventListener('input', (e) => {
        renderIcons(libraryFilter.value, e.target.value);
    });

    // Filter
    libraryFilter.addEventListener('change', (e) => {
        renderIcons(e.target.value, searchInput.value);
    });

    // Load icons when modal opens
    modal.addEventListener('show.bs.modal', () => {
        selectedIcon = inputField.value || '';
        if (selectedIcon) {
            selectedDisplay.innerHTML = `<i class="${selectedIcon}"></i><code class="ms-2">${selectedIcon}</code>`;
        }
        renderIcons();
    });

    // Set initial preview
    if (inputField.value) {
        previewSpan.innerHTML = `<i class="${inputField.value}"></i>`;
    }
}

// Clear icon button
document.addEventListener('click', function(e) {
    if (e.target.closest('.clear-icon-btn')) {
        const btn = e.target.closest('.clear-icon-btn');
        const inputId = btn.dataset.input;
        const inputField = document.getElementById(inputId);
        const previewSpan = document.getElementById('preview-' + inputId);
        
        inputField.value = '';
        previewSpan.innerHTML = '<i class="mdi mdi-emoticon-outline"></i>';
    }
});

// Auto-init on page load
document.addEventListener('DOMContentLoaded', function() {
    document.querySelectorAll('.icon-picker-input').forEach(input => {
        initIconPicker(input.id);
    });
});
</script>
@endpush
@endonce
