<?php
/**
 * Template Name: Dashboard template
 *
 * Plantilla para mostrar los dashboards de Power BI
 */

// Exit if accessed directly.
defined( 'ABSPATH' ) || exit;

get_header();

if ( have_posts() ) : while ( have_posts() ) : the_post();

get_sidebar();

?>

<div id="page-wrapper" class="flex-shrink-0 col-md d-flex flex-column" itemprop="mainContentOfPage">
    <div id="toolbar" class="d-flex flex-row-reverse p-1 noprint">
        <div>
            <button class="border-0 m-1 p-1" onClick="window.print();">
                <i class="p-1 fa-solid fa-print"></i>
                <p class="d-inline p-1">Imprimir</p>
            </button>
            <button class="border-0 m-1 p-1">
                <i class="p-1 fa-regular fa-file-excel"></i>
                <p class="d-inline p-1">Generar XLSX</p>
            </button>
        </div>
    </div>
    <iframe src="https://app.powerbi.com/view?r=eyJrIjoiNDdlMjY2ZTEtNzgwNC00YjVmLWI2NDktOGRiMzk0MjA2NDk4IiwidCI6IjI5YTJmODVmLTg2NjYtNGViMy05MWYwLWI5NGNmYzVjNmU3YSJ9&pageName=ReportSection&navContentPaneEnabled=false" class="p-2" width=100% height=200% style="clip-path: inset(0 0 45px 0);"></iframe>
</div>
<?php if ( comments_open() && !post_password_required() ) { comments_template( '', true ); } ?>
<?php endwhile; endif; ?>
<?php get_footer(); ?>