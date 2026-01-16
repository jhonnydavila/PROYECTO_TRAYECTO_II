const btnToggle = document.getElementById('btn-toggle');
const body = document.body;

btnToggle.addEventListener('click', () => {
    body.classList.toggle('collapsed');
    
    // Opcional: Guardar el estado en localStorage para que se mantenga al recargar
    const isCollapsed = body.classList.contains('collapsed');
    localStorage.setItem('sidebarStatus', isCollapsed ? 'collapsed' : 'expanded');
});

// Cargar estado guardado al iniciar
if (localStorage.getItem('sidebarStatus') === 'collapsed') {
    body.classList.add('collapsed');
}



// Función para abrir la modal
function abrir_modal(id) {
    const modalElement = document.getElementById(id);
    
    modalElement.classList.add('show');
    modalElement.style.display = 'block';
    
    document.body.classList.add('modal-open');
    let backdrop = document.createElement('div');
    backdrop.className = 'modal-backdrop fade show';
    backdrop.id = 'custom-modal-backdrop';
    document.body.appendChild(backdrop);
}
// Función para cerrar la modal 
function cerrar_modal(id) {
    const modalElement = document.getElementById(id);
    modalElement.classList.remove('show');
    modalElement.style.display = 'none';
    
    document.body.classList.remove('modal-open');
    const backdrop = document.getElementById('custom-modal-backdrop');
    if (backdrop) backdrop.remove();
}
