-- MySQL dump 10.13  Distrib 8.0.16, for Win64 (x86_64)
--
-- Host: 127.0.0.1    Database: bd_camaracomercio
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
) ENGINE=InnoDB AUTO_INCREMENT=45 DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `opciones`
--

LOCK TABLES `opciones` WRITE;
/*!40000 ALTER TABLE `opciones` DISABLE KEYS */;
INSERT INTO `opciones` VALUES (1,1,'Inicio de Sesion','inicio','-',0,0,1),(2,2,'Inicio','inicio','fa fa-play',1,1,1),(3,2,'Cerrar Sesión','finalizar_sesion','fa fa-sign-out',0,1,1),(4,3,'Gestionar Menús','inicio',NULL,1,1,1),(5,3,'Iconos','iconos',NULL,1,2,1),(6,3,'Accesos por Rol','roles',NULL,0,0,1),(7,3,'Opciones por Menú','opciones',NULL,0,0,1),(8,3,'Gestionar Permisos(breve)','gestion_permisos','',0,0,1),(9,4,'Gestionar Roles','inicio','',1,1,1),(10,4,'Accesos por Rol','accesos','',0,0,1),(11,3,'Gestionar Restricciones(breve)','gestion_restricciones','',0,0,1),(12,5,'Gestionar Usuarios','inicio','',1,1,1),(13,6,'Editar Datos','editar_datos','',0,0,1),(14,6,'Editar Usuario','editar_usuario','',0,0,1),(15,6,'Cambiar Contraseña','cambiar_contrasenha','',0,0,1),(16,3,'Agrupaciones','agrupaciones','',1,3,1),(17,7,'Ver Servicios','servicios','',1,1,1),(18,8,'Ver categorías','categorias','',1,1,1),(19,9,'Afiliación','afiliacion','',1,1,1),(20,9,'Listar Socio','vista_afiliacion','',1,2,1),(21,9,'Generar PDF Soc','generarpdf','',0,3,1),(22,9,'detalle socio','vista_detalle_afiliacion_socio','',0,3,1),(23,10,'Realizar Venta','vista_realizar_venta','',1,1,1),(24,10,'tabla_productos_html','tabla_productos_html','',0,2,1),(25,10,'Listar Ventas','vista_ver_ventas','',1,3,1),(26,10,'imprimir_ticket_pdf','imprimir_ticket_pdf','',0,4,1),(27,10,'imprimir_ticket_pdf_A4','imprimir_ticket_pdf_a4','',0,5,1),(28,11,'Generar Cobranza Masiva','cobranza','',1,1,1),(29,10,'Listar Ventas SUNAT','vista_ver_ventas_sunat',NULL,1,3,1),(30,10,'Listar Ventas Anuladas','vista_ver_ventas_anulados',NULL,1,5,1),(31,10,'Notas','vista_realizar_nota',NULL,0,6,1),(32,10,'Detalle Venta','vista_detalleventa',NULL,0,5,1),(33,12,'Listar Clientes','vista_cliente','',1,1,1),(34,13,'Ver Beneficios','vista_beneficios',NULL,1,1,1),(35,13,'detallebeneficio','vista_detallebeneficios',NULL,0,2,1),(36,13,'Uso Beneficio','vista_usobeneficios',NULL,0,2,1),(37,9,'Detalle Uso Beneficios','vista_detalle_beneficiousuo_socio',NULL,0,4,1),(38,14,'Lista de Atenciones','vista_listaratenciones',NULL,1,1,1),(39,15,'Listar Eventos','vista_listareventos',NULL,1,1,1),(40,11,'Consultar Cobros','listar','',1,2,1),(41,16,'Listar Reportes','vista_listarareporte',NULL,1,1,1),(42,15,'AgregarEventos','vista_listareventosasist','',0,2,1),(43,12,'Crear Cliente','vista_crear_clientes','',1,1,1),(44,17,'ListarTipoDocumentos','vista_listartipodocumento','',1,1,1);
/*!40000 ALTER TABLE `opciones` ENABLE KEYS */;
UNLOCK TABLES;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2025-10-01 19:29:24
