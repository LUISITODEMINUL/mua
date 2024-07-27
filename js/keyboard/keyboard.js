var omitformtags=["input", "textarea", "select"] 
omitformtags=omitformtags.join("|")
function disableselect(e){
if (omitformtags.indexOf(e.target.tagName.toLowerCase())==-1)
return false}
function reEnable(){
return true}
function blockSelect(element) {
if (typeof element.onselectstart!="undefined")
element.onselectstart=new Function ("event.returnValue=false;  return false; ");
else{
element.onmousedown=disableselect
element.onmouseup=reEnable}}
var isOpen = false;
var isLayer = false;
function getContent() {
var KEYCONTENT = 
" <table class='bg_button' id='_KEYBRD'>"
+"  <tr>"
+"	<td class='bg_button' onclick='displayVal(\"1\");'>1</td>"
+"	<td class='bg_button' onclick='displayVal(\"2\");'>2</td>"
+"	<td class='bg_button' onclick='displayVal(\"3\");'>3</td>"
+"  </tr>"
+"  <tr>"
+"	<td class='bg_button' onclick='displayVal(\"4\");'>4</td>"
+"	<td class='bg_button' onclick='displayVal(\"5\");'>5</td>"
+"	<td class='bg_button' onclick='displayVal(\"6\");'>6</td>"
+"  </tr>"
+"  <tr>"
+"	<td class='bg_button' onclick='displayVal(\"7\");'>7</td>"
+"	<td class='bg_button' onclick='displayVal(\"8\");'>8</td>"
+"	<td class='bg_button' onclick='displayVal(\"9\");'>9</td>"
+"  </tr>"
+"  <tr>"
+"	<td class='bg_button' onclick='displayVal(\"0\");'>0</td>"
+"      <td class='brr_button' colspan=2 onclick='clearKeys();'>&nbsp;</td>"
+"  </tr>"
+" </table>";
return KEYCONTENT;}
var DEF_MAXLENGTH = 4;
var keyboardBind ;
var maxLengthKeyboard = DEF_MAXLENGTH;
var regFunction;
function bindElement(elem) {
keyboardBind = elem;
maxLengthKeyboard = (keyboardBind && keyboardBind.maxLength? keyboardBind.maxLength: DEF_MAXLENGTH);}
function displayVal(keyVal) {
if (keyboardBind.value.length < maxLengthKeyboard) {
keyboardBind.value += keyVal;
if (regFunction) {
regFunction();}}}
function clearKeys() {
keyboardBind.value="";}
function startKeyb(elem, modal) {
if (keyboardBind) {
keyboardBind.disabled = false;}
bindElement(elem);
if (!isOpen && isLayer) {
activateChild(isOpen = true);}
if(modal)  {
keyboardBind.disabled = true;}}
function closeKeyb() {
if (isLayer) activateChild(isOpen = false);
keyboardBind.disabled = false;}
function createKeyboard(openLayer, xPos, yPos) {
if (isLayer = openLayer)
createChild(window, "keyboard", getContent(), isOpen, 330, 135, xPos, yPos); 
else 
document.writeln(getContent());
blockSelect(document.all? document.all['_KEYBRD']: document.getElementById? document.getElementById('_KEYBRD'): document);}
function fChangeStyle(field, others) {
var newClassName = "lockedColorText";
field.className="";
for (var e=0; e < others.length; e++) {
var ele = document.getElementById(others[e]);
if (ele) {
ele.className= newClassName;}}}