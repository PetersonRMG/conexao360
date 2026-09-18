-- MySQL dump 10.13  Distrib 8.4.8, for Linux (x86_64)
--
-- Host: localhost    Database: db_conexao360
-- ------------------------------------------------------
-- Server version	8.4.8

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!50503 SET NAMES utf8mb4 */;
/*!40103 SET @OLD_TIME_ZONE=@@TIME_ZONE */;
/*!40103 SET TIME_ZONE='+00:00' */;
/*!40014 SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;

--
-- Table structure for table `tbl_chats`
--

DROP TABLE IF EXISTS `tbl_chats`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `tbl_chats` (
  `id_chat` int NOT NULL AUTO_INCREMENT,
  `id_usuario` int NOT NULL,
  `mensagem_chat` text COLLATE utf8mb4_general_ci NOT NULL,
  `status_entregue_chat` varchar(10) COLLATE utf8mb4_general_ci NOT NULL,
  `status_remetente_chat` varchar(10) COLLATE utf8mb4_general_ci NOT NULL,
  `data_envio_chat` datetime NOT NULL,
  `data_receb_chat` datetime NOT NULL,
  `criado_em_chat` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id_chat`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `tbl_chats`
--

LOCK TABLES `tbl_chats` WRITE;
/*!40000 ALTER TABLE `tbl_chats` DISABLE KEYS */;
/*!40000 ALTER TABLE `tbl_chats` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `tbl_conteudos`
--

DROP TABLE IF EXISTS `tbl_conteudos`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `tbl_conteudos` (
  `id_conteudos` int NOT NULL AUTO_INCREMENT,
  `id_usuario` int NOT NULL,
  `id_evento` int NOT NULL,
  `titulo_conteudo` varchar(150) COLLATE utf8mb4_general_ci NOT NULL,
  `tipo_conteudo` varchar(10) COLLATE utf8mb4_general_ci NOT NULL,
  `descricao_conteudo` text COLLATE utf8mb4_general_ci NOT NULL,
  `liberado_em_conteudo` datetime NOT NULL,
  `url_conteudo` varchar(255) COLLATE utf8mb4_general_ci NOT NULL,
  `status_conteudo` varchar(10) COLLATE utf8mb4_general_ci NOT NULL,
  `criado_em_conteudo` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `atualizado_em_conteudo` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id_conteudos`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `tbl_conteudos`
--

LOCK TABLES `tbl_conteudos` WRITE;
/*!40000 ALTER TABLE `tbl_conteudos` DISABLE KEYS */;
/*!40000 ALTER TABLE `tbl_conteudos` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `tbl_depoimentos`
--

DROP TABLE IF EXISTS `tbl_depoimentos`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `tbl_depoimentos` (
  `id_depoimentos` int NOT NULL AUTO_INCREMENT,
  `id_usuario` int NOT NULL,
  `id_evento` int NOT NULL,
  `status_depoimento` varchar(10) COLLATE utf8mb4_general_ci NOT NULL,
  `descricao_depoimento` text COLLATE utf8mb4_general_ci NOT NULL,
  `criado_em_depoimento` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `atualizado_em_depoimento` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id_depoimentos`)
) ENGINE=InnoDB AUTO_INCREMENT=15 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `tbl_depoimentos`
--

LOCK TABLES `tbl_depoimentos` WRITE;
/*!40000 ALTER TABLE `tbl_depoimentos` DISABLE KEYS */;
INSERT INTO `tbl_depoimentos` VALUES (1,2,1,'ATIVO','A mentalidade que a Dra. Simone transmite quebra os paradigmas tradicionais da advocacia. O ecossistema de networking gerado dentro da rede é espetacular.','2026-06-19 14:26:36','2026-06-26 13:02:21'),(2,1,1,'ATIVO','O Conexão 360 mudou completamente a forma como precifico meus honorários. Em menos de 2 meses após a mentoria, consegui fechar contratos com valor 40% maior aplicando a postura de alta performance.','2026-06-19 14:27:21','2026-06-29 12:33:49'),(3,1,1,'ATIVO','teste','2026-06-19 14:57:06','2026-06-29 12:33:04'),(4,1,1,'ATIVO','teste2','2026-06-22 12:34:00','2026-06-29 12:33:06'),(5,1,1,'ATIVO','teste3','2026-06-22 12:34:04','2026-07-31 12:34:23'),(6,1,1,'RECUSADO','teste4','2026-06-22 12:34:46','2026-06-26 13:02:53'),(7,1,1,'RECUSADO','teste5','2026-06-22 12:34:50','2026-06-22 13:52:17'),(8,1,1,'RECUSADO','teste6','2026-06-22 12:34:54','2026-06-26 13:02:54'),(9,1,1,'RECUSADO','teste8teste9','2026-06-22 12:34:24','2026-06-26 13:02:56'),(10,1,1,'RECUSADO','teste10','2026-06-22 12:34:28','2026-06-26 13:02:59'),(11,1,1,'RECUSADO','teste depoimento','2026-06-22 15:00:27','2026-06-26 13:03:00'),(12,1,1,'ATIVO','\"O Conexão 360 mudou completamente .\"','2026-06-24 12:28:36','2026-06-26 13:02:26'),(13,1,1,'ATIVO','teste22222222','2026-06-29 12:33:31','2026-06-29 12:33:54'),(14,5,3,'ATIVO','Muito Bom','2026-07-31 12:56:10','2026-07-31 12:56:46');
/*!40000 ALTER TABLE `tbl_depoimentos` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `tbl_dra`
--

DROP TABLE IF EXISTS `tbl_dra`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `tbl_dra` (
  `id_dra` int NOT NULL AUTO_INCREMENT,
  `id_evento` int NOT NULL DEFAULT '1',
  `foto_dra` varchar(255) COLLATE utf8mb4_general_ci NOT NULL,
  `titulo_dra` varchar(100) COLLATE utf8mb4_general_ci NOT NULL,
  `sub_titulo_dra` varchar(100) COLLATE utf8mb4_general_ci NOT NULL,
  `descricao_dra` text COLLATE utf8mb4_general_ci NOT NULL,
  `status_dra` varchar(10) COLLATE utf8mb4_general_ci NOT NULL,
  `criado_em_dra` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `atualizado_em_dra` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id_dra`),
  KEY `fk_dra_eventos` (`id_evento`),
  CONSTRAINT `fk_dra_eventos` FOREIGN KEY (`id_evento`) REFERENCES `tbl_eventos` (`id_evento`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `tbl_dra`
--

LOCK TABLES `tbl_dra` WRITE;
/*!40000 ALTER TABLE `tbl_dra` DISABLE KEYS */;
INSERT INTO `tbl_dra` VALUES (1,1,'dra/fotodra.png','Dra. Simone Baptista','Advogada | Mentora de Advogados | Idealizadora do Conexão 360','Eu escolhi a advocacia como missão. E escolhi ensinar porque sei o peso de carregar um sonho sozinha.\r\nMentoro advogados que decidiram parar de aceitar migalhas e passaram a construir uma carreira sólida, estratégica e sustentável — com postura, método e constância.\r\nNo Advocacia Exponencial Conexão 360, eu vou te conduzir numa virada de chave completa. Mente, posicionamento, comunicação e decisão. Você não sai igual. Você sai com clareza, com plano e com uma nova postura.\r\nEu sou advogada de sucesso. E eu ensino você a se tornar uma também.','ATIVO','2026-05-04 11:45:20','2026-08-27 12:10:43'),(2,1,'dra/1781276092.jpg','teste dra','teste draaa','dra dra','INATIVO','2026-06-12 14:54:52','2026-08-27 12:10:43');
/*!40000 ALTER TABLE `tbl_dra` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `tbl_enquetes`
--

DROP TABLE IF EXISTS `tbl_enquetes`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `tbl_enquetes` (
  `id_enquete` int NOT NULL AUTO_INCREMENT,
  `pergunta_enquete` varchar(80) COLLATE utf8mb4_general_ci NOT NULL,
  `resposta_um_enquete` tinyint DEFAULT NULL,
  `resposta_dois_enquete` tinyint DEFAULT NULL,
  `resposta_tres_enquete` tinyint DEFAULT NULL,
  PRIMARY KEY (`id_enquete`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `tbl_enquetes`
--

LOCK TABLES `tbl_enquetes` WRITE;
/*!40000 ALTER TABLE `tbl_enquetes` DISABLE KEYS */;
/*!40000 ALTER TABLE `tbl_enquetes` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `tbl_eventos`
--

DROP TABLE IF EXISTS `tbl_eventos`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `tbl_eventos` (
  `id_evento` int NOT NULL AUTO_INCREMENT,
  `banner_evento` varchar(255) COLLATE utf8mb4_general_ci NOT NULL,
  `titulo_evento` varchar(200) COLLATE utf8mb4_general_ci NOT NULL,
  `edicao_evento` int NOT NULL,
  `descricao_evento` text COLLATE utf8mb4_general_ci NOT NULL,
  `data_inicial_evento` date NOT NULL,
  `hora_inicial_evento` time NOT NULL,
  `endereco_evento` varchar(80) COLLATE utf8mb4_general_ci NOT NULL,
  `url_evento` varchar(2000) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `status_evento` varchar(10) COLLATE utf8mb4_general_ci NOT NULL,
  `criado_em_evento` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `atualizado_em_evento` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `data_termino_evento` date NOT NULL,
  `hora_termino_evento` time NOT NULL,
  PRIMARY KEY (`id_evento`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `tbl_eventos`
--

LOCK TABLES `tbl_eventos` WRITE;
/*!40000 ALTER TABLE `tbl_eventos` DISABLE KEYS */;
INSERT INTO `tbl_eventos` VALUES (1,'evento/banner-evento.png','ADVOCACIA EXPONENCIAL',3,'O próximo nível da sua carreira jurídica é uma decisão estratégica.','2026-07-01','08:00:00','Alameda Araguaia 2104 - Alphaville industrial','https://www.google.com/maps/embed?pb=!3m2!1spt-BR!2sbr!4v1787839482767!5m2!1spt-BR!2sbr!6m8!1m7!1sINUr9-1IlS1A5xdPkw8xfw!2m2!1d-23.49529695252076!2d-46.43181758657467!3f189.97101!4f0!5f0.7820865974627469','INATIVO','2026-06-08 13:26:22','2026-09-11 12:39:05','2026-07-02','12:00:00'),(2,'evento/banner-evento4.png','ADVOCACIA EXPONENCIAL4',4,'O próximo nível da sua carreira jurídica é uma decisão estratégica4.','2026-12-10','19:00:00','Alameda Araguaia 2104 - Alphaville industrial','https://www.google.com/maps/embed?pb=!4v1770671449477!6m8!1m7!1sfyHhGVpN2cpdkC8-XjOdgA!2m2!1d-23.50074578412579!2d-46.84116819281623!3f190.46136!4f0!5f0.7820865974627469','INATIVO','2026-06-09 11:59:31','2026-09-11 12:39:05','2026-12-11','21:00:00'),(3,'evento/banner-evento5.png','ADVOCACIA EXPONENCIAL5',5,'O próximo nível da sua carreira jurídica é uma decisão estratégica5.','2027-01-10','19:00:00','Alameda Araguaia 2104 - Alphaville industrial','https://www.google.com/maps/embed?pb=!4v1770671449477!6m8!1m7!1sfyHhGVpN2cpdkC8-XjOdgA!2m2!1d-23.50074578412579!2d-46.84116819281623!3f190.46136!4f0!5f0.7820865974627469','ATIVO','2026-06-09 11:59:55','2026-09-11 12:39:05','2027-01-11','21:00:00'),(4,'evento/1781267221.jpg','titulo evento teste 1',25,'tessste descrição','2030-06-12','20:00:00','rua um','https://site.com/c/6a1d7097-42e4-83e9-9388-25c9403043a4','INATIVO','2026-06-12 12:27:01','2026-09-11 12:39:05','2030-06-15','22:00:00');
/*!40000 ALTER TABLE `tbl_eventos` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `tbl_feeds`
--

DROP TABLE IF EXISTS `tbl_feeds`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `tbl_feeds` (
  `id_feeds` int NOT NULL AUTO_INCREMENT,
  `id_usuario` int NOT NULL,
  `id_evento` int NOT NULL,
  `curtidas_feed` int DEFAULT NULL,
  `foto_feed` varchar(255) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `comentario_feed` varchar(100) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `status_feed` varchar(10) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `criado_em_feed` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `atualizado_em_feed` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id_feeds`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `tbl_feeds`
--

LOCK TABLES `tbl_feeds` WRITE;
/*!40000 ALTER TABLE `tbl_feeds` DISABLE KEYS */;
/*!40000 ALTER TABLE `tbl_feeds` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `tbl_hero_section`
--

DROP TABLE IF EXISTS `tbl_hero_section`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `tbl_hero_section` (
  `id_hero_section` int NOT NULL AUTO_INCREMENT,
  `tagline_hero` varchar(50) NOT NULL,
  `titulo_hero` varchar(100) NOT NULL,
  `subtitulo_hero` varchar(100) NOT NULL,
  `texto_botao_hero` varchar(50) NOT NULL,
  `link_botao_hero` varchar(255) NOT NULL,
  `foto_banner` varchar(255) NOT NULL,
  `status_hero` varchar(10) NOT NULL,
  `criado_em_hero` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `atualizado_em_hero` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id_hero_section`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `tbl_hero_section`
--

LOCK TABLES `tbl_hero_section` WRITE;
/*!40000 ALTER TABLE `tbl_hero_section` DISABLE KEYS */;
INSERT INTO `tbl_hero_section` VALUES (1,'— INSCRIÇÕES ABERTAS • VAGAS LIMITADAS —','a virada de chave da advocacia exponencial','Participe da 3ª Edição do Conexão 360º e dê a  Virada de Chave na Sua Carreira na Advocacia.','Garantir minha vaga no Conexão 360º','https://sun.eduzz.com/Q9N56RAK01','hero/hero-banner.jpg','ATIVO','2026-06-09 14:33:01','2026-08-27 14:11:04'),(2,'Advocacia Exponencial','conexão 360°','a virada de chave da advocacia exponencial','testeGarantir minha vaga no Conexão 360º','https://sun.eduzz.com/Q9N56RAK01','hero/1789134716_6aa4077cbd720.png','ATIVO','2026-06-11 14:52:15','2026-09-11 13:52:36');
/*!40000 ALTER TABLE `tbl_hero_section` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `tbl_ingressos`
--

DROP TABLE IF EXISTS `tbl_ingressos`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `tbl_ingressos` (
  `id_ingresso` int NOT NULL AUTO_INCREMENT,
  `id_usuario` int NOT NULL,
  `id_evento` int NOT NULL,
  `codigo_acesso_ingresso` varchar(255) COLLATE utf8mb4_general_ci NOT NULL,
  `status_ingresso` varchar(10) COLLATE utf8mb4_general_ci NOT NULL,
  `pagamento_compra_ingresso` datetime NOT NULL,
  `compra_em_ingresso` datetime NOT NULL,
  PRIMARY KEY (`id_ingresso`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `tbl_ingressos`
--

LOCK TABLES `tbl_ingressos` WRITE;
/*!40000 ALTER TABLE `tbl_ingressos` DISABLE KEYS */;
/*!40000 ALTER TABLE `tbl_ingressos` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `tbl_palestras`
--

DROP TABLE IF EXISTS `tbl_palestras`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `tbl_palestras` (
  `id_palestra` int NOT NULL AUTO_INCREMENT,
  `id_usuario` int NOT NULL,
  `id_evento` int NOT NULL,
  `foto_palestra` varchar(80) COLLATE utf8mb4_general_ci NOT NULL,
  `titulo_palestra` varchar(200) COLLATE utf8mb4_general_ci NOT NULL,
  `video_palestra` varchar(255) COLLATE utf8mb4_general_ci NOT NULL,
  `status_palestra` varchar(10) COLLATE utf8mb4_general_ci NOT NULL,
  `criado_em_palestra` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `atualizado_em_palestra` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id_palestra`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `tbl_palestras`
--

LOCK TABLES `tbl_palestras` WRITE;
/*!40000 ALTER TABLE `tbl_palestras` DISABLE KEYS */;
/*!40000 ALTER TABLE `tbl_palestras` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `tbl_respostas`
--

DROP TABLE IF EXISTS `tbl_respostas`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `tbl_respostas` (
  `id_resposta` int NOT NULL AUTO_INCREMENT,
  `id_usuario` int NOT NULL,
  `id_enquete` int NOT NULL,
  `resposta_resposta` tinyint NOT NULL,
  PRIMARY KEY (`id_resposta`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `tbl_respostas`
--

LOCK TABLES `tbl_respostas` WRITE;
/*!40000 ALTER TABLE `tbl_respostas` DISABLE KEYS */;
/*!40000 ALTER TABLE `tbl_respostas` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `tbl_temas`
--

DROP TABLE IF EXISTS `tbl_temas`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `tbl_temas` (
  `id_tema` int NOT NULL AUTO_INCREMENT,
  `titulo_tema` varchar(200) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `subtitulo_tema` varchar(200) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `breve_descricao_tema` varchar(80) COLLATE utf8mb4_general_ci NOT NULL,
  `foto_tema` varchar(255) COLLATE utf8mb4_general_ci NOT NULL,
  `id_evento` int NOT NULL DEFAULT '1',
  `status_tema` varchar(10) COLLATE utf8mb4_general_ci NOT NULL,
  `criado_em_tema` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `atualizado_em_tema` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id_tema`),
  KEY `fk_temas_eventos` (`id_evento`),
  CONSTRAINT `fk_temas_eventos` FOREIGN KEY (`id_evento`) REFERENCES `tbl_eventos` (`id_evento`)
) ENGINE=InnoDB AUTO_INCREMENT=9 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `tbl_temas`
--

LOCK TABLES `tbl_temas` WRITE;
/*!40000 ALTER TABLE `tbl_temas` DISABLE KEYS */;
INSERT INTO `tbl_temas` VALUES (1,'Mentalidade Exponencial do Advogado de Alta Performance','Você vai entender por que esforço sem mentalidade trava resultados e como reprogramar decisões, coragem e posicionamento para crescer com estrátegia, autorirade e proposta.','Aqui, o advogado deixa de operar no automático e passa a jogar o jogo grande.','tema/foto-tema-mentalidade.png',1,'INATIVO','2026-05-04 11:54:55','2026-06-29 11:25:22'),(2,'Atendimento Consultivo que Converte sem Pressão','Aprenda a conduzir atendimentos que geram confiança imediata, segurança jurídica e decisão consciente Sem implorar, sem convencer, sem desconto.','O cliente percebe valor antes mesmo de perguntar o preço.','tema/foto-tema-atendimento.png',1,'INATIVO','2026-05-04 11:57:31','2026-06-17 14:59:38'),(3,'Posicionamento Estratégico para ser Lembrado e Indicado','Descubra como sair da guerra de preços, construir autoridade real e ser reconhecido pelo valor que entrega — mesmo que hoje você se sinta “mais um” no mercado.','Quem não se posiciona… é escolhido pelo menor preço.','tema/foto-tema-posicionamento.png',1,'INATIVO','2026-05-05 08:21:20','2026-06-17 13:40:42'),(4,'Da conversa ao Contrato: O Método da Conversão Natural','Entenda o passo a passo que transforma conversas em contratos assinados, com ética, segurança e previsibilidade.','Advogado que entende valor nunca mais pede permissão para cobrar.','tema/foto-tema-conversa.png',1,'ATIVO','2026-05-05 08:22:37','2026-06-29 12:30:45'),(5,'Precificação com Valor, Consciência e Autorirade','Aprenda a precificar sem medo, sustentar seus honorários com segurança e cobrar pelo impacto que você gera — não por hora trabalhada.','Advogado que entende valor nunca mais pede permissão para cobrar.','tema/foto-tema-precificacao.png',1,'INATIVO','2026-05-05 08:52:15','2026-06-17 14:58:57'),(6,'novo teste','teste','teste','tema/1780064000.png',1,'ATIVO','2026-05-29 13:52:49','2026-06-17 13:49:13'),(7,'testando','teste','teste','tema/1781269758.jpg',1,'INATIVO','2026-06-12 13:09:18','2026-06-29 12:32:42'),(8,'TESTE','TESTE','TESTE','tema/1781787393.jpg',1,'INATIVO','2026-06-18 12:56:33','2026-06-18 12:57:17');
/*!40000 ALTER TABLE `tbl_temas` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `tbl_usuarios`
--

DROP TABLE IF EXISTS `tbl_usuarios`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `tbl_usuarios` (
  `id_usuario` int NOT NULL AUTO_INCREMENT,
  `nome_usuario` varchar(100) COLLATE utf8mb4_general_ci NOT NULL,
  `foto_usuario` varchar(80) COLLATE utf8mb4_general_ci NOT NULL,
  `email_usuario` varchar(80) COLLATE utf8mb4_general_ci NOT NULL,
  `area_atuacao_usuario` varchar(150) COLLATE utf8mb4_general_ci NOT NULL,
  `senha_usuario` varchar(255) COLLATE utf8mb4_general_ci NOT NULL,
  `termos_usuario` tinyint NOT NULL,
  `perfil_usuario` varchar(45) COLLATE utf8mb4_general_ci NOT NULL,
  `estado_usuario` varchar(2) COLLATE utf8mb4_general_ci NOT NULL,
  `conexoes_usuario` int DEFAULT NULL,
  `comentario_usuario` varchar(200) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `sobre_usuario` varchar(200) COLLATE utf8mb4_general_ci NOT NULL,
  `instagram_usuario` varchar(255) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `linkedin_usuario` varchar(255) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `youtube_usuario` varchar(255) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `tiktok_usuario` varchar(255) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `facebook_usuario` varchar(255) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `site_usuario` varchar(255) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `enquete_usuario` varchar(10) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `curtidas_usuario` int DEFAULT NULL,
  `criado_em_usuario` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `atualizado_em_usuario` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `status_usuario` varchar(15) COLLATE utf8mb4_general_ci NOT NULL,
  PRIMARY KEY (`id_usuario`)
) ENGINE=InnoDB AUTO_INCREMENT=8 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `tbl_usuarios`
--

LOCK TABLES `tbl_usuarios` WRITE;
/*!40000 ALTER TABLE `tbl_usuarios` DISABLE KEYS */;
INSERT INTO `tbl_usuarios` VALUES (1,'Alan Trabalhista','usuario/alan-trabalhista.jpg','alan.t@gmail.com','Trabalhista','$2y$12$aA8Mw3e1rrhf0BUpuzvxM.t89SSJrQpkfedQ.SQ8gdsLN6MRDwhLm',1,'palestrante','SP',NULL,NULL,'Advogado com atuação na área trabalhista',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,'2026-04-07 09:22:44','2026-08-10 14:06:24','ATIVO'),(2,'Armado Batista','usuario/armado-batista.jpg','armado.b@gmail.com','Criminal','$2y$12$aA8Mw3e1rrhf0BUpuzvxM.t89SSJrQpkfedQ.SQ8gdsLN6MRDwhLm',1,'palestrante','RJ',NULL,NULL,'Advogado com atuação na área criminal','https://www.instagram.com/simonebap.adv?igsh=MWF4OXp2NG96MDBqcQ%3D%3D&utm_source=qr','https://www.instagram.com/simonebap.adv?igsh=MWF4OXp2NG96MDBqcQ%3D%3D&utm_source=qr','https://www.instagram.com/simonebap.adv?igsh=MWF4OXp2NG96MDBqcQ%3D%3D&utm_source=qr','https://www.instagram.com/simonebap.adv?igsh=MWF4OXp2NG96MDBqcQ%3D%3D&utm_source=qr','https://www.instagram.com/simonebap.adv?igsh=MWF4OXp2NG96MDBqcQ%3D%3D&utm_source=qr','https://www.instagram.com/simonebap.adv?igsh=MWF4OXp2NG96MDBqcQ%3D%3D&utm_source=qr',NULL,NULL,'2026-04-10 08:51:01','2026-09-14 11:17:15','ATIVO'),(3,'João Camisa','usuario/joao-camisa.pgn','joao.c@gmail.com','Consumidor','teste1234',1,'usuario','MG',NULL,NULL,'Advogado com atuação na área do consumidor',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,'2026-04-10 08:59:05','2026-06-26 12:41:25','ATIVO'),(4,'Simone Batista','usuario/simone-batista.png','simone.b@gmail.com','Previdenciário','$2y$12$aA8Mw3e1rrhf0BUpuzvxM.t89SSJrQpkfedQ.SQ8gdsLN6MRDwhLm',1,'administrador','SP',NULL,NULL,' Especialista em Direito Previdenciário (INSS), com foco em aposentadorias (tempo de contribuição, idade, especial) e revisões, além de experiência na área da saúde.',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,'2026-05-08 11:44:28','2026-06-26 12:41:28','ATIVO'),(5,'Gabriela teste','usuario/1782485832.png','gabriela.g@email.com','criminal','$2y$12$WdwkFqxbgPlH/pu/cftOk.Y74OD5ttlZMe4eRy43KbEZlO0P1MUxu',1,'palestrante','SP',NULL,NULL,'teste',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,'2026-06-26 14:56:29','2026-08-05 12:57:39','ATIVO'),(6,'Maria Aparecida','usuario/1782485847.jpg','maria.a@gmail.com','criminal','$2y$12$XmO/tWq.G4QpyMNf41OqeekEvfglKYsenqpLdovagZuQWZoaFkhmG',1,'palestrante','SP',NULL,NULL,'teste',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,'2026-06-26 14:57:27','2026-08-05 13:43:38','ATIVO'),(7,'carla trindade','usuario/1785938348.png','carla.t@gmail.com','juridico','$2y$12$1Zd5p4Xr6TDHR8oDN3Mu8uGP6Iib4jY5D2aED4RY1hsYWCvGEhTV2',1,'palestrante','SP',NULL,NULL,'teste',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,'2026-08-05 13:59:08','2026-08-05 13:59:08','ATIVO');
/*!40000 ALTER TABLE `tbl_usuarios` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `tbl_videos`
--

DROP TABLE IF EXISTS `tbl_videos`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `tbl_videos` (
  `id_video` int NOT NULL AUTO_INCREMENT,
  `id_evento` int NOT NULL DEFAULT '1',
  `titulo_video` varchar(50) COLLATE utf8mb4_general_ci NOT NULL,
  `subtitulo_video` varchar(50) COLLATE utf8mb4_general_ci NOT NULL,
  `breve_descricao_video` varchar(80) COLLATE utf8mb4_general_ci NOT NULL,
  `url_video` varchar(255) COLLATE utf8mb4_general_ci NOT NULL,
  `status_video` varchar(10) COLLATE utf8mb4_general_ci NOT NULL,
  `legenda_video` varchar(100) COLLATE utf8mb4_general_ci NOT NULL,
  `capa_video` varchar(255) COLLATE utf8mb4_general_ci NOT NULL,
  `criado_em_video` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `atualizado_em_video` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id_video`),
  KEY `fk_video_eventos` (`id_evento`),
  CONSTRAINT `fk_video_eventos` FOREIGN KEY (`id_evento`) REFERENCES `tbl_eventos` (`id_evento`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `tbl_videos`
--

LOCK TABLES `tbl_videos` WRITE;
/*!40000 ALTER TABLE `tbl_videos` DISABLE KEYS */;
INSERT INTO `tbl_videos` VALUES (1,1,'Conduzida por quem vive a advocacia na práti','Uma imersão presencial, estratégica e exclusiva','Com método, clareza e direção estratégica Sem promessas vazias Sem atalhos irr','vide/videoconexao-360-2-edicao.mp4','ATIVO','Video Conexão 360º 2º edição','video/1789128352.png','2026-04-10 09:25:05','2026-09-11 12:05:52');
/*!40000 ALTER TABLE `tbl_videos` ENABLE KEYS */;
UNLOCK TABLES;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2026-09-18 12:04:51
