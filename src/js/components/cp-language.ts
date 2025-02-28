import { LitElement, html, css } from 'lit';
import { customElement, property } from 'lit/decorators.js';
import { gettext as _ } from '../_i18n.ts';

@customElement('cp-language')
export class CpLanguage extends LitElement {
  static styles = css`
    label > * {
      vertical-align: middle;
    }
  `;

  @property()
  declare currentLanguage : string;

  @property()
  declare languages : Array = [];

  constructor() {
    super();
    this.currentLanguage = document.documentElement.lang;
    this.languages = Array.from(document.querySelectorAll('link[rel="alternate"][hreflang]')).map(el => ({
      iso: el.hreflang,
      label: el.title,
      url: el.href,
    }));
  }

  render() {
    return html`
    <link rel="stylesheet" href="${document.getElementById('main-css').href}">
    <label>
      <cp-icon icon="language-icon" width="24px" height="24px"></cp-icon>&nbsp;
      ${_('choose language:')}
      <select @change="${this.choose}">
        ${this.languages.map(lang =>
          html`<option .selected="${lang.iso === this.currentLanguage}" value="${lang.url}">${lang.label}</option>`)}
      </select>
    </label>
    `;
  }

  choose(event) {
    window.location.href = event.target.value;
  }
}
