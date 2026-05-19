-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Tempo de geração: 19/05/2026 às 14:26
-- Versão do servidor: 10.4.32-MariaDB
-- Versão do PHP: 8.2.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Banco de dados: `db_conexao360`
--

-- --------------------------------------------------------

--
-- Estrutura para tabela `tbl_chats`
--

CREATE TABLE `tbl_chats` (
  `id_chat` int(11) NOT NULL,
  `id_usuario` int(11) NOT NULL,
  `mensagem_chat` text NOT NULL,
  `status_entregue_chat` varchar(10) NOT NULL,
  `status_remetente_chat` varchar(10) NOT NULL,
  `data_envio_chat` datetime NOT NULL,
  `data_receb_chat` datetime NOT NULL,
  `criado_em_chat` datetime NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Estrutura para tabela `tbl_conteudos`
--

CREATE TABLE `tbl_conteudos` (
  `id_conteudos` int(11) NOT NULL,
  `id_usuario` int(11) NOT NULL,
  `id_evento` int(11) NOT NULL,
  `titulo_conteudo` varchar(150) NOT NULL,
  `tipo_conteudo` varchar(10) NOT NULL,
  `descricao_conteudo` text NOT NULL,
  `liberado_em_conteudo` datetime NOT NULL,
  `url_conteudo` varchar(255) NOT NULL,
  `status_conteudo` varchar(10) NOT NULL,
  `criado_em_conteudo` datetime NOT NULL DEFAULT current_timestamp(),
  `atualizado_em_conteudo` datetime NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Estrutura para tabela `tbl_depoimentos`
--

CREATE TABLE `tbl_depoimentos` (
  `id_depoimentos` int(11) NOT NULL,
  `id_usuario` int(11) NOT NULL,
  `id_evento` int(11) NOT NULL,
  `status_depoimento` varchar(10) NOT NULL,
  `descricao_depoimento` text NOT NULL,
  `criado_em_depoimento` datetime NOT NULL DEFAULT current_timestamp(),
  `atualizado_em_depoimento` datetime NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Estrutura para tabela `tbl_dra`
--

CREATE TABLE `tbl_dra` (
  `id_dra` int(11) NOT NULL,
  `foto_dra` varchar(255) NOT NULL,
  `titulo_dra` varchar(100) NOT NULL,
  `sub_titulo_dra` varchar(100) NOT NULL,
  `descricao_dra` text NOT NULL,
  `status_dra` varchar(10) NOT NULL,
  `criado_em_dra` datetime NOT NULL DEFAULT current_timestamp(),
  `atualizado_em_dra` datetime NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Despejando dados para a tabela `tbl_dra`
--

INSERT INTO `tbl_dra` (`id_dra`, `foto_dra`, `titulo_dra`, `sub_titulo_dra`, `descricao_dra`, `status_dra`, `criado_em_dra`, `atualizado_em_dra`) VALUES
(1, 'dra/fotodra.png', 'Dra. Simone Baptista', 'Advogada | Mentora de Advogados | Idealizadora do Conexão 360', 'Eu escolhi a advocacia como missão. E escolhi ensinar porque sei o peso de carregar um sonho sozinha.\nMentoro advogados que decidiram parar de aceitar migalhas e passaram a construir uma carreira sólida, estratégica e sustentável — com postura, método e constância.\nNo Advocacia Exponencial Conexão 360, eu vou te conduzir numa virada de chave completa. Mente, posicionamento, comunicação e decisão. Você não sai igual. Você sai com clareza, com plano e com uma nova postura.\nEu sou advogada de sucesso. E eu ensino você a se tornar uma também.', 'ATIVO', '2026-05-04 11:45:20', '2026-05-04 11:45:20');

-- --------------------------------------------------------

--
-- Estrutura para tabela `tbl_enquetes`
--

CREATE TABLE `tbl_enquetes` (
  `id_enquete` int(11) NOT NULL,
  `pergunta_enquete` varchar(80) NOT NULL,
  `resposta_um_enquete` tinyint(4) DEFAULT NULL,
  `resposta_dois_enquete` tinyint(4) DEFAULT NULL,
  `resposta_tres_enquete` tinyint(4) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Estrutura para tabela `tbl_eventos`
--

CREATE TABLE `tbl_eventos` (
  `id_evento` int(11) NOT NULL,
  `banner_evento` varchar(255) NOT NULL,
  `titulo_evento` varchar(200) NOT NULL,
  `edicao_evento` int(11) NOT NULL,
  `descricao_evento` text NOT NULL,
  `data_inicial_evento` date NOT NULL,
  `hora_inicial_evento` time NOT NULL,
  `endereco_evento` varchar(80) NOT NULL,
  `url_evento` varchar(255) NOT NULL,
  `status_evento` varchar(10) NOT NULL,
  `criado_em_evento` datetime NOT NULL DEFAULT current_timestamp(),
  `atualizado_em_evento` datetime NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Estrutura para tabela `tbl_feeds`
--

CREATE TABLE `tbl_feeds` (
  `id_feeds` int(11) NOT NULL,
  `id_usuario` int(11) NOT NULL,
  `id_evento` int(11) NOT NULL,
  `curtidas_feed` int(11) DEFAULT NULL,
  `foto_feed` varchar(255) DEFAULT NULL,
  `comentario_feed` varchar(100) DEFAULT NULL,
  `status_feed` varchar(10) DEFAULT NULL,
  `criado_em_feed` datetime NOT NULL DEFAULT current_timestamp(),
  `atualizado_em_feed` datetime NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Estrutura para tabela `tbl_ingressos`
--

CREATE TABLE `tbl_ingressos` (
  `id_ingresso` int(11) NOT NULL,
  `id_usuario` int(11) NOT NULL,
  `id_evento` int(11) NOT NULL,
  `codigo_acesso_ingresso` varchar(255) NOT NULL,
  `status_ingresso` varchar(10) NOT NULL,
  `pagamento_compra_ingresso` datetime NOT NULL,
  `compra_em_ingresso` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Estrutura para tabela `tbl_palestras`
--

CREATE TABLE `tbl_palestras` (
  `id_palestra` int(11) NOT NULL,
  `id_usuario` int(11) NOT NULL,
  `id_evento` int(11) NOT NULL,
  `foto_palestra` varchar(80) NOT NULL,
  `titulo_palestra` varchar(200) NOT NULL,
  `video_palestra` varchar(255) NOT NULL,
  `status_palestra` varchar(10) NOT NULL,
  `criado_em_palestra` datetime NOT NULL DEFAULT current_timestamp(),
  `atualizado_em_palestra` datetime NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Estrutura para tabela `tbl_respostas`
--

CREATE TABLE `tbl_respostas` (
  `id_resposta` int(11) NOT NULL,
  `id_usuario` int(11) NOT NULL,
  `id_enquete` int(11) NOT NULL,
  `resposta_resposta` tinyint(4) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Estrutura para tabela `tbl_temas`
--

CREATE TABLE `tbl_temas` (
  `id_tema` int(11) NOT NULL,
  `titulo_tema` varchar(200) DEFAULT NULL,
  `subtitulo_tema` varchar(200) DEFAULT NULL,
  `breve_descricao_tema` varchar(80) NOT NULL,
  `foto_tema` varchar(255) NOT NULL,
  `status_tema` varchar(10) NOT NULL,
  `criado_em_tema` datetime NOT NULL DEFAULT current_timestamp(),
  `atualizado_em_tema` datetime NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Despejando dados para a tabela `tbl_temas`
--

INSERT INTO `tbl_temas` (`id_tema`, `titulo_tema`, `subtitulo_tema`, `breve_descricao_tema`, `foto_tema`, `status_tema`, `criado_em_tema`, `atualizado_em_tema`) VALUES
(1, 'Mentalidade Exponencial do Advogado de Alta Performance', 'Você vai entender por que esforço sem mentalidade trava resultados e como reprogramar decisões, coragem e posicionamento para crescer com estrátegia, autorirade e proposta.', 'Aqui, o advogado deixa de operar no automático e passa a jogar o jogo grande.', 'tema/foto-tema-mentalidade.png', 'ATIVO', '2026-05-04 11:54:55', '2026-05-05 08:48:10'),
(2, 'Atendimento Consultivo que Converte sem Pressão', 'Aprenda a conduzir atendimentos que geram confiança imediata, segurança jurídica e decisão consciente Sem implorar, sem convencer, sem desconto.', 'O cliente percebe valor antes mesmo de perguntar o preço.', 'tema/foto-tema-atendimento.png', 'ATIVO', '2026-05-04 11:57:31', '2026-05-05 08:49:11'),
(3, 'Posicionamento Estratégico para ser Lembrado e Indicado', 'Descubra como sair da guerra de preços, construir autoridade real e ser reconhecido pelo valor que entrega — mesmo que hoje você se sinta “mais um” no mercado.', 'Quem não se posiciona… é escolhido pelo menor preço.', 'tema/foto-tema-posicionamento.png', 'ATIVO', '2026-05-05 08:21:20', '2026-05-05 08:50:28'),
(4, 'Da conversa ao Contrato: O Método da Conversão Natural', 'Entenda o passo a passo que transforma conversas em contratos assinados, com ética, segurança e previsibilidade.', 'Advogado que entende valor nunca mais pede permissão para cobrar.', 'tema/foto-tema-conversa.png', 'ATIVO', '2026-05-05 08:22:37', '2026-05-05 08:51:07'),
(5, 'Precificação com Valor, Consciência e Autorirade', 'Aprenda a precificar sem medo, sustentar seus honorários com segurança e cobrar pelo impacto que você gera — não por hora trabalhada.', 'Advogado que entende valor nunca mais pede permissão para cobrar.', 'tema/foto-tema-precificacao.png', 'ATIVO', '2026-05-05 08:52:15', '2026-05-05 08:52:15');

-- --------------------------------------------------------

--
-- Estrutura para tabela `tbl_usuarios`
--

CREATE TABLE `tbl_usuarios` (
  `id_usuario` int(11) NOT NULL,
  `nome_usuario` varchar(100) NOT NULL,
  `foto_usuario` varchar(80) NOT NULL,
  `email_usuario` varchar(80) NOT NULL,
  `area_atuacao_usuario` varchar(150) NOT NULL,
  `senha_usuario` varchar(255) NOT NULL,
  `termos_usuario` tinyint(4) NOT NULL,
  `perfil_usuario` varchar(45) NOT NULL,
  `estado_usuario` varchar(2) NOT NULL,
  `conexoes_usuario` int(11) DEFAULT NULL,
  `comentario_usuario` varchar(200) DEFAULT NULL,
  `sobre_usuario` varchar(200) NOT NULL,
  `enquete_usuario` varchar(10) DEFAULT NULL,
  `curtidas_usuario` int(11) DEFAULT NULL,
  `criado_em_usuario` datetime NOT NULL DEFAULT current_timestamp(),
  `atualizado_em_usuario` datetime NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Despejando dados para a tabela `tbl_usuarios`
--

INSERT INTO `tbl_usuarios` (`id_usuario`, `nome_usuario`, `foto_usuario`, `email_usuario`, `area_atuacao_usuario`, `senha_usuario`, `termos_usuario`, `perfil_usuario`, `estado_usuario`, `conexoes_usuario`, `comentario_usuario`, `sobre_usuario`, `enquete_usuario`, `curtidas_usuario`, `criado_em_usuario`, `atualizado_em_usuario`) VALUES
(1, 'Alan Trabalhista', 'usuario/alan-trabalhista.png', 'alan.t@gmail.com', 'Trabalhista', 'teste1234', 1, 'palestrante', 'SP', NULL, NULL, 'Advogado com atuação na área trabalhista', NULL, NULL, '2026-04-07 09:22:44', '2026-04-07 09:22:44'),
(2, 'Armado Batista', 'usuario/armado-batista.pgn', 'armado.b@gmail.com', 'Criminal', 'teste1234', 1, 'palestrante', 'RJ', NULL, NULL, 'Advogado com atuação na área criminal', NULL, NULL, '2026-04-10 08:51:01', '2026-04-10 08:51:01'),
(3, 'João Camisa', 'usuario/joao-camisa.pgn', 'joao.c@gmail.com', 'Consumidor', 'teste1234', 1, 'usuario', 'MG', NULL, NULL, 'Advogado com atuação na área do consumidor', NULL, NULL, '2026-04-10 08:59:05', '2026-04-10 08:59:05'),
(4, 'Simone Batista', 'usuario/simone-batista.png', 'simone.b@gmail.com', 'Previdenciário', 'teste1234', 1, 'administrador', 'SP', NULL, NULL, ' Especialista em Direito Previdenciário (INSS), com foco em aposentadorias (tempo de contribuição, idade, especial) e revisões, além de experiência na área da saúde.', NULL, NULL, '2026-05-08 11:44:28', '2026-05-08 11:44:28');

-- --------------------------------------------------------

--
-- Estrutura para tabela `tbl_videos`
--

CREATE TABLE `tbl_videos` (
  `id_video` int(11) NOT NULL,
  `titulo_video` varchar(50) NOT NULL,
  `subtitulo_video` varchar(50) NOT NULL,
  `breve_descricao_video` varchar(80) NOT NULL,
  `url_video` varchar(255) NOT NULL,
  `status_video` varchar(10) NOT NULL,
  `legenda_video` varchar(100) NOT NULL,
  `capa_video` varchar(255) NOT NULL,
  `criado_em_video` datetime NOT NULL DEFAULT current_timestamp(),
  `atualizado_em_video` datetime NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Despejando dados para a tabela `tbl_videos`
--

INSERT INTO `tbl_videos` (`id_video`, `titulo_video`, `subtitulo_video`, `breve_descricao_video`, `url_video`, `status_video`, `legenda_video`, `capa_video`, `criado_em_video`, `atualizado_em_video`) VALUES
(1, 'Conduzida por quem vive a advocacia na prática', 'Uma imersão presencial, estratégica e exclusiva pa', 'Com método, clareza e direção estratégica Sem promessas vazias Sem atalhos irrea', 'video/videoconexao-360-2-edicao', 'ATIVO', ' Video Conexão 360º 2º edição ', 'video/capa-video.png', '2026-04-10 09:25:05', '2026-04-10 09:25:05');

--
-- Índices para tabelas despejadas
--

--
-- Índices de tabela `tbl_chats`
--
ALTER TABLE `tbl_chats`
  ADD PRIMARY KEY (`id_chat`);

--
-- Índices de tabela `tbl_conteudos`
--
ALTER TABLE `tbl_conteudos`
  ADD PRIMARY KEY (`id_conteudos`);

--
-- Índices de tabela `tbl_depoimentos`
--
ALTER TABLE `tbl_depoimentos`
  ADD PRIMARY KEY (`id_depoimentos`);

--
-- Índices de tabela `tbl_dra`
--
ALTER TABLE `tbl_dra`
  ADD PRIMARY KEY (`id_dra`);

--
-- Índices de tabela `tbl_enquetes`
--
ALTER TABLE `tbl_enquetes`
  ADD PRIMARY KEY (`id_enquete`);

--
-- Índices de tabela `tbl_eventos`
--
ALTER TABLE `tbl_eventos`
  ADD PRIMARY KEY (`id_evento`);

--
-- Índices de tabela `tbl_feeds`
--
ALTER TABLE `tbl_feeds`
  ADD PRIMARY KEY (`id_feeds`);

--
-- Índices de tabela `tbl_ingressos`
--
ALTER TABLE `tbl_ingressos`
  ADD PRIMARY KEY (`id_ingresso`);

--
-- Índices de tabela `tbl_palestras`
--
ALTER TABLE `tbl_palestras`
  ADD PRIMARY KEY (`id_palestra`);

--
-- Índices de tabela `tbl_respostas`
--
ALTER TABLE `tbl_respostas`
  ADD PRIMARY KEY (`id_resposta`);

--
-- Índices de tabela `tbl_temas`
--
ALTER TABLE `tbl_temas`
  ADD PRIMARY KEY (`id_tema`);

--
-- Índices de tabela `tbl_usuarios`
--
ALTER TABLE `tbl_usuarios`
  ADD PRIMARY KEY (`id_usuario`);

--
-- Índices de tabela `tbl_videos`
--
ALTER TABLE `tbl_videos`
  ADD PRIMARY KEY (`id_video`);

--
-- AUTO_INCREMENT para tabelas despejadas
--

--
-- AUTO_INCREMENT de tabela `tbl_chats`
--
ALTER TABLE `tbl_chats`
  MODIFY `id_chat` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de tabela `tbl_conteudos`
--
ALTER TABLE `tbl_conteudos`
  MODIFY `id_conteudos` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de tabela `tbl_depoimentos`
--
ALTER TABLE `tbl_depoimentos`
  MODIFY `id_depoimentos` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de tabela `tbl_dra`
--
ALTER TABLE `tbl_dra`
  MODIFY `id_dra` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT de tabela `tbl_enquetes`
--
ALTER TABLE `tbl_enquetes`
  MODIFY `id_enquete` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de tabela `tbl_eventos`
--
ALTER TABLE `tbl_eventos`
  MODIFY `id_evento` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de tabela `tbl_feeds`
--
ALTER TABLE `tbl_feeds`
  MODIFY `id_feeds` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de tabela `tbl_ingressos`
--
ALTER TABLE `tbl_ingressos`
  MODIFY `id_ingresso` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de tabela `tbl_palestras`
--
ALTER TABLE `tbl_palestras`
  MODIFY `id_palestra` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de tabela `tbl_respostas`
--
ALTER TABLE `tbl_respostas`
  MODIFY `id_resposta` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de tabela `tbl_temas`
--
ALTER TABLE `tbl_temas`
  MODIFY `id_tema` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT de tabela `tbl_usuarios`
--
ALTER TABLE `tbl_usuarios`
  MODIFY `id_usuario` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT de tabela `tbl_videos`
--
ALTER TABLE `tbl_videos`
  MODIFY `id_video` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
