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