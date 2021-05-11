<?php
$collectionTitle = metadata('collection', array('Dublin Core', 'Title'), 'all');
?>

<?php echo head(array('title'=> strip_tags($collectionTitle[0]), 'bodyclass' => 'collections show')); ?>
<div class="container content">
    <article>
        <h2><?php echo $collectionTitle[0]; echo $collectionTitle[1] ? ' / '.$collectionTitle[1] : null ;?></h2>
        <div id="collection-header-meta">
            <span><?php echo link_to_items_browse(
    __(
        '<span class="count">%s</span> Resources',
        metadata('collection', 'total_items')
    ),
    array('collection' => metadata('collection', 'id'))
); ?></span>
            <span><?php echo ($c=metadata('collection', array('Dublin Core','Creator'))) ? ' / '.$c : null;?></span>
        </div>
        <?php echo the_description($collection);?>
    </article>

    <?php echo link_to_items_browse(
    __(
        'Browse %s resources in this collection',
        metadata('collection', 'total_items')
    ),
    array('collection' => metadata('collection', 'id')),
    array('class'=>'button')
); ?>

</div>
<?php echo foot(); ?>