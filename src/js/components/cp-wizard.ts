import anime from 'animejs/lib/anime.es.js';
import {LitElement, css, html} from 'lit';
import {customElement, property} from 'lit/decorators.js';
import {ref, createRef} from 'lit/directives/ref.js';
import {unsafeHTML} from 'lit/directives/unsafe-html.js';
import {gettext as _} from '../_i18n.ts';


/**
 * a single question for the wizard
 */
@customElement('cp-question')
export class CpQuestion extends LitElement {

  static current: null;

  sliderRef: Ref<HTMLInputElement> = createRef();

  txtRef: Ref<HTMLInputElement> = createRef();

  constructor(id, text, answers) {
    super();
    /* eslint-disable wc/no-constructor-attributes */
    this.id = id;
    /* eslint-enable wc/no-constructor-attributes */
    this.text = text;
    this.prev = null;
    this.next = {};
    this.answers = answers || {};
    this.selected = null;
  }

  setNextForAnswer(id, next) {
    this.next[id] = next;
  }

  render() {
    return html`
      <p>${this.text}</p>
      ${this.renderAnswers()}`;
  }

  renderAnswers() {
    const answers = [];
    for (const id in this.answers) {
      const label = this.answers[id];
      if (id === '_number') {
        answers.push(html`<div class="answer number">
          <p><input type="range" ${ref(this.sliderRef)} min="${label[1]||0}" max="${label[2]||100}" value="${label[1]||0}" /></p>
          <p><button type="button" @click="${() => this.select(this.sliderRef.value, this.next[id])}">${unsafeHTML(label[0])}</button></p>
        </div>`);
      } else if (id === '_text') {
        answers.push(html`<p class="answer text">
          <input type="text" ${ref(this.txtRef)} @keypress="${(e) => {
            if (e.which === 13) {
              e.target.nextElementSibling.click();
              return false;
            }
          }}"/>
          <button type="button" @click="${() => this.select(this.txtRef.val(), this.next[id])}">${unsafeHTML(label)}</button>
        </p>`);
      } else {
        answers.push(html`<p class="answer">
          <button type="button" @click="${() => this.select(id, this.next[id])}">${unsafeHTML(label)}</button>
        </p>`);
      }
    }
    return answers;
  }

  select(id, next) {
    this.selected = id;
    const event = new Event('question-answered', {bubbles: true, composed: true});
    event.question = this;
    this.dispatchEvent(event);
    if (! next) {
      const event = new Event('question-finished', {bubbles: true, composed: true});
      this.dispatchEvent(event);
    } else {
      next.prev = this;
      return anime({
        targets: this,
        opacity: [1, 0],
        duration: 300,
        easing: 'cubicBezier(0.455, 0.030, 0.015, 0.955)',
      }).finished.then(() => {
        this.replaceWith(next);
        anime({
          targets: next,
          opacity: [0, 1],
          duration: 300,
          easing: 'cubicBezier(0.455, 0.030, 0.015, 0.955)',
        });
      });
    }
  }
}


/* eslint-disable @typescript-eslint/no-unused-vars */
const q_swallow = new CpQuestion('swallow',
  _('What’s the airspeed velocity of an unladen swallow?'), {
    1: _('An African, or'),
    2: _('A European Swallow?')
});
/* eslint-enable @typescript-eslint/no-unused-vars */

const q_region = new CpQuestion('region',
  _('Where does the character appear usually?'), {
    'Africa': _('Africa <small>(without Arabic)</small>'),
    'America': _('America <small>(originally, <i>e. g.</i> Cherokee, not Latin)</small>'),
    'Europe': _('Europe <small>(Latin, Cyrillic, …)</small>'),
    'Middle_East': _('Middle East'),
    'Central_Asia': _('Central Asia'),
    'East_Asia': _('East Asia <small>(Chinese, Korean, Japanese, …)</small>'),
    'South_Asia': _('South Asia <small>(Indian)</small>'),
    'Southeast Asia': _('Southeast Asia <small>(Thai, Khmer, …)</small>'),
    'Philippines': _('Philippines, Indonesia, Oceania'),
    'n': _('Nowhere specific'),
    '': _('I don’t know')
});

const q_number = new CpQuestion('number',
  _('Is it a number of any kind?'), {
    1: _('Yes'),
    0: _('No'),
    '': _('I don’t know')
});

const q_case = new CpQuestion('case',
  _('Has the character a case (upper, lower, title)?'), {
    l: _('Yes, it’s lowercase'),
    u: _('Yes, it’s uppercase'),
    t: _('Yes, it’s titlecase'),
    y: _('Yes, but I don’t know the case'),
    n: _('No, it’s uncased'),
    '': _('I don’t know')
});

const q_symbol = new CpQuestion('symbol',
  _('Is the character some kind of symbol or dingbat?'), {
    s: _('Yes <small>(It isn’t part of usually written text)</small>'),
    c: _('No <small>(But it is some kind of control character)</small>'),
    t: _('No <small>(It may appear in text, like letters or punctuation)</small>'),
    '': _('I don’t know')
});

