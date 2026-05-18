@php
$raw = strtolower(trim((string) ($section->type ?? 'default')));
$type = str_replace('_', '-', $raw);
$typeToView = [
'faqs' => 'frontend.pages.faq.cms.types.faqs',
'default' => 'frontend.pages.faq.cms.types.generic',
];
$partial = $typeToView[$type] ?? 'frontend.pages.faq.cms.types.generic';
@endphp
@include($partial, ['section' => $section])
