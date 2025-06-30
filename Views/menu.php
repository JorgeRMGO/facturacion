<!-- menu.php -->
<aside id="layout-menu" class="layout-menu menu-vertical menu bg-menu-theme">
  <div class="app-brand demo">
        <a href="inicio.php" class="app-brand-link">
            <center><img src="https://reports.grupo-ortiz.site/Librerias/img/Logo.png" alt="Logo go" width="50" height="50"></center>
            <span class="app-brand-text demo menu-text fw-bold">Facturacion</span>
        </a>
        <a href="javascript:void(0);" class="layout-menu-toggle menu-link text-large ms-auto">
            <i class="ti menu-toggle-icon d-none d-xl-block ti-sm align-middle"></i>
            <i class="ti ti-x d-block d-xl-none ti-sm align-middle"></i>    
        </a>
    </div>
  <div class="menu-inner-shadow"></div>
  <!-- Menu Items -->
  <ul class="menu-inner py-1">
    <!-- Static Button -->
      <li class="menu-item">
      <a href="inicio.php" class="menu-link">
      <i class="menu-icon tf-icons ti ti-smart-home"></i>
      <div data-i18n="Inicio">Inicio</div>
      </a>
    </li>
    <!-- Dropdown Menu -->
    <li class="menu-item">
      <a href="javascript:void(0);" class="menu-link menu-toggle">
        <i class="menu-icon tf-icons ti ti-user"></i>
        <div data-i18n="Usuarios">Usuarios</div>
      </a>
      <ul class="menu-sub">
        <li class="menu-item">
          <a href="../Views/crear_usuario.php" class="menu-link">
            <div data-i18n="Crear Usuario">Crear Usuario</div>
          </a>
        </li>
        <li class="menu-item">
          <a href="layouts-content-navbar.html" class="menu-link">
            <div data-i18n="Roles">Roles</div>
          </a>
        </li>
        <li class="menu-item">
          <a href="layouts-content-navbar.html" class="menu-link">
            <div data-i18n="Permisos">Tipo Usuario</div>
          </a>
        </li>
      </ul>
    </li>
    <!-- Dropdown Menu -->
    <li class="menu-item">
      <a href="javascript:void(0);" class="menu-link menu-toggle">
        <i class="menu-icon tf-icons ti ti-settings"></i>
        <div data-i18n="Administracion">Administracion</div>
      </a>
      <ul class="menu-sub">
        <li class="menu-item">
          <a href="layouts-collapsed-menu.html" class="menu-link">
            <div data-i18n="Menu 1">menu 1</div>
          </a>
        </li>
        <li class="menu-item">
          <a href="layouts-content-navbar.html" class="menu-link">
            <div data-i18n="Menu 2">menu 2</div>
          </a>
        </li>
        <li class="menu-item">
          <a href="layouts-content-navbar.html" class="menu-link">
            <div data-i18n="Menu 3">menu 3</div>
          </a>
        </li>
      </ul>
    </li>
  </ul>
</aside>
