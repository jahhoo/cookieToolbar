# Implementace Cookie lišty

 - nakopírujte složku *cookieToolbar* do hlavního adresáře webu
 - vytvořte konfigurační soubor:
	 - [upravením vzorového souboru](https://github.com/jahhoo/cookieToolbar/wiki/Vzorov%C3%BD-konfigura%C4%8Dn%C3%AD-soubor-JSON)
	 - [vygenerováním pomocí PHP třídy](https://github.com/jahhoo/cookieToolbar/wiki/Vygenerov%C3%A1n%C3%AD-konfigura%C4%8Dn%C3%ADho-souboru-pomoc%C3%AD-PHP)
- vložte kód do všech HTML stránek (např. do index.html):
```
<link rel='stylesheet' href='/cookieToolbar/bundle.css'>  
<script defer src='/cookieToolbar/bundle.js'></script>
<script src='/cookieToolbar/cookies.js'></script>
```
- pokud konfiguračnímu souboru nastavíte jiný název nebo ho uložíte do podreasáře - je potřeba to nastavit v HTML tagu:
  `<html lang="cs" data-cookieToolbar="/cookieToolbarConfig.php">`

Hotovo :)

