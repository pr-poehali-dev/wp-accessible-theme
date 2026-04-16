/**
 * ХМАО ВОИ — main.js v2.0
 * Мобильное меню + версия для слабовидящих + AJAX-форма
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
      toggle.setAttribute('aria-expanded', isOpen ? 'true' : 'false');
    });
    document.addEventListener('click', function (e) {
      if (menu.classList.contains('is-open') && !toggle.contains(e.target) && !menu.contains(e.target)) {
        menu.classList.remove('is-open');
        toggle.setAttribute('aria-expanded', 'false');
      }
    });
  }

  /* ====================================================
     ВЕРСИЯ ДЛЯ СЛАБОВИДЯЩИХ
  ==================================================== */
  var viBtn   = document.getElementById('vi-toggle');
  var body    = document.body;
  var VI_KEY  = 'hmao-vi-mode';

  function enableVI() {
    body.classList.add('vi-mode');
    localStorage.setItem(VI_KEY, '1');
    if (viBtn) {
      var lbl = viBtn.querySelector('.vi-toggle__label');
      if (lbl) lbl.textContent = 'Обычная версия';
    }
  }

  function disableVI() {
    body.classList.remove('vi-mode');
    localStorage.setItem(VI_KEY, '0');
    if (viBtn) {
      var lbl = viBtn.querySelector('.vi-toggle__label');
      if (lbl) lbl.textContent = 'Версия для слабовидящих';
    }
  }

  if (localStorage.getItem(VI_KEY) === '1') enableVI();

  if (viBtn) {
    viBtn.addEventListener('click', function () {
      body.classList.contains('vi-mode') ? disableVI() : enableVI();
    });
  }

  /* ====================================================
     AJAX ФОРМА ОБРАТНОЙ СВЯЗИ
  ==================================================== */
  var form = document.getElementById('hmao-contact-form');
  if (form && typeof hmaoAjax !== 'undefined') {
    form.addEventListener('submit', function (e) {
      e.preventDefault();

      var name    = form.querySelector('[name="cf_name"]');
      var email   = form.querySelector('[name="cf_email"]');
      var message = form.querySelector('[name="cf_message"]');
      var nonce   = form.querySelector('[name="cf_nonce"]');
      var phone   = form.querySelector('[name="cf_phone"]');
      var btn     = form.querySelector('.cf-submit');
      var success = document.getElementById('cf-success');
      var error   = document.getElementById('cf-error');

      success.style.display = 'none';
      error.style.display   = 'none';

      if (!name.value.trim() || !email.value.trim() || !message.value.trim()) {
        error.style.display = 'block';
        return;
      }

      btn.disabled    = true;
      btn.textContent = 'Отправка...';

      var data = new URLSearchParams();
      data.append('action',  'hmao_contact');
      data.append('nonce',   nonce ? nonce.value : '');
      data.append('name',    name.value.trim());
      data.append('email',   email.value.trim());
      data.append('phone',   phone ? phone.value.trim() : '');
      data.append('message', message.value.trim());

      fetch(hmaoAjax.url, {
        method: 'POST',
        headers: { 'Content-Type': 'application/x-www-form-urlencoded' },
        body:    data.toString()
      })
      .then(function (r) { return r.json(); })
      .then(function (res) {
        if (res.success) {
          success.style.display = 'block';
          form.reset();
        } else {
          error.style.display = 'block';
          error.textContent   = res.data && res.data.msg ? res.data.msg : 'Ошибка отправки. Попробуйте позже.';
        }
      })
      .catch(function () {
        error.style.display = 'block';
        error.textContent   = 'Ошибка соединения. Попробуйте позже.';
      })
      .finally(function () {
        btn.disabled    = false;
        btn.textContent = 'Отправить сообщение';
      });
    });
  }

  /* ====================================================
     ПЛАВНАЯ ПРОКРУТКА ДЛЯ ЯКОРЕЙ
  ==================================================== */
  document.querySelectorAll('a[href^="#"]').forEach(function (a) {
    a.addEventListener('click', function (e) {
      var target = document.querySelector(this.getAttribute('href'));
      if (target) {
        e.preventDefault();
        target.scrollIntoView({ behavior: 'smooth', block: 'start' });
      }
    });
  });

})();
