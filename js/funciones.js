
function validaFormulario()
{
    name = document.getElementById('name').value;
    dni = document.getElementById('dni').value;
    pass = document.getElementById('password').value;
    apellidos = document.getElementById('apellidos').value;
    correo = document.getElementById('correo').value;
    github = document.getElementById('github').value;

    if (name === null || name === "" || dni === null || dni === "" 
    || pass === null || pass === "" || apellidos === null || apellidos === "" || correo === null || correo === "" 
    || github === null || github === "") {
        alert("Todos los campos son obligatorios");
    return false;
}
    return true;
}


window.onload = function () 
{
    var table = document.getElementsByName('notas');
    for (var nTable=0;nTable<table.length;nTable++) {
        var tbody = table[nTable].getElementsByTagName('tbody')[0];
        var cells = tbody.getElementsByTagName('td');

        for (var i=0, len=cells.length; i<len; i++){
            if (parseInt(cells[i].innerHTML,10) < 2){
                cells[i].style.backgroundColor = 'red';
            }
            else if (parseInt(cells[i].innerHTML,10) === 3){
                cells[i].style.backgroundColor = 'green';
            }
        }
        var cells = tbody.getElementsByClassName('notaT');
        for (var i=0, len=cells.length; i<len; i++){
            if (parseInt(cells[i].innerHTML,10) <= 19){
                cells[i].style.backgroundColor = 'red';
            }
            else if (parseInt(cells[i].innerHTML,10) > 19){
                cells[i].style.backgroundColor = 'green';
            }
        }
    }
    
    
    
}

          