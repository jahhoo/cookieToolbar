//author Jan Holomek (e-mail: jahhoo@gmail.com)
//GitHub: https://github.com/jahhoo/cookieToolbar
export function getTranslate(item, data, lang) {
  let translate="";
  if(lang.includes("-")) {
    let l=lang.split("-");
    lang=l[0];
  }
	if(data) {
		if(typeof data.labels[lang]!=="undefined") {
      if(typeof data.labels[lang][item]!=="undefined") { return data.labels[lang][item]; }
    }
	   if(data.labels[data.defaultLang]) {
      if(typeof data.labels[data.defaultLang][item]!=="undefined") { return data.labels[data.defaultLang][item]; }
    }
	}
	return "";
}
