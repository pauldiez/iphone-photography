<?php
    
    
    namespace App\Models;
    
    class Course
    {
        
        // course keys
        public static $COURSE_KEY_IPHONE_PHOTO_ACADEMY = 'ipa';
        public static $COURSE_KEY_IPHONE_EDITING_ACADEMY = 'iea';
        public static $COURSE_KEY_IPHONE_ART_ACADEMY = 'iaa';
        
        // modules per course
        public static $MODULES_PER_COURSE = 7;
        
        /**
         * Get all course keys
         *
         * @return array
         */
        public static function getAllKeys()
        {
            return [
                self::$COURSE_KEY_IPHONE_PHOTO_ACADEMY,
                self::$COURSE_KEY_IPHONE_EDITING_ACADEMY,
                self::$COURSE_KEY_IPHONE_ART_ACADEMY
            ];
        }
        
    }