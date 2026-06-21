var themes=[
{id:'forest',label:'Forest',dot:'#1B4332'},
{id:'ocean',label:'Ocean',dot:'#1A3A5C'},
{id:'sunset',label:'Sunset',dot:'#8B3A3A'},
{id:'midnight',label:'Midnight',dot:'#4A4A6A'},
{id:'earth',label:'Earth',dot:'#5C4033'}
];

function getCurrentTheme(){
var t=localStorage.getItem('theme')||'forest-light';
if(!t.includes('-'))t='forest-'+t;
return t;
}

function getMode(t){return t.endsWith('-dark')?'dark':'light'}
function getBase(t){return t.replace('-light','').replace('-dark','')}

function getModeIcon(mode){return mode==='dark'?'<i class="fa-solid fa-moon"></i>':'<i class="fa-solid fa-sun"></i>'}

function applyTheme(theme){
document.documentElement.setAttribute('data-theme',theme);
localStorage.setItem('theme',theme);
var btn=document.getElementById('themePickerBtn');
if(btn){
var mode=getMode(theme);
btn.innerHTML=mode==='dark'?'<i class="fa-solid fa-moon"></i>':'<i class="fa-solid fa-sun"></i>';
}
var drop=document.getElementById('themePickerDropdown');
if(drop)renderThemePicker(drop);
}

function renderThemePicker(container){
var cur=getCurrentTheme();
var curBase=getBase(cur);
var curMode=getMode(cur);
var html='';
for(var i=0;i<themes.length;i++){
var t=themes[i];
var isActive=t.id===curBase;
var modeColor=t.id===curBase?curMode:'light';
html+='<button class="theme-picker-item'+(isActive?' active':'')+'" data-theme-base="'+t.id+'">';
html+='<span class="theme-picker-swatch">';
html+='<span class="theme-color-dot" style="background:'+t.dot+'"></span>';
html+='<span>'+t.label+'</span>';
html+='</span>';
html+='<span class="theme-mode-btn" data-theme-base="'+t.id+'" data-mode="'+(t.id===curBase&&curMode==='dark'?'light':'dark')+'">';
html+=(t.id===curBase&&curMode==='dark')?getModeIcon('light'):getModeIcon('dark');
html+='</span>';
html+='</button>';
}
container.innerHTML=html;

// Theme select
container.querySelectorAll('.theme-picker-item').forEach(function(el){
el.addEventListener('click',function(e){
var base=this.dataset.themeBase;
var mode=getMode(getCurrentTheme());
if(base===getBase(getCurrentTheme())){
mode=mode==='light'?'dark':'light';
}
applyTheme(base+'-'+mode);
});
});

// Mode toggle
container.querySelectorAll('.theme-mode-btn').forEach(function(el){
el.addEventListener('click',function(e){
e.stopPropagation();
var base=this.dataset.themeBase;
var mode=this.dataset.mode;
applyTheme(base+'-'+mode);
});
});
}

function initThemePicker(){
applyTheme(getCurrentTheme());
var btn=document.getElementById('themePickerBtn');
var drop=document.getElementById('themePickerDropdown');
if(btn&&drop){
btn.addEventListener('click',function(e){
e.stopPropagation();
drop.classList.toggle('show');
renderThemePicker(drop);
});
document.addEventListener('click',function(e){
if(!e.target.closest('.theme-picker-wrap')&&!e.target.closest('#themePickerDropdown')&&!e.target.closest('#themePickerBtn')){
if(drop)drop.classList.remove('show');
}
});
}
}

document.addEventListener('DOMContentLoaded',initThemePicker);
