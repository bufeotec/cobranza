<body>
<!-- Modal Restablecer Contraseña-->
<div class="modal fade" id="ContrasenhaUsuario" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Cambiar Contraseña</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="container-fluid">
                    <div class="row">
                        <div class="col-lg-6">
                            <div class="form-group">
                                <label class="col-form-label">Nueva Contraseña</label>
                                <input class="form-control" type="password" id="contra1p" maxlength="16" placeholder="Ingrese Información...">
                            </div>
                        </div>
                        <div class="col-lg-6">
                            <div class="form-group">
                                <label class="col-form-label">Repetir Contraseña</label>
                                <input class="form-control" type="password" id="contra2p"  maxlength="16" placeholder="Ingrese Información...">
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal"><i class="fa fa-close fa-sm text-white-50"></i> Cerrar</button>
                <button type="button" class="btn btn-success" id="btn-nueva_contra" onclick="guardar_contrasenha()"><i class="fa fa-save fa-sm text-white-50"></i> Guardar</button>
            </div>
        </div>
    </div>
</div>
<!-- Modal Editar Usuario-->
<div class="modal fade" id="DatosUsuario" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel1">Editar Usuario Personal</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form enctype="multipart/form-data" method="post" id="editarDatosDelUsuario">
                <div class="modal-body">
                    <div class="container-fluid">
                        <div id="usuario">
                            <div class="row">
                                <div class="col-lg-12">
                                    <div class="form-group">
                                        <label class="col-form-label">Usuario</label>
                                        <input class="form-control" type="text" id="usuario_nicknamep" name="usuario_nicknamep" value="<?= $this->encriptar->desencriptar($_SESSION['_n'],_FULL_KEY_)?>" maxlength="16" placeholder="Ingrese Información...">
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-lg-12">
                                    <div class="form-group">
                                        <label class="col-form-label">Email</label>
                                        <input class="form-control" type="text" id="usuario_emailp" name="usuario_emailp" value="<?= $this->encriptar->desencriptar($_SESSION['u_e'],_FULL_KEY_)?>" maxlength="40" placeholder="Ingrese Información...">
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-lg-12">
                                    <div class="form-group">
                                        <label class="col-form-label">Foto de Perfil</label>
                                        <input class="form-control" type="file" id="usuario_imagenp" name="usuario_imagenp" placeholder="Ingrese Información...">
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal"><i class="fa fa-close fa-sm text-white-50"></i> Cerrar</button>
                    <button type="submit" class="btn btn-success" id="btn-editar-usuario-datos"><i class="fa fa-save fa-sm text-white-50"></i> Guardar</button>
                </div>
            </form>
        </div>
    </div>
</div>
<!-- Modal Editar Persona-->
<div class="modal fade" id="editarPersonaDatos" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Editar Datos Personales</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form enctype="multipart/form-data" method="post" id="gestionarInfoDatosPersona">
                <div class="modal-body">
                    <div class="container-fluid">
                        <div id="persona">
                            <div class="row">
                                <div class="col-lg-12">
                                    <div class="form-group">
                                        <label class="col-form-label">Nombre Persona</label>
                                        <input class="form-control" type="text" id="persona_nombrep" name="persona_nombrep" value="<?= $this->encriptar->desencriptar($_SESSION['p_n'],_FULL_KEY_)?>" maxlength="20" placeholder="Ingrese Información...">
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-lg-6">
                                    <div class="form-group">
                                        <label class="col-form-label">Apellido Paterno</label>
                                        <input class="form-control" type="text" id="persona_apellido_paternop" name="persona_apellido_paternop" value="<?= $this->encriptar->desencriptar($_SESSION['p_p'],_FULL_KEY_)?>" maxlength="30" placeholder="Ingrese Información...">
                                    </div>
                                </div>
                                <div class="col-lg-6">
                                    <div class="form-group">
                                        <label class="col-form-label">Apellido Materno</label>
                                        <input class="form-control" type="text" id="persona_apellido_maternop" name="persona_apellido_maternop" value="<?= $this->encriptar->desencriptar($_SESSION['p_m'],_FULL_KEY_)?>" maxlength="30" placeholder="Ingrese Información...">
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-lg-6">
                                    <div class="form-group">
                                        <label class="col-form-label">Fecha de Nacimiento</label>
                                        <input class="form-control" type="date" id="persona_nacimientop" name="persona_nacimientop" value="<?= $this->encriptar->desencriptar($_SESSION['p_nc'],_FULL_KEY_)?>" maxlength="30" placeholder="Ingrese Información...">
                                    </div>
                                </div>
                                <div class="col-lg-6">
                                    <div class="form-group">
                                        <label class="col-form-label">Número de Teléfono</label>
                                        <input class="form-control" type="text" id="persona_telefonop" value="<?= $this->encriptar->desencriptar($_SESSION['p_t'],_FULL_KEY_)?>" onkeyup="return validar_numeros(this.id)" name="persona_telefonop" maxlength="30" placeholder="Ingrese Información...">
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal"><i class="fa fa-close fa-sm text-white-50"></i> Cerrar</button>
                    <button type="submit" class="btn btn-success" id="btn-editar-persona-datos"><i class="fa fa-save fa-sm text-white-50"></i> Guardar</button>
                </div>
            </form>
        </div>
    </div>
