(function () {
  document.addEventListener('DOMContentLoaded', () => {
    const cookieEl = document.querySelector('.cookie-disclaimer');
    const acceptBtn = document.getElementById('cookie-disclaimer-accept-btn');
    const closeBtn = document.getElementById('cookie-disclaimer-close-btn');

    function setCookie(name, value, days) {
      const date = new Date();
      date.setTime(date.getTime() + days * 24 * 60 * 60 * 1000);
      const expires = '; expires=' + date;
      document.cookie = name + '=' + (value || '') + expires + '; path=/';
    }

    function getCookie(name) {
      return document.cookie
        .split('; ')
        .find((row) => row.startsWith(name + '='));
    }

    if (!getCookie('cookie-disclaimer')) {
      cookieEl.classList.remove('cookie-disclaimer-disabled');
    } else {
      cookieEl.classList.add('cookie-disclaimer-disabled');
    }

    acceptBtn.addEventListener('click', () => {
      setCookie('cookie-disclaimer', true, 30);
      cookieEl.classList.add('cookie-disclaimer-disabled');
    });

    closeBtn.addEventListener('click', () => {
      cookieEl.classList.add('cookie-disclaimer-disabled');
    });
  });
})();
