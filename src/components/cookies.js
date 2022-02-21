//author Jan Holomek (e-mail: jahhoo@gmail.com)
//GitHub: https://github.com/jahhoo/cookieToolbar
export function setCookie(name, value, days) {
  const d = new Date();
  d.setTime(d.getTime() + (days*60*60*24*1000));
  document.cookie = name + "=" + value + ";" + "expires="+ d.toUTCString() + ";path=/";
}

export function getCookie(name) {
  let coknam = name + "=";
  let ca = decodeURIComponent(document.cookie).split(';');
  for(let i = 0; i <ca.length; i++) {
    let c = ca[i];
    while (c.charAt(0) == ' ') { c = c.substring(1); }
    if (c.indexOf(coknam) == 0) { return c.substring(coknam.length, c.length); }
  }
  return false;
}

export function cookieSettings(personalization=true, analytics=true, marketing=true, cookieName="CookieSettings") {
  let actualSettings=[
    { necessary: true, personalization: personalization, analytics: analytics, marketing:marketing }
  ];
  updateCookie(actualSettings, cookieName);
}

export function updateCookie(actualSettings, cookieName="CookieSettings") {
  setCookie(cookieName, JSON.stringify(actualSettings), "365");
}

export function isAllowCookie(type, cookieName="CookieSettings") {
  let cook=getCookie(cookieName);
  if(!cook) { return false; }
  let actualSettings=JSON.parse(cook);
  if(actualSettings[0][type]) { return true; }
  return false;
}
