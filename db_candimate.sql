

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";



CREATE DATABASE db_candimate;
USE db_candimate;



--

-- --------------------------------------------------------

--
-- Structure de la table `cover_letter`
--

DROP TABLE IF EXISTS `cover_letter`;
CREATE TABLE IF NOT EXISTS `cover_letter` (
  `id` int NOT NULL AUTO_INCREMENT,
  `job_offer_id` int DEFAULT NULL,
  `app_user_id` int DEFAULT NULL,
  `content` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` datetime NOT NULL COMMENT '(DC2Type:datetime_immutable)',
  `updated_at` datetime NOT NULL COMMENT '(DC2Type:datetime_immutable)',
  PRIMARY KEY (`id`),
  KEY `IDX_EBE6B473481D195` (`job_offer_id`),
  KEY `IDX_EBE6B474A3353D8` (`app_user_id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Déchargement des données de la table `cover_letter`
--


INSERT INTO `cover_letter` (`id`, `job_offer_id`, `app_user_id`, `content`, `created_at`, `updated_at`) VALUES
(1, 5, 1, '<br>\nCher/Chère Responsable du recrutement,<br>\n<br>\nJe vous écris pour exprimer mon vif intérêt pour le poste de Développeur Android au sein de votre prestigieuse entreprise, Delta.<br>\n<br>\nEn tant que développeur Android chevronné avec plus de [Nombre] années d\'expérience, je suis convaincu de posséder les compétences et l\'expertise nécessaires pour exceller dans ce rôle.<br>\n<br>\nTout au long de ma carrière, j\'ai acquis une solide maîtrise des technologies Android, notamment Java, Kotlin, Android Studio et le SDK Android.<br>\n<br>\nJe suis également très compétent dans la conception et le développement d\'applications Android intuitives, réactives et conviviales.<br>\n<br>\nMon expérience comprend le développement d\'applications pour divers secteurs, notamment la finance, la santé et le commerce électronique.<br>\n<br>\nJe suis particulièrement fier de mon travail sur l\'application [Nom de l\'application], qui a remporté le prix [Nom du prix]. Cette application a utilisé des technologies Android innovantes pour fournir une expérience utilisateur exceptionnelle et a considérablement augmenté l\'engagement des utilisateurs.<br>\n<br>\nAu-delà de mes compétences techniques, je suis un travailleur acharné, motivé et orienté résultats.<br>\n<br>\nJe suis également un excellent joueur d\'équipe et je suis capable de travailler de manière autonome ou en collaboration avec d\'autres membres de l\'équipe.<br>\n<br>\nJe suis convaincu que mes compétences et mon expérience contribueraient grandement à l\'équipe de développement Android de Delta.<br>\n<br>\nJe serais ravi d\'avoir l\'opportunité de discuter plus en détail de mes qualifications et de la façon dont je peux apporter de la valeur à votre entreprise.<br>\n<br>\nMerci de votre temps et de votre attention.<br>\n<br>\nSincères salutations,<br>\n<br>\n[Votre nom complet]', '2024-10-07 16:11:31', '2024-10-07 16:11:31'),
(2, 6, 2, '<br>\nCher/Chère Responsable du recrutement,<br>\n<br>\nJe vous adresse ma candidature pour le poste de Développeur Java au sein de votre entreprise, Orange.<br>\n<br>\nAvec une solide expérience en développement Java et en architecture de systèmes, je suis convaincu que mes compétences techniques et ma passion pour l\'innovation seraient des atouts précieux pour votre équipe.<br>\n<br>\nJe maîtrise les frameworks Java, Spring, Hibernate, et j\'ai une grande expérience en gestion des bases de données SQL et NoSQL.<br>\n<br>\nMon objectif est de contribuer à l\'évolution et à la performance de vos projets en utilisant les meilleures pratiques de développement.<br>\n<br>\nJe serais ravi de discuter de ma candidature plus en détail.<br>\n<br>\nCordialement,<br>\n<br>\n[Votre nom complet]', '2024-10-07 16:12:45', '2024-10-07 16:12:45'),
(3, 7, 3, '<br>\nMadame, Monsieur,<br>\n<br>\nJe vous écris pour postuler au poste de Développeur Front-End chez Capgemini à Lyon.<br>\n<br>\nJe suis passionné par la conception d\'interfaces web modernes et conviviales, et j\'ai plusieurs années d\'expérience dans le développement de sites web interactifs utilisant HTML5, CSS3, JavaScript, et React.<br>\n<br>\nJe suis persuadé que mes compétences techniques, associées à ma capacité à travailler en équipe, me permettraient de contribuer efficacement à vos projets.<br>\n<br>\nJe serais heureux de pouvoir échanger davantage sur ma candidature.<br>\n<br>\nBien à vous,<br>\n<br>\n[Votre nom complet]', '2024-10-07 16:14:00', '2024-10-07 16:14:00'),
(4, 8, 4, '<br>\nMadame, Monsieur,<br>\n<br>\nJe vous présente ma candidature pour le poste de Développeur Fullstack au sein de votre entreprise Accenture à Bordeaux.<br>\n<br>\nFort d\'une expérience de plusieurs années en développement web et mobile, je maîtrise un large éventail de technologies telles que JavaScript, Node.js, Angular, et MongoDB.<br>\n<br>\nJe suis convaincu que ma polyvalence technique et ma capacité à travailler dans un environnement agile seraient des atouts précieux pour votre équipe.<br>\n<br>\nDans l\'attente de pouvoir échanger avec vous,<br>\n<br>\nSincèrement,<br>\n<br>\n[Votre nom complet]', '2024-10-07 16:15:30', '2024-10-07 16:15:30'),
(5, 9, 5, '<br>\nCher/Chère Responsable du recrutement,<br>\n<br>\nJe vous soumets ma candidature pour le poste d\'Ingénieur DevOps au sein de Sopra Steria à Toulouse.<br>\n<br>\nJe possède une solide expertise dans le domaine de la gestion des infrastructures et des outils d\'automatisation. J\'ai travaillé sur des projets complexes en utilisant Docker, Kubernetes, et Jenkins.<br>\n<br>\nMon objectif est de participer activement à l\'optimisation et à l\'automatisation de vos processus de développement.<br>\n<br>\nJe serais heureux d\'avoir l\'opportunité de discuter plus en détail de mes compétences.<br>\n<br>\nCordialement,<br>\n<br>\n[Votre nom complet]', '2024-10-07 16:16:45', '2024-10-07 16:16:45'),
(6, 10, 6, '<br>\nMadame, Monsieur,<br>\n<br>\nJe vous adresse ma candidature pour le poste de Data Scientist au sein d\'Altran à Nantes.<br>\n<br>\nAyant obtenu un master en sciences des données et une expérience dans le traitement de grandes quantités de données, je suis certain que je pourrais contribuer de manière significative à vos projets d\'analyse de données et d\'intelligence artificielle.<br>\n<br>\nJe maîtrise Python, R, et SQL, et je suis familiarisé avec les outils de big data comme Hadoop et Spark.<br>\n<br>\nDans l\'attente de vous rencontrer pour discuter de ma candidature,<br>\n<br>\nCordialement,<br>\n<br>\n[Votre nom complet]', '2024-10-07 16:17:00', '2024-10-07 16:17:00'),
(7, 11, 7, '<br>\nMadame, Monsieur,<br>\n<br>\nJe vous présente ma candidature pour le poste de Développeur Python au sein de Dassault à Nice.<br>\n<br>\nAvec une solide expérience en développement Python et une expertise en analyse de données, je suis convaincu que je serais un atout précieux pour votre équipe.<br>\n<br>\nJe maîtrise les bibliothèques Python populaires comme Pandas, NumPy, ainsi que les outils de data visualization comme Matplotlib et Seaborn.<br>\n<br>\nJe serais ravi de discuter plus en détail de mes qualifications avec vous.<br>\n<br>\nSincèrement,<br>\n<br>\n[Votre nom complet]', '2024-10-07 16:18:15', '2024-10-07 16:18:15'),
(8, 12, 8, '<br>\nCher/Chère Responsable,<br>\n<br>\nJe vous écris pour vous faire part de mon intérêt pour le poste d\'Ingénieur QA chez Atos à Marseille.<br>\n<br>\nJ\'ai une solide expérience en test logiciel et en assurance qualité. Je maîtrise les outils d\'automatisation de tests et les méthodes de tests fonctionnels et unitaires.<br>\n<br>\nJe serais ravi de contribuer à l\'amélioration de la qualité des logiciels développés par votre équipe.<br>\n<br>\nDans l\'attente de votre réponse,<br>\n<br>\nCordialement,<br>\n<br>\n[Votre nom complet]', '2024-10-07 16:19:30', '2024-10-07 16:19:30'),
(9, 13, 9, '<br>\nMadame, Monsieur,<br>\n<br>\nJe vous écris pour postuler au poste de Développeur Mobile chez KPMG à Lille.<br>\n<br>\nPassionné par le développement mobile, j\'ai une vaste expérience dans la création d\'applications mobiles natives et hybrides.<br>\n<br>\nJe suis particulièrement intéressé par la perspective de rejoindre votre équipe et de travailler sur des projets innovants.<br>\n<br>\nJe serais heureux de discuter de mes qualifications lors d\'un entretien.<br>\n<br>\nBien à vous,<br>\n<br>\n[Votre nom complet]', '2024-10-07 16:20:45', '2024-10-07 16:20:45'),
(10, 14, 10, '<br>\nCher/Chère Responsable du recrutement,<br>\n<br>\nJe vous adresse ma candidature pour le poste de Développeur Ruby chez Pivotal à Paris.<br>\n<br>\nJe suis un développeur Ruby expérimenté, avec une expertise approfondie dans le développement d\'applications backend performantes et évolutives.<br>\n<br>\nJe maîtrise les frameworks Ruby on Rails et Sinatra et j\'ai travaillé sur des projets d\'envergure dans des environnements Agile.<br>\n<br>\nJe serais ravi de discuter plus en détail de ma candidature avec vous.<br>\n<br>\nCordialement,<br>\n<br>\n[Votre nom complet]', '2024-10-07 16:22:00', '2024-10-07 16:22:00');


-- --------------------------------------------------------

--
-- Structure de la table `doctrine_migration_versions`
--



--
-- Déchargement des données de la table `doctrine_migration_versions`
--


-- --------------------------------------------------------

--
-- Structure de la table `job_offer`
--

DROP TABLE IF EXISTS `job_offer`;
CREATE TABLE IF NOT EXISTS `job_offer` (
  `id` int NOT NULL AUTO_INCREMENT,
  `app_user_id` int DEFAULT NULL,
  `title` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `company` varchar(150) COLLATE utf8mb4_unicode_ci NOT NULL,
  `link` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `location` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `salary` varchar(50) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `contact_person` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `contact_email` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `application_date` date NOT NULL,
  `status` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` datetime NOT NULL COMMENT '(DC2Type:datetime_immutable)',
  `updated_at` datetime NOT NULL COMMENT '(DC2Type:datetime_immutable)',
  PRIMARY KEY (`id`),
  KEY `IDX_288A3A4E4A3353D8` (`app_user_id`)
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Déchargement des données de la table `job_offer`
--

INSERT INTO `job_offer` (`id`, `app_user_id`, `title`, `company`, `link`, `location`, `salary`, `contact_person`, `contact_email`, `application_date`, `status`, `created_at`, `updated_at`) VALUES
(1, 1, 'Développeur Informatique Industrielle H/F', 'SPIE Industrie', 'Le Rheu - 35', 'Le Rheu - 35', '1425', 'devim', 'devim@gmail.com', '2024-10-08', 'A postuler', '2024-10-07 14:24:02', '2024-10-07 14:31:07'),
(2, 1, 'Développeur PHP - Symfony H/F', 'Groupe VILAVI', 'La Chapelle-sur-Erdre - 44', 'La Chapelle-sur-Erdre - 44', '4512', 'tashi', 'tashi@gmail.com', '2024-10-17', 'Entretien', '2024-10-07 14:25:06', '2024-10-07 14:31:15'),
(3, 1, 'Le poste de Développeur SAP F/H', 'le postes', 'Rueil-Malmaison (92)', 'Rueil-Malmaison (92)', '5647', 'roman', 'roman@gmail.com', '2024-10-26', 'En attente', '2024-10-07 14:26:13', '2024-10-07 16:13:15'),
(4, 1, 'Développeur C#', 'Dualis', 'Perpignan', 'Perpignan', '5648', 'C sharp', 'c@email.com', '2024-10-24', 'Refusé', '2024-10-07 14:28:39', '2024-10-07 14:28:39'),
(5, 1, 'Développeur Android', 'dleta', 'paris', 'paris', '8545', 'paris', 'paris@gmail.com', '2024-10-26', 'Accepté', '2024-10-07 14:29:20', '2024-10-07 14:29:20'),
(6, 1, 'Développeur Java H/F', 'Orange', 'Paris', 'Paris', '3500', 'charles', 'charles@gmail.com', '2024-11-01', 'A postuler', '2024-10-07 14:35:00', '2024-10-07 14:35:00'),
(7, 2, 'Développeur Front-End', 'Capgemini', 'Lyon', 'Lyon', '3900', 'lucas', 'lucas@gmail.com', '2024-11-10', 'Entretien', '2024-10-07 14:36:20', '2024-10-07 14:36:20'),
(8, 3, 'Développeur Fullstack', 'Accenture', 'Bordeaux', 'Bordeaux', '4700', 'martin', 'martin@gmail.com', '2024-11-15', 'En attente', '2024-10-07 14:37:45', '2024-10-07 14:37:45'),
(9, 4, 'Ingénieur DevOps', 'Sopra Steria', 'Toulouse', 'Toulouse', '5000', 'nicolas', 'nicolas@gmail.com', '2024-11-20', 'Refusé', '2024-10-07 14:38:00', '2024-10-07 14:38:00'),
(10, 5, 'Data Scientist', 'Altran', 'Nantes', 'Nantes', '5100', 'lucie', 'lucie@gmail.com', '2024-11-25', 'Accepté', '2024-10-07 14:39:10', '2024-10-07 14:39:10'),
(11, 6, 'Développeur Python', 'Dassault', 'Nice', 'Nice', '4600', 'sebastien', 'sebastien@gmail.com', '2024-11-30', 'A postuler', '2024-10-07 14:40:30', '2024-10-07 14:40:30'),
(12, 7, 'Ingénieur QA', 'Atos', 'Marseille', 'Marseille', '4000', 'vincent', 'vincent@gmail.com', '2024-12-05', 'Entretien', '2024-10-07 14:42:00', '2024-10-07 14:42:00'),
(13, 8, 'Développeur Mobile', 'KPMG', 'Lille', 'Lille', '4200', 'caroline', 'caroline@gmail.com', '2024-12-10', 'En attente', '2024-10-07 14:43:30', '2024-10-07 14:43:30'),
(14, 9, 'Développeur Ruby', 'Pivotal', 'Paris', 'Paris', '4800', 'hugo', 'hugo@gmail.com', '2024-12-15', 'Refusé', '2024-10-07 14:45:00', '2024-10-07 14:45:00'),
(15, 10, 'Développeur JavaScript', 'SAP', 'Rennes', 'Rennes', '4700', 'marion', 'marion@gmail.com', '2024-12-20', 'Accepté', '2024-10-07 14:46:00', '2024-10-07 14:46:00'),
(16, 11, 'Analyste Data', 'BNP Paribas', 'Paris', 'Paris', '4900', 'guillaume', 'guillaume@gmail.com', '2024-12-25', 'A postuler', '2024-10-07 14:47:30', '2024-10-07 14:47:30'),
(17, 12, 'Développeur C++', 'Esker', 'Lyon', 'Lyon', '5100', 'celine', 'celine@gmail.com', '2025-01-05', 'Entretien', '2024-10-07 14:48:40', '2024-10-07 14:48:40'),
(18, 13, 'Architecte Cloud', 'IBM', 'Bordeaux', 'Bordeaux', '5300', 'florence', 'florence@gmail.com', '2025-01-10', 'En attente', '2024-10-07 14:50:10', '2024-10-07 14:50:10'),
(19, 14, 'Développeur Go', 'Microsoft', 'Paris', 'Paris', '5500', 'mathieu', 'mathieu@gmail.com', '2025-01-15', 'Refusé', '2024-10-07 14:51:30', '2024-10-07 14:51:30'),
(20, 15, 'Ingénieur AI', 'Google', 'Toulouse', 'Toulouse', '5800', 'jean', 'jean@gmail.com', '2025-01-20', 'Accepté', '2024-10-07 14:53:00', '2024-10-07 14:53:00'),
(21, 16, 'Développeur SQL', 'Orange Business', 'Paris', 'Paris', '4200', 'emily', 'emily@gmail.com', '2025-01-25', 'A postuler', '2024-10-07 14:54:10', '2024-10-07 14:54:10'),
(22, 17, 'Consultant DevOps', 'IBM', 'Nantes', 'Nantes', '4600', 'alexandre', 'alexandre@gmail.com', '2025-01-30', 'Entretien', '2024-10-07 14:55:00', '2024-10-07 14:55:00'),
(23, 18, 'Développeur Machine Learning', 'Capgemini', 'Lyon', 'Lyon', '5200', 'sarah', 'sarah@gmail.com', '2025-02-10', 'En attente', '2024-10-07 14:56:30', '2024-10-07 14:56:30'),
(24, 19, 'Développeur Node.js', 'Accenture', 'Toulouse', 'Toulouse', '5300', 'paul', 'paul@gmail.com', '2025-02-15', 'Refusé', '2024-10-07 14:57:10', '2024-10-07 14:57:10'),
(25, 20, 'Développeur React.js', 'Sopra Steria', 'Marseille', 'Marseille', '5400', 'victor', 'victor@gmail.com', '2025-02-20', 'Accepté', '2024-10-07 14:58:30', '2024-10-07 14:58:30');



-- --------------------------------------------------------

--
-- Structure de la table `linked_in_message`
--

DROP TABLE IF EXISTS `linked_in_message`;
CREATE TABLE IF NOT EXISTS `linked_in_message` (
  `id` int NOT NULL AUTO_INCREMENT,
  `job_offer_id` int DEFAULT NULL,
  `app_user_id` int DEFAULT NULL,
  `content` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` datetime NOT NULL COMMENT '(DC2Type:datetime_immutable)',
  `updated_at` datetime NOT NULL COMMENT '(DC2Type:datetime_immutable)',
  PRIMARY KEY (`id`),
  KEY `IDX_6ACAC8D63481D195` (`job_offer_id`),
  KEY `IDX_6ACAC8D64A3353D8` (`app_user_id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;



INSERT INTO `linked_in_message` (`id`, `job_offer_id`, `app_user_id`, `content`, `created_at`, `updated_at`) VALUES
(1, 5, 1, 'Bonjour l\'équipe Delta,<br><br>\n\nJe vous écris pour exprimer mon vif intérêt pour le poste de Développeur Android actuellement vacant au sein de votre entreprise.<br><br>\n\nEn tant que développeur Android expérimenté, j\'ai acquis une solide expertise dans la conception, le développement et la maintenance d\'applications Android de haute qualité.<br><br>\n\nJe maîtrise parfaitement les technologies Android fondamentales, notamment Java, Kotlin et les frameworks tels que AndroidX et Jetpack.<br><br>\n\nMes compétences techniques comprennent également :<br><br>\n\n* Conception de l\'interface utilisateur (UI) et expérience utilisateur (UX)<br>\n* Intégration de l\'API et des services Web<br>\n* Debugging et résolution de problèmes<br><br>\n\nJe suis passionné par la création d\'applications innovantes et conviviales qui répondent aux besoins des utilisateurs. Je suis également un fervent partisan des méthodologies agiles et possède une excellente éthique de travail en équipe.<br><br>\n\nJe suis impatient de mettre mes compétences et mon expérience au service de Delta et de contribuer au succès continu de votre entreprise.<br><br>\n\nJe suis disponible pour un entretien à votre convenance.<br><br>\n\nMerci de votre temps et de votre attention.<br><br>\n\nSincèrement,<br>\nAdmin Admin', '2024-10-07 16:12:01', '2024-10-07 16:12:01'),
(2, 6, 2, 'Bonjour l\'équipe Orange,<br><br>\n\nJe vous écris pour exprimer mon intérêt pour le poste de Développeur Java au sein de votre entreprise.<br><br>\n\nAvec une solide expérience en développement Java, je suis convaincu que mes compétences en conception d\'applications robustes et évolutives pourraient être un atout pour votre équipe.<br><br>\n\nJe maîtrise des technologies telles que Spring, Hibernate, et JPA, et je possède une bonne expérience dans la gestion des bases de données relationnelles et NoSQL.<br><br>\n\nJe suis également familiarisé avec les pratiques agiles et j\'ai une grande capacité à travailler en équipe.<br><br>\n\nJe serais ravi de discuter plus en détail de mes qualifications.<br><br>\n\nMerci de votre attention.<br><br>\n\nCordialement,<br>\nLucas Dupont', '2024-10-07 16:15:00', '2024-10-07 16:15:00'),
(3, 7, 3, 'Bonjour l\'équipe Capgemini,<br><br>\n\nJe me permets de vous écrire pour vous faire part de mon intérêt pour le poste de Développeur Front-End.<br><br>\n\nPassionné par la conception d\'interfaces utilisateur modernes et réactives, j\'ai une expérience approfondie avec HTML5, CSS3, JavaScript et les frameworks comme React.js.<br><br>\n\nJe suis particulièrement intéressé par l\'opportunité de rejoindre votre équipe et de contribuer à la réalisation de projets innovants.<br><br>\n\nJe serais ravi de discuter plus en détail de mes qualifications.<br><br>\n\nCordialement,<br>\nMartin Dupuis', '2024-10-07 16:17:30', '2024-10-07 16:17:30'),
(4, 8, 4, 'Bonjour l\'équipe Accenture,<br><br>\n\nJe vous adresse ma candidature pour le poste de Développeur Fullstack.<br><br>\n\nJe possède une expérience diversifiée dans le développement web, avec des compétences solides en JavaScript, Node.js, et React.js. Je suis également à l\'aise avec les bases de données SQL et NoSQL.<br><br>\n\nMon expertise en développement de solutions fullstack me permet d\'intervenir à tous les niveaux des projets et de contribuer efficacement aux objectifs de l\'équipe.<br><br>\n\nJe serais ravi de vous rencontrer pour échanger sur cette opportunité.<br><br>\n\nCordialement,<br>\nAlice Moreau', '2024-10-07 16:19:00', '2024-10-07 16:19:00'),
(5, 9, 5, 'Bonjour l\'équipe Sopra Steria,<br><br>\n\nJe vous adresse cette candidature pour le poste d\'Ingénieur DevOps.<br><br>\n\nAyant une expérience significative en gestion d\'infrastructures et en automatisation des processus avec des outils comme Docker, Kubernetes, Jenkins, je suis convaincu de pouvoir apporter une réelle valeur ajoutée à votre équipe.<br><br>\n\nJe suis passionné par l\'optimisation des workflows de développement et l\'amélioration de l\'efficacité des processus de livraison.<br><br>\n\nDans l\'attente d\'une rencontre,<br><br>\n\nCordialement,<br>\nPierre Lemoine', '2024-10-07 16:21:00', '2024-10-07 16:21:00'),
(6, 10, 6, 'Bonjour l\'équipe Altran,<br><br>\n\nJe vous écris pour postuler au poste de Data Scientist.<br><br>\n\nTitulaire d\'un master en sciences des données, j\'ai travaillé sur plusieurs projets d\'analyse de données complexes, utilisant Python, R, et des outils comme TensorFlow et Spark.<br><br>\n\nJe suis passionné par l\'extraction de connaissances à partir de données massives et par l\'application de l\'intelligence artificielle pour résoudre des problèmes complexes.<br><br>\n\nJe serais ravi de discuter plus en détail de cette opportunité.<br><br>\n\nCordialement,<br>\nJulie Martin', '2024-10-07 16:23:30', '2024-10-07 16:23:30'),
(7, 11, 7, 'Bonjour l\'équipe Dassault,<br><br>\n\nJe vous écris pour postuler au poste de Développeur Python.<br><br>\n\nAvec plusieurs années d\'expérience en développement Python et dans le domaine de l\'analyse de données, je suis convaincu de pouvoir contribuer à vos projets techniques.<br><br>\n\nJe maîtrise les bibliothèques Python comme Pandas et NumPy, et je suis expérimenté dans l\'automatisation des processus à grande échelle.<br><br>\n\nDans l\'attente de votre retour,<br><br>\n\nCordialement,<br>\nSamuel Perrier', '2024-10-07 16:25:00', '2024-10-07 16:25:00'),
(8, 12, 8, 'Bonjour l\'équipe Atos,<br><br>\n\nJe vous contacte pour exprimer mon intérêt pour le poste d\'Ingénieur QA.<br><br>\n\nJ\'ai une solide expérience en tests logiciels et automatisation des tests, ainsi qu\'une bonne maîtrise des outils comme Selenium, JUnit et TestNG.<br><br>\n\nJe suis convaincu que mon expertise technique et ma capacité à résoudre des problèmes complexes seraient des atouts précieux pour vos projets.<br><br>\n\nJe suis disponible pour échanger davantage sur mes qualifications.<br><br>\n\nCordialement,<br>\nSophie Girard', '2024-10-07 16:27:30', '2024-10-07 16:27:30'),
(9, 13, 9, 'Bonjour l\'équipe KPMG,<br><br>\n\nJe vous adresse ma candidature pour le poste de Développeur Mobile.<br><br>\n\nFort d\'une expérience dans le développement d\'applications mobiles, je suis à l\'aise avec les technologies iOS et Android ainsi que le framework Flutter pour le développement multiplateforme.<br><br>\n\nJe serais ravi de contribuer à l\'élargissement de votre portefeuille d\'applications mobiles.<br><br>\n\nCordialement,<br>\nMaxime Bernard', '2024-10-07 16:29:00', '2024-10-07 16:29:00'),
(10, 14, 10, 'Bonjour l\'équipe Pivotal,<br><br>\n\nJe vous écris pour exprimer mon intérêt pour le poste de Développeur Ruby.<br><br>\n\nJe suis un développeur Ruby avec plusieurs années d\'expérience dans la conception d\'applications backend performantes en utilisant Ruby on Rails et Sinatra.<br><br>\n\nJe suis particulièrement intéressé par cette opportunité et serais heureux d\'en discuter davantage avec vous.<br><br>\n\nCordialement,<br>\nVictor Lefevre', '2024-10-07 16:30:30', '2024-10-07 16:30:30'),
(11, 15, 11, 'Bonjour l\'équipe Google,<br><br>\n\nJe vous écris pour vous faire part de mon intérêt pour le poste de Développeur Front-End.<br><br>\n\nJe suis passionné par le développement web et j\'ai une forte expérience dans l\'utilisation de JavaScript, HTML, CSS et React.js pour construire des interfaces utilisateurs intuitives et performantes.<br><br>\n\nJe serais ravi d\'avoir l\'opportunité de discuter avec vous de ma candidature.<br><br>\n\nCordialement,<br>\nJulien Roy', '2024-10-07 16:32:00', '2024-10-07 16:32:00'),
(12, 16, 12, 'Bonjour l\'équipe Microsoft,<br><br>\n\nJe vous contacte pour postuler au poste de Développeur C#.<br><br>\n\nAvec une solide expérience en développement C#, ainsi que dans l\'utilisation de .NET Core et de SQL Server, je suis persuadé que je peux apporter une réelle valeur ajoutée à vos projets.<br><br>\n\nJe serais ravi de pouvoir échanger avec vous sur mes qualifications.<br><br>\n\nCordialement,<br>\nNicolas Bellamy', '2024-10-07 16:34:00', '2024-10-07 16:34:00'),
(13, 17, 13, 'Bonjour l\'équipe IBM,<br><br>\n\nJe vous écris pour vous faire part de mon intérêt pour le poste d\'Ingénieur DevOps.<br><br>\n\nJe possède une expertise en gestion des infrastructures et en automatisation des processus avec Docker et Kubernetes.<br><br>\n\nJe suis convaincu que je pourrais contribuer à vos projets en garantissant une gestion fluide des pipelines CI/CD.<br><br>\n\nJe reste à votre disposition pour tout entretien.<br><br>\n\nCordialement,<br>\nElise Morel', '2024-10-07 16:35:30', '2024-10-07 16:35:30'),
(14, 18, 14, 'Bonjour l\'équipe Tesla,<br><br>\n\nJe vous adresse ma candidature pour le poste de Développeur Python.<br><br>\n\nJe suis un développeur Python passionné par les nouvelles technologies et l\'automatisation. J\'ai une solide expérience avec Django, Flask et des bases de données SQL et NoSQL.<br><br>\n\nJe serais ravi d\'échanger avec vous pour discuter plus en détail de ma candidature.<br><br>\n\nCordialement,<br>\nFrançois Leclerc', '2024-10-07 16:37:00', '2024-10-07 16:37:00'),
(15, 19, 15, 'Bonjour l\'équipe SAP,<br><br>\n\nJe vous contacte pour exprimer mon intérêt pour le poste de Développeur Java.<br><br>\n\nJe suis un développeur Java expérimenté, avec une expertise en Spring Boot, Hibernate et Microservices.<br><br>\n\nJe suis convaincu que mes compétences techniques et mon approche axée sur la qualité me permettront de contribuer efficacement à vos projets.<br><br>\n\nDans l\'attente de vous rencontrer,<br><br>\n\nCordialement,<br>\nDamien Royer', '2024-10-07 16:38:30', '2024-10-07 16:38:30'),
(16, 20, 16, 'Bonjour l\'équipe Adobe,<br><br>\n\nJe vous écris pour vous faire part de ma candidature pour le poste de Développeur Front-End.<br><br>\n\nJe suis un développeur passionné par la création d\'interfaces utilisateur modernes, utilisant HTML, CSS, JavaScript, React.js et d\'autres technologies frontend.<br><br>\n\nJe serais ravi d\'échanger avec vous sur ma candidature.<br><br>\n\nCordialement,<br>\nCatherine Petit', '2024-10-07 16:39:00', '2024-10-07 16:39:00'),
(17, 21, 17, 'Bonjour l\'équipe Amazon,<br><br>\n\nJe vous contacte pour le poste de Développeur C++.<br><br>\n\nJ\'ai plusieurs années d\'expérience dans le développement logiciel, avec une expertise particulière en C++, ainsi qu\'une bonne maîtrise des algorithmes et structures de données.<br><br>\n\nJe serais ravi de discuter plus en détail de ma candidature avec vous.<br><br>\n\nCordialement,<br>\nThérèse Vidal', '2024-10-07 16:40:30', '2024-10-07 16:40:30'),
(18, 22, 18, 'Bonjour l\'équipe Oracle,<br><br>\n\nJe vous adresse ma candidature pour le poste de Développeur Fullstack.<br><br>\n\nJe suis un développeur Fullstack expérimenté avec des compétences approfondies en JavaScript, Node.js, Express, MongoDB et React.js.<br><br>\n\nJe serais heureux de discuter de la manière dont mes compétences peuvent contribuer à vos projets.<br><br>\n\nCordialement,<br>\nJean-Pierre Leroy', '2024-10-07 16:42:00', '2024-10-07 16:42:00'),
(19, 23, 19, 'Bonjour l\'équipe Airbnb,<br><br>\n\nJe vous écris pour exprimer mon intérêt pour le poste d\'Ingénieur DevOps.<br><br>\n\nJe possède une solide expérience avec les outils de gestion de configuration comme Ansible, Terraform, ainsi que des pratiques CI/CD.<br><br>\n\nJe serais ravi d\'échanger avec vous pour discuter de cette opportunité.<br><br>\n\nCordialement,<br>\nMarion Lefevre', '2024-10-07 16:43:30', '2024-10-07 16:43:30'),
(20, 24, 20, 'Bonjour l\'équipe Facebook,<br><br>\n\nJe vous adresse ma candidature pour le poste de Développeur Python.<br><br>\n\nAvec plusieurs années d\'expérience en Python, Django et Flask, je suis convaincu que mes compétences seraient un atout pour vos projets de développement.<br><br>\n\nJe serais ravi de discuter plus en détail de ma candidature avec vous.<br><br>\n\nCordialement,<br>\nLouis Martin', '2024-10-07 16:45:00', '2024-10-07 16:45:00');


-- --------------------------------------------------------

--
-- Structure de la table `messenger_messages`
--

DROP TABLE IF EXISTS `messenger_messages`;
CREATE TABLE IF NOT EXISTS `messenger_messages` (
  `id` bigint NOT NULL AUTO_INCREMENT,
  `body` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `headers` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `queue_name` varchar(190) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` datetime NOT NULL COMMENT '(DC2Type:datetime_immutable)',
  `available_at` datetime NOT NULL COMMENT '(DC2Type:datetime_immutable)',
  `delivered_at` datetime DEFAULT NULL COMMENT '(DC2Type:datetime_immutable)',
  PRIMARY KEY (`id`),
  KEY `IDX_75EA56E0FB7336F0` (`queue_name`),
  KEY `IDX_75EA56E0E3BD61CE` (`available_at`),
  KEY `IDX_75EA56E016BA31DB` (`delivered_at`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Structure de la table `user`
--

DROP TABLE IF EXISTS `user`;
CREATE TABLE IF NOT EXISTS `user` (
  `id` int NOT NULL AUTO_INCREMENT,
  `email` varchar(180) COLLATE utf8mb4_unicode_ci NOT NULL,
  `roles` json NOT NULL,
  `password` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `first_name` varchar(80) COLLATE utf8mb4_unicode_ci NOT NULL,
  `last_name` varchar(80) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` datetime NOT NULL COMMENT '(DC2Type:datetime_immutable)',
  `updated_at` datetime NOT NULL COMMENT '(DC2Type:datetime_immutable)',
  `image` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `UNIQ_IDENTIFIER_EMAIL` (`email`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

ALTER TABLE user
ADD COLUMN first_name VARCHAR(80) COLLATE utf8mb4_unicode_ci NOT NULL,
ADD COLUMN last_name VARCHAR(80) COLLATE utf8mb4_unicode_ci NOT NULL,
ADD COLUMN created_at DATETIME NOT NULL COMMENT '(DC2Type:datetime_immutable)',
ADD COLUMN updated_at DATETIME NOT NULL COMMENT '(DC2Type:datetime_immutable)';


--
-- Déchargement des données de la table `user`
--

INSERT INTO `user` (`id`, `email`, `roles`, `password`, `first_name`, `last_name`, `created_at`, `updated_at`, `image`) VALUES
(1, 'admin@email.com', '[\"ROLE_USER\"]', '$2y$13$aG2OcjtD2xZUsSqYcPmsw.ExR9aHtgj3eBhAhsnTtkp9/CkWRZMXq', 'admin', 'admin', '2024-10-07 14:20:54', '2024-10-07 14:20:54', NULL);

--
-- Contraintes pour les tables déchargées
--

--
-- Contraintes pour la table `cover_letter`
--
ALTER TABLE `cover_letter`
  ADD CONSTRAINT `FK_EBE6B473481D195` FOREIGN KEY (`job_offer_id`) REFERENCES `job_offer` (`id`),
  ADD CONSTRAINT `FK_EBE6B474A3353D8` FOREIGN KEY (`app_user_id`) REFERENCES `user` (`id`);

--
-- Contraintes pour la table `job_offer`
--
ALTER TABLE `job_offer`
  ADD CONSTRAINT `FK_288A3A4E4A3353D8` FOREIGN KEY (`app_user_id`) REFERENCES `user` (`id`);

--
-- Contraintes pour la table `linked_in_message`
--
ALTER TABLE `linked_in_message`
  ADD CONSTRAINT `FK_6ACAC8D63481D195` FOREIGN KEY (`job_offer_id`) REFERENCES `job_offer` (`id`),
  ADD CONSTRAINT `FK_6ACAC8D64A3353D8` FOREIGN KEY (`app_user_id`) REFERENCES `user` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
