<?php


namespace agpopov\localization\Helpers;


class DB
{
    public static function createOnUpdateFunction()
    {
        \DB::statement('CREATE OR REPLACE FUNCTION on_update()
            RETURNS TRIGGER AS $$
            BEGIN
                IF row(NEW.*) IS DISTINCT FROM row(OLD.*) THEN
                    NEW.created_at = OLD.created_at;
                    NEW.updated_at = CURRENT_TIMESTAMP;

                    IF (NEW.deleted_at IS NOT NULL) THEN
                        IF (OLD.deleted_at IS NULL) THEN
                            NEW.deleted_at = CURRENT_TIMESTAMP;
                        ELSE
                            NEW.deleted_at = OLD.deleted_at;
                        END IF;
                    END IF;

                  RETURN NEW;
                ELSE
                    RETURN OLD;
                END IF;
            END;
            $$ language \'plpgsql\';');
    }

    public static function createOnInsertFunction()
    {
        \DB::statement('CREATE OR REPLACE FUNCTION on_insert()
            RETURNS TRIGGER AS $$
            BEGIN
                NEW.created_at = CURRENT_TIMESTAMP;
                NEW.updated_at = CURRENT_TIMESTAMP;
                NEW.deleted_at = NULL;
                RETURN NEW;
            END;
            $$ language \'plpgsql\';');
    }

    public static function createOnUpdateTranslationFunction(string $dataTableName, string $translationTableName, string $dataKey, string $foreignKey)
    {
        \DB::statement('CREATE OR REPLACE FUNCTION on_' . $translationTableName . '_update()
                RETURNS TRIGGER AS $$
                BEGIN
                   IF row(NEW.*) IS DISTINCT FROM row(OLD.*) THEN
                      UPDATE ' . $dataTableName . ' d SET updated_at = CURRENT_TIMESTAMP WHERE d.' . $dataKey . ' = NEW.' . $foreignKey . ';
                   END IF;
                   RETURN NEW;
                END;
                $$ language \'plpgsql\';');
    }

    public static function dropOnUpdateFunction()
    {
        \DB::statement('DROP FUNCTION IF EXISTS on_update() CASCADE;');
    }

    public static function dropOnInsertFunction()
    {
        \DB::statement('DROP FUNCTION IF EXISTS on_insert() CASCADE;');
    }

    public static function dropOnUpdateTranslationFunction(string $translationTableName)
    {
        \DB::statement('DROP FUNCTION IF EXISTS on_' . $translationTableName . '_update() CASCADE;');
    }

    public static function createOnUpdateTrigger(string $tableName)
    {
        self::dropOnUpdateTrigger($tableName);
        \DB::statement('CREATE TRIGGER on_update_table BEFORE UPDATE ON ' . $tableName . ' FOR EACH ROW EXECUTE FUNCTION on_update();');
    }

    public static function createOnInsertTrigger(string $tableName)
    {
        self::dropOnInsertTrigger($tableName);
        \DB::statement('CREATE TRIGGER on_insert_table BEFORE INSERT ON ' . $tableName . ' FOR EACH ROW EXECUTE FUNCTION on_insert();');
    }

    public static function createOnUpdateTranslationTrigger(string $translationTableName)
    {
        self::dropOnUpdateTranslationTrigger($translationTableName);
        \DB::statement('CREATE TRIGGER on_update_or_insert_table AFTER UPDATE OR INSERT ON ' . $translationTableName . ' FOR EACH ROW EXECUTE FUNCTION on_' . $translationTableName . '_update();');
    }

    public static function dropOnUpdateTrigger(string $tableName)
    {
        \DB::statement('DROP TRIGGER IF EXISTS on_update_table ON ' . $tableName . ';');
    }

    public static function dropOnInsertTrigger(string $tableName)
    {
        \DB::statement('DROP TRIGGER IF EXISTS on_insert_table ON ' . $tableName . ';');
    }

    public static function dropOnUpdateTranslationTrigger(string $translationTableName)
    {
        \DB::statement('DROP TRIGGER IF EXISTS on_update_or_insert_table ON ' . $translationTableName . ';');
    }
}
