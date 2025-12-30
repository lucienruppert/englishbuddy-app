-- ============================================================
-- EnglishBuddy Database Schema
-- For table overview and relationships, see db_tables.MD
-- ============================================================
-- lmjelentkezok: User/registration management
CREATE TABLE IF NOT EXISTS `lmjelentkezok` (
  `id` INT(11) AUTO_INCREMENT PRIMARY KEY,
  `vezeteknev` VARCHAR(100) NOT NULL,
  `keresztnev` VARCHAR(100) NOT NULL,
  `email` VARCHAR(100) UNIQUE,
  `forras_nyelv` INT(11) NOT NULL DEFAULT 0,
  `nyelv` INT(11) NOT NULL DEFAULT 1,
  `jelszo` VARCHAR(30) NOT NULL,
  `program_start_date` DATETIME,
  `program_end_date` DATETIME,
  `client_data` TEXT,
  `send_mail` TINYINT(1) NOT NULL DEFAULT 1,
  `max_level` INT(11) NOT NULL DEFAULT 1,
  `status` INT(11) NOT NULL DEFAULT 1,
  `word_hits` INT(11) NOT NULL DEFAULT 0,
  `sentence_hits` INT(11) NOT NULL DEFAULT 0,
  `time_used` DECIMAL(20, 0) NOT NULL DEFAULT 0,
  `tanar_id` INT(11) NOT NULL DEFAULT 0,
  `payment` TEXT,
  `hazi_feladat` TEXT,
  `next_lesson` DATETIME,
  `last_login_date` DATETIME,
  `subscribe_length` INT(11),
  `hash` VARCHAR(128),
  FOREIGN KEY (`tanar_id`) REFERENCES `lmjelentkezok`(`id`)
) ENGINE = InnoDB DEFAULT CHARSET = utf8mb4 COLLATE = utf8mb4_unicode_ci;

-- words: Multi-language vocabulary storage
CREATE TABLE IF NOT EXISTS `words` (
  `id` INT AUTO_INCREMENT PRIMARY KEY,
  `word_hun` TEXT,
  `word_angol` TEXT,
  `word_spanyol` TEXT,
  `comment_hun` TEXT,
  `comment_angol` TEXT,
  `comment_spanyol` TEXT,
  `pronunc_angol` TEXT,
  `pronunc_spanyol` TEXT,
  `level_hun` INT DEFAULT 0,
  `level_angol` INT DEFAULT 0,
  `level_spanyol` INT DEFAULT 0,
  `user_id` INT,
  `category` INT,
  `hits` INT DEFAULT 0,
  `is_marked` BOOLEAN DEFAULT 0,
  `crdti` TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
  FOREIGN KEY (`user_id`) REFERENCES `lmjelentkezok`(`id`) ON DELETE
  SET
    NULL
) ENGINE = InnoDB DEFAULT CHARSET = utf8mb4 COLLATE = utf8mb4_unicode_ci;

-- user_words: User-word associations
CREATE TABLE IF NOT EXISTS `user_words` (
  `id` INT AUTO_INCREMENT PRIMARY KEY,
  `user_id` INT NOT NULL,
  `word_id` INT NOT NULL,
  `is_marked` BOOLEAN DEFAULT 0,
  FOREIGN KEY (`user_id`) REFERENCES `lmjelentkezok`(`id`) ON DELETE CASCADE,
  FOREIGN KEY (`word_id`) REFERENCES `words`(`id`) ON DELETE CASCADE,
  UNIQUE KEY `user_word_unique` (`user_id`, `word_id`)
) ENGINE = InnoDB DEFAULT CHARSET = utf8mb4 COLLATE = utf8mb4_unicode_ci;

-- WordsUpdate: Word modification tracking
CREATE TABLE IF NOT EXISTS `WordsUpdate` (
  `id` INT PRIMARY KEY,
  `Modified` TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `Deleted` BOOLEAN DEFAULT 0,
  FOREIGN KEY (`id`) REFERENCES `words`(`id`) ON DELETE CASCADE
) ENGINE = InnoDB DEFAULT CHARSET = utf8mb4 COLLATE = utf8mb4_unicode_ci;