</div>
<!-- Page Wrapper -->
<div id="app">
    <div id="sidebar" class="active">
        <div class="sidebar-wrapper active">
<!--            El logo que te lleva al inicio-->
            <div class="sidebar-header">
                <div class="d-flex justify-content-between">
                    <div class="logo" style="width: 80%;height: 60px">
                        <a href="<?= _SERVER_;?>"><img src="<?= _SERVER_ ._STYLES_ALL_?>logotextBu.png" alt="Logo" srcset="" style="width: 72%;height: 100%"></a>
                    </div>
                    <div class="toggler">
                        <a href="#" class="sidebar-hide d-xl-none d-block"><i class="bi bi-x bi-middle"></i></a>
                    </div>
                </div>
            </div>
            <div class="sidebar-menu">
                <ul class="menu">
                     <li class="sidebar-item navbar-light"><a href="<?= _SERVER_;?>" class='sidebar-link'><i class="fa fa-home"></i><span>Inicio</span></a></li>
					<?php
					$raioz2 = 1;
					foreach($grupos as $gru){
					$nav_link2 = "nav-link collapsed";
					$aria_expanded2 = "false";
					$collapse2 = "collapse";
					?>
                    <li class="sidebar-item  has-sub navbar-light">
                        <a href="<?= $nav_link2;?>" class='sidebar-link'>
                            <i class="<?= $gru->grupo_icono;?>"></i>
                            <span><?= $gru->grupo_nombre;?></span>
                        </a>
                        <ul class="submenu">
                            <li class="submenu-item ">
								<?php
								//Variable usada como correlativo
								$raioz = 1;
								//Listamos las restricciones de opciones para el rol del usuario
								$restricciones = $this->nav->listar_restricciones($this->encriptar->desencriptar($_SESSION['ru'],_FULL_KEY_));
								$navs = $this->nav->listar_menus_grupo($this->encriptar->desencriptar($_SESSION['ru'],_FULL_KEY_),$gru->id_grupo);
								//									if (count($navs) > 0) {
								//										echo '<script type="text/javascript">document.getElementById("mostrar_dep_' . $id_mo . '").style.display = "block";</script>';
								//									}
								foreach ($navs as $nav){
								//Clases necesarias para mostrar en el navbar
								$nav_link = "nav-link collapsed";
								$aria_expanded = "false";
								$collapse = "collapse";
								//Validamos si es controlador en el que estamos ingresando
								if($nav->menu_controlador == $_SESSION['controlador']){
									$nav_link = "nav-link";
									$_SESSION['controlador'] = $nav->menu_nombre;
									$_SESSION['icono'] = $nav->menu_icono;
									//Obtener el Nombre del Controlador y de la Funcion
									$name = $this->nav->listar_nombre_opcion($_SESSION['controlador'], $_SESSION['accion']);
									(isset($name->opcion_nombre)) ? $_SESSION['accion'] = $name->opcion_nombre : $_SESSION['accion'] = "";
									//Despues procedemos a llenar las las opciones del menú
								}?>
                            <li class="sidebar-item  has-sub navbar-light">
                                <a href="<?= $nav_link;?>" class='sidebar-link'>
                                    <i class="<?= $nav->menu_icono;?>"></i>
                                    <span><?= $nav->menu_nombre;?></span>
                                </a>
                                <ul class="submenu ">
                                    <li class="submenu-item ">
										<?php
										$option = $this->nav->listar_opciones($nav->id_menu);
										foreach ($option as $o){
											//Validamos si la opcion no tiene restriccion por rol
											$mostrar = true;
											foreach ($restricciones as $r){
												//Si entra al if, quiere decir que la opcion esta restringida para el rol del usuario
												if($r->id_opcion == $o->id_opcion){
													//Si entra aquí, quiere decir que el usuario no puede acceder a la opción especificada
													$mostrar = false;
												}
											}
											if($mostrar){
												?>
                                                <a href="<?= _SERVER_. $nav->menu_controlador . '/'. $o->opcion_funcion;?>"><?= $o->opcion_nombre;?></a>
                                                <!--                                   <a class="collapse-item" href="--><?php //= _SERVER_. $nav->menu_controlador . '/'. $o->opcion_funcion;?><!--">--><?php //= $o->opcion_nombre;?><!--</a>-->
												<?php
											}
										}
										?>
                                    </li>
                                </ul>
                            </li>
							<?php
							$raioz++;
							}
							?>
                    </li>
                </ul>
                </li>
				<?php
				$raioz2++;
				}
				?>
                <!--                    </div>-->
                </ul>
            </div>
            <button class="sidebar-toggler btn x"><i data-feather="x"></i></button>
        </div>
    </div>
    <div id="main" class='layout-navbar'>
        <header class='mb-2'>
            <nav class="navbar navbar-expand navbar-light bg-white  " >
                <div class="container-fluid">
                    <a href="#" class="burger-btn d-block">
                        <i class="bi bi-justify fs-3"></i>
                    </a>
                    <div class="collapse navbar-collapse" id="navbarSupportedContent">
