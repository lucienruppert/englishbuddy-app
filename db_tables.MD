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