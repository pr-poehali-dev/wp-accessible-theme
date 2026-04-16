/**
 * ХМАО ВОИ — main.js
 * Мобильное меню + версия для слабовидящих
 */
(function () {
    'use strict';

    /* ====================================================
       МОБИЛЬНОЕ МЕНЮ
    ==================================================== */
    var toggle = document.getElementById('nav-toggle');
    var menu   = document.querySelector('.main-menu');

    if (toggle && menu) {
        toggle.addEventListener('click', function () {
            var isOpen = menu.classList.toggle('is-open');
            toggle.classList.toggle('open', isOpen);
            toggle.setAttribute('aria-expanded', isOpen ? 'true' : 'false');
        });

        // Закрываем при клике вне
        document.addEventListener('click', function (e) {
            if (menu.classList.contains('is-open') && !toggle.contains(e.target) && !menu.contains(e.target)) {
                menu.classList.remove('is-open');
                toggle.classList.remove('open');
                toggle.setAttribute('aria-expanded', 'false');
            }
        });
    }

    /* ====================================================
       ВЕРСИЯ ДЛЯ СЛАБОВИДЯЩИХ
    ==================================================== */
    var viBtn   = document.getElementById('vi-toggle');
    var body    = document.body;
    var STORAGE = 'hmao-vi-mode';

    // Читаем настройки из Customizer (переданы через wp_localize_script)
    var viCfg = (typeof hmaoVI !== 'undefined') ? hmaoVI : {
        vi_bg:        '#000000',
        vi_text:      '#FFFF00',
        vi_link:      '#00FFFF',
        vi_font_size: '120'
    };

    function applyVICSS() {
        var root = document.documentElement;
        root.style.setProperty('--vi-bg',        viCfg.vi_bg);
        root.style.setProperty('--vi-text',       viCfg.vi_text);
        root.style.setProperty('--vi-link',       viCfg.vi_link);
        root.style.setProperty('--vi-font-size',  viCfg.vi_font_size + '%');
    }

    function enableVI() {
        applyVICSS();
        body.classList.add('vi-mode');
        localStorage.setItem(STORAGE, '1');
        if (viBtn) {
            viBtn.classList.add('active');
            var lbl = viBtn.querySelector('.vi-toggle__label');
            if (lbl) lbl.textContent = 'Обычная версия';
        }
    }

    function disableVI() {
        body.classList.remove('vi-mode');
        localStorage.setItem(STORAGE, '0');
        if (viBtn) {
            viBtn.classList.remove('active');
            var lbl = viBtn.querySelector('.vi-toggle__label');
            if (lbl) lbl.textContent = 'Версия для слабовидящих';
        }
    }

    // Восстанавливаем режим после перезагрузки страницы
    if (localStorage.getItem(STORAGE) === '1') {
        enableVI();
    }

    if (viBtn) {
        viBtn.addEventListener('click', function () {
            if (body.classList.contains('vi-mode')) {
                disableVI();
            } else {
                enableVI();
            }
        });
    }

    /* ====================================================
       LIGHTBOX ДЛЯ ФОТОГРАФИЙ (простой)
    ==================================================== */
    document.addEventListener('click', function (e) {
        var photoItem = e.target.closest('.photo-item');
        if (photoItem) {
            var img = photoItem.querySelector('img');
            if (!img) return;

            var overlay = document.createElement('div');
            overlay.style.cssText = [
                'position:fixed', 'inset:0', 'background:rgba(0,0,0,.92)',
                'z-index:9999', 'display:flex', 'align-items:center',
                'justify-content:center', 'padding:20px', 'cursor:pointer'
            ].join(';');

            var bigImg = document.createElement('img');
            bigImg.src = img.src;
            bigImg.style.cssText = 'max-width:100%;max-height:90vh;border-radius:10px;object-fit:contain;';
            overlay.appendChild(bigImg);

            var closeBtn = document.createElement('button');
            closeBtn.innerHTML = '&times;';
            closeBtn.style.cssText = [
                'position:absolute','top:16px','right:20px',
                'background:none','border:none','color:#fff',
                'font-size:2.5rem','cursor:pointer','line-height:1'
            ].join(';');
            overlay.appendChild(closeBtn);

            document.body.appendChild(overlay);

            overlay.addEventListener('click', function () { overlay.remove(); });
            closeBtn.addEventListener('click',  function () { overlay.remove(); });
        }
    });

})();
