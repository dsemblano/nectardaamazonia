// scripts/critical.js
import { generate } from 'critical';
import fs from 'fs';

const pages = [
  { url: 'https://nectardaamazonia.com.br/', template: 'home' },
  { url: 'https://nectardaamazonia.com.br/loja/', template: 'shop' },
];

async function generateCritical() {
  for (const page of pages) {
    const result = await generate({
      inline: false,
      src: page.url,
      width: 1300,
      height: 900,
      target: {
        css: `public/css/critical-${page.template}.css`,
      },
      extract: false,
    });
    console.log(`Generated Critical CSS for ${page.template}`);
  }
}

generateCritical();