/* Manila Institute website: navigation, header state and enquiry forms. No dependencies. */
(function () {
  'use strict';

  /* ---- Reveal content as it enters the viewport; keep native scrolling. ---- */
  var motionPreference = window.matchMedia('(prefers-reduced-motion: reduce)');
  if ('IntersectionObserver' in window && Element.prototype.animate && !motionPreference.matches) {
    var motionTargets = Array.prototype.slice.call(document.querySelectorAll(
      'main .hero-copy > *, main .page-hero h1, main .page-hero .lead, main .section-head, ' +
      'main .course-card, main .highlight-grid > li, main .legacy-media, main .legacy-copy, ' +
      'main .info-card, main .info-card-media, main .feature-media, main .feature-copy, ' +
      'main .timeline-item, main .why-media, main .why-copy > h2, main .why-list > li, ' +
      'main .doctor-card, main .apply-copy, main .form-card, main .program-row'
    ));
    var motionObserver = new IntersectionObserver(function (entries) {
      entries.forEach(function (entry) {
        if (!entry.isIntersecting) return;
        var element = entry.target;
        element.classList.remove('motion-pending');
        if (!motionPreference.matches) {
          element.animate([
            { opacity: 0, translate: '0 18px' },
            { opacity: 1, translate: '0 0' }
          ], { duration: 900, delay: Number(element.dataset.motionDelay || 0), easing: 'cubic-bezier(.16,1,.3,1)', fill: 'backwards' });
        }
        motionObserver.unobserve(element);
      });
    }, { threshold: 0, rootMargin: '0px 0px 72px 0px' });
    motionTargets.forEach(function (element) {
      // Only stagger short card rows; timeline entries should never wait to appear.
      var index = Array.prototype.indexOf.call(element.parentNode.children, element);
      var stagger = element.matches('.course-card, .doctor-card, .highlight-grid > li, .hero-copy > *');
      element.dataset.motionDelay = stagger ? Math.min(index, 3) * 55 : 0;
      if (element.getBoundingClientRect().bottom <= 0) return;
      element.classList.add('motion-pending');
      motionObserver.observe(element);
    });
    document.addEventListener('focusin', function (event) {
      var pending = event.target.closest('.motion-pending');
      if (pending) {
        pending.classList.remove('motion-pending');
        motionObserver.unobserve(pending);
      }
    });
    if (motionPreference.addEventListener) motionPreference.addEventListener('change', function (event) {
      if (!event.matches) return;
      motionObserver.disconnect();
      motionTargets.forEach(function (element) {
        element.classList.remove('motion-pending');
        element.getAnimations().forEach(function (animation) { animation.cancel(); });
      });
    });
  }

  /* ---- Mobile navigation ---- */
  var toggle = document.querySelector('[data-nav-toggle]');
  var nav = document.querySelector('[data-nav]');
  var subs = Array.prototype.slice.call(document.querySelectorAll('[data-sub]'));

  function setNav(open) {
    if (!toggle || !nav) return;
    toggle.setAttribute('aria-expanded', String(open));
    nav.classList.toggle('is-open', open);
    document.body.classList.toggle('nav-open', open);
  }

  function closeSubs(except) {
    subs.forEach(function (li) {
      if (li === except) return;
      li.classList.remove('is-open');
      var btn = li.querySelector('[data-sub-toggle]');
      if (btn) btn.setAttribute('aria-expanded', 'false');
    });
  }

  if (toggle && nav) {
    toggle.addEventListener('click', function () {
      setNav(toggle.getAttribute('aria-expanded') !== 'true');
    });
    nav.addEventListener('click', function (e) {
      if (e.target.closest('a')) setNav(false);
    });
    var desktop = window.matchMedia('(min-width: 1024px)');
    var onChange = function (mq) { if (mq.matches) setNav(false); };
    if (desktop.addEventListener) desktop.addEventListener('change', onChange);
  }

  subs.forEach(function (li) {
    var btn = li.querySelector('[data-sub-toggle]');
    if (!btn) return;
    btn.addEventListener('click', function (e) {
      e.stopPropagation();
      var open = !li.classList.contains('is-open');
      closeSubs(li);
      li.classList.toggle('is-open', open);
      btn.setAttribute('aria-expanded', String(open));
    });
  });

  document.addEventListener('click', function (e) {
    if (!e.target.closest('[data-sub]')) closeSubs();
  });

  document.addEventListener('keydown', function (e) {
    if (e.key !== 'Escape') return;
    var openSub = subs.filter(function (li) { return li.classList.contains('is-open'); })[0];
    closeSubs();
    if (openSub) {
      var b = openSub.querySelector('[data-sub-toggle]');
      if (b) b.focus();
    } else if (toggle && toggle.getAttribute('aria-expanded') === 'true') {
      setNav(false);
      toggle.focus();
    }
  });

  /* ---- Header shadow once the page scrolls ---- */
  var header = document.querySelector('[data-header]');
  if (header) {
    var onScroll = function () { header.classList.toggle('is-scrolled', window.scrollY > 8); };
    onScroll();
    window.addEventListener('scroll', onScroll, { passive: true });
  }

  /* ---- Enquiry forms: inline validation and sending without a page reload ---- */
  var EMAIL = /^[^\s@]+@[^\s@]+\.[^\s@]{2,}$/;

  function icon(name) {
    return '<svg class="icon" aria-hidden="true" focusable="false"><use href="#i-' + name + '"></use></svg>';
  }

  Array.prototype.forEach.call(document.querySelectorAll('form[data-form]'), function (form) {
    form.noValidate = true;
    var status = form.querySelector('[data-form-status]');
    var submit = form.querySelector('[data-submit]');
    var label = form.querySelector('[data-submit-label]');
    var labelText = label ? label.textContent : '';
    var controls = Array.prototype.slice.call(form.querySelectorAll('[data-field] input, [data-field] select, [data-field] textarea'));

    function check(input) {
      var v = input.value.trim();
      if (!v) return input.required ? (input.getAttribute('data-required') || 'Please fill in this field.') : '';
      if (input.type === 'email' && !EMAIL.test(v)) return 'Please enter a valid email address, for example name@gmail.com.';
      if (input.type === 'tel') {
        var digits = v.replace(/\D/g, '').length;
        if (!/^[0-9+()\-. ]+$/.test(v) || digits < 10 || digits > 13) return 'Please enter a valid mobile number (10 digits, with or without +91).';
      }
      if (input.maxLength > 0 && v.length > input.maxLength) return 'Please keep this under ' + input.maxLength + ' characters.';
      return '';
    }

    function setError(input, msg) {
      var wrap = input.closest('[data-field]');
      var err = wrap.querySelector('.field-error');
      if (msg) {
        if (!err) {
          err = document.createElement('p');
          err.className = 'field-error';
          err.id = input.id + '-error';
          wrap.appendChild(err);
        }
        err.textContent = msg;
        wrap.classList.add('has-error');
        input.setAttribute('aria-invalid', 'true');
        input.setAttribute('aria-describedby', err.id);
      } else {
        if (err) err.parentNode.removeChild(err);
        wrap.classList.remove('has-error');
        input.removeAttribute('aria-invalid');
        input.removeAttribute('aria-describedby');
      }
    }

    function showStatus(type, msg) {
      if (!status) return;
      status.innerHTML = '';
      if (!msg) return;
      var box = document.createElement('div');
      box.className = 'alert alert-' + type;
      box.setAttribute('role', type === 'error' ? 'alert' : 'status');
      box.innerHTML = icon(type === 'error' ? 'alert' : 'check-circle');
      var p = document.createElement('p');
      p.textContent = msg;
      box.appendChild(p);
      status.appendChild(box);
    }

    function setBusy(busy) {
      if (!submit) return;
      submit.disabled = busy;
      submit.classList.toggle('is-loading', busy);
      if (label) label.textContent = busy ? 'Sending…' : labelText;
    }

    controls.forEach(function (input) {
      input.addEventListener('blur', function () {
        if (input.value.trim() !== '' || input.getAttribute('aria-invalid') === 'true') setError(input, check(input));
      });
      input.addEventListener('input', function () {
        if (input.getAttribute('aria-invalid') === 'true') setError(input, check(input));
      });
    });

    form.addEventListener('submit', function (e) {
      var first = null;
      controls.forEach(function (input) {
        var msg = check(input);
        setError(input, msg);
        if (msg && !first) first = input;
      });
      if (first) {
        e.preventDefault();
        showStatus('error', 'Please correct the highlighted fields and try again.');
        first.focus();
        return;
      }
      if (!window.fetch || !window.FormData) return; // fall back to a normal form post

      e.preventDefault();
      setBusy(true);
      fetch(form.getAttribute('action').split('#')[0], {
        method: 'POST',
        body: new FormData(form),
        headers: { Accept: 'application/json' },
        credentials: 'same-origin'
      })
        .then(function (res) { return res.json(); })
        .then(function (data) {
          var token = form.querySelector('[data-token]');
          if (token && data.token) token.value = data.token;
          if (data.ok) {
            form.reset();
            controls.forEach(function (input) { setError(input, ''); });
            showStatus('success', data.message);
            if (status && status.scrollIntoView) status.scrollIntoView({ block: 'center', behavior: 'smooth' });
          } else {
            var errors = data.errors || {};
            controls.forEach(function (input) { setError(input, errors[input.name] || ''); });
            showStatus('error', data.message || 'Please correct the highlighted fields and try again.');
            var bad = form.querySelector('[aria-invalid="true"]');
            if (bad) bad.focus();
          }
          setBusy(false);
        })
        .catch(function () {
          // Network or server problem: send the form the classic way so nothing is lost
          setBusy(false);
          form.submit();
        });
    });
  });
})();
