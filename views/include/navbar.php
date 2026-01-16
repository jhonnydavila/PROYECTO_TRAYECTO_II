
<div class="navbar__sidebar" id="sidebar">
    <nav class="bg-dark p-0 w-100 d-flex justify-content-center px-2">
        <div class="navbar__sidebar-link-menu-btn">
            <img class="navbar__sidebar-icon" id="btn-toggle" src="<?php echo APP_URL ?>assets/svg/navbar__menu.svg">
            <h6 class="text-uppercase m-0 sidebar-text">Menú Principal</h6>
        </div>
    </nav>
    <nav class="navbar__sidebar-links">
        <a href="<?php echo APP_URL ?>home/" class="navbar__sidebar-link">
            <svg class="navbar__sidebar-icon" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                <g id="SVGRepo_iconCarrier"> 
                    <path d="M22 22L2 22" stroke="currentColor" stroke-width="1.5" stroke-linecap="round"></path> 
                    <path d="M2 11L10.1259 4.49931C11.2216 3.62279 12.7784 3.62279 13.8741 4.49931L22 11" stroke="currentColor" stroke-width="1.5" stroke-linecap="round"></path> 
                    <path d="M15.5 5.5V3.5C15.5 3.22386 15.7239 3 16 3H18.5C18.7761 3 19 3.22386 19 3.5V8.5" stroke="currentColor" stroke-width="1.5" stroke-linecap="round"></path> 
                    <path d="M4 22V9.5" stroke="currentColor" stroke-width="1.5" stroke-linecap="round"></path> 
                    <path d="M20 22V9.5" stroke="currentColor" stroke-width="1.5" stroke-linecap="round"></path> 
                    <path d="M15 22V17C15 15.5858 15 14.8787 14.5607 14.4393C14.1213 14 13.4142 14 12 14C10.5858 14 9.87868 14 9.43934 14.4393C9 14.8787 9 15.5858 9 17V22" stroke="currentColor" stroke-width="1.5"></path> 
                    <path d="M14 9.5C14 10.6046 13.1046 11.5 12 11.5C10.8954 11.5 10 10.6046 10 9.5C10 8.39543 10.8954 7.5 12 7.5C13.1046 7.5 14 8.39543 14 9.5Z" stroke="currentColor" stroke-width="1.5"></path> 
                </g>
            </svg>
            <span class="sidebar-text">Dashboard</span>
        </a>

        <a href="<?php echo APP_URL ?>usuarios/" class="navbar__sidebar-link">
            <svg class="navbar__sidebar-icon" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                <g id="SVGRepo_iconCarrier">
                    <circle cx="12" cy="6" r="4" fill="currentColor"></circle>
                    <path d="M20 17.5C20 19.9853 20 22 12 22C4 22 4 19.9853 4 17.5C4 15.0147 7.58172 13 12 13C16.4183 13 20 15.0147 20 17.5Z" fill="currentColor"></path>
                </g>
            </svg>
            <span class="sidebar-text">Usuarios</span>
        </a>

        <a href="#" class="navbar__sidebar-link">
            <svg class="navbar__sidebar-icon" style="padding: 2px;" fill="currentColor" version="1.1" id="Capa_1" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 340.274 340.274" xml:space="preserve">
                <g id="SVGRepo_iconCarrier"> 
                    <path d="M293.629,127.806l-5.795-13.739c19.846-44.856,18.53-46.189,14.676-50.08l-25.353-24.77l-2.516-2.12h-2.937 c-1.549,0-6.173,0-44.712,17.48l-14.184-5.719c-18.332-45.444-20.212-45.444-25.58-45.444h-35.765 c-5.362,0-7.446-0.006-24.448,45.606l-14.123,5.734C86.848,43.757,71.574,38.19,67.452,38.19l-3.381,0.105L36.801,65.032 c-4.138,3.891-5.582,5.263,15.402,49.425l-5.774,13.691C0,146.097,0,147.838,0,153.33v35.068c0,5.501,0,7.44,46.585,24.127 l5.773,13.667c-19.843,44.832-18.51,46.178-14.655,50.032l25.353,24.8l2.522,2.168h2.951c1.525,0,6.092,0,44.685-17.516 l14.159,5.758c18.335,45.438,20.218,45.427,25.598,45.427h35.771c5.47,0,7.41,0,24.463-45.589l14.195-5.74 c26.014,11,41.253,16.585,45.349,16.585l3.404-0.096l27.479-26.901c3.909-3.945,5.278-5.309-15.589-49.288l5.734-13.702 c46.496-17.967,46.496-19.853,46.496-25.221v-35.029C340.268,146.361,340.268,144.434,293.629,127.806z M170.128,228.474 c-32.798,0-59.504-26.187-59.504-58.364c0-32.153,26.707-58.315,59.504-58.315c32.78,0,59.43,26.168,59.43,58.315 C229.552,202.287,202.902,228.474,170.128,228.474z"></path> 
                </g>
            </svg>
            <span class="sidebar-text">Configuración</span>
        </a>
    </nav>
</div>

<header class="navbar__topbar">
    <h5 class="m-0">Sistema Web</h5>
    <div class="d-flex align-items-center gap-3">
        <a href="#" class="navbar__topbar-btn btn btn-outline-danger btn-sm">
            Salir
            <svg class="navbar__topbar-icon" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                <g id="SVGRepo_bgCarrier" stroke-width="0"></g>
                <g id="SVGRepo_tracerCarrier" stroke-linecap="round" stroke-linejoin="round"></g>
                <g id="SVGRepo_iconCarrier"> 
                    <path d="M14 7.63636L14 4.5C14 4.22386 13.7761 4 13.5 4L4.5 4C4.22386 4 4 4.22386 4 4.5L4 19.5C4 19.7761 4.22386 20 4.5 20L13.5 20C13.7761 20 14 19.7761 14 19.5L14 16.3636" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"></path> 
                    <path d="M10 12L21 12M21 12L18.0004 8.5M21 12L18 15.5" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"></path> 
                </g>
            </svg>
        </a>
        
    </div>
</header>

