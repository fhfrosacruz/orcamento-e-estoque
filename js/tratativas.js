
function Apenas_Numeros(caracter)
{
  var nTecla = 0;
  if (document.all) {
    nTecla = caracter.keyCode;
  } else {
    nTecla = caracter.which;
  }
  if ((nTecla> 47 && nTecla <58)
  || nTecla == 8 || nTecla == 127
  || nTecla == 0 || nTecla == 9  // 0 == Tab
  || nTecla == 13) { // 13 == Enter
    return true;
  } else {
    return false;
  }
}



 //envento onkeyup
 function maskCPF(CPF) {
  var evt = window.event;
  kcode=evt.keyCode;
  if (kcode == 8) return;
  if (CPF.value.length == 3) { CPF.value = CPF.value + '.'; }
  if (CPF.value.length == 7) { CPF.value = CPF.value + '.'; }
  if (CPF.value.length == 11) { CPF.value = CPF.value + '-'; }
 }

 // evento onBlur
 function formataCPF(CPF)
 {
  with (CPF)
  {
    value = value.substr(0, 3) + '.' +
        value.substr(3, 3) + '.' +
        value.substr(6, 3) + '-' +
        value.substr(9, 2);
  }
 }
 function retiraFormatacao(CPF)
 {
  with (CPF)
  {
    value = value.replace (".","");
    value = value.replace (".","");
    value = value.replace ("-","");
    value = value.replace ("/","");
  }
 }


/* Máscara Telefone  onkeyup="mascara( this, mtel );" */
function mascara(o,f){
    v_obj=o
    v_fun=f
    setTimeout("execmascara()",1)
}
function execmascara(){
    v_obj.value=v_fun(v_obj.value)
}
function mtel(v){
    v=v.replace(/\D/g,"");             //Remove tudo o que não é dígito
    v=v.replace(/^(\d{2})(\d)/g,"($1) $2"); //Coloca parênteses em volta dos dois primeiros dígitos
    v=v.replace(/(\d)(\d{4})$/,"$1-$2");    //Coloca hífen entre o quarto e o quinto dígitos
    return v;
}

String.prototype.reverse = function(){
  return this.split('').reverse().join('');
};

function mascaraMoeda(campo,evento){
  var tecla = (!evento) ? window.event.keyCode : evento.which;
  var valor  =  campo.value.replace(/[^\d]+/gi,'').reverse();
  var resultado  = "";
  var mascara = "##.###.###,##".reverse();
  for (var x=0, y=0; x<mascara.length && y<valor.length;) {
    if (mascara.charAt(x) != '#') {
      resultado += mascara.charAt(x);
      x++;
    } else {
      resultado += valor.charAt(y);
      y++;
      x++;
    }
  }
  campo.value = resultado.reverse();
}
