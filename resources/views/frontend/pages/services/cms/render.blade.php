@php
    $raw = strtolower(trim((string) ($section->type ?? 'default')));
    $type = str_replace('_', '-', $raw);
    $typeToView = [
         'services' => 'frontend.pages.services.cms.types.services',
         'default' => 'frontend.pages.services.cms.types.generic',
    ];
    $partial = $typeToView[$type] ?? 'frontend.pages.services.cms.types.generic';
@endphp
@include($partial, ['section' => $section])
