<?php if ( ! defined( 'WPINC' ) ) die;
use QuestionAnswer\Frontend\Frontend;
?>

<?php


if ( $questions->have_posts() ) {
    while ( $questions->have_posts() ) {
        $questions->the_post(); ?>



        <?php if($display != 'question_link'): ?>
        <h3 class="question-title"><?php the_title(); ?></h3>
        <p class="ansver-content"><?php the_content(); ?></p>
        <?php else: ?>
            <h3 class="question-title"><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a> </h3>
        <?php endif; ?>
    <?php } ?>
    <div class="row">
        <?php Frontend::qaPagenavi($questions); ?>
    </div>
<?php } else { ?>
    <p class="questions-info"><?php _e('No questions are found.', 'wp-question-answer'); ?></p>
<?php }


wp_reset_postdata();
