
INSERT INTO `profession` (`id`, `title`) VALUES
(1, ''any''),
(2, ''front end junior developer''),
(3, ''back end junior developer''),
(4, ''front end senior developer''),
(5, ''back end senior developer''),
(6, ''mid front end developer''),
(7, ''mid back end developer''),
(8, ''junior business analyst''),
(9, ''business analyst''),
(10, ''junior database specialist''),
(11, ''junior qa engineer''),
(12, ''software tester''),
(13, ''junior software tester''),
(14, ''qa engineer''),
(15, ''scrum master''),
(16, ''team manager'');

INSERT INTO `user` (`id`, `profession_id`, `email`, `roles`, `password`, `first_name`, `last_name`, `is_active`) VALUES
(1, 1, ''admin@nfq.lt'', ''[\"ROLE_ADMIN\"]'', ''$argon2i$v=19$m=65536,t=4,p=1$NFFYMVBOVk5SQktFeGxOSQ$HL07H6NutU65L65XeoovD9EJQ1XW428EIOxSQjCy+hk'', ''Human'', ''Resources'', 1),
(2, 2, ''gintaras.pr@nfq.lt'', ''[]'', ''$argon2i$v=19$m=65536,t=4,p=1$amtzT05hMzRKbWx0RllhRA$EjgHNRWTqhs99Xsr7cPQNR91aLWkfvoYYymliRmyaJo'', ''Gintaras'', ''Programuoja'', 1),
(3, 6, ''marius.ma@nfq.lt'', ''[]'', ''$argon2i$v=19$m=65536,t=4,p=1$aVBiUHk1WDJ1WXdhd1Iycw$tXPohp5qJT4IhHH9f8xoa8/qVQkwszJkSytgrnzHV/k'', ''Marius'', ''Marenas'', 1),
(4, 12, ''sigita.pa@nfq.lt'', ''[]'', ''$argon2i$v=19$m=65536,t=4,p=1$dEpIdmlKUGREVWNkbmpzTg$OYoXBJ2LUuhZW+Jlj6GvCZVJVu8Ph8DAEw+/P4CK+2Q'', ''Sigita'', ''Pavarde'', 1),
(5, 5, ''zbignev.bz@nfq.lt'', ''[]'', ''$argon2i$v=19$m=65536,t=4,p=1$SHlOdVc5NkJzVVN2U08yVg$jKerUfMnymtaSzYKC9xv91jtOwT5zQyB4OexQyFA6co'', ''Zbignev'', ''Bzignev'', 1),
(6, 3, ''henrikas.va@nfq.lt'', ''[]'', ''$argon2i$v=19$m=65536,t=4,p=1$Snk1SWNDamZ1dERHUnI5RA$JjTHySw3xmPit5sk9qyBwgyruMp/AOrWpy0Vp0Pnv3c'', ''Henrikas'', ''Valatka'', 1),
(7, 16, ''julius.ju@nfq.lt'', ''[\"ROLE_HEAD\"]'', ''$argon2i$v=19$m=65536,t=4,p=1$dEpIdmlKUGREVWNkbmpzTg$OYoXBJ2LUuhZW+Jlj6GvCZVJVu8Ph8DAEw+/P4CK+2Q'', ''Julius'', ''Jucikas'', 1),
(8, 16, ''karolina.ka@nfq.lt'', ''[\"ROLE_HEAD\"]'', ''$argon2i$v=19$m=65536,t=4,p=1$dEpIdmlKUGREVWNkbmpzTg$OYoXBJ2LUuhZW+Jlj6GvCZVJVu8Ph8DAEw+/P4CK+2Q'', ''Karolina'', ''Kalinauskaite'', 1),
(9, 16, ''giedrius.ra@nfq.lt'', ''[\"ROLE_HEAD\"]'', ''$argon2i$v=19$m=65536,t=4,p=1$dEpIdmlKUGREVWNkbmpzTg$OYoXBJ2LUuhZW+Jlj6GvCZVJVu8Ph8DAEw+/P4CK+2Q'', ''Giedrius'', ''Ramanauskas'', 1),
(10, 7, ''paulius.pa@nfq.lt'', ''[]'', ''$argon2i$v=19$m=65536,t=4,p=1$Snk1SWNDamZ1dERHUnI5RA$JjTHySw3xmPit5sk9qyBwgyruMp/AOrWpy0Vp0Pnv3c'', ''Paulius'', ''Paškevicius'', 1),
(11, 8, ''lukas.lu@nfq.lt'', ''[]'', ''$argon2i$v=19$m=65536,t=4,p=1$Snk1SWNDamZ1dERHUnI5RA$JjTHySw3xmPit5sk9qyBwgyruMp/AOrWpy0Vp0Pnv3c'', ''Lukas'', ''Lukauskas'', 1),
(12, 9, ''petras.pe@nfq.lt'', ''[]'', ''$argon2i$v=19$m=65536,t=4,p=1$Snk1SWNDamZ1dERHUnI5RA$JjTHySw3xmPit5sk9qyBwgyruMp/AOrWpy0Vp0Pnv3c'', ''Petras'', ''Petraitis'', 1),
(13, 10, ''jonas.jo@nfq.lt'', ''[]'', ''$argon2i$v=19$m=65536,t=4,p=1$Snk1SWNDamZ1dERHUnI5RA$JjTHySw3xmPit5sk9qyBwgyruMp/AOrWpy0Vp0Pnv3c'', ''Jonas'', ''Jonaitis'', 1),
(14, 11, ''gabriele.ka@nfq.lt'', ''[]'', ''$argon2i$v=19$m=65536,t=4,p=1$Snk1SWNDamZ1dERHUnI5RA$JjTHySw3xmPit5sk9qyBwgyruMp/AOrWpy0Vp0Pnv3c'', ''Gabriele'', ''Kazlauskaite'', 1),
(15, 12, ''juozas.ju@nfq.lt'', ''[]'', ''$argon2i$v=19$m=65536,t=4,p=1$Snk1SWNDamZ1dERHUnI5RA$JjTHySw3xmPit5sk9qyBwgyruMp/AOrWpy0Vp0Pnv3c'', ''Juozas'', ''Juozaits'', 1),
(16, 13, ''dovydas.ja@nfq.lt'', ''[]'', ''$argon2i$v=19$m=65536,t=4,p=1$Snk1SWNDamZ1dERHUnI5RA$JjTHySw3xmPit5sk9qyBwgyruMp/AOrWpy0Vp0Pnv3c'', ''Dovydas'', ''Jankunas'', 1),
(17, 14, ''kristina.pr@nfq.lt'', ''[]'', ''$argon2i$v=19$m=65536,t=4,p=1$Snk1SWNDamZ1dERHUnI5RA$JjTHySw3xmPit5sk9qyBwgyruMp/AOrWpy0Vp0Pnv3c'', ''Kristina'', ''Pranckeviciene'', 1),
(18, 15, ''ignas.uz@nfq.lt'', ''[]'', ''$argon2i$v=19$m=65536,t=4,p=1$Snk1SWNDamZ1dERHUnI5RA$JjTHySw3xmPit5sk9qyBwgyruMp/AOrWpy0Vp0Pnv3c'', ''Ignas'', ''Uzupis'', 1),
(19, 8, ''viktorija.jo@nfq.lt'', ''[]'', ''$argon2i$v=19$m=65536,t=4,p=1$Snk1SWNDamZ1dERHUnI5RA$JjTHySw3xmPit5sk9qyBwgyruMp/AOrWpy0Vp0Pnv3c'', ''Viktorija'', ''Jonaitiene'', 1),
(20, 4, ''ovidijus.or@nfq.lt'', ''[]'', ''$argon2i$v=19$m=65536,t=4,p=1$Snk1SWNDamZ1dERHUnI5RA$JjTHySw3xmPit5sk9qyBwgyruMp/AOrWpy0Vp0Pnv3c'', ''Ovidijus'', ''Orelikas'', 1),
(21, 12, ''evaldas.va@nfq.lt'', ''[]'', ''$argon2i$v=19$m=65536,t=4,p=1$Snk1SWNDamZ1dERHUnI5RA$JjTHySw3xmPit5sk9qyBwgyruMp/AOrWpy0Vp0Pnv3c'', ''Evaldas'', ''Vasiliauskas'', 1),
(22, 14, ''tadas.vi@nfq.lt'', ''[]'', ''$argon2i$v=19$m=65536,t=4,p=1$Snk1SWNDamZ1dERHUnI5RA$JjTHySw3xmPit5sk9qyBwgyruMp/AOrWpy0Vp0Pnv3c'', ''Tadas'', ''Vingis'', 1);


INSERT INTO `team` (`id`, `title`) VALUES
(1, ''Brogrammers''),
(2, ''Optimize Prime''),ė
(3, ''Code Warriors'');

INSERT INTO `team_user` (`team_id`, `user_id`) VALUES
(1, 2),
(1, 3),
(1, 4),
(2, 5),
(2, 6),
(1, 7),
(2, 8),
(3, 9),
(3, 10),
(1, 11),
(2, 12),
(2, 13),
(2, 14),
(3, 15),
(2, 16),
(1, 17),
(1, 18),
(3, 19),
(3, 20),
(3, 21),
(3, 22);
