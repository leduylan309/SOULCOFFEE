// Home page glue — only behaviour unique to this page. Everything reusable lives in components/.
import { bus } from '../core/events.js';
import { t } from '../core/i18n.js';

export default function home() {
  // B2B contact form success → confirm with a toast as well as the inline thank-you panel.
  document.getElementById('contact-form')?.addEventListener('soul:form:success', () => bus.emit('toast:show', { message: t('form.thanks') }));
}
