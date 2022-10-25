import { LitElement, css, html } from 'lit';
import { customElement } from 'lit/decorators.js';

@customElement('cp-searchform')
export class CpSearchform extends LitElement {
  static styles = css`
    :host {
      display: block;
    }
  `;

  render() {
    return html`<slot></slot>`;
  }
}