<!--						--><?php
//						if($this->encriptar->desencriptar($_SESSION['c_u'],_FULL_KEY_) == 9){
//							?>
<!--                            <h3 style="margin-left: 15%;" class="text-center cumpleanos-message">¡FELIZ CUMPLEAÑOS...!!! 🎉🎂</h3>-->
<!--							--><?php
//						}
//						?>
                        <ul class="navbar-nav ms-auto mb-2 mb-lg-0">
                            <li class="nav-item dropdown me-3">
                                    <a id="notificationLink" class="nav-link active dropdown-toggle" href="#" data-bs-toggle="dropdown" aria-expanded="false">
                                        <i  class='bi bi-bell bi-sub fs-4 text-gray-600'></i>
                                    </a>
                                    <ul style="border: 2px solid #0014ff33; border-radius: 11px" id="miUl" class="dropdown-menu dropdown-menu-end custom-dropdown-menu" aria-labelledby="notificationLink">
                                        <li>
                                            <h6 class="dropdown-header">Notificaciones</h6>
                                        </li>
                                        <li class="centered-li">
                                            <a class="dropdown-item" type="button">Sin notificaciones</a>
                                        </li>
                                        <li>
                                            <a href="<?= _SERVER_ ?>Notificaciones/inicio" id="verTodoButton" class="dropdown-item custom-button text-white " type="button">Ver todo</a>
                                        </li>
                                    </ul>
                            </li>
                        </ul>
                        <div class="dropdown">
                            <a href="#" data-bs-toggle="dropdown" aria-expanded="false">
                                <div class="user-menu d-flex">
                                    <div class="user-name text-end me-3">
                                        <h6 class="mb-0 text-gray-600"><?= $this->encriptar->desencriptar($_SESSION['p_n'],_FULL_KEY_);?></h6>
                                        <p class="mb-0 text-sm text-gray-600"><?= $this->encriptar->desencriptar($_SESSION['rn'],_FULL_KEY_);?></p>
                                    </div>
                                    <div class="user-img d-flex align-items-center">
                                        <div class="avatar avatar-md">
                                            <img src="<?= _SERVER_ . $this->encriptar->desencriptar($_SESSION['u_i'],_FULL_KEY_);?>">
                                        </div>
                                    </div>
                                </div>
                            </a>
                            <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="dropdownMenuButton">
                                <li>
                                    <h6 class="dropdown-header">Hola, <?= $this->encriptar->desencriptar($_SESSION['p_n'],_FULL_KEY_);?>!</h6>
                                </li>
                                <li><a class="dropdown-item" href="#" data-toggle="modal" data-target="#editarPersonaDatos"><i class="icon-mid bi bi-person me-2"></i>Datos Personales</a></li>
                                <li><a class="dropdown-item" href="#" data-toggle="modal" data-target="#DatosUsuario"> <i class="fa-regular fa-pen-to-square me-2"></i>Nombre de Usuario</a></li>
                                <li><a class="dropdown-item" href="#" data-toggle="modal" data-target="#ContrasenhaUsuario"><i class="fa-solid fa-lock me-2"></i>Contraseña</a></li>
                                <li>
                                    <hr class="dropdown-divider">
                                </li>
                                <li><a class="dropdown-item" href="<?= _SERVER_;?>Admin/finalizar_sesion"><i
                                                class="icon-mid bi bi-box-arrow-left me-2"></i> Cerrar Sesión</a></li>
                            </ul>
                        </div>
                    </div>
                </div>
            </nav>
        </header>
