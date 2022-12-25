import {LitElement, html, css} from 'lit';
import {customElement, property} from 'lit/decorators.js';
import {gettext as _} from '../_i18n.ts';
import {intToHex, codepointToUtf16} from '../_unicode-tools.ts';

function jsonify(n) {
  return codepointToUtf16(n).map(function(x) {
    return '\\u' + intToHex(x);
  }).join('');
}

function backslash_u_curly(n) {
  return '\\u{'+n.toString(16).toLowerCase()+'}';
}

const formatters = [
  [_('RFC 5137'), function(n) {
    return '\\u\'' + intToHex(n) + '\'';
  }],

  [_('Python'), function(n) {
    let str = n.toString(16).toUpperCase(),
        pad = 4, chr = 'u';
    if (n > 0xFFFF) {
      pad = 8;
      chr = 'U';
    }
    while (str.length < pad) {
      str = "0" + str;
    }
    return '\\'+chr+str;
  }],

  [_('Ruby'), backslash_u_curly],

  [_('PHP'), backslash_u_curly],

  [_('Perl'), function(n) {
    return '"\\x{'+n.toString(16).toUpperCase()+'}"';
  }],

  [_('JavaScript'), jsonify],
  [_('Modern JavaScript'), backslash_u_curly],
  [_('JSON'), jsonify],
  [_('Java'), jsonify],

  [_('C'), function(n) {
    let str = n.toString(16).toUpperCase(),
        pad = 4, chr = 'u';
    if (n > 0xFFFF) {
      pad = 8;
      chr = 'U';
    }
    while (str.length < pad) {
      str = "0" + str;
    }
    return '\\'+chr+str;
  }],

  [_('CSS'), function(n) {
    let str = n.toString(16).toUpperCase();
    while (str.length < 6) {
      str = "0" + str;
    }
    return '\\'+str;
  }],
];

@customElement('cp-representations')
export class CpRepresentations extends LitElement {
  static styles = css`
:host > button {
  display: block;
  margin-top: .5rem;
}
:host > button,
.props {
  margin-left: auto;
  margin-right: auto;
}
th, td {
  padding: .2rem .5rem;
}
th:first-child {
  text-align: right;
}
th:last-child {
  text-align: left;
}
small {
  font-weight: normal;
}
tbody tr:not(.primary,.visible) {
  display: none;
}
  `;

  @property({ type: Number })
  declare cp = null;

  @property({ type: Boolean })
  declare allShown = false;

  constructor() {
    super();
    this._representations = [];
    this.allShown = false;
  }

  connectedCallback() {
    super.connectedCallback();
    this._thead = this.querySelector('thead');
    this._thead.querySelector('th:last-child').insertAdjacentHTML('beforeend',
      ` <small>${_('(click value to copy)')}</small>`);
    this.querySelectorAll('tbody tr').forEach(tr => {
      const label = tr.querySelector('th').textContent.trim();
      const value = tr.querySelector('td').textContent.trim();
      if (label && value) {
        this._representations.push({label, value, primary: tr.classList.contains('primary')});
      }
    });
    formatters.forEach(formatter => {
      this._representations.push({label: formatter[0], value: formatter[1](this.cp)});
    });
  }

  render() {
    return html`
<table class="props representations">
  ${this._thead}
  <tbody>
    ${this._representations.map(obj => html`
      <tr class="${obj.primary? 'primary' : ''}">
        <th scope="row">${obj.label}</th>
        <td><cp-copy content="${obj.value}">${obj.value}</cp-copy></td>
      </tr>
    `)}
  </tbody>
</table>
<button type="button" @click="${this.toggle}">${this.allShown? _('hide') : _('show more')}</button>
    `;
  }

  toggle() {
    this.allShown = ! this.allShown;
    this.renderRoot.querySelectorAll('tbody tr').forEach(tr => tr.classList.toggle('visible', this.allShown));
  }
}
