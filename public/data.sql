
INSERT INTO `profession` (`id`, `title`) VALUES
(1, 'admin'),
(2, 'front end junior developer'),
(3, 'back end junior developer'),
(4, 'front end senior developer'),
(5, 'back end senior developer');

INSERT INTO `user` (`id`, `profession_id`, `email`, `roles`, `password`, `first_name`, `last_name`, `is_active`) VALUES
(1, 1, 'admin@nfq.lt', '[\"ROLE_ADMIN\"]', '$argon2i$v=19$m=65536,t=4,p=1$NFFYMVBOVk5SQktFeGxOSQ$HL07H6NutU65L65XeoovD9EJQ1XW428EIOxSQjCy+hk', 'admin', 'admin', 1),
(2, 4, 'user1@nfq.lt', '[\"ROLE_HEAD\"]', '$argon2i$v=19$m=65536,t=4,p=1$amtzT05hMzRKbWx0RllhRA$EjgHNRWTqhs99Xsr7cPQNR91aLWkfvoYYymliRmyaJo', 'Vardenis', 'Pavardenis', 1),
(3, 3, 'user2@nfq.lt', '[]', '$argon2i$v=19$m=65536,t=4,p=1$aVBiUHk1WDJ1WXdhd1Iycw$tXPohp5qJT4IhHH9f8xoa8/qVQkwszJkSytgrnzHV/k', 'Jonas', 'Jonaitis', 1),
(4, 5, 'user3@nfq.lt', '[\"ROLE_HEAD\"]', '$argon2i$v=19$m=65536,t=4,p=1$dEpIdmlKUGREVWNkbmpzTg$OYoXBJ2LUuhZW+Jlj6GvCZVJVu8Ph8DAEw+/P4CK+2Q', 'Petras', 'Petraitis', 1),
(5, 2, 'user4@nfq.lt', '[]', '$argon2i$v=19$m=65536,t=4,p=1$SHlOdVc5NkJzVVN2U08yVg$jKerUfMnymtaSzYKC9xv91jtOwT5zQyB4OexQyFA6co', 'Juozas', 'Juozaitis', 1),
(6, 2, 'user5@nfq.lt', '[]', '$argon2i$v=19$m=65536,t=4,p=1$Snk1SWNDamZ1dERHUnI5RA$JjTHySw3xmPit5sk9qyBwgyruMp/AOrWpy0Vp0Pnv3c', 'Antanas', 'Antanaitis', 1);


INSERT INTO `team` (`id`, `title`) VALUES
(1, 'Team front end'),
(2, 'Team back end');

INSERT INTO `team_user` (`team_id`, `user_id`) VALUES
(1, 2),
(2, 3),
(2, 4),
(1, 5),
(1, 6);
