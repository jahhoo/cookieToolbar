<?php
# author Jan Holomek (e-mail: jahhoo@gmail.com)
# GitHub: https://github.com/jahhoo/cookieToolbar
class CookieToolbar {
	private $company;
	private $defaultLang;
	private $allowSaveDisableCookie;
	private $refreshAfterSet;
	private $configCookieName;
	private $configLangStorageName;
	private $labels;
	private $cookies;
	private $lastCookieType;
	private $styles;

	function __construct($company="", $defaultLang="cs", $allowSaveDisableCookie=true, $refreshAfterSet=false, $configCookieName="CookieSettings", $langStorageName=false) {
		$this->company=$company;
		$this->defaultLang=$defaultLang;
		$this->allowSaveDisableCookie=$allowSaveDisableCookie;
		$this->refreshAfterSet=$refreshAfterSet;
		$this->configCookieName=$configCookieName;
		$this->configLangStorageName=$langStorageName;
		$this->labels=array();
		$this->cookies=array();
		$this->styles=array();
		$this->setColors();
		$this->setButtonColors();
		$this->setWidth();
		$this->setAlign();
		$this->defaultTextCs();
		$this->defaultTextEn();
	}

	function setSaveDisableCookie($value=true) { $this->allowSaveDisableCookie=$value; }
	function setColors($bg="lightblue", $font="black", $link="#1976d2") {
		$this->styles['bg']=$bg;
		$this->styles['color']=$font;
		$this->styles['linkColor']=$link;
	}
	function setButtonColors($confirm="primary", $cancel="rgba(0,0,0,.2)", $modify="primary") {
		$this->styles['confirmButton']=$confirm;
		$this->styles['cancelButton']=$cancel;
		$this->styles['modifyButtons']=$modify;
	}
	function setWidth($width=800) { $this->styles['maxWidth']=$width; }
	function setAlign($align="center") { $this->styles['align']=$align; }

	function addNecessaryCookie($item, $controller=false, $expire=false, $domain=false) {
		$this->addCookie("necessary", $item, $controller, $expire, $domain);
	}

	function addPersonalizationCookie($item, $controller=false, $expire=false, $domain=false) {
		$this->addCookie("personalization", $item, $controller, $expire, $domain);
	}

	function addAnalyticsCookie($item, $controller=false, $expire=false, $domain=false) {
		$this->addCookie("analytics", $item, $controller, $expire, $domain);
	}

	function addMarketingCookie($item, $controller=false, $expire=false, $domain=false) {
		$this->addCookie("marketing", $item, $controller, $expire, $domain);
	}

	function addCookie($category, $item, $controller=false, $expire=false, $domain=false) {
		if(!$controller) { $controller=$this->company; }
		$this->cookies[$category][]=new CookieToolbarCookie($item, $controller, $expire, $domain);
		$this->lastCookieType=$category;
	}

	function addDescription($description, $lang="cs") {
		if(!empty($this->lastCookieType)) {
			$count=count($this->cookies[$this->lastCookieType]);
			$this->cookies[$this->lastCookieType][($count-1)]->addDescription($description, $lang);
		}
	}

	function setLabel($item, $text, $lang="cs") {
		$this->labels[$lang][$item]=$text;
	}

