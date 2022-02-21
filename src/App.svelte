<script lang="ts">
	//author Jan Holomek (e-mail: jahhoo@gmail.com)
	//GitHub: https://github.com/jahhoo/cookieToolbar
	import { onMount } from 'svelte';
  import { Alert } from 'sveltestrap';
	import { Button } from 'svelte-mui';
	import IoMdSettings from 'svelte-icons/io/IoMdSettings.svelte';
	import Advanced from './components/Advanced.svelte';
	import { getTranslate } from "./components/translate.js";
	import { setCookie, getCookie, cookieSettings, updateCookie } from "./components/cookies.js";

  export let url="/cookieToolbarConfig.json";
	export let lang;
	export let cookieName="CookiesSettings";
	export let data=false;
	export let open=false;
	export let actualSettings=false;
	export let needToUpdateCookie=false;
	let noShow=true;

	let saveDisableCookie=true;
	let refreshAfterSet=false;
	let bgColor="lightblue";
	let textColor="black";
	let linkColor="#1976d2";
	let confirmButton="primary";
	let cancelButton="rgba(0,0,0,.2)";
	let modifyButtons="primary";
	let toolbarWidth="800";
	let butonClass="";
	let toolbarMargin="auto";
	let toolbarLeft=0;

	function noShowDisable() { noShow=false; }

 	onMount(async () => {
		if(document.documentElement.getAttribute('data-cookieToolbar')) { url=document.documentElement.getAttribute('data-cookieToolbar'); }
		setTimeout(noShowDisable, 500);
		const response = await fetch(url);
		data=await response.json();
		if(await data) {
			saveDisableCookie=await data.allowSaveDisableCookie;
			refreshAfterSet=await data.refreshAfterSet;
			if(await data.configCookieName) {
				cookieName=await data.configCookieName;
				actualSettings=JSON.parse(getCookie(cookieName));
			}
			if(await data.styles) {
				if(await data.styles['bg']) { bgColor=await data.styles['bg']; }
				if(await data.styles['color']) { textColor=await data.styles['color']; }
				if(await data.styles['linkColor']) { linkColor=await data.styles['linkColor']; }
				if(await data.styles['confirmButton']) { confirmButton=await data.styles['confirmButton']; }
				if(await data.styles['cancelButton']) { cancelButton=await data.styles['cancelButton']; }
				if(await data.styles['modifyButtons']) { modifyButtons=await data.styles['modifyButtons']; }
				toolbarWidth=await data.styles['maxWidth'];
				if(await data.styles['maxWidth']<500) { butonClass=" float-left"; }
				if(await data.styles['align']=="left") { toolbarMargin="10px"; toolbarLeft=0; }
				else if(await data.styles['align']=="right") { toolbarMargin="10px"; toolbarLeft="auto"; }
				else { toolbarMargin="auto"; toolbarLeft=0; }
			}
		}
		//if(document.documentElement.lang) { lang=document.documentElement.lang; }
		lang=navigator.language || navigator.userLanguage;
		if(await data.configLangStorageName && localStorage.getItem("lang") && localStorage.getItem("lang")!=null && localStorage.getItem("lang")!="null") { lang=localStorage.getItem(await data.configLangStorageName); }
 	});
	$: {
			if(needToUpdateCookie) {
					updateCookie(actualSettings, cookieName);
					needToUpdateCookie=false;
					noShow=true;
			}
	}

	function openDialog() {
		open=true;
		return false;
	}

	function allowAll() {
		cookieSettings(true, true, true, cookieName);
		actualSettings=[
			{ necessary: true, personalization: true, analytics: true, marketing:true }
		];
		noShow=true;
		if(refreshAfterSet) { location.reload(); }
	}
	function disableCookies() {
		if(saveDisableCookie) {
			cookieSettings(false, false, false, cookieName);
		}
		noShow=true;
	}
</script>

{#await data then data}
	{#if data && !open}
		<div style="--bg-color:{bgColor};--text-color:{textColor};--link-color:{linkColor};--cookieToolbarWidth:{toolbarWidth+"px"};--cookieToolbarMargin:{toolbarMargin};--cookieToolbarLeft:{toolbarLeft};">
		{#if getCookie(cookieName) || noShow}
			<div class="cookieBadge" on:click="{()=>(open=true)}"><div class="cookieBadgeIcon"><IoMdSettings /></div> <span>Cookies</span></div>
		{:else if !noShow}
			<div class="cookieToolbar">
			  <Alert>
			    <h4 class="alert-heading">{getTranslate("toolbarTitle", data, lang)}</h4>
			    <p class="cookieToolbarText">{getTranslate("toolbarText", data, lang)}</p>
					<div class="cookieToolbarButtons">
				    <div class="cookieToolbarButton{butonClass}"><Button color="{confirmButton}" raised on:click="{()=>(allowAll())}">{getTranslate("confirm", data, lang)}</Button></div>
						<div class="cookieToolbarButton{butonClass}"><Button color="{cancelButton}" raised on:click="{()=>(disableCookies())}">{getTranslate("cancel", data, lang)}</Button></div>
				  </div>
					<div class="cookieToolbarText cookieToolbarAdvanced">
						<span class="href" on:click="{()=>(openDialog())}">{getTranslate("advanced", data, lang)}</span>
					</div>
			  </Alert>
			</div>
		{/if}
		</div>
	{/if}
{/await}
<Advanced bind:data bind:lang bind:open bind:actualSettings bind:needToUpdateCookie bind:modifyButtons />

<style>
.alert-heading { font-size: 1.5rem; margin:5px 0 0px 0; }
.cookieBadge {
	background: var(--bg-color);
	color: var(--text-color);
	font-size:12px;
	padding:3px;
	position:fixed;
	left:0px;
	bottom:0px;
	border: 1px solid transparent;
	border-radius: 0 .25rem 0 0;
	cursor:pointer;
	box-shadow: 0 .5rem 1rem rgba(0,0,0,.15);
}
.cookieBadge span { position:relative; top:2px; }
.cookieBadgeIcon { float:left; max-width:20px; padding:2px 3px 0 2px; position: relative; top:2px; }
.cookieToolbar {
	background: var(--bg-color);
	color: var(--text-color);
	min-width:300px;
	max-width:var(--cookieToolbarWidth);
	width:90%;
	position:fixed;
	bottom:10px;
	margin-left: var(--cookieToolbarMargin);
	margin-right: var(--cookieToolbarMargin);
	left: var(--cookieToolbarLeft);
	right: 0;
  padding: 1rem 1rem;
  border: 1px solid transparent;
  border-radius: .25rem;
	z-index:999999999;
	box-shadow: 0 .5rem 1rem rgba(0,0,0,.15);
}
.cookieToolbarText { float:left; width:80%; max-width:600px; }
.cookieToolbarButtons { float:right; text-align:center; margin:auto auto 10px auto; }
.cookieToolbarButton { margin:10px auto 0px 10px; }
.cookieToolbarAdvanced { float:left; text-align:center; }
.href { text-decoration:underline; color:var(--linkColor); cursor: pointer; }
.href:hover { text-decoration:none; }
.float-left { float:left; }
</style>
