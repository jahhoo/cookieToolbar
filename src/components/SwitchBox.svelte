<script>
  export let checked = false;
  export let color = "#2196F3";
  $: {
    if(color=="primary") { color = "#2196F3"; }
  }
</script>

<label class="cookieToolbarSwitch" style="--switchColor:{color};">
  <input type="checkbox" class="cookieToolbarCheckboxSlider" bind:checked />
  <span class="cookieToolbarSlider" />
</label>

<style>
  .cookieToolbarSwitch {
    position: relative;
    display: inline-block;
    width: 60px;
    height: 34px;
    transform: scale(0.7);
  }
  .cookieToolbarSwitch input {
    opacity: 0;
    width: 0;
    height: 0;
  }
  .cookieToolbarSlider {
    position: absolute;
    cursor: pointer;
    top: 0;
    left: 0;
    right: 0;
    bottom: 0;
    background-color: #ccc;
    -webkit-transition: 0.4s;
    transition: 0.4s;
    border-radius: 34px;
  }
  .cookieToolbarSlider:before {
    position: absolute;
    content: "";
    height: 26px;
    width: 26px;
    left: 4px;
    bottom: 4px;
    background-color: white;
    -webkit-transition: 0.4s;
    transition: 0.4s;
    border-radius: 50%;
  }
  .cookieToolbarCheckboxSlider:checked + .cookieToolbarSlider {
    background-color: var(--switchColor, #2196F3);
  }
  .cookieToolbarCheckboxSlider:checked + .cookieToolbarSlider {
    box-shadow: 0 0 1px var(--switchColor, #2196F3);
  }
  .cookieToolbarCheckboxSlider:checked + .cookieToolbarSlider:before {
    -webkit-transform: translateX(26px);
    -ms-transform: translateX(26px);
    transform: translateX(26px);
  }
</style>
