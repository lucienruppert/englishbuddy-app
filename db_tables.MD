# Database Tables

1. `lmjelentkezok` - User/registration management
   - id (PK)
   - jelszo (password)
   - vezeteknev (last name)
   - keresztnev (first name)
   - email
   - program_start_date
   - program_end_date
   - client_data
   - send_mail (boolean)
   - forras_nyelv (source language)
   - nyelv (target language)
   - max_level
   - status
   - tanar_id (teacher ID)
   - payment
   - hazi_feladat (homework)
   - next_lesson
   - hash
   - word_hits
   - sentence_hits

2. `words` - Multi-language vocabulary storage
   - id (PK)
   - word_hun (Hungarian word)
   - word_angol (English word)
   - word_spanyol (Spanish word)
   - comment_hun
   - comment_angol 
   - comment_spanyol
   - pronunc_angol
   - pronunc_spanyol
   - level_hun
   - level_angol
   - level_spanyol
   - user_id (FK to lmjelentkezok)
   - category
   - hits
   - is_marked
   - crdti (creation date)

3. `user_words` - User-word associations
   - id (PK)
   - user_id (FK to lmjelentkezok)
   - word_id (FK to words)
   - is_marked

4. `WordsUpdate` - Word modification tracking
   - id (FK to words)
   - Modified (timestamp)
   - Deleted (boolean)

5. `finance` - Financial transaction records
   - id (PK)
   - user_id (FK to lmjelentkezok)
   - payment_date
   - amount
   - paid_to_who
   - time_package
   - payable_to_teacher
   - payable_to_boss
   - lesson_date

6. `daily_quiz` - Daily quiz data
   - word_id (FK to words)
   - datum (date)

7. `word_records` - Word usage and progress tracking
   - user_id (FK to lmjelentkezok)
   - tipus (type)
   - package_number
   - best_time

8. `user_hits` - User activity tracking
   - user_id (FK to lmjelentkezok)
   - datum (date)
   - hits

# SQL Create Statements

```sql
-- Create lmjelentkezok table
CREATE TABLE `lmjelentkezok` (
    `id` INT AUTO_INCREMENT PRIMARY KEY,
    `jelszo` VARCHAR(255) NOT NULL,
    `vezeteknev` VARCHAR(100) NOT NULL,
    `keresztnev` VARCHAR(100) NOT NULL,
    `email` VARCHAR(255) NOT NULL UNIQUE,
    `program_start_date` DATETIME,
    `program_end_date` DATETIME,
    `client_data` TEXT,
    `send_mail` BOOLEAN DEFAULT 0,
    `forras_nyelv` INT NOT NULL,
    `nyelv` INT NOT NULL,
    `max_level` INT DEFAULT 1000,
    `status` INT NOT NULL,
    `tanar_id` INT,
    `payment` TEXT,
    `hazi_feladat` TEXT,
    `next_lesson` VARCHAR(255),
    `hash` VARCHAR(44),
    `word_hits` INT DEFAULT 0,
    `sentence_hits` INT DEFAULT 0,
    FOREIGN KEY (`tanar_id`) REFERENCES `lmjelentkezok`(`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Create words table
CREATE TABLE `words` (
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
    FOREIGN KEY (`user_id`) REFERENCES `lmjelentkezok`(`id`) ON DELETE SET NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Create user_words table
CREATE TABLE `user_words` (
    `id` INT AUTO_INCREMENT PRIMARY KEY,
    `user_id` INT NOT NULL,
    `word_id` INT NOT NULL,
    `is_marked` BOOLEAN DEFAULT 0,
    FOREIGN KEY (`user_id`) REFERENCES `lmjelentkezok`(`id`) ON DELETE CASCADE,
    FOREIGN KEY (`word_id`) REFERENCES `words`(`id`) ON DELETE CASCADE,
    UNIQUE KEY `user_word_unique` (`user_id`, `word_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Create WordsUpdate table
CREATE TABLE `WordsUpdate` (
    `id` INT PRIMARY KEY,
    `Modified` TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    `Deleted` BOOLEAN DEFAULT 0,
    FOREIGN KEY (`id`) REFERENCES `words`(`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Create finance table
CREATE TABLE `finance` (
    `id` INT AUTO_INCREMENT PRIMARY KEY,
    `user_id` INT NOT NULL,
    `payment_date` DATE NOT NULL,
    `amount` DECIMAL(10,2) NOT NULL,
    `paid_to_who` INT NOT NULL,
    `time_package` INT,
    `payable_to_teacher` DECIMAL(10,2),
    `payable_to_boss` DECIMAL(10,2),
    `lesson_date` DATE,
    FOREIGN KEY (`user_id`) REFERENCES `lmjelentkezok`(`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Create daily_quiz table
CREATE TABLE `daily_quiz` (
    `word_id` INT NOT NULL,
    `datum` DATE NOT NULL,
    PRIMARY KEY (`word_id`, `datum`),
    FOREIGN KEY (`word_id`) REFERENCES `words`(`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Create word_records table
CREATE TABLE `word_records` (
    `user_id` INT NOT NULL,
    `tipus` INT NOT NULL,
    `package_number` INT NOT NULL,
    `best_time` INT NOT NULL,
    PRIMARY KEY (`user_id`, `tipus`, `package_number`),
    FOREIGN KEY (`user_id`) REFERENCES `lmjelentkezok`(`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Create user_hits table
CREATE TABLE `user_hits` (
    `user_id` INT NOT NULL,
    `datum` DATE NOT NULL,
    `hits` INT DEFAULT 0,
    PRIMARY KEY (`user_id`, `datum`),
    FOREIGN KEY (`user_id`) REFERENCES `lmjelentkezok`(`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
```