-- finance: Financial transaction records
CREATE TABLE IF NOT EXISTS `finance` (
  `id` INT AUTO_INCREMENT PRIMARY KEY,
  `user_id` INT NOT NULL,
  `payment_date` DATE NOT NULL,
  `amount` DECIMAL(10, 2) NOT NULL,
  `paid_to_who` INT NOT NULL,
  `time_package` INT,
  `payable_to_teacher` DECIMAL(10, 2),
  `payable_to_boss` DECIMAL(10, 2),
  `lesson_date` DATE,
  FOREIGN KEY (`user_id`) REFERENCES `lmjelentkezok`(`id`) ON DELETE CASCADE
) ENGINE = InnoDB DEFAULT CHARSET = utf8mb4 COLLATE = utf8mb4_unicode_ci;

-- daily_quiz: Daily quiz data
CREATE TABLE IF NOT EXISTS `daily_quiz` (
  `word_id` INT NOT NULL,
  `datum` DATE NOT NULL,
  PRIMARY KEY (`word_id`, `datum`),
  FOREIGN KEY (`word_id`) REFERENCES `words`(`id`) ON DELETE CASCADE
) ENGINE = InnoDB DEFAULT CHARSET = utf8mb4 COLLATE = utf8mb4_unicode_ci;

-- word_records: Word usage and progress tracking
CREATE TABLE IF NOT EXISTS `word_records` (
  `user_id` INT NOT NULL,
  `tipus` INT NOT NULL,
  `package_number` INT NOT NULL,
  `best_time` INT NOT NULL,
  PRIMARY KEY (`user_id`, `tipus`, `package_number`),
  FOREIGN KEY (`user_id`) REFERENCES `lmjelentkezok`(`id`) ON DELETE CASCADE
) ENGINE = InnoDB DEFAULT CHARSET = utf8mb4 COLLATE = utf8mb4_unicode_ci;

-- user_hits: User activity tracking
CREATE TABLE IF NOT EXISTS `user_hits` (
  `user_id` INT NOT NULL,
  `datum` DATE NOT NULL,
  `hits` INT DEFAULT 0,
  PRIMARY KEY (`user_id`, `datum`),
  FOREIGN KEY (`user_id`) REFERENCES `lmjelentkezok`(`id`) ON DELETE CASCADE
) ENGINE = InnoDB DEFAULT CHARSET = utf8mb4 COLLATE = utf8mb4_unicode_ci;

-- level_rules: Rules for language levels
CREATE TABLE IF NOT EXISTS `level_rules` (
  `id` INT AUTO_INCREMENT PRIMARY KEY,
  `level` INT NOT NULL,
  `lang` VARCHAR(3) NOT NULL,
  `rule_text` TEXT NOT NULL,
  `examples` TEXT,
  `crdti` TIMESTAMP DEFAULT CURRENT_TIMESTAMP
) ENGINE = InnoDB DEFAULT CHARSET = utf8mb4 COLLATE = utf8mb4_unicode_ci;

-- audio_progress: User progress tracking for audio files
CREATE TABLE IF NOT EXISTS `audio_progress` (
  `user_id` INT NOT NULL,
  `category` VARCHAR(50) NOT NULL,
  `audio_number` INT NOT NULL,
  `completed` BOOLEAN DEFAULT 0,
  PRIMARY KEY (`user_id`, `category`, `audio_number`),
  FOREIGN KEY (`user_id`) REFERENCES `lmjelentkezok`(`id`) ON DELETE CASCADE
) ENGINE = InnoDB DEFAULT CHARSET = utf8mb4 COLLATE = utf8mb4_unicode_ci;

-- ============================================================
-- End of Database Schema
-- ============================================================