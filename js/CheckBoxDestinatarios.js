function marcarTodos() {
    var checkboxes = document.getElementsByName('clases[]');
    checkboxes.forEach(function(checkbox) {
        checkbox.checked = true;
    });
}

function desmarcarTodos() {
    var checkboxes = document.getElementsByName('clases[]');
    checkboxes.forEach(function(checkbox) {
        checkbox.checked = false;
    });
}

function marcarTodosBaremo() {
    var checkboxes = document.getElementsByName('elementosBaremo[]');
    checkboxes.forEach(function(checkbox) {
        checkbox.checked = true;
    });
    mostrarRequisitos();
}

function desmarcarTodosBaremo() {
    var checkboxes = document.getElementsByName('elementosBaremo[]');
    checkboxes.forEach(function(checkbox) {
        checkbox.checked = false;
    });
    mostrarRequisitos();
}

function mostrarRequisitos() {
    var elementosBaremo = document.getElementsByName('elementosBaremo[]');
    var requisitosCampos = document.getElementsByClassName('requisitos-campos');
    var camposEspeciales = document.getElementsByClassName('campos-especiales');

    for (var i = 0; i < elementosBaremo.length; i++) {
        var elementoId = elementosBaremo[i].value;
        var requisitosCampo = requisitosCampos[i];
        var camposEspecialesCampo = camposEspeciales[i];

        if (elementoId === '1' && elementosBaremo[i].checked) {
            requisitosCampo.style.display = 'block';
            camposEspecialesCampo.style.display = 'table';
        } else {
            requisitosCampo.style.display = elementosBaremo[i].checked ? 'block' : 'none';
            camposEspecialesCampo.style.display = elementoId === '1' && elementosBaremo[i].checked ? 'table' : 'none';
        }
    }
}
function establecerVisibilidadInicial() {
    mostrarRequisitos();
}

window.onload = establecerVisibilidadInicial;

function mostrarNivelesIdioma() {
    var nivelIdiomaCheckbox = document.getElementById('nivelIdioma');
    var nivelesIdiomaCampos = document.getElementsByClassName('niveles-idioma-campos')[0];
    nivelesIdiomaCampos.style.display = nivelIdiomaCheckbox.checked ? 'block' : 'none';
    mostrarRequisitos();
}