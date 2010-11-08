<?php
class sfXmlToArray
{
    protected 
        $xml_array = array(),
        $reader = null,
        $tag = null;
 
    public function __construct()
    {
        $this -> reader = new XMLReader();
    }
 
    public function parse($contents) 
    { 
        if(!$contents) return array(); 

        $current = &$this -> xml_array; 
 
        $this -> reader = new XMLReader();
        $this -> reader -> XML($contents);
    
        while($this -> reader -> read())
        {                            
            unset($result);
            
            switch($this -> reader -> nodeType)
            {
                case 1:
                    $this -> tag = $this -> reader -> name;    
                    if($this -> reader -> depth > 0) $current = &$parent[$this -> reader -> depth - 1];    
                
                    if($this -> reader -> hasAttributes)
                    {
                        $attributeCount = $this -> reader -> attributeCount; 
                    
                        for($i = 0; $i < $attributeCount; $i++)
                        {
                            $this -> reader -> moveToAttributeNo($i);
                            $result[$this -> reader -> name] = $this -> reader -> value;
                        }

                        $this -> reader -> moveToElement();
                    }
                    else
                    {
                        $result = '';
                    }
                
                    if(!@is_array($current[$this -> tag]))
                        $current[$this -> tag] = $result;
                    elseif(!@is_array($current[$this -> tag][0]))
                        $current[$this -> tag] = array($current[$this -> tag], $result);
                    else
                        $current[$this -> tag][] = $result;

                    if(!@is_array($current[$this -> tag][0]))
                        $parent[$this -> reader -> depth] = &$current[$this -> tag];
                    else
                        $parent[$this -> reader -> depth] = &$current[$this -> tag][count($current[$this -> tag]) - 1];
                    break;
                case 3:
                    $current[$this -> tag] = $this -> reader -> value;
                    $this -> reader -> read();
                    break;
                case 4:
                    $current[$this -> tag] = $this -> reader -> value;
                    $this -> reader -> read();
                    break;
                default:
                    break;
            }
        }
        
        return($this -> xml_array); 
    } 
}