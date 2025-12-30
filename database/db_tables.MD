# Database Schema Overview

This document provides a high-level overview of the EnglishBuddy database structure. For the complete table definitions with data types and constraints, see **create_tables.sql**.

## Tables

1. **lmjelentkezok** - User/registration management
   User accounts, language preferences, teacher assignments, status tracking

2. **words** - Multi-language vocabulary storage
   Words with translations in Hungarian, English, and Spanish, with pronunciation and level info

3. **user_words** - User-word associations
   Links users to words for personalized vocabulary tracking

4. **WordsUpdate** - Word modification tracking
   Tracks when words are modified or deleted

5. **finance** - Financial transaction records
   Payment records, teacher payouts, lesson scheduling

6. **daily_quiz** - Daily quiz data
   Words selected for daily quiz practice

7. **word_records** - Word usage and progress tracking
   User progress on different word practice packages

8. **user_hits** - User activity tracking
   Daily activity counts per user

9. **level_rules** - Rules for language levels
   Grammar rules and examples for each language level
## Database Relationships

**Key Relationships:**
- `words.user_id` → `lmjelentkezok.id` (user-created custom words)
- `user_words.user_id` → `lmjelentkezok.id`
- `user_words.word_id` → `words.id`
- `WordsUpdate.id` → `words.id` (tracks modifications)
- `finance.user_id` → `lmjelentkezok.id`
- `daily_quiz.word_id` → `words.id`
- `word_records.user_id` → `lmjelentkezok.id`
- `user_hits.user_id` → `lmjelentkezok.id`
- `lmjelentkezok.tanar_id` → `lmjelentkezok.id` (self-referencing for teachers)

## SQL Definitions

See **create_tables.sql** for the complete SQL CREATE TABLE statements.

## Notes

- The application currently uses the deprecated `mysql_*` functions in `functions_userObj.php`
- Should be updated to use `mysqli` or `PDO` for better security and functionality