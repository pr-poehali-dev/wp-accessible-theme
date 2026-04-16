</main><!-- .site-main -->

<footer class="site-footer" role="contentinfo">
    <div class="container">
        <div class="footer-inner">
            <a href="<?php echo esc_url( home_url('/') ); ?>" class="footer-brand">
                <div class="footer-brand__name"><?php bloginfo('name'); ?></div>
            </a>
            <p class="footer-copy"><?php echo wp_kses_post( get_option('footer_copy_text', '© ' . date('Y') . ' ХМАО ВОИ. Все права защищены.') ); ?></p>
        </div>
    </div>
</footer><!-- .site-footer -->

</div><!-- .site-wrapper -->
<?php wp_footer(); ?>
</body>
</html>