const q_punc = new CpQuestion('punctuation',
  _('Is the character some kind of punctuation?'), {
    1: _('Yes'),
    0: _('No'),
    '': _('I don’t know')
});

const q_incomplete = new CpQuestion('incomplete',
  _('Is the character incomplete on its own, like a diacritic sign?'), {
    1: _('Yes <small>(It’s usually found together with another character)</small>'),
    0: _('No <small>(It stands on its own)</small>'),
    '': _('I don’t know')
});

const q_composed = new CpQuestion('composed',
  _('Is the character composed of two others?'), {
    1: _('Yes <small>(It is based on two or more other characters)</small>'),
    2: _('Sort of <small>(It’s got some quiggly lines or dots, like “Ä” or “ٷ”)</small>'),
    0: _('No <small>(It is a genuine character)</small>'),
    '': _('I don’t know')
});

const q_confuse = new CpQuestion('confuse',
  _('Off the top of your head, can the character be confused with another one?'), {
    1: _('Yes <small>(Like latin “A” and greek “Α”, alpha)</small>'),
    '': _('No <small>(I have no such pair in mind)</small>')
});

const q_archaic = new CpQuestion('archaic',
  _('Is it an archaic character or is it in use today?'), {
    1: _('Yep, noone would use that anymore!'),
    0: _('Nah, seen it yesterday in the newspaper'),
    '': _('I don’t know')
});

const q_strokes = new CpQuestion('strokes',
  _('Do you know the number of strokes the character has?'), {
    _number: [_('This much'), 1, 64],
    '': _('Nope, never counted them')
});

const q_def = new CpQuestion('def',
  _('Do you happen to know the meaning of the character?'), {
    _text: _('This is (part of) what I’m looking for'),
    '': _('I don’t speak that language')
});


q_region.setNextForAnswer('Africa', q_number);
q_region.setNextForAnswer('America', q_number);
q_region.setNextForAnswer('Europe', q_number);
q_region.setNextForAnswer('Middle_East', q_number);
q_region.setNextForAnswer('Central_Asia', q_number);
q_region.setNextForAnswer('South_Asia', q_number);
q_region.setNextForAnswer('Southeast_Asia', q_number);
q_region.setNextForAnswer('Philippines', q_number);
q_region.setNextForAnswer('n', q_symbol);
q_region.setNextForAnswer('', q_symbol);

q_region.setNextForAnswer('East_Asia', q_def);
q_def.setNextForAnswer('_text', q_strokes);
q_def.setNextForAnswer('', q_strokes);

q_strokes.setNextForAnswer('_number', q_composed);
q_strokes.setNextForAnswer('', q_composed);

q_number.setNextForAnswer(0, q_symbol);
q_number.setNextForAnswer('', q_symbol);

q_symbol.setNextForAnswer('t', q_punc);
q_symbol.setNextForAnswer('', q_punc);

q_punc.setNextForAnswer(1, q_archaic);
q_punc.setNextForAnswer(0, q_case);
q_punc.setNextForAnswer('', q_case);

q_case.setNextForAnswer('l', q_composed);
q_case.setNextForAnswer('u', q_composed);
q_case.setNextForAnswer('t', q_composed);
q_case.setNextForAnswer('y', q_composed);
q_case.setNextForAnswer('n', q_composed);
q_case.setNextForAnswer('', q_composed);

q_composed.setNextForAnswer(1, q_archaic);
q_composed.setNextForAnswer(2, q_archaic);
q_composed.setNextForAnswer(0, q_incomplete);
q_composed.setNextForAnswer('', q_incomplete);

q_incomplete.setNextForAnswer(1, q_archaic);
q_incomplete.setNextForAnswer(0, q_archaic);
q_incomplete.setNextForAnswer('', q_archaic);

q_archaic.setNextForAnswer(1, q_confuse);
q_archaic.setNextForAnswer(0, q_confuse);
q_archaic.setNextForAnswer('', q_confuse);


@customElement('cp-wizard')
export class CpWizard extends LitElement {
  static styles = css`
    :host {
      display: block;
    }
  `;

  @property()
  lastAnsweredQuestion = null;

  @property()
  loadResults = false;

  constructor() {
    super();
    this.addEventListener('question-answered', (event) => {
      this.lastAnsweredQuestion = event.question;
    });
    this.addEventListener('question-finished', this.finish);
  }

  render() {
    if (this.loadResults) {
      return html`
      loading...
      `;
    }
    return html`
      ${q_region}
      ${this.renderShortcut()}
    `;
  }

  renderShortcut() {
    if (! this.lastAnsweredQuestion) {
      return '';
    }
    return html`
      <p>
        <button type="button"
        @click="${this.finish}">${_('Enough questions! Search now.')}</button>
      </p>`;
  }

  finish() {
    const payload = { _wizard: 1, };
    let q = this.lastAnsweredQuestion;
    do {
      payload[q.id] = q.selected;
      q = q.prev;
    } while (q);
    this.loadResults = true;
    window.location.href = `/search?${(new URLSearchParams(payload)).toString()}`;
  }
}
