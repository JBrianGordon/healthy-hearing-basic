class Tab {
  constructor(element) {
    this.element = element;
  }

  static VERSION = '3.4.1';
  static TRANSITION_DURATION = 150;

  show() {
    const $this = this.element;
    const $ul = $this.closest('ul:not(.dropdown-menu)');
    let selector = $this.data('target');

    if (!selector) {
      selector = $this.attr('href');
      selector = selector && selector.replace(/.*(?=#[^\s]*$)/, ''); // strip for ie7
    }

    if ($this.parent('li').hasClass('active')) return;

    const $previous = $ul.find('.active:last a');
    const hideEvent = new Event('hide.bs.tab', {
      relatedTarget: $this[0]
    });
    const showEvent = new Event('show.bs.tab', {
      relatedTarget: $previous[0]
    });

    $previous.dispatchEvent(hideEvent);
    $this.dispatchEvent(showEvent);

    if (showEvent.defaultPrevented || hideEvent.defaultPrevented) return;

    const $target = document.querySelector(selector);

    this.activate($this.closest('li'), $ul);
    this.activate($target, $target.parentElement, () => {
      $previous.dispatchEvent(new Event('hidden.bs.tab', {
        relatedTarget: $this[0]
      }));
      $this.dispatchEvent(new Event('shown.bs.tab', {
        relatedTarget: $previous[0]
      }));
    });
  }

  activate(element, container, callback) {
    const $active = container.querySelector('> .active');
    const transition = callback
      && ($active?.classList.contains('fade') || !!container.querySelector('> .fade'));

    const next = () => {
      $active?.classList.remove('active');
      $active?.querySelector('> .dropdown-menu > .active')?.classList.remove('active');
      $active?.querySelectorAll('[data-toggle="tab"]')?.forEach(tab => {
        tab.setAttribute('aria-expanded', false);
      });

      element.classList.add('active');
      element.querySelectorAll('[data-toggle="tab"]')?.forEach(tab => {
        tab.setAttribute('aria-expanded', true);
      });

      if (transition) {
        element.offsetWidth; // reflow for transition
        element.classList.add('in');
      } else {
        element.classList.remove('fade');
      }

      if (element.parentElement?.classList.contains('dropdown-menu')) {
        element.closest('li.dropdown')?.classList.add('active');
        element.querySelectorAll('[data-toggle="tab"]')?.forEach(tab => {
          tab.setAttribute('aria-expanded', true);
        });
      }

      callback?.();
    };

    if ($active && transition) {
      $active.addEventListener('bsTransitionEnd', next, { once: true });
      emulateTransitionEnd($active, Tab.TRANSITION_DURATION);
    } else {
      next();
    }

    $active?.classList.remove('in');
  }
}

// Helper function to emulate transition end event
function emulateTransitionEnd(element, duration) {
  let called = false;
  const durationPadding = 5;
  const transitionEndEvent = new Event('bsTransitionEnd');

  const handleTransitionEnd = () => {
    called = true;
    element.removeEventListener('transitionend', handleTransitionEnd);
    element.removeEventListener('webkitTransitionEnd', handleTransitionEnd);
    element.dispatchEvent(transitionEndEvent);
  };

  element.addEventListener('transitionend', handleTransitionEnd);
  element.addEventListener('webkitTransitionEnd', handleTransitionEnd);

  setTimeout(() => {
    if (!called) {
      element.dispatchEvent(transitionEndEvent);
    }
  }, duration + durationPadding);
}

document.addEventListener('DOMContentLoaded', function() {
  const clickHandler = function(e) {
    e.preventDefault();
    const tab = new Tab(this);
    tab.show();
  };

  document.querySelectorAll('[data-toggle="tab"]').forEach(tab => {
    tab.addEventListener('click', clickHandler);
  });

  // Display the selected tab
  const hash = window.location.hash;
  if (hash.length > 0) {
    const parentTabId = document.querySelector(`a[href="${hash}"]`).closest('.tab-pane')?.id;
    if (typeof parentTabId !== 'undefined') {
      // If tab is nested with a parent tab, click both
      document.querySelector(`a[href="#${parentTabId}"]`)?.click();
    }
    document.querySelector(`a[href="${hash}"]`)?.click();
  }

  // When a tab is clicked, change the URL to our new hash
  document.querySelectorAll('.nav-tabs a').forEach(link => {
    link.addEventListener('click', function() {
      const scrollmem = document.body.scrollTop || document.documentElement.scrollTop;
      window.location.hash = this.hash;
      document.documentElement.scrollTop = document.body.scrollTop = scrollmem;
    });
  });

  // On submit, make any validation errors on tabs visible
  document.querySelectorAll('input[type=submit]').forEach(submitBtn => {
    submitBtn.addEventListener('click', function() {
      const form = this.closest('form');
      if (form && !form.checkValidity()) {
        displayErrorsOnTabs();
      }
    });
  });

  // Make validation errors on tabs more visible
  function displayErrorsOnTabs() {
    document.querySelectorAll('input:invalid').forEach(input => {
      const parentDiv = input.parentElement;
      if (parentDiv) {
        parentDiv.classList.add('has-error');
      }
    });
    document.querySelectorAll('input.form-error').forEach(input => {
      const parentDiv = input.parentElement;
      if (parentDiv) {
        parentDiv.classList.add('has-error');
      }
    });
    document.querySelectorAll('.nav-tabs li a').forEach(link => {
      const tab = document.querySelector(link.getAttribute('href'));
      if (tab && (tab.querySelector('div.has-error') || tab.querySelector('span.has-error') || tab.querySelector('input.form-error'))) {
        link.classList.add('tab-has-error');
        link.click();
      }
    });
  }
});