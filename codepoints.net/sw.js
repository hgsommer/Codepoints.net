if(!self.define){const s=s=>{"require"!==s&&(s+=".js");let e=Promise.resolve();return c[s]||(e=new Promise((async e=>{if("document"in self){const c=document.createElement("script");c.src=s,document.head.appendChild(c),c.onload=e}else importScripts(s),e()}))),e.then((()=>{if(!c[s])throw new Error(`Module ${s} didn’t register its module`);return c[s]}))},e=(e,c)=>{Promise.all(e.map(s)).then((s=>c(1===s.length?s[0]:s)))},c={require:Promise.resolve(e)};self.define=(e,i,r)=>{c[e]||(c[e]=Promise.resolve().then((()=>{let c={};const t={uri:location.origin+e.slice(1)};return Promise.all(i.map((e=>{switch(e){case"exports":return c;case"module":return t;default:return s(e)}}))).then((s=>{const e=r(...s);return c.default||(c.default=e),c}))})))}}define("./sw.js",["./workbox-994aa968"],(function(s){"use strict";self.skipWaiting(),s.clientsClaim(),s.precacheAndRoute([{url:"manifest.webmanifest",revision:"ac3a971c45ba26f49290b964864302c0"},{url:"static/css/_base.css",revision:"b10557e2802c57e0a3668c8d26ff3cbf"},{url:"static/css/_codepoints.css",revision:"e6c59e0755d34bedfdf5026803c2c1b7"},{url:"static/css/_crosslinks.css",revision:"8fed2e43b38519416a0494d78d34f7c1"},{url:"static/css/_font.css",revision:"81523c03e8b3a8aa206e595d436c090d"},{url:"static/css/_footer.css",revision:"3b0c63056332cc83502ef492dd58a858"},{url:"static/css/_forms.css",revision:"a9bc3ac133257bf3dc40d4122564dc92"},{url:"static/css/_header.css",revision:"c22ca7568ea5a98967fdd7859226c6a0"},{url:"static/css/_main-content.css",revision:"9329f0ed587bc449329fb217cd42dd93"},{url:"static/css/_pagination.css",revision:"377b22b69cfe6484d12909a5f7d39141"},{url:"static/css/main.css",revision:"34eab8cb7d4fef51f5c6d7825a410296"},{url:"static/fonts/Literata-Italic.woff2",revision:"ac992d80e3ce42dacb70271ea6458ebb"},{url:"static/fonts/Literata.woff2",revision:"0f38d0e4a1ffae4eec4a158fdecac91c"},{url:"static/locale/de.js",revision:"4d31cacc465ed0317b67187285597f91"},{url:"static/locale/pl.js",revision:"314b6105682ead4a2416db538236624d"},{url:"/offline.html",revision:"Feicheez5phe2am2"}],{})}));
