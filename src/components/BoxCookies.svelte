<script lang="ts">
  //author Jan Holomek (e-mail: jahhoo@gmail.com)
  //GitHub: https://github.com/jahhoo/cookieToolbar
  import { Table } from 'sveltestrap';
  import Switch from './SwitchBox.svelte';
  import IoIosArrowDown from 'svelte-icons/io/IoIosArrowDown.svelte';
  import { getTranslate } from "./translate.js";

  export let title="";
  export let category=false;
  export let data;
  export let enabled=false;
  export let disabled=false;
  export let lang="cs";
  export let modifyButtons=false;
  let show=false;

  function showHide() {
    if(show) { show=false; }
    else { show=true; }
  }

  function getExpire(days) {
    if(days==365) { return "1 "+getTranslate("1year", data, lang); }
    else if(days==730) { return "2 "+getTranslate("2years", data, lang); }
    else if(days==1095) { return "3 "+getTranslate("2years", data, lang); }
    else if(days==1460) { return "4 "+getTranslate("2years", data, lang); }
    else if(days==1825) { return "5 "+getTranslate("5years", data, lang); }
    else if(Number.isInteger(days)) {
      if(days==1) { return "1 "+getTranslate("1day", data, lang); }
      if(days<5) { return days+" "+getTranslate("2days", data, lang); }
      else { return days+" "+getTranslate("5days", data, lang); }
    }
    if(lang=="cs" || lang=="cs-CZ") {
      if(days==365) { return "1 rok"; }
      else if(days==730) { return "2 roky"; }
      else if(days==1095) { return "3 roky"; }
      else if(days==1460) { return "4 roky"; }
      else if(days==1825) { return "5 let"; }
      else if(Number.isInteger(days)) {
        if(days==1) { return "1 den"; }
        if(days<5) { return days+" den"; }
        else { return days+" dnů"; }
      }
    } else {
      if(days==365) { return "1 year"; }
      else if(days==730) { return "2 years"; }
      else if(days==1095) { return "3 years"; }
      else if(days==1460) { return "4 years"; }
      else if(days==1825) { return "5 years"; }
      else if(Number.isInteger(days)) {
        if(days==1) { return "1 day"; }
        else { return days+" days"; }
      }
    }
    return days;
  }
</script>

{#await data then data}
  <div class="cookieToolbarToast">
    <div class="cookieToolbarToast-header">
      <div class="cookieToolbarToast-headerTitle" on:click="{()=>showHide()}"><div class="cookieToolbarToastIcon"><IoIosArrowDown /></div> &nbsp;&nbsp;{title}</div>
      {#if !disabled}
        <div class="cookieToolbarSwitch">
          <Switch bind:checked={enabled} bind:color={modifyButtons}></Switch>
        </div>
      {/if}
    </div>
    <div class="cookieToolbarToast-body">
      {#if show}
        <p><slot /></p>
        {#if category}
          <table>
            <thead>
              <tr class="cookieToolbarTableHeader">
                <th>Cookie</th>
                <th>{getTranslate("domain", data, lang)}</th>
                <th>{getTranslate("expire", data, lang)}</th>
                <th>{getTranslate("description", data, lang)}</th>
                <th>{getTranslate("controller", data, lang)}</th>
              </tr>
            </thead>
            <tbody>
              {#each category as row}
                <tr>
                  <td class="bold" data-label="Cookie">{row.item}</td>
                  <td data-label="{getTranslate("domain", data, lang)}">
                    {#if row.domain}
                      {row.domain}
                    {:else}
                      {window.location.hostname}
                    {/if}
                  </td>
                  <td data-label="{getTranslate("expire", data, lang)}">
                    {#if row.expire}
                      {getExpire(row.expire)}
                    {/if}
                  </td>
                  <td data-label="{getTranslate("description", data, lang)}">
                    {#if row.description[lang]}
                      {row.description[lang]}
                    {:else if row.description[data.defaultLang]}
                      {row.description[data.defaultLang]}
                    {/if}
                  </td>
                  <td data-label="{getTranslate("controller", data, lang)}">{row.controller}</td>
                </tr>
              {/each}
            </tbody>
          </table>
        {/if}
      {/if}
    </div>
  </div>
  <br />
{/await}

<style>
.bold { font-weight: bold; }
.cookieToolbarToastIcon { width:22px; float:left; }
.cookieToolbarToast-headerTitle { cursor: pointer; float:left; width:90%; }
.cookieToolbarToast {
  width: auto;
  max-width: 100%;
  font-size: .875rem;
  pointer-events: auto;
  background-color: rgba(255,255,255,.85);
  background-clip: padding-box;
  border: 1px solid rgba(0,0,0,.1);
  box-shadow: 0 .5rem 1rem rgba(0,0,0,.15);
  border-radius: .25rem;
}
.cookieToolbarToast-header {
    display: flex;
    font-weight:bold;
    align-items: center;
    padding: .3rem .75rem;
    color: #6c757d;
    background-color: rgba(255,255,255,.85);
    background-clip: padding-box;
    border-bottom: 1px solid rgba(0,0,0,.05);
    border-top-left-radius: calc(.25rem - 1px);
    border-top-right-radius: calc(.25rem - 1px);
    min-height:56px;
}
.cookieToolbarToast-body { width:94%; margin:auto; }
.cookieToolbarToast-body p { text-align:justify; }
.cookieToolbarSwitch { float:right; margin:auto; }
.cookieToolbarToast-body td, .cookieToolbarToast-body th {  border-bottom: 1px solid rgba(0,0,0,.1); padding: .5rem .5rem; }
.cookieToolbarTableHeader th { border-bottom: 1px solid black; padding: .5rem .5rem; font-weight:bold; }

@media screen and (max-width: 680px) {
  .cookieToolbarToast-body td {
      padding-left: 33%;
      position: relative;
      border: none;
  }
  .cookieToolbarToast-body table, .cookieToolbarToast-body tbody, .cookieToolbarToast-body td, .cookieToolbarToast-body th, .cookieToolbarToast-body tr {
      display: block;
  }
  .cookieToolbarToast-body td:before, .cookieToolbarToast-body th:before {
    content: attr(data-label);
    font-weight:bold;
    position: absolute;
    overflow: hidden;
    left:10px;
    padding-right: 10px;
  }
  .cookieToolbarTableHeader th { display:none; }
  .cookieToolbarToast-body td:last-of-type { border-bottom: 1px solid black; padding-bottom:15px; }
  .cookieToolbarToast-body td:first-of-type { padding-top:15px; }
}
</style>
