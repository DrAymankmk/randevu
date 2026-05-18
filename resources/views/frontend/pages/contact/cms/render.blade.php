@php
    $raw = strtolower(trim((string) ($section->type ?? 'default')));
    $type = str_replace('_', '-', $raw);
    $typeToView = [
         'contact' => 'frontend.pages.contact.cms.types.contact',
         'default' => 'frontend.pages.contact.cms.types.generic',
    ];
    $partial = $typeToView[$type] ?? 'frontend.pages.contact.cms.types.generic';
@endphp
@include($partial, ['section' => $section])
