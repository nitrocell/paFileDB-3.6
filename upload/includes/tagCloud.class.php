<?php
/**
  * PHP-Class tagCloud Version 1.0 , released 23-OCT-2006
  * Author: Dror Golan, drorgolan@gmail.com
  *
  * License: GNU GPL (http://www.opensource.org/licenses/gpl-license.html)
  *
  * If you find it useful, you might rate it on http://www.phpclasses.org
  * If you use this class in a productional environment, you may drop me a note, so I can add a link to the page.
  *
  ** TODO : 
  *
  *  1. Strict checking for instancing (e.g. numeric values , max is more than min , etc
  *  2. AJAX hooks ( load TagArray from a Polling / Direct feed and update cloud on the fly  
  **
  * License: GNU GPL (http://www.opensource.org/licenses/gpl-license.html)
  *
  * This program is free software;
  *
  * you can redistribute it and/or modify it under the terms of the GNU General Public License
  * as published by the Free Software Foundation; either version 2 of the License,
  * or (at your option) any later version.
  *
  * This program is distributed in the hope that it will be useful,
  * but WITHOUT ANY WARRANTY; without even the implied warranty of MERCHANTABILITY or
  * FITNESS FOR A PARTICULAR PURPOSE. See the GNU General Public License for more details.
  *
  * You should have received a copy of the GNU General Public License along with this program;
  * if not, write to the Free Software Foundation, Inc., 59 Temple Place, Suite 330, Boston, MA 02111-1307 USA
  *
  **/

class tagCloud {

    ////////////////////////////////
	//
	//	PUBLIC PARAMS
	//

		 /**
		  * @shortdesc Number of rows in Cloud
          * @type Integer
		  * @public
          * @default value : 3
          **/
		  
		  var $Rows ;
		  
		  /**
		  * @shortdesc Number of Items(Tags) per Row 
          * @type Integer
		  * @public
          * @default value : 5
          **/
		  
		  var $itemsPerRow;
		  
		  /**
		  * @shortdesc Array of Tags item 
          * @type Array (e.g. array (
		                     "January" => 12,
		                     "February" => 28)
		  * @public
          * @default value : NULL
          **/
		  
		  var $KeywordsArray;
	
	      /**
		  * @shortdesc RGB color of font 
          * @type String with a '#' prefix (e.g. "#FF0080") 
		  * @public
          * @default value : BLUE ("#0000FF") 
          **/
	
		  var $TextColor ;   
		  
		  /**
		  * @shortdesc Name of Font type (True Type) 
          * @type String (e.g. "Curier") 
		  * @public
          * @default value : "Arial"
          **/
		    
		  var $FontType ;    
		  
		  /**
		  * @shortdesc Minimum font size
          * @type Integer 
		  * @public
          * @default value : 10
          **/
		   
		  var $MinFontSize ;  
		  
		  /**
		  * @shortdesc Maximum font size
          * @type Integer 
		  * @public
          * @default value : 20
          **/
		  
	     var $MaxFontSize ;  
		 
		 /**
		  * @shortdesc Spacing in Pixels between Items (Tags).
          * @type Integer 
		  * @public
          * @default value : 1
          **/
		 
		  var $SpacingPixelBetweenItems ;   
		  
		  /**
		  * @shortdesc URL Prefix to apply when Tag is pressed .
          * @type String 
		  * @public
          * @default value : 'http:/link2myscript.php?name=';
          **/
		  
		  var $LinkUrlPrefix ; 
		  
		  /**
		  * @shortdesc Append Name to URl Prefix .
          * @type Integer
		  * 1 : Append Name  (Array Key)
		  * 0 : Append Index (Absolute Position of item within Array) 
		  * @public
          * @default value : 1 ;
          **/
		  
		  var $AppendNameToPrefix  ;  
		  
		  /**
		  * @shortdesc RGB value for Background color of Cloud .
          * @type String with a '#' Prefix (e.g. "#FF0080")
		  * @public
          * @default value : "#FFFFFF" (White) ;
          **/
		  
		  var $BackgroundColor ;  
		  
		  /**
		  * @shortdesc ID and Name of Table Object .
		  * Please note that when using several TagClouds in same page it is advisible
		  * to use different ID Names
          * @type String 
		  * @public
          * @default value : MyTagCloud;
          **/
		  
		  var $TableIdName;     
		  
		   /**
		  * @shortdesc BorderWidth of Table Object.
          * @type Integer 
		  * @public
          * @default value : 0 (No Border);
          **/
		  
		  var $BorderWIdth;
		  
		  /**
		  * @shortdesc Sort Tag Array Option.
          * @type Integer 
		  * 0 : No Sorting
		  * 1 : Sort Up.
		  * 2 : Sort Down
		  * @public
          * @default value : 0 (No Sorting);
          **/
		  	        
		 var $SortArray;  
		 
		 /**
		  * @shortdesc Right To Left View .
          * @type Integer 
		  * 0 : Normal View (LTR)
		  * 1 : Right to Left view (Use this option for Hebrew / Arabic  content)
		  * @public
          * @default value : 0 (Normal View);
          **/
		 	       
		 var $RightToLeftView;  
		 
		 /**
		  * @shortdesc Output HTML source of Cloud .
          * @type String 
		  * @private
          * @default value : '';
          **/
		 
         var $HtmlStr = ''  ;  
		 
