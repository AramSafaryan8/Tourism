-- phpMyAdmin SQL Dump
-- version 5.1.2
-- https://www.phpmyadmin.net/
--
-- Host: localhost:3306
-- Generation Time: Mar 07, 2024 at 12:32 PM
-- Server version: 5.7.24
-- PHP Version: 8.0.1

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `tourism`
--

-- --------------------------------------------------------

--
-- Table structure for table `attractions`
--

CREATE TABLE `attractions` (
  `id` int(11) NOT NULL,
  `title` varchar(30) NOT NULL,
  `desc` text NOT NULL,
  `pic` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `attractions`
--

INSERT INTO `attractions` (`id`, `title`, `desc`, `pic`) VALUES
(1, 'Eiffel Tower', 'Nestled along the banks of the Seine, the Eiffel Tower, Paris\'s undying symbol of grace and innovation, reigns supreme over the city\'s skyline. Conceived by the visionary Gustave Eiffel for the 1889 Exposition Universelle, this iron-clad masterpiece was met with awe and controversy, solidifying its place as an indelible landmark.\n\nAscending with an elegant lattice of intricately crafted beams, the Eiffel Tower beckons both locals and wanderers alike to venture upwards, revealing breathtaking panoramic views that stretch across the enchanting city. Each level narrates a unique story — from the bustling streets below to the timeless landmarks that define Parisian allure.\n\nYet, as dusk descends, the Eiffel Tower undergoes a metamorphosis. A soft glow envelops its structure, and it becomes a canvas for the night. Thousands of twinkling lights, like stars descended to Earth, lend an ethereal quality, turning the Eiffel Tower into a beacon of romance. In this nightly transformation, the tower weaves tales of love, art, and history, encapsulating the timeless magic of a city that continues to captivate hearts worldwide.\n\nAs visitors and locals alike gather on the Champ de Mars to witness this luminous spectacle, the Eiffel Tower stands not merely as a monument but as a living testament to human ingenuity and the enduring allure of Paris. In its silhouette against the night sky, the Eiffel Tower whispers tales of resilience, sophistication, and the unwavering charm that has made it a global icon for more than a century.', '/attractions/eiffel_tower.avif'),
(2, 'Pisa Tower', 'Step into the enchanting world of architectural marvels with the Leaning Tower of Pisa, a captivating symbol of Italy\'s rich history. Nestled in the heart of Pisa Cathedral Square, this iconic structure, also known as the \"torre pendente di Pisa,\" beckons travelers with its beguiling four-degree lean—a testament to its centuries-old tale of resilience.\r\n\r\nRising to a majestic height of 55.86 meters on the low side and 56.67 meters on the high side, the Tower of Pisa is a freestanding bell tower that gracefully complements the grandeur of Pisa Cathedral and the Pisa Baptistry. The intricate details reveal walls with a base width of 2.44 meters and a weight estimated at a staggering 14,500 tonnes, adding to the allure of this architectural wonder.\r\n\r\nEmbark on a journey through time as you ascend the tower\'s 296 or 294 steps, discovering its unique charm at every turn. Marvel at the seventh floor, where the north-facing staircase boasts two fewer steps, adding a touch of mystery to this already captivating structure.\r\n\r\nThe Leaning Tower of Pisa\'s captivating lean began during its construction in the 12th century, a result of the soft ground struggling to support its weight. As the centuries unfolded, the lean intensified, reaching a remarkable 5.5 degrees by 1990. Witness the triumph of architectural ingenuity as remedial work, conducted from 1993 to 2001, not only stabilized the tower but also gracefully reduced the tilt to 3.97 degrees.\r\n\r\nImmerse yourself in the fascinating narrative of the Leaning Tower of Pisa—a timeless icon that stands tall, defying the odds and inviting visitors to witness the magic of its unique tilt.', '/attractions/pisa_tower.jpg'),
(3, 'Notre Dame', 'Embark on a journey through time and marvel at the timeless splendor of Notre-Dame Cathedral, an iconic masterpiece nestled along the banks of the Seine River in Paris. Immerse yourself in the architectural grandeur of this Gothic wonder, where history and art intertwine to create a symphony of awe-inspiring beauty.\r\n\r\nWith its magnificent façade adorned with intricate sculptures and gargoyles, Notre-Dame stands as a testament to centuries of craftsmanship. The majestic rose windows, bathed in the hues of centuries-old stories, cast a kaleidoscope of colors that dance upon the ancient stones, captivating visitors from around the globe.\r\n\r\nAscend the worn steps to the towers, where panoramic views of Paris unfold before your eyes. Gaze upon the city\'s timeless skyline, punctuated by landmarks that echo the footsteps of countless generations. The air is infused with a sense of reverence, as if the very stones hold the whispers of the past.\r\n\r\nNotre-Dame, a living canvas of history, witnessed the rise and fall of empires, weathered the storms of time, and bore witness to moments of both triumph and tragedy. The cathedral\'s spire, soaring towards the heavens, became a symbol of hope and resilience—a beacon that endured the ravages of time until a devastating fire in 2019.\r\n\r\nYet, like a phoenix rising from the ashes, Notre-Dame is on a path to restoration. The global community has rallied, uniting in a shared commitment to revive this architectural gem. The reconstruction efforts, a testament to human perseverance, aim to breathe new life into the cathedral, ensuring that its splendor continues to inspire generations to come.\r\n\r\nAs Notre-Dame undergoes its metamorphosis, let us reflect on the enduring spirit of this sacred monument—a guardian of Parisian history, a canvas of artistry, and a symbol of resilience that transcends the boundaries of time. In the heart of Paris, Notre-Dame beckons, inviting all to witness the beauty that emerges when history and craftsmanship converge in a symphony of stone and stained glass.', '/attractions/notre_dame.webp'),
(4, 'Louvre Pyramid', 'Embark on a captivating journey through the heart of Paris, where the iconic Louvre Pyramid emerges as a modern marvel amidst the timeless treasures of art and history. As the radiant sun casts its golden glow upon the glass facets, the Louvre Pyramid stands as a symbol of architectural innovation, seamlessly bridging the gap between classical elegance and contemporary design.\r\n\r\nNestled within the grandeur of the Louvre Museum, the pyramid serves as a beacon, drawing admirers into a realm where the past and the present coalesce. Comprising 673 diamond-shaped glass panes and a metal framework, this architectural gem echoes the precision of a finely crafted masterpiece, reflecting the sky above and the historical splendor that lies beneath.\r\n\r\nApproach the courtyard, where the Louvre Pyramid becomes a focal point of harmony—a juxtaposition of tradition and modernity. As you traverse the elegant pathways surrounding the pyramid, its symmetrical allure becomes a mesmerizing dance of light and shadow, creating an ambiance that captivates the imagination.\r\n\r\nStep inside the Louvre, passing through the Pyramid\'s subterranean entrance, and find yourself surrounded by the echoes of centuries. The convergence of contemporary design and classical art forms a dialogue that transcends the boundaries of time. The Louvre Pyramid, conceived by architect I. M. Pei, serves not only as an entrance but as a testament to the museum\'s commitment to evolution and reinvention.\r\n\r\nThe Louvre Pyramid, like a contemporary jewel nestled in the historical tapestry of Paris, invites exploration and contemplation. As you stand before its geometric splendor, you become part of a narrative that spans eras—a narrative that celebrates the marriage of innovation and tradition, inviting all to witness the artistry of human imagination and the eternal allure of cultural treasures.', '/attractions/louvre_pyramid.jpg'),
(5, 'Empire State Building', 'Embark on a vertical odyssey through the heart of Manhattan, where the Empire State Building ascends into the bustling skies, an architectural colossus that stands as an enduring symbol of New York City\'s grandeur. This towering icon, with its art-deco facade punctuating the skyline, invites both locals and wanderers to revel in its timeless majesty.\r\n\r\nGaze upward and witness the Empire State Building\'s silhouette against the vibrant canvas of the city that never sleeps. As daylight graces its steel and limestone exterior, the building stands as a testament to the ambitious spirit that defines New York—an artful blend of strength and sophistication.\r\n\r\nEnter the lobby, where the echoes of history resonate beneath the ornate ceiling. The aura is electric, a fusion of nostalgia and contemporary allure that welcomes visitors into a realm where every inch tells a tale of innovation and resilience. The Empire State Building, conceived during the Great Depression, arose as a beacon of hope, a testament to human tenacity, and a tribute to the city\'s unyielding spirit.\r\n\r\nAscend to the observation deck, where panoramic views of Manhattan sprawl beneath your feet. The cityscape stretches as far as the eye can see, a living tapestry woven with iconic landmarks and bustling streets. Whether bathed in the glow of the setting sun or illuminated by the city lights at night, the Empire State Building\'s summit offers a breathtaking spectacle—a testament to the city\'s perpetual pulse.\r\n\r\nMarvel at the meticulous design, the soaring spire, and the iconic pinnacle that crowns the building. The Empire State Building stands not only as a physical marvel but as a living testament to the audacity of dreams, a tribute to the visionaries who shaped its skyline-defining silhouette.\r\n\r\nAs you stand atop this architectural giant, let the Empire State Building be more than steel and stone. Let it be a conduit to the dreams, aspirations, and enduring spirit of New York—a city where the sky is not the limit but a canvas upon which stories of ambition and achievement are painted.', '/attractions/empire_state_building.jpg'),
(6, 'Cascade Complex', 'Nestled in the heart of Yerevan, Armenia, the Cascade Complex stands as a testament to the harmonious blend of art, nature, and architectural brilliance. This magnificent stairway, a grandiose limestone masterpiece, gracefully ascends the hills, offering a breathtaking panorama of the city below and the majestic Mount Ararat on the distant horizon.\r\n\r\nConceived by the visionary architect Alexander Tamanyan, the Cascade is not merely a staircase but an open-air museum, adorned with a splendid array of contemporary sculptures and installations. Each step unveils a captivating fusion of modern artistic expressions, creating a dynamic dialogue between the natural surroundings and the ingenuity of human creativity.\r\n\r\nThe serenity of the cascading fountains complements the vibrant cultural energy emanating from the Cafesjian Center for the Arts, nestled within the complex. This cultural hub houses a rich collection of contemporary art, engaging visitors in a sensory journey that transcends time and tradition.\r\n\r\nAs the sun sets, the Cascade transforms into a luminous spectacle, with its grandiose staircase illuminated in a soft, golden glow. Whether appreciated for its architectural prowess, artistic treasures, or panoramic views, the Cascade Complex stands as a testament to Armenia\'s rich cultural tapestry, inviting all who ascend its steps to partake in the beauty of this enchanting intersection of nature and human creativity.', '/attractions/cascade_complex.jpg');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `attractions`
--
ALTER TABLE `attractions`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `attractions`
--
ALTER TABLE `attractions`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
