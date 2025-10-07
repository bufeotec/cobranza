-- MySQL dump 10.13  Distrib 8.0.16, for Win64 (x86_64)
--
-- Host: 127.0.0.1    Database: prueba
-- ------------------------------------------------------
-- Server version	8.0.30

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
 SET NAMES utf8 ;
/*!40103 SET @OLD_TIME_ZONE=@@TIME_ZONE */;
/*!40103 SET TIME_ZONE='+00:00' */;
/*!40014 SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;

--
-- Table structure for table `opciones`
--

DROP TABLE IF EXISTS `opciones`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
 SET character_set_client = utf8mb4 ;
CREATE TABLE `opciones` (
  `id_opcion` int NOT NULL AUTO_INCREMENT,
  `id_menu` int NOT NULL,
  `opcion_nombre` varchar(30) COLLATE utf8mb3_unicode_ci NOT NULL,
  `opcion_funcion` varchar(35) COLLATE utf8mb3_unicode_ci NOT NULL,
  `opcion_icono` char(20) COLLATE utf8mb3_unicode_ci DEFAULT NULL,
  `opcion_mostrar` tinyint(1) NOT NULL,
  `opcion_orden` int NOT NULL,
  `opcion_estado` tinyint(1) NOT NULL,
  PRIMARY KEY (`id_opcion`),
  KEY `id_menu` (`id_menu`),
  CONSTRAINT `opciones_ibfk_1` FOREIGN KEY (`id_menu`) REFERENCES `menus` (`id_menu`)
) ENGINE=InnoDB AUTO_INCREMENT=42 DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `opciones`
--

LOCK TABLES `opciones` WRITE;
/*!40000 ALTER TABLE `opciones` DISABLE KEYS */;
INSERT INTO `opciones` VALUES (1,1,'Inicio de Sesion','inicio','-',0,0,1),(2,2,'Inicio','inicio','fa fa-play',1,1,1),(3,2,'Cerrar Sesión','finalizar_sesion','fa fa-sign-out',0,1,1),(4,3,'Gestionar Menús','inicio',NULL,1,1,1),(5,3,'Iconos','iconos',NULL,1,2,1),(6,3,'Accesos por Rol','roles',NULL,0,0,1),(7,3,'Opciones por Menú','opciones',NULL,0,0,1),(8,3,'Gestionar Permisos(breve)','gestion_permisos','',0,0,1),(9,4,'Gestionar Roles','inicio','',1,1,1),(10,4,'Accesos por Rol','accesos','',0,0,1),(11,3,'Gestionar Restricciones(breve)','gestion_restricciones','',0,0,1),(12,5,'Gestionar Usuarios','inicio','',1,1,1),(13,6,'Editar Datos','editar_datos','',0,0,1),(14,6,'Editar Usuario','editar_usuario','',0,0,1),(15,6,'Cambiar Contraseña','cambiar_contrasenha','',0,0,1),(16,3,'Agrupaciones','agrupaciones','',1,3,1),(17,7,'Ver Servicios','servicios','',1,1,1),(18,8,'Ver categorías','categorias','',1,1,1),(19,9,'Afiliación','afiliacion','',1,1,1),(20,9,'Listar Socio','vista_afiliacion','',1,2,1),(21,9,'Generar PDF Soc','generarpdf','',0,3,1),(22,9,'detalle socio','vista_detalle_afiliacion_socio','',0,3,1),(23,10,'Realizar Venta','vista_realizar_venta','',1,1,1),(24,10,'tabla_productos_html','tabla_productos_html','',0,2,1),(25,10,'Listar Ventas','vista_ver_ventas','',1,3,1),(26,10,'imprimir_ticket_pdf','imprimir_ticket_pdf','',0,4,1),(27,10,'imprimir_ticket_pdf_A4','imprimir_ticket_pdf_a4','',0,5,1),(28,11,'Generar Cobranza Masiva','cobranza','',1,1,1),(29,10,'Listar Ventas SUNAT','vista_ver_ventas_sunat',NULL,1,3,1),(30,10,'Listar ventas anuladas','vista_ver_ventas_anulados','',1,5,1),(31,10,'Notas','vista_realizar_nota','',0,6,1),(32,10,'Detalle Venta','vista_detalleventa','',0,5,1),(33,12,'Listar Clientes','vista_cliente','',1,1,1),(34,13,'ver beneficios','vista_beneficios','',1,1,1),(35,13,'detallebeneficio','vista_detallebeneficios','',0,2,1),(36,13,'Uso Beneficio','vista_usobeneficios','',0,2,1),(37,9,'DetalleUso Beneficio','vista_detalle_beneficiousuo_socio','',0,4,1),(38,14,'Lista de Atenciones','vista_listaratenciones','',1,1,1),(39,15,'Listar Eventos','vista_listareventos','',1,1,1),(40,16,'Listar Reportes','vista_listarareporte','',1,1,1),(41,15,'AgregarEventos','vista_listareventosasist','',0,2,1);
/*!40000 ALTER TABLE `opciones` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `permisos`
--

DROP TABLE IF EXISTS `permisos`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
 SET character_set_client = utf8mb4 ;
CREATE TABLE `permisos` (
  `id_permiso` int NOT NULL AUTO_INCREMENT,
  `id_opcion` int NOT NULL,
  `permiso_accion` varchar(30) COLLATE utf8mb3_unicode_ci NOT NULL,
  `permiso_estado` tinyint(1) NOT NULL,
  PRIMARY KEY (`id_permiso`),
  KEY `id_opcion` (`id_opcion`),
  CONSTRAINT `permisos_ibfk_1` FOREIGN KEY (`id_opcion`) REFERENCES `opciones` (`id_opcion`)
) ENGINE=InnoDB AUTO_INCREMENT=75 DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `permisos`
--

LOCK TABLES `permisos` WRITE;
/*!40000 ALTER TABLE `permisos` DISABLE KEYS */;
INSERT INTO `permisos` VALUES (1,1,'validar_sesion',1),(2,4,'guardar_menu',1),(3,6,'configurar_relacion',1),(4,7,'guardar_opcion',1),(5,7,'agregar_permiso',1),(6,7,'eliminar_permiso',1),(7,7,'configurar_acceso',1),(8,9,'guardar_rol',1),(9,10,'gestionar_acceso_rol',1),(10,12,'guardar_nuevo_usuario',1),(11,12,'guardar_edicion_usuario',1),(12,12,'guardar_edicion_persona',1),(13,12,'restablecer_contrasenha',1),(14,13,'guardar_datos',1),(15,14,'guardar_usuario',1),(16,15,'guardar_contrasenha',1),(17,16,'guardar_grupo',1),(18,16,'agregar_permisos_grupo',1),(19,16,'eliminar_permisos_grupo',1),(20,17,'guardar_servicio',1),(21,18,'guardar_categoria',1),(22,19,'rubro_por_sector',1),(23,19,'listar_categoria_select',1),(26,20,'vista_afiliacion',1),(27,19,'guardar_socio',1),(28,20,'vista_detalle_afiliacion_socio',1),(30,23,'vista_realizar_venta',1),(31,23,'consultar_serie',1),(34,24,'tabla_productos_html',1),(35,23,'guardar_venta',1),(36,25,'vista_ver_ventas',1),(37,23,'crear_xml_enviar_sunat',1),(40,25,'imprimir_ticket_pdf_a4',1),(41,26,'imprimir_ticket_pdf_a4',1),(42,23,'crear_tiket',1),(43,27,'imprimir_ticket_pdf_a4',1),(44,20,'obtener_datos_x_ruc',1),(45,28,'generar_cobranza',1),(46,25,'comunicacion_baja',1),(48,17,'buscar_servicio_nombreycodigo',1),(49,31,'consultar_serie_nota',1),(50,31,'tipo_nota_descripcion',1),(51,33,'obtener_datos_x_numdocumento',1),(52,34,'vista_beneficios',1),(56,35,'vista_detallebeneficios',1),(57,35,'guardar_categoriabeneficio',1),(58,35,'eliminar_categoriabeneficio',1),(59,34,'guardar_beneficio',1),(60,34,'eliminar_beneficio',1),(62,34,'listar_categoriaben_select',1),(63,36,'guardar_beneficiouso',1),(64,36,'eliminar_beneficiouso',1),(66,38,'vista_listaratenciones',1),(67,38,'guardar_atencion',1),(68,38,'eliminar_atencion',1),(69,18,'listar_categoria_select',1),(70,39,'vista_listareventos',1),(71,39,'guardar_eventoasit',1),(72,39,'eliminar_eventoasit',1),(73,41,'vista_listareventosasist',1),(74,39,'vista_listareventosasit',1);
/*!40000 ALTER TABLE `permisos` ENABLE KEYS */;
UNLOCK TABLES;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2025-09-26 16:08:48
