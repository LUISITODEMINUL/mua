
var ie=(navigator.appName.indexOf('Microsoft')!=-1)?true:false;var ie4=(ie&&document.all&&!document.getElementById)?true:false;var ie5=(ie&&document.getElementById&&navigator.userAgent.indexOf('MSIE 6.0')==-1)?true:false;var ie6=(ie&&document.getElementById&&!ie5)?true:false;var ie4Min=(ie4||ie5||ie6)?true:false;var ie5Min=(ie5||ie6)?true:false;var ie6Min=ie6;var ns=(navigator.appName.indexOf('Netscape')!=-1)?true:false;var ns4=(ns&&document.layers)?true:false;var ns6=(ns&&document.getElementById)?true:false;var ns4Min=(ns4||ns6)?true:false;var ns6Min=ns6;var layerDoc=document;function clipLayer(lyHandler,clipleft,cliptop,clipright,clipbottom){if(lyHandler!=null){if(ns4){lyHandler.clip.left=clipleft;lyHandler.clip.top=cliptop;lyHandler.clip.right=clipright;lyHandler.clip.bottom=clipbottom;}else{lyHandler.clip='rect('+cliptop+' '+clipright+' '+clipbottom+' '+clipleft+')';}}}
function createLayer(ID,left,top,width,height,visibility,content,refdoc){if(refdoc!=null){layerDoc=refdoc;}
if(ns4){layerDoc.writeln('<layer name="'+ID+'" left='+left+' top='+top+' width='+width+' height='+height+' visibility='+(visibility?'"show"':'"hide"')+'>');layerDoc.writeln(content);layerDoc.writeln('</layer>');}else{layerDoc.writeln('<div id="'+ID+'" style="position:absolute; overflow:none; z-index:10; left:'+left+'px; top:'+top+'px; width:'+width+'px; height:'+height+'px;'+' visibility:'+(visibility?'visible;':'hidden;')+'">');layerDoc.writeln(content);layerDoc.writeln('</div>');}
var objLayer=getLayerObj(ID);clipLayer(getLayerHandler(objLayer),0,0,width,height);return objLayer;}
function getLayerObj(ID){var layer=null;if(ns4)
layer=(layerDoc.layers[ID]);else if(ie4){layer=eval('layerDoc.all.'+ID);}else{layer=layerDoc.getElementById(ID);}
return layer;}
function getLayerHandler(layer){return layer!=null&&!ns4?layer.style:layer;}
function displayLayer(lyHandler,visibility){if(isDebug)self.status+=" Handler:"+lyHandler+" visibility:"+visibility;if(lyHandler!=null){lyHandler.visibility=ns4?(visibility?"show":"hide"):(visibility?"visible":"hidden");}}
function moveLayer(lyHandler,x,y){if(lyHandler!=null){if(ns4)
lyHandler.moveTo(x,y);else{lyHandler.left=x+"px";lyHandler.top=y+"px";}}}
function replaceLayerContent(layer,content){if(layer!=null){if(ns4){layer.document.open();layer.document.writeln(content);layer.document.close();}else{layer.innerHTML=content;}}}
function setLayerBgColor(lyHandler,color){if(lyHandler!=null){if(ns4)
lyHandler.bgColor=color;else
lyHandler.backgroundColor=color;}}
var loadLayer=null;var loadHandler=null;var isDebug=false;function createChild(win,ID,content,isOpen,layer_width,layer_height,xPos,yPos){var CHILDCONTENT="<table class='keyboard' cellspacing=0 cellpadding=0 >"
+" <tr><td><table width='100%' cellspacing=0 cellpadding=0 border=0><tr><td onmousedown='startDrag(event);' onmouseup='stopDrag(event);' style='cursor: move;'>&nbsp;</td><td width=13 height=13 align='right'><img src='/mua/images/cls_button.gif' border='0' onclick='closeKeyb();'></td></tr></table></td></tr>"
+" <tr><td>"+content+"</td></tr>"
+"</table>";var xPos=Math.ceil(xPos||getWinWidth(win)/2-(layer_width/2));var yPos=Math.ceil(yPos||getWinHeight(win)/2-(layer_height/2));loadHandler=getLayerHandler(loadLayer=createLayer(ID,xPos,yPos,layer_width,layer_height,isOpen,CHILDCONTENT,win.document));}
function activateChild(flag,ID){if(ID){loadHandler=getLayerHandler(loadLayer=getLayerObj(ID));if(isDebug)self.status+=" Active:"+ID;}
displayLayer(loadHandler,flag);}
var DRAGOBJ=null;var X,Y;function startDrag(e){if(DRAGOBJ==null){DRAGOBJ=loadHandler;var ev=(e||window.event);X=(ev.offsetX||ev.x||ev.layerX);Y=(ev.offsetY||ev.y||ev.layerY);if(isDebug)self.status="START X:"+X+" Y:"+Y;}}
function stopDrag(e){DRAGOBJ=null;}
function dragDrop(e){if(DRAGOBJ!=null){var ev=(e||window.event);var dX=(ev.clientX||ev.pageX)-X,dY=(ev.clientY||ev.pageY)-Y;if(!ns4){dX+=document.body.scrollLeft;dY+=document.body.scrollTop;}
if(dX>0&&dY>0)
moveLayer(DRAGOBJ,dX,dY);if(isDebug)self.status="MOVE X:"+dX+" Y:"+dY;}}
if(ns4){document.captureEvents(Event.MOUSEMOVE);}
document.onmousemove=dragDrop;function validValue(value,defaultValue){return typeof value!='undefined'&&value!=null&&value.length>0?value:defaultValue;}
function getDocHeight(win){if(ie4Min)return(win.document.body.scrollHeight>win.document.body.clientHeight)?win.document.body.scrollHeight:win.document.body.clientHeight;else if(ns4Min)return(win.document.height>win.innerHeight)?win.document.height:win.innerHeight;}
function getDocWidth(win){if(ie4Min)return(win.document.body.scrollWidth>win.document.body.clientWidth)?win.document.body.scrollWidth:win.document.body.clientWidth;else if(ns4Min)return(win.document.width>win.innerWidth)?win.document.width:win.innerWidth;}
function getWinHeight(win){return(ie4Min)?win.document.body.clientHeight:win.innerHeight;}
function getWinWidth(win){return(ie4Min)?win.document.body.clientWidth:win.innerWidth;}