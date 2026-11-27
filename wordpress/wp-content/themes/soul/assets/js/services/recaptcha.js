/**
 * Google reCAPTCHA v3 token helper.
 * No-op when SoulTheme.recaptcha.enabled is false / keys not set.
 */

function cfg() {
  return window.SoulTheme?.recaptcha || {};
}

export function recaptchaEnabled() {
  const r = cfg();
  return !!(r.enabled && r.siteKey);
}

export function recaptchaProtects(group) {
  if (!recaptchaEnabled()) return false;
  const p = cfg().protect || {};
  return p[group] !== false;
}

/**
 * @param {string} action Google action name (newsletter|contact|checkout|login|…)
 * @returns {Promise<string>} token or ''
 */
export function getRecaptchaToken(action) {
  if (!recaptchaEnabled()) return Promise.resolve('');
  const siteKey = cfg().siteKey;
  const run = () =>
    new Promise((resolve, reject) => {
      try {
        window.grecaptcha.ready(() => {
          window.grecaptcha
            .execute(siteKey, { action: action || 'submit' })
            .then((token) => resolve(token || ''))
            .catch(reject);
        });
      } catch (err) {
        reject(err);
      }
    });

  if (window.grecaptcha?.execute) return run();

  return new Promise((resolve, reject) => {
    let n = 0;
    const t = setInterval(() => {
      n += 1;
      if (window.grecaptcha?.execute) {
        clearInterval(t);
        run().then(resolve).catch(reject);
      } else if (n > 60) {
        clearInterval(t);
        reject(new Error('reCAPTCHA chưa tải được. Thử lại sau.'));
      }
    }, 100);
  });
}
