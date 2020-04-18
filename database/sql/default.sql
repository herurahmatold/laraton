INSERT INTO `options_laraton` (`id`, `option_key`, `option_value`, `is_sistem`) VALUES
(1, 'backend_theme', 'adminlte2', 1),
(2, 'logo', 'logo.jpg', 1),
(3, 'favicon', 'favicon.jpg', 1),
(4, 'app_name', 'Laraton', 1),
(5, 'app_version', '1.0.0-Alpha4', 1),
(6, 'app_year', '2019', 1),
(7, 'app_footer_custom', '', 1),
(8, 'company_name', 'Contoh Perusahaan', 1),
(9, 'company_address', '-', 1),
(10, 'company_phone', '-', 1),
(11, 'company_email', '-', 1),
(12, 'company_fax', '-', 1),
(13, 'company_web', '-', 1);

INSERT INTO `users_laraton` (`id`, `name`, `username`, `email`, `email_verified_at`, `password`, `user_group_id`, `status`, `avatar`, `remember_token`, `last_login`, `created_at`, `updated_at`, `isDeleted`) VALUES
(1, 'Administrator', 'admin', 'admin@admin.com', NULL, '$2a$08$PQ/1FcXdgcSSzPEF9Bb2AuK2jRIHyaCHAf5/bgG03Uq4YNgxchWzu', 1, 1, NULL, NULL, '2019-10-15 02:55:16', '2019-10-04 20:01:10', '2019-10-14 19:55:16', 0);

INSERT INTO `user_groups_laraton` (`id`, `group_name`, `group_value`) VALUES
(1, 'superadmin', 'Super Administrator');