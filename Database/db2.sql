-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: May 21, 2025 at 04:09 PM
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
(21, 'O\'neal', 'oneal.png');

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
(21, 2031871, 18, 64, 'James Wilson', 'jameswilson@gmail.com', 9820202020, 0, 'O’neal Matrix Ridewear Black Pants', 14385, 1, 'Elm Street', 'Elm Street', 'Springfield', 'Massachussets', 'Cash-on-Delivery', '2025-03-02 15:24:18', '2025-03-02 15:24:29');

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
  `image` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `motoproducts`
--

INSERT INTO `motoproducts` (`product_id`, `name`, `price`, `brand_fid`, `category_fid`, `sub_cat_fid`, `stock`, `description`, `features`, `image`) VALUES
(7, 'AGV PISTA GP R Winter Test 2018', 220000, 1, 2, 1, 3, '100% carbon fiber helmet offering unparalleled lightweight performance. The evolution of the groundbreaking Pista GP, the Moto GP helmet, it’s the most protective helmet ever developed. Its new “Biplano” spoiler and its included hydration system bring AGV’s safety and performances to the next level.', 'Double buckle closure.!\r\nHydration system fully integrated into the helmet, developed in MotoGP.!\r\nRoto-translational system in the mechanism for a perfect fit of the screen to the helmet.!\r\nEmergency release system of the side padding in the event of an accident, to facilitate helmet removal by medical personnel.    ', 'AGV PISTA GP R Winter Test 2018.jpg'),
(8, 'AGV PISTA GP RR Performante Carbon', 250000, 1, 2, 1, 1, 'Pista GP RR is an exact replica of the AGV helmet used in races by world champions. It has therefore received the new FIM homologation, which certifies the highest possible level of protection, even against any dangerous twisting of the head. Due to the exclusive AGV Extreme Safety design protocol, Pista GP RR already exceeds the requirements of the strict ECE22.06 homologation.', '100% carbon fiber! 190° panoramic vision! 85° vertical vision! Exclusive 360° Adaptive Fit system', 'Pista GP RR Performante Carbon.webp'),
(9, 'Airoh MARTYX Nytro Glossy', 60000, 6, 2, 1, 0, 'Determined, aggressive, self-confident. The new Matryx is the ideal travel companion to face any adventure, even the most demanding.', 'Determined, aggressive.!Self-confident; The ideal travel mate for any adventure!\r\nECE 2206 approved!\r\nCombines style, comfort and safety without neglecting even the smallest detail', 'MARTYX Nytro.jpg'),
(10, 'AXOR Retro Dominator Black', 13500, 4, 2, 1, 25, 'Retro Helmets are with a classic-legendary look. Retro’s are especially worn on traditional engines such as choppers, bobbers, cafe-racers, and many more. It is a complete entry-level full-face helmet with modern safety and production advancement with industrials standards in performance and style.', 'Fiberglass composite shell!\r\nChin air vent!\r\nDOT certified!\r\nHypoallergenic Liner!\r\nMulti-Density EPS liner!\r\nLeather Neck Roll', 'Axor Retro Dominator.webp'),
(12, 'SOMAN Balaclava', 800, 14, 4, 19, 88, 'This balaclava is made of high quality elastic fabric  to produce good quality outdoor sports masks which provide premium performance for breathability, absorbency, wicking, very soft and lightweight, stay warm and dry.', 'Material: High quality elastic fabric!\r\nColor: Black!\r\nStyle Unisex!\r\nLightweight', 'SOMAN Balaclava.png'),
(13, 'AXOR Jet Half', 5250, 4, 2, 4, 25, 'Traditional stitched Genuine leather edge trim and interior.', 'Genuine leather interiors and trims!\r\nReinforced strap and double D ring!\r\nRemovable, washable and anti-bacterial interior!\r\nWeighs up-to 1000 grams!\r\nDOT certified', 'Axor Jet Half.png'),
(14, 'Akrapovič Exhaust For Honda CBR600RR 2024 ', 130000, 8, 5, 17, 2, 'This product is created and designed using race-proven materials, with a high-grade lightweight titanium muffler, stainless-steel link pipe, and carbon-fibre end cap. It provides performance gains predominately in the mid and high rev ranges, with a power increase of 1.0 kW (1.4 hp) at 7,600 rpm and a torque increase of 1.0 Nm at 7,500 rpm, when compared to a Honda CBR600RR equipped with a standard stock exhaust system and tested on the Akrapovič dyno. Lightweight materials provide a weight reduction of 35.9% (1.6 kg) against the standard stock exhaust.', 'Power: +1.0 kW at 7600 rpm!\r\nTorque: +1.4Nm at 7500 rpm!\r\nWeight: -1.6kg', 'Honda Akrapovic.png'),
(15, 'Bell V3 RS Scans Helmet', 95000, 15, 2, 5, 5, 'As the most technologically advanced motocross helmet out there, the lightweight V3 RS Scans Helmet is packed with next-level features that align with your performance demands. Designed with Mips® Integra Split impact protection plus a dual-density Varizorb™ EPS liner that spreads forces of impact across a wider surface area, the V3 RS provides the kind of protection every racer needs in the heat of the moment.', 'Mips® Integra Split impact protection system equipped!\r\nCarbon fiber shell provides increased impact resistance while reducing weight!\r\n4 exhaust vents on the top of the helmet to aid in cooling!\r\nCompatible with most helmet communication systems', 'V3 RS Scans.webp'),
(43, 'ACF Handlebar', 16000, 16, 5, 12, 5, 'The ProTaper ACF Handlebar uses a revolutionary unidirectional carbon fiber core system to become the first carbon fiber reinforced motocross handlebar. The added strength allows the aluminum tubing wall thickness to be safely reduced in key areas, greatly decreasing weight and producing unrivaled impact-absorbtion. Innovative Control+ design features 220mm of control space or up to 40mm more than conventional 1-1/8', 'Control+ design provides more space for controls, mapping switches, and electric starters.!\r\nUnidirectional carbon fiber cores reinforce the aluminum tubing and safely reduce wall thickness in key areas.!\r\nUp to 20% lighter than conventional 1-1/8', 'acf-handlebar.png'),
(52, 'LS2 OF599 Spitfire Black', 7500, 3, 2, 4, 9, 'The LS2 OF599 Spitfire capture at first glance! The new LS2 half face is born thanks to the brand’s determination to propose a new modern and essential helmet, dedicated to the eclectic bikers doing of their total look a real style of life, which throw an eye to the design but not forgive protection and safety while riding their ‘two wheels’.LS2 visors are built with 3D Optically Correct “A Class” Polycarbonate, a space-age polymer with high resistance to impact, that avoids distortion and offers maximum clarity.', 'High-pressure thermoplastic outer shell construction!\r\nScratch and UV resistant quick release visor!\r\nIntegrated sun visor with quick control!\r\nMulti-density EPS lining!\r\nHypoallergenic, breathable, removable, and washable laser-cut extra comfort interior lining!\r\nQuick-release buckle fastening with reinforced chin strap!\r\nCertified ECE 22.05', 'LS2_OF599.jpg'),
(53, 'Shark VFX-EVO', 60000, 2, 2, 5, 4, 'Conquer rugged paths with the SHOEI VFX-Evo dirt bike helmet, crafted for peak performance. With its cutting-edge impact protection, enhanced ventilation, comfortable fit, and light build, it is the ideal companion for tackling challenging terrains while ensuring your safety and comfort.', 'Extra front intake vents combine with rear exhaust outlet vents and an enlarged neck outlet vent to maximize flow-through ventilation!\r\nCool air passes through the front intake vents, cools the helmet interior, and is exhausted through the rear vents by the force of negative air pressure!\r\nExpanded rib shapes across the rear enhances strap-holding performance for goggle wearers!\r\nE;Q;R;S; (Emergency Quick Release System) features special straps under the cheek pads which allow them to be easily removed, so the helmet can be quickly taken off by emergency personnel after an accident!', 'vfxevo.png'),
(54, 'LS2 Drifter Gloss White', 12499, 3, 2, 20, 7, 'The LS2 Drifter trial helmet boasts an aggressive and striking design, making it an ideal choice for riders across various biking domains, be it cruisers, trials, or navigating the bustling city streets. Its versatility shines through with a removable chin guard and an adjustable, removable peak, allowing riders to tailor their experience to their preferences. Crafted from KPA material, this helmet ensures both lightness and enhanced safety, a critical combination for any rider. Furthermore, the helmet’s adaptability is evident in its ability to swap from a clear to a dark visor, ensuring optimal visibility in various lighting conditions.', 'Kinetic Polymer Alloy (KPA) shell!\r\n2 shell sizes!\r\nReflective elements for added safety!\r\nRemovable helmet peak!\r\nUV and scratch resistant retractable sun visor!\r\nHypoallergenic, breathable, removable and washable lining!\r\nWeight: 1300g (+/-50g)!\r\nCertification: ECE 22.06', 'ls2drifter.jpg'),
(55, 'Shark Evo ES KRYD', 60000, 17, 2, 20, 6, 'he motorcycle jet EVO-ES helmet embodies all of SHARK’s expertise in the design of modular helmets for daily users seeking to enjoy optimal protection whether in the jet or integral position. In 2007, SHARK’s R&D department broke the codes of the modular helmet and created a new concept: the EVO-ES which remains the only true modular on the market.\r\n<br>\r\nWith a compact, aerodynamic profile, the EVO-ES modular is the ultimate 2-in-1 helmet – offering a choice of jet or full-face positioning. The EVO-ES is equipped with SHARK’s “Auto-up / Auto-down” system, the visor is automatically lifted when maneuvering the chin bar.', 'Shell made of injected thermoplastic resin!\r\nMulti-density EPS!\r\nMicrometric buckle system!\r\nAnti-scratch and anti-fog visor!\r\nUV380-labeled visor treated to resist scratches!\r\nQuick visor release system!\r\nWeight: 1,650!\r\nECE Certified', 'evoEs.png'),
(56, 'RCB HG66 Handle Grip Grey', 1500, 14, 5, 21, 45, 'The RCB HG66 bike handlebar grips provide a secured grip and enhanced comfort, ensuring a safer and more enjoyable riding experience. Available in various colors, they allow you to personalize your bike to match your style. Designed to improve riding safety, these grips absorb vibration, reducing hand fatigue and ensuring a smoother ride on any terrain.', 'Secured grip and comfort!\r\nImproves riding safety!\r\nAbsorbs vibration', 'RCB-HG66.jpg'),
(57, 'Vesrah Ceramic Disc Brake pad for KTM ALL /ROYAL ENFIELD ALL/ BAJAJ ALL/ BMW ALL SD-953 (Rear)', 2300, 18, 5, 13, 98, 'Vesrah Motorcycle Ceramic Brake Pads are high-quality brake pads designed specifically for motorcycles. These brake pads is made with advanced ceramic composite materials that offer exceptional braking performance, durability, and reduces noise and dust.<br>\r\n\r\nIn addition to their superior performance and durability. Vesrah Ceramic Brake Pads  produce less dust than traditional brake pads, Vesrah Ceramic Brake Pads  helps to keep wheels and tires cleaner and reduces the amount of airborne particles.<br>\r\n\r\nOverall, Vesrah Motorcycle Ceramic Brake Pads are a top-of-the-line option for motorcycle riders looking for high-performance, long-lasting brake pads that offer exceptional stopping power, reduced noise and dust, and a more comfortable riding experience.', 'An excellent, economical choice for replacing OEM sintered metal brake pads.!\r\nPad consists of 50-60% copper combined with carbon, ceramic, tin and abrasives.!\r\nIron backing plate is plated with copper to make it a stronger bond with the pad friction material.!\r\nPowerful stopping power in wet or dry conditions.!\r\nExcellent initial pad bite, lower lever effort and minimal pad bed-in time required.!\r\nCan be used with stainless steel rotors.!\r\nBRAKE PADS ARE SOLD IN PAIRS, ONE PAIR OF PADS PER EACH CALIPER..', 'Rear-Disc-Pad.webp'),
(58, 'JPA R15 V3/V4 Integrated Taillight', 7000, 14, 5, 14, 14, 'JPA focuses its products on lights on motor vehicles such as headlights, taillights, and turn signals. The type of lamp used is a quality HID and LED Tube lamp, resulting in a good description and vivid lamp color. With quality plastic, the frame body and mica lamps from JPA are more durable, and engineered to provide unparalleled safety and efficiency for your vehicle. Designed with a focus on longevity and eco-consciousness, this tail light combines durability, energy efficiency, and low radiation for a superior driving experience.', 'Compatible with R15 V3/V4!\r\nLong life Durable!\r\nMercury Free!\r\nEnergy Efficient Energy Saving!\r\nLow Head Radiation Low Radiation', 'R15_tailight.png'),
(59, 'Liqui Moly Motorbike 4T Synth 10W-40 STREET RACE 1L Engine Oil', 2235, 19, 5, 15, 25, 'The Liqui Moly Motorbike 4T Synth, Fully synthetic high-performance motor oil. For maximum performance and outstanding engine protection under all operating conditions. Offers perfect lubrication, outstanding engine cleanliness, excellent friction and minimum wear. Ensures smooth engagement and disengagement as well as gear shifting, which significantly increases driving pleasure. Tested for use with catalytic converters and on racing machines.', 'Fully Synthetic.!\r\nFor air and water-cooled 4-stroke engines.!\r\nSuitable for engines with or without a wet clutch.!\r\nFor sporting applications.!\r\nFor normal to extreme operating conditions.!\r\nVolume: 1 L!\r\nViscosity: 10W-40!\r\nQuality Levels: API SN Plus, JASO MA2', 'LiquiMoly10w-40.png'),
(60, 'HJC i71 Celos MC5 Black Glitter', 35000, 5, 2, 1, 10, 'The i71 sets a new standard in Sport-Touring excellence with its streamlined shell design. Utilizing Advanced Polycarbonate technology, this helmet features 3 shells across 6 sizes, meticulously engineered for optimal weight and rider comfort. The repositioned top vent and expanded mouth vents maximize airflow, enhancing intake and ventilation dynamics. Pioneering innovation, the i71 introduces the HJ-38 Pinlock-ready face shield with an upgraded PE (Push/Eject) locking mechanism for enhanced safety and usability, even with gloves. Additionally, the new sun visor (HJ-V12) offers a versatile 3-position adjustment, allowing riders to adjust the sun shield up to 10mm forward for optimal sun protection.', 'Advanced Polycarbonate Composite Shell: Lightweight, superior fit and enhanced comfort!\r\n“ACS” Advanced Channeling Ventilation System: Full front-to-back airflow flushes heat and humidity up and out.!\r\nPinlock Ready HJ-38 Visor: Provides 99% UV protection, Anti-Scratch coated.!\r\nInterior provides enhanced moisture wicking and quick drying function.!\r\nCrown and Cheek pads: Removable and washable.!\r\nReady for SMART HJC 11B, 21B & 50B Bluetooth (sold separately).!\r\nIt comes standard with Pinlock, Chin Curtain and Breath deflector.!\r\nWeight: 1650 grams!\r\nCertification: ECE 22-06.', 'hjc--i71.webp'),
(61, 'GP-R7 1PC Leather Suit', 160000, 7, 4, 7, 4, 'Designed for trackday riders, racers and advanced road riders, the GP-R7 1PC Leather Suit is optimized for performance riding, on the road or the track, and is constructed from premium Race-grade, 1.3mm bovine leather for superior abrasion resistance, flexibility, and comfort. With a race fit and extensive perforations for maximum airflow, this suit also incorporates a streamlined speed hump specifically engineered to complement Alpinestars Supertech R10 Helmet for optimum aerodynamic performance. It’s supremely protective too, thanks to its Nucleon PLASMA Pro armor.', '1.3mm ‘Race’ spec soft bovine leather construction incorporating dual layers in critical areas for optimized flexibility and abrasion resistance.!\r\nEquipped with Alpinestars Nucleon PLASMA Pro CE Level 2 armor.!!\r\nIncorporates Alpinestars ‘Race’ spec Supertech R10 aero hump. Designed and engineered to work in conjunction with Alpinestars S-R10 Helmet for optimum streamlining and aerodynamic performance with rider tucked in a racing crouch.!\r\nOptimized for use with Alpinestars Tech-Air® Airbag Systems; Tech-Air® 5, Tech-Air® 10 and is Tech-Air® Compatible with the new Tech-Air® 7x Airbag System.', 'gpr71pc.jpg'),
(62, 'X-Fourteen MARQUEZ6 X-Spirit III', 100000, 2, 2, 1, 5, '\"X-Series\"― SHOEI\'s full face helmet for Racing developed through World\'s Top Road Races including MotoGP.\r\nAll of shell, shield, interiors and aero device are renewed by realizing safety in high level and utilizing most advanced know-how obtained from race support in top category. \"REAL RACING SPEC\" is truly brought into shape, X-Fourteen / X-Spirit III, the full face helmet to win races.\r\nBrand new SHOEI top-of-the-line model starts racing in the world.', 'Tear-off Film Attachable Flat Shield – CWR-F Shield!\r\nPINLOCK® EVO lens!\r\nAdjust Wearing Position of Interiors corresponding to Racing Position!\r\nStrongly introduce riding wind, exhaust hot air and moisture effectively―ventilation system makes a rider feels wind.!\r\nE.Q.R.S.（Emergency Quick Release System)!\r\n', 'X-Fourteen-MARQUEZ6_TC-1.png'),
(63, 'KADOYA K’s Leather Early 00s ‘STEALTH’ Padded Leather Motorcycle Jacket', 90000, 20, 4, 2, 5, 'Established during World War II, Kadoya is a motorcycle gears manufacturer based in Tokyo, Japan with a heritage that spans for almost a century. Notorious for their amazing craft for leather specialty goods catering to bikers or motorcycles enthusiast. Their legacy consistently exists without change because of their proud philosophy that plays a part in the core of Japanese manufacturing. Similar to the previously posted ‘Hayabusa’ jacket, the particular model was custom-made for racing members of “STEALTH Racing”, a renowned Japanese automobile hardware manufacturer that specializes in innovative wheels model. The jacket is constructed with a premium cowhide leather as base, featuring thick motorcycle paddings throughout front, back and elbow for safety purposes, comes with adjustable side waist and YKK hardware.', 'Leather 100%!\r\nNylon Lining 100%!\r\nPlastic Paddings', 'kadoya1.jpg'),
(64, 'O’neal Matrix Ridewear Black Pants', 14385, 21, 4, 8, 9, 'The O’neal Matrix Ridewear Pants are one of a kind. You need top gear to keep you focused on the important thing: riding. And these pants are one of the most important things that you need.', 'Based on the O\'neals Element gear!\r\nOptimal freedom of movement!\r\nComfortable fit meets reliable protection!\r\nMade of highly durable material', 'ridewearOneal.png');

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

