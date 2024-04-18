SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `gabor`
--
CREATE DATABASE IF NOT EXISTS `gabor` DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci;
USE `gabor`;

-- --------------------------------------------------------

--
-- Table structure for table `accounts`
--

CREATE TABLE `accounts` (
  `id` int NOT NULL,
  `username` varchar(32) NOT NULL,
  `password` varchar(255) NOT NULL,
  `regdate` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `permission` int DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `accounts`
--

INSERT INTO `accounts` (`id`, `username`, `password`, `regdate`, `permission`) VALUES
(1, 'admin', 'c7ad44cbad762a5da0a452f9e854fdc1e0e7a52a38015f23f3eab1d80b931dd472634dfac71cd34ebc35d16ab7fb8a90c81f975113d6c7538dc69dd8de9077ec', '2024-04-17 18:06:13', 1);

-- --------------------------------------------------------

--
-- Table structure for table `likes_bind`
--

CREATE TABLE `likes_bind` (
  `id` int NOT NULL,
  `userid` int NOT NULL,
  `postid` int NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `likes_bind`
--

INSERT INTO `likes_bind` (`id`, `userid`, `postid`) VALUES
(1, 1, 1);

-- --------------------------------------------------------

--
-- Table structure for table `posts`
--

CREATE TABLE `posts` (
  `id` int NOT NULL,
  `userid` int NOT NULL,
  `title` varchar(64) NOT NULL,
  `text` text NOT NULL,
  `type` int NOT NULL,
  `postdate` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `posts`
--

INSERT INTO `posts` (`id`, `userid`, `title`, `text`, `type`, `postdate`) VALUES
(1, 1, 'Csak az 1.9', 'Az 1.9 PD TDI motor egyike a legjobban elismert és megbízhatóbb dízelmotoroknak. Erőteljes teljesítményt kínál, miközben hatékony üzemanyag-fogyasztást biztosít. Az alacsony fordulatszámon nyújtott nyomatéka kiváló gyorsulást és rugalmasságot eredményez minden helyzetben. Továbbá, megbízható és tartós szerkezetének köszönhetően hosszú távon is kiválóan teljesít, amiért sokan elismerik és választják ezt a motort.', 2, '2024-04-17 18:08:17'),
(2, 1, 'Munkát vállalok!', 'Szolgáltatásaim között szerepel az adott területen való szaktudásom alapján végzett maszek munka is. Rugalmas vagyok és elkötelezett az ügyfelek igényeinek kielégítése mellett. Minőségi munkát és pontos határidőket garantálok minden projektem során. Legyen szó barkácsprojektekről, takarításról vagy egyéb ház körüli feladatokról, szívesen álllok rendelkezésre maszekba.', 3, '2024-04-17 18:09:30');

-- --------------------------------------------------------

--
-- Table structure for table `topics`
--

CREATE TABLE `topics` (
  `id` int NOT NULL,
  `name` varchar(32) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `topics`
--

INSERT INTO `topics` (`id`, `name`) VALUES
(1, 'programozás'),
(2, 'autók'),
(3, 'maszek'),
(4, 'iskola');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `accounts`
--
ALTER TABLE `accounts`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `likes_bind`
--
ALTER TABLE `likes_bind`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `posts`
--
ALTER TABLE `posts`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `topics`
--
ALTER TABLE `topics`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `accounts`
--
ALTER TABLE `accounts`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `likes_bind`
--
ALTER TABLE `likes_bind`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `posts`
--
ALTER TABLE `posts`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `topics`
--
ALTER TABLE `topics`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
