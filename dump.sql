-- phpMyAdmin SQL Dump
-- version 4.0.10deb1
-- http://www.phpmyadmin.net
--
-- Host: localhost
-- Generation Time: Jul 07, 2017 at 03:27 PM
-- Server version: 5.5.55-0ubuntu0.14.04.1
-- PHP Version: 7.1.6-2~ubuntu14.04.1+deb.sury.org+1

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Database: `po`
--

-- --------------------------------------------------------

--
-- Table structure for table `authors`
--

CREATE TABLE IF NOT EXISTS `authors` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(150) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email` varchar(150) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `status` enum('student','department staff','other') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'other',
  `degree` enum('bachelor','master','candidate of sciences','doctor of sciences') COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `rank` enum('docent','professor') COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `post` varchar(150) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `authors_email_unique` (`email`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci AUTO_INCREMENT=7 ;

--
-- Dumping data for table `authors`
--

INSERT INTO `authors` (`id`, `name`, `email`, `status`, `degree`, `rank`, `post`, `created_at`, `updated_at`) VALUES
(1, 'Eugene Burdeinyi', 'ojdgaf@gmail.com', 'student', 'master', NULL, NULL, NULL, '2017-07-04 12:27:11'),
(2, 'Joe Vega', 'joevega@gmail.com', 'department staff', 'doctor of sciences', 'professor', 'Head of department', '2017-07-05 09:33:09', '2017-07-05 09:33:09'),
(3, 'Temple Grandin', 'templegrandin@gmail.comg', 'other', NULL, NULL, NULL, '2017-07-06 13:37:57', '2017-07-06 13:37:57'),
(4, 'Chitrita DebRoy', 'rcd3@psu.edu', 'other', NULL, NULL, NULL, '2017-07-06 13:38:36', '2017-07-06 13:39:34'),
(5, 'Subhashinie Kariyawasam', 'subhashiniekariyawasam@ukoz.ru', 'department staff', 'candidate of sciences', 'docent', 'Department of Veterinary and Biomedical Sciences', '2017-07-06 13:39:17', '2017-07-06 13:39:17');

-- --------------------------------------------------------

--
-- Table structure for table `author_publication`
--

CREATE TABLE IF NOT EXISTS `author_publication` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `author_id` int(10) unsigned NOT NULL,
  `publication_id` int(10) unsigned NOT NULL,
  `status_author` enum('student','department staff','other') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'other',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci AUTO_INCREMENT=53 ;

--
-- Dumping data for table `author_publication`
--

INSERT INTO `author_publication` (`id`, `author_id`, `publication_id`, `status_author`, `created_at`, `updated_at`) VALUES
(38, 1, 5, 'department staff', '2017-07-06 13:40:27', '2017-07-06 13:40:27'),
(39, 2, 5, 'student', '2017-07-06 13:40:27', '2017-07-06 13:40:27'),
(40, 4, 6, 'department staff', '2017-07-06 13:41:44', '2017-07-06 13:41:44'),
(46, 1, 4, 'student', '2017-07-06 14:04:31', '2017-07-06 14:04:31'),
(47, 3, 8, 'other', '2017-07-06 14:04:40', '2017-07-06 14:04:40'),
(48, 3, 3, 'other', '2017-07-06 15:11:13', '2017-07-06 15:11:13'),
(51, 4, 7, 'department staff', '2017-07-07 08:56:39', '2017-07-07 08:56:39'),
(52, 5, 7, 'other', '2017-07-07 08:56:39', '2017-07-07 08:56:39');

-- --------------------------------------------------------

--
-- Table structure for table `databases`
--

CREATE TABLE IF NOT EXISTS `databases` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(180) COLLATE utf8mb4_unicode_ci NOT NULL,
  `description` text COLLATE utf8mb4_unicode_ci,
  `url` varchar(180) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `access_mode` varchar(180) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `databases_name_unique` (`name`),
  UNIQUE KEY `databases_url_unique` (`url`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci AUTO_INCREMENT=6 ;

--
-- Dumping data for table `databases`
--

INSERT INTO `databases` (`id`, `name`, `description`, `url`, `access_mode`, `created_at`, `updated_at`) VALUES
(1, 'Web of Science', 'Bibliographic database system developed by ISI. Includes other products, such as Social Science Citation Index, Science Citation Index, Biological Abstracts & The Zoological Record', 'https://webofknowledge.com', 'Subscription', NULL, NULL),
(2, 'Scopus', 'Scopus is the world''s largest abstract and citation database of peer-reviewed research literature. It contains over 20,500 titles from more than 5,000 international publishers. While it is a subscription product, authors can review and update their profiles via ORCID.org or by first searching for their profile at the free Scopus author lookup page.', 'http://www.scopus.com/', 'Subscription', NULL, NULL),
(3, 'WorldWideScience', 'WorldWideScience is a global science gateway composed of national and international scientific databases and portals. WorldWideScience accelerates scientific discovery and progress by providing one-stop searching of databases from around the world. Multilingual WorldWideScience provides real-time searching and translation of globally dispersed multilingual scientific literature.', 'Free', 'https://worldwidescience.org/', NULL, NULL),
(4, 'African Journals OnLine (AJOL)', 'Scholarly journals published in Africa', 'http://www.ajol.info/', 'Free abstracts; Subscription full-text', NULL, NULL),
(5, 'Europe PubMed Central', 'A database of biomedical and life sciences literature with access to full-text research articles and citations.[56] Includes text-mining tools and links to external molecular and medical data sets. A partner in PMC International.', 'http://europepmc.org/', 'Free', NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `database_literature`
--

CREATE TABLE IF NOT EXISTS `database_literature` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `database_id` int(10) unsigned NOT NULL,
  `literature_id` int(10) unsigned NOT NULL,
  `date` date DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci AUTO_INCREMENT=21 ;

--
-- Dumping data for table `database_literature`
--

INSERT INTO `database_literature` (`id`, `database_id`, `literature_id`, `date`, `created_at`, `updated_at`) VALUES
(4, 2, 6, '2013-09-30', '2017-07-06 13:21:26', '2017-07-06 13:21:26'),
(5, 1, 6, '2013-11-10', '2017-07-06 13:21:26', '2017-07-06 13:21:26'),
(6, 5, 6, '2013-12-02', '2017-07-06 13:21:26', '2017-07-06 13:21:26'),
(7, 3, 4, '2017-06-02', '2017-07-06 13:24:19', '2017-07-06 13:24:19'),
(8, 4, 5, '2001-07-18', '2017-07-06 14:43:05', '2017-07-06 14:43:05'),
(19, 2, 2, '2006-02-28', '2017-07-06 14:49:10', '2017-07-06 14:49:10'),
(20, 5, 2, '2005-12-21', '2017-07-06 14:49:10', '2017-07-06 14:49:10');

-- --------------------------------------------------------

--
-- Table structure for table `literature`
--

CREATE TABLE IF NOT EXISTS `literature` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `title` varchar(180) COLLATE utf8mb4_unicode_ci NOT NULL,
  `description` text COLLATE utf8mb4_unicode_ci,
  `publisher` varchar(180) COLLATE utf8mb4_unicode_ci NOT NULL,
  `type` enum('journal','book','conference proceedings') COLLATE utf8mb4_unicode_ci NOT NULL,
  `periodicity` enum('12','6','4','3','2','1') COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `issn` varchar(9) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `size` int(10) unsigned DEFAULT NULL,
  `issue_year` int(10) unsigned DEFAULT NULL,
  `isbn` varchar(17) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `cover_path` varchar(180) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `literature_title_unique` (`title`),
  UNIQUE KEY `literature_issn_unique` (`issn`),
  UNIQUE KEY `literature_isbn_unique` (`isbn`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci AUTO_INCREMENT=8 ;

--
-- Dumping data for table `literature`
--

INSERT INTO `literature` (`id`, `title`, `description`, `publisher`, `type`, `periodicity`, `issn`, `size`, `issue_year`, `isbn`, `cover_path`, `created_at`, `updated_at`) VALUES
(2, 'Clinical Mass Spectrometry', 'Clinical Mass Spectrometry publishes peer-reviewed articles addressing the application of mass spectrometric technologies in Laboratory Medicine and Clinical Pathology with the focus on diagnostic applications. It is the first journal dedicated specifically to the application of mass spectrometry and related techniques in the context of diagnostic procedures in medicine. The journal has an interdisciplinary approach aiming to link clinical, biochemical and technological issues and results.\r\nBeyond the application of mass spectrometric technologies in the routine clinical diagnostic setting, by publishing critically validated analytical protocols, Clinical Mass Spectrometry also addresses the translation of experimental techniques and analytical research into patients'' care and the use of mass spectrometry in clinical research, studies, and routine patient care. The scope of the journal is not restricted to any particular mass spectrometric technologies but covers the entire methodological range of mass spectrometry and hyphenated technologies.\r\nSubject areas covered by the journal include, but are not restricted to:\r\nEndocrinology\r\nProtein quantification\r\nTherapeutic drug monitoring\r\nToxicology\r\nNeonatal screening\r\nClinical metabolomics and metabolic analyses\r\nMicrobiology\r\nImaging\r\nOn-site technologies\r\nNew technologies including automation\r\nData analysis and informatics including result reporting\r\nCross technology investigations\r\nValidation, standardization and quality management\r\nReference methods, materials and measurement services\r\nRegulatory aspects in diagnostic applications\r\nMass spectrometry based clinical studies\r\nError sources, risk assessment and patient safety', 'The Association for Mass Spectrometry: Applications to the Clinical Laboratory, Inc. (MSACL)', 'journal', '2', '2376-9998', NULL, NULL, NULL, 'literature/covers/Dz7vYjHJWE15kLkTqxJcPikCWkz48KYkl8EtDc1V.jpeg', '2017-07-05 09:58:32', '2017-07-06 14:49:10'),
(3, 'Practical Soft Tissue Pathology: A Diagnostic Approach', 'Part of the in-depth and practical Pattern Recognition series, Practical Surgical Soft Tissue Pathology, 2nd Edition, helps you arrive at an accurate diagnosis by using a proven pattern-based approach. Leading diagnosticians guide you through the most common patterns seen in soft tissue pathology, applying appropriate immunohistochemistry and molecular testing, avoiding pitfalls, and making the best diagnosis. High-quality illustrations capture key morphologic patterns for a full range of common and rare tumor types, and a "visual index" at the beginning of the book directs you to the exact location of in-depth diagnostic guidance.', 'A Volume in the Pattern Recognition Series', 'book', NULL, NULL, 576, 2017, '9780323497145', 'literature/covers/Hwbj9i3QNxkQiKltW5w30VBsLPrJz8L54bg910kU.jpeg', '2017-07-05 10:37:25', '2017-07-06 14:42:40'),
(4, 'Journal of Pure and Applied Algebra', 'The Journal of Pure and Applied Algebra concentrates on that part of algebra likely to be of general mathematical interest: algebraic results with immediate applications, and the development of algebraic theories of sufficiently general relevance to allow for future applications.', 'Elsevier', 'journal', '12', '0022-4049', NULL, NULL, NULL, NULL, '2017-07-05 15:18:47', '2017-07-06 11:56:46'),
(5, 'Veterinary and Animal Science', 'Veterinary and Animal Science is a new fully open access publication from Elsevier which strongly encourages a multidisciplinary approach to research. The scope of the journal is intentionally broad and includes almost all of the key aspects of animal science, veterinary science and veterinary medicine. The journal makes use of several innovative online technologies to help authors enhance their published research findings, such as Elsevier''s Virtual Microscope feature, 3D Visualizations, Graphical Abstracts and AudioSlides.\r\nAreas of animal science and veterinary science that will be considered for publication include: reproduction, breeding, genetics, physiology, nutrition, feed science, meat science, animal welfare, ethics & law, animal behaviour, endocrinology and metabolism, veterinary nursing, veterinary education, veterinary epidemiology, veterinary public health, livestock management and production, poultry science, equine science, bovine science, small ruminants, camelids, aquaculture, fisheries science and fish nutrition, zoo animal management, zoo animal clinical studies, conservation where there is a veterinary or animal science aspect, and wild animal disease.\r\nAreas of veterinary medicine that will be considered include: anaesthesia and analgesia, veterinary internal medicine, imaging, surgery, small animal medicine, companion animal medicine, zoo animal medicine, avian medicine, emergency medicine and critical care, parasitology, microbiology, immunology and immunopathology, virology, toxicology, pharmacology and vaccinology, therapeutics, veterinary behaviour, comparative psychology and comparative medicine, ophthalmology, dentistry, cardiology, oncology, dermatology, nephrology and urology.\r\nThis is a guide to the main areas which Veterinary and Animal Science considers however it is not an exhaustive list. Submissions on topics related to wild animal science and animals which are not under the care or direct management of humans will not be considered. Please visit the Guide for Authors for more information on how to make a submission.', 'Elsevier', 'journal', '4', '2451-943X', NULL, NULL, NULL, 'literature/covers/Kq7R6hVCxdWOchQT3vBYz0VoAbIJK0zvQlkHM090.gif', '2017-07-06 11:56:04', '2017-07-06 14:43:05'),
(6, 'Diagnostic Immunohistochemistry 5th Edition', 'User-friendly and concise, the new edition of this popular reference is your #1 guide for the appropriate use of immunohistochemical stains. Dr. David J. Dabbs and leading experts in the field use a consistent, organ system approach to cover all aspects of the field, with an emphasis on the role of genomics in diagnosis and theranostic applications that will better inform treatment options. Each well-written and well-researched chapter is enhanced with diagnostic algorithms, charts, tables, and superb, full-color histologic images, making this text a practical daily resource for all surgical pathologists.', 'Theranostic and Genomic Applications', 'book', NULL, NULL, 848, 2013, '9780323477321', NULL, '2017-07-06 12:19:02', '2017-07-06 12:19:02'),
(7, 'Encyclopedia of Cardiovascular Research and Medicine 1st Edition', 'Encyclopedia of Cardiovascular Research and Medicine offers researchers over 200 articles covering every aspect of cardiovascular research and medicine, including fully annotated figures, abundant color illustrations and links to supplementary datasets and references. With contributions from top experts in the field, this book is the most reputable and easily searchable resource of cardiovascular-focused basic and translational content for students, researchers, clinicians and teaching faculty across the biomedical and medical sciences. The panel of authors chosen from an international board of leading scholars renders the text trustworthy, contemporary and representative of the global scientific expertise in these domains.\r\n\r\nThe book''s thematic structuring of sections and in-depth breakdown of topics encourages user-friendly, easily searchable chapters. Cross-references to related articles and links to further reading and references will further guide readers to a full understanding of the topics under discussion. Readers will find an unparalleled, one-stop resource exploring all major aspects of cardiovascular research and medicine.', 'Elsevier', 'conference proceedings', NULL, NULL, 2800, 2016, '9780128096574', NULL, '2017-07-06 12:20:52', '2017-07-06 12:25:12');

-- --------------------------------------------------------

--
-- Table structure for table `migrations`
--

CREATE TABLE IF NOT EXISTS `migrations` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `migration` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `batch` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci AUTO_INCREMENT=28 ;

--
-- Dumping data for table `migrations`
--

INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES
(17, '2014_10_12_000000_create_users_table', 1),
(18, '2014_10_12_100000_create_password_resets_table', 1),
(19, '2017_02_15_010055_create_publications_table', 1),
(20, '2017_02_15_190653_create_authors_table', 1),
(21, '2017_02_21_175427_create_literatures_table', 1),
(22, '2017_02_22_180119_create_publication-_authors_table', 1),
(23, '2017_02_22_180210_create_literature-_databases_table', 1),
(24, '2017_02_22_180247_create_databases_table', 1),
(25, '2017_02_25_171919_add_id_col_to_publications_authors', 1),
(26, '2017_02_25_172014_add_id_col_to_literature_databases', 1),
(27, '2017_07_05_125420_add_coverpath_col_to_literature', 2);

-- --------------------------------------------------------

--
-- Table structure for table `password_resets`
--

CREATE TABLE IF NOT EXISTS `password_resets` (
  `email` varchar(150) COLLATE utf8mb4_unicode_ci NOT NULL,
  `token` varchar(200) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  KEY `password_resets_email_index` (`email`),
  KEY `password_resets_token_index` (`token`(191))
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `publications`
--

CREATE TABLE IF NOT EXISTS `publications` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `heading` varchar(180) COLLATE utf8mb4_unicode_ci NOT NULL,
  `abstract` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `description` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `genre` enum('book review','case report','article commentary','commentary','rapid communication','concept paper','correction','creative','data descriptor','discussion','editorial','erratum','essay','expression of concern','interesting image','letter','books received','obituary','opinion','project report','reply','retraction','review article','note','technical note') COLLATE utf8mb4_unicode_ci NOT NULL,
  `type` enum('journal article','book article','report of conference') COLLATE utf8mb4_unicode_ci NOT NULL,
  `literature_id` int(10) unsigned NOT NULL,
  `issue_number` enum('1','2','3','4','5','6','7','8','9','10','11','12') COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `issue_year` int(10) unsigned DEFAULT NULL,
  `page_initial` int(10) unsigned DEFAULT NULL,
  `page_final` int(10) unsigned DEFAULT NULL,
  `document_path` varchar(180) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `publications_heading_unique` (`heading`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci AUTO_INCREMENT=9 ;

--
-- Dumping data for table `publications`
--

INSERT INTO `publications` (`id`, `heading`, `abstract`, `description`, `genre`, `type`, `literature_id`, `issue_number`, `issue_year`, `page_initial`, `page_final`, `document_path`, `created_at`, `updated_at`) VALUES
(3, 'Analytical validation of protein biomarkers for risk of spontaneous preterm birth', 'Presented are the validation results of a second-generation assay for determining the relative abundances of two protein biomarkers found in maternal serum that predict an individual’s risk of spontaneous preterm birth. The sample preparation workflow is complex, consisting of immuno-depletion of high-abundance serum proteins, tryptic digestion of the immuno-depleted fraction to generate surrogate peptide analytes, and detection by tandem mass spectrometry. The method was determined to be robust on observation of the following characteristics: classifier peptide detection precision was excellent; results were accurate when compared to a reference method; results were linear over a clinically relevant range; the limits of quantitation encompassed the range of expected results; and the method demonstrated analytical specificity and resilience to differences in patient serum and common endogenous interferents.', 'M.C. McCormick\r\nThe contribution of low birth weight to infant mortality and childhood morbidity\r\nN. Engl. J. Med. (1985), pp. 82–90', 'technical note', 'journal article', 2, '1', 2017, 25, 38, 'publications/Analytical validation of protein biomarkers for risk of spontaneous preterm birth.txt', '2017-07-05 10:44:03', '2017-07-06 11:51:49'),
(4, 'Attenuated levels of phospholipids in the striatum of rats infused with rotenone causing hemiparkinsonism as detected by simple dye-lipid complex', 'Parkinson''s disease (PD), a progressive neurodegeneration, is characterized by loss of dopaminergic neurons in the substantia nigra (SN) and loss of motor co-ordination. Impaired metabolism of major lipids such as phospholipids which play regulatory roles in cellular functions and signaling has been implicated in the pathology of PD. We aim to investigate the striatal phospholipids (PLs) in hemiparkinsonism infused by rotenone in rats. As there are no cost-effective modes of PL, we have utilized dye-lipid complex technique for the first time in PD models for screening and also for semi-quantifying (individually) the levels of the deregulated PL in brain samples. Rats were divided into 2 groups: i. control and ii. ROT-infused which received intracranial injection of Rotenone (6 μg/μl; flow rate 0.2 μl/min). At the end of experimental period of 14 days, the striatum was dissected out for the analyses of PLs. Dye-based detection of PL and two-dimensional thin-layer chromatographic analyses of PL were performed. Detection of dye-PL complex was possible for phosphatidyl choline (PC), phosphatidyl inositol (PI), and spingomyelin (SM) (but not for phosphatidyl ethanolamine-PE) using dyes viz victoria blue B, toluidine blue and ammonium ferrothiocyanate, respectively. Two-dimensional analyses of phospholipids confirmed the dye-PL complex and depicted significant reduction (p < 0.05) on semi-quantitative assessment, in the striatum of control and hemiparkinsonic rats. We suggest a low level of PLs esp of PI in striatum of rats using a simple dye-detection that was validated by HR-LCMS. The finding implies that a critical role is being played by these PLs (PC, PI and SM) mainly PI (p < 0.001), in rotenone infused hemiparkinsonism, thus deserving wider but simpler investigations to detect and identify their role in parkinsonism.', 'T. Balla, Z. Szentpetery, Y.J. Kim\r\nPhosphoinositide signaling: new tools and insights\r\nPhysiology, 24 (4) (2009), pp. 231–244', 'project report', 'journal article', 2, '2', 2017, 1, 8, 'publications/Attenuated levels of phospholipids in the striatum of rats infused with rotenone causing hemiparkinsonism as detected by simple dye-lipid complex.txt', '2017-07-06 13:34:26', '2017-07-06 14:04:31'),
(5, 'Evaluation of the welfare of cattle housed in outdoor feedlot pens', 'The use of open outdoor feedlots for housing large numbers of cattle is increasing in many parts of the world. In these systems cattle are kept in large outdoor pens on a soil surface. One major welfare concern associated with this type of housing is keeping cattle clean and preventing muddy conditions. If the annual rainfall exceeds 20 in (51 cm). It is more difficult to keep the surface dry. In dry parts of the world with low rainfall, it is much easier to keep cattle clean and dry. Another issue is heat stress, and there are warmer parts of the world where shade may be required. The third issue is handling and vaccinating large numbers of cattle. In the U.S. this is an area where conditions have improved because management is now more aware about animal welfare. There are three major outcome based measurements that should be used to assess cattle welfare in open feedlots. They are: scoring of hide cleanliness, panting scoring for heat stress and numerical scoring of cattle handling practices.', 'Australian Cattle Standard Working Group. Austraian Government, Review of the Australian Standards for the Export of Livestock Review of the Livestock Export Standards Advisory Group, Final Report 31 May 2013', 'project report', 'journal article', 5, '3', 2016, 23, 28, 'publications/Evaluation of the welfare of cattle housed in outdoor feedlot pens.txt', '2017-07-06 13:36:48', '2017-07-06 13:36:48'),
(6, 'Comparison of antimicrobial resistant genes in chicken gut microbiome grown on organic and conventional diet', 'Antibiotics are widely used in chicken production for therapeutic purposes, disease prevention and growth promotion, and this may select for drug resistant microorganisms known to spread to humans through consumption of contaminated food. Raising chickens on an organic feed regimen, without the use of antibiotics, is increasingly popular with the consumers. In order to determine the effects of diet regimen on antibiotic resistant genes in the gut microbiome, we analyzed the phylotypes and identified the antimicrobial resistant genes in chicken, grown under conventional and organic dietary regimens. Phylotypes were analyzed from DNA extracted from fecal samples from chickens grown under these dietary conditions. While gut microbiota of chicken raised in both conventional and organic diet exhibited the presence of DNA from members of Proteobacteria and Bacteroidetes, organic diet favored the growth of members of Fusobacteria. Antimicrobial resistance genes were identified from metagenomic libraries following cloning and sequencing of DNA fragments from fecal samples and selecting for the resistant clones (n=340) on media containing different concentrations of eight antibiotics. The antimicrobial resistant genes exhibited diversity in their host distribution among the microbial population and expressed more in samples from chicken grown on a conventional diet at higher concentrations of certain antimicrobials than samples from chicken grown on organic diet. Further studies will elucidate if this phenomena is widespread and whether the antimicrobial resistance is indeed modulated by diet. This may potentially assist in defining strategies for intervention to reduce the prevalence and dissemination of antibiotic resistance genes in the production environment.', 'The role of antibiotics and antibiotic resistance in nature Environmental Microbiology, 11 (2009), pp. 2970-2988', 'note', 'journal article', 5, '4', 2016, 9, 14, 'publications/Comparison of antimicrobial resistant genes in chicken gut microbiome grown on organic and conventional diet.txt', '2017-07-06 13:41:44', '2017-07-06 13:41:44'),
(7, 'Observation of a positive interference in LC-MS/MS/ measurement of d6-25-OH-vitamin D3', 'Monitoring for consistent internal standard (IS) signal across samples, often referred to as the metric plot, is a central aspect of quality assurance in mass spectrometric-based assays [1]. Aberrant IS signal can indicate improper sample processing, the presence of an interferent affecting ionization, or, rarely, the presence of an isobaric compound. Here, we report interference in the measurement of the internal standard d6-25-OH-vitamin D3, as part of a 25-OH-vitamin D assay, which may be associated with the antiemetic ondansetron (Zofran, Novartis Pharmaceutical).', 'A simple, rapid atmospheric pressure chemical ionization liquid chromatography tandem mass spectrometry method for the determination of 25-hydroxyvitamin D2 and D3\r\nJ. Clin. Lab. Anal., 26 (5) (2012), pp. 349–357', 'opinion', 'book article', 6, NULL, NULL, 22, 24, 'publications/Observation of a positive interference in LC-MS/MS/ measurement of d6-25-OH-vitamin D3.txt', '2017-07-06 13:43:16', '2017-07-07 08:49:21'),
(8, 'SPE-IMS-MS: An automated platform for sub-sixty second surveillance of endogenous metabolites and xenobiotics in biofluids', 'Characterization of endogenous metabolites and xenobiotics is essential to deconvoluting the genetic and environmental causes of disease. However, surveillance of chemical exposure and disease-related changes in large cohorts requires an analytical platform that offers rapid measurement, high sensitivity, efficient separation, broad dynamic range, and application to an expansive chemical space. Here, we present a novel platform for small molecule analyses that addresses these requirements by combining solid-phase extraction with ion mobility spectrometry and mass spectrometry (SPE-IMS-MS). This platform is capable of performing both targeted and global measurements of endogenous metabolites and xenobiotics in human biofluids with high reproducibility (CV ⩽ 3%), sensitivity (LODs in the pM range in biofluids) and throughput (10-s sample-to-sample duty cycle). We report application of this platform to the analysis of human urine from patients with and without type 1 diabetes, where we observed statistically significant variations in the concentration of disaccharides and previously unreported chemical isomers. This SPE-IMS-MS platform overcomes many of the current challenges of large-scale metabolomic and exposomic analyses and offers a viable option for population and patient cohort screening in an effort to gain insights into disease processes and human environmental chemical exposure. © 2017 The Association for Mass Spectrometry: Applications to the Clinical Lab (MSACL)', 'Teeguarden, J.G.; 902 Battelle Blvd., P.O. Box 999, MSIN K8-98, Richland, WA, United States', 'concept paper', 'journal article', 2, '2', 2016, 1, 10, 'publications/SPE-IMS-MS An automated platform for sub-sixty second surveillance of endogenous metabolites and xenobiotics in biofluids.txt', '2017-07-06 13:53:30', '2017-07-06 14:04:40');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE IF NOT EXISTS `users` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(150) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email` varchar(150) COLLATE utf8mb4_unicode_ci NOT NULL,
  `password` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL,
  `remember_token` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `users_email_unique` (`email`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci AUTO_INCREMENT=1 ;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