--
-- Dumping data for table `orders`
--

INSERT INTO `orders` (`prim_id`, `bulk_id`, `user_id`, `product_id`, `name`, `email`, `ph_num`, `alt_ph_num`, `prod_name`, `prod_price`, `prod_quantity`, `street_name`, `tole`, `municipality`, `district`, `payment_method`, `placed_date`) VALUES
(67, 8041670, 16, 8, 'Chris', 'chrisbhaila5@gmail.com', 9844379971, 0, 'AGV PISTA GP RR Performante Carbon', 250000, 1, 'pataan', 'nyadhal', 'lalitpur', 'Lalitpur', 'Cash-on-Delivery', '2025-04-08 04:55:23');

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
(15, 'Test User', 'testuser@gmail.com', 'TestUser@123', 9811002233, 'Memory', '2024-12-27 17:30:05'),
(16, 'Chris', 'chrisbhaila5@gmail.com', 'Chris@123', 9844379971, '', '2025-02-26 10:39:44'),
(17, 'John Doe', 'johndoe@gmail.com', 'John@123', 9801010101, 'Willowbrook', '2025-02-25 05:29:12'),
(18, 'James Wilson', 'jameswilson@gmail.com', 'James@123', 9820202020, 'Elm Street', '2025-03-01 16:48:38'),
(20, 'Ava Clark', 'avaclark@gmail.com', 'Avaclark@123', 9840404040, '', '2025-03-04 04:31:14');

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
  MODIFY `brand_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=22;

--
-- AUTO_INCREMENT for table `categories`
--
ALTER TABLE `categories`
  MODIFY `category_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `c_orders`
--
ALTER TABLE `c_orders`
  MODIFY `prim_id` int(255) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=22;

--
-- AUTO_INCREMENT for table `motoproducts`
--
ALTER TABLE `motoproducts`
  MODIFY `product_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=65;

--
-- AUTO_INCREMENT for table `orders`
--
ALTER TABLE `orders`
  MODIFY `prim_id` int(255) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=68;

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
  MODIFY `id` int(255) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=21;

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
