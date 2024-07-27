
function isEmpty(value){return/^(\s*)+$/.test(value);}
function checkNumber(num_value){return/^([-+]?\d*[\.|\d])?(\d+)*$/.test(num_value);}
function checkInteger(int_value){return/^([-+]?\d)*(\d+)*$/.test(int_value);}
function checkNatural(nat_value){return!/\D+/.test(nat_value);}
function checkNumberLetter(value){return/^[A-Za-z0-9]+$/.test(value);}
function checkNumberLetterBlank(value){return/^[A-Za-zÃ±Ã‘0-9\s/]+$/.test(value);}
function checkNumberLetterBlankTilde(value){return/^[A-Za-zÃ±Ã‘0-9Ã¡Ã©Ã­Ã³ÃºÃÃ‰ÃÃ“Ãš\s/]+$/.test(value);}
function checkNumberLetterNotBlank(value){return/^[A-Za-zÃ±Ã‘0-9]+$/.test(value);}
function checkOnlyBlanks(value){return/^[\s]+$/.test(value);}
function checkOnlyStar(value){return/^\*+$/.test(value);}
isIE=document.all?true:false;function trim(value){var result;return isEmpty(value)?"":((result=value.match(/\S.+\S/))!=null?result:value.match(/\S+/)).toString();}
function noContieneCadena(value,cadena){re=new RegExp(".*"+cadena+".*")
return!re.test(value);}
function checkSingleWord(code_value){return!/\S.+\s+\S/.test(code_value);}
function checkEmail(email_value){return/^\w+([\.-]?\w+)*@\w+([\.-]?\w+)*(\.\w{2,3})+$/.test(email_value);}
function checkMinNumberAndLetter(value){return(/\d/.test(value)&&/[a-zÃ±]/i.test(value));}
function validate_Number(t1_01_f1_amount)
{return validate_SignedNumber(t1_01_f1_amount,false,"Monto inv?lido.\n");}
function validate_SignedNumber(t1_01_f2_amount,t1_01_f2_signed,t1_01_f2_err_msg)
{return parse_Number(t1_01_f2_amount,t1_01_f2_signed,true,t1_01_f2_err_msg);}
function parse_Number(amount,signed,alert_flag,err_msg,decimalSeparator){var sAmount=""+amount+"";var sAmountTemp="";var negative;var err_counter=0;if((negative=signed&&sAmount.charAt(0)=='-')){sAmount=sAmount.substring(1);}
var decimalPosition;var decimalDigits;var hasDecimalPoint=true;var decimalPoint;var thousandIndicator;if(!decimalSeparator){var decimalPointPosition=sAmount.lastIndexOf('.');var decimalCommaPosition=sAmount.lastIndexOf(',');decimalPosition=(decimalPointPosition>decimalCommaPosition)?decimalPointPosition:decimalCommaPosition;if(decimalPosition<0||(decimalDigits=sAmount.length-decimalPosition-1)>4||decimalDigits==3){hasDecimalPoint=false;}
decimalPoint=(hasDecimalPoint)?sAmount.charAt(decimalPosition):'\n';thousandIndicator=decimalPosition<0?'\n':!hasDecimalPoint?sAmount.charAt(decimalPosition):(decimalPoint=='.'?',':'.');}
else{hasDecimalPoint=(decimalPosition=sAmount.lastIndexOf(decimalSeparator))>=0;decimalPoint=decimalSeparator;thousandIndicator=(decimalPoint=='.'?',':'.');}
var numberParts=sAmount.split(decimalPoint);var thousands=numberParts[0].split(thousandIndicator);if(numberParts.length>2){err_counter=1;}
else if(thousands.length==1){sAmountTemp=thousands[0];}
else{for(var i=0;err_counter==0&&i<thousands.length;i++){if(thousands[i].length>3||(thousands[i].length<3&&i>0)){err_counter=2;}
else{sAmountTemp+=thousands[i];}}}
if(/\D+/.test(sAmountTemp)){err_counter=3;}
else if(numberParts.length==2){if(/\D+/.test(numberParts[1])){err_counter=3;}
else{sAmountTemp+="."+numberParts[1];}}
sAmount=sAmountTemp;if(err_counter>0){if(alert_flag)
alert(err_msg);return 0;}
return parseFloat((negative?'-'+sAmount:sAmount));}
function formatDecimalNumber(sValue,decimals)
{var i;sValue=""+sValue+"";var decPointPos=sValue.indexOf(".");if(decPointPos!=-1)
{i=decPointPos+decimals;tmp_value=(i<sValue.length)?sValue.substring(0,i+1):sValue;sValue=tmp_value.substring(0,i-decimals)+","+tmp_value.substring(i-(decimals-1));}
else{decPointPos=sValue.length;}
i=0;var fValue="";if(decPointPos!=-1){fValue=sValue.substring(decPointPos);}
for(i=decPointPos-3;i>0;i-=3){fValue='.'+sValue.substring(i,i+3)+fValue;}
fValue=sValue.substring(0,i+3)+fValue;return fValue;}
function isOnlyDigits(nat_value){return!/\D+/.test(nat_value);}
function isNumerico(field){if(!isOnlyDigits(field.value)){field.focus();field.select();return false;}
return true;}
function checkNumberKey(numberField,e){checkKey(numberField,e,/\d+/);}
function checkDashedNumberKey(numberField,e){checkKey(numberField,e,/(\d+-*)*/);}
function checkKey(field,e,re){var currentLen=field.value.length;var whichCode=(window.Event)?e.which:e.keyCode;if(currentLen==0||whichCode==8)
return;var tempField="";var matches=field.value.match(re);if(matches)
tempField=matches[0];field.value=tempField;}
function leftZeroTrim(value){var result;value=trim(value);return value!=""&&(result=value.match(/[1-9]\d*/))!=null?result.toString():value;}
function TieneSoloDigitosyPunto(Cadena){var Digitos="0123456789.";var TodosValidos=true;for(i=0;i<Cadena.length;i++){ch=Cadena.charAt(i);for(j=0;j<Digitos.length;j++)
if(ch==Digitos.charAt(j))break;if(j==Digitos.length){TodosValidos=false;break;}}
return TodosValidos;}
function TieneSoloDigitos(Cadena){var Digitos="0123456789";var TodosValidos=true;for(i=0;i<Cadena.length;i++){ch=Cadena.charAt(i);for(j=0;j<Digitos.length;j++)
if(ch==Digitos.charAt(j))break;if(j==Digitos.length){TodosValidos=false;break;}}
return TodosValidos;}
function noTieneSoloDigitos(Cadena){if(Cadena=="")return true;else{var Digitos="0123456789";var TodosValidos=true;for(i=0;i<Cadena.length;i++){ch=Cadena.charAt(i);for(j=0;j<Digitos.length;j++)
if(ch==Digitos.charAt(j))break;if(j==Digitos.length){TodosValidos=false;break;}}
return!TodosValidos;}}
function checkSelect(theField,mens){if(theField.selectedIndex==0){alert("Se debe seleccionar "+mens)
theField.focus()
return false}
else{return true}}
function LeapYear(intYear){if(intYear%100==0){if(intYear%400==0)
return true;}else{if((intYear%4)==0)
return true;}
return false;}
function fechaValida(month,day,year){var err=0;var intday;var intMonth;var intYear
intday=parseInt(day,10);intMonth=parseInt(month,10);intYear=parseInt(year,10);if((intMonth==4||intMonth==6||intMonth==9||intMonth==11)&&(intday==31)){err=7;return false;}
if(intMonth==2){if(LeapYear(intYear)==true){if(intday==30||intday==31){err=9;return false;}}else{if(intday==29||intday==30||intday==31){err=10;return false;}}}
return true;}
function trim(valueToTrim){return valueToTrim.replace(/^\s+|\s+$/g,'');}
function validateConceptData(e){tecla=(document.all)?e.keyCode:e.which;if(tecla==8)return true;if(tecla==0)return true;if(tecla==95)
{if(isIE){window.event.keyCode=0;}
return false;}
patron=/[\w\,\.\ ]/;te=String.fromCharCode(tecla);e.cancelBubble=true;return patron.test(te);}
function validateConceptDataNoSpace(e){tecla=(document.all)?e.keyCode:e.which;if(tecla==8)return true;if(tecla==0)return true;if(tecla==95||tecla==32){if(isIE){window.event.keyCode=0;}
return false;}
patron=/[\w\ ]/;te=String.fromCharCode(tecla);e.cancelBubble=true;return patron.test(te);}
function validateConceptDataNoSpecial(e){tecla=(document.all)?e.keyCode:e.which;if(tecla==8)return true;if(tecla==0)return true;if(tecla==95){if(isIE){window.event.keyCode=0;}
return false;}
patron=/[\w\ ]/;te=String.fromCharCode(tecla);e.cancelBubble=true;return patron.test(te);}