	function defaultTextCs() {
		$this->setLabel("toolbarTitle", "Souhlas s pou????v??n??m cookies", "cs");
		$this->setLabel("toolbarText", "Soubory cookies pou????v??me ke zlep??en?? na??ich webov??ch str??nek, mo??nosti personifikace str??nek a hlavn?? abychom v??m poskytli komfort p??i pou????v??n?? t??chto str??nek.", "cs");
		$this->setLabel("advanced", "Podrobn?? nastaven??", "cs");
		$this->setLabel("confirm", "P??ijmout v??e", "cs");
		$this->setLabel("cancel", "Odm??tnout", "cs");
		$this->setLabel("save", "Ulo??it", "cs");
		$this->setLabel("enableAll", "Povolit v??e", "cs");
		$this->setLabel("domain", "Dom??na", "cs");
		$this->setLabel("expire", "Platnost", "cs");
		$this->setLabel("description", "Popis", "cs");
		$this->setLabel("controller", "Zpracovatel", "cs");
		$this->setLabel("1day", "den", "cs");
		$this->setLabel("2days", "dny", "cs");
		$this->setLabel("5days", "dn??", "cs");
		$this->setLabel("1year", "rok", "cs");
		$this->setLabel("2years", "roky", "cs");
		$this->setLabel("5years", "let", "cs");
		$this->setLabel("necessary", "Nezbytn?? cookies", "cs");
			$this->setLabel("necessary_description", "Nezbytn?? cookies jsou d??le??it?? pro zobrazen?? t??to webov?? str??nky. Ukl??d?? se zde i souhlas ohledn?? nastaven?? Cookie.", "cs");
		$this->setLabel("analytics", "Analytick?? cookies", "cs");
			$this->setLabel("analytics_description", "Analytick?? cookies n??m pom??mhaj?? vylep??it na??e webov?? str??nky shroma????ov??n??m a hl????en??m informac?? o tom, jak je pou????v??te. Tento zp??sob p????mo nikoho neidentifikuje.", "cs");
		$this->setLabel("personalization", "Personaliza??n?? cookies", "cs");
			$this->setLabel("personalization_description", "Personaliza??n?? cookies umo????uj?? u??ivatel??m p??izp??sobit si webov?? slu??by na m??ru. ", "cs");
		$this->setLabel("marketing", "Marketingov?? cookies", "cs");
			$this->setLabel("marketing_description", "Marketingov?? cookies jsou pot??ebn?? k vytvo??en?? u??ivatelsk??ch profil?? za ????elem zas??l??n?? reklamy nebo sledov??n?? z??jm?? u??ivatele na webov??ch str??nk??ch pro podobn?? marketingov?? ????ely.", "cs");
	}

	function defaultTextEn() {
		$this->setLabel("toolbarTitle", "Our use of cookies", "en");
		$this->setLabel("toolbarText", "We use the necessary cookies to make our site work. We'd also like to set analytics cookies that help us make improvements by measuring how you use the site. These will be set only if you accept.", "en");
		$this->setLabel("advanced", "Andvanced options", "en");
		$this->setLabel("confirm", "Allow All", "en");
		$this->setLabel("cancel", "Disable All", "en");
		$this->setLabel("save", "Allow", "en");
		$this->setLabel("enableAll", "Allow All", "en");
		$this->setLabel("domain", "Domain", "en");
		$this->setLabel("expire", "Expire", "en");
		$this->setLabel("description", "Description", "en");
		$this->setLabel("controller", "Controller", "en");
		$this->setLabel("1day", "day", "en");
		$this->setLabel("2days", "days", "en");
		$this->setLabel("5days", "days", "en");
		$this->setLabel("1year", "year", "en");
		$this->setLabel("2years", "years", "en");
		$this->setLabel("5years", "years", "en");
		$this->setLabel("necessary", "Necessary Cookies", "en");
			$this->setLabel("necessary_description", "Necessary cookies enable core functionality such as security, network management, and accessibility. You may disable these by changing your browser settings, but this may affect how the website functions.", "en");
		$this->setLabel("analytics", "Analytics Cookies", "en");
			$this->setLabel("analytics_description", "We'd like to set Google Analytics cookies to help us improve our website by collecting and reporting information on how you use it. The cookies collect information in a way that does not directly identify anyone.", "en");
		$this->setLabel("personalization", "Personalization Cookies", "en");
			$this->setLabel("personalization_description", "Personalization cookies allow users to access web services with certain predefined elements, established through a series of criteria on the user???s computer.", "en");
		$this->setLabel("marketing", "Marketing Cookies", "en");
			$this->setLabel("marketing_description", "Marketing cookies required to create user profiles to send advertising, or to track the user on a website or across several websites for similar marketing purposes.", "en");
	}

	function defaultCookie() {
		$this->addNecessaryCookie($this->configCookieName, false, 365);
			$this->addDescription("Ukl??d?? souhlas u??ivatele s pou????v??n??m Cookies", "cs");
			$this->addDescription("Stores the user's consent to the use of cookies", "en");
		$this->addNecessaryCookie("PHPSESID");
					$this->addDescription("Ukl??d?? informace o aktu??ln?? relaci", "cs");
					$this->addDescription("Stores information about the current session", "en");
	}
	function defaultGoogleAnalytics() {
		$this->addAnalyticsCookie("_ga", "Google Inc", 730);
			$this->addDescription("Ukl??d?? unik??tn?? ID, kter?? slou???? pro generov??n?? statistick??ch dat s informacemi o vyu????v??n?? webu ze strany u??ivatele", "cs");
			$this->addDescription("Registers a unique ID that is used to generate statistical data on how the visitor uses the web site", "en");
		$this->addAnalyticsCookie("_gid", "Google Inc", 1);
			$this->addDescription("Ukl??d?? unik??tn?? ID, kter?? slou???? pro generov??n?? statistick??ch dat s informacemi o vyu????v??n?? webu ze strany u??ivatele", "cs");
			$this->addDescription("Registers a unique ID that is used to generate statistical data on how the visitor uses the web site", "en");
		$this->addAnalyticsCookie("_gat", "Google Inc", 1);
			$this->addDescription("Reguluje provoz a p??edch??z?? probl??m??m v Google Analytics", "cs");
			$this->addDescription("Used by Google Analytics to throttle request rate", "en");
	}

