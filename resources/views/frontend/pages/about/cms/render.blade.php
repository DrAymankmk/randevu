@php
    $raw = strtolower(trim((string) ($section->type ?? 'default')));
    $type = str_replace('_', '-', $raw);
    $typeToView = [
         'about-us' => 'frontend.pages.about.cms.types.about_us',
         'features' => 'frontend.pages.about.cms.types.features',
         'values' => 'frontend.pages.about.cms.types.values',

        'default' => 'frontend.pages.about.cms.types.generic',
    ];
    $partial = $typeToView[$type] ?? 'frontend.pages.about.cms.types.generic';
@endphp
@include($partial, ['section' => $section])
