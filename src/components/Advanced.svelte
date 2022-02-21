<script lang="ts">
	//author Jan Holomek (e-mail: jahhoo@gmail.com)
	//GitHub: https://github.com/jahhoo/cookieToolbar
	import { Dialog, Button } from 'svelte-mui';
	import IoIosClose from 'svelte-icons/io/IoIosClose.svelte'
	import BoxCookies from './BoxCookies.svelte';
	import { getTranslate } from "./translate.js";

  export let data;
	export let lang="cs";
	export let actualSettings=true;
  export let open;
	let firstOpen=true;
	export let needToUpdateCookie=false;
	export let values=[];
	export let modifyButtons="primary";
	values['personalization']=false;
	values['analytics']=false;
	values['marketing']=false;

	function saveCookies(all=true) {
		if(all) {
			actualSettings=[
		    { necessary: true, personalization: true, analytics: true, marketing:true }
		  ];
		} else {
			actualSettings=[
		    { necessary: true, personalization: values['personalization'], analytics: values['analytics'], marketing:values['marketing'] }
		  ];
		}
		open=false;
		firstOpen=true;
		needToUpdateCookie=true;
	}

	$:{
		if(open && firstOpen) {
			firstOpen=false;
			if(!actualSettings) {
				actualSettings=[
			    { necessary: true, personalization: false, analytics: false, marketing:false }
			  ];
			}
			values['personalization']=actualSettings[0].personalization;
			values['analytics']=actualSettings[0].analytics;
			values['marketing']=actualSettings[0].marketing;
		}
	}
</script>

{#await data then data}
	{#if data}
	<Dialog width="780" bind:visible={open}>
		<div slot="title">
			{getTranslate("toolbarTitle", data, lang)}
			<div class="cookieToolbarClose" on:click={()=>(open=false)}><IoIosClose /></div>
		</div>
		<p>{getTranslate("toolbarText", data, lang)}</p>
		<br />
		<div class="cookieToolbarBox">
			<BoxCookies title="{getTranslate("necessary", data, lang)}" category={data.necessary} {data} {lang} {modifyButtons} disabled>{getTranslate("necessary_description", data, lang)}</BoxCookies>
			{#if data.personalization}
				<BoxCookies title="{getTranslate("personalization", data, lang)}" bind:enabled={values['personalization']} category={data.personalization} {data} {lang} {modifyButtons}>{getTranslate("personalization_description", data, lang)}</BoxCookies>
			{/if}
			{#if data.analytics}
				<BoxCookies title="{getTranslate("analytics", data, lang)}" bind:enabled={values['analytics']} category={data.analytics} {data} {lang} {modifyButtons}>{getTranslate("analytics_description", data, lang)}</BoxCookies>
			{/if}
			{#if data.marketing}
				<BoxCookies title="{getTranslate("marketing", data, lang)}" bind:enabled={values['marketing']} category={data.marketing} {data} {lang} {modifyButtons}>{getTranslate("marketing_description", data, lang)}</BoxCookies>
			{/if}
			<br />
			<div class="floatRight"><small><a href="https://jahnet.eu/cookieToolbar" target="_blank">CookieToolbar</a></small></div><br />
		</div>
		<div slot="footer" class="cookieToolbarActions">
			<Button color="{modifyButtons}" raised on:click={()=>(saveCookies(true))}>{getTranslate("enableAll", data, lang)}</Button>&nbsp;
			<div class="floatRight"><Button color="{modifyButtons}" raised on:click={()=>(saveCookies(false))}>{getTranslate("save", data, lang)}</Button></div>
		</div>
	</Dialog>
	{/if}
{/await}

<style>
.floatRight { float:right; }
.cookieToolbarClose { float:right; width:40px; cursor:pointer; }
.cookieToolbarBox { margin:auto; width:650px; max-width:95%; }
.cookieToolbarActions { border-top:1px solid silver; margin-right:10px; min-height: 48px; padding: 8px; }
</style>