	function loadActiveCookies() {
		foreach($_COOKIE as $name=>$cook) {
			if($name=="_ga" || $name=="_ga_" || $name=="_gid") {
				$this->addAnalyticsCookie($name, "Google Inc", 730);
					$this->addDescription("Identifikace u??ivatele pro anal??zu n??v??t??vnosti", "cs");
			} else if($name=="_gat") {
				$this->addAnalyticsCookie($name, "Google Inc", 1);
					$this->addDescription("Slou???? ke sledov??n?? po??tu po??adavk??", "cs");
					$this->addDescription("Used to monitor the number of requests", "en");
			} else if($name=="_fbp") {
				$this->addAnalyticsCookie($name, "Facebook", "4 m??s??ce");
					$this->addDescription("Slou???? k c??len?? reklamn??ch nab??dek", "cs");
					$this->addDescription("Used to target advertising bids", "en");
			}
		}
	}

	function getConfigCookieName() { return $this->configCookieName; }

	function getAsArray() {
		$out=array();
		$out['company']=$this->company;
		$out['defaultLang']=$this->defaultLang;
		$out['allowSaveDisableCookie']=$this->allowSaveDisableCookie;
		$out['refreshAfterSet']=$this->refreshAfterSet;
		$out['configCookieName']=$this->configCookieName;
		$out['configLangStorageName']=$this->configLangStorageName;
		$out['styles']=$this->styles;
		$out['labels']=$this->labels;

		if(count($this->cookies)>0) {
			foreach($this->cookies as $type=>$typesCookies) {
				if(count($typesCookies)>0) {
					foreach($typesCookies as &$cook) {
						$out[$type][]=$cook->getAsArray();
					}
				}
			}
		}
		/*
			$out['agreed']=$this->isAgreed();
			$out['allowedPersonalization']=$this->isAllowedPersonalization();
			$out['allowedAnalytics']=$this->isAllowedAnalytics();
			$out['allowedMarketing']=$this->isAllowedMarketing();
		*/
		return $out;
	}

	function getJson() {
		return json_encode($this->getAsArray());
	}

	function createConfigJsonFile($file="cookieToolbarConfig.json") {
		$myfile = fopen($file, "w") or die("Unable to open file!");
		fwrite($myfile, $this->getJson());
		fclose($myfile);
	}

	function getCookieConfigValue($type) {
		$cookvalue=json_decode($_COOKIE[$this->configCookieName]);
		if(is_array($cookvalue)) { return $cookvalue[0]->$type; }
		return false;
	}

	function isAllowedPersonalization() {
		return $this->getCookieConfigValue('personalization');
	}

	function isAllowedAnalytics() {
		return $this->getCookieConfigValue('analytics');
	}

	function isAllowedMarketing() {
		return $this->getCookieConfigValue('marketing');
	}

	function isAgreed() {
		if(!empty($_COOKIE[$this->configCookieName])) { return true; }
		return false;
	}
}

class CookieToolbarCookie {
	private $item;
	private $description;
	private $controller;
	private $expire;
	private $domain;

	function __construct($item, $controller, $expire=false, $domain=false) {
		if(!$domain) { $domain=$_SERVER['HTTP_HOST']; }
		if($domain=="localhost") { $domain=""; }
		$this->item=$item;
		$this->controller=$controller;
		$this->expire=$expire;
		$this->domain=$domain;
		$this->description=array();
	}

	function addDescription($description, $lang="cs") {
		$this->description[$lang]=$description;
	}

	function getAsArray() {
		$out=array();
		$out['item']=$this->item;
		$out['controller']=$this->controller;
		$out['expire']=$this->expire;
		$out['domain']="$this->domain";
		$out['description']=$this->description;
		return $out;
	}
}
?>
