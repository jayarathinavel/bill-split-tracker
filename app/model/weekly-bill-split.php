<?php
    $title = 'Weekly Bill Split Tracker';

    class WeeklyBillSplitModel {
        private $bookId;
        private $name;
        private $mondayAmount;
        private $tuesdayAmount;
        private $wednesdayAmount;
        private $thursdayAmount;
        private $fridayAmount;
        private $saturdayAmount;
        private $sundayAmount;

        public function getBookId(){
            return $this->bookId;
        }
    
        public function setBookId($bookId){
            $this->bookId = $bookId;
        }
    
        public function getName(){
            return $this->name;
        }
    
        public function setName($name){
            $this->name = $name;
        }
    
        public function getMondayAmount(){
            return $this->mondayAmount;
        }
    
        public function setMondayAmount($mondayAmount){
            $this->mondayAmount = $mondayAmount;
        }
    
        public function getTuesdayAmount(){
            return $this->tuesdayAmount;
        }
    
        public function setTuesdayAmount($tuesdayAmount){
            $this->tuesdayAmount = $tuesdayAmount;
        }
    
        public function getWednesdayAmount(){
            return $this->wednesdayAmount;
        }
    
        public function setWednesdayAmount($wednesdayAmount){
            $this->wednesdayAmount = $wednesdayAmount;
        }
    
        public function getThursdayAmount(){
            return $this->thursdayAmount;
        }
    
        public function setThursdayAmount($thursdayAmount){
            $this->thursdayAmount = $thursdayAmount;
        }
    
        public function getFridayAmount(){
            return $this->fridayAmount;
        }
    
        public function setFridayAmount($fridayAmount){
            $this->fridayAmount = $fridayAmount;
        }
    
        public function getSaturdayAmount(){
            return $this->saturdayAmount;
        }
    
        public function setSaturdayAmount($saturdayAmount){
            $this->saturdayAmount = $saturdayAmount;
        }
    
        public function getSundayAmount(){
            return $this->sundayAmount;
        }
    
        public function setSundayAmount($sundayAmount){
            $this->sundayAmount = $sundayAmount;
        }
    }
?>