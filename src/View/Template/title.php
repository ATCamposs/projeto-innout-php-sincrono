<div class="content-title mb-4">
    <?php if (isset($icon)) : ?>
        <i class="icon <?= $icon ?> mr-2"></i>
    <?php endif ?>
    <div>
        <h1><?= isset($title) ? $title : null ?></h1>
        <h2><?= isset($subtitle) ? $subtitle : null ?></h2>
    </div>
</div>