function verificarTecla(event, n) {
    const teclasValidas = /^[a-zA-Z0-9!@#$%^&*()_+\-=\[\]{};':"\\|,.<>\/?`~áéíóúÁÉÍÓÚãõÃÕâêîôûÂÊÎÔÛçÇ°ºª§¹²³£¢¬]$/;
    const teclasIgnoradas = ['End', 'Home', 'ArrowLeft', 'ArrowRight', 'ArrowUp', 'ArrowDown', 'Shift', 'Control', 'Alt', 'Meta', 'CapsLock', 'Tab', 'Escape'];

    if (teclasValidas.test(event.key) || event.key === 'Backspace' || event.key === 'Delete') {
        if (n && n !== '') {
            limparFichaMon(n);
        } else {
            limparFichaProc();
        }
    } else if (!teclasIgnoradas.includes(event.key)) {
        event.preventDefault();
    }
}

function limparFormulario() {
    limparFichaProc();

    let pv = document.getElementById("formulario-pv-1");
    pv.innerHTML = '';

    let office = document.getElementById("formulario-office-1");
    office.innerHTML = '';

    let so = document.getElementById("formulario-so-1");
    so.innerHTML = '';

    contadorMonitor = 0;
    contadorbMonitor = 0;
    let mon = document.getElementById("monitores-container");
    mon.innerHTML = '';
    document.getElementById('adicionarMonitor').style.display = 'flex';

    contadorDsk = 0;
    contadorbDsk = 0;
    let dsk = document.getElementById("armazenamentos-container");
    dsk.innerHTML = '';
    document.getElementById('adicionarDsk').style.display = 'flex';
}