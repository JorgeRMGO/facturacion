<nav class="layout-navbar container-xxl navbar navbar-expand-xl navbar-detached align-items-center bg-navbar-theme" id="layout-navbar">
  <div class="layout-menu-toggle navbar-nav align-items-xl-center me-3 me-xl-0 d-xl-none">
    <a class="nav-item nav-link px-0 me-xl-4" href="javascript:void(0)">
      <i class="ti ti-menu-2 ti-sm"></i>
    </a>
  </div>

  <div class="navbar-nav-right d-flex align-items-center" id="navbar-collapse">
    <ul class="navbar-nav flex-row align-items-center ms-auto">

      <!-- Estilos (opcional) -->
      <li class="nav-item dropdown-style-switcher dropdown me-2 me-xl-0">
        <a class="nav-link dropdown-toggle hide-arrow" href="javascript:void(0);" data-bs-toggle="dropdown">
          <i class="ti ti-md"></i>
        </a>
        <ul class="dropdown-menu dropdown-menu-end dropdown-styles">
          <li><a class="dropdown-item" href="javascript:void(0);" data-theme="light"><span class="align-middle"><i class="ti ti-sun me-2"></i>Blanco</span></a></li>
          <li><a class="dropdown-item" href="javascript:void(0);" data-theme="dark"><span class="align-middle"><i class="ti ti-moon me-2"></i>Obscuro</span></a></li>
          <li><a class="dropdown-item" href="javascript:void(0);" data-theme="system"><span class="align-middle"><i class="ti ti-device-desktop me-2"></i>Sistema</span></a></li>
        </ul>
      </li>

      <!-- USUARIO -->
      <li class="nav-item navbar-dropdown dropdown-user dropdown">
        <a class="nav-link dropdown-toggle hide-arrow" href="javascript:void(0);" data-bs-toggle="dropdown">
          <div class="avatar avatar-online">
            <img src="https://cdn-icons-png.flaticon.com/512/9303/9303155.png" alt class="h-auto rounded-circle" />
          </div>
        </a>
        <ul class="dropdown-menu dropdown-menu-end">
          <li>
            <a class="dropdown-item" href="#">
              <div class="d-flex">
                <div class="flex-shrink-0 me-3">
                  <div class="avatar avatar-online">
                    <img src="https://cdn-icons-png.flaticon.com/512/9303/9303155.png" alt class="h-auto rounded-circle" />
                  </div>
                </div>
                <div class="flex-grow-1">
                  <span class="fw-medium d-block">
                    <?php echo $_SESSION['nombre_compleo'] ?? $_SESSION['nombre_usuario'] ?? 'Usuario'; ?>
                  </span>
                  <?php
                  if (isset($_SESSION['rol']) && !empty(trim($_SESSION['rol']))) {
                      $roles = explode(",", $_SESSION['rol']);
                      $primerRol = trim($roles[0]);
                      echo "<small class='text-muted'>" . htmlspecialchars($primerRol) . "</small>";
                  } else {
                      echo "<small class='text-muted'>Sin rol</small>";
                  }
                  ?>
                </div>
              </div>
            </a>
          </li>
          <li><div class="dropdown-divider"></div></li>
          <li>
            <a class="dropdown-item" href="perfil.php">
              <i class="ti ti-user-check me-2 ti-sm"></i>
              <span class="align-middle">Mi perfil</span>
            </a>
          </li>
          <li>
            <a class="dropdown-item" href="pages-account-settings-account.html">
              <i class="ti ti-settings me-2 ti-sm"></i>
              <span class="align-middle">Configuraciones</span>
            </a>
          </li>
          <li><div class="dropdown-divider"></div></li>
          <li>
            <a class="dropdown-item" href="../Controllers/loginController.php?op=salir">
              <i class="ti ti-logout me-2 ti-sm"></i>
              <span class="align-middle">Salir</span>
            </a>
          </li>
        </ul>
      </li>
      <!-- /USUARIO -->

    </ul>
  </div>

  <!-- Buscador en pantallas pequeñas -->
  <div class="navbar-search-wrapper search-input-wrapper d-none">
    <input type="text" class="form-control search-input container-xxl border-0" placeholder="Buscar..." aria-label="Buscar..." />
    <i class="ti ti-x ti-sm search-toggler cursor-pointer"></i>
  </div>
</nav>
