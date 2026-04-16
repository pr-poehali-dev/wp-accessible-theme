</main><!-- .site-main -->

<!-- ===== FOOTER ===== -->
<footer class="site-footer" role="contentinfo">
    <div class="container">
        <div class="site-footer__inner">

            <div class="footer-brand">
                <div class="footer-brand__name"><?php bloginfo('name'); ?></div>
                <div><?php bloginfo('description'); ?></div>
                <div class="footer-copy" style="margin-top:8px;">
                    <?php echo wp_kses_post( hmao_mod( 'footer_copy', '© ' . date('Y') . ' ХМАО ВОИ. Все права защищены.' ) ); ?>
                </div>
            </div>

            <div class="footer-contacts">
                <?php if ( $addr = hmao_mod('contact_address') ) : ?>
                    <div><?php echo hmao_icon('map-pin'); ?> <?php echo esc_html( $addr ); ?></div>
                <?php endif; ?>
                <?php if ( $phone = hmao_mod('contact_phone') ) : ?>
                    <div>
                        <?php echo hmao_icon('phone'); ?>
                        <a href="tel:<?php echo esc_attr( preg_replace('/[^+\d]/', '', $phone) ); ?>">
                            <?php echo esc_html( $phone ); ?>
                        </a>
                    </div>
                <?php endif; ?>
                <?php if ( $email = hmao_mod('contact_email') ) : ?>
                    <div>
                        <?php echo hmao_icon('mail'); ?>
                        <a href="mailto:<?php echo esc_attr( $email ); ?>">
                            <?php echo esc_html( $email ); ?>
                        </a>
                    </div>
                <?php endif; ?>
            </div>

        </div>
    </div>
</footer><!-- .site-footer -->

</div><!-- .site-wrapper -->

<?php wp_footer(); ?>
</body>
</html>