<!--        ESTO ES PARA LA NOTIFICACION-->
        <script src="<?php echo _SERVER_ . _JS_;?>domain.js"></script>
        <script src="<?php echo _SERVER_ . _JS_;?>jquery-3.6.3.min.js"></script>
        <script src="<?php echo _SERVER_ . _JS_;?>notificaciones.js"></script>

        <style>
            /*PARA EL SPAN*/
            @keyframes shake {
                0%, 100% { transform: translateX(0); }
                10% { transform: translateX(-4px) rotate(-4deg); }
                20% { transform: translateX(4px) rotate(4deg); }
                30% { transform: translateX(-4px) rotate(-4deg); }
                40% { transform: translateX(4px) rotate(4deg); }
                50% { transform: translateX(-4px) rotate(-4deg); }
                60% { transform: translateX(4px) rotate(4deg); }
                70% { transform: translateX(-4px) rotate(-4deg); }
                80% { transform: translateX(4px) rotate(4deg); }
                90% { transform: translateX(-4px) rotate(-4deg); }
            }
            .vibrating-span {
                position: absolute;
                top: 13px;
                right: 15px;
                background-color: #ff0000;
                width: 20px;
                height: 18px;
                border-radius: 50%;
                text-align: center;
                color: #ffffff;
                font-weight: bold;
                line-height: 18px;
                animation: fadeInOut 3s infinite, shake 2s 3s infinite; /* fadeInOut cada 3 segundos, luego shake por 2 segundos */
                cursor: pointer; /* Añadido para indicar que es clickable */
            }
            @keyframes fadeInOut {
                0%, 100% { opacity: 1; }
                50% { opacity: 1; }
            }

            #notificationLink:visited {
                text-decoration: none;
            }
            .dropdown-menu {
                display: none; /* Asegura que el menú esté oculto inicialmente */
                position: relative; /* Permite posicionar el botón de manera absoluta en relación con este elemento */
            }
            .custom-dropdown-menu {
                width: 650%;
                height: 518px;
                right: 0; /* Deja right en 0 y ajusta este valor según sea necesario */
                left: auto;
            }

            /* Estilos para el botón */
            .custom-button {
                text-align: center;
                border-radius: 10px;
                background-color: #2f4ad8;
                position: absolute; /* Posiciona el botón de manera absoluta */
                bottom: 0; /* Lo coloca al fondo del elemento padre (el menú desplegable) */
                width: 100%; /* Ocupa todo el ancho del menú desplegable */
            }
            .custom-button.clicked {
                background-color: #ff0000; /* Color rojo cuando se hace clic */
            }
            .centered-li{
                display: flex;
                margin-top: 22%;
                margin-left: 25%;
            }
            .dropdown-menu  {
                left: auto!important;
            }
            /* Estilos para el mensaje de cumpleaños */
            .cumpleanos-message {
                background-color: #ffd700; /* Fondo amarillo */
                border: 2px solid #ff4500; /* Borde naranja */
                border-radius: 15px; /* Esquinas redondeadas */
                padding: 10px; /* Espaciado interno */
                display: inline-block; /* Alineación horizontal */
            }
        </style>
        <div id="main-content">




