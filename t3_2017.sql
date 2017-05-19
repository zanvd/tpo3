-- phpMyAdmin SQL Dump
-- version 4.6.4deb1
-- https://www.phpmyadmin.net/
--
-- Gostitelj: localhost:3306
-- Čas nastanka: 13. maj 2017 ob 22.36
-- Različica strežnika: 5.7.17-0ubuntu0.16.10.1
-- Različica PHP: 7.0.15-0ubuntu0.16.10.4

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Zbirka podatkov: `t3_2017`
--

-- --------------------------------------------------------

--
-- Struktura tabele `BloodTube`
--

CREATE TABLE `BloodTube` (
  `blood_tube_id` int(10) UNSIGNED NOT NULL,
  `color` varchar(10) COLLATE utf8mb4_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Odloži podatke za tabelo `BloodTube`
--

INSERT INTO `BloodTube` (`blood_tube_id`, `color`) VALUES
(996, 'Rdeča'),
(997, 'Modra'),
(998, 'Rumena'),
(999, 'Zelena');

-- --------------------------------------------------------

--
-- Struktura tabele `Contact`
--

CREATE TABLE `Contact` (
  `contact_id` int(10) UNSIGNED NOT NULL,
  `contact_name` varchar(60) COLLATE utf8mb4_unicode_ci NOT NULL,
  `contact_surname` varchar(60) COLLATE utf8mb4_unicode_ci NOT NULL,
  `contact_phone_num` varchar(15) COLLATE utf8mb4_unicode_ci NOT NULL,
  `contact_address` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `post_number` int(10) UNSIGNED NOT NULL,
  `relationship_id` int(10) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Odloži podatke za tabelo `Contact`
--

INSERT INTO `Contact` (`contact_id`, `contact_name`, `contact_surname`, `contact_phone_num`, `contact_address`, `post_number`, `relationship_id`) VALUES
(1, 'Stric', 'Vinko', '123456789', 'Vnesemo naslov 2', 1215, 21),
(2, 'Ivana', 'Cankar', '041331713', 'Naslov 1', 1001, 10);

-- --------------------------------------------------------

--
-- Struktura tabele `DependentPatient`
--

CREATE TABLE `DependentPatient` (
  `dependent_patient_id` int(10) UNSIGNED NOT NULL,
  `guardian_patient_id` int(10) UNSIGNED NOT NULL,
  `relationship_id` int(10) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Odloži podatke za tabelo `DependentPatient`
--

INSERT INTO `DependentPatient` (`dependent_patient_id`, `guardian_patient_id`, `relationship_id`) VALUES
(8, 7, 10),
(12, 11, 13);

-- --------------------------------------------------------

--
-- Struktura tabele `Employee`
--

CREATE TABLE `Employee` (
  `employee_id` int(11) NOT NULL,
  `person_id` int(10) UNSIGNED NOT NULL,
  `institution_id` int(10) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Odloži podatke za tabelo `Employee`
--

INSERT INTO `Employee` (`employee_id`, `person_id`, `institution_id`) VALUES
(1222, 5, 5150),
(17797, 10, 5030),
(66553, 6, 5150),
(69246, 17, 5030),
(73800, 11, 5150),
(94252, 7, 5150),
(99522, 16, 5900);

-- --------------------------------------------------------

--
-- Struktura tabele `FreeDays`
--

CREATE TABLE `FreeDays` (
  `free_day` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Odloži podatke za tabelo `FreeDays`
--

INSERT INTO `FreeDays` (`free_day`) VALUES
('2017-06-04'),
('2017-06-25'),
('2017-08-15'),
('2017-10-31'),
('2017-11-01'),
('2017-12-25'),
('2017-12-26'),
('2018-01-01'),
('2018-01-02'),
('2018-02-08'),
('2018-04-01'),
('2018-04-02'),
('2018-04-27'),
('2018-05-01'),
('2018-05-02'),
('2018-05-20'),
('2018-06-25'),
('2018-08-15'),
('2018-10-31'),
('2018-11-01'),
('2018-12-25'),
('2018-12-26');

-- --------------------------------------------------------

--
-- Struktura tabele `Illness`
--

CREATE TABLE `Illness` (
  `illness_id` varchar(7) COLLATE utf8mb4_unicode_ci NOT NULL,
  `illness_name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Odloži podatke za tabelo `Illness`
--

INSERT INTO `Illness` (`illness_id`, `illness_name`) VALUES
('Z35.0', 'Nadzor nad nosečnostjo z anamnezo infertilnosti'),
('Z35.1', 'Nadzor nad nosečnostjo z anamnezo splavov'),
('Z35.2', 'Nadzor nad nosečnostjo z drugače slabo reproduktivno ali porodniško anamnezo'),
('Z35.3', 'Nadzor nad nosečnostjo z anamnezo nezadostne predporodne nege'),
('Z35.4', 'Nadzor nad nosečnostjo po velikem številu porodov'),
('Z35.51', 'Nadzor nad starejšo primiparo(prvorodnico)'),
('Z35.52', 'Nadzor nad starejšo mnogorodnico'),
('Z35.6', 'Nadzor nad zelo mlado prvesnico'),
('Z35.7', 'Nadzor nad zelo tvegano nosečnostjo zaradi socialnih težav'),
('Z35.8', 'Nadzor nad drugimi zelo tveganimi nosečnostmi'),
('Z39.01', 'Poporodna oskrba po porodu v porodnišnici'),
('Z39.02', 'Poporodna oskrba po načrtovanem porodu izven porodnišnice'),
('Z39.03', 'Poporodna oskrba po nenačrtovanem porodu izven porodnišnice'),
('Z39.1', 'Oskrba in pregled doječe matere'),
('Z39.2', 'Rutinsko poporodno spremljanje'),
('Z48.0', 'Oskrba pri kirurških prevezah in šivih'),
('Z51.9', 'Zdravstvena oskrba, neopredeljena');

-- --------------------------------------------------------

--
-- Struktura tabele `Institution`
--

CREATE TABLE `Institution` (
  `institution_id` int(10) UNSIGNED NOT NULL,
  `institution_title` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `institution_address` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `post_number` int(10) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Odloži podatke za tabelo `Institution`
--

INSERT INTO `Institution` (`institution_id`, `institution_title`, `institution_address`, `post_number`) VALUES
(3751, 'BOLNIŠNICA POSTOJNA', 'PREČNA ULICA 4', 6230),
(3771, 'BOLNIŠNICA SEŽANA', 'CANKARJEVA ULICA 4', 6210),
(4071, 'SB JESENICE', 'CESTA MARŠALA TITA 112', 4270),
(5030, 'ZD LJUBLJANA - BEŽIGRAD', 'KRŽIČEVA ULICA 10', 1000),
(5150, 'ZD LJUBLJANA - CENTER', 'METELKOVA ULICA 9', 1000),
(5470, 'ZD LJUBLJANA - ŠIŠKA', 'DERČEVA ULICA 5', 1000),
(5600, 'ZD LJUBLJANA - VIČ - RUDNIK', 'ŠESTOVA ULICA 10', 1000),
(5844, 'ZD IVANČNA GORICA', 'CESTA 2. GRUPE ODREDOV 16', 1295),
(5900, 'ZDS LJUBLJANA', 'AŠKERČEVA CESTA 4', 1000),
(6501, 'ŽZD LJUBLJANA', 'CELOVŠKA CESTA 4', 1000);

-- --------------------------------------------------------

--
-- Struktura tabele `Material`
--

CREATE TABLE `Material` (
  `material_id` int(10) UNSIGNED NOT NULL,
  `material_title` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Odloži podatke za tabelo `Material`
--

INSERT INTO `Material` (`material_id`, `material_title`) VALUES
(996, 'Epruveta - rdeča'),
(997, 'Epruveta - modra'),
(998, 'Epruveta - rumena'),
(999, 'Epruveta - zelena'),
(1686, 'Insulatard Penfill'),
(4561, 'NovoRapid FlexPen'),
(6912, 'Apidra'),
(7900, 'Betaferon'),
(11711, 'Copaxone'),
(13013, 'NovoRapid Penfill'),
(14117, 'Enbrel'),
(14621, 'PegIntron'),
(16632, 'Aranesp'),
(17108, 'HUMIRA'),
(19011, 'Lantus'),
(22748, 'Humalog'),
(22764, 'Humalog'),
(24872, 'Somatuline Autogel'),
(24880, 'Somatuline'),
(24899, 'Somatuline Autogel'),
(27510, 'Binocrit'),
(27588, 'Binocrit'),
(30554, 'FRAXIPARINE FORTE'),
(61891, 'Levemir'),
(61921, 'Levemir'),
(64238, 'ReFacto AF'),
(64807, 'LITAK'),
(64823, 'LITAK');

-- --------------------------------------------------------

--
-- Struktura tabele `Measurement`
--

CREATE TABLE `Measurement` (
  `measurement_id` int(10) UNSIGNED NOT NULL,
  `measurement_title` varchar(45) COLLATE utf8mb4_unicode_ci NOT NULL,
  `units` varchar(15) COLLATE utf8mb4_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Odloži podatke za tabelo `Measurement`
--

INSERT INTO `Measurement` (`measurement_id`, `measurement_title`, `units`) VALUES
(10, 'Krvni pritisk - sistolični', 'mmHg'),
(11, 'Krvni pritisk - diastolični', 'mmHg'),
(12, 'Dihanje', 'vdihov/min'),
(13, 'Srčni utrip', 'udarcev/min'),
(14, 'Telesna teža', 'kg'),
(15, 'Telesna teža novorojenčka', 'g'),
(16, 'Telesna teža pred nosečnostjo', 'kg'),
(17, 'Telesna višina', 'cm'),
(18, 'Telesna višina novorojenčka', 'cm'),
(19, 'Telesna temperatura', '°C'),
(20, 'Krvni sladkor', 'mmol/L'),
(21, 'Oksigenacija SpO2', '%'),
(22, 'Meritev bilirubina', 'μmol/L');

-- --------------------------------------------------------

--
-- Struktura tabele `Medicine`
--

CREATE TABLE `Medicine` (
  `medicine_id` int(10) UNSIGNED NOT NULL,
  `medicine_name` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `medicine_packaging` varchar(45) COLLATE utf8mb4_unicode_ci NOT NULL,
  `medicine_type` varchar(45) COLLATE utf8mb4_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Odloži podatke za tabelo `Medicine`
--

INSERT INTO `Medicine` (`medicine_id`, `medicine_name`, `medicine_packaging`, `medicine_type`) VALUES
(1686, 'Insulatard Penfill', '100 i.e./ml 3 ml 5x', 'susp.za inj.vložek'),
(4561, 'NovoRapid FlexPen', '100 enot/ml  3 ml 5x', 'razt.za inj.peresnik'),
(6912, 'Apidra', '100 i.e./ml 3 ml 5x', 'razt.za inj. peresnik Solo Star '),
(7900, 'Betaferon', '250 mcg/ml 15x', 'razt.za inj.'),
(11711, 'Copaxone', '20 mg/ml 28x', 'razt.za inj. brizga'),
(13013, 'NovoRapid Penfill', '100 enot/ml 3 ml 5x', 'razt.za inj. vložek'),
(14117, 'Enbrel', '50 mg 4x', 'inj.razt. brizga'),
(14621, 'PegIntron', '80 mcg 4x', 'prašek in vehikel za razt.za inj.peresnik'),
(16632, 'Aranesp', '80 mcg', 'razt.za inj.peresnik (SureClick) 0'),
(17108, 'HUMIRA', '40 mg 2x', 'razt.za inj. brizga'),
(19011, 'Lantus', '100 i.e./ml 3ml 5x', 'vložki za inj. peresnik OptiPen'),
(22748, 'Humalog', '100 i.e./ml 3 ml 5x', 'Mix25 vložki za inj.pero'),
(22764, 'Humalog', '100 i.e./ml 3 ml 5x22', 'Mix50 vložki za inj.pero'),
(24872, 'Somatuline Autogel', '120 mg 1x', 'razt.za inj. brizga'),
(24880, 'Somatuline Autogel', '90 mg 1x', 'inj.brizga'),
(24899, 'Somatuline Autogel', '60 mg 1x', 'razt.za inj. brizga'),
(27510, 'Binocrit', '2000 i.e./1 ml 6x', 'inj.brizga'),
(27588, 'Binocrit', '10 000 i.e./1 ml 6x', 'inj.brizga'),
(30554, 'FRAXIPARINE FORTE', '19000 i.e.AXa/1 ml 10x', 'inj.brizga'),
(61891, 'Levemir', '100 e./ml 3 ml 5x', 'razt.za inj. vložek'),
(61921, 'Levemir', '100 e./ml 3 ml 5x', 'razt.za inj. peresnik'),
(64238, 'ReFacto AF', '2000 i.e. 1x', 'razt.za inj.viala'),
(64807, 'LITAK', '2 mg/ml 5 ml 1x', 'razt.za inj.'),
(64823, 'LITAK', '2 mg/ml 5 ml 5x', 'razt.za inj.');

-- --------------------------------------------------------

--
-- Struktura tabele `migrations`
--

CREATE TABLE `migrations` (
  `id` int(10) UNSIGNED NOT NULL,
  `migration` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `batch` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Odloži podatke za tabelo `migrations`
--

INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES
(1, '2017_04_20_155319_create_region_table', 1),
(2, '2017_04_20_160132_create_user_role_table', 1),
(3, '2017_04_21_205714_create_service_table', 1),
(4, '2017_04_21_210251_create_measurement_table', 1),
(5, '2017_04_21_210724_create_blood_tube_table', 1),
(6, '2017_04_21_211010_create_material_table', 1),
(7, '2017_04_21_211148_create_illness_table', 1),
(8, '2017_04_21_211353_create_medicine_table', 1),
(9, '2017_04_21_211657_create_visit_type_table', 1),
(10, '2017_04_21_211944_create_relationship_table', 1),
(11, '2017_04_21_212142_create_post_table', 1),
(12, '2017_04_27_194538_create_visit_subtype_table', 1),
(13, '2017_04_27_200318_create_contact_table', 1),
(14, '2017_04_27_201058_create_institution_table', 1),
(15, '2017_04_27_201658_create_person_table', 1),
(16, '2017_04_27_203411_create_user_table', 1),
(17, '2017_04_27_204221_create_employee_table', 1),
(18, '2017_04_27_205300_create_substitution_table', 1),
(19, '2017_04_27_205902_create_verification_table', 1),
(20, '2017_04_27_210216_create_reset_link_table', 1),
(21, '2017_04_27_210533_create_patient_table', 1),
(22, '2017_04_27_211011_create_dependent_patient_table', 1),
(23, '2017_04_27_211508_create_work_order_table', 1),
(24, '2017_04_27_212015_create_work_order_patient_table', 1),
(25, '2017_04_27_212312_create_work_order_medicine_table', 1),
(26, '2017_04_27_212621_create_work_order_illness_table', 1),
(27, '2017_04_27_213104_create_work_order_material_table', 1),
(28, '2017_04_27_213542_create_work_order_blood_tube_table', 1),
(29, '2017_04_27_213833_create_work_order_measurement_table', 1),
(30, '2017_04_27_215415_create_visit_table', 1),
(31, '2017_05_09_201431_create_free_days_table', 1);

-- --------------------------------------------------------

--
-- Struktura tabele `Patient`
--

CREATE TABLE `Patient` (
  `patient_id` int(10) UNSIGNED NOT NULL,
  `insurance_num` char(11) COLLATE utf8mb4_unicode_ci NOT NULL,
  `birth_date` date NOT NULL,
  `sex` char(1) COLLATE utf8mb4_unicode_ci NOT NULL,
  `person_id` int(10) UNSIGNED NOT NULL,
  `contact_id` int(10) UNSIGNED DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Odloži podatke za tabelo `Patient`
--

INSERT INTO `Patient` (`patient_id`, `insurance_num`, `birth_date`, `sex`, `person_id`, `contact_id`) VALUES
(5, '123456789', '1991-01-01', 'm', 8, 1),
(6, '123456789', '1987-05-17', 'm', 9, NULL),
(7, '668592354', '1980-06-08', 'f', 12, NULL),
(8, '668592354', '2017-05-04', 'f', 13, NULL),
(9, '123456789', '2017-05-02', 'm', 14, NULL),
(10, '029382738', '1995-04-12', 'm', 15, NULL),
(11, '938274917', '1991-05-08', 'm', 18, 2),
(12, '863947939', '2000-05-01', 'm', 19, NULL);

-- --------------------------------------------------------

--
-- Struktura tabele `Person`
--

CREATE TABLE `Person` (
  `person_id` int(10) UNSIGNED NOT NULL,
  `name` varchar(60) COLLATE utf8mb4_unicode_ci NOT NULL,
  `surname` varchar(60) COLLATE utf8mb4_unicode_ci NOT NULL,
  `phone_num` varchar(15) COLLATE utf8mb4_unicode_ci NOT NULL,
  `address` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `post_number` int(10) UNSIGNED NOT NULL,
  `region_id` int(10) UNSIGNED DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Odloži podatke za tabelo `Person`
--

INSERT INTO `Person` (`person_id`, `name`, `surname`, `phone_num`, `address`, `post_number`, `region_id`) VALUES
(2, 'Administrator', 'Patronaža', '123456789', 'Večna pot 113', 1000, NULL),
(5, 'Zdravnik', 'Patronaža', '051447853', 'Večna pot 113', 1000, NULL),
(6, 'VodjaPS', 'Patronaža', '051932645', 'Večna pot 113', 1000, NULL),
(7, 'Sestra - Šiška', 'Patronaža', '031258963', 'Večna pot 113', 1000, 13169),
(8, 'Kontaknta', 'Oseba', '646416168', 'Večna pot 113', 1000, 13169),
(9, 'Zamudnik', 'Vselej', '123456789', 'Nimam ure 10', 6210, 29378),
(10, 'Sovica', 'Oka', '123456789', 'Ulica 1', 1000, NULL),
(11, 'Sestra - Center', 'Patronaža', '041878554', 'Večna pot 113', 1000, 47207),
(12, 'Zvonka', 'Center', '051489632', 'Večna pot 113', 1000, 47207),
(13, 'Diana', 'Center', '051489632', 'Večna pot 113', 1000, 47207),
(14, 'Verif', 'Test', '123456789', 'Hisa 4', 1001, 13169),
(15, 'Marjo', 'Špinel', '01928372', 'Naslov 2', 1216, 94853),
(16, 'Matjaž', 'Kopitar', '041226172', 'Večna pot 113', 1000, NULL),
(17, 'Mateja', 'Zadovoljna', '041313711', 'Slovenska cesta 10', 1000, 58492),
(18, 'Tadej', 'Prešeren', '031321789', 'Naslov 1', 1001, 58492),
(19, 'Polde', 'Prešeren', '031321789', 'Naslov 1', 1001, 58492);

-- --------------------------------------------------------

--
-- Struktura tabele `Post`
--

CREATE TABLE `Post` (
  `post_number` int(10) UNSIGNED NOT NULL,
  `post_title` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Odloži podatke za tabelo `Post`
--

INSERT INTO `Post` (`post_number`, `post_title`) VALUES
(1000, 'Ljubljana'),
(1001, 'Ljubljana – P.P.'),
(1210, 'Ljubljana – Šentvid'),
(1211, 'Ljubljana – Šmartno'),
(1215, 'Medvode'),
(1216, 'Smlednik'),
(1217, 'Vodice'),
(1218, 'Komenda'),
(1219, 'Laze v Tuhinju'),
(1221, 'Motnik'),
(1222, 'Trojane'),
(1223, 'Blagovica'),
(1225, 'Lukovica'),
(1230, 'Domžale'),
(1231, 'Ljubljana – Črnuče'),
(1233, 'Dob'),
(1234, 'Mengeš'),
(1235, 'Radomlje'),
(1236, 'Trzin'),
(1241, 'Kamnik'),
(1242, 'Stahovica'),
(1251, 'Moravče'),
(1252, 'Vače'),
(1260, 'Ljubljana – Polje'),
(1261, 'Ljubljana – Dobrunje'),
(1262, 'Dol pri Ljubljani'),
(1270, 'Litija'),
(1272, 'Polšnik'),
(1273, 'Dole pri Litiji'),
(1274, 'Gabrovka'),
(1275, 'Šmartno pri Litiji'),
(1276, 'Primskovo'),
(1281, 'Kresnice'),
(1282, 'Sava'),
(1290, 'Grosuplje'),
(1291, 'Škofljica'),
(1292, 'Ig'),
(1293, 'Šmarje – Sap'),
(1294, 'Višnja Gora'),
(1295, 'Ivančna Gorica'),
(1296, 'Šentvid pri Stični'),
(1301, 'Krka'),
(1303, 'Zagradec'),
(1310, 'Ribnica'),
(1311, 'Turjak'),
(1312, 'Videm – Dobrepolje'),
(1313, 'Struge'),
(1314, 'Rob'),
(1315, 'Velike Lašče'),
(1316, 'Ortnek'),
(1317, 'Sodražica'),
(1318, 'Loški Potok'),
(1319, 'Draga'),
(1330, 'Kočevje'),
(1331, 'Dolenja vas'),
(1332, 'Stara Cerkev'),
(1336, 'Kostel'),
(1337, 'Osilnica'),
(1338, 'Kočevska Reka'),
(1351, 'Brezovica pri Ljubljani'),
(1352, 'Preserje'),
(1353, 'Borovnica'),
(1354, 'Horjul'),
(1355, 'Polhov Gradec'),
(1356, 'Dobrova'),
(1357, 'Notranje Gorice'),
(1358, 'Log pri Brezovici'),
(1360, 'Vrhnika'),
(1370, 'Logatec'),
(1371, 'Logatec'),
(1372, 'Hotedršica'),
(1373, 'Rovte'),
(1380, 'Cerknica'),
(1381, 'Rakek'),
(1382, 'Begunje pri Cerknici'),
(1384, 'Grahovo'),
(1385, 'Nova vas'),
(1386, 'Stari trg pri Ložu'),
(1410, 'Zagorje ob Savi'),
(1411, 'Izlake'),
(1412, 'Kisovec'),
(1413, 'Čemšenik'),
(1414, 'Podkum'),
(1420, 'Trbovlje'),
(1423, 'Dobovec'),
(1430, 'Hrastnik'),
(1431, 'Dol pri Hrastniku'),
(1432, 'Zidani Most'),
(1433, 'Radeče'),
(1434, 'Loka pri Zidanem Mostu'),
(2000, 'Maribor'),
(2001, 'Maribor – P.P.'),
(2201, 'Zgornja Kungota'),
(2204, 'Miklavž na Dravskem polju'),
(2205, 'Starše'),
(2206, 'Marjeta na Dravskem polju'),
(2208, 'Pohorje'),
(2211, 'Pesnica pri Mariboru'),
(2212, 'Šentilj v Slovenskih goricah'),
(2213, 'Zgornja Velka'),
(2214, 'Sladki Vrh'),
(2215, 'Ceršak'),
(2221, 'Jarenina'),
(2222, 'Jakobski Dol'),
(2223, 'Jurovski Dol'),
(2229, 'Malečnik'),
(2230, 'Lenart v Slovenskih goricah'),
(2231, 'Pernica'),
(2232, 'Voličina'),
(2233, 'Sv. Ana v Slovenskih goricah'),
(2234, 'Benedikt'),
(2235, 'Sv. Trojica v Slovenskih goricah'),
(2236, 'Cerkvenjak'),
(2241, 'Spodnji Duplek'),
(2242, 'Zgornja Korena'),
(2250, 'Ptuj'),
(2252, 'Dornava'),
(2253, 'Destrnik'),
(2254, 'Trnovska vas'),
(2255, 'Vitomarci'),
(2256, 'Juršinc'),
(2257, 'Polenšak'),
(2258, 'Sveti Tomaž'),
(2259, 'Ivanjkovci'),
(2270, 'Ormož'),
(2272, 'Gorišnica'),
(2273, 'Podgorci'),
(2274, 'Velika Nedelja'),
(2275, 'Miklavž pri Ormožu'),
(2276, 'Kog'),
(2277, 'Središče ob Dravi'),
(2281, 'Markovci'),
(2282, 'Cirkulane'),
(2283, 'Zavrč'),
(2284, 'Videm pri Ptuju'),
(2285, 'Zgornji Leskovec'),
(2286, 'Podlehnik'),
(2287, 'Žetale'),
(2288, 'Hajdina'),
(2289, 'Stoperce'),
(2310, 'Slovenska Bistrica'),
(2311, 'Hoče'),
(2312, 'Orehova vas'),
(2313, 'Fram'),
(2314, 'Zgornja Polskava'),
(2315, 'Šmartno na Pohorju'),
(2316, 'Zgornja Ložnica'),
(2317, 'Oplotnica'),
(2318, 'Laporje'),
(2319, 'Poljčane'),
(2321, 'Makole'),
(2322, 'Majšperk'),
(2323, 'Ptujska Gora'),
(2324, 'Lovrenc na Dravskem polju'),
(2325, 'Kidričevo'),
(2326, 'Cirkovce'),
(2327, 'Rače'),
(2331, 'Pragersko'),
(2341, 'Limbuš'),
(2342, 'Ruše'),
(2343, 'Fala'),
(2344, 'Lovrenc na Pohorju'),
(2345, 'Bistrica ob Dravi'),
(2351, 'Kamnica'),
(2352, 'Selnica ob Dravi'),
(2353, 'Sveti Duh na Ostrem Vrhu'),
(2354, 'Bresternica'),
(2360, 'Radlje ob Dravi'),
(2361, 'Ožbalt'),
(2362, 'Kapla'),
(2363, 'Podvelka'),
(2364, 'Ribnica na Pohorju'),
(2365, 'Vuhred'),
(2366, 'Muta'),
(2367, 'Vuzenica'),
(2370, 'Dravograd'),
(2371, 'Trbonje'),
(2372, 'Libeliče'),
(2373, 'Šentjanž pri Dravogradu'),
(2380, 'Slovenj Gradec'),
(2381, 'Podgorje pri Slovenj Gradcu'),
(2382, 'Mislinja'),
(2383, 'Šmartno pri Slovenj Gradcu'),
(2390, 'Ravne na Koroškem'),
(2391, 'Prevalje'),
(2392, 'Mežica'),
(2393, 'Črna na Koroškem'),
(2394, 'Kotlje'),
(3000, 'Celje'),
(3001, 'Celje – P.P.'),
(3201, 'Šmartno v Rožni dolini'),
(3202, 'Ljubečna'),
(3203, 'Nova Cerkev'),
(3205, 'Vitanje'),
(3206, 'Stranice'),
(3210, 'Slovenske Konjice'),
(3211, 'Škofja vas'),
(3212, 'Vojnik'),
(3213, 'Frankolovo'),
(3214, 'Zreče'),
(3215, 'Loče'),
(3220, 'Štore'),
(3221, 'Teharje'),
(3222, 'Dramlje'),
(3223, 'Loka pri Žusmu'),
(3224, 'Dobje pri Planini'),
(3225, 'Planina pri Sevnici'),
(3230, 'Šentjur'),
(3231, 'Grobelno'),
(3232, 'Ponikva'),
(3233, 'Kalobje'),
(3240, 'Šmarje pri Jelšah'),
(3241, 'Podplat'),
(3250, 'Rogaška Slatina'),
(3252, 'Rogatec'),
(3253, 'Pristava pri Mestinju'),
(3254, 'Podčetrtek'),
(3255, 'Buče'),
(3256, 'Bistrica ob Sotli'),
(3257, 'Podsreda'),
(3260, 'Kozje'),
(3261, 'Lesično'),
(3262, 'Prevorje'),
(3263, 'Gorica pri Slivnici'),
(3264, 'Sveti Štefan'),
(3270, 'Laško'),
(3271, 'Šentrupert'),
(3272, 'Rimske Toplice'),
(3273, 'Jurklošter'),
(3301, 'Petrovče'),
(3302, 'Griže'),
(3303, 'Gomilsko'),
(3304, 'Tabor'),
(3305, 'Vransko'),
(3310, 'Žalec'),
(3311, 'Šempeter v Savinjski dolini'),
(3312, 'Prebold'),
(3313, 'Polzela'),
(3314, 'Braslovče'),
(3320, 'Velenje'),
(3322, 'Velenje – P.P.'),
(3325, 'Šoštanj'),
(3326, 'Topolšica'),
(3327, 'Šmartno ob Paki'),
(3330, 'Mozirje'),
(3331, 'Nazarje'),
(3332, 'Rečica ob Savinji'),
(3333, 'Ljubno ob Savinji'),
(3334, 'Luče'),
(3335, 'Solčava'),
(3341, 'Šmartno ob Dreti'),
(3342, 'Gornji Grad'),
(4000, 'Kranj'),
(4001, 'Kranj – P.P.'),
(4201, 'Zgornja Besnica'),
(4202, 'Naklo'),
(4203, 'Duplje'),
(4204, 'Golnik'),
(4205, 'Preddvor'),
(4206, 'Zgornje Jezersko'),
(4207, 'Cerklje na Gorenjskem'),
(4208, 'Šenčur'),
(4209, 'Žabnica'),
(4210, 'Brnik – Aerodrom'),
(4211, 'Mavčiče'),
(4212, 'Visoko'),
(4220, 'Škofja Loka'),
(4223, 'Poljane nad Škofjo Loko'),
(4224, 'Gorenja vas'),
(4225, 'Sovodenj'),
(4226, 'Žiri'),
(4227, 'Selca'),
(4228, 'Železniki'),
(4229, 'Sorica'),
(4240, 'Radovljica'),
(4243, 'Brezje'),
(4244, 'Podnart'),
(4245, 'Kropa'),
(4246, 'Kamna Gorica'),
(4247, 'Zgornje Gorje'),
(4248, 'Lesce'),
(4260, 'Bled'),
(4263, 'Bohinjska Bela'),
(4264, 'Bohinjska Bistrica'),
(4265, 'Bohinjsko jezero'),
(4267, 'Srednja vas v Bohinju'),
(4270, 'Jesenice'),
(4273, 'Blejska Dobrava'),
(4274, 'Žirovnica'),
(4275, 'Begunje na Gorenjskem'),
(4276, 'Hrušica'),
(4280, 'Kranjska Gora'),
(4281, 'Mojstrana'),
(4282, 'Gozd Martuljek'),
(4283, 'Rateče – Planica'),
(4290, 'Tržič'),
(4294, 'Križe'),
(5000, 'Nova Gorica'),
(5001, 'Nova Gorica – P.P.'),
(5210, 'Deskle'),
(5211, 'Kojsko'),
(5212, 'Dobrovo v Brdih'),
(5213, 'Kanal'),
(5214, 'Kal nad Kanalom'),
(5215, 'Ročinj'),
(5216, 'Most na Soči'),
(5220, 'Tolmin'),
(5222, 'Kobarid'),
(5223, 'Breginj'),
(5224, 'Srpenica'),
(5230, 'Bovec'),
(5231, 'Log pod Mangartom'),
(5232, 'Soča'),
(5242, 'Grahovo ob Bači'),
(5243, 'Podbrdo'),
(5250, 'Solkan'),
(5251, 'Grgar'),
(5252, 'Trnovo pri Gorici'),
(5253, 'Čepovan'),
(5261, 'Šempas'),
(5262, 'Črniče'),
(5263, 'Dobravlje'),
(5270, 'Ajdovščina'),
(5271, 'Vipava'),
(5272, 'Podnanos'),
(5273, 'Col'),
(5274, 'Črni Vrh nad Idrijo'),
(5275, 'Godovič'),
(5280, 'Idrija'),
(5281, 'Spodnja Idrija'),
(5282, 'Cerkno'),
(5283, 'Slap ob Idrijci'),
(5290, 'Šempeter pri Gorici'),
(5291, 'Miren'),
(5292, 'Renče'),
(5293, 'Volčja Draga'),
(5294, 'Dornberk'),
(5295, 'Branik'),
(5296, 'Kostanjevica na Krasu'),
(5297, 'Prvačina'),
(6000, 'Koper/Capodistria'),
(6001, 'Koper/Capodistria – P.P.'),
(6210, 'Sežana'),
(6215, 'Divača'),
(6216, 'Podgorje'),
(6217, 'Vremski Britof'),
(6219, 'Lokev'),
(6221, 'Dutovlje'),
(6222, 'Štanjel'),
(6223, 'Komen'),
(6224, 'Senožeče'),
(6225, 'Hruševje'),
(6230, 'Postojna'),
(6232, 'Planina'),
(6240, 'Kozina'),
(6242, 'Materija'),
(6243, 'Obrov'),
(6244, 'Podgrad'),
(6250, 'Ilirska Bistrica'),
(6251, 'Ilirska Bistrica-Trnovo'),
(6253, 'Knežak'),
(6254, 'Jelšane'),
(6255, 'Prem'),
(6256, 'Košana'),
(6257, 'Pivka'),
(6258, 'Prestranek'),
(6271, 'Dekani'),
(6272, 'Gračišče'),
(6273, 'Marezige'),
(6274, 'Šmarje'),
(6275, 'Črni Kal'),
(6276, 'Pobegi'),
(6280, 'Ankaran/Ancarano'),
(6281, 'Škofije'),
(6310, 'Izola/Isola'),
(6320, 'Portorož/Portorose'),
(6330, 'Piran/Pirano'),
(6333, 'Sečovlje/Sicciole'),
(8000, 'Novo mesto'),
(8001, 'Novo mesto – P.P.'),
(8210, 'Trebnje'),
(8211, 'Dobrnič'),
(8212, 'Velika Loka'),
(8213, 'Veliki Gaber'),
(8216, 'Mirna Peč'),
(8220, 'Šmarješke Toplice'),
(8222, 'Otočec'),
(8230, 'Mokronog'),
(8231, 'Trebelno'),
(8232, 'Šentrupert'),
(8233, 'Mirna'),
(8250, 'Brežice'),
(8251, 'Čatež ob Savi'),
(8253, 'Artiče'),
(8254, 'Globoko'),
(8255, 'Pišece'),
(8256, 'Sromlje'),
(8257, 'Dobova'),
(8258, 'Kapele'),
(8259, 'Bizeljsko'),
(8261, 'Jesenice na Dolenjskem'),
(8262, 'Krška vas'),
(8263, 'Cerklje ob Krki'),
(8270, 'Krško'),
(8272, 'Zdole'),
(8273, 'Leskovec pri Krškem'),
(8274, 'Raka'),
(8275, 'Škocjan'),
(8276, 'Bučka'),
(8280, 'Brestanica'),
(8281, 'Senovo'),
(8282, 'Koprivnica'),
(8283, 'Blanca'),
(8290, 'Sevnica'),
(8292, 'Zabukovje'),
(8293, 'Studenec'),
(8294, 'Boštanj'),
(8295, 'Tržišče'),
(8296, 'Krmelj'),
(8297, 'Šentjanž'),
(8310, 'Šentjernej'),
(8311, 'Kostanjevica na Krki'),
(8312, 'Podbočje'),
(8321, 'Brusnice'),
(8322, 'Stopiče'),
(8323, 'Uršna sela'),
(8330, 'Metlika'),
(8331, 'Suhor'),
(8332, 'Gradac'),
(8333, 'Semič'),
(8340, 'Črnomelj'),
(8341, 'Adlešiči'),
(8342, 'Stari trg ob Kolpi'),
(8343, 'Dragatuš'),
(8344, 'Vinica'),
(8350, 'Dolenjske Toplice'),
(8351, 'Straža'),
(8360, 'Žužemberk'),
(8361, 'Dvor'),
(8362, 'Hinje'),
(9000, 'Murska Sobota'),
(9001, 'Murska Sobota – P.P.'),
(9201, 'Puconci'),
(9202, 'Mačkovci'),
(9203, 'Petrovci'),
(9204, 'Šalovci'),
(9205, 'Hodoš/Hodos'),
(9206, 'Križevci'),
(9207, 'Prosenjakovci/Partosfalva'),
(9208, 'Fokovci'),
(9220, 'Lendava/Lendva'),
(9221, 'Martjanci'),
(9222, 'Bogojina'),
(9223, 'Dobrovnik/Dobronak'),
(9224, 'Turnišče'),
(9225, 'Velika Polana'),
(9226, 'Moravske Toplice'),
(9227, 'Kobilje'),
(9231, 'Beltinci'),
(9232, 'Črenšovci'),
(9233, 'Odranci'),
(9240, 'Ljutomer'),
(9241, 'Veržej'),
(9242, 'Križevci pri Ljutomeru'),
(9243, 'Mala Nedelja'),
(9244, 'Sveti Jurij ob Ščavnici'),
(9245, 'Spodnji Ivanjci'),
(9250, 'Gornja Radgona'),
(9251, 'Tišina'),
(9252, 'Radenci'),
(9253, 'Apače'),
(9261, 'Cankova'),
(9262, 'Rogašovci'),
(9263, 'Kuzma'),
(9264, 'Grad'),
(9265, 'Bodonci');

-- --------------------------------------------------------

--
-- Struktura tabele `Region`
--

CREATE TABLE `Region` (
  `region_id` int(10) UNSIGNED NOT NULL,
  `region_title` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Odloži podatke za tabelo `Region`
--

INSERT INTO `Region` (`region_id`, `region_title`) VALUES
(13169, 'Lj. Šiška'),
(19119, 'Ivančna Gorica'),
(29378, 'Sežana'),
(47207, 'Lj. Center'),
(52015, 'Postojna'),
(56756, 'Lj. Koseze'),
(58492, 'Lj. Bežigrad'),
(63058, 'Lj. Dravlje'),
(78353, 'Lj. Vič - Rudnik'),
(89541, 'Jesenice'),
(94853, 'Lj. Savlje'),
(97569, 'Lj. Moste - Polje');

-- --------------------------------------------------------

--
-- Struktura tabele `Relationship`
--

CREATE TABLE `Relationship` (
  `relationship_id` int(10) UNSIGNED NOT NULL,
  `relationship_type` varchar(60) COLLATE utf8mb4_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Odloži podatke za tabelo `Relationship`
--

INSERT INTO `Relationship` (`relationship_id`, `relationship_type`) VALUES
(10, 'Mati'),
(11, 'Oče'),
(12, 'Hči'),
(13, 'Sin'),
(20, 'Teta'),
(21, 'Stric'),
(22, 'Nečakinja'),
(23, 'Nečak'),
(24, 'Svakinja'),
(25, 'Svak'),
(26, 'Sestrična'),
(27, 'Bratranec'),
(30, 'Babica'),
(31, 'Dedek'),
(32, 'Vnukinja'),
(33, 'Vnuk'),
(34, 'Tašča'),
(35, 'Tast'),
(36, 'Snaha'),
(37, 'Zet'),
(40, 'Skrbnica'),
(41, 'Skrbnik'),
(50, 'Drugo');

-- --------------------------------------------------------

--
-- Struktura tabele `ResetLink`
--

CREATE TABLE `ResetLink` (
  `reset_link_id` int(10) UNSIGNED NOT NULL,
  `email` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `token` char(64) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Struktura tabele `Substitution`
--

CREATE TABLE `Substitution` (
  `substitution_id` int(10) UNSIGNED NOT NULL,
  `start_date` date NOT NULL,
  `end_date` date NOT NULL,
  `employee_absent` int(11) NOT NULL,
  `employee_substitution` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Struktura tabele `User`
--

CREATE TABLE `User` (
  `user_id` int(10) UNSIGNED NOT NULL,
  `email` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `password` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` datetime NOT NULL,
  `last_login` datetime DEFAULT NULL,
  `active` tinyint(1) NOT NULL DEFAULT '0',
  `remember_token` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `user_role_id` int(10) UNSIGNED NOT NULL,
  `person_id` int(10) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Odloži podatke za tabelo `User`
--

INSERT INTO `User` (`user_id`, `email`, `password`, `created_at`, `last_login`, `active`, `remember_token`, `user_role_id`, `person_id`) VALUES
(1, 'admin@patronaza.tpo', '$2y$10$bIdfW.KOxzaqHj5QE3VNW.KffIWkB4wD6.092wntGeoKqQrieaEs2', '2017-05-10 22:54:23', '2017-05-11 16:33:11', 1, 'BwAy6g3uBy2P168FV64TB25xfCTWaozfQqz3egrzlcaXwIGg0oWgQwU1whmW', 10, 2),
(2, 'zdravnik@patronaza.tpo', '$2y$10$4FiIzpNzTq9I7HnoNNXLcOTuU93M4yLv7g9Jy5zwyll/pnsKVPpom', '2017-05-10 23:08:41', '2017-05-11 16:25:11', 1, 'b3Lv4oYroBusYv2rXV9zlj7ivSb5PUmvjJdYyFjMBgLBh7Y4SohNA6AVhfrg', 21, 5),
(3, 'vodjaPS@patronaza.tpo', '$2y$10$PPVZIaVK6cV/9u/4eEcRlO6H7HBnKohOQm7TPhYJJ2EeTv/tNHlB2', '2017-05-10 23:10:04', '2017-05-11 15:56:01', 1, 'dQQQ7GYXOtBpUg0TVkeOYg73Hy91X6HIZIghMF4jDmZlENZ05yQ9a8txrNwO', 22, 6),
(4, 'sestra.siska@patronaza.tpo', '$2y$10$L2LTAz7NAAQQm5m.mP6MPeMViOu0xNPna4tUOYiYr9ycbSK.39oMC', '2017-05-10 23:11:15', '2017-05-11 04:15:32', 1, 'n3T99gojXzkvzU9ol8EhXGFQyQoxh6Z0FE3DRcJoUlBekds8jGAVlFOgCX6W', 23, 7),
(7, 'contact@patronaza.tpo', '$2y$10$FUwGjznWmWU0WCk/hjoMeuNJA9cw00Zsl2CSiukbvkRZHPPPnCNRi', '2017-05-10 23:19:08', '2017-05-11 03:51:48', 1, 'OYWKsH1PBR1TQixY9lu5vKaGnDZxvT48wPXycuTYb9UsTVRR1jHO8O4p2RbT', 30, 8),
(8, 'zamudnik@patronaza.tpo', '$2y$10$.kvYX2pmcDA8duagoIAnqOUs/7TYtyLB8D1B5UPS0dj0WYoMySgQK', '2017-05-11 01:28:22', NULL, 1, NULL, 30, 9),
(9, 'nocna@patronaza.tpo', '$2y$10$6bEzEHW3fywNYczH8jfD.OylNjHFCC1oozzXPLTUy7wST7Jf5kaUS', '2017-05-11 02:50:23', NULL, 1, NULL, 22, 10),
(10, 'sestra.center@patronaza.tpo', '$2y$10$N3260D0PkDVWo2GxrRlpAeDpg5dF5X6VAecvXj6uveYUm3xhqcPU.', '2017-05-11 12:32:01', '2017-05-11 15:48:42', 1, '8jqm0Rvp5NuEFn2L6plqrDwbOjwnCkZqd5okTyp1lV0Ua6xSLd9ldKIgSMz7', 23, 11),
(11, 'zvonka.center@patronaza.tpo', '$2y$10$N3260D0PkDVWo2GxrRlpAeDpg5dF5X6VAecvXj6uveYUm3xhqcPU.', '2017-05-11 15:02:35', '2017-05-11 15:28:40', 1, 'X8gD30higUPgEmXo70OJWUKd3pGtiku0NTcMGmylyXNAdvjENC0ysp1X771v', 30, 12),
(12, 'verif@test.tpo', '$2y$10$Ul.2of1.Us8KbzVgT8W49e8tO2jpQF.dr5LFEvZpn/fZ7QtOGBOcm', '2017-05-11 15:29:15', NULL, 1, NULL, 30, 14),
(13, 'pacientmarjo@patronaza.tpo', '$2y$10$pBPc/5hSOrsyGe7VEHWDluhnPqNckomG/m9djkvaMUkKDQ.X9aVLK', '2017-05-11 16:00:11', NULL, 1, NULL, 30, 15),
(14, 'zdravnik1@patronaza.tpo', '$2y$10$4nOwe.LLPWTtN9wIbHzloOcPvc1f9UO9ru5oR71GdMxxKn3gFkTpS', '2017-05-11 16:31:23', NULL, 1, NULL, 21, 16),
(15, 'sestra1@patronaza.tpo', '$2y$10$.O7Lx.A7qauk.lLIx9iSS.zPDYBr.nuMYZTElC6mn4pzlXgxxEDbq', '2017-05-11 16:32:47', NULL, 1, NULL, 23, 17),
(16, 'tadej.presern@karkoli.si', '$2y$10$YmBUCPsTyZH1KTXulGwA6O/qbtJwZuW9vLu/obb1WxFGCzEXp12I2', '2017-05-11 16:36:48', '2017-05-11 16:43:03', 1, 'XZ5DxsE948a4ned4alcAVBVsT2Z44m0RWkbZMF5aCfW6UFmQ0JkBKx1UkSO5', 30, 18);

-- --------------------------------------------------------

--
-- Struktura tabele `UserRole`
--

CREATE TABLE `UserRole` (
  `user_role_id` int(10) UNSIGNED NOT NULL,
  `user_role_title` varchar(45) COLLATE utf8mb4_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Odloži podatke za tabelo `UserRole`
--

INSERT INTO `UserRole` (`user_role_id`, `user_role_title`) VALUES
(10, 'Admin'),
(21, 'Zdravnik'),
(22, 'Vodja PS'),
(23, 'Patronažna sestra'),
(24, 'Uslužbenec ZD'),
(30, 'Pacient');

-- --------------------------------------------------------

--
-- Struktura tabele `Verification`
--

CREATE TABLE `Verification` (
  `verification_id` int(10) UNSIGNED NOT NULL,
  `verification_token` char(45) COLLATE utf8mb4_unicode_ci NOT NULL,
  `verification_expiry` datetime NOT NULL,
  `user_id` int(10) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Struktura tabele `Visit`
--

CREATE TABLE `Visit` (
  `visit_id` int(10) UNSIGNED NOT NULL,
  `visit_date` date NOT NULL,
  `first_visit` tinyint(1) NOT NULL,
  `fixed_visit` tinyint(1) NOT NULL,
  `done` tinyint(1) NOT NULL DEFAULT '0',
  `work_order_id` int(10) UNSIGNED NOT NULL,
  `visit_subtype_id` tinyint(10) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Odloži podatke za tabelo `Visit`
--

INSERT INTO `Visit` (`visit_id`, `visit_date`, `first_visit`, `fixed_visit`, `done`, `work_order_id`, `visit_subtype_id`) VALUES
(1, '2017-05-18', 1, 0, 0, 2, 2),
(2, '2017-06-01', 0, 1, 0, 2, 2),
(3, '2017-05-19', 1, 1, 0, 3, 4),
(4, '2017-06-01', 0, 1, 0, 3, 4),
(5, '2017-05-29', 1, 0, 0, 4, 2),
(6, '2017-06-07', 0, 0, 0, 4, 2),
(7, '2017-05-26', 1, 0, 0, 5, 3),
(8, '2017-05-15', 1, 0, 0, 6, 2),
(9, '2017-06-14', 0, 1, 0, 6, 2),
(10, '2017-05-22', 1, 0, 0, 7, 4),
(11, '2017-06-05', 0, 1, 0, 7, 4),
(12, '2017-06-19', 0, 1, 0, 7, 4),
(13, '2017-07-03', 0, 1, 0, 7, 4),
(14, '2017-07-17', 0, 1, 0, 7, 4),
(15, '2017-06-01', 1, 0, 0, 8, 5);

-- --------------------------------------------------------

--
-- Struktura tabele `VisitSubtype`
--

CREATE TABLE `VisitSubtype` (
  `visit_subtype_id` int(10) UNSIGNED NOT NULL,
  `visit_subtype_title` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `visit_type_id` int(10) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Odloži podatke za tabelo `VisitSubtype`
--

INSERT INTO `VisitSubtype` (`visit_subtype_id`, `visit_subtype_title`, `visit_type_id`) VALUES
(1, 'Obisk nosečnice', 1),
(2, 'Obisk novorojenčka in otročnice', 1),
(3, 'Preventiva starostnika', 1),
(4, 'Aplikacija injekcij', 2),
(5, 'Odvzem krvi', 2),
(6, 'Kontrola zdravstvenega stanja', 2);

-- --------------------------------------------------------

--
-- Struktura tabele `VisitType`
--

CREATE TABLE `VisitType` (
  `visit_type_id` int(10) UNSIGNED NOT NULL,
  `visit_type_title` varchar(60) COLLATE utf8mb4_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Odloži podatke za tabelo `VisitType`
--

INSERT INTO `VisitType` (`visit_type_id`, `visit_type_title`) VALUES
(1, 'Preventivni'),
(2, 'Kurativni');

-- --------------------------------------------------------

--
-- Struktura tabele `WorkOrder`
--

CREATE TABLE `WorkOrder` (
  `work_order_id` int(10) UNSIGNED NOT NULL,
  `created_at` datetime NOT NULL,
  `start_date` date NOT NULL,
  `end_date` date NOT NULL,
  `substitution` tinyint(1) NOT NULL DEFAULT '0',
  `visit_subtype_id` int(10) UNSIGNED DEFAULT NULL,
  `performer_id` int(11) NOT NULL,
  `prescriber_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Odloži podatke za tabelo `WorkOrder`
--

INSERT INTO `WorkOrder` (`work_order_id`, `created_at`, `start_date`, `end_date`, `substitution`, `visit_subtype_id`, `performer_id`, `prescriber_id`) VALUES
(1, '2017-05-11 15:35:26', '2017-05-18', '2017-06-01', 0, NULL, 94252, 1222),
(2, '2017-05-11 15:41:24', '2017-05-18', '2017-06-01', 0, NULL, 94252, 1222),
(3, '2017-05-11 15:42:44', '2017-05-19', '2017-06-01', 0, NULL, 94252, 1222),
(4, '2017-05-11 15:47:30', '2017-05-29', '2017-06-09', 0, NULL, 94252, 66553),
(5, '2017-05-11 16:12:17', '2017-05-26', '2017-05-26', 0, NULL, 94252, 1222),
(6, '2017-05-11 16:48:02', '2017-05-15', '2017-06-14', 0, NULL, 94252, 99522),
(7, '2017-05-11 16:51:17', '2017-05-22', '2017-07-17', 0, NULL, 94252, 99522),
(8, '2017-05-11 16:52:46', '2017-06-01', '2017-06-01', 0, NULL, 94252, 99522);

-- --------------------------------------------------------

--
-- Struktura tabele `WorkOrder_BloodTubes`
--

CREATE TABLE `WorkOrder_BloodTubes` (
  `blood_tube_id` int(10) UNSIGNED NOT NULL,
  `work_order_id` int(10) UNSIGNED NOT NULL,
  `num_of_tubes` int(10) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Odloži podatke za tabelo `WorkOrder_BloodTubes`
--

INSERT INTO `WorkOrder_BloodTubes` (`blood_tube_id`, `work_order_id`, `num_of_tubes`) VALUES
(996, 8, 1),
(997, 8, 2),
(998, 8, 3),
(999, 8, 5);

-- --------------------------------------------------------

--
-- Struktura tabele `WorkOrder_Illness`
--

CREATE TABLE `WorkOrder_Illness` (
  `illness_id` varchar(7) COLLATE utf8mb4_unicode_ci NOT NULL,
  `work_order_id` int(10) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Struktura tabele `WorkOrder_Material`
--

CREATE TABLE `WorkOrder_Material` (
  `material_id` int(10) UNSIGNED NOT NULL,
  `work_order_id` int(10) UNSIGNED NOT NULL,
  `material_quantity` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Struktura tabele `WorkOrder_Measurement`
--

CREATE TABLE `WorkOrder_Measurement` (
  `measurement_id` int(10) UNSIGNED NOT NULL,
  `work_order_id` int(10) UNSIGNED NOT NULL,
  `num_of_units` int(10) UNSIGNED DEFAULT NULL,
  `measurement_date` date DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Odloži podatke za tabelo `WorkOrder_Measurement`
--

INSERT INTO `WorkOrder_Measurement` (`measurement_id`, `work_order_id`, `num_of_units`, `measurement_date`) VALUES
(10, 1, NULL, NULL),
(11, 1, NULL, NULL),
(12, 1, NULL, NULL),
(13, 1, NULL, NULL),
(14, 1, NULL, NULL),
(19, 1, NULL, NULL),
(15, 1, NULL, NULL),
(18, 1, NULL, NULL),
(22, 1, NULL, NULL),
(10, 2, NULL, NULL),
(11, 2, NULL, NULL),
(12, 2, NULL, NULL),
(13, 2, NULL, NULL),
(14, 2, NULL, NULL),
(19, 2, NULL, NULL),
(15, 2, NULL, NULL),
(18, 2, NULL, NULL),
(22, 2, NULL, NULL),
(10, 4, NULL, NULL),
(11, 4, NULL, NULL),
(12, 4, NULL, NULL),
(13, 4, NULL, NULL),
(14, 4, NULL, NULL),
(19, 4, NULL, NULL),
(15, 4, NULL, NULL),
(18, 4, NULL, NULL),
(22, 4, NULL, NULL),
(10, 5, NULL, NULL),
(11, 5, NULL, NULL),
(12, 5, NULL, NULL),
(13, 5, NULL, NULL),
(14, 5, NULL, NULL),
(19, 5, NULL, NULL),
(10, 6, NULL, NULL),
(11, 6, NULL, NULL),
(12, 6, NULL, NULL),
(13, 6, NULL, NULL),
(14, 6, NULL, NULL),
(19, 6, NULL, NULL),
(15, 6, NULL, NULL),
(18, 6, NULL, NULL),
(22, 6, NULL, NULL);

-- --------------------------------------------------------

--
-- Struktura tabele `WorkOrder_Medicine`
--

CREATE TABLE `WorkOrder_Medicine` (
  `medicine_id` int(10) UNSIGNED NOT NULL,
  `work_order_id` int(10) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Odloži podatke za tabelo `WorkOrder_Medicine`
--

INSERT INTO `WorkOrder_Medicine` (`medicine_id`, `work_order_id`) VALUES
(14621, 3),
(19011, 3),
(24872, 3),
(17108, 7),
(30554, 7);

-- --------------------------------------------------------

--
-- Struktura tabele `WorkOrder_Patient`
--

CREATE TABLE `WorkOrder_Patient` (
  `patient_id` int(10) UNSIGNED NOT NULL,
  `work_order_id` int(10) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Odloži podatke za tabelo `WorkOrder_Patient`
--

INSERT INTO `WorkOrder_Patient` (`patient_id`, `work_order_id`) VALUES
(7, 1),
(8, 1),
(7, 2),
(8, 2),
(7, 3),
(7, 4),
(8, 4),
(10, 5),
(7, 6),
(8, 6),
(10, 7),
(11, 8);

--
-- Indeksi zavrženih tabel
--

--
-- Indeksi tabele `BloodTube`
--
ALTER TABLE `BloodTube`
  ADD PRIMARY KEY (`blood_tube_id`);

--
-- Indeksi tabele `Contact`
--
ALTER TABLE `Contact`
  ADD PRIMARY KEY (`contact_id`),
  ADD KEY `contact_post_number_foreign` (`post_number`),
  ADD KEY `contact_relationship_id_foreign` (`relationship_id`);

--
-- Indeksi tabele `DependentPatient`
--
ALTER TABLE `DependentPatient`
  ADD KEY `dependentpatient_dependent_patient_id_foreign` (`dependent_patient_id`),
  ADD KEY `dependentpatient_guardian_patient_id_foreign` (`guardian_patient_id`),
  ADD KEY `dependentpatient_relationship_id_foreign` (`relationship_id`);

--
-- Indeksi tabele `Employee`
--
ALTER TABLE `Employee`
  ADD PRIMARY KEY (`employee_id`),
  ADD KEY `employee_person_id_foreign` (`person_id`),
  ADD KEY `employee_institution_id_foreign` (`institution_id`);

--
-- Indeksi tabele `FreeDays`
--
ALTER TABLE `FreeDays`
  ADD PRIMARY KEY (`free_day`);

--
-- Indeksi tabele `Illness`
--
ALTER TABLE `Illness`
  ADD PRIMARY KEY (`illness_id`);

--
-- Indeksi tabele `Institution`
--
ALTER TABLE `Institution`
  ADD PRIMARY KEY (`institution_id`),
  ADD KEY `institution_post_number_foreign` (`post_number`);

--
-- Indeksi tabele `Material`
--
ALTER TABLE `Material`
  ADD PRIMARY KEY (`material_id`);

--
-- Indeksi tabele `Measurement`
--
ALTER TABLE `Measurement`
  ADD PRIMARY KEY (`measurement_id`);

--
-- Indeksi tabele `Medicine`
--
ALTER TABLE `Medicine`
  ADD PRIMARY KEY (`medicine_id`);

--
-- Indeksi tabele `migrations`
--
ALTER TABLE `migrations`
  ADD PRIMARY KEY (`id`);

--
-- Indeksi tabele `Patient`
--
ALTER TABLE `Patient`
  ADD PRIMARY KEY (`patient_id`),
  ADD KEY `patient_person_id_foreign` (`person_id`),
  ADD KEY `patient_contact_id_foreign` (`contact_id`);

--
-- Indeksi tabele `Person`
--
ALTER TABLE `Person`
  ADD PRIMARY KEY (`person_id`),
  ADD KEY `person_post_number_foreign` (`post_number`),
  ADD KEY `person_region_id_foreign` (`region_id`);

--
-- Indeksi tabele `Post`
--
ALTER TABLE `Post`
  ADD PRIMARY KEY (`post_number`);

--
-- Indeksi tabele `Region`
--
ALTER TABLE `Region`
  ADD PRIMARY KEY (`region_id`);

--
-- Indeksi tabele `Relationship`
--
ALTER TABLE `Relationship`
  ADD PRIMARY KEY (`relationship_id`);

--
-- Indeksi tabele `ResetLink`
--
ALTER TABLE `ResetLink`
  ADD PRIMARY KEY (`reset_link_id`),
  ADD UNIQUE KEY `resetlink_email_unique` (`email`);

--
-- Indeksi tabele `Substitution`
--
ALTER TABLE `Substitution`
  ADD PRIMARY KEY (`substitution_id`),
  ADD KEY `substitution_employee_absent_foreign` (`employee_absent`),
  ADD KEY `substitution_employee_substitution_foreign` (`employee_substitution`);

--
-- Indeksi tabele `User`
--
ALTER TABLE `User`
  ADD PRIMARY KEY (`user_id`),
  ADD UNIQUE KEY `user_email_unique` (`email`),
  ADD KEY `user_user_role_id_foreign` (`user_role_id`),
  ADD KEY `user_person_id_foreign` (`person_id`);

--
-- Indeksi tabele `UserRole`
--
ALTER TABLE `UserRole`
  ADD PRIMARY KEY (`user_role_id`);

--
-- Indeksi tabele `Verification`
--
ALTER TABLE `Verification`
  ADD PRIMARY KEY (`verification_id`),
  ADD KEY `verification_user_id_foreign` (`user_id`);

--
-- Indeksi tabele `Visit`
--
ALTER TABLE `Visit`
  ADD PRIMARY KEY (`visit_id`),
  ADD KEY `visit_work_order_id_foreign` (`work_order_id`);

--
-- Indeksi tabele `VisitSubtype`
--
ALTER TABLE `VisitSubtype`
  ADD PRIMARY KEY (`visit_subtype_id`),
  ADD KEY `visitsubtype_visit_type_id_foreign` (`visit_type_id`);

--
-- Indeksi tabele `VisitType`
--
ALTER TABLE `VisitType`
  ADD PRIMARY KEY (`visit_type_id`);

--
-- Indeksi tabele `WorkOrder`
--
ALTER TABLE `WorkOrder`
  ADD PRIMARY KEY (`work_order_id`),
  ADD KEY `workorder_visit_subtype_id_foreign` (`visit_subtype_id`),
  ADD KEY `workorder_performer_id_foreign` (`performer_id`),
  ADD KEY `workorder_prescriber_id_foreign` (`prescriber_id`);

--
-- Indeksi tabele `WorkOrder_BloodTubes`
--
ALTER TABLE `WorkOrder_BloodTubes`
  ADD KEY `workorder_bloodtubes_blood_tube_id_foreign` (`blood_tube_id`),
  ADD KEY `workorder_bloodtubes_work_order_id_foreign` (`work_order_id`);

--
-- Indeksi tabele `WorkOrder_Illness`
--
ALTER TABLE `WorkOrder_Illness`
  ADD KEY `workorder_illness_illness_id_foreign` (`illness_id`),
  ADD KEY `workorder_illness_work_order_id_foreign` (`work_order_id`);

--
-- Indeksi tabele `WorkOrder_Material`
--
ALTER TABLE `WorkOrder_Material`
  ADD KEY `workorder_material_material_id_foreign` (`material_id`),
  ADD KEY `workorder_material_work_order_id_foreign` (`work_order_id`);

--
-- Indeksi tabele `WorkOrder_Measurement`
--
ALTER TABLE `WorkOrder_Measurement`
  ADD KEY `workorder_measurement_measurement_id_foreign` (`measurement_id`),
  ADD KEY `workorder_measurement_work_order_id_foreign` (`work_order_id`);

--
-- Indeksi tabele `WorkOrder_Medicine`
--
ALTER TABLE `WorkOrder_Medicine`
  ADD KEY `workorder_medicine_medicine_id_foreign` (`medicine_id`),
  ADD KEY `workorder_medicine_work_order_id_foreign` (`work_order_id`);

--
-- Indeksi tabele `WorkOrder_Patient`
--
ALTER TABLE `WorkOrder_Patient`
  ADD KEY `workorder_patient_patient_id_foreign` (`patient_id`),
  ADD KEY `workorder_patient_work_order_id_foreign` (`work_order_id`);

--
-- AUTO_INCREMENT zavrženih tabel
--

--
-- AUTO_INCREMENT tabele `BloodTube`
--
ALTER TABLE `BloodTube`
  MODIFY `blood_tube_id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=1000;
--
-- AUTO_INCREMENT tabele `Contact`
--
ALTER TABLE `Contact`
  MODIFY `contact_id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;
--
-- AUTO_INCREMENT tabele `Institution`
--
ALTER TABLE `Institution`
  MODIFY `institution_id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6502;
--
-- AUTO_INCREMENT tabele `Material`
--
ALTER TABLE `Material`
  MODIFY `material_id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=64824;
--
-- AUTO_INCREMENT tabele `Measurement`
--
ALTER TABLE `Measurement`
  MODIFY `measurement_id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=23;
--
-- AUTO_INCREMENT tabele `Medicine`
--
ALTER TABLE `Medicine`
  MODIFY `medicine_id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=64824;
--
-- AUTO_INCREMENT tabele `migrations`
--
ALTER TABLE `migrations`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=32;
--
-- AUTO_INCREMENT tabele `Patient`
--
ALTER TABLE `Patient`
  MODIFY `patient_id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;
--
-- AUTO_INCREMENT tabele `Person`
--
ALTER TABLE `Person`
  MODIFY `person_id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=20;
--
-- AUTO_INCREMENT tabele `Region`
--
ALTER TABLE `Region`
  MODIFY `region_id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=97570;
--
-- AUTO_INCREMENT tabele `Relationship`
--
ALTER TABLE `Relationship`
  MODIFY `relationship_id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=51;
--
-- AUTO_INCREMENT tabele `ResetLink`
--
ALTER TABLE `ResetLink`
  MODIFY `reset_link_id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT tabele `Substitution`
--
ALTER TABLE `Substitution`
  MODIFY `substitution_id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT tabele `User`
--
ALTER TABLE `User`
  MODIFY `user_id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=17;
--
-- AUTO_INCREMENT tabele `UserRole`
--
ALTER TABLE `UserRole`
  MODIFY `user_role_id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=31;
--
-- AUTO_INCREMENT tabele `Verification`
--
ALTER TABLE `Verification`
  MODIFY `verification_id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;
--
-- AUTO_INCREMENT tabele `Visit`
--
ALTER TABLE `Visit`
  MODIFY `visit_id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=16;
--
-- AUTO_INCREMENT tabele `VisitSubtype`
--
ALTER TABLE `VisitSubtype`
  MODIFY `visit_subtype_id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;
--
-- AUTO_INCREMENT tabele `VisitType`
--
ALTER TABLE `VisitType`
  MODIFY `visit_type_id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;
--
-- AUTO_INCREMENT tabele `WorkOrder`
--
ALTER TABLE `WorkOrder`
  MODIFY `work_order_id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;
--
-- Omejitve tabel za povzetek stanja
--

--
-- Omejitve za tabelo `Contact`
--
ALTER TABLE `Contact`
  ADD CONSTRAINT `contact_post_number_foreign` FOREIGN KEY (`post_number`) REFERENCES `Post` (`post_number`),
  ADD CONSTRAINT `contact_relationship_id_foreign` FOREIGN KEY (`relationship_id`) REFERENCES `Relationship` (`relationship_id`);

--
-- Omejitve za tabelo `DependentPatient`
--
ALTER TABLE `DependentPatient`
  ADD CONSTRAINT `dependentpatient_dependent_patient_id_foreign` FOREIGN KEY (`dependent_patient_id`) REFERENCES `Patient` (`patient_id`),
  ADD CONSTRAINT `dependentpatient_guardian_patient_id_foreign` FOREIGN KEY (`guardian_patient_id`) REFERENCES `Patient` (`patient_id`),
  ADD CONSTRAINT `dependentpatient_relationship_id_foreign` FOREIGN KEY (`relationship_id`) REFERENCES `Relationship` (`relationship_id`);

--
-- Omejitve za tabelo `Employee`
--
ALTER TABLE `Employee`
  ADD CONSTRAINT `employee_institution_id_foreign` FOREIGN KEY (`institution_id`) REFERENCES `Institution` (`institution_id`),
  ADD CONSTRAINT `employee_person_id_foreign` FOREIGN KEY (`person_id`) REFERENCES `Person` (`person_id`);

--
-- Omejitve za tabelo `Institution`
--
ALTER TABLE `Institution`
  ADD CONSTRAINT `institution_post_number_foreign` FOREIGN KEY (`post_number`) REFERENCES `Post` (`post_number`);

--
-- Omejitve za tabelo `Patient`
--
ALTER TABLE `Patient`
  ADD CONSTRAINT `patient_contact_id_foreign` FOREIGN KEY (`contact_id`) REFERENCES `Contact` (`contact_id`),
  ADD CONSTRAINT `patient_person_id_foreign` FOREIGN KEY (`person_id`) REFERENCES `Person` (`person_id`);

--
-- Omejitve za tabelo `Person`
--
ALTER TABLE `Person`
  ADD CONSTRAINT `person_post_number_foreign` FOREIGN KEY (`post_number`) REFERENCES `Post` (`post_number`),
  ADD CONSTRAINT `person_region_id_foreign` FOREIGN KEY (`region_id`) REFERENCES `Region` (`region_id`);

--
-- Omejitve za tabelo `Substitution`
--
ALTER TABLE `Substitution`
  ADD CONSTRAINT `substitution_employee_absent_foreign` FOREIGN KEY (`employee_absent`) REFERENCES `Employee` (`employee_id`),
  ADD CONSTRAINT `substitution_employee_substitution_foreign` FOREIGN KEY (`employee_substitution`) REFERENCES `Employee` (`employee_id`);

--
-- Omejitve za tabelo `User`
--
ALTER TABLE `User`
  ADD CONSTRAINT `user_person_id_foreign` FOREIGN KEY (`person_id`) REFERENCES `Person` (`person_id`),
  ADD CONSTRAINT `user_user_role_id_foreign` FOREIGN KEY (`user_role_id`) REFERENCES `UserRole` (`user_role_id`);

--
-- Omejitve za tabelo `Verification`
--
ALTER TABLE `Verification`
  ADD CONSTRAINT `verification_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `User` (`user_id`);

--
-- Omejitve za tabelo `Visit`
--
ALTER TABLE `Visit`
  ADD CONSTRAINT `visit_work_order_id_foreign` FOREIGN KEY (`work_order_id`) REFERENCES `WorkOrder` (`work_order_id`);

--
-- Omejitve za tabelo `VisitSubtype`
--
ALTER TABLE `VisitSubtype`
  ADD CONSTRAINT `visitsubtype_visit_type_id_foreign` FOREIGN KEY (`visit_type_id`) REFERENCES `VisitType` (`visit_type_id`);

--
-- Omejitve za tabelo `WorkOrder`
--
ALTER TABLE `WorkOrder`
  ADD CONSTRAINT `workorder_performer_id_foreign` FOREIGN KEY (`performer_id`) REFERENCES `Employee` (`employee_id`),
  ADD CONSTRAINT `workorder_prescriber_id_foreign` FOREIGN KEY (`prescriber_id`) REFERENCES `Employee` (`employee_id`),
  ADD CONSTRAINT `workorder_visit_subtype_id_foreign` FOREIGN KEY (`visit_subtype_id`) REFERENCES `VisitSubtype` (`visit_subtype_id`);

--
-- Omejitve za tabelo `WorkOrder_BloodTubes`
--
ALTER TABLE `WorkOrder_BloodTubes`
  ADD CONSTRAINT `workorder_bloodtubes_blood_tube_id_foreign` FOREIGN KEY (`blood_tube_id`) REFERENCES `BloodTube` (`blood_tube_id`),
  ADD CONSTRAINT `workorder_bloodtubes_work_order_id_foreign` FOREIGN KEY (`work_order_id`) REFERENCES `WorkOrder` (`work_order_id`);

--
-- Omejitve za tabelo `WorkOrder_Illness`
--
ALTER TABLE `WorkOrder_Illness`
  ADD CONSTRAINT `workorder_illness_illness_id_foreign` FOREIGN KEY (`illness_id`) REFERENCES `Illness` (`illness_id`),
  ADD CONSTRAINT `workorder_illness_work_order_id_foreign` FOREIGN KEY (`work_order_id`) REFERENCES `WorkOrder` (`work_order_id`);

--
-- Omejitve za tabelo `WorkOrder_Material`
--
ALTER TABLE `WorkOrder_Material`
  ADD CONSTRAINT `workorder_material_material_id_foreign` FOREIGN KEY (`material_id`) REFERENCES `Material` (`material_id`),
  ADD CONSTRAINT `workorder_material_work_order_id_foreign` FOREIGN KEY (`work_order_id`) REFERENCES `WorkOrder` (`work_order_id`);

--
-- Omejitve za tabelo `WorkOrder_Measurement`
--
ALTER TABLE `WorkOrder_Measurement`
  ADD CONSTRAINT `workorder_measurement_measurement_id_foreign` FOREIGN KEY (`measurement_id`) REFERENCES `Measurement` (`measurement_id`),
  ADD CONSTRAINT `workorder_measurement_work_order_id_foreign` FOREIGN KEY (`work_order_id`) REFERENCES `WorkOrder` (`work_order_id`);

--
-- Omejitve za tabelo `WorkOrder_Medicine`
--
ALTER TABLE `WorkOrder_Medicine`
  ADD CONSTRAINT `workorder_medicine_medicine_id_foreign` FOREIGN KEY (`medicine_id`) REFERENCES `Medicine` (`medicine_id`),
  ADD CONSTRAINT `workorder_medicine_work_order_id_foreign` FOREIGN KEY (`work_order_id`) REFERENCES `WorkOrder` (`work_order_id`);

--
-- Omejitve za tabelo `WorkOrder_Patient`
--
ALTER TABLE `WorkOrder_Patient`
  ADD CONSTRAINT `workorder_patient_patient_id_foreign` FOREIGN KEY (`patient_id`) REFERENCES `Patient` (`patient_id`),
  ADD CONSTRAINT `workorder_patient_work_order_id_foreign` FOREIGN KEY (`work_order_id`) REFERENCES `WorkOrder` (`work_order_id`);

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
