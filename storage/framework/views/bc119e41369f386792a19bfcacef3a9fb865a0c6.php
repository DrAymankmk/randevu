<?php
    $acronyms = ['ui', 'seo', 'api', 'faq', 'gdpr', 'ip', 'rtl', 'hrm']; // Acronyms
    $formTypes = ['basic', 'cover', 'illustration'];
    $specialPrefixes = ['icon', 'chart', 'maps', 'form'];
    $pluralMap = [
        'icon' => 'Icons',
        'chart' => 'Charts',
        'maps' => 'Maps',
        'form' => 'Forms',
    ];

    $segments = explode('-', Route::currentRouteName());

    // Remove 'ui' prefix if it's the first segment
    if ($segments[0] === 'ui') {
        array_shift($segments);
    }

    // Move special prefix to suffix if present
    $prefix = null;
    if (in_array($segments[0], $specialPrefixes)) {
        $prefix = $pluralMap[$segments[0]];
        array_shift($segments);
    }

    // Check for form type in last segment
    $lastSegment = end($segments);
    $hasFormType = in_array($lastSegment, $formTypes);

    // Build title
    $title = collect($segments)
        ->map(function ($word) use ($acronyms) {
            return in_array(strtolower($word), $acronyms)
                ? strtoupper($word)
                : ucfirst($word);
        })
        ->toArray();

    // Add 'Form' if last word is form type
    if ($hasFormType) {
        $title[] = 'Form';
    }

    // Add pluralized prefix if applicable
    if ($prefix) {
        $title[] = $prefix;
    }

    $title = implode(' ', $title);
?>

<head>
    <!-- Meta Tags -->
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <?php if(Route::is(['index'])): ?>
    <title> <?php echo e(trans('admin.takafol_title')); ?></title>
    <?php endif; ?>
    <?php if(!Route::is(['index'])): ?>
    <title><?php echo e($title); ?> | <?php echo e(trans('admin.takafol_title')); ?></title>
    <?php endif; ?>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="author" content="Dreams Technologies">

    <?php echo $__env->make('layout_new.partials.head-css', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>


</head>
<?php /**PATH C:\xampp\htdocs\Other\randvous\TakafolJoodNew\resources\views/layout_new/partials/title-meta.blade.php ENDPATH**/ ?>