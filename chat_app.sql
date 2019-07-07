
CREATE TABLE `files` (
  `file_id` int(11) NOT NULL,
  `file_name` varchar(100) NOT NULL,
  `file_size` int(11) NOT NULL,
  `file_type` varchar(50) NOT NULL,
  `msg_id` int(11) NOT NULL
);

CREATE TABLE `msgs` (
  `msg_id` int(11) NOT NULL,
  `source_id` int(11) NOT NULL,
  `dest_id` int(11) NOT NULL,
  `content` text NOT NULL,
  `type` varchar(20) NOT NULL DEFAULT 'text',
  `time` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
);

CREATE TABLE `user` (
  `id` int(11) NOT NULL,
  `username` varchar(40) NOT NULL,
  `password` varchar(50) NOT NULL,
  `email` varchar(50) NOT NULL,
  `state` varchar(15) NOT NULL DEFAULT 'offline'
);

ALTER TABLE `files`
  ADD PRIMARY KEY (`file_id`);

ALTER TABLE `msgs`
  ADD PRIMARY KEY (`msg_id`);

ALTER TABLE `user`
  ADD PRIMARY KEY (`id`);

ALTER TABLE `files`
  MODIFY `file_id` int(11) NOT NULL AUTO_INCREMENT;

ALTER TABLE `msgs`
  MODIFY `msg_id` int(11) NOT NULL AUTO_INCREMENT;

ALTER TABLE `user`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
