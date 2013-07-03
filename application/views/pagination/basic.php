<div class="pagination pagination-centered">
    <ul>
    <?php if ($first_page !== FALSE): ?>
        <li><a href="<?php echo HTML::chars($page->url($first_page)) ?>" rel="first"><?php echo __('First') ?></a></li>
    <?php else: ?>
        <li class="disabled"><a href="<?php echo HTML::chars($page->url($first_page)) ?>" rel="first"><?php echo __('First') ?></a></li>
    <?php endif ?>


    <?php for ($i = 1; $i <= $total_pages; $i++): ?>

        <?php if ($i == $current_page): ?>
            <li class="disabled"><a href="<?php echo HTML::chars($page->url($i)) ?>"><strong><?php echo $i ?></strong></a></li>
        <?php else: ?>
            <li><a href="<?php echo HTML::chars($page->url($i)) ?>"><?php echo $i ?></a></li>
        <?php endif ?>

    <?php endfor ?>


    <?php if ($last_page !== FALSE): ?>
        <li><a href="<?php echo HTML::chars($page->url($last_page)) ?>" rel="last"><?php echo __('Last') ?></a></li>
    <?php else: ?>
        <li class="disabled"><a href="<?php echo HTML::chars($page->url($last_page)) ?>" rel="last"><?php echo __('Last') ?></a></li>
    <?php endif ?>
    </ul>
</div><!-- .pagination -->