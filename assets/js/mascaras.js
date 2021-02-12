/*-------------------------------------------------------------------------------*/
/**
* FunÃ§Ã£o para aplicar mÃ¡scara em campos de texto
* Copyright (c) 2008, Dirceu Bimonti Ivo - http://www.bimonti.net
* All rights reserved.
* @constructor
*/
/* Version 0.27 */
/**
* FunÃ§Ã£o Principal
* @param w - O elemento que serÃ¡ aplicado (normalmente this).
* @param e - O evento para capturar a tecla e cancelar o backspace.
* @param m - A mÃ¡scara a ser aplicada.
* @param r - Se a mÃ¡scara deve ser aplicada da direita para a esquerda. Veja Exemplos.
* @param a -
* @returns null
*/
function maskIt(w,e,m,r,a){
// Cancela se o evento for Backspace
if (!e) var e = window.event
if (e.keyCode) code = e.keyCode;
else if (e.which) code = e.which;
// VariÃ¡veis da funÃ§Ã£o
var txt = (!r) ? w.value.replace(/[^\d]+/gi,'') : w.value.replace(/[^\d]+/gi,'').reverse();
var mask = (!r) ? m : m.reverse();
var pre = (a ) ? a.pre : "";
var pos = (a ) ? a.pos : "";
var ret = "";
if(code == 9 || code == 8 || txt.length == mask.replace(/[^#]+/g,'').length) return false;
// Loop na mÃ¡scara para aplicar os caracteres
for(var x=0,y=0, z=mask.length;x<z && y<txt.length;){
if(mask.charAt(x)!='#'){
ret += mask.charAt(x); x++;
} else{
ret += txt.charAt(y); y++; x++;
}
}
// Retorno da funÃ§Ã£o
ret = (!r) ? ret : ret.reverse()
w.value = pre+ret+pos;
}
// Novo mÃ©todo para o objeto 'String'
String.prototype.reverse = function(){
return this.split('').reverse().join('');
};
/*-------------------------------------------------------------------------------*/