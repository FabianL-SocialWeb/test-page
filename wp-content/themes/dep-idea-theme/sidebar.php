<?php if ( is_active_sidebar( 'primary-widget-area' ) ) : ?>
    <aside class="flex-shrink-0 col-md-auto p-0 sidebar-visible noprint" id="sidebar" role="complementary">
        <div id="primary" class="widget-area h-100 sidebar-content d-flex flex-column flex-shrink-0">
            <a href="/" class="d-block align-items-center p-3 mb-3 link-body-emphasis text-decoration-none border-bottom">
                <img src="/wp-content/themes/dep-idea-theme/images/idea-logo.svg" class="w-100" />
            </a>
            <?php
                wp_nav_menu( 
                    array(
                        'theme-location'    => 'sidebar-menu',
                        'container'      => 'ul',
                        'menu_class'     => 'list-unstyled ps-0 flex-column mb-auto',
                        'menu_id'        => 'sidebar_menu_id',
                        'echo'              => true,
                        'walker' => new Sidebar_Walker
                    ) 
                ); 
            ?>
            <div class="border-top">
                <img class="d-flex align-items-center p-2 mt-3 w-100" src="/wp-content/themes/dep-idea-theme/images/dep-bid.svg"/>
            </div>
        </div>
        <button id="sidebar-toggle-btn" onclick="toggleSidebar()">☰</button>
    </aside>
    <script>
        function toggleSidebar() {
            const sidebar = document.getElementById('content-wrapper');
            sidebar.classList.toggle('sidebar-hidden');
        }
    </script>
<?php endif; ?>