		 /**
		  * @shortdesc Minimum value of Tag
          * @type Integer 
		  * @private
          * @calculated upon instancing ;
          **/
		  
          var $minTagValue ;
		  
		  /**
		  * @shortdesc Maximum value of Tag
          * @type Integer 
		  * @private
          * @calculated upon instancing ;
          **/
		   
          var $maxTagValue ;
		  
		  /**
		  * @shortdesc: ratio between Tag value and font size variables
		  * a parameter in function  : Y = aX + b (Y:font size , X:Tag Value)
          * @type Float 
		  * @private
          * @calculated upon instancing ;
          **/
		  
          var $FontRatio ;  
		  
		  /**
		  * @shortdesc: Offset between Tag value and font size variables
		  * b parameter in function  : Y = aX + b (Y:font size , X:Tag Value)
          * @type Float 
		  * @private
          * @calculated upon instancing ;
          **/
		  
          var $FontOffset ; 



function tagCloud ($KA,$R=3,$IPR=10,$TC="#0000FF",$FT="Arial",$MinFS=10,$MaxFS=20,$SPBI=5,$LUP='index.php?act=viewtag&tag=',$ANTP=1,$BC="#FFFFFF",$TID="MyTagCloud",$BW=0,$SA=0,$RTL=0) {


// init default values 
if (empty($R)) $this->Rows =3; 
	else  $this->Rows  = $R ;
if (empty($IPR)) $this->itemsPerRow =5;
	else $this->itemsPerRow = $IPR;
	
if (!is_array($KA)) exit ('Keywords Array is not a valid Array');
	else $this->KeywordsArray = $KA;

if (empty($SA)) $this->SortArray = 0;
	else $this->SortArray = $SA;

// sort Array if needed

if 	($this->SortArray == 1) 
     ksort($this->KeywordsArray);
else  
     if($this->SortArray == 2) 
     krsort($this->KeywordsArray); 
  
	
	
if (empty($TC))  $this->TextColor = "#0000FF";
	else $this->TextColor = $TC;	
if (empty($FT))  $this->FontType = "Arial";
	else $this->FontType = $FT;	 
if (empty($MinFS))  $this->MinFontSize = 10;
	else $this->MinFontSize = $MinFS; 
if (empty($MaxFS))  $this->MaxFontSize = 20;
	else $this->MaxFontSize = $MaxFS;	
if (empty($SPBI))  $this->SpacingPixelBetweenItems = 1;
	else $this->SpacingPixelBetweenItems = $SPBI;	
if (empty($LUP))  $this->LinkUrlPrefix = 'http:/link2myscript.php?name=';
	else $this->LinkUrlPrefix = $LUP;		
if (empty($ANTP)) $this->AppendNameToPrefix = 0;
	else $this->AppendNameToPrefix = $ANTP;		
if (empty($BC)) $this->BackgroundColor = "#FFFFFF";
	else $this->BackgroundColor = $BC;		
if (empty($TID)) $this->TableIdName = "MyTagCloud";
	else $this->TableIdName = $TID;	
if (empty($BW)) $this->BorderWIdth = 0;
	else $this->BorderWIdth = $BW;		
if (empty($RTL)) $this->RightToLeftView = 0;
	else $this->RightToLeftView = $RTL;			
	
if ($this->RightToLeftView == 0 ) $this->RightToLeftView = 'ltr';
else $this->RightToLeftView = 'rtl';

$this->HtmlStr = ''  ;  


 // calculated Values
 
 $this->minTagValue = min($this->KeywordsArray);
 $this->maxTagValue = max($this->KeywordsArray);
 
 $this->FontRatio = ($this->MaxFontSize - $this->MinFontSize) / ($this->maxTagValue -  $this->minTagValue)  ;
 $this->FontOffset = $this->MaxFontSize -  ($this->FontRatio * $this->maxTagValue );
 
 
}


function CreateHtmlCode() {

$htmlCode = '';
	
			  reset($this->KeywordsArray);
			  $AbsuloteIndex = 0;
		for ($i=1;$i<=count($this->KeywordsArray);$i++) // Loop over Raws (correlate to Table TR Tag ) 
		{
		//$htmlCode .= '<TR>';
		    
			//for ($itemsPerRaw=1;$itemsPerRaw<=$this->itemsPerRow;$itemsPerRaw++) // Loop inside Raw (correlate to Table TD Tag )
			//{
			$AbsuloteIndex++;
			$currentKey = key($this->KeywordsArray);
			@$currentValue = $this->KeywordsArray[$currentKey];
			// calculate Tag View Size 
			$TagSize = round( ($this->FontRatio * $currentValue) + $this->FontOffset);
			// when appending ID and not Name , simply concatunate the absolute Index of Array.
			if ($this->AppendNameToPrefix==0) $currentKeyLink = $AbsuloteIndex; 
			else $currentKeyLink = $currentKey;
		    $htmlCode .= '<a href="'.$this->LinkUrlPrefix.$currentKeyLink.'" style="font-size:'.$TagSize.'px">'.$currentKey.'</a> '."\n";
		 	next($this->KeywordsArray);                     
			//}
			
		//$htmlCode .= '</TR>';	
		}
		
	
// append HTML source to HtmlStr 	
$this->HtmlStr = $htmlCode;
		
} // createHtml Code
} // Class


?>


