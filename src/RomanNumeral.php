<?php
namespace PhpNwSykes;

class RomanNumeral
{
    protected $symbols = [
        1000 => 'M',
        500 => 'D',
        100 => 'C',
        50 => 'L',
        10 => 'X',
        5 => 'V',
        1 => 'I',
    ];

    protected $numeral;

    public function __construct(string $romanNumeral)
    {
        $this->numeral = $romanNumeral;
    }


    /**
     * Tests if a character is a valid Roman Numeral character,
     * and if it is a correct position (e.g., 'VVXVV. is invalid, and
     * so is 'FALSENUMBER')
     * 
     * @param string $current The numeral being tested
     * @param string $prev The character preceding it in $numeral
     * @return true if valid, otherwise false.
     */
    private function isValidNextNumeral($current, $prev) {
        $result = false;
        switch($prev) {
          case "I":
            $result = (strpos("IVX", $current)!==false);
            break;
          case "V":
            $result = (strpos("I", $current)!==false);
            break;
          case "X":
            $result = (strpos("IVXLC", $current)!==false);
            break;
          case "L":
            $result = (strpos("IVX", $current)!==false);
            break;
          case "C":
            $result = (strpos("IVXLDM", $current)!==false);
            break;
          case "D":
            $result = (strpos("IVXC", $current)!==false);
            break;
          case "M":
            $result = true;
            break;
          default:
            break;
        }
      
        return $result;
      }

    /**
     * Tests if $this->numeral is a valid Roman Numeral.
     * 
     * @return boolean true if valid, otherwise false.
     */
    private function isValidRomanNumeral() {
        if(strlen($this->numeral)==0) {
            return false;
        }

        $firstCharacter = $this->numeral[0];

        // Test the first character against 'M'. (It will only fail
        // if it is not a valid character.)
        if($this->isValidNextNumeral($firstCharacter, "M")==false) {
            return false;
        }
        
        $prev = $firstCharacter;

        // Test the other characters in the numeral string
        for($i=1; $i<strlen($this->numeral); $i++) {
          $current = $this->numeral[$i];
          if($this->isValidNextNumeral($current, $prev)==false) {
            return false;
          }
        }  
      
        return true;
    }


    /**
     * Converts a roman numeral such as 'X' to a number, 10
     *
     * @throws InvalidNumeral on failure (when a numeral is invalid)
     */
    public function toInt():int
    { 
        $romanToInteger = array(
          "I" => "1",
          "V" => "5",
          "X" => "10",
          "L" => "50",
          "C" => "100",
          "D" => "500",
          "M" => "1000" 
        );

        if($this->isValidRomanNumeral()==false) {
            throw new InvalidNumeral('Invalid Roman Numeral!');
        }

        $previous = 0;
        $total = 0;
      
        for($i=0; $i<strlen($this->numeral); $i++) {
          $current = $romanToInteger[$this->numeral[$i]];
      
          if($previous==0) {
            $total+=$current;
          }
          else if($current > $previous) {
            $total+=$current;
            $total-=$previous*2;
          } 
          else {
            $total+=$current;
          }
      
          $previous=$current;
        }  
        return $total;
    }
}
