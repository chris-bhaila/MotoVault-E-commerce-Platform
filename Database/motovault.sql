-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Aug 03, 2025 at 07:48 PM
-- Server version: 10.4.32-MariaDB
-- PHP Version: 8.2.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `motovault`
--

-- --------------------------------------------------------

--
-- Table structure for table `admin`
--

CREATE TABLE `admin` (
  `aid` int(255) NOT NULL,
  `name` char(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL,
  `phone_number` bigint(255) NOT NULL,
  `reg_date` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `admin`
--

INSERT INTO `admin` (`aid`, `name`, `email`, `password`, `phone_number`, `reg_date`) VALUES
(2, 'Admin', 'admin@gmail.com', 'Admin@123', 9880000000, '2024-12-19 10:08:02');

-- --------------------------------------------------------

--
-- Table structure for table `brands`
--

CREATE TABLE `brands` (
  `brand_id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `image` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `brands`
--

INSERT INTO `brands` (`brand_id`, `name`, `image`) VALUES
(1, 'AGV', 'agv-seeklogo-3.svg'),
(2, 'Shoei', 'shoei.svg'),
(3, 'LS2', 'ls2.svg'),
(4, 'Axor', 'axor.svg'),
(5, 'HJC', 'hjc.svg'),
(6, 'Airoh', 'airoh.svg'),
(7, 'Alpinestars', 'alpine.svg'),
(8, 'Akrapovic', 'akrapovic.svg'),
(9, 'Arai', 'arai.svg'),
(10, 'M2R', 'm2r.svg'),
(11, 'Brembo', 'brembo.svg'),
(12, 'Suzuki', 'suzuki.svg'),
(14, 'No Brand', 'question.png'),
(15, 'Bell', 'bell.jpg'),
(16, 'ProTaper', 'Pro Taper.png'),
(17, 'Shark', 'shark_helmets.png'),
(18, 'Vesrah', 'Vesrah Logo Vector.png'),
(19, 'Liqui Molly', 'Liqui-Molly.png'),
(20, 'Kadoya', 'kadoya.png'),
(21, 'O\'neal', 'oneal.png'),
(22, 'MT Helmets', 'MTHelmets.png'),
(23, 'Rizoma', 'Rizaoma.png'),
(24, 'Motul', 'Motul.png'),
(25, 'K-Tech', 'KTech.png'),
(26, 'Yoshimura', 'Yoshimura.jpg'),
(27, 'Bridgestone', 'Bridgestone-Logo.png'),
(28, 'Michelin', 'Michelin.jpg'),
(29, 'Rynox', 'Rynox.png'),
(30, 'Dainese', 'Dainese-Logo.jpg'),
(31, 'Kavach', 'Kavach.png'),
(32, 'TR Tiger', 'TRTiger.png'),
(33, 'Motowolf', 'Motowolf.webp'),
(34, 'ScorpionEXO', 'ScorpionEXO.png');

-- --------------------------------------------------------

--
-- Table structure for table `categories`
--

CREATE TABLE `categories` (
  `category_id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `image` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `categories`
--

INSERT INTO `categories` (`category_id`, `name`, `image`) VALUES
(2, 'Helmets', 'full.png'),
(4, 'Riding Gear', 'gear.png'),
(5, 'Parts', 'parts.png'),
(6, 'Accessories', 'phone.png'),
(7, 'Motorbike', 'motorbike.png');

-- --------------------------------------------------------

--
-- Table structure for table `c_orders`
--

CREATE TABLE `c_orders` (
  `prim_id` int(255) NOT NULL,
  `bulk_id` int(255) NOT NULL,
  `user_id` int(11) NOT NULL,
  `product_id` int(255) NOT NULL,
  `name` char(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `ph_num` bigint(10) NOT NULL,
  `alt_ph_num` bigint(10) NOT NULL,
  `prod_name` varchar(255) NOT NULL,
  `prod_price` int(255) NOT NULL,
  `prod_quantity` int(255) NOT NULL,
  `street_name` varchar(255) NOT NULL,
  `tole` varchar(255) NOT NULL,
  `municipality` char(255) NOT NULL,
  `district` char(255) NOT NULL,
  `payment_method` char(255) NOT NULL,
  `placed_date` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `completed_date` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `c_orders`
--

INSERT INTO `c_orders` (`prim_id`, `bulk_id`, `user_id`, `product_id`, `name`, `email`, `ph_num`, `alt_ph_num`, `prod_name`, `prod_price`, `prod_quantity`, `street_name`, `tole`, `municipality`, `district`, `payment_method`, `placed_date`, `completed_date`) VALUES
(11, 28021671, 16, 43, 'Chris', 'chrisbhaila5@gmail.com', 9844379971, 0, 'ACF Handlebar', 16000, 2, 'Suryabinayak', 'Sipadol', 'Suryabinayak', 'Bhaktapur', 'Cash-on-Delivery', '2025-02-28 15:22:26', '2025-02-28 15:22:46'),
(12, 28021671, 16, 61, 'Chris', 'chrisbhaila5@gmail.com', 9844379971, 0, 'GP-R7 1PC Leather Suit', 160000, 1, 'Suryabinayak', 'Sipadol', 'Suryabinayak', 'Bhaktapur', 'Cash-on-Delivery', '2025-02-28 15:22:26', '2025-02-28 15:22:46'),
(13, 28021671, 16, 12, 'Chris', 'chrisbhaila5@gmail.com', 9844379971, 0, 'SOMAN Balaclava', 800, 7, 'Suryabinayak', 'Sipadol', 'Suryabinayak', 'Bhaktapur', 'Cash-on-Delivery', '2025-02-28 15:22:26', '2025-02-28 15:22:46'),
(14, 28021657, 16, 56, 'Chris', 'chrisbhaila5@gmail.com', 9844379971, 0, 'RCB HG66 Handle Grip Grey', 1500, 5, 'Suryabinayak', 'Sipadol', 'Suryabinayak', 'Bhaktapur', 'Cash-on-Delivery', '2025-02-28 17:00:21', '2025-02-28 17:00:40'),
(15, 1031694, 16, 58, 'Chris', 'chrisbhaila5@gmail.com', 9844379971, 0, 'JPA R15 V3/V4 Integrated Taillight', 7000, 1, 'Suryabinayak', 'Sipadol', 'Suryabinayak', 'Bhaktapur', 'Cash-on-Delivery', '2025-03-01 05:04:28', '2025-03-01 05:04:38'),
(16, 1031694, 16, 57, 'Chris', 'chrisbhaila5@gmail.com', 9844379971, 0, 'Vesrah Ceramic Disc Brake pad for KTM ALL /ROYAL ENFIELD ALL/ BAJAJ ALL/ BMW ALL SD-953 (Rear)', 2300, 1, 'Suryabinayak', 'Sipadol', 'Suryabinayak', 'Bhaktapur', 'Cash-on-Delivery', '2025-03-01 05:04:28', '2025-03-01 05:04:38'),
(17, 25021782, 17, 54, 'John Doe', 'johndoe@gmail.com', 9801010101, 0, 'LS2 Drifter Gloss White', 12499, 1, 'Oakridge Lane', 'Greenview Heights', 'Willowbrook Township', 'Crestwood', 'Cash-on-Delivery', '2025-02-25 05:34:11', '2025-02-25 05:34:56'),
(18, 25021782, 17, 12, 'John Doe', 'johndoe@gmail.com', 9801010101, 0, 'SOMAN Balaclava', 800, 4, 'Oakridge Lane', 'Greenview Heights', 'Willowbrook Township', 'Crestwood', 'Cash-on-Delivery', '2025-02-25 05:34:11', '2025-02-25 05:34:56'),
(19, 1031924, 19, 53, 'Ava Clark', 'avaclark@gmail.com', 9803030303, 0, 'Shark VFX-EVO', 60000, 1, 'Main Road', 'Basantapur', 'Kathmandu', 'Kathmandu', 'Cash-on-Delivery', '2025-03-01 17:59:16', '2025-03-01 17:59:39'),
(20, 2031871, 18, 63, 'James Wilson', 'jameswilson@gmail.com', 9820202020, 0, 'KADOYA K’s Leather Early 00s ‘STEALTH’ Padded Leather Motorcycle Jacket', 90000, 1, 'Elm Street', 'Elm Street', 'Springfield', 'Massachussets', 'Cash-on-Delivery', '2025-03-02 15:24:18', '2025-03-02 15:24:29'),
(21, 2031871, 18, 64, 'James Wilson', 'jameswilson@gmail.com', 9820202020, 0, 'O’neal Matrix Ridewear Black Pants', 14385, 1, 'Elm Street', 'Elm Street', 'Springfield', 'Massachussets', 'Cash-on-Delivery', '2025-03-02 15:24:18', '2025-03-02 15:24:29'),
(22, 8041670, 16, 8, 'Chris', 'chrisbhaila5@gmail.com', 9844379971, 0, 'AGV PISTA GP RR Performante Carbon', 250000, 1, 'pataan', 'nyadhal', 'lalitpur', 'Lalitpur', 'Cash-on-Delivery', '2025-04-08 04:55:23', '2025-05-28 14:26:52'),
(23, 3081615, 16, 50032, 'Chris', 'chrisbhaila5@gmail.com', 9844379971, 0, 'Motowolf MDL1904 Black Balaclava Mask', 1000, 2, 'Suryabinayak', 'Sipadol', 'Suryabinayak', 'Bhaktapur', 'Cash-on-Delivery', '2025-08-03 06:26:57', '2025-08-03 06:27:22'),
(24, 3081615, 16, 50001, 'Chris', 'chrisbhaila5@gmail.com', 9844379971, 0, 'LS2 Smoke Visor for LS2 Rapid Full Face Motorcycle Helmet', 1400, 1, 'Suryabinayak', 'Sipadol', 'Suryabinayak', 'Bhaktapur', 'Cash-on-Delivery', '2025-08-03 06:26:57', '2025-08-03 06:27:22'),
(25, 3081615, 16, 50003, 'Chris', 'chrisbhaila5@gmail.com', 9844379971, 0, 'Rizoma 1 1/8″ Handlebar', 14000, 1, 'Suryabinayak', 'Sipadol', 'Suryabinayak', 'Bhaktapur', 'Cash-on-Delivery', '2025-08-03 06:26:57', '2025-08-03 06:27:22');

-- --------------------------------------------------------

--
-- Table structure for table `motoproducts`
--

CREATE TABLE `motoproducts` (
  `product_id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `price` int(11) NOT NULL,
  `brand_fid` int(11) NOT NULL,
  `category_fid` int(11) NOT NULL,
  `sub_cat_fid` int(255) NOT NULL,
  `stock` int(11) NOT NULL,
  `description` text DEFAULT NULL,
  `features` text DEFAULT NULL,
  `image` varchar(255) NOT NULL,
  `tags` varchar(255) NOT NULL,
  `timestamp` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `motoproducts`
--

INSERT INTO `motoproducts` (`product_id`, `name`, `price`, `brand_fid`, `category_fid`, `sub_cat_fid`, `stock`, `description`, `features`, `image`, `tags`, `timestamp`) VALUES
(7, 'AGV PISTA GP R Winter Test 2018', 220000, 1, 2, 1, 3, '100% carbon fiber helmet offering unparalleled lightweight performance. The evolution of the groundbreaking Pista GP, the Moto GP helmet, it’s the most protective helmet ever developed. Its new “Biplano” spoiler and its included hydration system bring AGV’s safety and performances to the next level.', 'Double buckle closure.!\r\nHydration system fully integrated into the helmet, developed in MotoGP.!\r\nRoto-translational system in the mechanism for a perfect fit of the screen to the helmet.!\r\nEmergency release system of the side padding in the event of an accident, to facilitate helmet removal by medical personnel.    ', 'AGV PISTA GP R Winter Test 2018.jpg', 'helmet, full-face, carbon fiber, MotoGP, hydration system, high performance, premium, AGV, racing, winter test, professional', '2025-05-29 15:38:32'),
(8, 'AGV PISTA GP RR Performante Carbon', 250000, 1, 2, 1, 1, 'Pista GP RR is an exact replica of the AGV helmet used in races by world champions. It has therefore received the new FIM homologation, which certifies the highest possible level of protection, even against any dangerous twisting of the head. Due to the exclusive AGV Extreme Safety design protocol, Pista GP RR already exceeds the requirements of the strict ECE22.06 homologation.', '100% carbon fiber! 190° panoramic vision! 85° vertical vision! Exclusive 360° Adaptive Fit system', 'Pista GP RR Performante Carbon.webp', 'helmet, carbon fiber, FIM certified, MotoGP, racing, premium, extreme safety, AGV, track, performance, professional', '2025-05-29 15:38:32'),
(9, 'Airoh MARTYX Nytro Glossy', 60000, 6, 2, 1, 0, 'Determined, aggressive, self-confident. The new Matryx is the ideal travel companion to face any adventure, even the most demanding.', 'Determined, aggressive.!Self-confident; The ideal travel mate for any adventure!\r\nECE 2206 approved!\r\nCombines style, comfort and safety without neglecting even the smallest detail', 'MARTYX Nytro.jpg', 'helmet, carbon fiber, FIM certified, MotoGP, racing, premium, extreme safety, Airoh, adventure, ECE 2206, aggressive', '2025-05-29 15:38:32'),
(10, 'AXOR Retro Dominator Black', 13500, 4, 2, 1, 25, 'Retro Helmets are with a classic-legendary look. Retro’s are especially worn on traditional engines such as choppers, bobbers, cafe-racers, and many more. It is a complete entry-level full-face helmet with modern safety and production advancement with industrials standards in performance and style.', 'Fiberglass composite shell!\r\nChin air vent!\r\nDOT certified!\r\nHypoallergenic Liner!\r\nMulti-Density EPS liner!\r\nLeather Neck Roll', 'Axor Retro Dominator.webp', 'helmet, retro, full-face, DOT certified, fiberglass, classic, entry-level, AXOR, vintage, cruiser, traditional', '2025-05-29 15:38:32'),
(12, 'SOMAN Balaclava', 800, 14, 4, 19, 88, 'This balaclava is made of high quality elastic fabric  to produce good quality outdoor sports masks which provide premium performance for breathability, absorbency, wicking, very soft and lightweight, stay warm and dry.', 'Material: High quality elastic fabric!\r\nColor: Black!\r\nStyle Unisex!\r\nLightweight', 'SOMAN Balaclava.png', 'balaclava, mask, face protection, SOMAN, elastic fabric, black, unisex, lightweight, outdoor, breathable', '2025-05-29 15:38:32'),
(13, 'AXOR Jet Half', 5250, 4, 2, 4, 25, 'Traditional stitched Genuine leather edge trim and interior.', 'Genuine leather interiors and trims!\r\nReinforced strap and double D ring!\r\nRemovable, washable and anti-bacterial interior!\r\nWeighs up-to 1000 grams!\r\nDOT certified', 'Axor Jet Half.png', 'helmet, half-face, open-face, DOT certified, leather interior, AXOR, retro, cruiser, vintage, classic', '2025-05-29 15:38:32'),
(14, 'Akrapovič Exhaust For Honda CBR600RR 2024 ', 130000, 8, 5, 17, 2, 'This product is created and designed using race-proven materials, with a high-grade lightweight titanium muffler, stainless-steel link pipe, and carbon-fibre end cap. It provides performance gains predominately in the mid and high rev ranges, with a power increase of 1.0 kW (1.4 hp) at 7,600 rpm and a torque increase of 1.0 Nm at 7,500 rpm, when compared to a Honda CBR600RR equipped with a standard stock exhaust system and tested on the Akrapovič dyno. Lightweight materials provide a weight reduction of 35.9% (1.6 kg) against the standard stock exhaust.', 'Power: +1.0 kW at 7600 rpm!\r\nTorque: +1.4Nm at 7500 rpm!\r\nWeight: -1.6kg', 'Honda Akrapovic.png', 'exhaust, CBR600RR, titanium, performance, torque, lightweight, Akrapovič, Honda, racing, power gain', '2025-05-29 15:38:32'),
(15, 'Bell V3 RS Scans Helmet', 95000, 15, 2, 5, 5, 'As the most technologically advanced motocross helmet out there, the lightweight V3 RS Scans Helmet is packed with next-level features that align with your performance demands. Designed with Mips® Integra Split impact protection plus a dual-density Varizorb™ EPS liner that spreads forces of impact across a wider surface area, the V3 RS provides the kind of protection every racer needs in the heat of the moment.', 'Mips® Integra Split impact protection system equipped!\r\nCarbon fiber shell provides increased impact resistance while reducing weight!\r\n4 exhaust vents on the top of the helmet to aid in cooling!\r\nCompatible with most helmet communication systems', 'V3 RS Scans.webp', 'helmet, motocross, carbon fiber, MIPS, ventilation, racing, advanced protection, Bell, dirt bike, off-road', '2025-05-29 15:38:32'),
(43, 'ACF Handlebar', 16000, 16, 5, 12, 5, 'The ProTaper ACF Handlebar uses a revolutionary unidirectional carbon fiber core system to become the first carbon fiber reinforced motocross handlebar. The added strength allows the aluminum tubing wall thickness to be safely reduced in key areas, greatly decreasing weight and producing unrivaled impact-absorbtion. Innovative Control+ design features 220mm of control space or up to 40mm more than conventional 1-1/8', 'Control+ design provides more space for controls, mapping switches, and electric starters.!\r\nUnidirectional carbon fiber cores reinforce the aluminum tubing and safely reduce wall thickness in key areas.!\r\nUp to 20% lighter than conventional 1-1/8', 'acf-handlebar.png', 'handlebar, motocross, carbon fiber, ProTaper, lightweight, durable, Control+, unidirectional, revolutionary, performance', '2025-05-29 15:38:32'),
(52, 'LS2 OF599 Spitfire Black', 7500, 3, 2, 4, 9, 'The LS2 OF599 Spitfire capture at first glance! The new LS2 half face is born thanks to the brand’s determination to propose a new modern and essential helmet, dedicated to the eclectic bikers doing of their total look a real style of life, which throw an eye to the design but not forgive protection and safety while riding their ‘two wheels’.LS2 visors are built with 3D Optically Correct “A Class” Polycarbonate, a space-age polymer with high resistance to impact, that avoids distortion and offers maximum clarity.', 'High-pressure thermoplastic outer shell construction!\r\nScratch and UV resistant quick release visor!\r\nIntegrated sun visor with quick control!\r\nMulti-density EPS lining!\r\nHypoallergenic, breathable, removable, and washable laser-cut extra comfort interior lining!\r\nQuick-release buckle fastening with reinforced chin strap!\r\nCertified ECE 22.05', 'LS2_OF599.jpg', 'helmet, half-face, urban, sun visor, thermoplastic, stylish, ECE certified, LS2, modern, essential', '2025-05-29 15:38:32'),
(53, 'Shark VFX-EVO', 60000, 2, 2, 5, 4, 'Conquer rugged paths with the SHOEI VFX-Evo dirt bike helmet, crafted for peak performance. With its cutting-edge impact protection, enhanced ventilation, comfortable fit, and light build, it is the ideal companion for tackling challenging terrains while ensuring your safety and comfort.', 'Extra front intake vents combine with rear exhaust outlet vents and an enlarged neck outlet vent to maximize flow-through ventilation!\r\nCool air passes through the front intake vents, cools the helmet interior, and is exhausted through the rear vents by the force of negative air pressure!\r\nExpanded rib shapes across the rear enhances strap-holding performance for goggle wearers!\r\nE;Q;R;S; (Emergency Quick Release System) features special straps under the cheek pads which allow them to be easily removed, so the helmet can be quickly taken off by emergency personnel after an accident!', 'vfxevo.png', 'helmet, motocross, ventilation, impact protection, emergency release, lightweight, Shark, dirt bike, off-road, safety', '2025-05-29 15:38:32'),
(54, 'LS2 Drifter Gloss White', 12499, 3, 2, 20, 7, 'The LS2 Drifter trial helmet boasts an aggressive and striking design, making it an ideal choice for riders across various biking domains, be it cruisers, trials, or navigating the bustling city streets. Its versatility shines through with a removable chin guard and an adjustable, removable peak, allowing riders to tailor their experience to their preferences. Crafted from KPA material, this helmet ensures both lightness and enhanced safety, a critical combination for any rider. Furthermore, the helmet’s adaptability is evident in its ability to swap from a clear to a dark visor, ensuring optimal visibility in various lighting conditions.', 'Kinetic Polymer Alloy (KPA) shell!\r\n2 shell sizes!\r\nReflective elements for added safety!\r\nRemovable helmet peak!\r\nUV and scratch resistant retractable sun visor!\r\nHypoallergenic, breathable, removable and washable lining!\r\nWeight: 1300g (+/-50g)!\r\nCertification: ECE 22.06', 'ls2drifter.jpg', 'helmet, modular, trial, KPA shell, sun visor, lightweight, ECE 22.06, LS2, versatile, removable', '2025-05-29 15:38:32'),
(55, 'Shark Evo ES KRYD', 60000, 17, 2, 20, 6, 'The motorcycle jet EVO-ES helmet embodies all of SHARK’s expertise in the design of modular helmets for daily users seeking to enjoy optimal protection whether in the jet or integral position. In 2007, SHARK’s R&D department broke the codes of the modular helmet and created a new concept: the EVO-ES which remains the only true modular on the market.\n<br>\nWith a compact, aerodynamic profile, the EVO-ES modular is the ultimate 2-in-1 helmet – offering a choice of jet or full-face positioning. The EVO-ES is equipped with SHARK’s “Auto-up / Auto-down” system, the visor is automatically lifted when maneuvering the chin bar.', 'Shell made of injected thermoplastic resin!\r\nMulti-density EPS!\r\nMicrometric buckle system!\r\nAnti-scratch and anti-fog visor!\r\nUV380-labeled visor treated to resist scratches!\r\nQuick visor release system!\r\nWeight: 1,650!\r\nECE Certified', 'evoEs.png', 'helmet, modular, full-face, jet, anti-fog visor, compact, ECE certifiedhelmet, modular, full-face, jet, anti-fog visor, compact, ECE certified, Shark, 2-in-1, aerodynamic', '2025-05-29 15:38:32'),
(56, 'RCB HG66 Handle Grip Grey', 1500, 14, 5, 21, 45, 'The RCB HG66 bike handlebar grips provide a secured grip and enhanced comfort, ensuring a safer and more enjoyable riding experience. Available in various colors, they allow you to personalize your bike to match your style. Designed to improve riding safety, these grips absorb vibration, reducing hand fatigue and ensuring a smoother ride on any terrain.', 'Secured grip and comfort!\r\nImproves riding safety!\r\nAbsorbs vibration', 'RCB-HG66.jpg', 'handle grip, comfort, vibration dampening, safety, RCB, bike accessory, greyhandle grip, comfort, vibration dampening, safety, RCB, bike accessory, grey, secured grip, enhanced', '2025-05-29 15:38:32'),
(57, 'Vesrah Ceramic Disc Brake pad for KTM ALL /ROYAL ENFIELD ALL/ BAJAJ ALL/ BMW ALL SD-953 (Rear)', 2300, 18, 5, 13, 98, 'Vesrah Motorcycle Ceramic Brake Pads are high-quality brake pads designed specifically for motorcycles. These brake pads is made with advanced ceramic composite materials that offer exceptional braking performance, durability, and reduces noise and dust.<br>\r\n\r\nIn addition to their superior performance and durability. Vesrah Ceramic Brake Pads  produce less dust than traditional brake pads, Vesrah Ceramic Brake Pads  helps to keep wheels and tires cleaner and reduces the amount of airborne particles.<br>\r\n\r\nOverall, Vesrah Motorcycle Ceramic Brake Pads are a top-of-the-line option for motorcycle riders looking for high-performance, long-lasting brake pads that offer exceptional stopping power, reduced noise and dust, and a more comfortable riding experience.', 'An excellent, economical choice for replacing OEM sintered metal brake pads.!\r\nPad consists of 50-60% copper combined with carbon, ceramic, tin and abrasives.!\r\nIron backing plate is plated with copper to make it a stronger bond with the pad friction material.!\r\nPowerful stopping power in wet or dry conditions.!\r\nExcellent initial pad bite, lower lever effort and minimal pad bed-in time required.!\r\nCan be used with stainless steel rotors.!\r\nBRAKE PADS ARE SOLD IN PAIRS, ONE PAIR OF PADS PER EACH CALIPER..', 'Rear-Disc-Pad.webp', 'brake pad, ceramic, motorcycle, rear, high performance, low dust, OEM replacementbrake pad, ceramic, motorcycle, rear, high performance, low dust, OEM replacement, Vesrah, universal, stopping power', '2025-05-29 15:38:32'),
(58, 'JPA R15 V3/V4 Integrated Taillight', 7000, 14, 5, 14, 14, 'JPA focuses its products on lights on motor vehicles such as headlights, taillights, and turn signals. The type of lamp used is a quality HID and LED Tube lamp, resulting in a good description and vivid lamp color. With quality plastic, the frame body and mica lamps from JPA are more durable, and engineered to provide unparalleled safety and efficiency for your vehicle. Designed with a focus on longevity and eco-consciousness, this tail light combines durability, energy efficiency, and low radiation for a superior driving experience.', 'Compatible with R15 V3/V4!\r\nLong life Durable!\r\nMercury Free!\r\nEnergy Efficient Energy Saving!\r\nLow Head Radiation Low Radiation', 'R15_tailight.png', 'taillight, JPA, Yamaha R15, integrated, LED, stylish, motorcycle accessorytaillight, JPA, Yamaha R15, integrated, LED, stylish, motorcycle accessory, energy efficient, long life', '2025-05-29 15:38:32'),
(59, 'Liqui Moly Motorbike 4T Synth 10W-40 STREET RACE 1L Engine Oil', 2235, 19, 5, 15, 25, 'The Liqui Moly Motorbike 4T Synth, Fully synthetic high-performance motor oil. For maximum performance and outstanding engine protection under all operating conditions. Offers perfect lubrication, outstanding engine cleanliness, excellent friction and minimum wear. Ensures smooth engagement and disengagement as well as gear shifting, which significantly increases driving pleasure. Tested for use with catalytic converters and on racing machines.', 'Fully Synthetic.!\r\nFor air and water-cooled 4-stroke engines.!\r\nSuitable for engines with or without a wet clutch.!\r\nFor sporting applications.!\r\nFor normal to extreme operating conditions.!\r\nVolume: 1 L!\r\nViscosity: 10W-40!\r\nQuality Levels: API SN Plus, JASO MA2', 'LiquiMoly10w-40.png', 'engine oil, fully synthetic, Liqui Moly, 10W-40, motorbike, high performance, racing, lubrication, JASO MA2, API SN Plusengine oil, fully synthetic, Liqui Moly, 10W-40, motorbike, high performance, racing, lubrication, JASO MA2, API SN Plus', '2025-05-29 15:38:32'),
(60, 'HJC i71 Celos MC5 Black Glitter', 35000, 5, 2, 1, 10, 'The i71 sets a new standard in Sport-Touring excellence with its streamlined shell design. Utilizing Advanced Polycarbonate technology, this helmet features 3 shells across 6 sizes, meticulously engineered for optimal weight and rider comfort. The repositioned top vent and expanded mouth vents maximize airflow, enhancing intake and ventilation dynamics. Pioneering innovation, the i71 introduces the HJ-38 Pinlock-ready face shield with an upgraded PE (Push/Eject) locking mechanism for enhanced safety and usability, even with gloves. Additionally, the new sun visor (HJ-V12) offers a versatile 3-position adjustment, allowing riders to adjust the sun shield up to 10mm forward for optimal sun protection.', 'Advanced Polycarbonate Composite Shell: Lightweight, superior fit and enhanced comfort!\r\n“ACS” Advanced Channeling Ventilation System: Full front-to-back airflow flushes heat and humidity up and out.!\r\nPinlock Ready HJ-38 Visor: Provides 99% UV protection, Anti-Scratch coated.!\r\nInterior provides enhanced moisture wicking and quick drying function.!\r\nCrown and Cheek pads: Removable and washable.!\r\nReady for SMART HJC 11B, 21B & 50B Bluetooth (sold separately).!\r\nIt comes standard with Pinlock, Chin Curtain and Breath deflector.!\r\nWeight: 1650 grams!\r\nCertification: ECE 22-06.', 'hjc--i71.webp', 'helmet, HJC, i71, black glitter, ECE 22-06, pinlock ready, sun visor, sport-touring, ventilation, Bluetooth readyhelmet, HJC, i71, black glitter, ECE 22-06, pinlock ready, sun visor, sport-touring, ventilation, Bluetooth ready', '2025-05-29 15:38:32'),
(61, 'GP-R7 1PC Leather Suit', 160000, 7, 4, 7, 4, 'Designed for trackday riders, racers and advanced road riders, the GP-R7 1PC Leather Suit is optimized for performance riding, on the road or the track, and is constructed from premium Race-grade, 1.3mm bovine leather for superior abrasion resistance, flexibility, and comfort. With a race fit and extensive perforations for maximum airflow, this suit also incorporates a streamlined speed hump specifically engineered to complement Alpinestars Supertech R10 Helmet for optimum aerodynamic performance. It’s supremely protective too, thanks to its Nucleon PLASMA Pro armor.', '1.3mm ‘Race’ spec soft bovine leather construction incorporating dual layers in critical areas for optimized flexibility and abrasion resistance.!\r\nEquipped with Alpinestars Nucleon PLASMA Pro CE Level 2 armor.!\r\nIncorporates Alpinestars ‘Race’ spec Supertech R10 aero hump. Designed and engineered to work in conjunction with Alpinestars S-R10 Helmet for optimum streamlining and aerodynamic performance with rider tucked in a racing crouch.!\r\nOptimized for use with Alpinestars Tech-Air® Airbag Systems; Tech-Air® 5, Tech-Air® 10 and is Tech-Air® Compatible with the new Tech-Air® 7x Airbag System.', 'gpr71pc.jpg', 'racing suit, leather suit, GP-R7, trackday gear, Alpinestars, CE armor, Tech-Air compatible, 1.3mm bovine leather, aerodynamic', '2025-05-29 15:38:32'),
(62, 'X-Fourteen MARQUEZ6 X-Spirit III', 100000, 2, 2, 1, 5, '\"X-Series\"― SHOEI\'s full face helmet for Racing developed through World\'s Top Road Races including MotoGP. All of shell, shield, interiors and aero device are renewed by realizing safety in high level and utilizing most advanced know-how obtained from race support in top category. \"REAL RACING SPEC\" is truly brought into shape, X-Fourteen / X-Spirit III, the full face helmet to win races. Brand new SHOEI top-of-the-line model starts racing in the world.', 'Tear-off Film Attachable Flat Shield – CWR-F Shield!\r\nPINLOCK® EVO lens!\r\nAdjust Wearing Position of Interiors corresponding to Racing Position!\r\nStrongly introduce riding wind, exhaust hot air and moisture effectively―ventilation system makes a rider feels wind.!\r\nE.Q.R.S.（Emergency Quick Release System)', 'X-Fourteen-MARQUEZ6_TC-1.png', 'helmet, SHOEI, X-Fourteen, Marquez, MotoGP, racing helmet, PINLOCK, aero design, ventilation, E.Q.R.S.', '2025-05-29 15:38:32'),
(63, 'KADOYA K’s Leather Early 00s ‘STEALTH’ Padded Leather Motorcycle Jacket', 90000, 20, 4, 2, 5, 'Established during World War II, Kadoya is a motorcycle gears manufacturer based in Tokyo, Japan with a heritage that spans for almost a century. Notorious for their amazing craft for leather specialty goods catering to bikers or motorcycles enthusiast. Their legacy consistently exists without change because of their proud philosophy that plays a part in the core of Japanese manufacturing. Similar to the previously posted ‘Hayabusa’ jacket, the particular model was custom-made for racing members of “STEALTH Racing”, a renowned Japanese automobile hardware manufacturer that specializes in innovative wheels model. The jacket is constructed with a premium cowhide leather as base, featuring thick motorcycle paddings throughout front, back and elbow for safety purposes, comes with adjustable side waist and YKK hardware.', 'Leather 100%!\r\nNylon Lining 100%!\r\nPlastic Paddings', 'kadoya1.jpg', 'motorcycle jacket, Kadoya, leather jacket, STEALTH Racing, cowhide, Japanese brand, padded jacket, vintage style, adjustable waist, YKK zippers', '2025-05-29 15:38:32'),
(64, 'LS2 Smoke Visor for LS2 Rapid Full Face Motorcycle Helmet', 1400, 3, 2, 6, 29, 'Specially designed for the LS2 Rapid full face motorcycle helmet, this smoke visor combines sleek style with practical protection. Crafted from high-quality polycarbonate, it offers excellent resistance against impacts while providing a tinted finish to reduce glare and protect against harmful UV rays. Perfect for enhancing both the aesthetics and functionality of your helmet, it ensures clear visibility and comfort even during long rides.', 'Impact-resistant polycarbonate construction! Tinted smoke finish for glare reduction! UV protection for safer rides under sunlight! Quick-release mechanism for easy visor changes! Scratch-resistant coating for long-lasting clarity! Compatible exclusively with LS2 Rapid full face helmets', 'Dark-Smoke-Visor-for-rapid-stream-evo-.webp', 'visor, LS2, smoke visor, Rapid, full-face helmet, UV protection, scratch-resistant, motorcycle accessoryvisor, smoke, LS2, Rapid helmet, face shield, tinted, UV protection, motorcycle accessory, replacement part', '2025-08-02 08:40:01'),
(65, 'MT Dark Smoke Visor for MT Targo Full Face Motorcycle Helmet', 1400, 22, 2, 6, 40, 'This dark smoke visor is tailored specifically for the MT Targo full face helmet. It delivers a sleek, tinted look while minimizing glare and enhancing visual comfort under bright conditions. Ready for quick changes with its tool-free release mechanism.', 'Impact-resistant polycarbonate lens! Dark smoke tint for strong glare reduction! Pre-pinlock lens ready for anti-fog inserts! Scratch-resistant coating for enduring clarity! Tool-free quick-release system for easy swapping! Compatible exclusively with MT Targo helmets', 'MT Dark Smoke Visor for MT Targo Full Face Motorcycle Helmet.webp', 'visor, dark smoke, MT Helmets, Targo helmet, face shield, tinted, UV protection, motorcycle accessory, replacement part', '2025-08-02 08:54:59'),
(66, 'Rizoma 1 1/8″ Handlebar', 14000, 23, 5, 12, 5, 'These precision-machined 1 1/8″ handlebars from Rizoma are designed for riders who demand performance, durability, and sleek aesthetics. Crafted in Italy, they offer a refined solution to upgrade OEM steel bars with lightweight yet robust billet aluminum construction, complete with elegant finishing touches.', 'Billet aluminum construction for strength and low weight! Premium anodized finish with laser‑engraved logo and position markers! 1 1/8″ outer diameter (28 mm) taper design for compatibility and rider ergonomics! Lighter than typical OEM steel handlebars for enhanced handling! Made in Italy for top-level craftsmanship!', 'Rizoma 1 1by8 Handlebars.jpg', 'handlebars, Rizoma, 1 1/8″, billet aluminum, anodized finish, lightweight, Italian motorcycle parts', '2025-08-02 09:02:43'),
(67, 'Motul DOT 4 Brake Fluid 100ml', 175, 24, 5, 15, 100, 'Motul DOT 4 is a high-performance 100% synthetic brake fluid designed to ensure consistent and reliable braking power under all riding conditions. Engineered to withstand high temperatures and resist moisture absorption, it helps prevent brake fade and maintains hydraulic system efficiency. Ideal for use in motorcycles, scooters, and other vehicles with hydraulic brake or clutch systems requiring DOT 4 specification fluid.', '100% synthetic formula for superior thermal stability!\r\nHigh dry and wet boiling points to reduce vapor lock and brake fade!\r\nCompatible with all hydraulic brake and clutch systems specifying DOT 4!\r\nExcellent moisture resistance for longer fluid life!\r\nMeets or exceeds DOT 4 performance standards!\r\nPack size 100ml for easy top-ups and maintenance', 'Motul DOT 4 Brake Fluid 100ml.png', 'brake fluid, Motul, DOT 4, synthetic brake fluid, hydraulic system, brake fade resistance, moisture resistantbrake fluid, DOT 4, Motul, motorcycle, hydraulic, braking system, high performance, 100ml, safety, premium', '2025-08-02 09:08:28'),
(68, 'K-Tech RCU Razor-R Lite Rear Shock for Honda CRF300L', 60000, 25, 5, 16, 10, 'The K-Tech Razor-R Lite rear shock is an affordable performance upgrade designed for the Honda CRF300L. Engineered to enhance handling and comfort, it offers improved damping control and adjustability over the stock suspension. Ideal for riders seeking better performance on both trails and tarmac.', 'Rebound damping adjustable in 16 positions!\r\nSpring preload adjustable for precise sag settings!\r\nNitrogen-charged design for consistent performance!\r\nInternal reservoir for improved heat dissipation!\r\nLength adjustable to fit rider preference and weight', 'K-Tech RCU Razor-R Lite Rear Shock for Honda CRF300L.jpg', 'rear shock, suspension, K-Tech, Honda CRF300L, Razor-R Lite, performance, motorcycle parts, adjustable, racing', '2025-08-02 09:19:19'),
(69, 'Akrapovič Slip-On Exhaust', 74000, 8, 5, 17, 7, 'Akrapovič Slip-On Exhausts are designed to enhance the performance and aesthetics of your motorcycle. Constructed from high-grade materials such as titanium and carbon fiber, these exhausts offer improved power output, reduced weight, and a distinctive sound. They are engineered for easy installation, typically requiring no ECU remapping, making them a popular choice for riders seeking a balance between performance and convenience.', 'High-quality titanium and carbon fiber construction!\r\nSignificant weight reduction compared to stock systems!\r\nIncreased power and torque output!\r\nDistinctive, deep exhaust note!\r\nEasy installation with no ECU remapping required!\r\nSleek, race-inspired design!\r\nCompatible with various motorcycle models!', 'Akrapovič Slip-On Exhaust.jpg', 'exhaust, Akrapovič, slip-on, titanium, carbon fiber, lightweight, performance, motorcycle accessoryexhaust, slip-on, Akrapovič, performance, sound, motorcycle, aftermarket, racing, premium, titanium', '2025-08-02 09:24:51'),
(70, 'Yoshimura AT2 Slip-On Exhaust', 60000, 26, 5, 17, 10, 'The Yoshimura AT2 Slip-On Exhausts are designed to enhance the performance and aesthetics of various motorcycle models. Featuring an aggressive conical shape and end cap, these exhausts offer improved ground clearance and optimized exhaust flow. Crafted with precision, they provide a distinctive exhaust note that Yoshimura is renowned for, all while maintaining durability and ease of service.', 'Aggressive conical shape and end cap!\r\nUnrivaled fit and finish due to improved production tolerances!\r\nOptimized for maximum flow and improved ground clearance!\r\nMuffler volume and shape produces that magic tone Yoshimura is famous for!\r\nOptimized for durability and ease of service!\r\nMade in the USA', 'Yoshimura AT2 Slip-On Exhaust.webp', 'exhaust, Yoshimura, AT2, slip-on, motorcycle performance, aggressive design, ground clearance, USA-made', '2025-08-02 09:30:42'),
(71, 'Bridgestone M59 Front Tire', 11000, 27, 5, 18, 25, 'The Bridgestone M59 is a race-proven soft-to-intermediate terrain front tire built for cross-country competition. Known as “The Living Legend,” it excels in varied conditions—from mud and roots to rocky trails—delivering reliable grip, self-cleaning performance, and smooth ride feel across changing terrain', 'Extra-wide tread blocks combined with a rounded profile for excellent self-cleaning bite!\r\nReinforced side lugs for traction in soft terrain conditions!\r\nDual-compound MX-CAP/BASE construction for high traction and cushioning balance!\r\nSoft carcass design for easy mounting and superior bump absorption!\r\nOutstanding grip and linear traction for stability and response in varied off-road situations', 'Bridgestone M59 Front Tire.jpg', 'tire, Bridgestone, M59, front tire, soft terrain, motocross, MX-CAP BASE, cross-country, off-road performancemotorcycle tire, front tire, Bridgestone, M59, grip, performance, traction, handling, street, sport', '2025-08-03 03:52:19'),
(72, 'Michelin Road 6 Tire', 20250, 28, 5, 18, 20, 'The Michelin Road 6 is a sport-touring tire engineered to deliver exceptional grip and reliability across both wet and dry roads. Featuring advanced silica-based compounds and tread innovations, it offers impressive traction and controlled wear. Ideal for riders who demand long-lasting performance without sacrificing confidence or safety in variable weather.', '15% better wet traction compared to the Road 5!\r\n10% improved wear life over its predecessor!\r\n100% silica compound with Water Evergrip technology for consistent grip as tread wears!\r\nDual-compound 2CT+ construction on both front and rear for enhanced stability and precise turn-in!\r\nRounded profile for smooth, predictable handling and cornering feel\r\nAvailable in reinforced \"GT\" version for heavyweight touring bikes', 'Michelin Road 6 Tire.jpg', 'motorcycle tire, Michelin, Road 6, sport touring, wet grip, longevity, performance, all-weather, premium', '2025-08-03 03:57:03'),
(73, 'Rynox Helium GT 3 Jacket', 11120, 29, 4, 2, 40, 'The Helium GT 3 is a lightweight, highly ventilated riding jacket designed for urban sport riding and short weekend escapes. Featuring advanced mesh airflow, CE Level 2 impact protection, and high-visibility detailing, it offers a perfect blend of comfort, safety, and style for warm-weather commutes and city cruising.', 'Cerros Zero‑G Level 2 impact protectors on shoulders, elbows, back and chest!\r\nHeavy-duty 600D PU-coated polyester in key impact zones!\r\nSeamless elbow‑to‑cuff panel to reduce seam failure risk!\r\nLarge dual‑tone 3D mesh panels for enhanced ventilation and visibility!\r\nShort summer collar and soft neoprene trim for improved comfort and airflow!\r\nHi‑Viz trims and retro‑reflective panels for day‑time and low‑light visibility', 'Rynox Helium GT 3 Jacket.webp', 'jacket, Rynox, Helium GT 3, CE Level 2, ventilated mesh, hi-viz, urban sport, lightweightmotorcycle jacket, Rynox, Helium GT 3, textile, ventilation, protection, touring, Indian brand, all-weather', '2025-08-03 04:11:55'),
(74, '  STEALTH EVO 4 JACKET', 28000, 29, 4, 2, 30, 'Engineered for adventure touring and urban riders alike, the Stealth Evo 4 is built to withstand changing terrain and weather without compromise. With a clean, unassuming design that hides serious protective tech beneath, this jacket keeps you safe, dry, and comfortable on extended journeys.', 'D3O Viper Air 2 level 2 back protector!\r\nD3O T5 Evo Pro X level 2 protectors on shoulders and elbows!\r\nCerros CE level 2 chest protectors!\r\nHeavy‑duty nylon shell with DWR coating for abrasion resistance!\r\nInvista Cordura® and SuperFabric® panels on high-wear slide zones!\r\nConverts to a full suit using jacket-to-pants zipper!\r\nRemovable ventilated lumbar support belt!\r\n3‑way AeroBurst ventilation on chest and back, plus forearm and armpit vents', 'STEALTH EVO 4 JACKET.webp', 'motorcycle jacket, STEALTH, EVO 4, protection, riding gear, textile, ventilation, sport, performance', '2025-08-03 04:14:07'),
(75, 'Avro 4 Men’s 2-Piece Motorcycle Leather Suit', 100000, 30, 4, 7, 10, 'The Avro 4 is a premium two-piece leather suit built for riders who want race-inspired protection with the flexibility of separate jacket and pants. Made from durable Tutu cowhide leather, it delivers excellent abrasion resistance while integrated stretch panels ensure a comfortable, ergonomic fit. Designed for both spirited street riding and track days, it features CE-certified armor, replaceable sliders, and an aerodynamic hump for enhanced performance and safety.', 'Constructed from premium Tutu cowhide leather for durability and abrasion resistance!\r\nCE-certified composite protectors on shoulders, elbows, and knees!\r\nReplaceable knee sliders and aluminum shoulder plates for added protection!\r\nAerodynamic racing hump for improved airflow and stability!\r\nMicroelastic 2.0 stretch panels for mobility and comfort!\r\nFull jacket-to-pants connection zipper for a secure and versatile fit', 'Avro 4 Men’s 2-Piece Motorcycle Leather Suit.webp', 'racing suit, leather suit, Avro 4, two-piece, men\'s, motorcycle, track gear, protection, racing, premium', '2025-08-03 04:20:15'),
(76, 'Drake 2 Super Air', 35000, 30, 4, 8, 7, 'The Drake 2 Super Air Tex are lightweight summer riding pants built using breathable mesh fabric for maximum airflow in hot conditions. Designed with riding ergonomics in mind, they combine soft, flexible construction with Dainese’s EN 17092 Class A protective standards. Ideal companion for sport-touring or commuting in warm weather, they pair seamlessly with the Air Frame 3 jacket via a connection zipper', 'Extensive mesh fabric for superb ventilation!\r\nRemovable CE-certified composite knee protectors!\r\nHip pockets fitted for Pro-Shape 2.0 soft protectors!\r\nJacket‑pants connection zipper compatibility!\r\nAdjustable waist and calf zip openings', 'DRAKE 2 SUPER AIR.webp', 'pants, Dainese, Drake 2 Super Air, summer riding, mesh fabric, EN 17092 A, composite protectors, Pro-Shape', '2025-08-03 04:25:25'),
(77, 'Kavach Tight Fitting Riding Jeans Pant', 8300, 31, 4, 8, 50, 'The Kavach Straight Fitting Riding Jeans Pant blends the everyday style of denim with motorcycle-grade protection. Reinforced with Kevlar in high-impact zones and featuring flexible, removable knee pads, these slim-fitting riding jeans deliver both comfort and confidence on the road—without compromising your street style.', 'Kevlar reinforcement at knees and hips for abrasion resistance!\r\nRemovable flexible knee pads for on-demand protection!\r\nSlim-fit denim tailored for riding posture!\r\nBreathable and stretchable fabric for comfort during long rides!\r\nTriple-stitched seams for enhanced durability and safety!\r\nEquipped with reflective trims for increased visibility', 'Kavach-Tight-Fitting-Riding-Jeans-Pant.webp', 'riding jeans, Kavach, denim, Kevlar reinforced, knee pads, slim fit, breathable, durable, reflective trimsriding jeans, Kavach, tight fitting, motorcycle pants, protective, denim, street riding, Indian brand, casual', '2025-08-03 04:30:36'),
(78, 'Kavach Adventure Touring Pant – Black', 15000, 31, 4, 8, 35, 'The Kavach Adventure Touring Pant is engineered for serious adventure riders facing diverse terrain and unpredictable conditions. Built from abrasion-resistant fabric and featuring CE-level armor, these pants deliver confidence whether you\'re on highway stretches or rugged trails. With added pockets and adjustments, they support long-distance comfort and utility without compromising style.', 'CE Level-2 hip and knee armor included for certified protection!\r\nDurable abrasion-resistant fabric over key impact zones!\r\nLarge cargo pocket design for storage convenience!\r\nAdjustable waist and ankle straps for tailored fit!\r\nReflective trims for visibility at night', 'Kavach Adventure Touring Pant Black.webp', 'pants, Kavach, Adventure Touring, CE Level-2, cargo pockets, adjustable fit, reflectiveadventure pants, touring pants, Kavach, black, motorcycle, protective, adventure riding, Indian brand, durable', '2025-08-03 04:36:40'),
(79, 'Alpinestars Tech 3 Motocross Boots White, Red And Blue', 49500, 7, 4, 9, 20, 'The Tech 3 motocross boots bring Alpinestars’ proven race-level technology into an anatomically profiled, flexible off-road riding boot. Built from light yet durable microfiber, they deliver high-impact protection with enhanced comfort—ideal for beginner to intermediate riders who want trusted safety without sacrificing mobility', 'Lightweight microfiber upper for abrasion resistance and flexibility!\r\nInjected TPU shin and ankle protection with medial blade system for support!\r\nTriple TPU buckle straps with ratchet-style memory closure and replaceability!\r\nReplaceable high-grip rubber sole and EVA footbed for traction and comfort!\r\nCE certified to EN 13634:2010 for industry-standard protection', 'Alpinestars-Tech-3-Motocross-Boots-White-Red-And-Blue.webp', 'boots, Alpinestars, Tech 3, motocross boots, microfiber, TPU protection, CE certifiedmotocross boots, Alpinestars, Tech 3, white red blue, off-road, dirt bike, protection, racing, premium', '2025-08-03 05:46:10'),
(80, 'Alpinestars Tech 3 Motocross Boots Black', 49500, 7, 4, 9, 20, 'The Tech 3 Motocross Boots deliver Alpinestars’ proven off-road protection in a lightweight, anatomically shaped design. Built for motocross and trail riders, they combine durable microfiber construction with advanced protection systems to keep you safe and comfortable during demanding rides.', 'Lightweight microfiber upper for durability and flexibility!\r\nInjected TPU shin and medial panels for impact protection!\r\nTriple buckle closure system with replaceable straps!\r\nBiomechanical medial blade system for controlled ankle movement!\r\nHigh-grip rubber sole with replaceable EVA footbed for traction and comfort', 'Alpinestars Tech 3 Motocross Boots Black.webp', 'boots, Alpinestars, Tech 3, motocross, off-road, TPU protection, buckle system, ankle supportmotocross boots, Alpinestars, Tech 3, black, off-road, dirt bike, protection, racing, premium, MX', '2025-08-03 05:47:46'),
(81, 'Alpinestars Tech 10 Motocross Boots Dark Blue and Grey', 105000, 7, 4, 9, 4, 'The Tech 10 stands as Alpinestars’ flagship motocross boot, offering the highest level of protection, comfort, and performance for serious off-road riders. Built with a combination of advanced microfiber, TPU protection, and a revolutionary inner ankle brace system, it delivers exceptional impact resistance and controlled mobility. Designed for the rigors of professional motocross and enduro racing, the Tech 10 provides uncompromising safety and a precise fit.', 'Lightweight microfiber and TPU construction for maximum durability and flexibility!\r\nPatented Dynamic Heel Compression Protector for impact absorption!\r\nRevolutionary inner ankle brace system for improved stability and protection!\r\nTriple buckle closure with self-aligning, replaceable straps!\r\nDual-compound rubber sole for grip and shock absorption', 'Alpinestars Tech 10 Motocross Boots Dark Blue and Grey.webp', 'boots, Alpinestars, Tech 10, motocross, off-road, ankle brace, TPU protection, racing bootsmotocross boots, Alpinestars, Tech 10, dark blue grey, premium, off-road, racing, protection, professional, MX', '2025-08-03 05:49:44'),
(82, 'TR Tiger MTR-T3 Black Red Men’s Boot', 15000, 32, 4, 9, 25, 'The MTR-T3 is a rugged, knee-high motocross boot designed for serious off-road and trail use. Constructed from TPU, microfiber, PVC and mesh, it offers breathability, anti-slip grip, and impact protection at a more accessible price. Engineered for comfort and durability in diverse weather and terrain conditions.', 'TPU and microfiber upper with PVC overlays for abrasion resistance and structural support!\r\nBreathable mesh lining and padded sponge for airflow and all-day comfort!\r\nMulti-buckle closure system for secure fit and adjustability!\r\nRubber outsole with anti-slip tread for grip on rough terrain!\r\nShock-absorbing midsole and TPU shin plate for impact protection', 'TR Tiger MTR-T3 Black Red Men’s Boot.webp', 'boots, TR Tiger, MTR-T3, motocross, TPU protection, breathable lining, anti-slip sole, adjustable fit', '2025-08-03 05:53:30'),
(83, 'Tiger TR G1 Adventure Boots Brown', 16500, 32, 4, 9, 15, 'The TR Tiger TR-G1 Adventure Boots are built for rugged touring and off-road adventure. Constructed with a mix of cowhide, microfiber, PVC, and a waterproof lining, these high-cut boots offer a solid combination of protection, comfort, and toe-to-heel support. Equipped with adjustable closure hardware and a grippy rubber sole, they’re ideal for riders covering long distances or tackling unpredictable terrain.', 'Durable cowhide leather, microfiber, and PVC upper materials for abrasion resistance and structure!\r\nBuilt-in waterproof membrane lining for all-weather use!\r\nMulti-point adjustable buckle closure system for a secure fit!\r\nRubber outsole with anti-slip tread for excellent traction on varied surfaces!\r\nShock-absorbing midsole and reinforced TPU shin and heel protection', 'Tiger TR G1 Adventure Boots Brown.webp', 'adventure boots, Tiger TR, G1, brown, motorcycle, touring, off-road, waterproof, protection, durable', '2025-08-03 05:55:41'),
(84, 'LS2 Black Textile Street Gloves with Knuckle Protection', 4850, 3, 4, 10, 20, 'The LS2 All Terrain gloves combine breathable textile, perforated goat leather, neoprene, and Lycra to create a comfortable and protective option for street and touring riders. Designed for versatility, they offer excellent airflow, impact protection, and touchscreen capability for modern riding convenience.', 'Touchscreen-capable fingertip for device use while riding!\r\nBreathable construction with perforated leather and textile panels!\r\nTPR molded knuckle and finger protection for impact resistance!\r\nLeather-reinforced palm with foam slide pad for durability!\r\nHook-and-loop cuff adjustment with neoprene panel for comfort and fit', 'LS2 Black Textile Street Gloves with Knuckle Protection.webp', 'gloves, LS2, All Terrain, motorcycle gloves, touchscreen, breathable, knuckle protection, palm reinforcementmotorcycle gloves, LS2, black, textile, street, knuckle protection, riding gear, safety, urban, comfort', '2025-08-03 05:59:25'),
(85, 'LS2 All Terrain Black/Red/Grey Textile Street Gloves with Knuckle Protection', 4850, 3, 4, 10, 13, 'Description: The LS2 All Terrain gloves merge breathable textile, perforated goat-skin leather, neoprene, and Lycra to create a highly ventilated and durable glove option for street and touring riders. This Black/Grey/Red color variant maintains the same comfort and protection standards, offering modern riding convenience with a sport-inspired aesthetic.', 'Touchscreen-capable fingertip for convenient device use!\r\nHigh levels of breathability via perforated leather and mesh textile panels!\r\nTPR molded knuckle and finger protectors for impact resistance!\r\nLeather-reinforced palm with foam slide insert for durability!\r\nHook-and-loop cuff adjustment with neoprene isolation for secure fit', 'LS2 All Terrain Black Red Grey Textile Street Gloves with Knuckle Protection.webp', 'gloves, LS2, All Terrain, Black Grey Red, touchscreen, breathability, knuckle protection, reinforced palmmotorcycle gloves, LS2, all terrain, black red grey, textile, street, knuckle protection, riding gear, colorful', '2025-08-03 06:00:51'),
(86, 'LS2 Spark 2 Man', 6750, 3, 4, 10, 5, 'The Spark 2 Air gloves bring premium leather and carbon protection into a sport-cut glove designed for aggressive road or track riders. Constructed from full-grain cowhide and goatskin with mesh and spandex enhancement, these gloves pair durability with airflow. Advanced knuckle protection, ergonomic fit, and touchscreen-ready fingertips make them a versatile choice for both spirited rides and daily commuting.', 'Touchscreen-capable fingertip for device use while riding!\r\nCarbon and Kevlar knuckle and finger protection for impact resistance!\r\nPower-stretch panels at finger knuckles and perforated zones for airflow!\r\nSilicone-printed palm and reinforced padding for grip and durability!\r\nHook-and-loop cuff adjustment for secure fit', 'LS2 Spark 2 Man.webp', 'motorcycle gloves, LS2, Spark 2, men\'s, riding gear, protection, street, performance, textile, safety\n', '2025-08-03 06:02:10'),
(87, 'Motowolf Street Gloves Black MDL0305 with Carbon Fiber Knuckle Protection', 3200, 33, 4, 10, 10, 'The Motowolf MDL0305 gloves are designed for riders seeking a blend of protection and comfort. Crafted from sheepskin leather, these gloves feature carbon fiber knuckle protection and a breathable design, making them suitable for various riding conditions.', 'Made from sheepskin leather for durability and comfort!\r\nEquipped with carbon fiber knuckle protection for impact resistance!\r\nBreathable design to keep hands cool during rides!\r\nTouchscreen-compatible fingertips for device use!\r\nAdjustable wrist closure for a secure fit', 'Motowolf Street Gloves Black MDL0305 with Carbon Fiber Knuckle Protection.webp', 'motorcycle gloves, Motowolf, street, black, MDL0305, carbon fiber, knuckle protection, riding gear, performance', '2025-08-03 06:08:15'),
(88, 'Motowolf Universal Shoe Protector', 300, 33, 4, 9, 100, 'The Motowolf Universal Shoe Protector is designed to shield your footwear from scuffs and damage caused by motorcycle gear shifters. Crafted from durable materials, it fits over most shoes and boots, making it an essential accessory for riders who want to keep their footwear in pristine condition.', 'The Motowolf Universal Shoe Protector is designed to shield your footwear from scuffs and damage caused by motorcycle gear shifters. Crafted from durable materials, it fits over most shoes and boots, making it an essential accessory for riders who want to keep their footwear in pristine condition.', 'Motowolf Universal Shoe Protector.webp', 'shoe protector, Motowolf, universal, motorcycle accessory, gear protection, riding gear, foot protection, durable', '2025-08-03 06:09:54'),
(89, 'Scorpion Exo Goggles Gold', 6500, 34, 4, 11, 21, 'The Scorpion EXO Gold Goggles are designed for off-road riders seeking optimal vision and comfort. Featuring a gold mirrored lens, these goggles offer enhanced visibility and reduced glare in bright conditions. The flexible frame and adjustable strap ensure a secure fit, while the anti-fog coating maintains clear vision during intense rides. Ideal for motocross and trail enthusiasts, these goggles combine style and functionality.', 'Gold mirrored lens for reduced glare and enhanced visibility!\r\nAnti-fog coating to maintain clear vision in varying conditions!\r\nFlexible frame adapts to different face shapes for a comfortable fit!\r\nAdjustable strap ensures a secure and customizable fit!\r\nCompatible with most off-road helmets for versatile use', 'Scorpion Exo Goggles Gold.webp', 'motorcycle goggles, Scorpion Exo, gold, eye protection, riding gear, motocross, off-road, premium, stylish', '2025-08-03 06:13:16'),
(90, 'LS2 Charger Goggle Orange with Rose Gold Iridium Visor', 2500, 3, 4, 11, 50, 'The LS2 Charger Goggle in HIV Orange with a Rose Gold Iridium visor is engineered for off-road enthusiasts seeking superior visibility and comfort. Its wide field of view, advanced lens technology, and secure fit make it an ideal choice for motocross and trail riding. The vibrant orange frame enhances visibility, while the rose gold iridium lens reduces glare and improves contrast.', 'Wide vertical (185mm arc-length) and horizontal (86mm arc-length) view area for optimal visibility!\r\nAnti-fog, abrasion, and impact-resistant Lexan lens with UVA & UVB protection!\r\nHigh-quality triple-layer foam for superior comfort and sweat absorption!\r\nElasticated 45mm strap with non-slip silicone reinforcement for a secure fit!\r\nVentilation holes around the frame for excellent airflow!\r\nVisor with nine-pin retention system for maximum stability', 'LS2 Charger Goggle HIV Orange with Rose Gold Iridium Visor.webp', 'motorcycle goggles, LS2, Charger, orange, rose gold iridium, visor, eye protection, motocross, colorful, premium', '2025-08-03 06:15:09'),
(91, 'Scorpion Exo Goggles White Black', 6500, 34, 4, 11, 21, 'The Scorpion Goggles in white and black are designed for off-road enthusiasts seeking durability and comfort. Featuring a flexible frame and anti-fog lens, they provide clear vision and a secure fit during intense rides. The white and black color scheme offers a sleek, modern look.', 'Durable construction for long-lasting use!\r\nAnti-fog lens to maintain clear vision!\r\nFlexible frame for a comfortable fit!\r\nSleek white and black design!\r\nCompatible with most off-road helmets', 'Scorpion Exo Goggles White Black.webp', 'motorcycle goggles, Scorpion Exo, white black, eye protection, riding gear, motocross, off-road, classic colors', '2025-08-03 06:17:06'),
(92, 'Airoh Blast XR1 Matt Pink Goggle | Red Mirrored Lens', 11000, 6, 4, 11, 5, 'The Airoh Blast XR1 Matt Pink Goggle with Red Mirrored Lens is designed for off-road enthusiasts seeking optimal visibility and comfort. Its ergonomic fit and high-quality lens provide clear vision and protection during intense rides. The vibrant pink frame adds a touch of style to your gear.', 'Red mirrored lens reduces glare and enhances contrast! Anti-fog coating ensures clear vision in varying conditions! Cylindrical lens design provides a wide field of view! Triple-layer foam offers superior comfort and moisture management! Adjustable strap with silicone grip ensures a secure fit! Vibrant matt pink frame adds a stylish look', 'Airoh Blast XR1 Matt Pink Goggle Red Mirrored Lens.webp', 'goggles, Airoh, off-road, pink, red lens, anti-fog, adjustable strap, comfortmotorcycle goggles, Airoh, Blast XR1, matt pink, red mirrored lens, eye protection, motocross, stylish, premium', '2025-08-03 06:18:27');
INSERT INTO `motoproducts` (`product_id`, `name`, `price`, `brand_fid`, `category_fid`, `sub_cat_fid`, `stock`, `description`, `features`, `image`, `tags`, `timestamp`) VALUES
(93, 'Motowolf MDL1921 Black Balaclava Mask', 700, 33, 4, 19, 60, 'The Motowolf MDL1921 Black Balaclava Mask is designed for motorcyclists and scooter riders seeking comfort and protection. Made from breathable polyester, it ensures optimal airflow, keeping you cool during rides. The mask features a glasses slot design, allowing for easy use with eyewear. Its reflective logo enhances visibility in low-light conditions, adding an extra layer of safety.', 'Breathable polyester fabric ensures comfort during rides!\r\nGlasses slot design allows for easy use with eyewear!\r\nReflective logo enhances visibility in low-light conditions!\r\nStretchable material fits most head sizes!\r\nLightweight and compact for easy storage', 'Motowolf MDL1921 Black Balaclava Mask.webp', 'balaclava, mask, Motowolf, MDL1921, black, face protection, riding gear, cold weather, breathable, comfort', '2025-08-03 06:22:58'),
(94, 'LS2 Black Balaclava Mask', 700, 3, 4, 19, 30, 'The LS2 Black Balaclava Mask is designed for motorcyclists and scooter riders seeking comfort and protection. Made from breathable cotton, it ensures optimal airflow, keeping you cool during rides. The mask features a universal fit, accommodating various head sizes. Its lightweight and compact design allows for easy storage and convenience. Ideal for both cold and warm weather conditions, this balaclava enhances your riding experience.', 'Breathable cotton fabric ensures comfort during rides!\r\nUniversal fit accommodates various head sizes!\r\nLightweight and compact design for easy storage!\r\nIdeal for both cold and warm weather conditions!\r\nSoft and wrinkle-free material for added comfort', 'LS2 Black Balaclava Mask.webp', 'balaclava, mask, LS2, black, face protection, riding gear, cold weather, moisture wicking, comfort, breathable', '2025-08-03 06:24:18'),
(95, 'Motowolf MDL1904 Black Balaclava Mask', 1000, 33, 4, 19, 48, 'The Motowolf MDL1904 Black Balaclava Mask is designed to provide comfort and protection for motorcyclists and scooter riders. Crafted from breathable fabric, it ensures optimal airflow, keeping you cool during rides. The mask features body temperature regulation, making it suitable for all seasons. Its soft and high-elasticity material offers a comfortable fit, while the universal size ensures compatibility with most riders. Ideal for shielding against wind, dust, and debris, this balaclava enhances your riding experience.', 'Quick-drying fabric ensures comfort during rides!\r\nBreathable material promotes optimal airflow!\r\nBody temperature regulation suitable for all seasons!\r\nSoft and high-elasticity fabric for a comfortable fit!\r\nUniversal fit accommodates various head sizes', 'Motowolf MDL1904 Black Balaclava Mask.webp', 'balaclava, Motowolf, motorcycle accessory, scooter gear, breathable, universal fit, quick-drybalaclava, mask, Motowolf, MDL1904, black, face protection, riding gear, cold weather, breathable, outdoor', '2025-08-03 06:25:34');

-- --------------------------------------------------------

--
-- Table structure for table `orders`
--

CREATE TABLE `orders` (
  `prim_id` int(255) NOT NULL,
  `bulk_id` int(255) NOT NULL,
  `user_id` int(11) NOT NULL,
  `product_id` int(255) NOT NULL,
  `name` char(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `ph_num` bigint(10) NOT NULL,
  `alt_ph_num` bigint(10) NOT NULL,
  `prod_name` varchar(255) NOT NULL,
  `prod_price` int(255) NOT NULL,
  `prod_quantity` int(255) NOT NULL,
  `street_name` varchar(255) NOT NULL,
  `tole` varchar(255) NOT NULL,
  `municipality` char(255) NOT NULL,
  `district` char(255) NOT NULL,
  `payment_method` char(255) NOT NULL,
  `placed_date` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `review`
--

CREATE TABLE `review` (
  `review_id` int(255) NOT NULL,
  `user_id` int(255) NOT NULL,
  `product_id` int(255) NOT NULL,
  `description` varchar(255) NOT NULL,
  `rating` varchar(255) NOT NULL,
  `review_date` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `review`
--

INSERT INTO `review` (`review_id`, `user_id`, `product_id`, `description`, `rating`, `review_date`) VALUES
(44, 17, 12, 'Great Product', '5', '2025-03-01 15:19:53'),
(45, 16, 12, 'Uncomfortable', '3', '2025-03-01 15:20:28'),
(46, 18, 12, 'Excellent product', '5', '2025-03-01 16:49:36');

-- --------------------------------------------------------

--
-- Table structure for table `sub_category`
--

CREATE TABLE `sub_category` (
  `sub_cat_id` int(255) NOT NULL,
  `cat_id` int(255) NOT NULL,
  `name` varchar(255) NOT NULL,
  `image` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `sub_category`
--

INSERT INTO `sub_category` (`sub_cat_id`, `cat_id`, `name`, `image`) VALUES
(1, 2, 'Full Face', 'full.png'),
(2, 4, 'Jackets', 'jacket.png'),
(4, 2, 'Half Helmet', 'half.png'),
(5, 2, 'Motocross', 'dirt.png'),
(6, 2, 'Visors', 'visor-helmet.png'),
(7, 4, 'Motorcycle Suits', 'race-suit.png'),
(8, 4, 'Trousers', 'trouser.png'),
(9, 4, 'Boots & Shoes', 'boots.png'),
(10, 4, 'Gloves', 'gear.png'),
(11, 4, 'Goggles', 'goggles.png'),
(12, 5, 'Handlebars', 'motorcycle.png'),
(13, 5, 'Brakes', 'brakes.png'),
(14, 5, 'Motorcycle Lights', 'turn-signal.png'),
(15, 5, 'Oils & Lubricants', 'engine-oil.png'),
(16, 5, 'Suspension', 'suspension.png'),
(17, 5, 'Exhausts', 'exhaust.png'),
(18, 5, 'Tyres', 'tyre.png'),
(19, 4, 'Masks', 'mask.png'),
(20, 2, 'Modular', 'modular.png'),
(21, 5, 'Handle Grips', 'grip.jpg');

-- --------------------------------------------------------

--
-- Table structure for table `user`
--

CREATE TABLE `user` (
  `id` int(255) NOT NULL,
  `name` char(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL,
  `phone_number` bigint(10) NOT NULL,
  `address` varchar(255) NOT NULL,
  `reg_date` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `user`
--

INSERT INTO `user` (`id`, `name`, `email`, `password`, `phone_number`, `address`, `reg_date`) VALUES
(16, 'Chris', 'chrisbhaila5@gmail.com', 'Chris@123', 9844379971, 'Suryabinayak', '2025-02-26 10:39:44'),
(17, 'John Doe', 'johndoe@gmail.com', 'John@123', 9801010101, 'Willowbrook', '2025-02-25 05:29:12'),
(18, 'James Wilson', 'jameswilson@gmail.com', 'James@123', 9820202020, 'Elm Street', '2025-03-01 16:48:38'),
(20, 'Ava Clark', 'avaclark@gmail.com', 'Avaclark@123', 9840404040, '', '2025-03-04 04:31:14'),
(21, 'User', 'user@gmail.com', 'User@123', 9810101010, '', '2025-07-29 06:58:12');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `admin`
--
ALTER TABLE `admin`
  ADD PRIMARY KEY (`aid`);

--
-- Indexes for table `brands`
--
ALTER TABLE `brands`
  ADD PRIMARY KEY (`brand_id`);

--
-- Indexes for table `categories`
--
ALTER TABLE `categories`
  ADD PRIMARY KEY (`category_id`);

--
-- Indexes for table `c_orders`
--
ALTER TABLE `c_orders`
  ADD PRIMARY KEY (`prim_id`);

--
-- Indexes for table `motoproducts`
--
ALTER TABLE `motoproducts`
  ADD PRIMARY KEY (`product_id`),
  ADD KEY `brand_fid` (`brand_fid`),
  ADD KEY `category_fid` (`category_fid`),
  ADD KEY `fk_sub_id` (`sub_cat_fid`);

--
-- Indexes for table `orders`
--
ALTER TABLE `orders`
  ADD PRIMARY KEY (`prim_id`);

--
-- Indexes for table `review`
--
ALTER TABLE `review`
  ADD PRIMARY KEY (`review_id`),
  ADD KEY `user_id` (`user_id`),
  ADD KEY `product_id` (`product_id`);

--
-- Indexes for table `sub_category`
--
ALTER TABLE `sub_category`
  ADD PRIMARY KEY (`sub_cat_id`),
  ADD KEY `fk_sub_cat` (`cat_id`);

--
-- Indexes for table `user`
--
ALTER TABLE `user`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `admin`
--
ALTER TABLE `admin`
  MODIFY `aid` int(255) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `brands`
--
ALTER TABLE `brands`
  MODIFY `brand_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=35;

--
-- AUTO_INCREMENT for table `categories`
--
ALTER TABLE `categories`
  MODIFY `category_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `c_orders`
--
ALTER TABLE `c_orders`
  MODIFY `prim_id` int(255) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=26;

--
-- AUTO_INCREMENT for table `motoproducts`
--
ALTER TABLE `motoproducts`
  MODIFY `product_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=105033;

--
-- AUTO_INCREMENT for table `orders`
--
ALTER TABLE `orders`
  MODIFY `prim_id` int(255) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=71;

--
-- AUTO_INCREMENT for table `review`
--
ALTER TABLE `review`
  MODIFY `review_id` int(255) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=48;

--
-- AUTO_INCREMENT for table `sub_category`
--
ALTER TABLE `sub_category`
  MODIFY `sub_cat_id` int(255) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=22;

--
-- AUTO_INCREMENT for table `user`
--
ALTER TABLE `user`
  MODIFY `id` int(255) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=22;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `motoproducts`
--
ALTER TABLE `motoproducts`
  ADD CONSTRAINT `motoproducts_ibfk_1` FOREIGN KEY (`brand_fid`) REFERENCES `brands` (`brand_id`),
  ADD CONSTRAINT `motoproducts_ibfk_2` FOREIGN KEY (`category_fid`) REFERENCES `categories` (`category_id`),
  ADD CONSTRAINT `motoproducts_ibfk_3` FOREIGN KEY (`sub_cat_fid`) REFERENCES `sub_category` (`sub_cat_id`);

--
-- Constraints for table `review`
--
ALTER TABLE `review`
  ADD CONSTRAINT `review_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `user` (`id`),
  ADD CONSTRAINT `review_ibfk_2` FOREIGN KEY (`product_id`) REFERENCES `motoproducts` (`product_id`);

--
-- Constraints for table `sub_category`
--
ALTER TABLE `sub_category`
  ADD CONSTRAINT `sub_category_ibfk_1` FOREIGN KEY (`cat_id`) REFERENCES `categories` (`category_id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
