//author Jan Holomek (e-mail: jahhoo@gmail.com)
//GitHub: https://github.com/jahhoo/cookieToolbar
function getCookie(name) {
  let coknam = name + "=";
  let ca = decodeURIComponent(document.cookie).split(';');
  for(let i = 0; i <ca.length; i++) {
    let c = ca[i];
    while (c.charAt(0) == ' ') { c = c.substring(1); }
    if (c.indexOf(coknam) == 0) { return c.substring(coknam.length, c.length); }
  }
  return false;
}

function isAllowCookie(type, cookieName="CookieSettings") {
  let cook=getCookie(cookieName);
  if(!cook) { return false; }
  let actualSettings=JSON.parse(cook);
  if(actualSettings[0][type]) { return true; }
  return false;
}

function isAllowPersonalizationCookie(cookieName="CookieSettings") { return isAllowCookie("personalization", cookieName); }
function isAllowAnalyticsCookie(cookieName="CookieSettings") { return isAllowCookie("analytics", cookieName); }
function isAllowMarketingCookie(cookieName="CookieSettings") { return isAllowCookie("marketing", cookieName); }
