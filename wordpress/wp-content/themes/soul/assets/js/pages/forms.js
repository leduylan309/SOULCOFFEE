// Bind [data-soul-form] → REST newsletter / contact (+ reCAPTCHA v3 when enabled).
import { getRecaptchaToken } from '../services/recaptcha.js';

export default function bootForms() {
  if (!window.SoulTheme?.restUrl) return;

  document.querySelectorAll('[data-soul-form]').forEach((form) => {
    if (!(form instanceof HTMLFormElement)) return;
    form.addEventListener('submit', async (e) => {
      e.preventDefault();
      const kind = form.getAttribute('data-soul-form');
      const msg = form.querySelector('.soul-form-msg');
      const btn = form.querySelector('[type="submit"]');
      const fd = new FormData(form);
      const payload = Object.fromEntries(fd.entries());
      if (!payload.website) payload.website = '';
      if (kind === 'contact') {
        payload.source = form.getAttribute('data-source') || 'contact';
      }
      if (btn) btn.disabled = true;
      if (msg) {
        msg.hidden = true;
        msg.textContent = '';
      }
      try {
        const action = kind === 'newsletter' ? 'newsletter' : 'contact';
        payload.recaptchaToken = await getRecaptchaToken(action);
        const endpoint = kind === 'newsletter' ? 'newsletter' : 'contact';
        const res = await fetch(window.SoulTheme.restUrl + endpoint, {
          method: 'POST',
          headers: {
            'Content-Type': 'application/json',
            'X-WP-Nonce': window.SoulTheme.nonce,
          },
          body: JSON.stringify(payload),
        });
        const data = await res.json();
        if (!res.ok) throw new Error(data?.message || 'Không gửi được.');
        if (msg) {
          msg.hidden = false;
          msg.textContent = kind === 'newsletter' ? 'Cảm ơn bạn đã đăng ký.' : 'Cảm ơn bạn. Soul đã nhận thông tin.';
        }
        form.reset();
      } catch (err) {
        if (msg) {
          msg.hidden = false;
          msg.textContent = err.message || 'Lỗi gửi form.';
        }
      } finally {
        if (btn) btn.disabled = false;
      }
    });
  });
}
