<?php

use CodeIgniter\Pager\PagerRenderer;

/** @var PagerRenderer $pager */
$pager->setSurroundCount(2);
?>
<nav aria-label="<?= lang('Pager.pageNavigation') ?>">
    <div class="join">
        <?php if ($pager->hasPrevious()) : ?>
            <a href="<?= $pager->getFirst() ?>" class="join-item btn btn-sm">&#171;</a>
            <a href="<?= $pager->getPrevious() ?>" class="join-item btn btn-sm">&#8249;</a>
        <?php endif ?>

        <?php foreach ($pager->links() as $link) : ?>
            <a href="<?= $link['uri'] ?>" class="join-item btn btn-sm <?= $link['active'] ? 'btn-active' : '' ?>"><?= $link['title'] ?></a>
        <?php endforeach ?>

        <?php if ($pager->hasNext()) : ?>
            <a href="<?= $pager->getNext() ?>" class="join-item btn btn-sm">&#8250;</a>
            <a href="<?= $pager->getLast() ?>" class="join-item btn btn-sm">&#187;</a>
        <?php endif ?>
    </div>
</nav>
