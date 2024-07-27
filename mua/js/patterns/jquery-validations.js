
$(document).ready(function(){$.validator.addMethod("validAlfaNumericoSec",function(value,element,param){if(checkNumberLetterBlank(element.value)){return true;}
else{return false;}});$.validator.addMethod("validAlfaNumericoTil",function(value,element,param){if(checkNumberLetterBlankTilde(element.value)){return true;}
else{return false;}});$.validator.addMethod("validAlfaNumericoSecNotBlank",function(value,element,param){if(checkNumberLetterNotBlank(element.value)){return true;}
else{return false;}});$.validator.addMethod("longMin4",function(value,element,param){return(element.value.length>=4);});$.validator.addMethod("equal",function(value,element,param){if(element.value==param[0].value){return true;}
else{return false;}});$.validator.addMethod("checked",function(value,element,param){if(element.checked){return true;}
else{return false;}});$.validator.addMethod("email",function(value,element,param){if(checkEmail(element.value)){return true;}
else{return false;}});$.validator.addMethod("number",function(value,element,param){if(checkNumber(element.value)){return true;}
else{return false;}});});