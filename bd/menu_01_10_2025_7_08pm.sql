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
-- Table structure for table `menus`
--

DROP TABLE IF EXISTS `menus`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
 SET character_set_client = utf8mb4 ;
CREATE TABLE `menus` (
  `id_menu` int NOT NULL AUTO_INCREMENT,
  `id_grupo` int NOT NULL,
  `menu_nombre` varchar(20) COLLATE utf8mb3_unicode_ci NOT NULL,
  `menu_controlador` varchar(20) COLLATE utf8mb3_unicode_ci NOT NULL,
  `menu_icono` varchar(30) COLLATE utf8mb3_unicode_ci NOT NULL,
  `menu_orden` int NOT NULL,
  `menu_mostrar` tinyint(1) NOT NULL,
  `menu_estado` tinyint(1) NOT NULL,
  PRIMARY KEY (`id_menu`),
  KEY `id_grupo` (`id_grupo`),
  CONSTRAINT `menus_ibfk_1` FOREIGN KEY (`id_grupo`) REFERENCES `grupos` (`id_grupo`)
) ENGINE=InnoDB AUTO_INCREMENT=18 DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `menus`
--

LOCK TABLES `menus` WRITE;
/*!40000 ALTER TABLE `menus` DISABLE KEYS */;
INSERT INTO `menus` VALUES (1,1,'Login','Login','-',0,0,1),(2,1,'Panel de Inicio','Admin','fa fa-dashboard',1,0,1),(3,1,'Gestión de Menu','Menu','fa fa-desktop',2,1,1),(4,1,'Roles de Usuario','Rol','fa fa-user-secret',4,1,1),(5,1,'Usuarios','Usuario','fa fa-user',5,1,1),(6,1,'Datos Personales','Datos','fa fa-',0,0,1),(7,2,'Servicios','Servicios','fa fa-star',1,1,1),(8,2,'Categorias','Categorias','fa fa-tags',2,1,1),(9,3,'Socios','Socios','fa fa-user-plus',1,1,1),(10,4,'Ventas','Ventas','fa fa-external-link-square',1,1,1),(11,4,'Gestión de Cobranza','Cobranza','fa fa-laptop',5,1,1),(12,3,'Clientes','Clientes','fa fa-users',2,1,1),(13,2,'Beneficios','Beneficios','fa fa-code-fork',2,1,1),(14,5,'Gestion Horario','Atencion','fa fa-book',1,1,1),(15,5,'Eventos','Evento','fa fa-bullhorn',2,1,1),(16,6,'Ver Reporte','Reporte','fa fa-bullhorn',1,1,1),(17,2,'TipoDocumento','Tipodocumento','fa fa-bullhorn',1,0,1);
/*!40000 ALTER TABLE `menus` ENABLE KEYS */;
UNLOCK TABLES;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2025-10-01 19:31:27
